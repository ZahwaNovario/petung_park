<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Scene;

use Illuminate\Http\Request;

class TourController extends Controller
{
    // public function index()
    // {
    //     return view('virtual-tour');
    // }

    public function index()
    {
        $locations = Location::all();
        return view('virtualtourhome.home', compact('locations'));
    }

    // Halaman Detail Lokasi -> ambil scene pertama
    public function showLocation($slug)
    {
        $location = Location::where('slug', $slug)->firstOrFail();
        $firstScene = $location->scenes()->first(); // scene pertama di lokasi itu
        return redirect()->route('scene.show', $firstScene->id);
    }

    // Halaman Scene Viewer
    public function showScene($id)
    {
        $scene = Scene::with(['location', 'connections.sceneTo'])->find($id);

        if (!$scene) {
            // bikin scene dummy untuk placeholder
            $scene = new \stdClass();
            $scene->id = 0;
            $scene->name = "Coming Soon";
            $scene->image_path = null;
            $scene->location = (object) [
                'name' => "Virtual Tour",
                'slug' => "virtual-tour",
                'scenes' => collect([])
            ];
            $scene->connections = collect([]);
        }

        return view('virtualtourhome.scene', compact('scene'));
    }

    public function preview()
    {
        $scenes = Scene::all(); // atau with('location') kalau perlu lokasi juga
        return view('preview', compact('scenes'));
    }
}
