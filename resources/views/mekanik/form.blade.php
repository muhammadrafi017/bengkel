@extends('layouts.app')

@section('content')

<meta name="base_url" content="{{ url('mekanik') }}">

<div class="row">
    <div class="col-md-8">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="mt-2 font-weight-bold text-primary">
                    Form Mekanik
                </h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <form id="form" action=" {{ $type == 'create'? url('mekanik/store') : url('mekanik/update/'.$id) }}">
                    <div class="row">
                        <div class="form-group col-12">
                            <label for="">Nama</label>
                            <input type="text" class="form-control" name="nama" value="{{ $data? $data->nama : '' }}" id="">
                        </div>
                        <div class="form-group col-12">
                            <label for="">No. Handphone</label>
                            <input type="text" class="form-control" name="no_handphone" value="{{ $data? $data->no_handphone : '' }}" id="">
                        </div>
                        <div class="form-group col-12">
                            <label for="">Alamat</label>
                            <input type="text" class="form-control" name="alamat" value="{{ $data? $data->alamat : '' }}" id="">
                        </div>
                    </div>
                    <button class="btn btn-primary btn-block submit">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
