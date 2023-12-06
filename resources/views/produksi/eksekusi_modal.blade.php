<div class="container mt-1" id="containerAjx">
    <div class="row invoice-info">
        <div class="col-sm-6 invoice-col">
            <address style="display: flex; flex-direction: column;">

                <div style="display: flex;">
                    <strong style="min-width: 150px;">Nomor</strong>
                    <span>: <strong>{{ $produksi->nomor }}</strong> </span>
                </div>

                <div style="display: flex;">
                    <strong style="min-width: 150px;">Penanggung Jawab</strong>
                    <span>: {{ $produksi->pegawai->nama }}</span>
                </div>

                <div style="display: flex;">
                    <strong style="min-width: 150px;">Nama Produk</strong>
                    <span>: {{ $produksi->produk->nama }}</span>
                </div>

                <div style="display: flex;">
                    <strong style="min-width: 150px;">Jumlah Produksi</strong>
                    <span>: {{ $produksi->jumlah_produksi }}</span>
                </div>

            </address>

        </div>
        <!-- /.col -->
        <div class="col-sm-6 invoice-col">
            <br>
            <address style="display: flex; flex-direction: column;">
                {{-- <strong>{{ $invoice->pelanggan->nama }}</strong> --}}

                <div style="display: flex;">
                    <strong style="min-width: 150px;">Tanggal Ditambahkan</strong>
                    <span>: {{ $produksi->tanggal_ditambahkan }} </span>
                </div>
                <div style="display: flex;">
                    <strong style="min-width: 150px;">Tanggal Eksekusi</strong>
                    <span>: {{ $produksi->tanggal_mulai }} </span>
                </div>
                <div style="display: flex;">
                    <strong style="min-width: 150px;">Tanggal Selesai</strong>
                    <span>: {{ $produksi->tanggal_selesai }}</span>
                </div>
            </address>

        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-12">
            <table class="table table-striped jambo_table bulk_action">
                <thead>
                    <tr>
                        <th>#</th>
                        <th scope="col">Nama Barang</th>
                        <th scope="col">Jumlah</th>
                        <th scope="col">Satuan</th>
                        <th scope="col">Tempat</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($produksi->barang as $item)
                        <tr>
                            <td>{{ $item->nomor }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->pivot->jumlah }}</td>
                            <td>{{ $item->satuan->nama }}</td>

                            @foreach ($gudang as $gd)
                                @if ($gd->id == $item->pivot->gudang_id)
                                    <td>{{ $gd->nama }}</td>
                                @endif
                            @endforeach

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-12 text-right">
            <button type="button" class="btn btn-secondary" onclick="closeModal()" data-dismiss="modal">Tutup</button>

            @if ($produksi->pegawai->id == Auth::user()->id)

                @if ($status == 'Dalam Antrian')
                    <button class="btn btn-primary" id="eksekusi">Eksekusi</button>
                @elseif($status == 'Eksekusi')
                    <button class="btn btn-primary" id="selesai">Selesai</button>
                @else
                @endif
            @endif
        </div>
    </div>

    <form action="/acuan-produksi/tambahkan" method="POST" id="sending">
        @csrf
        <input type="text" name="produksi" id="produksi" value="{{ $produksi->id }}" hidden>
    </form>
</div>

<!-- Bootstrap Modal for Confirmation -->
<form action="/acuan-produksi/tambahkan" method="POST" id="sending">
    @csrf

    <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog"
        aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Konfirmasi Selesai</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="text" name="produksi" id="produksi" value="{{ $produksi->id }}" hidden>

                    <p>Produk Selesai Dibuat : </p>
                    <input type="number" class="form-control" name="produkJumlah" id="produkJumlah" required" value="{{ (int)$produksi->jumlah_produksi }}"><br>

                    <h5>Kelebihan Barang</h5>
                    <table id="barang_lebih" class="table table-striped jambo_table bulk_action">
                        <thead>
                            <tr>
                                <td>#</td>
                                <td>Nama</td>
                                <td>Jumlah</td>
                                <td>Satuan</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($produksi->barang as $item)
                                <tr>
                                    <td><input class="form-control-plaintext" type="text" name="id[]"
                                            id="id" value="{{ $item->nomor }}" readonly></td>
                                    <td><input type="text" class="form-control-plaintext" name="barang[]"
                                            value="{{ $item->nama }}" readonly></td>
                                    <td><input type="text" class="form-control" name="jumlah[]" value="0"></td>
                                    <td><input type="text" class="form-control-plaintext" name="satuan[]"
                                            value="{{ $item->satuan->nama }}"></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <label for="leterangan">Keterangan</label>
                    <textarea class="form-control" name="keterangan" id="" cols="3" rows="2"></textarea>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModalCon()">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="confirmButton">Konfirmasi</button>
                </div>
            </div>
        </div>
    </div>
</form>


<script>
    $("#eksekusi").on("click", function() {
        $("#sending").submit();
    });

    $("#selesai").on("click", function() {

        $("#confirmationModal").modal("show");
        $("#containerAjx").addClass("blurred");
    });

    function closeModalCon() {
        $("#confirmationModal").modal("hide");
    }

    $("#confirmationModal").on("hidden.bs.modal", function() {

        $("#containerAjx").removeClass("blurred");
    });
</script>
