<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tipepembayaran extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('tipepembayaran_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('master/tipepembayaran');
		$this->load->view('general/footer');
	}
	
	public function getdatatipepembayaran(){
		$DataTipePembayaran = $this->tipepembayaran_model->getDataTipePembayaran();
		
		$html = "<table class=\"table table-striped table-bordered table-hover\" id=\"dataTables-tipepembayaran\">
                    <thead>
                        <tr>
                       		<th>KODE</th>
                            <th>NAMA</th>
                        </tr>
                    </thead>
                    <tbody>";
		foreach ($DataTipePembayaran as $key => $value) {
			$html .= "<tr data=\"".base64_encode(json_encode($value))."\">
						<td>".$value['kode']."</td>
						<td>".$value['nama']."</td>
					  </tr>";
		}
		
		$html .= "</tbody>
				</table>";
		echo $html;
	}
	
	public function getlisttipepembayaran(){
		$DataTipePembayaran = $this->tipepembayaran_model->getDataTipePembayaran();
		
		$html = "";
		foreach ($DataTipePembayaran as $key => $value) {
			$html .= "<option value='".$value['kode']."'>".$value['nama']."</option>";
		}
		
		echo $html;
	}
	
	public function simpantipepembayaran(){
		$this->tipepembayaran_model->SimpanTipePembayaran($_POST);
	}
	
	public function hapustipepembayaran(){
		$this->tipepembayaran_model->HapusTipePembayaran($_POST);
	}
}