<!-- Informasi Pelanggan -->
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div style="display: flex; flex-direction: column;">
                <div style="display: flex; margin-bottom: 5px;">
                    <strong style="min-width: 150px;">Nomor Pesanan </strong> : 
                     <span>{{ $pesanan->nomor }}</span>
                </div>
                <div style="display: flex; margin-bottom: 5px;">
                    <strong style="min-width: 150px;">Tanggal </strong> : 
                     <span>{{ explode(' ', $pesanan->tanggal)[0] }}</span>
                </div>
                <div style="display: flex; margin-bottom: 5px;">
                    <strong style="min-width: 150px;">Nama </strong> : 
                     <span>{{ $pesanan->pelanggan->nama }}</span>
                </div>
                <div style="display: flex; margin-bottom: 5px;">
                    <strong style="min-width: 150px;">Alamat </strong> : 
                     <span>{{ $pesanan->alamat_pengiriman }}</span>
                </div>
                <div style="display: flex;">
                    <strong style="min-width: 150px;">No tlp </strong> : 
                     <span>{{ $pesanan->pelanggan->no_tlp }}</span>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Tabel Produk -->
<table class="table">
    <thead>
        <tr>
            <th scope="col">No. Produk</th>
            <th scope="col">Nama Produk</th>
            <th scope="col">Harga</th>
            <th scope="col">Jumlah</th>
            <th scope="col">Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pesanan->produk as $item)
            <tr>
                <td>{{ $item->produk_id }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ number_format($item->pivot->harga_beli, 0, ',', '.') }}</td>
                <td>{{ $item->pivot->jumlah }}</td>
                <td>{{ number_format($item->pivot->harga_beli * $item->pivot->jumlah, 0, ',', '.') }}
                </td>
            </tr>
        @endforeach
        <!-- Tambahkan baris lainnya sesuai kebutuhan -->
    </tbody>
</table>

<!-- Subtotal -->
<div class="text-right">
    <h5>Subtotal: {{ 'Rp ' . number_format($pesanan->total_harga, 2, ',', '.') }}</h5>
</div><br>
