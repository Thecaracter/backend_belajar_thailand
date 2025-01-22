<?php

namespace App\Http\Controllers\Admin;

use App\Models\Artikel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ArticleController extends Controller
{
    public function index()
    {
        try {
            $articles = Artikel::with('user')
                ->orderBy('created_at', 'desc')
                ->get();

            return view('admin.artikel', compact('articles'));

        } catch (\Exception $e) {
            Log::error('Error in ArticleController@index: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to load articles.');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'judul' => 'required|max:255',
                'ringkasan' => 'required',
                'konten' => 'required',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            // Convert image to base64
            if ($request->hasFile('foto')) {
                $image = $request->file('foto');
                $foto = 'data:image/' . $image->getClientOriginalExtension() . ';base64,' . base64_encode(file_get_contents($image));
            } else {
                $foto = null;
            }

            Artikel::create([
                'user_id' => Auth::id(),
                'judul' => $request->judul,
                'ringkasan' => $request->ringkasan,
                'konten' => $request->konten,
                'foto' => $foto,
                'is_published' => true,
                'view_count' => 0
            ]);

            Log::info('Article created successfully by user: ' . Auth::id());
            return redirect()->back()->with('success', 'Article has been created successfully.');

        } catch (\Exception $e) {
            Log::error('Error in ArticleController@store: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to create article.')->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'judul' => 'required|max:255',
                'ringkasan' => 'required',
                'konten' => 'required',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            $article = Artikel::findOrFail($id);

            // Handle image update
            if ($request->hasFile('foto')) {
                $image = $request->file('foto');
                $foto = 'data:image/' . $image->getClientOriginalExtension() . ';base64,' . base64_encode(file_get_contents($image));
            } else {
                $foto = $article->foto; // Keep existing image if no new upload
            }

            $article->update([
                'judul' => $request->judul,
                'ringkasan' => $request->ringkasan,
                'konten' => $request->konten,
                'foto' => $foto
            ]);

            Log::info('Article updated successfully. ID: ' . $id . ', User: ' . Auth::id());
            return redirect()->back()->with('success', 'Article has been updated successfully.');

        } catch (\Exception $e) {
            Log::error('Error in ArticleController@update: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update article.')->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $article = Artikel::findOrFail($id);
            $article->delete();

            Log::info('Article deleted successfully. ID: ' . $id . ', User: ' . Auth::id());
            return redirect()->back()->with('success', 'Article has been deleted successfully.');

        } catch (\Exception $e) {
            Log::error('Error in ArticleController@destroy: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to delete article.');
        }
    }
}