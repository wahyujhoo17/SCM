@extends('tamplate')

@section('judul')
    <p>Area Gudang</p>
@endsection

@section('konten')
    <div class="clearfix"></div>

    <div class="row">
        <div class="x_panel">
            <div class="x_content">
                <div class="col-md-12 col-sm-12  text-center">
                </div>

                <div class="clearfix"></div>
                @php
                    $gudangid =0;
                @endphp

                @foreach ($data as $gudang)
                    <div class="col-md-4 col-sm-4  profile_details">
                        <div class="well profile_view">
                            <div class="col-sm-12">
                                <h4 class="brief"><i>Gudang</i></h4>
                                <div class="left col-md-7 col-sm-7">
                                    <h2>{{ $gudang->nama }}</h2>
                                    {{-- <p><strong>About: </strong> Web Designer / UX / Graphic Artist / Coffee Lover </p> --}}
                                    <ul class="list-unstyled">
                                        <li><i class="fa fa-building"></i> Alamat : {{ $gudang->alamat }}</li>
                                    </ul>
                                    
                                </div>
                            </div>
                            <div class=" profile-bottom text-right">
                                <div class=" col-sm emphasis">
                                    <button type="button" class="btn btn-secondary" data-toggle="modal"
                                        data-target=".modal-ubah-gudang"
                                        onclick="editGudang({{ $gudang->id }})">Edit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{-- AND --}}
            </div>
        </div>
    </div>

    {{-- TAMBAH AREA GUDANG --}}
    {{-- <form method="POST" action="">
        @csrf --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Area</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Nama:</label>
                        <input type="text" class="form-control" name="nama-area" id="nama-area">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    {{-- <button type="button" onclick="saveData()" class="btn btn-primary">Tambahkan Area</button> --}}
                </div>
            </div>
        </div>
    </div>
    {{-- </form> --}}

    {{-- MODAL UBAH GUDANG --}}

    <div class="modal fade modal-ubah-gudang" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Gudang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="isiUbahModal">

                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function editGudang(id) {

            $.ajax({
                type: 'GET',
                url: 'gudang/{gudang}/edit',
                data: {
                    'id': id,
                },
                success: function(data) {
                    // console.log(data.msg);
                    $('#isiUbahModal').html(data.msg);
                },
                error: function() {
                    alert("error!!!!");
                }
            });
        }
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
    </script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        idgudang = 0

        function getID(id) {
            idgudang = id;
        }
    </script>
@endsection
