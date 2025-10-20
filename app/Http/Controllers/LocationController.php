<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::all();
        return view('admin.virtualtouradmin.locations.index', compact('locations'));
    }

    public function create()
    {
        return view('admin.virtualtouradmin.locations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:locations,name',
            'slug' => 'nullable|string|max:255|unique:locations,slug',
        ]);

        $slug = $request->slug ?: Str::slug($request->name, '-');

        Location::create([
            'name' => $request->name,
            'slug' => $slug,
        ]);

        return redirect()->route('locations.index')->with('success', 'Lokasi berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $location = Location::findOrFail($id);
        return view('admin.virtualtouradmin.locations.edit', compact('location'));
    }

    public function update(Request $request, $id)
    {
        $location = Location::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:locations,name,' . $id,
            'slug' => 'nullable|string|max:255|unique:locations,slug,' . $id,
        ]);

        $slug = $request->slug ?: Str::slug($request->name, '-');

        $location->update([
            'name' => $request->name,
            'slug' => $slug,
        ]);

        return redirect()->route('locations.index')->with('success', 'Lokasi berhasil diperbarui!');
    }


    public function destroy($id)
    {
        $location = Location::findOrFail($id);

        foreach ($location->scenes as $scene) {
            $sceneFolder = public_path('images/virtual-tour/' . strtolower(str_replace(' ', '_', $location->name)));

            // Cek apakah scene punya file individual (misal scene.jpg)
            $sceneFilePattern = $sceneFolder . '/' . Str::slug($scene->name) . '.*';
            $sceneFiles = glob($sceneFilePattern);

            foreach ($sceneFiles as $file) {
                if (is_file($file)) {
                    unlink($file);
                }
            }

            // Hapus data scene-nya dari DB
            $scene->delete();
        }

        // --- Setelah semua scene dihapus, hapus folder lokasi-nya ---
        $locationFolder = public_path('images/virtual-tour/' . strtolower(str_replace(' ', '_', $location->name)));
        if (File::isDirectory($locationFolder)) {
            // Hapus seluruh isi folder + folder-nya
            File::deleteDirectory($locationFolder);
        }

        // --- Hapus lokasi dari DB ---
        $location->delete();

        return redirect()->route('locations.index')->with('success', 'Lokasi dan semua file virtual tour berhasil dihapus!');
    }
}
