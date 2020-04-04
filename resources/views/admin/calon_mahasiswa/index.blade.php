@extends('admin.layouts.app')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Daftar Calon Mahasiswa</h1>
</div>

<div class="card shadow mb-4">
    <!-- Card Header - Dropdown -->
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="mt-2 font-weight-bold text-primary">List</h6>
        <div class="float-right">
            {{-- <a href="{{ url('admin/peminat/form/create') }}" class="btn btn-primary"><i class="fa fa-plus"></i></a> --}}
            <a href="#" class="btn btn-primary refresh-button"><i class="fa fa-sync"></i></a>
        </div>
    </div>
    <!-- Card Body -->
    <div class="card-body">
        <div class="table-responsive">
            <table id="datatable" class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <th>Gelombang</th>
                    <th>Jurusan</th>
                    <th>Level</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Tanggal lahir</th>
                    <th>Tempat lahir</th>
                    <th>Status Tes Masuk</th>
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
                url: '{{ url('admin/datatable/calon-mahasiswa') }}',
                type:'POST',
            },
            order: [
                [1, "DESC"]
            ],
            columns: [
                { data : 'gelombang.nama' },
                { data : 'jurusan.nama' },
                { data : 'jurusan.level' },
                { data : 'nama_lengkap' },
                { data : 'alamat' },
                { data : 'tanggal_lahir' },
                { data : 'tempat_lahir' },
                { data : 'tes.status' },
                { data : 'action' }
            ]
        });
        $(document).on('click', '.periksa-button', function() {
            let status;
            let content = $(this).data('content');
            let id = $(this).val();
            let element_id = $(this).attr('id');
            if (element_id == 'lulus') {
                status = 'lulus';
            } else {
                status = 'tidak-lulus';
            }
            $.ajax({
                url: content +'/status-tes/'+ id,
                type: 'post',
                data: {
                    status : status
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
