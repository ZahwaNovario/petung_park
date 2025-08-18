<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $galleries = Gallery::all();
        return view('galeri.index', compact('galleries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('galeri.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'photo' => 'required|image|mimes:jpg,jpeg,png|max:10240', // Validate the file upload
                'description' => 'nullable|string',
            ], [
                'name.required' => 'Nama harus diisi.',
                'photo.required' => 'Foto harus diunggah.',
                'photo.image' => 'File yang diunggah harus berupa gambar.',
                'photo.mimes' => 'Format file yang diunggah harus jpg, jpeg, atau png.',
                'photo.max' => 'Ukuran file tidak boleh lebih dari 10 MB.',
                'description.max' => 'Deskripsi tidak boleh lebih dari 255 karakter.',
            ]);
        
            $gallery = new Gallery;
            $gallery->name = $request->input('name');
            $gallery->description = $request->input('description');
            $gallery->status = 1;
            $gallery->number_love = 0;
            $extension = $request->file('photo')->getClientOriginalExtension();
            
            $newFileName = str_replace(' ', '_', strtolower($gallery->name)) . '_' . time() . '.' . $extension;
            
            $filePath = $request->file('photo')->storeAs('images/galeri/baru', $newFileName, 'public');
            
            $gallery->photo_link = 'storage/images/galeri/baru/' . $newFileName; // Save as relative URL   
            $gallery->save();
        
            return redirect()->route('galeri.index')->with('success', 'Galeri berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->route('galeri.index')->with('error', 'Terjadi kesalahan saat menambahkan galeri: ' . $e->getMessage());
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(Gallery $gallery)
    {
        return view('galeri.show', compact('gallery'));
    }
    public function showGalleriAllPengguna()
    {
        $galleries = Gallery::where('status', 1)->get();
        return view('galeri.show', compact('galleries'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gallery $gallery)
    {
        return view('galeri.edit', compact('gallery'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gallery $gallery)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'status' => 'required|in:0,1',
                'description' => 'nullable|string',
                'file' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
            ], [
                'name.required' => 'Nama harus diisi.',
                'status.required' => 'Status harus dipilih.',
                'description.max' => 'Deskripsi tidak boleh lebih dari 255 karakter.',
                'file.image' => 'File yang diunggah harus berupa gambar.',
                'file.mimes' => 'Format file yang diunggah harus jpg, jpeg, atau png.',
                'file.max' => 'Ukuran file tidak boleh lebih dari 10 MB.',
            ]);

            $gallery->name = $request->input('name');
            $gallery->status = $request->input('status');

            if ($request->hasFile('file')) {
                $oldPhotoPath = str_replace('storage/', '', $gallery->photo_link);
                Storage::disk('public')->delete($oldPhotoPath);
                $extension = $request->file('file')->getClientOriginalExtension();
                $newFileName = str_replace(' ', '_', strtolower($gallery->name)) . '_' . time() . '.' . $extension;
                $filePath = $request->file('file')->storeAs('images/galeri/baru', $newFileName, 'public');
                $gallery->photo_link = 'storage/images/galeri/baru/' . $newFileName;
            }

            $gallery->description = $request->input('description');
            $gallery->updated_at = now();
            $gallery->save();

            return redirect()->route('galeri.index')->with('success', 'Galeri berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->route('galeri.index')->with('error', 'Terjadi kesalahan saat memperbarui galeri: ' . $e->getMessage());
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function unactive(Gallery $gallery)
    {
        try {
            DB::transaction(function () use ($gallery) {
                $gallery->status = 0;
                $gallery->updated_at = now();
                $gallery->save();
                });
                $message = 'Galeri berhasil dinonaktifkan.';
                return redirect()->route('galeri.index')->with('success', $message);
         } catch (\Exception $e) {
                return redirect()->route('galeri.index')->with('error', 'Terjadi kesalahan saat menonaktifkan galeri: ' . $e->getMessage());
         }
    }

    /**
     * Like or unlike a gallery.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function like(Request $request, $galleryId)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $gallery = Gallery::findOrFail($galleryId);

        $sessionKey = 'liked_gallery_' . $galleryId;

        if (session()->has($sessionKey)) {
            if ($gallery->number_love > 0) {
                $gallery->number_love--;
            }

            session()->forget($sessionKey);
            $action = 'unliked'; 
        } else {
            $gallery->number_love++;

            session()->put($sessionKey, true);
            $action = 'liked'; 
        }

        $gallery->save();

        return response()->json([
            'number_love' => $gallery->number_love,
            'action' => $action,
        ]);
    }

}

