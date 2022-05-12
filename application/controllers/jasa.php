<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jasa extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('jasa_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('master/jasa');
		$this->load->view('general/footer');
	}
	
	public function getdatajasa(){
		$DataJasa = $this->jasa_model->getDataJasa();
		
		$html = "<table class=\"table table-striped table-bordered table-hover\" id=\"dataTables-jasa\">
                    <thead>
                        <tr>
                       		<th>KODE</th>
							<th>NAMA JASA</th>
                        </tr>
                    </thead>
                    <tbody>";
		foreach ($DataJasa as $key => $value) {
			$html .= "<tr data=\"".base64_encode(json_encode($value))."\">
						<td>".$value['kode']."</td>
						<td>".$value['nama_jasa']."</td>
					  </tr>";
		}
		
		$html .= "</tbody>
				</table>";
		echo $html;
	}
	
	public function getlistjasa(){
		$DataJasa = $this->jasa_model->getListDataJasa($_GET);
		$jumlahdata = sizeof($DataJasa);
		$DataResult = array();
		$DataResult['total_count'] = $jumlahdata;
		$DataResult['incomplete_results'] = false;
		$DataResult['items'] = $DataJasa;
		
		echo json_encode($DataResult);
	}
	
	public function simpanjasa(){
		$this->jasa_model->SimpanJasa($_POST);
	}
	
	public function hapusjasa(){
		$this->jasa_model->HapusJasa($_POST);
	}
}