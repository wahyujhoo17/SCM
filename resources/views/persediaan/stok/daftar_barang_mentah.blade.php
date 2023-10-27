@extends('tamplate')

@section('judul')
    <p>Daftar Barang Mentah</p>
@endsection

@section('konten')
    <br><br>
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-right">
                <button type="button" class="btn btn-round btn-success" id="tambah" data-toggle="modal"
                    data-target=".modalbarang">Tambah
                    Barang</button>
            </div>
        </div>
    </div>

    <table id="datatable" class="table table-striped table-bordered" style="width:100%">

        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Pemasok</th>
                <th>Stok</th>
                <th>Satuan Simpan</th>
                <th>Aksi</th>
            </tr>
        </thead>


        <tbody>
            @php
                $urut = 0;
            @endphp
            @foreach ($barang as $barang)
                @php
                    $urut += 1;
                @endphp
                <tr id="tr_{{ $barang->id }}">
                    <td>{{ $urut }}</td>
                    <td>{{ $barang->nama }}</td>
                    <td>
                        <table style="width: 100%">
                            @foreach ($barang->pemasok as $bp)
                                <tr>
                                    <td>{{ $bp->nama }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%">
                            <tr>
                                <th>Jumlah Stok</th>
                                <th>Lokasi gudang</th>
                            </tr>

                            @if ($barang->gudang == '[]')
                                <td>0</td>
                                <td>-</td>
                            @else
                                @foreach ($barang->gudang as $pg)
                                    <tr>
                                        <td>{{ $pg->pivot->jumlah }}</td>
                                        <td>{{ $pg->nama }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </table>
                    </td>
                    <td>{{ $barang->satuan->nama }}</td>
                    <td><a href="#Umodalbarang" id="edit" class="btn btn-primary" data-toggle="modal"
                            data-target=".Umodalbarang" onclick="editData({{ $barang->id }})">Edit</a>

                        <form method="POST" action="{{ route('daftar-barang-mentah.destroy', $barang->id) }}">
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
    <form method="POST" action="{{ route('daftar-barang-mentah.store') }}">
        @csrf
        <div class="modal fade modalbarang">
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

                        {{-- Harga Beli --}}
                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="harga">Harga pasar <span
                                    class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 ">
                                <input type="number" id="harga" name="harga" required="required"
                                    class="form-control ">
                            </div>
                        </div>
                        {{-- satuan --}}
                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="satuan">satuan <span
                                    class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 ">
                                <select class="form-control py-4" name="satuan" id="satuan" style="width: 100%;">
                                    @foreach ($satuan as $satuan)
                                        <option value="{{ $satuan->id }}">{{ $satuan->nama }}</option>
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
        <div class="modal fade Umodalbarang">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Ubah Barang</h5>
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
@endsection

@section('javascript')
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
    </script>

    <script>
        $(document).ready(function() {
            $("#satuan").select2();

        });
    </script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function editData(id) {
            // console.log(1);
            $.ajax({
                type: 'GET',
                url: 'daftar-barang-mentah/'+id+'/edit',
                data: {
                    id
                },
                success: function(data) {
                    // console.log(data.msg);
                    $("#UbahModal").html(data.msg);
                },
                error: function() {
                    alert("error!!!!");
                }
            }); //end of ajax
            // console.log(2);
        }

        //  GET EDIT DATA
            $(document).ready(function() {
            var table = $('#datatable').DataTable();
            table.on('click', '#edit', function() {
                $tr = $(this).closest('tr');
                if ($($tr).hasClass('child')) {
                    $tr = $tr.prev('.parent');
                }
                var data = table.row($tr).data();
                $('#editform').attr('action', 'daftar-barang-mentah/' + data[0]);
            });
        });
    </script>
@endsection
