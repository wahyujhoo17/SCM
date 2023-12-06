@extends('tamplate')

@section('judul')
    <p>Daftar Produksi</p>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .invoice-container {
            /* text-align: center; */
            padding: 20px;
        }

        .pModal {
            display: none;
            position: fixed;
            top: 0;
            right: -100%;
            /* Mulai dari luar layar kanan */
            width: 75%;
            /* 3/4 dari lebar layar */
            height: 90vh;
            /* tinggi sama dengan tinggi layar */
            background-color: #fefefe;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: right 0.3s ease-in-out;
            /* Efek transisi untuk animasi */
        }

        .pModal-content {
            padding: 20px;
            height: 100%;
            overflow-y: auto;
        }

        .close {
            position: absolute;
            top: 10px;
            right: 60px;
            font-size: 30px;
            cursor: pointer;
        }

        .modal-footer {
            background-color: white;
        }

        .containerR {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 10px;
            margin-top: 5px;
        }

        .form-check-input {
            width: 20px;
            height: 20px;
            margin-top: 5px;
        }

        .form-check-label {
            font-size: 15px;
            margin-left: 5px;
        }

        .form-check-input:checked {
            background-color: #007bff;
            border-color: #007bff;
        }

        .form-check-input:checked:after {
            /* content: '\2713'; */
            font-size: 14px;
            color: white;
            position: relative;
            top: -3px;
            left: 2px;
        }

        .blurred {
            filter: blur(5px);
            /* Adjust the blur amount as needed */
            pointer-events: none;
            /* Allow clicks to pass through the blurred background */
        }
    </style>
@endsection

