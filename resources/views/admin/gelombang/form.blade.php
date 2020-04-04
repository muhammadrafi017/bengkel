@extends('admin.layouts.app')

@section('content')

<meta name="base_url" content="{{ url('admin/gelombang/index') }}">

<div class="row">
    <div class="col-md-8">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="mt-2 font-weight-bold text-primary">
                    Form Gelombang
                </h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <form id="form" action=" {{ $type == 'create'? url('admin/gelombang/store') : url('admin/gelombang/update/'.$id) }}">
                    <div class="row">
                        <div class="form-group col-12">
                            <label for="">Nama</label>
                            <input type="text" class="form-control" name="nama" value="{{ $data? $data->nama : '' }}" id="">
                        </div>
                        <div class="form-group col-12">
                            <label for="">Kuota</label>
                            <input type="text" class="form-control" name="kuota" value="{{ $data? $data->kuota : '' }}" id="" oninput="inputOnlyNumber(event)">
                        </div>
                        <div class="form-group col-12">
                            <label for="">Biaya Formulir</label>
                            <input type="text" class="form-control balance" name="biaya_formulir" value="{{ $data? $data->biaya_formulir : '' }}" id="" oninput="inputRupiah(event)">
                        </div>
                        <div class="form-group col-12">
                            <label for="">Biaya Administrasi</label>
                            <input type="text" class="form-control balance" name="biaya_admisi" value="{{ $data? $data->biaya_admisi : '' }}" id="" oninput="inputRupiah(event)">
                        </div>
                        <div class="form-group col-12">
                            <label for="">Tanggal mulai</label>
                            <input type="text" class="form-control" name="tanggal_mulai" value="{{ $data? $data->tanggal_mulai : '' }}" id="tanggal_mulai" data-toggle="datetimepicker" data-target="#tanggal_mulai">
                        </div>
                        <div class="form-group col-12">
                            <label for="">Tanggal selesai</label>
                            <input type="text" class="form-control" name="tanggal_selesai" value="{{ $data? $data->tanggal_selesai : '' }}" id="tanggal_selesai" data-toggle="datetimepicker" data-target="#tanggal_selesai">
                        </div>
                        <div class="form-group col-12">
                            <label for="">Tanggal tes</label>
                            <input type="text" class="form-control" name="tanggal_tes" value="{{ $data? $data->tanggal_tes : '' }}" id="tanggal_tes" data-toggle="datetimepicker" data-target="#tanggal_tes">
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
            dateGenerator('#tanggal_mulai', {format: 'Y-MM-DD'});
            dateGenerator('#tanggal_selesai', {format: 'Y-MM-DD'});
            dateGenerator('#tanggal_tes', {format: 'Y-MM-DD'});
        });
    </script>
@endpush
