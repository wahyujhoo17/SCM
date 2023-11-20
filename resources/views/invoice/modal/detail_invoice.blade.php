<div class="row" id="buatPrint">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_content">
                <section class="content invoice">
                    <!-- title row -->
                    <div class="row">
                        <div class="  invoice-header">
                            <h1>
                                <i class="fa fa-globe"></i> Invoice.
                                <small class="pull-right">Date: {{ $invoice->tanggal }}</small>
                            </h1>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- info row -->
                    <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                            Dari.
                            <address>
                                <strong>Jaya Abadi.</strong>
                                <br>795 Freedom Ave, Suite 600
                                <br>Lamongan Jl.Moroseneng No.12
                                <br>Telepon: (+62) 83831211636
                                <br>Email: jaya-abadi@gmail.com
                            </address>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                            Kepada.
                            <address>
                                <strong>{{ $invoice->pelanggan->nama }}</strong>
                                <br>{{ $invoice->alamat_pengiriman }}
                                <br>Telepon: {{ $invoice->pelanggan->no_tlp }}
                            </address>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                            <br>
                            <b>Invoice #{{ $invoice->nomor }}</b>
                            <br>
                            <b>Order ID:</b> {{ $invoice->nomor_pesanan }}
                            <br>
                            <b>Jatuh Tempo :</b> {{ $invoice->jatuh_tempo }}
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
                                        <th>ID</th>
                                        <th>Nama Produk</th>
                                        <th>Jumlah</th>
                                        <th>Harga</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($invoice->produk as $item)
                                        <tr>
                                            <td>{{ $item->produk_id }}</td>
                                            <td>{{ $item->nama }}</td>
                                            <td>{{ $item->pivot->jumlah }}</td>
                                            <td>{{ number_format($item->pivot->harga, 2, ',', '.') }}</td>
                                            <td>{{ number_format($item->pivot->total, 2, ',', '.') }}</td>
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
                            <p class="lead">Keterangan :</p>
                            <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                                {{ $invoice->keterangan }}
                            </p>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-6">
                            <p class="lead">Jumlah yang Harus Dibayar</p>
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th style="width:50%">Subtotal:</th>
                                            <td>{{"Rp " .number_format($invoice->subTotal, 2, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            @php
                                                $diskon = explode('-' ,$invoice->diskon ) ;
                                            @endphp
                                            <th>Diskon ({{ $diskon[0] }}%)</th>
                                            <td>{{ "Rp ".number_format($diskon[1], 2, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Pengiriman:</th>
                                            <td>{{ "Rp ".number_format($invoice->biaya_pengiriman, 2, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <th class="h6">Total:</th>
                                            <td class="h6">{{ "Rp ".number_format($invoice->total, 2, ',', '.') }}</td>
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
                            <button class="btn btn-default" onclick="printIn()"><i class="fa fa-print"></i>
                                Print</button>
                            
                            @if ($invoice->status != 'Lunas')
                            <a class="btn btn-success pull-right" href="daftar-penerimaan/{{ $invoice->id }}/edit"><i class="fa fa-credit-card"></i> Tambah Pembayaran</a>
                            @endif
                            
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

