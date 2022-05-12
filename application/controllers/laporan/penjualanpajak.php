<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Penjualanpajak extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('laporan_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('laporan/penjualanpajak');
		$this->load->view('general/footer');
	}
	
	public function getpenjualanpajak(){
		$DataPenjualanPajak = $this->laporan_model->getPenjualanBulanan($_POST);
		
		$TotalTunai = 0;
		$TotalKredit = 0;
		$TotalJumlah = 0;
		$TotalDPP = 0;
		$TotalPajak = 0;
		$html = "<table class=\"table table-striped table-bordered table-hover\">
					<thead>
						<tr>
							<th rowspan=\"2\">TANGGAL</th>
							<th colspan=\"2\">PENJUALAN</th>
							<th rowspan=\"2\">JUMLAH TERMASUK PAJAK</th>
							<th rowspan=\"2\">DPP</th>
							<th rowspan=\"2\">PAJAK</th>
						</tr>
						<tr>
							<td>TUNAI</td>
							<td>KREDIT</td>
						</tr>
					</thead>
					<tbody>";
		foreach ($DataPenjualanPajak as $key => $value) {
			$jumlah = $value['tunai'] + $value['kredit'];
			$dpp = $jumlah / 1.11; //k3pg-ppn
			$pajak = $dpp * 0.11; //k3pg-ppn
			$html .= "<tr>
						<td>".$value['fdate']."</td>
						<td align=\"right\">".round($value['tunai'],2)."</td>
						<td align=\"right\">".round($value['kredit'],2)."</td>
						<td align=\"right\">".round($jumlah,2)."</td>
						<td align=\"right\">".round($dpp,2)."</td>
						<td align=\"right\">".round($pajak,2)."</td>
					  </tr>";
					  
			$TotalTunai += $value['tunai'];
			$TotalKredit += $value['kredit'];
			$TotalJumlah += $jumlah;
			$TotalDPP += $dpp;
			$TotalPajak += $pajak;
		}
		$html .= "<tr>
					<td><strong>Total</strong></td>
					<td align=\"right\"><strong>".round($TotalTunai,2)."</strong></td>
					<td align=\"right\"><strong>".round($TotalKredit,2)."</strong></td>
					<td align=\"right\"><strong>".round($TotalJumlah,2)."</strong></td>
					<td align=\"right\"><strong>".round($TotalDPP,2)."</strong></td>
					<td align=\"right\"><strong>".round($TotalPajak,2)."</strong></td>
				  </tr>";
		$html .= "</tbody></table>";
		echo $html;
	}
	
	public function cetakpenjualanpajak(){
		$DataPenjualanPajak = $this->laporan_model->getPenjualanBulanan($_GET);
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;Filename=penjualan_bulanan_".$_GET['bulan']."_".$_GET['tahun'].".xls");
		
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
						<td align=\"center\" colspan=\"8\"><strong>LAPORAN PENJUALAN (PAJAK)</strong></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"8\"><strong>PERIODE : ".$_GET['bulan']." - ".$_GET['tahun']."</strong></td>
					</tr>
				 </table>";
		$TotalTunai = 0;
		$TotalKredit = 0;
		$TotalJumlah = 0;
		$TotalDPP = 0;
		$TotalPajak = 0;
		$html .= "<table border=\"1\">
					<thead>
						<tr>
							<th rowspan=\"2\">TANGGAL</th>
							<th colspan=\"2\">PENJUALAN</th>
							<th rowspan=\"2\">JUMLAH TERMASUK PAJAK</th>
							<th rowspan=\"2\">DPP</th>
							<th rowspan=\"2\">PAJAK</th>
						</tr>
						<tr>
							<td>TUNAI</td>
							<td>KREDIT</td>
						</tr>
					</thead>
					<tbody>";
		foreach ($DataPenjualanPajak as $key => $value) {
			$jumlah = $value['tunai'] + $value['kredit'];
			$dpp = $jumlah / 1.11; //k3pg-ppn
			$pajak = $dpp * 0.11; //k3pg-ppn
			$html .= "<tr>
						<td>".$value['fdate']."</td>
						<td align=\"right\">".round($value['tunai'],2)."</td>
						<td align=\"right\">".round($value['kredit'],2)."</td>
						<td align=\"right\">".round($jumlah,2)."</td>
						<td align=\"right\">".round($dpp,2)."</td>
						<td align=\"right\">".round($pajak,2)."</td>
					  </tr>";
					  
			$TotalTunai += $value['tunai'];
			$TotalKredit += $value['kredit'];
			$TotalJumlah += $jumlah;
			$TotalDPP += $dpp;
			$TotalPajak += $pajak;
		}
		$html .= "<tr>
					<td><strong>Total</strong></td>
					<td align=\"right\"><strong>".round($TotalTunai,2)."</strong></td>
					<td align=\"right\"><strong>".round($TotalKredit,2)."</strong></td>
					<td align=\"right\"><strong>".round($TotalJumlah,2)."</strong></td>
					<td align=\"right\"><strong>".round($TotalDPP,2)."</strong></td>
					<td align=\"right\"><strong>".round($TotalPajak,2)."</strong></td>
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