@extends('tamplate')

@section('judul')
    <p> Perputaran Stok</p>
@endsection

@section('konten')
    <div class="clearfix"></div>


    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button"
                role="tab" aria-controls="nav-home" aria-selected="true">Barang Mentah</button>
            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button"
                role="tab" aria-controls="nav-profile" aria-selected="false">Produk</button>
        </div>
    </nav>

    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
            <br>
            <div class="table-responsive">
                <table class="table table-striped jambo_table bulk_action" id="datatable">
                    <thead>
                        <tr class="headings">
                            <th class="column-title">Nomor </th>
                            <th class="column-title">Nama Barang </th>
                            <th class="column-title">Tanggal</th>
                            <th class="column-title">Jumlah </th>
                            <th class="column-title">keterangan </th>
                            <th class="column-title">Status </th>
                            <th class="column-title">Gudang</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php
                            $urut = 0;
                        @endphp
                        {{-- {{ $pb }} --}}
                        @foreach ($pb as $b)
                            @foreach ($b->barang as $barang)
                                @php
                                    $urut += 1;
                                @endphp
                                <tr>
                                    <td>{{ $barang->nomor }}</td>
                                    <td>{{ $barang->nama }}</td>
                                    <td>{{ $b->tanggal }}</td>
                                    <td>{{ $barang->pivot->jumlah.' '.$barang->satuan->nama }}</td>
                                    <td>{{ $b->keterangan }}</td>
                                    <td>{{ $b->status }}</td>
                                    <td>{{ $b->gudang_id }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab"><br>
            <div class="table-responsive">
                <table class="table table-striped jambo_table bulk_action" id="datatable2">
                    <thead>
                        <tr class="headings">
                            <th class="column-title">No </th>
                            <th class="column-title">Nama Produk </th>
                            <th class="column-title">Tanggal</th>
                            <th class="column-title">Jumlah </th>
                            <th class="column-title">keterangan </th>
                            <th class="column-title">Status </th>
                            <th class="column-title">Gudang</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php
                        $urut = 0;
                    @endphp
                    @foreach ($pp as $p)
                        @foreach ($p->produk as $produk)
                            @php
                                $urut += 1;
                            @endphp
                            <tr>
                                <td>{{ $urut }}</td>
                                <td>{{ $produk->nama }}</td>
                                <td>{{ $p->tanggal }}</td>
                                <td>{{ $produk->pivot->jumlah }}</td>
                                <td>{{ $p->keterangan }}</td>
                                <td>{{ $p->status }}</td>
                                <td>{{ $p->gudang_id }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>

    <script>
        $('#datatable').dataTable({
            "order": [
                [2, 'desc']
            ]
        });

        $('#datatable2').dataTable({
            "order": [
                [2, 'desc']
            ]
        });
    </script>
@endsection
