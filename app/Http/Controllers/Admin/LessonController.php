<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\KategoriLesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{
    public function index()
    {
        try {
            $lessons = Lesson::with('kategori')->orderBy('created_at', 'desc')->get();
            $categories = KategoriLesson::all();
            return view('admin.lessons', compact('lessons', 'categories'));
        } catch (\Exception $e) {
            Log::error('Error in LessonController@index: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to load lessons.');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'kategori_id' => 'required|exists:kategori_lessons,id',
                'judul' => 'required|max:255',
                'deskripsi' => 'nullable|string',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate as image
                'isi' => 'required|string',
            ]);

            // Convert image to Base64
            $foto = null;
            if ($request->hasFile('gambar')) {
                $image = $request->file('gambar');
                $foto = 'data:image/' . $image->getClientOriginalExtension() . ';base64,' . base64_encode(file_get_contents($image));
            }

            Lesson::create([
                'kategori_id' => $request->kategori_id,
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'gambar' => $foto,
                'isi' => $request->isi,
                'user_id' => Auth::id(), // Optional if you want to track the creator
            ]);

            Log::info('Lesson created successfully by user: ' . Auth::id());
            return redirect()->back()->with('success', 'Lesson has been created successfully.');
        } catch (\Exception $e) {
            Log::error('Error in LessonController@store: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to create lesson.')->withInput();
        }
    }

    public function update(Request $request, Lesson $lesson)
    {
        try {
            $request->validate([
                'kategori_id' => 'required|exists:kategori_lessons,id',
                'judul' => 'required|max:255',
                'deskripsi' => 'nullable|string',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate as image
                'isi' => 'required|string',
            ]);

            // Convert image to Base64
            $foto = null;
            if ($request->hasFile('gambar')) {
                $image = $request->file('gambar');
                $foto = 'data:image/' . $image->getClientOriginalExtension() . ';base64,' . base64_encode(file_get_contents($image));
            } else {
                $foto = $lesson->gambar; // Keep existing image if no new upload
            }

            $lesson->update([
                'kategori_id' => $request->kategori_id,
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'gambar' => $foto,
                'isi' => $request->isi,
            ]);

            Log::info('Lesson updated successfully. ID: ' . $lesson->id . ', User: ' . Auth::id());
            return redirect()->back()->with('success', 'Lesson has been updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error in LessonController@update: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update lesson.')->withInput();
        }
    }

    public function destroy(Lesson $lesson)
    {
        try {
            $lesson->delete();
            Log::info('Lesson deleted successfully. ID: ' . $lesson->id . ', User: ' . Auth::id());
            return redirect()->back()->with('success', 'Lesson has been deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error in LessonController@destroy: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to delete lesson.');
        }
    }
}