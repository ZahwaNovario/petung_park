<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleGallery;
use App\Models\Gallery;
use App\Models\Agenda;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::all(); 
        return view('artikel.index', compact('articles')); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $agendas = Agenda::where('status', 1)->get();
        $galleries = Gallery::where('status', 1)->get();
        return view('artikel.create', compact('agendas', 'galleries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'agenda_id' => 'required|integer|exists:agendas,id',
            'photos' => 'required|array', 
            'photos.*' => 'integer|exists:galleries,id', 
        ],
        [
            'title.required' => 'Judul artikel harus diisi.',
            'content.required' => 'Konten artikel harus diisi.',
            'agenda_id.required' => 'Agenda harus dipilih.',
            'photos.required' => 'Foto harus dipilih.',
            'photos.*.exists' => 'Foto tidak ditemukan.',
        ]);
        $article = new Article([
            'user_id' => 2,
            'title' => $request->input('title'),
            'main_content' => $request->input('content'),
            'status' => 1,
            'number_love' => 0,
            'agenda_id' => $request->input('agenda_id'),
        ]);
        $article->save();
        $name = $request->get('title');
        foreach($request->get('photos') as $galleryId){
            $articleGallery = new ArticleGallery([
                'gallery_id' => $galleryId,
                'article_id' => $article->id,
                'name_collage' => 'Kolase '. $name,
            ]);
            $articleGallery->status = 1;
            $articleGallery->save();
        }
        return redirect()->route('artikel.index')->with('success', 'Artikel berhasil ditambahkan!');
    }
    
    /**
     * Display the specified resource.
     */
    public function showArtikelAllPengguna()
    {
        $articles = Article::where('status', 1)->get();
        return view('artikel.show', compact('article'));
    }
    public function show(Article $article)
    {
        $articles = Article::where('status', 1)->get();
        return view('artikel', compact('artikel'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $artikel)
    {
        $artikel = Article::with('agenda')->findOrFail($artikel->id);
        $agendas = Agenda::where('status', 1)->get();
        $users = User::where('status', 1)->get();
        return view('artikel.edit', compact('artikel', 'agendas', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData= $request->validate([
            'title' => 'required|string|max:255',
            'main_content' => 'required|string',
            'status' => 'required|integer',
            'agenda_id' => 'required|exists:agendas,id',
            'user_id' => 'required|exists:users,id',
        ],[
            'title.required' => 'Judul artikel harus diisi.',
            'main_content.required' => 'Konten artikel harus diisi.',
            'status.required' => 'Status artikel harus diisi.',
            'agenda_id.required' => 'Agenda harus dipilih.',
            'user_id.required' => 'User harus dipilih.',
        ]);
        try {
            $article = Article::findOrFail($id);
            $article->update($validatedData);
            $article->updated_at = now();
            $article->save();
            return redirect()->route('artikel.index')->with('success', 'Artikel berhasil Diupdate!');
        } catch (Exception $e) {
            return redirect()->route('artikel.index')->with('error', 'Artikel Gagal Diupdate!');
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function unactive(Article $artikel)
    {
        // ArticleGallery::where('article_id', $artikel->id)->update(['status' => 0]);
        DB::transaction(function () use ($artikel) {
            $artikel->status = 0;
            $artikel->updated_at = now();
            $artikel->save();
                    });
        return redirect()->route('artikel.index')->with('success', 'Artikel berhasil dinonaktifkan!');
    }

    public function like(Request $request, $articleId)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $article = Article::findOrFail($articleId);

        $sessionKey = 'liked_article_' . $articleId;

        if (session()->has($sessionKey)) {
            if ($article->number_love > 0) {
                $article->number_love--;
            }

            session()->forget($sessionKey);
            $action = 'unliked';
        } else {
            $article->number_love++;

            session()->put($sessionKey, true);
            $action = 'liked';
        }
        $article->updated_at = now();
        $article->save();

        return response()->json([
            'number_love' => $article->number_love,
            'action' => $action,
        ]);
    }

    // M to M article_gallery
    /**
     * Store a newly created resource in storage for pivot table article_gallery
     */


     public function indexArticleGallery()
     {
         $collages = ArticleGallery::all();
         return view('artikel.galeri.index', compact('collages'));
     }
      public function createArticleGallery()
     {
         $articles = Article::where('status', 1)->get();
         $galleries = Gallery::where('status', 1)->get();
         return view('artikel.galeri.create', compact('articles', 'galleries'));
     }

    public function storeArticleGallery(Request $request)
    {
        $request->validate([
            'article_id' => 'required|integer|exists:articles,id',
            'photos' => 'required|array', 
            'photos.*' => 'integer|exists:galleries,id', 
            'name_collage' => 'required|string',
        ]);

        $name = $request->get('name_collage');
        $articleId = $request->get('article_id');
        $galleryIds = $request->get('photos');

        $duplicateEntries = [];

        try {
            foreach ($galleryIds as $galleryId) {
                // Check for existing entry before inserting
                $exists = ArticleGallery::where('gallery_id', $galleryId)
                    ->where('article_id', $articleId)
                    ->exists();

                if ($exists) {
                    $duplicateEntries[] = $galleryId;
                } else {
                    ArticleGallery::create([
                        'gallery_id' => $galleryId,
                        'article_id' => $articleId,
                        'name_collage' => 'Kolase ' . $name,
                        'status' => 1,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            if (!empty($duplicateEntries)) {
                return redirect()->route('artikel.galeri.index')->with(
                    'error', 'Beberapa foto sudah ada dalam galeri artikel.'
                );
            }

            return redirect()->route('artikel.galeri.index')->with('success', 'Foto di Galeri berhasil ditambahkan!');
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) { // SQL Integrity Constraint Violation (Duplicate Entry)
                return redirect()->route('artikel.galeri.index')->with(
                    'error', 'Terjadi duplikasi dalam database. Foto sudah ada dalam galeri artikel.'
                );
            }

            return redirect()->route('artikel.galeri.index')->with(
                'error', 'Terjadi kesalahan. Silakan coba lagi.'
            );
        }
    }

     
    public function editArticleGallery(Request $request)
    {
        $selectedCollage = ArticleGallery::with(['article', 'gallery'])
                                        ->where('article_id', $request->get('article_id'))
                                        ->where('gallery_id', $request->get('gallery_id'))
                                        ->first(); 
        $existingGallery = ArticleGallery::with(['article', 'gallery'])
                                        ->where('article_id', $request->get('article_id'))
                                        ->where('gallery_id', '<>', $request->get('gallery_id'))
                                        ->get(); 
        
        $galleries = Gallery::where('status', 1)->get();

        if (!$selectedCollage) {
            return redirect()->route('artikel.galeri.index')
                             ->with('error', 'The selected collage with article_id and gallery_id  was not found.');
        }
        return view('artikel.galeri.edit', compact('galleries', 'selectedCollage', 'existingGallery'));
    }
    /**
     * Update the specified resource in storage for pivot table article_gallery
     */
    public function updateArticleGallery(Request $request)
    {
        $request->validate([
            'article_id' => 'required|integer',
            'gallery_id' => 'required|array', 
            'gallery_id.*' => 'integer|exists:galleries,id', 
            'name_collage' => 'required|string',
            'status' => 'required|integer',
            'new_photos' => 'nullable|array',
            'new_photos.*' => 'integer|exists:galleries,id', 
        ]);
    
        try {
            $articleId = $request->get('article_id');
            $oldGalleryIds = $request->get('gallery_id');
            $nameCollage = $request->get('name_collage');
            $status = $request->get('status');
            $newGalleryIds = $request->get('new_photos', []);
            if (!empty($newGalleryIds)) {
                    $oldGalleryIds = array_map('intval', $oldGalleryIds);
                    $newGalleryIds = array_map('intval', $newGalleryIds);
    
                    $galleryIdsToRemove = array_diff($oldGalleryIds, $newGalleryIds);
    
    
                    if (!empty($galleryIdsToRemove)) {
                        ArticleGallery::where('article_id', $articleId)
                                    ->whereIn('gallery_id', $galleryIdsToRemove)
                                    ->delete();
                    }
    
                    $existingGalleryIds = ArticleGallery::where('article_id', $articleId)
                                                    ->whereIn('gallery_id', $newGalleryIds)
                                                    ->pluck('gallery_id')
                                                    ->toArray();
    
                    $filteredNewGalleryIds = array_diff($newGalleryIds, $existingGalleryIds);
    
                foreach ($filteredNewGalleryIds as $galleryId) {
                    ArticleGallery::create([
                        'article_id' => $articleId,
                        'gallery_id' => $galleryId,
                        'name_collage' => $nameCollage,
                        'status' => $status,
                        'updated_at' => now(),
                        'created_at' => now(),
                    ]);
                }
            } else {
                ArticleGallery::where('article_id', $articleId)
                             ->whereIn('gallery_id', $oldGalleryIds)
                             ->update([
                                 'name_collage' => $nameCollage,
                                 'status' => $status,
                                 'updated_at' => now(),
                             ]);
            }
        
            return redirect()->route('artikel.galeri.index')->with('success', 'Data kolase berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->route('artikel.galeri.edit', [
                'article_id' => $request->get('article_id'),
                'gallery_id' => $oldGalleryIds
            ])->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
        
    }
    public function unactiveArticleGallery($artikel)
    {
        try {
            ArticleGallery::where('article_id', $artikel)
                ->update([
                    'status' => 0,
                    'updated_at' => now(),
                ]);
    
            return redirect()->route('artikel.galeri.index')->with('success', 'Kolase berhasil dinonaktifkan!');
        } catch (\Exception $e) {
            return redirect()->route('artikel.galeri.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
