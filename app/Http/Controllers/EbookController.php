<?php

namespace App\Http\Controllers;

use App\Models\Ebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class EbookController extends Controller
{
    public function index()
    {
        $ebooks = Ebook::all();

        return view('dashboard', compact('ebooks'));
    }

    public function destroy(Ebook $ebook)
    {
        // Hapus file dari storage jika ada
        if (Storage::disk('public')->exists($ebook->file_path)) {
            Storage::disk('public')->delete($ebook->file_path);
        }

        // Hapus data dari database
        $ebook->delete();

        return redirect()->back()->with('success', 'eBook berhasil dihapus.');
    }
}
