@extends('tamplate')

@section('judul')
    <p>Daftar Pemasok</p>
@endsection

@section('konten')
    <br><br>

    <div class="container">
        <div class="row">
            <div class="col-md-12 text-right">
                <button type="button" class="btn btn-round btn-success" data-toggle="modal" data-target=".modalpemasok">Tambah
                    Pemasok</button>
            </div>
        </div>
    </div>

    <table id="datatable" class="table table-striped jambo_table bulk_action" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>No telepon</th>
                <th>Item</th>
                <th>Email</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($data as $pemasok)
                <tr id="tr_{{ $pemasok->id }}">
                    <td>{{ $pemasok->pemasok_id }}</td>
                    <td>{{ $pemasok->nama }}</td>
                    <td>{{ $pemasok->alamat }}</td>
                    <td>{{ $pemasok->no_tlp }}</td>
                    <td>
                        <table style="width: 100%">
                            @foreach ($pemasok->barang as $bp)
                                <tr>
                                    <td>{{ $bp->nama }}</td>
                                </tr>
                            @endforeach
                            @foreach ($pemasok->produk as $p)
                                <tr>
                                    <td>{{ $p->nama }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </td>
                    <td>{{ $pemasok->email }}</td>
                    <td>
                        <div class="d-grid gap-2 d-md-block">
                            <button data-toggle="modal" data-target=".Umodalpemasok" id='edit'
                                onclick="editData({{ $pemasok->id }})" class="btn btn-primary" type="button">Edit</button>

                            <form method="POST" action="{{ route('pemasok.destroy', $pemasok->id) }}">
                                @csrf
                                <input name="_method" type="hidden" value="DELETE">
                                <button type="submit" class="btn btn-xs btn-danger btn-flat show_confirm"
                                    data-toggle="tooltip" type="button">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Modal Tambah Data --}}
    <form method="POST" action="{{ route('pemasok.store') }}">
        @csrf
        <div class="modal fade modalpemasok" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Tambah pemasok</h5>
                    </div>
                    {{-- NAMA --}}
                    <div class="modal-body">
                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="nama">Nama <span
                                    class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 ">
                                <input type="text" id="nama" name="nama" required="required"
                                    class="form-control ">
                            </div>
                        </div>

                        {{-- Alamat --}}
                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="alamat">Alamat <span
                                    class="required">*</span>
                            </label>
                            <div class="col-md-9 col-sm-9 ">
                                <textarea class="form-control" name="alamat" id="alamat" rows="3"></textarea>
                            </div>
                        </div>
                        {{-- No TLP --}}
                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="telepon">No telepon <span
                                    class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 ">
                                <input type="text" id="telepon" name="telepon" required="required"
                                    class="form-control ">
                            </div>
                        </div>

                        {{-- No TLP --}}
                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="email">Email <span
                                    class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 ">
                                <input type="text" id="email" name="email" required="required"
                                    class="form-control ">
                            </div>
                        </div>


                    </div>

                    <div class="modal-footer">
                        <button type="button" id="batal" class="btn btn-outline-secondary"
                            data-dismiss="modal">Batal</button>
                        <input type="submit" class="btn btn-primary" id="tambahkan" name="insert" value="Tambahkan" />
                    </div>
                </div>
            </div>
        </div>
    </form>

    {{-- MODAL UDAH DATA --}}

    <form method="POST" action="" id="editform">
        @csrf
        @method('PUT')
        <div class="modal fade Umodalpemasok">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Ubah pelanggan</h5>
                    </div>
                    {{-- NAMA --}}
                    <div class="modal-body" id="Ubahmodal">


                    </div>

                    <div class="modal-footer">
                        <button type="button" id="batal" class="btn btn-outline-secondary"
                            data-dismiss="modal">Batal</button>
                        <input type="submit" class="btn btn-primary" id="tambahkan" name="insert"
                            value="Tambahkan" />
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
        // Alert berhasil
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

        //  GET EDIT DATA
        $(document).ready(function() {
            var table = $('#datatable').DataTable();
            table.on('click', '#edit', function() {
                $tr = $(this).closest('tr');
                if ($($tr).hasClass('child')) {
                    $tr = $tr.prev('.parent');
                }
                var data = table.row($tr).data();

                $('#editform').attr('action', 'pemasok/' + data[0]);
            });
        });

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

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function editData(id) {
            // console.log(1);
            $.ajax({
                type: 'GET',
                url: 'pemasok/' + id + '/edit',
                data: {
                    id
                },
                success: function(data) {
                    // console.log(data.msg);
                    $("#Ubahmodal").html(data.msg);
                },
                error: function() {
                    alert("error!!!!");
                }
            }); //end of ajax
            // console.log(2);
        }


    </script>


@endsection
