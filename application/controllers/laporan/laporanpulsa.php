<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Laporanpulsa extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('laporan_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('laporan/laporanpulsa');
		$this->load->view('general/footer');
	}
	
	public function getlaporanpulsa(){
		$DataPenjualanPulsa = $this->laporan_model->getLaporanPenjualanPulsa($_POST);
		
		$html = "<table class=\"table table-striped table-bordered table-hover\">
					<thead>
						<tr>
							<th>Kode Barang</th>
							<th>Nama Barang</th>
							<th width=\"150px\">Penjualan (BO)</th>
							<th width=\"150px\">Pengadaan (BI)</th>
							<th width=\"150px\">Selisih</th>
							<th width=\"150px\">HPP</th>
							<th width=\"150px\">Harga</th>
							<th width=\"150px\">Jumlah</th>
						</tr>
					</thead>
					<tbody>";
		
		foreach ($DataPenjualanPulsa as $key => $value) {
			$selisih = $value['kwt_jual'] - $value['kwt_bi'];
			$jumlah = $selisih * $value['fprice'];
			$html .= "<tr>
						<td>".$value['kode']."</td>
						<td>".$value['nama_barang']."</td>
						<td align=\"right\">".number_format($value['kwt_jual'])."</td>
						<td align=\"right\">".number_format($value['kwt_bi'])."</td>
						<td align=\"right\">".number_format($selisih)."</td>
						<td align=\"right\">".number_format($value['hpp'], 2)."</td>
						<td align=\"right\">".number_format($value['fprice'], 2)."</td>
						<td align=\"right\">".number_format($jumlah, 2)."</td>
					 </tr>";
		}
		$html .=    "
					</tbody>
				 </table>";
				 
		echo $html;
	}
	
	public function cetaklaporanpulsa(){
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;Filename=laporanpulsaeratel.xls");
		
		$html = "<table>
					<tr>
						<td colspan=\"3\"><strong>KOPERASI KARYAWAN KELUARGA BESAR PETROKIMIA GRESIK</strong></td>
						<td align=\"right\" colspan=\"3\"><strong>TGL. : ".date("d-m-Y H:i:s")."</strong></th>
					</tr>
					<tr>
						<td colspan=\"3\"><strong>K-Mart</strong></td>
						<td colspan=\"3\"></th>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"6\"><strong>LAPORAN PERBANDINGAN BI-BO PULSA ERATEL</strong></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"6\"><strong>PERIODE : ".$_GET['tanggal_awal']." / ".$_GET['tanggal_akhir']."</strong></td>
					</tr>
				 </table>";
		$DataPenjualanPulsa = $this->laporan_model->getLaporanPenjualanPulsa($_GET);
		
		$html .= "<table border=\"1\">
					<thead>
						<tr>
							<th>Kode Barang</th>
							<th>Nama Barang</th>
							<th width=\"150px\">Penjualan (BO)</th>
							<th width=\"150px\">Pengadaan (BI)</th>
							<th width=\"150px\">Selisih</th>
							<th width=\"150px\">HPP</th>
							<th width=\"150px\">Harga</th>
							<th width=\"150px\">Jumlah</th>
						</tr>
					</thead>
					<tbody>";
		
		foreach ($DataPenjualanPulsa as $key => $value) {
			$selisih = $value['kwt_jual'] - $value['kwt_bi'];
			$jumlah = $selisih * $value['fprice'];
			$html .= "<tr>
						<td>".$value['kode']."</td>
						<td>".$value['nama_barang']."</td>
						<td align=\"right\">".number_format($value['kwt_jual'])."</td>
						<td align=\"right\">".number_format($value['kwt_bi'])."</td>
						<td align=\"right\">".number_format($selisih)."</td>
						<td align=\"right\">".number_format($value['hpp'], 2)."</td>
						<td align=\"right\">".number_format($value['fprice'], 2)."</td>
						<td align=\"right\">".number_format($jumlah, 2)."</td>
					 </tr>";
		}
		$html .=    "
					</tbody>
				 </table>";
				
		$html .= "<table>
					<tr>
						<td align=\"center\" colspan=\"3\">Mengetahui</td>
						<td align=\"center\" colspan=\"3\">Yang membuat</td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"3\"></td>
						<td align=\"center\" colspan=\"3\"></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"3\"></td>
						<td align=\"center\" colspan=\"3\"></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"3\"></td>
						<td align=\"center\" colspan=\"3\"></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"3\"><strong>(....................................)</strong></td>
						<td align=\"center\" colspan=\"3\"><strong>(....................................)</strong></td>
					</tr>
				  </table>";
		echo $html;
	}
}