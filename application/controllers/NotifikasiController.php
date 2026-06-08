<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class NotifikasiController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Notifikasi_m');
    }

    public function index()
    {
        $data['title'] = 'Notifikasi';
        $username = $this->session->userdata('username');
        $level = $this->session->userdata('level');
        $data['notifikasi'] = $this->Notifikasi_m->get_by_user($username, $level, 100);

        $this->load->view('_part/backend_head', $data);
        $this->load->view('_part/backend_sidebar_v');
        $this->load->view('_part/backend_topbar_v');
        $this->load->view('notifikasi/index', $data);
        $this->load->view('_part/backend_footer_v');
        $this->load->view('_part/backend_foot');
    }

    public function unread_json()
    {
        $username = $this->session->userdata('username');
        $level = $this->session->userdata('level');
        $unread = $this->Notifikasi_m->get_unread_by_user($username, $level, 10);

        $data = [
            'unread_count'  => $this->Notifikasi_m->count_unread($username, $level),
            'unread'        => $unread,
            'last_id'       => !empty($unread) ? (int) $unread[0]['id_notifikasi'] : 0,
        ];

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function read($id)
    {
        $notif = $this->Notifikasi_m->get($id);
        if ($notif) {
            $this->Notifikasi_m->mark_read($id);
            redirect($notif['url']);
        } else {
            redirect('NotifikasiController');
        }
    }
}
