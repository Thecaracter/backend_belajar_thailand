<?php

namespace App\Http\Controllers\Api;

use App\Models\Artikel;
use App\Models\ArtikelLike;
use Illuminate\Http\Request;
use App\Models\ArtikelBookmark;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ApiArtikelController extends Controller
{
    public function index()
    {
        try {
            $artikel = Artikel::with(['user:id,name'])
                ->withCount('likes')
                ->where('is_published', true)
                ->orderBy('created_at', 'desc')
                ->select('id', 'user_id', 'judul', 'ringkasan', 'foto', 'like_count', 'view_count', 'created_at')
                ->paginate(10);

            $artikel->getCollection()->transform(function ($item) {
                $item->penulis = $item->user->name;
                unset($item->user);
                return $item;
            });

            return response()->json([
                'status' => 'success',
                'message' => 'Articles retrieved successfully',
                'data' => $artikel
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve articles',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $artikel = Artikel::with(['user:id,name'])
                ->withCount('likes')
                ->findOrFail($request->id);

            if ($artikel->is_published) {
                $artikel->increment('view_count');
            }

            $artikel->penulis = $artikel->user->name;
            unset($artikel->user);

            return response()->json([
                'status' => 'success',
                'message' => 'Article retrieved successfully',
                'data' => $artikel
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Article not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve article',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function like(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $artikel = Artikel::findOrFail($request->id);
            $user = Auth::user();

            $existingLike = ArtikelLike::where('user_id', $user->id)
                ->where('artikel_id', $artikel->id)
                ->first();

            if ($existingLike) {
                $existingLike->delete();
                $message = 'Article unliked successfully';
            } else {
                ArtikelLike::create([
                    'user_id' => $user->id,
                    'artikel_id' => $artikel->id
                ]);
                $message = 'Article liked successfully';
            }

            return response()->json([
                'status' => 'success',
                'message' => $message,
                'data' => ['likes_count' => $artikel->likes()->count()]
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Article not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to process like',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function bookmark(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $artikel = Artikel::findOrFail($request->id);
            $user = Auth::user();

            $existingBookmark = ArtikelBookmark::where('user_id', $user->id)
                ->where('artikel_id', $artikel->id)
                ->first();

            if ($existingBookmark) {
                $existingBookmark->delete();
                $message = 'Bookmark removed successfully';
            } else {
                ArtikelBookmark::create([
                    'user_id' => $user->id,
                    'artikel_id' => $artikel->id
                ]);
                $message = 'Article bookmarked successfully';
            }

            return response()->json([
                'status' => 'success',
                'message' => $message
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Article not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to process bookmark',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
