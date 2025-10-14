<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Scene;
use App\Models\Connection;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Str;

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
            'image' => 'required|image|mimes:jpg,jpeg,png|max:30000', // max 30MB
        ]);

        // 🔹 Generate UUID unik untuk folder scene
        $uuid = Str::uuid()->toString();

        // 🔹 Buat path dasar folder
        $baseFolder = public_path("images/virtual-tour/{$uuid}");
        if (!file_exists($baseFolder)) {
            mkdir($baseFolder, 0777, true);
        }

        // 🔹 Buat folder resolusi
        $resolutions = [480, 720, 1080, 1440];
        foreach ($resolutions as $res) {
            $resFolder = "{$baseFolder}/{$res}";
            if (!file_exists($resFolder)) {
                mkdir($resFolder, 0777, true);
            }
        }

        // 🔹 Simpan nama file dasar
        $originalExt = $request->file('image')->getClientOriginalExtension();
        $fileBaseName = strtolower(str_replace(' ', '_', $request->name));

        // 🔹 Baca gambar utama
        $image = Image::make($request->file('image'));

        // 🔹 Simpan versi original tanpa resize
        $originalPath = "{$baseFolder}/original/{$fileBaseName}_original.{$originalExt}";
        if (!file_exists("{$baseFolder}/original")) {
            mkdir("{$baseFolder}/original", 0777, true);
        }
        $image->save($originalPath);

        // 🔹 Resize dan simpan tiap resolusi (480,720,1080,1440)
        foreach ($resolutions as $res) {
            $resized = clone $image;
            $resized->resize($res, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize(); // biar gak pecah
            });
            $resized->save("{$baseFolder}/{$res}/{$fileBaseName}_{$res}.{$originalExt}");
        }

        // 🔹 Path default (misal resolusi 720 untuk tampilan awal)
        $defaultImagePath = "images/virtual-tour/{$uuid}/720/{$fileBaseName}_720.{$originalExt}";

        // 🔹 Simpan scene ke database
        $scene = Scene::create([
            'uuid' => $uuid,
            'location_id' => $request->location_id,
            'name' => $request->name,
            'image_path' => $defaultImagePath,
        ]);

        // 🔹 Simpan connections (jika dikirim)
        if ($request->filled('connections')) {
            $connections = json_decode($request->connections, true);
            foreach ($connections as $conn) {
                if (!empty($conn['target'])) {
                    Connection::create([
                        'scene_from' => $scene->id,
                        'scene_to' => $conn['target'],
                        'yaw' => $conn['yaw'] ?? 0,
                        'pitch' => $conn['pitch'] ?? 0,
                    ]);
                }
            }
        }

        return redirect()->route('scenes.index')
            ->with('success', 'Scene berhasil ditambahkan dan dibuat dalam 5 resolusi (480–Original)!');
    }


    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'location_id' => 'required|exists:locations,id',
    //         'name' => 'required|string|max:255',
    //         'image' => 'required|image|mimes:jpg,jpeg,png',
    //     ]);

    //     $location = Location::findOrFail($request->location_id);
    //     $locationName = strtolower(str_replace(' ', '_', $location->name));
    //     $folder = 'images/virtual-tour/' . $locationName;

    //     $fileName = strtolower(str_replace(' ', '_', $request->name)) . '.' .
    //         $request->file('image')->getClientOriginalExtension();

    //     $request->file('image')->move(public_path($folder), $fileName);

    //     $imagePath = $folder . '/' . $fileName;

    //     $scene = Scene::create([
    //         'location_id' => $request->location_id,
    //         'name' => $request->name,
    //         'image_path' => $imagePath,
    //     ]);

    //     // Simpan connections kalau ada
    //     if ($request->filled('connections')) {
    //         $connections = json_decode($request->connections, true);
    //         foreach ($connections as $conn) {
    //             if (!empty($conn['target'])) {
    //                 Connection::create([
    //                     'scene_from' => $scene->id,
    //                     'scene_to' => $conn['target'],
    //                     'yaw' => $conn['yaw'],
    //                     'pitch' => $conn['pitch'],
    //                 ]);
    //             }
    //         }
    //     }

    //     return redirect()->route('scenes.index')
    //         ->with('success', 'Scene & connections berhasil ditambahkan!');
    // }

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
        Connection::where('scene_from', $scene->id)
            ->orWhere('scene_to', $scene->id)
            ->delete();

        $locationName = strtolower(str_replace(' ', '_', $scene->location->name));
        $fileName = strtolower(str_replace(' ', '_', $scene->name));

        $files = glob(public_path('images/virtual-tour/' . $locationName . '/' . $fileName . '.*'));
        foreach ($files as $file) {
            if (is_file($file)) unlink($file);
        }


        $scene->delete();

        return redirect()->route('scenes.index')->with('success', 'Scene dan file terkait berhasil dihapus!');
    }
}
