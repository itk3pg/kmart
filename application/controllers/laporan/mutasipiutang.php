<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mutasipiutang extends CI_Controller {
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
		$this->load->view('laporan/mutasipiutang', $Param);
		$this->load->view('general/footer');
	}
	
	public function getmutasipiutang(){
		$DataMutasiPiutang = $this->laporan_model->getMutasiPiutang($_POST);
		
		$html = "<table class=\"table table-striped table-bordered table-hover\">
					<thead>
						<tr>
							<th>KD Pelanggan</th>
							<th>Nama Pelanggan</th>
							<th width=\"150px\">Saldo Awal</th>
							<th width=\"150px\">Piutang</th>
							<th width=\"150px\">Pembayaran</th>
							<th width=\"150px\">Saldo Akhir</th>
						</tr>
					</thead>
					<tbody>";
		$jumlahSAwal = 0;
		$jumlahPiutang = 0;
		$jumlahBayar = 0;
		$jumlahSAkhir = 0;
		foreach ($DataMutasiPiutang as $key => $value) {
			$saldo_akhir = $value['saldo_awal'] + ($value['jm_piutang'] - $value['jm_bayar']);
			$html .= "<tr>
						<td>".$value['kode']."</td>
						<td>".$value['nama_pelanggan']."</td>
						<td align=\"right\">".number_format($value['saldo_awal'],2)."</td>
						<td align=\"right\">".number_format($value['jm_piutang'],2)."</td>
						<td align=\"right\">".number_format($value['jm_bayar'],2)."</td>
						<td align=\"right\">".number_format($saldo_akhir,2)."</td>
					 </tr>";
			$jumlahSAwal += $value['saldo_awal'];
			$jumlahPiutang += $value['jm_piutang'];
			$jumlahBayar += $value['jm_bayar'];
			$jumlahSAkhir += $saldo_akhir;
		}
		$html .= "<tr>
					<td colspan=\"2\"><strong>Jumlah</strong></td>
					<td align=\"right\"><strong>".number_format($jumlahSAwal,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($jumlahPiutang,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($jumlahBayar,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($jumlahSAkhir,2)."</strong></td>
				 </tr>";
		$html .=    "
					</tbody>
				 </table>";
				 
		echo $html;
	}
	
	public function cetakmutasipiutang(){
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;Filename=mutasi_piutang_".$_GET['bulan']."_".$_GET['tahun'].".xls");
		
		$DataMutasiPiutang = $this->laporan_model->getMutasiPiutang($_GET);
		
		$html = "<table>
					<tr>
						<td colspan=\"3\"><strong>KOPERASI KARYAWAN KELUARGA BESAR PETROKIMIA GRESIK</strong></td>
						<td align=\"right\" colspan=\"3\"><strong>TGL. : ".date("d-m-Y H:i:s")."</strong></th>
					</tr>
					<tr>
						<td colspan=\"3\"><strong>K-Mart</strong></td>
						<td colspan=\"3\"></th>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"6\"><strong>LAPORAN MUTASI PIUTANG</strong></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"6\"><strong>TOKO : ".$_GET['nama_toko']."</strong></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"6\"><strong>PERIODE : ".$_GET['bulan']." - ".$_GET['tahun']."</strong></td>
					</tr>
				 </table>";
		$html .= "<table border=\"1\">
					<thead>
						<tr>
							<th>KD Pelanggan</th>
							<th>Nama Pelanggan</th>
							<th width=\"150px\">Saldo Awal</th>
							<th width=\"150px\">Piutang</th>
							<th width=\"150px\">Pembayaran</th>
							<th width=\"150px\">Saldo Akhir</th>
						</tr>
					</thead>
					<tbody>";
		$jumlahSAwal = 0;
		$jumlahPiutang = 0;
		$jumlahBayar = 0;
		$jumlahSAkhir = 0;
		foreach ($DataMutasiPiutang as $key => $value) {
			$saldo_akhir = $value['saldo_awal'] + ($value['jm_piutang'] - $value['jm_bayar']);
			$html .= "<tr>
						<td>'".$value['kode']."</td>
						<td>".$value['nama_pelanggan']."</td>
						<td align=\"right\">".round($value['saldo_awal'],2)."</td>
						<td align=\"right\">".round($value['jm_piutang'],2)."</td>
						<td align=\"right\">".round($value['jm_bayar'],2)."</td>
						<td align=\"right\">".round($saldo_akhir,2)."</td>
					 </tr>";
			$jumlahSAwal += $value['saldo_awal'];
			$jumlahPiutang += $value['jm_piutang'];
			$jumlahBayar += $value['jm_bayar'];
			$jumlahSAkhir += $saldo_akhir;
		}
		$html .= "<tr>
					<td colspan=\"2\"><strong>Jumlah</strong></td>
					<td align=\"right\"><strong>".round($jumlahSAwal,2)."</strong></td>
					<td align=\"right\"><strong>".round($jumlahPiutang,2)."</strong></td>
					<td align=\"right\"><strong>".round($jumlahBayar,2)."</strong></td>
					<td align=\"right\"><strong>".round($jumlahSAkhir,2)."</strong></td>
				 </tr>";
		$html .=    "
					</tbody>
				 </table>";
		$html .= "<table>
					<tr>
						<td align=\"center\" colspan=\"3\">Mengetahui</td>
						<td align=\"center\" colspan=\"3\">Yang membuat</td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"3\"></td>
						<td align=\"center\" colspan=\"3\"></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"3\"></td>
						<td align=\"center\" colspan=\"3\"></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"3\"></td>
						<td align=\"center\" colspan=\"3\"></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"3\"><strong>(..................................)</strong></td>
						<td align=\"center\" colspan=\"3\"><strong>(..................................)</strong></td>
					</tr>
				  </table>";
		echo $html;
	}
}