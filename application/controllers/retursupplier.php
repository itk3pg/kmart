<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Retursupplier extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('retursupplier_model');
		$this->load->model('syncsaldo_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('retursupplier/home');
		$this->load->view('general/footer');
	}
	
	public function getdataretursupplier(){
		$DataReturSupplier = $this->retursupplier_model->getDataReturSupplier($_POST);
		
		$bukti = "";
		$html = "<table class=\"table table-striped table-bordered table-hover\" id=\"dataTables-retursupplier\">
                    <thead>
                        <tr>
							<th>BUKTI</th>
                       		<th>TANGGAL</th>
							<th>SUPPLIER</th>
                            <th>BARANG</th>
							<th>SATUAN</th>
                            <th>KWT</th>
                            <th>HARGA</th>
                            <th>PPN</th>
                            <th>JUMLAH</th>
                        </tr>
                    </thead>
                    <tbody>";
		foreach ($DataReturSupplier as $key => $value) {
			$html .= "<tr data=\"".base64_encode(json_encode($value))."\">";
			if($bukti != $value['bukti']){
				$html .= "<td>".$value['bukti']."</td>
						  <td>".$value['tanggal']."</td>
						  <td>".$value['nama_supplier']."</td>";
				$bukti = $value['bukti'];
			}else{
				$html .= "<td></td>
						  <td></td>
						  <td></td>";
			}
			$html .= "	<td>".$value['nama_barang']."</td>
						<td>".$value['satuan']."</td>
						<td align='right'>".$value['kwt']."</td>
						<td align='right'>".number_format($value['harga'],2)."</td>
						<td align='right'>".number_format($value['ppn'],2)."</td>
						<td align='right'>".number_format($value['jumlah'],2)."</td>
					  </tr>";
		}
		
		$html .= "</tbody>
				</table>";
		echo $html;
	}
	
	public function listpilihretursupplier(){
		$DataReturSupplier = $this->retursupplier_model->getDataListReturSupplier($_POST);
		
		$bukti = "";
		$html = "<table class=\"table table-striped table-bordered table-hover\" id=\"dataTables-retursupplier\">
                    <thead>
                        <tr>
							<th>BUKTI</th>
                       		<th>TANGGAL</th>
							<th>SUPPLIER</th>
							<th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>";
		foreach ($DataReturSupplier as $key => $value) {
			$html .= "<tr>
						<td>".$value['bukti']."</td>
						<td>".$value['tanggal']."</td>
						<td>".$value['nama_supplier']."</td>
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
	
	public function simpanretursupplier(){
		if($_POST['kwt'] > 0){
			$_POST['supplier_kode'] = base64_decode($_POST['supplier_kode']);
			$this->retursupplier_model->SimpanReturSupplier($_POST);
			
			// $TglArr = explode('-', $_POST['tanggal']);
			// $ParamSync = array();
			// $ParamSync['bulan'] = $TglArr[1];
			// $ParamSync['tahun'] = $TglArr[0];
			// $ParamSync['barang_kode'] = $_POST['barang_kode'];
			// $ParamSync['toko_kode'] = $_POST['toko_kode'];
			// $this->syncsaldo_model->SyncSaldoBarangGudangUtamaSpesifik($ParamSync);
		}
	}
	
	public function hapusretursupplier(){
		$this->retursupplier_model->HapusReturSupplier($_POST);
	}

	public function syncstokretursupplier(){
		$DataRetur = $this->retursupplier_model->getAllDataRetur($_POST);
		foreach ($DataRetur as $key => $value) {
			$TglArr = explode('-', $value['tanggal']);
			$ParamSync = array();
			$ParamSync['bulan'] = $TglArr[1];
			$ParamSync['tahun'] = $TglArr[0];
			$ParamSync['barang_kode'] = $value['barang_kode'];
			$this->syncsaldo_model->SyncSaldoBarangGudangUtamaSpesifik($ParamSync);
		}
	}
	
	public function getdatabarangretursupplier(){
		$DataBarangot = $this->retursupplier_model->getDataBarangReturSupplier($_POST);
		
		$html = "";
		foreach ($DataBarangot as $key => $value) {
			$html .= "<tr>
						<td>".$value['barang_kode']."</td>
						<td>".$value['nama_barang']."</td>
						<td id=\"kwt_".$value['barang_kode']."\" class=\"text-right\">".$value['kwt']."</td>
						<td id=\"harga_".$value['barang_kode']."\" class=\"text-right\">".round($value['harga'] + $value['ppn'],2)."</td>
						<td id=\"ppn_".$value['barang_kode']."\" class=\"text-right\">".round($value['ppn'],2)."</td>
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
							<!--<button type=\"button\" style=\"padding: 1px 5px;\" onclick=\"Editkwt('".$value['barang_kode']."', '".$this->db->escape_str($value['nama_barang'])."', '".$value['kwt']."')\" class=\"btn btn-warning btn-sm\">
								<i class=\"fa fa-edit\"></i>
							</button>-->
							<button type=\"button\" style=\"padding: 1px 6px;\" onclick=\"HapusRow(this)\" class=\"btn btn-danger btn-sm\"><i class=\"fa fa-times\"></i></button>
						</td>
					</tr>";
		}
		
		echo $html;
	}
	
	public function getdatabarangsupplier(){
		$DataBarangSupplier = $this->retursupplier_model->getDataBarangSupplier($_POST);
		
		$html = "";
		foreach ($DataBarangSupplier as $key => $value) {
			$value['ppn'] = 0;
			if($value['pkp'] == "1"){
				$dpp = round(($value['harga']/1.11),2); //k3pg-ppn
				$value['ppn'] = $dpp * 0.11; //k3pg-ppn
			}
			$html .= "<tr>
						<td>".$value['kode']."</td>
						<td>".$value['nama_barang']."</td>
						<td>".$value['satuan']."</td>
						<td id=\"kwt_".$value['kode']."\" class=\"text-right\">0</td>
						<td id=\"harga_".$value['kode']."\" class=\"text-right\">".number_format($value['harga'],2, ",", ".")."</td>
						<td id=\"ppn_".$value['kode']."\" class=\"text-right\">".number_format($value['ppn'],2, ",", ".")."</td>
						<td id=\"jumlah_".$value['kode']."\" class=\"text-right\">".number_format(0,2, ",", ".")."</td>
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
							<button type=\"button\" style=\"padding: 1px 5px;\" onclick=\"Editkwt('".$value['kode']."', '".$this->db->escape_str($value['nama_barang'])."', '0')\" class=\"btn btn-warning btn-sm\">
								<i class=\"fa fa-edit\"></i>
							</button>
							<button type=\"button\" style=\"padding: 1px 6px;\" onclick=\"HapusRow(this)\" class=\"btn btn-danger btn-sm\"><i class=\"fa fa-times\"></i></button>
						</td>
					</tr>";
		}
		
		echo $html;
	}
	
	public function getrekapretursupplier(){
		$DataReturSupplier = $this->retursupplier_model->getRekapReturSupplier($_POST);
		
		$html = "";
		foreach($DataReturSupplier as $key => $value){
			$html .= "<tr>
						<td>".$value['bukti']."</td>
						<td>".$value['tanggal']."</td>
						<td class=\"text-right\">".number_format($value['jumlah'],2)."</td>";
			if(isset($_POST['supplier_kode'])){
				$html .= "<td>
							<button type=\"button\" style=\"padding: 1px 6px;\" onclick=\"HapusRow(this)\" class=\"btn btn-danger btn-sm\"><i class=\"fa fa-times\"></i></button>
						</td>";
			}else{
				$html .= "<td></td>";
			}
			$html .= "</tr>";
		}
		
		echo $html;
	}
	
	public function cetakretursupplier(){
		$DataBarangReturSupplier = $this->retursupplier_model->getDataBarangReturSupplier($_GET);
		
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
						<td align=\"right\">Retur Supplier</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				  </table><br/><br/>";
		$html .= "<table>
					<tr>
						<td width=\"70\">Supplier</td>
						<td width=\"30\"> : </td>
						<td width=\"200\">".$DataBarangReturSupplier[0]['nama_supplier']."</td>
						<td width=\"70\"></td>
						<td width=\"80\">Tanggal</td>
						<td width=\"30\"> : </td>
						<td width=\"100\">".$DataBarangReturSupplier[0]['tanggal']."</td>
					</tr>
					<tr>
						<td width=\"70\">Uraian</td>
						<td width=\"30\"> : </td>
						<td width=\"200\">Retur Supplier</td>
						<td width=\"70\"></td>
						<td width=\"80\">No Transaksi</td>
						<td width=\"30\"> : </td>
						<td width=\"100\">".$DataBarangReturSupplier[0]['bukti']."</td>
					</tr>
				  </table><br/><br/>";
		$html .= "<table class=\"content\">
					<thead>
						<tr class=\"border_bottom\">
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
		$TotalHarga = 0;
		$TotalPPN = 0;
		$TotalTransaksi = 0;
		foreach($DataBarangReturSupplier as $key => $value){
			$html .= "<tr>
						<td width=\"20\">".$inc."</td>
						<td width=\"80\">".$value['barang_kode']."</td>
						<td width=\"150\">".$value['nama_barang']."</td>
						<td width=\"40\" align=\"right\">".number_format($value['kwt'],2)."</td>
						<td width=\"35\">".$value['satuan']."</td>
						<td width=\"80\" align=\"right\">".number_format($value['harga'] + $value['ppn'],2)."</td>
						<td width=\"100\" align=\"right\">".number_format($value['jumlah'],2)."</td>
					  </tr>";
			$inc++;
			$TotalHarga += ($value['harga'] * $value['kwt']);
			$TotalPPN += ($value['ppn'] * $value['kwt']);
			$TotalTransaksi += $value['jumlah'];
		}
		$html .= "<tr class=\"border_top\">
					<td colspan=\"6\" align=\"center\"><strong>Total</strong></td>
					<td align=\"right\"><strong>".number_format($TotalTransaksi, 2)."</strong></td>
				  </tr>";
		$html .= "</tbody></table><br/><br/><br/>";
		
		$html .= "<table>
					<tr>
						<td align=\"center\">Yang menerima</td>
						<td colspan=\"2\" align=\"center\">Mengetahui, </td>
						<td align=\"center\">Yang menyerahkan</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td align=\"center\">-----------------------------</td>
						<td align=\"center\">-----------------------------</td>
						<td align=\"center\">-----------------------------</td>
						<td align=\"center\">-----------------------------</td>
					</tr>
					<tr>
						<td align=\"center\">&nbsp;</td>
						<td align=\"center\">Kabid. Toko</td>
						<td align=\"center\">Kaunit. Can & Gud</td>
						<td align=\"center\">&nbsp;</td>
					</tr>
				  </table>";

		$this->load->library('Pdf');
		
		$pdf = new TCPDF("P", PDF_UNIT, 'A4', true, 'UTF-8', false);
		// Add a page
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->AddPage();
		$pdf->writeHTML($html, true, false, true, false, '');
		$pdf->Output('ReturSupplier.pdf', 'I');
	}

	public function getlaprekapretursupplier(){
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

		$DataPembelianBarang = $this->retursupplier_model->getLapRekapReturSupplier($_GET);
		
		$html .= "<table>
					<tr>
						<td colspan=\"6\" align=\"center\">Rekap Harian Retur Supplier</td>
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
							<th width=\"130\">Kode Supplier</th>
							<th align=\"left\" width=\"55\">Supplier</th>
                            <th align=\"right\">DPP</th>
                            <th align=\"right\">PPN</th>
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
							<td align=\"right\"><strong>".number_format($TotalDPP, 2)."</strong></td>
							<td align=\"right\"><strong>".number_format($TotalPPn, 2)."</strong></td>
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
						<td>".$value['supplier_kode']."</td>
						<td width=\"130\">".$value['nama_supplier']."</td>
						<td align=\"right\">".number_format($value['dpp'], 2)."</td>
						<td align=\"right\">".number_format($value['ppn'], 2)."</td>
						<td align=\"right\">".number_format($value['jumlah'], 2)."</td>
					  </tr>";
			$inc++;
			$TotalDPP += $value['dpp'];
	        $TotalPPn += $value['ppn'];
	        $TotalJumlah += $value['jumlah'];
	        $TotalDPPAll += $value['dpp'];
	        $TotalPPnAll += $value['ppn'];
	        $TotalJumlahAll += $value['jumlah'];
		}
		$html .= "<tr class=\"border_top\">
					<td colspan=\"5\">Sub Total</td>
					<td align=\"right\"><strong>".number_format($TotalDPP, 2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalPPn, 2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalJumlah, 2)."</strong></td>
				  </tr>
				  <tr class=\"border_top\">
					<td colspan=\"5\">Total</td>
					<td align=\"right\"><strong>".number_format($TotalDPPAll, 2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalPPnAll, 2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalJumlahAll, 2)."</strong></td>
				  </tr>";

		$html .= "</tbody></table><br/><br/>";

		$DataKelompokPembelianBarang = $this->retursupplier_model->getRekapKelompokReturSupplier($_GET);
		$html .= "<table width=\"30%\">";
		$TotalAll = 0;
		foreach ($DataKelompokPembelianBarang as $key => $value) {
			$html .= "<tr>
						<td>(".$value['kategori'].") ".$value['nama']."</td>
						<td align=\"right\">".number_format($value['jumlah'])."</td>
					  </tr>";
			$TotalAll += $value['jumlah'];
		}
		$html .= "<tr>
					<td>Total</td>
					<td align=\"right\"><strong>".number_format($TotalJumlahAll)."</strong></td>
				  </tr>";
					
		$html .= "</table>";
		
		$this->load->library('Pdf');
		
		$pdf = new TCPDF("P", PDF_UNIT, 'A4', true, 'UTF-8', false);
		// Add a page
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->AddPage();
		$pdf->writeHTML($html, true, false, true, false, '');
		$pdf->Output('RekapHarianReturSupplier.pdf', 'I');
	}

	public function getlaprekapretursupplier_xls(){
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;Filename=rekap_harian_rs_".$_GET['tanggal_awal'].".xls");
		
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

		$DataPembelianBarang = $this->retursupplier_model->getLapRekapReturSupplier($_GET);
		
		$html .= "<table>
					<tr>
						<td colspan=\"6\" align=\"center\">Rekap Harian Retur Supplier</td>
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
							<th width=\"130\">Kode Supplier</th>
							<th align=\"left\" width=\"55\">Supplier</th>
                            <th align=\"right\">DPP</th>
                            <th align=\"right\">PPN</th>
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
							<td align=\"right\"><strong>".number_format($TotalDPP, 2)."</strong></td>
							<td align=\"right\"><strong>".number_format($TotalPPn, 2)."</strong></td>
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
						<td>".$value['supplier_kode']."</td>
						<td width=\"130\">".$value['nama_supplier']."</td>
						<td align=\"right\">".number_format($value['dpp'], 2)."</td>
						<td align=\"right\">".number_format($value['ppn'], 2)."</td>
						<td align=\"right\">".number_format($value['jumlah'], 2)."</td>
					  </tr>";
			$inc++;
			$TotalDPP += $value['dpp'];
	        $TotalPPn += $value['ppn'];
	        $TotalJumlah += $value['jumlah'];
	        $TotalDPPAll += $value['dpp'];
	        $TotalPPnAll += $value['ppn'];
	        $TotalJumlahAll += $value['jumlah'];
		}
		$html .= "<tr class=\"border_top\">
					<td colspan=\"5\">Sub Total</td>
					<td align=\"right\"><strong>".number_format($TotalDPP, 2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalPPn, 2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalJumlah, 2)."</strong></td>
				  </tr>
				  <tr class=\"border_top\">
					<td colspan=\"5\">Total</td>
					<td align=\"right\"><strong>".number_format($TotalDPPAll, 2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalPPnAll, 2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalJumlahAll, 2)."</strong></td>
				  </tr>";

		$html .= "</tbody></table><br/><br/>";

		$DataKelompokPembelianBarang = $this->retursupplier_model->getRekapKelompokReturSupplier($_GET);
		$html .= "<table width=\"30%\">";
		$TotalAll = 0;
		foreach ($DataKelompokPembelianBarang as $key => $value) {
			$html .= "<tr>
						<td>(".$value['kategori'].") ".$value['nama']."</td>
						<td align=\"right\">".number_format($value['jumlah'])."</td>
					  </tr>";
			$TotalAll += $value['jumlah'];
		}
		$html .= "<tr>
					<td>Total</td>
					<td align=\"right\"><strong>".number_format($TotalJumlahAll)."</strong></td>
				  </tr>";
					
		$html .= "</table>";

		echo $html;
	}
}