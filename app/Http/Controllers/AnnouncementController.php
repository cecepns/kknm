<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    /**
     * Menampilkan daftar semua pengumuman.
     */
    public function index()
    {
        $announcements = Announcement::with('user')->latest()->get();
        return view('kelola-pengumuman.daftar', compact('announcements'));
    }

    /**
     * Menampilkan form untuk membuat pengumuman baru.
     */
    public function create()
    {
        return view('kelola-pengumuman.form');
    }

    /**
     * Menyimpan pengumuman yang baru dibuat.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'published_date' => 'required|date',
        ]);

        Announcement::create([
            'title' => $request->title,
            'content' => $request->content,
            'published_date' => $request->published_date,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('daftar.kelola.pengumuman')->with('success', 'Pengumuman baru berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit pengumuman.
     */
    public function edit(Announcement $announcement)
    {
        return view('kelola-pengumuman.form', compact('announcement'));
    }

    /**
     * Memperbarui pengumuman yang ada.
     */
    public function update(Request $request, Announcement $announcement)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'published_date' => 'required|date',
        ]);

        $announcement->update($request->all());

        return redirect()->route('daftar.kelola.pengumuman')->with('success', 'Pengumuman berhasil diperbarui!');
    }

    /**
     * Menghapus pengumuman.
     */
    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
        return redirect()->route('daftar.kelola.pengumuman')->with('success', 'Pengumuman berhasil dihapus!');
    }
}
