<!-- ================= CONTENT ================= -->
<div id="content" class="site-content" tabindex="-1">
    <div class="col-full">
        <div id="primary" class="content-area">
            <main id="main" class="site-main">

                <!-- ================= SLIDER ================= -->
                <!-- SLIDER -->
                <div class="home-v1-slider">
                    <div id="owl-main" class="owl-carousel owl-inner-nav owl-ui-sm">
                        <?php
                        $no = 1;
                        foreach ($listSlider as $r) {
                        ?>
                        <div class="item slider-<?= $no; ?>"
                            style="background-image: url(<?= base_url('img/slider_folder/' . $r->slider_image); ?>);">
                        </div>
                        <?php
                            $no++;
                        }
                        ?>
                    </div>
                </div>

                <!-- PRODUCTS -->
                <div class="section-products">
                    <h2 class="section-title">Menu Kami</h2>
                    <div class="columns-4">
                        <ul class="products">
                            <?php
                            if (!empty($listMenu)) {
                                $no = 1;
                                foreach ($listMenu as $r) {
                                    $class = ($no % 4 == 1) ? 'first' : (($no % 4 == 0) ? 'last' : '');
                            ?>
                            <li class="product <?= $class; ?>">
                                <div class="product-outer">
                                    <div class="product-inner">
                                        <div class="product-image-wrapper">
                                            <a href="<?= site_url('menuorder/' . $r->menu_seo); ?>"
                                                class="woocommerce-LoopProduct-link">
                                                <img src="<?= base_url('img/menu_folder/thumbs/' . $r->menu_foto); ?>"
                                                    class="img-responsive" alt="">
                                            </a>
                                        </div>
                                        <div class="product-content-wrapper">
                                            <a href="<?= site_url('menuorder/' . $r->menu_seo); ?>"
                                                class="woocommerce-LoopProduct-link">
                                                <h3><?= ucwords(strtolower($r->menu_nama)); ?></h3>
                                                <div class="yith_wapo_groups_container">
                                                    <div
                                                        class="ywapo_group_container ywapo_group_container_radio form-row form-row-wide">
                                                        <h3><span>Harga</span></h3>
                                                        <div class="ywapo_input_container ywapo_input_container_radio">
                                                            <span class="ywapo_label_price">
                                                                <span class="woocommerce-Price-amount amount">
                                                                    <span
                                                                        class="woocommerce-Price-currencySymbol">Rp.</span>
                                                                    <?= number_format($r->menu_harga, 0, '', ','); ?>
                                                                </span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                            <div class="hover-area">
                                                <?php if ($r->stok_menu > 0): ?>
                                                <a data-id="<?= $r->menu_id; ?>" data-qty="1"
                                                    data-stok="<?= $r->stok_menu; ?>"
                                                    class="addToCart button product_type_simple add_to_cart_button">
                                                    Order
                                                </a>
                                                <?php else: ?>
                                                <button class="button disabled" disabled
                                                    style="background-color:#dc3545;color:#fff;">
                                                    <i class="fa fa-times-circle"></i> Stok Habis
                                                </button>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <?php
                                    $no++;
                                }
                            } else {
                                echo '<p style="text-align:center; width:100%; color:#555;">Menu belum tersedia.</p>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </main>
        </div>
    </div>
</div>

<!-- ================= STYLE ================= -->
<style>
/* Slider agar muncul dari atas */
.home-v1-slider {
    width: 100%;
    height: 400px;
    /* Sesuaikan tinggi slider */
    overflow: hidden;
}

.home-v1-slider .item {
    width: 100%;
    height: 100%;
    background-position: center;
    background-size: cover;
    background-repeat: no-repeat;
}

/* Jika header fixed, tambahkan jarak agar slider tidak tertutup */
.site-header.fixed {
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 9999;
}

.site-content {
    padding-top: 0;
    /* hapus jarak atas supaya slider muncul langsung */
}

@media (max-width: 768px) {
    .home-v1-slider {
        height: 250px;
    }
}
</style>

<!-- ================= SCRIPT OWL CAROUSEL ================= -->
<script>
$(document).ready(function() {
    $("#owl-main").owlCarousel({
        items: 1,
        loop: true,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        nav: true,
        dots: true,
        navText: ["<", ">"]
    });
});
</script>