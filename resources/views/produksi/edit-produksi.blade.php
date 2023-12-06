<form action="/daftar-produksi/{{ $produksi->id }}" method="POST">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="form-group col-md-6">
            <label for="produk">Pilih produk</label>
            <select name="produk" id="produkU" class="form-control" style="width: 100%" required>
                <option value="">Pilih produk</option>
                @foreach ($produk as $item)
                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                @endforeach
            </select>
            <div class="invalid-feedback" id="warning"></div>
        </div>
        <div class="form-group col-md-6">
            <label for="kode">Kode Produksi</label>
            <input type="text" class="form-control" name="kode" id="kode" value="{{ $produksi->nomor }}"
                readonly>
        </div>
    </div>

    <div class="row">
        <div class="form-group col-md-6">
            <label for="pegawai">Penanggung jawab</label>
            <select name="pegawai" id="pegawaiU" class="form-control" required style="width: 100%;">
                <option value="">Pilih Pegawai</option>
                @foreach ($pegawai as $usr)
                    <option value="{{ $usr->id }}">{{ $usr->nama }}</option>
                @endforeach
            </select>
            <div class="invalid-feedback" id="warning"></div>
        </div>

        <div class="form-group col-md-4">
            <label for="kuantitas">Jumlah Produksi</label>
            <input type="number" name="kuantitas" id="kuantitasU" class="form-control" required
                value="{{ $produksi->jumlah_produksi }}">
            <div class="invalid-feedback" id="warning"></div>
        </div>
        <div class="form-group col-md-2">
            <label for="button" class="invisible">Button</label>
            <button type="button" class="btn btn-primary btn-block" id="proses"
                onclick="ubahProses()">Proses</button>
            <div id="warning"></div>
        </div>
    </div><br>
    <H4>Barang Mentah Diambil</H4>
    <div id="isiProduk">
        <table class="table table-striped jambo_table bulk_action">
            <thead>
                <tr>
                    <th>Nomor</th>
                    <th>Nama</th>
                    <th>Jumlah</th>
                    <th>Satuan</th>
                    <th>Stok Gudang</th>
                    <th>Gudang</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="tableBody2">
                @php
                    $row = 0;
                @endphp
                @foreach ($produksi->barang as $item)
                    @php
                        $row++;
                        $stok = false;

                    @endphp

                    <tr>
                        <td><input class="form-control-plaintext" value = "{{ $item->nomor }}" name ="nomor[]"></td>
                        <td><input class="form-control-plaintext" value = "{{ $item->nama }}" name ="bahan[]"></td>
                        <td><input class="form-control" value = "{{ $item->pivot->jumlah }}" name ="jumlah[]">
                        </td>
                        <td><input class="form-control-plaintext" value = "{{ $item->satuan->nama }}" name ="satuan[]">
                        </td>
                        <td><input type="text" class="form-control-plaintext" id="stokGudang_{{ $row }}">
                        </td>
                        <td>
                            <select name="gudang[]" id="gudang_{{ $row }}" class="form-control"
                                onchange="gudangFunc('{{ $row }}')" required>
                                <option value="">Pilih gudang</option>
                                @foreach ($item->gudang as $igd)
                                    @if ($igd->pivot->jumlah >= $item->pivot->jumlah)
                                        @php
                                            $stok = true;
                                            $selected = '';

                                            if ($igd->id == $item->pivot->gudang_id) {
                                                $selected = 'selected';
                                            }
                                        @endphp

                                        @if ($igd->id == $item->pivot->gudang_id)
                                            <script>
                                                $('#stokGudang_' + {{ $row }}).val('{{ $igd->pivot->jumlah }}')
                                            </script>
                                        @endif
                                        
                                        <option value="{{ $igd->id . '-' . $igd->pivot->jumlah }}"
                                            {{ $selected }}>{{ $igd->nama }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>

                        </td>
                        <td>
                            @if ($stok)
                                Tersedia
                            @else
                                Tidak Tersedia
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="closeModal()" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Ubah Produksi</button>
    </div>
</form>

<script>
    $('#produkU').val('{{ $produksi->produk_id }}');
    $("#produkU").select2();
    $("#pegawaiU").val('{{ $produksi->user_id }}');
    $("#pegawaiU").select2();
</script>
