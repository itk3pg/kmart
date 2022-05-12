<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_kasbank extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('m_kasbank_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('master/m_kasbank');
		$this->load->view('general/footer');
	}
	
	public function getdatakasbank(){
		$DataBarang = $this->m_kasbank_model->getDataKasbank();
		
		$html = "<table class=\"table table-striped table-bordered table-hover\" id=\"dataTables-kasbank\">
                    <thead>
                        <tr>
                       		<th>KD KAS/BANK</th>
                       		<th>KETERANGAN</th>
                        </tr>
                    </thead>
                    <tbody>";
		foreach ($DataBarang as $key => $value) {
			$html .= "<tr kd_kb=\"".$value['kd_kb']."\">
						<td>".$value['kd_kb']."</td>
						<td>".$value['keterangan']."</td>
					  </tr>";
		}
		
		$html .= "</tbody>
				</table>";
		echo $html;
	}
	
	public function hapuskasbank(){
		$this->m_kasbank_model->HapusKasbank($_POST);
	}
	
	public function simpankasbank(){
		$this->m_kasbank_model->SimpanKasbank($_POST);
	}
}
