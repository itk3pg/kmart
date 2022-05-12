<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pembelianbarangkonsinyasi_model extends CI_Model {
	function __construct(){
		parent::__construct();
	}
	
	function getDataPembelianBarang($data){
		$query = "select a.bukti, a.barang_kode, b.nama_barang, a.supplier_kode, c.nama_supplier, a.tanggal, a.kwt, a.kwt_op, a.retur, a.harga, a.ppn, a.jumlah, a.status_pembayaran, d.tukar_nota_bukti, e.nama as nama_user, c.fee_konsinyasi 
		from pengadaan_barang_konsinyasi a left join barang b on a.barang_kode = b.kode left join supplier c on a.supplier_kode = c.kode left join detail_tukar_nota d on a.bukti=d.pengadaan_bukti left join `user` e on a.user_id=e.username 
		where (date(a.tanggal) between '".$data['tanggal_awal']."' and '".$data['tanggal_akhir']."') and a.is_hapus='0' order by a.tanggal desc, a.bukti desc, a.urut";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	function getRekapPembelianBarang($data){
		$query = "select a.bukti, a.supplier_kode, c.nama_supplier, a.tanggal, sum(a.kwt * a.harga) as dpp, sum(a.kwt * a.ppn) as ppn, sum(a.jumlah) as jumlah, a.status_pembayaran from pengadaan_barang_konsinyasi a left join supplier c on a.supplier_kode = c.kode where (date(a.tanggal) between '".$data['tanggal_awal']."' and '".$data['tanggal_akhir']."') and a.is_hapus='0' group by a.bukti, a.supplier_kode order by a.tanggal desc, a.bukti desc";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	function SimpanPembelianBarang($data){
		$username = $this->session->userdata('username');
		
		$jumlahHarga = ($data['harga'] + $data['ppn']) * $data['kwt'];
		if($data['pembelian_mode'] == 'i'){
			$query = "insert into pengadaan_barang_konsinyasi (bukti, barang_kode, supplier_kode, unit_kode, tanggal, kwt, kwt_op, retur, harga_asli, diskon1, harga, ppn, jumlah, status_pembayaran, 
			ref_op, waktu_insert, waktu_update, user_id, is_hapus, urut) values('".$data['bukti']."','".$data['barang_kode']."','".$data['supplier_kode']."', 'VO0006',
			'".$data['tanggal']."',".$data['kwt'].",".$data['kwt_op'].",".$data['retur'].",".$data['harga_asli'].",".$data['diskon1'].",".$data['harga'].",".$data['ppn'].",".$data['jumlah'].",'".$data['status_pembayaran']."',
			'".$data['ref_op']."',NOW(),NOW(),'".$username."','0', ".$data['index'].") on duplicate key update tanggal='".$data['tanggal']."', 
			supplier_kode='".$data['supplier_kode']."', kwt=".$data['kwt'].", kwt_op=".$data['kwt_op'].", retur=".$data['retur'].", harga_asli=".$data['harga_asli'].", diskon1=".$data['diskon1'].", is_hapus='0', harga=".$data['harga'].", ppn=".$data['ppn'].", 
			jumlah=".$data['jumlah'].", status_pembayaran='".$data['status_pembayaran']."', waktu_update=NOW(), urut=".$data['index'].", user_id='".$username."'";
			
			$this->db->query($query);
		}else{
			$query = "insert into pengadaan_barang_konsinyasi (bukti, barang_kode, supplier_kode, unit_kode, tanggal, kwt, kwt_op, retur, harga_asli, diskon1, harga, ppn, jumlah, status_pembayaran, 
			ref_op, waktu_insert, waktu_update, user_id, is_hapus, urut) values('".$data['bukti']."','".$data['barang_kode']."','".$data['supplier_kode']."', 'VO0006',
			'".$data['tanggal']."',".$data['kwt'].",".$data['kwt_op'].",".$data['retur'].",".$data['harga_asli'].",".$data['diskon1'].",".$data['harga'].",".$data['ppn'].",".$data['jumlah'].",'".$data['status_pembayaran']."',
			'".$data['ref_op']."',NOW(),NOW(),'".$username."','0', ".$data['index'].") on duplicate key update tanggal='".$data['tanggal']."', 
			supplier_kode='".$data['supplier_kode']."', kwt=".$data['kwt'].", kwt_op=".$data['kwt_op'].", retur=".$data['retur'].", harga_asli=".$data['harga_asli'].", diskon1=".$data['diskon1'].", is_hapus='0', harga=".$data['harga'].", ppn=".$data['ppn'].", 
			jumlah=".$data['jumlah'].", status_pembayaran='".$data['status_pembayaran']."', waktu_update=NOW(), urut=".$data['index'].", user_id='".$username."'";
			
			$this->db->query($query);
		}
		
		$ParamHarga = array();
		$ParamHarga['barang_kode'] = $data['barang_kode'];
		$ParamHarga['supplier_kode'] = $data['supplier_kode'];
		$ParamHarga['harga'] = $data['harga'] + $data['ppn'];
		$ParamHarga['tanggal'] = $data['tanggal'];
		$this->updateHargaBeli($ParamHarga);
		$this->UpdateHargaJual($ParamHarga);
	}
	
	function HapusPembelianBarang($data){
		$username = $this->session->userdata('username');
		
		$query = "update pengadaan_barang_konsinyasi set is_hapus='1', waktu_update=NOW(), user_id='".$username."' where bukti='".$data['bukti']."'";
		if(substr($data['bukti'],0,1) == "T"){
			$query = "update pengadaan_barang_konsinyasi_tau set is_hapus='1', waktu_update=NOW(), user_id='".$username."' where bukti='".$data['bukti']."'";
		}
		
		/*if(isset($data['barang_kode'])){
			$query .= " and barang_kode='".$data['barang_kode']."'";
		}*/
		
		$this->db->query($query);
		
		// $querysetOP = "update op a set a.is_receive='0' where bukti='".$data['ref_op']."'";
		// $this->db->query($querysetOP);

		$querysetTG = "update transfer_toko_konsinyasi a set a.is_hapus='1' where a.ref_ot='".$data['bukti']."'";
		$this->db->query($querysetTG);		
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
	
	function getDataBarangBI($data){
		$query = "select a.bukti, a.barang_kode, b.barcode, b.nama_barang, b.satuan, a.supplier_kode, c.nama_supplier, a.tanggal, a.kwt_op, a.retur, a.kwt, a.harga_asli, a.diskon1, a.harga, a.ppn, a.jumlah, a.status_pembayaran, c.fee_konsinyasi, d.toko_kode 
		from pengadaan_barang_konsinyasi a left join barang b on a.barang_kode = b.kode 
		left join supplier c on a.supplier_kode=c.kode left join (select bukti, ref_ot, barang_kode, toko_kode from transfer_toko_konsinyasi where is_hapus='0') d on a.bukti=d.ref_ot and a.barang_kode=d.barang_kode
		where a.bukti='".$data['bukti']."' and a.is_hapus like '".$data['is_hapus']."%' order by a.urut";
		// echo $query;
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
		$query = "select a.bukti, a.supplier_kode, a.unit_kode, b.nama_supplier, a.tanggal, sum(a.jumlah) jumlah  
		from pengadaan_barang_konsinyasi a left join supplier b on a.supplier_kode=b.kode where a.bukti='".$bukti."' group by a.bukti, a.supplier_kode, a.tanggal, a.unit_kode";
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function ApproveBKL($data){
		$query = "insert into pengadaan_barang_konsinyasi select * from pengadaan_barang_konsinyasi_bkl where bukti='".$data['bukti']."'";
		$this->db->query($query);
		
		$querydelete = "update pengadaan_barang_konsinyasi_bkl set is_hapus='2' where bukti='".$data['bukti']."'";
		$this->db->query($querydelete);
	}
	
	function updateHargaBeli($data){
		$query = "insert into harga_barang_supplier(barang_kode, supplier_kode, harga, harga_periode, periode) values('".$data['barang_kode']."', '".$data['supplier_kode']."', ".$data['harga'].", ".$data['harga'].", '".$data['tanggal']."') on duplicate key update harga=".$data['harga'].", harga_periode=".$data['harga'].", periode='".$data['tanggal']."'";
		
		$this->db->query($query);

		$TanggalArr = explode("-", $data['tanggal']);
		$queryhpp = "insert into hpp(bulan, tahun, barang_kode, hpp) values(".$TanggalArr[1].", ".$TanggalArr[0].", '".$data['barang_kode']."', ".$data['harga'].") on duplicate key update hpp=".$data['harga']."";
		$this->db->query($queryhpp);

		$queryUpdateHPP = "update barang set hpp=".$data['harga'].", waktu_hpp=NOW() where kode='".$data['barang_kode']."'";
		$this->db->query($queryUpdateHPP);
	}

	function UpdateHargaJual($data){
		// $queryGet = "SELECT a.kode, a.barcode, ifnull(b.margin_harga, 0) as margin_harga FROM barang a left join kategori_barang b on a.kategori=b.kode where a.kode='".$data['barang_kode']."'";
		// $resultget = $this->db->query($queryGet);
		// $resultgetArr = $resultget->result_array();

		// $Margin = $data['harga'] * ($resultgetArr[0]['margin_harga']/100);
		// $HargaJual = $data['harga'] + $Margin;

		$QueryUpdate = "UPDATE harga_barang_toko SET harga1=".$data['harga'].", harga2=".$data['harga'].", harga3=".$data['harga'].", waktu_update=NOW() where barang_kode='".$data['barang_kode']."'";

		$this->db->query($QueryUpdate);
	}

	function SyncHargaJualHpp($data){
		$queryGet = "select a.barang_kode, a.harga, a.ppn, a.supplier_kode, a.tanggal from pengadaan_barang_konsinyasi a where a.barang_kode='".$data['barang_kode']."' order by a.tanggal desc limit 1";

		$result = $this->db->query($queryGet);
		$resultArr = $result->result_array();

		if(sizeof($resultArr) > 0){
			$ParamHarga = array();
			$ParamHarga['barang_kode'] = $resultArr[0]['barang_kode'];
			$ParamHarga['supplier_kode'] = $resultArr[0]['supplier_kode'];
			$ParamHarga['harga'] = $resultArr[0]['harga'] + $resultArr[0]['ppn'];
			$ParamHarga['tanggal'] = $resultArr[0]['tanggal'];

			$this->updateHargaBeli($ParamHarga);
			$this->UpdateHargaJual($ParamHarga);
		}
	}
	
	function SimpanTransferKeToko($data){
		$this->load->model('bukti_model');
		
		$Param = array();
		$Param['mode'] = "TN";
		$Param['tanggal'] = $data['tanggal'];
		$BuktiTG = $this->bukti_model->GenerateBukti($Param);
		
		$query = "insert ignore into transfer_toko_konsinyasi(bukti, barang_kode, toko_kode, tanggal, kwt, harga, jumlah, ref_ot, is_approve, user_id, waktu_insert, waktu_update, is_hapus, urut) select '".$BuktiTG."' as bukti, barang_kode, '".$data['toko_kode']."' as toko_kode, tanggal, kwt, (harga+ppn) as harga, jumlah, bukti as ref_ot, '1' as is_approve, user_id, NOW() as waktu_insert, NOW() as waktu_update, '0' as is_hapus, urut from pengadaan_barang_konsinyasi where bukti='".$data['bukti_bi']."' and is_hapus='0'";
		
		$this->db->query($query);
		
		return $BuktiTG;
	}

	function hapusTransferGudang($data){
		$query = "update transfer_toko_konsinyasi set is_hapus='0' where bukti='".$data['bukti']."' and ref_ot='".$data['ref_ot']."'";
		// echo $query;
		$this->db->query($query);
	}
	
	function getDataTransferGudang($data){
		$query = "select bukti, toko_kode, ref_ot from transfer_toko_konsinyasi where ref_ot='".$data['bukti_bi']."' and is_hapus='0' group by bukti, toko_kode, ref_ot";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
}
