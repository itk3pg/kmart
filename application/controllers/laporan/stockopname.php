<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stockopname extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('laporan_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('laporan/stockopname');
		$this->load->view('general/footer');
	}
	
	public function getstockopname(){
		$DataStockOpname = $this->laporan_model->getLaporanStockOpname($_POST);
		
		$html = "<table class=\"table table-striped table-bordered table-hover\" id=\"dataTables-stockopname\">
					<thead>
						<tr>
							<th>Kode Barang</th>
							<th>Nama Barang</th>
							<th>Rak</th>
							<th>Stok Sistem</th>
							<th>Stok Fisik</th>
							<th>Selisih</th>
							<th>HPP</th>
							<th>Jumlah Selisih</th>
						</tr>
					</thead>
					<tbody>";
		
		$TotalAll = 0;
		foreach ($DataStockOpname as $key => $value) {
			$html .= "<tr>
						<td>".$value['barang_kode']."</td>
						<td>".$value['nama_barang']."</td>
						<td>".$value['rak']."</td>
						<td align=\"right\">".$value['stok_sistem']."</td>
						<td align=\"right\">".($value['stok_fisik'] + $value['revisi'])."</td>
						<td align=\"right\">".$value['selisih']."</td>
						<td align=\"right\">".number_format($value['hpp'], 2)."</td>
						<td align=\"right\">".number_format($value['jumlah_selisih'], 2)."</td>
					 </tr>";
			
			$TotalAll += $value['jumlah_selisih'];
		}
		//$html .= "<tr>
		//			<td colspan=\"7\"><strong>Total</strong></td>
		//			<td align=\"right\"><strong>".number_format($TotalAll,2)."</strong></td>
		//		 </tr>";
		$html .=    "
					</tbody>
				 </table>";
				 
		echo $html;
	}
	
	public function cetakstockopname(){
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;Filename=hasil_stockopname_".$_GET['toko_kode']."_".$_GET['bukti'].".xls");
		
		$DataStockOpname = $this->laporan_model->getLaporanStockOpname($_GET);
		
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
						<td align=\"center\" colspan=\"6\"><strong>LAPORAN STOCK OPNAME</strong></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"6\"><strong>TEMPAT : ".$_GET['nama_toko']."</strong></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"6\"><strong>BUKTI : ".$_GET['bukti']."</strong></td>
					</tr>
				 </table>";
		$html .= "<table border=\"1\">
					<thead>
						<tr>
							<th>Kode Barang</th>
							<th>Nama Barang</th>
							<th>Rak</th>
							<th>Stok Sistem</th>
							<th>Stok Fisik</th>
							<th>Selisih</th>
							<th>HPP</th>
							<th>Jumlah Selisih</th>
						</tr>
					</thead>
					<tbody>";
		
		$TotalAll = 0;
		foreach ($DataStockOpname as $key => $value) {
			$html .= "<tr>
						<td>'".$value['barang_kode']."</td>
						<td>".$value['nama_barang']."</td>
						<td>".$value['rak']."</td>
						<td align=\"right\">".$value['stok_sistem']."</td>
						<td align=\"right\">".($value['stok_fisik'] + $value['revisi'])."</td>
						<td align=\"right\">".$value['selisih']."</td>
						<td align=\"right\">".$value['hpp']."</td>
						<td align=\"right\">".$value['jumlah_selisih']."</td>
					 </tr>";
			
			$TotalAll += $value['jumlah_selisih'];
		}
		$html .= "<tr>
					<td colspan=\"7\"><strong>Total</strong></td>
					<td align=\"right\"><strong>".$TotalAll."</strong></td>
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