<div class="row">
    <div class="col-md-12">
        <div class="x_panel">

            <div class="x_content">

                <section class="content invoice">
                    <!-- title row -->
                    <div class="row">
                        <div class="  invoice-header">
                            <h1>
                                <i class="fa fa-globe"></i> Nota Pemesanan.
                                <small class="pull-right">{{ $nota->tanggal }}</small>
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
                            <b>Payment Due:</b> 2/22/2014
                            <br>
                            <b>Account:</b> 968-34567
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
                                    @if ($status == 'NB')
                                        @foreach ($nota->barang as $dl)
                                            <tr>
                                                <td>{{ $dl->pivot->jumlah_barang }}</td>
                                                <td>{{ $dl->nama }}</td>
                                                <td>{{ 'Rp ' . number_format($dl->pivot->harga_beli, 2, ',', '.') }}
                                                </td>
                                                <td>{{ 'Rp ' . number_format($dl->pivot->harga_beli * $dl->pivot->jumlah_barang, 2, ',', '.') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        @foreach ($nota->produk as $dl)
                                            <tr>
                                                {{-- <td>{{ $dl }}</td> --}}
                                                <td>{{ $dl->pivot->jumlah_barang }}</td>
                                                <td>{{ $dl->nama }}</td>
                                                <td>{{ 'Rp ' . number_format($dl->pivot->harga_beli, 2, ',', '.') }}
                                                </td>
                                                <td>{{ 'Rp ' . number_format($dl->pivot->harga_beli * $dl->pivot->jumlah_barang, 2, ',', '.') }}
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
                        <!-- accepted payments column -->
                        <div class="col-md-6">
                            <p class="lead">Payment Methods:</p>
                            <img src="images/visa.png" alt="Visa">
                            <img src="images/mastercard.png" alt="Mastercard">
                            <img src="images/american-express.png" alt="American Express">
                            <img src="images/paypal.png" alt="Paypal">
                            <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                                Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya
                                handango imeem plugg dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
                            </p>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-6">
                            <p class="lead">Pembayaran(tanggal)</p>
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th style="width:50%">Subtotal:</th>
                                            <td>{{ 'Rp ' . number_format($nota->total_harga, 2, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Biaya Pajak:</th>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <th>Biaya Pengiriman:</th>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <th>Total:</th>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <th>Dibayar:</th>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                    <div class="text-right">
                    <button class="btn btn-default" onclick="printCertificate()"><i class="fa fa-print"></i>
                        Print</button>
                    </div>
                    <!-- this row will not appear when printing -->
                    @if ($nota->status_pemesanan == 'diproses')
                    <form method="POST" action="{{ route('pemesanan.destroy', $nota->id) }}">
                        @csrf
                        <div class="text-right">
                            <div class="">
                            </div>
                            <input name="_method" type="hidden" value="DELETE">
                            <button type="submit" id="batalkan-nota" class="btn btn-danger">Batalkan Pemesanan</button>
                        </div>
                    </form>
                    @else
                    @endif
                </section>
            </div>
        </div>
    </div>
</div>

<script>
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
</script>
