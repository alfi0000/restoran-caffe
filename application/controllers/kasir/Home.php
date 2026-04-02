<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Load library Template dan model Home_m
        $this->load->library('template');
        $this->load->model('kasir/Home_m');
    }

    public function index()
    {
        $data['TotalPesanan'] = $this->Home_m->getTotalPesanan();
        $data['TotalMinuman'] = $this->Home_m->getTotalMinuman();
        $data['TotalCemilan'] = $this->Home_m->getTotalCemilan();
        $data['Pendapatan']   = $this->Home_m->getTotalPendapatan();

        // Panggil tampilan lewat library Template
        $this->template->display('kasir/home_v', $data);
    }
}
