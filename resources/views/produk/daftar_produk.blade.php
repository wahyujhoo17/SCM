@extends('tamplate')

@section('judul')
    <p>Daftar Produk</p>
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

    <br><br>
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-right">
                <button type="button" class="btn btn-round btn-success" id="tambah" data-toggle="modal"
                    data-target=".modalProduk">Tambah
                    Produk</button>
            </div>
        </div>
    </div>

    <table id="datatable" class="table table-striped table-bordered" style="width:100%">

        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Barcode</th>
                <th>Harga Jual</th>
                <th>Stok</th>
                <th>Kategori Produk</th>
                <th>Aksi</th>
            </tr>
        </thead>


        <tbody>
            @foreach ($data as $produk)
                <tr id="tr_{{ $produk->id }}">
                    <td>{{ $produk->produk_id }}</td>
                    <td>{{ $produk->nama }}</td>
                    <td>{{ $produk->barcode }}</td>
                    <td>{{ $produk->harga_jual }} </td>
                    <td>
                        <table style="width: 100%">
                            <tr>
                                <th>Jumlah Stok</th>
                                <th>Lokasi gudang</th>
                            </tr>

                            @if ($produk->gudang == "[]")
                                <td>0</td>
                                <td>-</td>
                            @else
                                @foreach ($produk->gudang as $pg)
                                <tr>
                                    <td>{{ $pg->pivot->jumlah }}</td>
                                    <td>{{ $pg->nama }}</td>
                                </tr>
                                @endforeach
                            @endif
                        </table>
                    </td>
                    <td>{{ $produk->kategori->nama }}</td>
                    <td><a href="#UmodalProduk" id="edit" class="btn btn-primary" data-toggle="modal"
                            data-target=".UmodalProduk" onclick="editData({{ $produk->id }})">Edit</a>

                        <form method="POST" action="{{ route('produk.destroy', $produk->id) }}">
                            @csrf
                            <input name="_method" type="hidden" value="DELETE">
                            <button type="submit" class="btn btn-xs btn-danger btn-flat show_confirm" data-toggle="tooltip"
                                type="button">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Tambah Modal  --}}
    <form method="POST" action="{{ route('produk.store') }}">
        @csrf
        <div class="modal fade modalProduk" id="addProduk">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Tambah Produk</h5>
                    </div>
                    <div class="modal-body">
                        {{-- NAMA --}}
                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="nama">Nama <span
                                    class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 ">
                                <input type="text" id="nama" name="nama" required="required"
                                    class="form-control ">
                            </div>
                        </div>
                        {{-- Barcode --}}
                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="barcode">Barcode <span
                                    class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 ">
                                <input type="number" id="barcode" name="barcode" required="required"
                                    class="form-control ">
                            </div>
                            <div class="col-md-6 col-sm-6 ">
                                <button type="button" id="scane" class="btn btn-outline-secondary" data-toggle="modal"
                                    data-target=".modalScane">Scane</button>
                            </div>
                        </div>

                        {{-- Harga Jual --}}
                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="harga">Harga <span
                                    class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 ">
                                <input type="number" id="harga" name="harga" required="required"
                                    class="form-control ">
                            </div>
                        </div>
                        {{-- Kategori --}}
                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="kategori">Kategori <span
                                    class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 ">
                                <select class="form-control py-4" name="kategori" id="kategori" style="width: 100%;">
                                    @foreach ($kt as $kategori)
                                        <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" id="tambahkan" name="insert" value="Tambahkan" />
                    </div>
                </div>
            </div>
        </div>
    </form>
    {{-- END MODAL --}}

    {{-- MODAL EDIT --}}

    <form method="POST" action="" id="editform">
        @csrf
        @method('PUT')
        <div class="modal fade UmodalProduk">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Ubah Produk</h5>
                    </div>
                    <div class="modal-body" id="UbahModal">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" id="Ubah" name="insert" value="Ubah" />
                    </div>
                </div>
            </div>
        </div>
    </form>

    {{-- END MODAL EDIT --}}
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

{{-- JS SECTION --}}

@section('javascript')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function editData(id) {
            console.log(1);
            $.ajax({
                type: 'POST',
                url: '{{ route('get_update') }}',
                data: {
                    id
                },
                success: function(data) {
                    $("#UbahModal").html(data.msg);
                },
                error: function() {
                    alert("error!!!!");
                }
            }); //end of ajax
            console.log(2);
        }
    </script>
    <script>
        var html5QrcodeScanner;

        // Tambah Data Scnner
        document.getElementById('scane').onclick = function() {
            var barcodeText = document.getElementById("barcode");
            var sound = new Audio("barcode.wav");

            //Barcode 2
            barcode.config.start = 0.1;
            barcode.config.end = 0.9;
            barcode.config.video = '#barcodevideo';
            barcode.config.canvas = '#barcodecanvas';
            barcode.config.canvasg = '#barcodecanvasg';
            barcode.setHandler(function(barcode) {
                // Barcode selesai di pindai
                $('#modalScane').modal('hide');
                barcodeText.value = barcode;
                sound.play();
            });
            barcode.init();
        }

        $('#tambah').click(function() {
            var barcodeText = document.getElementById("barcode");
            barcodeText.value = "";
        });

        $('#modalScane').on('hidden.bs.modal', function() {
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
        })
    </script>

    <script>
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

    {{-- Barcode 2 --}}
    <script type="text/javascript" src="js/barcode.js"></script>

    {{-- UBAH SCTYPT --}}
    <script>
        // Confirm Dalate
        $('.show_confirm').click(function(event) {
            var form = $(this).closest("form");
            var name = $(this).data("name");
            event.preventDefault();
            swal({
                    title: `Are you sure you want to delete this record?`,
                    text: "If you delete this, it will be gone forever.",
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

        //  GET EDIT DATA
        $(document).ready(function() {
            var table = $('#datatable').DataTable();
            table.on('click', '#edit', function() {
                $tr = $(this).closest('tr');
                if ($($tr).hasClass('child')) {
                    $tr = $tr.prev('.parent');
                }
                var data = table.row($tr).data();
                $('#editform').attr('action', 'produk/' + data[0]);
            });
        });
    </script>
@endsection
