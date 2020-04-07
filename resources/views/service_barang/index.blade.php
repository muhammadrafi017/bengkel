@extends('layouts.app')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Daftar Service Barang</h1>
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
                <a href=" {{ url('service-barang/form/create') }} " class="btn btn-primary"><i class="fa fa-plus"></i></a>
                <a href="#" class="btn btn-primary refresh-button"><i class="fa fa-sync"></i></a>
                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-print"></i>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a id="execution" class="dropdown-item report">Laporan pengerjaan</a>
                    <a id="cumulative" class="dropdown-item report">Laporan kumulatif</a>
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
                    <th>No Nota</th>
                    <th>Barang</th>
                    <th>Service</th>
                    <th>Jumlah</th>
                    <th>Mekanik</th>
                    <th>Keterangan</th>
                    <th>Proses</th>
                    <th>Selesai</th>
                    <th>Pengerjaan</th>
                    <th>Aksi</th>
                </thead>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-status" role="dialog" aria-labelledby="modal-label">
    <div class="modal-dialog" role="document">
        <form id="form" action="{{ url('service-barang/status') }}">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-label">Pilih mekanik</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body" id="coba">
                    <input id="id_service_barang" type="hidden" name="id_service_barang">
                    <input type="hidden" name="status" value="proses">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="">Mekanik</label>
                                <select id="select-mekanik" class="form-control" name="id_mekanik"></select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary submit">Submit</button>
                </div>
            </div>
        </form>
     </div>
</div>
<div class="modal fade" id="modal-progres" role="dialog" aria-labelledby="modal-label">
    <div class="modal-dialog" role="document">
        <form id="form" action="{{ url('service-barang/progres') }}">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-label">Perkembangan Pengerjaan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body" id="coba">
                    <div class="row">
                        <input id="id_service_barang" type="hidden" name="id_service_barang">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="">Status pengerjaan</label>
                                <select class="form-control select2plain" name="status_pengerjaan">
                                    <option value="proses">Proses</option>
                                    <option value="masalah">Masalah</option>
                                    <option value="selesai">Selesai</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="">Keterangan</label>
                                <input type="text" class="form-control" name="keterangan">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary submit">Submit</button>
                </div>
            </div>
        </form>
     </div>
</div>
@endsection


@push('js')
<script>
    $(document).ready(function() {
        select2Generator('#select-mekanik', '{{ url('mekanik/list') }}');
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
        $('.report').click(function() {
            let start_date = $('#start_date').val();
            let end_date = $('#end_date').val();
            if (start_date && end_date) {
                if (start_date <= end_date) {
                    let content = $(this).attr('id');
                    window.open('{{ url('service-barang/report') }}/'+ content +'/'+ start_date +'/'+ end_date);
                } else {
                    Swal.fire({
                        type: 'error',
                        title: 'Oops..',
                        text: 'Tanggal mulai harus lebih kecil atau sama dengan tanggal selesai'
                    });
                }
            }
        });
        $(document).on('click', '.service-button', function() {
            let content = $(this).data('content');
            let id = $(this).val();
            let status = $(this).attr('id');
            if (status == 'proses') {
                $('#id_service_barang').val(id);
                $('#modal-status').modal('toggle');
            } else {
                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Lanjutkan mengkonfirmasi?',
                    type: "warning",
                })
                .then((willUpdate) => {
                    if (willUpdate) {
                        $.ajax({
                            url : content + '/status/' + id,
                            type: 'post',
                            data: {
                                status : status
                            },
                            success:function(x) {
                                ajaxSuccess(x)
                            },
                            error:function(x, e) {
                                ajaxError(x, e)
                            }
                        });
                    }
                });
            }
        });
        $(document).on('click', '.progres-button', function() {
            let id = $(this).val();
            $.ajax({
                url : "{{ url('service-barang/list') }}",
                type:'post',
                data: {
                    id : id
                },
                success:function(data) {
                    $('#id_service_barang').val(id);
                    $('#modal-progres').modal('toggle');

                    $('#modal-progres').find('select[name="status_pengerjaan"]').val(data.data.status_pengerjaan);
                    $('#modal-progres').find('input[name="id_service_barang"]').val(data.data.id);
                    $('#modal-progres').find('input[name="keterangan"]').val(data.data.keterangan);
                }
            })
        });
        function generateTable() {
            table = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                defaultContent: '-',
                destroy: true,
                ajax: {
                    url: '{{ url('datatable/service-barang') }}',
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
                    { data : 'nota.admin.nama' },
                    { data : 'nota.no_nota' },
                    { data : 'barang.nama' },
                    { data : 'service.nama' },
                    { data : 'jumlah' },
                    { data : 'mekanik.nama' },
                    { data : 'keterangan' },
                    { data : 'tanggal_proses' },
                    { data : 'tanggal_selesai' },
                    { data : 'status_pengerjaan' },
                    { data : 'action' },
                ]
            });
        }
        generateTable();
    });
</script>
@endpush
