<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

use App\User;
use App\Kupon;
use App\Produk;
use App\Service;
use App\Mekanik;
use App\NotaService;
use App\ServiceBarang;

class DatatableController extends Controller
{
    public function user(DataTables $datatables)
    {
        $data = User::get();
        return $datatables->of($data)
        ->addColumn('actor', function($data) {
            if ($data->is_owner) {
                return 'Owner';
            } elseif ($data->is_admin) {
                return 'Admin';
            } else {
                return 'Member';
            }
        })
        ->make(true);
    }

    public function kupon(DataTables $datatables)
    {
        $data = Kupon::get();
        return $datatables->of($data)
        ->addColumn('action', function($data) {
            return '<a href="'.url('kupon/form/edit/'.$data->id).'" class="btn btn-info edit-button"><i class="fa fa-edit"></i></a>
            <button value="'.$data->id.'" data-content="'.url('kupon').'" class="btn btn-warning delete-button"><i class="fa fa-trash"></i></button>';
        })
        ->make(true);
    }

    public function produk(DataTables $datatables)
    {
        $data = Produk::get();
        return $datatables->of($data)
        ->editColumn('foto_produk', function($data) {
            if ($data->foto_produk) {
                return '<a href="'. Storage::url('produk/'.$data->foto_produk).'" target="_blank">'.$data->foto_produk.'</a>';
            }
        })
        ->addColumn('action', function($data) {
            return '<a href="'.url('produk/form/edit/'.$data->id).'" class="btn btn-info edit-button"><i class="fa fa-edit"></i></a>
            <button value="'.$data->id.'" data-content="'.url('produk').'" class="btn btn-warning delete-button"><i class="fa fa-trash"></i></button>';
        })
        ->rawColumns(['foto_produk', 'action'])
        ->make(true);
    }

    public function produkTransaksi(DataTables $datatables)
    {
        $data = Produk::get();
        return $datatables->of($data)
        ->editColumn('foto_produk', function($data) {
            return '<img class="img-fluid" src="'.Storage::url('produk/'.$data->foto_produk).'"></img>';
        })
        ->addColumn('action', function($data) {
            return '-';
        })
        ->rawColumns(['foto_produk', 'action'])
        ->make(true);
    }

    public function service(DataTables $datatables)
    {
        $data = Service::get();
        return $datatables->of($data)
        ->addColumn('action', function($data) {
            return '<a href="'.url('service/form/edit/'.$data->id).'" class="btn btn-info edit-button"><i class="fa fa-edit"></i></a>
            <button value="'.$data->id.'" data-content="'.url('service').'" class="btn btn-warning delete-button"><i class="fa fa-trash"></i></button>';
        })
        ->make(true);
    }
    
    public function mekanik(DataTables $datatables)
    {
        $data = Mekanik::get();
        return $datatables->of($data)
        ->addColumn('action', function($data) {
            return '<a href="'.url('mekanik/form/edit/'.$data->id).'" class="btn btn-info edit-button"><i class="fa fa-edit"></i></a>
            <button value="'.$data->id.'" data-content="'.url('mekanik').'" class="btn btn-warning delete-button"><i class="fa fa-trash"></i></button>';
        })
        ->make(true);
    }

    public function serviceBarang(DataTables $datatables, Request $request)
    {
        $data = ServiceBarang::with('nota.admin', 'barang', 'service', 'mekanik')->whereBetween('created_at', [$request->start_date, $request->end_date])->get();
        return $datatables->of($data)
        ->addColumn('action', function($data) {
            $button = '';
            if ($data->status_pengerjaan == 'pending') {
                $button = '<div class="btn-group" role="group" aria-label="Action Button">
                    <button id="proses" value="'.$data->id.'"  data-content="'.url('service-barang').'" class="btn btn-sm btn-info service-button"><i class="fa fa-check-circle"></i> </button>
                    <button id="cancel" value="'.$data->id.'"  data-content="'.url('service-barang').'" class="btn btn-sm btn-danger service-button"><i class="fa fa-ban"></i></button>
                </div>';
            } elseif ($data->status_pengerjaan == 'selesai' || $data->status_pengerjaan == 'cancel') {
                $button = null;
            } else {
                $button = '<button id="progres" value="'.$data->id.'"  data-content="'.url('service-barang').'" class="btn btn-sm btn-warning progres-button"><i class="fa fa-edit"></i> </button>';
            }
            return $button;
        })
        ->editColumn('mekanik.nama', function($data) {
            if ($data->mekanik) {
                return $data->mekanik->nama;
            } else {
                return '-';
            }
        })
        ->editColumn('status_pengerjaan', function($data) {
            switch ($data->status_pengerjaan) {
                case 'cancel':
                    return '<h6><span class="badge badge-danger">'. ucfirst($data->status_pengerjaan) .'</span></h6>';
                    break;
                case 'pending':
                    return '<h6><span class="badge badge-dark">'. ucfirst($data->status_pengerjaan) .'</span></h6>';
                    break;
                case 'proses':
                    return '<h6><span class="badge badge-info">'. ucfirst($data->status_pengerjaan) .'</span></h6>';
                    break;
                case 'masalah':
                    return '<h6><span class="badge badge-warning">'. ucfirst($data->status_pengerjaan) .'</span></h6>';
                    break;
                default:
                    return '<h6><span class="badge badge-success">'. ucfirst($data->status_pengerjaan) .'</span></h6>';
                    break;
            }
        })
        ->rawColumns(['status_pengerjaan', 'action'])
        ->make(true);
    }

