<div class="item form-group">
    <label class="col-form-label col-md-3 col-sm-3 label-align" for="Unama">Nama <span
            class="required">*</span>
    </label>
    <div class="col-md-6 col-sm-6 ">
        <input type="text" value="{{ $pegawai->nama }}" id="Unama" name="Unama" required="required"
            class="form-control ">
    </div>
</div>
{{-- Alamat --}}
<div class="item form-group">
    <label class="col-form-label col-md-3 col-sm-3 label-align" for="Ualamat">Alamat <span
            class="required">*</span>
    </label>
    <div class="col-md-9 col-sm-9 ">
        <textarea class="form-control"name="Ualamat" id="Ualamat" rows="3">{{ $pegawai->alamat}}</textarea>
    </div>
</div>
{{-- No TLP --}}
<div class="item form-group">
    <label class="col-form-label col-md-3 col-sm-3 label-align" for="Utelepon">No telepon <span
            class="required">*</span>
    </label>
    <div class="col-md-6 col-sm-6 ">
        <input type="number" id="Utelepon" value="{{ $pegawai->no_tlp}}" name="Utelepon" required="required"
            class="form-control ">
    </div>
</div>
{{-- Email --}}
<div class="item form-group">
    <label class="col-form-label col-md-3 col-sm-3 label-align" for="Uemail">Email <span
            class="required">*</span>
    </label>
    <div class="col-md-6 col-sm-6 ">
        <input type="text" id="Uemail" value="{{ $pegawai->email }}" name="Uemail" required="required"
            class="form-control">
    </div>
</div>
{{-- Kategori --}}
{{-- {{ $pegawai->jabatan->nama }} --}}
<div class="item form-group">
    <label class="col-form-label col-md-3 col-sm-3 label-align" for="Ujabatan">Jabatan <span
            class="required">*</span>
    </label>
    <div class="col-md-6 col-sm-6 ">
        <select class="form-control py-4" name="Ujabatan" id="Ujabatan" style="width: 100%;">
            @foreach ($jabatan as $j)
            {{ $selected = '' }}
            @if ($j->id == $pegawai->jabatan->id)
               {{ $selected = 'selected'}}
            @else
            @endif
                <option value="{{ $j->id }}" {{ $selected }}>{{ $j->nama }} </option>
            @endforeach
        </select>
    </div>
</div>

<script> $("#Ujabatan").select2();</script>