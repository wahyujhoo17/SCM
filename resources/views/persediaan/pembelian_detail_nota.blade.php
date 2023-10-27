<div class="row">
    <div class="col-md-12">
        <div class="x_panel">

            <div class="x_content">

                <section class="content invoice">
                    <!-- title row -->
                    <div class="row">
                        <div class="  invoice-header">
                            <h1>
                                <i class="fa fa-globe"></i> Nota Pembelian.
                                {{-- <small class="pull-right">{{ $nota->tanggal }}</small> --}}
                            </h1>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- info row -->
                    <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                            From
                            <address>
                                <strong>{{ $nota->pemasok->nama }}</strong>
                                <br>{{ $nota->pemasok->alamat }}
                                <br>{{ $nota->pemasok->no_tlp }}
                            </address>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                            To
                            <address>
                                <strong>{{ $nota->pegawai->nama }}</strong>
                                <br>795 Freedom Ave, Suite 600
                                <br>New York, CA 94107
                                <br>Phone: 1 (804) 123-9876
                                <br>Email: jon@ironadmin.com
                            </address>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                            <b>Nomer Nota: {{ $nota->no_nota }}</b>
                            <br>
                            <b>Payment Due:</b>
                            @foreach ($nota->pembayarans as $np)
                                {{ $np->tanggal }}
                            @endforeach
                            <br>
                            <b>Nomor Pemesanan:</b> {{ $nota->pemesanan->no_nota }}
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <!-- Table row -->
                    <div class="row">
                        <div class="  table">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Qty</th>
                                        <th>Produk</th>
                                        <th style="width: 59%">Harga</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $split = explode('-', $nota->no_nota);
                                        $status = $split[0];
                                    @endphp
                                    @if ($status == 'PB')
                                        @foreach ($nota->barang as $dl)
                                            <tr>
                                                <td>{{ $dl->pivot->jumlah }}</td>
                                                <td>{{ $dl->nama }}</td>
                                                <td>{{ 'Rp ' . number_format($dl->pivot->harga_beli, 2, ',', '.') }}
                                                </td>
                                                <td>{{ 'Rp ' . number_format($dl->pivot->harga_beli * $dl->pivot->jumlah, 2, ',', '.') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        @foreach ($nota->produk as $dl)
                                            <tr>
                                                {{-- <td>{{ $dl }}</td> --}}
                                                <td>{{ $dl->pivot->jumlah }}</td>
                                                <td>{{ $dl->nama }}</td>
                                                <td>{{ 'Rp ' . number_format($dl->pivot->harga_beli, 2, ',', '.') }}
                                                </td>
                                                <td>{{ 'Rp ' . number_format($dl->pivot->harga_beli * $dl->pivot->jumlah, 2, ',', '.') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <div class="row">


                        <div class="col-md-6">
                            @php
                                $total_dibayar = 0;
                                $sisa = 0;
                            @endphp

                            @foreach ($nota->pembayarans as $np)
                                @php
                                    $total_dibayar += $np->total_bayar;
                                    $sisa = $np->sisa_tagihan;
                                @endphp
                                {{-- {{ $np->total_bayar }} --}}
                            @endforeach

                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th style="width:50%">Subtotal:</th>
                                            <td>{{ 'Rp ' . number_format($nota->total_harga, 2, ',', '.') }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Biaya Pajak (%):</th>
                                            <td>{{ $nota->pajak }}</td>
                                        </tr>
                                        <tr>
                                            <th>Biaya Pengiriman:</th>
                                            <td>{{ $nota->biaya_pengiriman }}</td>
                                        </tr>
                                        <tr>
                                            <th>Total:</th>
                                            <td>{{ 'Rp ' . number_format($nota->total, 2, ',', '.') }}
                                        </tr>
                                        <tr>
                                            <th>Dibayar: </th>
                                            <td>{{ 'Rp ' . number_format($total_dibayar, 2, ',', '.') }}</td>
                                        </tr>

                                        @if ($sisa != 0)
                                            <tr>
                                                <th>Sisa Tagihan: </th>
                                                <td>{{ 'Rp ' . number_format($sisa, 2, ',', '.') }}</td>
                                            </tr>
                                        @else
                                        @endif

                                        {{-- <tr id="bayar">
                                            <th>Bayar: </th>
                                            <td><input id="dibayar" name="jumlah_bayar" type="text"
                                                    class="form-control"></td>
                                        </tr> --}}

                                    </tbody>
                                </table>
                            </div>

                        </div>


                        <!-- /.col -->
                        <!-- accepted payments column -->
                        <div class="col-md-6" id="form-bayar">
                            <form action="{{ route('tambahPembayaran') }}" method="POST">
                                @csrf
                                <p class="lead">Pembayaran:</p>
                                <div class="mb-3 row">
                                    <label for="no_nota" class="col-sm-2 col-form-label">No.Nota: </label>
                                    <div class="col-sm-10">
                                        <input type="text" name="no_nota" readonly class="form-control-plaintext"
                                            id="no_nota" value="{{ $nota->no_nota }}">
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="tagihan" class="col-sm-2 col-form-label">Tagihan (Rp): </label>
                                    <div class="col-sm-10">
                                        @if ($sisa != 0)
                                            <input type="text" readonly class="form-control-plaintext" name="tagihan"
                                                id="tagihan" value="{{ number_format($sisa, 0, ',', '.') }}">
                                        @else
                                            <input type="text" readonly class="form-control-plaintext" name="tagihan"
                                                id="tagihan" value="{{ number_format($nota->total, 0, ',', '.') }}">
                                        @endif

                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="metode" class="col-sm-2 col-form-label">metode: </label>
                                    <div class="col-sm-6">
                                        <select name="metode" id="metode" class="form-control">
                                            @foreach ($metode as $metode)
                                                <option value="{{ $metode->id }}">{{ $metode->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="bayar" class="col-sm-2 col-form-label">Bayar: </label>
                                    <div class="col-sm-9">
                                        <input type="text" name="jumlah_bayar" class="form-control" id="bayar">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <div class="col-sm-12">
                                        <input type="submit" class="btn btn-primary" style="width: 100%"
                                            value="Bayar">
                                    </div>
                                </div>
                            </form>

                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                    <div class="text-right">
                        <button class="btn btn-default" onclick="printCertificate()"><i class="fa fa-print"></i>
                            Print</button>

                        @if ($nota->pembayarans == '[]' || $nota->status_pembelian == 'diproses' || $nota->status_pembelian == 'belum dibayar')
                            <button type="button" onclick="bayar()" class="btn btn-secondary" id="btnStart">Lakukan
                                Pembayaran</button>
                        @else
                        @endif
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

<script>

    function formatRupiah(angka, prefix)
    {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split    = number_string.split(','),
            sisa     = split[0].length % 3,
            rupiah     = split[0].substr(0, sisa),
            ribuan     = split[0].substr(sisa).match(/\d{3}/gi);
            
        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        
        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }

    var tanpa_rupiah =  document.getElementById('bayar');
    tanpa_rupiah.addEventListener('keyup', function(e)
    {
        tanpa_rupiah.value = formatRupiah(this.value);
    });

    $('#form-bayar').hide();
    // Confirm Dalate
    $('#batalkan-nota').click(function(event) {
        var form = $(this).closest("form");
        var name = $(this).data("name");
        event.preventDefault();
        swal({
                title: `Are you sure you want to delete this record?`,
                text: "If you delete this, it will be gone forever.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    form.submit();
                }
            });
    });

    function bayar() {
        console.log('masokk');
        $('#form-bayar').show();
        $('#btnStart').hide();

    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
