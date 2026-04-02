<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Checkout extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('template_front');
    }

    public function index()
    {
        $check = $this->check_stock_api();

        if (!$check['status']) {
            $this->session->set_flashdata('error', $check['message']);
            redirect('cart');
            exit;
        }

        redirect('checkout/review');
    }




    public function review()
    {
        // ================= CEK PINDAH MEJA =================
        $meja_baru = $this->input->get('meja');
        $meja_lama = $this->session->userdata('meja_id');

        if ($meja_baru) {

            // Jika belum ada meja aktif
            if (!$meja_lama) {
                $this->session->set_userdata('meja_id', $meja_baru);

                $this->db->where('meja_id', $meja_baru);
                $this->db->update('resto_meja', ['meja_status' => 1]);
            }

            // Jika meja berbeda → tampilkan halaman pindah
            elseif ($meja_lama != $meja_baru) {

                $data['meja_lama'] = $meja_lama;
                $data['meja_baru'] = $meja_baru;

                $this->load->view('akses_ditolak', $data);
                return; // hentikan proses review
            }
        }
        $cart_content = $this->cart->contents();

        if (!$cart_content) {
            redirect('/cart');
            return;
        }

        $total_qty   = 0;
        $total_waktu = 0;

        foreach ($cart_content as $key => $value) {
            $cart_content[$key]['subtotal'] =
                number_format($value['price'] * $value['qty'], 0, '', ',');

            $total_qty   += $value['qty'];
            $total_waktu += $value['waktu'];
        }

        // ================= AMBIL SEMUA MEJA =================
        $meja_db = $this->db
            ->order_by('meja_id', 'ASC')
            ->get('resto_meja')
            ->result();

        // ================= OLAH DATA MEJA UNTUK PARSER =================
        $resto_meja = [];

        $mejaQR = $this->session->userdata('meja_id');

        foreach ($meja_db as $meja) {

            $selected = ($meja->meja_id == $mejaQR) ? 'selected' : '';

            if ($meja->meja_status == 1) {

                if ($meja->meja_id == $mejaQR) {
                    $resto_meja[] = [
                        'meja_value'    => $meja->meja_id,
                        'meja_disabled' => '',
                        'meja_selected' => $selected,
                        'meja_label'    => 'Meja ' . $meja->meja_id . ' (Sedang Dipakai)',
                    ];
                } else {
                    $resto_meja[] = [
                        'meja_value'    => '',
                        'meja_disabled' => 'disabled',
                        'meja_selected' => '',
                        'meja_label'    => 'Meja ' . $meja->meja_id . ' (Sedang Dipakai)',
                    ];
                }
            } else {
                $resto_meja[] = [
                    'meja_value'    => $meja->meja_id,
                    'meja_disabled' => '',
                    'meja_selected' => $selected,
                    'meja_label'    => 'Meja ' . $meja->meja_id,
                ];
            }
        }

        // ================= DATA KE VIEW =================
        $this->data['resto_meja']         = $resto_meja;
        $this->data['cart_content']       = $cart_content;
        $this->data['cart_count']         = count($cart_content);
        $this->data['total_qty']          = $total_qty;
        $this->data['total_waktu']        = $total_waktu;
        $this->data['cart_total']         = $this->cart->total();
        $this->data['cart_total_format']  =
            number_format($this->cart->total(), 0, '', '.');

        $data['review_content'] = $this->parser
            ->parse('front/checkout/review_content.html', $this->data, true);

        $this->template_front
            ->display('front/checkout/review', $data);
    }

    public function pindah_meja()
    {
        $meja_lama = $this->input->post('meja_lama');
        $meja_baru = $this->input->post('meja_baru');

        // Nonaktifkan meja lama
        $this->db->where('meja_id', $meja_lama);
        $this->db->update('resto_meja', ['meja_status' => 0]);

        // Aktifkan meja baru
        $this->db->where('meja_id', $meja_baru);
        $this->db->update('resto_meja', ['meja_status' => 1]);

        // Hapus session lama
        $this->session->unset_userdata('meja_id');

        // Set session baru
        $this->session->set_userdata('meja_id', $meja_baru);

        redirect('checkout/review?meja=' . $meja_baru);
    }


    private function check_stock_api()
    {
        $cart = $this->cart->contents();

        if (!$cart) {
            return ['status' => false, 'message' => 'Keranjang kosong'];
        }

        $groupQty = [];
        foreach ($cart as $c) {
            if (!isset($groupQty[$c['id']])) {
                $groupQty[$c['id']] = 0;
            }
            $groupQty[$c['id']] += (int)$c['qty'];
        }

        foreach ($groupQty as $menu_id => $totalQty) {

            $menu = $this->db->get_where('resto_menu', [
                'menu_id' => $menu_id
            ])->row();

            if (!$menu) {
                return ['status' => false, 'message' => 'Menu tidak ditemukan'];
            }

            if ($totalQty > (int)$menu->stok_menu) {
                return [
                    'status' => false,
                    'message' => "Stok {$menu->menu_nama} hanya {$menu->stok_menu}"

                ];
            }
        }

        return ['status' => true];
    }




    public function check_stock()
    {
        $cart = $this->cart->contents();

        if (!$cart) {
            $this->output->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => false,
                    'message' => 'Keranjang kosong'
                ]));
            return;
        }

        // ================= GABUNG QTY ITEM YANG SAMA =================
        $groupQty = [];
        foreach ($cart as $c) {
            if (!isset($groupQty[$c['id']])) {
                $groupQty[$c['id']] = 0;
            }
            $groupQty[$c['id']] += (int)$c['qty']; // 🔒 pastikan integer
        }

        // ================= CEK STOK ADMIN =================
        foreach ($groupQty as $menu_id => $totalQty) {

            $menu = $this->db->get_where('resto_menu', [
                'menu_id' => $menu_id
            ])->row();

            if (!$menu) {
                $this->output->set_content_type('application/json')
                    ->set_output(json_encode([
                        'status' => false,
                        'message' => 'Menu tidak ditemukan'
                    ]));
                return;
            }

            // ================= PASTIKAN STOK INTEGER =================
            $stok = (int) $menu->stok_menu;

            // ================= JIKA QTY MELEBIHI STOK ADMIN =================
            if ($totalQty > $stok) {

                $this->output->set_content_type('application/json')
                    ->set_output(json_encode([
                        'status' => false,
                        'menu_id' => $menu_id,
                        'stok' => $stok,
                        'qty_pesan' => $totalQty,
                        'message' => "Stok menu {$menu->nama_menu} hanya {$stok}, sedangkan anda memesan {$totalQty}"
                    ]));
                return;
            }
        }

        // ================= SEMUA AMAN =================
        $this->output->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => true
            ]));
    }





    // public function dobooking()
    // {
    //     if ($this->input->post()) {
    //         $resto_order        = json_decode($this->input->post('resto_order'), true);
    //         $resto_order_detail = json_decode($this->input->post('resto_order_detail'), true);
    //         $this->db->insert('resto_order', $resto_order);
    //         $order_id = $this->db->insert_id();
    //         $res             = array();
    //         $res['order_id'] = $order_id;
    //         foreach ($resto_order_detail as $key => $value) {
    //             $value['order_id'] = $order_id;
    //             $this->db->insert('resto_order_detail', $value);
    //         }
    //         $this->cart->destroy();
    //         if ($this->input->is_ajax_request()) {
    //             header('Content-Type: application/json');
    //             echo json_encode($res);
    //         } else {
    //             opn($res);
    //         }
    //     }
    // }

    public function konfirmasi()
    {
        // =============================
        // 🔒 CEK STOK FINAL (ANTI BYPASS)
        // =============================
        $check = $this->check_stock_api();

        if (!$check['status']) {
            header('Content-Type: application/json');
            echo json_encode([
                'status'  => false,
                'message' => $check['message']
            ]);
            return;
        }

        if (!$this->input->post()) {
            return;
        }

        // =============================
        // 🔐 TRANSACTION START
        // =============================
        $this->db->trans_begin();

        $param   = $this->input->post(null, true);
        $meja_id = stripHTMLtags($param['resto_order']['meja_id']);

        // =============================
        // 🔥 LOCK & VALIDASI MEJA
        // =============================
        $meja = $this->db
            ->query("SELECT meja_status FROM resto_meja WHERE meja_id = ? FOR UPDATE", [$meja_id])
            ->row();
        $mejaSession = $this->session->userdata('meja_id');

        if (!$meja) {

            $this->db->trans_rollback();

            echo json_encode([
                'status'  => false,
                'message' => 'Meja tidak ditemukan'
            ]);
            return;
        }

        // Jika meja sudah dipakai DAN bukan meja dari session QR
        if ($meja->meja_status != 0 && $meja_id != $mejaSession) {

            $this->db->trans_rollback();

            echo json_encode([
                'status'  => false,
                'message' => 'Meja sudah digunakan, silakan pilih meja lain'
            ]);
            return;
        }

        // =============================
        // 🔥 SET MEJA JADI TERPAKAI
        // =============================
        // Hanya set jadi terpakai jika masih kosong
        if ($meja->meja_status == 0) {

            $this->db->where('meja_id', $meja_id);
            $this->db->update('resto_meja', [
                'meja_status' => 1,
                'meja_update' => date('Y-m-d H:i:s')
            ]);
        }

        // =============================
        // 📝 DATA ORDER
        // =============================
        $dataOrder = [
            'meja_id'       => $meja_id,
            'order_nama'    => strtoupper(stripHTMLtags(trim($param['resto_order']['nama']))),
            'order_tanggal' => date('Y-m-d'),
            'order_waktu'   => $param['resto_order']['total_waktu'],
            'order_qty'     => $param['resto_order']['total_qty'],
            'order_catatan' => $param['resto_order']['catatan'],
            'order_total'   => $param['resto_order']['total'],
            'order_status'  => 1, // BELUM BAYAR
            'order_update'  => date('Y-m-d H:i:s'),
        ];

        $this->db->insert('resto_order', $dataOrder);
        $order_id = $this->db->insert_id();

        // =============================
        // 🔁 DETAIL ORDER & STOK MENU
        // =============================
        $cart_content = $this->cart->contents();

        foreach ($cart_content as $value) {

            // 🔒 LOCK MENU
            $menu = $this->db
                ->query("SELECT stok_menu FROM resto_menu WHERE menu_id = ? FOR UPDATE", [$value['id']])
                ->row();

            if (!$menu || $value['qty'] > $menu->stok_menu) {

                // ❌ BALIKIN MEJA KE KOSONG
                $this->db->where('meja_id', $meja_id);
                $this->db->update('resto_meja', [
                    'meja_status' => 0,
                    'meja_update' => date('Y-m-d H:i:s')
                ]);

                $this->db->trans_rollback();

                header('Content-Type: application/json');
                echo json_encode([
                    'status'  => false,
                    'message' => 'Stok menu berubah / tidak mencukupi'
                ]);
                return;
            }

            $subtotal = $value['qty'] * $value['price'];

            // ✅ INSERT DETAIL
            $this->db->insert('resto_order_detail', [
                'order_id'              => $order_id,
                'menu_id'               => $value['id'],
                'order_detail_harga'    => $value['price'],
                'order_detail_qty'      => $value['qty'],
                'order_detail_waktu'    => $value['waktu'],
                'order_detail_subtotal' => $subtotal,
                'order_detail_status'   => 1,
                'order_detail_update'   => date('Y-m-d H:i:s'),
            ]);

            // ✅ KURANGI STOK
            $this->db->set('stok_menu', 'stok_menu - ' . (int)$value['qty'], false);
            $this->db->where('menu_id', $value['id']);
            $this->db->update('resto_menu');
        }

        // =============================
        // 🔐 FINAL COMMIT / ROLLBACK
        // =============================
        if ($this->db->trans_status() === false) {

            // ❌ BALIKIN MEJA
            $this->db->where('meja_id', $meja_id);
            $this->db->update('resto_meja', [
                'meja_status' => 0,
                'meja_update' => date('Y-m-d H:i:s')
            ]);

            $this->db->trans_rollback();

            header('Content-Type: application/json');
            echo json_encode([
                'status'  => false,
                'message' => 'Gagal menyimpan order'
            ]);
            return;
        }

        // ✅ COMMIT
        $this->db->trans_commit();

        // 🧹 KOSONGKAN CART
        $this->cart->destroy();

        // ✅ RESPONSE SUKSES
        header('Content-Type: application/json');
        echo json_encode([
            'status'   => true,
            'order_id' => $order_id
        ]);
    }

    public function hapus_order($order_id)
    {
        if (!$order_id) return;

        $this->db->trans_begin();

        // 🔒 LOCK ORDER
        $order = $this->db
            ->query("SELECT meja_id FROM resto_order WHERE order_id = ? FOR UPDATE", [$order_id])
            ->row();

        if (!$order) {
            $this->db->trans_rollback();
            return false;
        }

        $meja_id = $order->meja_id;

        // =============================
        // 🔁 KEMBALIKAN STOK MENU
        // =============================
        $details = $this->db
            ->query("SELECT menu_id, order_detail_qty 
                 FROM resto_order_detail 
                 WHERE order_id = ? FOR UPDATE", [$order_id])
            ->result();

        foreach ($details as $d) {
            $this->db->set('stok_menu', 'stok_menu + ' . (int)$d->order_detail_qty, false);
            $this->db->where('menu_id', $d->menu_id);
            $this->db->update('resto_menu');
        }

        // =============================
        // ❌ HAPUS DETAIL ORDER
        // =============================
        $this->db->where('order_id', $order_id);
        $this->db->delete('resto_order_detail');

        // =============================
        // ❌ HAPUS ORDER
        // =============================
        $this->db->where('order_id', $order_id);
        $this->db->delete('resto_order');

        // =============================
        // 🔓 BUKA KEMBALI MEJA
        // =============================
        $this->db->where('meja_id', $meja_id);
        $this->db->update('resto_meja', [
            'meja_status' => 0,
            'meja_update' => date('Y-m-d H:i:s')
        ]);

        // =============================
        // 🔐 FINAL
        // =============================
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        }

        $this->db->trans_commit();
        return true;
    }




    public function selesai($order_id = null)
    {
        // $this->db->where('order_id', $order_id);
        // $resto_order = $this->db->get('resto_order')->result();
        // if ($resto_order) {
        //     foreach ($resto_order as $key => $value) {
        //         $this->db->where('order_id', $value->order_id);
        //         $this->db->join('resto_menu', 'resto_menu.menu_id = resto_order_detail.menu_id', 'left');
        //         $value->resto_order_detail = $this->db->get('resto_order_detail')->result();
        //     }
        //     $this->data['resto_order'] = $resto_order;
        //     $data['detail_content']    = $this->parser->parse('front/checkout/detail_content.html', $this->data, true);
        // } else {
        //     $data['detail_content'] = $this->parser->parse('front/checkout/detail_content_empty.html', $this->data, true);
        // }
        // $data['class'] = 'woocommerce-checkout';
        $data['listOrder'] = $this->db->get_where('v_order_detail', array('order_id' => $order_id))->result();
        $data['Order']     = $this->db->get_where('v_order', array('order_id' => $order_id))->row();
        $data['listOrder'] = $this->db->get_where('v_order_detail', array('order_id' => $order_id))->result();
        $this->template_front->display('front/checkout/detail_v', $data);
    }

    public function bill_jpg($order_id)
    {
        // =====================================================
        // 1️⃣ AMBIL DATA ORDER + MEJA + WAKTU KONFIRMASI
        // =====================================================
        $order = $this->db
            ->select('
            resto_order.order_id,
            resto_order.order_nama,
            resto_order.order_tanggal,
            resto_order.order_update,
            resto_order.order_total,
            resto_meja.meja_nama
        ')
            ->from('resto_order')
            ->join('resto_meja', 'resto_meja.meja_id = resto_order.meja_id', 'left')
            ->where('resto_order.order_id', $order_id)
            ->get()
            ->row();

        if (!$order) show_404();

        $detail = $this->db
            ->get_where('resto_order_detail', ['order_id' => $order_id])
            ->result();

        // =====================================================
        // 2️⃣ SETUP IMAGE
        // =====================================================
        $width  = 800;
        $height = 420 + (count($detail) * 32);
        $image  = imagecreatetruecolor($width, $height);

        // Warna
        $white = imagecolorallocate($image, 255, 255, 255);
        $black = imagecolorallocate($image, 0, 0, 0);
        $dark  = imagecolorallocate($image, 40, 40, 40);
        $gray  = imagecolorallocate($image, 140, 140, 140);
        $line  = imagecolorallocate($image, 200, 200, 200);

        imagefill($image, 0, 0, $white);

        // Font
        $font_path = FCPATH . 'backend/assets/fonts/arial.ttf';
        if (!file_exists($font_path)) {
            imagedestroy($image);
            show_error('Font tidak ditemukan');
        }

        $font      = 15;
        $font_bold = 18;
        $y = 40;

        // =====================================================
        // 3️⃣ HEADER
        // =====================================================
        imagettftext($image, 22, 0, 280, $y, $dark, $font_path, 'BILL PEMBAYARAN');
        $y += 15;
        imageline($image, 20, $y, 780, $y, $line);
        $y += 30;

        // =====================================================
        // 4️⃣ INFO ORDER (2 KOLOM)
        // =====================================================
        $waktu_konfirmasi = date('d-m-Y H:i', strtotime($order->order_update));

        // Kiri
        imagettftext($image, $font, 0, 20, $y, $dark, $font_path, 'No Order');
        imagettftext($image, $font, 0, 150, $y, $dark, $font_path, ': ' . $order->order_id);

        imagettftext($image, $font, 0, 20, $y + 28, $dark, $font_path, 'Tanggal');
        imagettftext($image, $font, 0, 150, $y + 28, $dark, $font_path, ': ' . tgl_indo($order->order_tanggal));

        // Kanan
        imagettftext($image, $font, 0, 420, $y, $dark, $font_path, 'Konfirmasi');
        imagettftext($image, $font, 0, 560, $y, $dark, $font_path, ': ' . $waktu_konfirmasi);

        imagettftext($image, $font, 0, 420, $y + 28, $dark, $font_path, 'Meja');
        imagettftext($image, $font, 0, 560, $y + 28, $dark, $font_path, ': ' . ($order->meja_nama ?? '-'));

        $y += 80;

        imagettftext(
            $image,
            $font,
            0,
            20,
            $y,
            $dark,
            $font_path,
            'Nama Pemesan : ' . $order->order_nama
        );
        $y += 30;

        // =====================================================
        // 5️⃣ HEADER TABEL MENU
        // =====================================================
        imageline($image, 20, $y, 780, $y, $line);
        $y += 25;

        imagettftext($image, $font, 0, 20, $y, $dark, $font_path, 'Menu');
        imagettftext($image, $font, 0, 600, $y, $dark, $font_path, 'Subtotal');

        $y += 20;
        imageline($image, 20, $y, 780, $y, $line);
        $y += 28;

        // =====================================================
        // 6️⃣ DETAIL MENU
        // =====================================================
        foreach ($detail as $d) {
            imagettftext(
                $image,
                $font,
                0,
                20,
                $y,
                $black,
                $font_path,
                $d->menu_nama . ' x' . $d->order_detail_qty
            );

            imagettftext(
                $image,
                $font,
                0,
                600,
                $y,
                $black,
                $font_path,
                'Rp ' . number_format($d->order_detail_subtotal, 0, '', ',')
            );

            $y += 28;
        }

        // =====================================================
        // 7️⃣ TOTAL
        // =====================================================
        $y += 5;
        imageline($image, 20, $y, 780, $y, $line);
        $y += 35;

        imagettftext($image, $font_bold, 0, 20, $y, $dark, $font_path, 'TOTAL PEMBAYARAN');
        imagettftext(
            $image,
            $font_bold,
            0,
            560,
            $y,
            $dark,
            $font_path,
            'Rp ' . number_format($order->order_total, 0, '', ',')
        );

        // =====================================================
        // 8️⃣ FOOTER
        // =====================================================
        $y += 50;
        imageline($image, 260, $y, 540, $y, $line);
        $y += 30;
        imagettftext(
            $image,
            $font,
            0,
            100, // ← digeser ke kiri
            $y,
            $gray,
            $font_path,
            'Terima kasih atas kepercayaan Anda, selamat menikmati hidangan '
        );



        // =====================================================
        // 9️⃣ OUTPUT JPG
        // =====================================================
        if (ob_get_contents()) ob_end_clean();

        header('Content-Type: image/jpeg');
        header('Content-Disposition: attachment; filename="Bill_Order_' . $order_id . '.jpg"');
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Pragma: no-cache');
        header('Expires: 0');

        imagejpeg($image, null, 90);
        imagedestroy($image);
        exit;
    }
}
/* Location: ./application/controller/front/Checkout.php */