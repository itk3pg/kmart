<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pembelianjasa extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('pembelianjasa_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('pembelianjasa/home');
		$this->load->view('general/footer');
	}
	
	public function getdatapembelianjasa(){
		$DataPembelianJasa = $this->pembelianjasa_model->getDataPembelianJasa($_POST);
		
		$bukti = "";
		$html = "<table class=\"table table-striped table-bordered table-hover\" id=\"dataTables-pembelian-jasa\">
                    <thead>
                        <tr>
                       		<th>Tanggal</th>
                       		<th>Bukti</th>
							<th>Ref Event</th>
							<th>Supplier</th>
                            <th>Jasa</th>
                            <th>KWT</th>
                            <th>Harga</th>
                            <th>PPn</th>
							<th>PPh</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>";
		foreach ($DataPembelianJasa as $key => $value) {
			$jumlah = ($value['harga'] + $value['ppn']) * $value['kwt'];
			
			$html .= "<tr data=\"".base64_encode(json_encode($value))."\">";
			if($bukti != $value['bukti']){
				$html .= "<td>".$value['tanggal']."</td>
						  <td>".$value['bukti']."</td>
						  <td>".$value['ref_order']."</td>
						  <td>".$value['nama_supplier']."</td>";
				$bukti = $value['bukti'];
			}else{
				$html .= "<td></td>
						  <td></td>
						  <td></td>
						  <td></td>";
			}
			$html .= "	<td>".$value['nama_jasa']."</td>
						<td align='right'>".$value['kwt']."</td>
						<td align=\"right\">".number_format($value['harga'],2,",",".")."</td>
						<td align=\"right\">".number_format($value['ppn'],2,",",".")."</td>
						<td align=\"right\">".number_format($value['pph'],2,",",".")."</td>
						<td align=\"right\">".number_format($jumlah,2,",",".")."</td>
					  </tr>";
		}

		$html .= "</tbody></table>";
		
		echo $html;
	}
	
	public function getbuktiuangmuka(){
		$DataBuktiUM = $this->pembelianjasa_model->getBuktiUangMuka($_POST);
		
		$html = "<option value=\"-1\">Cari Bukti</option>";
		foreach ($DataBuktiUM as $key => $value) {
			$html .= "<option value=\"".$value['bukti']."-".$value['jumlah']."\">".$value['bukti']."</option>";
		}
		
		echo $html;
	}
	
	function removeCurrency($currency){
		$b = str_replace(".","",$currency);;
		$b = str_replace(',', '.', $b);
		
		return $b;
	}
	
	public function simpanpembelianjasa(){
		$this->load->model('hutang_model');
		$this->load->model('kasbank_model');
		$dataArr = json_decode(rawurldecode($_POST['data']));
		$JumlahPembelian = 0;
		//$index = 0;
		for($index=0;$index<sizeof($dataArr);$index = $index + 8){
			$jasa_kode = $dataArr[$index];
			$kwt = $dataArr[$index+2];
			$harga = $this->removeCurrency($dataArr[$index+3]);
			$ppn = $this->removeCurrency($dataArr[$index+4]);
			$pph = $this->removeCurrency($dataArr[$index+5]);
			$total = $this->removeCurrency($dataArr[$index+6]);
			
			$_POST['jasa_kode'] = $jasa_kode;
			$_POST['kwt'] = $kwt;
			$_POST['harga'] = $harga;
			$_POST['ppn'] = $ppn;
			if($pph == ""){
				$_POST['pph'] = "0";
			}else{
				$_POST['pph'] = $pph;
			}
			$_POST['jumlah'] = $total;
			
			$this->pembelianjasa_model->SimpanPembelianJasa($_POST);
			
			$JumlahPembelian += $total;
		}
		
		$DataPembelian = $this->pembelianjasa_model->checkData($_POST['bukti']);
		//print_r($DataPembelian);
		if(sizeof($DataPembelian) > 0){
			if($_POST['status_pembayaran'] == "K"){ // kredit
				// insert uang muka
				if($_POST['bukti_um'] != ""){
					$jumlah_um = 0;
					if($_POST['uang_muka'] > $DataPembelian[0]['jumlah']){
						$_POST['jumlah_um'] = $DataPembelian[0]['jumlah'];
						$_POST['sisa_um'] = $_POST['uang_muka'] - $DataPembelian[0]['jumlah'];
					}else{
						$_POST['jumlah_um'] = $_POST['uang_muka'];
						$_POST['sisa_um'] = 0;
					}
					
					$this->pembelianjasa_model->SimpanUangMuka($_POST);
					//$DataPembelian[0]['jumlah'] = $DataPembelian[0]['jumlah'] - $_POST['jumlah_um'];
				}
				// insert hutang
				if($DataPembelian[0]['jumlah'] > 0){
					$DataPembelian[0]['jatuh_tempo'] = $_POST['jatuh_tempo'];
					$this->hutang_model->SimpanHutang($DataPembelian[0]);
					
					if($_POST['bukti_um'] != ""){
						// insert pembayaran hutang (imbas dari uang muka yang dianggap sebagai pembayaran)
						$ParamPembayaran = array();
						$ParamPembayaran['mode_form'] = 1;
						$ParamPembayaran['ref_pengadaan'] = $DataPembelian[0]['bukti'];
						$ParamPembayaran['supplier_kode'] = $DataPembelian[0]['supplier_kode'];
						$ParamPembayaran['nama_supplier'] = $DataPembelian[0]['nama_supplier'];
						$ParamPembayaran['tanggal'] = $DataPembelian[0]['tanggal'];
						$ParamPembayaran['jumlah'] = $_POST['jumlah_um'];
						$ParamPembayaran['pembayaran_dari'] = "110";
						$this->hutang_model->SimpanPembayaran($ParamPembayaran);
					}
				}
			}else{ // tunai
				// insert kasbank pembelian tunai
				$ParamKasbank = array();
				$ParamKasbank['mode_form'] = "i";
				$ParamKasbank['mode'] = "KK";
				$ParamKasbank['kd_kb'] = "110";
				$ParamKasbank['kd_cb'] = "202";
				$ParamKasbank['tanggal'] = $DataPembelian[0]['tanggal'];
				$ParamKasbank['kode_subject'] = $DataPembelian[0]['supplier_kode'];
				$ParamKasbank['nama_subject'] = $DataPembelian[0]['nama_supplier'];
				$ParamKasbank['keterangan'] = "PEMBELIAN TUNAI";
				$ParamKasbank['jumlah'] = $DataPembelian[0]['jumlah'];
				$ParamKasbank['no_ref'] = $DataPembelian[0]['bukti'];
				
				$this->kasbank_model->SimpanKasbank($ParamKasbank);
			}
		}
	}
	
	public function hapuspembelianjasa(){
		$this->load->model('hutang_model');
		$this->load->model('kasbank_model');
		
		$DataPembelian = $this->pembelianjasa_model->checkData($_POST['bukti']);
		$_POST['tanggal'] = $DataPembelian[0]['tanggal'];
		$_POST['supplier_kode'] = $DataPembelian[0]['supplier_kode'];
		$this->pembelianjasa_model->HapusPembelianJasa($_POST);
		
		// hapus um, hapus hutang, hapus pembayaran
		$this->pembelianjasa_model->HapusUangMuka($_POST);
		$this->hutang_model->HapusSemuaPembayaran($_POST);
		$this->hutang_model->HapusHutang($_POST);
		// hapus kasabank pembelian tunai
		
		$_POST['kd_kb'] = "110";
		$this->kasbank_model->HapusKasbank($_POST);
	}
	
	public function getdatajasaji(){
		$DataJasaJI = $this->pembelianjasa_model->getDataJasaJI($_POST);
		
		$html = "";
		foreach ($DataJasaJI as $key => $value) {
			$html .= "<tr>
						<td>".$value['jasa_kode']."</td>
						<td>".$value['nama_jasa']."</td>
						<td class=\"text-right\">".$value['kwt']."</td>
						<td class=\"text-right\">".$value['harga']."</td>
						<td class=\"text-right\">".$value['ppn']."</td>
						<td class=\"text-right\">".$value['pph']."</td>
						<td class=\"text-right\">".$value['jumlah']."</td>
						<td><button type=\"button\" onclick=\"HapusRow(this)\" class=\"btn btn-default\"><i class=\"fa fa-times\"></i></button></td>
					</tr>";
		}
		
		echo $html;
	}
}
