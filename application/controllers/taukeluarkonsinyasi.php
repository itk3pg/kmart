<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Taukeluarkonsinyasi extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('taukeluarkonsinyasi_model');
		$this->load->model('syncsaldo_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('taukeluarkonsinyasi/home');
		$this->load->view('general/footer');
	}
	
	public function getdatatg(){
		$Datatg = $this->taukeluarkonsinyasi_model->getDataTG($_POST);
		
		$bukti = "";
		$html = "<table class=\"table table-striped table-bordered table-hover\" id=\"dataTables-biayakonsinyasi\">
                    <thead>
                        <tr>
							<th>Bukti</th>
                       		<th>Tanggal</th>
							<th>Toko</th>
							<th>Pelanggan</th>
                            <th>Barang</th>
                            <th>Qty</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>";
        $JumlahPerBukti = 0;
		foreach ($Datatg as $key => $value) {
			if($bukti != $value['bukti']){
				if($bukti != ""){
					$html .= "<tr>
								<td colspan=\"7\"><strong>Sub Total</strong></td>
								<td align=\"right\"><strong>".number_format($JumlahPerBukti,2)."</strong></td>
							  </tr>";
					$JumlahPerBukti = 0;
				}
				$html .= "<tr data=\"".base64_encode(json_encode($value))."\">";
				$html .= "<td>".$value['bukti']."</td>
						  <td>".$value['tanggal']."</td>
						  <td>".$value['nama_toko']."</td>
						  <td>".$value['nama_pelanggan']."</td>";
				$bukti = $value['bukti'];
			}else{
				$html .= "<td></td>
						  <td></td>
						  <td></td>
						  <td></td>";
			}
			$html .= "	<td>".$value['nama_barang']."</td>
						<td align='right'>".$value['kwt']."</td>
						<td align='right'>".number_format($value['harga'], 2)."</td>
						<td align='right'>".number_format($value['jumlah'], 2)."</td>
					  </tr>";
			$JumlahPerBukti += $value['jumlah'];
		}
		$html .= "<tr>
					<td colspan=\"7\"><strong>Sub Total</strong></td>
					<td align=\"right\"><strong>".number_format($JumlahPerBukti,2)."</strong></td>
				  </tr>";
		$html .= "</tbody>
				</table>";
		echo $html;
	}
	
	// public function listpilihtg(){
	// 	$Datatg = $this->taukeluarkonsinyasi_model->getDataListTG($_POST);
		
	// 	$bukti = "";
	// 	$html = "<table class=\"table table-striped table-bordered table-hover\" id=\"dataTables-tg\">
 //                    <thead>
 //                        <tr>
	// 						<th>BUKTI</th>
 //                       		<th>TANGGAL</th>
	// 						<th>TOKO</th>
	// 						<th>&nbsp;</th>
 //                        </tr>
 //                    </thead>
 //                    <tbody>";
	// 	foreach ($Datatg as $key => $value) {
	// 		$html .= "<tr>
	// 					<td>".$value['bukti']."</td>
	// 					<td>".$value['tanggal']."</td>
	// 					<td>".$value['nama_toko']."</td>
	// 					<td align=\"center\">
	// 						<button id=\"btn_pilih\" class=\"btn btn-info btn-sm\" type=\"button\" onclick=\"PilihOT('".$value['bukti']."')\">
	// 							<i class=\"fa fa-check\"></i>
	// 						</button>
	// 					</td>
	// 				  </tr>";
	// 	}
		
	// 	$html .= "</tbody>
	// 			</table>";
	// 	echo $html;
	// }
	
	public function simpantg(){
		$this->taukeluarkonsinyasi_model->SimpanTG($_POST);
		// if($_POST['ref_ot'] != ""){
		// 	$this->taukeluarkonsinyasi_model->setStatusOT($_POST);
		// }
	}
	
	public function hapustg(){
		$this->taukeluarkonsinyasi_model->HapusTG($_POST);
	}
	
	public function getdatabarangtg(){
		$DataBarangtg = $this->taukeluarkonsinyasi_model->getDataBarangTG($_POST);
		
		$html = "";
		foreach ($DataBarangtg as $key => $value) {
			$html .= "<tr>
						<td>".$value['barang_kode']."</td>
						<td>".$value['nama_barang']."</td>
						<td class=\"text-right\" id=\"kwt_".$value['barang_kode']."\">".$value['kwt']."</td>
						<td class=\"text-right\" id=\"harga_".$value['barang_kode']."\">".$value['harga']."</td>
						<td class=\"text-right\" id=\"jumlah_".$value['barang_kode']."\">".$value['jumlah']."</td>
						<td>".$value['satuan']."</td>
						<td class=\"text-center\">
							<button type=\"button\" onclick=\"openFormEditKWT('".$value['barang_kode']."', '".$value['kwt']."')\" class=\"btn btn-warning btn-sm\"><i class=\"fa fa-edit\"></i></button>
							<button type=\"button\" onclick=\"HapusRow(this)\" class=\"btn btn-danger btn-sm\"><i class=\"fa fa-times\"></i></button>
						</td>
					</tr>";
		}
		
		echo $html;
	}

	public function syncstok(){
		$DataRetur = $this->taukeluarkonsinyasi_model->getAllData($_POST);
		foreach ($DataRetur as $key => $value) {
			$TglArr = explode('-', $value['tanggal']);
			$ParamSync = array();
			$ParamSync['bulan'] = $TglArr[1];
			$ParamSync['tahun'] = $TglArr[0];
			$ParamSync['barang_kode'] = $value['barang_kode'];
			$ParamSync['toko_kode'] = $value['toko_kode'];
			$this->syncsaldo_model->SyncSaldoBarangTokoKonsinyasiSpesifik($ParamSync);
		}
	}
	
	// function terimatransfertoko(){
	// 	$this->taukeluarkonsinyasi_model->TerimaTransferToko($_POST);
		
	// 	$dataTransfer = $this->taukeluarkonsinyasi_model->getDataBarangTG($_POST);
	// 	foreach($dataTransfer as $key => $value){
	// 		$TglArr = explode('-', $value['tanggal']);
	// 		$ParamSync = array();
	// 		$ParamSync['bulan'] = $TglArr[1];
	// 		$ParamSync['tahun'] = $TglArr[0];
	// 		$ParamSync['barang_kode'] = $value['barang_kode'];
	// 		$ParamSync['toko_kode'] = $value['toko_kode'];
	// 		$this->syncsaldo_model->SyncSaldoBarangGudangKonsinyasiSpesifik($ParamSync);
	// 		$this->syncsaldo_model->SyncSaldoBarangTokoKonsinyasiSpesifik($ParamSync);
	// 		$ParamSync['toko_kode'] = "VO0001";
	// 		$this->syncsaldo_model->SyncSaldoBarangTokoKonsinyasiSpesifik($ParamSync);
	// 	}
	// }
	
	public function cetaktg(){
		$DataBarangtg = $this->taukeluarkonsinyasi_model->getDataBarangTG($_GET);
		
		$html = "<style>
				 	table {
				 		font-size: 9px;
				 	}

				 	table.content {
				 		padding: 1px;
				 	}

				 	tr.border_bottom th {
				 		border-bottom:0.5pt dashed black;
					}

					tr.border_top td {
				 		border-top:0.5pt dashed black;
					}
				 </style>";
		$html .= "<table>
					<tr>
						<td><strong>Koperasi karyawan Keluarga Besar Petrokimia Gresik</strong></td>
						<td align=\"right\">Biaya Keluar Konsinyasi (YN)</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				  </table><br/>";

		$html .= "<table>
					<tr>
						<td width=\"70\">Gudang Asal</td>
						<td width=\"30\"> : </td>
						<td width=\"200\">".$DataBarangtg[0]['nama_toko']."</td>
						<td width=\"70\"></td>
						<td width=\"80\">Tanggal</td>
						<td width=\"30\"> : </td>
						<td width=\"100\">".$DataBarangtg[0]['tanggal']."</td>
					</tr>
					<tr>
						<td width=\"70\">Pelanggan</td>
						<td width=\"30\"> : </td>
						<td width=\"200\">".$DataBarangtg[0]['nama_pelanggan']."</td>
						<td width=\"70\"></td>
						<td width=\"80\">No Transaksi</td>
						<td width=\"30\"> : </td>
						<td width=\"100\">".$DataBarangtg[0]['bukti']."</td>
					</tr>
					<tr>
						<td width=\"70\">Uraian</td>
						<td width=\"30\"> : </td>
						<td width=\"200\">Biaya Keluar Konsinyasi (KN)</td>
						<td width=\"70\"></td>
						<td width=\"80\">&nbsp;</td>
						<td width=\"30\">&nbsp;</td>
						<td width=\"100\">&nbsp;</td>
					</tr>
				  </table><br/><br/>";
		$html .= "<table class=\"content\">
					<thead>
						<tr class=\"border_bottom\">
							<th width=\"20\">No</th>
							<th width=\"80\">Kode Barang</th>
							<th width=\"200\">Nama Barang</th>
							<th width=\"35\">Satuan</th>
							<th width=\"40\" align=\"right\">Qty</th>
							<th width=\"80\" align=\"right\">Harga</th>
							<th width=\"80\" align=\"right\">Jumlah</th>
						</tr>
					</thead>
					<tbody>";
		$inc = 1;
		$Jumlah = 0;
		foreach($DataBarangtg as $key => $value){
			$html .= "<tr>
						<td width=\"20\">".$inc."</td>
						<td width=\"80\">".$value['barang_kode']."</td>
						<td width=\"200\">".$value['nama_barang']."</td>
						<td width=\"35\">".$value['satuan']."</td>
						<td width=\"40\" align=\"right\">".number_format($value['kwt'],2)."</td>
						<td width=\"80\" align=\"right\">".number_format($value['harga'],2)."</td>
						<td width=\"80\" align=\"right\">".number_format($value['jumlah'],2)."</td>
					  </tr>";
			$inc++;
			$Jumlah += $value['jumlah'];
		}
		$html .= "<tr class=\"border_top\">
					<td width=\"455\" colspan=\"6\"><strong>Total</strong></td>
					<td width=\"80\" align=\"right\"><strong>".number_format($Jumlah,2)."</strong></td>
				  </tr>";
		$html .= "</tbody></table><br/><br/><br/><br/>";
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

		$this->load->library('Pdf');
		
		$pdf = new TCPDF("P", PDF_UNIT, 'A4', true, 'UTF-8', false);
		// Add a page
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->AddPage();
		$pdf->writeHTML($html, true, false, true, false, '');
		$pdf->Output('BiayaKeluarKonsinyasi.pdf', 'I');
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

		$DataPembelianBarang = $this->taukeluarkonsinyasi_model->getRekapTAUKeluar($_GET);
		
		$html .= "<table>
					<tr>
						<td colspan=\"6\" align=\"center\">Rekap Harian Biaya Keluar Konsinyasi</td>
					</tr>
					<tr>
						<td colspan=\"6\" align=\"center\">".$_GET['tanggal_awal']." / ".$_GET['tanggal_akhir']."</td>
					</tr>
					<tr>
						<td colspan=\"6\" align=\"center\">".$DataPembelianBarang[0]['nama_toko']."</td>
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

		$DataKelompokPembelianBarang = $this->taukeluarkonsinyasi_model->getRekapKelompokTAUKeluar($_GET);
		
		$html .= "<table width=\"50%\">";
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
}