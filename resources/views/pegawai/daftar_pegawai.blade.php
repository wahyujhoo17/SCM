@extends('tamplate')

@section('judul')
    <p>Daftar Pegawai</p>
@endsection

@section('konten')
    <br><br>

    <div class="container">
        <div class="row">
            <div class="col-md-12 text-right">
                <button type="button" class="btn btn-round btn-success" data-toggle="modal" data-target=".modalpegawai">Tambah
                    Karyawan</button>
            </div>
        </div>
    </div>

    <table id="datatable" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>No telepon</th>
                <th>Email</th>
                <th>Jabatan</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($data as $pegawai)
                <tr id="tr_{{ $pegawai->id }}">
                    <td>{{ $pegawai->user_id }}</td>
                    <td>{{ $pegawai->nama }}</td>
                    <td>{{ $pegawai->alamat }}</td>
                    <td>{{ $pegawai->no_tlp }}</td>
                    <td>{{ $pegawai->email }}</td>
                    <td>{{ $pegawai->jabatan->nama }}</td>
                    <td>
                        <div class="d-grid gap-2 d-md-block">
                            <button data-toggle="modal" data-target=".Umodalpegawai" id='edit' class="btn btn-primary"
                                onclick="editData({{ $pegawai->id }})" type="button">Edit</button>

                            <form method="POST" action="{{ route('pegawai.destroy', $pegawai->id) }}">
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
    <form method="POST" action="{{ route('pegawai.store') }}">
        @csrf
        <div class="modal fade modalpegawai">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Tambah pegawai</h5>
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
                                <input type="number" id="telepon" name="telepon" required="required"
                                    class="form-control ">
                            </div>
                        </div>
                        {{-- Email --}}
                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="email">Email <span
                                    class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 ">
                                <input type="text" id="email" name="email" required="required"
                                    class="form-control ">
                            </div>
                        </div>
                        {{-- jabatan --}}
                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="jabatan">jabatan <span
                                    class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 ">
                                <select class="form-control py-4" name="jabatan" id="jabatan" style="width: 100%;">
                                    @foreach ($kt as $jabatan)
                                        <option value="{{ $jabatan->id }}">{{ $jabatan->nama }} </option>
                                    @endforeach
                                </select>
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
        <div class="modal fade Umodalpegawai">
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
        $(document).ready(function() {
            $("#jabatan").select2();
            $("#Ujabatan").select2();
        });
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
