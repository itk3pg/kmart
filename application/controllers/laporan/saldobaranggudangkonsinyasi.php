<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Saldobaranggudangkonsinyasi extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('laporan_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$this->load->model('toko_model');
		$this->load->model('supplier_model');
		$Data = array();
		$DataToko = $this->toko_model->getDataToko();
		$Data['datatoko'] = $DataToko;

		$DataSupplier = $this->supplier_model->getDataSupplier();
		$Data['datasupplier'] = $DataSupplier;
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('laporan/saldobaranggudangkonsinyasi', $Data);
		$this->load->view('general/footer');
	}
	
	public function getsaldobaranggudang(){
		$DataSaldoBarangGudang = $this->laporan_model->getSaldoBarangGudangKonsinyasi($_POST);
		
		$html = "<table class=\"table table-striped table-bordered table-hover\">
					<thead>
						<tr>
							<th>No</th>
							<th>Kode Barang</th>
							<th>Nama Barang</th>
							<th>Harga Beli</th>
							<th>Saldo Awal KWT</th>
							<th>KWT Masuk</th>
							<th>KWT Laku</th>
							<th>KWT Biaya</th>
							<th>KWT Retur</th>
							<th>Saldo Akhir KWT</th>
						</tr>
					</thead>
					<tbody>";
		$jumlahSaldoAwal = 0;
		$jumlahIn = 0;
		$jumlahOut = 0;
		$jumlahRetur = 0;
		$jumlahBiaya = 0;
		$JumlahSaldoAkhir = 0;

		$jumlahSaldoAwalAll = 0;
		$jumlahInAll = 0;
		$jumlahOutAll = 0;
		$jumlahReturAll = 0;
		$jumlahBiayaAll = 0;
		$JumlahSaldoAkhirAll = 0;

		$jumlahSaldoAwalRp = 0;
		$jumlahInRp = 0;
		$jumlahOutRp = 0;
		$jumlahReturRp = 0;
		$jumlahBiayaRp = 0;
		$JumlahSaldoAkhirRp = 0;

		$nomor = 1;

		$kategori = "";
		foreach ($DataSaldoBarangGudang as $key => $value) {
			$jumlah = $value['saldo_akhir_kwt'] * $value['harga_beli'];
			if($kategori == ""){
				$kategori = $value['kategori'];
				$html .= "<tr>
							<td colspan=\"10\">(".$value['kategori'].") ".$value['nama_kategori']."</td>
						  </tr>";
			}

			if($kategori != $value['kategori']){
				$html .= "<tr>
							<td colspan=\"4\">Total Per Kelompok Barang</td>
							<td align=\"right\">".number_format($jumlahSaldoAwal,2)."</td>
							<td align=\"right\">".number_format($jumlahIn,2)."</td>
							<td align=\"right\">".number_format($jumlahOut,2)."</td>
							<td align=\"right\">".number_format($jumlahBiaya,2)."</td>
							<td align=\"right\">".number_format($jumlahRetur,2)."</td>
							<td align=\"right\">".number_format($JumlahSaldoAkhir,2)."</td>
						  </tr>";
				$html .= "<tr>
							<td colspan=\"4\">Grand Total Per Kelompok Barang</td>
							<td align=\"right\">".number_format($jumlahSaldoAwalRp,2)."</td>
							<td align=\"right\">".number_format($jumlahInRp,2)."</td>
							<td align=\"right\">".number_format($jumlahOutRp,2)."</td>
							<td align=\"right\">".number_format($jumlahBiayaRp,2)."</td>
							<td align=\"right\">".number_format($jumlahReturRp,2)."</td>
							<td align=\"right\">".number_format($JumlahSaldoAkhirRp,2)."</td>
						  </tr>";
				$html .= "<tr>
							<td colspan=\"10\">(".$value['kategori'].") ".$value['nama_kategori']."</td>
						  </tr>";

				$jumlahSaldoAwal = 0;
				$jumlahIn = 0;
				$jumlahOut = 0;
				$jumlahRetur = 0;
				$jumlahBiaya = 0;
				$JumlahSaldoAkhir = 0;

				$jumlahSaldoAwalRp = 0;
				$jumlahInRp = 0;
				$jumlahOutRp = 0;
				$jumlahReturRp = 0;
				$jumlahBiayaRp = 0;
				$JumlahSaldoAkhirRp = 0;

				$nomor = 1;
				$kategori = $value['kategori'];
			}
// - $value['retur'] - $value['biaya']
// $jumlahOut += ($value['kwt_out'] - $value['retur'] - $value['biaya']);
// $jumlahOutAll += ($value['kwt_out'] - $value['retur'] - $value['biaya']);
// $jumlahOutRp += (($value['kwt_out'] - $value['retur'] - $value['biaya']) * $value['harga_beli']);
			
			$html .= "<tr>
						<td align=\"right\">".$nomor."</td>
						<td>".$value['barang_kode']."</td>
						<td>".$value['nama_barang']."</td>
						<td align=\"right\">".number_format($value['harga_beli'],2)."</td>
						<td align=\"right\">".number_format($value['saldo_awal_kwt'],2)."</td>
						<td align=\"right\">".number_format($value['kwt_in'],2)."</td>
						<td align=\"right\">".number_format($value['kwt_out'],2)."</td>
						<td align=\"right\">".number_format($value['biaya'],2)."</td>
						<td align=\"right\">".number_format($value['retur'],2)."</td>
						<td align=\"right\">".number_format($value['saldo_akhir_kwt'],2)."</td>
					</tr>";
			$jumlahSaldoAwal += $value['saldo_awal_kwt'];
			$jumlahIn += $value['kwt_in'];
			$jumlahOut += $value['kwt_out'];
			$jumlahRetur += $value['retur'];
			$jumlahBiaya += $value['biaya'];
			$JumlahSaldoAkhir += $value['saldo_akhir_kwt'];

			$jumlahSaldoAwalAll += $value['saldo_awal_kwt'];
			$jumlahInAll += $value['kwt_in'];
			$jumlahOutAll += $value['kwt_out'];
			$jumlahReturAll += $value['retur'];
			$jumlahBiayaAll += $value['biaya'];
			$JumlahSaldoAkhirAll += $value['saldo_akhir_kwt'];

			$jumlahSaldoAwalRp += ($value['saldo_awal_kwt'] * $value['harga_beli']);
			$jumlahInRp += ($value['kwt_in'] * $value['harga_beli']);
			$jumlahOutRp += ($value['kwt_out']* $value['harga_beli']);
			$jumlahReturRp += ($value['retur'] * $value['harga_beli']);
			$jumlahBiayaRp += ($value['biaya'] * $value['harga_beli']);
			$JumlahSaldoAkhirRp += ($value['saldo_akhir_kwt'] * $value['harga_beli']);

			$nomor++;
		}
		$html .= "<tr>
					<td colspan=\"4\">Total Per Kelompok Barang</td>
					<td align=\"right\">".number_format($jumlahSaldoAwal,2)."</td>
					<td align=\"right\">".number_format($jumlahIn,2)."</td>
					<td align=\"right\">".number_format($jumlahOut,2)."</td>
					<td align=\"right\">".number_format($jumlahBiaya,2)."</td>
					<td align=\"right\">".number_format($jumlahRetur,2)."</td>
					<td align=\"right\">".number_format($JumlahSaldoAkhir,2)."</td>
				  </tr>";
		$html .= "<tr>
					<td colspan=\"4\">Grand Total Per Kelompok Barang</td>
					<td align=\"right\">".number_format($jumlahSaldoAwalRp,2)."</td>
					<td align=\"right\">".number_format($jumlahInRp,2)."</td>
					<td align=\"right\">".number_format($jumlahOutRp,2)."</td>
					<td align=\"right\">".number_format($jumlahBiayaRp,2)."</td>
					<td align=\"right\">".number_format($jumlahReturRp,2)."</td>
					<td align=\"right\">".number_format($JumlahSaldoAkhirRp,2)."</td>
				  </tr>";
		// $html .= "<tr>
		// 			<td colspan=\"4\">Grand Total</td>
		// 			<td align=\"right\">".number_format($jumlahSaldoAwalAll,2)."</td>
		// 			<td align=\"right\">".number_format($jumlahInAll,2)."</td>
		// 			<td align=\"right\">".number_format($jumlahOutAll,2)."</td>
		// 			<td align=\"right\">".number_format($jumlahBiayaAll,2)."</td>
		// 			<td align=\"right\">".number_format($jumlahReturAll,2)."</td>
		// 			<td align=\"right\">".number_format($JumlahSaldoAkhirAll,2)."</td>
		// 		  </tr>";
		$html .=    "
					</tbody>
				 </table>";

		// $html .= "<table class=\"table table-striped table-bordered table-hover\">
		// 			<tr>
		// 				<td>Jumlah Saldo Awal</td>
		// 				<td> : </td>
		// 				<td align=\"right\">".number_format($jumlahSaldoAwalRp,2)."</td>
		// 			</tr>
		// 			<tr>
		// 				<td>Jumlah Masuk</td>
		// 				<td> : </td>
		// 				<td align=\"right\">".number_format($jumlahInRp,2)."</td>
		// 			</tr>
		// 			<tr>
		// 				<td>Jumlah Keluar</td>
		// 				<td> : </td>
		// 				<td align=\"right\">".number_format($jumlahOutRp,2)."</td>
		// 			</tr>
		// 			<tr>
		// 				<td>Jumlah Biaya</td>
		// 				<td> : </td>
		// 				<td align=\"right\">".number_format($jumlahBiayaRp,2)."</td>
		// 			</tr>
		// 			<tr>
		// 				<td>Jumlah Retur</td>
		// 				<td> : </td>
		// 				<td align=\"right\">".number_format($jumlahReturRp,2)."</td>
		// 			</tr>
		// 			<tr>
		// 				<td>Jumlah Saldo Akhir</td>
		// 				<td> : </td>
		// 				<td align=\"right\">".number_format($JumlahSaldoAkhirRp,2)."</td>
		// 			</tr>
		// 		  </table>";
				 
		echo $html;
	}
	
	public function getdetailbarang(){
		$DataSaldo = $this->laporan_model->getDetailSaldoKonsinyasi($_POST);
		
		$html = "<table class=\"table table-striped table-bordered table-hover\">
					<thead>
						<tr>
							<th>Tanggal</th>
							<th>Bukti</th>
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
		foreach ($DataSaldo as $key => $value) {
			$html .= "<tr>
						<td>".$value['tanggal']."</td>
						<td>".$value['bukti']."</td>
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
					<td colspan=\"3\"><strong>Total</strong></td>
					<td align=\"right\"><strong>".$jumlah_in."</strong></td>
					<td align=\"right\"><strong>".$jumlah_out."</strong></td>
				  </tr>";
		$html .=    "
					</tbody>
				 </table>";
				 
		echo $html;
	}
	
	public function cetaksaldobaranggudang(){
		$html = "<style>
				 	table {
				 		font-size: 7px;
				 	}

				 	table.content {
				 		padding: 1px;
				 	}

				 	tr.border_bottom th {
				 		border-bottom:0.5pt dashed black;
				 		border-top:0.5pt dashed black;
				 		border-right:0.5pt dashed black;
					}

					tr.border_top td {
				 		border-top:0.5pt dashed black;
				 		border-bottom:0.5pt dashed black;
				 		border-right:0.5pt dashed black;
					}

					tr.border_content td {
						border-right:0.5pt dashed black;
					}
				 </style>";
		$_GET['cetak'] = "1";
		$DataSaldoBarangGudang = $this->laporan_model->getSaldoBarangGudangKonsinyasi($_GET);
		$html .= "<table>
					<tr>
						<td colspan=\"5\"><strong>KOPERASI KARYAWAN KELUARGA BESAR PETROKIMIA GRESIK</strong></td>
						<td align=\"right\" colspan=\"3\"><strong>TGL. : ".date("d-m-Y H:i:s")."</strong></td>
					</tr>
					<tr>
						<td colspan=\"5\"><strong>K-Mart</strong></td>
						<td colspan=\"3\"></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"8\"><strong>LAPORAN SALDO BARANG GUDANG KONSINYASI</strong></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"8\"><strong>PERIODE : ".$_GET['bulan']." - ".$_GET['tahun']."</strong></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"8\"><strong>TOKO : ".$_GET['nama_toko']."</strong></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"8\"><strong>SUPPLIER : ".base64_decode($_GET['nama_supplier'])."</strong></td>
					</tr>
				 </table><br/><br/>";
		
		$html .= "<table class=\"content\">
					<thead>
						<tr class=\"border_bottom\">
							<th align=\"right\" width=\"15\">No</th>
							<th>Kode Barang</th>
							<th width=\"100\">Nama Barang</th>
							<th align=\"right\">Harga Beli</th>
							<th align=\"right\">Saldo Awal</th>
							<th align=\"right\">Masuk</th>
							<th align=\"right\">Laku</th>
							<th align=\"right\">Biaya</th>
							<th align=\"right\">Retur</th>
							<th align=\"right\">Saldo Akhir</th>
						</tr>
					</thead>
					<tbody>";
		$jumlahSaldoAwal = 0;
		$jumlahIn = 0;
		$jumlahOut = 0;
		$jumlahRetur = 0;
		$jumlahBiaya = 0;
		$JumlahSaldoAkhir = 0;

		$jumlahSaldoAwalAll = 0;
		$jumlahInAll = 0;
		$jumlahOutAll = 0;
		$jumlahReturAll = 0;
		$jumlahBiayaAll = 0;
		$JumlahSaldoAkhirAll = 0;

		$jumlahSaldoAwalRp = 0;
		$jumlahInRp = 0;
		$jumlahOutRp = 0;
		$jumlahReturRp = 0;
		$jumlahBiayaRp = 0;
		$JumlahSaldoAkhirRp = 0;

		$nomor = 1;

		$kategori = "";
		foreach ($DataSaldoBarangGudang as $key => $value) {
			$jumlah = $value['saldo_akhir_kwt'] * $value['harga_beli'];
			if($kategori == ""){
				$kategori = $value['kategori'];
				$html .= "<tr class=\"border_top\">
							<td colspan=\"10\">(".$value['kategori'].") ".$value['nama_kategori']."</td>
						  </tr>";
			}

			if($kategori != $value['kategori']){
				$html .= "<tr class=\"border_top\">
							<td colspan=\"4\">Total Per Kelompok Barang</td>
							<td align=\"right\">".number_format($jumlahSaldoAwal,2)."</td>
							<td align=\"right\">".number_format($jumlahIn,2)."</td>
							<td align=\"right\">".number_format($jumlahOut,2)."</td>
							<td align=\"right\">".number_format($jumlahBiaya,2)."</td>
							<td align=\"right\">".number_format($jumlahRetur,2)."</td>
							<td align=\"right\">".number_format($JumlahSaldoAkhir,2)."</td>
						  </tr>";
				$html .= "<tr class=\"border_top\">
							<td colspan=\"4\">Grand Total Per Kelompok Barang</td>
							<td align=\"right\">".number_format($jumlahSaldoAwalRp,2)."</td>
							<td align=\"right\">".number_format($jumlahInRp,2)."</td>
							<td align=\"right\">".number_format($jumlahOutRp,2)."</td>
							<td align=\"right\">".number_format($jumlahBiayaRp,2)."</td>
							<td align=\"right\">".number_format($jumlahReturRp,2)."</td>
							<td align=\"right\">".number_format($JumlahSaldoAkhirRp,2)."</td>
						  </tr>";
				$html .= "<tr class=\"border_top\">
							<td colspan=\"10\">(".$value['kategori'].") ".$value['nama_kategori']."</td>
						  </tr>";

				$jumlahSaldoAwal = 0;
				$jumlahIn = 0;
				$jumlahOut = 0;
				$jumlahRetur = 0;
				$jumlahBiaya = 0;
				$JumlahSaldoAkhir = 0;

				$jumlahSaldoAwalRp = 0;
				$jumlahInRp = 0;
				$jumlahOutRp = 0;
				$jumlahReturRp = 0;
				$jumlahBiayaRp = 0;
				$JumlahSaldoAkhirRp = 0;

				$nomor = 1;
				$kategori = $value['kategori'];
			}
// <td align=\"right\">".number_format($value['kwt_out'] - $value['retur'] - $value['biaya'],2)."</td>
						
			$html .= "<tr class=\"border_content\">
						<td align=\"right\" width=\"15\">".$nomor."</td>
						<td>".$value['barang_kode']."</td>
						<td width=\"100\">".$value['nama_barang']."</td>
						<td align=\"right\">".number_format($value['harga_beli'],2)."</td>
						<td align=\"right\">".number_format($value['saldo_awal_kwt'],2)."</td>
						<td align=\"right\">".number_format($value['kwt_in'],2)."</td>
						<td align=\"right\">".number_format($value['kwt_out'],2)."</td>
						<td align=\"right\">".number_format($value['biaya'],2)."</td>
						<td align=\"right\">".number_format($value['retur'],2)."</td>
						<td align=\"right\">".number_format($value['saldo_akhir_kwt'],2)."</td>
					</tr>";
			$jumlahSaldoAwal += $value['saldo_awal_kwt'];
			$jumlahIn += $value['kwt_in'];
			$jumlahOut += $value['kwt_out']; 
			//- $value['retur'] - $value['biaya']);
			$jumlahRetur += $value['retur'];
			$jumlahBiaya += $value['biaya'];
			$JumlahSaldoAkhir += $value['saldo_akhir_kwt'];

			$jumlahSaldoAwalAll += $value['saldo_awal_kwt'];
			$jumlahInAll += $value['kwt_in'];
			$jumlahOutAll += $value['kwt_out'];
			//- $value['retur'] - $value['biaya']);
			$jumlahReturAll += $value['retur'];
			$jumlahBiayaAll += $value['biaya'];
			$JumlahSaldoAkhirAll += $value['saldo_akhir_kwt'];
// $jumlahOutRp += (($value['kwt_out'] - $value['retur'] - $value['biaya']) * $value['harga_beli']);
			
			$jumlahSaldoAwalRp += ($value['saldo_awal_kwt'] * $value['harga_beli']);
			$jumlahInRp += ($value['kwt_in'] * $value['harga_beli']);
			$jumlahOutRp += (($value['kwt_out']) * $value['harga_beli']);
			$jumlahReturRp += ($value['retur'] * $value['harga_beli']);
			$jumlahBiayaRp += ($value['biaya'] * $value['harga_beli']);
			$JumlahSaldoAkhirRp += ($value['saldo_akhir_kwt'] * $value['harga_beli']);

			$nomor++;
		}
		$html .= "<tr class=\"border_top\">
					<td colspan=\"4\">Total Per Kelompok Barang</td>
					<td align=\"right\">".number_format($jumlahSaldoAwal,2)."</td>
					<td align=\"right\">".number_format($jumlahIn,2)."</td>
					<td align=\"right\">".number_format($jumlahOut,2)."</td>
					<td align=\"right\">".number_format($jumlahBiaya,2)."</td>
					<td align=\"right\">".number_format($jumlahRetur,2)."</td>
					<td align=\"right\">".number_format($JumlahSaldoAkhir,2)."</td>
				  </tr>";
		$html .= "<tr class=\"border_top\">
					<td colspan=\"4\">Grand Total Per Kelompok Barang</td>
					<td align=\"right\">".number_format($jumlahSaldoAwalRp,2)."</td>
					<td align=\"right\">".number_format($jumlahInRp,2)."</td>
					<td align=\"right\">".number_format($jumlahOutRp,2)."</td>
					<td align=\"right\">".number_format($jumlahBiayaRp,2)."</td>
					<td align=\"right\">".number_format($jumlahReturRp,2)."</td>
					<td align=\"right\">".number_format($JumlahSaldoAkhirRp,2)."</td>
				  </tr>";
		// $html .= "<tr class=\"border_top\">
		// 			<td colspan=\"4\">Grand Total</td>
		// 			<td align=\"right\">".number_format($jumlahSaldoAwalAll,2)."</td>
		// 			<td align=\"right\">".number_format($jumlahInAll,2)."</td>
		// 			<td align=\"right\">".number_format($jumlahOutAll,2)."</td>
		// 			<td align=\"right\">".number_format($jumlahBiayaAll,2)."</td>
		// 			<td align=\"right\">".number_format($jumlahReturAll,2)."</td>
		// 			<td align=\"right\">".number_format($JumlahSaldoAkhirAll,2)."</td>
		// 		  </tr>";
		$html .=    "
					</tbody>
				 </table><br/><br/>";

		// $html .= "<table class=\"content\" style=\"width: 40%\">
		// 			<tr class=\"border_bottom\">
		// 				<td>Jumlah Saldo Awal</td>
		// 				<td> : </td>
		// 				<td align=\"right\">".number_format($jumlahSaldoAwalRp,2)."</td>
		// 			</tr>
		// 			<tr>
		// 				<td>Jumlah Masuk</td>
		// 				<td> : </td>
		// 				<td align=\"right\">".number_format($jumlahInRp,2)."</td>
		// 			</tr>
		// 			<tr>
		// 				<td>Jumlah Keluar</td>
		// 				<td> : </td>
		// 				<td align=\"right\">".number_format($jumlahOutRp,2)."</td>
		// 			</tr>
		// 			<tr>
		// 				<td>Jumlah Biaya</td>
		// 				<td> : </td>
		// 				<td align=\"right\">".number_format($jumlahBiayaRp,2)."</td>
		// 			</tr>
		// 			<tr>
		// 				<td>Jumlah Retur</td>
		// 				<td> : </td>
		// 				<td align=\"right\">".number_format($jumlahReturRp,2)."</td>
		// 			</tr>
		// 			<tr>
		// 				<td>Jumlah Saldo Akhir</td>
		// 				<td> : </td>
		// 				<td align=\"right\">".number_format($JumlahSaldoAkhirRp,2)."</td>
		// 			</tr>
		// 		  </table>";
		$this->load->library('Pdf');
		
		$pdf = new TCPDF("P", PDF_UNIT, 'A4', true, 'UTF-8', false);
		// Add a page
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->AddPage();
		$pdf->writeHTML($html, true, false, true, false, '');
		$pdf->Output('SaldoBarangKonsinyasi.pdf', 'I');
	}

	public function cetaksaldobaranggudang_xls(){
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;Filename=saldobarangkonsinyasi_".$_GET['bulan']."_".$_GET['tahun'].".xls");

		$_GET['cetak'] = "1";
		$DataSaldoBarangGudang = $this->laporan_model->getSaldoBarangGudangKonsinyasi($_GET);
		$html = "<table>
					<tr>
						<td colspan=\"5\"><strong>KOPERASI KARYAWAN KELUARGA BESAR PETROKIMIA GRESIK</strong></td>
						<td align=\"right\" colspan=\"5\"><strong>TGL. : ".date("d-m-Y H:i:s")."</strong></td>
					</tr>
					<tr>
						<td colspan=\"5\"><strong>K-Mart</strong></td>
						<td colspan=\"5\"></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"10\"><strong>LAPORAN SALDO BARANG GUDANG KONSINYASI</strong></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"10\"><strong>PERIODE : ".$_GET['bulan']." - ".$_GET['tahun']."</strong></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"10\"><strong>TOKO : ".$_GET['nama_toko']."</strong></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"8\"><strong>SUPPLIER : ".base64_decode($_GET['nama_supplier'])."</strong></td>
					</tr>
				 </table><br/><br/>";
		
		$html .= "<table border=\"1\">
					<thead>
						<tr class=\"border_bottom\">
							<th align=\"right\" width=\"15\">No</th>
							<th>Kode Barang</th>
							<th width=\"100\">Nama Barang</th>
							<th align=\"right\">Harga Beli</th>
							<th align=\"right\">Saldo Awal</th>
							<th align=\"right\">Masuk</th>
							<th align=\"right\">Laku</th>
							<th align=\"right\">Biaya</th>
							<th align=\"right\">Retur</th>
							<th align=\"right\">Saldo Akhir</th>
						</tr>
					</thead>
					<tbody>";
		$jumlahSaldoAwal = 0;
		$jumlahIn = 0;
		$jumlahOut = 0;
		$jumlahRetur = 0;
		$jumlahBiaya = 0;
		$JumlahSaldoAkhir = 0;

		$jumlahSaldoAwalAll = 0;
		$jumlahInAll = 0;
		$jumlahOutAll = 0;
		$jumlahReturAll = 0;
		$jumlahBiayaAll = 0;
		$JumlahSaldoAkhirAll = 0;

		$jumlahSaldoAwalRp = 0;
		$jumlahInRp = 0;
		$jumlahOutRp = 0;
		$jumlahReturRp = 0;
		$jumlahBiayaRp = 0;
		$JumlahSaldoAkhirRp = 0;

		$nomor = 1;

		$kategori = "";
		foreach ($DataSaldoBarangGudang as $key => $value) {
			$jumlah = $value['saldo_akhir_kwt'] * $value['harga_beli'];
			if($kategori == ""){
				$kategori = $value['kategori'];
				$html .= "<tr class=\"border_top\">
							<td colspan=\"10\">(".$value['kategori'].") ".$value['nama_kategori']."</td>
						  </tr>";
			}

			if($kategori != $value['kategori']){
				$html .= "<tr class=\"border_top\">
							<td colspan=\"4\">Total Per Kelompok Barang</td>
							<td align=\"right\">".number_format($jumlahSaldoAwal,2)."</td>
							<td align=\"right\">".number_format($jumlahIn,2)."</td>
							<td align=\"right\">".number_format($jumlahOut,2)."</td>
							<td align=\"right\">".number_format($jumlahBiaya,2)."</td>
							<td align=\"right\">".number_format($jumlahRetur,2)."</td>
							<td align=\"right\">".number_format($JumlahSaldoAkhir,2)."</td>
						  </tr>";
				$html .= "<tr class=\"border_top\">
							<td colspan=\"4\">Grand Total Per Kelompok Barang</td>
							<td align=\"right\">".number_format($jumlahSaldoAwalRp,2)."</td>
							<td align=\"right\">".number_format($jumlahInRp,2)."</td>
							<td align=\"right\">".number_format($jumlahOutRp,2)."</td>
							<td align=\"right\">".number_format($jumlahBiayaRp,2)."</td>
							<td align=\"right\">".number_format($jumlahReturRp,2)."</td>
							<td align=\"right\">".number_format($JumlahSaldoAkhirRp,2)."</td>
						  </tr>";
				$html .= "<tr class=\"border_top\">
							<td colspan=\"10\">(".$value['kategori'].") ".$value['nama_kategori']."</td>
						  </tr>";

				$jumlahSaldoAwal = 0;
				$jumlahIn = 0;
				$jumlahOut = 0;
				$jumlahRetur = 0;
				$jumlahBiaya = 0;
				$JumlahSaldoAkhir = 0;

				$jumlahSaldoAwalRp = 0;
				$jumlahInRp = 0;
				$jumlahOutRp = 0;
				$jumlahReturRp = 0;
				$jumlahBiayaRp = 0;
				$JumlahSaldoAkhirRp = 0;

				$nomor = 1;
				$kategori = $value['kategori'];
			}
// 	// - $value['retur'] - $value['biaya'],2)."</td>
					
			$html .= "<tr class=\"border_content\">
						<td align=\"right\" width=\"15\">".$nomor."</td>
						<td>".$value['barang_kode']."</td>
						<td width=\"100\">".$value['nama_barang']."</td>
						<td align=\"right\">".number_format($value['harga_beli'],2)."</td>
						<td align=\"right\">".number_format($value['saldo_awal_kwt'],2)."</td>
						<td align=\"right\">".number_format($value['kwt_in'],2)."</td>
						<td align=\"right\">".number_format($value['kwt_out'],2)."</td>
						<td align=\"right\">".number_format($value['biaya'],2)."</td>
						<td align=\"right\">".number_format($value['retur'],2)."</td>
						<td align=\"right\">".number_format($value['saldo_akhir_kwt'],2)."</td>
					</tr>";
// $jumlahOut += ($value['kwt_out'] - $value['retur'] - $value['biaya']);
						
			$jumlahSaldoAwal += $value['saldo_awal_kwt'];
			$jumlahIn += $value['kwt_in'];
			$jumlahOut += $value['kwt_out'];
			$jumlahRetur += $value['retur'];
			$jumlahBiaya += $value['biaya'];
			$JumlahSaldoAkhir += $value['saldo_akhir_kwt'];
// $jumlahOutAll += ($value['kwt_out'] - $value['retur'] - $value['biaya']);
			
			$jumlahSaldoAwalAll += $value['saldo_awal_kwt'];
			$jumlahInAll += $value['kwt_in'];
			$jumlahOutAll += $value['kwt_out'];
			$jumlahReturAll += $value['retur'];
			$jumlahBiayaAll += $value['biaya'];
			$JumlahSaldoAkhirAll += $value['saldo_akhir_kwt'];
// $jumlahOutRp += (($value['kwt_out'] - $value['retur'] - $value['biaya']) * $value['harga_beli']);
			
			$jumlahSaldoAwalRp += ($value['saldo_awal_kwt'] * $value['harga_beli']);
			$jumlahInRp += ($value['kwt_in'] * $value['harga_beli']);
			$jumlahOutRp += ($value['kwt_out'] * $value['harga_beli']);
			$jumlahReturRp += ($value['retur'] * $value['harga_beli']);
			$jumlahBiayaRp += ($value['biaya'] * $value['harga_beli']);
			$JumlahSaldoAkhirRp += ($value['saldo_akhir_kwt'] * $value['harga_beli']);

			$nomor++;
		}
		$html .= "<tr class=\"border_top\">
					<td colspan=\"4\">Total Per Kelompok Barang</td>
					<td align=\"right\">".number_format($jumlahSaldoAwal,2)."</td>
					<td align=\"right\">".number_format($jumlahIn,2)."</td>
					<td align=\"right\">".number_format($jumlahOut,2)."</td>
					<td align=\"right\">".number_format($jumlahBiaya,2)."</td>
					<td align=\"right\">".number_format($jumlahRetur,2)."</td>
					<td align=\"right\">".number_format($JumlahSaldoAkhir,2)."</td>
				  </tr>";
		$html .= "<tr class=\"border_top\">
					<td colspan=\"4\">Grand Total Per Kelompok Barang</td>
					<td align=\"right\">".number_format($jumlahSaldoAwalRp,2)."</td>
					<td align=\"right\">".number_format($jumlahInRp,2)."</td>
					<td align=\"right\">".number_format($jumlahOutRp,2)."</td>
					<td align=\"right\">".number_format($jumlahBiayaRp,2)."</td>
					<td align=\"right\">".number_format($jumlahReturRp,2)."</td>
					<td align=\"right\">".number_format($JumlahSaldoAkhirRp,2)."</td>
				  </tr>";
		
		$html .=    "
					</tbody>
				 </table>";
		echo $html;
	}
}