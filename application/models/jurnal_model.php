<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

error_reporting(E_ALL);
set_time_limit(14400);
class Jurnal_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function getDataPiutangAnggota($data){
		$query = "select a.kd_prsh, a.nm_prsh, a.sub_akun, sum(a.total_omzet_sg + a.fvat_sg) as total_omzet_sg, sum(a.total_omzet_tb + a.fvat_tb) as total_omzet_tb, sum(a.omzet_kena_pajak_sg + a.fvat_sg) as omzet_kena_pajak_sg, sum(a.omzet_kena_pajak_tb + a.fvat_tb) as omzet_kena_pajak_tb, sum(a.omzet_tidak_kena_pajak_sg) as omzet_tidak_kena_pajak_sg, sum(a.omzet_tidak_kena_pajak_tb) as omzet_tidak_kena_pajak_tb from (select b.fcode, b.flokasi, d.kd_prsh, e.nm_prsh, e.sub_akun, d.no_peg, sum(if(b.flokasi='VO0001', a.ftotal, 0)) as total_omzet_sg, sum(if(b.flokasi='VO0002', a.ftotal, 0)) as total_omzet_tb, sum(if(b.flokasi='VO0001',if(c.is_ppn='1', a.ftotal, 0),0)) as omzet_kena_pajak_sg, sum(if(b.flokasi='VO0002',if(c.is_ppn='1', a.ftotal, 0),0)) as omzet_kena_pajak_tb, sum(if(b.flokasi='VO0001',if(c.is_ppn='1', 0, a.ftotal),0)) as omzet_tidak_kena_pajak_sg, sum(if(b.flokasi='VO0002',if(c.is_ppn='1', 0, a.ftotal),0)) as omzet_tidak_kena_pajak_tb, if(b.flokasi='VO0001', b.fvat, 0) as fvat_sg, if(b.flokasi='VO0002', b.fvat, 0) as fvat_tb from rst_fc_trans_detail a left join rst_fc_trans_header b on a.fcode=b.fcode and a.flokasi=b.flokasi left join barang c on a.fitemkey=c.kode left join pelanggan d on b.fcustkey=d.kode left join tbl_prsh e on d.kd_prsh=e.kd_prsh where month(b.fdate)=".$data['bulan']." and year(b.fdate)=".$data['tahun']." and (b.fname_payment='Kredit') and b.fbill_amount is not null and b.fstatuskey='1' and d.jenis_pelanggan='1440822187' and (b.flokasi='VO0001' or b.flokasi='VO0002') group by b.fcode) a group by a.kd_prsh";
		//echo $query;
		$result = $this->db->query($query);
		$this->db->close();
		return $result->result_array();
	}
}