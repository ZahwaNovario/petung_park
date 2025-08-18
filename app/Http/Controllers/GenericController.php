<?php

namespace App\Http\Controllers;

use App\Models\Generic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GenericController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $generics = Generic::all();
        return view('generic.index', compact('generics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('generic.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'key' => 'required|string|max:255',
                'value' => 'required|string',
                'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
            ]
            ,[
                'key.required' => 'Key harus diisi.',
                'value.required' => 'Value harus diisi.',
                'photo.image' => 'File yang diunggah harus berupa gambar.',
                'photo.mimes' => 'Format file yang diunggah harus jpg, jpeg, atau png.',
                'photo.max' => 'Ukuran file tidak boleh lebih dari 10 MB.',
            ]);

            $generic = new Generic;
            $generic->key = $request->input('key');
            $generic->value = $request->input('value');
            $generic->status = 1;
            $generic->user_id = Auth::user()->id;
            if ($request->hasFile('photo')) {
                $extension = $request->file('photo')->getClientOriginalExtension();
                
                $newFileName = str_replace(' ', '_', strtolower($generic->key)) . '_' . time() . '.' . $extension;
                
                $filePath = $request->file('photo')->storeAs('images/galeri/baru', $newFileName, 'public');
                
                $generic->icon_picture_link = 'storage/images/galeri/baru/' . $newFileName; // Save as relative URL   
            }
            $generic->created_at = now();
            $generic->updated_at = now();
            $generic->save();

            return redirect()->route('generic.index')->with('success', 'Data umum berhasil ditambahkan!');
        } catch (\Throwable $th) {
            return redirect()->route('generic.index')->with('error', 'Data umum gagal ditambahkan');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Generic $generic)
    {
        $users = User::where('status', 1)->get();
        return view('generic.edit', compact('generic', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Generic $generic)
    {
        try {
            $request->validate([
                'key' => 'required|string|max:255',
                'value' => 'required|string',
                'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
                'user_id' => 'required|exists:users,id',
            ]
            ,[
                'key.required' => 'Key harus diisi.',
                'value.required' => 'Value harus diisi.',
                'photo.image' => 'File yang diunggah harus berupa gambar.',
                'photo.mimes' => 'Format file yang diunggah harus jpg, jpeg, atau png.',
                'photo.max' => 'Ukuran file tidak boleh lebih dari 10 MB.',
                'user_id.required' => 'User harus dipilih.',
            ]);

            $generic->key = $request->input('key');
            $generic->value = $request->input('value');

            // Check if a new user is selected
            if ($request->has('user_id')) {
                $generic->user_id = $request->input('user_id');
            }

            // Check if a new photo is uploaded
            if ($request->hasFile('photo')) {
                // Delete the old photo if it exists
                if ($generic->icon_picture_link) {
                    $oldPhotoPath = str_replace('storage/', '', $generic->icon_picture_link);
                    Storage::disk('public')->delete($oldPhotoPath);
                }

                // Save the new photo
                $extension = $request->file('photo')->getClientOriginalExtension();
                $newFileName = str_replace(' ', '_', strtolower($generic->key)) . '_' . time() . '.' . $extension;
                $filePath = $request->file('photo')->storeAs('images/galeri/baru', $newFileName, 'public');
                $generic->icon_picture_link = 'storage/images/galeri/baru/' . $newFileName;
            }

            $generic->updated_at = now();
            $generic->save();

            return redirect()->route('generic.index')->with('success', 'Data umum berhasil diubah!');
        } catch (\Throwable $th) {
            return redirect()->route('generic.index')->with('error', 'Data umum gagal diubah');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function unactive(Generic $generic)
    {
        try {
            $generic->status = 0;
            $generic->updated_at = now();
            $generic->save();

            return redirect()->route('generic.index')->with('success', 'Data umum berhasil dinonaktifkan!');
        } catch (\Throwable $th) {
            return redirect()->route('generic.index')->with('error', 'Data umum gagal dinonaktifkan');
        }
    }
    public function aboutUs()
    {
        $aboutUs = [];
        $data = Generic::where('status',1)->get();
        $aboutUs = [
            'sejarah' => null,
            'visi_misi' => null,
            'gambar' => null,
        ];

        foreach ($data as $item) {
            switch ($item->key) {
                case 'sejarah':
                    $aboutUs['sejarah_nama'] = 'Sejarah';
                    $aboutUs['sejarah_text'] = $item->value; 
                    break;
                case 'sejarah_2':
                    $aboutUs['sejarah_2_text'] = $item->value;
                    break;
                case 'visi_misi':
                    $aboutUs['visi_misi_nama'] = 'Visi & Misi'; 
                    $aboutUs['visi_misi_text'] = $item->value; 
                    break;
                case 'visi_misi_2':
                    $aboutUs['visi_misi_2_text'] = $item->value;
                    break;
                case 'gambar_baris_1':
                    $aboutUs['gambar1'] = $item->icon_picture_link; 
                    break;
                case 'gambar_baris_2':
                    $aboutUs['gambar2'] = $item->icon_picture_link; 
                    break;
                case 'gambar_baris_3':
                    $aboutUs['gambar3'] = $item->icon_picture_link; 
                    break;    
            }
        }
        return view('tentangKami', compact('aboutUs'));
    }
}

