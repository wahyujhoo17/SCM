<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Detail Item</h5>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <div class="form-group">
                <label for="no_nota"> Nomor Nota :</label>
                <input type="text" id="no_nota" name="no_nota" class="form-control" readonly
                    value="{{ $produksi->nomor }}">
            </div>

            <div class="form-group">
                <label for="gudang"> Gudang :</label>
                <select name="gudang" id="gudang" class="form-control" style="width: 100%">
                    @foreach ($gudang as $gd)
                        <option value="{{ $gd->id }}">{{ $gd->nama }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <br>
    <div style="border-top: 2px solid #E5E5E5;"></div><br>

    {{-- ADD-ITEM --}}
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <table class="table table-condensed table-striped">
                {{-- Table Body --}}

                <tr>
                    <th width="15%">#</th>
                    <th width="35%">Item Name</th>
                    <th width="12%">Quantity</th>
                </tr>
                <tr>
                    <td><input type="text" class="form-control-plaintext" value="{{ $produksi->produk->produk_id }}"></td>
                    <td>
                        <input type="text" class="form-control-plaintext" value="{{ $produksi->produk->nama }}">
                    </td>
                    <td><input type="number" name="quantity" value="{{ $produksi->jumlah_selesai }}"
                            id="quantity" class="form-control" autocomplete="off" readonly></td>
                </tr>

                {{-- BATAS --}}
            </table>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Tutup</button>
    <input type="submit" class="btn btn-primary" value="Konfirmasi">
</div>

<script>
    $(document).ready(function() {
        $("#gudang").select2();
    });
</script>
