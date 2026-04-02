<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Monitoring extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->cek_auth_operator();
        $this->load->library('template');
        $this->load->model('kasir/monitoring_m');
    }

    public function index()
    {
        // Ambil role user dari session
        $role = $this->session->userdata('role');

        // Data meja
        $data['listData'] = $this->db->get('resto_meja')->result();

        // Tentukan kategori yang boleh tampil berdasarkan role
        if ($role == 'dapur') {
            $data['kategori_akses'] = ['Camilan', 'Hidangan Penutup', 'Hidangan Utama'];
        } elseif ($role == 'barista') {
            $data['kategori_akses'] = ['Minum'];
        } elseif ($role == 'kasir') {
            $data['kategori_akses'] = []; // Semua kategori
        } else {
            $data['kategori_akses'] = [];
        }

        $this->template->display('kasir/monitoring/view', $data);
    }

    public function data_list()
    {
        $List = $this->monitoring_m->get_datatables();
        $data = array();
        $no   = isset($_POST['start']) ? (int)$_POST['start'] : 0;

        foreach ($List as $r) {
            $no++;
            $row             = array();
            $order_detail_id = $r->order_detail_id;

            if ($r->order_detail_status == 1) {
                $row[] = '<input type="checkbox" name="checked_id[]" class="checkbox" value="' . $order_detail_id . '"/>';
            } else {
                $row[] = '';
            }

            $row[] = $no;
            $row[] = $r->meja_nama;
            $row[] = $r->menu_kode;
            $row[] = $r->menu_nama; // hanya tampil nama menu
            $row[] = number_format($r->order_detail_qty, 0, '', ',');
            $row[] = number_format($r->order_detail_harga, 0, '', ',');
            $row[] = $r->order_detail_waktu . ' Menit';
            $row[] = number_format($r->order_detail_subtotal, 0, '', ',');

            if ($r->order_detail_status == 1) {
                $status = '<span class="label label-primary">Baru</span>';
            } else {
                $status = '<span class="label label-success">Selesai</span>';
            }

            $row[]  = $status;
            $data[] = $row;
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->monitoring_m->count_all(),
            "recordsFiltered" => $this->monitoring_m->count_filtered(),
            "data"            => $data,
        );

        echo json_encode($output);
    }

    public function prosesselesai()
    {
        header("Content-type:application/json");
        $post = $this->input->post('checked_id');
        if (is_array($post) && count($post) > 0) {
            foreach ($post as $order_detail_id) {
                $data = array(
                    'order_detail_status' => 2,
                    'order_detail_update' => date('Y-m-d H:i:s'),
                );

                $this->db->where('order_detail_id', $order_detail_id);
                $this->db->update('resto_order_detail', $data);
            }
            $response['status'] = 'success';
        } else {
            $response['status'] = 'nodata';
        }

        echo json_encode($response);
    }
}
