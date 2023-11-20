@extends('tamplate')

@section('judul')
    <p>Stok Opname</p>
@endsection

@section('konten')
    {{-- MODAL UBAH DATA --}}
    <form method="POST" action="" id="editform">
        @csrf
        @method('PUT')
        <div class="modal fade UbahSO">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Ubah Data</h5>
                    </div>
                    {{-- NAMA --}}

                    <div class="modal-body" id="UbahModal">
                        <div class="form-group">
                            <label for="pilihan_nama">Nomor SPK:</label>
                            <input type="text" class="form-control" id="Unomor" name="nomor" readonly>
                        </div>
                        <div class="form-group">
                            <label for="pilihan_nama">Nama Gudang:</label>
                            <select class="form-control" id="Upilihan_nama" name="pilihan_nama">
                                <option value="">Pilih Gudang</option>
                                @foreach ($gudang as $g)
                                    <option value="{{ $g->id }}">{{ $g->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_mulai">Tanggal Mulai:</label>
                            <input type="date" class="form-control" id="Utanggal_mulai" name="tanggal_mulai">
                        </div>
                        <div class="form-group">
                            <label for="penanggung_jawab">Penanggung Jawab:</label>
                            <select class="form-control" id="Upenanggung_jawab" name="penanggung_jawab">
                                <option value="">Pilih Pegawai</option>
                                @foreach ($user as $u)
                                    <option value="{{ $u->id }}">{{ $u->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan:</label>
                            <textarea class="form-control" id="Uketerangan" name="keterangan" rows="3"></textarea>
                        </div>
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
    {{-- ENDMODAL --}}

    {{-- Modal SHOW --}}
    <div class="modal fade viewModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div id="view-konten">

                </div>
            </div>
        </div>
    </div>
    {{-- END MODAL --}}

    <div class="clearfix"></div>
    @if (Auth::user()->jabatan->nama == 'admin')
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home"
                    type="button" role="tab" aria-controls="nav-home" aria-selected="true">Daftar
                    Opname</button>
                <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile"
                    type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Perintah Stok
                    Opname</button>
            </div>
        </nav>
        <br>

        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

                <table class="table table-striped jambo_table bulk_action" id="datatable">
                    <thead>
                        <tr>
                            <th>Nomor</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal SPK</th>
                            <th>Keterangan</th>
                            <th>User ID</th>
                            <th>Gudang ID</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($stok_opname as $sp)
                            <tr>
                                <td>{{ $sp->nomor }}</td>
                                <td>{{ $sp->tanggal_mulai }}</td>
                                <td>{{ $sp->tanggal_SPK }}</td>
                                <td>{{ $sp->keterangan }}</td>
                                <td>{{ $sp->pegawai->nama }}</td>
                                <td>{{ $sp->gudang->nama }}</td>
                                <td>{{ $sp->status }}</td>
                                <td>
                                    @if ($sp->status == 'ditambahkan')
                                        <button class="btn btn-primary" data-toggle="modal" data-target=".UbahSO"
                                            onclick="getData({{ $sp->id }})">Edit</button>
                                    @else
                                        <button class="btn btn-link" data-toggle="modal" data-target=".viewModal"
                                            onclick="view({{ $sp->id }})">review</button>
                                    @endif

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- END CONTENT --}}
            </div>
            {{-- DAFTAR --}}
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab"><br>
                <div class="x_panel">
                    <div class="x_content" style="display: block;">
                        {{-- CONTENT --}}

                        <div class="form-row">
                            <div class="form-group col-md-6 mx-auto"> <!-- Gunakan class mx-auto di sini -->
                                <label for="nomor_spk">Nomor SPK:</label>
                                <input type="text" class="form-control" id="nomor_spk" name="nomor_spk"
                                    value="{{ $spk }}" readonly>
                            </div>
                            <div class="form-group col-md-6 mx-auto"> <!-- Gunakan class mx-auto di sini -->
                                <label for="tanggal_spk">Tanggal SPK:</label>
                                <input type="date" class="form-control" id="tanggal_spk" name="tanggal_spk" readonly>
                            </div>
                        </div>
                        <form id="spk_form" action="/stok-opname" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="pilihan_nama">Nama Gudang:</label>
                                <select class="form-control" id="pilihan_nama" name="pilihan_nama" required="required">
                                    <option value="">Pilih Gudang</option>
                                    @foreach ($gudang as $g)
                                        <option value="{{ $g->id }}">{{ $g->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="tanggal_mulai">Tanggal Mulai:</label>
                                <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" required="required">
                            </div>
                            <div class="form-group">
                                <label for="penanggung_jawab">Penanggung Jawab:</label>
                                <select class="form-control" id="penanggung_jawab" name="penanggung_jawab" required="required">
                                    <option value="">Pilih Pegawai</option>
                                    @foreach ($user as $u)
                                        <option value="{{ $u->id }}">{{ $u->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="keterangan">Keterangan:</label>
                                <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
                            </div>
                            <div class="mt-3">
                                <button type="submit" class="btn btn-success pull-right"
                                    id="simpan_data">Simpan</button>
                                <button type="button" class="btn btn-danger pull-right" id="hapus_data">Hapus
                                    Data</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        </div>
    @elseif(Auth::user()->jabatan->nama == 'manager gudang')
        <br>
        <table class="table table-striped jambo_table bulk_action" id="datatable">
            <thead>
                <tr>
                    <th>Nomor</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal SPK</th>
                    <th>Keterangan</th>
                    {{-- <th>Penaggung Jawab</th> --}}
                    <th>Gudang</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($stok_opname as $sp)
                    @if ($sp->user_id == Auth::user()->id)
                        <tr>
                            <td>{{ $sp->nomor }}</td>
                            <td>{{ $sp->tanggal_mulai }}</td>
                            <td>{{ $sp->tanggal_SPK }}</td>
                            <td>{{ $sp->keterangan }}</td>
                            {{-- <td>{{ $sp->pegawai->nama }}</td> --}}
                            <td>{{ $sp->gudang->nama }}</td>
                            <td>{{ $sp->status }}</td>
                            @if ($sp->status == 'ditambahkan')
                                <td>
                                    @if ($sp->tanggal_mulai <= date('Y-m-d'))
                                        <a class="btn btn-primary"
                                            href="{{ route('pengerjaan_opname', $sp->id) }}">Input</a>
                                    @endif
                                    <button class="btn btn-outline-dark"
                                        onclick="printDiv('printMe' , {{ $sp->id }})"><i class="fa fa-print"></i>
                                        Print</button>
                                </td>
                            @else
                                <td><button class="btn btn-link" data-toggle="modal" data-target=".viewModal"
                                        onclick="view({{ $sp->id }})">view</button></td>
                            @endif

                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    @endif

    {{-- DIV TO PRINT --}}

    <div id='printMe' style="visibility: hidden">
    </div>

@endsection
@section('javascript')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>

    <script>
        $('#datatable').dataTable({
            "order": [
                [0, 'desc']
            ]
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

        $(document).ready(function() {
            // Mengisi nilai tanggal SPK dengan tanggal saat ini
            var currentDate = new Date().toISOString().split('T')[0];
            $("#tanggal_spk").val(currentDate);
            // $("#tanggal_mulai").val(currentDate);

            if ('{{ Auth::user()->jabatan->nama }}' == 'admin') {
                var tanggal_mulai = document.getElementById('tanggal_mulai');
                tanggal_mulai.min = currentDate;

                var Utanggal_mulai = document.getElementById('Utanggal_mulai');
                Utanggal_mulai.min = currentDate;
            }
        });

        $(document).ready(function() {
            $("#hapus_data").click(function() {
                // console.log('masom');
                // Kode untuk menghapus data yang telah diinputkan
                $("#spk_form")[0].reset();
                $("#spesifik_data").empty();
            });
        });
    </script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function getData(id) {
            $.ajax({
                url: "/stok-opname/" + id,
                method: "GET",
                data: [
                    id
                ],
                success: function(data) {
                    var sp = data.sp;

                    var myForm = $('#editform');
                    // Change the action attribute to a new URL
                    myForm.attr('action', 'stok-opname/' + sp['id']);

                    $("#Unomor").val(sp['nomor']);
                    $('#Upilihan_nama').val(sp['gudang_id']);
                    $('#Utanggal_mulai').val(sp['tanggal_mulai']);
                    $('#Upenanggung_jawab').val(sp['user_id'])
                    $('#Uketerangan').val(sp['keterangan']);
                },
                error: function(xhr, status, error) {
                    // Callback yang dipanggil ketika terjadi kesalahan
                    console.error("Terjadi kesalahan: " + error);
                }
            });
        }
    </script>

    <script>
        function printDiv(divName, id) {

            $.ajax({
                url: "/print-list/" + id,
                method: "GET",
                data: [
                    id
                ],
                success: function(data) {
                    // console.log(data.view);
                    $('#printMe').html(data.view);

                    var printContents = document.getElementById(divName).innerHTML;
                    var originalContents = document.body.innerHTML;
                    document.body.innerHTML = printContents;
                    window.print();
                    document.body.innerHTML = originalContents;
                    location.reload();
                },
                error: function(xhr, status, error) {
                    // Callback yang dipanggil ketika terjadi kesalahan
                    console.error("Terjadi kesalahan: " + error);
                }
            });
        }

        function view(id) {
            $.ajax({
                url: "/view-stokopname/" + id,
                method: "GET",
                data: [
                    id
                ],
                success: function(data) {
                    $('#view-konten').html(data.view);
                },
                error: function(xhr, status, error) {
                    // Callback yang dipanggil ketika terjadi kesalahan
                    console.error("Terjadi kesalahan: " + error);
                }
            });
        }

        function review(id) {

            $.ajax({
                url: "/review/" + id,
                method: "POST",
                data: [
                    id
                ],
                success: function(data) {

                    if(data.msg == 'success'){
                        swal("Success", "Konfirmasi Berhasil Dilakukan", "success");
                        location.reload();
                    }
                    // console.log(data);
                },
                error: function(xhr, status, error) {
                    // Callback yang dipanggil ketika terjadi kesalahan
                    console.error("Terjadi kesalahan: " + error);
                }
            });
        }
    </script>
@endsection
