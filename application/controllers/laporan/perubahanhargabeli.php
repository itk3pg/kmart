<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Perubahanhargabeli extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('laporan_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('laporan/perubahanhargabeli');
		$this->load->view('general/footer');
	}
	
	public function getperubahanhargabeli(){
		$DataPerubahanHargaBeli = $this->laporan_model->getPerubahanHargaBeli($_POST);
		
		$html = "<table class=\"table table-striped table-bordered table-hover\">
					<thead>
						<tr>
							<th>No</th>
							<th>Tgl Beli</th>
							<th>Kel</th>
							<th>Kode</th>
							<th>Nama Barang</th>
							<th>Bukti</th>
							<th align=\"right\">Qty</th>
							<th align=\"right\">Harga Beli</th>
							<th align=\"right\">HPP</th>
							<th align=\"right\">Selisih Harga</th>
							<th align=\"right\">Jumlah Selisih</th>
						</tr>
					</thead>
					<tbody>";
		$jumlahSelisih = 0;
		$nomor = 1;
		foreach ($DataPerubahanHargaBeli as $key => $value) {
			$Selisih = $value['hpp'] - $value['harga'];
			$Jumlah = $Selisih * $value['kwt'];
			$html .= "<tr>
						<td>".$nomor."</td>
						<td>".$value['tanggal']."</td>
						<td>".$value['kategori']."</td>
						<td>".$value['barang_kode']."</td>
						<td>".$value['nama_barang']."</td>
						<td>".$value['bukti']."</td>
						<td align=\"right\">".number_format($value['kwt'])."</td>
						<td align=\"right\">".number_format($value['harga'],2)."</td>
						<td align=\"right\">".number_format($value['hpp'],2)."</td>
						<td align=\"right\">".number_format($Selisih,2)."</td>
						<td align=\"right\">".number_format($Jumlah,2)."</td>
					 </tr>";
			$jumlahSelisih += $Jumlah;
			$nomor++;
		}
		$html .= "<tr>
					<td colspan=\"10\"><strong>Jumlah</strong></td>
					<td align=\"right\"><strong>".number_format($jumlahSelisih,2)."</strong></td>
				 </tr>";
		$html .=    "
					</tbody>
				 </table>";
				 
		echo $html;
	}
	
	public function cetakperubahanhargabeli(){
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;Filename=perubahanhargabeli_".$_GET['bulan']."_".$_GET['tahun'].".xls");
		
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
						<td align=\"center\" colspan=\"6\"><strong>LAPORAN PERUBAHAN HARGA BELI</strong></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"6\"><strong>PERIODE : ".$_GET['bulan']." - ".$_GET['tahun']."</strong></td>
					</tr>
				 </table>";
		$DataPerubahanHargaBeli = $this->laporan_model->getPerubahanHargaBeli($_GET);
		
		$html .= "<table border=\"1\">
					<thead>
						<tr>
							<th>No</th>
							<th>Tgl Beli</th>
							<th>Kel</th>
							<th>Kode</th>
							<th>Nama Barang</th>
							<th>Bukti</th>
							<th align=\"right\">Qty</th>
							<th align=\"right\">Harga Beli</th>
							<th align=\"right\">HPP</th>
							<th align=\"right\">Selisih Harga</th>
							<th align=\"right\">Jumlah Selisih</th>
						</tr>
					</thead>
					<tbody>";
		$jumlahSelisih = 0;
		$nomor = 1;
		foreach ($DataPerubahanHargaBeli as $key => $value) {
			$Selisih = $value['hpp'] - $value['harga'];
			$Jumlah = $Selisih * $value['kwt'];
			$html .= "<tr>
						<td>".$nomor."</td>
						<td>".$value['tanggal']."</td>
						<td>".$value['kategori']."</td>
						<td>".$value['barang_kode']."</td>
						<td>".$value['nama_barang']."</td>
						<td>".$value['bukti']."</td>
						<td align=\"right\">".number_format($value['kwt'])."</td>
						<td align=\"right\">".number_format($value['harga'],2)."</td>
						<td align=\"right\">".number_format($value['hpp'],2)."</td>
						<td align=\"right\">".number_format($Selisih,2)."</td>
						<td align=\"right\">".number_format($Jumlah,2)."</td>
					 </tr>";
			$jumlahSelisih += $Jumlah;
			$nomor++;
		}
		$html .= "<tr>
					<td colspan=\"10\"><strong>Jumlah</strong></td>
					<td align=\"right\"><strong>".number_format($jumlahSelisih,2)."</strong></td>
				 </tr>";
		$html .=    "
					</tbody>
				 </table>";
		echo $html;
	}
}