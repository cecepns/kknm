<?php

namespace App\Http\Controllers;

use App\Models\Knowledge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class KnowledgeController extends Controller
{
    // ANCHOR: Show Upload Form
    public function create()
    {
        return view('unggah-pengetahuan.form');
    }

    // ANCHOR: Store Knowledge
    public function store(Request $request)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:5000',
            'jenis_kkn' => 'required|in:reguler,tematik,internasional',
            'tahun_kkn' => 'required|integer|min:2020|max:' . (date('Y') + 1),
            'jenis_file' => 'required|in:dokumen,presentasi,video,gambar,lainnya',
            'kategori_bidang' => 'required|in:pendidikan,kesehatan,ekonomi,lingkungan,teknologi,sosial',
            'lokasi_kkn' => 'required|string|max:255',
            'nomor_kelompok' => 'required|integer|min:1|max:100',
            'file' => 'required|file|max:102400', // 100MB max
            'declaration' => 'required|accepted',
        ], [
            'judul.required' => 'Judul pengetahuan harus diisi.',
            'judul.max' => 'Judul pengetahuan maksimal 255 karakter.',
            'deskripsi.required' => 'Deskripsi harus diisi.',
            'deskripsi.max' => 'Deskripsi maksimal 5000 karakter.',
            'jenis_kkn.required' => 'Jenis KKN harus dipilih.',
            'jenis_kkn.in' => 'Jenis KKN tidak valid.',
            'tahun_kkn.required' => 'Tahun KKN harus dipilih.',
            'tahun_kkn.integer' => 'Tahun KKN harus berupa angka.',
            'tahun_kkn.min' => 'Tahun KKN minimal 2020.',
            'tahun_kkn.max' => 'Tahun KKN tidak boleh lebih dari tahun depan.',
            'jenis_file.required' => 'Jenis file harus dipilih.',
            'jenis_file.in' => 'Jenis file tidak valid.',
            'kategori_bidang.required' => 'Kategori bidang harus dipilih.',
            'kategori_bidang.in' => 'Kategori bidang tidak valid.',
            'lokasi_kkn.required' => 'Lokasi KKN harus diisi.',
            'lokasi_kkn.string' => 'Lokasi KKN harus berupa teks.',
            'lokasi_kkn.max' => 'Lokasi KKN maksimal 255 karakter.',
            'nomor_kelompok.required' => 'Nomor kelompok harus dipilih.',
            'nomor_kelompok.integer' => 'Nomor kelompok harus berupa angka.',
            'nomor_kelompok.min' => 'Nomor kelompok minimal 1.',
            'nomor_kelompok.max' => 'Nomor kelompok maksimal 100.',
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
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'informasi_tambahan' => $request->informasi_tambahan,
                'jenis_kkn' => $request->jenis_kkn,
                'tahun_kkn' => $request->tahun_kkn,
                'jenis_file' => $request->jenis_file,
                'kategori_bidang' => $request->kategori_bidang,
                'lokasi_kkn' => $request->lokasi_kkn,
                'nomor_kelompok' => $request->nomor_kelompok,
                'nama_file' => $file->getClientOriginalName(),
                'path_file' => $filePath,
                'tipe_file' => $file->getClientMimeType(),
                'ukuran_file' => $file->getSize(),
                'user_id' => auth()->id(),
                'status' => 'pending',
            ]);

            return redirect()->route('unggah.pengetahuan')
                ->with('success', 'Pengetahuan berhasil diunggah! Tim kami akan melakukan review dalam waktu 1-3 hari kerja.');

        } catch (\Exception $e) {
            // Delete uploaded file if database insert fails
            if (isset($filePath) && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat mengunggah pengetahuan. Silakan coba lagi.')
                ->withInput();
        }
    }

    // ANCHOR: Download File
    public function download(Knowledge $knowledge)
    {
        // Check if user owns this knowledge or has admin permission
        if ($knowledge->user_id !== auth()->id() && !auth()->user()->hasPermission('validasi-pengetahuan')) {
            abort(403);
        }

        if (!Storage::disk('public')->exists($knowledge->path_file)) {
            abort(404, 'File tidak ditemukan.');
        }

        return Storage::disk('public')->download($knowledge->path_file, $knowledge->nama_file);
    }
}
