@extends('tamplate')

@section('judul')
    <p>Stok Opname</p>
@endsection

@section('konten')
    <div class="clearfix"></div>
    @if (Auth::user()->id == $stok_opname->user_id)
        @if ($stok_opname->status == 'ditambahkan')
            <div class="row">
                <div class="col-md-5 ">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Input</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <br>

                            <div class="mb-3">
                                <label for="nama_barang" class="form-label">Nama Produk</label>
                                <select class="form-control" id="nama_barang">
                                    @foreach ($produk as $item)
                                        <option value="{{ $item->produk_id . '-' . $item->nama }}">{{ $item->nama }}
                                        </option>
                                    @endforeach

                                    <!-- Tambahkan opsi lainnya sesuai kebutuhan -->
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="jumlah_barang" class="form-label">Jumlah Barang</label>
                                <input type="number" class="form-control" id="jumlah_barang" placeholder="Jumlah Barang"
                                    required="required" class="form-control parsley-success" data-parsley-id="5">
                            </div>
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea class="form-control" name="keterangan" id="keterangan" rows="3"></textarea>
                                  </div>
                            </div>
                            <button type="submit" class="btn btn-primary pull-right"
                                onclick="tambahkanData()">Tambah</button>
                        </div>
                    </div>

                </div>

                <div class="col-md-7 ">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Hasil Input</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="row invoice-info">
                                <div class="col-sm-4 invoice-col">
                                    <address>
                                        <strong>Nomor : {{ $stok_opname->nomor }}</strong>
                                        {{-- <br>Tanggal SPK : {{ $stok_opname->tanggal_SPK }} --}}
                                        <br>Gudang : {{ $stok_opname->gudang->nama }}
                                        <br>Tanggal Mulai : {{ $stok_opname->tanggal_mulai }}
                                        {{-- <br>Keretangan : {{ $stok_opname->keterangan }} --}}
                                    </address>
                                </div>
                            </div>
                            <table class="table" id="tabel-stok">
                                <thead>
                                    <tr>
                                        <th style="width: 15%">ID</th>
                                        <th style="width: 25%">Nama Barang</th>
                                        <th style="width: 20%">Jumlah</th>
                                        <th style="width: 30%">Keterangan</th>
                                        <th style="width: 10%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data stok akan ditambahkan di sini menggunakan jQuery -->
                                </tbody>
                            </table>
                            <div class="clearfix"></div>

                            <button type="submit" class="btn btn-success pull-right" id="kirimDataButton">Simpan
                                Data</button>
                            <button type="submit" class="btn btn-primary pull-right">Batal</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @else
    @endif
@endsection

@section('javascript')
    <script>
        // Fungsi untuk menambahkan data ke tabel dan menghapus opsi dari select
        function tambahkanData() {
            namaBarang = $("#nama_barang").val();
            jumlahBarang = $("#jumlah_barang").val();
            keterangan = $("#keterangan").val();

            split = namaBarang.split('-');

            if (jumlahBarang != '') {
                var newRow = $("<tr>");
                newRow.append("<td>" + split[0] + "</td>");
                newRow.append("<td>" + split[1] + "</td>");
                newRow.append("<td>" + jumlahBarang + "</td>");
                newRow.append("<td>" + keterangan + "</td>");
                newRow.append("<td><button class='btn btn-danger btn-hapus'>Hapus</button></td>");

                $("#tabel-stok tbody").append(newRow);
                $("#nama_barang option[value='" + namaBarang + "']").remove();

                $('#jumlah_barang').val("");
                $('#keterangan').val("");
            }


        }

        // Fungsi untuk menghapus baris tabel saat tombol "Hapus" diklik
        $(document).on("click", ".btn-hapus", function() {
            var nomor = $(this).closest("tr").find("td:first").text();
            var namaBarang = $(this).closest("tr").find("td:eq(1)").text();
            // console.log(namaBarang2);
            var option = "<option value='" + nomor + '-' + namaBarang + "'>" + namaBarang + "</option>";

            // Menambahkan kembali opsi yang dihapus dari elemen select
            $("#nama_barang").append(option);

            $(this).closest("tr").remove();
        });

        $('#kirimDataButton').click(function() {
            var id = '{{ $stok_opname->id }}'
            var tableData = [];
            // Loop melalui baris tabel (kecuali baris header)
            $('#tabel-stok tbody tr').each(function() {
                var row = {};
                row.id = $(this).find('td:eq(0)').text(); // Kolom id
                row.nama = $(this).find('td:eq(1)').text(); // Kolom nama
                row.jumlah = $(this).find('td:eq(2)').text(); // Kolom Jumlah
                row.keterangan = $(this).find('td:eq(3)').text(); // Kolom keterangan
                // Tambahkan data ke array
                tableData.push(row);
            });

            console.log(tableData);
            // Kirim data ke controller melalui permintaan AJAX
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/simpan-pengecekan-stok/' + id,
                method: "post",
                data: {
                    Vdata: tableData,
                },
                success: function(data) {
                    if (data.msg == 'success') {
                        swal("Success", 'Perhitunggan berhasil dikirimkan', "success");

                        setTimeout(function() {
                            window.location.replace("/stok-opname");
                        }, 1000);

                    }
                },
                error: function(xhr, status, error) {
                    // Callback yang dipanggil ketika terjadi kesalahan
                    console.error("Terjadi kesalahan: " + error);
                }
            });
        });
    </script>
@endsection
