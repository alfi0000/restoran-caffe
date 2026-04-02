<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bill extends CI_Controller
{
    public function bill_jpg($order_id)
    {
        $order = $this->db
            ->get_where('resto_order', ['order_id' => $order_id])
            ->row();

        if (!$order) {
            show_404();
        }

        $detail = $this->db
            ->get_where('resto_order_detail', ['order_id' => $order_id])
            ->result();

        $width  = 800;
        $height = 600 + (count($detail) * 30);
        $image  = imagecreatetruecolor($width, $height);

        $white = imagecolorallocate($image, 255, 255, 255);
        $black = imagecolorallocate($image, 0, 0, 0);
        $gray  = imagecolorallocate($image, 120, 120, 120);

        imagefill($image, 0, 0, $white);

        $font = 5;
        $y = 20;

        imagestring($image, $font, 320, $y, 'BILL PEMBAYARAN', $black);
        $y += 40;

        imagestring($image, $font, 20, $y, 'No Order : ' . $order->order_id, $black);
        $y += 25;
        imagestring($image, $font, 20, $y, 'Nama     : ' . $order->order_nama, $black);
        $y += 25;
        imagestring($image, $font, 20, $y, 'Meja     : ' . $order->meja_nama, $black);
        $y += 30;

        imagestring($image, $font, 20, $y, '------------------------------', $gray);
        $y += 20;

        foreach ($detail as $d) {
            imagestring($image, $font, 20, $y, $d->menu_nama . ' x' . $d->order_detail_qty, $black);
            imagestring($image, $font, 600, $y, 'Rp ' . number_format($d->order_detail_subtotal, 0, '', ','), $black);
            $y += 25;
        }

        $y += 20;
        imagestring($image, $font, 20, $y, 'TOTAL', $black);
        imagestring($image, $font, 600, $y, 'Rp ' . number_format($order->order_total, 0, '', ','), $black);

        header('Content-Type: image/jpeg');
        header('Content-Disposition: attachment; filename="Bill_Order_' . $order_id . '.jpg"');

        imagejpeg($image, null, 90);
        imagedestroy($image);
    }
}