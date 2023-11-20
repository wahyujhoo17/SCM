
                    <!-- Informasi Pelanggan -->
                    <div class="mb-3">
                        <strong>Nomor Pesanan : {{ $pesanan->nomor }}</strong>
                        <br>Tanggal : {{ explode(' ',$pesanan->tanggal)[0] }}
                        <br>Nama : {{ $pesanan->pelanggan->nama }}
                        <br>Alamat : {{ $pesanan->alamat_pengiriman }}
                        <br>No tlp : {{ $pesanan->pelanggan->no_tlp }}
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
