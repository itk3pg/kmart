<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Barang_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function getDataBarang($data){
		$mode_is_aktif = "1";
		if(isset($data['mode_is_aktif'])){
			if($data['mode_is_aktif'] == "0"){
				$mode_is_aktif = "0";
			}
		}
		$mode_urut = "order by a.".$data['mode_urut'];
		if($data['mode_urut'] == ""){
			$mode_urut = "";
		}
		$addwhere = "and a.kategori = '".$data['kategori_kode']."'";
		if($data['kategori_kode'] == "-1"){
			$addwhere = "";
		}
		$query = "select a.kode, a.barcode, a.kategori, b.nama nama_kategori, a.nama_barang, a.satuan, 
		a.is_ppn, a.bkl, a.hpp, a.is_aktif, if(a.margin is null or a.margin <= 0, b.margin_harga, a.margin) as margin_harga, d.harga1 as harga_barang, GROUP_CONCAT(e.nama separator '#') nama_toko 
		from barang a left join kategori_barang b on a.kategori=b.kode 
		left join harga_barang_toko d on a.kode=d.barang_kode 
		left join toko e on d.toko_kode=e.kode
		where a.is_hapus='0' and a.is_aktif='".$mode_is_aktif."' and (a.barcode = '".$data['keyword']."' or a.kode = '".$data['keyword']."' or a.nama_barang like '".$data['keyword']."%') ".$addwhere." 
		group by a.kode ".$mode_urut." limit ".(($data['halaman'] -1) * 1000).", 1000";
		// echo $query;
		$result = $this->db->query($query);
		
		return $result->result_array();
	}

	function getKodeBarang($data){
		$query = "select kode, nama_barang, satuan from barang where barcode='".$data['barcode']."'";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function getHargaBarang($data){
		$query = "select b.kode as toko_kode, b.nama, if(a.harga1 is null, 0, a.harga1) as harga from toko b 
		left join (select * from harga_barang_toko where barang_kode='".$data['barang_kode']."') a on a.toko_kode=b.kode where b.is_hapus='0'";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function getHargaSupplier($data){
		if(!isset($data['toko_kode'])){
			$data['toko_kode'] = "VO0006";
		}
		
		$query = "select b.kode as barang_kode, b.nama_barang, a.supplier_kode, ifnull(a.harga, 0) as harga, if(a.harga is null, 0, if(b.is_ppn='1', a.harga/1.1, a.harga)) as dpp, if(a.harga is null, 0, if(b.is_ppn='1', (a.harga/1.1)*0.11, 0)) as ppn, ifnull(c.saldo_akhir_kwt, 0) as saldo_akhir_kwt from barang b left join harga_barang_supplier a on a.barang_kode=b.kode left join (select barang_kode, saldo_akhir_kwt from saldo_barang_toko where bulan=month(NOW()) and tahun=year(NOW()) and toko_kode='".$data['toko_kode']."') c on b.kode=c.barang_kode where (b.kode='".$data['barang_kode']."' or b.barcode='".$data['barang_kode']."') and b.is_hapus='0' and b.is_aktif='1'";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function getHargaBarangToko($data){
		$query = "select a.toko_kode, a.barang_kode, a.harga1 
		from harga_barang_toko a where a.toko_kode='".$data['toko_kode']."' and barang_kode='".$data['barang_kode']."'";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function getListDataBarang($data){
		$query = "select a.kode, a.barcode, a.kategori, a.nama_barang, a.is_ppn, a.hpp, a.satuan 
		from barang a   
		where a.is_hapus='0' and (a.nama_barang like '%".$data['q']."%' or a.kode like '".$data['q']."%' or a.kode like '".$data['q']."%' or a.barcode like '".$data['q']."%')";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}

	function getListDataBarangToko($data){
		$query = "select a.kode, a.barcode, a.kategori, a.nama_barang, a.is_ppn, a.hpp, a.satuan 
		from barang_toko b left join barang a on b.barang_kode=a.kode where b.toko_kode='".$data['toko_kode']."' and a.is_hapus='0' and (a.nama_barang like '%".$data['q']."%' or a.kode like '".$data['q']."%' or a.barcode like '".$data['q']."%')";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function getListPelanggan($data){
		$query = "select a.kode, a.jenis_pelanggan, a.no_ang, a.nama_pelanggan from pelanggan a where (a.kode like '".$data['q']."%' or a.nama_pelanggan like '%".$data['q']."%')";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function getListPelangganAll($data){
		$query = "select a.kode, a.jenis_pelanggan, a.no_ang, a.nama_pelanggan from pelanggan a where (a.kode like '".$data['q']."%' or a.nama_pelanggan like '%".$data['q']."%')";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function SimpanBarang($data){
		$query = "";
		$username = $this->session->userdata('username');
		
		if($data['mode'] == "i"){
			$query = "insert into barang (kode, barcode, kategori, nama_barang, satuan, is_ppn, bkl, waktu_insert, waktu_update, is_hapus, user_id, is_aktif) 
			values('".$data['kode']."','".$data['barcode']."','".base64_decode($data['kategori'])."','".$this->db->escape_str($data['nama_barang'])."','".$data['satuan']."','".$data['is_ppn']."','".$data['is_bkl']."', NOW(), NOW(), 
			'0', '".$username."','".$data['is_aktif']."')";
		}else{
			$query = "update barang set barcode='".$data['barcode']."', kategori='".base64_decode($data['kategori'])."', nama_barang='".$this->db->escape_str($data['nama_barang'])."', satuan='".$data['satuan']."', 
			is_ppn='".$data['is_ppn']."', bkl='".$data['is_bkl']."', waktu_update=NOW(), 
			user_id='".$username."', is_aktif='".$data['is_aktif']."' 
			where kode='".$data['kode']."'";
		}
		
		$this->db->query($query);
	}
	
	//KPG validasi kode barang
	function getListBarangByCode($kode){
		$query = "select a.kode, a.nama_barang from barang a where a.kode = '".$kode."'";
		
		$result = $this->db->query($query);
		
		return $result;
	}
	
	function SimpanHargaBarang($data){
		$queryharga = "";
		$username = $this->session->userdata('username');

		$queryBarangToko = "insert ignore into barang_toko(barang_kode, toko_kode) values('".$data['kode']."', '".$data['toko_kode']."')";
		$this->db->query($queryBarangToko);
		
		$queryharga = "insert into harga_barang_toko (toko_kode, barang_kode, harga1, harga2, user_id, waktu_insert, waktu_update) 
		values('".$data['toko_kode']."','".$data['kode']."',".$data['harga1'].",".$data['harga1'].",'".$username."',NOW(),NOW()) on duplicate key update 
		harga1=".$data['harga1'].", harga2=".$data['harga1'].", user_id='".$username."', waktu_update=NOW()";
		
		$this->db->query($queryharga);
		
		// $queryHist = "insert into hist_harga_barang(kode, toko_kode, barang_kode, harga1, harga2, harga3, waktu_insert, user_id) 
		// values(UNIX_TIMESTAMP(), '".$data['toko_kode']."', '".$data['kode']."', ".$data['harga1'].",".$data['harga2'].",".$data['harga3'].", NOW(), '".$username."')";
		
		// $this->db->query($queryHist);
	}
	
	function HapusBarang($data){
		$this->db->trans_begin();

		$query = "update barang set is_hapus='1' where kode='".$data['kode']."'";

		$query1 = "DELETE from bad_stock where is_hapus='1' and barang_kode='".$data['kode']."'";
		$query2 = "DELETE from barang_supplier where barang_kode='".$data['kode']."'";
		$query3 = "DELETE from barang_toko where barang_kode='".$data['kode']."'";
		$query4 = "DELETE from bo_bad_stock where is_hapus='1' and barang_kode='".$data['kode']."'";
		$query5 = "DELETE from harga_barang_supplier where barang_kode='".$data['kode']."'";
		$query6 = "DELETE from harga_barang_toko where barang_kode='".$data['kode']."'";
		$query7 = "DELETE from hist_harga_barang where barang_kode='".$data['kode']."'";
		$query8 = "DELETE from minmax_stok_barang where barang_kode='".$data['kode']."'";
		$query9 = "DELETE from op where is_hapus='1' and barang_kode='".$data['kode']."'";
		$query10 = "DELETE from order_transfer where is_hapus='1' and barang_kode='".$data['kode']."'";
		$query11 = "DELETE from pengadaan_barang where is_hapus='1' and barang_kode='".$data['kode']."'";
		$query12 = "DELETE from pengadaan_barang_bkl where is_hapus='1' and barang_kode='".$data['kode']."'";
		$query13 = "DELETE from pengadaan_barang_konsinyasi where is_hapus='1' and barang_kode='".$data['kode']."'";
		$query14 = "DELETE from penyesuaian where is_hapus='1' and barang_kode='".$data['kode']."'";
		$query15 = "DELETE from planogram where barang_kode='".$data['kode']."'";
		$query16 = "DELETE from promo where barang_kode='".$data['kode']."'";
		$query17 = "DELETE from retur_supplier where is_hapus='1' and barang_kode='".$data['kode']."'";
		$query18 = "DELETE from retur_supplier_konsinyasi where is_hapus='1' and barang_kode='".$data['kode']."'";
		$query19 = "DELETE from retur_toko where is_hapus='1' and barang_kode='".$data['kode']."'";
		$query20 = "DELETE from retur_toko_konsinyasi where is_hapus='1' and barang_kode='".$data['kode']."'";
		$query21 = "DELETE from rst_fc_trans_detail where fstatuskey<>'1' and fitemkey='".$data['kode']."'";
		$query22 = "DELETE from saldo_barang_konsinyasi where barang_kode='".$data['kode']."'";
		$query23 = "DELETE from saldo_barang_toko where barang_kode='".$data['kode']."'";
		$query24 = "DELETE from stock_opname where barang_kode='".$data['kode']."'";
		$query25 = "DELETE from tau_keluar where is_hapus='1' and barang_kode='".$data['kode']."'";
		$query26 = "DELETE from tau_masuk where is_hapus='1' and barang_kode='".$data['kode']."'";
		$query27 = "DELETE from transfer_toko where is_hapus='1' and barang_kode='".$data['kode']."'";
		$query28 = "DELETE from transfer_toko_konsinyasi where is_hapus='1' and barang_kode='".$data['kode']."'";
		$query29 = "DELETE from barang where kode='".$data['kode']."'";

		$this->db->query($query);
		$this->db->query($query1);
		$this->db->query($query2);
		$this->db->query($query3);
		$this->db->query($query4);
		$this->db->query($query5);
		$this->db->query($query6);
		$this->db->query($query7);
		$this->db->query($query8);
		$this->db->query($query9);
		$this->db->query($query10);
		$this->db->query($query11);
		$this->db->query($query12);
		$this->db->query($query13);
		$this->db->query($query14);
		$this->db->query($query15);
		$this->db->query($query16);
		$this->db->query($query17);
		$this->db->query($query18);
		$this->db->query($query19);
		$this->db->query($query20);
		$this->db->query($query21);
		$this->db->query($query22);
		$this->db->query($query23);
		$this->db->query($query24);
		$this->db->query($query25);
		$this->db->query($query26);
		$this->db->query($query27);
		$this->db->query($query28);
		$this->db->query($query29);

		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
		}else{
			$this->db->trans_commit();
		}

		$querySelect = "select kode from barang where kode='".$data['kode']."'";
		$resultb = $this->db->query($querySelect);
		$resultbArr = $resultb->result_array();

		if(sizeof($resultbArr) > 0){
			return "-1";
		}else{
			return "1";
		}
	}

	function NonAktifBarang($data){
		$query = "update barang set is_aktif='0' where kode='".$data['kode']."'";
		$this->db->query($query);
	}

	function AktifkanBarang($data){
		$query = "update barang set is_aktif='1' where kode='".$data['kode']."'";
		$this->db->query($query);
	}
	
	function SimpanBarangSupplier($data){
		$queryDelete = "delete from barang_supplier where barang_kode='".$data['barang_kode']."'";
		$this->db->query($queryDelete);

		$query = "insert ignore into barang_supplier(barang_kode, supplier_kode) values('".$data['barang_kode']."', '".$data['supplier_kode']."')";
		
		$this->db->query($query);
	}
	
	function SimpanHargaBeliSupplier($data){
		$queryDelete = "delete from harga_barang_supplier where barang_kode='".$data['barang_kode']."'";
		$this->db->query($queryDelete);

		$query = "insert into harga_barang_supplier(barang_kode, supplier_kode, harga, harga_periode, periode) values('".$data['barang_kode']."', 
		'".$data['supplier_kode']."', ".$data['harga_beli_supplier'].", ".$data['harga_beli_supplier'].", NOW()) on duplicate key update 
		harga=".$data['harga_beli_supplier'].", harga_periode=".$data['harga_beli_supplier'].", periode=NOW()";
		
		$this->db->query($query);

		$queryUpdateHpp = "update barang set hpp=".$data['harga_beli_supplier']." where kode='".$data['barang_kode']."'";
		$this->db->query($queryUpdateHpp);

		$queryUpdateHpp2 = "insert into hpp (tahun, bulan, barang_kode, hpp) values(".date('Y').", ".date('m').", '".$data['barang_kode']."', ".$data['harga_beli_supplier'].") on duplicate key update hpp=".$data['harga_beli_supplier']."";
		$this->db->query($queryUpdateHpp2);
	}
	
	function SimpanBarangToko($data){
		$query = "insert ignore into barang_toko(barang_kode, toko_kode) values('".$data['barang_kode']."', '".$data['toko_kode']."')";
		$this->db->query($query);
	}
	
	function GetBarangSupplier($data){
		$query = "select a.supplier_kode, b.nama_supplier, if(date(NOW()) >= c.periode, c.harga_periode, c.harga) as harga, 
		c.periode from barang_supplier a left join supplier b on a.supplier_kode=b.kode 
		left join harga_barang_supplier c on a.barang_kode=c.barang_kode and a.supplier_kode=c.supplier_kode 
		where a.barang_kode='".$data['barang_kode']."'";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	function GetBarangToko($data){
		$query = "select c.toko_kode, d.nama as nama_toko, if(a.margin is null or a.margin<=0, b.margin_harga, a.margin) as margin_harga, if(a.margin2 is null or a.margin2<=0, b.margin_harga2, a.margin2) as margin_harga2, a.hpp, c.harga1 from barang a left join kategori_barang b on a.kategori=b.kode left join harga_barang_toko c on a.kode=c.barang_kode left join toko d on c.toko_kode=d.kode where a.kode='".$data['barang_kode']."' and d.is_hapus='0'";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	function DeleteAllBarangToko($data){
		$query = "DELETE from barang_toko where barang_kode='".$data['barang_kode']."'";
		$this->db->query($query);
	}

	function DeleteBarangToko($data){
		$query = "DELETE from barang_toko where barang_kode='".$data['barang_kode']."' and toko_kode='".$data['toko_kode']."'";
		$this->db->query($query);
	}
	
	function DeleteAllBarangSupplier($data){
		$query = "DELETE from barang_supplier where barang_kode='".$data['barang_kode']."'";
		$this->db->query($query);
	}

	function SimpanMarginHarga($data){
		if($data['margin1'] != "" && $data['margin1'] > 0){
			$query = "update barang set margin=".$data['margin1'].", margin2=".$data['margin1']." where kode='".$data['barang_kode']."'";

			$this->db->query($query);
		}
		if($data['harga_jual'] != "" && $data['harga_jual'] > 0){
			$query = "update harga_barang_toko set harga1=".$data['harga_jual'].", harga2=".$data['harga_jual']." where barang_kode='".$data['barang_kode']."'";

			$this->db->query($query);
		}
	}

	function getMarginKategori($data){
		$query = "select a.margin_harga from kategori_barang a where kode='".$data['kategori_kode']."'";
		
		$result = $this->db->query($query);
		$ResultArr = $result->result_array();

		if(sizeof($ResultArr) > 0){
			return $ResultArr[0]['margin_harga'];
		}else{
			return 0;
		}
	}

	function generateKodeBarang($data){
		$panjangKategori = strlen(trim($data['kategori_kode']));
		$panjangKategori += 1;
		if($panjangKategori > 3){
			$query = "select (SUBSTRING(kode, ".$panjangKategori.") + 1) as urut, kode, barcode, nama_barang, kategori from barang where kode LIKE '".$data['kategori_kode']."%' and concat('',SUBSTRING(kode, ".$panjangKategori.") * 1) = SUBSTRING(kode, ".$panjangKategori.") order by CAST(urut as UNSIGNED) desc limit 1";
		}else{
			$query = "select if(concat('',SUBSTRING(kode, 2) * 1) = SUBSTRING(kode, 2), (SUBSTRING(kode, 2) + 1), if(concat('',SUBSTRING(kode, 3) * 1) = SUBSTRING(kode, 3), (SUBSTRING(kode, 3) + 1), (SUBSTRING(kode, 2) + 1))) as urut, kode, barcode, nama_barang, kategori from barang order by CAST(urut as UNSIGNED) desc limit 1";
		}
		$query = "select (cast(replace(kode, kategori, '') as integer) + 1) as urut, kode, barcode, nama_barang, kategori from barang where kategori = '".$data['kategori_kode']."' and length(replace(kode, kategori, '')) < 7 order by CAST(urut as UNSIGNED) desc limit 1";
		
		$result = $this->db->query($query);
		$ResultArr = $result->result_array();

		if(sizeof($ResultArr) > 0){
			return $data['kategori_kode']."".$ResultArr[0]['urut'];
		}else{
			return $data['kategori_kode']."1";
		}
	}
}