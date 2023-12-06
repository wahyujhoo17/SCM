@foreach ($produk->barang as $item)
    <tr>
        <td><input class="form-control-plaintext" value = "{{ $item->nomor }}" name ="nomor[]"></td>
        <td><input class="form-control-plaintext" value = "{{ $item->nama }}" name ="bahan[]"></td>
        <td><input class="form-control-plaintext" value = "{{ $item->pivot->jumlah . ' ' . $item->pivot->satuan }}"
                name ="jumlah[]"></td>
        <td><button type="button" class="btn btn-danger btn-hapus">Hapus</button></td>
        
        <script>
            removeOption('{{ $item->nomor."-".$item->satuan->nama }}');
        </script>
    </tr>
@endforeach


