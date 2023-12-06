                        {{-- NAMA --}}
                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="Unama">Nama <span
                                    class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 ">
                                <input type="text" id="Unama" value="{{ $pr->nama }}" name="Unama"
                                    required="required" class="form-control ">
                            </div>
                        </div>
                        {{-- Barcode --}}
                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="Ubarcode">Barcode <span
                                    class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 ">
                                <input type="text" id="Ubarcode" value="{{ $pr->barcode }}" name="Ubarcode"
                                     class="form-control ">
                            </div>
                            <div class="col-md-6 col-sm-6 ">
                                <button type="button" id="Uscane" class="btn btn-outline-secondary"
                                    data-toggle="modal" data-target=".modalScane">Scane</button>
                            </div>
                        </div>

                        {{-- Harga Jual --}}
                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="Uharga">Harga <span
                                    class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 ">
                                <input type="text" id="Uharga" name="Uharga" value="{{ $pr->harga_jual }}"
                                    required="required" class="form-control ">
                            </div>
                        </div>
                        {{-- Kategori --}}
                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="kategori">Kategori <span
                                    class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 ">
                                <select class="form-control py-4" name="Ukategori" id="Ukategori" style="width: 100%;">
                                    @foreach ($kt as $kategori)
                                        {{ $selected = '' }}
                                        @if ($kategori->id == $pr->kategori_produk_id)
                                            {{ $selected = 'selected' }}
                                        @else
                                        @endif
                                        <option value="{{ $kategori->id }}" {{ $selected }}>{{ $kategori->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <script>
                            $("#Ukategori").select2();
                            // Ubah Data Scnner
                            document.getElementById('Uscane').onclick = function() {
                                var barcodeText = document.getElementById("Ubarcode");
                                var sound = new Audio("barcode.wav");

                                //Barcode 2
                                barcode.config.start = 0.1;
                                barcode.config.end = 0.9;
                                barcode.config.video = '#barcodevideo';
                                barcode.config.canvas = '#barcodecanvas';
                                barcode.config.canvasg = '#barcodecanvasg';
                                barcode.setHandler(function(barcode) {
                                    // Barcode selesai di pindai
                                    barcodeText.value = barcode;
                                    $('#modalScane').modal('hide');
                                    sound.play();
                                });
                                barcode.init();
                            }
                        </script>
