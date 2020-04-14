<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Produk;

class ProdukController extends Controller
{
    private function validation($type, $request, $id = null) {
        $this->validate($request, [
            'nama' => 'required',
            'satuan' => 'required',
            'kuantitas' => 'required|integer',
            'harga_satuan' => 'required|numeric',
            'foto_produk_file' => 'required|mimes:jpg,png,jpeg',
            'status' => 'required|in:ada,tidak-ada',
        ]);
    }

    public function index()
    {
        return view('produk.index');
    }

    public function list(Request $request)
    {
        if ($request->q) {
            $produk = Produk::where('nama', 'like', '%'.$request->q.'%')->get();
        } elseif ($request->id_produk) {
            $produk = Produk::where('id', $request->id_produk)->first();
        } else {
            $produk = Produk::get();
        }
        return response()->json(['data' => $produk]);
    }

    public function form($type, $id = null)
    {
        if ($type == 'create') {
            $data = null;
            return view('produk.form', compact('type', 'data'));
        } elseif ($type == 'edit') {
            $data = Produk::where('id', $id)->first();
            // return response()->json($data);
            return view('produk.form', compact('type', 'data', 'id'));
        } else {
            abort(404);
        }
    }

    public function store(Request $request)
    {
        $this->validation('store', $request);
        if ($request->foto_produk_file) {
            $filename = 'produk_'.strtotime(date(now())).'.'.$request->foto_produk_file->getClientOriginalExtension();
            $request->foto_produk_file->storeAs('public/produk', $filename);
            $request->request->add(['foto_produk' => $filename]);
        }
        Produk::create($request->except('foto_produk_file'));
    }

    public function update(Request $request, $id)
    {
        $this->validation('update', $request, $id);
        $produk = Produk::where('id', $id)->first();
        if ($request->foto_produk_file) {
            if ($produk->foto_produk) {
                Storage::delete('public/produk/'.$produk->foto_produk);
            }
            $filename = 'produk_'.strtotime(date(now())).'.'.$request->foto_produk_file->getClientOriginalExtension();
            $request->foto_produk_file->storeAs('public/produk', $filename);
            $request->request->add(['foto_produk' => $filename]);
        }
        $produk->update($request->except('foto_produk_file'));
            
    }

    public function delete($id)
    {
        $produk = Produk::where('id', $id)->first();
        if ($produk->foto_produk) {
            Storage::delete('public/produk/'.$produk->foto_produk);
        }
        $produk->delete();
    }
}
