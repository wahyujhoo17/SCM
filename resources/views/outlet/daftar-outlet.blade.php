@extends('tamplate')

@section('judul')
    <p>Daftar Outlet</p>
@endsection

@section('konten')
    <style>
        .outlet-card {
            margin-bottom: 20px;
        }

        @media (min-width: 576px) {
            .outlet-card {
                flex: 0 0 48%;
            }
        }

        @media (min-width: 768px) {
            .outlet-card {
                flex: 0 0 32%;
            }
        }
    </style>
    <div class="clearfix"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-right">
                <button type="button" class="btn btn-round btn-success" id="openModalBtn" data-toggle="modal"
                    data-target="#tambahOutletModal">Tambah Outlet</button>
            </div>
        </div>
    </div><br>
    <div class="container">
        <div class="row">
            @foreach ($data as $out)
                <div class="col-md-4">
                    <div class="card outlet-card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $out->nama }}</h5>
                            <p class="card-text"><strong>Alamat:</strong> {{ $out->alamat }}</p>

                            @foreach ($out->pegawai as $pegawai)
                                @if ($pegawai->jabatan->nama == 'Casir')
                                    <p class="card-text"><strong>Kasir:</strong> {{ $pegawai->nama }}</p>
                                @else
                                    <p class="card-text"><strong>Manager:</strong> {{ $pegawai->nama }}</p>
                                @endif
                            @endforeach

                            <button type="submit" data-toggle="modal" data-target="#tambahOutletModalUbah"
                                class="btn btn-primary float-right" onclick="getUbah({{ $out->id }})">Ubah</button>
                        </div>
                    </div>
                </div>
            @endforeach
            <!-- Tambahkan outlet lainnya sesuai kebutuhan -->
        </div>
    </div>

    {{-- TAMBAH OUTLET --}}

    <!-- Modal Tambah Outlet -->
    <div class="modal fade" id="tambahOutletModal" tabindex="-1" role="dialog" aria-labelledby="tambahOutletModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahOutletModalLabel">Tambah Outlet</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Isi form tambah outlet di sini -->
                    <form method="POST" action="/daftar-outlet">
                        @csrf
                        <div class="form-group">
                            <label for="namaOutlet">Nama Outlet:</label>
                            <input type="text" class="form-control" name="nama" id="namaOutlet"
                                placeholder="Masukkan nama outlet">
                        </div>
                        <div class="form-group">
                            <label for="alamatOutlet">Alamat Outlet:</label>
                            <textarea name="alamat" class="form-control" id="alamatOutlet" cols="30" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary float-right">Simpan</button>
                        <button type="button" id="batal" class="btn btn-outline-secondary float-right"
                            data-dismiss="modal">Batal</button>

                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Ubah Outlet --}}

    <div class="modal fade" id="tambahOutletModalUbah" tabindex="-1" role="dialog"
        aria-labelledby="tambahOutletModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahOutletModalLabel">Ubah Outlet</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="ubahContent">

                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        // Alert berhasil
        var msg = '{{ Session::get('alert') }}';
        var exist = '{{ Session::has('alert') }}';
        if (exist) {
            swal("Success", msg, "success");
        }
    </script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function getUbah(id) {
            console.log(id);
            $.ajax({
                type: 'GET',
                url: 'daftar-outlet/' + id + '/edit',
                data: {
                },
                success: function(data) {
                    $("#ubahContent").html(data.msg);
                },
                error: function() {
                    alert("error!!!!");
                }
            });
        }
    </script>
@endsection
