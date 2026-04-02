<div id="content" class="site-content" tabindex="-1">
    <div class="col-full">
        <div class="pizzaro-breadcrumb">
            <nav class="woocommerce-breadcrumb" itemprop="breadcrumb">
                <a href="<?= base_url(); ?>">Beranda</a><span class="delimiter"><i
                        class="po po-arrow-right-slider"></i></span>
                <a
                    href="<?= site_url('kategori/' . $detail->kategori_seo); ?>"><?= ucwords(strtolower($detail->kategori_nama)); ?></a>
            </nav>
        </div>


        <div id="primary" class="content-area">
            <main id="main" class="site-main">
                <div class="columns-4">
                    <ul class="products">
                        <?php
                        $no = 1;
                        foreach ($listMenu as $r) {
                            if ($no % 4 == 1) {
                                $class = 'first';
                            } elseif ($no % 4 == 0) {
                                $class = 'last';
                            } else {
                                $class = '';
                            }
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
                                                    <div class="ywapo_group_container ywapo_group_container_radio form-row form-row-wide"
                                                        data-requested="1" data-type="radio" data-id="1" data-condition="">
                                                        <h3><span>Harga</span></h3>
                                                        <div class="ywapo_input_container ywapo_input_container_radio">
                                                            <span class="ywapo_label_price">
                                                                <span class="woocommerce-Price-amount amount">
                                                                    <span class="woocommerce-Price-currencySymbol">Rp.
                                                                    </span><?= number_format($r->menu_harga, 0, '', ','); ?>
                                                                </span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>

                                            <div class="hover-area">
                                                <?php if ($r->stok_menu > 0): ?>
                                                    <a data-id="<?= $r->menu_id; ?>" data-qty="1"
                                                        data-stok="<?= $r->stok_menu; ?>" title="Tambah ke Keranjang"
                                                        type="button"
                                                        class="addToCart button product_type_simple add_to_cart_button">
                                                        Order
                                                    </a>
                                                <?php else: ?>
                                                    <button class="button disabled" disabled
                                                        style="background-color: #dc3545; color: #fff;">
                                                        <i class="fa fa-times-circle"></i> Stok Habis
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        <?php
                            if ($no % 4 == 0) {
                                echo '</ul></div><div class="columns-4"><ul class="products">';
                            }
                            $no++;
                        }
                        ?>
                    </ul>
                </div>


            </main>
        </div>
    </div>
</div>


<style>
    .site-content {
        padding-top: 180px;
    }

    @media (max-width: 768px) {
        .site-content {
            padding-top: 120px;
        }
    }
</style>


<script>
    const header = document.querySelector('.header-modern');
    const content = document.querySelector('.site-content');

    const extraSpace = 50; // TAMBAHAN JARAK
    content.style.paddingTop = (header.offsetHeight + extraSpace) + 'px';
</script>