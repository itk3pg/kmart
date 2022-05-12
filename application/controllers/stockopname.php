<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stockopname extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('stockopname_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('stockopname/home2');
		$this->load->view('general/footer');
	}
	
	public function getdatastockopname(){
		$DataStockopname = $this->stockopname_model->getDatastockopname($_POST);
		
		$html = "<table class=\"table table-striped table-bordered table-hover\" id=\"dataTables-stockopname\">
                    <thead>
                        <tr>
							<th>TOKO</th>
							<th>TANGGAL</th>
							<th>KODE BARANG</th>
							<th>NAMA BARANG</th>
							<th>RAK</th>   
							<th>STOCK SYS PER ITEM</th>
							<th>STOCK OP</th>
							<th>SELISIH PER ITEM</th>
                        </tr>
                    </thead>
                    <tbody>";
		foreach ($DataStockopname as $key => $value) {
			$html .= "<tr data=\"".base64_encode(json_encode($value))."\">
						<td>".$value['toko_kode']."</td>
						<td>".$value['tanggal']."</td>
						<td>".$value['barang_kode']."</td>
						<td>".$value['nama_barang']."</td>
						<td>".$value['rak']."</td>
						<td>".$value['stok_sistem']."</td>
						<td>".$value['stok_opname']."</td>
						<td>".$value['selisih']."</td>
					  </tr>";
		}
		
		$html .= "</tbody>
				</table>";
		echo $html;
	}
	
	public function geteditstockopname(){
		$DataStockopname = $this->stockopname_model->getDatastockopname($_POST);
		
		$html = "<table class=\"table table-striped table-bordered table-hover\" id=\"dataTables-stockopname\">
                    <thead>
                        <tr>
							<th>RAK</th>
							<th>SHLV</th>
							<th>URUT</th>
							<th>BARCODE</th>
                       		<th>NAMA BARANG</th>
							<th>STOK SYS</th>
							<th>STOK OP</th>
							<th>USER</th>
                        </tr>
                    </thead>
                    <tbody>";
		foreach ($DataStockopname as $key => $value) {
			$html .= "<tr data=\"".base64_encode(json_encode($value))."\">
						<td>".$value['rak']."</td>
						<td>".$value['shlv']."</td>
						<td>".$value['urut']."</td>
						<td>".$value['barcode']."</td>
						<td>".$value['nama_barang']."</td>
						<td>".$value['stok_sistem']."</td>
						<td>
							<input type=\"text\" class=\"form-control input-so\" id=\"data_".$value['barcode']."_".$value['bukti']."_".$value['toko_kode']."_".$value['stok_sistem']."_".$value['rak']."_".$value['shlv']."_".$value['urut']."\" value=\"".$value['stok_opname']."\" />
						</td>
						<td>".$value['user_id']."</td>
					  </tr>";
		}
		
		$html .= "</tbody>
				</table>";
		echo $html;
	}

	public function simpanso(){
		$this->stockopname_model->SimpanSO($_POST);
	}
	
	public function simpanstockopname(){
		$dataArr = json_decode(rawurldecode($_POST['data']));
		
		$DataParam = array();
		foreach($dataArr as $key => $value){
			$DataParam['bukti'] = $value[0];
			$DataParam['toko_kode'] = $value[1];
			$DataParam['barang_kode'] = $value[2];
			$DataParam['stok_opname'] = $value[3];
			$DataParam['selisih'] = $value[4];
			$DataParam['rak'] = $value[5];
			$DataParam['shlv'] = $value[6];
			$DataParam['urut'] = $value[7];
			$this->stockopname_model->SimpanStockopname($DataParam);
		}
	}

	public function simpanstockopnamesatu(){
		$dataArr = json_decode(rawurldecode($_POST['data']));
		
		$DataParam = array();
		foreach($dataArr as $key => $value){
			$DataParam['bukti'] = $value[0];
			$DataParam['toko_kode'] = $value[1];
			$DataParam['barang_kode'] = $value[2];
			$DataParam['stok_opname'] = $value[3];
			$DataParam['selisih'] = $value[4];
			$DataParam['rak'] = $value[5];
			$DataParam['shlv'] = $value[6];
			$DataParam['urut'] = $value[7];
			$this->stockopname_model->SimpanStockopname($DataParam);
		}
	}
	
	public function hapusstockopname(){
		$this->stockopname_model->HapusStockopname($_POST);
	}
	
	public function tambahbarang(){
		$this->stockopname_model->TambahBarangStock($_POST);
	}
	
	public function getlistdatabukti(){
		$DataBukti = $this->stockopname_model->getBuktiStockOpname($_POST);
		
		$html = "";
		foreach ($DataBukti as $key => $value) {
			$html .= "<option value='".$value['bukti']."'>".$value['bukti']."</option>";
		}
		
		echo $html;
	}
	
	public function getstoktoko(){
		$DataStock = $this->stockopname_model->getStockToko($_POST);
		
		if(sizeof($DataStock) > 0){
			echo $DataStock[0]['jumlah'];
		}else{
			echo "0";
		}
	}
	
	public function getlistdatarak(){
		$DataRak = $this->stockopname_model->getDataRak($_POST);
		
		$html = "<option value=\"-1\">Semua</option>";
		foreach ($DataRak as $key => $value) {
			$html .= "<option value='".$value['rak']."'>".$value['rak']."</option>";
		}
		
		echo $html;
	}
	
	public function cetakstockopname(){
		//header("Content-type: application/vnd.ms-excel");
		//header("Content-Disposition: attachment;Filename=stockopname_".$_GET['toko_kode']."_".$_GET['bukti']."_".$_GET['rak'].".xls");
		$html = "<style>
				 	table {
				 		font-size: 9px;
				 	}
				 </style>";
				 
		$html .= "<table>
					<tr>
						<td><strong>KOPERASI KARYAWAN KELUARGA BESAR PETROKIMIA GRESIK</strong></td>
						<td align=\"right\"><strong>TGL. : ".date("d-m-Y H:i:s")."</strong></td>
					</tr>
					<tr>
						<td><strong>K-MART</strong></td>
						<td></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"2\"><strong>LAPORAN STOCK OPNAME</strong></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"2\"><strong>BUKTI : ".$_GET['bukti']."</strong></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"2\"><strong>Toko : ".$_GET['nama_toko']." / RAK : ".$_GET['rak']."</strong></td>
					</tr>
				 </table>
				 <br /><br />";
		$DataStockopname = $this->stockopname_model->getDatastockopname($_GET);
		
		
		$html .= "<table border=\"1\">
                    <thead>
                        <tr>
							<th width=\"50px\">RAK</th>
							<th width=\"50px\">SHLV</th>
							<th width=\"50px\">URUT</th>
							<th width=\"90px\">BARCODE</th>
                       		<th width=\"250px\">NAMA BARANG</th>
							<th width=\"50px\">STOK OP</th>
                        </tr>
                    </thead>
                    <tbody>";
		foreach ($DataStockopname as $key => $value) {
			$html .= "<tr data=\"".base64_encode(json_encode($value))."\">
						<td width=\"50px\">".$value['rak']."</td>
						<td width=\"50px\">".$value['shlv']."</td>
						<td width=\"50px\">".$value['urut']."</td>
						<td width=\"90px\">".$value['barcode']."</td>
						<td width=\"250px\">".$value['nama_barang']."</td>
						<td width=\"50px\">".$value['stok_opname']."</td>
					  </tr>";
		}
		
		$html .= "</tbody>
				</table>
				<br /><br />";
				
		$html .= "<table width=\"200px\" border=\"1\">
					<tr>
						<td align=\"center\">Petugas Entri</td>
						<td align=\"center\">Petugas Hitung</td>
					</tr>
					<tr>
						<td height=\"50px\">&nbsp;</td>
						<td height=\"50px\">&nbsp;</td>
					</tr>
					<tr>
						<td align=\"center\">&nbsp;</td>
						<td align=\"center\">&nbsp;</td>
					</tr>
				  </table>";
		
		//echo $html;
		$this->load->library('Pdf');
		
		$pdf = new TCPDF("P", PDF_UNIT, 'A4', true, 'UTF-8', false);
		// Add a page
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->AddPage();
		$pdf->writeHTML($html, true, false, true, false, '');
		$pdf->Output("stockopname_".$_GET['toko_kode']."_".$_GET['bukti']."_".$_GET['rak'].".pdf", 'I');
	}
	
	public function cetakstockopnameexcel(){
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;Filename=stockopname_".$_GET['toko_kode']."_".$_GET['bukti'].".xls");
				 
		$html = "<table>
					<tr>
						<td colspan=\"3\"><strong>KOPERASI KARYAWAN KELUARGA BESAR PETROKIMIA GRESIK</strong></td>
						<td colspan=\"3\" align=\"right\"><strong>TGL. : ".date("d-m-Y H:i:s")."</strong></th>
					</tr>
					<tr>
						<td colspan=\"3\"><strong>K-MART</strong></td>
						<td colspan=\"3\"></th>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"6\"><strong>LAPORAN STOCK OPNAME</strong></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"6\"><strong>BUKTI : ".$_GET['bukti']."</strong></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"6\"><strong>Toko : ".$_GET['nama_toko']."</strong></td>
					</tr>
				 </table>";
		$DataStockopname = $this->stockopname_model->getDatastockopname($_GET);
		
		
		$html = "<table border=\"1\">
                    <thead>
                        <tr>
							<th>TOKO</th>
							<th>TANGGAL</th>
							<th>KODE BARANG</th>
                       		<th>NAMA BARANG</th>
							<th>STOCK SYS</th>
							<th>STOCK OP</th>
							<th>SELISIH</th>
                        </tr>
                    </thead>
                    <tbody>";
		foreach ($DataStockopname as $key => $value) {
			$html .= "<tr data=\"".base64_encode(json_encode($value))."\">
						<td>".$value['toko_kode']."</td>
						<td>".$value['tanggal']."</td>
						<td>".$value['barang_kode']."</td>
						<td>".$value['nama_barang']."</td>
						<td>".$value['stok_sistem']."</td>
						<td>".$value['stok_opname']."</td>
						<td>".$value['selisih']."</td>
					  </tr>";
		}
		
		$html .= "</tbody>
				</table>";
		
		echo $html;
	}

	public function importdata(){
		$output_dir = "uploads/";
		
		$valid_formats = array("txt"); //add the formats you want to upload
		$file = $_FILES['fileupload']['tmp_name']; //get the temporary uploaded excel name 
		$name = $_FILES['fileupload']['name']; //get the name of the excel
		
		if(strlen($name)){
			list($txt, $ext) = explode(".", $name);
			//echo $ext;
			if(in_array($ext, $valid_formats)){
				move_uploaded_file($_FILES["fileupload"]["tmp_name"], $output_dir. $_FILES["fileupload"]["name"]);
				
				$file = $output_dir. $_FILES["fileupload"]["name"];
		
				$myfile = fopen($file, "r") or die("Unable to open file!");

				fseek($myfile, 0);
				while(!feof($myfile)) {
				    $line=fgets($myfile);
				    // echo $line;
					if($line != ""){
						$lineArr = explode(",", $line);
						// print_r($lineArr);
						$this->stockopname_model->SimpanImportData($lineArr, $_POST);
					}
				}
				// $TextContent = fread($myfile,filesize($file));
				fclose($myfile);
				
				echo "Import file selesai";
			}else{
				echo "Maaf, format file harus <strong>.pdam</strong>";
			}
		}else{
			echo "Please select file";
		}
		//exit;
	}

	public function prosesstocksystem(){
		$this->stockopname_model->UpdateStockSystem($_POST);
	}

	public function hapusdatastockopname(){
		$this->stockopname_model->HapusDataStockOpname($_POST);
	}
}

?>