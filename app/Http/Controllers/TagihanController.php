<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\User;
use App\Tagihan;

class TagihanController extends Controller
{
    public function index()
    {
        return view('admin/tagihan/index');
    }

    public function status(Request $request, $id)
    {
        $tagihan = Tagihan::where('id', $id)->first();
        if ($request->status == 'tolak') {
            Storage::delete('public/bukti_bayar/'.$tagihan->bukti_pembayaran);
            $tagihan->delete();
        } elseif ($request->status == 'lunas') {
            if ($request->tagihan == 'formulir') {
                User::where('id', $tagihan->id_user)->update(['posisi' => 'pembayaran-formulir']);
            } elseif ($request->tagihan == 'admisi') {
                User::where('id', $tagihan->id_user)->update(['posisi' => 'pembayaran-administrasi']);
            }
            $tagihan->update(['status' => 'lunas']);
        }
    }
}
