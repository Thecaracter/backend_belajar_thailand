<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\ArtikelBookmark;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ApiBookmarkController extends Controller
{
    public function index()
    {
        try {
            $user = Auth::user();
            $bookmarks = ArtikelBookmark::where('user_id', $user->id)
                ->with([
                    'artikel' => function ($query) {
                        $query->with('user:id,name')
                            ->withCount('likes');
                    }
                ])
                ->latest()
                ->get();

            $formattedBookmarks = $bookmarks->map(function ($bookmark) {
                $artikel = $bookmark->artikel;
                $artikel->penulis = $artikel->user->name ?? 'Unknown Author';
                unset($artikel->user);

                // Menambahkan informasi bookmark
                $artikel->bookmarked_at = $bookmark->created_at;

                return $artikel;
            });

            return response()->json([
                'status' => 'success',
                'message' => 'Bookmarked articles retrieved successfully',
                'data' => $formattedBookmarks
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve bookmarked articles',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function toggle(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer|exists:artikel,id'
            ]);

            $user = Auth::user();
            $artikelId = $request->id;

            $existingBookmark = ArtikelBookmark::where('user_id', $user->id)
                ->where('artikel_id', $artikelId)
                ->first();

            if ($existingBookmark) {
                $existingBookmark->delete();
                $message = 'Bookmark removed successfully';
            } else {
                ArtikelBookmark::create([
                    'user_id' => $user->id,
                    'artikel_id' => $artikelId
                ]);
                $message = 'Article bookmarked successfully';
            }

            return response()->json([
                'status' => 'success',
                'message' => $message
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to process bookmark',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
