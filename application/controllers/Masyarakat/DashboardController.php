<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DashboardController extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		is_logged_in();
		if ( ! empty($this->session->userdata('level'))) :
			redirect('Auth/BlockedController');
			exit;
		endif;
	}

	public function index()
	{
		$data['title'] = 'Dashboard';

		$masyarakat = $this->db->get_where('masyarakat',['username' => $this->session->userdata('username')])->row_array();
		$nik = $masyarakat['nik'];

		$data['user_nama'] = $masyarakat['nama'];
		$data['total_pengaduan'] = $this->db->get_where('pengaduan', ['nik' => $nik])->num_rows();
		$data['pengaduan_pending'] = $this->db->get_where('pengaduan', ['nik' => $nik, 'status' => '0'])->num_rows();
		$data['pengaduan_proses'] = $this->db->get_where('pengaduan', ['nik' => $nik, 'status' => 'proses'])->num_rows();
		$data['pengaduan_selesai'] = $this->db->get_where('pengaduan', ['nik' => $nik, 'status' => 'selesai'])->num_rows();
		$data['pengaduan_tolak'] = $this->db->get_where('pengaduan', ['nik' => $nik, 'status' => 'tolak'])->num_rows();
		
		$data['recent_complaints'] = $this->db->order_by('id_pengaduan', 'DESC')
											  ->limit(5)
											  ->get_where('pengaduan', ['nik' => $nik])
											  ->result_array();

		$this->load->view('_part/backend_head', $data);
		$this->load->view('_part/backend_sidebar_v');
		$this->load->view('_part/backend_topbar_v');
		$this->load->view('masyarakat/dashboard', $data);
		$this->load->view('_part/backend_footer_v');
		$this->load->view('_part/backend_foot');
	}
}

/* End of file DashboardController.php */
/* Location: ./application/controllers/Masyarakat/DashboardController.php */
