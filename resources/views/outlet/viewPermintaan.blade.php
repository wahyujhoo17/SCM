<div class="row">
    <div class="col-md-12">
        <div class="x_panel">

            <div class="x_content">

                <section class="content invoice">
                    <!-- title row -->
                    <div class="row">
                        <div class="  invoice-header">
                            <h1>
                                Permintaan*
                                <small class="pull-right">{{ $ps->tanggal }}</small>
                            </h1>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- info row -->
                    <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                            Outlet : 
                            <address>
                                <strong>{{ $ps->outlet->nama }}</strong>
                                <br>{{ $ps->outlet->alamat }}
                            </address>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                            Gudang : 
                            <address>
                                <strong>{{ $ps->gudang->nama }}</strong>
                                <br>{{ $ps->gudang->alamat }}
                            </address>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 invoice-col">

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
                                        <th>No Produk</th>
                                        <th>Nama</th>                                        
                                        <th>Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ps->produk as $item)
                                        <tr>
                                            <td>{{ $item->produk_id }}</td>
                                            <td>{{ $item->nama }}</td>
                                            <td>{{ $item->pivot->jumlah }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <div class="row">
                    </div>
                    <!-- /.row -->
                    <div class="text-right">
                    <button class="btn btn-default" onclick="printCertificate()"><i class="fa fa-print"></i>
                        Print</button>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

