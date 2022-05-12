<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hargabarangtoko extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('laporan_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('laporan/hargabarangtoko');
		$this->load->view('general/footer');
	}
	
	public function getkategoribarang(){
		$DataKategori = $this->laporan_model->getKategoriBarang();
		
		$html = "<option value=\"\">SEMUA</option>";
		foreach($DataKategori as $key => $value){
			$html .= "<option value=\"".$value['kode']."\">".$value['nama']."</option>";
		}
		
		echo $html;
	}
	
	public function getdatabarang(){
		$DataBarang = $this->laporan_model->getDataBarang($_POST);
		
		$html = "";
		foreach($DataBarang as $key => $value){
			$selisih = $value['harga_jual'] - $value['hpp'];
			$persentase = 0;
			if($value['hpp'] > 0){
				$persentase = ($selisih/$value['hpp']) * 100;
			}
			$html .= "<tr data=\"".base64_encode(json_encode($value))."\">
						<td>".$value['kode']."</td>
						<td>".$value['barcode']."</td>
						<td>".$value['nama_barang']."</td>
						<td>".$value['satuan']."</td>
						<td align=\"right\">".number_format($value['hpp'],2)."</td>
						<td align=\"right\">".number_format($value['harga_jual'], 2)."</td>
						<td align=\"right\">".number_format($persentase,2)."</td>
					  </tr>";
		}
		
		echo $html;
	}
	
	public function getdataharga(){
		$DataHarga = $this->laporan_model->getDataHarga($_POST);
		
		$html = "";
		foreach($DataHarga as $key => $value){
			$selisih = $value['harga1'] - $value['hpp'];
			$persentase = 0;
			if($value['hpp'] > 0){
				$persentase = ($selisih/$value['hpp']) * 100;
			}
			$html .= "<tr data=\"".base64_encode(json_encode($value))."\">
						<td>".$value['nama_toko']."</td>
						<td align=\"right\">".number_format($value['hpp'],2)."</td>
						<td align=\"right\">".number_format($value['harga1'], 2)."</td>
						<td align=\"right\">".number_format($persentase,2)."</td>
					  </tr>";
		}
		
		echo $html;
	}
}