<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Toko extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('toko_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('master/toko');
		$this->load->view('general/footer');
	}
	
	public function getdatatoko(){
		$DataToko = $this->toko_model->getDataToko();
		
		$html = "<table class=\"table table-striped table-bordered table-hover\" id=\"dataTables-toko\">
                    <thead>
                        <tr>
                       		<th>KODE</th>
                            <th>NAMA</th>
                            <th>KOTA</th>
							<th>ALAMAT</th>
							<th>NPWP</th>
							<th>NO TELP</th>
                        </tr>
                    </thead>
                    <tbody>";
		foreach ($DataToko as $key => $value) {
			$html .= "<tr data=\"".base64_encode(json_encode($value))."\">
						<td>".$value['kode']."</td>
						<td>".$value['nama']."</td>
						<td>".$value['kota']."</td>
						<td>".$value['alamat']."</td>
						<td>".$value['npwp']."</td>
						<td>".$value['notelp']."</td>
					  </tr>";
		}
		
		$html .= "</tbody>
				</table>";
		echo $html;
	}
	
	public function getListToko(){
		$DataToko = $this->toko_model->getAllDataToko();
		
		$html = "";
		foreach ($DataToko as $key => $value) {
			$html .= "<option value='".$value['kode']."'>".$value['nama']."</option>";
		}
		
		echo $html;
	}
	
	public function getListDataToko(){
		$DataToko = $this->toko_model->getDataToko();
		
		$html = "";
		foreach ($DataToko as $key => $value) {
			$html .= "<option value='".$value['kode']."'>".$value['nama']."</option>";
		}
		
		echo $html;
	}
	
	public function simpantoko(){
		$this->toko_model->SimpanToko($_POST);
	}
	
	public function hapustoko(){
		$this->toko_model->HapusToko($_POST);
	}
}