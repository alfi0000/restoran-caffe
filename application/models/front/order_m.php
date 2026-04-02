<?php
class Order_m extends CI_Model
{
    public function getOrderById($id)
    {
        return $this->db->get_where('order', ['id_order' => $id])->row();
    }

    public function updateStatus($id_order, $status)
    {
        return $this->db->where('id_order', $id_order)
            ->update('order', ['status' => $status]);
    }

    public function insertOrder($data)
    {
        $this->db->insert('order', $data);
    }
}
