@extends('tamplate')

@section('judul')
    <p>Dashbord</p>
    <style>
        .custom-card {
            height: 100%;
        }

        .custom-card-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
        }

        .custom-count {
            font-size: 20px;
            font-weight: bold;
            /* Adjust the font size as needed */
        }

        .custom-percentage {
            font-size: 14px;
            /* Adjust the font size for percentages */
        }

        .custom-card .card-title {
            font-size: 14px;
            /* Adjust the font size for card titles */
        }
    </style>
@endsection

@section('konten')
    <div class="clearfix"></div>

    <div class="container mt-4">
        <div class="row">
            <!-- Total Penjualan -->
            <div class="col-md-3 mb-4">
                <div class="card custom-card">
                    <div class="card-body custom-card-body">
                        <h5 class="card-title">Total Penjualan</h5>
                        <p class="card-text custom-count">{{ 'Rp ' . number_format($dataPenjualan[0], 0, ',', '.') }}</p>
                        @if ($dataPenjualan[1] < 0)
                            <p class="card-text custom-percentage text-danger"><i
                                    class="fa fa-sort-desc"></i>{{ $dataPenjualan[1] }}% Dari Minggu Lalu</p>
                        @else
                            <p class="card-text custom-percentage text-success"><i
                                    class="fa fa-sort-asc"></i>{{ $dataPenjualan[1] }}% Dari Kemarin</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Laba Kotor -->
            <div class="col-md-3 mb-4">
                <div class="card custom-card">
                    <div class="card-body custom-card-body">
                        <h5 class="card-title">Laba Kotor</h5>
                        <p class="card-text custom-count">{{ 'Rp ' . number_format($dataKeuntungan[0], 0, ',', '.') }}</p>
                        @if ($dataKeuntungan[1] < 0)
                            <p class="card-text custom-percentage text-danger"><i
                                    class="fa fa-sort-desc"></i>{{ $dataKeuntungan[1] }}% Dari Minggu Lalu</p>
                        @else
                            <p class="card-text custom-percentage text-success"><i
                                    class="fa fa-sort-asc"></i>{{ $dataKeuntungan[1] }}% Dari Kemarin</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Penerimaan Kotor -->
            <div class="col-md-3 mb-4">
                <div class="card custom-card">
                    <div class="card-body custom-card-body">
                        <h5 class="card-title">Penerimaan Kotor</h5>
                        <p class="card-text custom-count">{{ 'Rp ' . number_format($dataPenerimaan[0], 0, ',', '.') }}</p>
                        @if ($dataPenerimaan[1] < 0)
                            <p class="card-text custom-percentage text-danger"><i
                                    class="fa fa-sort-desc"></i>{{ $dataPenerimaan[1] }}% Dari Minggu Lalu</p>
                        @else
                            <p class="card-text custom-percentage text-success"><i
                                    class="fa fa-sort-asc"></i>{{ $dataPenerimaan[1] }}% Dari Kemarin</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Jumlah Produk Terjual -->
            <div class="col-md-3 mb-4">
                <div class="card custom-card">
                    <div class="card-body custom-card-body">
                        <h5 class="card-title">Jumlah Produk Terjual</h5>
                        <p class="card-text custom-count text-success">{{ $dataProdukTerjual[0] }}</p>
                        @if ($dataProdukTerjual[1] < 0)
                            <p class="card-text custom-percentage text-danger"><i
                                    class="fa fa-sort-desc"></i>{{ $dataProdukTerjual[1] }}% Dari Kemarin</p>
                        @else
                            <p class="card-text custom-percentage text-success"><i
                                    class="fa fa-sort-asc"></i>{{ $dataProdukTerjual[1] }}% Dari Kemarin</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Jumlah Transaksi -->
            <div class="col-md-3 mb-4">
                <div class="card custom-card">
                    <div class="card-body custom-card-body">
                        <h5 class="card-title">Jumlah Transaksi</h5>
                        <p class="card-text custom-count text-success">{{ $dataTransaksi[0] }}</p>
                        @if ($dataTransaksi[1] < 0)
                            <p class="card-text custom-percentage text-danger"><i
                                    class="fa fa-sort-desc"></i>{{ $dataTransaksi[1] }}% Dari Minggu Lalu</p>
                        @else
                            <p class="card-text custom-percentage text-success"><i
                                    class="fa fa-sort-asc"></i>{{ $dataTransaksi[1] }}% Dari Kemarin</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Chart --}}
    <canvas id="lineChard"></canvas>
@endsection

@section('javascript')
    <script>
        //line
        // Ambil data dari controller
        // var penjualanData = @json($waktuPenjualan);

        // var labels = penjualanData.map(data => data.jam);
        // var totalPenjualan = penjualanData.map(data => data.total_penjualan);


        var dataPenjualan = @json($arrayPunch);
        // Buat array untuk label dan data
        var labels = Array.from({
            length: 10
        }, (_, i) => (i + 8).toString().padStart(2, '0') + ':00 - ' + (i + 9).toString().padStart(2, '0') + ':00');
        // Inisialisasi array totalPenjualan dengan nilai 0
        var totalPenjualan = Array(labels.length).fill(0);

        // Map dataPenjualan ke interval jam yang sesuai
        Object.keys(dataPenjualan).forEach(function(key) {
            var hour = parseInt(key.split(":")[0], 10);
            var index = hour - 8; // Shift by 8 to match the labels
            totalPenjualan[index] += dataPenjualan[key];
        });

        var ctxL = document.getElementById("lineChard").getContext('2d');
        var myLineChart = new Chart(ctxL, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                        label: "Grafik Penjualan Harian",
                        data: totalPenjualan,
                        backgroundColor: [
                            'rgba(105, 0, 132, .2)',
                        ],
                        borderColor: [
                            'rgba(200, 99, 132, .7)',
                        ],
                        borderWidth: 2
                    },

                ]
            },
            options: {
                responsive: true
            }
        });
    </script>
@endsection
