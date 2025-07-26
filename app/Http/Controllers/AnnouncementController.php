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
     * ANCHOR: Menghapus pengumuman dan semua file terkait
     * Delete announcement and all associated files from storage
     */
    public function destroy(Announcement $announcement)
    {
        try {
            // Delete all associated files
            $deletedFiles = $this->deleteAssociatedFiles($announcement->content, $announcement->id);
            
            // Delete the announcement
            $announcement->delete();
            
            // Log the deletion
            \Log::info('Announcement deleted with associated files', [
                'announcement_id' => $announcement->id,
                'title' => $announcement->title,
                'deleted_files_count' => count($deletedFiles),
                'deleted_files' => $deletedFiles
            ]);
            
            $message = 'Pengumuman berhasil dihapus!';
            if (!empty($deletedFiles)) {
                $message .= ' (' . count($deletedFiles) . ' file terkait juga dihapus)';
            }
            
            return redirect()->route('daftar.kelola.pengumuman')->with('success', $message);
            
        } catch (\Exception $e) {
            \Log::error('Error deleting announcement: ' . $e->getMessage(), [
                'announcement_id' => $announcement->id
            ]);
            
            return redirect()->route('daftar.kelola.pengumuman')->with('error', 'Gagal menghapus pengumuman: ' . $e->getMessage());
        }
    }

    /**
     * ANCHOR: Delete all files associated with announcement content
     * Extract and delete files from HTML content
     */
    private function deleteAssociatedFiles($content, $announcementId)
    {
        $deletedFiles = [];
        
        // Find all file links (download links)
        preg_match_all('/href="[^"]*\/storage\/announcements\/([^"]+)"/', $content, $fileMatches);
        if (!empty($fileMatches[1])) {
            foreach ($fileMatches[1] as $filename) {
                if ($this->deleteFileIfValid($filename, $announcementId, 'file')) {
                    $deletedFiles[] = $filename;
                }
            }
        }
        
        // Find all image URLs
        preg_match_all('/src="[^"]*\/storage\/announcements\/([^"]+)"/', $content, $imageMatches);
        if (!empty($imageMatches[1])) {
            foreach ($imageMatches[1] as $filename) {
                if ($this->deleteFileIfValid($filename, $announcementId, 'image')) {
                    $deletedFiles[] = $filename;
                }
            }
        }
        
        return $deletedFiles;
    }

    /**
     * ANCHOR: Delete file if filename is valid and file exists
     * Security check and file deletion helper
     */
    private function deleteFileIfValid($filename, $announcementId, $type = 'file')
    {
        // Security check: ensure filename is safe
        if (!preg_match('/^[0-9]+_[a-zA-Z0-9._-]+$/', $filename)) {
            \Log::warning('Invalid filename pattern during announcement deletion', [
                'filename' => $filename,
                'announcement_id' => $announcementId,
                'type' => $type
            ]);
            return false;
        }
        
        $filePath = 'announcements/' . $filename;
        if (\Storage::disk('public')->exists($filePath)) {
            \Storage::disk('public')->delete($filePath);
            \Log::info("{$type} deleted during announcement deletion", [
                'filename' => $filename,
                'announcement_id' => $announcementId,
                'type' => $type
            ]);
            return true;
        }
        
        \Log::info("{$type} not found during announcement deletion", [
            'filename' => $filename,
            'announcement_id' => $announcementId,
            'type' => $type
        ]);
        return false;
    }

    /**
     * Menampilkan daftar pengumuman untuk akses publik (tanpa edit/delete)
     */
    public function publicIndex()
    {
        $announcements = Announcement::with('user')
            ->orderBy('published_date', 'desc')
            ->get();

        return view('akses-pengumuman.daftar', compact('announcements'));
    }

    /**
     * Menampilkan detail pengumuman untuk akses publik
     */
    public function publicShow($id)
    {
        $announcement = Announcement::with('user')->findOrFail($id);

        return view('akses-pengumuman.detail', compact('announcement'));
    }

    /**
     * ANCHOR: Handle file upload for Trix editor
     * Upload file and return URL for Trix editor attachment
     */
    public function uploadFile(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpeg,png,jpg,gif,webp,pdf,doc,docx,txt|max:5120', // 5MB max, support more file types
        ]);

        try {
            $file = $request->file('file');
            $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $filePath = $file->storeAs('public/announcements', $fileName);
            
            // Generate URL using simple approach
            $fileUrl = request()->getSchemeAndHttpHost() . '/storage/announcements/' . $fileName;
            
            // Check if file exists
            $fileExists = \Storage::disk('public')->exists('announcements/' . $fileName);
            
            \Log::info('File upload debug', [
                'fileName' => $fileName,
                'filePath' => $filePath,
                'fileUrl' => $fileUrl,
                'fileExists' => $fileExists,
                'storagePath' => storage_path('app/public/announcements/' . $fileName)
            ]);
            
            return response()->json([
                'success' => true,
                'url' => $fileUrl,
                'filename' => $fileName,
                'filesize' => $file->getSize(),
                'mime_type' => $file->getMimeType()
            ]);
        } catch (\Exception $e) {
            \Log::error('File upload error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupload file: ' . $e->getMessage()
            ], 500);
        }
    }


}
