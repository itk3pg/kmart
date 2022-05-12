<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
ini_set('max_execution_time', 0);
class Orderpembelian extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('orderpembelian_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('op/home');
		$this->load->view('general/footer');
	}

	public function import(){
		$this->load->library('excel');
		// $output_dir = "/var/www/vmart/uploads/";
		$output_dir = HOME_DIR."uploads/";
		
		$valid_formats = array("xls"); //add the formats you want to upload
		$file = $_FILES['fileupload']['tmp_name']; //get the temporary uploaded excel name 
		$name = $_FILES['fileupload']['name']; //get the name of the excel
		
		if(strlen($name)){
			list($txt, $ext) = explode(".", $name);
			//echo $ext;
			if(in_array($ext, $valid_formats)){
				move_uploaded_file($_FILES["fileupload"]["tmp_name"], $output_dir. $_FILES["fileupload"]["name"]);
			}else{
				echo "Maaf, format file harus <strong>.xls</strong>";
			}
		}else{
			echo "Please select file";
		}
		//exit;
		$file = $output_dir. $_FILES["fileupload"]["name"];
		
		$Reader = PHPExcel_IOFactory::createReaderForFile($file);
		$Reader->setReadDataOnly(true);
		$objXLS = $Reader->load($file);
		$sheet = $objXLS->getSheet(0);
		$highestRow = $sheet->getHighestRow();
		$highestColumn = $sheet->getHighestColumn();
		$DataOP = array();
		//$this->kupon_model->truncateDump();
		$index = 0;
		for ($row = 2; $row <= $highestRow; $row++) {
			$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
			if($rowData[0][1] != ""){
				$DataOP[$index]['barang_kode'] = str_replace("'", "", $rowData[0][1]);
				$DataOP[$index]['nama_barang'] = $rowData[0][2];
				$DataOP[$index]['satuan'] = $rowData[0][3];
				$DataOP[$index]['kwt'] = $rowData[0][5];
				if($rowData[0][8] == "0"){ // non ppn
					$DataOP[$index]['harga'] = $rowData[0][6];
				}else{
					$DataOP[$index]['harga'] = ($rowData[0][6] / 1.11); //k3pg-ppn
				}
				$DataOP[$index]['ppn'] = $rowData[0][8];
				$DataOP[$index]['jumlah'] = ($DataOP[$index]['harga'] * $DataOP[$index]['kwt']);
				$DataOP[$index]['total'] = $rowData[0][7];

				$index++;
			}
		}

		echo base64_encode(json_encode($DataOP));
	}
	
	public function getdataop(){
		$Dataop = $this->orderpembelian_model->getDataOP($_POST);
		
		$bukti = "";
		$html = "<table class=\"table table-striped table-bordered table-hover\" id=\"dataTables-op\">
                    <thead>
                        <tr>
							<th>BUKTI</th>
                       		<th>TANGGAL</th>
							<th>SUPPLIER</th>
                            <th colspan=\"2\">BARANG</th>
							<th>SATUAN</th>
                            <th>KWT</th>
                            <th>HARGA</th>
                            <th>PPN</th>
                            <th>JUMLAH</th>
                        </tr>
                    </thead>
                    <tbody>";
		foreach ($Dataop as $key => $value) {
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
			$html .= "	<td>".$value['barang_kode']."</td>
						<td>".$value['nama_barang']."</td>
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
	
	public function simpanop(){
		if($_POST['jumlah'] > 0){
			$_POST['supplier_kode'] = base64_decode($_POST['supplier_kode']);
			$this->orderpembelian_model->SimpanOP($_POST);
		}
	}
	
	public function hapusop(){
		$this->orderpembelian_model->HapusOP($_POST);
	}
	
	public function getdatabarangop(){
		$DataBarangop = $this->orderpembelian_model->getDataBarangEditOP($_POST);
		
		$html = "";
		foreach ($DataBarangop as $key => $value) {
			$JumlahSebelumPajak = $value['harga'] * $value['kwt'];
			$ppn = $value['ppn'];
			$html .= "<tr>
						<td>".$value['barang_kode']."</td>
						<td>".$value['nama_barang']."</td>
						<td>".$value['satuan']."</td>
						<td id=\"saldo_akhir_ket_".$value['barang_kode']."\" class=\"text-right\">".$value['saldo_akhir_kwt']."</td>
						<td id=\"kwt_op_".$value['barang_kode']."\" class=\"text-right\">".$value['kwt']."</td>
						<td id=\"kwt_".$value['barang_kode']."\" class=\"text-right\">".$value['kwt']."</td>
						<td id=\"harga_".$value['barang_kode']."\" class=\"text-right\">".$value['harga_asli']."</td>
						<td id=\"harga_".$value['barang_kode']."\" class=\"text-right\">".$value['diskon1']."</td>
						<td id=\"jumlah_".$value['barang_kode']."\" class=\"text-right\">".$JumlahSebelumPajak."</td>
						<td id=\"ppn_".$value['barang_kode']."\" class=\"text-right\">".$ppn."</td>
						<td id=\"total_".$value['barang_kode']."\" class=\"text-right\">".$value['jumlah']."</td>
						<td class=\"text-center\">
							<button type=\"button\" style=\"padding: 1px 5px;\" onclick=\"Editkwt('".base64_encode(json_encode($value))."')\" class=\"btn btn-warning btn-sm\">
								<i class=\"fa fa-edit\"></i>
							</button>
							<button type=\"button\" style=\"padding: 1px 6px;\" onclick=\"HapusRow(this)\" class=\"btn btn-danger btn-sm\"><i class=\"fa fa-times\"></i></button>
						</td>
					</tr>";
		}
		
		echo $html;
	}
	
	public function getdatabarangsupplier(){
		$DataBarangSupplier = $this->orderpembelian_model->getDataBarangSupplier($_POST);
		
		$html = "";
		foreach ($DataBarangSupplier as $key => $value) {
			$ppn = 0;
			if($value['pkp'] == "1"){
				$ppn = $value['harga'] * 0.11; //k3pg-ppn
			}
			$html .= "<tr>
						<td>".$value['kode']."</td>
						<td>".$value['nama_barang']."</td>
						<td>".$value['satuan']."</td>
						<td id=\"saldo_akhir_ket_".$value['kode']."\" class=\"text-right\">".$value['saldo_akhir_kwt']."</td>
						<td id=\"kwt_".$value['kode']."\" class=\"text-right\">".$value['kwt']."</td>
						<td id=\"harga_".$value['kode']."\" class=\"text-right\">".$value['harga']."</td>
						<td id=\"diskon1_".$value['kode']."\" class=\"text-right\">".$value['diskon1']."</td>
						<td id=\"jumlah_".$value['kode']."\" class=\"text-right\">0</td>
						<td id=\"ppn_".$value['kode']."\" class=\"text-right\">".$ppn."</td>
						<td id=\"total_".$value['kode']."\" class=\"text-right\">0</td>
						<td class=\"text-center\">
							<button type=\"button\" style=\"padding: 1px 5px;\" onclick=\"Editkwt('".$value['kode']."', '".$this->db->escape_str($value['nama_barang'])."', '".$value['kwt']."', '".$value['diskon1']."')\" class=\"btn btn-warning btn-sm\">
								<i class=\"fa fa-edit\"></i>
							</button>
							<button type=\"button\" style=\"padding: 1px 6px;\" onclick=\"HapusRow(this)\" class=\"btn btn-danger btn-sm\"><i class=\"fa fa-times\"></i></button>
						</td>
					</tr>";
		}
		
		echo $html;
	}
	
	public function getdatabarangeditop(){
		$DataBarangSupplier = $this->orderpembelian_model->getDataBarangEditOP($_POST);
		
		$html = "";
		foreach ($DataBarangSupplier as $key => $value) {
			$JumlahSebelumPajak = $value['harga'] * $value['kwt'];
			$ppn = $value['ppn'];
			$html .= "<tr>
						<td>".$value['barang_kode']."</td>
						<td>".$value['nama_barang']."</td>
						<td>".$value['satuan']."</td>
						<td id=\"saldo_akhir_ket_".$value['barang_kode']."\" class=\"text-right\">".$value['saldo_akhir_kwt']."</td>
						<td id=\"kwt_".$value['barang_kode']."\" class=\"text-right\">".$value['kwt']."</td>
						<td id=\"harga_".$value['barang_kode']."\" class=\"text-right\">".$value['harga_asli']."</td>
						<td id=\"harga_".$value['barang_kode']."\" class=\"text-right\">".$value['diskon1']."</td>
						<td id=\"jumlah_".$value['barang_kode']."\" class=\"text-right\">".$JumlahSebelumPajak."</td>
						<td id=\"ppn_".$value['barang_kode']."\" class=\"text-right\">".$ppn."</td>
						<td id=\"total_".$value['barang_kode']."\" class=\"text-right\">".$value['jumlah']."</td>
						<td class=\"text-center\">
							<button type=\"button\" style=\"padding: 1px 5px;\" onclick=\"Editkwt('".$value['barang_kode']."', '".$this->db->escape_str($value['nama_barang'])."', '".$value['kwt']."', '".$value['diskon1']."')\" class=\"btn btn-warning btn-sm\">
								<i class=\"fa fa-edit\"></i>
							</button>
							<button type=\"button\" style=\"padding: 1px 6px;\" onclick=\"HapusRow(this)\" class=\"btn btn-danger btn-sm\"><i class=\"fa fa-times\"></i></button>
						</td>
					</tr>";
		}
		
		echo $html;
	}
	
	public function listpilihop(){
		$_POST['supplier_kode'] = base64_decode($_POST['supplier_kode']);
		$Dataod = $this->orderpembelian_model->getDataListOP($_POST);
		
		$bukti = "";
		$html = "<table class=\"table table-striped table-bordered table-hover\" id=\"dataTables-od\">
                    <thead>
                        <tr>
							<th>BUKTI</th>
                       		<th>TANGGAL</th>
							<th>SUPPLIER</th>
							<th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>";
		foreach ($Dataod as $key => $value) {
			$html .= "<tr>
						<td>".$value['bukti']."</td>
						<td>".$value['tanggal']."</td>
						<td>".$value['nama_supplier']."</td>
						<td align=\"center\">
							<button id=\"btn_pilih\" class=\"btn btn-info btn-sm\" type=\"button\" onclick=\"PilihOP('".$value['bukti']."')\">
								<i class=\"fa fa-check\"></i>
							</button>
						</td>
					  </tr>";
		}
		
		$html .= "</tbody>
				</table>";
		echo $html;
	}
	
	public function gethargabeli(){
		$DataHargaSupplier = $this->orderpembelian_model->getHargaBarangSupplier($_POST);
		
		$harga = 0;
		if(sizeof($DataHargaSupplier) > 0){
			$harga = $DataHargaSupplier[0]['harga'];
		}
		
		echo $harga;
	}
	
	public function getstokdc(){
		$DataStokDC = $this->orderpembelian_model->getStokDC($_POST);
		
		$saldo_kwt = 0;
		if(sizeof($DataStokDC) > 0){
			$saldo_kwt = $DataStokDC[0]['saldo_akhir_kwt'];
		}
		
		echo $saldo_kwt;
	}

	public function getrekaporderpembelian(){
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

		$DataPembelianBarang = $this->orderpembelian_model->getRekapOrderPembelian($_GET);
		
		$html .= "<table>
					<tr>
						<td colspan=\"6\" align=\"center\">Rekap Harian Order Pembelian</td>
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

		$DataKelompokPembelianBarang = $this->orderpembelian_model->getRekapKelompokOrderPembelian($_GET);
		
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
		$pdf->Output('RekapHarianOrderPembelian.pdf', 'I');
	}

	public function getrekaporderpembelian_xls(){
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;Filename=rekap_harian_op_".$_GET['tanggal_awal'].".xls");

		$html = "<table>
					<tr>
						<td><strong>Koperasi karyawan Keluarga Besar Petrokimia Gresik</strong></td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td align=\"right\">".date('d-m-Y H:m:s')."</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				  </table>";

		$DataPembelianBarang = $this->orderpembelian_model->getRekapOrderPembelian($_GET);
		
		$html .= "<table>
					<tr>
						<td colspan=\"8\" align=\"center\">Rekap Harian Order Pembelian</td>
					</tr>
					<tr>
						<td colspan=\"8\" align=\"center\">".$_GET['tanggal_awal']." / ".$_GET['tanggal_akhir']."</td>
					</tr>
					<tr>
						<td colspan=\"8\" align=\"center\"></td>
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

		$DataKelompokPembelianBarang = $this->orderpembelian_model->getRekapKelompokOrderPembelian($_GET);
		
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
	
	public function cetakbarangsupplier(){
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;Filename=Barang_Supplier_".$_GET['supplier_kode'].".xls");
		
		$DataBarangSupplier = $this->orderpembelian_model->getDataBarangSupplier($_GET);
		
		$html = "<table>
					<thead>
						<tr>
							<th>Kode Barang</th>
							<th>Nama Barang</th>
							<th>Satuan</th>
							<th>Saldo Barang DC</th>
							<th>Saldo Barang Tuban</th>
							<th>Harga</th>
						</tr>
					</thead>
					<tbody>";
		foreach ($DataBarangSupplier as $key => $value) {
			$html .= "<tr>
						<td>".$value['kode']."</td>
						<td>".$value['nama_barang']."</td>
						<td>".$value['satuan']."</td>
						<td class=\"text-right\">".$value['saldo_akhir_kwt']."</td>
						<td class=\"text-right\">".$value['saldo_akhir_kwt_tuban']."</td>
						<td class=\"text-right\">".$value['harga']."</td>
					</tr>";
		}
		$html .= "</tbody>
				</table>";
		
		echo $html;
	}
	
	public function cetakpp(){
		$DataBarangOP = $this->orderpembelian_model->getDataBarangCetak($_GET);
		
		$html = "<style>
				 	table {
				 		font-size: 7.5px;
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
						<td align=\"right\">Permintaan Pembelian</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				  </table>";
		$html .= "<table>
					<tr>
						<td width=\"70\">Supplier</td>
						<td width=\"30\"> : </td>
						<td width=\"200\">".$DataBarangOP[0]['nama_supplier']."</td>
						<td width=\"70\"></td>
						<td width=\"80\">Tanggal</td>
						<td width=\"30\"> : </td>
						<td width=\"100\">".$DataBarangOP[0]['tanggal']."</td>
					</tr>
					<tr>
						<td width=\"70\">Uraian</td>
						<td width=\"30\"> : </td>
						<td width=\"200\">Permintaan Pembelian</td>
						<td width=\"70\"></td>
						<td width=\"80\">No Transaksi</td>
						<td width=\"30\"> : </td>
						<td width=\"100\">".$DataBarangOP[0]['bukti']."</td>
					</tr>
				  </table><br/><br/>";
		$html .= "<table class=\"content\">
					<thead>
						<tr class=\"border_bottom\">
							<th width=\"15\"><strong>No</strong></th>
							<th width=\"40\"><strong>Kode</strong></th>
							<th width=\"125\"><strong>Nama Barang</strong></th>
							<th width=\"60\" align=\"right\"><strong>Harga</strong></th>
							<th width=\"35\" align=\"right\"><strong>Minta</strong></th>
							<th width=\"60\" align=\"right\"><strong>Total</strong></th>
							<th width=\"35\" align=\"right\"><strong>Saldo Gudang</strong></th>
							<th width=\"30\" align=\"right\"><strong>Saldo Toko 1</strong></th>
							<th width=\"30\" align=\"right\"><strong>Saldo Toko 2</strong></th>
							<th width=\"30\" align=\"right\"><strong>Saldo Toko 3</strong></th>
							<th width=\"30\" align=\"right\"><strong>Bulan Ke 1</strong></th>
							<th width=\"30\" align=\"right\"><strong>Bulan Ke 2</strong></th>
							<th width=\"30\" align=\"right\"><strong>Bulan Ke 3</strong></th>
							<th width=\"30\" align=\"right\"><strong>Bulan Skrg</strong></th>
						</tr>
					</thead>
					<tbody>";
		$inc = 1;
		$TotalHarga = 0;
		$TotalPPN = 0;
		$TotalTransaksi = 0;
		foreach($DataBarangOP as $key => $value){
			$DateArr = explode("-", $DataBarangOP[0]['tanggal']);
			$Paramget = array();
			$Paramget['bulan'] = $DateArr[1] - 3;
			if($Paramget['bulan'] <= 0){
				$Paramget['tahun'] = $DateArr[0] - 1;
				$Paramget['bulan'] = 12 - $Paramget['bulan'];
			}else{
				$Paramget['tahun'] = $DateArr[0];
			}
			$Paramget['barang_kode'] = $value['barang_kode'];
			$Bulanke3 = $this->orderpembelian_model->getJumlahBarangJual($Paramget);

			$Paramget['bulan'] = $DateArr[1] - 2;
			if($Paramget['bulan'] <= 0){
				$Paramget['tahun'] = $DateArr[0] - 1;
				$Paramget['bulan'] = 12 - $Paramget['bulan'];
			}else{
				$Paramget['tahun'] = $DateArr[0];
			}
			$Bulanke2 = $this->orderpembelian_model->getJumlahBarangJual($Paramget);

			$Paramget['bulan'] = $DateArr[1] - 1;
			if($Paramget['bulan'] <= 0){
				$Paramget['tahun'] = $DateArr[0] - 1;
				$Paramget['bulan'] = 12 - $Paramget['bulan'];
			}else{
				$Paramget['tahun'] = $DateArr[0];
			}
			$Bulanke1 = $this->orderpembelian_model->getJumlahBarangJual($Paramget);

			$Paramget['bulan'] = $DateArr[1];
			$Paramget['tahun'] = $DateArr[0];
			$Bulankeskr = $this->orderpembelian_model->getJumlahBarangJual($Paramget);

			$JumlahHarga = ($value['harga'] + $value['ppn']) * $value['kwt'];
			$html .= "<tr>
						<td width=\"15\">".$inc."</td>
						<td width=\"40\">".$value['barang_kode']."</td>
						<td width=\"125\">".$value['nama_barang']."</td>
						<td width=\"60\" align=\"right\">".number_format(($value['harga'] + $value['ppn']),2)."</td>
						<td width=\"35\" align=\"right\">".number_format($value['kwt'],2)."</td>
						<td width=\"60\" align=\"right\">".number_format($JumlahHarga,2)."</td>
						<td width=\"35\" align=\"right\">".number_format($value['saldo_gudang'])."</td>
						<td width=\"30\" align=\"right\">".number_format($value['saldo_toko1'])."</td>
						<td width=\"30\" align=\"right\">".number_format($value['saldo_toko2'])."</td>
						<td width=\"30\" align=\"right\">".number_format($value['saldo_toko3'])."</td>
						<td width=\"30\" align=\"right\">".number_format($Bulanke1)."</td>
						<td width=\"30\" align=\"right\">".number_format($Bulanke2)."</td>
						<td width=\"30\" align=\"right\">".number_format($Bulanke3)."</td>
						<td width=\"30\" align=\"right\">".number_format($Bulankeskr)."</td>
					  </tr>";
			$inc++;
			$TotalTransaksi += $JumlahHarga;
		}
		$html .= "<tr class=\"border_top\">
					<td colspan=\"5\"><strong>Total</strong></td>
					<td align=\"right\"><strong>".number_format($TotalTransaksi, 2)."</strong></td>
					<td colspan=\"8\">&nbsp;</td>
				  </tr>";
		$html .= "</tbody></table>
				  <br/><br/><br/><br/>";
		
		$html .= "<table>
					<tr>
						<td align=\"center\">Mengetahui,</td>
						<td align=\"center\">Yang Mengajukan,</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td align=\"center\">---------------------</td>
						<td align=\"center\">------------------</td>
					</tr>
					<tr>
						<td align=\"center\">Mgr. Operasional III</td>
						<td align=\"center\">Kabid. Toko</td>
					</tr>
				  </table>";
		// echo $html; exit;
		$this->load->library('Pdf');
		
		$pdf = new TCPDF("P", PDF_UNIT, 'A4', true, 'UTF-8', false);
		// Add a page
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->SetMargins(5, 5, 5, true);
		$pdf->AddPage();
		$pdf->writeHTML($html, true, false, true, false, '');
		$pdf->Output('PermintaanPembelian.pdf', 'I');
	}

	public function cetakop(){
		$DataBarangOP = $this->orderpembelian_model->getDataBarangCetakop($_GET);
		
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
						<td align=\"right\">Surat Pesanan Pembelian</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				  </table>";
		$html .= "<table>
					<tr>
						<td width=\"70\">Supplier</td>
						<td width=\"30\"> : </td>
						<td width=\"200\">".$DataBarangOP[0]['nama_supplier']."</td>
						<td width=\"70\"></td>
						<td width=\"80\">Tanggal</td>
						<td width=\"30\"> : </td>
						<td width=\"100\">".date('d-m-Y')."</td>
					</tr>
					<tr>
						<td width=\"70\">Uraian</td>
						<td width=\"30\"> : </td>
						<td width=\"200\">Surat Pesanan Pembelian</td>
						<td width=\"70\"></td>
						<td width=\"80\">No Transaksi</td>
						<td width=\"30\"> : </td>
						<td width=\"100\">".$DataBarangOP[0]['bukti']."</td>
					</tr>
				  </table><br/><br/>";
		$html .= "<table class=\"content\">
					<thead>
						<tr class=\"border_bottom\">
							<th width=\"20\"><strong>No</strong></th>
							<th width=\"50\"><strong>Kode</strong></th>
							<th width=\"200\"><strong>Nama Barang</strong></th>
							<th width=\"70\" align=\"right\"><strong>Jumlah Pesanan Dalam Satuan</strong></th>
							<th width=\"200\" align=\"center\"><strong>Keterangan</strong></th>
						</tr>
					</thead>
					<tbody>";
		$inc = 1;
		foreach($DataBarangOP as $key => $value){
			$html .= "<tr>
						<td width=\"20\">".$inc."</td>
						<td width=\"50\">".$value['barang_kode']."</td>
						<td width=\"200\">".$value['nama_barang']."</td>
						<td width=\"70\" align=\"right\">".$value['kwt']."</td>
						<td width=\"200\" align=\"center\">&nbsp;</td>
					  </tr>";
			$inc++;
		}
		$html .= "</tbody></table>
				  <br/><br/><br/><br/>";
		
		$html .= "<table>
					<tr>
						<td align=\"center\">Gresik, ".date('d-m-Y')."</td>
						<td align=\"center\">Pemasok,</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td align=\"center\">------------------</td>
						<td align=\"center\">------------------</td>
					</tr>
					<tr>
						<td align=\"center\">Mgr. Operasional IV</td>
						<td align=\"center\">&nbsp;</td>
					</tr>
				  </table>";
		// echo $html; exit;
		$this->load->library('Pdf');
		
		$pdf = new TCPDF("P", PDF_UNIT, 'A4', true, 'UTF-8', false);
		// Add a page
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->SetMargins(5, 5, 5, true);
		$pdf->AddPage();
		$pdf->writeHTML($html, true, false, true, false, '');
		$pdf->Output('OrderPembelian.pdf', 'I');
	}
}