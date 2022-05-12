<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setstockopname_model extends CI_Model {
	function __construct(){
		parent::__construct();
	}
	
	function setDataStockOpname($data){
		$query = "insert into stock_opname (bukti, toko_kode, barang_kode, rak, shlv, urut, tanggal, stok_sistem, hpp, waktu_insert, waktu_update) select '".$data['bukti']."' as bukti, a.toko_kode, a.barang_kode, '' as rak, '' as shlv, '' as urut, NOW() as tanggal, if(b.saldo_akhir_kwt is null, 0, b.saldo_akhir_kwt) as stok_sistem, if(c.hpp is null, 0, c.hpp) as hpp, NOW() as waktu_insert, NOW() as waktu_update from harga_barang_toko a left join (select barang_kode, toko_kode, saldo_akhir_kwt from saldo_barang_toko where tahun=year(NOW()) and bulan=month(NOW()) and toko_kode='".$data['toko_kode']."') b on a.barang_kode=b.barang_kode and a.toko_kode=b.toko_kode left join barang c on a.barang_kode=c.kode where a.toko_kode='".$data['toko_kode']."' on duplicate key update  stok_sistem=if(b.saldo_akhir_kwt is null, 0, b.saldo_akhir_kwt), hpp=if(c.hpp is null, 0, c.hpp)";
		
		if($data['toko_kode'] == "VO0006"){
			$query = "insert into stock_opname (bukti, toko_kode, barang_kode, rak, shlv, urut, tanggal, stok_sistem, hpp, waktu_insert, waktu_update) select '".$data['bukti']."' as bukti, '".$data['toko_kode']."' as toko_kode, a.kode as barang_kode, '' as rak, '' as shlv, '' as urut, NOW() as tanggal, if(b.saldo_akhir_kwt is null, 0, b.saldo_akhir_kwt) as stok_sistem, if(a.hpp is null, 0, a.hpp) as hpp, NOW() as waktu_insert, NOW() as waktu_update from barang a left join (select barang_kode, toko_kode, saldo_akhir_kwt from saldo_barang_toko where tahun=year(NOW()) and bulan=month(NOW()) and toko_kode='".$data['toko_kode']."') b on a.kode=b.barang_kode on duplicate key update stok_sistem=if(b.saldo_akhir_kwt is null, 0, b.saldo_akhir_kwt), hpp=if(a.hpp is null, 0, a.hpp)";
		}
		// echo $query;
		$this->db->query($query);
	}
}