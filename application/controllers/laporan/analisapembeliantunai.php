<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Analisapembeliantunai extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('laporan_model');
		$this->load->model('kasbank_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('laporan/analisapembeliantunai');
		$this->load->view('general/footer');
	}
	
	public function getdatapembeliantunai(){
		$DataPembelianTunai = $this->laporan_model->getAnalisaPembelianTunai($_POST);
		
		$html = "<table class=\"table table-striped table-bordered table-hover\">
					<thead>
						<tr>
							<th class='text-center'>Tanggal</th>
							<th class='text-center'>Bukti</th>
							<th class='text-center'>Kode Supplier</th>
							<th class='text-center'>Nama Supplier</th>
							<th class='text-center'>DPP</th>
							<th class='text-center'>PPN</th>
							<th class='text-center'>Total</th>
							<th class='text-center'>Bukti Kasbank</th>
							<th class='text-center'>Jumlah Kasbank</th>
						</tr>
					</thead>
					<tbody>";
		
		$JumlahDPP = 0;
		$JumlahPPN = 0;
		$JumlahTotal = 0;
		$JumlahKasbank = 0;
		foreach($DataPembelianTunai as $key => $value){
			$status_hapus = "";
			if($value['is_hapus'] == "1"){
				$status_hapus = "<button onclick=\"AktifkanKasbankPembelianTunai('".$value['bukti']."')\" class=\"btn btn-danger btn-sm ask\" type=\"button\">
									<i class=\"fa fa-edit\"></i>
									&nbsp;&nbsp;Perbaiki
								</button>";
			}else{
				$status_hapus = "<button class=\"btn btn-success btn-sm ask\" type=\"button\">
									<i class=\"fa fa-check\"></i>
								</button>";
			}
			$bukti_kasbank = $value['bukti_kasbank'];
			if($bukti_kasbank == ""){
				$bukti_kasbank = "<button onclick=\"InsertKasbankPembelianTunai('".base64_encode(json_encode($value))."')\" class=\"btn btn-danger btn-sm ask\" type=\"button\">
									<i class=\"fa fa-edit\"></i>
									&nbsp;&nbsp;Perbaiki
								</button>";
			}
			$html .= "<tr>
						<td>".$value['tanggal']."</td>
						<td>".$value['bukti']."</td>
						<td>".$value['supplier_kode']."</td>
						<td>".$value['nama_supplier']."</td>
						<td align=\"right\">".number_format($value['dpp'],2)."</td>
						<td align=\"right\">".number_format($value['ppn'],2)."</td>
						<td align=\"right\">".number_format($value['total'],2)."</td>
						<td>".$bukti_kasbank."</td>
						<td align=\"right\">".number_format($value['jumlah_kasbank'],2)."</td>
					  </tr>";
					  
			$JumlahDPP += $value['dpp'];
			$JumlahPPN += $value['ppn'];
			$JumlahTotal += $value['total'];
			$JumlahKasbank += $value['jumlah_kasbank'];
		}
		
		$html .= "<tr>
					<td colspan=\"4\"><strong>Jumlah</strong></td>
					<td align=\"right\">".number_format($JumlahDPP,2)."</td>
					<td align=\"right\">".number_format($JumlahPPN,2)."</td>
					<td align=\"right\">".number_format($JumlahTotal,2)."</td>
					<td></td>
					<td align=\"right\">".number_format($JumlahKasbank,2)."</td>
				  </tr>";
		$html .= "</tbody></table>";
				  
		echo $html;
	}
	
	public function aktifkankasbank(){
		$this->laporan_model->AktifkanKasbankPembelianTunai($_POST);
	}
	
	public function insertkasbank(){
		$data = json_decode(base64_decode($_POST['data']), true);
		
		$ParamKasbank = array();
		$ParamKasbank['mode_form'] = "i";
		$ParamKasbank['mode'] = "KK";
		$ParamKasbank['kd_kb'] = "110";
		$ParamKasbank['kd_cb'] = "202";
		$ParamKasbank['tanggal'] = $data['tanggal'];
		$ParamKasbank['kd_subject'] = $data['supplier_kode'];
		$ParamKasbank['nama_subject'] = $data['nama_supplier'];
		$ParamKasbank['keterangan'] = "PEMBELIAN TUNAI ATAS BUKTI ".$data['bukti'];
		$ParamKasbank['jumlah'] = $data['total'];
		$ParamKasbank['no_ref'] = $data['bukti'];
		$ParamKasbank['unit_kode'] = 'VO0008';
		
		$this->kasbank_model->SimpanKasbank($ParamKasbank);
	}
}