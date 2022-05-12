<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Taukeluar extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('laporan_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('laporan/taukeluar');
		$this->load->view('general/footer');
	}
	
	public function getmutasitaukeluar(){
		$DataMutasiTAU = $this->laporan_model->getDataTAUKeluar($_POST);
		
		$html = "<table class=\"table table-striped table-bordered table-hover\">
					<thead>
						<tr>
							<th>Tanggal</th>
							<th>Bukti</th>
							<th>Pelanggan</th>
							<th>Barang</th>
							<th>KWT</th>
							<th>harga</th>
							<th>jumlah</th>
						</tr>
					</thead>
					<tbody>";
		$bukti = "";
		$jumlahperbukti = 0;
		$totalAll = 0;
		foreach ($DataMutasiTAU as $key => $value) {
			if($bukti == ""){
				$bukti = $value['bukti'];
			}
			if($bukti != $value['bukti']){
				$html .= "<tr>
							<td colspan='6'><strong>Jumlah</strong></td>
							<td align=\"right\"><strong>".number_format($jumlahperbukti,2)."</strong></td>
						 </tr>";
				$jumlahperbukti = 0;
				$bukti = $value['bukti'];
			}
			$html .= "<tr>
						<td>".$value['tanggal']."</td>
						<td>".$value['bukti']."</td>
						<td>".$value['nama_pelanggan']."</td>
						<td>".$value['nama_barang']."</td>
						<td align=\"right\">".number_format($value['kwt'],2)."</td>
						<td align=\"right\">".number_format($value['harga'],2)."</td>
						<td align=\"right\">".number_format($value['jumlah'],2)."</td>
					  </tr>";
					  
			$jumlahperbukti += $value['jumlah'];
			$totalAll += $value['jumlah'];
		}
		$html .= "<tr>
					<td colspan='6'><strong>Jumlah</strong></td>
					<td align=\"right\"><strong>".number_format($jumlahperbukti,2)."</strong></td>
				 </tr>";
		$html .= "<tr>
					<td colspan='6'><strong>Total</strong></td>
					<td align=\"right\"><strong>".number_format($totalAll,2)."</strong></td>
				 </tr>";
		$html .= "</tbody>
				 </table>";
		
		echo $html;
	}
	
	public function cetakmutasitaukeluar(){
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;Filename=TAU_keluar_".$_GET['bulan']."_".$_GET['tahun'].".xls");
		
		$DataMutasiTAU = $this->laporan_model->getDataTAUKeluar($_GET);
		
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
						<td align=\"center\" colspan=\"8\"><strong>LAPORAN TAU KELUAR</strong></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"8\"><strong>PERIODE : ".$_GET['bulan']." - ".$_GET['tahun']."</strong></td>
					</tr>
				 </table>";
		$html .= "<table border=\"1\">
					<thead>
						<tr>
							<th>Tanggal</th>
							<th>Bukti</th>
							<th>Pelanggan</th>
							<th>Barang</th>
							<th>KWT</th>
							<th>harga</th>
							<th>jumlah</th>
						</tr>
					</thead>
					<tbody>";
		$bukti = "";
		$jumlahperbukti = 0;
		$totalAll = 0;
		foreach ($DataMutasiTAU as $key => $value) {
			if($bukti == ""){
				$bukti = $value['bukti'];
			}
			if($bukti != $value['bukti']){
				$html .= "<tr>
							<td colspan='6'><strong>Jumlah</strong></td>
							<td align=\"right\"><strong>".round($jumlahperbukti,2)."</strong></td>
						 </tr>";
				$jumlahperbukti = 0;
				$bukti = $value['bukti'];
			}
			$html .= "<tr>
						<td>".$value['tanggal']."</td>
						<td>".$value['bukti']."</td>
						<td>".$value['nama_pelanggan']."</td>
						<td>".$value['nama_barang']."</td>
						<td align=\"right\">".round($value['kwt'],2)."</td>
						<td align=\"right\">".round($value['harga'],2)."</td>
						<td align=\"right\">".round($value['jumlah'],2)."</td>
					  </tr>";
					  
			$jumlahperbukti += $value['jumlah'];
			$totalAll += $value['jumlah'];
		}
		$html .= "<tr>
					<td colspan='6'><strong>Jumlah</strong></td>
					<td align=\"right\"><strong>".round($jumlahperbukti,2)."</strong></td>
				 </tr>";
		$html .= "<tr>
					<td colspan='6'><strong>Total</strong></td>
					<td align=\"right\"><strong>".round($totalAll,2)."</strong></td>
				 </tr>";
		$html .= "</tbody>
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
						<td align=\"center\" colspan=\"4\"><strong>(..............................)</strong></td>
						<td align=\"center\" colspan=\"4\"><strong>(..............................)</strong></td>
					</tr>
				  </table>";
		
		echo $html;
	}
}

?>