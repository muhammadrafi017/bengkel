<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Mekanik;

class MekanikController extends Controller
{
    private function validation($type, $request, $id = null) {
        $this->validate($request, [
            'nama' => 'required',
            'no_handphone' => 'required',
            'alamat' => 'required',
        ]);
    }

    public function index()
    {
        return view('mekanik.index');
    }

    public function list(Request $request)
    {
        if ($request->q) {
            $mekanik = Mekanik::where('nama', 'like', '%'.$request->q.'%')->get();
        } else {
            $mekanik = Mekanik::get();
        }
        return response()->json(['data' => $mekanik]);
    }

    public function form($type, $id = null)
    {
        if ($type == 'create') {
            $data = null;
            return view('mekanik.form', compact('type', 'data'));
        } elseif ($type == 'edit') {
            $data = Mekanik::where('id', $id)->first();
            // return response()->json($data);
            return view('mekanik.form', compact('type', 'data', 'id'));
        } else {
            abort(404);
        }
    }

    public function store(Request $request)
    {
        $this->validation('store', $request);
        Mekanik::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $this->validation('update', $request, $id);
        Mekanik::where('id', $id)->update($request->all());
            
    }

    public function delete($id)
    {
        Mekanik::where('id', $id)->delete();
    }
}
