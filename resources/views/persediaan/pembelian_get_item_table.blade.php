<tr>
    <th width="2%">
        <div class="custom-control custom-checkbox mb-3">
            <input type="checkbox" class="custom-control-input" id="checkAll" name="checkAll">
            <label class="custom-control-label" for="checkAll"></label>
        </div>
    </th>
    {{-- <th width="15%">Item No</th> --}}
    <th width="35%">Item Name</th>
    <th width="12%">Quantity</th>
    <th width="20%">Price</th>
    <th width="20%">Total</th>
</tr>
@php
    $kodeid = explode('-', $pemesanan->no_nota);
    $row = 0;
@endphp

@if ($kodeid[0] == 'NB')

    @foreach ($pemesanan->barang as $item)
        @php
            $row += 1;
        @endphp

        <tr>
            <td>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="itemRow custom-control-input" id="itemRow_{{ $row }}">
                    <label class="custom-control-label" for="itemRow_{{ $row }}"></label>
                </div>
            </td>
            <td>
                <select name="item[]" id="item_{{ $row }}" class="form-control">
                    <option selected value="{{ $item->id }}">{{ $item->nama }}</option>
                </select>
            </td>
            <td><input type="number" name="quantity[]" value="{{ $item->pivot->jumlah_barang }}"
                    id="quantity_{{ $row }}" class="form-control" autocomplete="off"></td>

            <td><input type="number" name="price[]" id="price_{{ $row }}" value="{{ $item->harga_beli }}"
                    class="form-control" autocomplete="off"></td>

            <td><input type="number" name="total[]" value="{{ $item->pivot->jumlah_barang * $item->harga_beli }}"
                    id="total_{{ $row }}" class="form-control" autocomplete="off" readonly></td>
        </tr>
    @endforeach
@else
    @foreach ($pemesanan->produk as $item)
        <tr>
            <td>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="itemRow custom-control-input" id="itemRow_{{ $row }}">
                    <label class="custom-control-label" for="itemRow_{{ $row }}"></label>
                </div>
            </td>
            <td>
                <select name="item[]" id="item_{{ $row }}" class="form-control">
                    <option selected value="{{ $item->id }}">{{ $item->nama }}</option>
                </select>
            </td>
            <td><input type="number" name="quantity[]" value="{{ $item->pivot->jumlah_barang }}"
                    id="quantity_{{ $row }}" class="form-control" autocomplete="off"></td>

            <td><input type="number" name="price[]" id="price_{{ $row }}" value="{{ $item->harga_beli }}"
                    class="form-control" autocomplete="off"></td>

            <td><input type="number" name="total[]" value="{{ $item->pivot->jumlah_barang * $item->harga_beli }}"
                    id="total_1" class="form-control" autocomplete="off" readonly></td>
        </tr>
    @endforeach

@endif

<script>
    $('#namaC').html('{{ $pemesanan->pemasok->nama }}')
    $('#alamatC').html('{{ $pemesanan->pemasok->alamat }}')
    $('#notlpC').html('{{ $pemesanan->pemasok->no_tlp }}')
    $('#subTotal').val("{{number_format($pemesanan->total_harga, 0, ',','.') }}")
</script>