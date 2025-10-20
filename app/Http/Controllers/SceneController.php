<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Scene;
use App\Models\Connection;
use Intervention\Image\ImageManagerStatic as intrvnt;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

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
        $folders = ['low', 'medium', 'original'];
        foreach ($folders as $folder) {
            $path = "{$baseFolder}/{$folder}";
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
        }

        // 🔹 Simpan nama file dasar
        $originalExt = $request->file('image')->getClientOriginalExtension();
        $fileBaseName = strtolower(str_replace(' ', '_', $request->name));

        // 🔹 Baca gambar utama
        $image = intrvnt::make($request->file('image'));

        // 🔹 Simpan versi original (tanpa resize)
        $originalPath = "{$baseFolder}/original/{$fileBaseName}_original.{$originalExt}";
        $image->save($originalPath);

        // 🔹 Simpan versi low (misal 720px)
        $low = clone $image;
        $low->resize(720, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $lowPath = "{$baseFolder}/low/{$fileBaseName}_low.{$originalExt}";
        $low->save($lowPath);

        // 🔹 Simpan versi medium (misal 1440px)
        $medium = clone $image;
        $medium->resize(1440, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $mediumPath = "{$baseFolder}/medium/{$fileBaseName}_medium.{$originalExt}";
        $medium->save($mediumPath);

        // 🔹 Path default (misal versi low untuk tampilan awal)
        $defaultImagePath = "images/virtual-tour/{$uuid}/low/{$fileBaseName}_low.{$originalExt}";

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
            ->with('success', 'Scene berhasil ditambahkan dan dibuat dalam 3 versi: Low, Medium, dan Original!');
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



    // public function update(Request $request, Scene $scene)
    // {
    //     $request->validate([
    //         'location_id' => 'required|exists:locations,id',
    //         'name' => 'required|string|max:255',
    //         'image' => 'nullable|image|mimes:jpg,jpeg,png',
    //     ]);

    //     $data = [
    //         'location_id' => $request->location_id,
    //         'name' => $request->name,
    //     ];

    //     if ($request->hasFile('image')) {
    //         $location = Location::findOrFail($request->location_id);
    //         $locationName = strtolower(str_replace(' ', '_', $location->name));
    //         $folder = 'images/' . $locationName;

    //         $fileName = strtolower(str_replace(' ', '_', $request->name)) . '.' .
    //             $request->file('image')->getClientOriginalExtension();

    //         $request->file('image')->move(public_path($folder), $fileName);
    //         $data['image_path'] = $folder . '/' . $fileName;
    //     }

    //     $scene->update($data);

    //     // Update connections
    //     Connection::where('scene_from', $scene->id)->delete();
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

    //     return redirect()->route('scenes.index')->with('success', 'Scene berhasil diupdate!');
    // }

    public function update(Request $request, Scene $scene)
    {
        $request->validate([
            'location_id' => 'required|exists:locations,id',
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:30000',
        ]);

        $scene->location_id = $request->location_id;
        $scene->name = $request->name;

        if ($request->hasFile('image')) {
            $uuid = $scene->uuid;
            $baseFolder = public_path("images/virtual-tour/{$uuid}");

            // Bersihkan isi folder lama
            foreach (['low', 'medium', 'original'] as $folder) {
                File::cleanDirectory("{$baseFolder}/{$folder}");
            }

            $ext = $request->file('image')->getClientOriginalExtension();
            $fileBaseName = strtolower(str_replace(' ', '_', $request->name));
            $image = intrvnt::make($request->file('image'));

            $image->save("{$baseFolder}/original/{$fileBaseName}_original.{$ext}");

            $low = clone $image;
            $low->resize(720, null, function ($c) {
                $c->aspectRatio();
                $c->upsize();
            });
            $low->save("{$baseFolder}/low/{$fileBaseName}_low.{$ext}");

            $medium = clone $image;
            $medium->resize(1440, null, function ($c) {
                $c->aspectRatio();
                $c->upsize();
            });
            $medium->save("{$baseFolder}/medium/{$fileBaseName}_medium.{$ext}");

            $scene->image_path = "images/virtual-tour/{$uuid}/low/{$fileBaseName}_low.{$ext}";
        }

        $scene->save();

        // Update koneksi
        Connection::where('scene_from', $scene->id)->delete();
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

        return redirect()->route('scenes.index')->with('success', 'Scene berhasil diupdate!');
    }

    // public function destroy(Scene $scene)
    // {
    //     Connection::where('scene_from', $scene->id)
    //         ->orWhere('scene_to', $scene->id)
    //         ->delete();

    //     $locationName = strtolower(str_replace(' ', '_', $scene->location->name));
    //     $fileName = strtolower(str_replace(' ', '_', $scene->name));

    //     $files = glob(public_path('images/virtual-tour/' . $locationName . '/' . $fileName . '.*'));
    //     foreach ($files as $file) {
    //         if (is_file($file)) unlink($file);
    //     }


    //     $scene->delete();

    //     return redirect()->route('scenes.index')->with('success', 'Scene dan file terkait berhasil dihapus!');
    // }
    public function destroy(Scene $scene)
    {
        // Hapus semua koneksi yang terkait
        \App\Models\Connection::where('scene_from', $scene->id)
            ->orWhere('scene_to', $scene->id)
            ->delete();

        // Hapus folder UUID
        if ($scene->uuid) {
            $folderPath = public_path("images/virtual-tour/{$scene->uuid}");
            if (File::exists($folderPath)) {
                File::deleteDirectory($folderPath);
            }
        }

        // Hapus dari database
        $scene->delete();

        return redirect()->route('scenes.index')->with('success', 'Scene dan semua gambar telah dihapus!');
    }
}
