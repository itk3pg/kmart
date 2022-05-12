<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Promo extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('promo_model');
		$this->load->model('toko_model');
		$this->load->model('barang_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('master/promo');
		$this->load->view('general/footer');
	}
	
	public function getdatapromo(){
		$DataPromo = $this->promo_model->getDataPromo($_POST);
		
		$html = "<table class=\"table table-striped table-bordered table-hover\" id=\"dataTables-promo\">
                    <thead>
                        <tr>
                       		<th>KODE</th>
                            <th>TOKO</th>
                            <th>BARCODE</th>
                            <th>BARANG</th>
                            <th>HARGA</th>
							<th>PERIODE</th>
                            <th>PERSENTASE (%)</th>
                            <th>KELIPATAN</th>
                            <th>POTONGAN HARGA</th>
                        </tr>
                    </thead>
                    <tbody>";
		foreach ($DataPromo as $key => $value) {
			$html .= "<tr data=\"".base64_encode(json_encode($value))."\">
						<td>".$value['kode']."</td>
						<td>".$value['nama_toko']."</td>
						<td>".$value['barang_kode']."</td>
						<td>".$value['nama_barang']."</td>
						<td align=\"right\">".number_format($value['harga1'])."</td>
						<td>".$value['tanggal_awal']." / ".$value['tanggal_akhir']."</td>
						<td align=\"right\">".$value['persentase_promo']."</td>
						<td align=\"right\">".$value['kwt_kondisi']."</td>
						<td align=\"right\">".number_format($value['harga_promo'],2)."</td>
					  </tr>";
		}
		
		$html .= "</tbody>
				</table>";
		echo $html;
	}
	
	public function simpanpromo(){
		$dataArr = json_decode(rawurldecode($_POST['data']));
		
		if($_POST['toko_kode'] == "-"){
			$DataToko = $this->toko_model->getDataToko();
			foreach ($DataToko as $key => $value) {
				$_POST['toko_kode'] = $value['kode'];
				$this->promo_model->HapusPromoToko($_POST);
				for($index=0;$index<sizeof($dataArr);$index = $index + 6){
					$barang_kode = $dataArr[$index];
					$paramHarga = array();
					$paramHarga['toko_kode'] = $value['kode'];
					$paramHarga['barang_kode'] = $barang_kode;
					$DataHarga = $this->barang_model->getHargaBarangToko($paramHarga);
					
					if(sizeof($DataHarga) > 0){
						$persentase_promo = $dataArr[$index+2];
						$harga_promo = $this->removeCurrency($dataArr[$index+3]);
						if(($persentase_promo == "" || $persentase_promo="Infinity") && $harga_promo != ""){
							$persentase_promo = ($harga_promo/$DataHarga[0]['harga1']) * 100;
						}else if($persentase_promo != "" && $harga_promo == ""){
							$harga_promo = $DataHarga[0]['harga1'] * ($persentase_promo/100);
						}
						$kwt_kondisi = $dataArr[$index+4];
						
						$_POST['barang_kode'] = $barang_kode;
						$_POST['persentase_promo'] = $persentase_promo;
						$_POST['harga_promo'] = $harga_promo;
						$_POST['kwt_kondisi'] = $kwt_kondisi;
						
						$this->promo_model->SimpanPromo($_POST);
					}
				}
			}
		}else{
			$this->promo_model->HapusPromoToko($_POST);
			for($index=0;$index<sizeof($dataArr);$index = $index + 6){
				$barang_kode = $dataArr[$index];
				$persentase_promo = $dataArr[$index+2];
				$harga_promo = $dataArr[$index+3];
				$kwt_kondisi = $dataArr[$index+4];
				
				$_POST['barang_kode'] = $barang_kode;
				$_POST['persentase_promo'] = $persentase_promo;
				$_POST['harga_promo'] = $this->removeCurrency($harga_promo);
				$_POST['kwt_kondisi'] = $kwt_kondisi;
				
				$this->promo_model->SimpanPromo($_POST);
			}
		}
	}
	
	public function getdatabarangpromo(){
		$DataBarangPromo = $this->promo_model->getDataBarangPromo($_POST);
		
		$html = "";
		foreach ($DataBarangPromo as $key => $value) {
			$html .= "<tr>
						<td>".$value['barang_kode']."</td>
						<td>".$value['nama_barang']."</td>
						<td class=\"text-right\">".$value['persentase_promo']."</td>
						<td class=\"text-right\">".$value['harga_promo']."</td>
						<td class=\"text-right\">".$value['kwt_kondisi']."</td>
						<td><button type=\"button\" onclick=\"HapusRow(this)\" class=\"btn btn-default\"><i class=\"fa fa-times\"></i></button></td>
					</tr>";
		}
		
		echo $html;
	}
	
	public function hapuspromo(){
		$this->promo_model->HapusPromo($_POST);
	}

	public function restorepromo(){
		$this->promo_model->RestorePromo($_POST);
	}
	
	function removeCurrency($currency){
		$b = str_replace(".","",$currency);;
		$b = str_replace(',', '.', $b);
		
		return $b;
	}
}