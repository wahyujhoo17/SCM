<div class="modal-body" id="printableContent">


<div class="row">
    <div class="col-md-8">
        <div class="row">
            <div class="col-md-3">
                <p><strong>Nomor </strong></p>
            </div>
            <div class="col-md-0">
                <strong>:</strong>
            </div>
            <div class="col-md-6">
                <strong>
                    <p id="alamat">{{ $pengiriman->nomor }}</p>
                </strong>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <p><strong>Pelanggan</strong></p>
            </div>
            <div class="col-md-0">
                <strong>:</strong>
            </div>
            <div class="col-md-5">
                <p id="alamat">{{ $pengiriman->pesanan->pelanggan->nama }}</p>
            </div>
        </div>


        <div class="row">
            <div class="col-md-3">
                <p><strong>Alamat</strong></p>
            </div>
            <div class="col-md-0">
                <strong>:</strong>
            </div>
            <div class="col-md-6">
                <p id="alamat">{{ $invoice->alamat_pengiriman }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Konten Nota Pengiriman lainnya disini -->

<table class="table mt-2">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Produk</th>
            <th scope="col">Jumlah</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($invoice->produk as $item)
            <tr>
                <td>{{ $item->produk_id }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->pivot->jumlah }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
</div>

<input type="text" name="keterangan" id="keterangan" hidden>

<!-- Bagian footer modal -->
<div class="modal-footer">
    <button class="btn btn-primary" onclick="printModal()">
        <i class="fas fa-print"></i> Cetak
    </button>
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>

    @if ($pengiriman->status != 'Selesai')
    <button type="submit" class="btn btn-primary" onclick="kirimPesanan()">Konfirmasi</button>
    @endif
    
</div>
