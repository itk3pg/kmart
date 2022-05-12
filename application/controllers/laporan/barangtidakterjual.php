<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Barangtidakterjual extends CI_Controller {
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
		$this->load->view('laporan/barangtidakterjual', $Param);
		$this->load->view('general/footer');
	}
	
	public function getdatabarangtidakterjual(){
		$DataBarangTidakTerjual = $this->laporan_model->getBarangTidakTerjual($_POST);
		
		$html = "<table class=\"table table-striped table-bordered table-hover\">
					<thead>
						<tr>
							<th>No</th>
							<th>Kode Barang</th>
							<th>Nama Barang</th>
							<th>Saldo Akhir</th>
							<th>Hpp</th>
							<th>Jumlah</th>
						</tr>
					</thead>
					<tbody>";
		$inc = 1;
		$TotalAll = 0;
		foreach ($DataBarangTidakTerjual as $key => $value) {
			$Total = $value['saldo_akhir_kwt'] * $value['saldo_akhir_hsat'];
			$html .= "<tr>
						<td>".$inc."</td>
						<td>".$value['barang_kode']."</td>
						<td>".$value['nama_barang']."</td>
						<td align=\"right\">".number_format($value['saldo_akhir_kwt'])."</td>
						<td align=\"right\">".number_format($value['saldo_akhir_hsat'], 2)."</td>
						<td align=\"right\">".number_format($Total, 2)."</td>
					  </tr>";
			$inc++;
			$TotalAll += $Total;
		}
		$html .= "<tr>
					<td colspan=\"5\">Total</td>
					<td align=\"right\">".number_format($TotalAll, 2)."</td>
				  </tr>";
		$html .= "</tbody>
				 </table>";
		
		echo $html;
	}
	
	public function cetakdatabarangtidakterjual(){
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;Filename=barang_tidak_terjual_".$_GET['toko_kode'].".xls");
		
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
						<td align=\"center\" colspan=\"8\"><strong>DATA BARANG TIDAK TERJUAL</strong></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"8\"><strong>Toko : ".$_GET['toko_kode']." - ".$_GET['nama_toko']."</strong></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"8\"><strong>Periode : ".$_GET['tanggal_awal']." - ".$_GET['tanggal_akhir']."</strong></td>
					</tr>
				 </table>";
		$DataBarangTidakTerjual = $this->laporan_model->getBarangTidakTerjual($_GET);
		
		$html .= "<table border=\"1\">
					<thead>
						<tr>
							<th>No</th>
							<th>Kode Barang</th>
							<th>Nama Barang</th>
							<th>Saldo Akhir</th>
							<th>Hpp</th>
							<th>Jumlah</th>
						</tr>
					</thead>
					<tbody>";
		$inc = 1;
		$TotalAll = 0;
		foreach ($DataBarangTidakTerjual as $key => $value) {
			$Total = $value['saldo_akhir_kwt'] * $value['saldo_akhir_hsat'];
			$html .= "<tr>
						<td>".$inc."</td>
						<td>".$value['barang_kode']."</td>
						<td>".$value['nama_barang']."</td>
						<td align=\"right\">".number_format($value['saldo_akhir_kwt'])."</td>
						<td align=\"right\">".number_format($value['saldo_akhir_hsat'], 2)."</td>
						<td align=\"right\">".number_format($Total, 2)."</td>
					  </tr>";
			$inc++;
			$TotalAll += $Total;
		}
		$html .= "<tr>
					<td colspan=\"5\">Total</td>
					<td align=\"right\">".number_format($TotalAll, 2)."</td>
				  </tr>";
		$html .= "</tbody>
				 </table>";
		
		echo $html;
	}
}

?>