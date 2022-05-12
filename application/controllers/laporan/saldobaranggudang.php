<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Saldobaranggudang extends CI_Controller {
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
		$this->load->view('laporan/saldobaranggudang', $Data);
		$this->load->view('general/footer');
	}
	
	public function getsaldobaranggudang(){
		$DataMasterSupplier = $this->laporan_model->getMasterSupplierBarang();
		$DataSaldoBarangGudang = $this->laporan_model->getSaldoBarangGudang($_POST);
		
		$html = "<table class=\"table table-striped table-bordered table-hover\">
					<thead>
						<tr>
							<th>Kode Barang</th>
							<th>Nama Barang</th>
							<th>Kode Kelompok</th>
							<th>Nama Kelompok</th>
							<th>Kode Supplier</th>
							<th>Nama Supplier</th>
							<th>Satuan</th>
							<th>Saldo Awal KWT</th>
							<th>KWT IN</th>
							<th>KWT OUT</th>
							<th>Retur</th>
							<th>Saldo Akhir KWT</th>
							<th>HPP</th>
							<th>Jumlah</th>
							<th>Detail</th>
						</tr>
					</thead>
					<tbody>";
		$jumlahSaldoAwal = 0;
		$jumlahIn = 0;
		$jumlahOut = 0;
		$jumlahRetur = 0;
		$JumlahSaldoAkhir = 0;
		$JumlahHPP = 0;

		$JumlahSaldoAWalRp = 0;
		$JumlahInRp = 0;
		$JumlahOutRp = 0;
		$JumlahReturRp = 0;
		$JumlahSaldoAkhirRp = 0;
		foreach ($DataSaldoBarangGudang as $key => $value) {
			$SupArr = array();
			$SupArr['supplier_kode'] = "";
			$SupArr['nama_supplier'] = "";
			if(isset($DataMasterSupplier[$value['barang_kode']])){
				$SupArr = $DataMasterSupplier[$value['barang_kode']];
			}
			
			$html .= "<tr>
						<td>".$value['barang_kode']."</td>
						<td>".$value['nama_barang']."</td>
						<td>".$value['kategori']."</td>
						<td>".$value['nama_kategori']."</td>
						<td>".$SupArr['supplier_kode']."</td>
						<td>".$SupArr['nama_supplier']."</td>
						<td>".$value['satuan']."</td>
						<td align=\"right\">".round($value['saldo_awal_kwt'],2)."</td>
						<td align=\"right\">".round($value['kwt_in'],2)."</td>
						<td align=\"right\">".round($value['kwt_out'],2)."</td>
						<td align=\"right\">".round($value['retur'],2)."</td>
						<td align=\"right\">".round($value['saldo_akhir_kwt'],2)."</td>
						<td align=\"right\">".number_format($value['hpp'],2)."</td>
						<td align=\"right\">".number_format($value['jumlah_hpp'],2)."</td>
						<td><button onclick=\"openformdetail('".$value['barang_kode']."')\">Detail</button></td>
					</tr>";
			$jumlahSaldoAwal += $value['saldo_awal_kwt'];
			$jumlahIn += $value['kwt_in'];
			$jumlahOut += $value['kwt_out']; 
			//- $value['retur'];
			$jumlahRetur += $value['retur'];
			$JumlahSaldoAkhir += $value['saldo_akhir_kwt'];
			$JumlahHPP += $value['jumlah_hpp'];

			$JumlahSaldoAWalRp += $value['saldo_awal_kwt'] * $value['hpp'];
			$JumlahInRp += $value['kwt_in'] * $value['hpp'];
			$JumlahOutRp += ($value['kwt_out'] - $value['retur']) * $value['hpp'];
			$JumlahReturRp += $value['retur'] * $value['hpp'];
			$JumlahSaldoAkhirRp += $value['saldo_akhir_kwt'] * $value['hpp'];
		}
		$html .= "<tr>
					<td colspan=\"7\">Total</td>
					<td align=\"right\">".round($jumlahSaldoAwal,2)."</td>
					<td align=\"right\">".round($jumlahIn,2)."</td>
					<td align=\"right\">".round($jumlahOut,2)."</td>
					<td align=\"right\">".round($jumlahRetur,2)."</td>
					<td align=\"right\">".round($JumlahSaldoAkhir,2)."</td>
					<td align=\"right\"></td>
					<td align=\"right\">".number_format($JumlahHPP,2)."</td>
				  </tr>";
		$html .=    "
					</tbody>
				 </table>";

		$html .= "<table class=\"table table-striped table-bordered table-hover\">
					<tr>
						<td>Jumlah Saldo Awal</td>
						<td> : </td>
						<td>".number_format($JumlahSaldoAWalRp, 2)."</td>
					</tr>
					<tr>
						<td>Jumlah Masuk</td>
						<td> : </td>
						<td>".number_format($JumlahInRp, 2)."</td>
					</tr>
					<tr>
						<td>Jumlah Keluar</td>
						<td> : </td>
						<td>".number_format($JumlahOutRp, 2)."</td>
					</tr>
					<tr>
						<td>Jumlah Retur</td>
						<td> : </td>
						<td>".number_format($JumlahReturRp, 2)."</td>
					</tr>
					<tr>
						<td>Jumlah Saldo AKhir</td>
						<td> : </td>
						<td>".number_format($JumlahSaldoAkhirRp, 2)."</td>
					</tr>
				  </table>";
				 
		echo $html;
	}
	
	public function getdetailbarang(){
		$DataSaldo = $this->laporan_model->getDetailSaldo($_POST);
		
		$html = "<table class=\"table table-striped table-bordered table-hover\">
					<thead>
						<tr>
							<th>Tanggal</th>
							<th>Bukti</th>
							<th>Toko</th>
							<th>Kode Barang</th>
							<th>KWT IN</th>
							<th>KWT OUT</th>
						</tr>
					</thead>
					<tbody>";
		$kwt_in = 0;
		$kwt_out = 0;
		$jumlah_in = 0;
		$jumlah_out = 0;
		$nama_toko = "";
		foreach ($DataSaldo as $key => $value) {
			if($value['toko_kode'] == "VO0001"){
				$nama_toko = "Toko 1";
			}else if ($value['toko_kode'] == "VO0002"){
				$nama_toko = "Toko 2";
			}else if ($value['toko_kode'] == "VO0003"){
				$nama_toko = "KSport";
			}else{
				$nama_toko = "";
			}

			$html .= "<tr>
						<td>".$value['tanggal']."</td>
						<td>".$value['bukti']."</td>
						<td>".$nama_toko."</td>
						<td>".$value['barang_kode']."</td>";
			if($value['mode'] == "1"){
				$kwt_in = $value['kwt'];
				$kwt_out = 0;
			}else{
				$kwt_in = 0;
				$kwt_out = $value['kwt'];
			}
			$html .= "<td align=\"right\">".$kwt_in."</td>
					  <td align=\"right\">".$kwt_out."</td>
					  </tr>";
			$jumlah_in += $kwt_in;
			$jumlah_out += $kwt_out;
		}
		$html .= "<tr>
					<td colspan=\"4\"><strong>Total</strong></td>
					<td align=\"right\"><strong>".$jumlah_in."</strong></td>
					<td align=\"right\"><strong>".$jumlah_out."</strong></td>
				  </tr>";
		$html .=    "
					</tbody>
				 </table>";
				 
		echo $html;
	}
	
	public function cetaksaldobaranggudang(){
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;Filename=saldo_barang_gudang_".$_GET['toko_kode']."_".$_GET['bulan']."_".$_GET['tahun'].".xls");
		
		$_GET['cetak'] = "1";
		$DataSaldoBarangGudang = $this->laporan_model->getSaldoBarangGudang($_GET);
		$DataMasterSupplier = $this->laporan_model->getMasterSupplierBarang();
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
						<td align=\"center\" colspan=\"8\"><strong>LAPORAN SALDO BARANG GUDANG</strong></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"8\"><strong>PERIODE : ".$_GET['bulan']." - ".$_GET['tahun']."</strong></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"8\"><strong>TOKO : ".$DataSaldoBarangGudang[0]['nama_toko']."</strong></td>
					</tr>
				 </table>";
		
		$html .= "<table border=\"1\">
					<thead>
						<tr>
							<th>Kode Barang</th>
							<th>Nama Barang</th>
							<th>Kode Kelompok</th>
							<th>Nama Kelompok</th>
							<th>Kode Supplier</th>
							<th>Nama Supplier</th>
							<th>Satuan</th>
							<th>Saldo Awal KWT</th>
							<th>KWT IN</th>
							<th>KWT OUT</th>
							<th>Retur</th>
							<th>Saldo Akhir KWT</th>
							<th>HPP</th>
							<th>Jumlah</th>
						</tr>
					</thead>
					<tbody>";
		$jumlahSaldoAwal = 0;
		$jumlahIn = 0;
		$jumlahOut = 0;
		$jumlahRetur = 0;
		$JumlahSaldoAkhir = 0;
		$JumlahHPP = 0;

		$JumlahSaldoAWalRp = 0;
		$JumlahInRp = 0;
		$JumlahOutRp = 0;
		$JumlahReturRp = 0;
		$JumlahSaldoAkhirRp = 0;
		foreach ($DataSaldoBarangGudang as $key => $value) {
			$SupArr = array();
			$SupArr['supplier_kode'] = "";
			$SupArr['nama_supplier'] = "";
			if(isset($DataMasterSupplier[$value['barang_kode']])){
				$SupArr = $DataMasterSupplier[$value['barang_kode']];
			}
			$html .= "<tr>
						<td>".$value['barang_kode']."</td>
						<td>".$value['nama_barang']."</td>
						<td>".$value['kategori']."</td>
						<td>".$value['nama_kategori']."</td>
						<td>".$SupArr['supplier_kode']."</td>
						<td>".$SupArr['nama_supplier']."</td>
						<td>".$value['satuan']."</td>
						<td align=\"right\">".round($value['saldo_awal_kwt'],2)."</td>
						<td align=\"right\">".round($value['kwt_in'],2)."</td>
						<td align=\"right\">".round($value['kwt_out'],2)."</td>
						<td align=\"right\">".round($value['retur'],2)."</td>
						<td align=\"right\">".round($value['saldo_akhir_kwt'],2)."</td>
						<td align=\"right\">".number_format($value['hpp'],2)."</td>
						<td align=\"right\">".number_format($value['jumlah_hpp'],2)."</td>
					</tr>";
			// - $value['retur'],		
			$jumlahSaldoAwal += $value['saldo_awal_kwt'];
			$jumlahIn += $value['kwt_in'];
			$jumlahOut += $value['kwt_out']; 
			// - $value['retur'];
			$jumlahRetur += $value['retur'];
			$JumlahSaldoAkhir += $value['saldo_akhir_kwt'];
			$JumlahHPP += $value['jumlah_hpp'];

			$JumlahSaldoAWalRp += $value['saldo_awal_kwt'] * $value['hpp'];
			$JumlahInRp += $value['kwt_in'] * $value['hpp'];
			$JumlahOutRp += ($value['kwt_out'] - $value['retur']) * $value['hpp'];
			$JumlahReturRp += $value['retur'] * $value['hpp'];
			$JumlahSaldoAkhirRp += $value['saldo_akhir_kwt'] * $value['hpp'];
		}
		$html .= "<tr>
					<td colspan=\"5\">Total</td>
					<td align=\"right\">".round($jumlahSaldoAwal,2)."</td>
					<td align=\"right\">".round($jumlahIn,2)."</td>
					<td align=\"right\">".round($jumlahOut,2)."</td>
					<td align=\"right\">".round($jumlahRetur,2)."</td>
					<td align=\"right\">".round($JumlahSaldoAkhir,2)."</td>
					<td align=\"right\"></td>
					<td align=\"right\">".number_format($JumlahHPP,2)."</td>
				  </tr>";
		$html .=    "
					</tbody>
				 </table>";

		$html .= "<table border=\"1\">
					<tr>
						<td>Jumlah Saldo Awal</td>
						<td> : </td>
						<td>".number_format($JumlahSaldoAWalRp, 2)."</td>
					</tr>
					<tr>
						<td>Jumlah Masuk</td>
						<td> : </td>
						<td>".number_format($JumlahInRp, 2)."</td>
					</tr>
					<tr>
						<td>Jumlah Keluar</td>
						<td> : </td>
						<td>".number_format($JumlahOutRp, 2)."</td>
					</tr>
					<tr>
						<td>Jumlah Retur</td>
						<td> : </td>
						<td>".number_format($JumlahReturRp, 2)."</td>
					</tr>
					<tr>
						<td>Jumlah Saldo AKhir</td>
						<td> : </td>
						<td>".number_format($JumlahSaldoAkhirRp, 2)."</td>
					</tr>
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