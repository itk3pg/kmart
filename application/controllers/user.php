<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('master/user');
		$this->load->view('general/footer');
	}
	
	public function getdatauser(){
		$result = $this->user_model->getdatauser();
		
		$html = "<table class=\"table table-striped table-bordered table-hover\" id=\"dataTables-user\">
				 	<thead>
				 		<tr>
							<th>USERNAME</th>
				 			<th>NAMA LENGKAP</th>
				 			<th>GROUP</th>
				 			<th>TOKO</th>
				 			<th style=\"width:90px;\">AKSI</th>
				 		</tr>
				 	</thead>
				 	<tbody>";
		foreach ($result as $key => $value) {
			$html .= "<tr>
					  	<td>".$value['username']."</td>
						<td>".$value['nama']."</td>
					  	<td>".$value['nama_group']."</td>
					  	<td>".$value['nama_toko']."</td>
					  	<td>
					  		<button type=\"button\" class=\"btn btn-success btn-circle\" onclick=\"showformuser('u','".base64_encode(json_encode($value))."')\" id=\"btn-edit-user\"><i class=\"fa fa-edit\"></i></button>
					  		<button type=\"button\" class=\"btn btn-danger btn-circle\" onclick=\"hapususer('".$value['username']."', '".$value['group_kode']."')\" id=\"btn-hapus-user\"><i class=\"fa fa-times\"></i></button>
					  	</td>
					  </tr>";
		}
		$html .= "</tbody></table>";
		
		echo $html;
	}

	public function getdatagroup(){
		$result = $this->user_model->getdatagroup();
		
		$html = "";
		if($_POST['mode'] == 'select'){
			foreach ($result as $key => $value) {
				$html .= "<option value=\"".$value['kode']."\">".$value['kode']." - ".$value['nama']."</option>";
			}
		}else{
			$html = "<table class=\"table table-striped table-bordered table-hover\" id=\"dataTables-group\">
					 	<thead>
					 		<tr>
					 			<th>KODE</th>
					 			<th>NAMA</th>
					 			<th style=\"width:81px;\">KETERANGAN</th>
					 		</tr>
					 	</thead>
					 	<tbody>";
			foreach ($result as $key => $value) {
				$html .= "<tr>
							<td>".$value['kode']."</td>
							<td>".$value['nama']."</td>
							<!--<td>
						  		<button type=\"button\" class=\"btn btn-success btn-circle\" onclick=\"showformgroup('u','".base64_encode(json_encode($value))."')\" id=\"btn-edit-user\"><i class=\"fa fa-edit\"></i></button>
						  		<button type=\"button\" class=\"btn btn-danger btn-circle\" onclick=\"hapusgroup('".$value['kode']."')\" id=\"btn-hapus-user\"><i class=\"fa fa-times\"></i></button>
						  	</td>-->
						  	<td>".$value['keterangan']."</td>
						  </tr>";
			}
			
			$html .= "</tbody></table>";
		}
		
		echo $html;
	}

	public function hapususer(){
		$result = $this->user_model->deleteuser($_POST);
		
		print_r($result);
	}
	
	public function simpanuser(){
		$mode = $_POST['mode'];
		$result = '';
		if($mode == 'i'){
			$result = $this->user_model->tambahuser($_POST);
		}else{
			$result = $this->user_model->edituser($_POST);
		}
		
		print_r($result);
	}
	
	public function simpangroup(){
		$mode = $_POST['mode'];
		$result = '';
		if($mode == 'i'){
			$result = $this->user_model->tambahgroup($_POST);
		}else{
			$result = $this->user_model->editgroup($_POST);
		}
		
		print_r($result);
	}
	
	public function hapusgroup(){
		$result = $this->user_model->deletegroup($_POST);
		
		print_r($result);
	}
	
	function gantipassword(){
		$result = $this->user_model->gantipassword($_POST);
		
		print_r($result);
	}
	
	public function logout(){
		$this->session->sess_destroy();
		header("location:".base_url());
	}

	public function getlistkasir(){
		$DataToko = $this->user_model->getListKasir();
		
		$html = "<option value=''>Pilih Kasir</option>";
		foreach ($DataToko as $key => $value) {
			$html .= "<option value='".$value['username']."'>".$value['username']." - ".$value['nama']."</option>";
		}
		
		echo $html;
	}
}
