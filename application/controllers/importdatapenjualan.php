<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Importdatapenjualan extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('syncdata_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('importdatapenjualan');
		$this->load->view('general/footer');
	}
	
	public function importfile(){
		$output_dir = "uploads/";
		
		$valid_formats = array("vmart"); //add the formats you want to upload
		$file = $_FILES['fileupload']['tmp_name']; //get the temporary uploaded excel name 
		$name = $_FILES['fileupload']['name']; //get the name of the excel
		
		if(strlen($name)){
			list($txt, $ext) = explode(".", $name);
			//echo $ext;
			if(in_array($ext, $valid_formats)){
				move_uploaded_file($_FILES["fileupload"]["tmp_name"], $output_dir. $_FILES["fileupload"]["name"]);
				
				$file = $output_dir. $_FILES["fileupload"]["name"];
		
				$myfile = fopen($file, "r") or die("Unable to open file!");
				$TextContent = fread($myfile,filesize($file));
				fclose($myfile);
				
				$Uncompressed = gzuncompress(base64_decode($TextContent));
				$UncompressedArr = explode(";", $Uncompressed);
				
				$this->syncdata_model->StartTransaction();
				for($i=0;$i<sizeof($UncompressedArr);$i++){
					$UncompressedArr[$i] = str_replace(", ,", ", '',", $UncompressedArr[$i]);
					$UncompressedArr[$i] = str_replace("=,", "='',", $UncompressedArr[$i]);
					$this->syncdata_model->ExecuteImportDataToko($UncompressedArr[$i]);
				}
				$this->syncdata_model->CommitTransaction();
				
				// sinkronisasi saldo barang toko
				
				// sinkronisasi saldo barang all
				// sinkronisasi saldo kasbank
				// sinkronisasi saldo piutang
				echo "Import file selesai";
			}else{
				echo "Maaf, format file harus <strong>.vmart</strong>";
			}
		}else{
			echo "Please select file";
		}
		//exit;
	}
}

?>