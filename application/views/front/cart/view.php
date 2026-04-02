<div id="content" class="site-content" tabindex="-1">
    <div class="col-full">
        <div class="pizzaro-breadcrumb">
            <nav class="woocommerce-breadcrumb">
                <a href="<?= base_url(); ?>">Beranda</a>
                <span class="delimiter"><i class="po po-arrow-right-slider"></i></span>Cart
            </nav>
        </div>

        <div id="primary" class="content-area">
            <main id="main" class="site-main">
                <?= $_proses; ?>
                <div id="post-8" class="post-8 page type-page status-publish hentry">
                    <div class="entry-content">
                        <div class="woocommerce">
                            <?= $keranjang_belanja; ?>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</div>
<script>
    $('#btnKonfirmasi').on('click', function() {

        const btn = $(this);
        btn.text('Memeriksa stok...').prop('disabled', true);

        $.ajax({
            url: '<?= site_url("checkout/check_stock"); ?>',
            type: 'GET',
            dataType: 'json',
            success: function(res) {
                if (res.status === false) {
                    alert(res.message);
                    btn.text('Konfirmasi').prop('disabled', false);
                } else {
                    window.location.href = '<?= site_url("checkout"); ?>';
                }
            },
            error: function() {
                alert('Gagal cek stok');
                btn.text('Konfirmasi').prop('disabled', false);
            }
        });
    });
</script>

<style>
    #content.site-content {
        /* margin-top: 100px; */
        padding-top: 132px;
    }
</style>