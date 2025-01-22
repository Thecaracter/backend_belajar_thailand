<!-- Sidebar -->
<aside 
    class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform"
    :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}"
>
    <div class="h-full bg-gradient-to-b from-rose-800 to-rose-900">
        <!-- Logo -->
        <div class="flex items-center h-16 px-6 bg-rose-950">
            <div class="flex items-center justify-center w-10 h-10 bg-white bg-opacity-10 rounded-lg">
                <i class="fas fa-book text-white text-xl"></i>
            </div>
            <span class="ml-3 text-lg font-semibold text-white">{{ config('app.name') }}</span>
        </div>

        <!-- Navigation -->
        <nav class="px-4 py-4">
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex items-center px-4 py-3 text-rose-100 rounded-lg hover:bg-rose-700/30 transition-all {{ Request::is('admin/dashboard') ? 'bg-rose-700/40 text-white' : '' }}">
                        <i class="w-5 fas fa-home"></i>
                        <span class="ml-3">Dashboard</span>
                    </a>
                </li>
                {{-- <li>
                    <a href="{{ route('admin.users.index') }}"
                       class="flex items-center px-4 py-3 text-rose-100 rounded-lg hover:bg-rose-700/30 transition-all {{ Request::is('admin/users*') ? 'bg-rose-700/40 text-white' : '' }}">
                        <i class="w-5 fas fa-users"></i>
                        <span class="ml-3">Users</span>
                    </a>
                </li> --}}
                <li>
                    <a href="{{ route('admin.artikel.index') }}"
                       class="flex items-center px-4 py-3 text-rose-100 rounded-lg hover:bg-rose-700/30 transition-all {{ Request::is('admin/articles*') ? 'bg-rose-700/40 text-white' : '' }}">
                        <i class="w-5 fas fa-newspaper"></i>
                        <span class="ml-3">Articles</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.kategori-lesson.index') }}"
                       class="flex items-center px-4 py-3 text-rose-100 rounded-lg hover:bg-rose-700/30 transition-all {{ Request::is('admin/kategori-lesson*') ? 'bg-rose-700/40 text-white' : '' }}">
                        <i class="w-5 fas fa-folder"></i>
                        <span class="ml-3">Kategori Lesson</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.lesson.index') }}"
                       class="flex items-center px-4 py-3 text-rose-100 rounded-lg hover:bg-rose-700/30 transition-all {{ Request::is('admin/lesson*') ? 'bg-rose-700/40 text-white' : '' }}">
                        <i class="w-5 fas fa-book"></i>
                        <span class="ml-3">Lessons</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>