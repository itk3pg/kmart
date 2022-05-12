<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rekapitulasibarangkonsinyasi extends CI_Controller {
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
		$this->load->view('laporan/rekapitulasibarangkonsinyasi', $Data);
		$this->load->view('general/footer');
	}
	
	public function getrekapitulasikonsinyasi(){
		$DataSaldoBarangGudang = $this->laporan_model->getRekapitulasiBarangKonsinyasi($_POST);
		
		$html = "<table class=\"table table-striped table-bordered table-hover\">
					<thead>
						<tr>
							<th>No</th>
							<th>Kode</th>
							<th>Nama Supplier</th>
							<th>Saldo Awal</th>
							<th>Masuk</th>
							<th>Laku</th>
							<th>Biaya</th>
							<th>Retur</th>
							<th>Saldo Akhir</th>
							<th>% 1</th>
							<th>Discount</th>
							<th>Jml Tagihan</th>
						</tr>
					</thead>
					<tbody>";
		$jumlahSaldoAwal = 0;
		$jumlahIn = 0;
		$jumlahOut = 0;
		$jumlahBiaya = 0;
		$jumlahRetur = 0;
		$JumlahSaldoAkhir = 0;
		$JumlahDiskon = 0;
		$JumlahTagihan = 0;

		$jumlahSaldoAwalKategori = 0;
		$jumlahInKategori = 0;
		$jumlahOutKategori = 0;
		$jumlahBiayaKategori = 0;
		$jumlahReturKategori = 0;
		$JumlahSaldoAkhirKategori = 0;
		$JumlahDiskonKategori = 0;
		$JumlahTagihanKategori = 0;
		$nomor = 1;

		$kategori = "";
		foreach ($DataSaldoBarangGudang as $key => $value) {
			$value['saldo_awal_kwt_lap'] = $value['saldo_awal_kwt'];
			$value['saldo_awal_kwt_hit'] = $value['saldo_awal_kwt'] + $value['kwt_in_awal'] - $value['kwt_out_awal'] - $value['kwt_retur_awal'] - $value['kwt_biaya_awal'];
			$value['saldo_akhir_kwt'] = $value['saldo_awal_kwt_hit'] + $value['kwt_in'] - $value['kwt_out'] - $value['retur'] - $value['biaya'];
			if($kategori == ""){
				$kategori = $value['kategori'];
				$html .= "<tr>
							<td colspan=\"12\">(".$value['kategori'].") ".$value['nama_kategori']."</td>
						  </tr>";
			}
			if($kategori != $value['kategori']){
				$html .= "<tr>
							<td colspan=\"3\">Total</td>
							<td align=\"right\">".number_format($jumlahSaldoAwalKategori,2)."</td>
							<td align=\"right\">".number_format($jumlahInKategori,2)."</td>
							<td align=\"right\">".number_format($jumlahOutKategori,2)."</td>
							<td align=\"right\">".number_format($jumlahBiayaKategori,2)."</td>
							<td align=\"right\">".number_format($jumlahReturKategori,2)."</td>
							<td align=\"right\">".number_format($JumlahSaldoAkhirKategori,2)."</td>
							<td align=\"right\">&nbsp;</td>
							<td align=\"right\">".number_format($JumlahDiskonKategori,2)."</td>
							<td align=\"right\">".number_format($JumlahTagihanKategori,2)."</td>
						  </tr>";
				$html .= "<tr>
							<td colspan=\"12\">(".$value['kategori'].") ".$value['nama_kategori']."</td>
						  </tr>";
				$jumlahSaldoAwalKategori = 0;
				$jumlahInKategori = 0;
				$jumlahOutKategori = 0;
				$jumlahBiayaKategori = 0;
				$jumlahReturKategori = 0;
				$JumlahSaldoAkhirKategori = 0;
				$JumlahDiskonKategori = 0;
				$JumlahTagihanKategori = 0;
				$nomor = 1;
				$kategori = $value['kategori'];
			}
			$Diskon = round((($value['kwt_out'] + $value['biaya']) * ($value['fee_konsinyasi']/100)), 2);
			$JmlTagihan = ($value['kwt_out'] + $value['biaya']) - $Diskon;
			$html .= "<tr>
						<td align=\"right\">".$nomor."</td>
						<td>".$value['supplier_kode']."</td>
						<td>".$value['nama_supplier']."</td>
						<td align=\"right\">".number_format($value['saldo_awal_kwt_lap'],2)."</td>
						<td align=\"right\">".number_format($value['kwt_in'],2)."</td>
						<td align=\"right\">".number_format($value['kwt_out'],2)."</td>
						<td align=\"right\">".number_format($value['biaya'],2)."</td>
						<td align=\"right\">".number_format($value['retur'],2)."</td>
						<td align=\"right\">".number_format($value['saldo_akhir_kwt'],2)."</td>
						<td align=\"right\">".number_format($value['fee_konsinyasi'],2)."</td>
						<td align=\"right\">".number_format($Diskon,2)."</td>
						<td align=\"right\">".number_format($JmlTagihan,2)."</td>
					</tr>";
			$jumlahSaldoAwalKategori += $value['saldo_awal_kwt_lap'];
			$jumlahInKategori += $value['kwt_in'];
			$jumlahOutKategori += ($value['kwt_out']);
			$jumlahBiayaKategori += ($value['biaya']);
			$jumlahReturKategori += $value['retur'];
			$JumlahSaldoAkhirKategori += $value['saldo_akhir_kwt'];
			$JumlahDiskonKategori += $Diskon;
			$JumlahTagihanKategori += $JmlTagihan;

			$jumlahSaldoAwal += $value['saldo_awal_kwt_lap'];
			$jumlahIn += $value['kwt_in'];
			$jumlahOut += ($value['kwt_out']);
			$jumlahBiaya += ($value['biaya']);
			$jumlahRetur += $value['retur'];
			$JumlahSaldoAkhir += $value['saldo_akhir_kwt'];
			$JumlahDiskon += $Diskon;
			$JumlahTagihan += $JmlTagihan;
			$nomor++;
		}
		$html .= "<tr>
					<td colspan=\"3\">Total</td>
					<td align=\"right\">".number_format($jumlahSaldoAwalKategori,2)."</td>
					<td align=\"right\">".number_format($jumlahInKategori,2)."</td>
					<td align=\"right\">".number_format($jumlahOutKategori,2)."</td>
					<td align=\"right\">".number_format($jumlahBiayaKategori,2)."</td>
					<td align=\"right\">".number_format($jumlahReturKategori,2)."</td>
					<td align=\"right\">".number_format($JumlahSaldoAkhirKategori,2)."</td>
					<td align=\"right\">&nbsp;</td>
					<td align=\"right\">".number_format($JumlahDiskonKategori,2)."</td>
					<td align=\"right\">".number_format($JumlahTagihanKategori,2)."</td>
				  </tr>";
		$html .= "<tr>
					<td colspan=\"3\">Grand Total</td>
					<td align=\"right\">".number_format($jumlahSaldoAwal,2)."</td>
					<td align=\"right\">".number_format($jumlahIn,2)."</td>
					<td align=\"right\">".number_format($jumlahOut,2)."</td>
					<td align=\"right\">".number_format($jumlahBiaya,2)."</td>
					<td align=\"right\">".number_format($jumlahRetur,2)."</td>
					<td align=\"right\">".number_format($JumlahSaldoAkhir,2)."</td>
					<td align=\"right\">&nbsp;</td>
					<td align=\"right\">".number_format($JumlahDiskon,2)."</td>
					<td align=\"right\">".number_format($JumlahTagihan,2)."</td>
				  </tr>";
		$html .=    "
					</tbody>
				 </table>";
				 
		echo $html;
	}
	
	public function cetakrekapitulasikonsinyasi(){
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
						<td align=\"center\" colspan=\"8\"><strong>REKAPITULASI BARANG KONSINYASI</strong></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"8\"><strong>PERIODE : ".$_GET['tanggal_awal']." / ".$_GET['tanggal_akhir']."</strong></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"8\"><strong>TOKO : ".$_GET['nama_toko']."</strong></td>
					</tr>
				 </table><br/><br/>";
		
		$DataSaldoBarangGudang = $this->laporan_model->getRekapitulasiBarangKonsinyasi($_GET);
		
		$html .= "<table class=\"content\">
					<thead>
						<tr class=\"border_bottom\">
							<th width=\"15\" align=\"right\">No</th>
							<th width=\"30\">Kode</th>
							<th width=\"60\">Nama Supplier</th>
							<th width=\"50\" align=\"right\">Saldo Awal</th>
							<th width=\"60\" align=\"right\">Masuk</th>
							<th width=\"60\" align=\"right\">Laku</th>
							<th width=\"60\" align=\"right\">Biaya</th>
							<th width=\"40\" align=\"right\">Retur</th>
							<th width=\"60\" align=\"right\">Saldo Akhir</th>
							<th width=\"30\" align=\"right\">% 1</th>
							<th width=\"50\" align=\"right\">Discount</th>
							<th width=\"50\" align=\"right\">Jml Tagihan</th>
						</tr>
					</thead>
					<tbody>";
		$jumlahSaldoAwal = 0;
		$jumlahIn = 0;
		$jumlahOut = 0;
		$jumlahBiaya = 0;
		$jumlahRetur = 0;
		$JumlahSaldoAkhir = 0;
		$JumlahDiskon = 0;
		$JumlahTagihan = 0;

		$jumlahSaldoAwalKategori = 0;
		$jumlahInKategori = 0;
		$jumlahOutKategori = 0;
		$jumlahBiayaKategori = 0;
		$jumlahReturKategori = 0;
		$JumlahSaldoAkhirKategori = 0;
		$JumlahDiskonKategori = 0;
		$JumlahTagihanKategori = 0;
		$nomor = 1;

		$kategori = "";
		foreach ($DataSaldoBarangGudang as $key => $value) {
			$value['saldo_awal_kwt'] = $value['saldo_awal_kwt'] + $value['kwt_in_awal'] - $value['kwt_out_awal'] - $value['kwt_retur_awal'] - $value['kwt_biaya_awal'];
			$value['saldo_akhir_kwt'] = $value['saldo_awal_kwt'] + $value['kwt_in'] - $value['kwt_out'] - $value['retur'] - $value['biaya'];
			if($kategori == ""){
				$kategori = $value['kategori'];
				$html .= "<tr class=\"border_top\">
							<td colspan=\"12\">(".$value['kategori'].") ".$value['nama_kategori']."</td>
						  </tr>";
			}
			if($kategori != $value['kategori']){
				$html .= "<tr class=\"border_top\">
							<td colspan=\"3\">Total</td>
							<td align=\"right\">".number_format($jumlahSaldoAwalKategori,2)."</td>
							<td align=\"right\">".number_format($jumlahInKategori,2)."</td>
							<td align=\"right\">".number_format($jumlahOutKategori,2)."</td>
							<td align=\"right\">".number_format($jumlahBiayaKategori,2)."</td>
							<td align=\"right\">".number_format($jumlahReturKategori,2)."</td>
							<td align=\"right\">".number_format($JumlahSaldoAkhirKategori,2)."</td>
							<td align=\"right\">&nbsp;</td>
							<td align=\"right\">".number_format($JumlahDiskonKategori,2)."</td>
							<td align=\"right\">".number_format($JumlahTagihanKategori,2)."</td>
						  </tr>";
				$html .= "<tr class=\"border_top\">
							<td colspan=\"12\">(".$value['kategori'].") ".$value['nama_kategori']."</td>
						  </tr>";
				$jumlahSaldoAwalKategori = 0;
				$jumlahInKategori = 0;
				$jumlahOutKategori = 0;
				$jumlahBiayaKategori = 0;
				$jumlahReturKategori = 0;
				$JumlahSaldoAkhirKategori = 0;
				$JumlahDiskonKategori = 0;
				$JumlahTagihanKategori = 0;
				$nomor = 1;
				$kategori = $value['kategori'];
			}
			$Diskon = round((($value['kwt_out'] + $value['biaya']) * ($value['fee_konsinyasi']/100)), 2);
			$JmlTagihan = ($value['kwt_out'] + $value['biaya']) - $Diskon;
			$html .= "<tr class=\"border_content\">
						<td width=\"15\" align=\"right\">".$nomor."</td>
						<td width=\"30\">".$value['supplier_kode']."</td>
						<td width=\"60\">".$value['nama_supplier']."</td>
						<td width=\"50\" align=\"right\">".number_format($value['saldo_awal_kwt'],2)."</td>
						<td width=\"60\" align=\"right\">".number_format($value['kwt_in'],2)."</td>
						<td width=\"60\" align=\"right\">".number_format($value['kwt_out'],2)."</td>
						<td width=\"60\" align=\"right\">".number_format($value['biaya'],2)."</td>
						<td width=\"40\" align=\"right\">".number_format($value['retur'],2)."</td>
						<td width=\"60\" align=\"right\">".number_format($value['saldo_akhir_kwt'],2)."</td>
						<td width=\"30\" align=\"right\">".number_format($value['fee_konsinyasi'],2)."</td>
						<td width=\"50\" align=\"right\">".number_format($Diskon,2)."</td>
						<td width=\"50\" align=\"right\">".number_format($JmlTagihan,2)."</td>
					</tr>";
			$jumlahSaldoAwalKategori += $value['saldo_awal_kwt'];
			$jumlahInKategori += $value['kwt_in'];
			$jumlahOutKategori += ($value['kwt_out']);
			$jumlahBiayaKategori += ($value['biaya']);
			$jumlahReturKategori += $value['retur'];
			$JumlahSaldoAkhirKategori += $value['saldo_akhir_kwt'];
			$JumlahDiskonKategori += $Diskon;
			$JumlahTagihanKategori += $JmlTagihan;

			$jumlahSaldoAwal += $value['saldo_awal_kwt'];
			$jumlahIn += $value['kwt_in'];
			$jumlahOut += ($value['kwt_out']);
			$jumlahBiaya += ($value['biaya']);
			$jumlahRetur += $value['retur'];
			$JumlahSaldoAkhir += $value['saldo_akhir_kwt'];
			$JumlahDiskon += $Diskon;
			$JumlahTagihan += $JmlTagihan;
			$nomor++;
		}
		$html .= "<tr class=\"border_top\">
					<td colspan=\"3\">Total</td>
					<td align=\"right\">".number_format($jumlahSaldoAwalKategori,2)."</td>
					<td align=\"right\">".number_format($jumlahInKategori,2)."</td>
					<td align=\"right\">".number_format($jumlahOutKategori,2)."</td>
					<td align=\"right\">".number_format($jumlahBiayaKategori,2)."</td>
					<td align=\"right\">".number_format($jumlahReturKategori,2)."</td>
					<td align=\"right\">".number_format($JumlahSaldoAkhirKategori,2)."</td>
					<td align=\"right\">&nbsp;</td>
					<td align=\"right\">".number_format($JumlahDiskonKategori,2)."</td>
					<td align=\"right\">".number_format($JumlahTagihanKategori,2)."</td>
				  </tr>";
		$html .= "<tr class=\"border_bottom\">
					<td colspan=\"3\">Grand Total</td>
					<td align=\"right\">".number_format($jumlahSaldoAwal,2)."</td>
					<td align=\"right\">".number_format($jumlahIn,2)."</td>
					<td align=\"right\">".number_format($jumlahOut,2)."</td>
					<td align=\"right\">".number_format($jumlahBiaya,2)."</td>
					<td align=\"right\">".number_format($jumlahRetur,2)."</td>
					<td align=\"right\">".number_format($JumlahSaldoAkhir,2)."</td>
					<td align=\"right\">&nbsp;</td>
					<td align=\"right\">".number_format($JumlahDiskon,2)."</td>
					<td align=\"right\">".number_format($JumlahTagihan,2)."</td>
				  </tr>";
		$html .=    "
					</tbody>
				 </table><br/><br/>";
		$html .= "<table>
					<tr>
						<td align=\"center\" >Yang Membuat,</td>
						<td align=\"center\" >Mengetahui,</td>
						<td align=\"center\" >Menyetujui,</td>
					</tr>
					<tr>
						<td align=\"center\" ></td>
						<td align=\"center\" ></td>
						<td align=\"center\" ></td>
					</tr>
					<tr>
						<td align=\"center\" ></td>
						<td align=\"center\" ></td>
						<td align=\"center\" ></td>
					</tr>
					<tr>
						<td align=\"center\" ></td>
						<td align=\"center\" ></td>
						<td align=\"center\" ></td>
					</tr>
					<tr>
						<td align=\"center\" ><strong> Rosa M J </strong></td>
						<td align=\"center\" ><strong> Sumarso </strong></td>
						<td align=\"center\" ><strong> Suprapto </strong></td>
					</tr>
					<tr>
						<td align=\"center\" >-----------------------------</td>
						<td align=\"center\" >-----------------------------</td>
						<td align=\"center\" >-----------------------------</td>
					</tr>
					<tr>
						<td align=\"center\" ><strong>  </strong></td>
						<td align=\"center\" ><strong> Kabid. Toko </strong></td>
						<td align=\"center\" ><strong> Pgs.Mgr.Dept.Penjualan Retail </strong></td>
					</tr>
				  </table>";
		$this->load->library('Pdf');
		
		$pdf = new TCPDF("P", PDF_UNIT, 'A4', true, 'UTF-8', false);
		// Add a page
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->SetMargins(5, 5, 5, true);
		$pdf->AddPage();
		$pdf->writeHTML($html, true, false, true, false, '');
		$pdf->Output('RekapitulasiBarangKonsinyasi.pdf', 'I');
	}

	public function cetaktagihankonsinyasi(){
		$html = "<style>
				 	table {
				 		font-size: 9px;
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
						<td align=\"center\" colspan=\"8\"><strong>TAGIHAN BARANG KONSINYASI</strong></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"8\"><strong>PERIODE : ".$_GET['tanggal_awal']." / ".$_GET['tanggal_akhir']."</strong></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"8\"><strong>TOKO : ".$_GET['nama_toko']."</strong></td>
					</tr>
				 </table><br/><br/>";
		
		$DataSaldoBarangGudang = $this->laporan_model->getRekapitulasiBarangKonsinyasi($_GET);
		
		$html .= "<table class=\"content\">
					<thead>
						<tr class=\"border_bottom\">
							<th width=\"30\" align=\"right\">No</th>
							<th width=\"60\">Kode</th>
							<th width=\"200\">Nama Supplier</th>
							<th width=\"100\" align=\"right\">Jml Tagihan</th>
						</tr>
					</thead>
					<tbody>";
		$jumlahSaldoAwal = 0;
		$jumlahIn = 0;
		$jumlahOut = 0;
		$jumlahBiaya = 0;
		$jumlahRetur = 0;
		$JumlahSaldoAkhir = 0;
		$JumlahDiskon = 0;
		$JumlahTagihan = 0;

		$jumlahSaldoAwalKategori = 0;
		$jumlahInKategori = 0;
		$jumlahOutKategori = 0;
		$jumlahBiayaKategori = 0;
		$jumlahReturKategori = 0;
		$JumlahSaldoAkhirKategori = 0;
		$JumlahDiskonKategori = 0;
		$JumlahTagihanKategori = 0;
		$nomor = 1;

		$kategori = "";
		foreach ($DataSaldoBarangGudang as $key => $value) {
			$value['saldo_awal_kwt'] = $value['saldo_awal_kwt'] + $value['kwt_in_awal'] - $value['kwt_out_awal'] - $value['kwt_retur_awal'] - $value['kwt_biaya_awal'];
			$value['saldo_akhir_kwt'] = $value['saldo_awal_kwt'] + $value['kwt_in'] - $value['kwt_out'] - $value['retur'] - $value['biaya'];
			if($kategori == ""){
				$kategori = $value['kategori'];
				$html .= "<tr class=\"border_top\">
							<td width=\"390\" colspan=\"4\">(".$value['kategori'].") ".$value['nama_kategori']."</td>
						  </tr>";
			}
			if($kategori != $value['kategori']){
				$html .= "<tr class=\"border_top\">
							<td colspan=\"3\">Total</td>
							<td align=\"right\">".number_format($JumlahTagihanKategori,2)."</td>
						  </tr>";
				$html .= "<tr class=\"border_top\">
							<td width=\"390\" colspan=\"4\">(".$value['kategori'].") ".$value['nama_kategori']."</td>
						  </tr>";
				$jumlahSaldoAwalKategori = 0;
				$jumlahInKategori = 0;
				$jumlahOutKategori = 0;
				$jumlahBiayaKategori = 0;
				$jumlahReturKategori = 0;
				$JumlahSaldoAkhirKategori = 0;
				$JumlahDiskonKategori = 0;
				$JumlahTagihanKategori = 0;
				$nomor = 1;
				$kategori = $value['kategori'];
			}
			$Diskon = round((($value['kwt_out'] + $value['biaya']) * ($value['fee_konsinyasi']/100)), 2);
			$JmlTagihan = ($value['kwt_out'] + $value['biaya']) - $Diskon;
			$html .= "<tr class=\"border_content\">
						<td width=\"30\" align=\"right\">".$nomor."</td>
						<td width=\"60\">".$value['supplier_kode']."</td>
						<td width=\"200\">".$value['nama_supplier']."</td>
						<td width=\"100\" align=\"right\">".number_format($JmlTagihan,2)."</td>
					</tr>";
			$jumlahSaldoAwalKategori += $value['saldo_awal_kwt'];
			$jumlahInKategori += $value['kwt_in'];
			$jumlahOutKategori += ($value['kwt_out']);
			$jumlahBiayaKategori += ($value['biaya']);
			$jumlahReturKategori += $value['retur'];
			$JumlahSaldoAkhirKategori += $value['saldo_akhir_kwt'];
			$JumlahDiskonKategori += $Diskon;
			$JumlahTagihanKategori += $JmlTagihan;

			$jumlahSaldoAwal += $value['saldo_awal_kwt'];
			$jumlahIn += $value['kwt_in'];
			$jumlahOut += ($value['kwt_out']);
			$jumlahBiaya += ($value['biaya']);
			$jumlahRetur += $value['retur'];
			$JumlahSaldoAkhir += $value['saldo_akhir_kwt'];
			$JumlahDiskon += $Diskon;
			$JumlahTagihan += $JmlTagihan;
			$nomor++;
		}
		$html .= "<tr class=\"border_top\">
					<td colspan=\"3\">Total</td>
					<td align=\"right\">".number_format($JumlahTagihanKategori,2)."</td>
				  </tr>";
		$html .= "<tr class=\"border_bottom\">
					<td colspan=\"3\">Grand Total</td>
					<td align=\"right\">".number_format($JumlahTagihan,2)."</td>
				  </tr>";
		$html .=    "
					</tbody>
				 </table>";

		$this->load->library('Pdf');
		
		$pdf = new TCPDF("P", PDF_UNIT, 'A4', true, 'UTF-8', false);
		// Add a page
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->SetMargins(5, 5, 5, true);
		$pdf->AddPage();
		$pdf->writeHTML($html, true, false, true, false, '');
		$pdf->Output('TagihanKonsinyasi.pdf', 'I');
	}
}