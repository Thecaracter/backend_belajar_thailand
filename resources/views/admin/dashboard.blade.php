@extends('layouts.app')

@section('title', 'Dashboard - Admin Panel')

@section('page_title', 'Dashboard')

@section('content')
<div class="container mx-auto px-4">
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">
        <!-- Total Users Card -->
        <div class="transform hover:-translate-y-1 transition-transform duration-300">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center mb-3">
                    <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-blue-100 text-blue-600 mr-3">
                        <i class="fas fa-users"></i>
                    </div>
                    <h6 class="text-sm font-semibold">Total Users</h6>
                </div>
                <h2 class="text-2xl font-bold mb-2">{{ number_format($totalUsers) }}</h2>
                <p class="text-gray-500 text-sm">
                    <i class="fas fa-chart-line mr-1"></i>
                    Active users in system
                </p>
            </div>
        </div>

        <!-- Total Articles Card -->
        <div class="transform hover:-translate-y-1 transition-transform duration-300">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center mb-3">
                    <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-green-100 text-green-600 mr-3">
                        <i class="fas fa-newspaper"></i>
                    </div>
                    <h6 class="text-sm font-semibold">Total Articles</h6>
                </div>
                <h2 class="text-2xl font-bold mb-2">{{ number_format($totalArtikel) }}</h2>
                <p class="text-sm">
                    <span class="text-green-500">
                        <i class="fas fa-check-circle mr-1"></i>
                        {{ number_format($publishedArtikel) }} Published
                    </span>
                    <span class="mx-2">|</span>
                    <span class="text-yellow-500">
                        <i class="fas fa-clock mr-1"></i>
                        {{ number_format($unpublishedArtikel) }} Pending
                    </span>
                </p>
            </div>
        </div>

        <!-- Total Lessons Card -->
        <div class="transform hover:-translate-y-1 transition-transform duration-300">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center mb-3">
                    <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-sky-100 text-sky-600 mr-3">
                        <i class="fas fa-book"></i>
                    </div>
                    <h6 class="text-sm font-semibold">Total Lessons</h6>
                </div>
                <h2 class="text-2xl font-bold mb-2">{{ number_format($totalLessons) }}</h2>
                <p class="text-gray-500 text-sm">
                    <i class="fas fa-graduation-cap mr-1"></i>
                    Available lessons
                </p>
            </div>
        </div>
    </div>

    <!-- Article View Statistics Chart -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <h5 class="font-semibold flex items-center mb-4">
            <i class="fas fa-chart-line text-blue-500 mr-2"></i>
            Article View Statistics (Last 6 Months)
        </h5>
        <canvas id="articleStatsChart"></canvas>
    </div>

    <!-- Popular Content Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-6">
        <!-- Popular Articles -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="px-6 py-4 border-b">
                <h5 class="font-semibold flex items-center">
                    <i class="fas fa-star text-yellow-400 mr-2"></i>
                    Popular Articles
                </h5>
            </div>
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="border-b">
                                <th class="text-left py-2">Title</th>
                                <th class="text-left py-2">Author</th>
                                <th class="text-left py-2">Views</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($popularArticles as $article)
                            <tr class="hover:bg-gray-50">
                                <td class="py-2">{{ Str::limit($article->judul, 30) }}</td>
                                <td class="py-2">{{ $article->user->name }}</td>
                                <td class="py-2">{{ number_format($article->view_count) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center py-4">No articles found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Most Liked Articles -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="px-6 py-4 border-b">
                <h5 class="font-semibold flex items-center">
                    <i class="fas fa-heart text-red-500 mr-2"></i>
                    Most Liked Articles
                </h5>
            </div>
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="border-b">
                                <th class="text-left py-2">Title</th>
                                <th class="text-left py-2">Author</th>
                                <th class="text-left py-2">Likes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mostLikedArticles as $article)
                            <tr class="hover:bg-gray-50">
                                <td class="py-2">{{ Str::limit($article->judul, 30) }}</td>
                                <td class="py-2">{{ $article->user->name }}</td>
                                <td class="py-2">{{ number_format($article->likes_count) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center py-4">No articles found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Latest Activity Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <!-- Most Read Lessons -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="px-6 py-4 border-b">
                <h5 class="font-semibold flex items-center">
                    <i class="fas fa-book-reader text-sky-500 mr-2"></i>
                    Most Read Lessons
                </h5>
            </div>
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="border-b">
                                <th class="text-left py-2">Title</th>
                                <th class="text-left py-2">Readers</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mostReadLessons as $lesson)
                            <tr class="hover:bg-gray-50">
                                <td class="py-2">{{ Str::limit($lesson->judul, 40) }}</td>
                                <td class="py-2">{{ number_format($lesson->read_count) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="text-center py-4">No lessons found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Latest Registered Users -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="px-6 py-4 border-b">
                <h5 class="font-semibold flex items-center">
                    <i class="fas fa-user-plus text-green-500 mr-2"></i>
                    Latest Registered Users
                </h5>
            </div>
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="border-b">
                                <th class="text-left py-2">Name</th>
                                <th class="text-left py-2">Email</th>
                                <th class="text-left py-2">Joined</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latestUsers as $user)
                            <tr class="hover:bg-gray-50">
                                <td class="py-2">{{ $user->name }}</td>
                                <td class="py-2">{{ $user->email }}</td>
                                <td class="py-2">{{ $user->created_at->diffForHumans() }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center py-4">No users found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Prepare data for the chart
    const months = {!! json_encode($articleStats->pluck('month')) !!};
    const years = {!! json_encode($articleStats->pluck('year')) !!};
    const totalViews = {!! json_encode($articleStats->pluck('total_views')) !!}; // Use total_views

    const ctx = document.getElementById('articleStatsChart').getContext('2d');
    const articleStatsChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: months.map((month, index) => `${month}-${years[index]}`), // Combine month and year
            datasets: [{
                label: 'Total Views',
                data: totalViews,
                backgroundColor: 'rgba(54, 162, 235, 0.5)', // Blue color
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Number of Views'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Month-Year'
                    }
                }
            }
        }
    });
</script>
@endpush

@endsection