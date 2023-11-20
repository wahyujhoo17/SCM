@extends('tamplate')

@section('judul')
    <p>Daftar Pesanan</p>
@endsection
@section('konten')
    @php
        $pList = $produk;
    @endphp

    <div class="clearfix"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-right">
                <button type="button" onclick="tambah()" data-toggle="modal" data-target=".tambahStok"
                    class="btn btn-round btn-success">Tambah Pesanan</button>
            </div>
        </div>
    </div><br>
    {{-- TABLE PESANAN --}}

    <table class="table table-striped jambo_table bulk_action" id="datatable">
        <thead>
            <tr class="headings">
                <th class="column-title">ID </th>
                <th class="column-title">Tanggal </th>
                <th class="column-title">Nama Pelanggan</th>
                <th class="column-title">Total Harga </th>
                <th class="column-title">Alamats </th>
                <th class="column-title">Status</th>
                <th class="column-title no-link last"><span class="nobr">Action</span>
                </th>
                <th class="bulk-actions" colspan="7">
                    <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span>
                        ) <i class="fa fa-chevron-down"></i></a>
                </th>
            </tr>
        </thead>

        <tbody>
            @foreach ($data as $ps)
                <tr>
                    <td>{{ $ps->nomor }}</td>
                    <td>{{ $ps->tanggal }}</td>
                    <td>{{ $ps->pelanggan->nama }}</td>
                    <td>{{ 'Rp ' . number_format($ps->total_harga, 2, ',', '.') }}</td>
                    <td>{{ $ps->alamat_pengiriman }}</td>
                    <td>{{ $ps->status_pesanan }}</td>
                    <td>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#invoiceModal"
                            onclick="view({{ $ps->id }})">
                            <i class="fas fa-info-circle"></i>
                        </button>

                        @if ($ps->status_pesanan == 'dalam antrian')
                            <button type="button" class="btn btn-warning">
                                <i class="fas fa-edit"></i>
                            </button>

                            <form method="POST" action="{{ route('daftar-pesanan.destroy', $ps->nomor) }}">
                                @csrf
                                <input name="_method" type="hidden" value="DELETE">
                                <button type="submit" class="btn btn-secondary show_confirm" data-toggle="tooltip">
                                    <i class="fas fa-times"></i> Batal
                                </button>
                            </form>
                        @endif

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Tambah Modal -->
    <form method="POST" action="{{ route('daftar-pesanan.store') }}">
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
                                <h3>Dari ,</h3>
                                Jaya Abadi <br>
                                Jl Letda Nasir 45 RT 001/02,Lamongan,16961,Indonesia<br>
                                083831211636<br>
                                jaya-abadi@gmail.com<br>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <h3>To,</h3>
                                <div class="form-group">
                                    <select class="form-control py-4" name="pelanggan" id="pelanggan" style="width: 80%;"
                                        required>
                                        <option value="">Pilih Pelanggan</option>
                                        @foreach ($pelanggan as $pl)
                                            <option value="{{ $pl->id }}">{{ $pl->nama }}</option>
                                        @endforeach
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
                        <div class="row">

                            <button class="btn btn-danger delete" id="removeRows" type="button" style="width: 10%"><i
                                    class="fas fa-trash"></i></button>
                            <button class="btn btn-success" id="addRows" type="button" style="width: 88%;">+ Add
                                More</button>
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

    <!-- Modal View-->
    <div class="modal fade" id="invoiceModal" tabindex="-1" role="dialog" aria-labelledby="invoiceModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="invoiceModalLabel">Detail Pesanan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="kontenView">
                    {{-- ISI KONTEN --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script>
        $(document).ready(function() {
            $("#pelanggan").select2();
            $("#jenis_barang").select2();
            $("#item").select2();
            $("#productId_1").select2();
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

        $('#datatable').dataTable({
            "order": [
                [1, 'desc']
            ]
        });

        // Confirm Dalate
        $('.show_confirm').click(function(event) {
            var form = $(this).closest("form");
            var name = $(this).data("name");
            event.preventDefault();
            swal({
                    title: `Anda yakin akan membatalkan pesanan ini?`,
                    text: "Jika anda membatalkan pesanan ini otomatis pesanan akan dibatalkan selamanya",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                    }
                });
        });
    </script>


    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function view(id) {
            $.ajax({
                type: 'GET',
                url: '/daftar-pesanan/' + id,
                success: function(data) {
                    $("#kontenView").html(data.view);
                },
                error: function() {
                    alert("error!!!!");
                }
            }); //end of ajax
        }
    </script>

    <script>
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
                        '" class="form-control selectItem" style="width: 100%;"><option value=""></option></select></td>';
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
                    '" class="form-control selectItem" style="width: 100%;"><option value=""></option></select></td>';
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

        //Onclick Tambah
        function tambah() {}

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
            });
        }
        //
        $(document).on('click', '#removeRows', function() {
            $(".itemRow:checked").each(function() {

                var valueItem = $(this).closest("tr").find("select").val();
                ListItem = ListItem.filter(item => item !== valueItem);
                console.log(ListItem);
                console.log(valueItem);

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
    </script>
@endsection
