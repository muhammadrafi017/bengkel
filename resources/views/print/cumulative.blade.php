<!DOCTYPE html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name') }} | Laporan Kumulatif {{ date('d-m-Y', strtotime($start_date)) }} sampai {{ date('d-m-Y', strtotime($end_date)) }} </title>
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
                <div class="row text-center">
                    <div class="col-5 align-self-center text-center">
                        <img src="{{ asset('logo.jpeg') }}" height="100" width="100">
                        <p><b>MITRA CENTRAL TEKHNIK</b></p>
                        <p class="small">Bubut & Modifikasi Motor</p>
                        <p class="small">Jl. Ciledug Raya No. 5 Petukangan Utara, Jakarta 12260</p>
                        <p class="small">Telp. 0813 8082 4150 - 0813 8220 0507</p>
                    </div>
                    <div class="col align-self-center">
                        <h3>Laporan Kumulatif</h3>
                        <p>Periode</p>
                        <p>{{ date('d-m-Y', strtotime($start_date)) }} sampai {{ date('d-m-Y', strtotime($end_date)) }}</p>
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
                            <h3 class="text-center">Mekanik</h3>
                            <table class="table table-condensed table-sm">
                                <thead>
                                    <tr>
                                        <th style="width:10%">Mekanik</th>
                                        <th style="width:10%">Jumlah Service</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data['mekanik'] as $data_mekanik)
                                        <tr>
                                            <td>{{ $data_mekanik['mekanik'] }}</td>
                                            <td>{{ $data_mekanik['total'] }}</td>
                                        </tr>
                                    @endforeach
                                <tbody>
                            </table>
                        </div>
                        <div class="table-responsive">
                            <h3 class="text-center">Service</h3>
                            <table class="table table-condensed table-sm">
                                <thead>
                                    <tr>
                                        <th style="width:10%">Service</th>
                                        <th style="width:10%">Jumlah Service</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data['service'] as $data_service)
                                        <tr>
                                            <td>{{ $data_service['service'] }}</td>
                                            <td>{{ $data_service['total'] }}</td>
                                        </tr>
                                    @endforeach
                                <tbody>
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
