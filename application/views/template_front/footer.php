<?php
$contact    = $this->menu_m->select_contact()->row();
$meta       = $this->menu_m->select_meta()->row();
$listSocial = $this->menu_m->select_social()->result();
?>
<footer id="colophon" class="site-footer footer-v1">
    <div class="col-full">
        <div class="footer-social-icons">
            <span class="social-icon-text">Follow us</span>
            <ul class="social-icons list-unstyled">
                <?php
                foreach ($listSocial as $r) {
                ?>
                    <li><a class="fa fa-<?= $r->social_class; ?>" href="<?= $r->social_url; ?>" target="_blank"></a></li>
                <?php } ?>
            </ul>
        </div>
        <!-- <div class="footer-logo">
            <a href="<?= base_url(); ?>" class="custom-logo-link" rel="home">
                <img src="<?= base_url('img/logo-front.png'); ?>">
            </a>
        </div> -->
        <div class="site-address">
            <ul class="address">
                <li><?= $contact->contact_name; ?></li>
                <li><?= trim($contact->contact_address); ?></li>
                <li>Telp. <?= $contact->contact_phone; ?></li>
                <li><?= $contact->contact_email; ?></li>
            </ul>
        </div>

        <div class="site-info">
            <p class="copyright">Copyright &copy; <?= date('Y'); ?> <?= $meta->meta_name; ?></p>
        </div>

        <div class="pizzaro-handheld-footer-bar">
            <ul class="columns-3">
                <!-- <li class="my-account">
                    <a href="login-and-register.html">My Account</a>
                </li>
                <li class="search">
                    <a href="">Search</a>
                    <div class="site-search">
                        <div class="widget woocommerce widget_product_search">
                            <form role="search" method="get" class="woocommerce-product-search" >
                                <label class="screen-reader-text" for="woocommerce-product-search-field">Search for:</label>
                                <input type="search" id="woocommerce-product-search-field" class="search-field" placeholder="Search Products&hellip;" value="" name="s" title="Search for:" />
                                <input type="submit" value="Search" />
                                <input type="hidden" name="post_type" value="product" />
                            </form>
                        </div>
                    </div>
                </li> -->
                <li class="cart" style="margin-left:35%;">
                    <a class="footer-cart-contents" href="<?= site_url('cart'); ?>" title="Tampilkan Cart Order Anda">
                        <?= $cart_count_footer; ?>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</footer>
<style>
    /* ================= FOOTER ================= */
    footer.site-footer.footer-v1 {
        background: #2b2b2b;
        padding: 14px 0 8px;
        font-size: 14px;
        /* diperbesar dari 12px */
        color: #ccc;
    }

    /* ===== FOOTER ROW ===== */
    footer.site-footer.footer-v1 .col-full {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
    }

    /* ===== SOCIAL (LEFT) ===== */
    footer.site-footer .footer-social-icons {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    footer.site-footer .social-icon-text {
        font-size: 13px;
        /* diperbesar dari 11px */
        color: #aaa;
    }

    footer.site-footer .social-icons {
        display: flex;
        gap: 6px;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    footer.site-footer .social-icons li a {
        width: 30px;
        /* lebih besar */
        height: 30px;
        /* lebih besar */
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        /* diperbesar dari 13px */
        background: #444;
        color: #fff;
        border-radius: 50%;
        transition: all 0.3s ease;
    }

    footer.site-footer .social-icons li a:hover {
        background: #ff004d;
        transform: translateY(-2px);
    }

    /* ===== CART (CENTER) ===== */
    footer.site-footer .pizzaro-handheld-footer-bar {
        order: 2;
    }

    footer.site-footer .pizzaro-handheld-footer-bar .cart {
        margin: 0;
    }

    footer.site-footer .pizzaro-handheld-footer-bar .cart a {
        padding: 6px 16px;
        /* sedikit lebih besar */
        font-size: 13px;
        /* diperbesar dari 11px */
        border-radius: 18px;
        background: #ff004d;
        color: #fff;
        text-decoration: none;
    }

    /* ===== ADDRESS (RIGHT) ===== */
    footer.site-footer .site-address {
        order: 3;
        text-align: right;
    }

    footer.site-footer .site-address li {
        font-size: 13px;
        /* diperbesar dari 11px */
        line-height: 1.6;
        color: #bbb;
        list-style: none;
    }

    /* ===== COPYRIGHT (BOTTOM CENTER) ===== */
    footer.site-footer .site-info {
        width: 100%;
        margin-top: 6px;
        text-align: center;
        order: 4;
    }

    footer.site-footer .site-info p {
        font-size: 12px;
        /* diperbesar dari 10.5px */
        color: #999;
        margin: 0;
    }

    /* ===== MOBILE ===== */
    @media (max-width: 768px) {
        footer.site-footer.footer-v1 .col-full {
            flex-direction: column;
            text-align: center;
            gap: 10px;
        }

        footer.site-footer .site-address {
            text-align: center;
        }

        footer.site-footer .social-icon-text {
            font-size: 14px;
        }

        footer.site-footer .site-address li {
            font-size: 14px;
        }

        footer.site-footer .pizzaro-handheld-footer-bar .cart a {
            font-size: 14px;
            padding: 8px 20px;
        }

        footer.site-footer .site-info p {
            font-size: 13px;
        }
    }
</style><!-- ================= SCRIPT OWL CAROUSEL ================= -->
<script>
    $(document).ready(function() {
        var owl = $("#owl-main");
        owl.owlCarousel({
            items: 1,
            loop: true,
            autoplay: true,
            autoplayTimeout: 4000, // lama slide otomatis
            autoplayHoverPause: true,
            nav: false, // nav bawaan kita matikan, pakai tombol custom
            dots: true,
            smartSpeed: 800, // kecepatan geser lembut
            mouseDrag: true,
            touchDrag: true,
            pullDrag: true
        });

        // Tombol prev/next custom
        $(".slider-prev").click(function() {
            owl.trigger('prev.owl.carousel');
        });
        $(".slider-next").click(function() {
            owl.trigger('next.owl.carousel');
        });
    });
</script>