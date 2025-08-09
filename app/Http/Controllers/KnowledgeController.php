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
        $userKnowledge = Knowledge::with('category')
            ->where('user_id', auth()->id())
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
        $knowledge = Knowledge::with(['user', 'category'])->findOrFail($id);
        
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
            'category_id' => 'required|exists:knowledge_categories,id',
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
            'category_id.required' => 'Kategori bidang harus dipilih.',
            'category_id.exists' => 'Kategori bidang tidak valid.',
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
                'category_id' => $request->category_id,
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

    // ANCHOR: Destroy Knowledge
    public function destroy(Knowledge $knowledge)
    {
        // Check if user owns this knowledge
        if ($knowledge->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki izin untuk menghapus pengetahuan ini.');
        }

        // Check if knowledge can be deleted (only pending or rejected status can be deleted by user)
        if (!in_array($knowledge->status, ['pending', 'rejected'])) {
            return redirect()->back()
                ->with('error', 'Hanya pengetahuan yang masih menunggu review atau ditolak yang dapat dihapus.');
        }

        try {
            // ANCHOR: Log Knowledge Deletion Activity
            $this->logKnowledgeDeletion($knowledge->title);

            // ANCHOR: Delete file from storage
            if (Storage::disk('public')->exists($knowledge->file_path)) {
                Storage::disk('public')->delete($knowledge->file_path);
            }

            // ANCHOR: Delete knowledge record
            $knowledge->delete();

                    return redirect()->route('unggah.pengetahuan')
            ->with('success', 'Pengetahuan berhasil dihapus!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus pengetahuan: ' . $e->getMessage());
        }
    }

    // ANCHOR: Show Edit Form
    public function edit(Knowledge $knowledge)
    {
        // Check if user owns this knowledge
        if ($knowledge->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki izin untuk mengedit pengetahuan ini.');
        }

        // Check if knowledge can be edited (only pending or rejected status can be edited by user)
        if (!in_array($knowledge->status, ['pending', 'rejected'])) {
            return redirect()->back()
                ->with('error', 'Hanya pengetahuan yang masih menunggu review atau ditolak yang dapat diedit.');
        }

        return view('kelola-pengetahuan.form', compact('knowledge'))
            ->with('jenis_kkn', UniversityDataHelper::getJenisKKN())
            ->with('tahun_kkn', UniversityDataHelper::getTahunKKN())
            ->with('nomor_kelompok_kkn', UniversityDataHelper::getNoKelompokKKN())
            ->with('jenis_file', UniversityDataHelper::getJenisFile())
            ->with('kategori_bidang', UniversityDataHelper::getKategoriBidang())
            ->with('user_role', auth()->user()->role_id)
            ->with('isEdit', true);
    }

    // ANCHOR: Update Knowledge
    public function update(Request $request, Knowledge $knowledge)
    {
        // Check if user owns this knowledge
        if ($knowledge->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki izin untuk mengedit pengetahuan ini.');
        }

        // Check if knowledge can be edited (only pending or rejected status can be edited by user)
        if (!in_array($knowledge->status, ['pending', 'rejected'])) {
            return redirect()->back()
                ->with('error', 'Hanya pengetahuan yang masih menunggu review atau ditolak yang dapat diedit.');
        }

        // Validate request
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:5000',
            'kkn_type' => 'required|string|max:255',
            'kkn_year' => 'required|integer|min:2020|max:' . (date('Y') + 50),
            'file_type' => 'required|in:dokumen,presentasi,video,gambar,lainnya',
            'category_id' => 'required|exists:knowledge_categories,id',
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
            'category_id.required' => 'Kategori bidang harus dipilih.',
            'category_id.exists' => 'Kategori bidang tidak valid.',
            'declaration.required' => 'Anda harus menyetujui deklarasi.',
            'declaration.accepted' => 'Anda harus menyetujui deklarasi.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $oldFilePath = $knowledge->file_path;
            $newFilePath = null;

            // ANCHOR: Handle File Upload if new file is provided
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                $newFilePath = $file->storeAs('knowledge', $fileName, 'public');
            }

            // ANCHOR: Update Knowledge Record
            $updateData = [
                'title' => $request->title,
                'description' => $request->description,
                'additional_info' => $request->additional_info,
                'kkn_type' => $request->kkn_type,
                'kkn_year' => $request->kkn_year,
                'file_type' => $request->file_type,
                'category_id' => $request->category_id,
                'kkn_location' => $request->kkn_location,
                'group_number' => $request->group_number,
            ];

            // Update file information if new file is uploaded
            if ($newFilePath) {
                $updateData['file_name'] = $request->file('file')->getClientOriginalName();
                $updateData['file_path'] = $newFilePath;
                $updateData['file_mime_type'] = $request->file('file')->getClientMimeType();
                $updateData['file_size'] = $request->file('file')->getSize();
            }

            $knowledge->update($updateData);

            // ANCHOR: Delete old file if new file is uploaded
            if ($newFilePath && $oldFilePath && Storage::disk('public')->exists($oldFilePath)) {
                Storage::disk('public')->delete($oldFilePath);
            }

            // ANCHOR: Log Knowledge Update Activity
            $this->logKnowledgeUpdate($knowledge->title);

            return redirect()->route('unggah.pengetahuan')
                ->with('success', 'Pengetahuan berhasil diperbarui! Tim kami akan melakukan review ulang dalam waktu 1-3 hari kerja.');

        } catch (\Exception $e) {
            // Delete uploaded file if database update fails
            if (isset($newFilePath) && Storage::disk('public')->exists($newFilePath)) {
                Storage::disk('public')->delete($newFilePath);
            }

            // Log the error for debugging
            \Log::error('Knowledge update error: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'knowledge_id' => $knowledge->id,
                'file' => $request->hasFile('file') ? $request->file('file')->getClientOriginalName() : 'no file',
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui pengetahuan: ' . $e->getMessage())
                ->withInput();
        }
    }

    // ANCHOR: Show Verification Index
    public function verificationIndex()
    {
        $pendingKnowledge = Knowledge::with(['user', 'category'])
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

        $knowledge->load(['user', 'category']);

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

    // ANCHOR: Batch Approve Knowledge
    public function batchApprove(Request $request)
    {
        $request->validate([
            'knowledge_ids' => 'required|array|min:1',
            'knowledge_ids.*' => 'exists:knowledge,id'
        ]);

        $knowledgeIds = $request->knowledge_ids;
        $approvedCount = 0;
        $errors = [];

        foreach ($knowledgeIds as $id) {
            $knowledge = Knowledge::find($id);
            
            if (!$knowledge) {
                $errors[] = "Pengetahuan dengan ID {$id} tidak ditemukan.";
                continue;
            }

            if ($knowledge->status !== 'pending') {
                $errors[] = "Pengetahuan '{$knowledge->title}' sudah diverifikasi.";
                continue;
            }

            $knowledge->approve(auth()->id(), null);
            $this->logKnowledgeApproval($knowledge->title);
            $approvedCount++;
        }

        $message = "{$approvedCount} pengetahuan berhasil diverifikasi!";
        if (!empty($errors)) {
            $message .= " Beberapa item tidak dapat diproses: " . implode(', ', $errors);
        }

        return redirect()->route('verifikasi.pengetahuan')
            ->with($approvedCount > 0 ? 'success' : 'error', $message);
    }

    // ANCHOR: Batch Reject Knowledge
    public function batchReject(Request $request)
    {
        $request->validate([
            'knowledge_ids' => 'required|array|min:1',
            'knowledge_ids.*' => 'exists:knowledge,id'
        ]);

        $knowledgeIds = $request->knowledge_ids;
        $rejectedCount = 0;
        $errors = [];

        foreach ($knowledgeIds as $id) {
            $knowledge = Knowledge::find($id);
            
            if (!$knowledge) {
                $errors[] = "Pengetahuan dengan ID {$id} tidak ditemukan.";
                continue;
            }

            if ($knowledge->status !== 'pending') {
                $errors[] = "Pengetahuan '{$knowledge->title}' sudah diverifikasi.";
                continue;
            }

            $knowledge->reject(auth()->id(), null);
            $this->logKnowledgeRejection($knowledge->title);
            $rejectedCount++;
        }

        $message = "{$rejectedCount} pengetahuan berhasil ditolak!";
        if (!empty($errors)) {
            $message .= " Beberapa item tidak dapat diproses: " . implode(', ', $errors);
        }

        return redirect()->route('verifikasi.pengetahuan')
            ->with($rejectedCount > 0 ? 'success' : 'error', $message);
    }

    // ANCHOR: Show Validation Index
    public function validationIndex()
    {
        $verifiedKnowledge = Knowledge::with(['user', 'category'])
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

        $knowledge->load(['user', 'category']);

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

    // ANCHOR: Batch Validate Knowledge
    public function batchValidate(Request $request)
    {
        $request->validate([
            'knowledge_ids' => 'required|array|min:1',
            'knowledge_ids.*' => 'exists:knowledge,id'
        ]);

        $knowledgeIds = $request->knowledge_ids;
        $validatedCount = 0;
        $errors = [];

        foreach ($knowledgeIds as $id) {
            $knowledge = Knowledge::find($id);
            
            if (!$knowledge) {
                $errors[] = "Pengetahuan dengan ID {$id} tidak ditemukan.";
                continue;
            }

            if ($knowledge->status !== 'verified') {
                $errors[] = "Pengetahuan '{$knowledge->title}' tidak dapat divalidasi.";
                continue;
            }

            $knowledge->validate(auth()->id(), null);
            $this->logKnowledgeValidation($knowledge->title);
            $validatedCount++;
        }

        $message = "{$validatedCount} pengetahuan berhasil divalidasi!";
        if (!empty($errors)) {
            $message .= " Beberapa item tidak dapat diproses: " . implode(', ', $errors);
        }

        return redirect()->route('validasi.pengetahuan')
            ->with($validatedCount > 0 ? 'success' : 'error', $message);
    }

    // ANCHOR: Batch Reject Validation
    public function batchRejectValidation(Request $request)
    {
        $request->validate([
            'knowledge_ids' => 'required|array|min:1',
            'knowledge_ids.*' => 'exists:knowledge,id'
        ]);

        $knowledgeIds = $request->knowledge_ids;
        $rejectedCount = 0;
        $errors = [];

        foreach ($knowledgeIds as $id) {
            $knowledge = Knowledge::find($id);
            
            if (!$knowledge) {
                $errors[] = "Pengetahuan dengan ID {$id} tidak ditemukan.";
                continue;
            }

            if ($knowledge->status !== 'verified') {
                $errors[] = "Pengetahuan '{$knowledge->title}' tidak dapat divalidasi.";
                continue;
            }

            $knowledge->reject(auth()->id(), null);
            $this->logKnowledgeValidationRejection($knowledge->title);
            $rejectedCount++;
        }

        $message = "{$rejectedCount} pengetahuan berhasil ditolak!";
        if (!empty($errors)) {
            $message .= " Beberapa item tidak dapat diproses: " . implode(', ', $errors);
        }

        return redirect()->route('validasi.pengetahuan')
            ->with($rejectedCount > 0 ? 'success' : 'error', $message);
    }

    // ANCHOR: Show Public Repository Index
    public function publicIndex(Request $request)
    {
        $query = Knowledge::with(['user', 'category'])
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
            $query->where('category_id', $request->get('category'));
        }

        // ANCHOR: Apply file type filter
        if ($request->filled('file_type')) {
            $query->where('file_type', $request->get('file_type'));
        }

        // ANCHOR: Apply group filter
        if ($request->filled('group')) {
            $query->where('group_number', $request->get('group'));
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

        // ANCHOR: Get unique KKN groups for filter
        $kknGroups = UniversityDataHelper::getKKNGroups();

        return view('kelola-pengetahuan.daftar-publik', compact('knowledgeItems', 'kknGroups'));
    }

    // ANCHOR: Show Public Repository Detail
    public function publicShow(Knowledge $knowledge)
    {
        if ($knowledge->status !== 'validated') {
            abort(404, 'Pengetahuan tidak ditemukan.');
        }

        $knowledge->load(['user', 'category']);

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
        $allKnowledge = Knowledge::with(['user', 'category'])
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

        $knowledge->load(['user', 'category']);

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
