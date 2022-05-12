<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kategoribarang extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('kategoribarang_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('master/kategoribarang2');
		$this->load->view('general/footer');
	}
	
	public function getlistkategori(){
		echo "<ul class=\"sTree2\" id=\"sTree2\">";
		$data = array();
		$data['kode'] = "";
		$data['nama'] = "";
		$data['margin_harga'] = "0";
		$this->getsubkategori($data);
		echo "</ul>";
	}
	
	function getsubkategori($data){
		$dataKat = $this->kategoribarang_model->getChild($data['kode']);
		
		if(sizeof($data) > 0){
			if($data['kode'] != ""){
				echo "<li class=\"sortableListsOpen\" id=\"item_a\" data-module=\"".$data['kode']."\">
						<div>".$data['nama']." ( ".$data['margin_harga']."% )
							<button class=\"clickable\" id=\"btn_hapus\" onclick=\"HapusKategori('".$data['kode']."')\" style=\"float: right;\" class=\"btn btn-danger btn-xs\" type=\"button\">
								<i class=\"fa fa-times\"></i>
							</button>
							<button class=\"clickable\" id=\"btn_edit\" onclick=\"EditKategori('".$data['kode']."','".$data['nama']."','".$data['margin_harga']."')\" style=\"float: right; margin-right:5px;\" class=\"btn btn-success btn-xs\" type=\"button\">
								<i class=\"fa fa-edit\"></i>
							</button>
						</div>
						<ul class=\"\">";
			}
			foreach ($dataKat as $key => $value) {
				$this->getsubkategori($value);
			}
			if($data['kode'] != ""){
				echo "</ul>
					</li>";
			}
		}else{
			if($data['kode'] != ""){
				echo "<li id=\"item_a\" data-module=\"".$data['kode']."\">
						<div>".$data['nama']." ( ".$data['margin_harga']."% ) 
							<button class=\"clickable\" id=\"btn_hapus\" onclick=\"HapusKategori('".$data['kode']."')\" style=\"float: right;\" class=\"btn btn-danger btn-xs\" type=\"button\">
								<i class=\"fa fa-times\"></i>
							</button>
							<button class=\"clickable\" id=\"btn_edit\" onclick=\"EditKategori('".$data['kode']."','".$data['nama']."','".$data['margin_harga']."')\" style=\"float: right; margin-right:5px;\" class=\"btn btn-success btn-xs\" type=\"button\">
								<i class=\"fa fa-edit\"></i>
							</button>
						</div>
					</li>";
			}
		}
	}

	public function getlistkategoriform(){
		//echo "<ul>";
		//$this->getsubkategoriform("FOOD", "FOOD");
		//echo "</ul>";
		$data = $this->kategoribarang_model->getDataKategori();
		$html = "";
		foreach($data as $key => $value){
			$html .= "<option value=\"".$value['kode']."\">(".$value['kode'].") ".$value['nama']."</option>";
		}
		echo $html;
	}
	
	function getsubkategoriform($kode, $nama){
		$data = $this->kategoribarang_model->getChild($kode);
		
		if(sizeof($data) > 0){
			if($kode != ""){
				echo "<li>
						<div>".$nama."
							<button id=\"btn_pilih\" onclick=\"PilihKategori(\"".$kode."\",\"".$nama."\")\" class=\"btn btn-success btn-xs\" type=\"button\">
								<i class=\"fa fa-check\"></i>
							</button>
						</div>
						<ul>";
			}
			foreach ($data as $key => $value) {
				//$this->getsubkategoriform($value['kode'], $value['nama']);
				echo "<li>
						<div>".$value['kode']." 
							<button id=\"btn_pilih\" onclick=\"PilihKategori(\"".$value['kode']."\",\"".$value['nama']."\")\" class=\"btn btn-success btn-xs\" type=\"button\">
								<i class=\"fa fa-check\"></i>
							</button>
						</div>
					</li>";
			}
			if($kode != ""){
				echo "</ul>
					</li>";
			}
		}/*else{
			if($kode != ""){
				echo "<li>
						<div>".$nama." 
							<button id=\"btn_pilih\" onclick=\"PilihKategori(\"".$kode."\",\"".$nama."\")\" class=\"btn btn-success btn-xs\" type=\"button\">
								<i class=\"fa fa-check\"></i>
							</button>
						</div>
					</li>";
			}
		}*/
	}

	public function getdatakelbarang(){
		$DataKategori = $this->kategoribarang_model->getDataKategori();
		
		$html = "<table class=\"table table-striped table-bordered table-hover\" id=\"dataTables-kelbarang\">
                    <thead>
                        <tr>
                       		<th>KODE</th>
                            <th>NAMA</th>
                            <th>MARGIN Harga 1 (%)</th>
							<th>MARGIN Harga 2 (%)</th>
                        </tr>
                    </thead>
                    <tbody>";
		foreach ($DataKategori as $key => $value) {
			$html .= "<tr data=\"".base64_encode(json_encode($value))."\">
						<td>".$value['kode']."</td>
						<td>".$value['nama']."</td>
						<td>".$value['margin_harga']." %</td>
						<td>".$value['margin_harga2']." %</td>
					  </tr>";
		}
		
		$html .= "</tbody>
				</table>";
		echo $html;
	}
	
	public function simpankelbarang(){
		$result = $this->kategoribarang_model->simpankategori($_POST);
		echo $result;
	}
	
	public function setparent(){
		$this->kategoribarang_model->setparent($_POST);
	}
	
	public function hapuskelbarang(){
		$result = $this->kategoribarang_model->HapusKategori($_POST);

		echo $result;
	}

	public function getdataakun(){
		$DataAkunKategori = $this->kategoribarang_model->getDataAkunKategori($_POST);
		
		$html = "";
		foreach ($DataAkunKategori as $key => $value) {
			$html .= "<tr data=\"".base64_encode(json_encode($value))."\">
						<td>".$value['nama_toko']."</td>
						<td>".$value['kode_akun']."</td>
					  </tr>";
		}
		
		$html .= "";
		
		echo $html;
	}

	public function simpankodeakun(){
		$result = $this->kategoribarang_model->SimpanKodeAkun($_POST);

		echo $result;
	}
}

?>