<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Databarangpos extends CI_Controller {
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
		$this->load->view('laporan/databarangpos', $Param);
		$this->load->view('general/footer');
	}
	
	public function getdatabarangpos(){
		$DataBarangPOS = $this->laporan_model->getDataBarangPOS($_POST);
		
		$html = "<table class=\"table table-striped table-bordered table-hover\">
					<thead>
						<tr>
							<th>Kode Barang</th>
							<th>Nama Barang</th>
							<th>Satuan</th>
							<th>Harga Beli</th>
							<th>HPP</th>
							<th>Harga Jual 1</th>
							<th>Harga Jual 2</th>
						</tr>
					</thead>
					<tbody>";
		
		foreach ($DataBarangPOS as $key => $value) {
			
			$html .= "<tr>
						<td>".$value['barang_kode']."</td>
						<td>".$value['nama_barang']."</td>
						<td>".$value['satuan']."</td>
						<td align=\"right\">".number_format($value['harga_beli'],2)."</td>
						<td align=\"right\">".number_format($value['hpp'],2)."</td>
						<td align=\"right\">".number_format($value['harga_jual_1'],2)."</td>
						<td align=\"right\">".number_format($value['harga_jual_2'],2)."</td>
					  </tr>";
		}
		$html .= "</tbody>
				 </table>";
		
		echo $html;
	}
	
	public function cetakdatabarangpos(){
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;Filename=barang_pos".$_GET['toko_kode'].".xls");
		
		$DataBarangPOS = $this->laporan_model->getDataBarangPOS($_GET);
		
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
						<td align=\"center\" colspan=\"8\"><strong>DATA BARANG POS</strong></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"8\"><strong>Toko : ".$_GET['toko_kode']." - ".$_GET['nama_toko']."</strong></td>
					</tr>
				 </table>";
		$html .= "<table border=\"1\">
					<thead>
						<tr>
							<th>Kode Barang</th>
							<th>Nama Barang</th>
							<th>Satuan</th>
							<th>Harga Beli</th>
							<th>HPP</th>
							<th>Harga Jual 1</th>
							<th>Harga Jual 2</th>
						</tr>
					</thead>
					<tbody>";
		
		foreach ($DataBarangPOS as $key => $value) {
			$html .= "<tr>
						<td>'".$value['barang_kode']."</td>
						<td>".$value['nama_barang']."</td>
						<td>".$value['satuan']."</td>
						<td align=\"right\">".$value['harga_beli']."</td>
						<td align=\"right\">".$value['hpp']."</td>
						<td align=\"right\">".$value['harga_jual_1']."</td>
						<td align=\"right\">".$value['harga_jual_2']."</td>
					  </tr>";
		}
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