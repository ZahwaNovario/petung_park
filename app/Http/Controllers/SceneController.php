<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Scene;
use App\Models\Connection;

class SceneController extends Controller
{
    public function index()
    {
        $scenes = Scene::with('location')->get();
        return view('admin.virtualtouradmin.scenes.index', compact('scenes'));
    }

    public function create()
    {
        $locations = Location::all();
        $scenes = Scene::all();
        return view('admin.virtualtouradmin.scenes.create', compact('locations', 'scenes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'location_id' => 'required|exists:locations,id',
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpg,jpeg,png',
        ]);

        $location = Location::findOrFail($request->location_id);
        $locationName = strtolower(str_replace(' ', '_', $location->name));
        $folder = 'images/' . $locationName;

        $fileName = strtolower(str_replace(' ', '_', $request->name)) . '.' .
            $request->file('image')->getClientOriginalExtension();

        $request->file('image')->move(public_path($folder), $fileName);

        $imagePath = $folder . '/' . $fileName;

        $scene = Scene::create([
            'location_id' => $request->location_id,
            'name' => $request->name,
            'image_path' => $imagePath,
        ]);

        // Simpan connections kalau ada
        if ($request->filled('connections')) {
            $connections = json_decode($request->connections, true);
            foreach ($connections as $conn) {
                if (!empty($conn['target'])) {
                    Connection::create([
                        'scene_from' => $scene->id,
                        'scene_to' => $conn['target'],
                        'yaw' => $conn['yaw'],
                        'pitch' => $conn['pitch'],
                    ]);
                }
            }
        }

        return redirect()->route('scenes.index')
            ->with('success', 'Scene & connections berhasil ditambahkan!');
    }

    public function edit(Scene $scene)
    {
        $locations = Location::all();
        $allScenes = Scene::all();
        $connections = Connection::where('scene_from', $scene->id)->get();

        // Ubah jadi plain array supaya aman buat @json
        $existingConnections = $connections->map(function ($c) {
            return [
                'yaw' => (float) $c->yaw,
                'pitch' => (float) $c->pitch,
                'target' => (string) $c->scene_to,
            ];
        })->values()->toArray();

        return view('admin.virtualtouradmin.scenes.edit', compact(
            'scene',
            'locations',
            'allScenes',
            'existingConnections'
        ));
    }



    public function update(Request $request, Scene $scene)
    {
        $request->validate([
            'location_id' => 'required|exists:locations,id',
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        $data = [
            'location_id' => $request->location_id,
            'name' => $request->name,
        ];

        if ($request->hasFile('image')) {
            $location = Location::findOrFail($request->location_id);
            $locationName = strtolower(str_replace(' ', '_', $location->name));
            $folder = 'images/' . $locationName;

            $fileName = strtolower(str_replace(' ', '_', $request->name)) . '.' .
                $request->file('image')->getClientOriginalExtension();

            $request->file('image')->move(public_path($folder), $fileName);
            $data['image_path'] = $folder . '/' . $fileName;
        }

        $scene->update($data);

        // Update connections
        Connection::where('scene_from', $scene->id)->delete();
        if ($request->filled('connections')) {
            $connections = json_decode($request->connections, true);
            foreach ($connections as $conn) {
                if (!empty($conn['target'])) {
                    Connection::create([
                        'scene_from' => $scene->id,
                        'scene_to' => $conn['target'],
                        'yaw' => $conn['yaw'],
                        'pitch' => $conn['pitch'],
                    ]);
                }
            }
        }

        return redirect()->route('scenes.index')->with('success', 'Scene berhasil diupdate!');
    }

    public function destroy(Scene $scene)
    {
        // Hapus semua koneksi yang terkait
        Connection::where('scene_from', $scene->id)->orWhere('scene_to', $scene->id)->delete();

        $scene->delete();

        return redirect()->route('scenes.index')->with('success', 'Scene berhasil dihapus!');
    }
}
