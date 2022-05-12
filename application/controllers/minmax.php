<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Minmax extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('minmax_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('master/minmax');
		$this->load->view('general/footer');
	}
	
	public function getdataminmax(){
		$DataMinmax = $this->minmax_model->getDataMinmax($_POST);
		
		$html = "<table class=\"table table-striped table-bordered table-hover\" id=\"dataTables-minmax\">
                    <thead>
                        <tr>
							<th>KODE BARANG</th>
							<th>BARCODE</th>
                       		<th>NAMA BARANG</th>
							<th>MIN</th>
							<th>MAX</th>
							<th>MINOR</th>
                        </tr>
                    </thead>
                    <tbody>";
		foreach ($DataMinmax as $key => $value) {
			$html .= "<tr data=\"".base64_encode(json_encode($value))."\">
						<td>".$value['barang_kode']."</td>
						<td>".$value['barcode']."</td>
						<td>".$value['nama_barang']."</td>
						<td>".$value['min']."</td>
						<td>".$value['max']."</td>
						<td>".$value['minor']."</td>
					  </tr>";
		}
		
		$html .= "</tbody>
				</table>";
		echo $html;
	}
	
	public function simpanimportminmax(){
		$dataArr = json_decode(rawurldecode($_POST['data']));

		for($index=0;$index<sizeof($dataArr);$index = $index + 5){
			$_POST['barang_kode'] = str_replace("'","",$dataArr[$index]);
			$_POST['min'] = $dataArr[$index+2];
			$_POST['max'] = $dataArr[$index+3];
			$_POST['minor'] = $dataArr[$index+4];
			$this->minmax_model->SimpanMinmax($_POST);
		}
	}
	
	public function hapusminmax(){
		$this->minmax_model->HapusMinmax($_POST);
	}
	
	public function cetakminmax(){
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;Filename=minmax_".$_GET['toko_kode'].".xls");
		
		$DataMinmax = $this->minmax_model->getDataMinmax($_GET);
		
		$html = "<table border=\"1\">
                    <thead>
                        <tr>
							<th>KODE BARANG</th>
							<th>BARCODE</th>
                       		<th>NAMA BARANG</th>
							<th>MIN</th>
							<th>MAX</th>
							<th>MINOR</th>
                        </tr>
                    </thead>
                    <tbody>";
		foreach ($DataMinmax as $key => $value) {
			$html .= "<tr data=\"".base64_encode(json_encode($value))."\">
						<td>".$value['barang_kode']."</td>
						<td>".$value['barcode']."</td>
						<td>".$value['nama_barang']."</td>
						<td>".$value['min']."</td>
						<td>".$value['max']."</td>
						<td>".$value['minor']."</td>
					  </tr>";
		}
		
		$html .= "</tbody>
				</table>";
		echo $html;
	}

	public function importminmax(){
		$this->load->library('excel');
		// $output_dir = "/opt/lampp/htdocs/vmart/uploads/";
		$output_dir = "uploads/";
		
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
		$DataHarga = array();
		//$this->kupon_model->truncateDump();
		$index = 0;
		// echo "highestRow : ".$highestRow;
		// echo "highestColumn : ".$highestColumn;
		// exit();
		for ($row = 2; $row <= $highestRow; $row++) {
			$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
			// print_r($rowData);exit();
			if($rowData[0][1] != ""){
				$DataHarga[$index]['barang_kode'] = str_replace("'", "", $rowData[0][0]);
				$DataHarga[$index]['nama_barang'] = $rowData[0][1];
				$DataHarga[$index]['min'] = $rowData[0][2];
				$DataHarga[$index]['max'] = $rowData[0][3];
				$DataHarga[$index]['minor'] = $rowData[0][4];

				$index++;
			}
		}

		echo base64_encode(json_encode($DataHarga));
	}
}

?>