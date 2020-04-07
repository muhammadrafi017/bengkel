@extends('layouts.app')

@section('content')

<meta name="base_url" content="{{ url('service') }}">

<div class="row">
    <div class="col-md-8">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="mt-2 font-weight-bold text-primary">
                    Form Service
                </h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <form id="form" action=" {{ $type == 'create'? url('service/store') : url('service/update/'.$id) }}">
                    <div class="row">
                        <div class="form-group col-12">
                            <label for="">Nama</label>
                            <input type="text" class="form-control" name="nama" value="{{ $data? $data->nama : '' }}" id="">
                        </div>
                        <div class="form-group col-12">
                            <label for="">Harga Minimal</label>
                            <input type="text" class="form-control balance" name="harga_minimal" value="{{ $data? $data->harga_minimal : '' }}" id="" oninput="inputRupiah(event)">
                        </div>
                        <div class="form-group col-12">
                            <label for="">Harga Maksimal</label>
                            <input type="text" class="form-control balance" name="harga_maksimal" value="{{ $data? $data->harga_maksimal : '' }}" id="" oninput="inputRupiah(event)">
                        </div>
                    </div>
                    <button class="btn btn-primary btn-block submit">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
