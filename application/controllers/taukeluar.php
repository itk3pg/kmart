<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Taukeluar extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('taukeluar_model');
		$this->load->model('syncsaldo_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('taukeluar/home');
		$this->load->view('general/footer');
	}
	
	public function getdatataukeluar(){
		$DataTAUKeluar = $this->taukeluar_model->getDataTAUKeluar($_POST);
		
		$bukti = "";
		$html = "<table class=\"table table-striped table-bordered table-hover\" id=\"dataTables-taukeluar\">
                    <thead>
                        <tr>
							<th>Bukti</th>
                       		<th>Tanggal</th>
							<th>Pelanggan</th>
                            <th>Barang</th>
                            <th>KWT</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>";
		foreach ($DataTAUKeluar as $key => $value) {
			$html .= "<tr data=\"".base64_encode(json_encode($value))."\">";
			if($bukti != $value['bukti']){
				$html .= "<td>".$value['bukti']."</td>
						  <td>".$value['tanggal']."</td>
						  <td>".$value['nama_pelanggan']."</td>";
				$bukti = $value['bukti'];
			}else{
				$html .= "<td></td>
						  <td></td>
						  <td></td>";
			}
			$html .= "	<td>".$value['nama_barang']."</td>
						<td align='right'>".$value['kwt']."</td>
						<td align=\"right\">".number_format($value['harga'],2)."</td>
						<td align=\"right\">".number_format($value['jumlah'],2)."</td>
					  </tr>";
		}

		$html .= "</tbody></table>";
		
		echo $html;
	}
	
	public function simpantaukeluar(){
		$dataArr = json_decode(rawurldecode($_POST['data']));
		//$index = 0;
		for($index=0;$index<sizeof($dataArr);$index = $index + 7){
			$barang_kode = $dataArr[$index];
			$kwt = $dataArr[$index+3];
			$harga = $dataArr[$index+4];
			$jumlah = $dataArr[$index+5];
			
			$_POST['barang_kode'] = $barang_kode;
			$_POST['kwt'] = $kwt;
			$_POST['harga'] = $harga;
			$_POST['jumlah'] = $jumlah;
			
			$this->taukeluar_model->SimpanTAUKeluar($_POST);
			
			$TglArr = explode('-', $_POST['tanggal']);
			$ParamSync = array();
			$ParamSync['bulan'] = $TglArr[1];
			$ParamSync['tahun'] = $TglArr[0];
			$ParamSync['barang_kode'] = $barang_kode;
			//$this->syncsaldo_model->SyncSaldoBarangSpesifik($ParamSync);
			$this->syncsaldo_model->SyncSaldoBarangGudangUtamaSpesifik($ParamSync);
		}
	}
	
	public function hapustaukeluar(){
		$this->taukeluar_model->HapusTAUKeluar($_POST);
	}
	
	public function getdatabarangtaukeluar(){
		$DataBarangTAUKeluar = $this->taukeluar_model->getDataBarangTAUKeluar($_POST);
		
		$html = "";
		foreach ($DataBarangTAUKeluar as $key => $value) {
			$html .= "<tr>
						<td>".$value['barang_kode']."</td>
						<td>".$value['nama_barang']."</td>
						<td>".$value['satuan']."</td>
						<td class=\"text-right\">".$value['kwt']."</td>
						<td class=\"text-right\">".$value['harga']."</td>
						<td class=\"text-right\">".$value['jumlah']."</td>
						<td class=\"text-center\">
							<button type=\"button\" style=\"padding: 1px 6px;\" onclick=\"HapusRow(this)\" class=\"btn btn-danger btn-sm\"><i class=\"fa fa-times\"></i></button>
						</td>
					</tr>";
		}
		
		echo $html;
	}
	
	public function cetaktaukeluar(){
		$DataBarangTAUKeluar = $this->taukeluar_model->getDataBarangTAUKeluar($_GET);
		
		$html = "<style>
				 	table {
				 		font-size: 9px;
				 	}
				 </style>";
		$html .= "<table>
					<tr>
						<td><strong>Koperasi karyawan Keluarga Besar Petrokimia Gresik</strong></td>
						<td align=\"right\">Transfer Antar Unit (TAU)</td>
					</tr>
					<tr>
						<td>Jl. ..... Petrokimia Gresik</td>
						<td>&nbsp;</td>
					</tr>
				  </table>";
		
		$html .= "<table>
					<tr>
						<td width=\"70\">Pelanggan</td>
						<td width=\"30\"> : </td>
						<td width=\"200\">".$DataBarangTAUKeluar[0]['pelanggan_kode']."</td>
						<td width=\"70\"></td>
						<td width=\"80\">Tanggal</td>
						<td width=\"30\"> : </td>
						<td width=\"100\">".$DataBarangTAUKeluar[0]['tanggal']."</td>
					</tr>
					<tr>
						<td width=\"70\"></td>
						<td width=\"30\"></td>
						<td width=\"200\">".$DataBarangTAUKeluar[0]['nama_pelanggan']."</td>
						<td width=\"70\"></td>
						<td width=\"80\">No Transaksi</td>
						<td width=\"30\"> : </td>
						<td width=\"100\">".$DataBarangTAUKeluar[0]['bukti']."</td>
					</tr>
					<tr>
						<td width=\"70\">Uraian</td>
						<td width=\"30\"> : </td>
						<td width=\"200\">Transfer Antar Unit (TAU)</td>
						<td width=\"70\"></td>
						<td width=\"80\"></td>
						<td width=\"30\"></td>
						<td width=\"100\"></td>
					</tr>
				  </table><br/><br/>";
		$html .= "<table>
					<thead>
						<tr>
							<th width=\"20\">No</th>
							<th width=\"80\">Kode Barang</th>
							<th width=\"150\">Nama Barang</th>
							<th width=\"40\" align=\"right\">Jumlah</th>
							<th width=\"35\">Satuan</th>
							<th width=\"80\" align=\"right\">Harga @</th>
							<th width=\"100\" align=\"right\">Total</th>
						</tr>
					</thead>
					<tbody>";
		$inc = 1;
		$TotalTransaksi = 0;
		foreach($DataBarangTAUKeluar as $key => $value){
			$JumlahHarga = $value['harga'] * $value['kwt'];
			$html .= "<tr>
						<td width=\"20\">".$inc."</td>
						<td width=\"80\">".$value['barang_kode']."</td>
						<td width=\"150\">".$value['nama_barang']."</td>
						<td width=\"40\" align=\"right\">".number_format($value['kwt'],2)."</td>
						<td width=\"35\">".$value['satuan']."</td>
						<td width=\"80\" align=\"right\">".number_format($value['harga'],2)."</td>
						<td width=\"100\" align=\"right\">".number_format($value['jumlah'],2)."</td>
					  </tr>";
			$inc++;
			$TotalTransaksi += $value['jumlah'];
		}
		$html .= "<tr>
					<td colspan=\"6\">&nbsp;</td>
					<td align=\"right\">&nbsp;</td>
				  </tr>";
		$html .= "</tbody></table>";
		$html .= "<table>
					<tr>
						<td width=\"70\">Total Transaksi</td>
						<td width=\"30\"> : </td>
						<td width=\"100\" align=\"right\">".number_format($TotalTransaksi,2)."</td>
					</tr>
				  </table><br/><br/><br/><br/>";
		$html .= "<table border=\"1\" width=\"200\">
					<tr>
						<td width=\"100\" align=\"center\">Pengirim</td>
						<td width=\"100\" align=\"center\">Penerima</td>
					</tr>
					<tr>
						<td width=\"100\">&nbsp;<br/></td>
						<td width=\"100\">&nbsp;</td>
					</tr>
				  </table>";
		/*$html .= "<table>
					<tr>
						<td align=\"center\">Dibuat oleh</td>
						<td align=\"center\">Manager Ops. DC</td>
						<td align=\"center\">Manager Ops. MD</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td align=\"center\">Yati / Yanti</td>
						<td align=\"center\">.....................................</td>
						<td align=\"center\">Teguh Prabowo</td>
					</tr>
				  </table>";*/
		
		$this->load->library('Pdf');
		
		$pdf = new TCPDF("P", PDF_UNIT, 'A4', true, 'UTF-8', false);
		// Add a page
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->AddPage();
		$pdf->writeHTML($html, true, false, true, false, '');
		$pdf->Output('TansferAntarUnit.pdf', 'I');
	}

	public function getrekaptaukeluar(){
		// header("Content-type: application/vnd.ms-excel");
		// header("Content-Disposition: attachment;Filename=rekap_harian_bi_".$_GET['tanggal_awal'].".xls");
		
		$html = "<style>
				 	table {
				 		font-size: 8px;
				 	}

				 	table.content {
				 		padding: 1px;
				 	}

				 	tr.border_bottom th {
				 		border-bottom:0.5pt dashed black;
					}

					tr.border_top td {
				 		border-top:0.5pt dashed black;
				 		border-bottom:0.5pt dashed black;
					}
				 </style>";
		$html .= "<table>
					<tr>
						<td><strong>Koperasi karyawan Keluarga Besar Petrokimia Gresik</strong></td>
						<td align=\"right\">".date('d-m-Y H:m:s')."</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				  </table>";

		$DataPembelianBarang = $this->taukeluar_model->getRekapTAUKeluar($_GET);
		
		$html .= "<table>
					<tr>
						<td colspan=\"6\" align=\"center\">Rekap Harian Biaya Keluar</td>
					</tr>
					<tr>
						<td colspan=\"6\" align=\"center\">".$_GET['tanggal_awal']." / ".$_GET['tanggal_akhir']."</td>
					</tr>
					<tr>
						<td colspan=\"6\" align=\"center\"></td>
					</tr>
				 </table>";

		$html .= "<table class=\"content\">
                    <thead>
                        <tr class=\"border_bottom\">
                       		<th width=\"15\" align=\"right\">No</th>
                       		<th width=\"15\">&nbsp;</th>
                       		<th>Tanggal</th>
							<th>Bukti</th>
							<th align=\"left\" width=\"150\">Pelanggan / Unit</th>
                            <th align=\"right\">Total</th>
                        </tr>
                    </thead>
                    <tbody>";
        $inc = 1;
        $tanggal = "";
        $TotalDPP = 0;
        $TotalPPn = 0;
        $TotalJumlah = 0;
        $TotalDPPAll = 0;
        $TotalPPnAll = 0;
        $TotalJumlahAll = 0;
		foreach ($DataPembelianBarang as $key => $value) {
			if($tanggal == ""){
				$tanggal = $value['tanggal'];
			}
			
			if($tanggal != $value['tanggal']){
				$html .= "<tr class=\"border_top\">
							<td colspan=\"5\">Sub Total</td>
							<td align=\"right\"><strong>".number_format($TotalJumlah, 2)."</strong></td>
						  </tr>";
				$tanggal = $value['tanggal'];
				$TotalDPP = 0;
		        $TotalPPn = 0;
		        $TotalJumlah = 0;
		        $inc = 1;
			}
			$html .= "<tr>
						<td width=\"15\" align=\"right\">".$inc."</td>
						<td width=\"15\">&nbsp;</td>
						<td>".$value['tanggal']."</td>
						<td>".$value['bukti']."</td>
						<td width=\"150\">".$value['nama_pelanggan']."</td>
						<td align=\"right\">".number_format($value['jumlah'], 2)."</td>
					  </tr>";
			$inc++;
	        $TotalJumlah += $value['jumlah'];
	        $TotalJumlahAll += $value['jumlah'];
		}
		$html .= "<tr class=\"border_top\">
					<td colspan=\"5\">Sub Total</td>
					<td align=\"right\"><strong>".number_format($TotalJumlah, 2)."</strong></td>
				  </tr>
				  <tr class=\"border_top\">
					<td colspan=\"5\">Total</td>
					<td align=\"right\"><strong>".number_format($TotalJumlahAll, 2)."</strong></td>
				  </tr>";

		$html .= "</tbody></table><br/><br/>";

		$DataKelompokPembelianBarang = $this->taukeluar_model->getRekapKelompokTAUKeluar($_GET);
		
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
					<td align=\"right\"><strong>".number_format($TotalJumlahAll, 2)."</strong></td>
				  </tr>";
					
		$html .= "</table>";
		
		$this->load->library('Pdf');
		
		$pdf = new TCPDF("P", PDF_UNIT, 'A4', true, 'UTF-8', false);
		// Add a page
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->AddPage();
		$pdf->writeHTML($html, true, false, true, false, '');
		$pdf->Output('RekapHarianBiaya.pdf', 'I');
	}

	public function getrekaptaukeluar_xls(){
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;Filename=rekap_harian_biaya_".$_GET['tanggal_awal'].".xls");
		
		$html = "<table>
					<tr>
						<td><strong>Koperasi karyawan Keluarga Besar Petrokimia Gresik</strong></td>
						<td align=\"right\">".date('d-m-Y H:m:s')."</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				  </table>";

		$DataPembelianBarang = $this->taukeluar_model->getRekapTAUKeluar($_GET);
		
		$html .= "<table>
					<tr>
						<td colspan=\"6\" align=\"center\">Rekap Harian Biaya Keluar</td>
					</tr>
					<tr>
						<td colspan=\"6\" align=\"center\">".$_GET['tanggal_awal']." / ".$_GET['tanggal_akhir']."</td>
					</tr>
					<tr>
						<td colspan=\"6\" align=\"center\"></td>
					</tr>
				 </table>";

		$html .= "<table class=\"content\">
                    <thead>
                        <tr class=\"border_bottom\">
                       		<th width=\"15\" align=\"right\">No</th>
                       		<th>Tanggal</th>
							<th>Bukti</th>
							<th align=\"left\" width=\"55\">Pelanggan / Unit</th>
                            <th align=\"right\">Total</th>
                        </tr>
                    </thead>
                    <tbody>";
        $inc = 1;
        $tanggal = "";
        $TotalDPP = 0;
        $TotalPPn = 0;
        $TotalJumlah = 0;
        $TotalDPPAll = 0;
        $TotalPPnAll = 0;
        $TotalJumlahAll = 0;
		foreach ($DataPembelianBarang as $key => $value) {
			if($tanggal == ""){
				$tanggal = $value['tanggal'];
			}
			
			if($tanggal != $value['tanggal']){
				$html .= "<tr class=\"border_top\">
							<td colspan=\"4\">Sub Total</td>
							<td align=\"right\"><strong>".number_format($TotalJumlah, 2)."</strong></td>
						  </tr>";
				$tanggal = $value['tanggal'];
				$TotalDPP = 0;
		        $TotalPPn = 0;
		        $TotalJumlah = 0;
		        $inc = 1;
			}
			$html .= "<tr>
						<td width=\"15\" align=\"right\">".$inc."</td>
						<td>".$value['tanggal']."</td>
						<td>".$value['bukti']."</td>
						<td width=\"55\">".$value['nama_pelanggan']."</td>
						<td align=\"right\">".number_format($value['jumlah'], 2)."</td>
					  </tr>";
			$inc++;
	        $TotalJumlah += $value['jumlah'];
	        $TotalJumlahAll += $value['jumlah'];
		}
		$html .= "<tr class=\"border_top\">
					<td colspan=\"4\">Sub Total</td>
					<td align=\"right\"><strong>".number_format($TotalJumlah, 2)."</strong></td>
				  </tr>
				  <tr class=\"border_top\">
					<td colspan=\"4\">Total</td>
					<td align=\"right\"><strong>".number_format($TotalJumlahAll, 2)."</strong></td>
				  </tr>";

		$html .= "</tbody></table><br/><br/>";

		$DataKelompokPembelianBarang = $this->taukeluar_model->getRekapKelompokTAUKeluar($_GET);
		
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
					<td align=\"right\"><strong>".number_format($TotalJumlahAll, 2)."</strong></td>
				  </tr>";
					
		$html .= "</table>";

		echo $html;
	}
}