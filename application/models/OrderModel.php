<?php
defined('BASEPATH') or exit('No direct script access allowed');

class OrderModel extends CI_Model
{
    // ==========================================================
    // 📦 BAGIAN UMUM
    // ==========================================================

    // ✅ Total semua pesanan (semua kategori gabungan)
    public function getTotalPesanan()
    {
        return $this->db->count_all('v_order_detail');
    }

    // ✅ Total pendapatan dari semua kategori
    public function getTotalPendapatan()
    {
        $this->db->select_sum('total_harga');
        $query = $this->db->get('v_order_detail');
        $row = $query->row();
        return $row ? $row->total_harga : 0;
    }

    // ✅ Fungsi fleksibel: ambil total menu berdasarkan kategori dari v_menu
    public function getTotalMenuByKategori($kategori)
    {
        $this->db->where('kategori_nama', $kategori);
        return $this->db->count_all_results('v_menu');
    }

    // ==========================================================
    // ☕ BAGIAN BARISTA (khusus minuman)
    // ==========================================================

    // ✅ Total menu kategori Minum (ambil dari v_menu)
    public function getTotalMinum()
    {
        $this->db->where('kategori_nama', 'Minum');
        return $this->db->count_all_results('v_menu');
    }

    // ✅ Total pesanan kategori Minum (ambil dari v_order_detail)
    public function getTotalPesananMinum()
    {
        $this->db->where('menu_kategori', 'Minum');
        return $this->db->count_all_results('v_order_detail');
    }

    // ✅ Total pendapatan kategori Minum (hanya untuk barista)
    public function getTotalPendapatanMinum()
    {
        $this->db->select_sum('total_harga');
        $this->db->where('menu_kategori', 'Minum');
        $query = $this->db->get('v_order_detail');
        $row = $query->row();
        return $row ? $row->total_harga : 0;
    }

    // ==========================================================
    // 🍳 BAGIAN DAPUR (khusus makanan)
    // ==========================================================

    // ✅ Total menu kategori Cemilan
    public function getTotalCemilan()
    {
        $this->db->where('kategori_nama', 'Camilan');
        return $this->db->count_all_results('v_menu');
    }

    // ✅ Total menu kategori Hidangan Utama
    public function getTotalHidanganUtama()
    {
        $this->db->where('kategori_nama', 'Hidangan Utama');
        return $this->db->count_all_results('v_menu');
    }

    // ✅ Total menu kategori Hidangan Penutup
    public function getTotalHidanganPenutup()
    {
        $this->db->where('kategori_nama', 'Hidangan Penutup');
        return $this->db->count_all_results('v_menu');
    }

    // ✅ Total pesanan kategori Cemilan
    public function getTotalPesananCemilan()
    {
        $this->db->where('menu_kategori', 'Cemilan');
        return $this->db->count_all_results('v_order_detail');
    }

    // ✅ Total pesanan kategori Hidangan Utama
    public function getTotalPesananHidanganUtama()
    {
        $this->db->where('menu_kategori', 'Hidangan Utama');
        return $this->db->count_all_results('v_order_detail');
    }

    // ✅ Total pesanan kategori Hidangan Penutup
    public function getTotalPesananHidanganPenutup()
    {
        $this->db->where('menu_kategori', 'Hidangan Penutup');
        return $this->db->count_all_results('v_order_detail');
    }

    // ✅ Total pendapatan kategori Cemilan
    public function getTotalPendapatanCemilan()
    {
        $this->db->select_sum('total_harga');
        $this->db->where('menu_kategori', 'Cemilan');
        $query = $this->db->get('v_order_detail');
        $row = $query->row();
        return $row ? $row->total_harga : 0;
    }

    // ✅ Total pendapatan kategori Hidangan Utama
    public function getTotalPendapatanHidanganUtama()
    {
        $this->db->select_sum('total_harga');
        $this->db->where('menu_kategori', 'Hidangan Utama');
        $query = $this->db->get('v_order_detail');
        $row = $query->row();
        return $row ? $row->total_harga : 0;
    }

    // ✅ Total pendapatan kategori Hidangan Penutup
    public function getTotalPendapatanHidanganPenutup()
    {
        $this->db->select_sum('total_harga');
        $this->db->where('menu_kategori', 'Hidangan Penutup');
        $query = $this->db->get('v_order_detail');
        $row = $query->row();
        return $row ? $row->total_harga : 0;
    }

    // ==========================================================
    // 🧮 TOTAL GABUNGAN UNTUK DAPUR (Cemilan + Utama + Penutup)
    // ==========================================================

    // ✅ Total seluruh pesanan untuk dapur
    public function getTotalPesananDapur()
    {
        return
            $this->getTotalPesananCemilan() +
            $this->getTotalPesananHidanganUtama() +
            $this->getTotalPesananHidanganPenutup();
    }

    // ✅ Total seluruh pendapatan untuk dapur
    public function getTotalPendapatanDapur()
    {
        return
            $this->getTotalPendapatanCemilan() +
            $this->getTotalPendapatanHidanganUtama() +
            $this->getTotalPendapatanHidanganPenutup();
    }
}