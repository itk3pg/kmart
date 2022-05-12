<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ordertransfer extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('ordertransfer_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('ordertransfer/home');
		$this->load->view('general/footer');
	}
	
	public function getdataot(){
		$Dataot = $this->ordertransfer_model->getDataOT($_POST);
		
		$bukti = "";
		$html = "<table class=\"table table-striped table-bordered table-hover\" id=\"dataTables-ot\">
                    <thead>
                        <tr>
							<th>BUKTI</th>
                       		<th>TANGGAL</th>
							<th>TOKO</th>
							<th>KODE BARANG</th>
                            <th>BARANG</th>
                            <th>STOK DC</th>
                            <th>KWT</th>
                            <th>HPP</th>
                            <th>JUMLAH</th>
							<th>SATUAN</th>
                        </tr>
                    </thead>
                    <tbody>";
		foreach ($Dataot as $key => $value) {
			$html .= "<tr data=\"".base64_encode(json_encode($value))."\">";
			if($bukti != $value['bukti']){
				$html .= "<td>".$value['bukti']."</td>
						  <td>".$value['tanggal']."</td>
						  <td>".$value['nama_toko']."</td>";
				$bukti = $value['bukti'];
			}else{
				$html .= "<td></td>
						  <td></td>
						  <td></td>";
			}
			$html .= "	<td>".$value['barang_kode']."</td>
						<td>".$value['nama_barang']."</td>
						<td align='right'>".$value['stok_dc']."</td>
						<td align='right'>".$value['kwt']."</td>
						<td align='right'>".number_format($value['harga'], 2)."</td>
						<td align='right'>".number_format($value['jumlah'], 2)."</td>
						<td align='right'>".$value['satuan']."</td>
					  </tr>";
		}
		
		$html .= "</tbody>
				</table>";
		echo $html;
	}
	
	public function listpilihot(){
		$Dataot = $this->ordertransfer_model->getDataListOT($_POST);
		
		$bukti = "";
		$html = "<table class=\"table table-striped table-bordered table-hover\" id=\"dataTables-ot\">
                    <thead>
                        <tr>
							<th>BUKTI</th>
                       		<th>TANGGAL</th>
							<th>TOKO</th>
							<th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>";
		foreach ($Dataot as $key => $value) {
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
	
	public function simpanot(){
		if($_POST['kwt'] > 0){
			$this->ordertransfer_model->SimpanOT($_POST);
		}
	}
	
	public function hapusot(){
		$this->ordertransfer_model->HapusOT($_POST);
	}

	public function fixot(){
		$this->ordertransfer_model->FixOT($_POST);
	}
	
	public function getdatabarangot(){
		$DataBarangot = $this->ordertransfer_model->getDataBarangOT($_POST);
		
		$html = "";
		foreach ($DataBarangot as $key => $value) {
			$html .= "<tr>
						<td>".$value['barang_kode']."</td>
						<td>".$value['nama_barang']."</td>
						<td>".$value['satuan']."</td>
						<td class=\"text-right\">".$value['stok_dc']."</td>
						<td id=\"kwt_".$value['barang_kode']."\" class=\"text-right\">".$value['kwt']."</td>
						<td id=\"harga_".$value['barang_kode']."\" class=\"text-right\">".$value['harga']."</td>
						<td id=\"jumlah_".$value['barang_kode']."\" class=\"text-right\">".$value['jumlah']."</td>
						<td class=\"text-center\">
							<!--<button type=\"button\" style=\"padding: 1px 5px;\" onclick=\"Editkwt('".$value['barang_kode']."')\" class=\"btn btn-warning btn-sm\">
								<i class=\"fa fa-edit\"></i>
							</button>-->
							<input type='text' style='width: 80px; text-align: right; float: left; display: none;' class='form-control' id='kwt_edit_".$value['barang_kode']."' name='kwt_edit_".$value['barang_kode']."' />
							<button id='btn_cancel_edit_kwt_".$value['barang_kode']."' onclick=\"CancelEditkwt('".$value['barang_kode']."')\" name='btn_cancel_edit_kwt_".$value['barang_kode']."' type=\"button\" style=\"padding: 6px 5px; float: left; display: none;\" class=\"btn btn-danger btn-sm\">
								<i class=\"fa fa-times\"></i>
							</button>
							<button id='btn_edit_kwt_".$value['barang_kode']."' onclick=\"SimpanEditKwt('".$value['barang_kode']."')\" name='btn_edit_kwt_".$value['barang_kode']."' type=\"button\" style=\"padding: 6px 5px; float: left; display: none;\" class=\"btn btn-success btn-sm\">
								<i class=\"fa fa-check\"></i>
							</button>
							<button type=\"button\" onclick=\"HapusRow(this)\" style=\"padding: 1px 5px;\" class=\"btn btn-danger btn-sm\"><i class=\"fa fa-times\"></i></button>
						</td>
					</tr>";
		}
		
		echo $html;
	}
	
	public function getdatabarangottg(){
		$DataBarangot = $this->ordertransfer_model->getDataBarangOT($_POST);
		
		$html = "";
		foreach ($DataBarangot as $key => $value) {
			$html .= "<tr>
						<td>".$value['barang_kode']."</td>
						<td>".$value['nama_barang']."</td>
						<td id=\"kwt_".$value['barang_kode']."\" class=\"text-right\">".$value['kwt']."</td>
						<td id=\"harga_".$value['barang_kode']."\" class=\"text-right\">".$value['harga']."</td>
						<td id=\"jumlah_".$value['barang_kode']."\" class=\"text-right\">".$value['jumlah']."</td>
						<td>".$value['satuan']."</td>
						<td class=\"text-center\">
							<button type=\"button\" onclick=\"openFormEditKWT('".$value['barang_kode']."', '".$value['kwt']."')\" class=\"btn btn-warning btn-sm\"><i class=\"fa fa-edit\"></i></button>
							<button type=\"button\" onclick=\"HapusRow(this)\" class=\"btn btn-danger btn-sm\"><i class=\"fa fa-times\"></i></button>
						</td>
					</tr>";
		}
		
		echo $html;
	}
	
	public function getdatabarangotlast(){
		$DataBarangot = $this->ordertransfer_model->getDataBarangOTLast($_POST);
		
		$html = "";
		foreach ($DataBarangot as $key => $value) {
			$html .= "<tr>
						<td>".$value['barang_kode']."</td>
						<td>".$value['nama_barang']."</td>
						<td>".$value['satuan']."</td>
						<td></td>
						<td id=\"kwt_".$value['barang_kode']."\" class=\"text-right\">".$value['kwt']."</td>
						<td id=\"harga_".$value['barang_kode']."\" class=\"text-right\">".$value['harga']."</td>
						<td id=\"jumlah_".$value['barang_kode']."\" class=\"text-right\">".$value['jumlah']."</td>
						<td class=\"text-center\">
							<!--<button type=\"button\" style=\"padding: 1px 5px;\" onclick=\"Editkwt('".$value['barang_kode']."')\" class=\"btn btn-warning btn-sm\">
								<i class=\"fa fa-edit\"></i>
							</button>-->
							<input type='text' style='width: 80px; text-align: right; float: left; display: none;' class='form-control' id='kwt_edit_".$value['barang_kode']."' name='kwt_edit_".$value['barang_kode']."' />
							<button id='btn_cancel_edit_kwt_".$value['barang_kode']."' onclick=\"CancelEditkwt('".$value['barang_kode']."')\" name='btn_cancel_edit_kwt_".$value['barang_kode']."' type=\"button\" style=\"padding: 6px 5px; float: left; display: none;\" class=\"btn btn-danger btn-sm\">
								<i class=\"fa fa-times\"></i>
							</button>
							<button id='btn_edit_kwt_".$value['barang_kode']."' onclick=\"SimpanEditKwt('".$value['barang_kode']."')\" name='btn_edit_kwt_".$value['barang_kode']."' type=\"button\" style=\"padding: 6px 5px; float: left; display: none;\" class=\"btn btn-success btn-sm\">
								<i class=\"fa fa-check\"></i>
							</button>
							<button type=\"button\" onclick=\"HapusRow(this)\" style=\"padding: 1px 5px;\" class=\"btn btn-danger btn-sm\"><i class=\"fa fa-times\"></i></button>
						</td>
					</tr>";
		}
		
		echo $html;
	}
	
	public function getdatabarangsupplier(){
		$DataBarangSupplier = $this->ordertransfer_model->getDataBarangSupplier($_POST);
		
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
		$DataSaldo = $this->ordertransfer_model->getSaldoBarangTokoDC($_POST);
		
		if(isset($DataSaldo['VO0006'])){
			echo $DataSaldo['VO0006'];
		}else{
			echo 0;
		}
	}
	
	public function listpilihotlast(){
		$Dataot = $this->ordertransfer_model->getDataListOTLast();
		
		$bukti = "";
		$html = "<table class=\"table table-striped table-bordered table-hover\" id=\"dataTables-ot\">
                    <thead>
                        <tr>
							<th>BUKTI</th>
                       		<th>TANGGAL</th>
							<th>TOKO</th>
							<th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>";
		foreach ($Dataot as $key => $value) {
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
	
	public function cetakot(){
		$DataBarangot = $this->ordertransfer_model->getDataBarangOTCetak($_GET);
		
		$tambahan = "";
		if(isset($_GET['cetak'])){
			$tambahan = "letter-spacing: 2px;";
		}

		$html = "<style>
				 	table {
				 		font-size: 8px;
				 		".$tambahan."
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
				 		border-right:0.5pt dashed black;
					}

					tr.border_content td {
						border-right:0.5pt dashed black;
					}
				 </style>";
		$html .= "<table width=\"100%\">
					<tr>
						<td><strong>Koperasi karyawan Keluarga Besar Petrokimia Gresik</strong></td>
						<td align=\"right\">Order Transfer Toko (OT)</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				  </table>";
		$Status = "Draft";
		if($DataBarangot[0]['is_approve'] == "1"){
			$Status = "Approved";
		}
		$html .= "<table width=\"100%\">
					<tr>
						<td width=\"100\">Gudang Asal</td>
						<td width=\"30\"> : </td>
						<td width=\"200\">DC</td>
						<td width=\"40\"></td>
						<td width=\"80\">Tanggal</td>
						<td width=\"30\"> : </td>
						<td width=\"100\">".$DataBarangot[0]['tanggal']."</td>
					</tr>
					<tr>
						<td width=\"100\">Gudang Tujuan</td>
						<td width=\"30\"> : </td>
						<td width=\"200\">".$DataBarangot[0]['nama_toko']."</td>
						<td width=\"40\"></td>
						<td width=\"80\">No Transaksi</td>
						<td width=\"30\"> : </td>
						<td width=\"100\">".$DataBarangot[0]['bukti']."</td>
					</tr>
					<tr>
						<td width=\"100\">Uraian</td>
						<td width=\"30\"> : </td>
						<td width=\"200\">Order Transfer Toko (OT)</td>
						<td width=\"40\"></td>
						<td width=\"80\">PIC</td>
						<td width=\"30\"> : </td>
						<td width=\"100\">".$DataBarangot[0]['pic']."</td>
					</tr>
				  </table><br/><br/>";
		$html .= "<table class=\"content\">
					<thead>
						<tr class=\"border_bottom\">
							<th width=\"20\"><strong>No</strong></th>
							<th width=\"40\"><strong>Kode</strong></th>
							<th width=\"70\"><strong>Barcode</strong></th>
							<th width=\"130\"><strong>Nama Barang</strong></th>
							<th width=\"40\" align=\"right\"><strong>Realisasi</strong></th>
							<th width=\"25\" align=\"right\"><strong>Qty</strong></th>
							<th width=\"70\" align=\"right\"><strong>Harga Nota</strong></th>
							<th width=\"60\" align=\"right\"><strong>Jumlah</strong></th>
							<th width=\"30\" align=\"right\"><strong>Stok DC</strong></th>
							<th width=\"30\" align=\"right\"><strong>Stok Toko</strong></th>
							<th width=\"50\" align=\"right\"><strong>Harga Jual</strong></th>
						</tr>
					</thead>
					<tbody>";
		$inc = 1;
		$Total = 0;
		foreach($DataBarangot as $key => $value){
			$html .= "<tr class=\"border_content\">
						<td width=\"20\">".$inc."</td>
						<td width=\"40\">".$value['barang_kode']."</td>
						<td width=\"70\">".$value['barcode']."</td>
						<td width=\"130\">".$value['nama_barang']."</td>
						<td width=\"40\" align=\"right\">&nbsp;</td>
						<td width=\"25\" align=\"right\">".$value['kwt']."</td>
						<td width=\"70\" align=\"right\">".number_format($value['harga'],2)."</td>
						<td width=\"60\" align=\"right\">".number_format($value['jumlah'],2)."</td>
						<td width=\"30\" align=\"right\">".$value['stok_dc']."</td>
						<td width=\"30\" align=\"right\">".$value['stok_toko']."</td>
						<td width=\"50\" align=\"right\">".number_format($value['harga_jual'],2)."</td>
					  </tr>";
			$inc++;
			$Total += $value['jumlah'];
		}
		$html .= "<tr class=\"border_top\">
					<td width=\"20\"></td>
					<td width=\"40\"><strong>TOTAL</strong></td>
					<td width=\"70\"></td>
					<td width=\"130\"></td>
					<td width=\"40\" align=\"right\"></td>
					<td width=\"25\" align=\"right\"></td>
					<td width=\"70\" align=\"right\"></td>
					<td width=\"60\" align=\"right\"><strong>".number_format($Total,2)."</strong></td>
					<td width=\"30\" align=\"right\">&nbsp;</td>
					<td width=\"30\" align=\"right\">&nbsp;</td>
					<td width=\"50\" align=\"right\">&nbsp;</td>
				  </tr>";
		$html .= "</tbody></table><br/><br/>";
		$html .= "<table width=\"70%\">
					<tr>
						<td colspan=\"2\" align=\"center\">Peminta,</td>
						<td>&nbsp;</td>
						<td align=\"center\">Mengetahui,</td>
					</tr>
					<tr>
						<td colspan=\"2\">&nbsp;</td>
						<td colspan=\"2\">&nbsp;</td>
					</tr>
					<tr>
						<td colspan=\"2\">&nbsp;</td>
						<td colspan=\"2\">&nbsp;</td>
					</tr>
					<tr>
						<td colspan=\"2\">&nbsp;</td>
						<td colspan=\"2\">&nbsp;</td>
					</tr>
					<tr>
						<td align=\"center\">------------------</td>
						<td align=\"center\">------------------</td>
						<td align=\"center\">&nbsp;</td>
						<td align=\"center\">------------------</td>
					</tr>
					<tr>
						<td align=\"center\">Koordinator</td>
						<td align=\"center\">Ka. Unit Toko</td>
						<td align=\"center\">&nbsp;</td>
						<td align=\"center\">Ka. Bid Toko</td>
					</tr>
					<tr>
						<td colspan=\"2\">&nbsp;</td>
						<td colspan=\"2\">&nbsp;</td>
					</tr>
					<tr>
						<td align=\"center\">&nbsp;</td>
						<td align=\"center\">Yang Menyerahkan,</td>
						<td align=\"center\" colspan=\"2\">Yang Menerima,</td>
					</tr>
					<tr>
						<td colspan=\"2\">&nbsp;</td>
						<td colspan=\"2\">&nbsp;</td>
					</tr>
					<tr>
						<td colspan=\"2\">&nbsp;</td>
						<td colspan=\"2\">&nbsp;</td>
					</tr>
					<tr>
						<td colspan=\"2\">&nbsp;</td>
						<td colspan=\"2\">&nbsp;</td>
					</tr>
					<tr>
						<td align=\"center\">&nbsp;</td>
						<td align=\"center\">------------------</td>
						<td align=\"center\">------------------</td>
						<td align=\"center\">------------------</td>
					</tr>
					<tr>
						<td align=\"center\">&nbsp;</td>
						<td align=\"center\">Ka. Unit Candal Gud</td>
						<td align=\"center\">Koordinator</td>
						<td align=\"center\">Ka. Unit Toko</td>
					</tr>
				  </table>";
		// echo $html;
		$this->load->library('Pdf');
		
		$pdf = new TCPDF("P", PDF_UNIT, 'A4', true, 'UTF-8', false);
		// Add a page
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->AddPage();
		$pdf->writeHTML($html, true, false, true, false, '');
		$pdf->Output('OrderTransfer.pdf', 'I');
	}

	// public function cetakotplain(){
	// 	$DataBarangot = $this->ordertransfer_model->getDataBarangOT($_GET);
		
	// 	$html = "<style>
	// 			 	table {
	// 			 		font-size: 9px;
	// 			 	}
	// 			 </style>";
	// 	$html .= "<table width=\"100%\">
	// 				<tr>
	// 					<td><strong>Koperasi karyawan Keluarga Besar Petrokimia Gresik</strong></td>
	// 					<td align=\"right\">Order Transfer Toko (OT)</td>
	// 				</tr>
	// 				<tr>
	// 					<td>Jl. ..... Petrokimia Gresik</td>
	// 					<td>&nbsp;</td>
	// 				</tr>
	// 			  </table><br/><br/>";
	// 	$Status = "Draft";
	// 	if($DataBarangot[0]['is_approve'] == "1"){
	// 		$Status = "Approved";
	// 	}
	// 	$html .= "<table width=\"100%\">
	// 				<tr>
	// 					<td width=\"100\">Gudang Asal</td>
	// 					<td width=\"30\"> : </td>
	// 					<td width=\"200\">DC</td>
	// 					<td width=\"40\"></td>
	// 					<td width=\"80\">Tanggal</td>
	// 					<td width=\"30\"> : </td>
	// 					<td width=\"100\">".$DataBarangot[0]['tanggal']."</td>
	// 				</tr>
	// 				<tr>
	// 					<td width=\"100\">Gudang Tujuan</td>
	// 					<td width=\"30\"> : </td>
	// 					<td width=\"200\">".$DataBarangot[0]['nama_toko']."</td>
	// 					<td width=\"40\"></td>
	// 					<td width=\"80\">No Transaksi</td>
	// 					<td width=\"30\"> : </td>
	// 					<td width=\"100\">".$DataBarangot[0]['bukti']."</td>
	// 				</tr>
	// 				<tr>
	// 					<td width=\"100\">Uraian</td>
	// 					<td width=\"30\"> : </td>
	// 					<td width=\"200\">Order Transfer Toko (OT)</td>
	// 					<td width=\"40\"></td>
	// 					<td width=\"80\">PIC</td>
	// 					<td width=\"30\"></td>
	// 					<td width=\"100\">".$DataBarangot[0]['pic']."</td>
	// 				</tr>
	// 			  </table><br/><br/>";
	// 	$html .= "<table width=\"100%\">
	// 				<thead>
	// 					<tr>
	// 						<th width=\"20\"><strong>No</strong></th>
	// 						<th width=\"80\"><strong>Kode Barang</strong></th>
	// 						<th width=\"120\"><strong>Nama Barang</strong></th>
	// 						<th width=\"30\" align=\"right\"><strong>KWT</strong></th>
	// 						<th width=\"70\" align=\"right\"><strong>Harga</strong></th>
	// 						<th width=\"80\" align=\"right\"><strong>Jumlah</strong></th>
	// 						<th width=\"40\"><strong>Satuan</strong></th>
	// 						<th width=\"60\" align=\"left\"><strong>Rak</strong></th>
	// 						<th width=\"30\" align=\"left\"><strong>Shlv</strong></th>
	// 						<th width=\"30\" align=\"left\"><strong>Urut</strong></th>
	// 					</tr>
	// 				</thead>
	// 				<tbody>";
	// 	$inc = 1;
	// 	$Total = 0;
	// 	foreach($DataBarangot as $key => $value){
	// 		$html .= "<tr>
	// 					<td width=\"20\">".$inc."</td>
	// 					<td width=\"80\">".$value['barang_kode']."</td>
	// 					<td width=\"120\">".$value['nama_barang']."</td>
	// 					<td width=\"30\" align=\"right\">".$value['kwt']."</td>
	// 					<td width=\"70\" align=\"right\">".number_format($value['harga'],2)."</td>
	// 					<td width=\"80\" align=\"right\">".number_format($value['jumlah'],2)."</td>
	// 					<td width=\"40\">".$value['satuan']."</td>
	// 					<td width=\"60\" align=\"left\">".$value['rak']."</td>
	// 					<td width=\"30\" align=\"left\">".$value['shlv']."</td>
	// 					<td width=\"30\" align=\"left\">".$value['urut']."</td>
	// 				  </tr>";
	// 		$inc++;
	// 		$Total += $value['jumlah'];
	// 	}
	// 	$html .= "<tr>
	// 				<td width=\"20\"></td>
	// 				<td width=\"80\"><strong>TOTAL</strong></td>
	// 				<td width=\"120\"></td>
	// 				<td width=\"30\" align=\"right\"></td>
	// 				<td width=\"70\" align=\"right\"></td>
	// 				<td width=\"80\" align=\"right\"><strong>".number_format($Total,2)."</strong></td>
	// 				<td width=\"40\"></td>
	// 				<td width=\"60\" align=\"right\">&nbsp;</td>
	// 				<td width=\"30\" align=\"right\">&nbsp;</td>
	// 				<td width=\"30\" align=\"right\">&nbsp;</td>
	// 			  </tr>";
	// 	$html .= "</tbody></table><br/><br/><br/><br/>";
	// 	$html .= "<table border=\"1\" width=\"200\">
	// 				<tr>
	// 					<td width=\"100\" align=\"center\">Pembuat</td>
	// 				</tr>
	// 				<tr>
	// 					<td width=\"100\">&nbsp;<br/></td>
	// 				</tr>
	// 			  </table>";

	// 	echo $html;
	// 	exit;
	// }

	public function cetakdataot(){
		$Dataot = $this->ordertransfer_model->getDataOT($_GET);
		
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;Filename=order_transfer_".$_GET['tanggal_awal']."_".$_GET['tanggal_akhir'].".xls");
		
		$html = "<table>
					<tr>
						<td colspan=\"5\"><strong>KOPERASI KARYAWAN KELUARGA BESAR PETROKIMIA GRESIK</strong></td>
						<td align=\"right\" colspan=\"3\"><strong>TGL. : ".date("d-m-Y H:i:s")."</strong></th>
					</tr>
					<tr>
						<td colspan=\"5\"><strong>K-MART</strong></td>
						<td colspan=\"3\"></th>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"8\"><strong>Data Order Transfer (OT)</strong></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"8\"><strong>PERIODE : ".$_GET['tanggal_awal']." / ".$_GET['tanggal_akhir']."</strong></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"8\"><strong>Toko / Unit : ".$_GET['nama_toko']."</strong></td>
					</tr>
				 </table>";

		$bukti = "";
		$html .= "<table border=\"1\">
                    <thead>
                        <tr>
							<th>BUKTI</th>
                       		<th>TANGGAL</th>
							<th>TOKO</th>
                            <th>BARANG</th>
                            <th>KWT</th>
                            <th>HPP</th>
                            <th>JUMLAH</th>
							<th>SATUAN</th>
                        </tr>
                    </thead>
                    <tbody>";
		foreach ($Dataot as $key => $value) {
			$html .= "<tr data=\"".base64_encode(json_encode($value))."\">";
			if($bukti != $value['bukti']){
				$html .= "<td>".$value['bukti']."</td>
						  <td>".$value['tanggal']."</td>
						  <td>".$value['nama_toko']."</td>";
				$bukti = $value['bukti'];
			}else{
				$html .= "<td></td>
						  <td></td>
						  <td></td>";
			}
			$html .= "	<td>".$value['nama_barang']."</td>
						<td align='right'>".$value['kwt']."</td>
						<td align='right'>".number_format($value['harga'], 2)."</td>
						<td align='right'>".number_format($value['jumlah'], 2)."</td>
						<td align='right'>".$value['satuan']."</td>
					  </tr>";
		}
		
		$html .= "</tbody>
				</table>";
		echo $html;
	}

	public function getrekapordertransfer(){
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

		$DataPembelianBarang = $this->ordertransfer_model->getRekapOrderTransfer($_GET);
		
		$html .= "<table>
					<tr>
						<td colspan=\"6\" align=\"center\">Rekap Harian Order Transfer</td>
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
							<th align=\"left\" width=\"55\">Toko</th>
                            <th align=\"right\">Total</th>
                            <th>&nbsp;</th>
                            <th>Realisasi</th>
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
			$Realisasi = "Belum";
			if($value['is_approve'] == "1"){
				$Realisasi = "Sudah";
			}
			if($tanggal != $value['tanggal']){
				$html .= "<tr class=\"border_top\">
							<td colspan=\"4\">Sub Total</td>
							<td align=\"right\"><strong>".number_format($TotalJumlah, 2)."</strong></td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
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
						<td width=\"55\">".$value['nama_toko']."</td>
						<td align=\"right\">".number_format($value['jumlah'], 2)."</td>
						<td>&nbsp;</td>
						<td>".$Realisasi."</td>
					  </tr>";
			$inc++;
	        $TotalJumlah += $value['jumlah'];
	        $TotalJumlahAll += $value['jumlah'];
		}
		$html .= "<tr class=\"border_top\">
					<td colspan=\"4\">Sub Total</td>
					<td align=\"right\"><strong>".number_format($TotalJumlah, 2)."</strong></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				  </tr>
				  <tr class=\"border_top\">
					<td colspan=\"4\">Total</td>
					<td align=\"right\"><strong>".number_format($TotalJumlahAll, 2)."</strong></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				  </tr>";

		$html .= "</tbody></table><br/><br/>";

		$DataKelompokPembelianBarang = $this->ordertransfer_model->getRekapKelompokOrderTransfer($_GET);
		
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
		$pdf->Output('RekapHarianOrderTransfer.pdf', 'I');
	}

	public function getrekapordertransfer_xls(){
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;Filename=rekap_harian_ot_".$_GET['tanggal_awal'].".xls");
		
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

		$DataPembelianBarang = $this->ordertransfer_model->getRekapOrderTransfer($_GET);
		
		$html .= "<table>
					<tr>
						<td colspan=\"6\" align=\"center\">Rekap Harian Order Transfer</td>
					</tr>
					<tr>
						<td colspan=\"6\" align=\"center\">".$_GET['tanggal_awal']." / ".$_GET['tanggal_akhir']."</td>
					</tr>
					<tr>
						<td colspan=\"6\" align=\"center\"></td>
					</tr>
				 </table>";

		$html .= "<table border=\"1\">
                    <thead>
                        <tr class=\"border_bottom\">
                       		<th width=\"15\" align=\"right\">No</th>
                       		<th>Tanggal</th>
							<th>Bukti</th>
							<th align=\"left\" width=\"55\">Toko</th>
                            <th align=\"right\">Total</th>
                            <th>&nbsp;</th>
                            <th>Realisasi</th>
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
			$Realisasi = "Belum";
			if($value['is_approve'] == "1"){
				$Realisasi = "Sudah";
			}
			if($tanggal != $value['tanggal']){
				$html .= "<tr class=\"border_top\">
							<td colspan=\"4\">Sub Total</td>
							<td align=\"right\"><strong>".number_format($TotalJumlah, 2)."</strong></td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
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
						<td width=\"55\">".$value['nama_toko']."</td>
						<td align=\"right\">".number_format($value['jumlah'], 2)."</td>
						<td>&nbsp;</td>
						<td>".$Realisasi."</td>
					  </tr>";
			$inc++;
	        $TotalJumlah += $value['jumlah'];
	        $TotalJumlahAll += $value['jumlah'];
		}
		$html .= "<tr class=\"border_top\">
					<td colspan=\"4\">Sub Total</td>
					<td align=\"right\"><strong>".number_format($TotalJumlah, 2)."</strong></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				  </tr>
				  <tr class=\"border_top\">
					<td colspan=\"4\">Total</td>
					<td align=\"right\"><strong>".number_format($TotalJumlahAll, 2)."</strong></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				  </tr>";

		$html .= "</tbody></table><br/><br/>";

		$DataKelompokPembelianBarang = $this->ordertransfer_model->getRekapKelompokOrderTransfer($_GET);
		
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