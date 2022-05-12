<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Syncdata_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function getDataKategoriBarang(){
		$query = "select a.kode, a.nama, a.keterangan, a.parent, a.hist_parent, a.is_hapus from kategori_barang a;";
		
		$DataKategoriBarang = $this->db->query($query);
		$DataKategoriBarangArr = $DataKategoriBarang->result_array();
		
		$Text = "";
		foreach($DataKategoriBarangArr as $key => $value){
			$Text .= "insert into kategori_barang(kode, nama, keterangan, parent, hist_parent, is_hapus) values('".$this->db->escape_str($value['kode'])."', '".$this->db->escape_str($value['nama'])."', '".$this->db->escape_str($value['keterangan'])."', '".$this->db->escape_str($value['parent'])."', '".$this->db->escape_str($value['hist_parent'])."', '".$value['is_hapus']."') on duplicate key update nama='".$this->db->escape_str($value['nama'])."', keterangan='".$this->db->escape_str($value['keterangan'])."', parent='".$this->db->escape_str($value['parent'])."', hist_parent='".$this->db->escape_str($value['hist_parent'])."', is_hapus='".$value['is_hapus']."';";
		}
		
		return $Text;
	}
	
	function getDataPelanggan(){
		$query = "select a.kode, a.jenis_pelanggan, a.no_ang, a.nama_pelanggan, a.no_peg, a.no_peglm, a.kd_prsh, a.alamat, a.kota, a.provinsi, a.no_telp from pelanggan a";
		
		$DataPelanggan = $this->db->query($query);
		$DataPelangganArr = $DataPelanggan->result_array();
		
		$Text = "";
		foreach($DataPelangganArr as $key => $value){
			$Text .= "insert into pelanggan(kode, jenis_pelanggan, no_ang, nama_pelanggan, no_peg, no_peglm, kd_prsh, alamat, kota, provinsi, no_telp) values('".$this->db->escape_str($value['kode'])."', '".$this->db->escape_str($value['jenis_pelanggan'])."', '".$this->db->escape_str($value['no_ang'])."', '".$this->db->escape_str($value['nama_pelanggan'])."', '".$this->db->escape_str($value['no_peg'])."', '".$this->db->escape_str($value['no_peglm'])."', '".$this->db->escape_str($value['kd_prsh'])."', '".$this->db->escape_str($value['alamat'])."', '".$this->db->escape_str($value['kota'])."', '".$this->db->escape_str($value['provinsi'])."', '".$this->db->escape_str($value['no_telp'])."') on duplicate key update jenis_pelanggan='".$this->db->escape_str($value['jenis_pelanggan'])."', no_ang='".$this->db->escape_str($value['no_ang'])."', nama_pelanggan='".$this->db->escape_str($value['nama_pelanggan'])."', no_peg='".$this->db->escape_str($value['no_peg'])."', no_peglm='".$this->db->escape_str($value['no_peglm'])."', kd_prsh='".$this->db->escape_str($value['kd_prsh'])."', alamat='".$this->db->escape_str($value['alamat'])."', kota='".$this->db->escape_str($value['kota'])."', provinsi='".$this->db->escape_str($value['provinsi'])."', no_telp='".$this->db->escape_str($value['no_telp'])."';";
		}
		$Text .= "DELETE FROM pelanggan WHERE kode='0000000';";
		return $Text;
	}
	
	function getDataToko(){
		$query = "select a.kode, a.nama, a.alamat, a.kota, a.npwp, a.notelp, a.active, a.is_hapus from toko a";
		
		$DataToko = $this->db->query($query);
		$DataTokoArr = $DataToko->result_array();
		
		$Text = "";
		foreach($DataTokoArr as $key => $value){
			$Text .= "insert ignore into toko(kode, nama, alamat, kota, npwp, notelp, active, is_hapus) values('".$value['kode']."', '".$this->db->escape_str($value['nama'])."', '".$this->db->escape_str($value['alamat'])."', '".$this->db->escape_str($value['kota'])."', '".$value['npwp']."', '".$value['notelp']."', '".$value['active']."', '".$value['is_hapus']."');";
		}
		
		return $Text;
	}
	
	function getDataGroup(){
		$query = "select a.kode, a.nama, a.keterangan from `group` a";
		
		$DataGroup = $this->db->query($query);
		$DataGroupArr = $DataGroup->result_array();
		
		$Text = "";
		foreach($DataGroupArr as $key => $value){
			$Text .= "insert ignore into `group`(kode, nama, keterangan) values('".$value['kode']."', '".$this->db->escape_str($value['nama'])."', '".$this->db->escape_str($value['keterangan'])."');";
		}
		
		return $Text;
	}
	
	function getDataUser($data){
		$query = "select a.username, a.password, a.group_kode, a.nama, a.no_kasir, a.toko_kode, a.is_aktif from `user` a where a.toko_kode='".$data['toko_kode']."'";
		
		$DataUser = $this->db->query($query);
		$DataUserArr = $DataUser->result_array();
		
		$Text = "update `user` set is_aktif='0';";
		foreach($DataUserArr as $key => $value){
			$Text .= "insert into `user`(username, password, group_kode, nama, no_kasir, toko_kode, is_aktif) values('".$value['username']."', '".$value['password']."', '".$value['group_kode']."', '".$this->db->escape_str($value['nama'])."', '".$value['no_kasir']."', '".$value['toko_kode']."', '".$value['is_aktif']."') on duplicate key update nama='".$this->db->escape_str($value['nama'])."', no_kasir='".$value['no_kasir']."', toko_kode='".$value['toko_kode']."', is_aktif='".$value['is_aktif']."';";
		}
		
		return $Text;
	}
	
	function getDataBarang(){
		$query = "select a.kode, a.barcode, a.kategori, a.nama_barang, a.satuan, a.is_ppn, a.bkl, a.print, a.hpp, a.waktu_hpp, a.waktu_insert, a.waktu_update, 
		a.is_hapus, a.user_id, a.is_aktif from barang a";
		
		$DataBarang = $this->db->query($query);
		$DataBarangArr = $DataBarang->result_array();
		
		$Text = "";
		foreach($DataBarangArr as $key => $value){
			if($value['print'] == ""){
				$value['print'] = 'NULL';
			}
			if($value['hpp'] == ""){
				$value['hpp'] = 'NULL';
			}
			if($value['waktu_hpp'] == ""){
				$value['waktu_hpp'] = "NULL";
			}else{
				$value['waktu_hpp'] = "'".$value['waktu_hpp']."'";
			}
			$Text .= "insert into barang(kode, barcode, kategori, nama_barang, satuan, is_ppn, bkl, print, hpp, waktu_hpp, waktu_insert, waktu_update, is_hapus, user_id, 
			is_aktif) values('".$value['kode']."', '".$value['barcode']."', '".$this->db->escape_str($value['kategori'])."', '".$this->db->escape_str($value['nama_barang'])."', '".$value['satuan']."', 
			'".$value['is_ppn']."', '".$value['bkl']."', ".$value['print'].", ".$value['hpp'].", ".$value['waktu_hpp'].", '".$value['waktu_insert']."', '".$value['waktu_update']."', '".$value['is_hapus']."', 
			'".$value['user_id']."', '".$value['is_aktif']."') on duplicate key update barcode='".$value['barcode']."', kategori='".$this->db->escape_str($value['kategori'])."', nama_barang='".$this->db->escape_str($value['nama_barang'])."', 
			satuan='".$value['satuan']."', is_ppn='".$value['is_ppn']."', bkl='".$value['bkl']."', print=".$value['print'].", hpp=".$value['hpp'].", waktu_hpp=".$value['waktu_hpp'].", waktu_insert='".$value['waktu_insert']."', 
			waktu_update='".$value['waktu_update']."', is_hapus='".$value['is_hapus']."', user_id='".$value['user_id']."', is_aktif='".$value['is_aktif']."';";
		}
		
		return $Text;
	}
	
	function getDataHargaBarangToko($data){
		$query = "select a.toko_kode, a.barang_kode, if(a.harga1 is null,'null',a.harga1) as harga1 , if(a.harga2 is null,'null',a.harga2) as harga2, if(a.harga3 is null,'null',a.harga3) as harga3, a.user_id, a.waktu_insert, a.waktu_update 
		from harga_barang_toko a where a.toko_kode='".$data['toko_kode']."'";
		
		$DataHargaToko = $this->db->query($query);
		$DataHargaTokoArr = $DataHargaToko->result_array();
		
		$Text = "";
		foreach($DataHargaTokoArr as $key => $value){
			$Text .= "insert into harga_barang_toko(toko_kode, barang_kode, harga1, harga2, harga3, user_id, waktu_insert, waktu_update) 
			values('".$value['toko_kode']."', '".$value['barang_kode']."', ".$value['harga1'].", ".$value['harga2'].", 
			".$value['harga3'].", '".$value['user_id']."', '".$value['waktu_insert']."', '".$value['waktu_update']."') on duplicate key update 
			harga1=".$value['harga1'].", harga2=".$value['harga2'].", harga3=".$value['harga3'].", user_id='".$value['user_id']."', 
			waktu_insert='".$value['waktu_insert']."', waktu_update='".$value['waktu_update']."';";
		}
		
		return $Text;
	}
	
	function getDataPromo($data){
		$this->CheckPromo();
		
		$query = "select a.kode, a.toko_kode, a.barang_kode, if(a.persentase_promo is null,'null',a.persentase_promo) as persentase_promo, 
		if(a.harga_promo is null,'null',a.harga_promo) as harga_promo, if(a.kwt_kondisi is null,'null',a.kwt_kondisi) as kwt_kondisi, a.barang_promo, 
		if(a.kwt_promo is null,'null',a.kwt_promo) as kwt_promo, 
		a.tanggal_awal, a.tanggal_akhir, a.senin, a.selasa, a.rabu, a.kamis, a.jumat, a.sabtu, a.minggu, a.is_aktif, a.user_id, 
		a.waktu_insert, a.waktu_update from promo a where a.toko_kode='".$data['toko_kode']."'";
		
		$DataPromo = $this->db->query($query);
		$DataPromoArr = $DataPromo->result_array();
		
		$Text = "update promo set is_aktif='0' where 1;";
		foreach($DataPromoArr as $key => $value){
			$Text .= "insert into promo(kode, toko_kode, barang_kode, persentase_promo, harga_promo, kwt_kondisi, barang_promo, kwt_promo, 
			tanggal_awal, tanggal_akhir, senin, selasa, rabu, kamis, jumat, sabtu, minggu, is_aktif, user_id, waktu_insert, waktu_update) 
			values('".$value['kode']."','".$value['toko_kode']."','".$value['barang_kode']."',".$value['persentase_promo'].",".$value['harga_promo'].",".$value['kwt_kondisi'].",
			'".$value['barang_promo']."',".$value['kwt_promo'].",'".$value['tanggal_awal']."','".$value['tanggal_akhir']."','".$value['senin']."','".$value['selasa']."',
			'".$value['rabu']."','".$value['kamis']."','".$value['jumat']."','".$value['sabtu']."','".$value['minggu']."','".$value['is_aktif']."',
			'".$value['user_id']."','".$value['waktu_insert']."','".$value['waktu_update']."') on duplicate key update 
			persentase_promo=".$value['persentase_promo'].",harga_promo=".$value['harga_promo'].",kwt_kondisi=".$value['kwt_kondisi'].",
			barang_promo='".$value['barang_promo']."',kwt_promo=".$value['kwt_promo'].",tanggal_awal='".$value['tanggal_awal']."',
			tanggal_akhir='".$value['tanggal_akhir']."',senin='".$value['senin']."',selasa='".$value['selasa']."',rabu='".$value['rabu']."',
			kamis='".$value['kamis']."',jumat='".$value['jumat']."',sabtu='".$value['sabtu']."',minggu='".$value['minggu']."',
			is_aktif='".$value['is_aktif']."',user_id='".$value['user_id']."',waktu_insert='".$value['waktu_insert']."',waktu_update='".$value['waktu_update']."';";
		}
		
		return $Text;
	}
	
	function CheckPromo(){
		$query = "update promo a set a.is_aktif='0' where date(a.tanggal_akhir)<date(NOW())";
		
		$this->db->query($query);
	}
	
	function getDataStokToko($data){
		$query = "select a.toko_kode, a.barang_kode, a.tahun, a.bulan, a.saldo_awal_kwt, a.kwt_in, a.kwt_out, a.saldo_akhir_kwt, 
		a.waktu_update from saldo_barang_toko a where a.toko_kode='".$data['toko_kode']."' and a.tahun=".$data['tahun']." 
		and a.bulan=".$data['bulan'];
		
		$DataStokToko = $this->db->query($query);
		$DataStokTokoArr = $DataStokToko->result_array();
		
		$Text = "";
		foreach($DataStokTokoArr as $key => $value){
			$Text .= "insert into saldo_barang_toko(toko_kode, barang_kode, tahun, bulan, saldo_awal_kwt, kwt_in, kwt_out, saldo_akhir_kwt, waktu_update) 
			values('".$value['toko_kode']."', '".$value['barang_kode']."', ".$value['tahun'].", ".$value['bulan'].", 
			".$value['saldo_awal_kwt'].", ".$value['kwt_in'].", ".$value['kwt_out'].", ".$value['saldo_akhir_kwt'].", 
			'".$value['waktu_update']."') on duplicate key update saldo_awal_kwt=".$value['saldo_awal_kwt'].",kwt_in=".$value['kwt_in'].",
			kwt_out=".$value['kwt_out'].",saldo_akhir_kwt=".$value['saldo_akhir_kwt'].",waktu_update='".$value['waktu_update']."';";
		}
		
		return $Text;
	}
	
	function StartTransaction(){
		$this->db->query("START TRANSACTION");
	}
	
	function ExecuteImportDataToko($textQuery){
		if($textQuery != ""){
			$this->db->query($textQuery);
		}
	}
	
	function CommitTransaction(){
		$this->db->query("COMMIT");
	}
	
	function getDataTransHeader($data){
		$query = "select a.* from rst_fc_trans_header a where date(a.fdate)='".$data['tanggal']."' and a.flokasi='".$data['toko_kode']."'";
		
		$DataTransHeader = $this->db->query($query);
		$DataTransHeaderArr = $DataTransHeader->result_array();
		
		$Text = "";
		foreach($DataTransHeaderArr as $key => $value){
			$Text .= "insert into rst_fc_trans_header(fpkey, ftype, flokasi, fstatuskey, fcode, fdate, ftime, fcodecashier, fnocashier, fshift, 
			fcustkey, fcustname, fpos_discType, fpos_discValue, fpos_discount, fpos_serviceCharge, fpos_serviceCharge_count, fpos_tax, fpos_tax_count, 
			fpembulatan, fprinted, fbill_discby, fbill_taxby, fbill_scby, fcreateddt, fcancelby, fcanceldt, fdeleted, fcharge_trans, fvat, 
			fgrand_total, fcash_received, fcash_change, fshow_bill, fvoidby, fvoiddt, fvoidreason, fvoidclosingkey, fvoidclosingdate, 
			fvoidclosingtime, ftransType, fdesc, fclose, fclose_date, fpromokey, fcard_number, fflag_wr, fclosingkey, fstamps_email, 
			fstamps_reward, fbill_amount, fcash, fkupon, fshu, fdebet, fkredit, fpotga, fvoucher, ftau, fpoint, fchange, fpayment_type, 
			fname_payment, fnoslip_sipintar, funit, fbank_name, fcard_name, fnocredit_card, fnodebet_card, ftgl_update) 
			values(".$value['fpkey'].", ".$value['ftype'].", '".$value['flokasi']."', ".$value['fstatuskey'].", '".$value['fcode']."', 
			'".$value['fdate']."', '".$value['ftime']."', '".$value['fcodecashier']."', '".$value['fnocashier']."', ".$value['fshift'].", 
			'".$value['fcustkey']."', '".$this->db->escape_str($value['fcustname'])."', ".$value['fpos_discType'].", ".$value['fpos_discValue'].", 
			".$value['fpos_discount'].", ".$value['fpos_serviceCharge'].", ".$value['fpos_serviceCharge_count'].", ".$value['fpos_tax'].", 
			".$value['fpos_tax_count'].", ".$value['fpembulatan'].", ".$value['fprinted'].", ".$value['fbill_discby'].", ".$value['fbill_taxby'].", 
			".$value['fbill_scby'].", '".$value['fcreateddt']."', ".$value['fcancelby'].", '".$value['fcanceldt']."', ".$value['fdeleted'].", 
			".$value['fcharge_trans'].", ".$value['fvat'].", ".$value['fgrand_total'].", ".$value['fcash_received'].", ".$value['fcash_change'].", 
			".$value['fshow_bill'].", ".$value['fvoidby'].", '".$value['fvoiddt']."', '".$value['fvoidreason']."', ".$value['fvoidclosingkey'].", 
			'".$value['fvoidclosingdate']."', '".$value['fvoidclosingtime']."', ".$value['ftransType'].", '".$value['fdesc']."', ".$value['fclose'].", 
			'".$value['fclose_date']."', ".$value['fpromokey'].", '".$value['fcard_number']."', ".$value['fflag_wr'].", ".$value['fclosingkey'].", 
			'".$value['fstamps_email']."', ".$value['fstamps_reward'].", ".$value['fbill_amount'].", ".$value['fcash'].", ".$value['fkupon'].", 
			".$value['fshu'].", ".$value['fdebet'].", ".$value['fkredit'].", ".$value['fpotga'].", ".$value['fvoucher'].", ".$value['ftau'].", 
			".$value['fpoint'].", ".$value['fchange'].", ".$value['fpayment_type'].", '".$value['fname_payment']."', '".$value['fnoslip_sipintar']."', 
			'".$value['funit']."', '".$value['fbank_name']."', '".$value['fcard_name']."', '".$value['fnocredit_card']."', '".$value['fnodebet_card']."', 
			'".$value['ftgl_update']."') 
			on duplicate key update 
			fpkey=".$value['fpkey'].", ftype=".$value['ftype'].", fstatuskey=".$value['fstatuskey'].", fdate='".$value['fdate']."', 
			ftime='".$value['ftime']."', fcodecashier='".$value['fcodecashier']."', fnocashier='".$value['fnocashier']."', fshift=".$value['fshift'].", 
			fcustkey='".$value['fcustkey']."', fcustname='".$this->db->escape_str($value['fcustname'])."', fpos_discType=".$value['fpos_discType'].", 
			fpos_discValue=".$value['fpos_discValue'].", fpos_discount=".$value['fpos_discount'].", fpos_serviceCharge=".$value['fpos_serviceCharge'].", 
			fpos_serviceCharge_count=".$value['fpos_serviceCharge_count'].", fpos_tax=".$value['fpos_tax'].", 
			fpos_tax_count=".$value['fpos_tax_count'].", fpembulatan=".$value['fpembulatan'].", fprinted=".$value['fprinted'].", 
			fbill_discby=".$value['fbill_discby'].", fbill_taxby=".$value['fbill_taxby'].", fbill_scby=".$value['fbill_scby'].", 
			fcreateddt='".$value['fcreateddt']."', fcancelby=".$value['fcancelby'].", fcanceldt='".$value['fcanceldt']."', 
			fdeleted=".$value['fdeleted'].", fcharge_trans=".$value['fcharge_trans'].", fvat=".$value['fvat'].", 
			fgrand_total=".$value['fgrand_total'].", fcash_received=".$value['fcash_received'].", fcash_change=".$value['fcash_change'].", 
			fshow_bill=".$value['fshow_bill'].", fvoidby=".$value['fvoidby'].", fvoiddt='".$value['fvoiddt']."', fvoidreason='".$value['fvoidreason']."', 
			fvoidclosingkey=".$value['fvoidclosingkey'].", fvoidclosingdate='".$value['fvoidclosingdate']."', 
			fvoidclosingtime='".$value['fvoidclosingtime']."', ftransType=".$value['ftransType'].", fdesc='".$value['fdesc']."', 
			fclose=".$value['fclose'].", fclose_date='".$value['fclose_date']."', fpromokey=".$value['fpromokey'].", 
			fcard_number='".$value['fcard_number']."', fflag_wr=".$value['fflag_wr'].", fclosingkey=".$value['fclosingkey'].", 
			fstamps_email='".$value['fstamps_email']."', fstamps_reward=".$value['fstamps_reward'].", fbill_amount=".$value['fbill_amount'].", 
			fcash=".$value['fcash'].", fkupon=".$value['fkupon'].", fshu=".$value['fshu'].", fdebet=".$value['fdebet'].", 
			fkredit=".$value['fkredit'].", fpotga=".$value['fpotga'].", fvoucher=".$value['fvoucher'].", ftau=".$value['ftau'].", 
			fpoint=".$value['fpoint'].", fchange=".$value['fchange'].", fpayment_type=".$value['fpayment_type'].", 
			fname_payment='".$value['fname_payment']."', fnoslip_sipintar='".$value['fnoslip_sipintar']."', funit='".$value['funit']."', 
			fbank_name='".$value['fbank_name']."', fcard_name='".$value['fcard_name']."', fnocredit_card='".$value['fnocredit_card']."', 
			fnodebet_card='".$value['fnodebet_card']."', ftgl_update='".$value['ftgl_update']."';";
		}
		
		return $Text;
	}
	
	function getDataTransDetail($data){
		$query = "select a.* from rst_fc_trans_detail a where date(a.fcreateddt)='".$data['tanggal']."' and a.flokasi='".$data['toko_kode']."'";
		
		$DataTransDetail = $this->db->query($query);
		$DataTransDetailArr = $DataTransDetail->result_array();
		
		$Text = "";
		foreach($DataTransDetailArr as $key => $value){
			if($value['fdiscvalue']==""){$value['fdiscvalue'] = "NULL";}else{$value['fdiscvalue'] = $value['fdiscvalue'];}
			if($value['fdiscount']==""){$value['fdiscount'] = "NULL";}else{$value['fdiscount'] = $value['fdiscount'];}
			
			$Text = "insert into rst_fc_trans_detail(fpkey, fcode, flokasi, fstatuskey, fitemkey, fqty, fprice, fdisctype, fdiscvalue, fdiscount, 
			ftotal, fstok, fcreateddt, fcreatedby, fcanceldt, fcancelreason, fflag, fprint, fdiscpromoname, fnotesglobal, fpromokey, ftglupdate) 
			values(".$value['fpkey'].", '".$value['fcode']."', '".$value['flokasi']."', ".$value['fstatuskey'].", '".$value['fitemkey']."', ".$value['fqty'].", 
			".$value['fprice'].", ".$value['fdisctype'].", ".$value['fdiscvalue'].", ".$value['fdiscount'].", ".$value['ftotal'].", ".$value['fstok'].", 
			'".$value['fcreateddt']."', ".$value['fcreatedby'].", '".$value['fcanceldt']."', '".$value['fcancelreason']."', ".$value['fflag'].", 
			".$value['fprint'].", '".$value['fdiscpromoname']."', '".$value['fnotesglobal']."', ".$value['fpromokey'].", '".$value['ftglupdate']."') 
			on duplicate key update 
			fstatuskey=".$value['fstatuskey'].", fitemkey='".$value['fitemkey']."', fqty=".$value['fqty'].", fprice=".$value['fprice'].", 
			fdisctype=".$value['fdisctype'].", fdiscvalue=".$value['fdiscvalue'].", fdiscount=".$value['fdiscount'].", 
			ftotal=".$value['ftotal'].", fstok=".$value['fstok'].", fcreateddt='".$value['fcreateddt']."', fcreatedby=".$value['fcreatedby'].", 
			fcanceldt='".$value['fcanceldt']."', fcancelreason='".$value['fcancelreason']."', fflag=".$value['fflag'].", fprint=".$value['fprint'].", 
			fdiscpromoname='".$value['fdiscpromoname']."', fnotesglobal='".$value['fnotesglobal']."', fpromokey=".$value['fpromokey'].", 
			ftglupdate='".$value['ftglupdate']."';";
		}
		
		return $Text;
	}
	
	function getDataKasbankPenjualan($data){
		$query = "select a.bukti, a.kd_kb, a.kd_cb, a.tanggal, a.kode_subject, a.nama_subject, a.keterangan, a.jumlah, a.no_ref, 
		a.toko_kode, a.fcharge_trans, a.user_id, a.is_hapus, a.waktu_update 
		from kasbank a where date(a.tanggal)='".$data['tanggal']."' and a.toko_kode='".$data['toko_kode']."'";
		
		$DataKasbank = $this->db->query($query);
		$DataKasbankArr = $DataKasbank->result_array();
		
		$Text = "";
		foreach($DataKasbankArr as $key => $value){
			$Text .= "insert into kasbank(bukti, kd_kb, kd_cb, tanggal, kode_subject, nama_subject, keterangan, jumlah, no_ref, toko_kode, 
			fcharge_trans, user_id, is_hapus, waktu_update) values('".$value['bukti']."', '".$value['kd_kb']."', '".$value['kd_cb']."', 
			'".$value['tanggal']."', '".$value['kode_subject']."', '".$this->db->escape_str($value['nama_subject'])."', '".$this->db->escape_str($value['keterangan'])."', 
			".$value['jumlah'].", '".$value['no_ref']."', '".$value['toko_kode']."', '".$value['fcharge_trans']."', '".$value['user_id']."', 
			'".$value['is_hapus']."', '".$value['waktu_update']."') on duplicate key update tanggal='".$value['tanggal']."', 
			kode_subject='".$value['kode_subject']."', nama_subject='".$this->db->escape_str($value['nama_subject'])."', 
			keterangan='".$this->db->escape_str($value['keterangan'])."', jumlah=".$value['jumlah'].", no_ref='".$value['no_ref']."', 
			toko_kode='".$value['toko_kode']."', fcharge_trans='".$value['fcharge_trans']."', user_id='".$value['user_id']."', 
			is_hapus='".$value['is_hapus']."', waktu_update='".$value['waktu_update']."';";
		}
		
		return $Text;
	}
}

?>
