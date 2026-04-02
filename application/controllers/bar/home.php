<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('template');
        if ($this->session->userdata('level') != 'Bar') {
            redirect('login');
        }
        $this->load->model('OrderModel');
    }

    public function index()
    {
        // Dari v_menu → jumlah menu minuman yang tersedia
        $data['TotalMinum'] = $this->OrderModel->getTotalMinum();

        // Dari v_order_detail → jumlah pesanan kategori minum
        $data['TotalPesananMinum'] = $this->OrderModel->getTotalPesananMinum();

        // Total pendapatan dari kategori minum
        $data['Pendapatan'] = $this->OrderModel->getTotalPendapatanMinum();

        // Jika tidak digunakan, beri 0 agar tidak error
        $data['TotalCemilan'] = 0;

        $this->template->display('bar/home_v', $data);
    }
}