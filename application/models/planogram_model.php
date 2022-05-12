<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Planogram_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function getDataPlanogram($data){
		$query = "select a.kode, a.barang_kode, a.toko_kode, b.nama_barang, b.barcode, a.rak, a.shlv, a.urut, a.kirikanan, a.depanbelakang, a.atasbawah 
		from planogram a left join barang b on a.barang_kode=b.kode where a.toko_kode='".$data['toko_kode']."' 
		order by a.rak, a.shlv, a.urut";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function getDataPlanogramCetak($data){
		$query = "select a.kode, a.barang_kode, a.toko_kode, b.nama_barang, b.barcode, a.rak, a.shlv, a.urut, a.kirikanan, a.depanbelakang, a.atasbawah, c.saldo_akhir_kwt from planogram a left join barang b on a.barang_kode=b.kode left join (select * from saldo_barang_toko where bulan=month(NOW()) and tahun=year(NOW()) and toko_kode='".$data['toko_kode']."') c on a.toko_kode=c.toko_kode and a.barang_kode=c.barang_kode where a.toko_kode='".$data['toko_kode']."' order by a.rak, a.shlv, a.urut";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	function SimpanPlanogram($data){
		$query = "";
		$username = $this->session->userdata('username');
		
		if($data['mode'] == "i"){
			$query = "insert into planogram (kode, toko_kode, barang_kode, rak, shlv, urut, kirikanan, depanbelakang, atasbawah, 
			user_id, waktu_insert, waktu_update) 
			values(UNIX_TIMESTAMP(),'".$data['toko_kode']."','".$data['barang_kode']."','".$data['rak']."','".$data['shlv']."',
			'".$data['urut']."',".$data['kirikanan'].",".$data['depanbelakang'].",".$data['atasbawah'].",'".$username."', NOW(), NOW())";
		}else{
			$query = "update planogram set toko_kode='".$data['toko_kode']."', barang_kode='".$data['barang_kode']."', rak='".$data['rak']."', 
			shlv='".$data['shlv']."', urut='".$data['urut']."', kirikanan=".$data['kirikanan'].", depanbelakang=".$data['depanbelakang'].", 
			atasbawah=".$data['atasbawah'].", waktu_update=NOW(), user_id='".$username."' 
			where kode='".$data['planogram_kode']."'";
		}
		
		$this->db->query($query);
	}
	
	function HapusPlanogram($data){
		$queryDelete = "delete from planogram where kode='".$data['kode']."'";
		
		$this->db->query($queryDelete);
	}
}

?>