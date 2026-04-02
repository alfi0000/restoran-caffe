<div class="page-content-wrapper">
    <div class="page-content">
        <h3 class="page-title">Dashboard</h3>
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="<?= site_url('kasir/home'); ?>">Dashboard</a>
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


        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat blue-madison">
                    <div class="visual">
                        <i class="fa fa-cutlery"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            <?= number_format($TotalPesanan, 0, '', ','); ?>
                        </div>
                        <div class="desc">Total Pesanan</div>
                    </div>
                    <a class="more" href="<?= site_url('kasir/monitoring'); ?>">
                        Detail <i class="m-icon-swapright m-icon-white"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat red-intense">
                    <div class="visual">
                        <i class="fa fa-coffee"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            <?= number_format($TotalMinuman, 0, '', ','); ?>
                        </div>
                        <div class="desc">Total Minuman</div>
                    </div>
                    <a class="more" href="<?= site_url('kasir/monitoring'); ?>">
                        Detail <i class="m-icon-swapright m-icon-white"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat green-haze">
                    <div class="visual">
                        <i class="fa fa-birthday-cake"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            <?= number_format($TotalCemilan, 0, '', ','); ?>
                        </div>
                        <div class="desc">Total Cemilan</div>
                    </div>
                    <a class="more" href="<?= site_url('kasir/monitoring'); ?>">
                        Detail <i class="m-icon-swapright m-icon-white"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat purple-plum">
                    <div class="visual">
                        <i class="fa fa-line-chart"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            Rp <?= number_format($Pendapatan, 0, '', ','); ?>
                        </div>
                        <div class="desc">Total Pendapatan</div>
                    </div>
                    <a class="more" href="<?= site_url('kasir/monitoring'); ?>">
                        Detail <i class="m-icon-swapright m-icon-white"></i>
                    </a>
                </div>
            </div>
        </div>


        <div class="clearfix"></div>
    </div>
</div>