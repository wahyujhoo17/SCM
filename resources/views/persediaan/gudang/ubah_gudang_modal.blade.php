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
      

      <div class="d-flex justify-content-center"><h5>Area Gudang</h5></div>

      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Nama</th>


          </tr>
        </thead>
        <tbody>
          @php
            $urutan =0;   
          @endphp

          @foreach($gudang->area_gudang as $gad)
            @php
                $urutan +=1;
            @endphp
            <tr>
                <th scope="row">{{ $urutan }}</th>
                <td>{{ $gad->nama }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Save changes</button>
</div>
</form>