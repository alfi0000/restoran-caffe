<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Monitoring_m extends CI_Model
{
    public $table = 'v_order_detail';
    public $column_order = array(
        null,
        'meja_nama',
        'menu_kode',
        'menu_nama',
        'order_detail_qty',
        'order_detail_harga',
        'order_detail_waktu',
        'order_detail_subtotal',
        'order_detail_status'
    );
    public $column_search = array(
        'meja_nama',
        'menu_kode',
        'menu_nama'
    );
    public $order = array('order_detail_id' => 'DESC');

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query()
    {
        $this->db->from($this->table);

        // 🔹 Ambil role user dari session
        $role = $this->session->userdata('role');

        // 🔹 Filter kategori berdasarkan role (pakai kategori_id)
        if ($role == 'dapur') {
            $this->db->where_in('kategori_id', [1, 2, 3]); // camilan, hidangan penutup, hidangan utama
        } elseif ($role == 'barista') {
            $this->db->where('kategori_id', 4); // minum
        } elseif ($role == 'kasir') {
            // Kasir melihat semua kategori → tidak difilter
        }

        // 🔹 Filter meja (jika ada input)
        if (!empty($this->input->post('lstMeja'))) {
            $this->db->where('meja_nama', $this->input->post('lstMeja'));
        }

        // 🔹 Filter status detail (jika ada input)
        if (!empty($this->input->post('lstStatus'))) {
            $this->db->where('order_detail_status', $this->input->post('lstStatus'));
        }

        // 🔹 Searching (global search datatables)
        if (!empty($_POST['search']['value'])) {
            $search_value = $_POST['search']['value'];
            $this->db->group_start();
            foreach ($this->column_search as $item) {
                $this->db->or_like($item, $search_value);
            }
            $this->db->group_end();
        }

        // 🔹 Urutkan data terbaru di atas
        if (isset($_POST['order'])) {
            $this->db->order_by(
                $this->column_order[$_POST['order'][0]['column']],
                $_POST['order'][0]['dir']
            );
        } else {
            foreach ($this->order as $key => $val) {
                $this->db->order_by($key, $val);
            }
        }
    }

    public function get_datatables()
    {
        $this->_get_datatables_query();

        if (isset($_POST['length']) && $_POST['length'] != -1) {
            $this->db->limit((int)$_POST['length'], (int)$_POST['start']);
        }

        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
}
