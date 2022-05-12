<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Supplier extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('supplier_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('master/supplier');
		$this->load->view('general/footer');
	}
	
	public function getdatasupplier(){
		$DataSupplier = $this->supplier_model->getDataSupplier();
		
		$html = "<table class=\"table table-striped table-bordered table-hover display nowrap\" style=\"width:100%\" id=\"dataTables-supplier\">
                    <thead>
                        <tr>
                       		<th>KD SUPPLIER</th>
                       		<th>NAMA SUPPLIER</th>
							<th>NPWP</th>
                            <th>ALAMAT</th>
                            <th>KOTA</th>
                            <th>NO TELP</th>
                            <th>NAMA BANK</th>
                            <th>NO REK</th>
                            <th>ATAS NAMA</th>
                            <th>TOP</th>
                            <th>PKP</th>
                        </tr>
                    </thead>
                    <tbody>";
		foreach ($DataSupplier as $key => $value) {
			$html .= "<tr data=\"".base64_encode(json_encode($value))."\" kode=\"".$value['kode']."\">
						<td>".$value['kode']."</td>
						<td>".$value['nama_supplier']."</td>
						<td>".$value['npwp']."</td>
						<td>".$value['alamat']."</td>
						<td>".$value['kota']."</td>
						<td>".$value['no_telp']."</td>
						<td>".$value['nama_bank']."</td>
						<td>".$value['no_rekening']."</td>
						<td>".$value['atas_nama']."</td>
						<td>".$value['top']."</td>
						<td>".($value['pkp']=='1' ? '<strong>&#x2713;</strong>' : '<strong>-</strong>')."</td>
					  </tr>";
		}
		
		$html .= "</tbody>
				</table>";
		echo $html;
	}

	public function getselectsupplier(){
		$DataSupplier = $this->supplier_model->getDataSupplier();
		
		$html = "<option value=\"\">Pilih Supplier</option>";
		foreach ($DataSupplier as $key => $value) {
			$html .= "<option value=\"".$value['kode']."\">".$value['kode']." - ".$value['nama_supplier']."</option>";
		}
		
		echo $html;
	}

	public function getselectsupplierkonsinyasi(){
		$DataSupplier = $this->supplier_model->getDataSupplier();
		
		$html = "<option value=\"\">Pilih Supplier</option>";
		foreach ($DataSupplier as $key => $value) {
			$html .= "<option value=\"".$value['kode']."_wecode_".$value['fee_konsinyasi']."\">".$value['kode']." - ".$value['nama_supplier']."</option>";
		}
		
		echo $html;
	}
	
	public function getlistsupplier(){
		$DataSupplier = $this->supplier_model->getListDataSupplier($_GET);
		$jumlahdata = sizeof($DataSupplier);
		$DataResult = array();
		$DataResult['total_count'] = $jumlahdata;
		$DataResult['incomplete_results'] = false;
		$DataResult['items'] = $DataSupplier;
		
		echo json_encode($DataResult);
	}
	
	public function hapussupplier(){
		$_POST['kode'] = base64_decode($_POST['kode']);
		$result = $this->supplier_model->HapusSupplier($_POST);
		echo $result;
	}
	
	public function simpansupplier(){
		$_POST['kode'] = base64_decode($_POST['kode']);
		$_POST['nama_supplier'] = base64_decode($_POST['nama_supplier']);
		$result = $this->supplier_model->SimpanSupplier($_POST);
		echo $result;
	}
}
