<div id="content" class="site-content" tabindex="-1">
    <div class="col-full">
        <div class="pizzaro-breadcrumb">
            <nav class="woocommerce-breadcrumb">
                <a href="<?= base_url(); ?>">Beranda</a>
                <span class="delimiter"><i class="po po-arrow-right-slider"></i></span>
                <a href="#">Konfirmasi</a>
                <span class="delimiter"><i class="po po-arrow-right-slider"></i></span>Order Selesai
            </nav>
        </div>
        <div id="primary" class="content-area">
            <main id="main" class="site-main">
                <?= $_proses; ?>

                <div id="post-9" class="post-9 page type-page status-publish hentry">
                    <header class="entry-header">
                        <h1 class="entry-title">Order Selesai</h1>
                    </header>
                    <div class="entry-content">
                        <div class="woocommerce">
                            <p class="woocommerce-thankyou-order-received">Terima Kasih, Pesanan Anda Kami Terima.</p>
                            <p class="woocommerce-thankyou-order-received">Segera Lakukan Pembayaran Di Kasir Agar
                                Pesanan Anda Dapat Kami Proses Dengan Cepat.</p>
                            <ul class="woocommerce-thankyou-order-details order_details">
                                <li class="order">No. Order #:<strong><?= $Order->order_id; ?></strong></li>
                                <li class="date">Tanggal :<strong><?= tgl_indo($Order->order_tanggal); ?></strong></li>
                                <li class="date">Qty dan Waktu
                                    :<strong><?= $Order->order_qty . ' / ' . $Order->order_waktu . ' Menit'; ?></strong>
                                </li>
                                <li class="total">Total :<strong><span class="woocommerce-Price-amount amount"><span
                                                class="woocommerce-Price-currencySymbol">Rp.
                                            </span><?= number_format($Order->order_total, 0, '', ','); ?></span></strong>
                                </li>
                            </ul>
                            <div class="clear"></div>
                            <p>Silahkan melakukan Pembayaran setelah Anda menikmati hidangan Kami.</p>
                            <h2>Order Detail</h2>
                            <table class="shop_table order_details">
                                <thead>
                                    <tr>
                                        <th class="product-name">Menu</th>
                                        <th class="product-total">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($listOrder as $r) { ?>
                                    <tr class="order_item">
                                        <td class="product-name">
                                            <a
                                                href="<?= site_url('menuorder/' . $r->menu_seo); ?>"><?= ucwords(strtolower($r->menu_nama)); ?></a>
                                            <strong class="product-quantity">× <?= $r->order_detail_qty; ?></strong>
                                        </td>
                                        <td class="product-total"><span class="woocommerce-Price-amount amount"><span
                                                    class="woocommerce-Price-currencySymbol">Rp.
                                                </span><?= number_format($r->order_detail_subtotal, 0, '', ','); ?></span>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th scope="row">Total :</th>
                                        <td><span class="woocommerce-Price-amount amount"><span
                                                    class="woocommerce-Price-currencySymbol">Rp.
                                                </span><?= number_format($Order->order_total, 0, '', ','); ?></span>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                            <header>
                                <h2>Detail Pembeli</h2>
                            </header>
                            <table class="shop_table customer_details">
                                <tbody>
                                    <tr>
                                        <th>Nama :</th>
                                        <td><?= $Order->order_nama; ?></td>
                                    </tr>
                                    <tr>
                                        <th>No. Meja :</th>
                                        <td><?= $Order->meja_nama; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="bill-download" style="margin-top:20px; text-align:right;">
                                <a href="<?= site_url('checkout/bill_jpg/' . $Order->order_id); ?>" class="button alt">
                                    ⬇ Unduh Bill (JPG)
                                </a>



                            </div>

                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</div>

<style>
/* ================= GLOBAL SPACING ================= */
#content.site-content {
    padding-top: 120px;
    padding-bottom: 40px;
    background: #f7f7f7;
}

/* ================= BREADCRUMB ================= */
.pizzaro-breadcrumb {
    margin-bottom: 20px;
}

.woocommerce-breadcrumb {
    font-size: 14px;
    color: #777;
}

.woocommerce-breadcrumb a {
    color: #ff6b35;
    font-weight: 500;
}

/* ================= CARD UTAMA ================= */
.post-9 {
    background: #ffffff;
    border-radius: 14px;
    padding: 24px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.06);
}

/* ================= JUDUL ================= */
.entry-title {
    font-size: 26px;
    font-weight: 700;
    margin-bottom: 16px;
    text-align: center;
}

.woocommerce-thankyou-order-received {
    text-align: center;
    font-size: 16px;
    color: #333;
    margin-bottom: 10px;
}

/* ================= ORDER INFO ================= */
.order_details {
    list-style: none;
    padding: 0;
    margin: 20px 0;
    border-radius: 10px;
    background: #fafafa;
}

.order_details li {
    padding: 12px 16px;
    border-bottom: 1px solid #eee;
    font-size: 15px;
}

.order_details li:last-child {
    border-bottom: none;
}

.order_details strong {
    float: right;
    font-weight: 600;
}

/* ================= TABLE ================= */
.shop_table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
}

.shop_table th,
.shop_table td {
    padding: 12px;
    border-bottom: 1px solid #eee;
    font-size: 15px;
}

.shop_table th {
    background: #f5f5f5;
    font-weight: 600;
}

/* ================= SECTION TITLE ================= */
h2 {
    margin-top: 30px;
    font-size: 20px;
    font-weight: 700;
}

/* ================= CUSTOMER DETAIL ================= */
.customer_details {
    background: #fafafa;
    border-radius: 10px;
}

.customer_details th,
.customer_details td {
    padding: 12px;
    font-size: 15px;
}

/* ================= MOBILE MODE ================= */
@media (max-width: 768px) {
    #content.site-content {
        padding-top: 90px;
    }

    .post-9 {
        padding: 18px;
    }

    .entry-title {
        font-size: 22px;
    }

    .order_details li {
        font-size: 14px;
    }

    .order_details strong {
        float: none;
        display: block;
        margin-top: 4px;
    }

    .shop_table th,
    .shop_table td {
        font-size: 14px;
        padding: 10px;
    }

    h2 {
        font-size: 18px;
    }
}
</style>