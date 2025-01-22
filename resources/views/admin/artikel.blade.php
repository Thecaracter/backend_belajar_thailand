@extends('layouts.app')

@section('title', 'Articles - Admin Panel')

@section('page_title', 'Articles Management')

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
                <i class="fas fa-newspaper text-blue-500 mr-3 text-2xl"></i>
                Articles List
            </h5>
            <button onclick="openModal()" 
                    class="w-full sm:w-auto bg-green-500 hover:bg-green-600 text-white px-4 sm:px-6 py-2 rounded-lg flex items-center justify-center transition-all duration-300 transform hover:scale-105">
                <i class="fas fa-plus mr-2"></i> Add Article
            </button>
        </div>
    </div>

    <!-- Articles Table - Desktop View -->
    <div class="hidden sm:block bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Summary</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Views</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($articles as $article)
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-10 w-10 flex-shrink-0">
                                    <img class="h-10 w-10 rounded-full object-cover" 
                                         src="{{ $article->foto ?? 'https://via.placeholder.com/150' }}" 
                                         alt="{{ $article->judul }}">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ Str::limit($article->judul, 30) }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $article->user->name }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ Str::limit($article->ringkasan, 50) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ number_format($article->view_count) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button onclick="editArticle('{{ $article->id }}', '{{ addslashes($article->judul) }}', '{{ addslashes($article->ringkasan) }}', '{{ addslashes($article->konten) }}', '{{ $article->foto }}')"
                                    class="text-blue-500 hover:text-blue-700 mr-3">
                                <i class="fas fa-edit text-lg"></i>
                            </button>
                            <button onclick="confirmDelete('{{ $article->id }}')"
                                    class="text-red-500 hover:text-red-700">
                                <i class="fas fa-trash text-lg"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">No articles found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Articles Cards - Mobile View -->
    <div class="sm:hidden space-y-4">
        @forelse($articles as $article)
        <div class="bg-white rounded-lg shadow p-4 space-y-3">
            <div class="flex items-center space-x-3">
                <img class="h-12 w-12 rounded-full object-cover" 
                     src="{{ $article->foto ?? 'https://via.placeholder.com/150' }}" 
                     alt="{{ $article->judul }}">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate">
                        {{ $article->judul }}
                    </p>
                    <p class="text-sm text-gray-500 truncate">
                        By {{ $article->user->name }}
                    </p>
                </div>
                <div class="inline-flex items-center">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                        {{ number_format($article->view_count) }}
                    </span>
                </div>
            </div>
            <p class="text-sm text-gray-500">
                {{ Str::limit($article->ringkasan, 100) }}
            </p>
            <div class="flex justify-end space-x-3">
                <button onclick="editArticle('{{ $article->id }}', '{{ addslashes($article->judul) }}', '{{ addslashes($article->ringkasan) }}', '{{ addslashes($article->konten) }}', '{{ $article->foto }}')"
                        class="text-blue-500 hover:text-blue-700">
                    <i class="fas fa-edit text-lg"></i>
                </button>
                <button onclick="confirmDelete('{{ $article->id }}')"
                        class="text-red-500 hover:text-red-700">
                    <i class="fas fa-trash text-lg"></i>
                </button>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-lg shadow p-4 text-center text-gray-500">
            No articles found
        </div>
        @endforelse
    </div>

    <!-- Hidden Delete Forms -->
    @foreach($articles as $article)
    <form id="delete-form-{{ $article->id }}" action="{{ route('admin.artikel.destroy', $article->id) }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>
    @endforeach

    <!-- Modal -->
    <div id="articleModal" class="fixed inset-0 bg-gray-900/50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="relative bg-white w-full max-w-4xl rounded-2xl shadow-2xl overflow-hidden">
                <!-- Header -->
                <div class="px-6 py-4 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2" id="modalTitle">
                            <i class="fas fa-newspaper text-rose-500"></i>
                            <span id="modalTitleText">Add New Article</span>
                        </h3>
                        <button onclick="closeModal()" class="text-gray-400 hover:text-gray-500 transition-colors">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                </div>
    
                <!-- Body -->
                <form id="articleForm" action="{{ route('admin.artikel.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" id="method" value="POST">
                    
                    <div class="p-6 space-y-5">
                        <!-- Title -->
                        <div>
                            <label for="judul" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                            <input type="text" 
                                   name="judul" 
                                   id="judul" 
                                   required
                                   class="block w-full px-4 py-2.5 text-gray-700 bg-white border border-gray-300 rounded-lg focus:border-rose-500 focus:ring-rose-500 focus:ring-1 text-sm placeholder-gray-400 transition-colors"
                                   placeholder="Enter article title">
                        </div>
    
                        <!-- Summary -->
                        <div>
                            <label for="ringkasan" class="block text-sm font-medium text-gray-700 mb-1">Summary</label>
                            <textarea name="ringkasan" 
                                      id="ringkasan" 
                                      rows="2" 
                                      required
                                      class="block w-full px-4 py-2.5 text-gray-700 bg-white border border-gray-300 rounded-lg focus:border-rose-500 focus:ring-rose-500 focus:ring-1 text-sm placeholder-gray-400 transition-colors resize-none"
                                      placeholder="Enter article summary"></textarea>
                        </div>
    
                        <!-- Content -->
                        <div>
                            <label for="konten" class="block text-sm font-medium text-gray-700 mb-1">Content</label>
                            <textarea name="konten" 
                                      id="konten" 
                                      rows="6" 
                                      required
                                      class="block w-full px-4 py-2.5 text-gray-700 bg-white border border-gray-300 rounded-lg focus:border-rose-500 focus:ring-rose-500 focus:ring-1 text-sm placeholder-gray-400 transition-colors"
                                      placeholder="Enter article content"></textarea>
                        </div>
    
                        <!-- Image Upload -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Image</label>
                            <div class="mt-1 flex justify-center px-6 py-8 border-2 border-gray-200 border-dashed rounded-lg hover:border-rose-400 transition-colors">
                                <div class="space-y-2 text-center">
                                    <div id="preview" class="mb-4">
                                        <i class="fas fa-cloud-upload-alt text-gray-400 text-4xl"></i>
                                    </div>
                                    <div class="flex flex-col items-center text-sm text-gray-600">
                                        <label for="foto" class="relative cursor-pointer rounded-md font-medium text-rose-600 hover:text-rose-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-rose-500">
                                            <span>Upload a file</span>
                                            <input type="file" id="foto" name="foto" accept="image/*" onchange="handleImage(event)" class="sr-only">
                                        </label>
                                        <p class="text-gray-500 mt-1">or drag and drop</p>
                                        <p class="text-xs text-gray-400 mt-2">PNG, JPG, GIF up to 10MB</p>
                                    </div>
                                    <input type="hidden" name="foto_base64" id="foto_base64">
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <!-- Footer -->
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                        <div class="flex flex-row-reverse gap-2">
                            <button type="submit" 
                                    class="inline-flex items-center justify-center px-4 py-2.5 bg-rose-600 text-white text-sm font-medium rounded-lg hover:bg-rose-700 focus:ring-2 focus:ring-rose-500 focus:ring-offset-2 transition-colors">
                                <i class="fas fa-save mr-2"></i>
                                Save Article
                            </button>
                            <button type="button" 
                                    onclick="closeModal()" 
                                    class="inline-flex items-center justify-center px-4 py-2.5 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:ring-2 focus:ring-gray-200 focus:ring-offset-2 transition-colors">
                                Cancel
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative min-h-screen md:flex md:items-center md:justify-center p-4">
            <div class="bg-white rounded-lg px-4 pt-5 pb-4 overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full sm:p-6">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <i class="fas fa-exclamation-triangle text-red-600"></i>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Delete Article</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Are you sure you want to delete this article? This action cannot be undone.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse gap-3 sm:gap-2">
                    <button type="button" onclick="deleteArticle()"
                            class="w-full sm:w-auto px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Delete
                    </button>
                    <button type="button" onclick="closeDeleteModal()"
                            class="w-full sm:w-auto px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let currentDeleteId = null;

    function handleImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('foto_base64').value = e.target.result;
                document.getElementById('preview').innerHTML = `
                    <img src="${e.target.result}" class="mx-auto h-32 w-32 object-cover rounded-lg">
                `;
            }
            reader.readAsDataURL(file);
        }
    }

    function openModal() {
        document.getElementById('articleModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        resetForm();
    }

    function closeModal() {
        document.getElementById('articleModal').classList.add('hidden');
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

    function deleteArticle() {
        if (currentDeleteId) {
            document.getElementById(`delete-form-${currentDeleteId}`).submit();
        }
    }

    function resetForm() {
        document.getElementById('articleForm').reset();
        document.getElementById('modalTitleText').innerHTML = 'Add New Article';
        document.getElementById('method').value = 'POST';
        document.getElementById('articleForm').action = '{{ route("admin.artikel.store") }}';
        document.getElementById('preview').innerHTML = '<i class="fas fa-image text-gray-400 text-4xl"></i>';
        document.getElementById('foto_base64').value = '';
    }

    function editArticle(id, judul, ringkasan, konten, foto) {
        openModal();
        document.getElementById('modalTitleText').innerHTML = 'Edit Article';
        document.getElementById('method').value = 'PUT';
        document.getElementById('articleForm').action = '/admin/artikel/' + id;
        
        document.getElementById('judul').value = judul;
        document.getElementById('ringkasan').value = ringkasan;
        document.getElementById('konten').value = konten;
        
        if (foto) {
            document.getElementById('preview').innerHTML = `
                <img src="${foto}" class="mx-auto h-32 w-32 object-cover rounded-lg">
            `;
            document.getElementById('foto_base64').value = foto;
        }
    }

    // Close modals when clicking outside
    window.onclick = function(event) {
        const articleModal = document.getElementById('articleModal');
        const deleteModal = document.getElementById('deleteModal');
        
        if (event.target === articleModal) {
            closeModal();
        }
        if (event.target === deleteModal) {
            closeDeleteModal();
        }
    }
</script>
@endpush

@endsection