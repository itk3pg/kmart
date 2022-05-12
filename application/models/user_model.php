<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function getdatauser(){
		$query = "select a.username, a.password, a.group_kode, b.nama nama_group, a.nama, a.toko_kode, a.no_kasir, c.nama as nama_toko  
					from `user` a left join `group` b ON a.group_kode = b.kode left join toko c on a.toko_kode=c.kode";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function getdatagroup(){
		$query = "select * from `group`";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	function tambahuser($data){
		$queryselect = "select username from `user` where username='".$data['username']."'";
		$result = $this->db->query($queryselect);
		$resultArr = $result->result_array();
  
		if(sizeof($resultArr) > 0){
			return "-1";
		}else{
			$query = "insert into `user`(username, password, group_kode, nama, no_kasir, toko_kode) values(upper('".$data['username']."'),upper('".$data['password']."'),'".$data['group_kode']."','".$this->db->escape_str($data['nama'])."','".$data['no_kasir']."','".$data['toko_kode']."')";
			
			$this->db->query($query);
			
			return "1";
		}
	}
	
	function edituser($data){
		$query = "update `user` set group_kode='".$data['group_kode']."', password='".$data['password']."', nama='".$this->db->escape_str($data['nama'])."', no_kasir='".$data['no_kasir']."', toko_kode='".$data['toko_kode']."' where username='".$data['username']."'";
		
		$this->db->query($query);
		
		return $this->db->_error_number();
	}
	
	function deleteuser($data){
		$query = "update `user` set is_aktif='0' where username='".$data['username']."' and group_kode='".$data['group_kode']."'";
		
		$this->db->query($query);

		$query = "delete from `user` where username='".$data['username']."' and group_kode='".$data['group_kode']."'";
		
		$this->db->query($query);
		
		return $this->db->_error_number();
	}
	
	function tambahgroup($data){
		$queryselect = "select kode from `group` where kode='".$data['kode']."'";
		$result = $this->db->query($queryselect);
		$resultArr = $result->result_array();
  
		if(sizeof($resultArr) > 0){
			return "-1";
		}else{
			$query = "insert into `group`(kode, nama, keterangan) values('".$data['kode']."','".$data['nama']."','".$data['keterangan']."')";
			
			$this->db->query($query);
			
			return "1";
		}
	}
	
	function editgroup($data){
		$query = "update `group` set nama='".$data['nama']."' where kode='".$data['kode']."'";
		
		$this->db->query($query);
		
		return $this->db->_error_number();
	}
	
	function deletegroup($data){
		$query = "delete from `group` where kode='".$data['kode']."'";
		
		$this->db->query($query);
		
		return $this->db->_error_number();
	}
	
	function proseslogin($data){
		$query = "select a.username, a.nama, a.group_kode, b.nama nama_group, a.toko_kode from `user` a left join `group` b ON b.kode = a.group_kode 
		where a.is_aktif='1' and upper(a.username)=upper('".$data['username']."') and upper(a.password)=upper('".$data['password']."')";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	function cekSession($controller){
		$username = $this->session->userdata('username');
		if($controller == 'login'){
			if($username != ''){
				header("location:".base_url()."index.php/home");
			}
		}else{
			if($username == ''){
				header("location:".base_url());
			}
		}
	}
	
	function gantipassword($data){
		$query = "update `user` set password='".$data['password']."' where username='".$data['username']."'";
		
		$this->db->query($query);
		
		return $this->db->_error_number();
	}
	
	function getTokoAktif(){
		$query = "select a.kode, a.nama from toko a where a.active='1'";

		$DataToko = $this->db->query($query);
		return $DataToko->result_array();
	}

	function getListKasir(){
		$query = "select a.username, a.nama from `user` a where a.group_kode='GRU0001'";

		$DataKasir = $this->db->query($query);
		return $DataKasir->result_array();
	}
}
