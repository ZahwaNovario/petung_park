<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\User;
use App\Models\Gallery;
use App\Models\Category;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $packages = Package::all();
        $menus= Menu::all();
        return view('menu.index', compact('packages','menus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {       
        $categories = Category::where('status', 1)->get();
        $users = User::where('status', 1)->get();
        $galleries = Gallery::where('status', 1)->get();
        return view('menu.hidangan.create', compact('categories', 'users', 'galleries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|double',
                'recommendation' => 'required|integer',
                'category_id' => 'required|integer|exists:categories,id',
                'user_id' => 'required|email|exists:users,id',
                'gallery_id' => 'required|integer|exists:galleries,id',
            ],[
                'name.required' => 'Nama harus diisi.',
                'description.required' => 'Deskripsi harus diisi.',
                'price.required' => 'Harga harus diisi.',
                'recommendation.required' => 'Rekomendasi harus diisi.',
                'category_id.required' => 'Kategori harus dipilih.',
                'user_id.required' => 'User harus dipilih.',
                'gallery_id.required' => 'Foto harus dipilih.',
            ]);
            $menu = Menu::create([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'status' => 1,
                'status_recommended' => $request->recommendation,
                'number_love' => 0,
                'category_id' => $request->category_id,
                'user_id' => $request->user_id,
                'gallery_id' => $request->gallery_id,
            ]);

            return redirect()->route('menu.index')->with('success', 'Menu berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $menu = Menu::findOrFail($id);
        return view('menu.hidangan.show', compact('menu'));
    }

    public function showMenuAllPengguna()
    {
        $menus = Menu::where('status', 1)->get();
        return view('menu.hidangan.show', compact('menus'));
    }

    public function cariMenuDariId($id)
    {
        $menu = Menu::with('category')
                    ->findOrFail($id);
    
        return view('menu.hidangan.show', compact('menu'));
    }

    public function like(Request $request, $menuId)
    {
        $menu = Menu::findOrFail($menuId);
        $sessionKey = 'liked_menu_' . $menuId;
    
        if (session()->has($sessionKey)) {
            if($menu->number_love==0){
                $menu->number_love=0;
            }
            else{
                $menu->number_love--;
            }
            session()->forget($sessionKey);
        } else {
            $menu->number_love++;
            session()->put($sessionKey, true);
        }
    
        $menu->save();
    
        return response()->json(['number_love' => $menu->number_love]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $menu = Menu::findOrFail($id);
        $categories = Category::where('status', 1)->get();
        $users = User::where('status', 1)->get();
        $galleries = Gallery::where('status', 1)->get();
        return view('menu.hidangan.edit', compact('menu', 'categories', 'users', 'galleries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric',
                'status' => 'required|integer|in:1,0',
                'recommendation' => 'required|integer',
                'category_id' => 'required|integer|exists:categories,id',
                'user_id' => 'required|integer|exists:users,id',
                'gallery_id' => 'nullable|integer|exists:galleries,id',
            ],
            [
                'name.required' => 'Nama harus diisi.',
                'description.required' => 'Deskripsi harus diisi.',
                'price.required' => 'Harga harus diisi.',
                'status.required' => 'Status harus diisi.',
                'recommendation.required' => 'Rekomendasi harus diisi.',
                'category_id.required' => 'Kategori harus dipilih.',
                'user_id.required' => 'User harus dipilih.',
            ]);
        
            $menu = Menu::findOrFail($id);
        
            $menu->update([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'status' => $request->status,
                'status_recommended' => $request->recommendation,
                'category_id' => $request->category_id,
                'user_id' => $request->user_id,
                'gallery_id' => $request->gallery_id,
                'updated_at' => now(),
            ]);
            return redirect()->route('menu.index')->with('success', 'Menu berhasil diupdate!');
        } catch (\Throwable $th) {
            return redirect()->route('menu.index')->with('error', 'Menu gagal diupdate');
        }
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function unactive(string $menu)
    {
        try {
            $menu = Menu::findOrFail($menu);
            $menu->status=0;
            $menu->updated_at = now();
            $menu->save();
            return redirect()->route('menu.index')->with('success', 'Menu berhasil dinonaktifkan');
        } catch (\Throwable $th) {
            return redirect()->route('menu.index')->with('error', 'Data gagal di nonaktifkan');
        }
    }
}

