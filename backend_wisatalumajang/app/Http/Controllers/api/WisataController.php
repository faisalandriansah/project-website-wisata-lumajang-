<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wisata;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class WisataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Wisata::with('comments')->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required',
            'deskripsi' => 'nullable',
            'lokasi' => 'required|string',
            'kategori' => 'required|in:gunung,air_terjun,pantai,danau,hutan',
            'gambar' => 'nullable|image',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('wisata_images', 'public');
    }

    $wisata = Wisata::create($data);
    return response()->json($wisata, 201);
}

    /**
     * Display the specified resource.
     */
    public function show(Wisata $wisata)
    {
        return $wisata->load('comments');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Wisata $wisata)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Wisata $wisata)
    {
        $data = $request->validate([
            'nama' => 'required',
            'deskripsi' => 'nullable',
            'lokasi' => 'required',
            'kategori' => 'required|in:gunung,air_terjun,pantai,danau,hutan',
            'gambar' => 'nullable|image',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        if ($request->hasFile('gambar')) {
            if ($wisata->gambar) {
                Storage::disk('public')->delete($wisata->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('wisata_images', 'public');
        }

        $updated = $wisata->update($data);

        $wisata->refresh();

        Log::info('Update result: ', ['updated' => $updated, 'wisata' => $wisata->toArray()]);

        return response()->json($wisata);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Wisata $wisata)
    {
        if ($wisata->gambar){
            Storage::disk('public')->delete($wisata->gambar);
        }

        $wisata->delete();
        return response()->json(['message' => 'wisata berhasil dihapus']);
    }
}
