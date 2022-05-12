<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rekapretursupplier extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('laporan_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('laporan/rekapretursupplier');
		$this->load->view('general/footer');
	}
	
	public function getrekapretursupplier(){
		$DataReturSupplier = $this->laporan_model->getRekapReturSupplier($_POST);
		
		$html = "<table class=\"table table-striped table-bordered table-hover\">
					<thead>
						<tr>
							<th class='text-center'>Bukti</th>
							<th class='text-center'>Tanggal</th>
							<th class='text-center'>Supplier</th>
							<th class='text-center'>Bukti TT</th>
							<th class='text-center'>User</th>
							<th class='text-center'>DPP</th>
							<th class='text-center'>PPN</th>
							<th class='text-center'>Total</th>
						</tr>
					</thead>
					<tbody>";
		
		$TotalSupplierDPP = 0;
		$TotalSupplierPPN = 0;
		$TotalSupplierAll = 0;
		$TotalDPP = 0;
		$TotalPPN = 0;
		$TotalAll = 0;
		$supplier_kode = "";
		if($_POST['mode'] == "supplier"){
			foreach ($DataReturSupplier as $key => $value) {
				if($supplier_kode == ""){
					$supplier_kode = $value['supplier_kode'];
				}
				if($supplier_kode != $value['supplier_kode']){
					$html .= "<tr>
								<td colspan=\"5\"><strong>Sub Total</strong></td>
								<td align=\"right\"><strong>".number_format($TotalSupplierDPP,2)."</strong></td>
								<td align=\"right\"><strong>".number_format($TotalSupplierPPN,2)."</strong></td>
								<td align=\"right\"><strong>".number_format($TotalSupplierAll,2)."</strong></td>
							  </tr>";
					$TotalSupplierDPP = 0;
					$TotalSupplierPPN = 0;
					$TotalSupplierAll = 0;
					$supplier_kode = $value['supplier_kode'];
				}
				$html .= "<tr>
							<td>".$value['bukti']."</td>
							<td>".$value['tanggal']."</td>
							<td>".$value['nama_supplier']."</td>
							<td>".$value['tukar_nota_bukti']."</td>
							<td>".$value['nama_user']."</td>
							<td align=\"right\">".number_format($value['dpp'],2)."</td>
							<td align=\"right\">".number_format($value['ppn'],2)."</td>
							<td align=\"right\">".number_format($value['total'],2)."</td>
						</tr>";
				
				$TotalSupplierDPP += $value['dpp'];
				$TotalSupplierPPN += $value['ppn'];
				$TotalSupplierAll += $value['total'];
				$TotalDPP += $value['dpp'];
				$TotalPPN += $value['ppn'];
				$TotalAll += $value['total'];
			}
			$html .= "<tr>
						<td colspan=\"5\"><strong>Sub Total</strong></td>
						<td align=\"right\"><strong>".number_format($TotalSupplierDPP,2)."</strong></td>
						<td align=\"right\"><strong>".number_format($TotalSupplierPPN,2)."</strong></td>
						<td align=\"right\"><strong>".number_format($TotalSupplierAll,2)."</strong></td>
					  </tr>";
		}else{
			foreach ($DataReturSupplier as $key => $value) {
				$html .= "<tr>
							<td>".$value['bukti']."</td>
							<td>".$value['tanggal']."</td>
							<td>".$value['nama_supplier']."</td>
							<td>".$value['tukar_nota_bukti']."</td>
							<td>".$value['nama_user']."</td>
							<td align=\"right\">".number_format($value['dpp'],2)."</td>
							<td align=\"right\">".number_format($value['ppn'],2)."</td>
							<td align=\"right\">".number_format($value['total'],2)."</td>
						</tr>";
						
				$TotalDPP += $value['dpp'];
				$TotalPPN += $value['ppn'];
				$TotalAll += $value['total'];
			}
		}
		$html .= "<tr>
					<td colspan=\"5\"><strong>Total</strong></td>
					<td align=\"right\"><strong>".number_format($TotalDPP,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalPPN,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalAll,2)."</strong></td>
				  </tr>";
		$html .= "</tbody></table>";
		
		echo $html;
	}
	
	public function cetakrekapretursupplier(){
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;Filename=rekap_retur_supplier_".$_GET['bulan']."_".$_GET['tahun'].".xls");
		
		$html = "<table>
					<tr>
						<td colspan=\"4\"><strong>KOPERASI KARYAWAN KELUARGA BESAR PETROKIMIA GRESIK</strong></td>
						<td align=\"right\" colspan=\"4\"><strong>TGL. : ".date("d-m-Y H:i:s")."</strong></th>
					</tr>
					<tr>
						<td colspan=\"4\"><strong>K-Mart</strong></td>
						<td colspan=\"4\"></th>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"8\"><strong>REKAP RETUR SUPPLIER</strong></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"8\"><strong>PERIODE : ".$_GET['bulan']." - ".$_GET['tahun']."</strong></td>
					</tr>
				 </table>";
		$DataReturSupplier = $this->laporan_model->getRekapReturSupplier($_GET);
		
		$html .= "<table border=\"1\">
					<thead>
						<tr>
							<th class='text-center'>Bukti</th>
							<th class='text-center'>Tanggal</th>
							<th class='text-center'>Supplier</th>
							<th class='text-center'>Bukti TT</th>
							<th class='text-center'>User</th>
							<th class='text-center'>DPP</th>
							<th class='text-center'>PPN</th>
							<th class='text-center'>Total</th>
						</tr>
					</thead>
					<tbody>";
		
		$TotalSupplierDPP = 0;
		$TotalSupplierPPN = 0;
		$TotalSupplierAll = 0;
		$TotalDPP = 0;
		$TotalPPN = 0;
		$TotalAll = 0;
		$supplier_kode = "";
		if($_GET['mode'] == "supplier"){
			foreach ($DataReturSupplier as $key => $value) {
				if($supplier_kode == ""){
					$supplier_kode = $value['supplier_kode'];
				}
				if($supplier_kode != $value['supplier_kode']){
					$html .= "<tr>
								<td colspan=\"5\"><strong>Sub Total</strong></td>
								<td align=\"right\"><strong>".number_format($TotalSupplierDPP,2)."</strong></td>
								<td align=\"right\"><strong>".number_format($TotalSupplierPPN,2)."</strong></td>
								<td align=\"right\"><strong>".number_format($TotalSupplierAll,2)."</strong></td>
							  </tr>";
					$TotalSupplierDPP = 0;
					$TotalSupplierPPN = 0;
					$TotalSupplierAll = 0;
					$supplier_kode = $value['supplier_kode'];
				}
				$html .= "<tr>
							<td>".$value['bukti']."</td>
							<td>".$value['tanggal']."</td>
							<td>".$value['nama_supplier']."</td>
							<td>".$value['tukar_nota_bukti']."</td>
							<td>".$value['nama_user']."</td>
							<td align=\"right\">".number_format($value['dpp'],2)."</td>
							<td align=\"right\">".number_format($value['ppn'],2)."</td>
							<td align=\"right\">".number_format($value['total'],2)."</td>
						</tr>";
				
				$TotalSupplierDPP += $value['dpp'];
				$TotalSupplierPPN += $value['ppn'];
				$TotalSupplierAll += $value['total'];
				$TotalDPP += $value['dpp'];
				$TotalPPN += $value['ppn'];
				$TotalAll += $value['total'];
			}
			$html .= "<tr>
						<td colspan=\"5\"><strong>Sub Total</strong></td>
						<td align=\"right\"><strong>".number_format($TotalSupplierDPP,2)."</strong></td>
						<td align=\"right\"><strong>".number_format($TotalSupplierPPN,2)."</strong></td>
						<td align=\"right\"><strong>".number_format($TotalSupplierAll,2)."</strong></td>
					  </tr>";
		}else{
			foreach ($DataReturSupplier as $key => $value) {
				$html .= "<tr>
							<td>".$value['bukti']."</td>
							<td>".$value['tanggal']."</td>
							<td>".$value['nama_supplier']."</td>
							<td>".$value['tukar_nota_bukti']."</td>
							<td>".$value['nama_user']."</td>
							<td align=\"right\">".number_format($value['dpp'],2)."</td>
							<td align=\"right\">".number_format($value['ppn'],2)."</td>
							<td align=\"right\">".number_format($value['total'],2)."</td>
						</tr>";
						
				$TotalDPP += $value['dpp'];
				$TotalPPN += $value['ppn'];
				$TotalAll += $value['total'];
			}
		}
		$html .= "<tr>
					<td colspan=\"5\"><strong>Total</strong></td>
					<td align=\"right\"><strong>".number_format($TotalDPP,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalPPN,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalAll,2)."</strong></td>
				  </tr>";
		$html .= "</tbody></table>";
		$html .= "<table>
					<tr>
						<td align=\"center\" colspan=\"4\">Mengetahui</td>
						<td align=\"center\" colspan=\"4\">Yang membuat</td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"4\"></td>
						<td align=\"center\" colspan=\"4\"></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"4\"></td>
						<td align=\"center\" colspan=\"4\"></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"4\"></td>
						<td align=\"center\" colspan=\"4\"></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"4\"><strong>(..............................)</strong></td>
						<td align=\"center\" colspan=\"4\"><strong>(..............................)</strong></td>
					</tr>
				  </table>";
		
		echo $html;
	}
}
?>