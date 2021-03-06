<?php

namespace App\Service;

use App\User;
use App\Kupon;
use App\NotaService;

class OrderService
{
    public static function claimKupon($id_member, $id_kupon)
    {
        $member = User::where('id', $id_member)->first();
        $kupon = Kupon::where('id', $id_kupon)->first();

        $member->update(['point' => $member->point - $kupon->point]);
        $kupon->update(['kuantitas' => $kupon->kuantitas - 1]);

        $data = [
            'id_kupon' => $kupon->id,
            'potongan_harga' => $kupon->potongan
        ];
        return $data;
    }

    public static function generateNota($data)
    {
        $nota = NotaService::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->count();
        $number = sprintf('%04d', $nota + 1).'/'.(date('m')).'/'.date('Y');
        $kupon = null;
        if ($data['id_kupon']) {
            $kupon = OrderService::claimKupon($data['id_member'], $data['id_kupon']);
        }
        $nota_data = [
            'no_nota' => $number,
            'id_admin' => auth()->user()->id,
            'id_member' => $data['id_member'],
            'id_kupon' => $kupon? $kupon['id_kupon'] : null,
            'nama_pelanggan' => $data['nama_pelanggan'],
            'no_handphone_pelanggan' => $data['no_handphone_pelanggan'],
            'alamat_pelanggan' => $data['alamat_pelanggan'],
            'potongan_harga' => $kupon? $kupon['potongan_harga'] : 0
        ];
        $nota = NotaService::create($nota_data);
        return ['id' => $nota->id, 'potongan_harga' => $nota->potongan_harga];
    }

    public static function updateNota($data)
    {
        $nota = NotaService::where('id', $data['id_nota'])->first();
        switch ($data['type']) {
            case 'add':
                $nota->update(['total_harga' => $nota->total_harga + $data['update_harga']]);
                break;
            case 'remove':
                $nota->update(['total_harga' => $nota->total_harga - $data['update_harga']]);
                break;
        }
    }
}
