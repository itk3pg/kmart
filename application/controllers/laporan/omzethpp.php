<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Omzethpp extends CI_Controller {
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
		$this->load->view('laporan/omzethpp', $Param);
		$this->load->view('general/footer');
	}
	
	public function getdataomzethpp(){
		$DataOmzetHPP = $this->laporan_model->getDataOmzetHPP($_POST);
		
		$html = "<table class=\"table table-striped table-bordered table-hover\">
					<thead>
						<tr>
							<th class='text-center'>Tanggal</th>
							<th class='text-center'>Omzet (inc)</th>
							<th class='text-center'>PPN</th>
							<th class='text-center'>Omzet (exc)</th>
							<th class='text-center'>HPP</th>
							<th class='text-center'>GPM (%)</th>
						</tr>
					</thead>
					<tbody>";
		
		$JumlahOmzetInc = 0;
		$JumlahPPN = 0;
		$JumlahOmzetExc = 0;
		$JumlahHPP = 0;
		foreach ($DataOmzetHPP as $key => $value) {
			$BesarPPN = ($value['omzet_kena_pajak'] /1.11)*0.11; //k3pg-ppn
			$DPPFvat = $value['fvat'] / 1.11; //k3pg-ppn
			$PPNFVat = $DPPFvat * 0.11; //k3pg-ppn
			$BesarPPN = $BesarPPN + $PPNFVat;
			
			$TotalOmzetInc = $value['total_omzet_inc'] + $value['fvat'];
			$TotalOmzetExc = $value['total_omzet_exc'] + $DPPFvat;
			$TotalGPM = (($TotalOmzetExc - $value['hpp'])/ $value['hpp']) * 100;
			$html .= "<tr>
						<td>".$value['fdate']."</td>
						<td align=\"right\">".number_format($TotalOmzetInc,2)."</td>
						<td align=\"right\">".number_format($BesarPPN,2)."</td>
						<td align=\"right\">".number_format($TotalOmzetExc,2)."</td>
						<td align=\"right\">".number_format($value['hpp'],2)."</td>
						<td align=\"right\">".number_format($TotalGPM,2)."</td>
					</tr>";
			$JumlahOmzetInc += $TotalOmzetInc;
			$JumlahPPN += $BesarPPN;
			$JumlahOmzetExc += $TotalOmzetExc;
			$JumlahHPP += $value['hpp'];
		}
		$html .= "<tr>
					<td>Total</td>
					<td align=\"right\">".number_format($JumlahOmzetInc,2)."</td>
					<td align=\"right\">".number_format($JumlahPPN,2)."</td>
					<td align=\"right\">".number_format($JumlahOmzetExc,2)."</td>
					<td align=\"right\">".number_format($JumlahHPP,2)."</td>
					<td>&nbsp</td>
				  </tr>";
		$html .= "</tbody></table>";
		
		echo $html;
	}
	
	public function cetakdataomzethpp(){
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;Filename=omzet_hpp_".$_GET['toko_kode']."_".$_GET['bulan']."_".$_GET['tahun'].".xls");
		
		$DataOmzetHPP = $this->laporan_model->getDataOmzetHPP($_GET);
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
						<td align=\"center\" colspan=\"8\"><strong>LAPORAN OMZET DAN HPP</strong></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"8\"><strong>PERIODE : ".$_GET['bulan']." - ".$_GET['tahun']."</strong></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"8\"><strong>Toko : ".$_GET['nama_toko']."</strong></td>
					</tr>
				 </table>";
		$html .= "<table border=\"1\">
					<thead>
						<tr>
							<th class='text-center'>Tanggal</th>
							<th class='text-center'>Omzet (inc)</th>
							<th class='text-center'>PPN</th>
							<th class='text-center'>Omzet (exc)</th>
							<th class='text-center'>HPP</th>
							<th class='text-center'>GPM (%)</th>
							
						</tr>
					</thead>
					<tbody>";
		
		$JumlahOmzetInc = 0;
		$JumlahPPN = 0;
		$JumlahOmzetExc = 0;
		$JumlahHPP = 0;
		foreach ($DataOmzetHPP as $key => $value) {
			$BesarPPN = ($value['omzet_kena_pajak'] /1.11)*0.1; //k3pg-ppn
			$DPPFvat = $value['fvat'] / 1.11; //k3pg-ppn
			$PPNFVat = $DPPFvat * 0.11; //k3pg-ppn
			$BesarPPN = $BesarPPN + $PPNFVat;
			
			$TotalOmzetInc = $value['total_omzet_inc'] + $value['fvat'];
			$TotalOmzetExc = $value['total_omzet_exc'] + $DPPFvat;
			$TotalGPM = (($TotalOmzetExc - $value['hpp'])/ $value['hpp']) * 100;
			$html .= "<tr>
						<td>".$value['fdate']."</td>
						<td align=\"right\">".round($TotalOmzetInc,2)."</td>
						<td align=\"right\">".round($BesarPPN,2)."</td>
						<td align=\"right\">".round($TotalOmzetExc,2)."</td>
						<td align=\"right\">".round($value['hpp'],2)."</td>
						<td align=\"right\">".round($TotalGPM,2)."</td>
					</tr>";
			$JumlahOmzetInc += $TotalOmzetInc;
			$JumlahPPN += $BesarPPN;
			$JumlahOmzetExc += $TotalOmzetExc;
			$JumlahHPP += $value['hpp'];
		}
		$html .= "<tr>
					<td>Total</td>
					<td align=\"right\">".round($JumlahOmzetInc,2)."</td>
					<td align=\"right\">".round($JumlahPPN,2)."</td>
					<td align=\"right\">".round($JumlahOmzetExc,2)."</td>
					<td align=\"right\">".round($JumlahHPP,2)."</td>
					<td>&nbsp</td>
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