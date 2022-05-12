<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Penjualan extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('penjualan_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('penjualan/home');
		$this->load->view('general/footer');
	}
	
	public function getdatapenjualan(){
		$DataPenjualan = $this->penjualan_model->getDataPenjualan($_POST);
		
		$html = "<table class=\"table table-striped table-bordered table-hover\" id=\"dataTables-penjualan\">
					<thead>
						<tr>
							<th style='vertical-align: middle;' class='text-center' rowspan='2'>Tanggal</th>
							<th style='vertical-align: middle;' class='text-center' rowspan='2'>Kode Trans</th>
							<th style='vertical-align: middle;' class='text-center' rowspan='2'>Pelanggan</th>
							<th style='vertical-align: middle;' class='text-center' rowspan='2'>Kasir</th>
							<th style='vertical-align: middle;' class='text-center' rowspan='2'>Total</th>
							<th class='text-center' colspan='6'>Pembayaran</th>
						</tr>
						<tr>
							<th class='text-center'>Tunai</th>
							<th class='text-center'>Kupon</th>
							<th class='text-center'>SHU</th>
							<th class='text-center'>Debit Card</th>
							<th class='text-center'>Credit Card</th>
						</tr>
					</thead>
					<tbody>";
					
		foreach ($DataPenjualan as $key => $value) {
			$Tunai = $value['fpayment'];
			if($value['fchange'] > 0){
				$Tunai = $value['fpayment'] - $value['fchange'];
			}
			$html .= "<tr data=\"".base64_encode(json_encode($value))."\">
						<td>".$value['fdate']."</td>
						<td>".$value['fcode']."</td>
						<td>".$value['fcustname']."</td>
						<td>".$value['nama_kasir']."</td>
						<td align=\"right\">".number_format($value['fbill_amount'],2,",",".")."</td>
						<td align=\"right\">".number_format($Tunai,2,",",".")."</td>
						<td align=\"right\">".number_format($value['fkupon'],2,",",".")."</td>
						<td align=\"right\">".number_format($value['fshu'],2,",",".")."</td>
						<td align=\"right\">".number_format($value['fdebet'],2,",",".")."</td>
						<td align=\"right\">".number_format($value['fkredit'],2,",",".")."</td>
					  </tr>";
		}
		
		$html .= "</tbody></table>";
		
		echo $html;
	}
	
	public function simpaneditpelanggan(){
		$this->penjualan_model->SimpanEditPelanggan($_POST);
	}
}
?>