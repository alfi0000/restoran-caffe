<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('login_m');
        $this->load->library('template_login');
    }

    public function index()
    {
        $this->template_login->display('admin/login_v');
    }

    public function validasi()
    {
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        if ($this->form_validation->run() == false) {
            $this->template_login->display('admin/login_v');
        } else {
            $username  = stripHTMLtags(trim($this->input->post('username', 'true')));
            $password  = stripHTMLtags(trim($this->input->post('password', 'true')));

            // Hitung jumlah user
            $num_user = $this->login_m->get_user($username)->num_rows();

            if ($num_user == 0) {
                $this->session->set_flashdata('notification', '<b>Username Anda Tidak Terdaftar.</b>');
                redirect(site_url('login'));
            } else {
                // Ambil data user
                $temp_account = $this->login_m->check_user_account($username, sha1($password));

                if ($temp_account->num_rows() > 0) {
                    $row = $temp_account->row();
                    $array_item = array(
                        'username'        => trim($row->user_username),
                        'pass'            => $row->user_password,
                        'nama'            => strtoupper(trim($row->user_name)),
                        'avatar'          => $row->user_avatar,
                        'level'           => $row->user_level,
                        'logged_in_resto' => true,
                    );

                    $this->session->set_userdata($array_item);

                    $level = $this->session->userdata('level');

                    switch ($level) {
                        case 'Admin':
                            redirect(site_url('admin/home'));
                            break;
                        case 'Bar':
                            redirect(site_url('bar/home'));
                            break;
                        case 'Dapur':
                            redirect(site_url('dapur/home'));
                            break;
                        case 'Kasir':
                            redirect(site_url('kasir/home'));
                            break;
                        default:
                            redirect(site_url('login'));
                            break;
                    }
                } else {
                    $this->session->set_flashdata('notification', '<b>Username atau Password Anda Salah.</b>');
                    redirect(site_url('login'));
                }
            }
        }
    }


    public function logout()
    {
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . 'GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-chace');
        $this->session->sess_destroy();
        redirect(base_url());
    }
}

/* Location: ./application/controller/Login.php */