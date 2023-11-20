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

{{-- Item --}}
<div class="item form-group">
    <label class="col-form-label col-md-3 col-sm-3 label-align" for="addItem">Item <span class="required">*</span>
    </label>
    <div class="col-md-6 col-sm-6 ">
        <select name="AddItemBarang" id="addItemBarang" class="form-control" style="width: 200px;">
            <option value="">Pilih Item</option>

            @foreach ($barang as $b)
                <option value="{{ $b->nomor }}">{{ $b->nama }}</option>
            @endforeach
        </select>

        <button type="button" onclick="tmbahItem({{ $pemasok->id }})" class="btn btn-round btn-success"
            style="margin-left: 20px;">Tambah
            Item</button>
    </div>
</div>

<h3>Daftar Item</h3>
<br>
<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button"
            role="tab" aria-controls="nav-home" aria-selected="true">Barang Mentah</button>
        <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button"
            role="tab" aria-controls="nav-profile" aria-selected="false">Produk</button>
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


            @foreach ($pemasok->barang as $pb)
                <tr>
                    <td>{{ $pb->nomor }}</td>
                    <td>{{ $pb->nama }}</td>
                    <td>
                        {{-- <input name="_method" type="hidden" value="DELETE"> --}}
                        <button type="button" onclick="hapusItem('{{ $pb->nomor }}' , this)" class="btn btn-danger"
                            id="hapus_{{ $pb->id }}">Hapus</button>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

    {{-- Produk --}}
    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
        <table class="table table-striped jambo_table bulk_action" id="tableProduk">
            <tr>
                <th style="width: 20%">No</th>
                <th>Nama</th>
                <th style="width: 10%">Hapus</th>
            </tr>

            @foreach ($pemasok->produk as $pp)
                <tr>
                    <td>{{ $pp->produk_id }}</td>
                    <td>{{ $pp->nama }}</td>
                    <td>
                        <button type="button" onclick="hapusItem('{{ $pp->produk_id }}' , this)" class="btn btn-danger"
                            id="hapus_{{ $pp->id }}">Hapus</button>
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

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function tmbahItem(id) {
        count++;

        nama = $("#addItemBarang  option:selected").text();
        idItem = $("#addItemBarang").val();

        // console.log(idItem);

        var htmlRows = '';
        htmlRows += '<tr>';
        htmlRows += '<td>' + idItem + '</td>';
        htmlRows += '<td><input type="text" name="item[]" id="item_' + count +
            '" class="form-control-plaintext" autocomplete="off" value="' + nama + '" readonly></td>';
        htmlRows +=
            '<td><button type="button" class="btn btn-danger" onclick="hapusItem('+'idItem.toString()'+', this)" id="hapus_' + idItem + '">Hapus</button></td>';
        htmlRows += '</tr>';
        if ($('#addItemBarang').val() != '') {
            $.ajax({
                type: 'post',
                url: '/pemasok-item',
                data: {
                    'nama': nama,
                    'id': id,
                    'jenis': item,
                    'idItem': idItem,
                },
                success: function(data) {
                    console.log(data);
                    if (data.msg == 'masuk') {
                        if (item == 'barang') {
                            $('#tableBarang').append(htmlRows);
                        } else {
                            $('#tableProduk').append(htmlRows);
                        }

                    } else {
                        alert('data sudah ada');
                    }
                },
                error: function() {
                    alert("error!!!!");
                }
            });
        }
    }

    var count = $(".itemRow").length;
    $(document).on('click', '#nav-home-tab', function() {
        count = $(".itemRow").length;
        // console.log("barang");

        var variable = '' +
            '<option value="">Pilih Item</option>' +
            '@foreach ($barang as $b)' +
            '<option value="{{ $b->nomor }}">{{ $b->nama }}</option>' +
            '@endforeach' +
            '';

        $('#addItemBarang').html(variable);
        item = 'barang';
    });

    $(document).on('click', '#nav-profile-tab', function() {
        count = $(".itemRowP").length;
        var variable = '' +
            '<option value="">Pilih Item</option>' +
            '@foreach ($produk as $p)' +
            '<option value="{{ $p->produk_id }}">{{ $p->nama }}</option>' +
            '@endforeach' +
            '';

        $('#addItemBarang').html(variable);
        item = "produk";
    });

    function hapusItem(id, row) {

        console.log(id);
        pemasokID = '{{ $pemasok->id }}';
        $.ajax({
            type: 'post',
            url: '/pemasok-hapus-item',
            data: {
                'item': id,
                'pemasok': pemasokID,
                'jenis': item,
            },
            success: function(data) {
                console.log(data);



            },
            error: function() {
                alert("error!!!!");
            }
        });
        var row = row.parentNode.parentNode;
                row.parentNode.removeChild(row);

    }
</script>
