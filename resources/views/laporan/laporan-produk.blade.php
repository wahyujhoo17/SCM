@extends('tamplate')

@section('judul')
    <p>Laporan Penjualan Produk</p>
@endsection

@section('konten')
    <div class="clearfix"></div>
    <div class="form-group">
        <label for="productName">Pilih Nama Produk:</label>
        <select class="form-control" id="productName">
            <option value="">Semua Produk</option>
            @foreach ($produk as $item)
                <option value="{{ $item->nama }}">{{ $item->nama }}</option>
            @endforeach
        </select>
    </div>

    <div class="row">

        <div class="form-group form-group col-md-6">
            <label for="startDate">Tanggal Mulai:</label>
            <input type="date" class="form-control" id="startDate">
        </div>

        <div class="form-group form-group col-md-6">
            <label for="endDate">Tanggal Akhir:</label>
            <input type="date" class="form-control" id="endDate">
        </div>
    </div>

    <button type="button" class="btn btn-primary" onclick="hitungTotalPenjualan()">Hitung Total Penjualan</button>



    <div class="mt-3">
        <p id="result"></p>
    </div>

    @php
        $dataPenjualan = [];
    @endphp
    @foreach ($produk as $item)
        @foreach ($item->nota_penjualan as $np)
            @foreach ($np->produk as $pr)
                @php
                    $dataBaru = ['tanggal' => explode(' ', $np->tanggal)[0], 'namaProduk' => $pr->nama, 'jumlahTerjual' => $np->pivot->jumlah];
                    $dataPenjualan[] = $dataBaru;
                @endphp
            @endforeach
        @endforeach
    @endforeach

    <canvas id="myChart" style="width:100%;max-width:100%"></canvas><br>

    <table class="table mt-3">
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Jumlah Terjual</th>
            </tr>
        </thead>
        <tbody id="tableBody">
            <!-- Data penjualan akan ditampilkan di sini -->
        </tbody>
    </table>

    <?php
    $jsonArray = json_encode($dataPenjualan);
    $json_data = json_encode($jsonArray);
    ?>
    
@endsection

@section('javascript')
    <script>
        $('#productName').select2();

        // Mendapatkan tanggal saat ini
        var currentDate = new Date();
        var currentDateEnd = new Date();

        // Format tanggal menjadi YYYY-MM-DD (sesuai dengan format input date)
        var formattedDate = currentDate.toISOString().slice(0, 10);
        // Subtract one month
        currentDateEnd.setMonth(currentDate.getMonth() - 1);

        // Format the date as 'YYYY-MM-DD'
        var formattedDateEnd = currentDateEnd.toISOString().slice(0, 10);

        document.getElementById('startDate').value = formattedDateEnd;
        document.getElementById('endDate').value = formattedDate;

        var jsonData = {!!  $json_data !!};

        // Now you can use jsonData as a JavaScript object
        // console.log(JSON.parse(jsonData));
        // Data penjualan simulasi (bisa diganti dengan data sebenarnya)
        var dataPenjualan = JSON.parse(jsonData);

        // Memanggil fungsi hitungTotalPenjualan saat halaman dimuat
        document.addEventListener("DOMContentLoaded", function() {
            tampilkanSemuaProduk(); // Menampilkan semua produk saat halaman dimuat
            hitungTotalPenjualan();
        });

        function tampilkanSemuaProduk() {
            var productSales = {};

            // Iterasi data penjualan untuk melakukan agregasi jumlah penjualan setiap produk
            for (var i = 0; i < dataPenjualan.length; i++) {
                var currentProduct = dataPenjualan[i].namaProduk;

                if (productSales[currentProduct]) {
                    productSales[currentProduct] += dataPenjualan[i].jumlahTerjual;
                } else {
                    productSales[currentProduct] = dataPenjualan[i].jumlahTerjual;
                }
            }

            // Tampilkan data penjualan pada tabel
            var tableBody = document.getElementById('tableBody');
            tableBody.innerHTML = '';

            // Iterasi objek productSales dan tampilkan data pada tabel
            for (var productName in productSales) {
                var row = "<tr><td>" + productName + "</td><td>" + productSales[productName] + "</td></tr>";
                tableBody.innerHTML += row;
            }
        }

        function hitungTotalPenjualan() {
            var selectedProduct = document.getElementById('productName').value;
            var startDate = document.getElementById('startDate').value;
            var endDate = document.getElementById('endDate').value;
            var productSales = {};

            // Iterasi data penjualan untuk mencari data berdasarkan nama produk yang dipilih dan range tanggal
            for (var i = 0; i < dataPenjualan.length; i++) {
                var currentProduct = dataPenjualan[i].namaProduk;
                var currentDate = dataPenjualan[i].tanggal;

                if (selectedProduct != '') {
                    if ((currentProduct === selectedProduct) && (!startDate || (currentDate >= startDate && currentDate <=
                            endDate))) {
                        if (productSales[currentProduct]) {
                            productSales[currentProduct] += dataPenjualan[i].jumlahTerjual;
                        } else {
                            productSales[currentProduct] = dataPenjualan[i].jumlahTerjual;
                        }
                    }
                } else {
                    if ((!startDate || (currentDate >= startDate && currentDate <=
                            endDate))) {
                        if (productSales[currentProduct]) {
                            productSales[currentProduct] += dataPenjualan[i].jumlahTerjual;
                        } else {
                            productSales[currentProduct] = dataPenjualan[i].jumlahTerjual;
                        }
                    }
                }

            }

            // Tampilkan hasil total penjualan
            var resultElement = document.getElementById('result');
            resultElement.innerHTML = 'Total Penjualan untuk ' + selectedProduct + ' dari ' + startDate + ' hingga ' +
                endDate + ': ';

            // Tampilkan data penjualan pada tabel
            var tableBody = document.getElementById('tableBody');
            tableBody.innerHTML = '';

            listNama = [];
            listJumlah = [];
            // Iterasi objek productSales dan tampilkan data pada tabel
            for (var productName in productSales) {
                var row = "<tr><td>" + productName + "</td><td>" + productSales[productName] + "</td></tr>";
                tableBody.innerHTML += row;

                //
                listNama.push(productName);
                listJumlah.push(productSales[productName]);
            }
            // console.log(listJumlah);
            updateChart(listJumlah, listNama);
        }
    </script>

    <script>
        const ctx = document.getElementById('myChart');

        var charts = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: '#Penjualan',
                    data: [],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                    }
                }
            }
        });

        function updateChart(data, label) {
            
            charts.data.labels = label;
            charts.data.datasets[0].data = data;
            charts.update();
            // console.log(label);
        }
    </script>
@endsection
