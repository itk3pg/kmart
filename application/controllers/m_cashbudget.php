<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_cashbudget extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('m_cashbudget_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('master/m_cashbudget');
		$this->load->view('general/footer');
	}
	
	public function getdatacashbudget(){
		$DataCB = $this->m_cashbudget_model->getDataCashbudget();
		
		$html = "<table class=\"table table-striped table-bordered table-hover\" id=\"dataTables-cashbudget\">
                    <thead>
                        <tr>
                       		<th>KD CASHBUDGET</th>
                       		<th>KETERANGAN</th>
                        </tr>
                    </thead>
                    <tbody>";
		foreach ($DataCB as $key => $value) {
			$html .= "<tr kd_cb=\"".$value['kd_cb']."\">
						<td>".$value['kd_cb']."</td>
						<td>".$value['keterangan']."</td>
					  </tr>";
		}
		
		$html .= "</tbody>
				</table>";
		echo $html;
	}
	
	public function hapuscashbudget(){
		$this->m_cashbudget_model->HapusCashbudget($_POST);
	}
	
	public function simpancashbudget(){
		$this->m_cashbudget_model->SimpanCashbudget($_POST);
	}
}
