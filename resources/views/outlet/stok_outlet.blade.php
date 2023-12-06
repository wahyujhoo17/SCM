@extends('tamplate')

@section('judul')
    <p>Stok Outlet {{ $data->nama }} </p>
@endsection

@section('konten')
    <div class="clearfix"></div>
    <table id="datatable" class="table table-striped jambo_table bulk_action" style="width:100%">
        <thead>
            <tr>
                <th>No Produk</th>
                <th>Nama</th>
                <th>Stok</th>
                <th>Harga Jual</th>

            </tr>
        </thead>

        <tbody>
            @foreach ($data->produk as $p)
                <tr id="tr_{{ $p->id }}">
                    <td>{{ $p->produk_id }}</td>
                    <td>{{ $p->nama }}</td>
                    <td>{{ $p->pivot->jumlah }}</td>
                    <td>{{ number_format($p->harga_jual, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
