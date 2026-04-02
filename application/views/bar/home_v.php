<div class="page-content-wrapper">
    <div class="page-content">
        <h3 class="page-title">Dashboard</h3>
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="<?= site_url('bar/home'); ?>">Dashboard</a>
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

        <!-- Statistik Singkat -->
        <div class="row mt-3">
            <!-- TOTAL PESANAN -->
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                <div class="dashboard-stat blue-madison" style="border-radius:15px;">
                    <div class="visual">
                        <i class="fa fa-cutlery"></i>
                    </div>
                    <div class="details">
                        <div class="number"><?= number_format($TotalPesananMinum, 0, '', ','); ?></div>
                        <div class="desc">Total Pesanan</div>
                    </div>
                    <a class="more" href="<?= site_url('bar/monitoring'); ?>">
                        Detail <i class="m-icon-swapright m-icon-white"></i>
                    </a>
                </div>
            </div>

            <!-- TOTAL MINUM -->
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                <div class="dashboard-stat red-intense" style="border-radius:15px;">
                    <div class="visual">
                        <i class="fa fa-coffee"></i>
                    </div>
                    <div class="details">
                        <div class="number"><?= number_format($TotalMinum, 0, '', ','); ?></div>
                        <div class="desc">Total Minuman</div>
                    </div>
                    <a class="more" href="<?= site_url('bar/monitoring'); ?>">
                        Detail <i class="m-icon-swapright m-icon-white"></i>
                    </a>
                </div>
            </div>

            <!-- TOTAL PENDAPATAN -->
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                <div class="dashboard-stat purple-plum" style="border-radius:15px;">
                    <div class="visual">
                        <i class="fa fa-line-chart"></i>
                    </div>
                    <div class="details">
                        <div class="number">Rp <?= number_format($Pendapatan, 0, '', ','); ?></div>
                        <div class="desc">Total Pendapatan</div>
                    </div>
                    <a class="more" href="<?= site_url('bar/monitoring'); ?>">
                        Detail <i class="m-icon-swapright m-icon-white"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Grafik Bar -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="portlet light bordered"
                    style="border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); padding: 20px;">
                    <div class="portlet-title">
                        <div class="caption font-blue-steel">
                            <i class="fa fa-bar-chart font-blue-steel"></i>
                            <span class="caption-subject bold uppercase">Grafik Penjualan Minuman per Kategori</span>
                        </div>
                    </div>
                    <div class="portlet-body text-center">
                        <canvas id="chartBarPenjualan" height="120"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>
    </div>
</div>

<!-- ====== SCRIPT GRAFIK (Chart.js) ====== -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const ctx = document.getElementById("chartBarPenjualan").getContext("2d");

    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["Kopi", "Teh", "Jus", "Soda", "Milkshake", "Lainnya"],
            datasets: [{
                label: 'Jumlah Terjual',
                data: [
                    <?= $kopi ?? 50; ?>,
                    <?= $teh ?? 30; ?>,
                    <?= $jus ?? 40; ?>,
                    <?= $soda ?? 20; ?>,
                    <?= $milkshake ?? 25; ?>,
                    <?= $lainnya ?? 10; ?>
                ],
                backgroundColor: [
                    "rgba(54, 162, 235, 0.7)",
                    "rgba(255, 99, 132, 0.7)",
                    "rgba(255, 206, 86, 0.7)",
                    "rgba(75, 192, 192, 0.7)",
                    "rgba(153, 102, 255, 0.7)",
                    "rgba(255, 159, 64, 0.7)"
                ],
                borderRadius: 8,
                borderWidth: 1,
                borderColor: "rgba(255,255,255,0.6)"
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#1e1e2f',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    padding: 10,
                    cornerRadius: 8
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: "rgba(200,200,200,0.2)"
                    },
                    ticks: {
                        color: "#666"
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: "#666"
                    }
                }
            }
        }
    });
});
</script>