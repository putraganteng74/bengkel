<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Antrian;

class AntrianController extends Controller
{
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

        return redirect()->route('index')->with('success', 'Antrian berhasil dibuat!');
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
}
