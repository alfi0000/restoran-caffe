<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Monitoring extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->cek_auth_operator();
        $this->load->library('template');
        $this->load->model('bar/Monitoring_m');
    }

    public function index()
    {
        $role = strtolower($this->session->userdata('level'));

        // Ambil semua kategori
        $kategori = $this->db->get('resto_kategori')->result();

        $idCamilan = null;
        $idPenutup = null;
        $idUtama   = null;
        $idMinuman = null;

        // Mapping nama → kategori_id
        foreach ($kategori as $k) {
            if ($k->kategori_nama == 'Camilan')           $idCamilan = $k->kategori_id;
            if ($k->kategori_nama == 'Hidangan Penutup')  $idPenutup = $k->kategori_id;
            if ($k->kategori_nama == 'Hidangan Utama')    $idUtama   = $k->kategori_id;
            if ($k->kategori_nama == 'Minuman')          $idMinuman = $k->kategori_id;
        }

        // Tentukan kategori akses berdasarkan role (PAKAI ID BUKAN NAMA)
        if ($role == 'dapur') {
            $data['kategori_akses'] = [$idCamilan, $idPenutup, $idUtama];
        } elseif ($role == 'bar') {
            $data['kategori_akses'] = [$idMinuman];
        } elseif ($role == 'kasir') {
            $data['kategori_akses'] = []; // Semua kategori
        }

        $this->template->display('dapur/monitoring/view', $data);
    }


    public function data_list()
    {
        // Ambil level user
        $level = strtolower(trim($this->session->userdata('level')));

        // Tentukan kategori berdasarkan level
        if ($level === 'bar') {
            $kategori_akses = ['MINUM'];
        } elseif ($level === 'dapur') {
            $kategori_akses = ['CAMILAN', 'HIDANGAN UTAMA', 'HIDANGAN PENUTUP'];
        } else {
            $kategori_akses = [];
        }

        // Ambil data dari model dengan filter kategori
        $List = $this->Monitoring_m->get_datatables($kategori_akses);
        $data = [];
        $no   = isset($_POST['start']) ? (int)$_POST['start'] : 0;

        foreach ($List as $r) {
            $no++;
            $row = [];

            if ($r->order_detail_status == 1) {
                $row[] = '<input type="checkbox" name="checked_id[]" class="checkbox" value="' . $r->order_detail_id . '"/>';
            } else {
                $row[] = '';
            }

            $row[] = $no;
            $row[] = $r->meja_nama;
            $row[] = $r->menu_kode;
            $row[] = $r->menu_nama;
            $row[] = number_format($r->order_detail_qty, 0, '', ',');
            $row[] = number_format($r->order_detail_harga, 0, '', ',');
            $row[] = date('d-m-Y H:i', strtotime($r->order_detail_update));
            // $row[] = $r->order_detail_waktu . ' Menit';
            $row[] = number_format($r->order_detail_subtotal, 0, '', ',');

            $status = ($r->order_detail_status == 1)
                ? '<span class="label label-primary">Baru</span>'
                : '<span class="label label-success">Selesai</span>';

            $row[] = $status;
            $data[] = $row;
        }

        $output = [
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->Monitoring_m->count_all(),
            "recordsFiltered" => $this->Monitoring_m->count_filtered($kategori_akses),
            "data"            => $data,
        ];

        echo json_encode($output);
    }

    public function prosesselesai()
    {
        header("Content-type:application/json");
        $post = $this->input->post('checked_id');

        if (is_array($post) && count($post) > 0) {
            foreach ($post as $order_detail_id) {
                $data = [
                    'order_detail_status' => 2,
                    'order_detail_update' => date('Y-m-d H:i:s'),
                ];

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
