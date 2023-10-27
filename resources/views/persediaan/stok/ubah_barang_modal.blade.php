                      {{-- NAMA --}}
                      <div class="item form-group">
                          <label class="col-form-label col-md-3 col-sm-3 label-align" for="nama">Nama <span
                                  class="required">*</span>
                          </label>
                          <div class="col-md-6 col-sm-6 ">
                              <input type="text" id="nama" name="namaUbah" required="required" class="form-control" value="{{ $barang->nama }}">
                          </div>
                      </div>

                      {{-- Harga Beli --}}
                      <div class="item form-group">
                          <label class="col-form-label col-md-3 col-sm-3 label-align" for="harga">Harga pasar <span
                                  class="required">*</span>
                          </label>
                          <div class="col-md-6 col-sm-6 ">
                              <input type="number" id="harga" name="hargaUbah" required="required"
                                  class="form-control " value="{{ $barang->harga_beli }}">
                          </div>
                      </div>
                      {{-- satuan --}}
                      <div class="item form-group">
                          <label class="col-form-label col-md-3 col-sm-3 label-align" for="satuan">satuan <span
                                  class="required">*</span>
                          </label>
                          <div class="col-md-6 col-sm-6 ">
                              <select class="form-control py-4" name="satuanUbah" id="satuanUbah" style="width: 100%;">
                                  @foreach ($satuan as $satuan)
                                      {{ $selected = '' }}
                                      @if ($satuan->id == $barang->satuan_id)
                                          {{ $selected = 'selected' }}
                                      @else
                                      @endif
                                      <option value="{{ $satuan->id }}" {{ $selected }}>{{ $satuan->nama }}
                                      </option>
                                  @endforeach
                              </select>
                          </div>
                      </div>
                      </div>
                      <script>
                          $(document).ready(function() {
                              $("#satuanUbah").select2();
                          });
                      </script>
