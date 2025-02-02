@extends('layout')

@section('content')
<main id="main" class="main">

  <div class="pagetitle">
      <nav>
          </ol>
      </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row mb-4">
        <div class="col-md-12">
            <form method="GET" action="{{ route('dashboardFPB') }}" class="form-inline">
                <label for="year" class="mr-2">Year:</label>
                <input type="number" name="year" id="year" class="form-control mr-2" value="{{ request('year') }}" min="2000" max="{{ date('Y') }}">
    
                <button type="submit" class="btn btn-primary">Filter</button>
            </form>
        </div>
    </div>

    <div class="row">
        <!-- Viewcard Kiri dan Kanan (Ukuran 5 untuk masing-masing) -->
        <div class="col-sm-5">
            <div class="card" style="height: 100%;">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>FORM PENGAJUAN BARANG</h4>
                    <div class="card p-2 bg-light text-dark">
                        <strong>Total: {{ $fpbOpen + $fpbFinish }}</strong>
                    </div>
                </div>
                <div class="card-body" style="height: calc(100% - 56px);">
                    <figure class="highcharts-figure">
                        <div id="chart-status-fpb" style="min-width: 310px; height: 100%; margin: 0 auto;"></div>
                    </figure>
                </div>
            </div>
        </div>

        <!-- ViewCard Pie Chart (Ukuran 6) -->
        <div class="col-sm-2">
            <div class="card">
                <div class="card-body">
                    <div id="pieChart" style="height: 200px;"></div>
                </div>
            </div>
        </div>

        <!-- Viewcard Kanan (Ukuran 6) -->
        <div class="col-sm-5">
            <div class="card" style="height: 100%;">
                <div class="card-header">
                    <h4>LEADTIME ORDER FULFILLMENT</h4>
                </div>
                <div class="card-body" style="height: calc(100% - 56px);">
                    <figure class="highcharts-figure">
                        <div id="chart-lead-time" style="min-width: 310px; height: 100%; margin: 0 auto;"></div>
                    </figure>
                </div>
            </div>
        </div>
    </div>
  </section>


<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
<script>
    $(document).ready(function() {
        // Hover function for dropdowns
        $('.nav-item.dropdown').hover(function() {
            $(this).find('.dropdown-menu').first().stop(true, true).slideDown(150);
        }, function() {
            $(this).find('.dropdown-menu').first().stop(true, true).slideUp(150);
        });
    });
    </script>

<script src="https://code.highcharts.com/highcharts.js"></script>
{{-- <script src="https://code.highcharts.com/modules/exporting.js"></script> --}}
{{-- <script src="https://code.highcharts.com/modules/accessibility.js"></script> --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
  // Ambil data bulanan dari controller
  const monthlyData = @json($monthlyData);

  // Nama bulan (indeks 0 untuk Jan, dst.)
  const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

  Highcharts.chart('chart-status-fpb', {
    chart: { type: 'column' },
    title: { align: 'center', text: 'Form Pengajuan Barang' },
    xAxis: { categories: months },
    yAxis: {
      allowDecimals: false,
      min: 0,
      title: { text: 'Jumlah FPB' }
    },
    tooltip: {
      formatter: function () {
        return `<b>${this.series.name}</b><br>Jumlah: ${this.point.y}`;
      }
    },
    plotOptions: {
      column: {
        dataLabels: {
          enabled: true,
          formatter: function () {
            return `${this.y} FPB`;
          },
          style: {
            fontWeight: 'bold',
            color: 'black',
            textOutline: 'none'
          }
        }
      }
    },
    colors: ['#f1c40f', '#3498db'], // Warna: kuning untuk Open, biru untuk Finish
    series: [
      { name: 'Open', data: monthlyData.open },
      { name: 'Finish', data: monthlyData.finish }
    ],
    credits: { enabled: false } // Menghapus link Highcharts.com
  });
});





    

