<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Databarangsupplier extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('laporan_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');

		$this->load->model('supplier_model');
		$DataSupplier = $this->supplier_model->getDataSupplier();
		$Data['datasupplier'] = $DataSupplier;
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('laporan/databarangsupplier', $Data);
		$this->load->view('general/footer');
	}
	
	public function getdatabarangsupplier(){
		$Databarangsupplier = $this->laporan_model->getDataBarangSupplier($_POST);
		
		$html = "<table class=\"table table-striped table-bordered table-hover\">
					<thead>
						<tr>
							<th>Kode Supplier</th>
							<th>Nama Supplier</th>
							<th>Kode Barang</th>
							<th>Barcode</th>
							<th>Nama Barang</th>
							<th>Kategori</th>
							<th>Satuan</th>
							<th>Harga Beli Terakhir</th>
						</tr>
					</thead>
					<tbody>";
		
		foreach ($Databarangsupplier as $key => $value) {
			$html .= "<tr>
						<td>".$value['supplier_kode']."</td>
						<td>".$value['nama_supplier']."</td>
						<td>".$value['kode']."</td>
						<td>".$value['barcode']."</td>
						<td>".$value['nama_barang']."</td>
						<td>".$value['nama_kategori']."</td>
						<td>".$value['satuan']."</td>
						<td align=\"right\">".number_format($value['harga'], 2)."</td>";
			$html .= "</tr>";
		}
		$html .= "</tbody>
				 </table>";
		
		echo $html;
	}
	
	public function cetakdatabarangsupplier(){
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;Filename=barang_supplier.xls");
		
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
						<td align=\"center\" colspan=\"8\"><strong>DATA BARANG SUPPLIER</strong></td>
					</tr>
				 </table>";
		$Databarangsupplier = $this->laporan_model->getDataBarangSupplier($_GET);
		
		$html = "<table border=\"1\">
					<thead>
						<tr>
							<th>Kode Supplier</th>
							<th>Nama Supplier</th>
							<th>Kode Barang</th>
							<th>Barcode</th>
							<th>Nama Barang</th>
							<th>Kategori</th>
							<th>Satuan</th>
							<th>Harga Beli Terakhir</th>
						</tr>
					</thead>
					<tbody>";
		
		foreach ($Databarangsupplier as $key => $value) {
			$html .= "<tr>
						<td>".$value['supplier_kode']."</td>
						<td>".$value['nama_supplier']."</td>
						<td>".$value['kode']."</td>
						<td>".$value['barcode']."</td>
						<td>".$value['nama_barang']."</td>
						<td>".$value['nama_kategori']."</td>
						<td>".$value['satuan']."</td>
						<td>".$value['harga']."</td>";
			$html .= "</tr>";
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