<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Peminat;

class PeminatController extends Controller
{
    private function validation($type, $request, $id = null) {
        $this->validate($request, [
            'nama_lengkap' => 'required',
            'no_handphone' => 'required|numeric',
            'email' => 'required',
            'status' => 'required|in:belum-follow-up,sudah-follow-up'
        ]);
    }

    public function index()
    {
        return view('admin.peminat.index');
    }

    public function form($type, $id = null)
    {
        if ($type == 'create') {
            $data = null;
            return view('admin.peminat.form', compact('type', 'data'));
        } elseif ($type == 'edit') {
            $data = Peminat::where('id', $id)->first();
            // return response()->json($data);
            return view('admin.peminat.form', compact('type', 'data', 'id'));
        } else {
            abort(404);
        }
    }

    public function store(Request $request)
    {
        $this->validation('store', $request);
        $request->request->add(['id_user' => auth()->user()->id]);
        Peminat::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $this->validation('update', $request, $id);
        Peminat::where('id', $id)->update($request->all());
    }

    public function status(Request $request, $id)
    {
        Peminat::where('id', $id)->update(['status' => $request->status]);
    }

    public function delete($id)
    {
        Peminat::where('id', $id)->delete();
    }
}
