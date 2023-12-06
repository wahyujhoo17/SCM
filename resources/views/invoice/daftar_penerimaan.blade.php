@extends('tamplate')

@section('judul')
    <p>Daftar Penerimaan</p>
@endsection

@section('konten')
    {{-- KONTEN --}}
    <div class="clearfix"></div>

    <div class="container">
        <div class="row">
            <div class="col-md-12 text-right">
                <button type="button" class="btn btn-round btn-success" data-toggle="modal" data-target="#myModal"
                    id="openModalBtn">Tambah Penerimaan</button>
            </div>
        </div>
    </div><br>

    <div class="col-md-5 form-group has-feedback float-right">
        <div id="reportrange" class="form-control">
            <i class="fa fa-calendar"></i>&nbsp;
            <span></span> <b class="caret"></b>
        </div>
    </div>

        {{-- TABLE PESANANN --}}
        <table class="table table-striped jambo_table bulk_action" id="table">
            <thead>
                <tr class="headings">
                    <th class="column-title">ID Penerimaan</th>
                    <th class="column-title">Invoice ID </th>
                    <th class="column-title">Nama Pelanggan</th>
                    <th class="column-title">Tanggal</th>
                    <th class="column-title">Tagihan</th>
                    <th class="column-title">Dibayar</th>
                    <th class="column-title">Sisa Tagihan</th>
                    <th class="column-title">Keterangan
                    </th>
                </tr>
            </thead>
    
            <tbody>
                @foreach ($pembayaran as $pm)
                    <tr>
                        <td>{{ $pm->nomor }}</td>
                        @foreach ($pm->invoice as $pi)
                            <td>{{ $pi->nomor }}</td>
                            <td>{{ $pi->pelanggan->nama }}</td>
                        @endforeach
                        
                        <td>{{ explode(' ' , $pm->tanggal )[0] }}</td>
                        <td>{{ 'Rp ' . number_format($pm->tagihan, 2, ',', '.') }}</td>
                        <td>{{ 'Rp ' . number_format($pm->total_bayar, 2, ',', '.')}}</td>
                        <td>{{ 'Rp ' . number_format($pm->sisa_tagihan, 2, ',', '.')}}</td>
                        <td>{{ $pm->keterangan }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>


    {{-- MODAL TAMBAH  --}}
    <div class="modal fade bd-example-modal-lg" id="myModal" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('daftar-penerimaan.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    {{-- HEADER --}}
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Penerimaan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    {{-- KONTEN --}}
                    <div class="modal-body">
                        {{-- NOMOR INVOICE --}}
                        <div class="form-group">
                            <label for="invoice">Pilih Nomor Invoice</label>
                            <select name="invoice" id="invoice" class="form-control" style="width: 100%"
                                onchange="getInvoice(this.value)">
                                    <option value="">Pilih No Invoice</option>
                                @foreach ($invoice as $inv)
                                    <option value="{{ $inv->id }}">{{ $inv->nomor }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- PELANGGAN --}}
                        <div class="form-row">
                            <div class="col-md-6">
                                <label for="namaPelanggan">Nama Pelanggan</label>
                                <input class="form-control" type="text" id="namaPelanggan" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="nomorPenerimaan">Nomor Penerimaan</label>
                                <input class="form-control" id="nomorPenerimaan" name="nomorPenerimaan" type="text"
                                    value="{{ $idG }}" readonly>
                            </div>
                        </div><br>
                        {{-- TAGIHAN --}}
                        <div style="border-top: 2px solid #E5E5E5;"></div>
                        <div class="form-row">
                            <div class="col-md-6">
                                <input class="form-control-plaintext text-muted h6" type="text"
                                    value="Sisa Tagihan Invoice" readonly>
                            </div>
                            <div class="col-md-6">
                                <input class="form-control-plaintext blockquote" style="text-align: right" id="sisaTagihan"
                                    name="sisaTagihan" type="text" value="Rp 0,00" readonly>
                            </div>
                        </div>

                        {{-- --- --}}
                        <div style="border-top: 2px solid #E5E5E5;"></div><br>
                        {{-- PEMBAYARAN --}}

                        <div class="form-row">
                            <div class="col-md-6">
                                <label for="jenisPembayaran">Pilih Jenis Pembayaran</label>
                                <select name="jenis_pembayaran" class="form-control" id="jenis_pembayaran"
                                    style="width: 100%">
                                    @foreach ($jenisPembayaran as $jp)
                                        <option value="{{ $jp->id }}">{{ $jp->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="nominal_bayar">Nominal Bayar</label>
                                <input type="text" class="form-control" name="nominal_bayar" id="nominal_bayar"
                                    style="text-align: right;" required>
                            </div>
                        </div><br>
                        {{-- --- --}}
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="2"> </textarea>
                        </div>

                    </div>
                    {{-- FOOTER --}}
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Tambah Penerimaan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('javascript')
    @if ($showModal)
        <script>
            $(document).ready(function() {
                $('#myModal').modal('show');
                $("#invoice").val({{ $id }});
                $("#invoice").select2();
                getInvoice({{ $id }});
            });
        </script>
    @endif

    @if (isset($alert))
        <script>
            swal("Success", 'Penerimaan berhasil ditambahkan !', "success");
        </script>
    @endif

    <script>
        //Alert Berhasil
        var msg = '{{ Session::get('alert') }}';
        var exist = '{{ Session::has('alert') }}';
        if (exist) {
            swal("Success", msg, "success");
        }

        $("#jenis_pembayaran").select2();

        function rupiah(val) {
            rupiahFormat = val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            return rupiahFormat;
        }

        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }

        var nominal_bayar = document.getElementById('nominal_bayar');
        nominal_bayar.addEventListener('keyup', function(e) {
            nominal_bayar.value = formatRupiah(this.value);
        });
    </script>

    <script>
        function getInvoice(id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'GET',
                url: '/daftar-penerimaan/' + id,
                data: {},
                success: function(data) {
                    $("#namaPelanggan").val(data.pelanggan);
                    $("#sisaTagihan").val("Rp " + rupiah(data.inv['tagihan']));
                    $("#totalTagihan").val("Rp " + rupiah(data.inv['tagihan']));
                },
                error: function() {
                    alert("error!!!!");
                }
            });
        }
    </script>

<script>
    let minDate, maxDate;
    $(function() {

        var start = moment().subtract(12, 'month');
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
            var date = data[3] || 0; // Our date column in the table

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
