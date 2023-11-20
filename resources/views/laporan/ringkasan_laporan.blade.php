@extends('tamplate')
@section('judul')
    <p>Ringkasan Penjualan</p>
@endsection

@section('konten')
    <div class="clearfix"></div>

    <div class="col-md-5 form-group has-feedback float-right">
        <div id="reportrange" class="form-control">
            <i class="fa fa-calendar"></i>&nbsp;
            <span></span> <b class="caret"></b>
        </div>
    </div>

    <table id="table" class="table table-striped jambo_table bulk_action" style="width:100%">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Total Penjualan</th>
                <th>Laba Kotor</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $tp)
                @php
                    $labakotor = ($tp->total_penjualan * 5) / 100;
                @endphp
                <tr>
                    <td>{{ $tp->Bulan . ' ' . $tp->tahun }}</td>
                    <td>{{ 'Rp ' . number_format($tp->total_penjualan, 2, ',', '.') }}</td>
                    <td>{{ 'Rp ' . number_format($labakotor, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection


@section('javascript')
    <script>
        let minDate, maxDate;
        $(function() {

            var start = moment().subtract(1, 'year').startOf('month');
            var end = moment();

            function cb(start, end) {
                $('#reportrange span').html(start.format('MMMM YYYY') + ' - ' + end.format('MMMM YYYY'));

                // Create date inputs
                minDate = start.format('MMMM YYYY');
                maxDate = end.format('MMMM YYYY');

                table.draw();
            }
            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')],
                    'This Year': [moment().subtract(1, 'year').startOf('month'), moment()]
                }
            }, cb);

            cb(start, end);
        });


        // Set up your table
        table = $('#table').DataTable({
            dom: "<'row'<'col-md-3'l><'col-md-5'B><'col-md-4'f>>" +
                "<'row'<'col-md-12'tr>>" +
                "<'row'<'col-md-5'i><'col-md-7'p>>",
            buttons: [{
                    extend: 'copy',
                    className: 'btn btn-outline-secondary'
                },
                {
                    extend: 'csv',
                    className: 'btn btn-outline-secondary'
                },
                {
                    extend: 'print',
                    className: 'btn btn-outline-secondary   '
                }
            ],
            "order": [
                [0, 'desc']
            ]
        });

        $.fn.dataTableExt.afnFiltering.push(
            function(settings, data, dataIndex) {
                var min = new Date(minDate);
                var max = new Date(maxDate);
                var date = new Date(data[0]) || 0; // Our date column in the table

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
