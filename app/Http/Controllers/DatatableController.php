<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

use App\User;
use App\Gelombang;
use App\KategoriJurusan;
use App\Jurusan;
use App\Peminat;
use App\Tagihan;
use App\CalonMahasiswa;

class DatatableController extends Controller
{
    public function user(DataTables $datatables)
    {
        $user = User::get();
        return $datatables->of($user)
        ->editColumn('created_at', function($data) {
            if ($data->created_at) {
                return Carbon::parse($data->created_at)->format('d-m-Y H:i');
            }
            return '-';
        })
        ->addColumn('group', function($data) {
            if ($data->is_admin) {
                return 'Admin';
            } else {
                return 'User';
            }
        })
        ->editColumn('status', function($data) {
            if ($data->status) {
                return '<label style="width:100%;" class="badge badge-pill badge-success">Aktif</label>';
            } else {
                return '<label style="width:100%;" class="badge badge-pill badge-danger">Tidak aktif</label>';
            }
        })
        ->addColumn('action', function($data) {
            $button = '
                <a href="'.url('admin/user/form/edit/'.$data->id).'" class="btn btn-info edit-button"><i class="fa fa-edit"></i></a>
                <button value="'.$data->id.'" data-content="'.url('admin/user').'" class="btn btn-warning delete-button"><i class="fa fa-trash"></i></button>
            ';
            if ($data->status) {
                $button .= '<button id="disable" value="'.$data->id.'" data-content="'.url('admin/user').'" class="btn btn-danger status-button"><i class="fa fa-ban"></i></button>';
            } else {
                $button .= '<button id="enable" value="'.$data->id.'" data-content="'.url('admin/user').'" class="btn btn-success status-button"><i class="fa fa-check"></i></button>';
            }
            return $button;

        })
        ->rawColumns(['status', 'action'])
        ->make(true);
    }

    public function gelombang(DataTables $datatables)
    {
        $gelombang = Gelombang::get();
        return $datatables->of($gelombang)
        ->addColumn('action', function($data) {
            return '<a href="'.url('admin/gelombang/form/edit/'.$data->id).'" class="btn btn-info edit-button"><i class="fa fa-edit"></i></a>
            <button value="'.$data->id.'" data-content="'.url('admin/gelombang').'" class="btn btn-warning delete-button"><i class="fa fa-trash"></i></button>';
        })
        ->make(true);
    }

    public function kategoriJurusan(DataTables $datatables)
    {
        $kategori_jurusan = KategoriJurusan::get();
        return $datatables->of($kategori_jurusan)
        ->addColumn('action', function($data) {
            return '<a href="'.url('admin/kategori-jurusan/form/edit/'.$data->id).'" class="btn btn-info edit-button"><i class="fa fa-edit"></i></a>
            <button value="'.$data->id.'" data-content="'.url('admin/kategori-jurusan').'" class="btn btn-warning delete-button"><i class="fa fa-trash"></i></button>';
        })
        ->make(true);
    }

    public function jurusan(DataTables $datatables)
    {
        $jurusan = Jurusan::with('kategoriJurusan')->get();
        return $datatables->of($jurusan)
        ->addColumn('action', function($data) {
            return '<a href="'.url('admin/jurusan/form/edit/'.$data->id).'" class="btn btn-info edit-button"><i class="fa fa-edit"></i></a>
            <button value="'.$data->id.'" data-content="'.url('admin/jurusan').'" class="btn btn-warning delete-button"><i class="fa fa-trash"></i></button>';
        })
        ->make(true);
    }

    public function peminat(DataTables $datatables)
    {
        $peminat = Peminat::with('user')->get();
        return $datatables->of($peminat)
        ->editColumn('status', function($data) {
            if ($data->status == 'belum-follow-up') {
                return '<label style="width:100%;" class="badge badge-pill badge-danger">Belum Follow Up</label>';
            } else {
                return '<label style="width:100%;" class="badge badge-pill badge-success">Sudah Follow Up</label>';
            }
        })
        ->addColumn('action', function($data) {
            $button = '
                <a href="'.url('admin/peminat/form/edit/'.$data->id).'" class="btn btn-info edit-button"><i class="fa fa-edit"></i></a>
                <button value="'.$data->id.'" data-content="'.url('admin/peminat').'" class="btn btn-warning delete-button"><i class="fa fa-trash"></i></button>
            ';
            if ($data->status == 'belum-follow-up') {
                $button .= '<button id="sudah-follow-up" value="'.$data->id.'" data-content="'.url('admin/peminat').'" class="btn btn-success follow-up-button"><i class="fa fa-check"></i></button>';
            } else {
                $button .= '<button id="belum-follow-up" value="'.$data->id.'" data-content="'.url('admin/peminat').'" class="btn btn-danger follow-up-button"><i class="fa fa-ban"></i></button>';
            }
            return $button;
        })
        ->rawColumns(['status', 'action'])
        ->make(true);
    }

    public function tagihan(DataTables $datatables)
    {
        $tagihan = Tagihan::with('user')->get();
        return $datatables->of($tagihan)
        ->editColumn('bukti_pembayaran', function($data) {
            return '<a href="'.Storage::url('public/bukti_bayar/'.$data->bukti_pembayaran).'" target="_blank">'.$data->bukti_pembayaran.'</a>';
        })
        ->editColumn('status', function($data) {
            if ($data->status == 'belum-lunas') {
                return '<label style="width:100%;" class="badge badge-pill badge-danger">Belum Lunas</label>';
            } else {
                return '<label style="width:100%;" class="badge badge-pill badge-success">Lunas</label>';
            }
        })
        ->addColumn('action', function($data) {
            if ($data->status != 'lunas') {
                return '<button id="lunas" value="'.$data->id.'" data-content="'.url('admin/tagihan').'" data-tagihan="'.$data->nama.'" class="btn btn-success konfirmasi-button"><i class="fa fa-check"></i></button>
                <button id="tolak" value="'.$data->id.'" data-content="'.url('admin/tagihan').'" data-tagihan="'.$data->nama.'" class="btn btn-danger konfirmasi-button"><i class="fa fa-ban"></i></button>';
            }
        })
        ->rawColumns(['bukti_pembayaran', 'status', 'action'])
        ->make(true);
    }

    public function calonMahasiswa(DataTables $datatables)
    {
        $calonMahasiswa = CalonMahasiswa::with('gelombang', 'jurusan', 'tes')->get();
        return $datatables->of($calonMahasiswa)
        ->editColumn('tes.status', function($data) {
            if ($data->tes->status == 'belum-diperiksa') {
                return '<label style="width:100%;" class="badge badge-pill badge-warning">Belum Diperiksa</label>';
            } elseif ($data->tes->status == 'lulus') {
                return '<label style="width:100%;" class="badge badge-pill badge-success">Lulus</label>';
            } else {
                return '<label style="width:100%;" class="badge badge-pill badge-danger">Tidak Lulus</label>';
            }
        })
        ->addColumn('action', function($data) {
            if ($data->tes->status == 'belum-diperiksa') {
                return '<button id="lulus" value="'.$data->tes->id.'" data-content="'.url('admin/calon-mahasiswa').'" class="btn btn-success periksa-button"><i class="fa fa-check"></i></button>
                <button id="tidak-lulus" value="'.$data->tes->id.'" data-content="'.url('admin/calon-mahasiswa').'" class="btn btn-danger periksa-button"><i class="fa fa-ban"></i></button>';
            }
        })
        ->rawColumns(['tes.status', 'action'])
        ->make(true);
    }


}
