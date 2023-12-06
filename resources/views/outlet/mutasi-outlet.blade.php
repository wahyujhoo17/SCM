@extends('tamplate')

@section('judul')
    <p>Mutasi Outlet {{ $outlet->nama }}</p>
@endsection

@section('konten')
    <div class="clearfix"></div>
    <div class="col-md-5 form-group has-feedback float-right">
        <div id="reportrange" class="form-control">
            <i class="fa fa-calendar"></i>&nbsp;
            <span></span> <b class="caret"></b>
        </div>
    </div>

    <table id="datatable" class="table table-striped jambo_table bulk_action" style="width:100%">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>No Produk</th>
                <th>Nama Produk</th>
                <th>Status</th>
                <th>Jumlah</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            {{-- MASUK --}}
            @foreach ($permintaan as $p)
                @foreach ($p->produk as $item)
                    <tr>
                        <td>{{ $p->tanggal }}</td>
                        <td>{{ $item->produk_id }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>Masuk</td>
                        <td>{{ $item->pivot->jumlah }}</td>
                        <td>Produk Masuk Berdasarkan Nota Permintaan : {{ $p->nomor }}</td>
                    </tr>
                @endforeach
            @endforeach

            {{-- KELUAR --}}
            @foreach ($penjualan as $pn)
                @foreach ($pn->produk as $item)
                    <tr>
                        <td>{{ explode(' ', $pn->tanggal)[0] }}</td>
                        <td>{{ $item->produk_id }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>Keluar</td>
                        <td>{{ $item->pivot->jumlah }}</td>
                        <td>Produk keluar berdasarkan nota penjualan : {{ $pn->nomor_nota }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
@endsection

@section('javascript')
    <script>
        let minDate, maxDate;
        $(function() {

            var start = moment().subtract(29, 'days');
            var end = moment();

            function cb(start, end) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

                // Create date inputs
                minDate = start.format('YYYY-MM-DD');
                maxDate = end.format('YYYY-MM-DD');

                table.draw();
            }

            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')]
                }
            }, cb);

            cb(start, end);

            // console.log(minDate);
        });


        // Set up your table
        table = $('#datatable').DataTable({
            "order": [
                [0, 'desc']
            ]
        });

        $.fn.dataTableExt.afnFiltering.push(
            function(settings, data, dataIndex) {
                var min = minDate;
                var max = maxDate;
                var date = data[0] || 0; // Our date column in the table

                if (
                    (min === null && max === null) ||
                    (min === null && date <= max) ||
                    (min <= date && max === null) ||
                    (min <= date && date <= max)
                ) {
                    return true;
                }
                return false;

            }
        );
    </script>
@endsection
