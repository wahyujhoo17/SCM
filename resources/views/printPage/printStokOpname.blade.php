<div class="container" style="padding-left: 10%; padding-right:10%;">
    <div class="row">
        <div class="col-md-12">
            <h2 class="text-center">Stok Opname</h2>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <p><strong>No.SPK:</strong> {{ $stok_opname->nomor }}</p>
                    <p><strong>Tanggal SPK:</strong> {{ $stok_opname->tanggal_SPK }}</p>
                    <p><strong>Penanggung Jawab:</strong> {{ $stok_opname->pegawai->nama }}</p>
                    <p><strong>Nama Gudang:</strong> {{ $stok_opname->gudang->nama }}</p>
                </div>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th style="width:20%;">Nomor</th>
                        <th style="width: 20%;">Nama Produk</th>
                        @if (Auth::user()->jabatan->nama == 'admin')
                        <th style="width: 20%">Jumlah Sistem</th>
                        @endif

                        <th style="width: 20%; text-align: center ;">Jumlah Hitung</th>
                        <th style="width: 20%; text-align: center ;">Keterangan</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($gudang->produk as $item)
                        <tr>
                            <td>{{ $item->produk_id }}</td>
                            <td>{{ $item->nama }}</td>
                            @if (Auth::user()->jabatan->nama == 'admin')
                            <td style="text-align: center">{{ $item->pivot->jumlah }}</td>
                            @endif
                            <td style="text-align: center">..........</td>
                            <td style="text-align: center">..........</td>
                        </tr>
                    @endforeach
                    <!-- Tambahkan baris ini untuk setiap produk yang akan ditampilkan -->
                </tbody>
            </table>
        </div>
    </div>
</div>
