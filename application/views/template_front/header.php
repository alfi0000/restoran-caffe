<?php
$contact      = $this->menu_m->select_contact()->row();
$listKategori = $this->menu_m->select_kategori()->result();
?>

<header class="header-modern" id="mainHeader">
    <div class="header-container">

        <!-- Logo -->
        <div class="header-logo">
            <a href="<?= base_url(); ?>">
                <img src="<?= base_url('img/home.png'); ?>" alt="Logo Resto">
            </a>
        </div>

        <!-- MENU -->
        <nav class="header-menu" id="headerMenu">
            <!-- <div class="menu-close" id="menuClose">&times;</div> -->
            <ul class="menu-list">
                <?php foreach ($listKategori as $r): ?>
                    <li class="menu-item">
                        <a href="<?= site_url('kategori/' . $r->kategori_seo); ?>">
                            <i class="<?= $r->kategori_icon; ?>"></i>
                            <?= ucwords(strtolower($r->kategori_nama)); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>

        <!-- RIGHT ACTION -->
        <div class="header-actions">

            <!-- CART -->
            <div class="header-cart">
                <a href="<?= site_url('cart'); ?>" class="cart-btn">
                    <i class="fa fa-cart-plus"></i>
                    <span class="cart-text">Cart</span>
                </a>
            </div>

            <!-- HAMBURGER -->
            <div class="hamburger" id="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>

        </div>

    </div>
</header>

<!-- OVERLAY -->
<div class="menu-overlay" id="menuOverlay"></div>


<!-- ================= STYLE ================= -->
<style>
    /* ================= RESET ================= */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* ================= HEADER ================= */
    .header-modern {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        background: rgba(107, 112, 107, 0.97);
        backdrop-filter: blur(10px);

        /* SHADOW HEADER */
        box-shadow: 0 4px 12px rgba(112, 107, 108, 0.97);

        z-index: 999;
    }

    /* CART di kiri, HAMBURGER di kanan */
    .header-actions {
        display: flex;
        align-items: center;
    }

    /* Geser CART mendekat ke hamburger */
    .header-cart {
        margin-right: 16px;
        /* atur jarak ke hamburger */
    }

    .header-container {
        max-width: 1300px;
        margin: auto;
        padding: 14px 24px;
        display: flex;
        align-items: center;
    }

    /* LOGO di kiri */
    .header-logo {
        margin-right: auto;
    }

    /* MENU di samping CART */
    .header-menu {
        margin-right: 20px;
    }


    .header-container {
        max-width: 1300px;
        margin: auto;
        padding: 14px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    /* ================= LOGO ================= */
    .header-logo img {
        height: 70px;
    }

    /* ================= MENU DESKTOP ================= */
    .header-menu .menu-list {
        display: flex;
        gap: 30px;
        list-style: none;
    }

    .header-menu a {
        color: #fff;
        text-decoration: none;
        font-size: 15px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .header-menu a:hover {
        color: #ffd700;
    }

    /* ================= HEADER ACTIONS ================= */
    .header-actions {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    /* ================= CART ================= */
    .header-cart .cart-btn {
        background: #ff004d;
        color: #fff;
        padding: 9px 22px;
        border-radius: 25px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* ================= HAMBURGER ================= */
    .hamburger {
        display: none;
        width: 28px;
        height: 22px;
        flex-direction: column;
        justify-content: space-between;
        cursor: pointer;
        z-index: 1100;
    }

    .hamburger span {
        width: 100%;
        height: 3px;
        background: #fff;
        border-radius: 3px;
        transition: 0.3s;
    }

    .hamburger.active span:nth-child(1) {
        transform: rotate(45deg) translateY(9px);
    }

    .hamburger.active span:nth-child(2) {
        opacity: 0;
    }

    .hamburger.active span:nth-child(3) {
        transform: rotate(-45deg) translateY(-9px);
    }

    /* ================= OVERLAY ================= */
    .menu-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.55);
        opacity: 0;
        visibility: hidden;
        transition: 0.3s;
        z-index: 900;
    }

    .menu-overlay.active {
        opacity: 1;
        visibility: visible;
    }

    /* ================= MOBILE MODE ================= */
    @media (max-width: 768px) {

        .hamburger {
            display: flex;
        }

        .header-cart .cart-text {
            display: none;
        }

        /* SIDEBAR MENU KANAN */
        .header-menu {
            position: fixed;
            top: 0;
            right: -100%;
            width: 78%;
            max-width: 300px;
            height: 100vh;
            background: #b10020;
            padding: 80px 20px 20px;
            transition: right 0.4s ease;
            z-index: 1000;
            box-shadow: -4px 0 20px rgba(0, 0, 0, 0.3);
        }

        .header-menu.active {
            right: 0;
        }

        .header-menu .menu-list {
            flex-direction: column;
            gap: 18px;
        }

        .header-menu a {
            padding: 12px;
            border-radius: 8px;
            font-size: 16px;
        }

        .header-menu a:hover {
            background: rgba(255, 255, 255, 0.15);
        }

        .menu-close {
            position: absolute;
            top: 18px;
            right: 18px;
            font-size: 30px;
            color: #fff;
            cursor: pointer;
        }

        .header-logo img {
            height: 55px;
        }
    }
</style>

<!-- ================= JS ================= -->
<script>
    const hamburger = document.getElementById("hamburger");
    const menu = document.getElementById("headerMenu");
    const overlay = document.getElementById("menuOverlay");
    const closeBtn = document.getElementById("menuClose");

    function openMenu() {
        hamburger.classList.add("active");
        menu.classList.add("active");
        overlay.classList.add("active");
    }

    function closeMenu() {
        hamburger.classList.remove("active");
        menu.classList.remove("active");
        overlay.classList.remove("active");
    }

    hamburger.addEventListener("click", () => {
        menu.classList.contains("active") ? closeMenu() : openMenu();
    });

    overlay.addEventListener("click", closeMenu);
    closeBtn.addEventListener("click", closeMenu);
</script>