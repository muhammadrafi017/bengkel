@extends('layouts.app')

<meta name="base_url" content="{{ url('service-barang/order') }}">

@section('content')
<div class="row">
    <div class="col-3">
        <div class="card shadow mb-4" style="min-height:100%">
            <div class="card-header py-3">
                <div class="row">
                    <h6 class="m-0 font-weight-bold text-primary">Form Member</h6>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <input type="text" class="form-control form-control-sm" placeholder="Kode Member" id="member-input">
                        </div>
                    </div>
                </div>
                <div class="row" id="kupon">
                    <table id="table-coupon" class="table table-striped table-sm col-12">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Kupon</th>
                                <th>Point</th>
                                <th>Potongan</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div id="undraw" class="row">
                    <img src="{{ asset('svg/order-unsplash.jpeg') }}" alt="unsplash">
                </div>
            </div>
        </div>
    </div>
    <div class="col-9">
        <div class="card shadow mb-4" style="min-height:100%">
            <div class="card-header py-3">
                <div class="row">
                    <h6 class="m-0 font-weight-bold text-primary">Form @yield('title')</h6>
                </div>
            </div>
            <div class="card-body">
                <form id="form" action="{{ url('service-barang/store-order') }}">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="member">Nama Pelanggan</label>
                                <input type="text" class="form-control" placeholder="Nama Pelanggan" name="nama_pelanggan" id="nama">
                                <input type="hidden" name="id_member" value="" id="id_member">
                                <input type="hidden" name="id_kupon" value="" id="id_kupon">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="member">Nomor Telepon</label>
                                <input type="text" class="form-control" placeholder="Nomor Telepon" name="no_handphone_pelanggan" id="no_handphone">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="member">Alamat</label>
                                <input type="text" class="form-control" placeholder="Alamat" name="alamat_pelanggan" id="alamat">
                            </div>
                        </div>
                        <div class="col-12">
                            <h5>Input barang <span class="float-right"><button id="order-container" type="button" class="btn btn-primary add" name="button"><i class="fa fa-plus"></i></button></span></h5>
                            <hr>
                            <div class="row order-container">
                                <div id="0" class="col-12 duplicate-item">
                                    <div class="card shadow">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-10">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="data[0][barang]" placeholder="Nama barang">
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <button id="item-container" type="button" class="btn btn-primary add" name="button"><i class="fa fa-plus"></i></button>
                                                </div>
                                                <div class="col-12 row item-container">
                                                    <div id="0" class="col-12 row duplicate-item-service">
                                                        <div class="col-3">
                                                            <div class="form-group">
                                                                <select class="form-control select2" name="data[0][service][0][id_service]"></select>
                                                            </div>
                                                        </div>
                                                        <div class="col-3">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" name="data[0][service][0][jumlah]" placeholder="Jumlah">
                                                            </div>
                                                        </div>
                                                        <div class="col-3">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" name="data[0][service][0][harga_satuan]" placeholder="Harga negosiasi">
                                                                <input type="text" class="form-control range-harga" placeholder="Range harga" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="col-3">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="data[0][service][0][keterangan]" placeholder="Keterangan">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-primary float-right mt-2 submit" id="submit"><i class="fas fa-ticket-alt"></i> Simpan</button>
            </form>
        </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
