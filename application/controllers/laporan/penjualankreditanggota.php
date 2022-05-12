<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Penjualankreditanggota extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('laporan_model');
		$this->load->model('toko_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$DataToko = $this->toko_model->getDataToko();
		
		$Param  = array();
		$Param['DataToko'] = $DataToko;
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('laporan/penjualankreditanggota', $Param);
		$this->load->view('general/footer');
	}
	
	public function getpenjualankreditanggota(){
		$DataPenjualanKreditAnggota = $this->laporan_model->getDataKreditAnggota($_POST);
		
		$html = "<table class=\"table table-striped table-bordered table-hover\">
					<thead>
						<tr>
							<th class='text-center'>No Pegawai</th>
							<th class='text-center'>No Anggota</th>
							<th class='text-center'>Nama Pegawai</th>
							<th class='text-center'>Instansi</th>
							<th class='text-center'>Jumlah</th>
						</tr>
					</thead>
					<tbody>";
		
		$Total = 0;
		$TotalAll = 0;
		$nm_prsh = "";
		foreach ($DataPenjualanKreditAnggota as $key => $value) {
			if($nm_prsh == ""){
				$nm_prsh = $value['nm_prsh'];
			}
			if($nm_prsh != $value['nm_prsh']){
				$html .= "<tr>
							<td colspan=\"4\"><strong>Sub Total</strong></td>
							<td align=\"right\"><strong>".number_format($Total)."</strong></td>
						  </tr>";
				$Total = 0;
				$nm_prsh = $value['nm_prsh'];
			}
			$html .= "<tr>
						<td>".$value['no_peg']."</td>
						<td>".$value['no_ang']."</td>
						<td>".$value['fcustname']."</td>
						<td>".$value['nm_prsh']."</td>
						<td align=\"right\">".number_format($value['fbill_amount'])."</td>
					</tr>";
			
			$Total += $value['fbill_amount'];
			$TotalAll += $value['fbill_amount'];
		}
		$html .= "<tr>
					<td colspan=\"4\"><strong>Sub Total</strong></td>
					<td align=\"right\"><strong>".number_format($Total)."</strong></td>
				  </tr>";
		$html .= "<tr>
					<td colspan=\"4\"><strong>Total</strong></td>
					<td align=\"right\"><strong>".number_format($TotalAll)."</strong></td>
				  </tr>";
		$html .= "</tbody></table>";
		
		echo $html;
	}
	
	public function cetakpenjualankreditanggota(){
		$DataPenjualanKreditAnggota = $this->laporan_model->getDataKreditAnggota($_GET);
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;Filename=penjualan_kredit_anggota_".$_GET['toko_kode']."_".$_GET['bulan']."_".$_GET['tahun'].".xls");
		
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
						<td align=\"center\" colspan=\"8\"><strong>LAPORAN PENJUALAN KREDIT ANGGOTA</strong></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"8\"><strong>PERIODE : ".$_GET['bulan']." - ".$_GET['tahun']."</strong></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"8\"><strong>Toko : ".$_GET['nama_toko']."</strong></td>
					</tr>
				 </table>";
		$html .= "<table border=\"1\">
					<thead>
						<tr>
							<th class='text-center'>No Pegawai</th>
							<th class='text-center'>No Anggota</th>
							<th class='text-center'>Nama Pegawai</th>
							<th class='text-center'>Instansi</th>
							<th class='text-center'>Jumlah</th>
						</tr>
					</thead>
					<tbody>";
		
		$Total = 0;
		$TotalAll = 0;
		$nm_prsh = "";
		foreach ($DataPenjualanKreditAnggota as $key => $value) {
			if($nm_prsh == ""){
				$nm_prsh = $value['nm_prsh'];
			}
			if($nm_prsh != $value['nm_prsh']){
				$html .= "<tr>
							<td colspan=\"4\"><strong>Sub Total</strong></td>
							<td align=\"right\"><strong>".round($Total)."</strong></td>
						  </tr>";
				$Total = 0;
				$nm_prsh = $value['nm_prsh'];
			}
			$html .= "<tr>
						<td>'".$value['no_peg']."</td>
						<td>'".$value['no_ang']."</td>
						<td>".$value['fcustname']."</td>
						<td>".$value['nm_prsh']."</td>
						<td align=\"right\">".round($value['fbill_amount'],2)."</td>
					</tr>";
			
			$Total += $value['fbill_amount'];
			$TotalAll += $value['fbill_amount'];
		}
		$html .= "<tr>
					<td colspan=\"4\"><strong>Sub Total</strong></td>
					<td align=\"right\"><strong>".round($Total,2)."</strong></td>
				  </tr>";
		$html .= "<tr>
					<td colspan=\"4\"><strong>Total</strong></td>
					<td align=\"right\"><strong>".round($TotalAll,2)."</strong></td>
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