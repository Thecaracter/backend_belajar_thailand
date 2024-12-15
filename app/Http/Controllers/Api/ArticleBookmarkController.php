<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ArticleBookmarkController extends Controller
{
    public function getBookmarkedArticles(Request $request): JsonResponse
    {
        try {
            $user = $request->user();

            $bookmarkedArticles = Artikel::whereHas('bookmarks', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
                ->with(['user:id,name,avatar', 'bookmarks'])
                ->select([
                    'id',
                    'user_id',
                    'judul',
                    'ringkasan',
                    'foto',
                    'konten',
                    'view_count',
                    'like_count',
                    'created_at'
                ])
                ->where('is_published', true)
                ->latest()
                ->get();

            return response()->json([
                'status' => 'success',
                'data' => $bookmarkedArticles
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch bookmarked articles'
            ], 500);
        }
    }
}