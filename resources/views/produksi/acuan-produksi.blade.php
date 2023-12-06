@extends('tamplate')

@section('judul')
    <p>Acuan Produksi</p>
@endsection

@section('konten')
    <div class="clearfix"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-right">
                <button type="button" class="btn btn-round btn-success" id="tambah" data-toggle="modal"
                    data-target="#myModal">Tambah Ubah
                    Data</button>
            </div>
        </div>
    </div>

    {{-- FILTER --}}
    <div class="d-flex justify-content-end">
        <div class="row mr-1 mt-2">
            <div class="col-md-12 mb-1 text-right">
                {{-- <label for="productFilter">Filter berdasarkan Produk:</label> --}}
                <select id="productFilter" class="form-control">
                    <option value="">Semua Produk</option>
                    @foreach ($produk as $item)
                        <option value="{{ $item->nama }}">{{ $item->nama }}</option>
                    @endforeach
                    <!-- Add other product names as needed -->
                </select>
            </div>
        </div>
    </div>

    {{-- TABLE --}}
    <table class="table table-striped jambo_table bulk_action" id="datatable">
        <thead>
            <tr class="headings">
                <th class="column-title">Nomor</th>
                <th class="column-title">Nama Produk </th>
                <th style="width: 40%">Resep</th>
                </th>
            </tr>
        </thead>
        @foreach ($produk as $item)
            <tr>
                <td>{{ $item->produk_id }}</td>
                <td>{{ $item->nama }}</td>
                <td>
                    <table style="width: 100%">
                        @foreach ($item->barang as $pb)
                            <tr style="text-align: center">
                                <td>{{ $pb->nama . ' : ' . $pb->pivot->jumlah . ' ' . $pb->pivot->satuan }}</td>
                                {{-- <td>{{ $pb->pivot->jumlah." ". $pb->pivot->satuan}}</td> --}}
                            </tr>
                        @endforeach
                    </table>
                </td>
            </tr>
        @endforeach
        <tbody>
        </tbody>
    </table>


    <!-- The Modal -->
    <div class="modal fade" id="myModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Modal Heading</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <!-- Form content moved into the modal -->
                    <form action="/acuan-produksi/tambah" method="post" id="your-form-id">
                        @csrf
                        <label for="nama">Nama Resep:</label>
                        <select name="nama" id="nama" class="form-control" style="width: 100%;" required
                            onchange="produkOnchange(this.value)">
                            <option value="">Pilih Produk</option>
                            @foreach ($produk as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>

                        <input type="text" name="produk" id="produk" style="visibility: hidden">
                        <hr>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6">
                                    <!-- Content for the first column -->
                                    <div class="form-group">
                                        <label for="bahan">Bahan-bahan:</label>
                                        <select class="form-control" id="bahan-dropdown" style="width: 100%;"
                                            onchange="bahanOnChange()">
                                            <option value="">Pilih bahan</option>
                                            @foreach ($barangMentah as $bahan)
                                                <option value="{{ $bahan->nomor . '-' . $bahan->satuan->nama }}">
                                                    {{ $bahan->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="jumlah">Jumlah</label>
                                    <input type="text" id="jumlah" class="form-control" placeholder="jumlah">
                                </div>
                                <div class="col-md-2">
                                    <label for="satuan">Satuan</label>
                                    <input type="text" id="satuan" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary mt-2" id="tambah-bahan">Tambah Bahan</button>

                        <div id="myTable">
                            <table class="table mt-3" id="iniTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Bahan</th>
                                        <th>Jumlah</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="bahan-list">
                                    <!-- Daftar bahan akan ditampilkan di sini -->
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" form="your-form-id" class="btn btn-success">Simpan Resep</button>
                </div>

            </div>
        </div>
    </div>
    {{-- END MODAL --}}
@endsection
@section('javascript')
    <!-- Skrip JavaScript -->
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
        function bahanOnChange() {
            var bahan = $("#bahan-dropdown").val();
            let satuan = bahan.split('-')[1];
            $("#satuan").val(satuan);
        }

        function produkOnchange(id) {

            $("#produk").val(id);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'GET',
                url: '/acuan-produksi/' + id,
                data: {
                    id
                },
                success: function(data) {
                    // console.log(data);
                    $("#bahan-list").html(data.msg);
                },
                error: function() {
                    alert("error!!!!");
                }
            }); //end of ajax
        }

        //HALAMAN TAMBAH 
        document.addEventListener('DOMContentLoaded', function() {
            $('#nama').select2();
            $('#bahan-dropdown').select2();
            $('#productFilter').select2();
            //
            var table = document.getElementById('iniTable');
            // Get the number of rows
            var rowCount = table.rows.length;
            //
            let bahanList = document.getElementById('bahan-list');
            let bahanDropdown = document.getElementById('bahan-dropdown');
            let tambahBahanButton = document.getElementById('tambah-bahan');
            let namaSelect = $("#nama");
            var mySelect = document.getElementById("nama");

            tambahBahanButton.addEventListener('click', function() {
                let selectedBahan = bahanDropdown.options[bahanDropdown.selectedIndex];
                let bahanNama = selectedBahan.text;
                let jumlah = $('#jumlah').val()
                var bahanVal = $('#bahan-dropdown').val();
                let nomor = bahanVal.split('-')[0];
                let satuan = bahanVal.split('-')[1];
                if (bahanVal != '' && jumlah != "") {
                    // Hapus bahan dari dropdown
                    selectedBahan.remove();

                    // Tambahkan baris ke dalam tabel bahan
                    let newRow = document.createElement('tr');
                    newRow.innerHTML = `
                <td><input class="form-control-plaintext" value = "${nomor}" name ="nomor[]"></td>
                <td><input class="form-control-plaintext" value = "${bahanNama}" name ="bahan[]"></td>
                <td><input class="form-control-plaintext" value = "${jumlah} ${satuan}" name ="jumlah[]"></td>
                <td><button type="button" class="btn btn-danger btn-hapus">Hapus</button></td>
            `;
                    bahanList.appendChild(newRow);

                    // Check jumlah baris, jika 0, enable select nama, jika tidak, disable select nama

                    if (bahanList.rows.length === 0) {
                        mySelect.disabled = false;
                    } else {
                        $("#produk").val(mySelect.value);
                        mySelect.disabled = true;
                    }


                    $("#jumlah").val("");
                    bahanOnChange();
                }
            });

            // Tambahkan event listener untuk tombol "Hapus"
            bahanList.addEventListener('click', function(event) {
                if (event.target.classList.contains('btn-hapus')) {
                    let row = event.target.closest('tr');
                    let id = row.cells[0].querySelector('input').value;
                    let jumlahSatuan = row.cells[2].querySelector('input').value.split(' ');
                    let nama = row.cells[1].querySelector('input').value;

                    // console.log(jumlahSatuan[1]);

                    // Tambahkan kembali bahan ke dropdown
                    let option = document.createElement('option');
                    option.value = id + "-" + jumlahSatuan[1];
                    option.text = nama;
                    bahanDropdown.add(option);

                    row.remove();

                    // Check jumlah baris, jika 0, enable select nama, jika tidak, disable select nama
                    if (bahanList.rows.length === 0) {
                        namaSelect.prop("disabled", false);
                    } else {
                        namaSelect.prop("disabled", true);
                    }
                }
            });

        });
    </script>

    <script>
        function removeOption(optionValue) {
            // Get the select element
            var select = document.getElementById('bahan-dropdown');

            // Find the option with the specified value
            var optionToRemove = select.querySelector('option[value="' + optionValue + '"]');

            // If the option is found, remove it
            if (optionToRemove) {
                optionToRemove.remove();
            } else {
                console.warn('Option with value ' + optionValue + ' not found.');
            }
        }

        var table = $('#datatable').DataTable({
            // Your DataTable options here
        });

        // Handle product name filter change
        $('#productFilter').on('change', function() {
            var selectedProductName = $(this).val();
            table.columns(1).search(selectedProductName).draw();
        });
    </script>
@endsection
