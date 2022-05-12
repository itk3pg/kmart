<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Omzetppn extends CI_Controller {
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
		$this->load->view('laporan/omzetppn', $Param);
		$this->load->view('general/footer');
	}
	
	public function getdataomzetppn(){
		$DataOmzetPPN = $this->laporan_model->getDataOmzetPPN($_POST);
		
		$html = "<table class=\"table table-striped table-bordered table-hover\">
					<thead>
						<tr>
							<th class='text-center'>Tanggal</th>
							<th class='text-center'>Omzet (inc)</th>
							<th class='text-center'>Omzet Kena Pajak (inc)</th>
							<th class='text-center'>Omzet Tidak Kena Pajak</th>
							<th class='text-center'>PPN</th>
						</tr>
					</thead>
					<tbody>";
		
		$TotalOmzet = 0;
		$TotalOmzetppn = 0;
		$TotalOmzetnonppn = 0;
		$Totalppn = 0;
		foreach ($DataOmzetPPN as $key => $value) {
			$BesarPPN = (($value['omzet_kena_pajak'] + $value['fvat'])/1.11) * 0.11; //k3pg-ppn
			$html .= "<tr>
						<td>".$value['fdate']."</td>
						<td align=\"right\">".number_format(($value['total_omzet'] + $value['fvat']),2)."</td>
						<td align=\"right\">".number_format(($value['omzet_kena_pajak'] + $value['fvat']),2)."</td>
						<td align=\"right\">".number_format($value['omzet_tidak_kena_pajak'],2)."</td>
						<td align=\"right\">".number_format($BesarPPN,2)."</td>
					</tr>";
			
			$TotalOmzet += ($value['total_omzet'] + $value['fvat']);
			$TotalOmzetppn += ($value['omzet_kena_pajak'] + $value['fvat']);
			$TotalOmzetnonppn += $value['omzet_tidak_kena_pajak'];
			$Totalppn += $BesarPPN;
		}
		$html .= "<tr>
					<td><strong>Total</strong></td>
					<td align=\"right\"><strong>".number_format($TotalOmzet,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalOmzetppn,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalOmzetnonppn,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($Totalppn,2)."</strong></td>
				  </tr>";
		$html .= "</tbody></table>";
		
		echo $html;
	}
	
	public function cetakdataomzetppn(){
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;Filename=omzet_ppn_".$_GET['toko_kode']."_".$_GET['bulan']."_".$_GET['tahun'].".xls");
		
		$DataOmzetPPN = $this->laporan_model->getDataOmzetPPN($_GET);
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
						<td align=\"center\" colspan=\"8\"><strong>LAPORAN OMZET DAN PPN KELUARAN</strong></td>
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
							<th class='text-center'>Omzet Kena Pajak</th>
							<th class='text-center'>Omzet Tidak Kena Pajak</th>
							<th class='text-center'>PPN</th>
						</tr>
					</thead>
					<tbody>";
		
		$TotalOmzet = 0;
		$TotalOmzetppn = 0;
		$TotalOmzetnonppn = 0;
		$Totalppn = 0;
		foreach ($DataOmzetPPN as $key => $value) {
			$BesarPPN = (($value['omzet_kena_pajak'] + $value['fvat'])/1.11) * 0.11; //k3pg-ppn
			$html .= "<tr>
						<td>".$value['fdate']."</td>
						<td align=\"right\">".number_format(($value['total_omzet'] + $value['fvat']),2)."</td>
						<td align=\"right\">".number_format(($value['omzet_kena_pajak'] + $value['fvat']),2)."</td>
						<td align=\"right\">".number_format($value['omzet_tidak_kena_pajak'],2)."</td>
						<td align=\"right\">".number_format($BesarPPN,2)."</td>
					</tr>";
			
			$TotalOmzet += ($value['total_omzet'] + $value['fvat']);
			$TotalOmzetppn += ($value['omzet_kena_pajak'] + $value['fvat']);
			$TotalOmzetnonppn += $value['omzet_tidak_kena_pajak'];
			$Totalppn += $BesarPPN;
		}
		$html .= "<tr>
					<td><strong>Total</strong></td>
					<td align=\"right\"><strong>".number_format($TotalOmzet,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalOmzetppn,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalOmzetnonppn,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($Totalppn,2)."</strong></td>
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