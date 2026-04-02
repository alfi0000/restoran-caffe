<!DOCTYPE html>
<html>

<head>
    <title>Pindah Meja</title>
    <style>
    body {
        font-family: Arial;
        text-align: center;
        padding: 80px;
        background: #f8f9fa;
    }

    .box {
        border: 1px solid #ddd;
        padding: 40px;
        border-radius: 12px;
        max-width: 500px;
        margin: auto;
        background: white;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .btn {
        padding: 12px 25px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        margin: 10px;
        font-size: 16px;
    }

    .btn-danger {
        background: #dc3545;
        color: white;
    }

    .btn-success {
        background: #28a745;
        color: white;
    }
    </style>
</head>

<body>

    <div class="box">
        <h2>⚠️ Meja Sedang Aktif</h2>

        <p>
            HP ini sedang digunakan untuk <b>Meja <?= $meja_lama; ?></b>
        </p>

        <p>
            Apakah ingin pindah ke <b>Meja <?= $meja_baru; ?></b>?
        </p>

        <form method="post" action="<?= base_url('checkout/pindah_meja'); ?>">
            <input type="hidden" name="meja_lama" value="<?= $meja_lama; ?>">
            <input type="hidden" name="meja_baru" value="<?= $meja_baru; ?>">

            <button type="submit" class="btn btn-success">
                ✅ Ya, Pindah Meja
            </button>

            <a href="<?= base_url(); ?>" class="btn btn-danger">
                ❌ Batal
            </a>
        </form>

    </div>

</body>

</html>