@extends('tamplate')

@section('judul')
    <p>Detail Laporan Penjualan </p>
@endsection

@section('konten')
    <div class="clearfix"></div>


    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <div class="col-md form-group has-feedback">
        </div>
        <div class="col-md-5 form-group has-feedback">
            <div id="reportrange" class="form-control">
                <i class="fa fa-calendar"></i>&nbsp;
                <span></span> <b class="caret"></b>
            </div>
        </div>
    </div>
    <br>

    <table id="datatable" class="table table-striped jambo_table bulk_action" style="width:100%">
        <thead>
            <tr>
                <th>Nomor Nota</th>
                <th>Tanggal</th>
                <th>Nama Pelanggan</th>
                <th>Sub Total</th>
                <th>Total Bayar</th>
                <th>Jenis Pembayaran</th>
                <th>Outlet</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody> 
            @foreach ($penjualan as $p)
                <tr id="tr_{{ $p->id }}">
                    <td>{{ $p->nomor_nota }}</td>
                    <td>{{ $p->tanggal }}</td>
                    <td>{{ $p->pelanggan->nama }}</td>
                    <td>{{ number_format($p->total_harga, 0, ',', '.') }}</td>
                    <td>{{ $p->total_bayar }}</td>
                    <td>{{ $p->jenis_pembayaran->nama }}</td>
                    <td>{{ $p->outlet->nama }}</td>
                    <td><a href="#" data-toggle="modal" data-target=".modal-detail-penjualan"
                            onclick="getDetail({{ $p->id }})">Detail</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Detail modal -->

    <div class="modal fade modal-detail-penjualan" id="modalPembelian" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <button type="button" class="btn btn-secondary" id="dismis" data-dismiss="modal"></button>
            <div class="modal-content" id="detailNota">
                MODAL
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
                [1, 'desc']
            ]
        });

        $.fn.dataTableExt.afnFiltering.push(
            function(settings, data, dataIndex) {
                var min = minDate;
                var max = maxDate;
                var date = data[1] || 0; // Our date column in the table

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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function getDetail(id) {
            console.log('masok');

            $.ajax({
                type: 'POST',
                url: '{{ route('getDetail') }}',
                data: {
                    'id': id,
                },
                success: function(data) {
                    // console.log(data.msg);
                    $('#detailNota').html(data.msg);
                },
                error: function() {
                    alert("error!!!!");
                }
            });
        }
    </script>
    <script>
        function rupiah(val) {
            rupiahFormat = val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            return rupiahFormat;
        }

        function printCertificate() {

            var printContents = document.getElementById('detailNota').innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            location.reload();
        }
    </script>
@endsection
