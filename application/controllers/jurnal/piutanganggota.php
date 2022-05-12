<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Piutanganggota extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('jurnal_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('jurnal/piutanganggota');
		$this->load->view('general/footer');
	}
	
	public function getdatapiutanganggota(){
		$DataPiutangAnggota = $this->jurnal_model->getDataPiutangAnggota($_POST);
		
		$html = "<table class=\"table table-striped table-bordered table-hover\">
					<thead>
						<tr>
							<th rowspan=\"2\" class='text-center'>No Urut</th>
							<th colspan=\"5\" class='text-center'>Perkiraan</th>
							<th rowspan=\"2\" class='text-center'>Uraian</th>
							<th colspan=\"2\" class='text-center'>Jumlah Rupiah</th>
						</tr>
						<tr>
							<th colspan=\"2\">Debet</th>
							<th colspan=\"2\">Kredit</th>
							<th>Sub Akun</th>
							<th>Debet</th>
							<th>Kredit</th>
						</tr>
					</thead>
					<tbody>";
		
		$JumlahDebet = 0;
		$JumlahKredit = 0;
		$TotalPendapatanSG = 0;
		$TotalPendapatanTB = 0;
		$TotalPajakSG = 0;
		$TotalPajakTB = 0;
		$inc = 1;
		foreach ($DataPiutangAnggota as $key => $value) {
			$JumlahOmzet = $value['total_omzet_sg'] + $value['total_omzet_tb'];
			$html .= "<tr>
						<td>".$inc."</td>
						<td>11420</td>
						<td>3200</td>
						<td></td>
						<td></td>
						<td>".$value['sub_akun']."</td>
						<td>".$value['nm_prsh']."</td>
						<td align=\"right\">".number_format($JumlahOmzet)."</td>
						<td align=\"right\">".number_format(0)."</td>
					</tr>";
			$JumlahDebet += $JumlahOmzet;
			
			$DPPSG = ($value['omzet_kena_pajak_sg'] / 1.11); //k3pg-ppn
			$DPPTB = ($value['omzet_kena_pajak_tb'] / 1.11); //k3pg-ppn
			
			$TotalPendapatanSG += ($DPPSG + $value['omzet_tidak_kena_pajak_sg']);
			$TotalPendapatanTB += ($DPPTB + $value['omzet_tidak_kena_pajak_tb']);
			
			$TotalPajakSG += ($DPPSG * 0.11); //k3pg-ppn
			$TotalPajakTB += ($DPPTB * 0.11); //k3pg-ppn
			
			$inc++;
		}
		$html .= "<tr>
					<td>".$inc."</td>
					<td></td>
					<td></td>
					<td>31201</td>
					<td>3201</td>
					<td></td>
					<td>PENDAPT.KREDIT BAHAN TKSG</td>
					<td align=\"right\">".number_format(0)."</td>
					<td align=\"right\">".number_format($TotalPendapatanSG)."</td>
				</tr>";
		$inc++;
		$html .= "<tr>
					<td>".$inc."</td>
					<td></td>
					<td></td>
					<td>21510</td>
					<td>3201</td>
					<td></td>
					<td>PPN SEDERHANA</td>
					<td align=\"right\">".number_format(0)."</td>
					<td align=\"right\">".number_format($TotalPajakSG)."</td>
				</tr>";
		$inc++;
		$html .= "<tr>
					<td>".$inc."</td>
					<td></td>
					<td></td>
					<td>31201</td>
					<td>3203</td>
					<td></td>
					<td>PENDAPT.KREDIT BAHAN TKTN</td>
					<td align=\"right\">".number_format(0)."</td>
					<td align=\"right\">".number_format($TotalPendapatanTB)."</td>
				</tr>";
		$inc++;
		$html .= "<tr>
					<td>".$inc."</td>
					<td></td>
					<td></td>
					<td>21510</td>
					<td>3203</td>
					<td></td>
					<td>PPN SEDERHANA</td>
					<td align=\"right\">".number_format(0)."</td>
					<td align=\"right\">".number_format($TotalPajakTB)."</td>
				</tr>";
		$JumlahKredit = $TotalPendapatanSG + $TotalPajakSG + $TotalPendapatanTB + $TotalPajakTB;
		$html .= "<tr>
					<td colspan=\"7\"><strong>Total</strong></td>
					<td align=\"right\"><strong>".number_format($JumlahDebet)."</strong></td>
					<td align=\"right\"><strong>".number_format($JumlahKredit)."</strong></td>
				</tr>";
		$html .= "</tbody></table>";
		
		echo $html;
	}
	
	public function cetakdatapiutanganggota(){
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;Filename=jurnal_kredit_pg_".$_GET['bulan']."_".$_GET['tahun'].".xls");
		
		$html = "<table>
					<tr>
						<td colspan=\"4\"><strong>KOPERASI KARYAWAN KELUARGA BESAR PETROKIMIA GRESIK</strong></td>
						<td align=\"right\" colspan=\"4\"><strong>TGL. : ".date("d-m-Y")."</strong></th>
					</tr>
					<tr>
						<td colspan=\"4\"><strong>Unit Akuntansi</strong></td>
						<td colspan=\"4\"></th>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"8\"><strong>Penjualan Kredit Anggota (PG)</strong></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"8\"><strong>PERIODE : ".$_GET['bulan']." - ".$_GET['tahun']."</strong></td>
					</tr>
				 </table>";
		$DataPiutangAnggota = $this->jurnal_model->getDataPiutangAnggota($_GET);
		$html .= "<table border=\"1\">
					<thead>
						<tr>
							<th rowspan=\"2\" class='text-center'>No Urut</th>
							<th colspan=\"5\" class='text-center'>Perkiraan</th>
							<th rowspan=\"2\" class='text-center'>Uraian</th>
							<th colspan=\"2\" class='text-center'>Jumlah Rupiah</th>
						</tr>
						<tr>
							<th colspan=\"2\">Debet</th>
							<th colspan=\"2\">Kredit</th>
							<th>Sub Akun</th>
							<th>Debet</th>
							<th>Kredit</th>
						</tr>
					</thead>
					<tbody>";
		
		$JumlahDebet = 0;
		$JumlahKredit = 0;
		$TotalPendapatanSG = 0;
		$TotalPendapatanTB = 0;
		$TotalPajakSG = 0;
		$TotalPajakTB = 0;
		$inc = 1;
		foreach ($DataPiutangAnggota as $key => $value) {
			$JumlahOmzet = $value['total_omzet_sg'] + $value['total_omzet_tb'];
			$html .= "<tr>
						<td>".$inc."</td>
						<td>11420</td>
						<td>3200</td>
						<td></td>
						<td></td>
						<td>".$value['sub_akun']."</td>
						<td>".$value['nm_prsh']."</td>
						<td align=\"right\">".round($JumlahOmzet)."</td>
						<td align=\"right\">".round(0)."</td>
					</tr>";
			$JumlahDebet += $JumlahOmzet;
			
			$DPPSG = ($value['omzet_kena_pajak_sg'] / 1.11); //k3pg-ppn
			$DPPTB = ($value['omzet_kena_pajak_tb'] / 1.11); //k3pg-ppn
			
			$TotalPendapatanSG += ($DPPSG + $value['omzet_tidak_kena_pajak_sg']);
			$TotalPendapatanTB += ($DPPTB + $value['omzet_tidak_kena_pajak_tb']);
			
			$TotalPajakSG += ($DPPSG * 0.11); //k3pg-ppn
			$TotalPajakTB += ($DPPTB * 0.11); //k3pg-ppn
			
			$inc++;
		}
		$html .= "<tr>
					<td>".$inc."</td>
					<td></td>
					<td></td>
					<td>31201</td>
					<td>3201</td>
					<td></td>
					<td>PENDAPT.KREDIT BAHAN TKSG</td>
					<td align=\"right\">".round(0)."</td>
					<td align=\"right\">".round($TotalPendapatanSG)."</td>
				</tr>";
		$inc++;
		$html .= "<tr>
					<td>".$inc."</td>
					<td></td>
					<td></td>
					<td>21510</td>
					<td>3201</td>
					<td></td>
					<td>PPN SEDERHANA</td>
					<td align=\"right\">".round(0)."</td>
					<td align=\"right\">".round($TotalPajakSG)."</td>
				</tr>";
		$inc++;
		$html .= "<tr>
					<td>".$inc."</td>
					<td></td>
					<td></td>
					<td>31201</td>
					<td>3203</td>
					<td></td>
					<td>PENDAPT.KREDIT BAHAN TKTN</td>
					<td align=\"right\">".round(0)."</td>
					<td align=\"right\">".round($TotalPendapatanTB)."</td>
				</tr>";
		$inc++;
		$html .= "<tr>
					<td>".$inc."</td>
					<td></td>
					<td></td>
					<td>21510</td>
					<td>3203</td>
					<td></td>
					<td>PPN SEDERHANA</td>
					<td align=\"right\">".round(0)."</td>
					<td align=\"right\">".round($TotalPajakTB)."</td>
				</tr>";
		$JumlahKredit = $TotalPendapatanSG + $TotalPajakSG + $TotalPendapatanTB + $TotalPajakTB;
		$html .= "<tr>
					<td colspan=\"7\"><strong>Total</strong></td>
					<td align=\"right\"><strong>".round($JumlahDebet)."</strong></td>
					<td align=\"right\"><strong>".round($JumlahKredit)."</strong></td>
				</tr>
				<tr>
					<td colspan=\"9\"></td>
				</tr>";
		$html .= "</tbody></table>";
		$html .= "<table border=\"1\">
					<tr>
						<td>PEMBUAT</td>
						<td>PEMBUKU</td>
					</tr>
					<tr>
						<td rowspan=\"3\"></td>
						<td rowspan=\"3\"></td>
					</tr>
				  </table>";
		
		echo $html;
	}
}
?>