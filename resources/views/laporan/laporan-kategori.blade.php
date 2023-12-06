@extends('tamplate')

@section('judul')
    <p>Laporan Penjualan Kategori</p>
@endsection

@section('konten')
    <div class="clearfix"></div>
    <div class="row">
        <div class="form-group form-group col-md-5">
            <label for="startDate">Tanggal Mulai:</label>
            <input type="date" class="form-control" id="startDate">
        </div>

        <div class="form-group form-group col-md-5">
            <label for="endDate">Tanggal Akhir:</label>
            <input type="date" class="form-control" id="endDate">
        </div>
        <div class="form-group form-group col-md-2">
            <button type="button" class="btn btn-primary mt-4" onclick="hitungTotalPenjualan()">Hitung</button>
        </div>

    </div><br><br>

    <div class="row">
        <div class="form-group form-group col-md-4">
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
        </div>
        <div class="form-group form-group col-md-8">
            <canvas id="myChart" style="width:100%;max-width:100%"></canvas>
        </div>
    </div>

    <div class="mt-3">
        <p id="result"></p>
    </div>

    @php
        $dataPenjualan = [];
    @endphp
    @foreach ($kategori as $kt)
        @foreach ($kt->produk as $item)
            @foreach ($item->nota_penjualan as $np)
                @foreach ($np->produk as $pr)
                    @php
                        $dataBaru = ['tanggal' => explode(' ', $np->tanggal)[0], 'namaKategori' => $kt->nama, 'jumlahTerjual' => $np->pivot->jumlah];
                        $dataPenjualan[] = $dataBaru;
                    @endphp
                @endforeach
            @endforeach
        @endforeach
    @endforeach

    <?php
    $jsonArray = json_encode($dataPenjualan);
    $json_data = json_encode($jsonArray);
    ?>
@endsection

@section('javascript')
    <script>
        // Mendapatkan tanggal saat ini
        var currentDate = new Date();
        var currentDateEnd = new Date();

        // Format tanggal menjadi YYYY-MM-DD (sesuai dengan format input date)
        var formattedDate = currentDate.toISOString().slice(0, 10);

        console.log(formattedDate);
        // Subtract one month
        currentDateEnd.setMonth(currentDate.getMonth() - 1);

        // Format the date as 'YYYY-MM-DD'
        var formattedDateEnd = currentDateEnd.toISOString().slice(0, 10);

        document.getElementById('startDate').value = formattedDateEnd;
        document.getElementById('endDate').value = formattedDate;

        var jsonData = {!! $json_data !!}
        var dataPenjualan = JSON.parse(jsonData);

        // console.log(formattedDate);

        document.addEventListener("DOMContentLoaded", function() {
            tampilkanSemuaProduk(); // Menampilkan semua produk saat halaman dimuat
            hitungTotalPenjualan();
        });

        function tampilkanSemuaProduk() {
            var productSales = {};

            // Iterasi data penjualan untuk melakukan agregasi jumlah penjualan setiap produk
            for (var i = 0; i < dataPenjualan.length; i++) {
                var currentProduct = dataPenjualan[i].namaKategori;

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
            // var selectedProduct = document.getElementById('productName').value;
            var startDate = document.getElementById('startDate').value;
            var endDate = document.getElementById('endDate').value;
            var productSales = {};

            // Iterasi data penjualan untuk mencari data berdasarkan nama produk yang dipilih dan range tanggal
            for (var i = 0; i < dataPenjualan.length; i++) {
                var currentProduct = dataPenjualan[i].namaKategori;
                var currentDate = dataPenjualan[i].tanggal;

                if ((!startDate || (currentDate >= startDate && currentDate <=
                        endDate))) {
                    if (productSales[currentProduct]) {
                        productSales[currentProduct] += dataPenjualan[i].jumlahTerjual;
                    } else {
                        productSales[currentProduct] = dataPenjualan[i].jumlahTerjual;
                    }
                }


            }

            // Tampilkan data penjualan pada tabel
            var tableBody = document.getElementById('tableBody');
            tableBody.innerHTML = '';

            listNama = [];
            listJumlah = [];
            listWarna = [];
            // Iterasi objek productSales dan tampilkan data pada tabel
            for (var productName in productSales) {
                var row = "<tr><td>" + productName + "</td><td>" + productSales[productName] + "</td></tr>";
                tableBody.innerHTML += row;

                //
                listNama.push(productName);
                listJumlah.push(productSales[productName]);
                listWarna.push(getRandomColor());
            }
            // console.log(listJumlah);
            updateChart(listJumlah, listNama, listWarna);
        }
    </script>

    <script>
        const ctx = document.getElementById('myChart');

        var charts = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: [],
                datasets: [{
                    label: '#Penjualan',
                    data: [],
                    backgroundColor: [],
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

        function updateChart(data, label, bg) {

            charts.data.labels = label;
            charts.data.datasets[0].data = data;
            charts.data.datasets[0].backgroundColor = bg;

            // Calculate percentages
            var total = data.reduce((acc, value) => acc + value, 0);
            var percentages = data.map(value => ((value / total) * 100).toFixed(2) + "%");

            console.log(percentages);
            // Display percentages on the chart
            charts.options.plugins = {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            var label = context.label || '';
                            var value = context.parsed || 0;
                            var percentage = percentages[context.dataIndex] || 0;
                            return label + ': ' + value + ' (' + percentage + ')';
                        }
                    }
                }
            };

            charts.update();
            // console.log(label);
        }

        function getRandomColor() {
            const letters = "0123456789ABCDEF";
            let color = "#";
            for (let i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }
    </script>
@endsection
