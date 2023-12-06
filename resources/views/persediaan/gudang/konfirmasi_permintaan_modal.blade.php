<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Detail Permintaan</h5>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <div class="form-group">
                <label for="no_nota"> No Permintaan :</label>
                <input type="text" id="no_nota" name="nomorPermintaan" class="form-control" readonly value="{{ $permintaan->nomor }}">
            </div>

            <div class="form-group">
                <label for="gudang"> Gudang :</label>
                <select name="gudang" id="gudang" class="form-control">
                    <option value="{{ $permintaan->gudang->id }}">{{ $permintaan->gudang->nama }}</option>
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
                    <th width="15%">No Produk</th>
                    <th width="35%">Nama</th>
                    <th width="12%">Jumlah</th>
                </tr>

                @php
                    $row = 0;
                @endphp
                @foreach ($permintaan->produk as $item)
                    @php
                        $row++;
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
                        <td><input type="text" class="form-control-plaintext" name="produk_id[]" value="{{ $item->produk_id }}" readonly ></td>
                        <td><input type="text" class="form-control-plaintext" value="{{ $item->nama }}" readonly ></td>
                        <td><input type="number" class="form-control" name="jumlah[]" value="{{(int)$item->pivot->jumlah}}"></td>
                    </tr>
                @endforeach

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
