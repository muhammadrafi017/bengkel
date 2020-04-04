@extends('admin.layouts.app')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Daftar Jurusan</h1>
</div>

<div class="card shadow mb-4">
    <!-- Card Header - Dropdown -->
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="mt-2 font-weight-bold text-primary">List</h6>
        <div class="float-right">
            <a href="{{ url('admin/jurusan/form/create') }}" class="btn btn-primary"><i class="fa fa-plus"></i></a>
            <a href="#" class="btn btn-primary refresh-button"><i class="fa fa-sync"></i></a>
        </div>
    </div>
    <!-- Card Body -->
    <div class="card-body">
        <div class="table-responsive">
            <table id="datatable" class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <th>Pengirim</th>
                    <th>Nama</th>
                    <th>Nominal</th>
                    <th>Bukti Pembayaran</th>
                    <th>Status</th>
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
        table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            defaultContent: '-',
            destroy: true,
            ajax: {
                url: '{{ url('admin/datatable/tagihan') }}',
                type:'POST',
            },
            order: [
                [1, "DESC"]
            ],
            columns: [
                { data : 'user.nama_lengkap' },
                { data : 'nama' },
                { data : 'nominal' },
                { data : 'bukti_pembayaran' },
                { data : 'status' },
                { data : 'action' }
            ]
        });
        $(document).on('click', '.konfirmasi-button', function() {
            let content = $(this).data('content');
            let tagihan = $(this).data('tagihan');
            let id = $(this).val();
            let status = $(this).attr('id');
            $.ajax({
                url: content +'/status/'+ id,
                type: 'post',
                data: {
                    status : status,
                    tagihan : tagihan
                },
                beforeSend: function() {
                    Swal.showLoading();
                    $('button').attr('disabled', true);
                },
                success: function(x) {
                    ajaxSuccess(x);
                },
                error: function(x) {
                    ajaxError(x);
                },
                complete: function() {
                    $('button').attr('disabled', false);
                }
            });
        });
    });
</script>
@endpush
