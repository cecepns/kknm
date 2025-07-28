<?php

namespace App\Http\Controllers;

use App\Models\Knowledge;
use App\Helpers\UniversityDataHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Traits\ActivityLogger;

class KnowledgeController extends Controller
{
    use ActivityLogger;

    // ANCHOR: Show User's Knowledge List
    public function userIndex()
    {
        $userKnowledge = Knowledge::where('user_id', auth()->id())
            ->where('status', '!=', 'approved')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('kelola-pengetahuan.daftar', compact('userKnowledge'))
            ->with('pageType', 'user');
    }

    // ANCHOR: Show Upload Form
    public function create()
    {
        return view('kelola-pengetahuan.form')
            ->with('jenis_kkn', UniversityDataHelper::getJenisKKN())
            ->with('tahun_kkn', UniversityDataHelper::getTahunKKN())
            ->with('nomor_kelompok_kkn', UniversityDataHelper::getNoKelompokKKN())
            ->with('jenis_file', UniversityDataHelper::getJenisFile())
            ->with('kategori_bidang', UniversityDataHelper::getKategoriBidang())
            ->with('user_role', auth()->user()->role_id);
    }

    // ANCHOR: Show Knowledge Detail
    public function show($id)
    {
        $knowledge = Knowledge::with('user')->findOrFail($id);
        
        // Check if user has permission to view this knowledge
        if (auth()->user()->id !== $knowledge->user_id) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('kelola-pengetahuan.detail', compact('knowledge'))
            ->with('pageType', 'user');
    }

