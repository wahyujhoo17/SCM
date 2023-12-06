<br><strong style="font-size: 18px;">Info Invoice</strong><br>
<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <label for="rNamaPelanggan">Nama Pelanggan</label>
        {{-- <input type="text" class="form-control" id="rNamaPelanggan" readonly value="{{ $pesanan->pelanggan->nama }}"> --}}
        <select class="form-control" name="rPelanggan" id="rNamaPelanggan">
            <option value="{{ $pesanan->pelanggan->id }}" selected>{{ $pesanan->pelanggan->nama }}</option>
        </select>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <label for="noInvoice">Nomor Invoice</label>
        <input type="text" class="form-control" name="noInvoice" id="rNoInvoice" readonly value="{{ $idG }}">
    </div>
</div><br>

<script>
    
    var address = `{{($pesanan->pelanggan->alamat)}}` ;
    document.getElementById("alamat_pelanggan").value = address;
    $('#subTotal').val(rupiah({{ $pesanan->total_harga }}));
    $('#totalFinal').val(rupiah({{ $pesanan->total_harga }}));
</script>
