<?php

namespace App\Http\Controllers\Api;

use App\Models\Lesson;
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

    public function getLessonById(Request $request)
    {
        $request->validate([
            'lesson_id' => 'required|exists:lessons,id'
        ]);

        $userId = auth()->id();
        $lessonId = $request->lesson_id;

        $lesson = Lesson::select('id', 'judul', 'deskripsi', 'gambar', 'isi')
            ->findOrFail($lessonId);

        // Cek status sudah dibaca
        $isRead = LessonRead::where('user_id', $userId)
            ->where('lesson_id', $lessonId)
            ->exists();

        // Jika belum dibaca, tandai sebagai sudah dibaca
        if (!$isRead) {
            LessonRead::create([
                'user_id' => $userId,
                'lesson_id' => $lessonId
            ]);
        }

        $lessonData = [
            'id' => $lesson->id,
            'judul' => $lesson->judul,
            'deskripsi' => $lesson->deskripsi,
            'gambar' => $lesson->gambar,
            'isi' => $lesson->isi,
            'sudah_dibaca' => true
        ];

        return response()->json([
            'status' => true,
            'message' => 'Lesson detail retrieved successfully',
            'data' => [
                'lesson' => $lessonData
            ]
        ]);
    }

    public function markAsRead(Request $request)
    {
        $request->validate([
            'lesson_id' => 'required|exists:lessons,id'
        ]);

        $userId = auth()->id();

        // Cek apakah lesson sudah pernah dibaca
        $lessonRead = LessonRead::where('user_id', $userId)
            ->where('lesson_id', $request->lesson_id)
            ->first();


        if (!$lessonRead) {
            LessonRead::create([
                'user_id' => $userId,
                'lesson_id' => $request->lesson_id
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Lesson marked as read successfully'
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Lesson already marked as read'
        ]);
    }
}