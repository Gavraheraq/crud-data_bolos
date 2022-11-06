<?php

namespace App\Http\Controllers;

use App\Models\bolos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BolosController extends Controller
{
    public function index()
    {
        //get bolos
        $bolos = bolos::latest()->paginate(5);

        //render view with bolos
        return view('siswa.index', compact('bolos'));
    }

    public function create()
    {
        return view('siswa.create');
    }

    /**
     * store
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        //validate form
        $this->validate($request, [
            'image'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nama'     => 'required',
            'kelas'     => 'required',
            'absen'     => 'required',
            'alamat'     => 'required',
            'keterangan'   => 'required'
        ]);

        //upload image
        $image = $request->file('image');
        $image->storeAs('image', $image->hashName());

        //create bolos
        bolos::create([
            'image'     => $image->hashName(),
            'nama'     => $request->nama,
            'kelas'     => $request->kelas,
            'absen'     => $request->absen,
            'alamat'     => $request->alamat,
            'keterangan'   => $request->keterangan
        ]);

        //redirect to index
        return redirect()->route('siswa.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function edit(bolos $siswa)
    {
        return view('siswa.edit', compact('siswa'));
    }
    
    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $bolos
     * @return void
     */
    public function update(Request $request, bolos $siswa)
    {
        //validate form
        $this->validate($request, [
            'image'     => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nama'     => 'required',
            'kelas'     => 'required',
            'absen'     => 'required',
            'alamat'     => 'required',
            'keterangan'   => 'required'
        ]);

        //check if image is uploaded
        if ($request->hasFile('image')) {

            //upload new image
            $image = $request->file('image');
            $image->storeAs('image', $image->hashName());

            //delete old image
            Storage::delete('image'.$siswa->image);

            //update bolos with new image
            $siswa->update([
                'image'     => $image->hashName(),
                'nama'     => $request->nama,
                'kelas'     => $request->kelas,
                'absen'     => $request->absen,
                'alamat'     => $request->alamat,
                'keterangan'   => $request->keterangan
            ]);

        } else {

            //update bolos without image
            $siswa->update([
                'nama'     => $request->nama,
                'kelas'     => $request->kelas,
                'absen'     => $request->absen,
                'alamat'     => $request->alamat,
                'keterangan'   => $request->keterangan
            ]);
        }

        //redirect to index
        return redirect()->route('siswa.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    public function destroy(bolos $siswa)
    {
        //delete image
        Storage::delete('image'. $siswa->image);

        //delete post
        $siswa->delete();

        //redirect to index
        return redirect()->route('siswa.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }

    function logout()
    {
        Auth::logout();
        return redirect('sesi')->with('success', 'Berhasil logout');
    }



}
