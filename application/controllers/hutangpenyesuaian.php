<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hutangpenyesuaian extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('hutangpenyesuaian_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('hutangpenyesuaian/home');
		$this->load->view('general/footer');
	}
	
	public function getdatahutangpenyesuaian(){
		$DataHutangPenyesuaian = $this->hutangpenyesuaian_model->getDataHutangPenyesuaian($_POST);
		
		$bukti = "";
		$html = "<table class=\"table table-striped table-bordered table-hover\" id=\"dataTables-hutangpenyesuaian\">
                    <thead>
                        <tr>
							<th>BUKTI</th>
                       		<th>TANGGAL</th>
							<th>SUPPLIER</th>
                            <th>JUMLAH</th>
							<th>NO PENGADAAN</th>
							<th>NO TT</th>
                        </tr>
                    </thead>
                    <tbody>";
		foreach ($DataHutangPenyesuaian as $key => $value) {
			$html .= "<tr data=\"".base64_encode(json_encode($value))."\">
						<td>".$value['bukti']."</td>
						<td>".$value['tanggal']."</td>
						<td>".$value['nama_supplier']."</td>
						<td align='right'>".number_format($value['jumlah'],2)."</td>
						<td>".$value['pengadaan_barang_bukti']."</td>
						<td>".$value['tukar_nota_bukti']."</td>
					  </tr>";
		}
		
		$html .= "</tbody>
				</table>";
		echo $html;
	}
	
	public function simpanhutangpenyesuaian(){
		$this->hutangpenyesuaian_model->SimpanHutangPenyesuaian($_POST);
	}
	
	public function hapushutangpenyesuaian(){
		$this->hutangpenyesuaian_model->HapusHutangPenyesuaian($_POST);
	}
}

?>