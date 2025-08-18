<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use App\Models\Travel;
use App\Models\Category;
use App\Models\Article;
use App\Models\Package;
use App\Models\User;

class AgendaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $agendas = Agenda::with('user')->get();
        return view('agenda.index', compact('agendas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('agenda.create'); 
    }

    /**
     * Store a newly created resource in storage.
     */
        public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'location' => 'required|string|max:255',
            'desc' => 'nullable|string',
        ], [
            'name.required' => 'Nama harus diisi.',
            'start_date.required' => 'Tanggal mulai harus diisi.',
            'end_date.required' => 'Tanggal selesai harus diisi.',
            'end_date.after_or_equal' => 'Tanggal selesai harus lebih akhir atau sama dengan tanggal mulai.',
            'location.required' => 'Lokasi harus diisi.',
        ]);

        if (Carbon::parse($request->input('start_date'))->gt(Carbon::parse($request->input('end_date')))) {
            return redirect()->route('agenda.create')->with('error', 'Tanggal mulai harus lebih awal atau sama dengan tanggal selesai.');
        } 

        try {
            Agenda::create([
                'event_name' => $request->input('name'),
                'event_start_date' => $request->input('start_date'),
                'event_end_date' => $request->input('end_date'),
                'event_location' => $request->input('location'),
                'status' => 1,
                'description' => $request->input('desc'),
                'user_id' => $request->input('user_id'), 
            ]);

            return redirect()->route('agenda.index')->with('success', 'Agenda berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->route('agenda.create')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Agenda $agenda)
    {
        return view('agenda.show', compact('agenda')); 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Agenda $agenda)
    {
        $users = User::where('status', 1)->get();
        return view('agenda.edit', compact('agenda','users')); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:tanggal_mulai',
            'location' => 'required|string|max:255',
            'status' => 'required|integer',
            'desc' => 'nullable|string',
            'user_id' => 'required|integer|exists:users,id',
        ], [
            'name.required' => 'Nama harus diisi.',
            'start_date.required' => 'Tanggal mulai harus diisi.',
            'end_date.required' => 'Tanggal selesai harus diisi.',
            'end_date.after_or_equal' => 'Tanggal selesai harus lebih akhir atau sama dengan tanggal mulai.',
            'location.required' => 'Lokasi harus diisi.',
            'status.required' => 'Status harus diisi.',
        ]);

        try {
            $agenda = Agenda::findOrFail($id);
            $startDate = Carbon::parse($request->get('start_date'));
            $endDate = Carbon::parse($request->get('end_date'));
            if (Carbon::parse($startDate)->gt(Carbon::parse($endDate))) {
                return redirect()->route('agenda.edit', $id)->with('error', 'Tanggal mulai harus lebih awal atau sama dengan tanggal selesai.');
            }
            
            $agenda->event_name = $request->get('name');
            $agenda->event_start_date = $startDate;
            $agenda->event_end_date = $endDate;
            $agenda->event_location = $request->get('location');
            $agenda->status = $request->get('status');
            $agenda->description = $request->get('desc');
            $agenda->user_id = $request->get('user_id');
            $agenda->updated_at = now();
            $agenda->save();
            return redirect()->route('agenda.index')->with('success', 'Agenda Berhasil Diubah!');
        } catch (Exception $e) {
            return redirect()->route('agenda.index')->with('error', 'Agenda Gagal Diubah!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function unactive(Agenda $agenda)
    {
        try {
            $articles = Article::where('agenda_id', $agenda->id)->count();
            foreach ($articles as $article) {
                if($article->status == 1){
                    return redirect()->route('agenda.index')->with('error', 'Tidak dapat menonaktifkan agenda karena masih ada artikel aktif yang terkait.');
                }
            }
            if ($articles > 0) {
                return redirect()->route('agenda.index')->with('error', 'Tidak dapat menonaktifkan agenda karena masih ada artikel yang terkait.');
            }
            $agenda->status = 0;
            $agenda->updated_at = now();
            $agenda->save();
            return redirect()->route('agenda.index')->with('success', 'Agenda Berhasil Dinonaktifkan!');
        } catch (Exception $e) {
            return redirect()->route('agenda.index')->with('error', 'Agenda Gagal Dinonaktifkan!');
        }
    }


    //TAMBAHAN
    public function showAgenda()
    {
        $agendaMendatang = Agenda::where('status', 1)->where('event_end_date', '>=', now())->orderBy('event_end_date', 'desc')->get();
        $agendaLalu = Agenda::where('status', 1)->where('event_end_date', '<', now())->orderBy('event_end_date', 'desc')->get();
        $kategori = Category::where('status', 1)->get();
        return view('agenda', compact('agendaMendatang', 'agendaLalu'));
    }
    public function showMendatang($id)
    {
        $agenda = Agenda::findOrFail($id);

        $articles = Article::where('status', 1)->where('agenda_id', $agenda->id)->get();
        $galleries = collect(); 
        foreach ($articles as $article) {
            $articleGalleries = $article->galleries()
                ->where('article_gallery.status', 1)
                ->get();

            $galleries = $galleries->merge($articleGalleries); // Menggabungkan hasil ke dalam koleksi
        }

        return view('agenda.mendatang', compact('agenda', 'articles', 'galleries'));
    }


    public function showLalu($id)
    {
        $agenda = Agenda::findOrFail($id);

        $articles = Article::where('status', 1)->where('agenda_id', $agenda->id)->get();

        $galleries = collect();
        foreach ($articles as $article) {
            $articleGalleries = $article->galleries()
                ->where('article_gallery.status', 1)
                ->get();

            $galleries = $galleries->merge($articleGalleries);
        }

        return view('agenda.lalu', compact('agenda', 'articles', 'galleries'));
    }
}
