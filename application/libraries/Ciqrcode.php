<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ciqrcode
{

    public function __construct()
    {
        include_once APPPATH . 'libraries/phpqrcode/qrlib.php';
    }

    public function generate($params = array())
    {
        if (empty($params['data'])) {
            return false;
        }

        $data  = $params['data'];
        $level = isset($params['level']) ? $params['level'] : 'H';
        $size  = isset($params['size']) ? $params['size'] : 10;

        QRcode::png($data, false, $level, $size, 2);
    }
}
