<?php

namespace App\Http\Controllers\Api;

use App\Models\LessonRead;
use Illuminate\Http\Request;
use App\Models\KategoriLesson;
use App\Http\Controllers\Controller;

class ApiLessonController extends Controller
{
    public function getLessonsByCategory(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori_lessons,id'
        ]);

        $userId = auth()->id();
        $categoryId = $request->kategori_id;

        $lessons = KategoriLesson::findOrFail($categoryId)
            ->lessons()
            ->select('id', 'judul', 'deskripsi', 'gambar')
            ->get()
            ->map(function ($lesson) use ($userId) {
                $isRead = LessonRead::where('user_id', $userId)
                    ->where('lesson_id', $lesson->id)
                    ->exists();

                return [
                    'id' => $lesson->id,
                    'judul' => $lesson->judul,
                    'deskripsi' => $lesson->deskripsi,
                    'gambar' => $lesson->gambar,
                    'sudah_dibaca' => $isRead
                ];
            });

        return response()->json([
            'status' => true,
            'message' => 'Lessons retrieved successfully',
            'data' => [
                'lessons' => $lessons
            ]
        ]);
    }
}
