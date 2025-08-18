<?php

namespace App\Http\Controllers;

use App\Models\SliderHome;
use App\Models\Gallery;
use Illuminate\Http\Request;

class SliderHomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sliders = SliderHome::all();
        return view('galeri.slider.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $galleries= Gallery::where('status', 1)->get();
        return view('galeri.slider.create', compact('galleries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'required|integer|exists:galleries,id',
        ],
        [
            'name.required' => 'Nama harus diisi.',
            'photo.required' => 'Foto harus dipilih.',
        ]);
    
        try {
            $sliderHome = new SliderHome();
            $sliderHome->name = $request->input('name');
            $sliderHome->status = 1;
    
            if ($request->filled('photo')) {
                $sliderHome->gallery_id = $request->input('photo');
            }
    
            $sliderHome->save();
    
            return redirect()->route('galeri.slider.index')->with('success', 'Tampilan Slider Home berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->route('galeri.slider.create')->with('error', 'Gagal tambah tampilan Slider Home: ' . $e->getMessage());
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(SliderHome $sliderHome)
    {
        return view('galeri.slider.show', compact('sliderHome'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($gallery)
    {
        $slider = SliderHome::find($gallery);

        if (!$slider || Gallery::where('status', 1)->where('id', $slider->gallery_id)->doesntExist()) {
            $galleries = Gallery::where('status', 1)->get();
        } else {
            $galleries = Gallery::where('status', 1)->whereNotIn('id', [$slider->gallery_id])->get();
        }

        return view('galeri.slider.edit', compact('slider', 'galleries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
    $request->validate([
        'name' => 'required|string|max:255',
        'status' => 'required|integer',
        'photo' => 'nullable|integer|exists:galleries,id',
    ],
    [
        'name.required' => 'Nama harus diisi.',
        'status.required' => 'Status harus diisi.',
    ]);

    try {
        $sliderHome = SliderHome::findOrFail($id);
        $sliderHome->name = $request->input('name');
        $sliderHome->status = $request->input('status');

        if ($request->filled('photo')) {
            $sliderHome->gallery_id = $request->input('photo');
        }

        $sliderHome->save();

        return redirect()->route('galeri.slider.index')->with('success', 'Tampilan Slider Home berhasil diperbarui.');
    } catch (\Exception $e) {
        return redirect()->route('galeri.slider.edit', $id)->with('error', 'Gagal update tampilan Slider Home: ' . $e->getMessage());
    }
}

    

    /**
     * Remove the specified resource from storage.
     */
    public function unactive($gallery)
    {
        try {
            $sliderHome = SliderHome::findorFail($gallery);
            $sliderHome->status=0;
            $sliderHome->updated_at = now();
            $sliderHome->save();
            return redirect()->route('galeri.slider.index')->with('success', 'Tampilan Slider Home berhasil dinonaktifkan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal nonaktifkan tampilan Slider Home');
        }
    }
}

