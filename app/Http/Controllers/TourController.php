<?php

namespace App\Http\Controllers;
use App\Models\Location;
use App\Models\Scene;
use App\Models\Connection;

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
    public function showScene($id = null)
    {
        $firstLocation = Location::with('scenes')->first();
        // Default ke scene id 1
        $sceneId = $id ?? $firstLocation->scenes->first()->id;
        // Ambil scene berdasarkan ID
        $scene = Scene::with(['location', 'location.scenes.connections'])->find($sceneId);

        if (!$scene) {
            abort(404, 'Scene not found');
        }

        // Ambil koneksi yang berawal dari scene ini
        $connection = connection::where('scene_from', $sceneId)->get();

        return view('virtualtourhome.scene', compact('scene', 'connection'));
    }

    public function preview()
    {
        $scenes = Scene::all(); // atau with('location') kalau perlu lokasi juga
        return view('preview', compact('scenes'));
    }
}
