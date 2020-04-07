@extends('layouts.app')

@section('content')

<meta name="base_url" content="{{ url('jurusan/index') }}">

<div class="row">
    <div class="col-md-8">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="mt-2 font-weight-bold text-primary">
                    Form Jurusan
                </h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <form id="form" action=" {{ $type == 'create'? url('jurusan/store') : url('jurusan/update/'.$id) }}">
                    <div class="row">
                        <div class="form-group col-12">
                            <label for="">Kategori Jurusan</label>
                            <select class="form-control" name="id_kategori_jurusan" id="select-kategori-jurusan"></select>
                        </div>
                        <div class="form-group col-12">
                            <label for="">Nama</label>
                            <input type="text" class="form-control" name="nama" value="{{ $data? $data->nama : '' }}" id="">
                        </div>
                        <div class="form-group col-12">
                            <label for="">Deskripsi</label>
                            <input type="text" class="form-control" name="deskripsi" value="{{ $data? $data->deskripsi : '' }}" id="">
                        </div>
                        <div class="form-group col-12">
                            <label for="">Level</label>
                            <select class="form-control" name="level" id="">
                                <option selected disabled>Pilih level</option>
                                <option {{ $data? $data->level == 'SMA-D3'? 'selected' : '' : '' }} value="SMA-D3">SMA-D3</option>
                                <option {{ $data? $data->level == 'SMA-S1'? 'selected' : '' : '' }} value="SMA-S1">SMA-S1</option>
                                <option {{ $data? $data->level == 'S1-S2'? 'selected' : '' : '' }} value="S1-S2">S1-S2</option>
                                <option {{ $data? $data->level == 'S2-S3'? 'selected' : '' : '' }} value="S2-S3">S2-S3</option>
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

@push('js')
<script>
    $(document).ready(function() {
        select2Generator('#select-kategori-jurusan', '{{ url('admin/kategori-jurusan/list') }}');
        @if($data)
            let kategori_jurusan = @json($data->kategoriJurusan);
            $('#select-kategori-jurusan').append(`<option value="${kategori_jurusan.id}" selected>${kategori_jurusan.nama}</option>`);
        @endif
    });
</script>
@endpush
