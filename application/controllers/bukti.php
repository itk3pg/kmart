<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bukti extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('bukti_model');
	}
	
	public function generatebukti(){
		$databukti = $this->bukti_model->GenerateBukti($_POST);
		
		echo $databukti;
	}
}