@extends('tamplate')

@section('judul')
    <p>Stok Outlet</p>
@endsection

@section('konten')
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
    <div class="clearfix"></div>

    <div class="container">
        <div class="row">
            <div class="col-md-12 text-right">
                <button type="button" class="btn btn-round btn-success" id="openModalBtn">Minta Stok</button>
            </div>
        </div>
    </div><br>

    <div class="col-md-5 form-group has-feedback float-right">
        <div id="reportrange" class="form-control">
            <i class="fa fa-calendar"></i>&nbsp;
            <span></span> <b class="caret"></b>
        </div>
    </div>

    <table id="datatable" class="table table-striped jambo_table bulk_action" style="width:100%">
        <thead>
            <tr>
                <th>No Permintaan</th>
                <th>Tanggal</th>
                <th>Pegawai</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($data as $dt)
            <tr>
                <td>{{ $dt->nomor }}</td>
                <td>{{ $dt->tanggal }}</td>
                <td>{{ $dt->pegawai->nama }}</td>
                <td>{{ $dt->status }}</td>
                <td> <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".detailInvoice"
                        onclick="view({{ $dt->id }})">
                        <i class="fas fa-info-circle"></i>
                    </button></td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{-- TAMBAH MODAL --}}
    <div class="invoice-container">
        <div id="pModal" class="pModal">
            <div class="pModal-content">
                <h3 style="text-align: center;">Minta Stok</h3>
                {{-- GUDANG DAN NOMOR --}}
                <div class="containerR" style="margin-top: 15px;" id="tanpaPesanan">
                    <br>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <label for="gudang">Gudang</label>
                            <select name="gudang" id="gudang" class="form-control" style="width: 100% ;"
                                onchange="gudang(this.value)" required>
                                <option value="">Pilih Gudang</option>
                                @foreach ($gudang as $g)
                                    <option value="{{ $g->id }}">{{ $g->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <label for="noInvoice">Nomor Permintaan</label>
                            <input type="text" class="form-control" name="noInvoice" id="noInvoice" readonly
                                value="{{ $idG }}" required>
                        </div>
                    </div><br>
                </div>
                {{-- PRODUK --}}
                <div class="containerR">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="productName" class="form-label">Nama Produk</label>
                                <!-- Menggunakan elemen select untuk pilihan produk -->
                                <select class="form-control" id="productName" style="width: 100%;"
                                    onchange="produkChange(this.value)">
                                    <option selected>Pilih Produk</option>
                                    <!-- Tambahkan lebih banyak option sesuai kebutuhan -->
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="stock" class="form-label">Stok di Gudang</label>
                                <input type="number" class="form-control" id="stock" placeholder="Stok" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Jumlah</label>
                                <input type="number" class="form-control" id="quantity" placeholder="Jumlah"
                                    min="1" max="5">
                            </div>
                        </div>
                    </div>

                    <!-- Tombol "Tambah Produk" -->
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <button type="button" class="btn btn-primary" id="addProduct">Tambah Produk</button>
                        </div>
                    </div>

                </div>

                {{-- INPUT FORM --}}
                <!-- Formulir tersembunyi untuk mengirim data ke controller -->
                <form id="productForm" method="post" action="/kirim-stok">
                    @csrf
                    <!-- Input tersembunyi untuk data produk -->
                    <input type="hidden" name="productData" id="productData">
                    <input type="hidden" name="gudang" id="gudangData">
                </form>

                {{-- TABLE --}}
                <!-- Tabel Produk -->
                <table class="table mt-4">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama Produk</th>
                            <th scope="col">Stok</th>
                            <th scope="col">Jumlah</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tableItem">
                        <!-- Data Produk akan ditampilkan di sini -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal()" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary" id="submitForm">Tambah Permintaan</button>
            </div>
        </div>
    </div>

    {{-- DETAIL MODAL --}}
    {{-- MODAL INVOICE --}}
    <div class="modal fade detailInvoice" id="detailInvoice" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div id="isiKonten">

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

        $("#gudang").select2();
        $("#productName").select2();

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
    </script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function hapusOpsi() {
            // Dapatkan elemen select
            var select = document.getElementById("productName");

            // Hapus semua elemen anak (options)
            while (select.options.length > 0) {
                select.remove(0);
            }
            $("#productName").append("<option value=''>Pilih Produk</option>");
        }

        function gudang(val) {
            if (val != '') {
                $.ajax({
                    type: 'GET',
                    url: '/kirim-stok/get-produk/' + val,
                    data: {},
                    success: function(data) {
                        hapusOpsi();

                        for (let index = 0; index < data.msg.length; index++) {
                            nama = data.msg[index]['nama'];
                            id = data.msg[index]['id'];
                            nomor = data.msg[index]['produk_id'];
                            jumlah = data.msg[index]['pivot']['jumlah'];

                            val = nomor + '-' + jumlah + '-' + nama;

                            $("#productName").append("<option value='" + val + "'>" + nama + "</option>");
                        }
                    },
                    error: function() {
                        alert("error!!!!");
                    }
                });
            }
        }

        function view(id) {
            $.ajax({
                type: 'GET',
                url: '/kirim-stok/' + id,
                data: {},
                success: function(data) {

                    $('#isiKonten').html(data.view);
                },
                error: function() {
                    alert("error!!!!");
                }
            });
        }

        function produkChange(val) {
            var split = val.split('-');

            $('#stock').val(split[1]);
            document.getElementById("quantity").setAttribute("max", split[1]);
        }

        $("#addProduct").on("click", function() {
            var value = $("#productName").val();
            var stock = $("#stock").val();
            var quantity = $("#quantity").val();

            var split = value.split('-');
            var nomor = split[0];
            var jumlah = split[1];
            var nama = split[2];


            if (productName != '' && stock && quantity) {
                // Menambahkan data produk ke dalam tabel
                $("#tableItem").append("<tr class='isi'><td><input type='text' name='idProduk[]' value='" +
                    nomor +
                    "' readonly class='form-control-plaintext' ></td><td><input type='text' name='productName[]' value='" +
                    nama +
                    "' readonly class='form-control-plaintext' ></td><td><input type='number' name='stock[]' value='" +
                    stock +
                    "' readonly class='form-control-plaintext' ></td><td><input type='number' name='quantity[]' value='" +
                    quantity +
                    "' readonly class='form-control-plaintext'></td><td><button class='btn btn-danger btn-sm delete-product'>Hapus</button></td></tr>"
                );

                // Menghapus produk yang sudah ditambahkan dari opsi dropdown
                $("#productName option[value='" + value + "']").remove();

                // Mengosongkan input setelah menambahkan produk
                $("#productName").val("");
                $("#stock").val("");
                $("#quantity").val("");
            } else {
                alert("Mohon isi semua field.");
            }
        });

        // Menangani klik tombol hapus
        $("tbody").on("click", ".delete-product", function() {
            var productName = $(this).closest("tr").find("input[name='productName[]']").val();
            var nomor = $(this).closest("tr").find("input[name='idProduk[]']").val();
            var stok = $(this).closest("tr").find("input[name='stock[]']").val();

            var val = nomor + "-" + stok + "-" + productName;

            // Mengembalikan nama produk ke opsi dropdown
            $("#productName").append("<option value='" + val + "'>" + productName + "</option>");

            // Menghapus baris dari tabel
            $(this).closest("tr").remove();
        });

        // Menangani klik tombol Kirim Data ke Controller
        $("#submitForm").on("click", function() {
            // Mengambil data dari formulir dan mengisikan ke input tersembunyi
            var productData = [];
            $(".isi").each(function() {
                var rowData = {
                    productName: $(this).find("input[name='productName[]']").val(),
                    stock: $(this).find("input[name='stock[]']").val(),
                    quantity: $(this).find("input[name='quantity[]']").val(),
                    id: $(this).find("input[name='idProduk[]']").val()
                };
                productData.push(rowData);
            });

            // Mengubah objek JavaScript menjadi JSON dan menetapkannya ke input tersembunyi
            $("#productData").val(JSON.stringify(productData));
            //mengambil value gudang
            var gudang = $('#gudang').val();
            $("#gudangData").val(gudang);

            // Mengirim formulir
            $("#productForm").submit();
        });
    </script>
@endsection
