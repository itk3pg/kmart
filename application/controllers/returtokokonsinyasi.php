<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Returtokokonsinyasi extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('returtokokonsinyasi_model');
		$this->load->model('syncsaldo_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('returtokokonsinyasi/home');
		$this->load->view('general/footer');
	}
	
	public function getdatareturtoko(){
		$DataReturToko = $this->returtokokonsinyasi_model->getDataReturToko($_POST);
		
		$bukti = "";
		$html = "<table class=\"table table-striped table-bordered table-hover\" id=\"dataTables-returtoko\">
                    <thead>
                        <tr>
							<th>&nbsp;</th>
							<th>Bukti</th>
							<th>Keterangan</th>
                       		<th>Tanggal</th>
							<th>Toko</th>
							<th>Kode Barang</th>
                            <th>Barang</th>
                            <th>Qty</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>";
		foreach ($DataReturToko as $key => $value) {
			$html .= "<tr data=\"".base64_encode(json_encode($value))."\">";
			if($bukti != $value['bukti']){
				if($value['is_approve'] == "1"){
					$html .= "<td><strong>&#x2713;</strong></td>";
				}else{
					$html .= "<td>-</td>";
				}
				$html .= "<td>".$value['bukti']."</td>
						  <td>".$value['keterangan']."</td>
						  <td>".$value['tanggal']."</td>
						  <td>".$value['nama_toko']."</td>";
				$bukti = $value['bukti'];
			}else{
				$html .= "<td></td>
						  <td></td>
						  <td></td>
						  <td></td>
						  <td></td>";
			}
			$html .= "	<td>".$value['barang_kode']."</td>
						<td>".$value['nama_barang']."</td>
						<td align='right'>".$value['kwt']."</td>
						<td align='right'>".number_format($value['harga'], 2)."</td>
						<td align='right'>".number_format($value['jumlah'], 2)."</td>
					  </tr>";
		}
		
		$html .= "</tbody>
				</table>";
		echo $html;
	}
	
	public function listpilihreturtoko(){
		$DataReturToko = $this->returtokokonsinyasi_model->getDataListReturToko($_POST);
		
		$bukti = "";
		$html = "<table class=\"table table-striped table-bordered table-hover\" id=\"dataTables-returtoko\">
                    <thead>
                        <tr>
							<th>BUKTI</th>
                       		<th>TANGGAL</th>
							<th>TOKO</th>
							<th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>";
		foreach ($DataReturToko as $key => $value) {
			$html .= "<tr>
						<td>".$value['bukti']."</td>
						<td>".$value['tanggal']."</td>
						<td>".$value['nama_toko']."</td>
						<td align=\"center\">
							<button id=\"btn_pilih\" class=\"btn btn-info btn-sm\" type=\"button\" onclick=\"PilihOT('".$value['bukti']."')\">
								<i class=\"fa fa-check\"></i>
							</button>
						</td>
					  </tr>";
		}
		
		$html .= "</tbody>
				</table>";
		echo $html;
	}

	public function listpilihreturtokoapprove(){
		$DataReturToko = $this->returtokokonsinyasi_model->getDataListReturTokoApprove($_POST);
		
		$bukti = "";
		$html = "<table class=\"table table-striped table-bordered table-hover\" id=\"dataTables-returtoko\">
                    <thead>
                        <tr>
							<th>BUKTI</th>
                       		<th>TANGGAL</th>
							<th>TOKO</th>
							<th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>";
		foreach ($DataReturToko as $key => $value) {
			$html .= "<tr>
						<td>".$value['bukti']."</td>
						<td>".$value['tanggal']."</td>
						<td>".$value['nama_toko']."</td>
						<td align=\"center\">
							<button id=\"btn_pilih\" class=\"btn btn-info btn-sm\" type=\"button\" onclick=\"PilihRT('".$value['bukti']."', '".$value['toko_kode']."')\">
								<i class=\"fa fa-check\"></i>
							</button>
						</td>
					  </tr>";
		}
		
		$html .= "</tbody>
				</table>";
		echo $html;
	}

	public function getdatabarangrttk(){
		$DataBarangot = $this->returtokokonsinyasi_model->getDataBarangReturToko($_POST);
		
		$html = "";
		foreach ($DataBarangot as $key => $value) {
			$html .= "<tr>
						<td>".$value['barang_kode']."</td>
						<td>".$value['nama_barang']."</td>
						<td id=\"kwt_".$value['barang_kode']."\" class=\"text-right\">".$value['kwt']."</td>
						<td id=\"harga_".$value['barang_kode']."\" class=\"text-right\">".$value['harga']."</td>
						<td id=\"jumlah_".$value['barang_kode']."\" class=\"text-right\">".$value['jumlah']."</td>
						<td class=\"text-center\">
							<button type=\"button\" onclick=\"HapusRow(this)\" class=\"btn btn-danger btn-sm\"><i class=\"fa fa-times\"></i></button>
						</td>
					</tr>";
		}
		
		echo $html;
	}
	
	public function simpanreturtoko(){
		if($_POST['kwt'] > 0){
			$this->returtokokonsinyasi_model->SimpanReturToko($_POST);
		}
	}
	
	public function hapusreturtoko(){
		$this->returtokokonsinyasi_model->HapusReturToko($_POST);
	}

	public function simpantransferketoko(){
		$DataTransferGudang = $this->returtokokonsinyasi_model->getDataTransferGudang($_POST);
		
		if(sizeof($DataTransferGudang) > 0){
			$BuktiTG = "S".$DataTransferGudang[0]['bukti'];
		}else{
			$BuktiTG = $this->returtokokonsinyasi_model->SimpanTransferKeToko($_POST);
		}
		
		echo $BuktiTG;
	}
	
	public function getdatabarangreturtoko(){
		$DataBarangot = $this->returtokokonsinyasi_model->getDataBarangReturToko($_POST);
		
		$html = "";
		foreach ($DataBarangot as $key => $value) {
			$html .= "<tr>
						<td>".$value['barang_kode']."</td>
						<td>".$value['nama_barang']."</td>
						<td id=\"saldo_akhir_ket_".$value['barang_kode']."\" class=\"text-right\">".$value['saldo_akhir_kwt']."</td>
						<td id=\"kwt_".$value['barang_kode']."\" class=\"text-right\">".$value['kwt']."</td>
						<td id=\"harga_".$value['barang_kode']."\" class=\"text-right\">".$value['harga']."</td>
						<td id=\"jumlah_".$value['barang_kode']."\" class=\"text-right\">".$value['jumlah']."</td>
						<td class=\"text-center\">
							<table id='form-edit-table-".$value['barang_kode']."' style='display: none;'>
								<thead>
									<tr>
										<th>kwt :</th>
										<th>&nbsp;</th>
									</tr>
									<tr>
										<th>
											<input type='text' style='width: 80px; text-align: right;' class='form-control' id='kwt_edit_".$value['barang_kode']."' name='kwt_edit_".$value['barang_kode']."' />
										</th>
										<th width='60px'>
											<button id='btn_cancel_edit_kwt_".$value['barang_kode']."' onclick=\"CancelEditkwt('".$value['barang_kode']."')\" name='btn_cancel_edit_kwt_".$value['barang_kode']."' type=\"button\" style=\"padding: 6px 5px; float:left;\" onclick=\"SimpanEditKwt(this)\" class=\"btn btn-danger btn-sm\">
												<i class=\"fa fa-times\"></i>
											</button>
											<button id='btn_edit_kwt_".$value['barang_kode']."' onclick=\"SimpanEditKwt('".$value['barang_kode']."')\" name='btn_edit_kwt_".$value['barang_kode']."' type=\"button\" style=\"padding: 6px 5px; float:left;\" class=\"btn btn-success btn-sm\">
												<i class=\"fa fa-check\"></i>
											</button>
										</th>
									</tr>
								</thead>
							</table>
							<!--<button type=\"button\" style=\"padding: 1px 5px;\" onclick=\"Editkwt('".$value['barang_kode']."')\" class=\"btn btn-warning btn-sm\">
								<i class=\"fa fa-edit\"></i>
							</button>-->
							<button type=\"button\" style=\"padding: 1px 6px;\" onclick=\"HapusRow(this)\" class=\"btn btn-danger btn-sm\"><i class=\"fa fa-times\"></i></button>
						</td>
					</tr>";
		}
		
		echo $html;
	}
	
	public function getdatabarangsupplier(){
		$DataBarangSupplier = $this->returtokokonsinyasi_model->getDataBarangSupplier($_POST);
		
		$html = "";
		foreach ($DataBarangSupplier as $key => $value) {
			$html .= "<tr>
						<td>".$value['kode']."</td>
						<td>".$value['nama_barang']."</td>
						<td>".$value['satuan']."</td>
						<td id=\"saldo_akhir_ket_".$value['kode']."\" class=\"text-right\">".$value['saldo_akhir_kwt']."</td>
						<td id=\"kwt_".$value['kode']."\" class=\"text-right\">0</td>
						<td class=\"text-center\">
							<table id='form-edit-table-".$value['kode']."' style='display: none;'>
								<thead>
									<tr>
										<th>kwt :</th>
										<th>&nbsp;</th>
									</tr>
									<tr>
										<th>
											<input type='text' style='width: 80px; text-align: right;' class='form-control' id='kwt_edit_".$value['kode']."' name='kwt_edit_".$value['kode']."' />
										</th>
										<th width='60px'>
											<button id='btn_cancel_edit_kwt_".$value['kode']."' onclick=\"CancelEditkwt('".$value['kode']."')\" name='btn_cancel_edit_kwt_".$value['kode']."' type=\"button\" style=\"padding: 6px 5px; float:left;\" onclick=\"SimpanEditKwt(this)\" class=\"btn btn-danger btn-sm\">
												<i class=\"fa fa-times\"></i>
											</button>
											<button id='btn_edit_kwt_".$value['kode']."' onclick=\"SimpanEditKwt('".$value['kode']."')\" name='btn_edit_kwt_".$value['kode']."' type=\"button\" style=\"padding: 6px 5px; float:left;\" class=\"btn btn-success btn-sm\">
												<i class=\"fa fa-check\"></i>
											</button>
										</th>
									</tr>
								</thead>
							</table>
							<button type=\"button\" style=\"padding: 1px 5px;\" onclick=\"Editkwt('".$value['kode']."')\" class=\"btn btn-warning btn-sm\">
								<i class=\"fa fa-edit\"></i>
							</button>
							<button type=\"button\" style=\"padding: 1px 6px;\" onclick=\"HapusRow(this)\" class=\"btn btn-danger btn-sm\"><i class=\"fa fa-times\"></i></button>
						</td>
					</tr>";
		}
		
		echo $html;
	}
	
	function getsaldobarangtoko(){
		$DataSaldo = $this->returtokokonsinyasi_model->getSaldoBarangToko($_POST);
		
		if(sizeof($DataSaldo)){
			echo $DataSaldo[0]['saldo_akhir_kwt'];
		}else{
			echo 0;
		}
	}
	
	function terimaretur(){
		$this->returtokokonsinyasi_model->TerimaRetur($_POST);
		
		$dataReturToko = $this->returtokokonsinyasi_model->getDataBarangReturToko($_POST);
		foreach($dataReturToko as $key => $value){
			$TglArr = explode('-', $value['tanggal']);
			$ParamSync = array();
			$ParamSync['bulan'] = $TglArr[1];
			$ParamSync['tahun'] = $TglArr[0];
			$ParamSync['barang_kode'] = $value['barang_kode'];
			$ParamSync['toko_kode'] = $value['toko_kode'];
			$this->syncsaldo_model->SyncSaldoBarangGudangKonsinyasiSpesifik($ParamSync);
			$this->syncsaldo_model->SyncSaldoBarangTokoKonsinyasiSpesifik($ParamSync);
		}
	}
	
	public function cetakreturtoko(){
		$DataBarangrt = $this->returtokokonsinyasi_model->getDataBarangReturToko($_GET);;
		
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
					}
				 </style>";
		$html .= "<table>
					<tr>
						<td><strong>Koperasi karyawan Keluarga Besar Petrokimia Gresik</strong></td>
						<td align=\"right\">Retur Toko Konsinyasi</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				  </table><br/><br/>";
		$html .= "<table>
					<tr>
						<td width=\"70\">Gudang Asal</td>
						<td width=\"30\"> : </td>
						<td width=\"200\">".$DataBarangrt[0]['nama_toko']."</td>
						<td width=\"70\"></td>
						<td width=\"80\">Tanggal</td>
						<td width=\"30\"> : </td>
						<td width=\"100\">".$DataBarangrt[0]['tanggal']."</td>
					</tr>
					<tr>
						<td width=\"70\">Gudang Tujuan</td>
						<td width=\"30\"> : </td>
						<td width=\"200\">DC</td>
						<td width=\"70\"></td>
						<td width=\"80\">No Transaksi</td>
						<td width=\"30\"> : </td>
						<td width=\"100\">".$DataBarangrt[0]['bukti']."</td>
					</tr>
					<tr>
						<td width=\"70\">Keterangan</td>
						<td width=\"30\"> : </td>
						<td width=\"200\">".$DataBarangrt[0]['keterangan']."</td>
						<td width=\"70\"></td>
						<td width=\"80\"></td>
						<td width=\"30\"></td>
						<td width=\"100\"></td>
					</tr>
				  </table><br/><br/>";
		$html .= "<table class=\"content\">
					<thead>
						<tr class=\"border_bottom\">
							<th width=\"20\">No</th>
							<th width=\"70\">Kode Barang</th>
							<th width=\"80\">Barcode</th>
							<th width=\"170\">Nama Barang</th>
							<th width=\"60\" align=\"right\">Qty</th>
							<th width=\"70\" align=\"right\">Harga</th>
							<th width=\"70\" align=\"right\">Jumlah</th>
						</tr>
					</thead>
					<tbody>";
		$inc = 1;
		$TotalHarga = 0;
		foreach($DataBarangrt as $key => $value){
			$html .= "<tr>
						<td width=\"20\">".$inc."</td>
						<td width=\"70\">".$value['barang_kode']."</td>
						<td width=\"80\">".$value['barcode']."</td>
						<td width=\"170\">".$value['nama_barang']."</td>
						<td width=\"60\" align=\"right\">".number_format($value['kwt'],2)."</td>
						<td width=\"70\" align=\"right\">".number_format($value['harga'],2)."</td>
						<td width=\"70\" align=\"right\">".number_format($value['jumlah'],2)."</td>
					  </tr>";
			$inc++;
			$TotalHarga += $value['jumlah'];
		}
		$html .= "<tr class=\"border_top\">
					<td colspan=\"6\"><strong>Total</strong></td>
					<td align=\"right\"><strong>".number_format($TotalHarga, 2)."</strong></td>
					<td></td>
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
		$pdf->Output('ReturToko.pdf', 'I');
	}
}