<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\GalleryShow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\SliderHome;
use App\Models\Generic;
use App\Models\Gallery;

class GalleryShowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showAllPengguna()
    {
        $galleryShows = GalleryShow::where('status', 1)->get();
        $sliderHomes = SliderHome::where('status', 1)->get();
        
        $info = [];
        $data = Generic::where('status',1)->get();
        $info = [
            'sejarah' => null,
            'visi_misi' => null,
            'gambar' => null,
        ];

        foreach ($data as $item) {
            switch ($item->key) {
                case 'video_promosi':
                    $info['video_promosi'] = $item->value;
                    break;
                case 'sejarah_beranda':
                    $info['sejarah'] = $item->value;
                    break;
                case 'lokasi':
                    $info['alamat'] = $item->value; 
                    $info['peta_lokasi'] = $item->icon_picture_link; 
                    break;
                case 'jam_operasional':
                    $info['jam'] = $item->value;
                    $info['jam_logo'] = $item->icon_picture_link;
                    break;  
                case 'kontak_whatsapp':
                    $info['telepon'] = preg_replace('/(\d{4})(?=\d)/', '$1-', $item->value);
                    $info['telepon_logo'] = $item->icon_picture_link;
                    break;   
            }
        }
        return view('beranda', compact('galleryShows','sliderHomes','info'));
    }
    
    public function index()
    {
        $shows = GalleryShow::all();
        return view('galeri.show.index', compact('shows'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $galleries= Gallery::where('status', 1)->get();
        return view('galeri.show.create', compact('galleries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'photos' => 'required|array',
                'photos.*' => 'integer|exists:galleries,id',
            ]);

            foreach ($request->input('photos') as $gallery_id) {
                GalleryShow::create([
                    'name' => $request->input('name'),
                    'status' => 1,
                    'gallery_id' => $gallery_id,
                ]);
            }
            return redirect()->route('galeri.show.index')->with('success', 'Tampilan Galeri berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data!']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(GalleryShow $galleryShow)
    {
        return view('galeri.show', compact('galleryShow'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($gallery)
    {
        $show = GalleryShow::find($gallery);

        if (!$show || Gallery::where('status', 1)->where('id', $show->gallery_id)->doesntExist()) {
            $galleries = Gallery::where('status', 1)->get();
        } else {
            $galleries = Gallery::where('status', 1)->whereNotIn('id', [$show->gallery_id])->get();
        }

        return view('galeri.show.edit', compact('show', 'galleries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'status' => 'required|integer',
                'photo' => 'nullable|integer|exists:galleries,id', // Accepts only ONE photo
            ]);

            // Update the GalleryShow attributes
            $galleryShow= GalleryShow::findorFail($id);
            $galleryShow->name = $request->input('name');
            $galleryShow->status = $request->input('status');

            // Replace the old gallery_id with the new one (if provided)
            if ($request->has('photo')) {
                $galleryShow->gallery_id = $request->input('photo'); // Replace old ID
            }

            $galleryShow->updated_at = now();
            $galleryShow->saveQuietly();

            return redirect()->route('galeri.show.index')->with('success', 'Tampilan Galeri berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data!']);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function unactive($gallery)
    {
        try {
            $galleryShow= GalleryShow::findorFail($gallery);
            $galleryShow->status=0;
            $galleryShow->updated_at = now();
            $galleryShow->save();
            return redirect()->route('galeri.show.index')->with('success', 'Tampilan Galeri berhasil dinonaktifkan!');
        } catch (\Exception $e) {
            return redirect()->route('galeri.show.index')->with('error', 'Terjadi kesalahan saat dinonaktifkan data!');
        }
    }
}

