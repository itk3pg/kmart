<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('menu_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('master/menu');
		$this->load->view('general/footer');
	}
	
	public function getdatamenu(){
		$DataBarang = $this->menu_model->getDataMenu();
		
		$html = "<table class=\"table table-striped table-bordered table-hover\" id=\"dataTables-menu\">
                    <thead>
                        <tr>
                       		<th>NAMA MENU</th>
                       		<th>NAMA CETAK</th>
                            <th>KATEGORI</th>
                            <th>KITCHEN</th>
                            <th>HARGA</th>
                            <th>PPN</th>
                        </tr>
                    </thead>
                    <tbody>";
		foreach ($DataBarang as $key => $value) {
			$html .= "<tr data=\"".base64_encode(json_encode($value))."\">
						<td>".$value['nama_menu']."</td>
						<td>".$value['nama_cetak']."</td>
						<td>".$value['nama_kategori']."</td>
						<td>".$value['nama_kitchen']."</td>
						<td align='right'>".number_format($value['harga'])."</td>
						<td align='right'>".number_format($value['ppn'])."</td>
					  </tr>";
		}
		
		$html .= "</tbody>
				</table>";
		echo $html;
	}

	public function getdatabom(){
		$DataBOM = $this->menu_model->getDataBom($_POST);
		$html = "";
		if($_POST['is_paket'] == "0"){ // menu biasa
			$html = "<table class=\"table table-striped table-bordered table-hover\">
	                    <thead>
	                        <tr>
	                       		<th>&nbsp;</th>
	                       		<th>NAMA BARANG</th>
	                            <th>TAKARAN</th>
	                            <th>SATUAN</th>
	                        </tr>
	                    </thead>
	                    <tbody>";
		}else{ // menu paket
			$html = "<table class=\"table table-striped table-bordered table-hover\">
	                    <thead>
	                        <tr>
	                       		<th>&nbsp;</th>
	                       		<th>NAMA ITEM</th>
								<th>KWT</th>
	                        </tr>
	                    </thead>
	                    <tbody>";
		}
		
		foreach ($DataBOM as $key => $value) {
			if($_POST['is_paket'] == "0"){
				$html .= "<tr data=\"".base64_encode(json_encode($value))."\">
							<td><input type='checkbox' name='check_item' id='check_item' value='".$value['barang_kode']."' /></td>
							<td>".$value['nama_barang']."</td>
							<td>".$value['takaran']."</td>
							<td>".$value['nama_satuan_terkecil']."</td>
						  </tr>";
			}else{
				$html .= "<tr data=\"".base64_encode(json_encode($value))."\">
							<td><input type='checkbox' name='check_item' id='check_item' value='".$value['menu_kode']."' /></td>
							<td>".$value['nama']."</td>
							<td>".$value['kwt']."</td>
						  </tr>";
			}
		}
		$html .= "</tbody></table>";
		
		echo $html;
	}

	public function getlistmenu(){
		$DataMenu = $this->menu_model->getListMenu($_GET);
		$jumlahdata = sizeof($DataMenu);
		$DataResult = array();
		$DataResult['total_count'] = $jumlahdata;
		$DataResult['incomplete_results'] = false;
		$DataResult['items'] = $DataMenu;
		
		echo json_encode($DataResult);
	}
	
	public function simpanmenu(){
		/*echo "<pre>";
		print_r($_POST);
		print_r($_FILES);
		echo "</pre>";
		exit;*/
		// uploading file 
		if(isset($_FILES["menu_gambar"]["name"]) && $_FILES["menu_gambar"]["name"] != ""){
			$namaFile = explode(".", $_FILES["menu_gambar"]["name"]);
			$target_file = $_POST['menu_kode'].".".$namaFile[sizeof($namaFile) - 1];
			$is_upload = move_uploaded_file($_FILES["menu_gambar"]["tmp_name"], "gambar_menu/".$target_file);
			if($is_upload){
				$_POST['menu_gambar'] = $target_file;
				$_POST['menu_harga'] = $this->removeCurrency($_POST['menu_harga']);
				$_POST['menu_ppn'] = $this->removeCurrency($_POST['menu_ppn']);
				$this->menu_model->SimpanMenu($_POST);
			}else{
				echo "Gambar gagal disimpan";
			}
		}else{
			$_POST['menu_harga'] = $this->removeCurrency($_POST['menu_harga']);
			$_POST['menu_ppn'] = $this->removeCurrency($_POST['menu_ppn']);
			$this->menu_model->SimpanMenu($_POST);
		}
	}
	
	function removeCurrency($currency){
		$b = str_replace(".","",$currency);;
		$b = str_replace(',', '.', $b);
		
		return $b;
	}
	
	public function hapusmenu(){
		$this->menu_model->HapusMenu($_POST);
	}
	
	public function simpanbom(){
		$this->menu_model->SimpanBom($_POST);
	}
	
	public function hapusbom(){
		for($i=0;$i<$_POST['jumlahdata'];$i++){
			$param = array();
			$param['kode'] = $_POST['data'.$i];
			$param['is_paket'] = $_POST['is_paket'];
			
			$this->menu_model->HapusBom($param);
		}
	}
	
	public function duplicatemenu(){
		$this->menu_model->DuplicateMenu($_POST);
	}
}