<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home_m extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    // Total semua pesanan
    public function getTotalPesanan()
    {
        return $this->db->count_all_results('resto_order_detail');
    }

    // Total minuman (kategori_nama = 'MINUM')
    public function getTotalMinuman()
    {
        $this->db->from('resto_order_detail d');
        $this->db->join('resto_menu m', 'm.menu_id = d.menu_id');
        $this->db->join('resto_kategori k', 'k.kategori_id = m.kategori_id');
        $this->db->where('UPPER(k.kategori_nama)', 'MINUM'); // gunakan huruf besar biar aman
        return $this->db->count_all_results();
    }

    // Total cemilan (kategori_nama = 'CAMILAN')
    public function getTotalCemilan()
    {
        $this->db->from('resto_order_detail d');
        $this->db->join('resto_menu m', 'm.menu_id = d.menu_id');
        $this->db->join('resto_kategori k', 'k.kategori_id = m.kategori_id');
        $this->db->where('UPPER(k.kategori_nama)', 'CAMILAN');
        return $this->db->count_all_results();
    }

    // Total pendapatan (jumlah subtotal)
    public function getTotalPendapatan()
    {
        $this->db->select_sum('order_detail_subtotal');
        $query = $this->db->get('resto_order_detail');
        return $query->row()->order_detail_subtotal ?? 0;
    }
}