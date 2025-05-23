<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Antrian;

class AntrianController extends Controller
{
    public function index()
    {
        $antrians = Antrian::with('user')->latest()->paginate(15);
        return view('antrian.index', compact('antrians'));
    }

    public function create()
    {
        return view('antrian.create');
    }

    public function store(Request $request)
    {
        // Validasi inputan
        $request->validate([
            'waktu_datang' => 'required',
        ]);

        // Simpan antrian
        Antrian::create([
            'user_id' => auth()->id(),
            'status' => 'menunggu',
            'waktu_datang' => $request->waktu_datang,
        ]);

        return redirect()->route('antrian.index')->with('success', 'Antrian berhasil dibuat!');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function tiket()
    {
        $tiketAktif = Antrian::where('user_id', auth()->id())
                            ->where('status', 'menunggu')
                            ->latest()
                            ->first();

        $semuaAntrian = Antrian::where('user_id', auth()->id())
                            ->latest()
                            ->paginate(10);

        return view('antrian.tiket', compact('tiketAktif', 'semuaAntrian'));
    }

}
