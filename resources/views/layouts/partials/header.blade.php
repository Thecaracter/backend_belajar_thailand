<!-- Header -->
<header class="fixed top-0 right-0 left-0 z-30 bg-white/80 backdrop-blur-sm shadow-sm" :class="{'ml-64': sidebarOpen}">
    <div class="flex items-center justify-between h-16 px-6">
        <!-- Sidebar Toggle -->
        <button @click="sidebarOpen = !sidebarOpen" class="text-rose-800 hover:text-rose-900 transition-colors">
            <i class="fas fa-bars text-xl"></i>
        </button>
        
        <!-- User Profile Dropdown -->
        <div class="flex items-center">
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="flex items-center space-x-3 group">
                    <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=be123c&color=fff" 
                         alt="Profile" 
                         class="w-9 h-9 rounded-full ring-2 ring-rose-100">
                    <span class="text-rose-900">{{ auth()->user()->name }}</span>
                    <i class="fas fa-chevron-down text-sm text-rose-600 group-hover:text-rose-800 transition-colors"></i>
                </button>
                
                <!-- Dropdown Menu -->
                <div x-show="open" 
                     @click.away="open = false"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-1.5">
                    <form action="{{ route('admin.logout') }}" method="POST" class="block">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-rose-800 hover:bg-rose-50 transition-colors flex items-center space-x-2">
                            <i class="fas fa-sign-out-alt w-5"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>