@extends('admin.layouts.app')

@section('content')

<meta name="base_url" content="{{ url('admin/user/index') }}">

<div class="row">
    <div class="col-md-8">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="mt-2 font-weight-bold text-primary">
                    Form User
                </h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <form id="form" action=" {{ $type == 'create'? url('admin/user/store') : url('admin/user/update/'.$id) }}">
                    <div class="row">
                        <input type="hidden" class="form-control" name="is_admin" value="1">
                        <div class="form-group col-12">
                            <label for="">Nama</label>
                            <input type="text" class="form-control" name="name" value="{{ $data? $data->nama_lengkap : '' }}" id="">
                        </div>
                        <div class="form-group col-12">
                            <label for="">Email</label>
                            <input type="text" class="form-control" name="email" value="{{ $data? $data->email : '' }}" id="">
                        </div>
                        <div class="form-group col-12">
                            <label for="">No. Handphone</label>
                            <input type="text" class="form-control" name="phone_number" value="{{ $data? $data->no_handphone : '' }}" id="" oninput="inputOnlyNumber(event)">
                        </div>
                    </div>
                    <button class="btn btn-primary btn-block submit">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
