<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Planogram extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('planogram_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('master/planogram');
		$this->load->view('general/footer');
	}
	
	public function getdataplanogram(){
		$DataPlanogram = $this->planogram_model->getDataPlanogram($_POST);
		
		$html = "<table class=\"table table-striped table-bordered table-hover\" id=\"dataTables-planogram\">
                    <thead>
                        <tr>
							<th>RAK</th>
							<th>SHLV</th>
							<th>URUT</th>
							<th>KODE BARANG</th>
							<th>BARCODE</th>
                       		<th>NAMA BARANG</th>
							<th>KIRI-KANAN</th>
							<th>DEPAN-BELAKANG</th>
							<th>ATAS-BAWAH</th>
                        </tr>
                    </thead>
                    <tbody>";
		foreach ($DataPlanogram as $key => $value) {
			$html .= "<tr data=\"".base64_encode(json_encode($value))."\">
						<td>".$value['rak']."</td>
						<td>".$value['shlv']."</td>
						<td>".$value['urut']."</td>
						<td>".$value['barang_kode']."</td>
						<td>".$value['barcode']."</td>
						<td>".$value['nama_barang']."</td>
						<td>".$value['kirikanan']."</td>
						<td>".$value['depanbelakang']."</td>
						<td>".$value['atasbawah']."</td>
					  </tr>";
		}
		
		$html .= "</tbody>
				</table>";
		echo $html;
	}
	
	public function simpanplanogram(){
		$this->planogram_model->SimpanPlanogram($_POST);
	}
	
	public function hapusplanogram(){
		$this->planogram_model->HapusPlanogram($_POST);
	}
	
	public function cetakplanogram(){
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;Filename=planogram_".$_GET['toko_kode'].".xls");
		
		$DataPlanogram = $this->planogram_model->getDataPlanogramCetak($_GET);
		
		$html = "<table border=\"1\">
                    <thead>
                        <tr>
							<th>RAK</th>
							<th>SHLV</th>
							<th>URUT</th>
							<th>KODE BARANG</th>
							<th>BARCODE</th>
                       		<th>NAMA BARANG</th>
							<th>KIRI-KANAN</th>
							<th>DEPAN-BELAKANG</th>
							<th>ATAS-BAWAH</th>
							<th>SALDO AKHIR</th>
                        </tr>
                    </thead>
                    <tbody>";
		foreach ($DataPlanogram as $key => $value) {
			$html .= "<tr data=\"".base64_encode(json_encode($value))."\">
						<td>".$value['rak']."</td>
						<td>".$value['shlv']."</td>
						<td>".$value['urut']."</td>
						<td>".$value['barang_kode']."</td>
						<td>".$value['barcode']."</td>
						<td>".$value['nama_barang']."</td>
						<td>".$value['kirikanan']."</td>
						<td>".$value['depanbelakang']."</td>
						<td>".$value['atasbawah']."</td>
						<td>".$value['saldo_akhir_kwt']."</td>
					  </tr>";
		}
		
		$html .= "</tbody>
				</table>";
		echo $html;
	}
}

?>