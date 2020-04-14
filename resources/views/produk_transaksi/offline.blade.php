@extends('layouts.app')

<meta name="base_url" content="{{ url('produk/transaction/offline') }}">

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
                        <div class="col-8">
                            <div class="card" style="border:none;">
                                <h6 class="mt-2 font-weight-bold text-primary">
                                    Daftar Produk
                                </h6>
                                <div class="table-responsive">
                                    <table id="datatable" class="table table-bordered" width="100%" cellspacing="0">
                                        <thead>
                                            <th>Gambar Produk</th>
                                            <th>Nama</th>
                                            <th>Kuantitas</th>
                                            <th>Harga Satuan</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card" style="border:none;">
                                <h6 class="mt-2 font-weight-bold text-primary">
                                    Keranjang
                                </h6>
                                <div class="row produk-cart">
                                </div>
                                {{-- <div class="card-footer"> --}}
                                    <h6 class="mt-2 font-weight-bold text-primary">
                                        Total
                                        <p class="float-right" id="total-harga">0</p>
                                    </h6>
                                    <button type="button" class="btn btn-primary btn-block mt-2 submit" id="submit"><i class="fas fa-ticket-alt"></i> Simpan</button>
                                {{-- </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </form>
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
            scrollY: '50vh',
            scrollCollapse: true,
            ajax: {
                url: '{{ url('datatable/produk-transaksi') }}',
                type:'POST',
            },
            order: [
                [1, "DESC"]
            ],
            columns: [
                { data : 'foto_produk' },
                { data : 'nama' },
                { data : 'kuantitas' },
                { data : 'harga_satuan' },
                { data : 'status' },
                { data : 'action' }
            ]
        });
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
                                console.log(value);
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
        $(document).on('click', '.plus-button', function(e) {
            e.preventDefault();
            let data = table.row( $(this).parents('tr') ).data();
            if (!$('.removeable').is('#produk-'+data.id)) {
                $('.produk-cart').append(`
                    <div id="produk-${data.id}" class="col-12 row removeable">
                        <input type="hidden" name="produk[id_produk][0]" value="${data.id}">
                        <div class="col-9">
                            <div class="form-group">
                                <input type="text" class="form-control" id="" readonly value="${data.nama}">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <input type="text" class="form-control kuantitas" name="produk[kuantitas][0]" id="kuantitas-${data.id}" value="1">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" class="form-control harga-satuan" id="" readonly value=${data.harga_satuan} id="harga-satuan-${data.id}">
                                    <button class="btn btn-danger remove-button"><i class="fa fa-minus"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                `);
            }
            let temp_harga = 0;
            generateTotalHarga();
        });
        $(document).on('keyup', '.kuantitas', function() {
            generateTotalHarga();
        });
        $(document).on('click', '.removeable', function() {
            generateTotalHarga();
        });
        function generateTotalHarga() {
            let temp_harga = 0;
            $('.removeable').each(function(i, val) {
                let kuantitas = $(this).find('.kuantitas').val();
                let harga_satuan = $(this).find('.harga-satuan').val().split('.').join('');
                temp_harga += kuantitas * harga_satuan;
            });
            $('#total-harga').text(temp_harga);
        }
    });
</script>
@endpush