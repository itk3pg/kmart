<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setstockopname extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('setstockopname_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('setstockopname/home');
		$this->load->view('general/footer');
	}
	
	public function setdatastockopname(){
		$this->setstockopname_model->setDataStockOpname($_POST);
	}
}