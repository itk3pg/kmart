<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Baranglakukonsinyasi extends CI_Controller {
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
		$this->load->view('laporan/baranglakukonsinyasi', $Data);
		$this->load->view('general/footer');
	}
	
	public function getbaranglakukonsinyasi(){
		$DataBarangLaku = $this->laporan_model->getBarangLakuKonsinyasi($_POST);
		
		$html = "<table class=\"table table-striped table-bordered table-hover\">
					<thead>
						<tr>
							<th rowspan=\"2\">No</th>
							<th rowspan=\"2\">Kel.</th>
							<th rowspan=\"2\">Kode</th>
							<th rowspan=\"2\">Nama Barang</th>
							<th rowspan=\"2\">Qty</th>
							<th colspan=\"2\">Harga</th>
							<th colspan=\"2\">Jumlah</th>
						</tr>
						<tr>
							<th>Nota</th>
							<th>Beli</th>
							<th>Nota</th>
							<th>Beli</th>
						</tr>
					</thead>
					<tbody>";
		$jumlahQtyKategori = 0;
		$jumlahHargaNotaKategori = 0;
		$jumlahHargaBeliKategori = 0;
		$jumlahJumlahNotaKategori = 0;
		$jumlahJumlahBeliKategori = 0;

		$jumlahQty = 0;
		$jumlahHargaNota = 0;
		$jumlahHargaBeli = 0;
		$jumlahJumlahNota = 0;
		$jumlahJumlahBeli = 0;
		$nomor = 1;
		$kategori = "";
		foreach ($DataBarangLaku as $key => $value) {
			if($kategori == ""){
				$kategori = $value['kategori'];
			}
			if($kategori != $value['kategori']){
				$html .= "<tr>
							<td colspan=\"4\">Total Per Kelompok Barang</td>
							<td align=\"right\">".number_format($jumlahQtyKategori,2)."</td>
							<td align=\"right\">".number_format($jumlahHargaNotaKategori,2)."</td>
							<td align=\"right\">".number_format($jumlahHargaBeliKategori,2)."</td>
							<td align=\"right\">".number_format($jumlahJumlahNotaKategori,2)."</td>
							<td align=\"right\">".number_format($jumlahJumlahBeliKategori,2)."</td>
						  </tr>";

				$jumlahQtyKategori = 0;
				$jumlahHargaNotaKategori = 0;
				$jumlahHargaBeliKategori = 0;
				$jumlahJumlahNotaKategori = 0;
				$jumlahJumlahBeliKategori = 0;
				$nomor = 1;
				$kategori = $value['kategori'];
			}
			$HargaNota = ($value['total'] / $value['qty']);
			$HargaBeli = $HargaNota - ($HargaNota * ($value['fee_konsinyasi']/100));
			$JumlahNota = $value['total'];
			$JumlahBeli = $JumlahNota - ($JumlahNota * ($value['fee_konsinyasi']/100));
			$html .= "<tr>
						<td align=\"right\">".$nomor."</td>
						<td>".$value['kategori']."</td>
						<td>".$value['barang_kode']."</td>
						<td>".$value['nama_barang']."</td>
						<td align=\"right\">".number_format($value['qty'],2)."</td>
						<td align=\"right\">".number_format($HargaNota,2)."</td>
						<td align=\"right\">".number_format($HargaBeli,2)."</td>
						<td align=\"right\">".number_format($JumlahNota,2)."</td>
						<td align=\"right\">".number_format($JumlahBeli,2)."</td>
					</tr>";
			$jumlahQty += $value['qty'];
			$jumlahHargaNota += $HargaNota;
			$jumlahHargaBeli += $HargaBeli;
			$jumlahJumlahNota += $JumlahNota;
			$jumlahJumlahBeli += $JumlahBeli;

			$jumlahQtyKategori += $value['qty'];
			$jumlahHargaNotaKategori += $HargaNota;
			$jumlahHargaBeliKategori += $HargaBeli;
			$jumlahJumlahNotaKategori += $JumlahNota;
			$jumlahJumlahBeliKategori += $JumlahBeli;
			$nomor++;
		}
		$html .= "<tr>
					<td colspan=\"4\">Total Per Kelompok Barang</td>
					<td align=\"right\">".number_format($jumlahQtyKategori,2)."</td>
					<td align=\"right\">".number_format($jumlahHargaNotaKategori,2)."</td>
					<td align=\"right\">".number_format($jumlahHargaBeliKategori,2)."</td>
					<td align=\"right\">".number_format($jumlahJumlahNotaKategori,2)."</td>
					<td align=\"right\">".number_format($jumlahJumlahBeliKategori,2)."</td>
				  </tr>";
		$html .= "<tr>
					<td colspan=\"4\">Grand Total</td>
					<td align=\"right\">".number_format($jumlahQty,2)."</td>
					<td align=\"right\">".number_format($jumlahHargaNota,2)."</td>
					<td align=\"right\">".number_format($jumlahHargaBeli,2)."</td>
					<td align=\"right\">".number_format($jumlahJumlahNota,2)."</td>
					<td align=\"right\">".number_format($jumlahJumlahBeli,2)."</td>
				  </tr>";
		$html .=    "
					</tbody>
				 </table>";
				 
		echo $html;
	}
	
	public function cetakbaranglakukonsinyasi(){
		$html = "<style>
				 	table {
				 		font-size: 8px;
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
						<td align=\"center\" colspan=\"8\"><strong>LAPORAN BARANG LAKU SUPPLIER</strong></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"8\"><strong>PERIODE : ".$_GET['tanggal_awal']." / ".$_GET['tanggal_akhir']."</strong></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"8\"><strong>TOKO : ".$_GET['nama_toko']."</strong></td>
					</tr>
				 </table><br/><br/>";
		
		$DataBarangLaku = $this->laporan_model->getBarangLakuKonsinyasi($_GET);
		
		$html .= "<table class=\"content\">
					<thead>
						<tr class=\"border_bottom\">
							<th width=\"15\" rowspan=\"2\">No</th>
							<th width=\"15\" rowspan=\"2\">Kel.</th>
							<th rowspan=\"2\">Kode</th>
							<th width=\"170\" rowspan=\"2\">Nama Barang</th>
							<th width=\"40\" align=\"right\" rowspan=\"2\">Qty</th>
							<th align=\"center\" colspan=\"2\">Harga</th>
							<th align=\"center\" colspan=\"2\">Jumlah</th>
						</tr>
						<tr class=\"border_bottom\">
							<th align=\"right\">Nota</th>
							<th align=\"right\">Beli</th>
							<th align=\"right\">Nota</th>
							<th align=\"right\">Beli</th>
						</tr>
					</thead>
					<tbody>";
		$jumlahQtyKategori = 0;
		$jumlahHargaNotaKategori = 0;
		$jumlahHargaBeliKategori = 0;
		$jumlahJumlahNotaKategori = 0;
		$jumlahJumlahBeliKategori = 0;

		$jumlahQty = 0;
		$jumlahHargaNota = 0;
		$jumlahHargaBeli = 0;
		$jumlahJumlahNota = 0;
		$jumlahJumlahBeli = 0;
		$nomor = 1;
		$kategori = "";
		foreach ($DataBarangLaku as $key => $value) {
			if($kategori == ""){
				$kategori = $value['kategori'];
			}
			if($kategori != $value['kategori']){
				$html .= "<tr class=\"border_top\">
							<td colspan=\"4\">Total Per Kelompok Barang</td>
							<td align=\"right\">".number_format($jumlahQtyKategori,2)."</td>
							<td align=\"right\">".number_format($jumlahHargaNotaKategori,2)."</td>
							<td align=\"right\">".number_format($jumlahHargaBeliKategori,2)."</td>
							<td align=\"right\">".number_format($jumlahJumlahNotaKategori,2)."</td>
							<td align=\"right\">".number_format($jumlahJumlahBeliKategori,2)."</td>
						  </tr>";

				$jumlahQtyKategori = 0;
				$jumlahHargaNotaKategori = 0;
				$jumlahHargaBeliKategori = 0;
				$jumlahJumlahNotaKategori = 0;
				$jumlahJumlahBeliKategori = 0;
				$nomor = 1;
				$kategori = $value['kategori'];
			}
			$HargaNota = 0;
			if($value['qty'] > 0){
				$HargaNota = ($value['total'] / $value['qty']);
			}
			$HargaBeli = $HargaNota - ($HargaNota * ($value['fee_konsinyasi']/100));
			$JumlahNota = $value['total'];
			$JumlahBeli = $JumlahNota - ($JumlahNota * ($value['fee_konsinyasi']/100));
			$html .= "<tr class=\"border_content\">
						<td width=\"15\" align=\"right\">".$nomor."</td>
						<td width=\"15\">".$value['kategori']."</td>
						<td>".$value['barang_kode']."</td>
						<td width=\"170\">".$value['nama_barang']."</td>
						<td width=\"40\" align=\"right\">".number_format($value['qty'],2)."</td>
						<td align=\"right\">".number_format($HargaNota,2)."</td>
						<td align=\"right\">".number_format($HargaBeli,2)."</td>
						<td align=\"right\">".number_format($JumlahNota,2)."</td>
						<td align=\"right\">".number_format($JumlahBeli,2)."</td>
					</tr>";
			$jumlahQty += $value['qty'];
			$jumlahHargaNota += $HargaNota;
			$jumlahHargaBeli += $HargaBeli;
			$jumlahJumlahNota += $JumlahNota;
			$jumlahJumlahBeli += $JumlahBeli;

			$jumlahQtyKategori += $value['qty'];
			$jumlahHargaNotaKategori += $HargaNota;
			$jumlahHargaBeliKategori += $HargaBeli;
			$jumlahJumlahNotaKategori += $JumlahNota;
			$jumlahJumlahBeliKategori += $JumlahBeli;
			$nomor++;
		}
		$html .= "<tr class=\"border_top\">
					<td colspan=\"4\">Total Per Kelompok Barang</td>
					<td align=\"right\">".number_format($jumlahQtyKategori,2)."</td>
					<td align=\"right\">".number_format($jumlahHargaNotaKategori,2)."</td>
					<td align=\"right\">".number_format($jumlahHargaBeliKategori,2)."</td>
					<td align=\"right\">".number_format($jumlahJumlahNotaKategori,2)."</td>
					<td align=\"right\">".number_format($jumlahJumlahBeliKategori,2)."</td>
				  </tr>";
		$html .= "<tr class=\"border_top\">
					<td colspan=\"4\">Grand Total</td>
					<td align=\"right\">".number_format($jumlahQty,2)."</td>
					<td align=\"right\">".number_format($jumlahHargaNota,2)."</td>
					<td align=\"right\">".number_format($jumlahHargaBeli,2)."</td>
					<td align=\"right\">".number_format($jumlahJumlahNota,2)."</td>
					<td align=\"right\">".number_format($jumlahJumlahBeli,2)."</td>
				  </tr>";
		$html .=    "
					</tbody>
				 </table><br/><br/>";
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
		$this->load->library('Pdf');
		
		$pdf = new TCPDF("P", PDF_UNIT, 'A4', true, 'UTF-8', false);
		// Add a page
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->AddPage();
		$pdf->writeHTML($html, true, false, true, false, '');
		$pdf->Output('BarangLakuKonsinyasi.pdf', 'I');
	}
}