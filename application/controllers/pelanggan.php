<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pelanggan extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('pelanggan_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');

		$dataPrsh = $this->pelanggan_model->getDataPrsh();
		$data['data_prsh'] = $dataPrsh;
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('master/pelanggan', $data);
		$this->load->view('general/footer');
	}
	
	public function getdatapelanggan(){
		$DataPelanggan = $this->pelanggan_model->getDataPelanggan();
		
		$html = "<table class=\"table table-striped table-bordered table-hover\" id=\"dataTables-pelanggan\">
                    <thead>
                        <tr>
                       		<th>KD PELANGGAN</th>
                       		<th>JENIS PELANGGAN</th>
                       		<th>NAMA PELANGGAN</th>
                            <th>ALAMAT</th>
                            <th>KOTA</th>
                            <th>PROVINSI</th>
							<th>NO TELP</th>
							<th>PRSH</th>
                        </tr>
                    </thead>
                    <tbody>";
		foreach ($DataPelanggan as $key => $value) {
			$html .= "<tr data=\"".base64_encode(json_encode($value))."\" kode=\"".$value['kode']."\">
						<td>".$value['kode']."</td>
						<td>".$value['nama_jenis']."</td>
						<td>".$value['nama_pelanggan']."</td>
						<td>".$value['alamat']."</td>
						<td>".$value['kota']."</td>
						<td>".$value['provinsi']."</td>
						<td>".$value['no_telp']."</td>
						<td>".$value['kd_prsh']."</td>
					  </tr>";
		}
		
		$html .= "</tbody>
				</table>";
		echo $html;
	}

	public function getdatajenispelanggan(){
		$DataJenisPelanggan = $this->pelanggan_model->getDataJenisPelanggan();
		
		$no = 1;
		$html = "<table class=\"table table-striped table-bordered table-hover\" id=\"dataTables-jenispelanggan\">
                    <thead>
                        <tr>
                       		<th>NO</th>
                       		<th>JENIS PELANGGAN</th>
                        </tr>
                    </thead>
                    <tbody>";
		foreach ($DataJenisPelanggan as $key => $value) {
			$html .= "<tr data=\"".base64_encode(json_encode($value))."\" kode=\"".$value['kode']."\">
						<td>".$no."</td>
						<td>".$value['nama']."</td>
					  </tr>";
			$no++;
		}
		
		$html .= "</tbody>
				</table>";
		echo $html;
	}

	public function getselectpelanggan(){
		$DataPelanggan = $this->pelanggan_model->getDataPelanggan();
		
		$html = "<option value=\"-1\">Pilih Pelanggan</option>";
		foreach ($DataPelanggan as $key => $value) {
			$html .= "<option value=\"".$value['kode']."\">".$value['nama_pelanggan']."</option>";
		}
		
		echo $html;
	}
	
	public function getselectjenispelanggan(){
		$DataJenisPelanggan = $this->pelanggan_model->getDataJenisPelanggan();
		
		$html = "";
		foreach ($DataJenisPelanggan as $key => $value) {
			$html .= "<option value=\"".$value['kode']."\">".$value['nama']."</option>";
		}
		
		echo $html;
	}
	
	public function getlistpelanggan(){
		$DataPelanggan = $this->pelanggan_model->getListDataPelanggan($_GET);
		$jumlahdata = sizeof($DataPelanggan);
		$DataResult = array();
		$DataResult['total_count'] = $jumlahdata;
		$DataResult['incomplete_results'] = false;
		$DataResult['items'] = $DataPelanggan;
		
		echo json_encode($DataResult);
	}
	
	public function hapuspelanggan(){
		$this->pelanggan_model->HapusPelanggan($_POST);
	}
	
	public function hapusjenispelanggan(){
		$this->pelanggan_model->HapusJenisPelanggan($_POST);
	}
	
	public function simpanpelanggan(){
		$this->pelanggan_model->SimpanPelanggan($_POST);
	}
	
	public function simpanjenispelanggan(){
		$this->pelanggan_model->SimpanJenisPelanggan($_POST);
	}
}
