@extends('admin.layouts.app')

@section('content')

<meta name="base_url" content="{{ url('admin/peminat/index') }}">

<div class="row">
    <div class="col-md-8">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="mt-2 font-weight-bold text-primary">
                    Form Peminat
                </h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <form id="form" action=" {{ $type == 'create'? url('admin/peminat/store') : url('admin/peminat/update/'.$id) }}">
                    <div class="row">
                        <div class="form-group col-12">
                            <label for="">Nama</label>
                            <input type="text" class="form-control" name="nama_lengkap" value="{{ $data? $data->nama_lengkap : '' }}" id="">
                        </div>
                        <div class="form-group col-12">
                            <label for="">No Handphone</label>
                            <input type="text" class="form-control" name="no_handphone" value="{{ $data? $data->no_handphone : '' }}" id="">
                        </div>
                        <div class="form-group col-12">
                            <label for="">Email</label>
                            <input type="text" class="form-control" name="email" value="{{ $data? $data->email : '' }}" id="">
                        </div>
                        <div class="form-group col-12">
                            <label for="">Status</label>
                            <select class="form-control" name="status" id="">
                                <option selected disabled>Pilih status</option>
                                <option {{ $data? $data->status == 'belum-follow-up'? 'selected' : '' : '' }} value="belum-follow-up">Belum Follow Up</option>
                                <option {{ $data? $data->status == 'sudah-follow-up'? 'selected' : '' : '' }} value="sudah-follow-up">Sudah Follow Up</option>
                            </select>
                        </div>
                    </div>
                    <button class="btn btn-primary btn-block submit">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
