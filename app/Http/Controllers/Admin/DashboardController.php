<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use App\Models\Lesson;
use App\Models\User;
use App\Models\LessonRead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get total counts
        $totalUsers = User::count();
        $totalArtikel = Artikel::count();
        $totalLessons = Lesson::count();

        // Get published vs unpublished articles
        $publishedArtikel = Artikel::where('is_published', true)->count();
        $unpublishedArtikel = Artikel::where('is_published', false)->count();

        // Get most viewed articles
        $popularArticles = Artikel::orderBy('view_count', 'desc')
            ->take(5)
            ->with('user')
            ->get();

        // Get most liked articles
        $mostLikedArticles = Artikel::withCount('likes')
            ->orderBy('likes_count', 'desc')
            ->take(5)
            ->with('user')
            ->get();

        // Get most read lessons
        $mostReadLessons = Lesson::withCount(['lessonReads as read_count'])
            ->orderBy('read_count', 'desc')
            ->take(5)
            ->get();

        // Get latest registered users
        $latestUsers = User::orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get articles statistics by month (last 6 months) - total views
        $articleStats = Artikel::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('YEAR(created_at) as year'),
            DB::raw('SUM(view_count) as total_views') // Sum of views instead of count
        )
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->take(6)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalArtikel',
            'totalLessons',
            'publishedArtikel',
            'unpublishedArtikel',
            'popularArticles',
            'mostLikedArticles',
            'mostReadLessons',
            'latestUsers',
            'articleStats'
        ));
    }
}