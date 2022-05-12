<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kartuhutang extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('laporan_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('laporan/kartuhutang');
		$this->load->view('general/footer');
	}
	
	public function getkartuhutang(){
		$DataKartuHutang = $this->laporan_model->getKartuHutang($_POST);
		
		$supplier_kode = "";
		$jm_hutang = 0;
		$jm_bayar = 0;
		$jm_saldo = 0;
		$html = "<table class=\"table table-striped table-bordered table-hover\">
					<thead>
						<tr>
							<th>REF BUKTI</th>
							<th>TANGGAL</th>
							<th>HUTANG</th>
							<th>BAYAR</th>
							<th>SALDO</th>
						</tr>
					</thead>
					<tbody>";
		foreach ($DataKartuHutang as $key => $value) {
			$saldo = $value['jumlah'] - $value['bayar'];
			if($supplier_kode <> $value['supplier_kode']){
				if($supplier_kode <> ""){
					$html .= "<tr>
								<td colspan=\"2\"><strong>Jumlah</strong></td>
								<td align=\"right\"><strong>".number_format($jm_hutang,2)."</strong></td>
							  	<td align=\"right\"><strong>".number_format($jm_bayar,2)."</strong></td>
							  	<td align=\"right\"><strong>".number_format($jm_saldo,2)."</strong></td>
							  </tr>";
					$jm_hutang = 0;
					$jm_bayar = 0;
					$jm_saldo = 0;
				}
				$html .= "<tr>
							<td colspan=\"5\"><strong>".$value['supplier_kode']." : ".$value['nama_supplier']."</strong></td>
						  </tr>";
				$supplier_kode = $value['supplier_kode'];
			}
			$html .= "<tr>
					  	<td>".$value['ref_pengadaan']."</td>
					  	<td>".$value['tanggal_format']."</td>
					  	<td align=\"right\">".number_format($value['jumlah'],2)."</td>
					  	<td align=\"right\">".number_format($value['bayar'],2)."</td>
					  	<td align=\"right\">".number_format($saldo,2)."</td>
					  </tr>";
			$jm_hutang += $value['jumlah'];
			$jm_bayar += $value['bayar'];
			$jm_saldo += $saldo;
		}

		$html .= "<tr>
					<td colspan=\"2\"><strong>Jumlah</strong></td>
					<td align=\"right\"><strong>".number_format($jm_hutang,2)."</strong></td>
				  	<td align=\"right\"><strong>".number_format($jm_bayar,2)."</strong></td>
				  	<td align=\"right\"><strong>".number_format($jm_saldo,2)."</strong></td>
				  </tr>
				 </tbody>
				</table>";
				
		echo $html;
	}
	
	public function cetakkartuhutang(){
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;Filename=kartu_hutang_".$_GET['bulan']."_".$_GET['tahun'].".xls");
		
		$DataKartuHutang = $this->laporan_model->getKartuHutang($_GET);
		
		$supplier_kode = "";
		$jm_hutang = 0;
		$jm_bayar = 0;
		$jm_saldo = 0;
		$html = "<table>
					<tr>
						<td colspan=\"3\"><strong>KOPERASI KARYAWAN KELUARGA BESAR PETROKIMIA GRESIK</strong></td>
						<td align=\"right\" colspan=\"2\"><strong>TGL. : ".date("d-m-Y H:i:s")."</strong></th>
					</tr>
					<tr>
						<td colspan=\"3\"><strong>K-Mart</strong></td>
						<td colspan=\"2\"></th>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"5\"><strong>KARTU HUTANG</strong></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"5\"><strong>PERIODE : ".$_GET['bulan']." - ".$_GET['tahun']."</strong></td>
					</tr>
				 </table>";
		$html .= "<table border=\"1\">
					<thead>
						<tr>
							<th>REF BUKTI</th>
							<th>TANGGAL</th>
							<th>HUTANG</th>
							<th>BAYAR</th>
							<th>SALDO</th>
						</tr>
					</thead>
					<tbody>";
		foreach ($DataKartuHutang as $key => $value) {
			$saldo = $value['jumlah'] - $value['bayar'];
			if($supplier_kode <> $value['supplier_kode']){
				if($supplier_kode <> ""){
					$html .= "<tr>
								<td colspan=\"2\"><strong>Jumlah</strong></td>
								<td align=\"right\"><strong>".round($jm_hutang,2)."</strong></td>
							  	<td align=\"right\"><strong>".round($jm_bayar,2)."</strong></td>
							  	<td align=\"right\"><strong>".round($jm_saldo,2)."</strong></td>
							  </tr>";
					$jm_hutang = 0;
					$jm_bayar = 0;
					$jm_saldo = 0;
				}
				$html .= "<tr>
							<td colspan=\"5\"><strong>".$value['supplier_kode']." : ".$value['nama_supplier']."</strong></td>
						  </tr>";
				$supplier_kode = $value['supplier_kode'];
			}
			$html .= "<tr>
					  	<td>".$value['ref_pengadaan']."</td>
					  	<td>".$value['tanggal_format']."</td>
					  	<td align=\"right\">".round($value['jumlah'],2)."</td>
					  	<td align=\"right\">".round($value['bayar'],2)."</td>
					  	<td align=\"right\">".round($saldo,2)."</td>
					  </tr>";
			$jm_hutang += $value['jumlah'];
			$jm_bayar += $value['bayar'];
			$jm_saldo += $saldo;
		}

		$html .= "<tr>
					<td colspan=\"2\"><strong>Jumlah</strong></td>
					<td align=\"right\"><strong>".round($jm_hutang,2)."</strong></td>
				  	<td align=\"right\"><strong>".round($jm_bayar,2)."</strong></td>
				  	<td align=\"right\"><strong>".round($jm_saldo,2)."</strong></td>
				  </tr>
				 </tbody>
				</table>";
		$html .= "<table>
					<tr>
						<td align=\"center\" colspan=\"3\">Mengetahui</td>
						<td align=\"center\" colspan=\"2\">Yang membuat</td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"3\"></td>
						<td align=\"center\" colspan=\"2\"></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"3\"></td>
						<td align=\"center\" colspan=\"2\"></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"3\"></td>
						<td align=\"center\" colspan=\"2\"></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"3\"><strong>(..............................)</strong></td>
						<td align=\"center\" colspan=\"2\"><strong>(..............................)</strong></td>
					</tr>
				  </table>";
		echo $html;
	}
}