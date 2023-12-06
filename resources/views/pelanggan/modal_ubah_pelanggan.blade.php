<div class="item form-group">
    <label class="col-form-label col-md-3 col-sm-3 label-align" for="Unama">Nama <span
            class="required">*</span>
    </label>
    <div class="col-md-6 col-sm-6 ">
        <input type="text" value="{{ $pr->nama }}" id="Unama" name="Unama" required="required"
            class="form-control ">
    </div>
</div>
{{-- Alamat --}}
<div class="item form-group">
    <label class="col-form-label col-md-3 col-sm-3 label-align" for="Ualamat">Alamat <span
            class="required">*</span>
    </label>
    <div class="col-md-9 col-sm-9 ">
        <textarea class="form-control"name="Ualamat" id="Ualamat" rows="3">{{ $pr->alamat}}</textarea>
    </div>
</div>
{{-- No TLP --}}
<div class="item form-group">
    <label class="col-form-label col-md-3 col-sm-3 label-align" for="Utelepon">No telepon <span
            class="required">*</span>
    </label>
    <div class="col-md-6 col-sm-6 ">
        <input type="text" id="Utelepon" value="{{ $pr->no_tlp}}" name="Utelepon" required="required"
            class="form-control ">
    </div>
</div>
{{-- Kategori --}}
<div class="item form-group">
    <label class="col-form-label col-md-3 col-sm-3 label-align" for="Ukategori">Kategori <span
            class="required">*</span>
    </label>
    <div class="col-md-6 col-sm-6 ">
        <select class="form-control py-4" name="Ukategori" id="Ukategori" style="width: 100%;">
            @foreach ($kt as $kategori)
            {{ $selected = '' }}
            @if ($kategori->id == $pr->kategori_pelanggan_id)
               {{ $selected = 'selected'}}
            @else
            @endif
                <option value="{{ $kategori->id }}" {{ $selected }}>{{ $kategori->nama }} </option>
            @endforeach
        </select>
    </div>
</div>

<script> $("#Ukategori").select2();</script>