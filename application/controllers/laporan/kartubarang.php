<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kartubarang extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('laporan_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('laporan/kartubarang');
		$this->load->view('general/footer');
	}
	
	public function getkartubarang(){
		$DataKartuBarang = $this->laporan_model->getKartuBarang($_POST);
		
		$html = "<table class=\"table table-striped table-bordered table-hover\">
					<thead>
						<tr>
							<th rowspan='2'>TANGGAL</th>
							<th colspan='4'>BARANG MASUK</th>
							<th colspan='4'>BARANG KELUAR</th>
							<th colspan='3'>SALDO AKHIR</th>
						</tr>
						<tr>
							<th>BUKTI</th>
							<th>KWT</th>
							<th>HRG SATUAN</th>
							<th>HARGA</th>
							<th>BUKTI</th>
							<th>KWT</th>
							<th>HRG SATUAN</th>
							<th>HARGA</th>
							<th>KWT</th>
							<th>HRG SATUAN</th>
							<th>HARGA</th>
						</tr>
					</thead>
					<tbody>";
		foreach($DataKartuBarang as $key => $value){
			$mode = substr($value['ref_bukti'],0,2);
			if($mode == "BO" || $mode == "RS"){
				$html .= "<tr>
							<td>".$value['tanggal']."</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td>".$value['ref_bukti']."</td>
							<td align='right'>".$value['kwt_out']."</td>
							<td align='right'>".round($value['hsat_out'],2)."</td>
							<td align='right'>".round($value['jumlah_out'],2)."</td>
							<td align='right'>".$value['saldo_akhir_kwt']."</td>
							<td align='right'>".round($value['saldo_akhir_hsat'],2)."</td>
							<td align='right'>".round($value['jumlah_saldo_akhir'],2)."</td>
						  </tr>";
			}else if($mode == "TK"){
				$html .= "<tr>
							<td>".$value['tanggal']."</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td>".$value['ref_bukti']."</td>
							<td align='right'>".$value['tau_out']."</td>
							<td align='right'>".round($value['hsat_out'],2)."</td>
							<td align='right'>".round($value['jumlah_out'],2)."</td>
							<td align='right'>".$value['saldo_akhir_kwt']."</td>
							<td align='right'>".round($value['saldo_akhir_hsat'],2)."</td>
							<td align='right'>".round($value['jumlah_saldo_akhir'],2)."</td>
						  </tr>";
			}else{
				$html .= "<tr>
							<td>".$value['tanggal']."</td>
							<td>".$value['ref_bukti']."</td>
							<td>".$value['kwt_in']."</td>
							<td align='right'>".round($value['hsat_in'],2)."</td>
							<td align='right'>".round($value['jumlah_in'],2)."</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td align='right'>".$value['saldo_akhir_kwt']."</td>
							<td align='right'>".round($value['saldo_akhir_hsat'],2)."</td>
							<td align='right'>".round($value['jumlah_saldo_akhir'],2)."</td>
						  </tr>";
			}
		}
		
		echo $html;
	}
	
	public function cetakkartubarang(){
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;Filename=kartu_barang_".$_GET['barang_kode']."_".$_GET['bulan']."_".$_GET['tahun'].".xls");
		
		$DataKartuBarang = $this->laporan_model->getKartuBarang($_GET);
		
		$html = "<table>
					<tr>
						<td colspan=\"5\"><strong>KOPERASI KARYAWAN KELUARGA BESAR PETROKIMIA GRESIK</strong></td>
						<td align=\"right\" colspan=\"7\"><strong>TGL. : ".date("d-m-Y H:i:s")."</strong></th>
					</tr>
					<tr>
						<td colspan=\"5\"><strong>K-Mart</strong></td>
						<td colspan=\"7\"></th>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"12\"><strong>KARTU BARANG</strong></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"12\"><strong>PERIODE : ".$_GET['bulan']." - ".$_GET['tahun']."</strong></td>
					</tr>
				 </table>";
		$html .= "<table border=\"1\">
					<thead>
						<tr>
							<th colspan='5' align='left'>KODE BARANG : ".$DataKartuBarang[0]['barang_kode']."</th>
							<th colspan='7' align='left'>NAMA BARANG : ".$DataKartuBarang[0]['nama_barang']."</th>
						</tr>
						<tr>
							<th rowspan='2'>TANGGAL</th>
							<th colspan='4'>BARANG MASUK</th>
							<th colspan='4'>BARANG KELUAR</th>
							<th colspan='3'>SALDO AKHIR</th>
						</tr>
						<tr>
							<th>BUKTI</th>
							<th>KWT</th>
							<th>HRG SATUAN</th>
							<th>HARGA</th>
							<th>BUKTI</th>
							<th>KWT</th>
							<th>HRG SATUAN</th>
							<th>HARGA</th>
							<th>KWT</th>
							<th>HRG SATUAN</th>
							<th>HARGA</th>
						</tr>
					</thead>
					<tbody>";
		foreach($DataKartuBarang as $key => $value){
			$mode = substr($value['ref_bukti'],0,2);
			if($mode == "BO"){
				$html .= "<tr>
							<td>".$value['tanggal']."</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td>".$value['ref_bukti']."</td>
							<td align='right'>".$value['kwt_out']."</td>
							<td align='right'>".round($value['hsat_out'],2)."</td>
							<td align='right'>".round($value['jumlah_out'],2)."</td>
							<td align='right'>".$value['saldo_akhir_kwt']."</td>
							<td align='right'>".round($value['saldo_akhir_hsat'],2)."</td>
							<td align='right'>".round($value['jumlah_saldo_akhir'],2)."</td>
						  </tr>";
			}else{
				$html .= "<tr>
							<td>".$value['tanggal']."</td>
							<td>".$value['ref_bukti']."</td>
							<td>".$value['kwt_in']."</td>
							<td align='right'>".round($value['hsat_in'],2)."</td>
							<td align='right'>".round($value['jumlah_in'],2)."</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td align='right'>".$value['saldo_akhir_kwt']."</td>
							<td align='right'>".round($value['saldo_akhir_hsat'],2)."</td>
							<td align='right'>".round($value['jumlah_saldo_akhir'],2)."</td>
						  </tr>";
			}
		}
		
		echo $html;
	}
}

?>