    public function notaService(Datatables $datatable, Request $request)
    {
        $data = NotaService::with('admin', 'serviceBarang')->whereBetween('created_at', [$request->start_date, $request->end_date])->get();
        return $datatable->of($data)
        ->editColumn('potongan_harga', function($data) {
            return number_format($data->potongan_harga, 0, '.', '.');
        })
        ->editColumn('total_harga', function($data) {
            return number_format($data->total_harga, 0, '.', '.');
        })
        ->addColumn('service_selesai', function($data) {
            return $data->serviceBarang->where('status_pengerjaan', 'selesai')->count().'/'.$data->serviceBarang->where('status_pengerjaan', '!=', 'cancel')->count();
        })
        ->editColumn('status_pembayaran', function($data) {
            $selesai = $data->serviceBarang->where('status_pengerjaan', 'selesai')->count();
            $total = $data->serviceBarang->where('status_pengerjaan', '!=', 'cancel')->count();
            if ($selesai == 0 && $total == 0) {
                return '<h6><span class="badge badge-danger">Cancel</span></h6>';
            }
            if ($data->status_pembayaran == 'belum-lunas') {
                return '<h6><span class="badge badge-warning">'. str_replace('-',' ',ucfirst($data->status_pembayaran)) .'</span></h6>';
            }
            return '<h6><span class="badge badge-success">'. str_replace('-',' ',ucfirst($data->status_pembayaran)) .'</span></h6>';
        })

        ->editColumn('status_pengambilan', function($data) {
            $selesai = $data->serviceBarang->where('status_pengerjaan', 'selesai')->count();
            $total = $data->serviceBarang->where('status_pengerjaan', '!=', 'cancel')->count();
            if ($selesai == 0 && $total == 0) {
                return '<h6><span class="badge badge-danger">Cancel</span></h6>';
            }
            if ($data->status_pengambilan == 'belum-ambil') {
                return '<h6><span class="badge badge-warning">'. str_replace('-',' ',ucfirst($data->status_pengambilan)) .'</span></h6>';
            }
            return '<h6><span class="badge badge-success">'. str_replace('-',' ',ucfirst($data->status_pengambilan)) .'</span></h6>';
        })
        ->editColumn('tanggal_pembayaran', function($data) {
            if ($data->tanggal_pembayaran) {
                return date('d-m-Y H:i:s', strtotime($data->tanggal_pembayaran));
            }
            return '-';
        })
        ->editColumn('tanggal_pengambilan', function($data) {
            if ($data->tanggal_pengambilan) {
                return date('d-m-Y H:i:s', strtotime($data->tanggal_pengambilan));
            }
            return '-';
        })
        ->addColumn('action', function($data) {
            $selesai = $data->serviceBarang->where('status_pengerjaan', 'selesai')->count();
            $total = $data->serviceBarang->where('status_pengerjaan', '!=', 'cancel')->count();
            $button = '<div class="btn-group" role="group" aria-label="Action Button">';
            if ($selesai == 0 && $total == 0) {
                return '-';
            }
            if ($data->status_pembayaran == 'belum-lunas') {
                $button .= '<button id="payment" value="'.$data->id.'"  class="btn btn-sm btn-success payment-button"><i class="fa fa-money-bill"></i> </button>';
            }
            $button .= '<a id="print-button" href="'.url('nota/service/print').'/'.$data->id.'" target="_blank" class="btn btn-info btn-sm print-button"> <i class="fa fa-print"></i> </a>';
            if ($data->status_pembayaran == 'lunas' && $data->status_pengambilan == 'belum-ambil' && $total == $selesai) {
                $button .= '<button id="take" value="'.$data->id.'"  class="btn btn-sm btn-warning take-button"><i class="fa fa-check-circle"></i> </button>';
            }
            $button .= '</div>';
            return $button;
        })
        ->rawColumns(['status_pembayaran', 'status_pengambilan', 'action'])
        ->make(true);
    }
}
