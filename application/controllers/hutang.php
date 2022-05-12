<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hutang extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('hutang_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('hutang/home');
		$this->load->view('general/footer');
	}
	
	public function getdatahutang(){
		$DataHutang = $this->hutang_model->getDataHutang($_POST);
		
		$html = "<table class=\"table table-striped table-bordered table-hover\" id=\"dataTables-hutang\">
                    <thead>
                        <tr>
                       		<th>Tanggal</th>
                       		<th>Supplier</th>
                            <th>No Ref.</th>
                            <th>Jatuh Tempo</th>
                            <th>Hutang</th>
                            <th>Bayar</th>
                            <th>Sisa</th>
                        </tr>
                    </thead>
                    <tbody>";
		foreach ($DataHutang as $key => $value) {
			$sisa = $value['jumlah'] - $value['jumlah_bayar'];
			$sisaStr = number_format($sisa,2,",",".");
			if($sisa == 0){
				$sisaStr = "Lunas";
			}
			$html .= "<tr id=\"".$value['ref_pengadaan']."\" bukti=\"".$value['ref_pengadaan']."\" nama_supplier=\"".$value['nama_supplier']."\" supplier_kode=\"".$value['supplier_kode']."\" hutang=\"".$value['jumlah']."\" sisa=\"".$sisa."\">
						<td>".$value['tanggal']."</td>
						<td>".$value['nama_supplier']."</td>
						<td>".$value['ref_pengadaan']."</td>
						<td>".$value['jatuh_tempo']."</td>
						<td align=\"right\">".number_format($value['jumlah'],2,",",".")."</td>
						<td align=\"right\">".number_format($value['jumlah_bayar'],2,",",".")."</td>
						<td align=\"right\">".$sisaStr."</td>
					  </tr>";
		}
		$html .= "</tbody>
				</table>";
		echo $html;
	}
	
	public function getlisthutang(){
		$DataHutang = $this->hutang_model->getListDataHutang($_GET);
		$jumlahdata = sizeof($DataHutang);
		$DataResult = array();
		$DataResult['total_count'] = $jumlahdata;
		$DataResult['incomplete_results'] = false;
		$DataResult['items'] = $DataHutang;
		
		echo json_encode($DataResult);
	}
	
	public function getlisthutangpenyesuaian(){
		$DataHutang = $this->hutang_model->getListDataHutangPenyesuaian($_GET);
		$jumlahdata = sizeof($DataHutang);
		$DataResult = array();
		$DataResult['total_count'] = $jumlahdata;
		$DataResult['incomplete_results'] = false;
		$DataResult['items'] = $DataHutang;
		
		echo json_encode($DataResult);
	}
	
	public function getdetailpembayaran(){
		$DataPembayaran = $this->hutang_model->getDetailPembayaran($_POST);
		
		$jumlahAll = 0;
		$html = "<table class=\"table table-striped table-bordered table-hover\" id=\"dataTables-pembayaran\">
                    <thead>
                        <tr>
                       		<th>Tanggal</th>
                       		<th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>";
		foreach ($DataPembayaran as $key => $value) {
			$html .= "<tr id_pembayaran=\"".$value['id_pembayaran']."\" tanggal=\"".$value['tanggal']."\" ref_kasbank=\"".$value['ref_kasbank']."\" jm_bayar=\"".$value['jumlah']."\">
						<td>".$value['tanggal']."</td>
						<td align=\"right\">".number_format($value['jumlah'],2,",",".")."</td>
					  </tr>";
			$jumlahAll += $value['jumlah'];
		}
		$html .= "<tr>
					<td>TOTAL</td>
					<td align=\"right\">".number_format($jumlahAll,2,",",".")."</td>
				  </tr>";
		$html .= "</tbody>
				</table>";
		echo $html;
	}
	
	public function simpanpembayaran(){
		$this->hutang_model->SimpanPembayaran($_POST);
	}
	
	public function hapuspembayaran(){
		$this->hutang_model->HapusPembayaran($_POST);
	}
}
