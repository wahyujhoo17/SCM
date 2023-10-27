<div class="item form-group">
    <label class="col-form-label col-md-3 col-sm-3 label-align" for="Unama">Nama <span class="required">*</span>
    </label>
    <div class="col-md-6 col-sm-6 ">
        <input type="text" id="Unama" name="Unama" value="{{ $pemasok->nama }}" required="required"
            class="form-control ">
    </div>
</div>

{{-- Alamat --}}
<div class="item form-group">
    <label class="col-form-label col-md-3 col-sm-3 label-align" for="Ualamat">Alamat <span class="required">*</span>
    </label>
    <div class="col-md-9 col-sm-9 ">
        <textarea class="form-control" name="Ualamat" id="Ualamat" rows="3">{{ $pemasok->alamat }}</textarea>
    </div>
</div>
{{-- No TLP --}}
<div class="item form-group">
    <label class="col-form-label col-md-3 col-sm-3 label-align" for="Utelepon">No telepon <span
            class="required">*</span>
    </label>
    <div class="col-md-6 col-sm-6 ">
        <input id="Utelepon" name="Utelepon" required="required" value="{{ $pemasok->no_tlp }}" class="form-control ">
    </div>
</div>

{{-- Email --}}
<div class="item form-group">
    <label class="col-form-label col-md-3 col-sm-3 label-align" for="Uemail">Email <span class="required">*</span>
    </label>
    <div class="col-md-6 col-sm-6 ">
        <input id="Uemail" name="Uemail" required="required" value="{{ $pemasok->email }}" class="form-control ">
    </div>
</div><br>
<h3>Daftar Item</h3>
<br>

<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button"
            role="tab" aria-controls="nav-home" aria-selected="true">Barang Mentah</button>
        <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button"
            role="tab" aria-controls="nav-profile" aria-selected="false">Produk</button>

        <div class="col-md text-right">
            <select name="AddItemBarang" id="addItemBarang" class=form-control">
                <option value="">Pilih Item</option>

                @foreach ($barang as $b)
                    <option value="{{ $b->id }}">{{ $b->nama }}</option>
                @endforeach
            </select>

            <button type="button" onclick="tmbahItem()" class="btn btn-round btn-success">Tambah
                Item</button>
        </div>
    </div>

</nav>

{{-- Barang Mnetah --}}

<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <table class="table table-striped jambo_table bulk_action" id="tableBarang">
            <tr>
                <th style="width: 20%">No</th>
                <th>Nama</th>
                <th style="width: 10%">Hapus</th>
            </tr>
            @php
                $urut = 0;
            @endphp

            @foreach ($pemasok->barang as $pb)
                @php
                    $urut += 1;
                @endphp
                <tr>
                    <td class="itemRow">{{ $urut }}</td>
                    <td>{{ $pb->nama }}</td>
                    <td>
                        <form method="POST" action="{{ route('pemasok.destroy', $pemasok->id) }}">
                            @csrf
                            <input name="_method" type="hidden" value="DELETE">
                            <button type="submit" class="btn btn-xs btn-danger btn-flat show_confirm"
                                data-toggle="tooltip" type="button">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

    {{-- Produk --}}
    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
        <table class="table table-striped jambo_table bulk_action" id="datatable">
            <tr>
                <th style="width: 20%">No</th>
                <th>Nama</th>
                <th style="width: 10%">Hapus</th>
            </tr>

            @php
                $urut = 0;
            @endphp

            @foreach ($pemasok->produk as $pp)
                @php
                    $urut += 1;
                @endphp
                <tr>
                    <td>{{ $urut }}</td>
                    <td>{{ $pp->nama }}</td>
                    <td>
                        <form method="POST" action="{{ route('pemasok.destroy', $pemasok->id) }}">
                            @csrf
                            <input name="_method" type="hidden" value="DELETE">
                            <button type="submit" class="btn btn-xs btn-danger btn-flat show_confirm"
                                data-toggle="tooltip" type="button">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#addItemBarang").select2();

    });

    var item = 'barang';
    var count = $(".itemRow").length;

    function tmbahItem() {
        
        count++;
        nama = $("#addItemBarang  option:selected").text();

        var htmlRows = '';
                htmlRows += '<tr>';
                htmlRows += '<td>'+count+'</td>';
                htmlRows += '<td>'+nama+'</td>';
                htmlRows += '<td><button type="submit" class="btn btn-xs btn-danger btn-flat show_confirm" data-toggle="tooltip" type="button">Hapus</button></td>';
                htmlRows += '</tr>';

        if($('#addItemBarang').val() != ''){
            $('#tableBarang').append(htmlRows);
            console.log(count);
        }
    }

    var count = $(".itemRow").length;
    $(document).on('click', '#nav-home-tab', function() {
        // console.log("barang");

        var variable = '' +
            '<option value="">Pilih Item</option>' +
            '@foreach ($barang as $b)' +
            '<option value="{{ $b->id }}">{{ $b->nama }}</option>' +
            '@endforeach' +
            '';

        $('#addItemBarang').html(variable);
        item = 'barang';
    });

    $(document).on('click', '#nav-profile-tab', function() {
        // console.log("produk");

        var variable = '' +
            '<option value="">Pilih Item</option>' +
            '@foreach ($produk as $p)' +
            '<option value="{{ $p->id }}">{{ $p->nama }}</option>' +
            '@endforeach' +
            '';

        $('#addItemBarang').html(variable);
        item = "produk";
    });
</script>
