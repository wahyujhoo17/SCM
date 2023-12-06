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

    <canvas id="myChart" height="100"></canvas>
@endsection

@section('javascript')
    <script>
        let minDate, maxDate;
        $(function() {

            var start = moment().startOf('year');
            var end = moment();

            function cb(start, end) {
                $('#reportrange span').html(start.format('MMMM YYYY') + ' - ' + end.format('MMMM YYYY'));

                // Create date inputs
                minDate = start.format('MMMM YYYY');
                maxDate = end.format('MMMM YYYY');

                table.draw();

                updateChart();
            }
            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
                    'Bulan Kemarin': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')],
                    'Tahun Ini': [moment().startOf('year'), moment()],
                    'Tahun Kemarin': [moment().subtract(2, 'year').startOf('year'), moment().subtract(1,
                        'year').endOf('year    ')],
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

    <script>
        // Read data from the table
        // var table = document.getElementById('table');


        var labels = [];
        var data = [];


        // Create a chart
        var ctx = document.getElementById('myChart').getContext('2d');
        var charts = new Chart(ctx, {
            type: 'bar', // You can use 'bar', 'line', 'pie', etc.
            data: {
                labels: labels,
                datasets: [{
                    label: 'Penjualan',
                    data: data,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                // Customize chart options as needed
            }
        });

        function updateChart() {

            var table = document.getElementById('table');

            var labels = [];
            var data = [];

            for (var i = 1; i < table.rows.length; i++) {
                var row = table.rows[i];
                var label = row.cells[0].textContent;
                var value = parseInt(row.cells[1].textContent.replace(/[^0-9]/g, ''));

                labels.push(label);
                data.push(value);
            }

            charts.data.labels = labels;
            charts.data.datasets[0].data = data;
            charts.update();
        }

    </script>
@endsection