$(document).ready(function() {
    var item_count = 0;
    var total_item_count = 0;
    var item_service_count = 0;
    var range_harga;
    $(document).on('click', '.add', function(e) {
        let container = $(this).attr('id');
        switch (container) {
            case 'order-container':
                total_item_count++;
                item_count = total_item_count;
                $('.order-container').append('<div id="'+item_count+'" class="col-12 pt-2 duplicate-item">'
                        + '<div class="card shadow">'
                            + '<div class="card-title">'
                                + '<button id="order-container" type="button" class="btn btn-danger float-right remove" name="button"> <i class="fa fa-minus"></i> </button>'
                            + '</div>'
                            + '<div class="card-body">'
                                + '<div class="row">'
                                    + '<div class="col-10">'
                                        + '<div class="form-group">'
                                            + '<input type="text" class="form-control" name="data['+item_count+'][barang]" placeholder="Nama barang">'
                                        + '</div>'
                                    + '</div>'
                                    + '<div class="col-2">'
                                        + '<button id="item-container" type="button" class="btn btn-primary add" name="button"><i class="fa fa-plus"></i></button>'
                                    + '</div>'
                                    + '<div class="col-12 row item-container">'
                                        + '<div class="col-12 row duplicate-item-service">'
                                            + '<div class="col-3">'
                                                + '<div class="form-group">'
                                                    + '<select class="select2 form-control" name="data['+item_count+'][service][0][id_service]"></select>'
                                                    // + '<input type="text" class="form-control range-harga" placeholder="Range harga" disabled>'
                                                + '</div>'
                                            + '</div>'
                                            + '<div class="col-3">'
                                                + '<div class="form-group">'
                                                    + '<input type="text" class="form-control" name="data['+item_count+'][service][0][jumlah]" placeholder="Jumlah">'
                                                + '</div>'
                                            + '</div>'
                                            + '<div class="col-3">'
                                                + '<div class="form-group">'
                                                    + '<input type="text" class="form-control" name="data['+item_count+'][service][0][harga_satuan]" placeholder="Harga negosiasi">'
                                                    + '<input type="text" class="form-control range-harga" placeholder="Range harga" disabled>'
                                                + '</div>'
                                            + '</div>'
                                            + '<div class="col-3">'
                                                + '<div class="input-group">'
                                                    + '<input type="text" class="form-control" name="data['+item_count+'][service][0][keterangan]" placeholder="Keterangan">'
                                                + '</div>'
                                            + '</div>'
                                        + '</div>'
                                    + '</div>'
                                + '</div>'
                            + '</div>'
                        + '</div>'
                    + '</div>');
                initSelect();
            break;
            case 'item-container':
                item_service_count++;
                item_count = $(this).closest('.duplicate-item').attr('id');
                $(this).parent().siblings('.item-container').append('<div id="'+item_service_count+'" class="col-12 row duplicate-item-service">'
                        + '<div class="col-3">'
                            + '<div class="form-group">'
                                + '<select class="select2 form-control" name="data['+item_count+'][service]['+item_service_count+'][id_service]"></select>'
                                // + '<input type="text" class="form-control range-harga" placeholder="Range harga" disabled>'
                            + '</div>'
                        + '</div>'
                        + '<div class="col-3">'
                            + '<div class="form-group">'
                                + '<input type="text" class="form-control" name="data['+item_count+'][service]['+item_service_count+'][jumlah]" placeholder="Jumlah">'
                            + '</div>'
                        + '</div>'
                        + '<div class="col-3">'
                            + '<div class="form-group">'
                                + '<input type="text" class="form-control" name="data['+item_count+'][service]['+item_service_count+'][harga_satuan]" placeholder="Harga negosiasi">'
                                + '<input type="text" class="form-control range-harga" placeholder="Range harga" disabled>'
                            + '</div>'
                        + '</div>'
                        + '<div class="col-3">'
                            + '<div class="input-group">'
                                + '<input type="text" class="form-control" name="data['+item_count+'][service]['+item_service_count+'][keterangan]" placeholder="Keterangan">'
                                {{-- appent > 1 --}}
                                + '<div class="input-group-append">'
                                    + '<button id="item-container" type="button" class="btn btn-danger remove" name="button"> <i class="fa fa-minus"></i> </button>'
                                + '</div>'
                        + '</div>'
                    + '</div>'
                + '</div>');
                initSelect();
            break;

        }
    });
    $(document).on('click', '.remove', function(e) {
        let container = $(this).attr('id');
        switch (container) {
            case 'order-container':
                $(this).closest('.duplicate-item').remove();
                break;
            case 'item-container':
                $(this).closest('.duplicate-item-service').remove();
                break;
        }
    });
    function initSelect() {
        $('.select2').select2({
            placeholder: 'Pilih service',
            width: '100%',
            heigh: '100%',
            ajax: {
                url: '{{ url('service/list') }}',
                type: 'post',
                dataType:'json',
                data: function (params) {
                    return {
                        q : $.trim(params.term)
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data.data, function (item) {
                            return {
                                text: item.nama,
                                id: item.id
                            }
                        })
                    };
                }
            }
        });
    }
    $(document).on('change', '.select2', function(e) {
        alert('jalan');
        let range_harga = $(this).closest('.duplicate-item-service').find('.range-harga');
        let id = $(this).val();
        $.ajax({
            url : '{{ url('service/list') }}',
            type: 'post',
            data : {
                id_service : id
            },
            success:function(data) {
                range_harga.val(data.data.harga_minimal+' - '+data.data.harga_maksimal);
            }
        });
    });
    $('input').val(null).attr('readonly', false);
    $('#kupon').hide();
    function ajaxError(x, e) {
        $('input').attr('readonly', false);
        if (x.responseJSON.message) {
            let errors = '';
            $.each(x.responseJSON.errors, function(i, v) {
                errors += v + '<br>';
            });
            Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: x.responseJSON.message,
                footer: errors
            });
        } else {
            Toast.fire({
              type: 'error',
              title: 'Oops, telah terjadi error, silahkan coba lagi'
            });
        }
    }
    $("#member-input").change(function () {
        $.ajax({
            url: "{{ url('user/find-member') }}",
            type: "POST",
            data: {
                kode_member: $("#member-input").val()
            },
            dataType: "json",
            success: (data) => {
                $('input[name="id_member"]').val(data.data.id);
                $.each(data.data, (i, v) => {
                    $('input[name="'+ i +'_pelanggan"]').val(v).attr('readonly', true);
                });
                $.ajax({
                    url : '{{ url('kupon/list') }}',
                    type: 'post',
                    data : {
                        point_member : data.data.point
                    },
                    success: function(data) {
                        let table_coupon;
                        $.each(data.data, function(key, value) {
                            table_coupon += '<tr>'
                                + '<th>'
                                    + '<div class="form-check">'
                                        + '<input class="form-check-input" type="radio" name="generated-id-coupon" value="'+value.id+'">'
                                    + '</div>'
                                + '</th>'
                                + '<th>'+value.nama+'</th>'
                                + '<th>'+value.point+'</th>'
                                + '<th>'+value.potongan+'</th>'
                            + '</tr>';
                        });
                        $('#kupon').show();
                        $('#table-coupon').append('<tbody class="generated-coupon">'
                            + table_coupon
                        + '</tbody>');
                        $('input[name="generated-id-coupon"]').change(function() {
                            let id_kupon = $(this).val();
                            $('input[name="id_kupon"]').val(id_kupon);
                        });
                        $('#undraw').hide();
                    }
                });
            }, error: function(x, e) {
                ajaxError(x, e);
            }
        });
    });
    initSelect();
});
</script>
@endpush