<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\User;
use App\NotaService;

class NotaServiceController extends Controller
{
    public function index()
    {
        return view('nota.service.index');
    }

    public function tracking()
    {
        return view('nota.tracking');
    }

    public function trackingProcess(Request $request)
    {
        $data = NotaService::where('no_nota', $request->no_nota)->with(
            'user', 'member','kupon','serviceBarang.barang', 'serviceBarang.mekanik', 'serviceBarang.service'
        )->first();
        return response()->json(['data' => $data]);
    }

    public function updatePayment($id)
    {
        DB::beginTransaction();
        try {
            $nota = NotaService::where('id', $id)->first();
            if ($nota->id_member) {
                $member = User::where('id', $nota->id_member)->first();
                $poin = $nota->total_harga / 10000;
                $member->update(['point' => $member->point + ceil($poin)]);
            }
            NotaService::where('id', $id)->update(['status_pembayaran' => 'lunas', 'tanggal_pembayaran' => date('Y-m-d H:i:s')]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }

    }

    public function updateTaking($id)
    {
        $data = NotaService::where('id', $id)->first();
        $selesai = $data->serviceBarang->where('status_pengerjaan', 'selesai')->count();
        $total = $data->serviceBarang->where('status_pengerjaan', '!=', 'cancel')->count();
        if ($data->status_pembayaran == 'lunas' && $data->status_pengambilan == 'belum-ambil' && $total == $selesai) {
            NotaService::where('id', $id)->update(['status_pengambilan' => 'ambil', 'tanggal_pengambilan' => date('Y-m-d H:i:s')]);
        } else {
            return response()->json(['message' => 'Silahkan lunasi pembayaran terlebih dahulu'], 500);
        }
    }

    public function print($id)
    {
        $data = NotaService::where('id', $id)->with(
            'admin', 'member','kupon','serviceBarang.barang', 'serviceBarang.mekanik', 'serviceBarang.service'
        )->first();
        return view('print.invoice', compact('data'));
    }

    public function reportEarning($start_date, $end_date)
    {
        $data = NotaService::with('admin')->whereBetween('created_at', [$start_date, $end_date])->get();
        return view('print.earnings', compact('data', 'start_date', 'end_date'));
    }
}
