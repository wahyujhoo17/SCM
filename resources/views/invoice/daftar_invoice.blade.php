@extends('tamplate')

@section('judul')
    <p>Daftar Invoice</p>
@endsection

@section('konten')
    @php
        $pList = $produk;
    @endphp
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .invoice-container {
            /* text-align: center; */
            padding: 20px;
        }

        .pModal {
            display: none;
            position: fixed;
            top: 0;
            right: -100%;
            /* Mulai dari luar layar kanan */
            width: 75%;
            /* 3/4 dari lebar layar */
            height: 90vh;
            /* tinggi sama dengan tinggi layar */
            background-color: #fefefe;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: right 0.3s ease-in-out;
            /* Efek transisi untuk animasi */
        }

        .pModal-content {
            padding: 20px;
            height: 100%;
            overflow-y: auto;
        }

        .close {
            position: absolute;
            top: 10px;
            right: 60px;
            font-size: 30px;
            cursor: pointer;
        }

        .modal-footer {
            background-color: white;
        }

        .containerR {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 10px;
            margin-top: 5px;
        }

        .form-check-input {
            width: 20px;
            height: 20px;
            margin-top: 5px;
        }

        .form-check-label {
            font-size: 15px;
            margin-left: 5px;
        }

        .form-check-input:checked {
            background-color: #007bff;
            border-color: #007bff;
        }

        .form-check-input:checked:after {
            /* content: '\2713'; */
            font-size: 14px;
            color: white;
            position: relative;
            top: -3px;
            left: 2px;
        }
    </style>

    {{-- KONTEN --}}
    <div class="clearfix"></div>

    <div class="container">
        <div class="row">
            <div class="col-md-12 text-right">
                <button type="button" class="btn btn-round btn-success" id="openModalBtn">Tambah Invoice</button>
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
                <th class="column-title">ID </th>
                <th class="column-title">Tanggal Dibuat</th>
                <th class="column-title">Tanggal Jatuh Tempo</th>
                <th class="column-title">Nama Pelanggan</th>
                <th class="column-title">Total Tagihan </th>
                <th class="column-title">Alamat Pengiriman </th>
                <th class="column-title">Status</th>
                <th class="column-title no-link last"><span>Action</span>
                </th>
            </tr>
        </thead>

        <tbody>
            @foreach ($invoice as $iv)
                <tr>
                    <td>{{ $iv->nomor }}</td>
                    <td>{{ $iv->tanggal }}</td>
                    <td>{{ $iv->jatuh_tempo }}</td>
                    <td>{{ $iv->pelanggan->nama }}</td>
                    <td>{{ 'Rp ' . number_format($iv->tagihan, 2, ',', '.') }}</td>
                    <td>{{ $iv->alamat_pengiriman }}</td>
                    @if ($iv->status == 'Belum Lunas')
                        <td>
                            <h6><span class="badge badge-info">{{ $iv->status }}</span></h6>
                        </td>
                    @elseif ($iv->status == 'Jatuh Tempo')
                        <td>
                            <h6><span class="badge badge-danger">{{ $iv->status }}</span></h6>
                        </td>
                    @else
                        <td>
                            <h6><span class="badge badge-primary">{{ $iv->status }}</span></h6>
                        </td>
                    @endif

                    <td>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".detailInvoice"
                            onclick="view({{ $iv->id }})">
                            <i class="fas fa-info-circle"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>


    {{-- MODAL TAMBAH INVOICE --}}
    <div class="invoice-container">
        <form method="POST" action="{{ route('daftar-invoice.store') }}">
            @csrf
            <div id="pModal" class="pModal">
                <div class="pModal-content">
                    <h3 style="text-align: center;">Tambah Invoice</h3>
                    <div class="containerR">
                        <div class="row">
                            <div class="col-md-6 offset-md-3">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input" id="radio1" name="radioGroup"
                                                checked>
                                            <label class="form-check-label" for="radio1">Tanpa Referensi</label>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input" id="radio2" name="radioGroup">
                                            <label class="form-check-label" for="radio2">Referensi Pesanan</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- CHECK BOX REFERENSI PESANAN --}}

                    <div class="containerR" style="margin-top: 15px;" id="pesanan">
                        <label for="rPesanan">Nomor Transaksi Pesanan Penjualan</label>
                        <select name="rPesanan" id="rPesanan" class="form-select" style="width: 100% ;"
                            onchange="onCgangeRadio(this.value)">
                            <option value="">Pilih Pesanan reverensi</option>
                            @foreach ($data as $noPesanan)
                                <option value="{{ $noPesanan->id }}">{{ $noPesanan->nomor }}</option>
                            @endforeach
                        </select>

                        <div id="infoInvoice">

                        </div>
                    </div>

                    {{-- TANPA REFERENSI --}}
                    <div class="containerR" style="margin-top: 15px;" id="tanpaPesanan">
                        <br>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <label for="namaPelanggan">Nama Pelanggan</label>
                                <select name="pelanggan" id="pelanggan" class="form-control" style="width: 100% ;"
                                    onchange="pelangganOnchange(this.value)" required>
                                    <option value="">Pilih Pelanggan</option>
                                    @foreach ($pelanggan as $p)
                                        <option value="{{ $p->id . '-' . $p->alamat }}">{{ $p->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <label for="noInvoice">Nomor Invoice</label>
                                <input type="text" class="form-control" name="noInvoice" id="noInvoice" readonly
                                    value="{{ $idG }}" required>
                            </div>
                        </div><br>
                    </div>
                    {{-- --- --}}
                    <div class="containerR" id="pengiriman">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="alamat_pelanggan">Alamat Pelanggan:</label>
                                <textarea class="form-control" id="alamat_pelanggan" name="alamat_pelanggan" rows="3" required readonly></textarea>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="alamat_pengiriman">Alamat Pengiriman:</label>
                                <textarea class="form-control" id="alamat_pengiriman" name="alamat_pengiriman" rows="3" required></textarea>
                            </div>
                        </div>
                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" id="copy_alamat" onclick="copyAlamat()">
                            <label class="form-check-label" for="copy_alamat">Salin alamat pelanggan ke alamat
                                pengiriman</label>
                        </div><br>
                        {{-- DATE --}}

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="tanggalTransaksi">Tanggal Transakasi</label>
                                <input type="date" id="tanggalTransaksi" class="form-control" readonly>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="tanggalJatuhTempo">Tanggal Jatuh Tempo</label>
                                <input type="date" id="tanggalJatuhTempo" name="tanggalJatuhTempo"
                                    class="form-control" required>
                            </div>
                        </div><br>

                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="2"> </textarea>
                        </div>

                    </div>

                    {{-- --- --}}
                    <br>
                    <div style="border-top: 2px solid #E5E5E5;"></div><br>
                    {{-- ISI TABLE --}}
                    <div class="row" id="listTable">
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
                                            <input type="checkbox" class="itemRow custom-control-input" id="itemRow_1">
                                            <label class="custom-control-label" for="itemRow_1"></label>
                                        </div>
                                    </td>

                                    <td>
                                        <select name="productId[]" id="productId_1"
                                            onchange="onCgangeItem(this.value,this.id)" class="form-control selectItem"
                                            style="width: 100%;" required>
                                            <option value=""></option>
                                            @foreach ($produk as $item)
                                                <option value="{{ $item->id . '-' . $item->harga_jual }}">
                                                    {{ $item->nama }}</option>
                                            @endforeach

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
                    <div class="row" id="buttonAdd">
                        <button class="btn btn-danger delete" id="removeRows" type="button" style="width: 10%"><i
                                class="fas fa-trash"></i></button>
                        <button class="btn btn-success" id="addRows" type="button" style="width: 88%;">+ Add
                            More</button>
                    </div> <br>
                    {{-- TOTAL DLL --}}
                    <div style="border-top: 2px solid #E5E5E5;"></div>

                    <div class="containerR">
                        {{-- SUB TOTAL --}}
                        <div class="form-row">
                            <div class="col-md-6">
                                <p class="form-control-plaintext" style="font-size: 16px;">Sub Total (Rp) </p>
                            </div>

                            <div class="col-md-6">
                                <input type="text" style="text-align: right;font-size: 20px;" id="subTotal"
                                    name="subTotal" value="" class="form-control" required readonly>
                            </div>
                        </div><br>
                        {{-- DISKON --}}
                        <div class="form-row">
                            <div class="col-md-6">
                                <p class="form-control-plaintext" style="font-size: 16px;">Diskon </p>
                            </div>
                            <div class="col-md-2">
                                <div class="input-group mb-3">

                                    <input value="0" type="number" onchange="perhitungan()" class="form-control"
                                        name="diskon" id="taxRate" min="0" max="20">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text currency">%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <input type="text" style="text-align: right;font-size: 16px;" name="diskonValue"
                                    id="diskonTotal" value="0" class="form-control" readonly>
                            </div>
                        </div>
                        {{-- ONGKIR --}}
                        <div class="form-row">
                            <div class="col-md-6">
                                <p class="form-control-plaintext" style="font-size: 16px;">Biaya Pengiriman</p>
                            </div>
                            <div class="col-md-6">
                                <input type="text" onchange="perhitungan()" name="ongkir"
                                    style="text-align: right;font-size: 16px;" id="biayaKirim" value="0"
                                    class="form-control" required>
                            </div>
                        </div><br>
                        {{-- TOTAL --}}
                        <div class="form-row">
                            <div class="col-md-6">
                                <p class="form-control-plaintext" style="font-size: 24px;"><strong>Total</strong></p>
                            </div>
                            <div class="col-md-6">
                                <input type="text" style="text-align: right;font-size: 24px;" name="total_final"
                                    id="totalFinal" value="0" class="form-control-plaintext" required readonly>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModal()"
                        data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Tambah Invoice</button>
                </div>
            </div>
        </form>
    </div>
    {{-- END MODAL --}}

    {{-- MODAL INVOICE --}}
    <div class="modal fade detailInvoice" id="detailInvoice" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div id="isiKontenInvoice">

                </div>

                <div class="col-md-12 text-right">
                    <button type="button" class="btn btn-secondary mb-3" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>
    {{-- END MODAL --}}
@endsection

@section('javascript')
    <script>
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
        var modal = document.getElementById('pModal');

        document.getElementById('openModalBtn').addEventListener('click', function() {
            modal.style.display = 'block';
            setTimeout(function() {
                modal.style.right = '0'; // Menggeser modal ke dalam layar
            }, 100);
        });

        function closeModal() {
            modal.style.right = '-100%'; // Menggeser modal kembali ke luar layar kanan
            setTimeout(function() {
                modal.style.display = 'none';
            }, 300); // Sesuaikan dengan durasi transisi CSS (0.3s)
        }

        $(document).ready(function() {
            $("#pelanggan").select2();
            $("#rPesanan").select2();
            $("#pelanggan").select2();
            $("#productId_1").select2();

            // Initially hide the dropdown
            $("#pesanan").hide();

            // Get the current date
            var currentDate = new Date();
            // Format the date to be in 'YYYY-MM-DD' format
            var formattedDate = currentDate.toISOString().slice(0, 10);
            // Set the value of the input element
            document.getElementById("tanggalTransaksi").value = formattedDate;

            // Listen for changes in the radio buttons
            var pelanggan = document.getElementById('pelanggan');
            var pesanan = document.getElementById('rPesanan');

            $('input[type="radio"]').change(function() {
                // Check if the "Referensi Pesanan" radio button is selected
                if ($(this).attr("id") == "radio2") {
                    // If selected, show the dropdown
                    $("#pesanan").show();
                    $("#tanpaPesanan").hide();
                    $("#pengiriman").hide();
                    $("#buttonAdd").hide();
                    $("#pengiriman").val("");
                    $('#pelanggan').val('');
                    $('#rPesanan').val('');

                    pelanggan.removeAttribute('required');
                    pesanan.setAttribute('required', 'true');
                    pembersihan();
                    removeAllRows();
                } else {
                    // If not selected, hide the dropdown
                    $("#pesanan").hide();
                    $("#tanpaPesanan").show();
                    $("#pengiriman").show();
                    $("#pengiriman").val("");
                    $("#buttonAdd").show();
                    $('#pelanggan').val('');
                    $('#rPesanan').val('');
                    pesanan.removeAttribute('required');
                    pelanggan.setAttribute('required', 'true');
                    pembersihan();
                    removeAllRows();
                }
            });
        });

        function copyAlamat() {
            var alamatPelanggan = document.getElementById("alamat_pelanggan").value;

            if (document.getElementById("copy_alamat").checked) {
                document.getElementById("alamat_pengiriman").value = alamatPelanggan;
            } else {
                document.getElementById("alamat_pengiriman").value = "";
            }
        }

        function removeAllRows() {
            // Get the table element
            var table = document.getElementById("invoiceItem");

            // Remove all rows
            while (table.rows.length > 0) {
                table.deleteRow(1);
                count = 0;
            }
        }
    </script>

    <script>
        function onCgangeRadio(val) {
            if (val != '') {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: 'GET',
                    url: '/daftar-invoice/' + val,
                    data: {},
                    success: function(data) {
                        $("#infoInvoice").html(data.view);
                        $("#listTable").html(data.listTable);
                        $("#pengiriman").show();
                    },
                    error: function() {
                        alert("error!!!!");
                    }
                });
            }
        }

        function pelangganOnchange(val) {
            var alamat = val.split("-");
            document.getElementById("alamat_pelanggan").value = alamat[1];
        }
    </script>

    <script>
        function rupiah(val) {
            rupiahFormat = val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            return rupiahFormat;
        }

        function unrupiah(val) {
            unrupiah = parseInt(val.replaceAll('.', ''));
            return unrupiah;
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

        var count = $(".itemRow").length;
        let ListItem = [];
        $(document).on('click', '#addRows', function() {

            if (count > 0) {
                Item = document.getElementById('productId_' + count + '').value;
                Qty = document.getElementById('quantity_' + count + '').value;
                Price = document.getElementById('price_' + count + '').value;
                Total = document.getElementById('total_' + count + '').value;

                if (Item && Qty && Price && Total != '' && count >= 0) {

                    ListItem.push(Item);
                    console.log(ListItem);
                    count++;

                    var htmlRows = '';
                    htmlRows += '<tr>';
                    htmlRows +=
                        '<td><div class="custom-control custom-checkbox"> <input type="checkbox" class="custom-control-input itemRow" id="itemRow_' +
                        count + '"> <label class="custom-control-label" for="itemRow_' + count +
                        '"></label> </div></td>';
                    htmlRows +=
                        '<td><select name="productId[]" onchange="onCgangeItem(this.value,this.id)" id="productId_' +
                        count +
                        '" class="form-control selectItem" style="width: 100%;" required ><option value=""></option></select></td>';
                    htmlRows += '<td><input type="number" name="quantity[]" id="quantity_' + count +
                        '" class="form-control quantity" autocomplete="off" ></td>';
                    htmlRows += '<td><input type="number" name="price[]" id="price_' + count +
                        '" class="form-control " autocomplete="off" ></td>';
                    htmlRows += '<td><input type="number" name="total[]" id="total_' + count +
                        '" class="form-control " autocomplete="off" readonly></td>';
                    htmlRows += '</tr>';


                    option =
                        ' <option value=""></option>@foreach ($pList as $item) <option value="{{ $item->id . '-' . $item->harga_jual }}">{{ $item->nama }}</option>@endforeach';

                    $('#invoiceItem').append(htmlRows);
                    $('#productId_' + count + "").html(option);
                    $("#productId_" + count + "").select2();

                    for (let index = 0; index < ListItem.length; index++) {
                        $("#productId_" + count + " option[value='" + ListItem[index] + "']").remove();
                    }

                } else {}
            } else {
                count++;

                var htmlRows = '';
                htmlRows += '<tr>';
                htmlRows +=
                    '<td><div class="custom-control custom-checkbox"> <input type="checkbox" class="custom-control-input itemRow" id="itemRow_' +
                    count + '"> <label class="custom-control-label" for="itemRow_' + count +
                    '"></label> </div></td>';
                htmlRows +=
                    '<td><select name="productId[]" onchange="onCgangeItem(this.value,this.id)" id="productId_' +
                    count +
                    '" class="form-control selectItem" style="width: 100%;" required><option value=""></option></select></td>';
                htmlRows += '<td><input type="number" name="quantity[]" id="quantity_' + count +
                    '" class="form-control quantity" autocomplete="off" ></td>';
                htmlRows += '<td><input type="number" name="price[]" id="price_' + count +
                    '" class="form-control " autocomplete="off" ></td>';
                htmlRows += '<td><input type="number" name="total[]" id="total_' + count +
                    '" class="form-control " autocomplete="off" readonly></td>';
                htmlRows += '</tr>';


                option =
                    ' <option value=""></option>@foreach ($produk as $item) <option value="{{ $item->id . '-' . $item->harga_jual }}">{{ $item->nama }}</option>@endforeach';

                $('#invoiceItem').append(htmlRows);
                $('#productId_' + count + "").html(option);
                $("#productId_" + count + "").select2();
            }
        });


        function removeSelectedOption(selectedValue) {
            $('#productId_' + count + ' option[value="' + selectedValue + '"]').remove();
        }

        //ProductChange
        function onCgangeItem(val, id) {

            idsplit = id.split('_');
            valsplit = val.split('-');

            harga = valsplit[1];
            id = idsplit[1];

            document.getElementById("price_" + id).value = harga;
            document.getElementById("quantity_" + id).value = "1";

            calculateTotal();
        }
        //Total
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

                $('#subTotal').val(rupiah(totalAmount));
                $('#totalFinal').val(rupiah(totalAmount));
            });
        }
        //
        $(document).on('click', '#removeRows', function() {
            $(".itemRow:checked").each(function() {

                var valueItem = $(this).closest("tr").find("select").val();
                ListItem = ListItem.filter(item => item !== valueItem);

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

        var tanpa_rupiah = document.getElementById('biayaKirim');
        tanpa_rupiah.addEventListener('keyup', function(e) {
            tanpa_rupiah.value = formatRupiah(this.value);
        });

        function pembersihan() {
            $('#subTotal').val('0');
            $('#taxRate').val('0');
            $('#diskonTotal').val('0');
            $('#biayaKirim').val('0');
            $('#totalFinal').val('0');
        }

        function perhitungan() {
            subtotal = $('#subTotal').val().replaceAll('.', '');
            persentas = $('#taxRate').val();
            totalDiskon = (subtotal * persentas) / 100;
            total = subtotal - totalDiskon;
            $('#diskonTotal').val(rupiah(totalDiskon));
            biayakirim = $("#biayaKirim").val().replaceAll('.', '');
            total += parseInt(biayakirim);
            $('#totalFinal').val(rupiah(total));
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
                [6, 'asc']
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

    {{-- SHOW DETAIL --}}
    <script>
        function view(id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'GET',
                url: '/detail-invoice/' + id,
                data: {},
                success: function(data) {

                    $("#isiKontenInvoice").html(data.view);
                    console.log(data);
                },
                error: function() {
                    alert("error!!!!");
                }
            });
        }

        function printIn() {
            const printContents = document.getElementById('buatPrint').innerHTML;
            const originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            location.reload();
        }
    </script>
@endsection
