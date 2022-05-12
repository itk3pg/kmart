<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mutasikasbank extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('laporan_model');
		$this->load->model('toko_model');
		$this->load->model('kasbank_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$DataToko = $this->toko_model->getAllDataToko();
		$DataKasbank = $this->kasbank_model->getDataKB();
		
		$Param  = array();
		$Param['DataToko'] = $DataToko;
		$Param['DataKasBank'] = $DataKasbank;
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('laporan/mutasikasbank', $Param);
		$this->load->view('general/footer');
	}
	
	public function getmutasikasbank(){
		$TanggalAwal = explode("-", $_POST['tanggal_awal']);
		$_POST['bulan'] = $TanggalAwal[1];
		$_POST['tahun'] = $TanggalAwal[0];
		
		$SaldoAwalKasbank = $this->laporan_model->getSaldoAwal($_POST);
		$DataMutasiKasbank = $this->laporan_model->getMutasiKasbank($_POST);
		
		$html = "<table class=\"table table-striped table-bordered table-hover\">
					<thead>
						<tr>
							<th>Tanggal</th>
							<th>No. Bukti</th>
							<th>Kode Subject</th>
							<th>Dibayarkan/Diterima</th>
							<th>Keterangan</th>
							<th>C.B</th>
							<th>Saldo Awal</th>
							<th>Debet</th>
							<th>Kredit</th>
							<th>Saldo Akhir</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td colspan=\"6\"><strong>Saldo Awal</strong></td>
							<td align=\"right\"><strong>".number_format($SaldoAwalKasbank,2)."</strong></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>";
		$JumlahDebet = 0;
		$JumlahKredit = 0;
		foreach ($DataMutasiKasbank as $key => $value) {
			$dataTanggal = explode(" ", $value['tanggal']);
			if($value['kd_cb']=='101' or $value['kd_cb']=='202' or $value['kd_cb']=='180' or $value['kd_cb']=='280' or $value['kd_cb']=='186' or $value['kd_cb']=='286' or $value['kd_cb']=='185' or $value['kd_cb']=='285'){
				$value['kode_subject'] = "";
				$value['nama_subject'] = "";
				//$value['keterangan'] = $value['nama_cb'];
			}
			$html .= "<tr>
						<td>".$dataTanggal[0]."</td>
						<td>".$value['bukti']."</td>
						<td>".$value['kode_subject']."</td>
						<td>".$value['nama_subject']."</td>
						<td>".$value['keterangan']."</td>
						<td>".$value['kd_cb']."</td>
						<td></td>";
			if(substr($value['bukti'], 1, 1) == "K"){ // kas keluar
				$html .= "<td></td><td align=\"right\">".number_format($value['jumlah'],2)."</td><td></td>";
				$JumlahKredit += $value['jumlah'];
			}else{ // kas masuk
				$html .= "<td align=\"right\">".number_format($value['jumlah'],2)."</td><td></td><td></td>";
				$JumlahDebet += $value['jumlah'];
			}
			$html .= "</tr>";
		}
		$html .= "<tr>
					<td colspan=\"6\"><strong>Jumlah</strong></td>
					<td></td>
					<td align=\"right\"><strong>".number_format($JumlahDebet,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($JumlahKredit,2)."</strong></td>
					<td></td>
				  </tr>";
		$SaldoAkhir = $SaldoAwalKasbank + $JumlahDebet - $JumlahKredit;
		$html .=    "<tr>
						<td colspan=\"6\"><strong>Saldo Akhir</strong></td>
						<td></td>
						<td></td>
						<td></td>
						<td align=\"right\"><strong>".number_format($SaldoAkhir,2)."</strong></td>
					</tr>
					</tbody>
				 </table>";
				 
		echo $html;
	}
	
	public function cetakmutasikasbank(){
		$TanggalAwal = explode("-", $_GET['tanggal_awal']);
		$_GET['bulan'] = $TanggalAwal[1];
		$_GET['tahun'] = $TanggalAwal[0];
		
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;Filename=mutasi_kasbank_".$_GET['bulan']."_".$_GET['tahun']."_".$_GET['kd_kb'].".xls");
		
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
						<td align=\"center\" colspan=\"8\"><strong>LAPORAN MUTASI KAS/BANK</strong></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"8\"><strong>PERIODE : ".$_GET['bulan']." - ".$_GET['tahun']."</strong></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"8\"><strong>Toko / Unit : ".$_GET['nama_toko']."</strong></td>
					</tr>
				 </table>";
			
		$SaldoAwalKasbank = $this->laporan_model->getSaldoAwal($_GET);
		$DataMutasiKasbank = $this->laporan_model->getMutasiKasbank($_GET);
		
		$title = "Kode Kas/Bank : ".$_GET['kd_kb']." ".$_GET['nama_kb'];
		
		$html .= "<table border=\"1\">
					<thead>
						<tr>
							<th align=\"left\" colspan=\"8\">".$title."</th>
						</tr>
						<tr>
							<th>Tanggal</th>
							<th>No. Bukti</th>
							<th>Kode Subject</th>
							<th>Dibayarkan/Diterima</th>
							<th>Keterangan</th>
							<th>C.B</th>
							<th>Saldo Awal</th>
							<th>Debet</th>
							<th>Kredit</th>
							<th>Saldo Akhir</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td colspan=\"6\"><strong>Saldo Awal</strong></td>
							<td align=\"right\"><strong>".round($SaldoAwalKasbank,2)."</strong></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>";
		$JumlahDebet = 0;
		$JumlahKredit = 0;
		foreach ($DataMutasiKasbank as $key => $value) {
			$dataTanggal = explode(" ", $value['tanggal']);
			if($value['kd_cb']=='101' or $value['kd_cb']=='202' or $value['kd_cb']=='180' or $value['kd_cb']=='280' or $value['kd_cb']=='186' or $value['kd_cb']=='286' or $value['kd_cb']=='185' or $value['kd_cb']=='285'){
				$value['kode_subject'] = "";
				$value['nama_subject'] = "";
				//$value['keterangan'] = $value['nama_cb'];
			}
			$html .= "<tr>
						<td>".$dataTanggal[0]."</td>
						<td>".$value['bukti']."</td>
						<td>".$value['kode_subject']."</td>
						<td>".$value['nama_subject']."</td>
						<td>".$value['keterangan']."</td>
						<td>".$value['kd_cb']."</td>
						<td></td>";
			if(substr($value['bukti'], 1, 1) == "K"){ // kas keluar
				$html .= "<td></td><td align=\"right\">".round($value['jumlah'],2)."</td><td></td>";
				$JumlahKredit += $value['jumlah'];
			}else{ // kas masuk
				$html .= "<td align=\"right\">".round($value['jumlah'],2)."</td><td></td><td></td>";
				$JumlahDebet += $value['jumlah'];
			}
			$html .= "</tr>";
		}
		$html .= "<tr>
					<td colspan=\"6\"><strong>Jumlah</strong></td>
					<td></td>
					<td align=\"right\"><strong>".round($JumlahDebet,2)."</strong></td>
					<td align=\"right\"><strong>".round($JumlahKredit,2)."</strong></td>
					<td></td>
				  </tr>";
		$SaldoAkhir = $SaldoAwalKasbank + $JumlahDebet - $JumlahKredit;
		$html .=    "<tr>
						<td colspan=\"6\"><strong>Saldo Akhir</strong></td>
						<td></td>
						<td></td>
						<td></td>
						<td align=\"right\">".round($SaldoAkhir,2)."</td>
					</tr>
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