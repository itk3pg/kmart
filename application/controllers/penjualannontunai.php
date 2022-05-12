<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Penjualannontunai extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('penjualannontunai_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('penjualannontunai/home');
		$this->load->view('general/footer');
	}
	
	public function getdatapenjualannontunai(){
		$DataPenjualanNonTunai = $this->penjualannontunai_model->getDataPenjualanNonTunai($_POST);
		
		$bukti = "";
		$html = "<table class=\"table table-striped table-bordered table-hover\" id=\"dataTables-penjualannontunai\">
                    <thead>
                        <tr>
							<th>&nbsp;</th>
							<th>Bukti</th>
                       		<th>Tanggal</th>
							<th>Pelanggan</th>
                            <th>Barang</th>
                            <th>KWT</th>
                            <th>hpp</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Edit</th>
                        </tr>
                    </thead>
                    <tbody>";
		foreach ($DataPenjualanNonTunai as $key => $value) {
			$html .= "<tr data=\"".base64_encode(json_encode($value))."\">";
			$BarangKodeEdit = explode(" ", $value['fitemkey']);
			$BarangKodeEdit = $BarangKodeEdit[0];
			if($bukti != $value['fcode']){
				if($value['fstatuskey'] == "5"){
					$html .= "<td><strong>-</strong></td>";
				}else{
					$html .= "<td><strong>&#x2713;</strong></td>";
				}
				$html .= "<td>".$value['fcode']."</td>
						  <td>".$value['fdate']."</td>
						  <td>".$value['fcustname']."</td>";
				$bukti = $value['fcode'];
			}else{
				$html .= "<td></td>
						  <td></td>
						  <td></td>
						  <td></td>";
			}
			$html .= "	<td>".$value['nama_barang']."</td>
						<td align='right' id=\"kwt_".$value['fcode']."_".$BarangKodeEdit."\">".$value['fqty']."</td>
						<td align='right'>".$value['hpp']."</td>
						<td align=\"right\" id=\"harga_".$value['fcode']."_".$BarangKodeEdit."\">".number_format($value['fprice'])."</td>
						<td align=\"right\" id=\"total_".$value['fcode']."_".$BarangKodeEdit."\">".number_format($value['ftotal'])."</td>
						<td class=\"text-center\">
							<table id='form-edit-table-".$value['fcode']."-".$BarangKodeEdit."' style='display: none;'>
								<thead>
									<tr>
										<th>Harga :</th>
										<th>&nbsp;</th>
									</tr>
									<tr>
										<th>
											<input type='text' style='width: 100px; text-align: right;' class='form-control' id='harga_edit_".$value['fcode']."_".$BarangKodeEdit."' name='harga_edit_".$value['fcode']."_".$BarangKodeEdit."' />
										</th>
										<th width='60px'>
											<button id='btn_cancel_edit_harga_".$value['fcode']."_".$BarangKodeEdit."' onclick=\"CancelEditharga('".$value['fcode']."', '".$BarangKodeEdit."')\" name='btn_cancel_edit_harga_".$value['fcode']."_".$BarangKodeEdit."' type=\"button\" style=\"padding: 6px 5px; float:left;\" class=\"btn btn-danger btn-sm\">
												<i class=\"fa fa-times\"></i>
											</button>
											<button id='btn_edit_harga_".$value['fcode']."_".$BarangKodeEdit."' onclick=\"SimpanEditHarga('".$value['fcode']."', '".$value['fitemkey']."')\" name='btn_edit_harga_".$value['fcode']."_".$BarangKodeEdit."' type=\"button\" style=\"padding: 6px 5px; float:left;\" class=\"btn btn-success btn-sm\">
												<i class=\"fa fa-check\"></i>
											</button>
										</th>
									</tr>
								</thead>
							</table>
							<button type=\"button\" style=\"padding: 1px 5px;\" onclick=\"Editharga('".$value['fcode']."', '".$BarangKodeEdit."')\" class=\"btn btn-warning btn-sm\">
								<i class=\"fa fa-edit\"></i>
							</button>
						</td>
					  </tr>";
		}

		$html .= "</tbody></table>";
		
		echo $html;
	}
	
	function simpaneditharga(){
		$this->penjualannontunai_model->SimpanEditHarga($_POST);
	}
	
	function approveharga(){
		$this->penjualannontunai_model->ApproveHarga($_POST);
	}
}