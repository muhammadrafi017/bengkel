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
    <div class="col-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="mt-2 font-weight-bold text-primary">
                    Daftar Produk
                </h6>
            </div>
            <div class="card-body">
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
    </div>
    <div class="col-3">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="mt-2 font-weight-bold text-primary">
                    Keranjang
                </h6>
            </div>
            <div class="card-body">
                {{-- <div id="undraw" class="row">
                    <img src="{{ asset('svg/order-unsplash.jpeg') }}" class="img-fluid" alt="unsplash">
                </div> --}}
                <div class="row produk-cart">
                    <div class="col-12 row removeable">
                        <input type="hidden" name="produk[id_produk][0]">
                        <div class="col-9">
                            <div class="form-group">
                                <input type="text" class="form-control" id="" readonly>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <input type="text" class="form-control" name="produk[kuantitas][0]" id="">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="" readonly>
                                    <button class="btn btn-danger remove-button"><i class="fa fa-minus"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <h6>Total</h6>
            </div>
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
    });
</script>
@endpush