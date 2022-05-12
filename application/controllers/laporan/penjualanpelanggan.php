<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Penjualanpelanggan extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('laporan_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('laporan/penjualanpelanggan');
		$this->load->view('general/footer');
	}
	
	public function getpenjualanpelanggan(){
		$DataPenjualanPelanggan = $this->laporan_model->getPenjualanPelanggan($_POST);
		
		$html = "<table class=\"table table-striped table-bordered table-hover\">
					<thead>
						<tr>
							<th style='vertical-align: middle;' class='text-center' rowspan='2'>Tanggal</th>
							<th style='vertical-align: middle;' class='text-center' rowspan='2'>Kode Trans</th>
							<th style='vertical-align: middle;' class='text-center' rowspan='2'>Pelanggan</th>
							<th style='vertical-align: middle;' class='text-center' rowspan='2'>Status</th>
							<th style='vertical-align: middle;' class='text-center' rowspan='2'>Total</th>
							<th class='text-center' colspan='5'>Pembayaran</th>
						</tr>
						<tr>
							<th class='text-center'>Tunai</th>
							<th class='text-center'>Member</th>
							<th class='text-center'>Debit Card</th>
							<th class='text-center'>Credit Card</th>
							<th class='text-center'>Kredit</th>
						</tr>
					</thead>
					<tbody>";
		
		$Total = 0;
		$TotalTunai = 0;
		$TotalKupon = 0;
		$TotalSHU = 0;
		$TotalDebit = 0;
		$TotalCredit = 0;
		$TotalKredit = 0;
		$TotalTAU = 0;
		
		$TotalPelanggan = 0;
		$TotalTunaiPelanggan = 0;
		$TotalKuponPelanggan = 0;
		$TotalSHUPelanggan = 0;
		$TotalDebitPelanggan = 0;
		$TotalCreditPelanggan = 0;
		$TotalKreditPelanggan = 0;
		$TotalTAUPelanggan = 0;
		
		$fcustkey = "";
		foreach ($DataPenjualanPelanggan as $key => $value) {
			$Tunai = $value['fpayment'];
			if($fcustkey == ""){
				$fcustkey = $value['fcustkey'];
			}
			if($fcustkey != $value['fcustkey']){
				$html .= "<tr>
							<td colspan='4'><strong>SUB TOTAL</strong></td>
							<td align=\"right\"><strong>".round($TotalPelanggan,2)."</strong></td>
							<td align=\"right\"><strong>".round($TotalTunaiPelanggan,2)."</strong></td>
							<td align=\"right\"><strong>".round($TotalKuponPelanggan + $TotalSHUPelanggan,2)."</strong></td>
							<td align=\"right\"><strong>".round($TotalDebitPelanggan,2)."</strong></td>
							<td align=\"right\"><strong>".round($TotalCreditPelanggan,2)."</strong></td>
							<td align=\"right\"><strong>".round($TotalKreditPelanggan,2)."</strong></td>
						  </tr>";
						  
				$TotalPelanggan = 0;
				$TotalTunaiPelanggan = 0;
				$TotalKuponPelanggan = 0;
				$TotalSHUPelanggan = 0;
				$TotalDebitPelanggan = 0;
				$TotalCreditPelanggan = 0;
				$TotalKreditPelanggan = 0;
				$TotalTAUPelanggan = 0;
				
				$fcustkey = $value['fcustkey'];
			}
			
			if($value['fchange'] > 0){
				$Tunai = $value['fpayment'] - $value['fchange'];
			}
			
			$html .= "<tr>
						<td>".$value['fdate']."</td>
						<td>".$value['fcode']."</td>
						<td>".$value['fcustname']."</td>
						<td>".$value['fname_payment']."</td>
						<td align=\"right\">".round($value['fbill_amount'],2)."</td>
						<td align=\"right\">".round($Tunai,2)."</td>
						<td align=\"right\">".round($value['fkupon'] + $value['fshu'],2)."</td>
						<td align=\"right\">".round($value['fdebet'],2)."</td>
						<td align=\"right\">".round($value['fkredit'],2)."</td>";
			if($value['fname_payment'] == "Kredit"){
				$html .= "<td align=\"right\">".round($value['fbill_amount'],2)."</td>";
				
				$TotalKreditPelanggan += $value['fbill_amount'];
				$TotalKredit += $value['fbill_amount'];
			}else if($value['fname_payment'] == "Tunai"){
				$html .= "<td align=\"right\">0</td>";
			}
			$html .= "</tr>";
			
			$TotalPelanggan += $value['fbill_amount'];
			$TotalTunaiPelanggan += $Tunai;
			$TotalKuponPelanggan += $value['fkupon'];
			$TotalSHUPelanggan += $value['fshu'];
			$TotalDebitPelanggan += $value['fdebet'];
			$TotalCreditPelanggan += $value['fkredit'];
			
			$Total += $value['fbill_amount'];
			$TotalTunai += $Tunai;
			$TotalKupon += $value['fkupon'];
			$TotalSHU += $value['fshu'];
			$TotalDebit += $value['fdebet'];
			$TotalCredit += $value['fkredit'];
		}
		
		$html .= "<tr>
					<td colspan='4'><strong>SUB TOTAL</strong></td>
					<td align=\"right\"><strong>".round($TotalPelanggan,2)."</strong></td>
					<td align=\"right\"><strong>".round($TotalTunaiPelanggan,2)."</strong></td>
					<td align=\"right\"><strong>".round($TotalKuponPelanggan + $TotalSHUPelanggan,2)."</strong></td>
					<td align=\"right\"><strong>".round($TotalDebitPelanggan,2)."</strong></td>
					<td align=\"right\"><strong>".round($TotalCreditPelanggan,2)."</strong></td>
					<td align=\"right\"><strong>".round($TotalKreditPelanggan,2)."</strong></td>
				  </tr>";
		$html .= "<tr>
					<td colspan='4'><strong>TOTAL</strong></td>
					<td align=\"right\"><strong>".round($Total,2)."</strong></td>
					<td align=\"right\"><strong>".round($TotalTunai,2)."</strong></td>
					<td align=\"right\"><strong>".round($TotalKupon + $TotalSHU,2)."</strong></td>
					<td align=\"right\"><strong>".round($TotalDebit,2)."</strong></td>
					<td align=\"right\"><strong>".round($TotalCredit,2)."</strong></td>
					<td align=\"right\"><strong>".round($TotalKredit,2)."</strong></td>
				  </tr>";
		$html .= "</tbody></table>";
		
		echo $html;
	}
	
	public function cetakpenjualanpelanggan(){
		$DataPenjualanPelanggan = $this->laporan_model->getPenjualanPelanggan($_GET);
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;Filename=penjualan_pelanggan_".$_GET['bulan']."_".$_GET['tahun'].".xls");
		
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
						<td align=\"center\" colspan=\"8\"><strong>LAPORAN PENJUALAN PER PELANGGAN</strong></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"8\"><strong>PERIODE : ".$_GET['bulan']." - ".$_GET['tahun']."</strong></td>
					</tr>
				 </table>";
		$html .= "<table border=\"1\">
					<thead>
						<tr>
							<th style='vertical-align: middle;' class='text-center' rowspan='2'>Tanggal</th>
							<th style='vertical-align: middle;' class='text-center' rowspan='2'>Kode Trans</th>
							<th style='vertical-align: middle;' class='text-center' rowspan='2'>Pelanggan</th>
							<th style='vertical-align: middle;' class='text-center' rowspan='2'>Status</th>
							<th style='vertical-align: middle;' class='text-center' rowspan='2'>Total</th>
							<th class='text-center' colspan='5'>Pembayaran</th>
						</tr>
						<tr>
							<th class='text-center'>Tunai</th>
							<th class='text-center'>Kupon</th>
							<th class='text-center'>Debit Card</th>
							<th class='text-center'>Credit Card</th>
							<th class='text-center'>Kredit</th>
						</tr>
					</thead>
					<tbody>";
		
		$Total = 0;
		$TotalTunai = 0;
		$TotalKupon = 0;
		$TotalSHU = 0;
		$TotalDebit = 0;
		$TotalCredit = 0;
		$TotalKredit = 0;
		$TotalTAU = 0;
		
		$TotalPelanggan = 0;
		$TotalTunaiPelanggan = 0;
		$TotalKuponPelanggan = 0;
		$TotalSHUPelanggan = 0;
		$TotalDebitPelanggan = 0;
		$TotalCreditPelanggan = 0;
		$TotalKreditPelanggan = 0;
		$TotalTAUPelanggan = 0;
		
		$fcustkey = "";
		foreach ($DataPenjualanPelanggan as $key => $value) {
			$Tunai = $value['fpayment'];
			if($fcustkey == ""){
				$fcustkey = $value['fcustkey'];
			}
			if($fcustkey != $value['fcustkey']){
				$html .= "<tr>
							<td colspan='4'><strong>SUB TOTAL</strong></td>
							<td align=\"right\"><strong>".round($TotalPelanggan,2)."</strong></td>
							<td align=\"right\"><strong>".round($TotalTunaiPelanggan,2)."</strong></td>
							<td align=\"right\"><strong>".round($TotalKuponPelanggan + $TotalSHUPelanggan,2)."</strong></td>
							<td align=\"right\"><strong>".round($TotalDebitPelanggan,2)."</strong></td>
							<td align=\"right\"><strong>".round($TotalCreditPelanggan,2)."</strong></td>
							<td align=\"right\"><strong>".round($TotalKreditPelanggan,2)."</strong></td>
						  </tr>";
						  
				$TotalPelanggan = 0;
				$TotalTunaiPelanggan = 0;
				$TotalKuponPelanggan = 0;
				$TotalSHUPelanggan = 0;
				$TotalDebitPelanggan = 0;
				$TotalCreditPelanggan = 0;
				$TotalKreditPelanggan = 0;
				$TotalTAUPelanggan = 0;
				
				$fcustkey = $value['fcustkey'];
			}
			
			if($value['fchange'] > 0){
				$Tunai = $value['fpayment'] - $value['fchange'];
			}
			
			$html .= "<tr>
						<td>".$value['fdate']."</td>
						<td>".$value['fcode']."</td>
						<td>".$value['fcustname']."</td>
						<td>".$value['fname_payment']."</td>
						<td align=\"right\">".round($value['fbill_amount'],2)."</td>
						<td align=\"right\">".round($Tunai,2)."</td>
						<td align=\"right\">".round($value['fkupon'] + $value['fshu'],2)."</td>
						<td align=\"right\">".round($value['fdebet'],2)."</td>
						<td align=\"right\">".round($value['fkredit'],2)."</td>";
			if($value['fname_payment'] == "Kredit"){
				$html .= "<td align=\"right\">".round($value['fbill_amount'],2)."</td>";
				
				$TotalKreditPelanggan += $value['fbill_amount'];
				$TotalKredit += $value['fbill_amount'];
			}else if($value['fname_payment'] == "Tunai"){
				$html .= "<td align=\"right\">0</td>";
			}
			$html .= "</tr>";
			
			$TotalPelanggan += $value['fbill_amount'];
			$TotalTunaiPelanggan += $Tunai;
			$TotalKuponPelanggan += $value['fkupon'];
			$TotalSHUPelanggan += $value['fshu'];
			$TotalDebitPelanggan += $value['fdebet'];
			$TotalCreditPelanggan += $value['fkredit'];
			
			$Total += $value['fbill_amount'];
			$TotalTunai += $Tunai;
			$TotalKupon += $value['fkupon'];
			$TotalSHU += $value['fshu'];
			$TotalDebit += $value['fdebet'];
			$TotalCredit += $value['fkredit'];
		}
		
		$html .= "<tr>
					<td colspan='4'><strong>SUB TOTAL</strong></td>
					<td align=\"right\"><strong>".round($TotalPelanggan,2)."</strong></td>
					<td align=\"right\"><strong>".round($TotalTunaiPelanggan,2)."</strong></td>
					<td align=\"right\"><strong>".round($TotalKuponPelanggan + $TotalSHUPelanggan,2)."</strong></td>
					<td align=\"right\"><strong>".round($TotalDebitPelanggan,2)."</strong></td>
					<td align=\"right\"><strong>".round($TotalCreditPelanggan,2)."</strong></td>
					<td align=\"right\"><strong>".round($TotalKreditPelanggan,2)."</strong></td>
				  </tr>";
		$html .= "<tr>
					<td colspan='4'><strong>TOTAL</strong></td>
					<td align=\"right\"><strong>".round($Total,2)."</strong></td>
					<td align=\"right\"><strong>".round($TotalTunai,2)."</strong></td>
					<td align=\"right\"><strong>".round($TotalKupon + $TotalSHU,2)."</strong></td>
					<td align=\"right\"><strong>".round($TotalDebit,2)."</strong></td>
					<td align=\"right\"><strong>".round($TotalCredit,2)."</strong></td>
					<td align=\"right\"><strong>".round($TotalKredit,2)."</strong></td>
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