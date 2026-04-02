<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('template_front');
        $this->load->library('cart');
    }

    public function index()
    {
        $mejaQR = $this->input->get('meja');
        $mejaSession = $this->session->userdata('meja_id');

        if ($mejaQR) {

            // 🔒 Jika sudah ada meja di session dan berbeda → TOLAK
            if ($mejaSession && $mejaSession != $mejaQR) {

                $data['meja_lama'] = $mejaSession;
                $data['meja_baru'] = $mejaQR;

                $this->load->view('front/meja_terkunci_v', $data);
                return; // HENTIKAN PROSES
            }

            // Jika belum ada session → set
            if (!$mejaSession) {
                $this->session->set_userdata('meja_id', $mejaQR);
            }
        }

        $data['meja_id'] = $this->session->userdata('meja_id');
        $data['listMenu']   = $this->db->order_by('menu_nama', 'asc')->get('v_menu')->result();
        $data['listSlider'] = $this->db->order_by('slider_id', 'asc')->get('resto_slider')->result();

        $this->template_front->display('front/home_v', $data);
    }
}
/* Location: ./application/controller/Home.php */