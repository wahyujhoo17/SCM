<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <h2 class="text-center">Laporan Hasil Stok Opname</h2>
            <div class="text-right">
                <div class="col-sm-11 invoice-col">
                    <b>{{ $stok_opname->nomor }}</b>
                    <br>
                    <b>Penanggung jawab :</b> {{ $stok_opname->pegawai->nama }}
                    <br>
                    <b>Nama Gudang :</b> {{ $stok_opname->gudang->nama }}
                    <br>
                    <b>Tanggal Mulai :</b> {{ $stok_opname->tanggal_mulai }}
                    <br>
                    <b>Tanggal Eksekusi :</b> {{ $stok_opname->tanggal_eksekusi }}
                    <br>
                    <b>Tanggal Selesai :</b> {{ $stok_opname->tanggal_selesai }}

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tabel Data Stok Opname -->
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered" style="margin: auto ; width:90%; hight:90%;">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Produk</th>
                        <th>Stok Perhitungan</th>
                        @if (Auth::user()->jabatan->nama == 'admin')
                            <th>Stok Sistem</th>
                            <th>Selisih</th>
                            <th>Keterangan</th>
                        @endif

                    </tr>
                </thead>
                <tbody>
                    <!-- Isi data stok opname di sini -->
                    @foreach ($stok_opname->produk as $item)
                        <tr>
                            <td>{{ $item->produk_id }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->pivot->jumlah_perhitungan }}</td>
                            @if (Auth::user()->jabatan->nama == 'admin')
                                <td>{{ $item->pivot->jumlah_sistem }}</td>

                                @if ($item->pivot->keterangan == 'Kurang')
                                    <td style="background-color: red">
                                        {{ $item->pivot->selisih . ' ' . $item->pivot->keterangan }}</td>
                                @elseif($item->pivot->keterangan == 'Lebih')
                                    <td style="background-color: yellow">
                                        {{ $item->pivot->selisih . ' ' . $item->pivot->keterangan }}</td>
                                @else
                                    <td>{{ $item->pivot->keterangan }}</td>
                                @endif
                                <td>{{ $item->pivot->keterangan2 }}</td>
                            @endif

                        </tr>
                    @endforeach
                    <!-- Anda bisa menambahkan lebih banyak baris data di sini -->
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- Tombol Konfirmasi dan Batal -->
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-md-12">
            <div class="text-right mr-5">
                <button class="btn btn-secondary" data-dismiss="modal">Tutup</button> <!-- Tombol Batal -->

                @if (Auth::user()->jabatan->nama == 'admin')
                    @if ($stok_opname->status != 'selesai')
                        <button class="btn btn-primary" onclick="review({{ $stok_opname->id }})">Konfirmasi</button>
                        <!-- Tombol Konfirmasi -->
                    @else
                    @endif

                @endif

            </div>
        </div>
    </div>
</div>
