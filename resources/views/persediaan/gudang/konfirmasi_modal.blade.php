<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Detail Item</h5>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <div class="form-group">
                <label for="no_nota"> No Nota :</label>
                <input type="text" id="no_nota" name="no_nota" class="form-control" readonly value="{{ $detaildata->no_nota }}">
            </div>

            <div class="form-group">
                <label for="gudang"> Gudang :</label>
                <select name="gudang" id="gudang" class="form-control">
                    @foreach($gudang as $gd)
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
                    <th width="2%">
                        <div class="custom-control custom-checkbox mb-3">
                            <input type="checkbox" class="custom-control-input" id="checkAll"
                                name="checkAll">
                            <label class="custom-control-label" for="checkAll"></label>
                        </div>
                    </th>
                    {{-- <th width="15%">Item No</th> --}}
                    <th width="35%">Item Name</th>
                    <th width="12%">Quantity</th>
                </tr>
                @php
                    $kodeid = explode('-', $detaildata->no_nota);
                    $row = 0;
                @endphp

                @if ($kodeid[0] == 'PB')
                    @foreach ($detaildata->barang as $item)
                        @php
                            $row += 1;
                        @endphp

                        <tr>
                            <td>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="itemRow custom-control-input"
                                        id="itemRow_{{ $row }}">
                                    <label class="custom-control-label"
                                        for="itemRow_{{ $row }}"></label>
                                </div>
                            </td>
                            <td>
                                <select name="item[]" id="item_{{ $row }}"
                                    class="form-control">
                                    <option selected value="{{ $item->id }}">{{ $item->nama }}
                                    </option>
                                </select>
                            </td>
                            <td><input type="number" name="quantity[]"
                                    value="{{ $item->pivot->jumlah }}"
                                    id="quantity_{{ $row }}" class="form-control"
                                    autocomplete="off"></td>

                        </tr>
                    @endforeach
                @else
                    @foreach ($detaildata->produk as $item)
                        <tr>
                            <td>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="itemRow custom-control-input"
                                        id="itemRow_{{ $row }}">
                                    <label class="custom-control-label"
                                        for="itemRow_{{ $row }}"></label>
                                </div>
                            </td>
                            <td>
                                <select name="item[]" id="item_{{ $row }}"
                                    class="form-control">
                                    <option selected value="{{ $item->id }}">{{ $item->nama }}
                                    </option>
                                </select>
                            </td>
                            <td><input type="number" name="quantity[]"
                                    value="{{ $item->pivot->jumlah }}"
                                    id="quantity_{{ $row }}" class="form-control"
                                    autocomplete="off"></td>

                        </tr>
                    @endforeach
                @endif

                {{-- BATAS --}}
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <button class="btn btn-danger delete" id="removeRows" type="button">- Delete</button>
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