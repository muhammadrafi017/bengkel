<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Kupon;

class KuponController extends Controller
{
    private function validation($type, $request, $id = null) {
        $this->validate($request, [
            'nama' => 'required',
            'point' => 'required|integer',
            'potongan' => 'required|numeric'
        ]);
    }

    public function index()
    {
        return view('kupon.index');
    }

    public function list(Request $request)
    {
        if ($request->q) {
            $kupon = Kupon::where('nama', 'like', '%'.$request->q.'%')->get();
        } elseif ($request->has('point_member')) {
            $kupon = Kupon::where('point', '<=', $request->point_member)->get();
        } else {
            $kupon = Kupon::get();
        }
        return response()->json(['data' => $kupon]);
    }

    public function form($type, $id = null)
    {
        if ($type == 'create') {
            $data = null;
            return view('kupon.form', compact('type', 'data'));
        } elseif ($type == 'edit') {
            $data = Kupon::where('id', $id)->first();
            // return response()->json($data);
            return view('kupon.form', compact('type', 'data', 'id'));
        } else {
            abort(404);
        }
    }

    public function store(Request $request)
    {
        $this->validation('store', $request);
        Kupon::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $this->validation('update', $request, $id);
        Kupon::where('id', $id)->update($request->all());
            
    }

    public function delete($id)
    {
        Kupon::where('id', $id)->delete();
    }
}
