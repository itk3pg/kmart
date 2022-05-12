<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Penjualanperbarang extends CI_Controller {
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

		$DataKategori = $this->toko_model->getDataKategori();
		
		$Param['DataKategori'] = $DataKategori;
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('laporan/penjualanperbarang', $Param);
		$this->load->view('general/footer');
	}
	
	public function getdatapenjualanperbarang(){
		$DataPenjualanPerbarang = $this->laporan_model->getPenjualanPerbarang($_POST);
		
		$html = "<table class=\"table table-striped table-bordered table-hover\">
					<thead>
						<tr>
							<th>No</th>
							<th>Kode Barang</th>
							<th>Nama Barang</th>
							<th>QTY</th>
							<th>RP</th>
							<th>AVG</th>
						</tr>
					</thead>
					<tbody>";
		$start_date = new DateTime($_POST['tanggal_awal']);
		$end_date = new DateTime($_POST['tanggal_akhir']);
		$interval = $start_date->diff($end_date);
		$days = $interval->format("%a");
		if ($days <= 0)  { 
			$days = 1;
		}  else  {
			$days = $interval->format("%a");
		}
			

		$inc = 1;
		$TotalRP = 0;
		foreach ($DataPenjualanPerbarang as $key => $value) {
			$avg = $value['qty'] / $days;
			//{if  ( $avg = 0 ) then { $avg = $value['qty'] / ($days + 1) ; } else { $avg = $value['qty'] / 1;}
			//$avg = $value['qty'] / $days;						
			$html .= "<tr>
						<td>".$inc."</td>
						<td>".$value['fitemkey']."</td>
						<td>".$value['nama_barang']."</td>
						<td align=\"right\">".$value['qty']."</td>
						<td align=\"right\">".number_format($value['total'],2)."</td>
						<td align=\"right\">".round($avg, 2)."</td>
					  </tr>";
			$inc++;
			$TotalRP += $value['total'];
		}
		$html .= "<tr>
					<td colspan=\"4\"><strong>Total</strong></td>
					<td align=\"right\"><strong>".number_format($TotalRP,2)."</strong></td>
					<td></td>
				  </tr>";
		$html .= "</tbody>
				 </table>";
		
		echo $html;
	}
	
	public function cetakdatapenjualanperbarang(){
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;Filename=penjualan_perbarang_".$_GET['toko_kode'].".xls");
		
		$DataPenjualanPerbarang = $this->laporan_model->getPenjualanPerbarang($_GET);
		
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
						<td align=\"center\" colspan=\"8\"><strong>DATA PENJUALAN PER BARANG</strong></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"8\"><strong>Toko : ".$_GET['toko_kode']." - ".$_GET['nama_toko']."</strong></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"8\"><strong>Periode : ".$_GET['tanggal_awal']." - ".$_GET['tanggal_akhir']."</strong></td>
					</tr>
				 </table>";
		$html = "<table border=\"1\">
					<thead>
						<tr>
							<th>No</th>
							<th>Kode Barang</th>
							<th>Nama Barang</th>
							<th>QTY</th>
							<th>RP</th>
							<th>AVG</th>
						</tr>
					</thead>
					<tbody>";
		$start_date = new DateTime($_GET['tanggal_awal']);
		$end_date = new DateTime($_GET['tanggal_akhir']);
		$interval = $start_date->diff($end_date);
		$days = $interval->format("%a");

		$inc = 1;
		$TotalRP = 0;
		foreach ($DataPenjualanPerbarang as $key => $value) {
			$avg = $value['qty'] / $days;
			$html .= "<tr>
						<td>".$inc."</td>
						<td>".$value['fitemkey']."</td>
						<td>".$value['nama_barang']."</td>
						<td align=\"right\">".$value['qty']."</td>
						<td align=\"right\">".number_format($value['total'],2)."</td>
						<td align=\"right\">".round($avg, 2)."</td>
					  </tr>";
			$inc++;
			$TotalRP += $value['total'];
		}
		$html .= "<tr>
					<td colspan=\"4\"><strong>Total</strong></td>
					<td align=\"right\"><strong>".number_format($TotalRP,2)."</strong></td>
					<td></td>
				  </tr>";
		$html .= "</tbody>
				 </table>";
		
		echo $html;
	}
}

?>