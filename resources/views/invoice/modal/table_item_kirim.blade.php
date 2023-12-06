<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <table class="table table-condensed table-striped" id="invoiceItem">
        <tr>
            <th width="2%">
                <div class="custom-control custom-checkbox mb-3">
                    <input type="checkbox" class="custom-control-input" id="checkAll" name="checkAll">
                    <label class="custom-control-label" for="checkAll"></label>
                </div>
            </th>
            <th width="15%">Item No</th>
            <th width="35%">nama</th>
            <th width="12%">Jumlah</th>
            <th>Stok Gudang</th>
            <th>Nama Gudang</th>
        </tr>

        @php
            $row = 0;
        @endphp

        @foreach ($pesanan->produk as $item)
            @php
                $row++;
            @endphp
            <tr>
                <td>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="itemRow custom-control-input" id="itemRow_{{ $row }}">
                        <label class="custom-control-label" for="itemRow_{{ $row }}"></label>
                    </div>
                </td>

                <td>
                    <input type="text" class="form-control-plaintext" value="{{ $item->produk_id }}" readonly>
                </td>

                <td>
                    <select name="productId[]" id="productId_{{ $row }}" class="form-control-plaintext">
                        <option selected value="{{ $item->id }}">{{ $item->nama }}</option>
                    </select>
                </td>

                <td><input type="number" name="quantity[]" value="{{ $item->pivot->jumlah }}"
                        id="quantity_{{ $row }}" class="form-control-plaintext" autocomplete="off" readonly>
                </td>

                <td><input type="number" id="stokGudang_{{ $row }}" class="form-control-plaintext" readonly
                        value="{{ $item->gudang[0]->pivot->jumlah }}"></td>

                <td>
                    <select name="gudang[]" id="gudang_{{ $row }}" class="form-control"
                        onchange="gudahOnchange(this.value , this.id)">
                        @foreach ($item->gudang as $gd)
                            @if ($gd->pivot->jumlah >= $item->pivot->jumlah)
                                <option value="{{ $gd->id . '-' . $gd->pivot->jumlah }}">{{ $gd->nama }}</option>
                            @endif
                        @endforeach
                    </select>
                </td>
            </tr>
        @endforeach
    </table>
</div>

<script>
    function gudahOnchange(params , id) {
        var splitStok = params.split('-');
        var id = id.replace("gudang_", "");
        $("#stokGudang_" + id).val(splitStok[1]);
    }
</script>
