@extends('tamplate')

@section('judul')
    <p>Daftar Pengiriman</p>
@endsection

@section('konten')
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

    </style>
    {{-- KONTEN --}}
    <div class="clearfix"></div>

    <div class="container">
        <div class="row">
            <div class="col-md-12 text-right">
                <button type="button" class="btn btn-round btn-success" id="openModalBtn">Tambah Pengiriman</button>
            </div>
        </div>
    </div><br>

    <div class="col-md-5 form-group has-feedback float-right">
        <div id="reportrange" class="form-control">
            <i class="fa fa-calendar"></i>&nbsp;
            <span></span> <b class="caret"></b>
        </div>
    </div>

    <table class="table table-striped jambo_table bulk_action" id="datatable">
        <thead>
            <tr class="headings">
                <th class="column-title">ID Pengiriman</th>
                <th class="column-title">Waktu Pengiriman </th>
                <th class="column-title">Waktu Diserahkan</th>
                <th class="column-title">Pesanan ID</th>
                <th class="column-title">Pengirim</th>
                <th class="column-title">Keterangan</th>
                <th class="column-title">Status</th>
                <th class="column-title">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($data as $pg)
                <tr>
                    <td>{{ $pg->nomor }}</td>
                    <td>{{ $pg->tanggal_dikirim }}</td>
                    <td>{{ $pg->tanggal_diterima }}</td>
                    <td>{{ $pg->pesanan->nomor }}</td>

                    <td>{{ $pg->pegawai->nama }}</td>
                    <td>{{ $pg->keterangan }}</td>
                    <td>{{ $pg->status }}</td>
                    <td> <button type="button" class="btn btn-primary" onclick="showPengiriman({{ $pg->id }})">
                            <i class="fas fa-info-circle"></i>
                        </button></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- MODAL --}}
    <form action="/daftar-pengiriman" method="POST">
        @csrf

        <div class="invoice-container">
            <div id="pModal" class="pModal">
                <div class="pModal-content">
                    <h3 style="text-align: left;">Tambah Pengiriman</h3><br>
                    <div class="row">
                        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                            <h6><strong>Informasi Pelanggan</strong></h6>
                        </div>
                        <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">

                            {{-- REFERENSI PESANAN --}}
                            <label for="pemesanan">Pemesanan</label>
                            <select name="pemesanan" id="pemesanan" class="form-control" style="width: 100% ;"
                                onchange="pesananChange(this.value)" required>
                                <option value="">Pilih Pesanan</option>
                                @foreach ($pesanan as $p)
                                    <option value="{{ $p->id }}">{{ $p->nomor }}</option>
                                @endforeach
                            </select><br>

                            {{-- Nama Pengirim --}}
                            <label for="pengirim" class="mt-2">Pengirim</label>
                            <select name="pengirim" id="pengirim" class="form-control" style="width: 100% ;" required>
                                <option value="">Pilih pengirim </option>
                                @foreach ($pengirim as $p)
                                    <option value="{{ $p->id }}">{{ $p->nama }}</option>
                                @endforeach
                            </select>

                            {{-- NAMA PELANGGAN --}}
                            <label for="namaPelanggan" class="mt-2">Nama Pelanggan</label>
                            <input type="text" name="namaPelanggan" id="namaPelanggan" class="form-control" readonly><br>

                            {{-- NOMOR DAN TANGGAL --}}
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <label for="noPengiriman">Nomor Pengiriman</label>
                                    <input type="text" class="form-control" value="{{ $idG }}"
                                        name="noPengiriman" id="noPengiriman" readonly required>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <label for="tanggalPengiriman">Tanggal Pengiriman</label>
                                    <input type="datetime-local" name="tanggal" id="tanggalPengiriman" class="form-control"
                                        required>
                                </div>
                            </div>

                            {{-- ALAMAT PENGIRIMAN --}}
                            <div class="container mt-4">
                                <h2>Alamat Pengiriman</h2>
                                <div class="row">
                                    <div class="col-md-3">
                                        <p><strong>Alamat</strong></p>
                                    </div>
                                    <div class="col-md-0">
                                        <strong>:</strong>
                                    </div>
                                    <div class="col-md-5">
                                        <p id="alamat"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <p><strong>Nomor Telepon</strong></p>
                                    </div>
                                    <div class="col-md-0">
                                        <strong>:</strong>
                                    </div>
                                    <div class="col-md-5">
                                        <p id="noTlp"></p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div style="border-top: 2px solid #E5E5E5;"></div><br>
                    {{-- ISI TABLE --}}
                    <div class="row" id="listTable">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <table class="table table-condensed table-striped" id="invoiceItem">
                                <tr>
                                    <th width="2%">
                                        <div class="custom-control custom-checkbox mb-3">
                                            <input type="checkbox" class="custom-control-input" id="checkAll"
                                                name="checkAll">
                                            <label class="custom-control-label" for="checkAll"></label>
                                        </div>
                                    </th>
                                    <th width="15%">Item No</th>
                                    <th width="35%">nama</th>
                                    <th width="12%">Jumlah</th>
                                    <th>Stok Gudang</th>
                                    <th>Nama Gudang</th>
                                </tr>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModal()"
                        data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Tambah Pengiriman</button>
                </div>
            </div>
        </div>
    </form>

    {{-- MODAL VIEW --}}
    <!-- Modal Pengiriman -->
    <form action="" method="POST" id="konfirmasiModal">
        @csrf
        @method('PUT')
        <div class="modal fade" id="myModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <!-- Bagian header modal -->
                    <div class="modal-header">
                        <h4 class="modal-title">Detail Pengiriman</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Bagian body modal -->
                    <div class="modal-body" id="contentModal">

                    </div>


                </div>
            </div>
        </div>
    </form>
