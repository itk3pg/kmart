<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rekappenjualannonanggota extends CI_Controller {
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
		$this->load->view('laporan/rekappenjualannonanggota', $Param);
		$this->load->view('general/footer');
	}
	
	public function getrekappenjualan(){
		$DataPenjualanPelanggan = $this->laporan_model->getRekapPenjualanNonAnggota($_POST);
		
		$html = "<table class=\"table table-striped table-bordered table-hover\">
					<thead>
						<tr>
							<th class='text-center'>Kode Pelanggan</th>
							<th class='text-center'>Nama Pelanggan</th>
							<th class='text-center'>Kode Kelompok</th>
							<th class='text-center'>Kelompok Barang</th>
							<th class='text-center'>Jumlah Harga Beli</th>
							<th class='text-center'>Jumlah Harga Jual</th>
						</tr>
					</thead>
					<tbody>";
		
		$TotalHargaBeliPel = 0;
		$TotalHargaJualPel = 0;
		$TotalHargaBeli = 0;
		$TotalHargaJual = 0;
		
		$KodePelanggan = "";
		foreach ($DataPenjualanPelanggan as $key => $value) {
			if($KodePelanggan == ""){
				$KodePelanggan = $value['fcustkey'];		
			}

			if($KodePelanggan != $value['fcustkey']){
				$html .= "<tr>
							<td colspan=\"4\">Total Per Pelanggan</td>
							<td align=\"right\">".number_format($TotalHargaBeliPel,2)."</td>
							<td align=\"right\">".number_format($TotalHargaJualPel,2)."</td>
						  </tr>";

				$KodePelanggan = $value['fcustkey'];
				$TotalHargaBeliPel = 0;
				$TotalHargaJualPel = 0;
			}

			$html .= "<tr>
						<td>".$value['fcustkey']."</td>
						<td>".$value['fcustname']."</td>
						<td>".$value['kategori']."</td>
						<td>".$value['nama_kategori']."</td>
						<td align=\"right\">".number_format($value['hpp'],2)."</td>
						<td align=\"right\">".number_format($value['total'],2)."</td>
					</tr>";
			
			$TotalHargaBeliPel += $value['hpp'];
			$TotalHargaJualPel += $value['total'];
			$TotalHargaBeli += $value['hpp'];
			$TotalHargaJual += $value['total'];
		}
		$html .= "<tr>
					<td colspan=\"4\"><strong>GRAND TOTAL</strong></td>
					<td align=\"right\"><strong>".number_format($TotalHargaBeli,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalHargaJual,2)."</strong></td>
				  </tr>";
		$html .= "</tbody></table><br/>";

		$DataPenjualanKel = $this->laporan_model->getKelPenjualanNonAnggota($_POST);
		$html .= "<table class=\"table table-striped table-bordered table-hover\">
					<thead>
						<tr>
							<th class='text-center'>Kode Kelompok</th>
							<th class='text-center'>Kelompok Barang</th>
							<th class='text-center'>Jumlah Harga Beli</th>
							<th class='text-center'>Jumlah Harga Jual</th>
						</tr>
					</thead>
					<tbody>";
		
		$TotalHargaBeli = 0;
		$TotalHargaJual = 0;
		foreach ($DataPenjualanKel as $key => $value) {
			$html .= "<tr>
						<td>".$value['kategori']."</td>
						<td>".$value['nama_kategori']."</td>
						<td align=\"right\">".number_format($value['hpp'],2)."</td>
						<td align=\"right\">".number_format($value['total'],2)."</td>
					</tr>";
			$TotalHargaBeli += $value['hpp'];
			$TotalHargaJual += $value['total'];
		}
		$html .= "<tr>
					<td colspan=\"2\"><strong>GRAND TOTAL</strong></td>
					<td align=\"right\"><strong>".number_format($TotalHargaBeli,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalHargaJual,2)."</strong></td>
				  </tr>";
		$html .= "</tbody></table>";
		
		echo $html;
	}
	
	public function cetakrekappenjualan(){
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
						<td colspan=\"4\"><strong>KOPERASI KARYAWAN KELUARGA BESAR PETROKIMIA GRESIK</strong></td>
						<td align=\"right\" colspan=\"4\"><strong>TGL. : ".date("d-m-Y H:i:s")."</strong></td>
					</tr>
					<tr>
						<td colspan=\"4\"><strong>K-Mart</strong></td>
						<td colspan=\"4\"></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"8\"><strong>REKAP PENJUALAN NON ANGGOTA</strong></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"8\"><strong>PERIODE : ".$_GET['bulan']." - ".$_GET['tahun']."</strong></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"8\"><strong>Toko : ".$_GET['nama_toko']."</strong></td>
					</tr>
				 </table>";
		$DataPenjualanPelanggan = $this->laporan_model->getRekapPenjualanNonAnggota($_GET);
		
		$html .= "<table class=\"content\">
					<thead>
						<tr class=\"border_bottom\">
							<th class='text-center'>Kode Pelanggan</th>
							<th class='text-center'>Nama Pelanggan</th>
							<th class='text-center'>Kode Kelompok</th>
							<th class='text-center'>Kelompok Barang</th>
							<th align=\"right\">Jumlah Harga Beli</th>
							<th align=\"right\">Jumlah Harga Jual</th>
						</tr>
					</thead>
					<tbody>";
		
		$TotalHargaBeliPel = 0;
		$TotalHargaJualPel = 0;
		$TotalHargaBeli = 0;
		$TotalHargaJual = 0;
		
		$KodePelanggan = "";
		foreach ($DataPenjualanPelanggan as $key => $value) {
			if($KodePelanggan == ""){
				$KodePelanggan = $value['fcustkey'];		
			}

			if($KodePelanggan != $value['fcustkey']){
				$html .= "<tr class=\"border_top\">
							<td colspan=\"4\">Total Per Pelanggan</td>
							<td align=\"right\">".number_format($TotalHargaBeliPel,2)."</td>
							<td align=\"right\">".number_format($TotalHargaJualPel,2)."</td>
						  </tr>";

				$KodePelanggan = $value['fcustkey'];
				$TotalHargaBeliPel = 0;
				$TotalHargaJualPel = 0;
			}

			$html .= "<tr class=\"border_content\">
						<td>".$value['fcustkey']."</td>
						<td>".$value['fcustname']."</td>
						<td>".$value['kategori']."</td>
						<td>".$value['nama_kategori']."</td>
						<td align=\"right\">".number_format($value['hpp'],2)."</td>
						<td align=\"right\">".number_format($value['total'],2)."</td>
					</tr>";
			
			$TotalHargaBeliPel += $value['hpp'];
			$TotalHargaJualPel += $value['total'];
			$TotalHargaBeli += $value['hpp'];
			$TotalHargaJual += $value['total'];
		}
		$html .= "<tr class=\"border_top\">
					<td colspan=\"4\"><strong>GRAND TOTAL</strong></td>
					<td align=\"right\"><strong>".number_format($TotalHargaBeli,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalHargaJual,2)."</strong></td>
				  </tr>";
		$html .= "</tbody></table><br/><br/>";

		$DataPenjualanKel = $this->laporan_model->getKelPenjualanNonAnggota($_GET);
		$html .= "<table class=\"content\">
					<thead>
						<tr class=\"border_bottom\">
							<th class='text-center'>Kode Kelompok</th>
							<th class='text-center'>Kelompok Barang</th>
							<th align=\"right\">Jumlah Harga Beli</th>
							<th align=\"right\">Jumlah Harga Jual</th>
						</tr>
					</thead>
					<tbody>";
		
		$TotalHargaBeli = 0;
		$TotalHargaJual = 0;
		foreach ($DataPenjualanKel as $key => $value) {
			$html .= "<tr class=\"border_content\">
						<td>".$value['kategori']."</td>
						<td>".$value['nama_kategori']."</td>
						<td align=\"right\">".number_format($value['hpp'],2)."</td>
						<td align=\"right\">".number_format($value['total'],2)."</td>
					</tr>";
			$TotalHargaBeli += $value['hpp'];
			$TotalHargaJual += $value['total'];
		}
		$html .= "<tr class=\"border_top\">
					<td colspan=\"2\"><strong>GRAND TOTAL</strong></td>
					<td align=\"right\"><strong>".number_format($TotalHargaBeli,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalHargaJual,2)."</strong></td>
				  </tr>";
		$html .= "</tbody></table>";

		$this->load->library('Pdf');
		
		$pdf = new TCPDF("P", PDF_UNIT, 'A4', true, 'UTF-8', false);
		// Add a page
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->AddPage();
		$pdf->writeHTML($html, true, false, true, false, '');
		$pdf->Output('PenjualanNonAnggota.pdf', 'I');
	}
}
?>