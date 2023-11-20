<form method="POST" action="/gudang/{{ $gudang->id }}">
    @csrf
    @method('PUT')
<div class="modal-body">
      <div class="form-group">
        <label for="recipient-name" class="col-form-label">Nama :</label>
        <input type="text" name="nama-gudang" class="form-control" id="recipient-name" value="{{ $gudang->nama }}">
      </div>
      <div class="form-group">
        <label for="alamat" class="col-form-label">Alamat :</label>
        <textarea class="form-control" name="alamat" id="alamat" >{{ $gudang->alamat }}</textarea>
      </div>

      <br>
      

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Save changes</button>
</div>
</form>