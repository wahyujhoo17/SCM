<form method="POST" action="/daftar-outlet/{{ $outlet->id }}">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="namaOutlet">Nama Outlet:</label>
        <input type="text" class="form-control" name="nama" id="namaOutlet"
            placeholder="Masukkan nama outlet" value="{{ $outlet->nama }}">
    </div>
    <div class="form-group">
        <label for="alamatOutlet">Alamat Outlet:</label>
        <textarea name="alamat" class="form-control" id="alamatOutlet" cols="30" rows="3">{{ $outlet->alamat }}</textarea>
    </div>
    <button type="submit" class="btn btn-primary float-right">Simpan</button>
    <button type="button" id="batal" class="btn btn-outline-secondary float-right"
        data-dismiss="modal">Batal</button>
</form>