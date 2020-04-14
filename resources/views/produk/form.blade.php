@extends('layouts.app')

@section('content')

<meta name="base_url" content="{{ url('produk') }}">

<div class="row">
    <div class="col-md-8">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="mt-2 font-weight-bold text-primary">
                    Form Kupon
                </h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <form id="form" action=" {{ $type == 'create'? url('produk/store') : url('produk/update/'.$id) }}">
                    <div class="row">
                        <div class="form-group col-12">
                            <label for="">Nama</label>
                            <input type="text" class="form-control" name="nama" value="{{ $data? $data->nama : '' }}" id="">
                        </div>
                        <div class="form-group col-12">
                            <label for="">Satuan</label>
                            <input type="text" class="form-control" name="satuan" value="{{ $data? $data->satuan : '' }}" id="">
                        </div>
                        <div class="form-group col-12">
                            <label for="">Kuantitas</label>
                            <input type="text" class="form-control" name="kuantitas" value="{{ $data? $data->kuantitas : '' }}" id="" oninput="inputOnlyNumber(event)">
                        </div>
                        <div class="form-group col-12">
                            <label for="">Harga Satuan</label>
                            <input type="text" class="form-control" name="harga_satuan" value="{{ $data? $data->harga_satuan : '' }}" id="" oninput="inputRupiah(event)">
                        </div>
                        <div class="form-group col-12">
                            <label for="">Foto Produk <a href="{{ $data? $data->foto_produk? Storage::url('produk/'.$data->foto_produk) : '' : '' }}" target="_blank">{{ $data?  $data->foto_produk : '' }}</a></label>
                            <input type="file" class="form-control" name="foto_produk_file">
                        </div>
                        <div class="form-group col-12">
                            <label for="">Status</label>
                            <select class="form-control" name="status" id="">
                                <option value="ada" {{ $data? $data->status == 'ada' ? 'selected' : '' : '' }}>Ada</option>
                                <option value="tidak-ada" {{ $data? $data->status == 'tidak-ada' ? 'selected' : '' : '' }}>Tidak Ada</option>
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
