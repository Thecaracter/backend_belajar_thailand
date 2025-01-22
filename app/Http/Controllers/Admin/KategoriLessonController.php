<?php

namespace App\Http\Controllers\Admin;

use App\Models\KategoriLesson;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class KategoriLessonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $kategories = KategoriLesson::withCount('lessons')->latest()->get();

            return view('admin.kategori-lesson', compact('kategories'));
        } catch (\Exception $e) {
            Log::error('Error in KategoriLessonController@index: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->with('error', 'Terjadi kesalahan saat memuat data kategori lesson');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nama' => 'required|string|max:255|unique:kategori_lessons,nama'
            ]);

            DB::beginTransaction();

            $kategori = KategoriLesson::create($validated);

            DB::commit();

            Log::info('Kategori lesson berhasil dibuat', [
                'id' => $kategori->id,
                'nama' => $kategori->nama,
                'user_id' => auth()->id()
            ]);

            return redirect()
                ->route('admin.kategori-lesson.index')
                ->with('success', 'Kategori lesson berhasil ditambahkan');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in KategoriLessonController@store: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);

            return back()
                ->with('error', 'Terjadi kesalahan saat menambahkan kategori lesson')
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KategoriLesson $kategoriLesson)
    {
        try {
            $kategories = KategoriLesson::withCount('lessons')->latest()->get();
            return view('admin.kategori-lesson.index', compact('kategories', 'kategoriLesson'));
        } catch (\Exception $e) {
            Log::error('Error in KategoriLessonController@edit: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'kategori_id' => $kategoriLesson->id
            ]);

            return back()->with('error', 'Terjadi kesalahan saat memuat data kategori lesson');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $kategoriLesson = KategoriLesson::findOrFail($id);

            $validated = $request->validate([
                'nama' => 'required|string|max:255|unique:kategori_lessons,nama,' . $id
            ]);

            DB::beginTransaction();

            // Simpan data lama sebelum update
            $oldNama = $kategoriLesson->nama;

            // Update data
            $kategoriLesson->update($validated);

            DB::commit();

            // Log setelah berhasil update dengan data yang sudah disimpan
            Log::info('Kategori lesson berhasil diupdate', [
                'id' => $kategoriLesson->id,
                'old_nama' => $oldNama,
                'new_nama' => $kategoriLesson->nama,
                'user_id' => auth()->id()
            ]);

            return redirect()
                ->route('admin.kategori-lesson.index')
                ->with('success', 'Kategori lesson berhasil diperbarui');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Kategori lesson tidak ditemukan', [
                'id' => $id,
                'user_id' => auth()->id()
            ]);

            return back()->with('error', 'Kategori lesson tidak ditemukan');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in KategoriLessonController@update: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'kategori_id' => $id,
                'request' => $request->all()
            ]);

            return back()
                ->with('error', 'Terjadi kesalahan saat memperbarui kategori lesson')
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $kategoriLesson = KategoriLesson::findOrFail($id);

            DB::beginTransaction();

            // Check if kategori has related lessons
            if ($kategoriLesson->lessons()->exists()) {
                throw new \Exception('Tidak dapat menghapus kategori yang memiliki lesson');
            }

            // Simpan data yang diperlukan sebelum dihapus
            $kategoriId = $kategoriLesson->id;
            $kategoriNama = $kategoriLesson->nama;

            // Hapus data
            $kategoriLesson->delete();

            DB::commit();

            // Log setelah berhasil menghapus
            Log::info('Kategori lesson berhasil dihapus', [
                'id' => $kategoriId,
                'nama' => $kategoriNama,
                'user_id' => auth()->id()
            ]);

            return back()->with('success', 'Kategori lesson berhasil dihapus');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Kategori lesson tidak ditemukan', [
                'id' => $id,
                'user_id' => auth()->id()
            ]);

            return back()->with('error', 'Kategori lesson tidak ditemukan');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in KategoriLessonController@destroy: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'kategori_id' => $id
            ]);

            $message = $e->getMessage() === 'Tidak dapat menghapus kategori yang memiliki lesson'
                ? $e->getMessage()
                : 'Terjadi kesalahan saat menghapus kategori lesson';

            return back()->with('error', $message);
        }
    }
}