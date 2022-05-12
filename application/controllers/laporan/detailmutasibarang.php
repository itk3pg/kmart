<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Detailmutasibarang extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('laporan_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$this->load->model('toko_model');
		$Data = array();
		$DataToko = $this->toko_model->getDataToko();
		$Data['datatoko'] = $DataToko;
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('laporan/detailmutasibarang', $Data);
		$this->load->view('general/footer');
	}
	
	public function getdetailmutasibarangtoko(){
		$DataDetailMutasiBarang = $this->laporan_model->getDetailMutasiBarangToko($_POST);
		
		$html = "<table class=\"table table-striped table-bordered table-hover\">
					<thead>
						<tr>
							<th>Kode Barang</th>
							<th>Nama Barang</th>
							<th>Satuan</th>
							<th>Penerimaan Barang</th>
							<th>Penjualan</th>
							<th>Retur ke DC</th>
						</tr>
					</thead>
					<tbody>";
		$jumlahPenerimaan = 0;
		$jumlahPenjualan = 0;
		$jumlahRetur = 0;
		foreach ($DataDetailMutasiBarang as $key => $value) {
			$html .= "<tr>
						<td>".$value['barang_kode']."</td>
						<td>".$value['nama_barang']."</td>
						<td>".$value['satuan']."</td>
						<td align=\"right\">".$value['kwt_transfer']."</td>
						<td align=\"right\">".$value['kwt_penjualan']."</td>
						<td align=\"right\">".$value['kwt_retur']."</td>
					</tr>";
			$jumlahPenerimaan += $value['kwt_transfer'];
			$jumlahPenjualan += $value['kwt_penjualan'];
			$jumlahRetur += $value['kwt_retur'];
		}
		$html .= "<tr>
					<td colspan=\"3\">Total</td>
					<td align=\"right\">".$jumlahPenerimaan."</td>
					<td align=\"right\">".$jumlahPenjualan."</td>
					<td align=\"right\">".$jumlahRetur."</td>
				  </tr>";
		$html .=    "
					</tbody>
				 </table>";
				 
		echo $html;
	}
	
	public function getdetailmutasibarangdc(){
		$DataDetailMutasiBarangDC = $this->laporan_model->getDetailMutasiBarangDC($_POST);
		
		$html = "<table class=\"table table-striped table-bordered table-hover\">
					<thead>
						<tr>
							<th>Kode Barang</th>
							<th>Nama Barang</th>
							<th>Satuan</th>
							<th>Pengadaan Barang</th>
							<th>Retur Toko</th>
							<th>Transfer Toko</th>
							<th>TAU Keluar</th>
							<th>Retur Supplier</th>
						</tr>
					</thead>
					<tbody>";
		$jumlahPengadaan = 0;
		$jumlahReturToko = 0;
		$jumlahTransferToko = 0;
		$jumlahTAUKeluar = 0;
		$jumlahReturSupplier = 0;
		foreach ($DataDetailMutasiBarangDC as $key => $value) {
			$html .= "<tr>
						<td>".$value['barang_kode']."</td>
						<td>".$value['nama_barang']."</td>
						<td>".$value['satuan']."</td>
						<td align=\"right\">".$value['kwt_pengadaan']."</td>
						<td align=\"right\">".$value['kwt_returtoko']."</td>
						<td align=\"right\">".$value['kwt_transfertoko']."</td>
						<td align=\"right\">".$value['kwt_taukeluar']."</td>
						<td align=\"right\">".$value['kwt_retursupplier']."</td>
					</tr>";
			$jumlahPengadaan += $value['kwt_pengadaan'];
			$jumlahReturToko += $value['kwt_returtoko'];
			$jumlahTransferToko += $value['kwt_transfertoko'];
			$jumlahTAUKeluar += $value['kwt_taukeluar'];
			$jumlahReturSupplier += $value['kwt_retursupplier'];
		}
		$html .= "<tr>
					<td colspan=\"3\">Total</td>
					<td align=\"right\">".$jumlahPengadaan."</td>
					<td align=\"right\">".$jumlahReturToko."</td>
					<td align=\"right\">".$jumlahTransferToko."</td>
					<td align=\"right\">".$jumlahTAUKeluar."</td>
					<td align=\"right\">".$jumlahReturSupplier."</td>
				  </tr>";
		$html .=    "
					</tbody>
				 </table>";
				 
		echo $html;
	}
	
	public function cetakdetailmutasibarangtoko(){
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;Filename=detailmutasibarang_".$_GET['toko_kode'].".xls");
		
		$html = "<table>
					<tr>
						<td colspan=\"5\"><strong>KOPERASI KARYAWAN KELUARGA BESAR PETROKIMIA GRESIK</strong></td>
						<td align=\"right\" colspan=\"3\"><strong>TGL. : ".date("d-m-Y H:i:s")."</strong></th>
					</tr>
					<tr>
						<td colspan=\"5\"><strong>K-Mart</strong></td>
						<td colspan=\"3\"></th>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"8\"><strong>DETAIL MUTASI BARANG</strong></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"8\"><strong>PERIODE : ".$_GET['tanggal_awal']." / ".$_GET['tanggal_akhir']."</strong></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"8\"><strong>TOKO/UNIT : ".$_GET['nama_toko']."</strong></td>
					</tr>
				 </table>";
		
		$DataDetailMutasiBarang = $this->laporan_model->getDetailMutasiBarangToko($_GET);
		
		$html .= "<table border=\"1\">
					<thead>
						<tr>
							<th>Kode Barang</th>
							<th>Nama Barang</th>
							<th>Satuan</th>
							<th>Penerimaan Barang</th>
							<th>Penjualan</th>
							<th>Retur ke DC</th>
						</tr>
					</thead>
					<tbody>";
		$jumlahPenerimaan = 0;
		$jumlahPenjualan = 0;
		$jumlahRetur = 0;
		foreach ($DataDetailMutasiBarang as $key => $value) {
			$html .= "<tr>
						<td>".$value['barang_kode']."</td>
						<td>".$value['nama_barang']."</td>
						<td>".$value['satuan']."</td>
						<td align=\"right\">".$value['kwt_transfer']."</td>
						<td align=\"right\">".$value['kwt_penjualan']."</td>
						<td align=\"right\">".$value['kwt_retur']."</td>
					</tr>";
			$jumlahPenerimaan += $value['kwt_transfer'];
			$jumlahPenjualan += $value['kwt_penjualan'];
			$jumlahRetur += $value['kwt_retur'];
		}
		$html .= "<tr>
					<td colspan=\"3\">Total</td>
					<td align=\"right\">".$jumlahPenerimaan."</td>
					<td align=\"right\">".$jumlahPenjualan."</td>
					<td align=\"right\">".$jumlahRetur."</td>
				  </tr>";
		$html .=    "
					</tbody>
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
						<td align=\"center\" colspan=\"4\"><strong>(......................)</strong></td>
						<td align=\"center\" colspan=\"4\"><strong>(......................)</strong></td>
					</tr>
				  </table>";
		echo $html;
	}
	
	public function cetakdetailmutasibarangdc(){
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;Filename=detailmutasibarang_".$_GET['toko_kode'].".xls");
		
		$html = "<table>
					<tr>
						<td colspan=\"5\"><strong>KOPERASI KARYAWAN KELUARGA BESAR PETROKIMIA GRESIK</strong></td>
						<td align=\"right\" colspan=\"3\"><strong>TGL. : ".date("d-m-Y H:i:s")."</strong></th>
					</tr>
					<tr>
						<td colspan=\"5\"><strong>K-Mart</strong></td>
						<td colspan=\"3\"></th>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"8\"><strong>DETAIL MUTASI BARANG</strong></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"8\"><strong>PERIODE : ".$_GET['tanggal_awal']." / ".$_GET['tanggal_akhir']."</strong></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"8\"><strong>TOKO/UNIT : ".$_GET['nama_toko']."</strong></td>
					</tr>
				 </table>";
		
		$DataDetailMutasiBarangDC = $this->laporan_model->getDetailMutasiBarangDC($_GET);
		
		$html .= "<table border=\"1\">
					<thead>
						<tr>
							<th>Kode Barang</th>
							<th>Nama Barang</th>
							<th>Satuan</th>
							<th>Pengadaan Barang</th>
							<th>Retur Toko</th>
							<th>Transfer Toko</th>
							<th>TAU Keluar</th>
							<th>Retur Supplier</th>
						</tr>
					</thead>
					<tbody>";
		$jumlahPengadaan = 0;
		$jumlahReturToko = 0;
		$jumlahTransferToko = 0;
		$jumlahTAUKeluar = 0;
		$jumlahReturSupplier = 0;
		foreach ($DataDetailMutasiBarangDC as $key => $value) {
			$html .= "<tr>
						<td>".$value['barang_kode']."</td>
						<td>".$value['nama_barang']."</td>
						<td>".$value['satuan']."</td>
						<td align=\"right\">".$value['kwt_pengadaan']."</td>
						<td align=\"right\">".$value['kwt_returtoko']."</td>
						<td align=\"right\">".$value['kwt_transfertoko']."</td>
						<td align=\"right\">".$value['kwt_taukeluar']."</td>
						<td align=\"right\">".$value['kwt_retursupplier']."</td>
					</tr>";
			$jumlahPengadaan += $value['kwt_pengadaan'];
			$jumlahReturToko += $value['kwt_returtoko'];
			$jumlahTransferToko += $value['kwt_transfertoko'];
			$jumlahTAUKeluar += $value['kwt_taukeluar'];
			$jumlahReturSupplier += $value['kwt_retursupplier'];
		}
		$html .= "<tr>
					<td colspan=\"3\">Total</td>
					<td align=\"right\">".$jumlahPengadaan."</td>
					<td align=\"right\">".$jumlahReturToko."</td>
					<td align=\"right\">".$jumlahTransferToko."</td>
					<td align=\"right\">".$jumlahTAUKeluar."</td>
					<td align=\"right\">".$jumlahReturSupplier."</td>
				  </tr>";
		$html .=    "
					</tbody>
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
						<td align=\"center\" colspan=\"4\"><strong>(......................)</strong></td>
						<td align=\"center\" colspan=\"4\"><strong>(......................)</strong></td>
					</tr>
				  </table>";
		echo $html;
	}
}