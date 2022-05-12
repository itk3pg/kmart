<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Piutang_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function getDataPiutang($data){
		$query = "select d.ref_penjualan, d.no_kuitansi, d.pelanggan_kode, DATE_FORMAT(d.tanggal,'%d-%m-%Y') tanggal, d.jumlah, d.jatuh_tempo, d.is_lunas, d.nama_pelanggan, 
		sum(if(d.jumlah_bayar is null or d.is_hapus='1', 0, d.jumlah_bayar)) as jumlah_bayar from (select a.*, c.nama_pelanggan, 
		b.jumlah as jumlah_bayar, b.is_hapus from piutang a 
		left join pembayaran_piutang b on (a.ref_penjualan = b.ref_penjualan and a.pelanggan_kode=b.pelanggan_kode) 
		left join pelanggan c on a.pelanggan_kode = c.kode 
		where a.tanggal<='".$data['tahun']."-".$data['bulan']."-31' and a.toko_kode='".$data['toko_kode']."' and (a.is_lunas='0' or (month(b.tanggal)=".$data['bulan']." and year(b.tanggal)=".$data['tahun']."))) d group by d.ref_penjualan, d.pelanggan_kode";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	function getListDataPiutang($data){
		$query = "select d.ref_penjualan, d.pelanggan_kode, DATE_FORMAT(d.tanggal,'%d-%m-%Y') tanggal, d.jumlah, d.jatuh_tempo, d.is_lunas, d.nama_pelanggan, 
		sum(if(d.jumlah_bayar is null, 0, d.jumlah_bayar)) as jumlah_bayar from (select a.*, c.nama_pelanggan, 
		b.jumlah as jumlah_bayar, b.is_hapus from piutang a 
		left join pembayaran_piutang b on (a.ref_penjualan = b.ref_penjualan and a.pelanggan_kode=b.pelanggan_kode) 
		left join pelanggan c on a.pelanggan_kode = c.kode 
		where a.tanggal<='".$data['tahun']."-".$data['bulan']."-31' and (a.ref_penjualan like '".$data['q']."%' or c.nama_pelanggan like '%".$data['q']."%')) d where d.is_hapus is null or d.is_hapus='0' 
		group by d.ref_penjualan, d.pelanggan_kode";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	function getListDataPiutangPelanggan($data){
		$query = "select d.ref_penjualan, d.pelanggan_kode, DATE_FORMAT(d.tanggal,'%d-%m-%Y') tanggal, d.nama_pelanggan, d.jumlah, d.jatuh_tempo, d.is_lunas, 
		sum(if(d.jumlah_bayar is null, 0, d.jumlah_bayar)) as jumlah_bayar from (select a.*, b.jumlah as jumlah_bayar, c.nama_pelanggan, b.is_hapus from piutang a 
		left join pembayaran_piutang b on (a.ref_penjualan = b.ref_penjualan and a.pelanggan_kode=b.pelanggan_kode) left join pelanggan c on a.pelanggan_kode = c.kode where date(a.tanggal)<=date(NOW()) and a.pelanggan_kode='".$data['pelanggan_kode']."' and a.toko_kode='".$data['toko_kode']."' and (a.no_kuitansi is null or a.no_kuitansi='')) d where d.is_hapus is null or d.is_hapus='0' and d.is_lunas='0' group by d.ref_penjualan, d.pelanggan_kode";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	function getDetailPembayaran($data){
		$query = "select * from pembayaran_piutang where ref_penjualan='".$data['bukti_order']."' and pelanggan_kode='".$data['pelanggan_kode']."' and is_hapus='0'";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	function SimpanPembayaran($data){
		$this->load->model('bukti_model');
		$this->load->model('kasbank_model');
		/**
		 * `id_pembayaran` VARCHAR(45) NOT NULL,
			`ref_penjualan` VARCHAR(12) NOT NULL,
			`pelanggan_kode` VARCHAR(10) NOT NULL,
			`tanggal` DATETIME NULL DEFAULT NULL,
			`jumlah` DOUBLE NULL DEFAULT NULL,
			`ref_kasbank` VARCHAR(10) NULL DEFAULT NULL,
			`is_hapus` VARCHAR(1) NULL DEFAULT NULL,
			`tanggal_update` DATETIME NULL DEFAULT NULL,
			`user_id` VARCHAR(8) NULL DEFAULT NULL
		 */
		$username = $this->session->userdata('username');
		if($data['mode_form'] == 1){ // untuk insert pembayaran baru
			$ParamBukti = array();
			$ParamBukti['mode'] = "PP";
			$ParamBukti['tanggal'] = $data['tanggal'];
			//$TanggalArr = explode("-", $data['tanggal']);

			$getTokoPiutang = "select toko_kode from piutang where ref_penjualan='".$data['ref_penjualan']."' and pelanggan_kode='".$data['pelanggan_kode']."' and toko_kode='".$data['toko_kode']."'";
			$DataTokoPiutang = $this->db->query($getTokoPiutang);
			$DataTokoPiutangArr = $DataTokoPiutang->result_array();

			$id_pembayaran = $this->bukti_model->GenerateBukti($ParamBukti);
			$query = "insert into pembayaran_piutang(id_pembayaran, ref_penjualan, pelanggan_kode, tanggal, jumlah, ref_kasbank, is_hapus, 
			tanggal_update, user_id, toko_kode) values('".$id_pembayaran."','".$data['ref_penjualan']."','".$data['pelanggan_kode']."','".$data['tanggal']."',
			".$data['jumlah'].",'','0',NOW(),'".$username."', '".$DataTokoPiutangArr[0]['toko_kode']."')";
			
			$this->db->query($query);
			
			//$data['mode'] = "bayar";
			$this->HitungSaldoPiutang($data);
			
			// insert into kasbank
			$paramkasbank = array();
			if($data['pembayaran_ke'] == "112"){ // dari cek/giro
				$paramkasbank['mode'] = "BM";
			}else{
				$paramkasbank['mode'] = "KM";
			}
			$paramkasbank['kd_cb'] = "1201"; //102
			$paramkasbank['mode_form'] = "i";
			$paramkasbank['unit_kode'] = $this->session->userdata('toko_kode');
			$paramkasbank['kd_kb'] = $data['pembayaran_ke'];
			$paramkasbank['tanggal'] = $data['tanggal'];
			$paramkasbank['kd_subject'] = $data['pelanggan_kode'];
			$paramkasbank['nama_subject'] = $data['nama_pelanggan'];
			$paramkasbank['keterangan'] = "PELUNASAN PIUTANG ATAS ".$data['ref_penjualan'];
			$paramkasbank['jumlah'] = $data['jumlah'];
			$paramkasbank['no_ref'] = $id_pembayaran;
			
			$bukti_kasbank = $this->kasbank_model->SimpanKasbank($paramkasbank);
			
			// jika pelunasan lewat pusat
			if($data['pembayaran_ke'] == "112"){ // dari cek/giro
				$paramkasbank['mode'] = "BK";
			}else{
				$paramkasbank['mode'] = "KK";
			}
			if($data['pembayaran_melalui'] == "pusat"){ // lewat pusat
				// $paramkasbank['mode'] = "KK";
				$paramkasbank['kd_cb'] = "2802"; // 290
				$paramkasbank['mode_form'] = "i";
				$paramkasbank['unit_kode'] = $this->session->userdata('toko_kode');
				$paramkasbank['kd_kb'] = $data['pembayaran_ke']; // dari kas besar
				$paramkasbank['tanggal'] = $data['tanggal'];
				$paramkasbank['kd_subject'] = "1111117";
				$paramkasbank['nama_subject'] = "KASIR PUSAT KWSG";
				$paramkasbank['keterangan'] = "PELUNASAN PIUTANG ATAS ".$data['ref_penjualan'];
				$paramkasbank['jumlah'] = $data['jumlah'];
				$paramkasbank['no_ref'] = $id_pembayaran;
				
				$this->kasbank_model->SimpanKasbank($paramkasbank);
			}else if($data['pembayaran_melalui'] == "pajak"){ // lewat pajak
				// $paramkasbank['mode'] = "KK";
				$paramkasbank['kd_cb'] = "2051";
				$paramkasbank['mode_form'] = "i";
				$paramkasbank['unit_kode'] = $this->session->userdata('toko_kode');
				$paramkasbank['kd_kb'] = $data['pembayaran_ke']; // dari kas besar
				$paramkasbank['tanggal'] = $data['tanggal'];
				$paramkasbank['kd_subject'] = "1111121";
				$paramkasbank['nama_subject'] = "UNIT PAJAK DAN ASURANSI";
				$paramkasbank['keterangan'] = "PELUNASAN PIUTANG ATAS ".$data['ref_penjualan'];
				$paramkasbank['jumlah'] = $data['jumlah'];
				$paramkasbank['no_ref'] = $id_pembayaran;
				
				$this->kasbank_model->SimpanKasbank($paramkasbank);
			}
			
			$queryUpdate = "update pembayaran_piutang set ref_kasbank='".$bukti_kasbank."' where id_pembayaran='".$id_pembayaran."'";
			$this->db->query($queryUpdate);
		}else{ // untuk edit pembayaran
			$query = "update pembayaran_piutang set jumlah=".$data['jumlah'].", tanggal_update=NOW(), user_id='".$username."' 
			where id_pembayaran='".$data['id_pembayaran']."'";
			
			$this->db->query($query);
			
			$paramkasbank = array();
			$paramkasbank['jumlah'] = $data['jumlah'];
			//$data['mode'] = "editbayar";
			//$data['jumlah'] = $data['jumlah'] - $data['jumlah_lama'];
			$this->HitungSaldoPiutang($data);
			
			// edit data kasbank
			$paramkasbank['mode_form'] = "uh";
			$paramkasbank['unit_kode'] = $this->session->userdata('toko_kode');
			$paramkasbank['kd_kb'] = $data['pembayaran_ke'];
			//$paramkasbank['jumlah_lama'] = $data['jumlah_lama'];
			$paramkasbank['bukti_kasbank'] = $data['ref_kasbank'];
			
			$this->kasbank_model->SimpanKasbank($paramkasbank);
			
			$queryGetBuktiKasBank = "select bukti from kasbank where no_ref='".$data['ref_kasbank']."'";
			$resultbkb = $this->db->query($queryGetBuktiKasBank);
			$resultbkbArr = $resultbkb->result_array();
			
			$paramkasbank['kd_kb'] = "110"; // kas besar
			$paramkasbank['bukti_kasbank'] = $resultbkbArr[0]['bukti'];
			
			$bukti_kasbank = $this->kasbank_model->SimpanKasbank($paramkasbank);
		}

		$ParamData = array();
		//$ParamData['mode'] = "piutang";
		$ParamData['ref_penjualan'] = $data['ref_penjualan'];
		$ParamData['pelanggan_kode'] = $data['pelanggan_kode'];
		$ParamData['toko_kode'] = $data['toko_kode'];
		$this->CheckIsLunas($ParamData);
	}
	
	function HapusPembayaran($data){
		$this->load->model('kasbank_model');
		$query = "delete from pembayaran_piutang where id_pembayaran='".$data['id_pembayaran']."'";
		
		$this->db->query($query);
		
		//$data['mode'] = "deletebayar";
		$this->HitungSaldoPiutang($data);
		
		$ParamData = array();
		//$ParamData['mode'] = "piutang";
		$ParamData['ref_penjualan'] = $data['ref_penjualan'];
		$ParamData['pelanggan_kode'] = $data['pelanggan_kode'];
		$ParamData['toko_kode'] = $data['toko_kode'];
		$this->CheckIsLunas($ParamData);
		
		// hapus kasbank
		$queryGetKasBank = "select kd_kb, tanggal, unit_kode from kasbank where no_ref='".$data['id_pembayaran']."'";
		$result = $this->db->query($queryGetKasBank);
		$resultArr = $result->result_array();
		
		$querykasbank = "update kasbank set is_hapus='1' where no_ref='".$data['id_pembayaran']."'";
		$this->db->query($querykasbank);
		
		$data['kd_kb'] = $resultArr[0]['kd_kb'];
		$data['tanggal'] = $resultArr[0]['tanggal'];
		$data['unit_kode'] = $resultArr[0]['unit_kode'];
		$this->kasbank_model->HitungSaldoKasbank($data);
	}
	
	function CheckIsLunas($data){
		$query = "select a.ref_penjualan, a.pelanggan_kode, a.tanggal, a.jumlah as jml_piutang, sum(if(b.jumlah is null, 0, b.jumlah)) as jml_bayar 
		from piutang a left join pembayaran_piutang b on a.ref_penjualan=b.ref_penjualan and a.pelanggan_kode=b.pelanggan_kode 
		where a.ref_penjualan='".$data['ref_penjualan']."' and a.pelanggan_kode='".$data['pelanggan_kode']."' and a.toko_kode='".$data['toko_kode']."' group by a.ref_penjualan";
		
		$result = $this->db->query($query);
		$resultArr = $result->result_array();
		
		$jml_piutang = $resultArr[0]['jml_piutang'];
		$jml_bayar = $resultArr[0]['jml_bayar'];
		
		$sisa = $jml_piutang - $jml_bayar;
		
		$queryUpdate = "";
		if($sisa == 0){
			$queryUpdate = "update piutang set is_lunas='1' where ref_penjualan='".$data['ref_penjualan']."' and pelanggan_kode='".$data['pelanggan_kode']."' and toko_kode='".$data['toko_kode']."'";
		}else{
			$queryUpdate = "update piutang set is_lunas='0' where ref_penjualan='".$data['ref_penjualan']."' and pelanggan_kode='".$data['pelanggan_kode']."' and toko_kode='".$data['toko_kode']."'";
		}
		$this->db->query($queryUpdate);
	}
	
	function SimpanKuitansi($data){
		$query = "update piutang set no_kuitansi='".$data['nokuitansi']."', keterangan_kuitansi='".$this->db->escape_str($data['keterangan_kuitansi'])."' where ref_penjualan='".$data['ref_penjualan']."' 
		and pelanggan_kode='".$data['pelanggan_kode']."' and toko_kode='".$data['toko_kode']."'";
		
		$this->db->query($query);
	}
	
	 //k3pg-ppn
	function getDataBOKuitansi($data){
		$query = "select b.nama_pelanggan, a.no_kuitansi, a.keterangan_kuitansi, round(sum((a.jumlah/1.11)),2) as dpp, round(sum((a.jumlah/1)*0.11),2) as ppn from piutang a left join pelanggan b on a.pelanggan_kode=b.kode where a.no_kuitansi='".$data['no_kuitansi']."'";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	function getJumlahKuitansi($data){
		$query = "select sum(a.jumlah) as jumlah 
		from piutang a where a.no_kuitansi='".$data['no_kuitansi']."'";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	function BatalKuitansi($data){
		$query = "update piutang set no_kuitansi=null where no_kuitansi='".$data['no_kuitansi']."'";
		$this->db->query($query);
	}
	
	function getListBOKuitansi($data){
		$query = "select a.ref_penjualan, a.pelanggan_kode, a.jumlah, a.toko_kode 
		from piutang a where a.no_kuitansi='".$data['no_kuitansi']."'";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	 //k3pg-ppn
	function getRekapPiutangKuitansi($data){
		$query = "select a.fcode, DATE_FORMAT(a.fdate,'%d-%m-%Y') as fdate, a.fcustkey, a.fcustname, b.fitemkey, e.nama_barang, b.fqty, b.fprice, b.ftotal, if(e.is_ppn='1', (b.ftotal/1.11), b.ftotal) as dpp, if(e.is_ppn='1', ((b.ftotal/1.11) * 0.11), 0) as ppn from rst_fc_trans_header a left join user c on a.fcodecashier=c.username left join rst_fc_trans_detail b on a.fcode=b.fcode and a.flokasi=b.flokasi left join pelanggan d on a.fcustkey=d.kode left join barang e on b.fitemkey=e.kode left join piutang f on f.ref_penjualan=a.fcode and f.pelanggan_kode=a.fcustkey and f.toko_kode=a.flokasi where a.ftype='2' and f.no_kuitansi='".$data['no_kuitansi']."' and a.fbill_amount is not null and a.fstatuskey='1' order by a.fcustkey, date(a.fdate), a.fcode";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	function HitungSaldoPiutang($data){
		$dataArr = explode("-", $data['tanggal']);
		$data['bulan'] = intval($dataArr[1]);
		$data['tahun'] = intval($dataArr[0]);
		
		$bulansebelum = $data['bulan'] - 1;
		$tahunsebelum = $data['tahun'];
		if($bulansebelum == 0){
			$bulansebelum = 12;
			$tahunsebelum = $data['tahun'] - 1;
		}
		
		$querygetsaldoawal = "";
		if($data['bulan'] == 5 && $data['tahun'] == 2016){
			$querygetsaldoawal = "select a.saldo_awal saldo_akhir from saldo_piutang a where a.bulan=".$data['bulan']." 
			and a.tahun=".$data['tahun']." and a.pelanggan_kode='".$data['pelanggan_kode']."'";
		}else{
			$querygetsaldoawal = "select a.saldo_akhir from saldo_piutang a where a.bulan=".$bulansebelum." 
			and a.tahun=".$tahunsebelum." and a.pelanggan_kode='".$data['pelanggan_kode']."'";
		}
		
		$Resultsa = $this->db->query($querygetsaldoawal);
		$ResultArrsa = $Resultsa->result_array();
		
		$queryPiutang = "select pelanggan_kode, sum(jumlah) jumlah from piutang where month(tanggal)=".$data['bulan']." 
		and year(tanggal)=".$data['tahun']." 
		and pelanggan_kode='".$data['pelanggan_kode']."' group by pelanggan_kode";
		
		$Resultpiutang = $this->db->query($queryPiutang);
		$ResultArrpiutang = $Resultpiutang->result_array();
		
		$queryPembayaran = "select pelanggan_kode, sum(jumlah) jumlah from pembayaran_piutang where month(tanggal)=".$data['bulan']." 
		and year(tanggal)=".$data['tahun']." 
		and pelanggan_kode='".$data['pelanggan_kode']."' group by pelanggan_kode";
		
		$ResultPembayaran = $this->db->query($queryPembayaran);
		$ResultArrpembayaran = $ResultPembayaran->result_array();
		
		$SaldoAwal = 0;
		$piutang = 0;
		$pembayaran = 0;
		if(sizeof($ResultArrsa) > 0){
			$SaldoAwal = $ResultArrsa[0]['saldo_akhir'];
		}
		if(sizeof($ResultArrpiutang) > 0){
			$piutang = $ResultArrpiutang[0]['jumlah'];
		}
		if(sizeof($ResultArrpembayaran) > 0){
			$pembayaran = $ResultArrpembayaran[0]['jumlah'];
		}
		$SaldoAkhir = $SaldoAwal + ($piutang - $pembayaran);
		
		$querygetcurrent = "select * from saldo_piutang a where a.bulan=".$data['bulan']." 
		and a.tahun=".$data['tahun']." and a.pelanggan_kode='".$data['pelanggan_kode']."'";
		$Resultcurr = $this->db->query($querygetcurrent);
		$ResultArrcurr = $Resultcurr->result_array();
		
		if(sizeof($ResultArrcurr) > 0){
			$queryUpdate = "update saldo_piutang set saldo_awal=".$SaldoAwal.", piutang=".$piutang.", bayar=".$pembayaran.", 
			saldo_akhir=".$SaldoAkhir." where bulan=".$data['bulan']." and tahun=".$data['tahun']." and pelanggan_kode='".$data['pelanggan_kode']."'";
			
			$this->db->query($queryUpdate);
		}else{
			$queryInsert = "insert into saldo_piutang(pelanggan_kode, bulan, tahun, saldo_awal, piutang, bayar, saldo_akhir, 
			waktu_update) values('".$data['pelanggan_kode']."', ".$data['bulan'].", ".$data['tahun'].", ".$SaldoAwal.", 
			".$piutang.", ".$pembayaran.", ".$SaldoAkhir.", NOW())";
			
			$this->db->query($queryInsert);
		}
	}
}