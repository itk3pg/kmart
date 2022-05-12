<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mutasihutang extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('laporan_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('laporan/mutasihutang');
		$this->load->view('general/footer');
	}
	
	public function getmutasihutang(){
		$DataMutasiHutang = $this->laporan_model->getMutasiHutang($_POST);
		
		$html = "<table class=\"table table-striped table-bordered table-hover\">
					<thead>
						<tr>
							<th>KD Supplier</th>
							<th>Nama Supplier</th>
							<th width=\"150px\">Saldo Awal</th>
							<th width=\"150px\">Hutang</th>
							<th width=\"150px\">Pembayaran</th>
							<th width=\"150px\">Retur</th>
							<th width=\"150px\">Total Saldo AKhir</th>
						</tr>
					</thead>
					<tbody>";
		$jumlahSAwal = 0;
		$jumlahSAwalRetur = 0;
		$jumlahTotalSAwal = 0;
		$jumlahHutang = 0;
		$jumlahRetur = 0;
		$jumlahBayar = 0;
		$jumlahRealisasiRetur = 0;
		$jumlahSAkhir = 0;
		foreach ($DataMutasiHutang as $key => $value) {
			$total_saldo_awal = $value['saldo_awal'];
			$saldo_akhir = $total_saldo_awal + (($value['jm_hutang'] - $value['jm_bayar']) - ($value['jumlah_retur']));
			$html .= "<tr>
						<td>".$value['kode']."</td>
						<td>".$value['nama_supplier']."</td>
						<td align=\"right\">".number_format($total_saldo_awal,2)."</td>
						<td align=\"right\">".number_format($value['jm_hutang'],2)."</td>
						<td align=\"right\">".number_format($value['jm_bayar'],2)."</td>
						<td align=\"right\">".number_format($value['jumlah_retur'],2)."</td>
						<td align=\"right\">".number_format($saldo_akhir,2)."</td>
					 </tr>";
			
			$jumlahTotalSAwal += $total_saldo_awal;
			$jumlahHutang += $value['jm_hutang'];
			$jumlahRetur += $value['jumlah_retur'];
			$jumlahBayar += $value['jm_bayar'];
			$jumlahSAkhir += $saldo_akhir;
		}
		$html .= "<tr>
					<td colspan=\"2\"><strong>Jumlah</strong></td>
					<td align=\"right\"><strong>".number_format($jumlahTotalSAwal,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($jumlahHutang,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($jumlahBayar,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($jumlahRetur,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($jumlahSAkhir,2)."</strong></td>
				 </tr>";
		$html .=    "
					</tbody>
				 </table>";
				 
		echo $html;
	}
	
	public function cetakmutasihutang(){
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;Filename=mutasi_hutang_".$_GET['bulan']."_".$_GET['tahun'].".xls");
		
		$DataMutasiHutang = $this->laporan_model->getMutasiHutang($_GET);
		
		$html = "<table>
					<tr>
						<td colspan=\"3\"><strong>KOPERASI KARYAWAN KELUARGA BESAR PETROKIMIA GRESIK</strong></td>
						<td align=\"right\" colspan=\"3\"><strong>TGL. : ".date("d-m-Y H:i:s")."</strong></th>
					</tr>
					<tr>
						<td colspan=\"3\"><strong>K-Mart</strong></td>
						<td colspan=\"3\"></th>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"6\"><strong>LAPORAN MUTASI  HUTANG</strong></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"6\"><strong>PERIODE : ".$_GET['bulan']." - ".$_GET['tahun']."</strong></td>
					</tr>
				 </table>";
		$html .= "<table border=\"1\">
					<thead>
						<tr>
							<th>KD Supplier</th>
							<th>Nama Supplier</th>
							<th width=\"150px\">Saldo Awal</th>
							<th width=\"150px\">Hutang</th>
							<th width=\"150px\">Pembayaran</th>
							<th width=\"150px\">Retur</th>
							<th width=\"150px\">Total Saldo AKhir</th>
						</tr>
					</thead>
					<tbody>";
		$jumlahSAwal = 0;
		$jumlahSAwalRetur = 0;
		$jumlahTotalSAwal = 0;
		$jumlahHutang = 0;
		$jumlahRetur = 0;
		$jumlahBayar = 0;
		$jumlahRealisasiRetur = 0;
		$jumlahSAkhir = 0;
		foreach ($DataMutasiHutang as $key => $value) {
			$total_saldo_awal = $value['saldo_awal'];
			$saldo_akhir = $total_saldo_awal + (($value['jm_hutang'] - $value['jm_bayar']) - ($value['jumlah_retur']));
			$html .= "<tr>
						<td>".$value['kode']."</td>
						<td>".$value['nama_supplier']."</td>
						<td align=\"right\">".number_format($total_saldo_awal,2)."</td>
						<td align=\"right\">".number_format($value['jm_hutang'],2)."</td>
						<td align=\"right\">".number_format($value['jm_bayar'],2)."</td>
						<td align=\"right\">".number_format($value['jumlah_retur'],2)."</td>
						<td align=\"right\">".number_format($saldo_akhir,2)."</td>
					 </tr>";
			
			$jumlahTotalSAwal += $total_saldo_awal;
			$jumlahHutang += $value['jm_hutang'];
			$jumlahRetur += $value['jumlah_retur'];
			$jumlahBayar += $value['jm_bayar'];
			$jumlahSAkhir += $saldo_akhir;
		}
		$html .= "<tr>
					<td colspan=\"2\"><strong>Jumlah</strong></td>
					<td align=\"right\"><strong>".number_format($jumlahTotalSAwal,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($jumlahHutang,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($jumlahBayar,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($jumlahRetur,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($jumlahSAkhir,2)."</strong></td>
				 </tr>";
		$html .=    "
					</tbody>
				 </table>";
		$html .= "<table>
					<tr>
						<td align=\"center\" colspan=\"3\">Mengetahui</td>
						<td align=\"center\" colspan=\"3\">Yang membuat</td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"3\"></td>
						<td align=\"center\" colspan=\"3\"></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"3\"></td>
						<td align=\"center\" colspan=\"3\"></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"3\"></td>
						<td align=\"center\" colspan=\"3\"></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"3\"><strong>(....................................)</strong></td>
						<td align=\"center\" colspan=\"3\"><strong>(....................................)</strong></td>
					</tr>
				  </table>";
		echo $html;
	}
}