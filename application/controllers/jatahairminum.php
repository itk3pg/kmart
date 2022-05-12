<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jatahairminum extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('jatahairminum_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('jatahairminum/home');
		$this->load->view('general/footer');
	}
	
	public function getdatajatahairminum(){
		$DataHutang = $this->jatahairminum_model->getDataAirMinum($_POST);
		
		$html = "<table class=\"table table-striped table-bordered table-hover\" id=\"dataTables-jatahairminum\">
                    <thead>
                        <tr>
                       		<th>Bulan</th>
                       		<th>Tahun</th>
                            <th>No Pegawai</th>
                            <th>Nama Pegawai</th>
                            <th>Kode Unit Kerja</th>
                            <th>Nama Unit Kerja</th>
                            <th>Jumlah Hari</th>
                            <th>Jumlah Botol</th>
                        </tr>
                    </thead>
                    <tbody>";
		foreach ($DataHutang as $key => $value) {
			$JumlahBotol = $value['jumlah_hari'] * 2;
			$html .= "<tr>
						<td>".$value['bulan']."</td>
						<td>".$value['tahun']."</td>
						<td>".$value['no_pegawai']."</td>
						<td>".$value['nama_pegawai']."</td>
						<td>".$value['kode_unit_kerja']."</td>
						<td>".$value['nama_unit_kerja']."</td>
						<td>".$value['jumlah_hari']."</td>
						<td>".$JumlahBotol."</td>
					  </tr>";
		}
		$html .= "</tbody>
				</table>";
		echo $html;
	}
	
	public function getjumlahhari(){
		$DataHutang = $this->jatahairminum_model->getJumlahDataAirMinum($_POST);
		$result = "0_0";
		foreach ($DataHutang as $key => $value) {
			$result = $value['jumlah_hari']."_".$value['jumlah_botol'];
		}
		
		echo $result;
	}
	
	public function upload(){
		$this->load->library('excel');
		$output_dir = "jatahairminum/";
		
		$valid_formats = array("xls"); //add the formats you want to upload
		if(!isset($_FILES['fileupload'])){
			echo "Pilih filenya terliebih dahulu";
			exit;
		}
		$file = $_FILES['fileupload']['tmp_name']; //get the temporary uploaded excel name 
		$name = $_FILES['fileupload']['name']; //get the name of the excel
		
		if(strlen($name)){
			list($txt, $ext) = explode(".", $name);
			//echo $ext;
			if(in_array($ext, $valid_formats)){
				move_uploaded_file($_FILES["fileupload"]["tmp_name"], $output_dir. $_FILES["fileupload"]["name"]);
			}else{
				echo "Maaf, format file harus <strong>.xls</strong>";
				exit;
			}
		}else{
			echo "Pilih filenya terliebih dahulu";
			exit;
		}
		//exit;
		$file = $output_dir. $_FILES["fileupload"]["name"];
		
		$Reader = PHPExcel_IOFactory::createReaderForFile($file);
		$Reader->setReadDataOnly(true);
		$objXLS = $Reader->load($file);
		$sheet = $objXLS->getSheet(0);
		$highestRow = $sheet->getHighestRow();
		$highestColumn = $sheet->getHighestColumn();
		//$this->kupon_model->truncateDump();
		for ($row = 2; $row <= $highestRow; $row++) {
			$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
			$this->jatahairminum_model->SimpanJatahAirMinum($_POST, $rowData[0]);
		}
	}
}
