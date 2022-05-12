<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Laporanfeepln extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('laporan_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('laporan/laporanfeepln');
		$this->load->view('general/footer');
	}
	
	public function getlaporanpulsa(){
		$DataPenjualanPulsa = $this->laporan_model->getLaporanFeePLN($_POST);
		
		$html = "<table class=\"table table-striped table-bordered table-hover\">
					<thead>
						<tr>
							<th>No Transaksi</th>
							<th>Tanggal</th>
							<th>Kode Barang</th>
							<th>Nama Barang</th>
							<th>QTY</th>
							<th>Fee</th>
							<th>Jumlah</th>
						</tr>
					</thead>
					<tbody>";
		$TotalAll = 0;
		foreach ($DataPenjualanPulsa as $key => $value) {
			$fee = 1250;
			$total = $fee * $value['fqty'];
			$html .= "<tr>
						<td>".$value['fcode']."</td>
						<td>".$value['fdate']."</td>
						<td>".$value['fitemkey']."</td>
						<td>".$value['nama_barang']."</td>
						<td align=\"right\">".number_format($value['fqty'])."</td>
						<td align=\"right\">".number_format($fee)."</td>
						<td align=\"right\">".number_format($total)."</td>
					 </tr>";
			$TotalAll += $total;
		}
		$html .= "<tr>
						<td colspan=\"6\">Total</td>
						<td align=\"right\">".number_format($TotalAll)."</td>
					 </tr>";
		$html .=    "
					</tbody>
				 </table>";
				 
		echo $html;
	}
	
	public function cetaklaporanpulsa(){
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;Filename=laporanplneratel.xls");
		
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
						<td align=\"center\" colspan=\"6\"><strong>LAPORAN FEE VOUCHER LISTRIK ERATEL</strong></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"6\"><strong>TOKO : ".$_GET['nama_toko']."</strong></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"6\"><strong>PERIODE : ".$_GET['tanggal_awal']." / ".$_GET['tanggal_akhir']."</strong></td>
					</tr>
				 </table>";
		$DataPenjualanPulsa = $this->laporan_model->getLaporanFeePLN($_GET);
		
		$html .= "<table border=\"1\">
					<thead>
						<tr>
							<th>No Transaksi</th>
							<th>Tanggal</th>
							<th>Kode Barang</th>
							<th>Nama Barang</th>
							<th>QTY</th>
							<th>Fee</th>
							<th>Jumlah</th>
						</tr>
					</thead>
					<tbody>";
		$TotalAll = 0;
		foreach ($DataPenjualanPulsa as $key => $value) {
			$fee = 1250;
			$total = $fee * $value['fqty'];
			$html .= "<tr>
						<td>".$value['fcode']."</td>
						<td>".$value['fdate']."</td>
						<td>".$value['fitemkey']."</td>
						<td>".$value['nama_barang']."</td>
						<td align=\"right\">".number_format($value['fqty'])."</td>
						<td align=\"right\">".number_format($fee)."</td>
						<td align=\"right\">".number_format($total)."</td>
					 </tr>";
			$TotalAll += $total;
		}
		$html .= "<tr>
						<td colspan=\"6\">Total</td>
						<td align=\"right\">".number_format($TotalAll)."</td>
					 </tr>";
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