@extends('layout')

@section('content')
<main id="main" class="main">

  <div class="pagetitle">
      <nav>
          </ol>
      </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">

    <div class="row">
        <!-- Viewcard Kiri: Pengajuan Barang -->
        <div class="col-sm-5">
            <div class="card" style="height: 100%;">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>FORM PENGAJUAN BARANG</h4>

                    <!-- Form Filter Pengajuan Barang (Chart FPB) -->
                    <form method="GET" action="{{ route('dashboardFPB') }}" class="form-inline">
                      <input type="hidden" name="filter_type" value="fpb">
                      
                      <!-- Field Filter FPB -->
                      <div class="form-group mr-2">
                        <label for="start_date_fpb" class="mr-2">Dari:</label>
                        <input type="date" name="start_date_fpb" id="start_date_fpb" class="form-control" 
                              value="{{ request('start_date_fpb', \Carbon\Carbon::create(2025, 1, 1)->toDateString()) }}">
                      </div>
                      <div class="form-group mr-2">
                        <label for="end_date_fpb" class="mr-2">Sampai:</label>
                        <input type="date" name="end_date_fpb" id="end_date_fpb" class="form-control" 
                              value="{{ request('end_date_fpb', \Carbon\Carbon::create(2025, 12, 31)->toDateString()) }}">
                      </div>  

                      <div class="form-group mr-2">
                          <label for="kategori_po" class="mr-2">Kategori:</label>
                          <select name="kategori_po" id="kategori_po" class="form-control">
                              <option value="">Semua Kategori</option>
                              @foreach($kategoriList as $kategoriItem)
                                  <option value="{{ $kategoriItem }}" {{ request('kategori_po') == $kategoriItem ? 'selected' : '' }}>
                                      {{ $kategoriItem }}
                                  </option>
                              @endforeach
                          </select>
                      </div>
                      
                      <!-- Hidden Input untuk Filter Lead Time agar tetap dipertahankan -->
                      <input type="hidden" name="start_date_leadtime" value="{{ request('start_date_leadtime') }}">
                      <input type="hidden" name="end_date_leadtime" value="{{ request('end_date_leadtime') }}">
                      
                      <button type="submit" class="btn btn-primary">Filter</button>
                    </form>


                    <!-- Card Total FPB -->
                    <div class="card p-2 bg-light text-dark">
                        <strong>Total: {{ $totalFPB }}</strong>
                    </div>
                </div>

                <!-- Informasi Filter Aktif -->
                <div class="card-body">
                    <figure class="highcharts-figure">
                        <div id="chart-status-fpb" style="min-width: 310px; height: 100%; margin: 0 auto;"></div>
                    </figure> 
                </div>
            </div>
        </div>    

        <!-- ViewCard Pie Chart -->
        <div class="col-sm-2">
            <div class="card">
                <div class="card-body">
                    <div id="pieChart" style="height: 200px;"></div>
                </div>
            </div>
        </div>

        <!-- Viewcard Kanan: Lead Time Order Fulfillment -->
        <div class="col-sm-5">
            <div class="card" style="height: 100%;">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>LEADTIME ORDER FULFILLMENT</h4>

                    <!-- Form Filter Lead Time (Chart Lead Time) -->
                    <form method="GET" action="{{ route('dashboardFPB') }}" class="form-inline">
                      <input type="hidden" name="filter_type" value="leadtime">
                      
                      <!-- Field Filter Lead Time -->
                      <div class="form-group mr-2">
                          <label for="start_date_leadtime" class="mr-2">Dari:</label>
                          <input type="date" name="start_date_leadtime" id="start_date_leadtime" class="form-control" value="{{ request('start_date_leadtime') }}">
                      </div>
                      <div class="form-group mr-2">
                          <label for="end_date_leadtime" class="mr-2">Sampai:</label>
                          <input type="date" name="end_date_leadtime" id="end_date_leadtime" class="form-control" value="{{ request('end_date_leadtime') }}">
                      </div>
                      
                      <!-- Hidden Input untuk Filter FPB agar tetap dipertahankan -->
                      <input type="hidden" name="start_date_fpb" value="{{ request('start_date_fpb') }}">
                      <input type="hidden" name="end_date_fpb" value="{{ request('end_date_fpb') }}">
                      <input type="hidden" name="kategori_po" value="{{ request('kategori_po') }}">
                      
                      <button type="submit" class="btn btn-primary">Filter</button>
                    </form>

                </div>

                <!-- Informasi Filter Aktif untuk Lead Time -->
                <div class="card-body">
                    <figure class="highcharts-figure">
                        <div id="chart-lead-time" style="min-width: 310px; height: 100%; margin: 0 auto;"></div>
                    </figure>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
      <!-- ViewCard Utama -->
      <div class="col-sm-12">
          <div class="card" style="height: 100%;">
              <div class="card-header d-flex justify-content-between align-items-center">
                  <h4>FORM INQUIRY LOCAL</h4>
                  <div class="card p-2 bg-light text-dark">
                      <strong>Total: {{ $totalinquiry }}</strong>
                  </div>
                  <form method="GET" action="{{ route('dashboardFPB') }}" class="form-inline">
                      <input type="hidden" name="filter_type" value="inquiry">
                      <div class="form-group mr-2">
                          <label for="start_date_inquiry" class="mr-2">Dari:</label>
                          <input type="date" name="start_date_inquiry" id="start_date_inquiry" class="form-control" value="{{ request('start_date_inquiry') }}">
                      </div>
                      <div class="form-group mr-2">
                          <label for="end_date_inquiry" class="mr-2">Sampai:</label>
                          <input type="date" name="end_date_inquiry" id="end_date_inquiry" class="form-control" value="{{ request('end_date_inquiry') }}">
                      </div>                                
                      <button type="submit" class="btn btn-primary">Filter</button>
                  </form>

                  <!-- Chart Pie -->
                  <div class="col-sm-3">
                      <div id="pieChart1" style="height: 200px;"></div>
                  </div>
              </div>
              
              <div class="card-body">
                  <div class="row">
                      <!-- Chart Bar -->
                      <div class="col-sm-9">
                          <figure class="highcharts-figure">
                              <div id="chart-status-inquiry" style="min-width: 310px; height: 100%; margin: 0 auto;"></div>
                          </figure>
                      </div>
                  
                  </div>
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
    const startDate = @json($startDate1);
    const endDate = @json($endDate1);

    // Nama bulan (indeks 0 untuk Jan, dst.)
    const allMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

    const start = startDate ? new Date(startDate) : null;
