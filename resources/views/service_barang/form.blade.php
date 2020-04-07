@extends('layouts.app')

@section('content')

<meta name="base_url" content="{{ url('mekanik') }}">

<div class="row">
    <div class="col-md-8">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="mt-2 font-weight-bold text-primary">
                    Form Servis
                </h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <form id="form" action=" {{ url('service-barang/store') }}">
                    <div class="row">
                        <div class="form-group col-12">
                            <label for="">Pilih Nota</label>
                            <select class="form-control" name="id_nota" id="select-nota-service"></select>
                        </div>
                        <div class="form-group col-12">
                            <label for="">Pilih Barang</label>
                            <select class="form-control" name="id_barang" id="select-barang" disabled></select>
                        </div>
                        <div class="form-group col-12">
                            <label for="">Pilih Service</label>
                            <select class="form-control" name="id_service" id="select-service"></select>
                        </div>
                        <div class="form-group col-12">
                            <label for="">Range Harga</label>
                            <input type="text" class="form-control" id="range-harga" readonly>
                        </div>
                        <div class="form-group col-12">
                            <label for="">Harga satuan</label>
                            <input type="text" class="form-control" name="harga_satuan" id="">
                        </div>
                        <div class="form-group col-12">
                            <label for="">Jumlah</label>
                            <input type="text" class="form-control" name="jumlah" id="">
                        </div>
                        <div class="form-group col-12">
                            <label for="">Keterangan</label>
                            <input type="text" class="form-control" name="keterangan" id="">
                        </div>
                    </div>
                    <button class="btn btn-primary btn-block submit">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            let nota_service_return = function (data) {
                return {
                    results: $.map(data.data, function(item) {
                        return {
                            text: item.no_nota,
                            id: item.id
                        }
                    })
                }
            }
            let barang_param = function(params) {
                return {
                    id_nota : $('#select-nota-service').val()
                };
            }
            select2Generator('#select-nota-service', '{{ url('service-barang/nota/list') }}', '', null, nota_service_return);
            select2Generator('#select-service', '{{ url('service/list') }}');
            $('#select-nota-service').on('change', function() {
                $('#select-barang').attr('disabled', false);
                select2Generator('#select-barang', '{{ url('service-barang/barang/list-by-nota') }}', '', barang_param);
            });
            $('#select-service').on('change', function() {
                let id = $(this).val();
                $.ajax({
                    url : '{{ url('service/list') }}',
                    type: 'post',
                    data : {
                        id_service : id
                    },
                    success:function(data) {
                        $('#range-harga').val(data.data.harga_minimal+' - '+data.data.harga_maksimal);
                    }
                });
            })
        })
    </script>
@endpush
