@extends('tamplate')

@section('judul')
    <p>Laporan Penjualan Harian</p>
@endsection
@section('konten')
    <div class="clearfix"></div><br>

    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <div class="filter">
                        <div id="reportrange" class="pull-right"
                            style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                            <i class="fa fa-calendar"></i>
                            <span></span> <b class="caret"></b>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <canvas id="myChart" style="width:100%;max-width:100%"></canvas>
                </div>
            </div>
        </div>
    </div>
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
                minDate = start.format('YYYY-MM-DD HH:mm:ss');
                maxDate = end.format('YYYY-MM-DD HH:mm:ss');
                chart(minDate, maxDate);

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
        });
    </script>

    {{-- CHART SCTYPT --}}

    <script>
        function chart(min, max) {

            var data = '<?php echo json_encode($penjualan); ?>'
            var penjualan = JSON.parse(data);
            // console.log(penjualan);

            var listValue = [];
            for (let index = 0; index < penjualan.length; index++) {

                var date = penjualan[index]['tanggal'];
                // listTime.push(date.getHours() + '.00');

                if (
                    (min === null && max === null) ||
                    (min === null && date <= max) ||
                    (min <= date && max === null) ||
                    (min <= date && date <= max)
                ) {

                    listValue.push({
                        tanggal: date
                    });
                }
            }

            //
            var result = [];
            listValue.reduce(function(res, value) {
                let onlyDate = value.tanggal.split(' ')[0];
                // console.log(onlyDate);

                if (!res[onlyDate]) {
                    res[onlyDate] = {
                        date: onlyDate,
                        cost: 0
                    };
                    result.push(res[onlyDate])
                }
                res[onlyDate].cost += 1;
                return res;
            }, {});

            //
            var listDate = [];
            var listPenjualan = [];
            //
            var startDate = min;
            var endDate = max;
            var dateMove = new Date(startDate);
            var strDate = startDate;

            console.log('--------------------');

            while (strDate < endDate) {
                strDate = dateMove.toISOString().slice(0, 10);

                const found = result.find(({
                    date
                }) => date === strDate);
                // console.log(found);

                if (found) {
                    listDate.push(strDate);
                    listPenjualan.push(found['cost'])
                } else {
                    listDate.push(strDate);
                    listPenjualan.push(0);
                }
                dateMove.add(1).day();
            };
            updateChart(listPenjualan, listDate);
        }
    </script>


    <script>
        const ctx = document.getElementById('myChart');

        var charts = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: '#Penjualan',
                    data: [],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                    }
                }
            }
        });

        function updateChart(data, label) {

            charts.data.labels = label;
            charts.data.datasets[0].data = data;
            charts.update();
            // console.log(label);
        }
    </script>
@endsection
