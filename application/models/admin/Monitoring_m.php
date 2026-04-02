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
        'menu_nama',
        'order_detail_qty',
        'order_detail_harga',
        'order_detail_waktu',
        'order_detail_subtotal',
        'order_detail_status'
    );


    // 🔧 Default urutan terbaru di atas
    public $order = array('order_detail_id' => 'DESC');

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query()
    {
        $this->db->from($this->table);

        $lstMeja   = $this->input->post('lstMeja');
        $lstStatus = $this->input->post('lstStatus');

        // ================= FILTER MEJA =================
        if (!empty($lstMeja)) {
            // Lebih aman pakai meja_id kalau ada
            $this->db->where('meja_id', $lstMeja);
        }

        // ================= FILTER STATUS =================
        if ($lstStatus == '1') {
            // Status Baru
            $this->db->where('order_detail_status', 1);
        } elseif ($lstStatus == '2') {
            // Status Selesai
            $this->db->where('order_detail_status', 2);
        }

        // ================= SEARCHING =================
        if (!empty($_POST['search']['value'])) {
            $search_value = $_POST['search']['value'];
            $this->db->group_start();
            foreach ($this->column_search as $item) {
                $this->db->or_like($item, $search_value);
            }
            $this->db->group_end();
        }

        // ==========================================================
        // 🔥 PRIORITAS MENU SAMA + STATUS BARU
        // ==========================================================
        if ($lstStatus == '3') {

            // Hanya ambil status Baru
            $this->db->where('order_detail_status', 1);

            // Hitung jumlah menu yang sama
            $this->db->select("{$this->table}.*, 
            COUNT(menu_nama) OVER (PARTITION BY menu_nama) as total_menu", false);

            // Urutkan berdasarkan jumlah terbanyak
            $this->db->order_by('total_menu', 'DESC');

            // Kelompokkan berdasarkan nama menu
            $this->db->order_by('menu_nama', 'ASC');

            // Terbaru di dalam grup
            $this->db->order_by('order_detail_id', 'DESC');
        } else {

            // Default: Baru tetap di atas
            $this->db->order_by('order_detail_status', 'ASC');
            $this->db->order_by('order_detail_id', 'DESC');
        }

        // ================= SORTING DARI DATATABLE =================
        if (isset($_POST['order'])) {
            $this->db->order_by(
                $this->column_order[$_POST['order'][0]['column']],
                $_POST['order'][0]['dir']
            );
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
