<?php

namespace App\Http\Controllers;

use App\Models\ForumCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumCategoryController extends Controller
{
    /**
     * Menampilkan daftar semua kategori forum.
     */
    public function index()
    {
        $categories = ForumCategory::with(['user', 'discussions'])->latest()->get();
        return view('kelola-kategori-forum.daftar', compact('categories'));
    }

    /**
     * Menampilkan form untuk membuat kategori forum baru.
     */
    public function create()
    {
        return view('kelola-kategori-forum.form');
    }

    /**
     * Menyimpan kategori forum yang baru dibuat.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        ForumCategory::create([
            'name' => $request->name,
            'description' => $request->description,
            'topic_count' => 0,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('daftar.kelola.kategori.forum')->with('success', 'Kategori forum baru berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit kategori forum.
     */
    public function edit(ForumCategory $forumCategory)
    {
        return view('kelola-kategori-forum.form', compact('forumCategory'));
    }

    /**
     * Memperbarui kategori forum yang ada.
     */
    public function update(Request $request, ForumCategory $forumCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $forumCategory->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('daftar.kelola.kategori.forum')->with('success', 'Kategori forum berhasil diperbarui!');
    }

    /**
     * Menghapus kategori forum.
     */
    public function destroy(ForumCategory $forumCategory)
    {
        $forumCategory->delete();
        return redirect()->route('daftar.kelola.kategori.forum')->with('success', 'Kategori forum berhasil dihapus!');
    }
}
