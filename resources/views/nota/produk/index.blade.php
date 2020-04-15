@extends('layouts.app')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Daftar Nota Produk</h1>
</div>

<div class="card shadow mb-4">
    <!-- Card Header - Dropdown -->
    <div class="card-header py-3">
        <div class="row">
            <div class="col-5">
                <h6 class="mt-2 font-weight-bold text-primary">List</h6>
            </div>
            <div class="col-5">
                <div class="input-group">
                    <input type="date" id="start_date" class="form-control date" value="{{ date('Y-m-d', strtotime('-30 days')) }}" placeholder="Tanggal awal" autocomplete="off">
                    <span class="input-group-text" id="basic-addon1">TO</span>
                    <input type="date" id="end_date" class="form-control date" value="{{ date('Y-m-d', strtotime('+1 days')) }}" placeholder="Tanggal akhir" autocomplete="off">
                </div>
            </div>
            <div class="col-2">
                <a href="#" class="btn btn-primary refresh-button"><i class="fa fa-sync"></i></a>
                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-print"></i>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a id="earning" class="dropdown-item report">Laporan pendapatan</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Card Body -->
    <div class="card-body">
        <div class="table-responsive">
            <table id="datatable" class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <th>Oleh</th>
                    <th>No nota</th>
                    <th>Nama pelanggan</th>
                    <th>Kontak pelanggan</th>
                    <th>Alamat pelanggan</th>
                    <th>Potongan harga</th>
                    <th>Total harga</th>
                    <th>Status pembayaran</th>
                    <th>Tgl pembayaran</th>
                    <th>Status pengambilan</th>
                    <th>Tgl pengambilan</th>
                    <th>Metode</th>
                    <th>Aksi</th>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection


@push('js')
<script>
    $(document).ready(function() {
        $('.date').on('change', function() {
            let start_date = $('#start_date').val();
            let end_date = $('#end_date').val();
            if (start_date < end_date) {
                generateTable();
            } else {
                Swal.fire({
                    type: 'error',
                    title: 'Oops..',
                    text: 'Tanggal mulai harus lebih kecil dari tanggal selesai'
                });
            }
        });
        $(document).on('click', '.payment-button', function() {
            let id = $(this).val();
            $.ajax({
                url: '{{ url('nota/produk/payment') }}/' + id,
                type:'post',
                beforeSend: function() {
                    $('button').prop('disabled', true);
                }, success: function(x) {
                    ajaxSuccess(x);
                }, error: function(x, e) {
                    ajaxError(x, e);
                }
            });
        });
        $(document).on('click', '.take-button', function() {
            let id = $(this).val();
            $.ajax({
                url: '{{ url('nota/produk/taking') }}/' + id,
                type:'post',
                beforeSend: function() {
                    $('button').prop('disabled', true);
                }, success: function(x) {
                    ajaxSuccess(x);
                }, error: function(x, e) {
                    ajaxError(x, e);
                }
            });
        });
        $('.report').on('click', function() {
            let start_date = $('#start_date').val();
            let end_date = $('#end_date').val();
            if (start_date <= end_date) {
                let content = $(this).attr('id');
                window.open('{{ url('nota/produk/report') }}/'+ content +'/'+ start_date +'/'+ end_date);
            } else {
                Swal.fire({
                    type: 'error',
                    title: 'Oops..',
                    text: 'Tanggal mulai harus lebih kecil dari tanggal selesai'
                });
            }
        })
        function generateTable() {
            table = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                defaultContent: '-',
                destroy: true,
                ajax: {
                    url: '{{ url('datatable/nota-produk') }}',
                    type:'POST',
                    data:function(d) {
                        d.start_date = $('#start_date').val();
                        d.end_date = $('#end_date').val();
                    }
                },
                order: [
                    [1, "DESC"]
                ],
                columns: [
                    {data: 'admin.nama'},
                    {data: 'no_nota'},
                    {data: 'nama_pelanggan'},
                    {data: 'no_handphone_pelanggan'},
                    {data: 'alamat_pelanggan'},
                    {data: 'potongan_harga'},
                    {data: 'total_harga'},
                    {data: 'status_pembayaran'},
                    {data: 'tanggal_pembayaran'},
                    {data: 'status_pengambilan'},
                    {data: 'tanggal_pengambilan'},
                    {data: 'metode'},
                    {data: 'action', orderable : false, searchable : false},
                ]
            });
        }
        generateTable();
    });
</script>
@endpush
