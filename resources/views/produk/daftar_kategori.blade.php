@extends('tamplate')

@section('judul')
    <p>Daftar Kategori</p>
@endsection

@section('konten')
    <br><br>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <div class="container">
        <div class="row">
            <div class="col-md-12 text-right">
                <button type="button" class="btn btn-round btn-success" data-toggle="modal" data-target=".modalKategori">Tambah
                    Kategori</button>
            </div>
        </div>
    </div>

    <table id="datatable" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($data as $kategori)
                <tr id="tr_{{ $kategori->id }}">
                    <td>{{ $kategori->id }}</td>
                    <td>{{ $kategori->nama }}</td>
                    <td>{{ $kategori->keterangan }}</td>
                    <td>
                        <div class="d-grid gap-2 d-md-block">
                            <button data-toggle="modal" id="edit" data-target=".UmodalKategori" class="btn btn-primary"
                                type="button">Edit</button>

                            <form method="POST" action="{{ route('kategori.destroy', $kategori->id) }}">
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
    <form method="POST" action="{{ route('kategori.store') }}">
        @csrf
        <div class="modal fade modalKategori" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Tambah Kategori</h5>
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
                        <br>

                        {{-- KETERANGAN --}}
                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="keterangan">keterangan <span
                                    class="required">*</span>
                            </label>
                            <div class="col-md-9 col-sm-9 ">
                                <textarea class="form-control" name="keterangan" id="keterangan" rows="3"></textarea>
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
        <div class="modal fade UmodalKategori" ">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5>Ubah Kategori</h5>
                        </div>
                            {{-- NAMA --}}
                            <div class="modal-body">
                                                 <div class="item form-group">
                                                      <label class="col-form-label col-md-3 col-sm-3 label-align" for="Unama">Nama <span
                                                             class="required">*</span>
                                                     </label>
                                                     <div class="col-md-6 col-sm-6 ">
                                                           <input type="text" id="Unama" name="Unama" required="required"
                                                             class="form-control ">
                                                     </div>

                                                 <br>
                                                 </div>

                                            {{-- KETERANGAN --}}
                                            <div class="item form-group">
                                                <label class="col-form-label col-md-3 col-sm-3 label-align" for="keterangan">keterangan <span
                                                         class="required">*</span>
                                                </label>
                                                <div class="col-md-9 col-sm-9 ">
                                                     <textarea class="form-control" name="Uketerangan" id="Uketerangan" rows="3"></textarea>
                                                </div>
                                            </div>

                                         </div>
                                        <div class="modal-footer">
                                            <button type="button" id="batal" class="btn btn-outline-secondary"
                                                                                                        data-dismiss="modal">Batal</button>
                                            <input type="submit" value="Ubah" type="hidden" class="btn btn-primary" id="Ubah" name="insert" />
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
                // console.log(data[0]);
                $('#Unama').val(data[1]);
                $('#Uketerangan').val(data[2]);
                $('#editform').attr('action', 'kategori/' + data[0]);
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
@endsection
