<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Umurpiutang extends CI_Controller {
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
		$this->load->view('laporan/umurpiutang', $Param);
		$this->load->view('general/footer');
	}
	
	public function getumurpiutang(){
		$DataUmurPiutang = $this->laporan_model->getUmurPiutang($_POST);
		
		$GrandTotal = 0;
		$Grand14 = 0;
		$Grand15 = 0;
		$Grand31 = 0;
		$Grand46 = 0;
		$Grand61 = 0;
		$Grand91 = 0;
		$Grand181 = 0;
		$Grand366 = 0;
		$Grand1096 = 0;
		$html = "<table class=\"table table-striped table-bordered table-hover\">
					<thead>
						<tr>
							<th>KODE PELANGGAN</th>
							<th>NAMA PELANGGAN</th>
							<th>TOTAL</th>
							<th>0 - 14 HARI</th>
							<th>15 - 30 HARI</th>
							<th>31 - 45 HARI</th>
							<th>46 - 60 HARI</th>
							<th>61 - 90 HARI</th>
							<th>91 - 180 HARI</th>
							<th>181 - 365 HARI</th>
							<th>366 - 1095 HARI</th>
							<th>&gt; 1096 HARI</th>
						</tr>
					</thead>
					<tbody>";
		foreach ($DataUmurPiutang as $key => $value) {
			$Total = $value['_14hari'] + $value['_15hari'] + $value['_31hari'] + $value['_46hari'] + $value['_61hari'] + $value['_91hari'] + $value['_181hari'] + $value['_366hari'] + $value['_1096hari'];
			$html .= "<tr>
						<td>".$value['pelanggan_kode']."</td>
						<td>".$value['nama_pelanggan']."</td>
						<td align=\"right\">".number_format($Total,2)."</td>
						<td align=\"right\">".number_format($value['_14hari'],2)."</td>
						<td align=\"right\">".number_format($value['_15hari'],2)."</td>
						<td align=\"right\">".number_format($value['_31hari'],2)."</td>
						<td align=\"right\">".number_format($value['_46hari'],2)."</td>
						<td align=\"right\">".number_format($value['_61hari'],2)."</td>
						<td align=\"right\">".number_format($value['_91hari'],2)."</td>
						<td align=\"right\">".number_format($value['_181hari'],2)."</td>
						<td align=\"right\">".number_format($value['_366hari'],2)."</td>
						<td align=\"right\">".number_format($value['_1096hari'],2)."</td>
					  </tr>";
			$GrandTotal += $Total;
			$Grand14 += $value['_14hari'];
			$Grand15 += $value['_15hari'];
			$Grand31 += $value['_31hari'];
			$Grand46 += $value['_46hari'];
			$Grand61 += $value['_61hari'];
			$Grand91 += $value['_91hari'];
			$Grand181 += $value['_181hari'];
			$Grand366 += $value['_366hari'];
			$Grand1096 += $value['_1096hari'];
		}
		$html .= "<tr>
					<td colspan=\"2\"><strong>GRAND TOTAL</strong></td>
					<td align=\"right\"><strong>".number_format($GrandTotal,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($Grand14,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($Grand15,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($Grand31,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($Grand46,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($Grand61,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($Grand91,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($Grand181,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($Grand366,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($Grand1096,2)."</strong></td>
				  </tr>";
		$html .= "</tbody></table>";
		echo $html;
	}
	
	public function cetakumurpiutang(){
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;Filename=umur_piutang_".$_GET['tanggal'].".xls");
		
		$DataUmurPiutang = $this->laporan_model->getUmurPiutang($_GET);
		
		$GrandTotal = 0;
		$Grand14 = 0;
		$Grand15 = 0;
		$Grand31 = 0;
		$Grand46 = 0;
		$Grand61 = 0;
		$Grand91 = 0;
		$Grand181 = 0;
		$Grand366 = 0;
		$Grand1096 = 0;
		$html = "<table>
					<tr>
						<td colspan=\"6\"><strong>KOPERASI KARYAWAN KELUARGA BESAR PETROKIMIA GRESIK</strong></td>
						<td align=\"right\" colspan=\"6\"><strong>TGL. : ".date("d-m-Y H:i:s")."</strong></th>
					</tr>
					<tr>
						<td colspan=\"6\"><strong>K-Mart</strong></td>
						<td colspan=\"6\"></th>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"12\"><strong>LAPORAN UMUR PIUTANG PER LANGGANAN</strong></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"12\"><strong>TOKO : ".$_GET['nama_toko']."</strong></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"12\"><strong>PERIODE : ".$_GET['tanggal']."</strong></td>
					</tr>
				 </table>";
		$html .= "<table border=\"1\">
					<thead>
						<tr>
							<th>KODE PELANGGAN</th>
							<th>NAMA PELANGGAN</th>
							<th>TOTAL</th>
							<th>0 - 14 HARI</th>
							<th>15 - 30 HARI</th>
							<th>31 - 45 HARI</th>
							<th>46 - 60 HARI</th>
							<th>61 - 90 HARI</th>
							<th>91 - 180 HARI</th>
							<th>181 - 365 HARI</th>
							<th>366 - 1095 HARI</th>
							<th>&gt; 1096 HARI</th>
						</tr>
					</thead>
					<tbody>";
		foreach ($DataUmurPiutang as $key => $value) {
			$Total = $value['_14hari'] + $value['_15hari'] + $value['_31hari'] + $value['_46hari'] + $value['_61hari'] + $value['_91hari'] + $value['_181hari'] + $value['_366hari'] + $value['_1096hari'];
			$html .= "<tr>
						<td>'".$value['pelanggan_kode']."</td>
						<td>".$value['nama_pelanggan']."</td>
						<td align=\"right\">".round($Total,2)."</td>
						<td align=\"right\">".round($value['_14hari'],2)."</td>
						<td align=\"right\">".round($value['_15hari'],2)."</td>
						<td align=\"right\">".round($value['_31hari'],2)."</td>
						<td align=\"right\">".round($value['_46hari'],2)."</td>
						<td align=\"right\">".round($value['_61hari'],2)."</td>
						<td align=\"right\">".round($value['_91hari'],2)."</td>
						<td align=\"right\">".round($value['_181hari'],2)."</td>
						<td align=\"right\">".round($value['_366hari'],2)."</td>
						<td align=\"right\">".round($value['_1096hari'],2)."</td>
					  </tr>";
			$GrandTotal += $Total;
			$Grand14 += $value['_14hari'];
			$Grand15 += $value['_15hari'];
			$Grand31 += $value['_31hari'];
			$Grand46 += $value['_46hari'];
			$Grand61 += $value['_61hari'];
			$Grand91 += $value['_91hari'];
			$Grand181 += $value['_181hari'];
			$Grand366 += $value['_366hari'];
			$Grand1096 += $value['_1096hari'];
		}
		$html .= "<tr>
					<td colspan=\"2\"><strong>GRAND TOTAL</strong></td>
					<td align=\"right\"><strong>".round($GrandTotal,2)."</strong></td>
					<td align=\"right\"><strong>".round($Grand14,2)."</strong></td>
					<td align=\"right\"><strong>".round($Grand15,2)."</strong></td>
					<td align=\"right\"><strong>".round($Grand31,2)."</strong></td>
					<td align=\"right\"><strong>".round($Grand46,2)."</strong></td>
					<td align=\"right\"><strong>".round($Grand61,2)."</strong></td>
					<td align=\"right\"><strong>".round($Grand91,2)."</strong></td>
					<td align=\"right\"><strong>".round($Grand181,2)."</strong></td>
					<td align=\"right\"><strong>".round($Grand366,2)."</strong></td>
					<td align=\"right\"><strong>".round($Grand1096,2)."</strong></td>
				  </tr>";
		$html .= "</tbody></table>";
		$html .= "<table>
					<tr>
						<td align=\"center\" colspan=\"6\">Mengetahui</td>
						<td align=\"center\" colspan=\"6\">Yang membuat</td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"6\"></td>
						<td align=\"center\" colspan=\"6\"></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"6\"></td>
						<td align=\"center\" colspan=\"6\"></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"6\"></td>
						<td align=\"center\" colspan=\"6\"></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"6\"><strong>(..............................)</strong></td>
						<td align=\"center\" colspan=\"6\"><strong>(..............................)</strong></td>
					</tr>
				  </table>";
		echo $html;
	}
}