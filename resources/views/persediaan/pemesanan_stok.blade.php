@extends('tamplate')

@section('judul')
    <p>
        Pemesanan Stok</p>
@endsection

@section('konten')
    <div class="clearfix"></div>

    <div class="container">
        <div class="row">
            <div class="col-md-12 text-right">
                <button type="button" onclick="tambah()" data-toggle="modal" data-target=".tambahStok"
                    class="btn btn-round btn-success">Pesan
                    Stok</button>
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
            <div class="col-md-2 col-sm-2  form-group has-feedback">
                <input type="date" class="form-control has-feedback-left" id="inputSuccess2">
                <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
            </div>
            <div class="col-md-2 col-sm-2  form-group has-feedback">
                <input type="date" class="form-control has-feedback-left" id="inputSuccess2">
                <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
            </div>
            <button type="button" class="btn btn-round btn-secondary">Mulai</button>
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        {{-- Daftar --}}
        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
            <br>
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
                        @foreach ($NP as $notaP)
                            <tr class="even pointer" id="tr_{{ $notaP->no_nota }} ">
                                <td>{{ $notaP->no_nota }}</td>
                                <td>{{ $notaP->tanggal }}</td>
                                <td>{{ $notaP->pegawai->nama }}</td>
                                <td>{{ $notaP->pemasok->nama }}</td>
                                <td>
                                    @if ($notaP->status_pemesanan == 'selesai')
                                        <span class="badge badge-pill badge-success">Selesai</span>
                                    @elseif($notaP->status_pemesanan == 'diproses')
                                        <span class="badge badge-pill badge-primary">Proses</span>
                                    @else
                                        <span class="badge badge-pill badge-danger">Batal</span>
                                    @endif
                                </td>
                                <td>{{ 'Rp ' . number_format($notaP->total_harga, 2, ',', '.') }}</td>

                                <td class=" last"><a href="#" data-toggle="modal" data-target=".modal-detail-pemesanan"
                                        onclick="detail('{{ $notaP->no_nota }}')">View</a>
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

                        @foreach ($NP as $notaP)
                            @if ($notaP->status_pemesanan == 'diproses')
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
                        @foreach ($NP as $notaP)
                            @if ($notaP->status_pemesanan == 'selesai')
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

    <div class="modal fade modal-detail-pemesanan" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="detailNota">
                MODAL
            </div>
        </div>
    </div>
    <!-- END Modal -->

    <!-- Tambah Modal -->
    <form method="POST" action="{{ route('pemesanan.store') }}">
        @csrf
        <div class="modal fade tambahStok" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Pesan Stok</h5>
                    </div>
                    <div class="modal-body">

                        {{-- <h2 id="judul"> Tambahkan</h2> --}}
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <h3>From,</h3>
                                DemoAccount<br>
                                demo address<br>
                                7412580000<br>
                                demo@demo.com<br>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <h3>To,</h3>
                                <div class="form-group">
                                    <select class="form-control py-4" name="pemasok" id="pemasok" style="width: 80%;">
                                        @foreach ($PM as $pemasok)
                                            <option value="{{ $pemasok->id }}">{{ $pemasok->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select class="form-control py-4" name="jenis_barang" id="jenis_barang"
                                        style="width: 50%;">
                                        <option value="Produk">Produk</option>
                                        <option value="Barang">Barang Mentah</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <br>
                        <div style="border-top: 2px solid #E5E5E5;"></div><br>

                        {{-- ADD-ITEM --}}
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <table class="table table-condensed table-striped" id="invoiceItem">
                                    <tr>
                                        <th width="2%">
                                            <div class="custom-control custom-checkbox mb-3">
                                                <input type="checkbox" class="custom-control-input" id="checkAll"
                                                    name="checkAll">
                                                <label class="custom-control-label" for="checkAll"></label>
                                            </div>
                                        </th>
                                        {{-- <th width="15%">Item No</th> --}}
                                        <th width="35%">Item Name</th>
                                        <th width="12%">Quantity</th>
                                        <th width="20%">Price</th>
                                        <th width="20%">Total</th>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="itemRow custom-control-input"
                                                    id="itemRow_1">
                                                <label class="custom-control-label" for="itemRow_1"></label>
                                            </div>
                                        </td>

                                        <td>
                                            <select name="productId[]" id="productId_1" onchange="onCgangeItem(this.id)"
                                                class="form-control selectItem" style="width: 100%;">
                                                <option value=""></option>
                                            </select>
                                        </td>
                                        <td><input type="number" name="quantity[]" id="quantity_1" class="form-control"
                                                autocomplete="off"></td>
                                        <td><input type="number" name="price[]" id="price_1" class="form-control"
                                                autocomplete="off"></td>
                                        <td><input type="number" name="total[]" id="total_1" class="form-control"
                                                autocomplete="off" readonly></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <button class="btn btn-danger delete" id="removeRows" type="button">- Delete</button>
                                <button class="btn btn-success" id="addRows" type="button">+ Add More</button>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Tutup</button>
                        <input type="submit" class="btn btn-primary" value="Kirim">
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- END Modal -->
@endsection

@section('javascript')
    <script>
        //end function
        $(document).ready(function() {
            $("#kategori").select2();
            $("#Ukategori").select2();
        });
        //Alert Berhasil
        var msg = '{{ Session::get('alert') }}';
        var exist = '{{ Session::has('alert') }}';
        if (exist) {
            swal("Success", msg, "success");
        }

        // Alert Gagal
        var msg = '{{ Session::get('alert_gagal') }}';
        var exist = '{{ Session::has('alert_gagal') }}';
        if (exist) {
            swal("Gagal", msg, "error");
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script>
        $('#datatable').dataTable({
            "order": [
                [1, 'desc']
            ]
        });
    </script>
    {{-- GET DATA DETAIL NOTA --}}
    <script>
        $(document).ready(function() {
            $("#pemasok").select2();
            $("#jenis_barang").select2();
            $("#item").select2();
            $("#productId_1").select2();
        });

        //GET DETAIL NOTA

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function detail(id) {
            console.log(id);
            $.ajax({
                type: 'GET',
                url: '/pemesanan/' + id,
                data: {
                    id
                },
                success: function(data) {
                    console.log(data.view);

                    $("#detailNota").html(data.view);
                },
                error: function() {
                    alert("error!!!!");
                }
            }); //end of ajax
            console.log(2);
        }
    </script>

    {{-- Scrypt Tambah Data --}}

    <script>
        //IF JENIS BARANG CHANGE
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        
        const harga = [];
        var option = '';

        function getItem() {
            pemasokID = document.getElementById('pemasok').value;
            jenis = document.getElementById('jenis_barang').value;
            $.ajax({
                type: 'POST',
                url: '{{ route('getItem') }}',
                data: {
                    'id': pemasokID,
                    'jenis': jenis,
                },
                success: function(data) {
                    console.log(data.msg);

                    if (data.msg.length != 0) {
                        for (var k in data.msg) {

                            // console.log(k, data.msg[k].harga_beli);

                            harga.push({
                                id: data.msg[k].id,
                                harga: data.msg[k].harga_beli
                            }, );

                            option += '<option value="' + data.msg[k].id + '">' + data.msg[k].nama + '</option>'
                        }
                        $('#productId_1').html(option);
                        console.log('op'+option);
                    }
                    else{
                        option = '<option value=""></option>';
                        $('#productId_1').html(option);
                    }
                },
                error: function() {
                    alert("error!!!!");
                }
            });

        }

        $('#jenis_barang').change(function() {
            harga.length = 0;
            getItem();

        })

        //IF SUPPLIER CHANGE
        $('#pemasok').change(function() {
            harga.length = 0;
            getItem();

        })

        function tambah() {
            harga.length = 0;
            getItem();

        }

        var count = $(".itemRow").length;

        $(document).on('click', '#addRows', function() {
            
            Item = document.getElementById('productId_' + count + '').value;
            Qty = document.getElementById('quantity_' + count + '').value;
            Price = document.getElementById('price_' + count + '').value;
            Total = document.getElementById('total_' + count + '').value;

            if (Item && Qty && Price && Total != '' && count >=0) {
                count++;

                var htmlRows = '';
                htmlRows += '<tr>';
                htmlRows +=
                    '<td><div class="custom-control custom-checkbox"> <input type="checkbox" class="custom-control-input itemRow" id="itemRow_' +
                    count + '"> <label class="custom-control-label" for="itemRow_' + count +
                    '"></label> </div></td>';
                htmlRows += '<td><select name="productId[]" onchange="onCgangeItem(this.id)" id="productId_' +
                    count +
                    '" class="form-control selectItem" style="width: 100%;"><option value=""></option></select></td>';
                htmlRows += '<td><input type="number" name="quantity[]" id="quantity_' + count +
                    '" class="form-control quantity" autocomplete="off" ></td>';
                htmlRows += '<td><input type="number" name="price[]" id="price_' + count +
                    '" class="form-control " autocomplete="off" ></td>';
                htmlRows += '<td><input type="number" name="total[]" id="total_' + count +
                    '" class="form-control " autocomplete="off" readonly></td>';
                htmlRows += '</tr>';

                $('#invoiceItem').append(htmlRows);
                $('#productId_' + count + "").html(option);
                $("#productId_" + count + "").select2();

            } else {

            }
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
        }

        function onCgangeItem(val) {
            $split = val.split('_');
            $value = document.getElementById("productId_" + $split[1]).value;

            let res = harga.find((item) => {
                return item.id == $value;
            });

            document.getElementById("price_" + $split[1]).value = res['harga']; 
            document.getElementById("quantity_" + $split[1]).value = "1"; 
            calculateTotal();
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
@endsection
