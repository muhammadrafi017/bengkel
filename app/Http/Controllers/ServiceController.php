<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Service;

class ServiceController extends Controller
{
    private function validation($type, $request, $id = null) {
        $this->validate($request, [
            'nama' => 'required',
            'harga_minimal' => 'required|numeric',
            'harga_maksimal' => 'required|numeric|gt:harga_minimal'
        ]);
    }

    public function index()
    {
        return view('service.index');
    }

    public function list(Request $request)
    {
        if ($request->q) {
            $service = Service::where('nama', 'like', '%'.$request->q.'%')->get();
        } elseif ($request->id_service) {
            $service = Service::where('id', $request->id_service)->first();
        } else {
            $service = Service::get();
        }
        return response()->json(['data' => $service]);
    }

    public function form($type, $id = null)
    {
        if ($type == 'create') {
            $data = null;
            return view('service.form', compact('type', 'data'));
        } elseif ($type == 'edit') {
            $data = Service::where('id', $id)->first();
            // return response()->json($data);
            return view('service.form', compact('type', 'data', 'id'));
        } else {
            abort(404);
        }
    }

    public function store(Request $request)
    {
        $this->validation('store', $request);
        Service::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $this->validation('update', $request, $id);
        Service::where('id', $id)->update($request->all());
            
    }

    public function delete($id)
    {
        Service::where('id', $id)->delete();
    }
}