    // ANCHOR: Store Knowledge
    public function store(Request $request)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:5000',
            'kkn_type' => 'required|string|max:255',
            'kkn_year' => 'required|integer|min:2020|max:' . (date('Y') + 50),
            'file_type' => 'required|in:dokumen,presentasi,video,gambar,lainnya',
            'field_category' => 'required|in:pendidikan,kesehatan,ekonomi,lingkungan,teknologi,sosial',
            'declaration' => 'required|accepted',
        ], [
            'title.required' => 'Judul pengetahuan harus diisi.',
            'title.max' => 'Judul pengetahuan maksimal 255 karakter.',
            'description.required' => 'Deskripsi harus diisi.',
            'description.max' => 'Deskripsi maksimal 5000 karakter.',
            'kkn_type.required' => 'Jenis KKN harus dipilih.',
            'kkn_type.string' => 'Jenis KKN harus berupa teks.',
            'kkn_type.max' => 'Jenis KKN maksimal 255 karakter.',
            'kkn_year.required' => 'Tahun KKN harus dipilih.',
            'kkn_year.integer' => 'Tahun KKN harus berupa angka.',
            'kkn_year.min' => 'Tahun KKN minimal 2020.',
            'kkn_year.max' => 'Tahun KKN tidak boleh lebih dari 50 tahun depan.',
            'file_type.required' => 'Jenis file harus dipilih.',
            'file_type.in' => 'Jenis file tidak valid.',
            'field_category.required' => 'Kategori bidang harus dipilih.',
            'field_category.in' => 'Kategori bidang tidak valid.',
            'declaration.required' => 'Anda harus menyetujui deklarasi.',
            'declaration.accepted' => 'Anda harus menyetujui deklarasi.',
        ]);

        if ($validator->fails()) {
            print_r($validator->errors());
            die();
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // ANCHOR: Handle File Upload
            $file = $request->file('file');
            $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('knowledge', $fileName, 'public');

            // ANCHOR: Create Knowledge Record
            $knowledge = Knowledge::create([
                'title' => $request->title,
                'description' => $request->description,
                'additional_info' => $request->additional_info,
                'kkn_type' => $request->kkn_type,
                'kkn_year' => $request->kkn_year,
                'file_type' => $request->file_type,
                'field_category' => $request->field_category,
                'kkn_location' => $request->kkn_location,
                'group_number' => $request->group_number,
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $filePath,
                'file_mime_type' => $file->getClientMimeType(),
                'file_size' => $file->getSize(),
                'user_id' => auth()->id(),
                'status' => 'pending',
            ]);

            // ANCHOR: Log Knowledge Upload Activity
            $this->logKnowledgeUpload($request->title);

            return redirect()->route('unggah.pengetahuan')
                ->with('success', 'Pengetahuan berhasil diunggah! Tim kami akan melakukan review dalam waktu 1-3 hari kerja.');

        } catch (\Exception $e) {
            // Delete uploaded file if database insert fails
            if (isset($filePath) && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }

            // Log the error for debugging
            \Log::error('Knowledge upload error: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'file' => $request->file('file') ? $request->file('file')->getClientOriginalName() : 'no file',
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat mengunggah pengetahuan: ' . $e->getMessage())
                ->withInput();
        }
    }

    // ANCHOR: Download File
    public function download(Knowledge $knowledge)
    {
        // Check if user owns this knowledge or has verification permission
        if ($knowledge->user_id !== auth()->id() && !auth()->user()->hasPermission('verifikasi-pengetahuan')) {
            abort(403);
        }

        if (!Storage::disk('public')->exists($knowledge->file_path)) {
            abort(404, 'File tidak ditemukan.');
        }

        // ANCHOR: Log Knowledge Download Activity
        $this->logKnowledgeDownload($knowledge->title);

        return Storage::disk('public')->download($knowledge->file_path, $knowledge->file_name);
    }

    // ANCHOR: Show Verification Index
    public function verificationIndex()
    {
        $pendingKnowledge = Knowledge::with('user')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('kelola-pengetahuan.daftar', compact('pendingKnowledge'))
            ->with('pageType', 'verification');
    }

    // ANCHOR: Show Verification Detail
    public function verificationShow(Knowledge $knowledge)
    {
        if ($knowledge->status !== 'pending') {
            return redirect()->route('verifikasi.pengetahuan')
                ->with('error', 'Pengetahuan ini sudah diverifikasi.');
        }

        return view('kelola-pengetahuan.detail', compact('knowledge'))
            ->with('pageType', 'verification');
    }

    // ANCHOR: Approve Knowledge
    public function approve(Request $request, Knowledge $knowledge)
    {
        if ($knowledge->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'Pengetahuan ini sudah diverifikasi.');
        }

        $knowledge->approve(auth()->id(), null);

        // ANCHOR: Log Knowledge Approval Activity
        $this->logKnowledgeApproval($knowledge->title);

        return redirect()->route('verifikasi.pengetahuan')
            ->with('success', 'Pengetahuan berhasil disetujui!');
    }

    // ANCHOR: Reject Knowledge
    public function reject(Request $request, Knowledge $knowledge)
    {
        if ($knowledge->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'Pengetahuan ini sudah diverifikasi.');
        }

        $knowledge->reject(auth()->id(), null);

        // ANCHOR: Log Knowledge Rejection Activity
        $this->logKnowledgeRejection($knowledge->title);

        return redirect()->route('verifikasi.pengetahuan')
            ->with('success', 'Pengetahuan berhasil ditolak.');
    }

    // ANCHOR: Show Validation Index
    public function validationIndex()
    {
        $verifiedKnowledge = Knowledge::with('user')
            ->where('status', 'verified')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('kelola-pengetahuan.daftar', compact('verifiedKnowledge'))
            ->with('pageType', 'validation');
    }

    // ANCHOR: Show Validation Detail
    public function validationShow(Knowledge $knowledge)
    {
        if ($knowledge->status !== 'verified') {
            return redirect()->route('validasi.pengetahuan')
                ->with('error', 'Pengetahuan ini tidak dapat divalidasi.');
        }

        return view('kelola-pengetahuan.detail', compact('knowledge'))
            ->with('pageType', 'validation');
    }

    // ANCHOR: Validate Knowledge
    public function validateKnowledge(Request $request, Knowledge $knowledge)
    {
        if ($knowledge->status !== 'verified') {
            return redirect()->back()
                ->with('error', 'Pengetahuan ini tidak dapat divalidasi.');
        }

        $knowledge->validate(auth()->id(), null);

        // ANCHOR: Log Knowledge Validation Activity
        $this->logKnowledgeValidation($knowledge->title);

        return redirect()->route('validasi.pengetahuan')
            ->with('success', 'Pengetahuan berhasil divalidasi!');
    }

    // ANCHOR: Reject Validation
    public function rejectValidation(Request $request, Knowledge $knowledge)
    {
        if ($knowledge->status !== 'verified') {
            return redirect()->back()
                ->with('error', 'Pengetahuan ini tidak dapat divalidasi.');
        }

        $knowledge->reject(auth()->id(), null);

        // ANCHOR: Log Knowledge Validation Rejection Activity
        $this->logKnowledgeValidationRejection($knowledge->title);

        return redirect()->route('validasi.pengetahuan')
            ->with('success', 'Pengetahuan berhasil ditolak.');
    }

    // ANCHOR: Show Public Repository Index
    public function publicIndex(Request $request)
    {
        $query = Knowledge::with('user')
            ->where('status', 'validated')
            ->orderBy('created_at', 'desc');

        // ANCHOR: Apply search filter
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // ANCHOR: Apply category filter
        if ($request->filled('category')) {
            $query->where('field_category', $request->get('category'));
        }

        // ANCHOR: Apply file type filter
        if ($request->filled('file_type')) {
            $query->where('file_type', $request->get('file_type'));
        }

        // ANCHOR: Apply location filter
        if ($request->filled('location')) {
            $query->where('kkn_type', $request->get('location'));
        }

        // ANCHOR: Apply KKN type filter
        if ($request->filled('kkn_type')) {
            $query->where('kkn_type', $request->get('kkn_type'));
        }

        // ANCHOR: Apply year filter
        if ($request->filled('year')) {
            $query->where('kkn_year', $request->get('year'));
        }

        $knowledgeItems = $query->paginate(10);

        return view('kelola-pengetahuan.daftar-publik', compact('knowledgeItems'));
    }

    // ANCHOR: Show Public Repository Detail
    public function publicShow(Knowledge $knowledge)
    {
        if ($knowledge->status !== 'validated') {
            abort(404, 'Pengetahuan tidak ditemukan.');
        }

        return view('kelola-pengetahuan.detail', compact('knowledge'))
            ->with('pageType', 'public');
    }

    // ANCHOR: Download Public Repository File
    public function publicDownload(Knowledge $knowledge)
    {
        if ($knowledge->status !== 'validated') {
            abort(404, 'File tidak ditemukan.');
        }

        if (!Storage::disk('public')->exists($knowledge->file_path)) {
            abort(404, 'File tidak ditemukan.');
        }

        return Storage::disk('public')->download($knowledge->file_path);
    }

    // ANCHOR: Show Repository Management Index
    public function repositoryIndex()
    {
        $allKnowledge = Knowledge::with('user')
            ->where('status', 'validated')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('kelola-pengetahuan.daftar', compact('allKnowledge'))
            ->with('pageType', 'repository');
    }



    // ANCHOR: Show Repository Detail
    public function repositoryShow(Knowledge $knowledge)
    {
        if ($knowledge->status !== 'validated') {
            return redirect()->route('kelola.repositori')
                ->with('error', 'Hanya pengetahuan yang sudah divalidasi yang dapat dilihat.');
        }

        return view('kelola-pengetahuan.detail', compact('knowledge'))
            ->with('pageType', 'repository');
    }

    // ANCHOR: Delete Repository Knowledge
    public function repositoryDestroy(Knowledge $knowledge)
    {
        if ($knowledge->status !== 'validated') {
            return redirect()->route('kelola.repositori')
                ->with('error', 'Hanya pengetahuan yang sudah divalidasi yang dapat dihapus.');
        }

        try {
            // ANCHOR: Delete file from storage
            if (Storage::disk('public')->exists($knowledge->file_path)) {
                Storage::disk('public')->delete($knowledge->file_path);
            }

            // ANCHOR: Log Knowledge Deletion Activity
            $this->logKnowledgeDeletion($knowledge->title);

            // ANCHOR: Delete knowledge record
            $knowledge->delete();

            return redirect()->route('kelola.repositori')
                ->with('success', 'Pengetahuan berhasil dihapus!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus pengetahuan: ' . $e->getMessage());
        }
    }
}
