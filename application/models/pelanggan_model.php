<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pelanggan_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function getDataPelanggan(){
		$query = "select a.kode, a.jenis_pelanggan, b.nama nama_jenis, a.nama_pelanggan, a.alamat, a.kota, a.provinsi, a.no_telp, a.no_ang, a.no_peg, a.kd_prsh, a.bagian, a.departemen 
		from pelanggan a left join jenis_pelanggan b on a.jenis_pelanggan=b.kode";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	function getDataJenisPelanggan(){
		$query = "select kode, nama from jenis_pelanggan";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}

	function getDataPrsh(){
		$query = "select kd_prsh, nm_prsh from tbl_prsh";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	function getListDataPelanggan($data){
		$query = "select a.kode, a.nama_pelanggan from pelanggan a where a.nama_pelanggan like '%".$data['q']."%' or a.kode like '".$data['q']."%'";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function SimpanPelanggan($data){
		/**
		 * `kd_pelanggan` varchar(6) NOT NULL,
		  `nama_pelanggan` varchar(100) DEFAULT NULL,
		  `alamat` varchar(400) DEFAULT NULL,
		  `kota` varchar(45) DEFAULT NULL,
		  `provinsi` varchar(45) DEFAULT NULL,
		  `no_telp` varchar(45) DEFAULT NULL
		 */
		if($data['pelanggan_mode'] == "1"){ // untuk insert
			$query = "insert into pelanggan(kode, jenis_pelanggan, no_ang, nama_pelanggan, alamat, kota, provinsi, no_telp, kd_prsh, no_peg, bagian, departemen) 
			values('".$data['kode']."','".$data['jenis_pelanggan']."', '".$data['kode']."','".$data['nama_pelanggan']."','".$data['alamat']."',
			'".$data['kota']."','".$data['provinsi']."','".$data['no_telp']."','".$data['perusahaan']."','".$data['no_pegawai']."','".$data['bagian']."','".$data['departemen']."')";
		}else{ // untuk update
			$query = "update pelanggan set jenis_pelanggan='".$data['jenis_pelanggan']."',nama_pelanggan='".$data['nama_pelanggan']."', 
			alamat='".$data['alamat']."', kota='".$data['kota']."', provinsi='".$data['provinsi']."', no_telp='".$data['no_telp']."', kd_prsh='".$data['perusahaan']."', no_peg='".$data['no_pegawai']."', bagian='".$data['bagian']."', departemen='".$data['departemen']."' 
			where kode='".$data['kode']."'";
		}
		
		$this->db->query($query);
	}
	
	function SimpanJenisPelanggan($data){
		$query = "insert into jenis_pelanggan(kode, nama) values(UNIX_TIMESTAMP(), '".$data['nama']."')";
		
		$this->db->query($query);
	}
	
	function HapusPelanggan($data){
		$query = "delete from pelanggan where kode='".$data['kode']."'";
		
		$this->db->query($query);
	}
	
	function HapusJenisPelanggan($data){
		$query = "delete from jenis_pelanggan where kode='".$data['kode']."'";
		
		$this->db->query($query);
	}
}
