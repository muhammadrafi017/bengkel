<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProdukTransaksiController extends Controller
{
    public function offline()
    {
        return view('produk_transaksi.offline');
    }
}
