
<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    {{-- <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                            aria-expanded="false"><i class="fa fa-wrench"></i></a>
                    </li> --}}
                    <li><a class="close-link"><i class="fa fa-close" data-dismiss="modal"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <section class="content invoice">
                    <!-- title row -->
                    <div class="row">
                        <div class="  invoice-header">
                            <h1>
                                <i class="fa fa-globe"></i> Penjualan.
                                <small class="pull-right">{{ $newDate2 = date("d/m/Y", strtotime($penjualan->tanggal)) }}</small>
                            </h1>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- info row -->
                    <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                            From
                            <address>
                                <strong>{{ $penjualan->outlet->nama }}</strong>
                                <br><p>{{ $penjualan->outlet->alamat }}</p>
                            </address>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                            To
                            <address>
                                <strong>{{ $penjualan->pelanggan->nama }}</strong>
                                <br><p>{{  $penjualan->pelanggan->alamat }}</p>
                            </address>
                        </div>
                        <br>
                        <!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                            <b>Invoice #{{ $penjualan->nomor_nota }}</b>
                            <br>
                            <b>Payment Due:</b> {{ $newDate2 = date("d/m/Y", strtotime($penjualan->tanggal)) }}
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
                                        <th>Product</th>
                                        <th>Harga</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $subtotal = 0;
                                    @endphp

                                    @foreach ($penjualan->produk as $item)
                                    @php
                                        $subtotal += $item->harga_jual * $item->pivot->jumlah;
                                    @endphp
                                        <tr>
                                            <td>{{ $item->pivot->jumlah }}</td>
                                            <td>{{ $item->nama }}</td>
                                            <td>{{number_format($item->harga_jual, 0, ',', '.') }}</td>
                                            <td>{{number_format($item->harga_jual * $item->pivot->jumlah, 0, ',', '.')  }}</td>
                                        </tr>
                                    @endforeach
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
                                {{ $penjualan ->jenis_pembayaran->nama }}
                            </p>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-6">
                            <p class="lead">{{ $newDate2 = date("d/m/Y", strtotime($penjualan->tanggal)) }}</p>
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th style="width:50%">Subtotal:</th>
                                            <td>{{number_format($subtotal, 0, ',', '.')}}</td>
                                        </tr>
                                        <tr>
                                            <th>Diskon</th>
                                            <td>{{ $penjualan->diskon }} %</td>
                                        </tr>
                                        <tr>
                                            <th>Total:</th>
                                            <td>{{number_format($penjualan->total_harga, 0, ',', '.')}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <!-- this row will not appear when printing -->
                    <div class="row no-print">
                        <div class=" ">
                            <button class="btn btn-default" onclick="printCertificate()"><i class="fa fa-print"></i>
                                Print</button>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
