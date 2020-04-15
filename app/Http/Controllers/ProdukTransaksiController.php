<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Service\ProdukService;

use App\Produk;
use App\NotaProduk;
use App\DetailNotaProduk;

class ProdukTransaksiController extends Controller
{
    public function offline()
    {
        return view('produk_transaksi.offline');
    }

    public function storeOffline(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->request->add(['metode' => 'offline']);
            $nota = ProdukService::generateNota($request->except('data'));
            $total_harga = 0;
            foreach ($request->data as $produk) {
                $produk_db = Produk::where('id', $produk['id_produk'])->first();
                $total_harga += $produk_db->harga_satuan * $produk['kuantitas'];
                DetailNotaProduk::create([
                    'id_nota' => $nota['id'],
                    'id_produk' => $produk_db->id,
                    'kuantitas' => $produk['kuantitas'],
                    'harga_satuan' => $produk_db->harga_satuan
                ]);
            }
            
            NotaProduk::where('id', $nota['id'])->update(['total_harga' => $total_harga - $nota['potongan_harga']]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $errors = '';
            if (method_exists($th, 'errors')) {
                $errors = $th->errors();
            } else {
                $errors = $th->getMessage();
            }
            return response()->json(['message' => $errors], $th->getCode() == 0? 500 : $th->getCode());
        }
    }
}