@section('konten')
    <div class="clearfix"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-right">
                <button type="button" class="btn btn-round btn-success" id="openModalBtn">Tambah
                    Produksi</button>
            </div>
        </div>
    </div>

    {{-- TABLE --}}

    {{-- TABLE PESANANN --}}
    <table class="table table-striped jambo_table bulk_action" id="datatable">
        <thead>
            <tr class="headings">
                <th class="column-title">No Produksi</th>
                <th class="column-title">Tanggal Ditambahkan</th>
                <th class="column-title">Produk</th>
                <th>Jumlah</th>
                <th>Penanggung Jawab</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($produksi as $item)
                <tr>
                    <td>{{ $item->nomor }}</td>
                    <td>{{ $item->tanggal_ditambahkan }}</td>
                    <td>{{ $item->produk->nama }}</td>
                    <td>{{ $item->jumlah_produksi }}</td>
                    <td>{{ $item->pegawai->nama }}</td>
                    <td>{{ $item->status_produksi }}</td>
                    <td>

                        <button type="button" class="btn btn-success"
                            onclick="eksekusi('{{ $item->id }}' , '{{ $item->status_produksi }}')">
                            <i class="fas fa-industry"></i>
                        </button>

                        @if ($item->status_produksi == 'Dalam Antrian')
                            <button type="button" class="btn btn-warning" onclick="editProduksi('{{ $item->id }}')">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-danger">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        @endif

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>


    {{-- MODAL TAMBAH --}}
    <form action="/daftar-produksi" method="POST">
        @csrf
        <div id="pModal" class="pModal">
            <div class="pModal-content">
                <h3 style="text-align: center;">Tambah Produksi</h3><br>
                <div class="containerR">
                    {{-- PRODUK DAN JUMLAH --}}
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="produk">Pilih produk</label>
                            <select name="produk" id="produk" class="form-control" style="width: 100%" required>
                                <option value="">Pilih produk</option>
                                @foreach ($produk as $item)
                                    @foreach ($item->pemasok as $ip)
                                        @if ($ip->id == 7)
                                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                        @endif
                                    @endforeach
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="warning"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="kode">Kode Produksi</label>
                            <input type="text" class="form-control" name="kode" id="kode"
                                value="{{ $idG }}" readonly>
                        </div>

                    </div>
                    {{-- NOMOR DAN PEGAWAI --}}
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="pegawai">Penanggung jawab</label>
                            <select name="pegawai" id="pegawai" class="form-control" required style="width: 100%;">
                                <option value="">Pilih Pegawai</option>
                                @foreach ($pegawai as $usr)
                                    <option value="{{ $usr->id }}">{{ $usr->nama }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="warning"></div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="kuantitas">Jumlah Produksi</label>
                            <input type="number" name="kuantitas" id="kuantitas" class="form-control" required>
                            <div class="invalid-feedback" id="warning"></div>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="button" class="invisible">Button</label>
                            <button type="button" class="btn btn-primary btn-block" id="proses"
                                onclick="prosesAcuan()">Proses</button>
                            <div id="warning"></div>
                        </div>
                    </div>
                </div><br>
                <H4>Barang Mentah Diambil</H4><br>
                <div id="isiProduk">
                    <table class="table table-striped jambo_table bulk_action">
                        <thead>
                            <tr>
                                <th>Nomor</th>
                                <th>Nama</th>
                                <th>Jumlah</th>
                                <th>Satuan</th>
                                <th>Stok Gudang</th>
                                <th>Gudang</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal()" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Tambah Produksi</button>
            </div>
        </div>

    </form>
    {{-- END MODAL --}}


    {{-- MODAL UBAH --}}
    <!-- The Modal -->
    <div class="modal fade" id="addProductionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel" style="text-align: center;">Ubah Produksi</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="body">

                </div>

            </div>
        </div>
    </div>

    {{-- EKSEKUSI MODAL --}}

    <!-- The Modal -->
    <div class="modal fade" id="eksekusiProduk" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel" style="text-align: center;">View</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="body2">

                </div>

            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        //Alert Berhasil
        var msg = '{{ Session::get('alert') }}';
        var exist = '{{ Session::has('alert') }}';
        if (exist) {
            swal("Success", msg, "success");
        }

        // Alert Gagal
        var msg = '{{ Session::get('alert_gagal') }}';
        var exist = '{{ Session::has('alert_gagal') }}';
        if (exist) {
            swal("Gagal", msg, "error");
        }
    </script>
    <script>
        $("#produk").select2();
        $("#pegawai").select2();
        var modal = document.getElementById('pModal');
        document.getElementById('openModalBtn').addEventListener('click', function() {
            modal.style.display = 'block';
            setTimeout(function() {
                modal.style.right = '0'; // Menggeser modal ke dalam layar
            }, 100);
        });

        function closeModal() {
            modal.style.right = '-100%'; // Menggeser modal kembali ke luar layar kanan
            setTimeout(function() {
                modal.style.display = 'none';
            }, 300); // Sesuaikan dengan durasi transisi CSS (0.3s)
        }
    </script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function prosesAcuan() {
            var warningDiv = document.getElementById('warning');
            var inputVal = document.getElementById('produk').value;
            var kuantitas = document.getElementById('kuantitas').value;

            var param = false;

            if (inputVal.trim() === '') {
                warningDiv.innerHTML = 'Input tidak boleh kosong!';
                document.getElementById('produk').classList.add('is-invalid');
            } else {
                if (kuantitas.trim() === '') {
                    document.getElementById('kuantitas').classList.add('is-invalid');
                } else {
                    param = true;
                }
            }

            $.ajax({
                type: 'GET',
                url: '/daftar-produksi/' + inputVal,
                data: {
                    kuantitas
                },
                success: function(data) {

                    $("#tableBody").html(data.msg);
                    // console.log(data);
                },
                error: function() {
                    alert("error!!!!");
                }
            });
        }

        function ubahProses() {
            var warningDiv = document.getElementById('warning');
            var inputVal = document.getElementById('produkU').value;
            var kuantitas = document.getElementById('kuantitasU').value;
            var param = false;

            if (inputVal.trim() === '') {
                warningDiv.innerHTML = 'Input tidak boleh kosong!';
                document.getElementById('produk').classList.add('is-invalid');
            } else {
                if (kuantitas.trim() === '') {
                    document.getElementById('kuantitas').classList.add('is-invalid');
                } else {
                    param = true;
                }
            }

            $.ajax({
                type: 'GET',
                url: '/daftar-produksi/' + inputVal,
                data: {
                    kuantitas
                },
                success: function(data) {

                    $("#tableBody2").html(data.msg);
                    // console.log(data);
                },
                error: function() {
                    alert("error!!!!");
                }
            });
        }

        function editProduksi(id) {

            $.ajax({
                type: 'GET',
                url: '/daftar-produksi/' + id + '/edit',
                data: {},
                success: function(data) {
                    // console.log(data);
                    $("#body").html(data.msg);
                    $('#addProductionModal').modal('show');
                },
                error: function() {
                    alert("error!!!!");
                }
            });
        }

        function eksekusi(id, status) {
            // console.log(status);
            $.ajax({
                type: 'GET',
                url: '/acuan-produksi/eksekusi/' + id,
                data: {
                    status
                },
                success: function(data) {
                    // console.log(data);
                    $("#body2").html(data.msg);
                    $('#eksekusiProduk').modal('show');
                },
                error: function() {
                    alert("error!!!!");
                }
            });
        }
    </script>
    <script>
        function gudangFunc(row) {
            gudang = $('#gudang_' + row).val();
            stok = gudang.split('-')[1];
            $('#stokGudang_' + row).val(stok);
            // console.log(row);
        }

        $('#datatable').DataTable({
            "order": [
                [5, "asc"]
            ] // 0 corresponds to the first column (index 0), "desc" stands for descending
        });
    </script>
@endsection
