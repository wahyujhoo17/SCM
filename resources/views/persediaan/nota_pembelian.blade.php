@extends('tamplate')

@section('judul')
    <p> Nota Pembelian</p>
@endsection

@section('konten')
    <div class="clearfix"></div>

    <div class="container">
        <div class="row">
            <div class="col-md-12 text-right">
                <button type="button" onclick="" data-toggle="modal" data-target=".tambahNotaBeli"
                    class="btn btn-round btn-success">Tambah Nota Pembelian</button>
            </div>
        </div>
    </div>

    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button"
                role="tab" aria-controls="nav-home" aria-selected="true">Daftar</button>
            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button"
                role="tab" aria-controls="nav-profile" aria-selected="false">Diproses</button>
            <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button"
                role="tab" aria-controls="nav-contact" aria-selected="false">Selesai</button>

            {{-- Time Select --}}
            <div class="col-md-5 form-group has-feedback float-right">
                <div id="reportrange" class="form-control">
                    <i class="fa fa-calendar"></i>&nbsp;
                    <span></span> <b class="caret"></b>
                </div>
            </div>
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        {{-- Daftar --}}
        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
            <br>
            <div class="table-responsive">
                <table class="table table-striped jambo_table bulk_action" id="table">
                    <thead>
                        <tr class="headings">
                            <th class="column-title">No pembelian </th>
                            <th class="column-title">Tanggal </th>
                            <th class="column-title">Pemesan</th>
                            <th class="column-title">Pemasok </th>
                            <th class="column-title">Status </th>
                            <th class="column-title">Total</th>
                            <th class="column-title no-link last"><span class="nobr">Action</span>
                            </th>
                            <th class="bulk-actions" colspan="7">
                                <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span
                                        class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($nota as $notaP)
                            <tr class="even pointer" id="tr_{{ $notaP->no_nota }} ">
                                <td>{{ $notaP->no_nota }}</td>
                                <td>{{ $notaP->tanggal }}</td>
                                <td>{{ $notaP->pegawai->nama }}</td>
                                <td>{{ $notaP->pemasok->nama }}</td>
                                <td>
                                    @if ($notaP->status_pembelian == 'selesai')
                                        <span class="badge badge-pill badge-success">Selesai</span>
                                    @elseif($notaP->status_pembelian == 'diproses')
                                        <span class="badge badge-pill badge-primary">Proses</span>
                                    @elseif($notaP->status_pembelian == 'belum diterima')
                                        <span class="badge badge-pill badge-info">belum diterima</span>
                                    @elseif($notaP->status_pembelian == 'belum dibayar')
                                        <span class="badge badge-pill badge-info">belum dibayar</span>
                                    @else
                                        <span class="badge badge-pill badge-danger">Batal</span>
                                    @endif
                                </td>
                                <td>{{ 'Rp ' . number_format($notaP->total_harga, 2, ',', '.') }}</td>

                                <td class=" last"><a href="#" data-toggle="modal"
                                        data-target=".modal-detail-pembelian"
                                        onclick="detail('{{ $notaP->id }}')">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{-- DIPROSES --}}
        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
            <div class="table-responsive">
                <table class="table table-striped jambo_table bulk_action" id="datatable">
                    <thead>
                        <tr class="headings">
                            <th class="column-title">No pembelian </th>
                            <th class="column-title">Tanggal </th>
                            <th class="column-title">Pemesan</th>
                            <th class="column-title">Pemasok </th>
                            <th class="column-title">Status </th>
                            <th class="column-title">Total</th>
                            <th class="column-title no-link last"><span class="nobr">Action</span>
                            </th>
                            <th class="bulk-actions" colspan="7">
                                <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span
                                        class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                            </th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($nota as $notaP)
                            @if ($notaP->status_pembelian == 'diproses')
                                <tr class="even pointer" id="tr_{{ $notaP->no_nota }} ">
                                    <td>{{ $notaP->no_nota }}</td>
                                    <td>{{ $notaP->tanggal }}</td>
                                    <td>{{ $notaP->pegawai->nama }}</td>
                                    <td>{{ $notaP->pemasok->nama }}</td>
                                    <td><span class="badge badge-pill badge-primary">Proses</span></td>
                                    <td>{{ 'Rp ' . number_format($notaP->total_harga, 2, ',', '.') }}</td>

                                    <td class=" last"><a href="#">View</a>
                                    </td>
                                </tr>
                            @else
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{-- SELESAI --}}

        <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
            <div class="table-responsive">
                <table class="table table-striped jambo_table bulk_action" id="datatable">
                    <thead>
                        <tr class="headings">
                            <th class="column-title">No pembelian </th>
                            <th class="column-title">Tanggal </th>
                            <th class="column-title">Pemesan</th>
                            <th class="column-title">Pemasok </th>
                            <th class="column-title">Status </th>
                            <th class="column-title">Total</th>
                            <th class="column-title no-link last"><span class="nobr">Action</span>
                            </th>
                            <th class="bulk-actions" colspan="7">
                                <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span
                                        class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($nota as $notaP)
                            @if ($notaP->status_pembelian == 'selesai')
                                <tr class="even pointer" id="tr_{{ $notaP->no_nota }} ">
                                    <td>{{ $notaP->no_nota }}</td>
                                    <td>{{ $notaP->tanggal }}</td>
                                    <td>{{ $notaP->pegawai->nama }}</td>
                                    <td>{{ $notaP->pemasok->nama }}</td>
                                    <td><span class="badge badge-pill badge-success">Selesai</span></td>
                                    <td>{{ 'Rp ' . number_format($notaP->total_harga, 2, ',', '.') }}</td>

                                    <td class=" last"><a href="#">View</a>
                                    </td>
                                </tr>
                            @else
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- Detail modal -->

    <div class="modal fade modal-detail-pembelian" id="modalPembelian" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <button type="button" class="btn btn-secondary" id="dismis" data-dismiss="modal"></button>
            <div class="modal-content" id="detailNota">
                MODAL
            </div>
        </div>
    </div>
    <!-- END Modal -->

    <!-- Tambah Modal -->
    <form method="POST" action="{{ route('pembelian.store') }}">
        @csrf
        <div class="modal fade tambahNotaBeli" role="dialog" aria-labelledby="myExtraLargeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Nota Pembelian</h5>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <h3>No Pemesanan,</h3>
                                <div class="form-group">
                                    <select class="form-control py-4" name="pemesanan" id="pemesanan"
                                        style="width: 60%;">
                                        <option value="">Pilih Nota</option>
                                        @foreach ($pm as $pemesanan)
                                            <option value="{{ $pemesanan->no_nota }}">{{ $pemesanan->no_nota }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <h3>To,</h3>
                                <strong id="namaC"></strong><br>
                                <p id="alamatC"></p>
                                <p id="notlpC"></p>
                            </div>
                        </div>

                        <br>
                        <div style="border-top: 2px solid #E5E5E5;"></div><br>

                        {{-- ADD-ITEM --}}
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <table class="table table-condensed table-striped" id="invoiceItem">
                                    {{-- Table Body --}}

                                    {{-- BATAS --}}
                                </table>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12">
                                <button class="btn btn-danger delete" id="removeRows" type="button">- Delete</button>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                <div class="form-group mt-3 mb-3 ">
                                    <label>Biaya Pajak: &nbsp;</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text currency">%</span>
                                        </div>
                                        <input value="0" type="number" onchange="tambahan()" class="form-control"
                                            name="taxRate" id="taxRate">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                <div class="form-group mt-3 mb-3 ">
                                    <label>Biaya pengiriman: &nbsp;</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text currency">Rp</span>
                                        </div>
                                        <input value="0" type="number" onchange="tambahan()" class="form-control"
                                            name="pengiriman" id="biayaPengiriman">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                <div class="form-group mt-3 mb-3 ">
                                    <label>Total: &nbsp;</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text currency">Rp</span>
                                        </div>
                                        <input value="0" type="text" class="form-control" name="totalAftertax"
                                            id="subTotal" placeholder="Total" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Tutup</button>
                        <input type="submit" class="btn btn-primary" value="Buat Nota">
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('javascript')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>

    <script>
        $(document).ready(function() {
            $("#pemesanan").select2();
        });

        $(document).on('click', '#removeRows', function() {
            $(".itemRow:checked").each(function() {
                $(this).closest('tr').remove();
                count -= 1;
            });
            $('#checkAll').prop('checked', false);
            calculateTotal();
        });
        $(document).on('click', '#checkAll', function() {
            $(".itemRow").prop("checked", this.checked);
        });

        //Alert Berhasil
        var msg = '{{ Session::get('alert') }}';
        var exist = '{{ Session::has('alert') }}';
        if (exist) {
            swal("Success", msg, "success");
        }
    </script>

    <script>
        // If NO PEMESANAN IN CHANGE
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#pemesanan').change(function() {

            id = $('#pemesanan').val();
            const jenis = id.split("-");
            if (id != '') {
                $.ajax({
                    type: 'POST',
                    url: '{{ route('getItemPembelian') }}',
                    data: {
                        'id': id,
                    },
                    success: function(data) {
                        // console.log(data.msg);
                        $('#invoiceItem').html(data.msg);
                    },
                    error: function() {
                        alert("error!!!!");
                    }
                });
            } else {
                $('#invoiceItem').html("");
                $('#namaC').html('')
                $('#alamatC').html('')
                $('#notlpC').html('')
            }

            // console.log(document.getElementById('tanpa-rupiah').value);
        });
    </script>
    {{-- GET DETAIL NOTA --}}
    <script>
        function detail(id) {
            $.ajax({
                type: 'GET',
                url: '/pembelian/' + id,
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
        function unrupiah(val){
            unrupiah =parseInt(val.replaceAll('.',''));
            return unrupiah;
        }

        let oldsub = 0;

        function tambahan() {

            if (oldsub != 0) {
                $('#subTotal').val(oldsub);
            }

            var taxPersentase = document.getElementById("taxRate").value;
            var x = document.getElementById("subTotal").value;
            let subTotal = parseInt(x.replaceAll(".", ""));

            if (oldsub == 0) {
                oldsub = subTotal;
            }
            console.log(oldsub);

            subTotal += parseInt((subTotal / 100) * taxPersentase);
            var biaya = parseInt(document.getElementById("biayaPengiriman").value);
            subTotal += biaya;

            $('#subTotal').val(rupiah(subTotal));

            oldTax = taxPersentase;
            oldKirim = biaya;
        }
        $(document).on('blur', "[id^=quantity_]", function() {
            calculateTotal();
        });
        $(document).on('blur', "[id^=price_]", function() {
            calculateTotal();
        });

        function calculateTotal() {
            var totalAmount = 0;
            $("[id^='price_']").each(function() {
                var id = $(this).attr('id');
                id = id.replace("price_", '');
                var price = $('#price_' + id).val();
                var quantity = $('#quantity_' + id).val();
                if (!quantity) {
                    quantity = 1;
                }
                var total = price * quantity;
                $('#total_' + id).val(parseFloat(total));
                totalAmount += total;
            });
            $('#subTotal').val(rupiah(parseFloat(totalAmount)));
            
            var taxRate = $("#taxRate").val();
            var subTotal = $('#subTotal').val();
            if (subTotal) {
                var taxAmount = subTotal * taxRate / 100;
                $('#taxAmount').val(taxAmount);
                subTotal = parseFloat(subTotal) + parseFloat(taxAmount);
                $('#totalAftertax').val(subTotal);
                var amountPaid = $('#amountPaid').val();
                var totalAftertax = $('#totalAftertax').val();
                if (amountPaid && totalAftertax) {
                    totalAftertax = totalAftertax - amountPaid;
                    $('#amountDue').val(totalAftertax);
                } else {
                    $('#amountDue').val(subTotal);
                }
            }
        }
        
    </script>

<script>
    function printCertificate() {
        const printContents = document.getElementById('detailNota').innerHTML;
        const originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        location.reload();
    }
</script>
    <script>
        let minDate, maxDate;
        $(function() {

            var start = moment().subtract(1, 'month');
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
                [6, 'asc']
            ]
        });

        $.fn.dataTableExt.afnFiltering.push(
            function(settings, data, dataIndex) {
                var min = minDate;
                var max = maxDate;
                var date = data[1].split(' ')[0] || 0; // Our date column in the table

                // console.log(data[1].split(' ')[0]);

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
