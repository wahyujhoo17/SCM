@extends('tamplate')

 @section('judul')
<p>Dashbord</p>
@endsection 

@section('konten')

<div class="row" style="display: inline-block;">
    <div class="tile_count">
      <div class="col-md-4 col-sm-4  tile_stats_count">
        <span class="count_top">Total Penjualan</span>
        <div class="count">Rp 8.000.000</div>
        <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>12%</i> Dari Minggu Lalu</span>
      </div>
      <div class="col-md-4 col-sm-4  tile_stats_count">
        <span class="count_top"> Laba Kotor</span>
        <div class="count green">Rp 900.000</div>
        <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> Dari Minggu Lalu</span>
      </div>
      <div class="col-md-4 col-sm-4  tile_stats_count">
        <span class="count_top">Penerimaan Kotor</span>
        <div class="count">Rp 4.000.000</div>
        <span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i>12% </i> Dari Minggu Lalu</span>
      </div>
      <div class="col-md-2 col-sm-4  tile_stats_count">
        <span class="count_top">Jumlah Produk Terjual</span>
        <div class="count">400</div>
        <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> Dari Minggu Lalu</span>
      </div>
      <div class="col-md-2 col-sm-4  tile_stats_count">
        <span class="count_top"> Jumlah Transaksi</span>
        <div class="count">15</div>
        <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> Dari Minggu Lalu</span>
      </div>
    </div>
</div>



{{-- Chart --}}
    <canvas id="lineChard"></canvas>
@endsection

@section('javascript')
<script>
 //line
var ctxL = document.getElementById("lineChard").getContext('2d');
var myLineChart = new Chart(ctxL, {
  type: 'line',
  data: {
    labels: ["08.00", "09.00", "10.00", "11.00", "12.00", "13.00", "14.00","15.00","16.00","17.00"],
    datasets: [{
      label: "Grafik Penjualan Harian",
      data: [65, 59, 80, 81, 56, 55, 40],
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
