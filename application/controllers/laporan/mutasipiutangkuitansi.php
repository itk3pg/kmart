<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mutasipiutangkuitansi extends CI_Controller {
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
		$this->load->view('laporan/mutasipiutangkuitansi', $Param);
		$this->load->view('general/footer');
	}
	
	public function getpiutangkuitansi(){
		$DataKartuPiutang = $this->laporan_model->getKuitansiPiutang($_POST);
		
		$html = "<table class=\"table table-striped table-bordered table-hover\">
					<thead>
						<tr>
							<th>No</th>
							<th>Perusahaan</th>
							<th>Tanggal</th>
							<th>Tagihan (Exc. PPn)</th>
							<th>PPn</th>
							<th>Total</th>
							<th>Saldo Akhir</th>
							<th>No Kuitansi</th>
						</tr>
					</thead>
					<tbody>";
		$inc = 1;
		foreach ($DataKartuPiutang as $key => $value) {
			$dpp = $value['jumlah'] / 1.11; //k3pg-ppn
			$ppn = $dpp * 0.11; //k3pg-ppn
			$html .= "<tr>
					  	<td>".$inc."</td>
					  	<td>".$value['nama_pelanggan']."</td>
					  	<td>".$value['tanggal_format']."</td>
					  	<td align=\"right\">".number_format(round($dpp,2))."</td>
					  	<td align=\"right\">".number_format(round($ppn,2))."</td>
					  	<td align=\"right\">".number_format(round($value['jumlah'],2))."</td>
					  	<td align=\"right\">".number_format(round($value['sisa'],2))."</td>
					  	<td>".$value['no_kuitansi']."</td>
					  </tr>";
			$inc++;
		}

		$html .= "</tbody>
				</table>";
				
		echo $html;
	}
	
	public function cetakpiutangkuitansi(){
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;Filename=kuitansi_piutang_".$_GET['bulan']."_".$_GET['tahun'].".xls");
		
		$html = "<table>
					<tr>
						<td colspan=\"3\"><strong>KOPERASI KARYAWAN KELUARGA BESAR PETROKIMIA GRESIK</strong></td>
						<td align=\"right\" colspan=\"2\"><strong>TGL. : ".date("d-m-Y H:i:s")."</strong></th>
					</tr>
					<tr>
						<td colspan=\"3\"><strong>K-Mart</strong></td>
						<td colspan=\"2\"></th>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"5\"><strong>KUITANSI PIUTANG</strong></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"5\"><strong>PERIODE : ".$_GET['bulan']." - ".$_GET['tahun']."</strong></td>
					</tr>
				 </table>";
		
		$DataKartuPiutang = $this->laporan_model->getKuitansiPiutang($_GET);
		
		$html .= "<table border=\"1\">
					<thead>
						<tr>
							<th>No</th>
							<th>Perusahaan</th>
							<th>Tanggal</th>
							<th>Tagihan (Exc. PPn)</th>
							<th>PPn</th>
							<th>Total</th>
							<th>Saldo Akhir</th>
							<th>No Kuitansi</th>
						</tr>
					</thead>
					<tbody>";
		$inc = 1;
		foreach ($DataKartuPiutang as $key => $value) {
			$dpp = $value['jumlah'] / 1.11; //k3pg-ppn
			$ppn = $dpp * 0.11; //k3pg-ppn
			$html .= "<tr>
					  	<td>".$inc."</td>
					  	<td>".$value['nama_pelanggan']."</td>
					  	<td>".$value['tanggal_format']."</td>
					  	<td align=\"right\">".round($dpp,2)."</td>
					  	<td align=\"right\">".round($ppn,2)."</td>
					  	<td align=\"right\">".round($value['jumlah'],2)."</td>
					  	<td align=\"right\">".round($value['sisa'],2)."</td>
					  	<td>".$value['no_kuitansi']."</td>
					  </tr>";
			$inc++;
		}

		$html .= "</tbody>
				</table>";
		$html .= "<table>
					<tr>
						<td align=\"center\" colspan=\"3\">Mengetahui</td>
						<td align=\"center\" colspan=\"2\">Yang membuat</td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"3\"></td>
						<td align=\"center\" colspan=\"2\"></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"3\"></td>
						<td align=\"center\" colspan=\"2\"></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"3\"></td>
						<td align=\"center\" colspan=\"2\"></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"3\"><strong>(..............................)</strong></td>
						<td align=\"center\" colspan=\"2\"><strong>(..............................)</strong></td>
					</tr>
				  </table>";
		echo $html;
	}
}