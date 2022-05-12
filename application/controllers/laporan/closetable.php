<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Closetable extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('laporan_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('laporan/closetable');
		$this->load->view('general/footer');
	}
	
	public function getdatatable(){
		$DataTable = $this->laporan_model->getDataTable($_POST);
		
		$html = "<table class=\"table table-striped table-bordered table-hover\">
						<thead>
							<tr>
								<th>No Meja</th>
								<th>Nama Meja</th>
								<th>No Transaksi</th>
								<th>Tanggal</th>
								<th>Pelanggan</th>
								<th>No Kasir</th>
								<th>Status Meja</th>
								<th>Status Header</th>
								<th>Close</th>
							</tr>
						</thead>
						<tbody>";
		foreach($DataTable as $key => $value){
			$html .= "<tr>
						<td>".$value['ftablekey']."</td>
						<td>".$value['fname']."</td>
						<td>".$value['fcode']."</td>
						<td>".$value['fdate']."</td>
						<td>".$value['fcustname']."</td>
						<td>".$value['fcreatedby']."</td>
						<td>".$value['fstatus']."</td>
						<td>".$value['fstatuskey']."</td>
						<td>
							<button id=\"btn_upload\" onclick=\"CloseTable('".$value['ftranskey']."')\" class=\"btn btn-danger\" type=\"button\">
								<i class=\"fa fa-times\"></i>
								&nbsp;&nbsp;Close
							</button>
						</td>
					  </tr>";
		}
		$html .= "</tbody></table>";
		
		echo $html;
	}
	
	public function prosesclosetable(){
		$this->laporan_model->CloseTable($_POST);
	}
}
?>