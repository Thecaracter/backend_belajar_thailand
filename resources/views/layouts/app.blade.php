<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Admin Dashboard'))</title>
    
    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    @stack('styles')
</head>
<body class="bg-gray-50">
    <div x-data="{ sidebarOpen: true }" class="min-h-screen">
        <!-- Include Sidebar -->
        @include('layouts.partials.sidebar')

        <!-- Main Content -->
        <div :class="{'ml-64': sidebarOpen}" class="transition-margin duration-300">
            <!-- Include Header -->
            @include('layouts.partials.header')

            <!-- Main Content Area -->
            <main class="pt-16 min-h-screen">
                <div class="p-6">
                    @if(session('success'))
                        <div x-data="{ show: true }"
                             x-show="show"
                             x-transition
                             x-init="setTimeout(() => show = false, 3000)"
                             class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                             role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                            <button @click="show = false" class="absolute top-0 right-0 px-4 py-3">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div x-data="{ show: true }"
                             x-show="show"
                             x-transition
                             x-init="setTimeout(() => show = false, 3000)"
                             class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                             role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                            <button @click="show = false" class="absolute top-0 right-0 px-4 py-3">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>

            <!-- Include Footer -->
            @include('layouts.partials.footer')
        </div>
    </div>

    @stack('scripts')
</body>
</html>