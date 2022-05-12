<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Barangmasuk extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('laporan_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('laporan/barangmasuk');
		$this->load->view('general/footer');
	}
	
	public function getbarangmasuk(){
		$DataBarangMasuk = $this->laporan_model->getBarangMasuk($_POST);
		
		if($_POST['is_per_supplier'] == "0"){
			$supplier_kode = "";
			$bukti = "";
			$TotalAll = 0;
			$TotalAll_harga = 0;
			$TotalAll_ppn = 0;

			$total_Perbukti = 0;
			$total_harga_Perbukti = 0;
			$total_ppn_Perbukti = 0;

			$total = 0;
			$total_harga = 0;
			$total_ppn = 0;
			
			$total_tunai = 0;
			$total_kredit = 0;
			$total_TAU = 0;
			$html = "<table class=\"table table-striped table-bordered table-hover\">
						<thead>
							<tr>
								<th>NO</th>
								<th>TANGGAL</th>
								<th>BUKTI</th>
								<th>REF OP</th>
								<th>NO REF</th>
								<th>KODE ITEM</th>
								<th>NAMA ITEM</th>
								<th>SATUAN</th>
								<th>QTY</th>
								<th>HARGA SATUAN</th>
								<th>JUMLAH</th>
								<th>PPN</th>
								<th>TOTAL</th>
							</tr>
						</thead>
						<tbody>";
			$no = 1;
			foreach ($DataBarangMasuk as $key => $value) {
				$jumlah_harga = $value['harga'] * $value['kwt'];
				$jumlah_ppn = $value['ppn'] * $value['kwt'];
				$subtotal = $value['jumlah'];
				if($bukti <> $value['bukti']){
					if($bukti <> ""){
						$html .= "<tr>
									<td colspan=\"10\"><strong>Jumlah Perbukti</strong></td>
									<td align=\"right\"><strong>".number_format($total_harga_Perbukti,2)."</strong></td>
									<td align=\"right\"><strong>".number_format($total_ppn_Perbukti,2)."</strong></td>
									<td align=\"right\"><strong>".number_format($total_Perbukti,2)."</strong></td>
								  </tr>";
						$total_Perbukti = 0;
						$total_harga_Perbukti = 0;
						$total_ppn_Perbukti = 0;
					}
					$bukti = $value['bukti'];
					$no = 1;
				}
				if($supplier_kode <> $value['supplier_kode']){
					if($supplier_kode <> ""){
						$html .= "<tr>
									<td colspan=\"10\"><strong>Jumlah Per Supplier</strong></td>
									<td align=\"right\"><strong>".number_format($total_harga,2)."</strong></td>
									<td align=\"right\"><strong>".number_format($total_ppn,2)."</strong></td>
									<td align=\"right\"><strong>".number_format($total,2)."</strong></td>
								  </tr>";
						$total = 0;
						$total_harga = 0;
						$total_ppn = 0;
					}
					$html .= "<tr>
								<td colspan=\"13\"><strong>".$value['supplier_kode']." : ".$value['nama_supplier']."</strong></td>
							  </tr>";
					$supplier_kode = $value['supplier_kode'];
				}
				
				$html .= "<tr>
							<td>".$no."</td>
							<td>".$value['tanggal']."</td>
							<td>".$value['bukti']."</td>
							<td>".$value['ref_op']."</td>
							<td>".$value['no_ref']."</td>
							<td>".$value['kd_item']."</td>
							<td>".$value['nama_item']."</td>
							<td>".$value['satuan']."</td>
							<td align=\"right\">".$value['kwt']."</td>
							<td align=\"right\">".number_format($value['harga'],2)."</td>
							<td align=\"right\">".number_format($jumlah_harga,2)."</td>
							<td align=\"right\">".number_format($jumlah_ppn,2)."</td>
							<td align=\"right\">".number_format($subtotal,2)."</td>
						  </tr>";
						  
				$total += $subtotal;
				$total_harga += $jumlah_harga;
				$total_ppn += $jumlah_ppn;

				$total_Perbukti += $subtotal;
				$total_harga_Perbukti += $jumlah_harga;
				$total_ppn_Perbukti += $jumlah_ppn;
				
				$TotalAll += $subtotal;
				$TotalAll_harga += $jumlah_harga;
				$TotalAll_ppn += $jumlah_ppn;
				
				if($value['status_pembayaran'] == "T"){
					$total_tunai += $jumlah_harga;
				}else if($value['status_pembayaran'] == "K"){
					$total_kredit += $jumlah_harga;
				}else if($value['status_pembayaran'] == "TAU"){
					$total_TAU += $jumlah_harga;
				}

				$no++;
			}
			$html .= "<tr>
						<td colspan=\"10\"><strong>Jumlah Perbukti</strong></td>
						<td align=\"right\"><strong>".number_format($total_harga_Perbukti,2)."</strong></td>
						<td align=\"right\"><strong>".number_format($total_ppn_Perbukti,2)."</strong></td>
						<td align=\"right\"><strong>".number_format($total_Perbukti,2)."</strong></td>
					  </tr>
					  <tr>
						<td colspan=\"10\"><strong>Jumlah Persupllier</strong></td>
						<td align=\"right\"><strong>".number_format($total_harga,2)."</strong></td>
						<td align=\"right\"><strong>".number_format($total_ppn,2)."</strong></td>
						<td align=\"right\"><strong>".number_format($total,2)."</strong></td>
					  </tr>
					  <tr>
						<td colspan=\"10\"><strong>Grand Total</strong></td>
						<td align=\"right\"><strong>".number_format($TotalAll_harga,2)."</strong></td>
						<td align=\"right\"><strong>".number_format($TotalAll_ppn,2)."</strong></td>
						<td align=\"right\"><strong>".number_format($TotalAll,2)."</strong></td>
					  </tr>";
			
			$html .= "</tbody></table>";
			$html .= "<table width=\"50%\" class=\"table table-striped table-bordered table-hover\">
						<tr>
							<td><strong>Tunai</strong></td>
							<td align=\"right\"><strong>".number_format($total_tunai,2)."</strong></td>
						</tr>
						<tr>
							<td><strong>Kredit</strong></td>
							<td align=\"right\"><strong>".number_format($total_kredit,2)."</strong></td>
						</tr>
						<tr>
							<td><strong>TAU</strong></td>
							<td align=\"right\"><strong>".number_format($total_TAU,2)."</strong></td>
						</tr>
						<tr>
							<td><strong>PPn</strong></td>
							<td align=\"right\"><strong>".number_format($TotalAll_ppn,2)."</strong></td>
						</tr>
					  </table>";
		}else{
			$TotalJumlah = 0;
			$TotalPPN = 0;
			$TOtalTotal = 0;
			$html = "<table class=\"table table-striped table-bordered table-hover\">
						<thead>
							<tr>
								<th>KODE SUPPLIER</th>
								<th>NAMA SUPPLIER</th>
								<th>JUMLAH</th>
								<th>PPN</th>
								<th>TOTAL</th>
							</tr>
						</thead>
						<tbody>";
			foreach ($DataBarangMasuk as $key => $value) {
				$html .= "<tr>
							<td>".$value['supplier_kode']."</td>
							<td>".$value['nama_supplier']."</td>
							<td align=\"right\">".number_format($value['harga'],2)."</td>
							<td align=\"right\">".number_format($value['ppn'],2)."</td>
							<td align=\"right\">".number_format($value['jumlah'],2)."</td>
						  </tr>";
				$TotalJumlah += $value['harga'];
				$TotalPPN += $value['ppn'];
				$TOtalTotal += $value['jumlah'];
			}
			$html .= "<tr>
						<td colspan='2'>Total</td>
						<td align=\"right\">".number_format($TotalJumlah,2)."</td>
						<td align=\"right\">".number_format($TotalPPN,2)."</td>
						<td align=\"right\">".number_format($TOtalTotal,2)."</td>
					  </tr>";
			$html .= "</tbody></table>";
		}
		
		echo $html;
	}
	
	public function cetakbarangmasuk(){
		$this->load->model("pembelianbarang_model");

		$html = "<style>
				 	table {
				 		/*font-size: 8px;*/
				 	}

				 	table.content {
				 		padding: 1px;
				 	}

				 	tr.border_bottom th {
				 		border-bottom:0.5pt dashed black;
				 		border-right:0.5pt dashed black;
					}

					tr.border_top th {
				 		border-top:0.5pt dashed black;
					}

					tr.border_top td {
				 		border-top:0.5pt dashed black;
				 		border-bottom:0.5pt dashed black;
				 		border-right:0.5pt dashed black;
					}

					tr.border_right td {
				 		border-right:0.5pt dashed black;
					}
				 </style>";
		
		$DataBarangMasuk = $this->laporan_model->getBarangMasuk($_GET);
		
		$total_tunai = 0;
		$total_kredit = 0;
		$total_TAU = 0;
		$html .= "<table width=\"100%\">
					<tr>
						<td ><strong>KOPERASI KARYAWAN KELUARGA BESAR PETROKIMIA GRESIK</strong></td>
						<td align=\"right\"><strong>TGL. : ".date("d-m-Y H:i:s")."</strong></td>
					</tr>
					<tr>
						<td><strong>K-Mart</strong></td>
						<td></td>
					</tr>
					<tr>
						<td colspan=\"2\" align=\"center\"><strong>LAPORAN PENGADAAN BARANG</strong></td>
					</tr>
					<tr>
						<td colspan=\"2\" align=\"center\"><strong>PERIODE : ".$_GET['tanggal_awal']." / ".$_GET['tanggal_akhir']."</strong></td>
					</tr>
				 </table>";
		if($_GET['is_per_supplier'] == "0"){
			$supplier_kode = "";
			$bukti = "";
			$TotalAll = 0;
			$TotalAll_harga = 0;
			$TotalAll_ppn = 0;

			$total_Perbukti = 0;
			$total_harga_Perbukti = 0;
			$total_ppn_Perbukti = 0;

			$total = 0;
			$total_harga = 0;
			$total_ppn = 0;
			
			$total_tunai = 0;
			$total_kredit = 0;
			$total_TAU = 0;
			$html .= "<table border=\"1\">
						<thead>
							<tr>
								<th>NO</th>
								<th>TANGGAL</th>
								<th>BUKTI</th>
								<th>REF OP</th>
								<th>NO REF</th>
								<th>KODE ITEM</th>
								<th>NAMA ITEM</th>
								<th>SATUAN</th>
								<th>QTY</th>
								<th>HARGA SATUAN</th>
								<th>JUMLAH</th>
								<th>PPN</th>
								<th>TOTAL</th>
							</tr>
						</thead>
						<tbody>";
			$no = 1;
			foreach ($DataBarangMasuk as $key => $value) {
				$jumlah_harga = $value['harga'] * $value['kwt'];
				$jumlah_ppn = $value['ppn'] * $value['kwt'];
				$subtotal = $value['jumlah'];
				if($bukti <> $value['bukti']){
					if($bukti <> ""){
						$html .= "<tr>
									<td colspan=\"10\"><strong>Jumlah Perbukti</strong></td>
									<td align=\"right\"><strong>".number_format($total_harga_Perbukti,2)."</strong></td>
									<td align=\"right\"><strong>".number_format($total_ppn_Perbukti,2)."</strong></td>
									<td align=\"right\"><strong>".number_format($total_Perbukti,2)."</strong></td>
								  </tr>";
						$total_Perbukti = 0;
						$total_harga_Perbukti = 0;
						$total_ppn_Perbukti = 0;
					}
					$bukti = $value['bukti'];
					$no = 1;
				}
				if($supplier_kode <> $value['supplier_kode']){
					if($supplier_kode <> ""){
						$html .= "<tr>
									<td colspan=\"10\"><strong>Jumlah Per Supplier</strong></td>
									<td align=\"right\"><strong>".number_format($total_harga,2)."</strong></td>
									<td align=\"right\"><strong>".number_format($total_ppn,2)."</strong></td>
									<td align=\"right\"><strong>".number_format($total,2)."</strong></td>
								  </tr>";
						$total = 0;
						$total_harga = 0;
						$total_ppn = 0;
					}
					$html .= "<tr>
								<td colspan=\"13\"><strong>".$value['supplier_kode']." : ".$value['nama_supplier']."</strong></td>
							  </tr>";
					$supplier_kode = $value['supplier_kode'];
				}
				
				$html .= "<tr>
							<td>".$no."</td>
							<td>".$value['tanggal']."</td>
							<td>".$value['bukti']."</td>
							<td>".$value['no_ref']."</td>
							<td>".$value['ref_op']."</td>
							<td>".$value['kd_item']."</td>
							<td>".$value['nama_item']."</td>
							<td>".$value['satuan']."</td>
							<td align=\"right\">".$value['kwt']."</td>
							<td align=\"right\">".number_format($value['harga'],2)."</td>
							<td align=\"right\">".number_format($jumlah_harga,2)."</td>
							<td align=\"right\">".number_format($jumlah_ppn,2)."</td>
							<td align=\"right\">".number_format($subtotal,2)."</td>
						  </tr>";
						  
				$total += $subtotal;
				$total_harga += $jumlah_harga;
				$total_ppn += $jumlah_ppn;

				$total_Perbukti += $subtotal;
				$total_harga_Perbukti += $jumlah_harga;
				$total_ppn_Perbukti += $jumlah_ppn;
				
				$TotalAll += $subtotal;
				$TotalAll_harga += $jumlah_harga;
				$TotalAll_ppn += $jumlah_ppn;
				
				if($value['status_pembayaran'] == "T"){
					$total_tunai += $jumlah_harga;
				}else if($value['status_pembayaran'] == "K"){
					$total_kredit += $jumlah_harga;
				}else if($value['status_pembayaran'] == "TAU"){
					$total_TAU += $jumlah_harga;
				}

				$no++;
			}
			$html .= "<tr>
						<td colspan=\"10\"><strong>Jumlah Perbukti</strong></td>
						<td align=\"right\"><strong>".number_format($total_harga_Perbukti,2)."</strong></td>
						<td align=\"right\"><strong>".number_format($total_ppn_Perbukti,2)."</strong></td>
						<td align=\"right\"><strong>".number_format($total_Perbukti,2)."</strong></td>
					  </tr>
					  <tr>
						<td colspan=\"10\"><strong>Jumlah Persupllier</strong></td>
						<td align=\"right\"><strong>".number_format($total_harga,2)."</strong></td>
						<td align=\"right\"><strong>".number_format($total_ppn,2)."</strong></td>
						<td align=\"right\"><strong>".number_format($total,2)."</strong></td>
					  </tr>
					  <tr>
						<td colspan=\"10\"><strong>Grand Total</strong></td>
						<td align=\"right\"><strong>".number_format($TotalAll_harga,2)."</strong></td>
						<td align=\"right\"><strong>".number_format($TotalAll_ppn,2)."</strong></td>
						<td align=\"right\"><strong>".number_format($TotalAll,2)."</strong></td>
					  </tr>";
			
			$html .= "</tbody></table><br/><br/>";
			// echo $html;exit();
		}else{
			$TotalJumlah = 0;
			$TotalPPN = 0;
			$TOtalTotal = 0;
			$html .= "<table border=\"1\">
						<thead>
							<tr class=\"border_bottom border_top\">
								<th>KODE SUPPLIER</th>
								<th>NAMA SUPPLIER</th>
								<th>JUMLAH</th>
								<th>PPN</th>
								<th>TOTAL</th>
							</tr>
						</thead>
						<tbody>";
			foreach ($DataBarangMasuk as $key => $value) {
				$html .= "<tr class=\"border_right\">
							<td>".$value['supplier_kode']."</td>
							<td>".$value['nama_supplier']."</td>
							<td align=\"right\">".number_format($value['harga'],2)."</td>
							<td align=\"right\">".number_format($value['ppn'],2)."</td>
							<td align=\"right\">".number_format($value['jumlah'],2)."</td>
						  </tr>";
				$TotalJumlah += $value['harga'];
				$TotalPPN += $value['ppn'];
				$TOtalTotal += $value['jumlah'];
			}
			$html .= "<tr class=\"border_top\">
						<td colspan='2'>Total</td>
						<td align=\"right\">".number_format($TotalJumlah,2)."</td>
						<td align=\"right\">".number_format($TotalPPN,2)."</td>
						<td align=\"right\">".number_format($TOtalTotal,2)."</td>
					  </tr>";
			$html .= "</tbody></table><br/><br/>";
		}
		
		$DataKelompokPembelianBarang = $this->pembelianbarang_model->getRekapKelompokPembelianBarang($_GET);
		$html .= "<table width=\"30%\">";
		$TotalAll = 0;
		foreach ($DataKelompokPembelianBarang as $key => $value) {
			$html .= "<tr>
						<td>(".$value['kategori'].") ".$value['nama']."</td>
						<td align=\"right\">".number_format($value['jumlah'], 2)."</td>
					  </tr>";
			$TotalAll += $value['jumlah'];
		}
		$html .= "<tr>
					<td>Total</td>
					<td align=\"right\"><strong>".number_format($TotalAll, 2)."</strong></td>
				  </tr>";
					
		$html .= "</table>";

		echo $html; exit();
		$this->load->library('Pdf');
		
		$pdf = new TCPDF("P", PDF_UNIT, 'A4', true, 'UTF-8', false);
		// Add a page
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->AddPage();
		$pdf->writeHTML($html, true, false, true, false, '');
		$pdf->Output('LaporanPengadaanBarang.pdf', 'I');
	}

	public function cetakbarangmasukexcel(){
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;Filename=laporan_pengadaan_barang_".$_GET['tanggal_awal'].".xls");

		$this->load->model("pembelianbarang_model");
		
		$DataBarangMasuk = $this->laporan_model->getBarangMasuk($_GET);
		
		$total_tunai = 0;
		$total_kredit = 0;
		$total_TAU = 0;
		$html = "<table>
					<tr>
						<td colspan=\"4\" ><strong>KOPERASI KARYAWAN KELUARGA BESAR PETROKIMIA GRESIK</strong></td>
						<td colspan=\"4\" align=\"right\"><strong>TGL. : ".date("d-m-Y H:i:s")."</strong></td>
					</tr>
					<tr>
						<td colspan=\"4\"><strong>K-Mart</strong></td>
						<td colspan=\"4\"></td>
					</tr>
					<tr>
						<td colspan=\"8\" align=\"center\"><strong>LAPORAN PENGADAAN BARANG</strong></td>
					</tr>
					<tr>
						<td colspan=\"8\" align=\"center\"><strong>PERIODE : ".$_GET['tanggal_awal']." / ".$_GET['tanggal_akhir']."</strong></td>
					</tr>
				 </table>";
		if($_GET['is_per_supplier'] == "0"){
			$supplier_kode = "";
			$bukti = "";
			$TotalAll = 0;
			$TotalAll_harga = 0;
			$TotalAll_ppn = 0;

			$total_Perbukti = 0;
			$total_harga_Perbukti = 0;
			$total_ppn_Perbukti = 0;

			$total = 0;
			$total_harga = 0;
			$total_ppn = 0;
			
			$total_tunai = 0;
			$total_kredit = 0;
			$total_TAU = 0;
			$html .= "<table border=\"1\">
						<thead>
							<tr>
								<th>NO</th>
								<th>TANGGAL</th>
								<th>BUKTI</th>
								<th>REF OP</th>
								<th>NO REF</th>
								<th>KODE ITEM</th>
								<th>NAMA ITEM</th>
								<th>SATUAN</th>
								<th>QTY</th>
								<th>HARGA SATUAN</th>
								<th>JUMLAH</th>
								<th>PPN</th>
								<th>TOTAL</th>
							</tr>
						</thead>
						<tbody>";
			$no = 1;
			foreach ($DataBarangMasuk as $key => $value) {
				$jumlah_harga = $value['harga'] * $value['kwt'];
				$jumlah_ppn = $value['ppn'] * $value['kwt'];
				$subtotal = $value['jumlah'];
				if($bukti <> $value['bukti']){
					if($bukti <> ""){
						$html .= "<tr>
									<td colspan=\"10\"><strong>Jumlah Perbukti</strong></td>
									<td align=\"right\"><strong>".number_format($total_harga_Perbukti,2)."</strong></td>
									<td align=\"right\"><strong>".number_format($total_ppn_Perbukti,2)."</strong></td>
									<td align=\"right\"><strong>".number_format($total_Perbukti,2)."</strong></td>
								  </tr>";
						$total_Perbukti = 0;
						$total_harga_Perbukti = 0;
						$total_ppn_Perbukti = 0;
					}
					$bukti = $value['bukti'];
					$no = 1;
				}
				if($supplier_kode <> $value['supplier_kode']){
					if($supplier_kode <> ""){
						$html .= "<tr>
									<td colspan=\"10\"><strong>Jumlah Per Supplier</strong></td>
									<td align=\"right\"><strong>".number_format($total_harga,2)."</strong></td>
									<td align=\"right\"><strong>".number_format($total_ppn,2)."</strong></td>
									<td align=\"right\"><strong>".number_format($total,2)."</strong></td>
								  </tr>";
						$total = 0;
						$total_harga = 0;
						$total_ppn = 0;
					}
					$html .= "<tr>
								<td colspan=\"13\"><strong>".$value['supplier_kode']." : ".$value['nama_supplier']."</strong></td>
							  </tr>";
					$supplier_kode = $value['supplier_kode'];
				}
				
				$html .= "<tr>
							<td>".$no."</td>
							<td>".$value['tanggal']."</td>
							<td>".$value['bukti']."</td>
							<td>".$value['no_ref']."</td>
							<td>".$value['ref_op']."</td>
							<td>".$value['kd_item']."</td>
							<td>".$value['nama_item']."</td>
							<td>".$value['satuan']."</td>
							<td align=\"right\">".$value['kwt']."</td>
							<td align=\"right\">".number_format($value['harga'],2)."</td>
							<td align=\"right\">".number_format($jumlah_harga,2)."</td>
							<td align=\"right\">".number_format($jumlah_ppn,2)."</td>
							<td align=\"right\">".number_format($subtotal,2)."</td>
						  </tr>";
						  
				$total += $subtotal;
				$total_harga += $jumlah_harga;
				$total_ppn += $jumlah_ppn;

				$total_Perbukti += $subtotal;
				$total_harga_Perbukti += $jumlah_harga;
				$total_ppn_Perbukti += $jumlah_ppn;
				
				$TotalAll += $subtotal;
				$TotalAll_harga += $jumlah_harga;
				$TotalAll_ppn += $jumlah_ppn;
				
				if($value['status_pembayaran'] == "T"){
					$total_tunai += $jumlah_harga;
				}else if($value['status_pembayaran'] == "K"){
					$total_kredit += $jumlah_harga;
				}else if($value['status_pembayaran'] == "TAU"){
					$total_TAU += $jumlah_harga;
				}

				$no++;
			}
			$html .= "<tr>
						<td colspan=\"10\"><strong>Jumlah Perbukti</strong></td>
						<td align=\"right\"><strong>".number_format($total_harga_Perbukti,2)."</strong></td>
						<td align=\"right\"><strong>".number_format($total_ppn_Perbukti,2)."</strong></td>
						<td align=\"right\"><strong>".number_format($total_Perbukti,2)."</strong></td>
					  </tr>
					  <tr>
						<td colspan=\"10\"><strong>Jumlah Persupllier</strong></td>
						<td align=\"right\"><strong>".number_format($total_harga,2)."</strong></td>
						<td align=\"right\"><strong>".number_format($total_ppn,2)."</strong></td>
						<td align=\"right\"><strong>".number_format($total,2)."</strong></td>
					  </tr>
					  <tr>
						<td colspan=\"10\"><strong>Grand Total</strong></td>
						<td align=\"right\"><strong>".number_format($TotalAll_harga,2)."</strong></td>
						<td align=\"right\"><strong>".number_format($TotalAll_ppn,2)."</strong></td>
						<td align=\"right\"><strong>".number_format($TotalAll,2)."</strong></td>
					  </tr>";
			
			$html .= "</tbody></table><br/><br/>";
			// echo $html;exit();
		}else{
			$TotalJumlah = 0;
			$TotalPPN = 0;
			$TOtalTotal = 0;
			$html .= "<table border=\"1\">
						<thead>
							<tr class=\"border_bottom border_top\">
								<th>KODE SUPPLIER</th>
								<th>NAMA SUPPLIER</th>
								<th>JUMLAH</th>
								<th>PPN</th>
								<th>TOTAL</th>
							</tr>
						</thead>
						<tbody>";
			foreach ($DataBarangMasuk as $key => $value) {
				$html .= "<tr class=\"border_right\">
							<td>".$value['supplier_kode']."</td>
							<td>".$value['nama_supplier']."</td>
							<td align=\"right\">".number_format($value['harga'],2)."</td>
							<td align=\"right\">".number_format($value['ppn'],2)."</td>
							<td align=\"right\">".number_format($value['jumlah'],2)."</td>
						  </tr>";
				$TotalJumlah += $value['harga'];
				$TotalPPN += $value['ppn'];
				$TOtalTotal += $value['jumlah'];
			}
			$html .= "<tr class=\"border_top\">
						<td colspan='2'>Total</td>
						<td align=\"right\">".number_format($TotalJumlah,2)."</td>
						<td align=\"right\">".number_format($TotalPPN,2)."</td>
						<td align=\"right\">".number_format($TOtalTotal,2)."</td>
					  </tr>";
			$html .= "</tbody></table><br/><br/>";
		}
		
		$DataKelompokPembelianBarang = $this->pembelianbarang_model->getRekapKelompokPembelianBarang($_GET);
		$html .= "<table width=\"30%\">";
		$TotalAll = 0;
		foreach ($DataKelompokPembelianBarang as $key => $value) {
			$html .= "<tr>
						<td>(".$value['kategori'].") ".$value['nama']."</td>
						<td align=\"right\">".number_format($value['jumlah'], 2)."</td>
					  </tr>";
			$TotalAll += $value['jumlah'];
		}
		$html .= "<tr>
					<td>Total</td>
					<td align=\"right\"><strong>".number_format($TotalAll, 2)."</strong></td>
				  </tr>";
					
		$html .= "</table>";

		echo $html;
	}
}
?>