<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Jurusan;

class JurusanController extends Controller
{
    private function validation($type, $request, $id = null) {
        $this->validate($request, [
            'nama' => 'required',
            'id_kategori_jurusan' => 'required|exists:kategori_jurusan,id',
            'level' => 'required|in:SMA-D3,SMA-S1,S1-S2,S2-S3'
        ]);
    }

    public function index()
    {
        return view('admin.jurusan.index');
    }

    public function list(Request $request)
    {
        if ($request->q) {
            $jurusan = Jurusan::where('nama', 'like', '%'.$request->q.'%')->get();
        } else {
            $jurusan = Jurusan::get();
        }
        return response()->json(['data' => $jurusan]);
    }

    public function form($type, $id = null)
    {
        if ($type == 'create') {
            $data = null;
            return view('admin.jurusan.form', compact('type', 'data'));
        } elseif ($type == 'edit') {
            $data = Jurusan::where('id', $id)->first();
            // return response()->json($data);
            return view('admin.jurusan.form', compact('type', 'data', 'id'));
        } else {
            abort(404);
        }
    }

    public function store(Request $request)
    {
        $this->validation('store', $request);
        Jurusan::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $this->validation('update', $request, $id);
        Jurusan::where('id', $id)->update($request->all());
            
    }

    public function delete($id)
    {
        Jurusan::where('id', $id)->delete();
    }
}
