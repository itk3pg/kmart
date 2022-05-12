<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pemakaianbarang extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('pemakaianbarang_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('pemakaianbarang/home');
		$this->load->view('general/footer');
	}
	
	public function getdatapemakaian(){
		$DataPemakaian = $this->pemakaianbarang_model->getDataPemakaian($_POST);
		
		$bukti = "";
		$html = "<table class=\"table table-striped table-bordered table-hover\" id=\"dataTables-pemakaian\">
                    <thead>
                        <tr>
							<th>BUKTI</th>
                       		<th>TANGGAL</th>
							<th>DAPUR</th>
                            <th>BARANG</th>
                            <th>KWT</th>
							<th>SATUAN</th>
                        </tr>
                    </thead>
                    <tbody>";
		foreach ($DataPemakaian as $key => $value) {
			$html .= "<tr data=\"".base64_encode(json_encode($value))."\">";
			if($bukti != $value['bukti']){
				$html .= "<td>".$value['bukti']."</td>
						  <td>".$value['tanggal']."</td>
						  <td>".$value['nama_kitchen']."</td>";
				$bukti = $value['bukti'];
			}else{
				$html .= "<td></td>
						  <td></td>
						  <td></td>";
			}
			$html .= "	<td>".$value['nama_barang']."</td>
						<td align='right'>".$value['kwt_kecil']."</td>
						<td align='right'>".$value['nama_satuan_terkecil']."</td>
					  </tr>";
		}
		
		$html .= "</tbody>
				</table>";
		echo $html;
	}
	
	public function listpilihpemakaian(){
		$Dataod = $this->pemakaianbarang_model->getDataListPemakaian($_POST);
		
		$bukti = "";
		$html = "<table class=\"table table-striped table-bordered table-hover\" id=\"dataTables-pemakaian\">
                    <thead>
                        <tr>
							<th>BUKTI</th>
                       		<th>TANGGAL</th>
							<th>DAPUR</th>
							<th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>";
		foreach ($Dataod as $key => $value) {
			$html .= "<tr>
						<td>".$value['bukti']."</td>
						<td>".$value['tanggal']."</td>
						<td>".$value['nama_kitchen']."</td>
						<td align=\"center\">
							<button id=\"btn_pilih\" class=\"btn btn-info btn-sm\" type=\"button\" onclick=\"PilihOD('".$value['bukti']."')\">
								<i class=\"fa fa-check\"></i>
							</button>
						</td>
					  </tr>";
		}
		
		$html .= "</tbody>
				</table>";
		echo $html;
	}
	
	public function simpanpemakaian(){
		$this->pemakaianbarang_model->SimpanPemakaian($_POST);
	}
	
	public function hapuspemakaian(){
		$this->pemakaianbarang_model->HapusPemakaian($_POST);
	}
	
	public function getdatabarangpemakaian(){
		$DataBarangPemakaian = $this->pemakaianbarang_model->getDataBarangPemakaian($_POST);
		
		$html = "";
		foreach ($DataBarangPemakaian as $key => $value) {
			$html .= "<tr>
						<td>".$value['barang_kode']."</td>
						<td>".$value['nama_barang']."</td>
						<td class=\"text-right\">".$value['kwt_besar']."</td>
						<td class=\"text-right\">".$value['kwt_kecil']."</td>
						<td>".$value['nama_satuan_terkecil']."</td>
						<td class=\"text-center\">
							<button type=\"button\" style=\"padding: 0px 20px;\" onclick=\"HapusRow(this)\" class=\"btn btn-danger btn-sm\"><i class=\"fa fa-times\"></i></button>
						</td>
					</tr>";
		}
		
		echo $html;
	}
}