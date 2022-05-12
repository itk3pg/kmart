<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pembelianbarang_model extends CI_Model {
	function __construct(){
		parent::__construct();
	}
	
	function getDataPembelianBarang($data){
		$query = "select a.bukti, a.barang_kode, b.nama_barang, a.supplier_kode, c.nama_supplier, a.tanggal, a.kwt, a.kwt_op, a.retur, a.harga, a.ppn, a.jumlah, a.status_pembayaran, d.tukar_nota_bukti, e.nama as nama_user, a.ref_op, a.no_ref 
		from pengadaan_barang a left join barang b on a.barang_kode = b.kode left join supplier c on a.supplier_kode = c.kode left join detail_tukar_nota d on a.bukti=d.pengadaan_bukti left join `user` e on a.user_id=e.username 
		where (date(a.tanggal) between '".$data['tanggal_awal']."' and '".$data['tanggal_akhir']."') and a.is_hapus='0' order by a.tanggal desc, a.bukti desc, a.urut";
		
		if($data['is_bkl'] == '1'){
			$query = "select a.bukti, a.barang_kode, b.nama_barang, a.supplier_kode, c.nama_supplier, a.tanggal, a.kwt, a.kwt_op, a.retur, a.harga, a.ppn, a.jumlah, a.status_pembayaran 
			from pengadaan_barang_bkl a left join barang b on a.barang_kode = b.kode left join supplier c on a.supplier_kode = c.kode 
			where (date(a.tanggal) between '".$data['tanggal_awal']."' and '".$data['tanggal_akhir']."') and a.is_hapus='0' order by a.tanggal desc, a.bukti desc";
		}
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	function getRekapPembelianBarang($data){
		$query = "select a.bukti, a.supplier_kode, c.nama_supplier, a.tanggal, sum(a.kwt * a.harga) as dpp, sum(a.kwt * a.ppn) as ppn, sum(a.jumlah) as jumlah, a.status_pembayaran, a.ref_op, a.no_ref from pengadaan_barang a left join supplier c on a.supplier_kode = c.kode where (date(a.tanggal) between '".$data['tanggal_awal']."' and '".$data['tanggal_akhir']."') and a.is_hapus='0' group by a.bukti, a.supplier_kode, a.tanggal, a.status_pembayaran order by a.tanggal asc, a.bukti asc";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}

	function getRekapKelompokPembelianBarang($data){
		$query = "select b.kategori, c.nama, sum(a.jumlah) as jumlah from pengadaan_barang a left join barang b on a.barang_kode=b.kode left join kategori_barang c on b.kategori=c.kode where (date(a.tanggal) between '".$data['tanggal_awal']."' and '".$data['tanggal_akhir']."') and a.is_hapus='0' group by b.kategori";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	function SimpanPembelianBarang($data){
		$username = $this->session->userdata('username');
		
		$jumlahHarga = ($data['harga'] + $data['ppn']) * $data['kwt'];
		if($data['pembelian_mode'] == 'i'){
			$query = "insert into pengadaan_barang (bukti, barang_kode, supplier_kode, unit_kode, tanggal, kwt, kwt_op, retur, harga_asli, diskon1, harga, ppn, jumlah, status_pembayaran, 
			ref_op, waktu_insert, waktu_update, user_id, is_hapus, urut, no_ref) values('".$data['bukti']."','".$data['barang_kode']."','".$data['supplier_kode']."', 'VO0006',
			'".$data['tanggal']."',".$data['kwt'].",".$data['kwt_op'].",".$data['retur'].",".$data['harga_asli'].",".$data['diskon1'].",".$data['harga'].",".$data['ppn'].",".$data['jumlah'].",'".$data['status_pembayaran']."',
			'".$data['ref_op']."',NOW(),NOW(),'".$username."','0', ".$data['index'].", '".$data['no_ref']."') on duplicate key update kwt=kwt+".$data['kwt'].", kwt_op=kwt_op+".$data['kwt'].", jumlah=jumlah+".$data['jumlah']."";
			
			if($data['is_bkl'] == "1"){
				$query = "insert into pengadaan_barang_bkl (bukti, barang_kode, supplier_kode, unit_kode, tanggal, kwt, kwt_op, retur, harga_asli, diskon1, harga, ppn, jumlah, status_pembayaran, 
				ref_op, waktu_insert, waktu_update, user_id, is_hapus) values('".$data['bukti']."','".$data['barang_kode']."','".$data['supplier_kode']."', 'VO0006',
				'".$data['tanggal']."',".$data['kwt'].",".$data['kwt_op'].",".$data['retur'].",".$data['harga_asli'].",".$data['diskon1'].",".$data['harga'].",".$data['ppn'].",".$data['jumlah'].",'".$data['status_pembayaran']."',
				'".$data['ref_op']."',NOW(),NOW(),'".$username."','0')";
			}
			
			$this->db->query($query);
		}else{
			$query = "insert into pengadaan_barang (bukti, barang_kode, supplier_kode, unit_kode, tanggal, kwt, kwt_op, retur, harga_asli, diskon1, harga, ppn, jumlah, status_pembayaran, 
			ref_op, waktu_insert, waktu_update, user_id, is_hapus, urut, no_ref) values('".$data['bukti']."','".$data['barang_kode']."','".$data['supplier_kode']."', 'VO0006',
			'".$data['tanggal']."',".$data['kwt'].",".$data['kwt_op'].",".$data['retur'].",".$data['harga_asli'].",".$data['diskon1'].",".$data['harga'].",".$data['ppn'].",".$data['jumlah'].",'".$data['status_pembayaran']."',
			'".$data['ref_op']."',NOW(),NOW(),'".$username."','0', ".$data['index'].", '".$data['no_ref']."') on duplicate key update tanggal='".$data['tanggal']."', 
			supplier_kode='".$data['supplier_kode']."', kwt=".$data['kwt'].", kwt_op=".$data['kwt_op'].", retur=".$data['retur'].", harga_asli=".$data['harga_asli'].", diskon1=".$data['diskon1'].", is_hapus='0', harga=".$data['harga'].", ppn=".$data['ppn'].", 
			jumlah=".$data['jumlah'].", status_pembayaran='".$data['status_pembayaran']."', waktu_update=NOW(), urut=".$data['index'].", user_id='".$username."', no_ref='".$data['no_ref']."'";
			
			if($data['is_bkl'] == "1"){
				$query = "insert into pengadaan_barang_bkl (bukti, barang_kode, supplier_kode, unit_kode, tanggal, kwt, kwt_op, retur, harga_asli, diskon1, harga, ppn, jumlah, status_pembayaran, 
				ref_op, waktu_insert, waktu_update, user_id, is_hapus) values('".$data['bukti']."','".$data['barang_kode']."','".$data['supplier_kode']."', 'VO0006',
				'".$data['tanggal']."',".$data['kwt'].",".$data['kwt_op'].",".$data['retur'].",".$data['harga_asli'].",".$data['diskon1'].",".$data['harga'].",".$data['ppn'].",".$data['jumlah'].",'".$data['status_pembayaran']."',
				'".$data['ref_op']."',NOW(),NOW(),'".$username."','0') on duplicate key update tanggal='".$data['tanggal']."', 
				supplier_kode='".$data['supplier_kode']."', kwt=".$data['kwt'].", kwt_op=".$data['kwt_op'].", retur=".$data['retur'].", harga_asli=".$data['harga_asli'].", diskon1=".$data['diskon1'].", is_hapus='0', harga=".$data['harga'].", ppn=".$data['ppn'].", 
				jumlah=".$data['jumlah'].", waktu_update=NOW(), user_id='".$username."'";
			}
			
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
		
		$query = "update pengadaan_barang set is_hapus='1', waktu_update=NOW(), user_id='".$username."' where bukti='".$data['bukti']."'";
		if(substr($data['bukti'],0,1) == "T"){
			$query = "update pengadaan_barang_tau set is_hapus='1', waktu_update=NOW(), user_id='".$username."' where bukti='".$data['bukti']."'";
		}
		
		/*if(isset($data['barang_kode'])){
			$query .= " and barang_kode='".$data['barang_kode']."'";
		}*/
		
		$this->db->query($query);
		
		$querysetOP = "update op a set a.is_receive='0' where bukti='".$data['ref_op']."'";
		$this->db->query($querysetOP);

		$querysetTG = "update transfer_toko a set a.is_hapus='1' where a.ref_ot='".$data['bukti']."'";
		$this->db->query($querysetTG);
		$querysetOT = "update order_transfer a set a.is_hapus='1' where a.keterangan='".$data['bukti']."'";
		$this->db->query($querysetOT);
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
		$query = "select a.bukti, a.barang_kode, b.nama_barang, b.satuan, a.supplier_kode, c.nama_supplier, a.tanggal, a.kwt_op, a.retur, a.kwt, a.harga_asli, a.diskon1, a.harga, a.ppn, a.jumlah, a.status_pembayaran, a.ref_op, a.no_ref 
		from pengadaan_barang a left join barang b on a.barang_kode = b.kode 
		left join supplier c on a.supplier_kode=c.kode
		where a.bukti='".$data['bukti']."' and a.is_hapus='0' order by a.urut";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}

	function getDataBarangEditBI($data){
		$query = "select a.bukti, a.tanggal, d.nama_supplier, a.barang_kode, b.nama_barang, a.kwt_op, a.kwt, a.harga, a.harga_asli, a.diskon1, a.ppn, a.jumlah, b.satuan, 
		if(c.saldo_akhir_kwt is null, 0, c.saldo_akhir_kwt) as saldo_akhir_kwt, e.nama as nama_user 
		from pengadaan_barang a left join barang b on a.barang_kode=b.kode 
		left join (select * from saldo_barang_toko where toko_kode='VO0006' and bulan=".date('m')." and tahun=".date('Y').") c on a.barang_kode=c.barang_kode 
		left join supplier d on a.supplier_kode=d.kode left join user e on a.user_id=e.username 
		where a.bukti='".$data['bukti']."' and a.is_hapus='0' order by a.urut";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}

	function getAllBarangBI($data){
		$query = "select a.bukti, a.barang_kode, a.tanggal from pengadaan_barang a where a.bukti='".$data['bukti']."'";
		
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
		$query = "select a.bukti, a.supplier_kode, b.nama_supplier, a.tanggal, a.ref_op, sum(a.jumlah) jumlah 
		from pengadaan_barang a left join supplier b on a.supplier_kode=b.kode where bukti='".$bukti."' group by a.bukti, a.supplier_kode";
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function ApproveBKL($data){
		$query = "insert into pengadaan_barang select * from pengadaan_barang_bkl where bukti='".$data['bukti']."'";
		$this->db->query($query);
		
		$querydelete = "update pengadaan_barang_bkl set is_hapus='2' where bukti='".$data['bukti']."'";
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

	function pembulatan($uang){
		$puluhan = substr($uang, -2);
		$akhir = $uang;
		if($puluhan<=50){
			if($puluhan > 0){
				$akhir = $uang + (50-$puluhan);
			}
		}else{
			$akhir = $uang + (100-$puluhan);
		}

		return $akhir;
	}

	function UpdateHargaJual($data){
		$queryGet = "SELECT a.kode, a.barcode, if(a.margin is null or a.margin <= 0, ifnull(b.margin_harga, 0), a.margin) as margin_harga, if(a.margin2 is null or a.margin2 <= 0, ifnull(b.margin_harga2, 0), a.margin2) as margin_harga2 FROM barang a left join kategori_barang b on a.kategori=b.kode where a.kode='".$data['barang_kode']."' AND (a.margin IS NULL OR a.margin2 IS NULL)";
		$resultget = $this->db->query($queryGet);
		$resultgetArr = $resultget->result_array();

		if(sizeof($resultgetArr) > 0){
			$Margin = ($data['harga'] * ($resultgetArr[0]['margin_harga']/100));
			$HargaJual = $data['harga'] + $Margin;
			$HargaJual = $this->pembulatan(round($HargaJual));

			$Margin2 = ($data['harga'] * ($resultgetArr[0]['margin_harga2']/100));
			$HargaJual2 = $data['harga'] + $Margin2;
			$HargaJual2 = $this->pembulatan(round($HargaJual2));

			$QueryUpdate = "UPDATE harga_barang_toko SET harga1=".$HargaJual.", harga2=".$HargaJual2.", waktu_update=NOW() where barang_kode='".$data['barang_kode']."' and toko_kode<>'VO0005'";
			
			$this->db->query($QueryUpdate);
			
			// untuk toko bunga margin + 5%
			$Margin = ($data['harga'] * (($resultgetArr[0]['margin_harga']+5)/100));
			$HargaJual = $data['harga'] + $Margin;
			$HargaJual = $this->pembulatan(round($HargaJual));

			$Margin2 = ($data['harga'] * (($resultgetArr[0]['margin_harga2']+5)/100));
			$HargaJual2 = $data['harga'] + $Margin2;
			$HargaJual2 = $this->pembulatan(round($HargaJual2));

			$QueryUpdate = "UPDATE harga_barang_toko SET harga1=".$HargaJual.", harga2=".$HargaJual2.", waktu_update=NOW() where barang_kode='".$data['barang_kode']."' and toko_kode='VO0005'";

			$this->db->query($QueryUpdate);
		}
	}

	function SyncHargaJualHpp($data){
		$queryGet = "select a.barang_kode, a.harga, a.ppn, a.supplier_kode, a.tanggal from pengadaan_barang a where a.barang_kode='".$data['barang_kode']."' order by a.tanggal desc limit 1";

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
		$Param['mode'] = "TG";
		$Param['tanggal'] = $data['tanggal'];
		$BuktiTG = $this->bukti_model->GenerateBukti($Param);
		
		$querytg = "insert into transfer_toko(bukti, barang_kode, toko_kode, tanggal, kwt, harga, jumlah, ref_ot, is_approve, user_id, waktu_insert, waktu_update, is_hapus, urut) select '".$BuktiTG."' as bukti, barang_kode, '".$data['toko_kode']."' as toko_kode, tanggal, kwt, (harga + ppn) as harga, jumlah, bukti as ref_ot, '0' as is_approve, user_id, NOW() as waktu_insert, NOW() as waktu_update, '0' as is_hapus, urut from pengadaan_barang where bukti='".$data['bukti_bi']."' and is_hapus='0'";
		$this->db->query($querytg);

		$Param = array();
		$Param['mode'] = "OT";
		$Param['tanggal'] = $data['tanggal'];
		$BuktiOT = $this->bukti_model->GenerateBukti($Param);
		
		$queryot = "insert into order_transfer(bukti, toko_kode, barang_kode, tanggal, kwt, harga, jumlah, keterangan, is_approve, is_hapus, user_id, waktu_insert, waktu_update, urut) select '".$BuktiOT."' as bukti, '".$data['toko_kode']."' as toko_kode, barang_kode, tanggal, kwt, (harga + ppn) as harga, jumlah, bukti as keterangan, '1' as is_approve, '0' as is_hapus, user_id, NOW() as waktu_insert, NOW() as waktu_update, urut from pengadaan_barang where bukti='".$data['bukti_bi']."' and is_hapus='0'";
		
		$this->db->query($queryot);
		
		return $BuktiTG;
	}
	
	function getDataTransferGudang($data){
		$query = "select * from transfer_toko where ref_ot='".$data['bukti_bi']."' and is_hapus='0'";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
}
