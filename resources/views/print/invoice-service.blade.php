<!DOCTYPE html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name') }} | Nota - {{ $data->no_nota ? $data->no_nota : '-' }} </title>
    <meta name="description" content="{{ config('app.name') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Load Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet">

    <!-- Load Font Awesome -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" media="all">
    <style media="all">
    body {
        background-color: white;
    }
    .invoice-title h2, .invoice-title h3 {
        display: inline-block;
    }

    .table > tbody > tr > .no-line {
        border-top: none;
    }

    .table > thead > tr > .no-line {
        border-bottom: none;
    }

    .table > tbody > tr > .thick-line {
        border-top: 2px solid;
    }

    .box {
        background-color: white;
        width: 100%;
        border: 3px solid black;
        padding: 5px;
        margin: 2px;
    }
    </style>
    <script src="{{ asset('js/app.js') }}" charset="utf-8"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        window.print();
    });
    </script>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="box">
                <div class="row">
                    <div class="col align-self-center text-center">
                        <img src="{{ asset('logo.jpeg') }}" height="100" width="100">
                        <p><b>MITRA CENTRAL TEKHNIK</b></p>
                        <p class="small">Bubut & Modifikasi Motor</p>
                        <p class="small">Jl. Ciledug Raya No. 5 Petukangan Utara, Jakarta 12260</p>
                        <p class="small">Telp. 0813 8082 4150 - 0813 8220 0507</p>
                    </div>
                    <div class="col-2 align-self-center">
                        Nama : <p>{{ $data->nama_pelanggan ? $data->nama_pelanggan : '-' }}</p>
                        Nomor Telepon : <p>{{ $data->no_telepon_pelanggan ? $data->no_telepon_pelanggan : '-' }}</p>
                        Member : <p>{{ $data->id_member ? 'Member' : 'Tidak' }}</p>
                    </div>
                    <div class="col-2 align-self-center">
                        Kasir : <p>{{ $data->admin->nama ? $data->admin->nama : '-' }}</p>
                        No. Nota : <p>{{ $data->no_nota ? $data->no_nota : '-' }}</p>
                        Tanggal : <p>{{ date('d F Y') }}</p>
                    </div>
                    <div class="col-3 align-self-center">
                        <h2 class="text-uppercase"><b>{{ $data->status_pembayaran ? str_replace('-', ' ', $data->status_pembayaran) : '-' }}</b></h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <br>
                    <div class="row"></div>
                    <br>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-condensed table-sm">
                                <thead>
                                    <tr>
                                        <td>Nama Barang</td>
                                        <td>Service</td>
                                        <td>Biaya</td>
                                        <td>Qty</td>
                                        <td>Sub Total</td>
                                    </tr>
                                </thead>
                                {{-- <tbody>
                                    @foreach ($data->serviceBarang as $key => $value)
                                        <tr>
                                            <td>{{ $value->barang->nama }}</td>
                                            <td>{{ $value->service->nama }}</td>
                                            <td>{{ number_format($value->harga_satuan,0,".",",") }}</td>
                                            <td>{{ number_format($value->jumlah,0,".",",") }}</td>
                                            <td>{{ number_format($value->harga_satuan*$value->jumlah,0,".",",") }}</td>
                                        </tr>
                                    @endforeach
                                <tbody> --}}
                            </table>
                            <table class="table table-condensed table-sm">
                                <tbody>
                                    @if ($data->kupon)
                                        @php
                                        $kupon = $data->kupon->potongan;
                                        $total_harga = $data->total_harga;
                                        $total = number_format($total_harga+$kupon,0,".",",");
                                        @endphp
                                    @else
                                        @php
                                        $total = number_format($data->total_harga,0,".",",");
                                        @endphp
                                    @endif
                                    <tr>
                                        <td class="thick-line" colspan="2"></td>
                                        <td class="thick-line"></td>
                                        <td class="thick-line text-right"></td>
                                    </tr>
                                    <tr>
                                        <td class="no-line" width="75%" colspan="2"></td>
                                        <td class="no-line" width="10%"><strong>Total</strong></td>
                                        <td class="no-line text-right">Rp. {{ $total }}</td>
                                    </tr>
                                    <tr>
                                        <td class="no-line" width="75%" colspan="2"></td>
                                        <td class="no-line" width="10%"><strong>Kupon</strong></td>
                                        <td class="no-line text-right">{{ $data->kupon ? $data->kupon->nama : '-' }} {{ $data->kupon ? number_format($data->kupon->potongan,0,".",",") : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="no-line" width="75%" colspan="2"></td>
                                        <td class="no-line" width="10%"><strong>Grand Total</strong></td>
                                        <td class="no-line text-right">Rp. {{ number_format($data->total_harga, 0, '.', '.') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="box">
                <p class="text-center">Terima kasih telah menggunakan layanan kami.</p>
            </div>
        </div>
    </div>
</body>
</html>
