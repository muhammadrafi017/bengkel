<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Service\OrderService;

use App\Service;
use App\Barang;
use App\Mekanik;
use App\ServiceBarang;
use App\NotaService;

class ServiceBarangController extends Controller
{
    public function index()
    {
        return view('service_barang.index');
    }

    public function order()
    {
        return view('service_barang.order');
    }

    public function form()
    {
        return view('service_barang.form');
    }

    public function list(Request $request)
    {
        if ($request->id) {
            $service_barang = ServiceBarang::where('id', $request->id)->first();
        }
        return response()->json(['data' => $service_barang]);
    }

    public function store(Request $request)
    {
        //id_nota, id_barang yg 1 nota, id_service, keterangan, jumlah, harga satuan
        DB::beginTransaction();
        try {
            $data = [
                'id_nota' => $request->id_nota,
                'id_barang' => $request->id_barang,
                'update_harga' => $request->jumlah * $request->harga_satuan,
                'type' => 'add'
            ];
            OrderService::updateNota($data);
            ServiceBarang::create($request->all());
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    public function storeOrder(Request $request)
    {
        //id_member?, id_kupon?, nama_pelanggan, no_telepon_pelanggan, alamat_pelanggan, data[][barang], data[][service][][keterangan], data[][service][harga_satuan], data[][service][jumlah]
        DB::beginTransaction();
        try {
            $nota = OrderService::generateNota($request->except('data'));
            $total_harga = 0;
            foreach ($request->data as $key => $value) {
                $barang = Barang::create([
                    'nama' => $value['barang']
                ]);
                foreach ($value['service'] as $k => $v) {
                    $service = Service::where('id', $v['id_service'])->select('id', 'nama', 'harga_minimal', 'harga_maksimal')->first();
                    if ($service->harga_minimal <= $v['harga_satuan'] && $v['harga_satuan'] <= $service->harga_maksimal) {
                        $total_harga += $v['jumlah'] * $v['harga_satuan'];
                        $data = [
                            'id_nota' => $nota['id'],
                            'id_barang' => $barang->id,
                            'id_service' => $v['id_service'],
                            'keterangan' => $v['keterangan'],
                            'jumlah' => $v['jumlah'],
                            'harga_satuan' => $v['harga_satuan']
                        ];
                        ServiceBarang::create($data);
                    } else {
                        throw new \Exception('Service '.$service->nama.' harganya tidak sesuai range');
                    }
                }
            }
            NotaService::where('id', $nota['id'])->update(['total_harga' => $total_harga - $nota['potongan_harga']]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
    
    public function updateStatus(Request $request, $id = null)
    {
        switch ($request->status) {
            case 'proses':
                $service_barang = ServiceBarang::where('id', $request->id_service_barang)->first();
                $service_barang->update(['status_pengerjaan' => 'proses', 'id_mekanik' => $request->id_mekanik, 'tanggal_proses' => date('Y-m-d H:i:s')]);
            break;
            case 'cancel':
                    $service_barang = ServiceBarang::where('id', $id)->first();
                    $service_barang->update(['status_pengerjaan' => 'cancel']);
                    $data = [
                        'id_nota' => $service_barang->id_nota,
                        'update_harga' => $service_barang->harga_satuan * $service_barang->jumlah,
                        'type' => 'remove'
                    ];
                    OrderService::updateNota($data);
                break;
            default:
                abort(422);
                break;
        }
    }

    public function updateProgres(Request $request)
    {
        //status_pengerjaan + keterangan
        $service_barang = ServiceBarang::where('id', $request->id_service_barang)->first();
        if ($request->status_pengerjaan == 'proses') {
            $service_barang->update(['tanggal_proses' => date('Y-m-d H:i:s')]);
        } elseif ($request->status_pengerjaan == 'selesai') {
            $service_barang->update(['tanggal_selesai' => date('Y-m-d H:i:s')]);
        }
        $service_barang->update($request->except('id_service_barang'));
    }

    public function listBarangByNota(Request $request)
    {
        $service_barang = ServiceBarang::with('barang_nota')->where('id_nota', $request->id_nota)->first();
        return response()->json(['data' => $service_barang->barang_nota]);
    }

    public function listNotaService(Request $request)
    {
        if ($request->q) {
            $nota_service = NotaService::where('no_nota', 'like', '%'.$request->q.'%')->get();
        } elseif ($request->no_nota) {
            $nota_service = NotaService::where('no_nota', $request->no_nota)->first();
        } else {
            $nota_service = NotaService::get();
        }
        return response()->json(['data' => $nota_service]);
    }

    public function reportExecution($start_date, $end_date)
    {
        $data = ServiceBarang::with('nota.admin', 'barang', 'service', 'mekanik')
        ->where('status_pengerjaan', 'pending')
        ->orWhere('status_pengerjaan', 'progres')
        ->orWhere('status_pengerjaan', 'selesai')
        ->whereBetween('created_at', [$start_date, $end_date])
        ->get();
        return view('print.execution', compact('data', 'start_date', 'end_date'));
    }

    public function reportCumulative($start_date, $end_date)
    {
        $service_barang = ServiceBarang::select('id', 'id_service', 'id_mekanik', 'created_at')
        ->whereBetween('created_at', [$start_date, $end_date])->get();
        $services = Service::select('id', 'nama')->get();
        $mekaniks = Mekanik::select('id', 'nama')->get();

        $data = [];
        foreach ($services as $service) {
            $data['service'][] = [
                'service' => $service->nama,
                'total' => $service_barang->where('id_service', $service->id)->count()
            ];
        }
        foreach ($mekaniks as $mekanik) {
            $data['mekanik'][] = [
                'mekanik' => $mekanik->nama,
                'total' => $service_barang->where('id_mekanik', $mekanik->id)->count()
            ];
        }
        return view('print.cumulative', compact('data', 'start_date', 'end_date'));
    }
}
