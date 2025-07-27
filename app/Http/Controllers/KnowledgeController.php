<?php

namespace App\Http\Controllers;

use App\Models\Knowledge;
use App\Helpers\UniversityDataHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class KnowledgeController extends Controller
{
    // ANCHOR: Show Upload Form
    public function create()
    {
        return view('kelola-pengetahuan.form')
            ->with('jenis_kkn', UniversityDataHelper::getJenisKKN())
            ->with('tahun_kkn', UniversityDataHelper::getTahunKKN())
            ->with('nomor_kelompok_kkn', UniversityDataHelper::getNoKelompokKKN())
            ->with('jenis_file', UniversityDataHelper::getJenisFile())
            ->with('kategori_bidang', UniversityDataHelper::getKategoriBidang());
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
            'kkn_location' => 'required|string|max:255',
            'group_number' => 'required|integer|min:1|max:100',
            'file' => 'required|file|max:102400', // 100MB max
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
            'kkn_location.required' => 'Lokasi KKN harus diisi.',
            'kkn_location.string' => 'Lokasi KKN harus berupa teks.',
            'kkn_location.max' => 'Lokasi KKN maksimal 255 karakter.',
            'group_number.required' => 'Nomor kelompok harus dipilih.',
            'group_number.integer' => 'Nomor kelompok harus berupa angka.',
            'group_number.min' => 'Nomor kelompok minimal 1.',
            'group_number.max' => 'Nomor kelompok maksimal 100.',
            'file.required' => 'File harus diunggah.',
            'file.file' => 'File yang diunggah tidak valid.',
            'file.max' => 'Ukuran file maksimal 100MB.',
            'declaration.required' => 'Anda harus menyetujui deklarasi.',
            'declaration.accepted' => 'Anda harus menyetujui deklarasi.',
        ]);

        if ($validator->fails()) {
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
                'status' => 'pedding',
            ]);

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

        return Storage::disk('public')->download($knowledge->file_path, $knowledge->file_name);
    }

    // ANCHOR: Show Verification Index
    public function verificationIndex()
    {
        $pendingKnowledge = Knowledge::with('user')
            ->where('status', 'pedding')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('kelola-pengetahuan.verifikasi', compact('pendingKnowledge'));
    }

    // ANCHOR: Show Verification Detail
    public function verificationShow(Knowledge $knowledge)
    {
        if ($knowledge->status !== 'pedding') {
            return redirect()->route('verifikasi.pengetahuan')
                ->with('error', 'Pengetahuan ini sudah diverifikasi.');
        }

        return view('kelola-pengetahuan.verifikasi-detail', compact('knowledge'));
    }

    // ANCHOR: Approve Knowledge
    public function approve(Request $request, Knowledge $knowledge)
    {
        if ($knowledge->status !== 'pedding') {
            return redirect()->back()
                ->with('error', 'Pengetahuan ini sudah diverifikasi.');
        }

        $knowledge->approve(auth()->id(), null);

        return redirect()->route('verifikasi.pengetahuan')
            ->with('success', 'Pengetahuan berhasil disetujui!');
    }

    // ANCHOR: Reject Knowledge
    public function reject(Request $request, Knowledge $knowledge)
    {
        if ($knowledge->status !== 'pedding') {
            return redirect()->back()
                ->with('error', 'Pengetahuan ini sudah diverifikasi.');
        }

        $knowledge->reject(auth()->id(), null);

        return redirect()->route('verifikasi.pengetahuan')
            ->with('success', 'Pengetahuan berhasil ditolak.');
    }
}
