<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Gelombang;
use App\Tagihan;
use App\CalonMahasiswa;
use App\TesCalonMahasiswa;

class CalonMahasiswaController extends Controller
{
    public function index()
    {
        return view('admin.calon_mahasiswa.index');
    }

    public function formulir()
    {
        $gelombang = Gelombang::where('tanggal_mulai', '<=', date('Y-m-d'))->where('tanggal_selesai', '>=', date('Y-m-d'))->first();
        return view('admin.calon_mahasiswa.formulir', compact('gelombang'));
    }

    public function uploadBuktiBayar(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:png,pdf,jpg,jpeg'
        ]);
        try {
            $filename = 'bukti_bayar_'.strtotime(now()).'.'.$request->file->getClientOriginalExtension();
            $request->file->storeAs('public/bukti_bayar', $filename);
            Tagihan::create([
                'id_user' => auth()->user()->id,
                'nama' => $request->tagihan,
                'nominal' => $request->nominal,
                'bukti_pembayaran' => $filename,
                'status' => 'belum-lunas'
            ]);
        } catch (\Throwable $th) {
            if (method_exists('errors',$th)) {
                $error = $th->errors();
            } else {
                $error = $th->getMessage();
            }
            return response()->json(['error' => $error], 500);
        }
    }

    public function pengisianData(Request $request)
    {
        $this->validate($request, [
            'id_user' => 'required|exists:users,id',
            'id_gelombang' => 'required|exists:gelombang,id',
            'id_jurusan' => 'required|exists:jurusan,id',
            'nama_lengkap' => 'required',
            'alamat' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
        ]);
        $calonMahasiswa = CalonMahasiswa::create($request->except('tanggal_tes'));
        User::where('id', $request->id_user)->update(['posisi' => 'pengisian-data']);
        TesCalonMahasiswa::create([
            'id_calon_mahasiswa' => $calonMahasiswa->id,
            'tanggal_tes' => $request->tanggal_tes,
            'status' => 'belum-diperiksa'
        ]);
    }

    public function statusTes(Request $request, $id)
    {
        $tes = TesCalonMahasiswa::with('calonMahasiswa')->where('id', $id)->first();
        if ($request->status == 'lulus') {
            User::where('id', $tes->calonMahasiswa->user->id)->update(['posisi' => 'tes-masuk']);
            $tes->update(['status' => 'lulus']);
        } else {
            User::where('id', $tes->calonMahasiswa->user->id)->update(['posisi' => '-']);
            $tes->update(['status' => 'tidak-lulus']);
        }
    }
}
