@extends('tamplate')

@section('judul')
    <p>Penjualan</p>
@endsection
@section('konten')
    <style>
        #barcodevideo,
        #barcodecanvas,
        #barcodecanvasg {
            height: 400px;
        }

        #barcodecanvasg {
            position: absolute;
            top: 0px;
            left: 0px;
        }

        #result {
            font-family: verdana;
            font-size: 1.5em;
        }

        #barcode {
            position: relative;
        }

        #barcodecanvas {
            display: none;
        }
    </style>
    <div class="clearfix"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <div class="x_panel">
                    <div class="x_content">
                        <section class="content invoice">
                            <!-- info row -->
                            <!-- /.row -->
                            <div class="row-md-2">
                                <div class="input-group">
                                    <label for="produkSelect"></label>
                                    <select class="custom-select" id="produkSelect" style="width:60%">
                                        <option value="" selected>Pilih Produk...</option>
                                        @foreach ($produk as $p)
                                            <option value="{{ $p->id }}">{{ $p->nama }}</option>
                                        @endforeach
                                    </select>
                                    <div class="col">
                                        <div class="row">
                                            <div class="col-md-12 text-right">
                                                <button type="button" class="btn btn-primary" id="scane"
                                                    data-toggle="modal" data-target=".modalScane">Scane</button>
                                                <button type="button" onclick="tambahkan()"
                                                    class="btn btn-warning">Tambahkan</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- Table row -->
                            <form action="{{ route('penjualan.store') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class=" table">
                                        <table class="table table-striped" id="itemTable">
                                            <thead>
                                                <tr>
                                                    <th width="2%">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input"
                                                                id="checkAll" name="checkAll">
                                                            <label class="custom-control-label" for="checkAll"></label>
                                                        </div>
                                                    </th>
                                                    <th style="width: 11%">No Produk</th>
                                                    <th style="width: 25%">Nama</th>
                                                    <th style="width: 15%">Jumlah</th>
                                                    <th>Harga</th>
                                                    <th>Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>

                                        </table>

                                        <button class="btn btn-danger delete" id="removeRows" type="button">-
                                            Delete</button>



                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->
                        </section>
                    </div>
                    {{-- END --}}
                </div>
            </div>

            {{-- PEMBELIAN --}}

            <div class="col">
                <div class="x_panel">
                    <div class="x_title">
                        <div class="col-md-8 col-sm-8 ">
                            {{-- Outlet --}}
                            <div class="item form-group">
                                <label class="col-form-label label-align" for="first-name">Outlet
                                    <span class="required">*</span>
                                </label>
                            </div>
                            <select name="outlet" id="outlet" required="required" class="form-control ">
                                @foreach ($outlet as $o)
                                    <option value="{{ $o->id }}">{{ $o->nama }}</option>
                                @endforeach
                            </select>
                            <br>
                            {{-- NAMA PEMBELI --}}
                            <div class="item form-group">
                                <label class="col-form-label label-align" for="first-name">Nama Pembeli
                                    <span class="required">*</span>
                                </label>
                            </div>
                            <select name="nama-pembeli" id="nama-pembeli" required="required" class="form-control ">
                                @foreach ($pelanggan as $p)
                                    {{ $selected = '' }}
                                    @if ($p->id == 8)
                                        {{ $selected = 'selected' }}
                                    @else
                                    @endif
                                    <option value="{{ $p->id }}|{{ $p->kategori_pelanggan->nominal_diskon }}"
                                        {{ $selected }}>{{ $p->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="clearfix"></div>
                        <br>
                    </div>
                    <div class="x_content">
                        <br>

                        <div class="form-group row">
                            <label class="col-form-label col-md-3 col-sm-3 ">Total <span class="required">*</span>
                            </label>
                            <div class="col-md-9 col-sm-9 ">
                                <input type="text" class="form-control" name="total_harga" id="total_harga"
                                    readonly="readonly" value="0" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-md-3 col-sm-3 ">Diskon <span class="required">% *</span>
                            </label>
                            <div class="col-md-9 col-sm-9 ">
                                <input type="number" class="form-control" name="diskon" id="diskon" value="0"
                                    required style="width: 50%">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-md-3 col-sm-3 ">Metode bayar <span class="required">*</span>
                            </label>
                            <div class="col-md-9 col-sm-9 ">
                                <select name="metode_bayar" id="metode_bayar" class="form-control">
                                    @foreach ($pembayaran as $p)
                                        <option value="{{ $p->id }}">{{ $p->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-md-3 col-sm-3 ">Nominal <span
                                    class="required">*</span></label>
                            <div class="col-md-9 col-sm-9 ">
                                <input type="text" class="form-control" name="nominal" placeholder="Nominal Bayar"
                                    id="nominal" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-md-3 col-sm-3 ">Kembalian <span class="required">*</span>
                            </label>
                            <div class="col-md-9 col-sm-9 ">
                                <input type="text" class="form-control" id="kembalian" readonly="readonly"
                                    name="kembalian" placeholder="Kembalian" required>
                            </div>
                        </div>

                        <div class="ln_solid"></div>
                        <div class="form-group row">
                            <div class="  offset-md-3">
                                {{-- <button type="button" class="btn btn-primary">Cancel</button> --}}
                                <button class="btn btn-primary" type="reset">Reset</button>
                                <button type="submit" class="btn btn-success">Submit</button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Scanner --}}
    <div class="modal fade modalScane" id="modalScane" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">

                    {{-- Scanner 2 --}}
                    <div id="barcode">
                        <video id="barcodevideo" autoplay></video>
                        <canvas id="barcodecanvasg"></canvas>
                    </div>
                    <canvas id="barcodecanvas"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script>
        //Pembeli change
        $("#nama-pembeli").on('change', function() {
            value = $("#nama-pembeli").val().split("|");
            $("#diskon").val(value[1]);
            calculateTotal();
            // console.log(value[1]);
        });
        //end function
        $(document).ready(function() {
            $("#nama-pembeli").select2();
            $("#produkSelect").select2();
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

        //RUPIAH FORMATER

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

        //BAYAR
        var tanpa_rupiah = document.getElementById('nominal');
        tanpa_rupiah.addEventListener('keyup', function(e) {
            tanpa_rupiah.value = formatRupiah(this.value);

            total = $('#total_harga').val().replaceAll('.', '');
            nominal = $('#nominal').val().replaceAll('.', '');
            console.log(nominal - total);
            $('#kembalian').val(rupiah(nominal - total));
        });
        //DISKON
        var diskon = document.getElementById('diskon');

        diskon.addEventListener('keyup', function(e) {
            calculateTotal();
        });

        $(document).on('blur', "[id^=quantity_]", function() {
            calculateTotal();
        });

        function calculateTotal() {
            var totalAmount = 0;
            $("[id^='harga_']").each(function() {
                var id = $(this).attr('id');
                id = id.replace("harga_", '');
                var price = $('#harga_' + id).val();
                var unrup = parseInt(price.replaceAll('.', ''));

                var quantity = $('#quantity_' + id).val();
                if (!quantity) {
                    quantity = 1;
                }
                var total = unrup * quantity;
                $('#total_' + id).val(rupiah(total));
                totalAmount += total;
            });

            var diskon =(totalAmount*$("#diskon").val())/100;

            totalAmount = totalAmount - diskon;
            console.log("diskon" + totalAmount);
            $('#total_harga').val(rupiah(totalAmount));
        }

        //Alert Berhasil
        var msg = '{{ Session::get('alert') }}';
        var exist = '{{ Session::has('alert') }}';
        if (exist) {
            swal("Success", msg, "success");
        }
    </script>

    {{-- Barcode 2 --}}
    <script type="text/javascript" src="js/barcode.js"></script>

    <script>
        var count = $(".itemRow").length;
        //ADD DATA ON TABLE
        function addTables(id, nama, harga) {

            calculateTotal();

            var variable = '' +
                '                                            <tr>' +
                '                                                <td>' +
                '                                                    <div class="custom-control custom-checkbox">' +
                '                                                        <input type="checkbox" class="itemRow custom-control-input"' +
                '                                                            id="itemRow_' + count + '">' +
                '                                                        <label class="custom-control-label" for="itemRow_' +
                count + '"></label>' +
                '                                                    </div>' +
                '                                                </td>' +
                '                                                <td><input type="text" readonly class="form-control-plaintext" id="id_' +
                count + '" name="id[]" value="' + id + '"></td>' +
                '                                                <td><input type="text" readonly class="form-control-plaintext" id="nama_' +
                count + '" name="nama[]" value="' + nama + '"></td>' +
                '                                                <td><input type="number" value="1" id="quantity_' + count +
                '" name="jumlah[]" class="form-control"/></td>' +
                '                                                <td><input type="text" readonly class="form-control-plaintext" id="harga_' +
                count + '" name="harga[]" value="' + rupiah(harga) + '"></td>' +
                '                                                <td><input type="text" readonly class="form-control-plaintext" id="total_' +
                count + '" name="total[]" value="' + rupiah(harga) + '"></td>' +
                '                                            </tr>' +
                '';

            $('#itemTable').append(variable);

            calculateTotal();
        }
        //
        function addItem(id, val) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // console.log('masuk barcode');
            $.ajax({
                type: 'GET',
                url: '/penjualan/' + id,
                data: {
                    value: val,
                },
                success: function(data) {

                    id = data.produk['produk_id'];
                    nama = data.produk['nama'];
                    harga = data.produk['harga_jual'];

                    param = 'tidak sama';
                    for (var i = 1; i <= count; i++) {
                        value = $("#id_" + i).val();
                        // console.log(value);
                        if (value == id) {
                            // console.log('sama');
                            param = 'sama';
                            break;
                        } else {
                            // console.log('TDK sama');
                            param = 'tidak sama';

                        }
                    }
                    console.log(param);
                    if (param == "sama") {
                        Qty = parseInt($('#quantity_' + i).val());
                        $('#quantity_' + i).val(Qty + 1);
                        calculateTotal();
                    } else {
                        count++;
                        addTables(id, nama, harga);
                        calculateTotal();
                    }

                },
                error: function() {
                    alert("error!!!!");
                }
            });

        }
        // Tambah Data Scnner
        document.getElementById('scane').onclick = function() {
            var barcodeText = document.getElementById("barcode");
            var sound = new Audio("barcode.wav");
            var c = 0;

            //Barcode 2
            barcode.config.start = 0.1;
            barcode.config.end = 0.9;
            barcode.config.video = '#barcodevideo';
            barcode.config.canvas = '#barcodecanvas';
            barcode.config.canvasg = '#barcodecanvasg';
            //IF BARCODE SCANE SUCCESS
            barcode.setHandler(function(barcode) {
                $('#modalScane').modal('hide');
                sound.play();
                endCamera()
                if (c == 0) {
                    c++;
                    addItem(barcode, 'barcode');
                    calculateTotal();
                }
            });
            barcode.init();
        }
        //Tambahkan
        function tambahkan() {
            id = $("#produkSelect").val();

            if (id != '') {
                addItem(id, 'id')
                calculateTotal();
            }
            calculateTotal();
        }

        $('#modalScane').on('hidden.bs.modal', function() {
            endCamera();
        })

        function endCamera() {
            //Turn Off Camera
            const video = document.querySelector('video');
            // A video's MediaStream object is available through its srcObject attribute
            const mediaStream = video.srcObject;
            // Through the MediaStream, you can get the MediaStreamTracks with getTracks():
            const tracks = mediaStream.getTracks();
            // Tracks are returned as an array, so if you know you only have one, you can stop it with: 
            tracks[0].stop();
            // Or stop all like so:
            tracks.forEach(track => track.stop())
            // Barcode selesai di pindai
        }

        $('#tambah').click(function() {
            var barcodeText = document.getElementById("barcode");
            barcodeText.value = "";
        });
    </script>
@endsection
