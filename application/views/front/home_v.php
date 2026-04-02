<!-- ================= CONTENT ================= -->
<div id="content" class="site-content" tabindex="-1">
    <div class="col-full">
        <div id="primary" class="content-area">
            <main id="main" class="site-main">

                <!-- ================= SLIDER ================= -->
                <div class="home-v1-slider">
                    <div id="owl-main" class="owl-carousel owl-inner-nav owl-ui-sm">
                        <?php
                        $no = 1;
                        foreach ($listSlider as $r) {
                        ?>
                            <div class="item slider-<?= $no; ?>"
                                style="background-image: url(<?= base_url('img/slider_folder/' . $r->slider_image); ?>);">

                                <!-- Overlay teks -->
                                <div class="slider-text">
                                    <?php if ($no == 1): ?>
                                        <h2>Selamat Datang di Barcode Caffe & Resto</h2>
                                        <p>Nikmati suasana nyaman sambil mencicipi hidangan lezat dan minuman segar.</p>
                                    <?php elseif ($no == 2): ?>
                                        <h2>Rasakan Sensasi Rasa!</h2>
                                        <p>Dari kopi hangat hingga hidangan spesial, semuanya siap memanjakan lidahmu.</p>
                                    <?php elseif ($no == 3): ?>
                                        <h2>Tempat Hangout & Santai</h2>
                                        <p>Ajak teman, keluarga, atau kolega dan jadikan setiap kunjungan lebih istimewa!</p>
                                    <?php else: ?>
                                        <h2>Hidangan Lezat, Suasana Nyaman</h2>
                                        <p>Kami menyajikan menu pilihan dan tempat yang sempurna untuk melepas penat.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php
                            $no++;
                        }
                        ?>
                    </div>

                    <!-- Tombol geser -->
                    <div class="slider-nav">
                        <button class="slider-prev">&#10094;</button>
                        <button class="slider-next">&#10095;</button>
                    </div>
                </div>

                <?php if (isset($meja_id) && $meja_id != ''): ?>
                    <input type="hidden" id="meja_id" value="<?= $meja_id; ?>">
                <?php endif; ?>

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
                                                                data-meja="<?= isset($meja_id) ? $meja_id : '' ?>"
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
    .home-v1-slider {
        position: relative;
        width: 100%;
        height: 600px;
        /* lebih besar */
        overflow: hidden;
    }

    .home-v1-slider .item {
        width: 100%;
        height: 100%;
        background-position: center;
        background-size: cover;
        background-repeat: no-repeat;
        position: relative;
    }

    /* Teks overlay */
    .slider-text {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: #fff;
        text-align: center;
        background: rgba(0, 0, 0, 0.4);
        /* sedikit transparan */
        padding: 20px 40px;
        border-radius: 10px;
    }

    .slider-text h2 {
        font-size: 36px;
        margin-bottom: 10px;
    }

    .slider-text p {
        font-size: 18px;
    }

    /* Tombol geser */
    .slider-nav button {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(0, 0, 0, 0.4);
        color: #fff;
        border: none;
        padding: 12px 18px;
        font-size: 24px;
        cursor: pointer;
        z-index: 20;
        border-radius: 50%;
        transition: background 0.3s;
    }

    .slider-nav button:hover {
        background: rgba(0, 0, 0, 0.7);
    }

    .slider-prev {
        left: 20px;
    }

    .slider-next {
        right: 20px;
    }

    /* Dots */
    .owl-dots {
        text-align: center;
        margin-top: 15px;
    }

    .owl-dots .owl-dot span {
        width: 12px;
        height: 12px;
        background: #fff;
        display: block;
        border-radius: 50%;
        margin: 5px;
        opacity: 0.7;
        transition: opacity 0.3s;
    }

    .owl-dots .owl-dot.active span {
        opacity: 1;
        background: #007bff;
    }

    @media (max-width: 768px) {
        .home-v1-slider {
            height: 350px;
        }

        .slider-text h2 {
            font-size: 24px;
        }

        .slider-text p {
            font-size: 14px;
        }
    }
</style>

<!-- ================= SCRIPT OWL CAROUSEL ================= -->
<script>
    $(document).ready(function() {

        var owl = $("#owl-main");
        owl.owlCarousel({
            items: 1,
            loop: true,
            autoplay: true,
            autoplayTimeout: 4000,
            autoplayHoverPause: true,
            nav: false,
            dots: true,
            smartSpeed: 600
        });

        <?php if (isset($meja_id) && $meja_id != ''): ?>
            localStorage.setItem("meja_id", "<?= $meja_id; ?>");
        <?php endif; ?>

    });

    $(document).on("click", ".addToCart", function() {

        var meja = localStorage.getItem("meja_id");

        if (!meja) {
            alert("Silakan scan QR Meja terlebih dahulu!");
            return false;
        }

        var menu_id = $(this).data("id");
        var qty = $(this).data("qty");

        $.ajax({
            url: "<?= site_url('cart/add'); ?>",
            type: "POST",
            data: {
                meja_id: meja,
                menu_id: menu_id,
                qty: qty
            },
            success: function(res) {
                alert("Berhasil ditambahkan ke keranjang");
                location.reload();
            }
        });
    });

    function qty_change() {
        var qty = $('#qty').val();
        $('.addToCart').attr('data-qty', qty);
    }
</script>