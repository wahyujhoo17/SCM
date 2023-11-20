<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <table class="table table-condensed table-striped" id="invoiceItem">
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
                    <select name="productId[]" id="productId_{{ $row }}" class="form-control">
                        <option selected value="{{ $item->id.'-'.$item->harga_jual}}">{{ $item->nama }}</option>
                    </select>
                </td>

                <td><input type="number" name="quantity[]" value="{{ $item->pivot->jumlah }}"
                        id="quantity_{{ $row }}" class="form-control" autocomplete="off"></td>

                <td><input type="number" name="price[]" id="price_{{ $row }}" value="{{ $item->harga_jual }}"
                        class="form-control" autocomplete="off"></td>

                <td><input type="number" name="total[]" value="{{ $item->pivot->jumlah * $item->harga_jual }}"
                        id="total_{{ $row }}" class="form-control" autocomplete="off" readonly></td>
            </tr>
        @endforeach

    </table>
</div>
