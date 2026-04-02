<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menuorder extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('template_front');
        $this->load->model('front/menuorder_m');
        $this->load->model('front/order_m'); // model order harus ada
    }

    public function index()
    {
        redirect(site_url('my_error'));
    }

    public function detail($menu_seo = null)
    {
        if (!$menu_seo) {
            show_404();
        }

        $detail = $this->db
            ->get_where('v_menu', ['menu_seo' => $menu_seo])
            ->row();

        if (!$detail) {
            show_404();
        }

        $data['detail'] = $detail;

        $this->template_front->display('front/menuorder_v', $data);
    }

    /**
     * Fungsi konfirmasi pesanan dari halaman detail menu.
     * - Mengurangi stok menu sesuai jumlah yang dipesan
     * - Menyimpan data order ke tabel order
     */
    public function konfirmasiPesanan()
    {
        $menu_id = $this->input->post('menu_id');
        $qty     = (int) $this->input->post('qty');

        if ($qty < 1) {
            $qty = 1;
        }

        // Ambil detail menu berdasarkan ID
        $menu = $this->menuorder_m->getMenuById($menu_id);

        if ($menu) {
            if ($menu->stok_menu >= $qty) {
                // Kurangi stok menu
                $stok_baru = $menu->stok_menu - $qty;
                $this->menuorder_m->updateStokMenu($menu_id, $stok_baru);

                // Simpan data pesanan ke tabel order
                $data_order = [
                    'menu_id'   => $menu_id,
                    'jumlah'    => $qty,
                    'status'    => 'Dikonfirmasi',
                    'tanggal'   => date('Y-m-d H:i:s')
                ];
                $this->order_m->insertOrder($data_order);

                $this->session->set_flashdata('success', 'Pesanan berhasil dikonfirmasi dan stok telah diperbarui.');
            } else {
                $this->session->set_flashdata('error', 'Stok tidak mencukupi untuk pesanan ini.');
            }
        } else {
            $this->session->set_flashdata('error', 'Menu tidak ditemukan.');
        }

        redirect(site_url('front/menuorder/detail/' . $menu->menu_seo));
    }


    // Di controller MenuOrder.php
    public function addToCart()
    {
        $menu_id = $this->input->post('id');
        $qty = (int) $this->input->post('qty');

        $menu = $this->MenuModel->getMenuById($menu_id);
        if (!$menu) {
            echo json_encode(['status' => 'error', 'message' => 'Menu tidak ditemukan.']);
            return;
        }

        if ($menu->stok_menu < $qty) {
            echo json_encode(['status' => 'error', 'message' => 'Stok tidak cukup.']);
            return;
        }

        // Lanjutkan proses tambah ke keranjang
        $this->CartModel->add($menu_id, $qty);

        echo json_encode(['status' => 'success']);
    }
}
