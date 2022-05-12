<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gantibarcode extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('syncsaldo_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');

		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('ganti_barcode');
		$this->load->view('general/footer');
	}
	
	public function proses(){
		$this->syncsaldo_model->GantiBarcode($_GET);
	}
}

?>