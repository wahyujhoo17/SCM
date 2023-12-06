@extends('tamplate')

@section('judul')
    <p>Metode Perhitungan Stok</p>
@endsection
@section('konten')
    <div class="clearfix"></div><br>
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button"
                role="tab" aria-controls="nav-home" aria-selected="true">EOQ</button>
            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button"
                role="tab" aria-controls="nav-profile" aria-selected="false">Safety Stok</button>
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        
        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
            {{-- EOQ --}}
            <h4 class="mt-3">EOQ</h4>
            <label for="eoqTable">Data EOQ diambil dari tanggal {{ explode(' ', $tanggal[0])[0] }} sampai
                {{ explode(' ', $tanggal[1])[0] }}</label>
            <table id="eoqTable" class="table table-striped jambo_table bulk_action" style="width:100%">
                <thead>
                    <tr>
                        <th>Nomor</th>
                        <th>Nama Produk</th>
                        <th>Jumlah Kebutuhan</th>
                        <th>Analisa EOQ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($eoq as $id => $value)
                        <tr>
                            <td>{{ $value[1]->produk_id }}</td>
                            <td>{{ $value[1]->nama }}</td>
                            <td>{{ $value[2] }}</td>
                            <td>{{ $value[0] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- SS --}}
        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
            <h4 class="mt-3">Data Safety Stok Produk</h4>
            <table id="datatable" class="table table-striped jambo_table bulk_action" style="width:100%">
                <thead>
                    <tr>
                        <th>Nomor Produk</th>
                        <th>Nama Produk</th>
                        <th>Safety Stok</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ss as $id => $value)
                        <tr>
                            <td>{{ $value[2] }}</td>
                            <td>{{ $value[1] }}</td>
                            <td>{{ $value[0] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('javascript')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script>
        $('#eoqTable').DataTable({
            "order": [
                [0, 'desc']
            ] // Assuming you want to order by the first column (index 0) in descending order
        });
    </script>
@endsection
