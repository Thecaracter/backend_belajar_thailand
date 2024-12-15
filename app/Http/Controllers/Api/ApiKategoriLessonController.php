<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KategoriLesson;
use App\Models\LessonRead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiKategoriLessonController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $categories = KategoriLesson::with([
            'lessons' => function ($query) {
                $query->select('id', 'kategori_id');
            }
        ])
            ->get()
            ->map(function ($category) use ($userId) {
                // Count unread lessons for this category
                $totalLessons = $category->lessons->count();
                $readLessons = LessonRead::where('user_id', $userId)
                    ->whereIn('lesson_id', $category->lessons->pluck('id'))
                    ->count();

                $unreadCount = $totalLessons - $readLessons;

                return [
                    'id' => $category->id,
                    'nama' => $category->nama,
                    'jumlah_baru' => $unreadCount,
                    'progress' => $totalLessons > 0
                        ? round(($readLessons / $totalLessons) * 100)
                        : 0
                ];
            });

        return response()->json([
            'status' => true,
            'message' => 'Categories retrieved successfully',
            'data' => [
                'categories' => $categories
            ]
        ]);
    }
}