<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Load library template dan model
        $this->load->library('template');
        $this->load->model('OrderModel');

        // Cek session: hanya bisa diakses oleh level Dapur
        if ($this->session->userdata('level') != 'Dapur') {
            redirect('login');
        }
    }

    public function index()
    {
        // ================================
        // 🍳 Bagian DAPUR (kategori makanan)
        // ================================

        // Total semua pesanan makanan (Cemilan + Hidangan Utama + Hidangan Penutup)
        $data['TotalPesanan'] = $this->OrderModel->getTotalPesananDapur();

        // Total menu per kategori (ambil dari v_menu)
        $data['TotalCemilan'] = $this->OrderModel->getTotalCemilan();
        $data['TotalHidanganUtama'] = $this->OrderModel->getTotalHidanganUtama();
        $data['TotalHidanganPenutup'] = $this->OrderModel->getTotalHidanganPenutup();

        // Total pendapatan dari semua kategori makanan
        $data['Pendapatan'] = $this->OrderModel->getTotalPendapatanDapur();

        // ================================
        // ✅ Tampilkan halaman
        // ================================
        $this->template->display('dapur/home_v', $data);
    }
}
