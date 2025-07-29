<?php

namespace App\Http\Controllers;

use App\Models\KnowledgeCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KnowledgeCategoryController extends Controller
{
    /**
     * ANCHOR: Display a listing of the resource.
     */
    public function index()
    {
        $categories = KnowledgeCategory::orderBy('name', 'asc')->get();
        return view('kelola-kategori-pengetahuan.index', compact('categories'));
    }

    /**
     * ANCHOR: Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kelola-kategori-pengetahuan.create');
    }

    /**
     * ANCHOR: Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:knowledge_categories,name',
        ], [
            'name.required' => 'Nama kategori harus diisi.',
            'name.string' => 'Nama kategori harus berupa teks.',
            'name.max' => 'Nama kategori maksimal 255 karakter.',
            'name.unique' => 'Nama kategori sudah ada.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            KnowledgeCategory::create([
                'name' => $request->name,
            ]);

            return redirect()->route('kelola.kategori.pengetahuan.index')
                ->with('success', 'Kategori pengetahuan berhasil ditambahkan!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menambahkan kategori: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * ANCHOR: Display the specified resource.
     */
    public function show($id)
    {
        $knowledgeCategory = KnowledgeCategory::findOrFail($id);
        return view('kelola-kategori-pengetahuan.show', compact('knowledgeCategory'));
    }

    /**
     * ANCHOR: Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $knowledgeCategory = KnowledgeCategory::findOrFail($id);
        return view('kelola-kategori-pengetahuan.edit', compact('knowledgeCategory'));
    }

    /**
     * ANCHOR: Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $knowledgeCategory = KnowledgeCategory::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:knowledge_categories,name,' . $knowledgeCategory->id,
        ], [
            'name.required' => 'Nama kategori harus diisi.',
            'name.string' => 'Nama kategori harus berupa teks.',
            'name.max' => 'Nama kategori maksimal 255 karakter.',
            'name.unique' => 'Nama kategori sudah ada.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $knowledgeCategory->update([
                'name' => $request->name,
            ]);

            return redirect()->route('kelola.kategori.pengetahuan.index')
                ->with('success', 'Kategori pengetahuan berhasil diperbarui!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui kategori: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * ANCHOR: Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Find the category by ID
            $knowledgeCategory = KnowledgeCategory::findOrFail($id);

            // Debug: Log the category being deleted
            \Log::info('Attempting to delete knowledge category', [
                'id' => $knowledgeCategory->id,
                'name' => $knowledgeCategory->name,
                'knowledge_count' => $knowledgeCategory->knowledgeItems()->count()
            ]);

            // Check if category is being used by any knowledge
            if ($knowledgeCategory->knowledgeItems()->count() > 0) {
                \Log::warning('Cannot delete category - still has knowledge items', [
                    'category_id' => $knowledgeCategory->id,
                    'knowledge_count' => $knowledgeCategory->knowledgeItems()->count()
                ]);
                
                return redirect()->back()
                    ->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh pengetahuan.');
            }

            // Store category info before deletion for logging
            $categoryInfo = [
                'id' => $knowledgeCategory->id,
                'name' => $knowledgeCategory->name
            ];

            // Delete the category
            $deleted = $knowledgeCategory->delete();

            \Log::info('Knowledge category deletion result', [
                'category_info' => $categoryInfo,
                'deleted' => $deleted
            ]);

            if ($deleted) {
                return redirect()->route('kelola.kategori.pengetahuan.index')
                    ->with('success', 'Kategori pengetahuan berhasil dihapus!');
            } else {
                return redirect()->back()
                    ->with('error', 'Gagal menghapus kategori pengetahuan.');
            }

        } catch (\Exception $e) {
            \Log::error('Error deleting knowledge category', [
                'category_id' => $id ?? 'unknown',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus kategori: ' . $e->getMessage());
        }
    }
}
