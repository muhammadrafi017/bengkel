<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Jurusan;

class LandingController extends Controller
{
    public function index()
    {
        $jurusan = Jurusan::with('kategoriJurusan')->get();
        return view('landing', compact('jurusan'));
    }

    public function detailJurusan($id)
    {
        $jurusan = Jurusan::where('id', $id)->first();
        $jurusan->update(['dilihat' => $jurusan->dilihat + 1]);
        return view('detail_jurusan', compact('jurusan'));
    }
}
