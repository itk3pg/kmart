<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
	}
	
	public function index(){
		$this->user_model->cekSession('login');
		$this->load->view('login');
	}
	
	public function proseslogin(){
		$username = $_POST['username'];
		$password = $_POST['password'];
		
		$result = $this->user_model->proseslogin($_POST);
		
		if(sizeof($result) > 0){
			$result[0]['password'] = "rahasia";
			$this->session->set_userdata($result[0]);
			header("location:".base_url()."index.php/home");
		}else{
			$this->session->set_flashdata('error_login', 'username dan password tidak cocok');
			header("location:".base_url());
		}
		/*if($username == 'admin' && $password == 'admin'){
			$userData = array();
			$userData['username'] = 'admin';
			$userData['mode'] = 'admin';
			$this->session->set_userdata($userData);
			header("location:".base_url()."index.php/home");
		}else if($username == 'akuntansi' && $password == 'akuntansi'){
			$userData = array();
			$userData['username'] = 'akuntansi';
			$userData['mode'] = 'akuntansi';
			$this->session->set_userdata($userData);
			header("location:".base_url()."index.php/laporan/mutasikasbank");
		}else if(strtoupper($username) == 'KW98020' && strtoupper($password) == 'KW98020'){
			$userData = array();
			$userData['username'] = 'KW98020';
			$userData['mode'] = 'akuntansi';
			$this->session->set_userdata($userData);
			header("location:".base_url()."index.php/laporan/mutasikasbank");
		}else{
			$this->session->set_flashdata('error_login', 'username dan password tidak cocok');
			header("location:".base_url());
		}*/
	}
}
