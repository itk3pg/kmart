<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_bank extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('m_bank_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('master/m_bank');
		$this->load->view('general/footer');
	}
	
	public function getdatabank(){
		$DataBarang = $this->m_bank_model->getDataBank();
		
		$html = "<table class=\"table table-striped table-bordered table-hover\" id=\"dataTables-bank\">
                    <thead>
                        <tr>
                       		<th>KD BANK</th>
                       		<th>NAMA</th>
                        </tr>
                    </thead>
                    <tbody>";
		foreach ($DataBarang as $key => $value) {
			$html .= "<tr kd_bank=\"".$value['kd_bank']."\">
						<td>".$value['kd_bank']."</td>
						<td>".$value['keterangan']."</td>
					  </tr>";
		}
		
		$html .= "</tbody>
				</table>";
		echo $html;
	}
	
	public function hapusbank(){
		$this->m_bank_model->HapusBank($_POST);
	}
	
	public function simpanbank(){
		$this->m_bank_model->SimpanBank($_POST);
	}
}
