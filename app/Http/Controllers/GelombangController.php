<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Gelombang;

class GelombangController extends Controller
{
    private function validation($type, $request, $id = null) {
        $this->validate($request, [
            'nama' => 'required',
            'kuota' => 'required|integer',
            'biaya_formulir' => 'required|numeric',
            'biaya_admisi' => 'required|numeric',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'tanggal_tes' => 'required|date|after:tanggal_selesai',
        ]);
    }

    public function index()
    {
        return view('admin.gelombang.index');
    }

    public function form($type, $id = null)
    {
        if ($type == 'create') {
            $data = null;
            return view('admin.gelombang.form', compact('type', 'data'));
        } elseif ($type == 'edit') {
            $data = Gelombang::where('id', $id)->first();
            // return response()->json($data);
            return view('admin.gelombang.form', compact('type', 'data', 'id'));
        } else {
            abort(404);
        }
    }

    public function store(Request $request)
    {
        $this->validation('store', $request);
        Gelombang::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $this->validation('update', $request, $id);
        Gelombang::where('id', $id)->update($request->all());
            
    }

    public function delete($id)
    {
        Gelombang::where('id', $id)->delete();
    }
}
