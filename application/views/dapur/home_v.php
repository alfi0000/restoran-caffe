<div class="page-content-wrapper">
    <div class="page-content">
        <h3 class="page-title">Dashboard</h3>
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="<?= site_url('dapur/home'); ?>">Dashboard</a>
                </li>
            </ul>
            <div class="page-toolbar">
                <div id="dashboard-report-range" class="pull-right tooltips btn btn-fit-height blue-madison">
                    <i class="icon-calendar">&nbsp;</i>
                    <span class="uppercase visible-lg-inline-block">
                        <?= tgl_indo(date('Y-m-d')); ?>
                    </span>
                </div>
            </div>
        </div>

        <!-- STATISTIK UTAMA -->
        <style>
        .dashboard-row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            margin-top: 30px;
        }

        .dashboard-card {
            flex: 1 1 250px;
            background: linear-gradient(135deg, #4a90e2, #0072bc);
            border-radius: 18px;
            color: white;
            padding: 25px;
            position: relative;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .dashboard-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.25);
        }

        .dashboard-card .icon {
            font-size: 48px;
            opacity: 0.2;
            position: absolute;
            right: 20px;
            top: 20px;
        }

        .dashboard-card .number {
            font-size: 36px;
            font-weight: bold;
            margin-top: 10px;
        }

        .dashboard-card .desc {
            font-size: 16px;
            opacity: 0.9;
            letter-spacing: 0.5px;
        }

        .dashboard-card a.more {
            display: inline-block;
            margin-top: 20px;
            color: #fff;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .dashboard-card a.more:hover {
            text-decoration: underline;
            opacity: 0.9;
        }

        /* Warna tema per kategori */
        .blue-madison {
            background: linear-gradient(135deg, #5b9bd5, #2f6fa7);
        }

        .green-haze {
            background: linear-gradient(135deg, #2ecc71, #1abc9c);
        }

        .yellow-casablanca {
            background: linear-gradient(135deg, #f1c40f, #f39c12);
        }

        .purple-soft {
            background: linear-gradient(135deg, #9b59b6, #8e44ad);
        }

        .purple-plum {
            background: linear-gradient(135deg, #8e44ad, #663399);
        }
        </style>

        <div class="dashboard-row">
            <!-- TOTAL PESANAN -->
            <div class="dashboard-card blue-madison">
                <i class="fa fa-list-alt icon"></i>
                <div class="number"><?= number_format($TotalPesanan, 0, '', ','); ?></div>
                <div class="desc">Total Pesanan</div>
                <a class="more" href="<?= site_url('dapur/monitoring'); ?>">
                    Detail <i class="fa fa-arrow-right"></i>
                </a>
            </div>

            <!-- TOTAL CAMILAN -->
            <div class="dashboard-card green-haze">
                <i class="fa fa-birthday-cake icon"></i>
                <div class="number"><?= number_format($TotalCemilan, 0, '', ','); ?></div>
                <div class="desc">Total Camilan</div>
                <a class="more" href="<?= site_url('dapur/monitoring'); ?>">
                    Detail <i class="fa fa-arrow-right"></i>
                </a>
            </div>

            <!-- TOTAL HIDANGAN UTAMA -->
            <div class="dashboard-card yellow-casablanca">
                <i class="fa fa-cutlery icon"></i>
                <div class="number"><?= number_format($TotalHidanganUtama, 0, '', ','); ?></div>
                <div class="desc">Total Hidangan Utama</div>
                <a class="more" href="<?= site_url('dapur/monitoring'); ?>">
                    Detail <i class="fa fa-arrow-right"></i>
                </a>
            </div>

            <!-- TOTAL HIDANGAN PENUTUP -->
            <div class="dashboard-card purple-soft">
                <i class="fa fa-ice-cream icon"></i>
                <div class="number"><?= number_format($TotalHidanganPenutup, 0, '', ','); ?></div>
                <div class="desc">Total Hidangan Penutup</div>
                <a class="more" href="<?= site_url('dapur/monitoring'); ?>">
                    Detail <i class="fa fa-arrow-right"></i>
                </a>
            </div>

            <!-- TOTAL PENDAPATAN -->
            <div class="dashboard-card purple-plum">
                <i class="fa fa-line-chart icon"></i>
                <div class="number">Rp <?= number_format($Pendapatan, 0, '', ','); ?></div>
                <div class="desc">Total Pendapatan</div>
                <a class="more" href="<?= site_url('dapur/monitoring'); ?>">
                    Detail <i class="fa fa-arrow-right"></i>
                </a>
            </div>
        </div>


        <!-- ====== GRAFIK ====== -->
        <div class="row mt-4">
            <!-- Grafik Total Menu -->
            <div class="col-md-6">
                <div class="portlet light bordered"
                    style="border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                    <div class="portlet-title">
                        <div class="caption font-green-sharp">
                            <i class="icon-bar-chart font-green-sharp"></i>
                            <span class="caption-subject bold uppercase">Grafik Total Menu Makanan</span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <canvas id="chartMenu"></canvas>
                    </div>
                </div>
            </div>

            <!-- Grafik Pendapatan -->
            <div class="col-md-6">
                <div class="portlet light bordered"
                    style="border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                    <div class="portlet-title">
                        <div class="caption font-purple-soft">
                            <i class="fa fa-line-chart font-purple-soft"></i>
                            <span class="caption-subject bold uppercase">Grafik Pendapatan per Kategori</span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <canvas id="chartPendapatan"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- ====== GRAFIK PROPORSI ====== -->
        <style>
        #chartProporsi {
            max-width: 400px;
            height: 200px !important;
            /* lebih kecil */
            margin: 0 auto;
        }

        .portlet.light.bordered {
            padding: 15px !important;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
        }

        .portlet-title .caption {
            font-size: 15px;
        }
        </style>

        <div class="row mt-4">
            <div class="col-md-12 text-center">
                <div class="portlet light bordered"
                    style="border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); max-width: 600px; margin: 0 auto;">
                    <div class="portlet-title">
                        <div class="caption font-blue-steel">
                            <i class="fa fa-pie-chart font-blue-steel"></i>
                            <span class="caption-subject bold uppercase">Proporsi Menu per Kategori</span>
                        </div>
                    </div>
                    <div class="portlet-body text-center">
                        <canvas id="chartProporsi" height="120"></canvas>
                    </div>
                </div>
            </div>
        </div>



        <div class="clearfix"></div>
    </div>
</div>

<!-- ====== SCRIPT GRAFIK ====== -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const totalCemilan = <?= $TotalCemilan; ?>;
    const totalHidanganUtama = <?= $TotalHidanganUtama; ?>;
    const totalHidanganPenutup = <?= $TotalHidanganPenutup; ?>;
    const totalPendapatan = <?= $Pendapatan; ?>;

    // === Grafik Total Menu (Bar Chart) ===
    const ctx1 = document.getElementById('chartMenu').getContext('2d');
    new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: ['Camilan', 'Hidangan Utama', 'Hidangan Penutup'],
            datasets: [{
                label: 'Jumlah Menu',
                data: [totalCemilan, totalHidanganUtama, totalHidanganPenutup],
                backgroundColor: [
                    'rgba(16, 196, 105, 0.8)',
                    'rgba(255, 193, 7, 0.8)',
                    'rgba(155, 89, 182, 0.8)'
                ],
                borderRadius: 10,
                borderWidth: 1,
                hoverBackgroundColor: [
                    'rgba(16, 196, 105, 1)',
                    'rgba(255, 193, 7, 1)',
                    'rgba(155, 89, 182, 1)'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#000',
                    titleFont: {
                        size: 14
                    },
                    bodyFont: {
                        size: 13
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#eee'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // === Grafik Pendapatan (Line Chart) ===
    const ctx2 = document.getElementById('chartPendapatan').getContext('2d');
    new Chart(ctx2, {
        type: 'line',
        data: {
            labels: ['Camilan', 'Hidangan Utama', 'Hidangan Penutup'],
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: [
                    totalCemilan * 12000,
                    totalHidanganUtama * 25000,
                    totalHidanganPenutup * 18000
                ],
                borderColor: '#8e44ad',
                backgroundColor: 'rgba(142, 68, 173, 0.2)',
                fill: true,
                tension: 0.4,
                borderWidth: 3,
                pointBackgroundColor: '#8e44ad'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#f0f0f0'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // === Grafik Proporsi (Doughnut Chart) ===
    const ctx3 = document.getElementById('chartProporsi').getContext('2d');
    new Chart(ctx3, {
        type: 'doughnut',
        data: {
            labels: ['Camilan', 'Hidangan Utama', 'Hidangan Penutup'],
            datasets: [{
                data: [totalCemilan, totalHidanganUtama, totalHidanganPenutup],
                backgroundColor: [
                    'rgba(16, 196, 105, 0.8)',
                    'rgba(255, 193, 7, 0.8)',
                    'rgba(155, 89, 182, 0.8)'
                ],
                borderWidth: 1,
                hoverOffset: 10
            }]
        },
        options: {
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: {
                            size: 13
                        }
                    }
                }
            }
        }
    });
});

const ctx = document.getElementById('chartProporsi').getContext('2d');
const chart = new Chart(ctx, {
    type: 'pie',
    data: dataChart,
    options: {
        maintainAspectRatio: false,
        responsive: true
    }
});
</script>