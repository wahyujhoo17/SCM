@extends('tamplate')

@section('judul')
    <p>Mutasi Stok</p>
@endsection

@section('konten')
    <!-- Date Range Filter -->
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
                <th>Nomor</th>
                <th>Produk</th>
                <th>Stok Sebelum</th>
                <th>Stok Setelah</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($data as $ms)
                <tr id="tr_{{ $ms->id }}">
                    <td>{{ $ms->nomor }}</td>
                    <td>{{ $ms->produk->nama }}</td>
                    <td>{{ $ms->stok_sebelum }}</td>
                    <td>{{ $ms->stok_sesudah }}</td>
                    <td>{{ $ms->tanggal }}</td>
                    <td>{{ $ms->keterangan }}</td>
                </tr>
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
                var min = minDate;
                var max = maxDate;
                var date = data[4] || 0; // Our date column in the table

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
