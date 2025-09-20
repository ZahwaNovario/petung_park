<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use Illuminate\Support\Str;

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
        $location->delete();

        return redirect()->route('locations.index')->with('success', 'Lokasi berhasil dihapus!');
    }
}
