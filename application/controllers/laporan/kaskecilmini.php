<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kaskecilmini extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('laporan_model');
		$this->load->model('toko_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('laporan/kaskecilmini');
		$this->load->view('general/footer');
	}
	
	public function getdatakaskecilmini(){
		$DataMutasiKasbank = $this->laporan_model->getKasKecilMini($_POST);
		
		$html = "<table class=\"table table-striped table-bordered table-hover\">
					<thead>
						<tr>
							<th>Tanggal</th>
							<th>No. Bukti</th>
							<th>Kode Subject</th>
							<th>Dibayarkan/Diterima</th>
							<th>Keterangan</th>
							<th>C.B</th>
							<th>Debet</th>
							<th>Kredit</th>
						</tr>
					</thead>
					<tbody>";
		$JumlahDebet = 0;
		$JumlahKredit = 0;
		foreach ($DataMutasiKasbank as $key => $value) {
			$dataTanggal = explode(" ", $value['tanggal']);
			$html .= "<tr>
						<td>".$dataTanggal[0]."</td>
						<td>".$value['bukti']."</td>
						<td>".$value['kode_subject']."</td>
						<td>".$value['nama_subject']."</td>
						<td>".$value['keterangan']."</td>
						<td>".$value['kd_cb']."</td>";
			if(substr($value['bukti'], 1, 1) == "K"){ // kas keluar
				$html .= "<td></td><td align=\"right\">".number_format($value['jumlah'],2)."</td>";
				$JumlahKredit += $value['jumlah'];
			}else{ // kas masuk
				$html .= "<td align=\"right\">".number_format($value['jumlah'],2)."</td><td></td>";
				$JumlahDebet += $value['jumlah'];
			}
			$html .= "</tr>";
		}
		$html .= "<tr>
					<td colspan=\"6\"><strong>Jumlah</strong></td>
					<td align=\"right\"><strong>".number_format($JumlahDebet,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($JumlahKredit,2)."</strong></td>
				  </tr>";
		$html .=    "
					</tbody>
				 </table>";
				 
		echo $html;
	}
	
	public function cetakkaskecilmini(){
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;Filename=kaskecil_mini_".$_GET['bulan']."_".$_GET['tahun']."_".$_GET['toko_kode'].".xls");
		
		$html = "<table>
					<tr>
						<td colspan=\"5\"><strong>KOPERASI KARYAWAN KELUARGA BESAR PETROKIMIA GRESIK</strong></td>
						<td align=\"right\" colspan=\"3\"><strong>TGL. : ".date("d-m-Y H:i:s")."</strong></th>
					</tr>
					<tr>
						<td colspan=\"5\"><strong>K-Mart</strong></td>
						<td colspan=\"3\"></th>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"8\"><strong>BIAYA OPERASIONAL</strong></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"8\"><strong>TOKO/UNIT : ".$_GET['nama_toko']."</strong></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"8\"><strong>PERIODE : ".$_GET['bulan']." - ".$_GET['tahun']."</strong></td>
					</tr>
				 </table>";
			
		$DataMutasiKasbank = $this->laporan_model->getKasKecilMini($_GET);
		
		$html .= "<table border=\"1\">
					<thead>
						<tr>
							<th>Tanggal</th>
							<th>No. Bukti</th>
							<th>Kode Subject</th>
							<th>Dibayarkan/Diterima</th>
							<th>Keterangan</th>
							<th>C.B</th>
							<th>Debet</th>
							<th>Kredit</th>
						</tr>
					</thead>
					<tbody>";
		$JumlahDebet = 0;
		$JumlahKredit = 0;
		foreach ($DataMutasiKasbank as $key => $value) {
			$dataTanggal = explode(" ", $value['tanggal']);
			$html .= "<tr>
						<td>".$dataTanggal[0]."</td>
						<td>".$value['bukti']."</td>
						<td>".$value['kode_subject']."</td>
						<td>".$value['nama_subject']."</td>
						<td>".$value['keterangan']."</td>
						<td>".$value['kd_cb']."</td>";
			if(substr($value['bukti'], 1, 1) == "K"){ // kas keluar
				$html .= "<td></td><td align=\"right\">".round($value['jumlah'],2)."</td>";
				$JumlahKredit += $value['jumlah'];
			}else{ // kas masuk
				$html .= "<td align=\"right\">".round($value['jumlah'],2)."</td><td></td>";
				$JumlahDebet += $value['jumlah'];
			}
			$html .= "</tr>";
		}
		$html .= "<tr>
					<td colspan=\"6\"><strong>Jumlah</strong></td>
					<td align=\"right\"><strong>".round($JumlahDebet,2)."</strong></td>
					<td align=\"right\"><strong>".round($JumlahKredit,2)."</strong></td>
				  </tr>";
		$html .=    "
					</tbody>
				 </table>
				 <table>
					<tr>
						<td colspan=\"8\"></td>
					</tr>
				 </table>";
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
						<td align=\"center\" colspan=\"4\"><strong>(......................)</strong></td>
						<td align=\"center\" colspan=\"4\"><strong>(......................)</strong></td>
					</tr>
				  </table>";
		echo $html;
	}
}