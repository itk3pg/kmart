<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Satuanbarang extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('satuanbarang_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('master/satuanbarang');
		$this->load->view('general/footer');
	}
	
	public function getdatasatuan(){
		$DataBarang = $this->satuanbarang_model->getDataSatuan();
		
		$html = "<table class=\"table table-striped table-bordered table-hover\" id=\"dataTables-satuan\">
                    <thead>
                        <tr>
                       		<th>KODE SATUAN</th>
                            <th>NAMA SATUAN</th>
                        </tr>
                    </thead>
                    <tbody>";
		foreach ($DataBarang as $key => $value) {
			$html .= "<tr data=\"".base64_encode(json_encode($value))."\">
						<td>".$value['kode']."</td>
						<td>".$value['nama']."</td>
					  </tr>";
		}
		
		$html .= "</tbody>
				</table>";
		echo $html;
	}
	
	public function getlistsatuan(){
		$DataBarang = $this->satuanbarang_model->getDataSatuan();
		
		$html = "";
		foreach ($DataBarang as $key => $value) {
			$html .= "<option value='".$value['kode']."'>".$value['nama']."</option>";
		}
		
		echo $html;
	}
	
	public function simpansatuan(){
		$this->satuanbarang_model->SimpanSatuan($_POST);
	}
	
	public function hapussatuan(){
		$this->satuanbarang_model->HapusSatuan($_POST);
	}
}