<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Menuorder_m extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getMenuById($id)
    {
        return $this->db->get_where('resto_menu', ['id_menu' => $id])->row();
    }

    public function updateStokMenu($id, $stok_baru)
    {
        return $this->db->where('id_menu', $id)
            ->update('resto_menu', ['stok_menu' => $stok_baru]);
    }
}
/* Location: ./application/model/front/Menuorder_m.php */