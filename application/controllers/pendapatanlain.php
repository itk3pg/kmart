<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pendapatanlain extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('pendapatanlain_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('pendapatanlain/home');
		$this->load->view('general/footer');
	}
	
	public function getdatapendapatanlain(){
		$DataPendapatanLain = $this->pendapatanlain_model->getDataPendapatanLain($_POST);
		
		$bukti = "";
		$html = "<table class=\"table table-striped table-bordered table-hover\" id=\"dataTables-pendapatanlain\">
                    <thead>
                        <tr>
							<th>BUKTI</th>
                       		<th>TANGGAL</th>
                       		<th>TOKO</th>
							<th>SUPPLIER</th>
							<th>DPP</th>
							<th>PPN</th>
                            <th>JUMLAH</th>
                            <th>STATUS</th>
							<th>NO TT</th>
							<th>NO KASBANK</th>
                        </tr>
                    </thead>
                    <tbody>";
		foreach ($DataPendapatanLain as $key => $value) {
			$Status = $value['status_pembayaran']=='0' ? "Potong Hutang" : "Tunai";
			$html .= "<tr data=\"".base64_encode(json_encode($value))."\">
						<td>".$value['bukti']."</td>
						<td>".$value['tanggal']."</td>
						<td>".$value['nama_toko']."</td>
						<td>".$value['nama_supplier']."</td>
						<td align='right'>".number_format($value['dpp'],2)."</td>
						<td align='right'>".number_format($value['ppn'],2)."</td>
						<td align='right'>".number_format($value['jumlah'],2)."</td>
						<td>".$Status."</td>
						<td>".$value['tukar_nota_bukti']."</td>
						<td>".$value['kasbank_bukti']."</td>
					  </tr>";
		}
		
		$html .= "</tbody>
				</table>";
		echo $html;
	}
	
	public function getdetailpendapatanlain(){
		$DataPendapatanLain = $this->pendapatanlain_model->getDetailPendapatanLain($_POST);
		
		$html = "";
		foreach ($DataPendapatanLain as $key => $value) {
			$html .= "<tr><td>".$value['keterangan']."</td><td class=\"text-right\">".round($value['dpp'],2)."</td><td class=\"text-right\">".round($value['ppn'],2)."</td><td class=\"text-right\">".round($value['jumlah'],2)."</td><td class=\"text-center\"><button type=\"button\" style=\"padding: 0px 20px;\" onclick=\"HapusRow(this)\" class=\"btn btn-danger btn-sm\"><i class=\"fa fa-times\"></i></button></td></tr>";
		}
		
		echo $html;
	}
	
	public function simpanpendapatanlain(){
		$this->pendapatanlain_model->SimpanPendapatanLain($_POST);
	}
	
	public function hapuspendapatanlain(){
		$this->pendapatanlain_model->HapusPendapatanLain($_POST);
	}

	public function bukaakses(){
		$this->pendapatanlain_model->BukaAkses($_POST);
	}
	
	public function getdatapendapatanlainpotongan(){
		$DataPendapatanLain = $this->pendapatanlain_model->getDataPendapatanLainPotongan($_POST);
		
		$html = "";
		foreach($DataPendapatanLain as $key => $value){
			$html .= "<tr>
						<td>".$value['bukti']."</td>
						<td>".$value['tanggal']."</td>
						<td>".$value['keterangan']."</td>
						<td class=\"text-right\">".number_format($value['jumlah'],2)."</td>";
			if(isset($_POST['supplier_kode'])){
				$html .= "<td>
							<button type=\"button\" style=\"padding: 1px 6px;\" onclick=\"HapusRow(this)\" class=\"btn btn-danger btn-sm\"><i class=\"fa fa-times\"></i></button>
						</td>";
			}else{
				$html .= "<td></td>";
			}
			$html .= "</tr>";
		}
		
		echo $html;
	}

	public function cetakpendapatanlain(){
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;Filename=rekap_pendapatan_lain_".$_GET['bulan']."_".$_GET['tahun'].".xls");

		$DataPendapatanLain = $this->pendapatanlain_model->getDataPendapatanLainCetak($_GET);
		
		$html = "<table>
					<tr>
						<td colspan=\"6\" align=\"center\">Rekap Pendapatan Lain</td>
					</tr>
					<tr>
						<td colspan=\"6\" align=\"center\">".$_GET['bulan']." / ".$_GET['tahun']."</td>
					</tr>
					<tr>
						<td colspan=\"6\" align=\"center\">".date("Y-m-d")."</td>
					</tr>
				 </table>";
		$html .= "<table border=\"1\">
                    <thead>
                        <tr>
							<th>BUKTI</th>
                       		<th>TANGGAL</th>
                       		<th>TOKO</th>
							<th>SUPPLIER</th>
							<th>KETERANGAN</th>
							<th>DPP</th>
							<th>PPN</th>
                            <th>JUMLAH</th>
                            <th>STATUS</th>
							<th>NO TT</th>
							<th>NO KASBANK</th>
                        </tr>
                    </thead>
                    <tbody>";
		foreach ($DataPendapatanLain as $key => $value) {
			$Status = $value['status_pembayaran']=='0' ? "Potong Hutang" : "Tunai";
			$html .= "<tr data=\"".base64_encode(json_encode($value))."\">
						<td>".$value['bukti']."</td>
						<td>".$value['tanggal']."</td>
						<td>".$value['nama_toko']."</td>
						<td>".$value['nama_supplier']."</td>
						<td>".$value['keterangan']."</td>
						<td align='right'>".number_format($value['dpp'],2)."</td>
						<td align='right'>".number_format($value['ppn'],2)."</td>
						<td align='right'>".number_format($value['jumlah'],2)."</td>
						<td>".$Status."</td>
						<td>".$value['tukar_nota_bukti']."</td>
						<td>".$value['kasbank_bukti']."</td>
					  </tr>";
		}
		
		$html .= "</tbody>
				</table>";
		echo $html;
	}
}

?>