<?php

namespace App\Http\Controllers;

use App\Models\Foto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $album = auth()->user()->album;
        return view(
            'foto.create',
            compact('album')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'album_id' => 'required',
        ]);

        $foto = new Foto();
        $foto->user_id = Auth::user()->id;
        $foto->judul = $request->judul;
        $foto->deskripsi = $request->deskripsi;
        $foto->album_id = $request->album_id;

        if ($request->file('lokasi')) {
            $imagePath = Storage::disk('public')->put('images/', $request->file('lokasi'));

            if (!Storage::disk('public')->exists($imagePath)) {
                return back()->withInput()->withError('Gagal menyimpan foto, silahkan coba kembali!');
            }

            $foto->lokasi = $imagePath;
        }

        $foto->save();

        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $foto = Foto::find($id);

        $album = auth()->user()->album;

        return view('foto.edit', compact('foto', 'album'));
    }

    /**
     * Update the specified resource in Storage.
     */
    public function update(Request $request, string $id)
    {
        $foto = Foto::find($id);

        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'album_id' => 'required',
        ]);

        $foto->user_id = Auth::user()->id;
        $foto->judul = $request->judul;
        $foto->deskripsi = $request->deskripsi;
        $foto->album_id = $request->album_id;

        if ($request->hasFile('lokasi')) {
            $imagePath = Storage::disk('public')->put('images/', $request->file('lokasi'));

            if (!Storage::disk('public')->exists($imagePath)) {
                return back()->withInput()->withError('Gagal menyimpan foto, silahkan coba kembali!');
            }

            $foto->lokasi = $imagePath;
        }

        $foto->save();

        return redirect()->route('home');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $foto = Foto::find($id);

        $foto->delete();

        return redirect()->route('home');
    }
}
