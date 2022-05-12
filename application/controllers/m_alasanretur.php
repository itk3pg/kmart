<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_alasanretur extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('m_alasanretur_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('master/m_alasanretur');
		$this->load->view('general/footer');
	}
	
	public function getdataalasanretur(){
		$DataBarang = $this->m_alasanretur_model->getDataAlasanretur();
		
		$html = "<table class=\"table table-striped table-bordered table-hover\" id=\"dataTables-alasanretur\">
                    <thead>
                        <tr>
                       		<th>Kode</th>
                       		<th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>";
		foreach ($DataBarang as $key => $value) {
			$html .= "<tr kd_alasanretur=\"".$value['kd_alasanretur']."\">
						<td>".$value['kd_alasanretur']."</td>
						<td>".$value['keterangan']."</td>
					  </tr>";
		}
		
		$html .= "</tbody>
				</table>";
		echo $html;
	}
	
	public function hapusalasanretur(){
		$this->m_alasanretur_model->HapusAlasanretur($_POST);
	}
	
	public function simpanalasanretur(){
		$this->m_alasanretur_model->SimpanAlasanretur($_POST);
	}
}
