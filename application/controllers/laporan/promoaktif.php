<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Promoaktif extends CI_Controller {
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
		$this->load->view('laporan/promoaktif', $Param);
		$this->load->view('general/footer');
	}
	
	public function getdatapromoaktif(){
		$Datapromoaktif = $this->laporan_model->getDataPromo($_POST);
		$html = "";
		foreach ($Datapromoaktif as $key => $value) {
			$html .= "<tr>
						<td>".$value['kode']."</td>
						<td>".$value['barang_kode']."</td>
						<td>".$value['nama_barang']."</td>
						<td align=\"right\">".round($value['persentase_promo'],2)."</td>
						<td align=\"right\">".number_format($value['harga_promo'],2)."</td>
						<td>".$value['kwt_kondisi']."</td>
						<td>".$value['tanggal_awal']."</td>
						<td>".$value['tanggal_akhir']."</td>
					  </tr>";
		}
		
		echo $html;
	}
	
	public function cetakpromoaktif(){
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;Filename=rekap_promo_aktif_".$_GET['toko_kode'].".xls");
		$Datapromoaktif = $this->laporan_model->getDataPromo($_GET);
		
		$html = "<table>
					<tr>
						<td colspan=\"10\" align=\"center\">DATA PROMO AKTIF</td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"10\">TOKO : ".$_GET['toko_kode']."</td>
					</tr>
				 </table>";
		$html .= "<table border=\"1\" id=\"table-rekap\">
					<thead>
						<tr>
							<th>Kode Promo</th>
							<th>Kode Barang</th>
							<th>Nama Barang</th>
							<th>% Promo</th>
							<th>Potongan Harga</th>
							<th>QTY</th>
							<th>Tanggal Awal</th>
							<th>Tanggal Akhir</th>
						</tr>
					</thead>
					<tbody>";
		foreach ($Datapromoaktif as $key => $value) {
			$html .= "<tr>
						<td>".$value['kode']."</td>
						<td>".$value['barang_kode']."</td>
						<td>".$value['nama_barang']."</td>
						<td align=\"right\">".round($value['persentase_promo'],2)."</td>
						<td align=\"right\">".number_format($value['harga_promo'],2)."</td>
						<td>".$value['kwt_kondisi']."</td>
						<td>".$value['tanggal_awal']."</td>
						<td>".$value['tanggal_akhir']."</td>
					  </tr>";
		}
		$html .= "</tbody></table>";		 
		echo $html;
	}
}