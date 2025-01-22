@extends('layouts.app')

@section('title', 'Kategori Lesson - Admin Panel')

@section('page_title', 'Kategori Lesson Management')

@section('content')
<div class="container mx-auto px-2 sm:px-4 lg:px-8 mb-8">
    @if(session('success'))
    <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-r-lg animate-fade-in-down" role="alert">
        <p class="font-bold">Success</p>
        <p>{{ session('success') }}</p>
    </div>
    @endif

    @if(session('error'))
    <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-r-lg animate-fade-in-down" role="alert">
        <p class="font-bold">Error</p>
        <p>{{ session('error') }}</p>
    </div>
    @endif

    <!-- Header Card -->
    <div class="bg-white rounded-lg shadow-lg mb-6 transition-all duration-300 hover:shadow-xl">
        <div class="p-4 sm:p-6 flex flex-col sm:flex-row justify-between items-center gap-4">
            <h5 class="text-xl font-semibold flex items-center text-gray-800">
                <i class="fas fa-folder text-rose-500 mr-3 text-2xl"></i>
                Kategori Lesson List
            </h5>
            <button onclick="openModal()" 
                    class="w-full sm:w-auto bg-green-500 hover:bg-green-600 text-white px-4 sm:px-6 py-2 rounded-lg flex items-center justify-center transition-all duration-300 transform hover:scale-105">
                <i class="fas fa-plus mr-2"></i> Add Kategori
            </button>
        </div>
    </div>

    <!-- Kategori Table - Desktop View -->
    <div class="hidden sm:block bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Lessons</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($kategories as $kategori)
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $kategori->nama }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-rose-100 text-rose-800">
                                {{ $kategori->lessons_count }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button onclick="openEditModal('{{ $kategori->id }}', '{{ str_replace("'", "\\'", $kategori->nama) }}')"
                                    class="text-blue-500 hover:text-blue-700 transition duration-200 mr-2">
                                <i class="fas fa-edit text-lg"></i>
                            </button>
                            <button onclick="confirmDelete('{{ $kategori->id }}')"
                                    class="text-red-500 hover:text-red-700 transition duration-200">
                                <i class="fas fa-trash text-lg"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-center text-gray-500">No categories found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Kategori Cards - Mobile View -->
    <div class="sm:hidden space-y-4">
        @forelse($kategories as $kategori)
        <div class="bg-white rounded-lg shadow p-4 space-y-3">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900">
                        {{ $kategori->nama }}
                    </p>
                    <p class="text-sm text-gray-500">
                        {{ $kategori->lessons_count }} Lessons
                    </p>
                </div>
                <div class="flex space-x-3">
                    <button onclick="openEditModal('{{ $kategori->id }}', '{{ str_replace("'", "\\'", $kategori->nama) }}')"
                            class="text-rose-500 hover:text-rose-700">
                        <i class="fas fa-edit text-lg"></i>
                    </button>
                    <button onclick="confirmDelete('{{ $kategori->id }}')"
                            class="text-red-500 hover:text-red-700">
                        <i class="fas fa-trash text-lg"></i>
                    </button>
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-lg shadow p-4 text-center text-gray-500">
            No categories found
        </div>
        @endforelse
    </div>

    <!-- Hidden Delete Forms -->
    @foreach($kategories as $kategori)
    <form id="delete-form-{{ $kategori->id }}" action="{{ route('admin.kategori-lesson.destroy', $kategori->id) }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>
    @endforeach

    <!-- Create Modal -->
    <div id="kategoriModal" class="fixed inset-0 bg-gray-900/50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="relative bg-white w-full max-w-md rounded-2xl shadow-2xl overflow-hidden">
                <!-- Header -->
                <div class="px-6 py-4 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                            <i class="fas fa-folder text-rose-500"></i>
                            <span>Add New Kategori</span>
                        </h3>
                        <button onclick="closeModal()" class="text-gray-400 hover:text-gray-500 transition-colors">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                </div>
    
                <!-- Body -->
                <form id="kategoriForm" action="{{ route('admin.kategori-lesson.store') }}" method="POST">
                    @csrf
                    <div class="p-6">
                        <div class="mb-5">
                            <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori</label>
                            <input type="text" 
                                   name="nama" 
                                   id="nama" 
                                   required
                                   class="block w-full px-4 py-2.5 text-gray-700 bg-white border border-gray-300 rounded-lg focus:border-rose-500 focus:ring-rose-500 focus:ring-1 text-sm placeholder-gray-400 transition-colors"
                                   placeholder="Masukkan nama kategori">
                        </div>
                    </div>
    
                    <!-- Footer -->
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                        <div class="flex flex-row-reverse gap-2">
                            <button type="submit" 
                                    class="inline-flex items-center justify-center px-4 py-2.5 bg-rose-600 text-white text-sm font-medium rounded-lg hover:bg-rose-700 focus:ring-2 focus:ring-rose-500 focus:ring-offset-2 transition-colors">
                                <i class="fas fa-save mr-2"></i>
                                Simpan
                            </button>
                            <button type="button" 
                                    onclick="closeModal()" 
                                    class="inline-flex items-center justify-center px-4 py-2.5 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:ring-2 focus:ring-gray-200 focus:ring-offset-2 transition-colors">
                                Batal
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 bg-gray-900/50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="relative bg-white w-full max-w-md rounded-2xl shadow-2xl overflow-hidden">
                <!-- Header -->
                <div class="px-6 py-4 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                            <i class="fas fa-folder text-rose-500"></i>
                            <span>Edit Kategori</span>
                        </h3>
                        <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-500 transition-colors">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                </div>

                <!-- Body -->
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="p-6">
                        <div class="mb-5">
                            <label for="edit_nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori</label>
                            <input type="text" 
                                   name="nama" 
                                   id="edit_nama" 
                                   required
                                   class="block w-full px-4 py-2.5 text-gray-700 bg-white border border-gray-300 rounded-lg focus:border-rose-500 focus:ring-rose-500 focus:ring-1 text-sm placeholder-gray-400 transition-colors"
                                   placeholder="Masukkan nama kategori">
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                        <div class="flex flex-row-reverse gap-2">
                            <button type="submit" 
                                    class="inline-flex items-center justify-center px-4 py-2.5 bg-rose-600 text-white text-sm font-medium rounded-lg hover:bg-rose-700 focus:ring-2 focus:ring-rose-500 focus:ring-offset-2 transition-colors">
                                <i class="fas fa-save mr-2"></i>
                                Update
                            </button>
                            <button type="button" 
                                    onclick="closeEditModal()" 
                                    class="inline-flex items-center justify-center px-4 py-2.5 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:ring-2 focus:ring-gray-200 focus:ring-offset-2 transition-colors">
                                Batal
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-900/50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="relative bg-white w-full max-w-md rounded-2xl shadow-2xl overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center gap-4">
                        <div class="flex-shrink-0 w-12 h-12 rounded-full bg-red-100 flex items-center justify-center">
                            <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Delete Category</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                Are you sure you want to delete this category? This action cannot be undone.
                            </p>
                        </div>
                    </div>
                    
                    <div class="mt-6 flex flex-row-reverse gap-2">
                        <button type="button" onclick="deleteKategori()"
                                class="inline-flex items-center justify-center px-4 py-2.5 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors">
                            <i class="fas fa-trash mr-2"></i>
                            Delete
                        </button>
                        <button type="button" onclick="closeDeleteModal()"
                                class="inline-flex items-center justify-center px-4 py-2.5 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:ring-2 focus:ring-gray-200 focus:ring-offset-2 transition-colors">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let currentDeleteId = null;
    function openModal() {
        document.getElementById('kategoriModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        resetForm();
    }

    function closeModal() {
        document.getElementById('kategoriModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    function openEditModal(id, nama) {
        document.getElementById('editModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        
        // Set form attributes
        document.getElementById('editForm').action = '/admin/kategori-lesson/' + id;
        document.getElementById('edit_nama').value = nama.replace(/&quot;/g, '"').replace(/&#039;/g, "'");
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    function confirmDelete(id) {
        currentDeleteId = id;
        document.getElementById('deleteModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
        currentDeleteId = null;
    }

    function deleteKategori() {
        if (currentDeleteId) {
            document.getElementById(`delete-form-${currentDeleteId}`).submit();
        }
    }

    function resetForm() {
        document.getElementById('kategoriForm').reset();
    }

    // Close modals when clicking outside
    window.onclick = function(event) {
        const kategoriModal = document.getElementById('kategoriModal');
        const editModal = document.getElementById('editModal');
        const deleteModal = document.getElementById('deleteModal');
        
        if (event.target === kategoriModal) {
            closeModal();
        }
        if (event.target === editModal) {
            closeEditModal();
        }
        if (event.target === deleteModal) {
            closeDeleteModal();
        }
    }
</script>
@endpush

@endsection