document.addEventListener('DOMContentLoaded', function () {
  // Ambil data lead time dari controller
  const leadTimeData = @json($leadTimeData);

  // Kategori tetap
  const categories = ['Total', 'IT', 'Spareparts', 'Consumable', 'GA', 'Subcont'];

  // Kategori yang memiliki target 5 hari
  const targetCategories = ['IT', 'Spareparts', 'Consumable'];

  // Ambil data pekerjaan 1 dan 2
  let leadDaysFirst = categories.map(category => leadTimeData[category]?.average_lead_days_first || 0);
  let leadDaysSecond = categories.map(category => leadTimeData[category]?.average_lead_days_second || 0);

  // Hitung total lead time untuk setiap kategori
  let totalLeadDays = leadDaysFirst.map((value, index) => value + leadDaysSecond[index]);

  // Hitung rata-rata Submit-Confirm dan Confirm-Finish untuk semua kategori (tanpa "Total")
  let avgLeadDaysFirst = leadDaysFirst.slice(1).reduce((sum, val) => sum + val, 0) / (categories.length - 1);
  let avgLeadDaysSecond = leadDaysSecond.slice(1).reduce((sum, val) => sum + val, 0) / (categories.length - 1);

  // Tetapkan kategori "Total" sebagai rata-rata dari semua kategori lainnya
  leadDaysFirst[0] = avgLeadDaysFirst;
  leadDaysSecond[0] = avgLeadDaysSecond;
  totalLeadDays[0] = avgLeadDaysFirst + avgLeadDaysSecond;

  // Data untuk garis target (hanya muncul di IT, Spareparts, Consumable)
  let targetData = categories.map(category => targetCategories.includes(category) ? 5 : null);

  // Hitung jumlah FPB untuk setiap kategori
  let fpbFirst = categories.map(category => leadTimeData[category]?.submit_confirm || 0);
  let fpbSecond = categories.map(category => leadTimeData[category]?.confirm_finish || 0);

  // Adjust counts for "Total" category
  fpbFirst[0] = fpbFirst.slice(1).reduce((sum, val) => sum + val, 0);
  fpbSecond[0] = fpbSecond.slice(1).reduce((sum, val) => sum + val, 0);

  Highcharts.chart('chart-lead-time', {
    chart: {
      type: 'column'
    },
    title: {
      text: 'Non Material FPB'
    },
    xAxis: {
      categories: categories
    },
    yAxis: {
      title: {
        text: 'Total Lead Time (Hari)'
      },
      min: 0,
      labels: {
        format: '{value} Hari'
      }
    },
    tooltip: {
      shared: true,
      headerFormat: '<b>{point.key}</b><br>',
      pointFormatter: function () {
        let seriesName = this.series.name;
        let value = Math.round(this.y); // Bulatkan nilai hari

        if (seriesName === 'Target') {
          return ''; // Tidak tampilkan tooltip untuk Target
        }

        let fpbCount;
        if (seriesName === 'Submit - Confirm') {
          fpbCount = fpbFirst[this.index];
        } else if (seriesName === 'Confirm - Finish') {
          fpbCount = fpbSecond[this.index];
        }

        return `<span style="color:${this.color}">●</span> ${seriesName}: <b>${value} hari</b> (${fpbCount} FPB)`;
      }
    },
    plotOptions: {
      column: {
        stacking: 'normal',
        dataLabels: {
          enabled: true,
          formatter: function () {
            let fpbCount;
            if (this.series.name === 'Submit - Confirm') {
              fpbCount = fpbFirst[this.index];
            } else if (this.series.name === 'Confirm - Finish') {
              fpbCount = fpbSecond[this.index];
            }
            return Math.round(this.y) + ' hari<br>' + `(${fpbCount} FPB)`;
          },
          style: {
            fontWeight: 'bold',
            color: 'black',
            textOutline: 'none'
          }
        }
      },
      line: {
        dashStyle: 'Solid',
        marker: {
          enabled: false
        }
      }
    },
    series: [
      {
        name: 'Confirm - Finish',
        data: leadDaysSecond,
        color: '#3498db',
      },
      {
        name: 'Submit - Confirm',
        data: leadDaysFirst,
        color: '#f1c40f',
      },
      {
        name: 'Target',
        type: 'line',
        data: targetData,
        color: 'red',
        lineWidth: 2,
        tooltip: {
          pointFormat: ''
        }
      }
    ],
    credits: {
      enabled: false // Menghapus link Highcharts.com
    }
  });
});




// Pie Chart FPB
Highcharts.chart({
    chart: {
        renderTo: 'pieChart',
        type: 'pie'
    },
    title: {
        text: 'Non Material'
    },
    tooltip: {
        valueSuffix: '%'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '{point.name}: {point.percentage:.1f}% ({point.count})',
                style: {
                    fontWeight: 'bold',
                    color: 'black',
                    textOutline: 'none'
                }
            }
        }
    },
    colors: ['#f1c40f', '#3498db'], // Warna biru dan kuning
    credits: {
        enabled: false // Menghapus credit "Highcharts.com"
    },
    series: [{
        name: 'Status',
        colorByPoint: true,
        data: [
            {
                name: 'Open',
                y: {{$fpbOpenPercentage}}, // Data PHP dinamis
                count: {{$fpbOpen}} // Jumlah dari PHP
            },
            {
                name: 'Finish',
                y: {{$fpbFinishPercentage}}, // Data PHP dinamis
                count: {{$fpbFinish}} // Jumlah dari PHP
            }
        ]
    }]
});

</script>
</main>
@endsection
