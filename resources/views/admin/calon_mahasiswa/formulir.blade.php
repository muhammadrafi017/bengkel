@extends('admin.layouts.app')

@section('content')
<meta name="base_url" content="{{ url('user/calon-mahasiswa/formulir') }}">
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Formulir Calon Mahasiswa</h1>
</div>

<div class="card shadow mb-4">
    <!-- Card Body -->
    <div class="card-body">
        <div class="row">

            <div class="nav nav-pills flex-column col-md-3 col-sm-12" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <a class="nav-link {{ auth()->user()->posisi == '-'? 'active' : 'disabled'}} " id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Formulir</a>
                <a class="nav-link {{ auth()->user()->posisi == 'pembayaran-formulir'? 'active' : 'disabled' }} " id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false" disabled>Pengisian Data</a>
                <a class="nav-link {{ auth()->user()->posisi == 'pengisian-data'? 'active' : 'disabled' }}" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false" disabled>Ujian Masuk</a>
                <a class="nav-link {{ auth()->user()->posisi == 'tes-masuk'? 'active' : 'disabled' }}" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false" disabled>Administrasi</a>
              </div>
              <div class="tab-content col-md-9 col-sm-12" id="v-pills-tabContent">
                <div class="tab-pane fade {{ auth()->user()->posisi == '-'? 'show active' : ''}}" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                    @if ($gelombang)
                        @if (auth()->user()->tagihanFormulir())
                            <label style="width:100%;" class="badge badge-pill badge-success"">Bukti pembayaran sudah diterima, admin akan melakukan pengecekan</label>
                        @endif
                        <p>Silahkan transfer Rp. {{ $gelombang->biaya_formulir }} untuk biaya formulir ke rekening XXX lalu upload bukti pembayaran ke form ini</p>
                        <form id="form" action=" {{ url('user/calon-mahasiswa/upload-bukti-bayar') }}">
                            <input type="hidden" name="nominal" value="{{ $gelombang->biaya_formulir }}">
                            <input type="hidden" name="tagihan" value="formulir">
                            <div class="row">
                                <div class="form-group col-12">
                                    <label for="">Upload bukti pembayaran</label>
                                    <input type="file" class="form-control" name="file" id="">
                                </div>
                            </div>
                            <button class="btn btn-primary btn-block submit">Kirim</button>
                        </form>
                    @else
                    <p>Saat ini belum ada gelombang pendaftaran, silahkan hubungi bagian admisi untuk info lebih lanjut</p>
                    @endif
                </div>
                <div class="tab-pane fade {{ auth()->user()->posisi == 'pembayaran-formulir'? 'show active' : ''}}" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                    <p>Silahkan lengkapi data - data dibawah ini</p>
                    <form id="form" action=" {{ url('user/calon-mahasiswa/pengisian-data') }}">
                        <input type="hidden" name="id_user" value="{{ auth()->user()->id }}">
                        <input type="hidden" name="id_gelombang" value="{{ $gelombang->id }}">
                        <input type="hidden" name="tanggal_tes" value="{{ $gelombang->tanggal_tes }}">
                        <div class="row">
                            <div class="form-group col-12">
                                <label for="">Jurusan</label>
                                <select name="id_jurusan" class="form-control" id="select-jurusan"></select>
                            </div>
                            <div class="form-group col-12">
                                <label for="">Nama Lengkap</label>
                                <input type="text" class="form-control" name="nama_lengkap" id="">
                            </div>
                            <div class="form-group col-12">
                                <label for="">Alamat</label>
                                <input type="text" class="form-control" name="alamat" id="">
                            </div>
                            <div class="form-group col-12">
                                <label for="">Tempat Lahir</label>
                                <input type="text" class="form-control" name="tempat_lahir" id="">
                            </div>
                            <div class="form-group col-12">
                                <label for="">Tanggal Lahir</label>
                                <input type="date" class="form-control" name="tanggal_lahir" id="">
                            </div>
                        </div>
                        <button class="btn btn-primary btn-block submit">Kirim</button>
                    </form>
                </div>
                <div class="tab-pane fade {{ auth()->user()->posisi == 'pengisian-data'? 'show active' : ''}}" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                    <h3 class="text-center">Jadwal Ujian Masuk</h3>
                    <p class="text-center">Silahkan datang ke kampus XXX pada {{ $gelombang->tanggal_tes }} </p>
                </div>
                <div class="tab-pane fade {{ auth()->user()->posisi == 'tes-masuk'? 'show active' : ''}}" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                    @if (auth()->user()->tagihanAdmisi())
                        <label style="width:100%;" class="badge badge-pill badge-success"">Bukti pembayaran sudah diterima, admin akan melakukan pengecekan</label>
                    @endif
                    <h3 class="text-center">Selamat, anda dinyatakan lulus</h3>
                    <p class="text-center">Silahkan transfer Rp. {{ $gelombang->biaya_admisi }} untuk biaya administrasi ke rekening XXX lalu upload bukti pembayaran ke form ini</p>
                    <form id="form" action=" {{ url('user/calon-mahasiswa/upload-bukti-bayar') }}">
                        <input type="hidden" name="nominal" value="{{ $gelombang->biaya_admisi }}">
                        <input type="hidden" name="tagihan" value="admisi">
                        <div class="row">
                            <div class="form-group col-12">
                                <label for="">Upload bukti pembayaran</label>
                                <input type="file" class="form-control" name="file" id="">
                            </div>
                        </div>
                        <button class="btn btn-primary btn-block submit">Kirim</button>
                    </form>
                </div>
                <div class="tab-pane fade {{ auth()->user()->posisi == 'pembayaran-administrasi'? 'show active' : ''}}" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                    <h3 class="text-center">Selamat {{ auth()->user()->nama_lengkap }} anda sudah resmi menjadi Mahasiswa </h3>
                </div>
              </div>
        </div>
    </div>
</div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            let returns = function(data) {
                    return {
                    results: $.map(data.data, function(item) {
                        return {
                            text: item.nama + ' ' + item.level,
                            id: item.id
                        }
                    })
                }
            }
            select2Generator('#select-jurusan', '{{ url('user/list-jurusan') }}', 'Pilih Jurusan', '', returns);
        })
    </script>
@endpush
