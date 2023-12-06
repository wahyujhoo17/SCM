@extends('tamplate')

@section('judul')
    <p> Konfirmasi Gudang</p>
@endsection

@section('konten')
    <div class="clearfix"></div>


    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button"
                role="tab" aria-controls="nav-home" aria-selected="true">Masuk</button>
            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button"
                role="tab" aria-controls="nav-profile" aria-selected="false">Keluar</button>
        </div>
    </nav>

    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
            <br>
            <div class="table-responsive">
                <table class="table table-striped jambo_table bulk_action" id="datatable">
                    <thead>
                        <tr class="headings">
                            <th class="column-title">No Nota </th>
                            <th class="column-title">Tanggal </th>
                            <th class="column-title">Pegawai</th>
                            <th class="column-title">Pemasok </th>
                            <th class="column-title">Status </th>
                            <th class="column-title no-link last"><span class="nobr">Action</span>
                            </th>
                            <th class="bulk-actions" colspan="7">
                                <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span
                                        class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($data as $notaP)
                            <tr class="even pointer" id="tr_{{ $notaP->no_nota }} ">
                                <td>{{ $notaP->no_nota }}</td>
                                <td>{{ $notaP->tanggal }}</td>
                                <td>{{ $notaP->pegawai->nama }}</td>
                                <td>{{ $notaP->pemasok->nama }}</td>
                                <td>
                                    <span class="badge badge-pill badge-info">Belum Dikonfirmasi</span>
                                </td>

                                <td class=" last"><a href="#" data-toggle="modal" data-target=".view-konfirmasi"
                                        onclick="detail('{{ $notaP->id }}')">View</a>
                                </td>
                            </tr>
                        @endforeach
                        {{-- PRODUKSI --}}
                        @foreach ($produksi as $prd)
                            <tr class="even pointer" id="tr_{{ $prd->nomor }} ">
                                <td>{{ $prd->nomor }}</td>
                                <td>{{ $prd->tanggal_selesai }}</td>
                                <td>{{ $prd->pegawai->nama }}</td>
                                <td>-</td>
                                <td>
                                    <span class="badge badge-pill badge-info">Belum Dikonfirmasi</span>
                                </td>

                                <td class=" last"><a href="#" data-toggle="modal" data-target=".view-produksi"
                                        onclick="detailProduksi('{{ $prd->id }}')">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
            <br>
            <div class="table-responsive">
                <table class="table table-striped jambo_table bulk_action" id="tableKeluar" style="width: 100%">
                    <thead>
                        <tr class="headings">
                            <th class="column-title">No Permintaan </th>
                            <th class="column-title">Tanggal </th>
                            <th class="column-title">Outlet</th>
                            <th class="column-title">Alamat </th>
                            <th class="column-title">Status </th>
                            <th class="column-title no-link last"><span class="nobr">Action</span>
                            </th>
                            <th class="bulk-actions" colspan="7">
                                <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span
                                        class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($permintaan as $per)
                            <tr class="even pointer" id="tr_{{ $per->id }} ">
                                <td>{{ $per->nomor }}</td>
                                <td>{{ $per->tanggal }}</td>
                                <td>{{ $per->outlet->nama }}</td>
                                <td>{{ $per->outlet->alamat }}</td>
                                <td>
                                    <span class="badge badge-pill badge-info">Belum Dikonfirmasi</span>
                                </td>

                                <td class=" last"><a href="#" data-toggle="modal" data-target=".view-permintaan"
                                        onclick="detailKeluar('{{ $per->id }}')">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- MODAL VIEW --}}
    <!-- Tambah Modal -->
    <form method="POST" action="{{ route('konfirmasi.store') }}">
        @csrf
        <div class="modal fade view-konfirmasi" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content" id="invoiceItem">

                </div>
            </div>
        </div>
    </form>

    <!-- VIEW PERMINTAAN MODAL -->
    <form method="POST" action="/konfirmasi-permintaan">
        @csrf
        <div class="modal fade view-permintaan" role="dialog" aria-labelledby="myExtraLargeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content" id="viewPermintaan">

                </div>
            </div>
        </div>
    </form>

    <!-- VIEW PERMINTAAN MODAL -->
    <form method="POST" action="/produksi/konfirmasi">
        {{-- @method('PUT'); --}}
        @csrf
        <div class="modal fade view-produksi" role="dialog" aria-labelledby="myExtraLargeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content" id="viewProduksi">

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
        $('#datatable').dataTable({
            "order": [
                [1, 'asc']
            ]
        });
        $(document).ready(function() {
            $("#gudang").select2();
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

        //Alert Berhasil
        var msg = '{{ Session::get('alert') }}';
        var exist = '{{ Session::has('alert') }}';
        if (exist) {
            swal("Success", msg, "success");
        }
    </script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function detail(id) {
            $.ajax({
                type: 'GET',
                url: '/konfirmasi/' + id,
                data: {
                    'id': id,
                },
                success: function(data) {
                    // console.log(data.msg);
                    $('#invoiceItem').html(data.msg);
                },
                error: function() {
                    alert("error!!!!");
                }
            });
        }

        function detailKeluar(id) {
            $.ajax({
                type: 'GET',
                url: '/view-permintaan/' + id,
                data: {},
                success: function(data) {
                    // console.log(data);
                    $('#viewPermintaan').html(data.msg);
                },
                error: function() {
                    alert("error!!!!");
                }
            });
        }

        function detailProduksi(id) {

            $.ajax({
                type: 'GET',
                url: '/konfirmasi/produksi/' + id,
                data: {},
                success: function(data) {
                    $('#viewProduksi').html(data.msg);
                },
                error: function() {
                    alert("error!!!!");
                }
            });
        }
    </script>
    <script>
        $('#nama-gudang').change(function() {
            id_gudang = $("#nama-gudang").val();
            @php
                $gudang_id = 'id_gudang';
            @endphp

        });

        $('#tableKeluar').DataTable({
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
                [0, 'desc']
            ]
        });
    </script>
@endsection
