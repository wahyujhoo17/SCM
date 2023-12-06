@php
    $row =0;
@endphp
@foreach ($produk->barang as $item)
    @php
        $row++;
        $stok = false;
    @endphp

    <tr>
        <td><input class="form-control-plaintext" value = "{{ $item->nomor }}" name ="nomor[]"></td>
        <td><input class="form-control-plaintext" value = "{{ $item->nama }}" name ="bahan[]"></td>
        <td><input class="form-control" value = "{{ $item->pivot->jumlah * $kuantitas}}" name ="jumlah[]"></td>
        <td><input class="form-control-plaintext" value = "{{ $item->pivot->satuan }}" name ="satuan[]"></td>
        <td><input type="text" class="form-control-plaintext" id="stokGudang_{{ $row }}"></td>
        <td>
            <select name="gudang[]" id="gudang_{{ $row }}" class="form-control" onchange="gudangFunc('{{ $row }}')" required>
                <option value="">Pilih gudang</option>
                @foreach ($item->gudang as $igd)
                    @if ($igd->pivot->jumlah >= $item->pivot->jumlah * $kuantitas)
                    @php
                        $stok = true;
                    @endphp
                        <option value="{{ $igd->id.'-'. $igd->pivot->jumlah}}">{{ $igd->nama }}</option>
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


