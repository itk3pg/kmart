<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pembelianjasa_model extends CI_Model {
	function __construct(){
		parent::__construct();
	}
	
	function getDataPembelianJasa($data){
		$query = "(select a.bukti, a.jasa_kode, b.nama_jasa, a.supplier_kode, c.nama_supplier, a.tanggal, a.kwt, a.harga, 
		a.ppn, a.pph, a.jumlah, a.status_pembayaran, a.ref_order 
		from pengadaan_jasa a left join jasa b on a.jasa_kode = b.kode left join supplier c on a.supplier_kode = c.kode 
		where MONTH(a.tanggal)=".$data['bulan']." and YEAR(a.tanggal)= ".$data['tahun']." and a.is_hapus='0')";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	function SimpanPembelianJasa($data){
		$username = $this->session->userdata('username');
		
		$jumlahHarga = ($data['harga'] + $data['ppn']) * $data['kwt'];
		if($data['pembelian_mode'] == 'i'){
			$query = "insert into pengadaan_jasa (bukti, jasa_kode, supplier_kode, tanggal, kwt, harga, ppn, pph, jumlah, status_pembayaran, ref_order, 
			waktu_insert, waktu_update, is_hapus, user_id) values('".$data['bukti']."','".$data['jasa_kode']."','".$data['supplier_kode']."',
			'".$data['tanggal']."',".$data['kwt'].",".$data['harga'].",".$data['ppn'].",".$data['pph'].",".$data['jumlah'].",'".$data['status_pembayaran']."',
			'".$data['ref_order']."', NOW(),NOW(),'0','".$username."')";
			
			$this->db->query($query);
		}else{
			$query = "insert into pengadaan_jasa (bukti, jasa_kode, supplier_kode, tanggal, kwt, harga, ppn, pph, jumlah, status_pembayaran, ref_order, 
			waktu_insert, waktu_update, is_hapus, user_id) values('".$data['bukti']."','".$data['jasa_kode']."','".$data['supplier_kode']."',
			'".$data['tanggal']."',".$data['kwt'].",".$data['harga'].",".$data['ppn'].",".$data['pph'].",".$data['jumlah'].",'".$data['status_pembayaran']."',
			'".$data['ref_order']."', NOW(),NOW(),'0','".$username."') on duplicate key update tanggal='".$data['tanggal']."', 
			supplier_kode='".$data['supplier_kode']."', kwt=".$data['kwt'].", is_hapus='0', harga=".$data['harga'].", ppn=".$data['ppn'].", 
			pph=".$data['pph'].", jumlah=".$data['jumlah'].", waktu_update=NOW()";
			
			$this->db->query($query);
		}
	}
	
	function HapusPembelianJasa($data){
		$username = $this->session->userdata('username');
		
		$query = "update pengadaan_jasa set is_hapus='1', waktu_update=NOW(), user_id='".$username."' where bukti='".$data['bukti']."'";
		
		/*if(isset($data['barang_kode'])){
			$query .= " and barang_kode='".$data['barang_kode']."'";
		}*/
		
		$this->db->query($query);
	}
	
	function getBuktiUangMuka($data){
		$kode_cb = "";
		$tambahUnion = "";
		if($data['mode'] == 'pembelian'){
			if($data['pengadaan_mode'] == '1'){
				$kode_cb = "2921";
			}else{
				$kode_cb = "2951";
			}
			$tambahUnion = "union (select ref_kasbank, sisa from um_pembelian where sisa > 0 
			and supplier_kode='".$data['kode_subject']."')";
		}else{
			$kode_cb = "1911";
		}
		
		$query = "(select bukti, jumlah from kasbank where kd_cb='".$kode_cb."' and no_ref='' 
		and kode_subject='".$data['kode_subject']."' and is_hapus='0') ".$tambahUnion;
		$result = $this->db->query($query);
		$this->db->close();
		return $result->result_array();
	}
	
	function getDataJasaJI($data){
		$query = "select a.bukti, a.jasa_kode, b.nama_jasa, a.supplier_kode, a.tanggal, a.kwt, a.harga, a.ppn, a.pph, a.jumlah, a.status_pembayaran 
		from pengadaan_jasa a left join jasa b on a.jasa_kode = b.kode 
		where a.bukti='".$data['bukti']."' and a.is_hapus='0'";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	function SimpanUangMuka($data){
		$username = $this->session->userdata('username');
		
		$query = "insert into um_pembelian(pengadaan_bukti, supplier_kode, jumlah, ref_kasbank, sisa, waktu_update, user) 
		values('".$data['bukti']."','".$data['supplier_kode']."',".$data['jumlah_um'].",'".$data['bukti_um']."',".$data['sisa_um'].",
		NOW(),'".$username."')";
		
		$this->db->query($query);
	}
	
	function HapusUangMuka($data){
		$username = $this->session->userdata('username');
		
		$query = "delete from um_pembelian where pengadaan_bukti='".$data['bukti']."'";
		
		$this->db->query($query);
	}
	
	function checkData($bukti){
		$query = "select a.bukti, a.supplier_kode, b.nama_supplier, a.tanggal, sum(a.jumlah) jumlah 
		from pengadaan_jasa a left join supplier b on a.supplier_kode=b.kode where bukti='".$bukti."' group by a.bukti, a.supplier_kode";
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
}