const end = endDate ? new Date(endDate) : null;


    let filteredMonths = [];
    let openData = [];
    let finishData = [];
    let defaultYear = 2025; // Set default ke tahun 2025
    // Jika tidak ada filter tanggal, gunakan tahun 2025
    if (!start && !end) { // Jika pengguna tidak memilih filter tanggal

    for (let i = 0; i < 12; i++) {
        filteredMonths.push(`${allMonths[i]} ${defaultYear}`);
        openData.push(monthlyData.open[i] ?? 0); // Gunakan nilai default 0 jika data tidak tersedia
        finishData.push(monthlyData.finish[i] ?? 0);
    }
} else {
    let startYear = start ? start.getFullYear() : 2025;
    let endYear = end ? end.getFullYear() : 2025;

    for (let year = startYear; year <= endYear; year++) {
        let startMonth = (year === startYear && start) ? start.getMonth() : 0;
        let endMonth = (year === endYear && end) ? end.getMonth() : 11;

        for (let month = startMonth; month <= endMonth; month++) {
            filteredMonths.push(`${allMonths[month]} ${year}`);
            openData.push(monthlyData.open[month] ?? 0);
            finishData.push(monthlyData.finish[month] ?? 0);
        }
    }
}




  Highcharts.chart('chart-status-fpb', {
    chart: { type: 'column' },
    title: { align: 'center', text: 'Form Pengajuan Barang' },
    xAxis: { categories: filteredMonths },
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
      { name: 'Open', data: openData },
      { name: 'Finish', data: finishData }
    ],
    credits: { enabled: false } // Menghapus link Highcharts.com
  });
});


    
    

document.addEventListener('DOMContentLoaded', function () {
  // Ambil data lead time dari controller dengan filter tanggal khusus Lead Time
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

  // Render chart Lead Time dengan filter yang sesuai
  Highcharts.chart('chart-lead-time', {
    chart: {
      type: 'column'
    },
    title: {
      text: 'Non Material FPB (Lead Time)'
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
                count: {{$fpbOpenUnique}} // Jumlah dari PHP
            },
            {
                name: 'Finish',
                y: {{$fpbFinishPercentage}}, // Data PHP dinamis
                count: {{$fpbFinishUnique}} // Jumlah dari PHP
            }
        ]
    }]
});

document.addEventListener('DOMContentLoaded', function () {
            const monthlyData = @json($monthlyData1);
            Highcharts.chart('chart-status-inquiry', {
                chart: { type: 'column' },
                title: { text: 'Form Inquiry Local' },
                credits: {
                enabled: false // Menghapus credit "Highcharts.com"
                },
                xAxis: { categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] },
                yAxis: { title: { text: 'Jumlah Inquiry' } },

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
                            return `${this.y} `;
                        },
                        style: {
                            fontWeight: 'bold',
                            color: 'black',
                            textOutline: 'none'
                        }
                        }
                    }
                    },
                series: [
                    { name: 'Open', data: monthlyData.open },
                    { name: 'On Progress', data: monthlyData.onprogress },
                    { name: 'Finish', data: monthlyData.finish }
                ]
            });

            Highcharts.chart('pieChart1', {
                chart: { type: 'pie' },
                title: { text: 'Status Inquiry' },
                credits: {
                enabled: false // Menghapus credit "Highcharts.com"
                },
                tooltip: {
                    valueSuffix: '{series.name}: <b>{point.percentage:.1f}%</b> ({point.custom.count})'
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
                            series: [{
                    name: 'Status',
                    data: [
                        {   name: 'Open',
                            y: {{ $inquiryOpenPercentage }},
                            count: {{ $inquiryOpenCount }}
                        },
                        {   name: 'OnProgress', 
                            y: {{$inquiryOnprogressPercentage}},
                            count: {{ $inquiryOnprogressCount }}
                    },
                        {   name: 'Finish', 
                            y: {{ $inquiryFinishPercentage }},
                            count: {{ $inquiryFinishCount }}
                    }
                    ]
                }]
            });
        });

</script>
</main>
@endsection
