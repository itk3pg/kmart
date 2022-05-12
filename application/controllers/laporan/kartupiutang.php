<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kartupiutang extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('laporan_model');
		$this->load->model('toko_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$DataToko = $this->toko_model->getDataToko();
		
		$Param  = array();
		$Param['DataToko'] = $DataToko;
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('laporan/kartupiutang', $Param);
		$this->load->view('general/footer');
	}
	
	public function getkartupiutang(){
		$DataKartuPiutang = $this->laporan_model->getKartuPiutang($_POST);
		
		$kd_pelanggan = "";
		$jm_piutang = 0;
		$jm_bayar = 0;
		$jm_saldo = 0;
		$html = "<table class=\"table table-striped table-bordered table-hover\">
					<thead>
						<tr>
							<th>REF BUKTI</th>
							<th>TANGGAL</th>
							<th>PIUTANG</th>
							<th>BAYAR</th>
							<th>SALDO</th>
						</tr>
					</thead>
					<tbody>";
		foreach ($DataKartuPiutang as $key => $value) {
			$saldo = $value['jumlah'] - $value['bayar'];
			if($kd_pelanggan <> $value['pelanggan_kode']){
				if($kd_pelanggan <> ""){
					$html .= "<tr>
								<td colspan=\"2\"><strong>Jumlah</strong></td>
								<td align=\"right\"><strong>".round($jm_piutang,2)."</strong></td>
							  	<td align=\"right\"><strong>".round($jm_bayar,2)."</strong></td>
							  	<td align=\"right\"><strong>".round($jm_saldo,2)."</strong></td>
							  </tr>";
					$jm_piutang = 0;
					$jm_bayar = 0;
					$jm_saldo = 0;
				}
				$html .= "<tr>
							<td colspan=\"5\"><strong>".$value['pelanggan_kode']." : ".$value['nama_pelanggan']."</strong></td>
						  </tr>";
				$kd_pelanggan = $value['pelanggan_kode'];
			}
			$html .= "<tr>
					  	<td>".$value['ref_penjualan']."</td>
					  	<td>".$value['tanggal_format']."</td>
					  	<td align=\"right\">".round($value['jumlah'],2)."</td>
					  	<td align=\"right\">".round($value['bayar'],2)."</td>
					  	<td align=\"right\">".round($saldo,2)."</td>
					  </tr>";
			$jm_piutang += $value['jumlah'];
			$jm_bayar += $value['bayar'];
			$jm_saldo += $saldo;
		}

		$html .= "<tr>
					<td colspan=\"2\"><strong>Jumlah</strong></td>
					<td align=\"right\"><strong>".round($jm_piutang,2)."</strong></td>
				  	<td align=\"right\"><strong>".round($jm_bayar,2)."</strong></td>
				  	<td align=\"right\"><strong>".round($jm_saldo,2)."</strong></td>
				  </tr>
				 </tbody>
				</table>";
				
		echo $html;
	}
	
	public function cetakkartupiutang(){
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;Filename=kartu_piutang_".$_GET['bulan']."_".$_GET['tahun'].".xls");
		
		$DataKartuPiutang = $this->laporan_model->getKartuPiutang($_GET);
		
		$kd_pelanggan = "";
		$jm_piutang = 0;
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
						<td align=\"center\" colspan=\"5\"><strong>KARTU PIUTANG</strong></td>
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
							<th>PIUTANG</th>
							<th>BAYAR</th>
							<th>SALDO</th>
						</tr>
					</thead>
					<tbody>";
		foreach ($DataKartuPiutang as $key => $value) {
			$saldo = $value['jumlah'] - $value['bayar'];
			if($kd_pelanggan <> $value['pelanggan_kode']){
				if($kd_pelanggan <> ""){
					$html .= "<tr>
								<td colspan=\"2\"><strong>Jumlah</strong></td>
								<td align=\"right\"><strong>".round($jm_piutang,2)."</strong></td>
							  	<td align=\"right\"><strong>".round($jm_bayar,2)."</strong></td>
							  	<td align=\"right\"><strong>".round($jm_saldo,2)."</strong></td>
							  </tr>";
					$jm_piutang = 0;
					$jm_bayar = 0;
					$jm_saldo = 0;
				}
				$html .= "<tr>
							<td colspan=\"5\"><strong>".$value['pelanggan_kode']." : ".$value['nama_pelanggan']."</strong></td>
						  </tr>";
				$kd_pelanggan = $value['pelanggan_kode'];
			}
			$html .= "<tr>
					  	<td>".$value['ref_penjualan']."</td>
					  	<td>".$value['tanggal_format']."</td>
					  	<td align=\"right\">".round($value['jumlah'],2)."</td>
					  	<td align=\"right\">".round($value['bayar'],2)."</td>
					  	<td align=\"right\">".round($saldo,2)."</td>
					  </tr>";
			$jm_piutang += $value['jumlah'];
			$jm_bayar += $value['bayar'];
			$jm_saldo += $saldo;
		}

		$html .= "<tr>
					<td colspan=\"2\"><strong>Jumlah</strong></td>
					<td align=\"right\"><strong>".round($jm_piutang,2)."</strong></td>
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