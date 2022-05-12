<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Barang extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('barang_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('master/barang');
		$this->load->view('general/footer');
	}

	public function generatekodebarang(){
		$kodebarang = $this->barang_model->generateKodeBarang($_POST);
		
		echo $kodebarang;
	}
	
	public function getdatabarang(){
		$DataBarang = $this->barang_model->getDataBarang($_POST);
		/*for($i=0;$i<sizeof($DataBarang);$i++){
			$DataBarang[$i]['check'] = "<input type='checkbox' onclick=\"ChekBarang('".$DataBarang[$i]['kode']."')\" name='barang_check' id='barang_".$DataBarang[$i]['kode']."' data=\"".base64_encode(json_encode($DataBarang[$i]))."\" />";
		}
		$output = array(
			"sEcho" => 1,
			"iTotalRecords" => count($DataBarang),
			"aaData" => $DataBarang
		);
		echo json_encode($output);
		exit;*/
		
		// $html = "<table class=\"table table-striped table-bordered table-hover\" id=\"dataTables-barang\">
  //                   <thead>
  //                       <tr>
		// 					<th>KODE BARANG</th>
		// 					<th>BARCODE</th>
  //                      		<th>NAMA BARANG</th>
		// 					<th>KATEGORI</th>
		// 					<th>SATUAN</th>
		// 					<th width='300'>HARGA</th>
		// 					<th>BKP</th>
		// 					<th>BKL</th>
  //                       </tr>
  //                   </thead>
  //                   <tbody>";
		$html = "";
		foreach ($DataBarang as $key => $value) {
			$html .= "<tr data=\"".base64_encode(json_encode($value))."\">
						<td>".$value['kode']."</td>
						<td>".$value['barcode']."</td>
						<td>".$value['nama_barang']."</td>
						<td>".$value['kategori']."</td>
						<td>".$value['nama_kategori']."</td>
						<td>".$value['satuan']."</td>
						<td align=\"right\">".number_format($value['hpp'], 2)."</td>";
			if($value['is_ppn'] == "1"){
				$html .= "<td>&#x2713;</td>";
			}else{
				$html .= "<td>-</td>";
			}
			if($value['bkl'] == "1"){
				$html .= "<td>&#x2713;</td>";
			}else{
				$html .= "<td>-</td>";
			}
			$html .= "</tr>";
		}
		echo $html;
	}
	
	public function getlistbarang(){
		$DataBarang = $this->barang_model->getListDataBarang($_GET);
		$jumlahdata = sizeof($DataBarang);
		$DataResult = array();
		$DataResult['total_count'] = $jumlahdata;
		$DataResult['incomplete_results'] = false;
		$DataResult['items'] = $DataBarang;
		
		echo json_encode($DataResult);
	}

	public function getlistbarangtoko(){
		$DataBarang = $this->barang_model->getListDataBarangToko($_GET);
		$jumlahdata = sizeof($DataBarang);
		$DataResult = array();
		$DataResult['total_count'] = $jumlahdata;
		$DataResult['incomplete_results'] = false;
		$DataResult['items'] = $DataBarang;
		
		echo json_encode($DataResult);
	}
	
	public function getlistpelanggan(){
		$DataPelanggan = $this->barang_model->getListPelanggan($_GET);
		$jumlahdata = sizeof($DataPelanggan);
		$DataResult = array();
		$DataResult['total_count'] = $jumlahdata;
		$DataResult['incomplete_results'] = false;
		$DataResult['items'] = $DataPelanggan;
		
		echo json_encode($DataResult);
	}
	
	public function getlistpelangganall(){
		$DataPelanggan = $this->barang_model->getListPelangganAll($_GET);
		$jumlahdata = sizeof($DataPelanggan);
		$DataResult = array();
		$DataResult['total_count'] = $jumlahdata;
		$DataResult['incomplete_results'] = false;
		$DataResult['items'] = $DataPelanggan;
		
		echo json_encode($DataResult);
	}
	
	public function getFormHargaToko(){
		$this->load->model('toko_model');
		
		$DataToko = $this->toko_model->getDataToko();
		
		$html = "";
		foreach ($DataToko as $key => $value) {
			$html .= "<tr>
						<td>".$value['nama']."</td>
						<td width='20px'></td>
						<td valign='center'>
							<div class='form-group input-group'>
							<span class='input-group-addon'>
								<i class='fa fa-money'></i>
							</span>
							<input type='text' style=\"text-align: right;\" toko_kode='".$value['kode']."' onkeyup=\"price('barang_harga_".$value['kode']."');\" placeholder='Harga' name='barang_harga_".$value['kode']."' id='barang_harga_".$value['kode']."' class='form-control harga_barang_toko'>
						</div>
						</td>
					  </tr>";
		}
		
		echo $html;
	}
	
	public function getFormEditHargaToko(){
		$DataToko = $this->barang_model->getHargaBarang($_POST);
		
		$html = "";
		foreach ($DataToko as $key => $value) {
			$html .= "<tr>
						<td>".$value['nama']."</td>
						<td width='20px'></td>
						<td valign='center'>
							<div class='form-group input-group'>
							<span class='input-group-addon'>
								<i class='fa fa-money'></i>
							</span>
							<input type='text' style=\"text-align: right;\" value='".$value['harga']."' toko_kode='".$value['toko_kode']."' onkeyup=\"price('barang_harga_".$value['toko_kode']."');\" placeholder='Harga' name='barang_harga_".$value['toko_kode']."' id='barang_harga_".$value['toko_kode']."' class='form-control harga_barang_toko'>
							<script>
								price('barang_harga_".$value['toko_kode']."');
							</script>
						</div>
						</td>
					  </tr>";
		}
		
		echo $html;
	}
	
	public function simpanbarang(){
		$_POST['barang_kode'] = $_POST['kode'];
		$_POST['supplier_kode'] = base64_decode($_POST['supplier_kode']);
		$_POST['nama_barang'] = base64_decode($_POST['nama_barang']);

		//KPG validasi kode barang
		$query = $this->barang_model->getListBarangByCode($_POST['kode']);
		if ($query->num_rows() > 0 && $_POST['mode']=='i'){
			$this->output->set_status_header('400');
			die('Kode Barang sudah ada!');
		}

		// simpan barang
		$this->barang_model->SimpanBarang($_POST);
		
		// simpan harga beli supplier
		$this->barang_model->SimpanHargaBeliSupplier($_POST);
		
		// simpan barang supplier
		$this->barang_model->SimpanBarangSupplier($_POST);
		
		// simpan harga jual toko
		$DataToko = json_decode(rawurldecode($_POST['datatoko']));
		$DataHarga = json_decode(rawurldecode($_POST['dataharga']));
		for($index=0;$index<sizeof($DataToko);$index++){
			$_POST['toko_kode'] = $DataToko[$index];
			$_POST['harga1'] = $DataHarga[$index];
			$_POST['harga2'] = 0;
			$_POST['harga3'] = 0;
			
			if($_POST['harga1'] > 0 && $_POST['harga1'] != ''){
				$this->barang_model->SimpanHargaBarang($_POST);
			}
			
			// simpan barang toko
			if($_POST['harga1'] > 0 && $_POST['harga1'] != ''){
				$this->barang_model->SimpanBarangToko($_POST);
			}
		}
	}

	public function getkodebarang(){
		$Result = $this->barang_model->getKodeBarang($_POST);

		echo base64_encode(json_encode($Result));
	}
	
	public function hapusbarang(){
		$result = $this->barang_model->HapusBarang($_POST);
		echo $result;
	}

	public function tidakaktifbarang(){
		$this->barang_model->NonAktifBarang($_POST);
	}

	public function aktifkanbarang(){
		$this->barang_model->AktifkanBarang($_POST);
	}
	
	public function gethargabarangtoko(){
		$DataHarga = $this->barang_model->getHargaBarangToko($_POST);
		
		if(sizeof($DataHarga) > 0){
			echo $DataHarga[0]['harga1'];
		}else{
			echo 0;
		}
	}

	public function gethargabarangsupplier(){
		$DataHarga = $this->barang_model->getHargaSupplier($_POST);
		
		if(sizeof($DataHarga) > 0){
			echo $DataHarga[0]['harga']."_wecode_".$DataHarga[0]['ppn']."_wecode_".$DataHarga[0]['barang_kode']."_wecode_".$DataHarga[0]['nama_barang']."_wecode_".$DataHarga[0]['saldo_akhir_kwt'];
		}else{
			echo "";
		}
	}
	
	function getFormEditHargaSupplier(){
		$DataHarga = $this->barang_model->getHargaSupplier($_POST);
		
		$supplier_kode = "";
		$harga = 0;
		
		if(sizeof($DataHarga) > 0){
			$supplier_kode = $DataHarga[0]['supplier_kode'];
			$harga = $DataHarga[0]['harga'];
		}
		
		echo $supplier_kode."_".$harga;
	}
	
	public function simpanbarangsupplier(){
		$_POST['kode'] = $_POST['barang_kode'];
		$dataArr = json_decode(rawurldecode($_POST['data']));
		
		$this->barang_model->DeleteAllBarangSupplier($_POST);
		for($index=0;$index<sizeof($dataArr);$index = $index + 4){
			$_POST['supplier_kode'] = $dataArr[$index];
			$_POST['harga_beli_supplier'] = $this->removeCurrency($dataArr[$index+2]);
			
			$this->barang_model->SimpanBarangSupplier($_POST);
			$this->barang_model->SimpanHargaBeliSupplier($_POST);
		}
	}
	
	function removeCurrency($currency){
		$b = str_replace(",","",$currency);;
		
		return $b;
	}

	public function simpanmarginharga(){
		$this->barang_model->SimpanMarginHarga($_POST);
	}
	
	public function simpanbarangtoko(){
		$_POST['kode'] = $_POST['barang_kode'];
		$dataArr = json_decode(rawurldecode($_POST['data']));
		// delete barang toko
		$this->barang_model->DeleteAllBarangToko($_POST);
		for($index=0;$index<sizeof($dataArr);$index = $index + 6){
			$_POST['toko_kode'] = $dataArr[$index];
			$_POST['harga1'] = $this->removeCurrency($dataArr[$index+2]);
			$_POST['harga2'] = $this->removeCurrency($dataArr[$index+3]);
			$_POST['harga3'] = $this->removeCurrency($dataArr[$index+4]);
			
			$this->barang_model->SimpanBarangToko($_POST);
			$this->barang_model->SimpanHargaBarang($_POST);
		}
	}
	
	public function loadbarangsupplier(){
		$DataSupplier = $this->barang_model->GetBarangSupplier($_POST);
		
		$html = "";
		foreach($DataSupplier as $key => $value){
			$html .= "<tr>
						<td>".$value['supplier_kode']."</td>
						<td>".$value['nama_supplier']."</td>
						<td align=\"right\">".number_format($value['harga'], 2)."</td>
						<td class=\"text-center\">
							<button type=\"button\" onclick=\"EditRowHargaSupplier(this)\" class=\"btn btn-success btn-sm\">
								<i class=\"fa fa-edit\"></i>
							</button>
							<button type=\"button\" onclick=\"HapusRow(this)\" class=\"btn btn-danger btn-sm\">
								<i class=\"fa fa-times\"></i>
							</button>
						</td>
					  </tr>";
		}
		
		echo $html;
	}
	
	public function loadbarangtoko(){
		$DataToko = $this->barang_model->GetBarangToko($_POST);
		
		$html = "";
		foreach($DataToko as $key => $value){
			$html .= "<tr>
						<td>".$value['toko_kode']."</td>
						<td>".$value['nama_toko']."</td>
						<td align=\"right\">".number_format($value['hpp'], 2)."</td>
						<td align=\"right\">".$value['margin_harga']." %</td>
						<td align=\"right\">".number_format($value['harga1'], 2)."</td>
					  </tr>";
		}
		
		echo $html;
	}

	public function importhargajual(){
		$this->load->library('excel');
		// $output_dir = "/opt/lampp/htdocs/vmart/uploads/";
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
				$DataHarga[$index]['harga1'] = $rowData[0][2];
				$DataHarga[$index]['harga2'] = $rowData[0][3];

				$index++;
			}
		}

		echo base64_encode(json_encode($DataHarga));
	}

	public function simpanimporthargajual(){
		$dataArr = json_decode(rawurldecode($_POST['data']));
		for($index=0;$index<sizeof($dataArr);$index = $index + 4){
			$dataSimpan = array();
			$dataSimpan['kode'] = $dataArr[$index];
			$dataSimpan['barang_kode'] = $dataArr[$index];
			$dataSimpan['toko_kode'] = $_POST['toko_kode'];
			$dataSimpan['harga1'] = $this->removeCurrency($dataArr[$index+2]);
			$dataSimpan['harga2'] = $this->removeCurrency($dataArr[$index+3]);
			$dataSimpan['harga3'] = 0;
			
			$this->barang_model->DeleteBarangToko($dataSimpan);
			$this->barang_model->SimpanBarangToko($dataSimpan);
			$this->barang_model->SimpanHargaBarang($dataSimpan);
		}
	}

	public function getmarginkategori(){
		$result = $this->barang_model->getMarginKategori($_POST);

		echo $result;
	}
}