<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\KategoriJurusan;

class KategoriJurusanController extends Controller
{
    private function validation($type, $request, $id = null) {
        $this->validate($request, [
            'nama' => 'required'
        ]);
    }

    public function index()
    {
        return view('admin.kategori_jurusan.index');
    }

    public function list(Request $request)
    {
        if ($request->q) {
            $kategori_jurusan = KategoriJurusan::where('nama', 'like', '%'.$request->q.'%')->get();
        } else {
            $kategori_jurusan = KategoriJurusan::get();
        }
        return response()->json(['data' => $kategori_jurusan]);
    }

    public function form($type, $id = null)
    {
        if ($type == 'create') {
            $data = null;
            return view('admin.kategori_jurusan.form', compact('type', 'data'));
        } elseif ($type == 'edit') {
            $data = KategoriJurusan::where('id', $id)->first();
            // return response()->json($data);
            return view('admin.kategori_jurusan.form', compact('type', 'data', 'id'));
        } else {
            abort(404);
        }
    }

    public function store(Request $request)
    {
        $this->validation('store', $request);
        KategoriJurusan::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $this->validation('update', $request, $id);
        KategoriJurusan::where('id', $id)->update($request->all());
            
    }

    public function delete($id)
    {
        KategoriJurusan::where('id', $id)->delete();
    }
}
