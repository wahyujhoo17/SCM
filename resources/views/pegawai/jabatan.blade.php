@extends('tamplate')

@section('judul')
    <p>Daftar Jabatan</p>
@endsection

@section('konten')
    <br><br>

    <div class="container">
        <div class="row">
            <div class="col-md-12 text-right">
                <button type="button" class="btn btn-round btn-success" data-toggle="modal" data-target=".modalJabatan">Tambah
                    Jabatan</button>
            </div>
        </div>
    </div>

    <table id="datatable" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($data as $jabatan)
                <tr id="tr_{{ $jabatan->id }}">
                    <td>{{ $jabatan->id }}</td>
                    <td>{{ $jabatan->nama }}</td>
                    <td>
                        <div class="d-grid gap-2 d-md-block">
                            <button data-toggle="modal" data-target=".Umodaljabatan" id='edit' class="btn btn-primary"
                                onclick="#" type="button">Edit</button>

                            <form method="POST" action="{{ route('jabatan.destroy', $jabatan->id) }}">
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

    {{-- Modal Data --}}
    <form method="POST" action="{{ route('jabatan.store') }}">
        @csrf
        <div class="modal fade modalJabatan">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Tambah Jabatan</h5>
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
        <div class="modal fade UmodalJabatan">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Ubah pegawai</h5>
                    </div>
                    {{-- NAMA --}}
                    <div class="modal-body" id="UbahModal">

                    </div>

                    <div class="modal-footer">
                        <button type="button" id="batal" class="btn btn-outline-secondary"
                            data-dismiss="modal">Batal</button>
                        <input type="submit" class="btn btn-primary" id="tambahkan" name="insert" value="Ubah" />
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('javascript')
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
                $('#editform').attr('action', 'pegawai/' + data[0]);
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
    </script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function editData(id) {
            // console.log(1);
            // $.ajax({
            //     type: 'GET',
            //     url: '{{ route('pegawai.edit', 'id') }}',
            //     data: {
            //         id
            //     },
            //     success: function(data) {
            //         $("#UbahModal").html(data.msg);
            //     },
            //     error: function() {
            //         alert("error!!!!");
            //     }
            // }); //end of ajax
            // console.log(2);
        }
    </script>
@endsection
