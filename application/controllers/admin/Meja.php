<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Meja extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->cek_auth_admin();
        $this->load->library('template');
        $this->load->model('admin/meja_m');
    }

    public function index()
    {
        $this->template->display('admin/master/meja_v');
    }

    public function data_list()
    {
        $List = $this->meja_m->get_datatables();
        $data = array();
        $no   = $_POST['start'];

        foreach ($List as $r) {
            $no++;
            $row     = array();
            $meja_id = $r->meja_id;
            $row[] = '
<a title="Edit Data" href="javascript:void(0)" onclick="edit_data(' . "'" . $meja_id . "'" . ')">
    <i class="icon-pencil"></i>
</a>

<a onclick="hapusData(' . $meja_id . ')" title="Delete Data">
    <i class="icon-close"></i>
</a>

<a href="' . site_url('admin/meja/download_barcode/' . $meja_id) . '" title="Download QR">
    <i class="fa fa-qrcode"></i>
</a>
';
            $row[]  = $no;
            $row[]  = $r->meja_nama;
            $data[] = $row;
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->meja_m->count_all(),
            "recordsFiltered" => $this->meja_m->count_filtered(),
            "data"            => $data,
        );

        echo json_encode($output);
    }
    public function barcode($id)
    {
        $this->load->library('ciqrcode');

        $meja = $this->meja_m->select_by_id($id)->row();

        if (!$meja) {
            show_404();
        }

        $config['cacheable']    = true;
        $config['cachedir']     = './assets/';
        $config['errorlog']     = './assets/';
        $config['imagedir']     = './assets/qrcode/';
        $config['quality']      = true;
        $config['size']         = 1024;
        $config['black']        = array(224, 255, 255);
        $config['white']        = array(70, 130, 180);

        $this->ciqrcode->initialize($config);

        $image_name = 'meja_' . $meja->meja_id . '.png';

        $params['data'] = site_url('checkout/review?meja=' . $meja->meja_id);
        $params['level'] = 'H';
        $params['size'] = 10;
        $params['savename'] = FCPATH . $config['imagedir'] . $image_name;

        $this->ciqrcode->generate($params);

        echo '<img src="' . base_url('assets/qrcode/' . $image_name) . '">';
    }

    public function download_barcode($id)
    {
        $this->load->library('ciqrcode');

        $meja = $this->meja_m->select_by_id($id)->row();

        if (!$meja) {
            show_404();
        }

        $url = base_url('?meja=' . $meja->meja_id);

        header("Content-Type: image/png");
        header("Content-Disposition: attachment; filename=QR-Meja-" . $meja->meja_id . ".png");

        $params['data'] = $url;
        $params['level'] = 'H';
        $params['size'] = 10;

        $this->ciqrcode->generate($params);
    }

    public function test_qr()
    {
        $this->load->library('ciqrcode');

        $params['data'] = "TEST QR BERHASIL";
        $params['level'] = 'H';
        $params['size'] = 10;

        $this->ciqrcode->generate($params);
    }

    public function savedata()
    {
        $this->meja_m->insert_data();
    }

    public function get_data($id)
    {
        $data = $this->meja_m->select_by_id($id)->row();
        echo json_encode($data);
    }

    public function updatedata()
    {
        $this->meja_m->update_data();
    }

    public function deletedata($id)
    {
        $this->meja_m->delete_data($id);
    }
}
/* Location: ./application/controller/admin/Meja.php */