@endsection

@section('javascript')
    <!-- Sertakan SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
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

        $("#pengirim").select2();
        $("#pemesanan").select2();

        //Alert Berhasil
        var msg = '{{ Session::get('alert') }}';
        var exist = '{{ Session::has('alert') }}';
        if (exist) {
            Swal.fire({
                title: "Good job!",
                text: "Pengiriman Berhasil Ditambahkan!",
                icon: "success"
            });
        }


        var pj = '{{ Session::has('berhasil') }}';
        if (pj) {
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Pengiriman Berhasil Dikonfirmasi",
                showConfirmButton: false,
                timer: 1500
            });
        }

        $('#datatable').DataTable({
            "order": [
                [1, 'desc']
            ]
        });
    </script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function pesananChange(id) {
            $.ajax({
                type: 'GET',
                url: '/getPesanan/' + id,
                data: {},
                success: function(data) {
                    // console.log(data);
                    $("#namaPelanggan").val(data.pelanggan['nama']);
                    $("#alamat").html(data.invoice['alamat_pengiriman']);
                    $("#noTlp").html(data.pelanggan['no_tlp']);
                    $("#listTable").html(data.listTable);
                },
                error: function() {
                    alert("error!!!!");
                }
            });
        }

        function showPengiriman(id) {

            $('#konfirmasiModal').attr('action', 'daftar-pengiriman/' + id);
            bukaModal();
            $.ajax({
                type: 'GET',
                url: '/daftar-pengiriman/' + id,
                data: {},
                success: function(data) {
                    $("#contentModal").html(data.view);
                },
                error: function() {
                    alert("error!!!!");
                }
            });
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/luxon@2.1.0/build/global/luxon.min.js"></script>
    <script>
        // Get the current date and time in the user's local timezone using Luxon
        const currentDateTime = luxon.DateTime.local().setZone('Asia/Jakarta');

        // Format the date and time to match the datetime-local input format
        const formattedDate = currentDateTime.toFormat('yyyy-MM-dd HH:mm');
        console.log(formattedDate);
        // Set the value of the input field to the current date and time
        document.getElementById('tanggalPengiriman').value = formattedDate;
    </script>



    <script>
        // Fungsi untuk membuka modal
        function bukaModal() {
            $('#myModal').modal('show');
        }

        // Fungsi untuk menangani pengiriman pesanan
        function kirimPesanan() {

            var form = $(this).closest("form");
            var name = $(this).data("name");
            event.preventDefault();

            Swal.fire({
                title: 'Apakah Anda yakin ingin mengkonfirmasi pengiriman ini?',
                html: '<label for="keterangan">Keterangan:</label><textarea class="form-control" id="swal-keterangan"></textarea>',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Simpan!',
                cancelButtonText: 'Batal',
                preConfirm: () => {
                    // Ambil nilai input keterangan
                    const keterangan = document.getElementById('swal-keterangan').value;
                    // Lakukan aksi yang diinginkan dengan nilai input, misalnya, kirim form atau simpan data
                    console.log(keterangan);

                    document.getElementById("keterangan").value = keterangan;
                    document.getElementById("konfirmasiModal").submit();
                }
            });
        }

        function printModal() {
            var printContents = document.getElementById('printableContent').innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;

            location.reload();
        }
    </script>
@endsection
