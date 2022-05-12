<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Penjualanbulanan extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('laporan_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('laporan/penjualanbulanan');
		$this->load->view('general/footer');
	}
	
	public function getpenjualanbulanan(){
		$DataPenjualanBulanan = $this->laporan_model->getPenjualanBulanan($_POST);
		
		$TotalKredit = 0;
		$TotalTunai = 0;
		$TotalTAU = 0;
		$html = "<table class=\"table table-striped table-bordered table-hover\">
					<thead>
						<tr>
							<th>TANGGAL</th>
							<th>TUNAI</th>
							<th>KREDIT</th>
							<th>TAU</th>
							<th>JUMLAH</th>
						</tr>
					</thead>
					<tbody>";
		foreach ($DataPenjualanBulanan as $key => $value) {
			$jumlah = $value['tunai'] + $value['kredit'] + $value['tau'];
			$html .= "<tr>
						<td>".$value['fdate']."</td>
						<td align=\"right\">".round($value['tunai'],2)."</td>
						<td align=\"right\">".round($value['kredit'],2)."</td>
						<td align=\"right\">".round($value['tau'],2)."</td>
						<td align=\"right\">".round($jumlah,2)."</td>
					  </tr>";
					  
			$TotalKredit += $value['kredit'];
			$TotalTunai += $value['tunai'];
			$TotalTAU += $value['tau'];
		}
		$html .= "<tr>
					<td><strong>Total</strong></td>
					<td align=\"right\"><strong>".round($TotalTunai,2)."</strong></td>
					<td align=\"right\"><strong>".round($TotalKredit,2)."</strong></td>
					<td align=\"right\"><strong>".round($TotalTAU,2)."</strong></td>
					<td align=\"right\"><strong>".round(($TotalKredit + $TotalTunai + $TotalTAU),2)."</strong></td>
				  </tr>";
		$html .= "</tbody></table>";
		echo $html;
	}
	
	public function cetakpenjualanbulanan(){
		$DataPenjualanBulanan = $this->laporan_model->getPenjualanBulanan($_GET);
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;Filename=penjualan_bulanan_".$_GET['bulan']."_".$_GET['tahun'].".xls");
		
		$TotalKredit = 0;
		$TotalTunai = 0;
		$TotalTAU = 0;
		$html = "<table>
					<tr>
						<td colspan=\"4\"><strong>KOPERASI KARYAWAN KELUARGA BESAR PETROKIMIA GRESIK</strong></td>
						<td align=\"right\" colspan=\"4\"><strong>TGL. : ".date("d-m-Y H:i:s")."</strong></th>
					</tr>
					<tr>
						<td colspan=\"4\"><strong>K-Mart</strong></td>
						<td colspan=\"4\"></th>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"8\"><strong>LAPORAN PENJUALAN BULANAN</strong></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"8\"><strong>PERIODE : ".$_GET['bulan']." - ".$_GET['tahun']."</strong></td>
					</tr>
				 </table>";
		$html .= "<table border=\"1\">
					<thead>
						<tr>
							<th>TANGGAL</th>
							<th>TUNAI</th>
							<th>KREDIT</th>
							<th>TAU</th>
							<th>JUMLAH</th>
						</tr>
					</thead>
					<tbody>";
		foreach ($DataPenjualanBulanan as $key => $value) {
			$jumlah = $value['tunai'] + $value['kredit'] + $value['tau'];
			$html .= "<tr>
						<td>".$value['fdate']."</td>
						<td align=\"right\">".round($value['tunai'],2)."</td>
						<td align=\"right\">".round($value['kredit'],2)."</td>
						<td align=\"right\">".round($value['tau'],2)."</td>
						<td align=\"right\">".round($jumlah,2)."</td>
					  </tr>";
					  
			$TotalKredit += $value['kredit'];
			$TotalTunai += $value['tunai'];
			$TotalTAU += $value['tau'];
		}
		$html .= "<tr>
					<td><strong>Total</strong></td>
					<td align=\"right\"><strong>".round($TotalTunai,2)."</strong></td>
					<td align=\"right\"><strong>".round($TotalKredit,2)."</strong></td>
					<td align=\"right\"><strong>".round($TotalTAU,2)."</strong></td>
					<td align=\"right\"><strong>".round(($TotalKredit + $TotalTunai + $TotalTAU),2)."</strong></td>
				  </tr>";
		$html .= "</tbody></table>";
		$html .= "<table>
					<tr>
						<td align=\"center\" colspan=\"4\">Mengetahui</td>
						<td align=\"center\" colspan=\"4\">Yang membuat</td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"4\"></td>
						<td align=\"center\" colspan=\"4\"></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"4\"></td>
						<td align=\"center\" colspan=\"4\"></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"4\"></td>
						<td align=\"center\" colspan=\"4\"></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"4\"><strong>(..............................)</strong></td>
						<td align=\"center\" colspan=\"4\"><strong>(..............................)</strong></td>
					</tr>
				  </table>";
		echo $html;
	}
}
?>