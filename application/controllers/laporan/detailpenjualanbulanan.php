<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Detailpenjualanbulanan extends CI_Controller {
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
		$this->load->view('laporan/detailpenjualanbulanan', $Param);
		$this->load->view('general/footer');
	}
	
	public function getpenjualanbulanan(){
		$DataPenjualanPelanggan = $this->laporan_model->getDataPenjualan($_POST);
		
		$html = "<table class=\"table table-striped table-bordered table-hover\">
					<thead>
						<tr>
							<th class='text-center'>Tanggal</th>
							<th class='text-center'>Cash</th>
							<th class='text-center'>Debit Mandiri</th>
							<th class='text-center'>Debit BRI</th>
							<th class='text-center'>Debit BNI</th>
							<th class='text-center'>Kartu Kredit</th>
							<th class='text-center'>Kredit Anggota</th>
							<th class='text-center'>Kupon</th>
							<th class='text-center'>SHU</th>
							<th class='text-center'>Kredit Instansi</th>
							<th class='text-center'>Voucher</th>
							<th class='text-center'>Pembulatan</th>
							<th class='text-center'>Total Penjualan</th>
						</tr>
					</thead>
					<tbody>";
		
		$Total = 0;
		$TotalCash = 0;
		$TotalDebetMandiri = 0;
		$TotalDebetBRI = 0;
		$TotalDebetBNI = 0;
		$TotalKartuKredit = 0;
		$TotalKreditAnggota = 0;
		$TotalKupon = 0;
		$TotalSHU = 0;
		$TotalKredit = 0;
		$TotalVoucher = 0;
		$TotalPembulatan = 0;
		
		foreach ($DataPenjualanPelanggan as $key => $value) {
			$html .= "<tr>
						<td>".$value['fdate']."</td>
						<td align=\"right\">".number_format($value['fpayment'],2)."</td>
						<td align=\"right\">".number_format($value['kartu_debit_mandiri'],2)."</td>
						<td align=\"right\">".number_format($value['kartu_debit_bri'],2)."</td>
						<td align=\"right\">".number_format($value['kartu_debit_bni'],2)."</td>
						<td align=\"right\">".number_format($value['kartu_kredit'],2)."</td>
						<td align=\"right\">".number_format($value['kredit_anggota'],2)."</td>
						<td align=\"right\">".number_format($value['fkupon'],2)."</td>
						<td align=\"right\">".number_format($value['fshu'],2)."</td>
						<td align=\"right\">".number_format($value['kredit'],2)."</td>
						<td align=\"right\">".number_format($value['voucher'],2)."</td>
						<td align=\"right\">".number_format($value['pembulatan'],2)."</td>
						<td align=\"right\">".number_format($value['fbill_amount'],2)."</td>
					</tr>";
			
			$Total += $value['fbill_amount'];
			$TotalCash += $value['fpayment'];
			$TotalDebetMandiri += $value['kartu_debit_mandiri'];
			$TotalDebetBRI += $value['kartu_debit_bri'];
			$TotalDebetBNI += $value['kartu_debit_bni'];
			$TotalKartuKredit += $value['kartu_kredit'];
			$TotalKreditAnggota += $value['kredit_anggota'];
			$TotalKupon += $value['fkupon'];
			$TotalSHU += $value['fshu'];
			$TotalKredit += $value['kredit'];
			$TotalVoucher += $value['voucher'];
			$TotalPembulatan += $value['pembulatan'];
		}
		$html .= "<tr>
					<td><strong>TOTAL</strong></td>
					<td align=\"right\"><strong>".number_format($TotalCash,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalDebetMandiri,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalDebetBRI,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalDebetBNI,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalKartuKredit,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalKreditAnggota,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalKupon,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalSHU,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalKredit,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalVoucher,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalPembulatan,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($Total,2)."</strong></td>
				  </tr>";
		$html .= "</tbody></table>";
		
		echo $html;
	}
	
	public function cetakpenjualanpelanggan(){
		$DataPenjualanPelanggan = $this->laporan_model->getDataPenjualan($_GET);
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;Filename=detail_penjualan_pelanggan_".$_GET['toko_kode']."_".$_GET['bulan']."_".$_GET['tahun'].".xls");
		
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
						<td align=\"center\" colspan=\"8\"><strong>DETAIL LAPORAN PENJUALAN BULANAN</strong></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"8\"><strong>PERIODE : ".$_GET['bulan']." - ".$_GET['tahun']."</strong></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"8\"><strong>Pelanggan : </strong></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"8\"><strong>Toko : ".$_GET['nama_toko']."</strong></td>
					</tr>
				 </table>";
		$html .= "<table border=\"1\">
					<thead>
						<tr>
							<th class='text-center'>Tanggal</th>
							<th class='text-center'>Cash</th>
							<th class='text-center'>Debit Mandiri</th>
							<th class='text-center'>Debit BRI</th>
							<th class='text-center'>Debit BNI</th>
							<th class='text-center'>Kartu Kredit</th>
							<th class='text-center'>Kredit Anggota</th>
							<th class='text-center'>Kupon</th>
							<th class='text-center'>SHU</th>
							<th class='text-center'>Kredit Instansi</th>
							<th class='text-center'>Voucher</th>
							<th class='text-center'>Pembulatan</th>
							<th class='text-center'>Total Penjualan</th>
						</tr>
					</thead>
					<tbody>";
		
		$Total = 0;
		$TotalCash = 0;
		$TotalDebetMandiri = 0;
		$TotalDebetBRI = 0;
		$TotalDebetBNI = 0;
		$TotalKartuKredit = 0;
		$TotalKreditAnggota = 0;
		$TotalKupon = 0;
		$TotalSHU = 0;
		$TotalKredit = 0;
		$TotalVoucher = 0;
		$TotalPembulatan = 0;
		
		foreach ($DataPenjualanPelanggan as $key => $value) {
			$html .= "<tr>
						<td>".$value['fdate']."</td>
						<td align=\"right\">".number_format($value['fpayment'],2)."</td>
						<td align=\"right\">".number_format($value['kartu_debit_mandiri'],2)."</td>
						<td align=\"right\">".number_format($value['kartu_debit_bri'],2)."</td>
						<td align=\"right\">".number_format($value['kartu_debit_bni'],2)."</td>
						<td align=\"right\">".number_format($value['kartu_kredit'],2)."</td>
						<td align=\"right\">".number_format($value['kredit_anggota'],2)."</td>
						<td align=\"right\">".number_format($value['fkupon'],2)."</td>
						<td align=\"right\">".number_format($value['fshu'],2)."</td>
						<td align=\"right\">".number_format($value['kredit'],2)."</td>
						<td align=\"right\">".number_format($value['voucher'],2)."</td>
						<td align=\"right\">".number_format($value['pembulatan'],2)."</td>
						<td align=\"right\">".number_format($value['fbill_amount'],2)."</td>
					</tr>";
			
			$Total += $value['fbill_amount'];
			$TotalCash += $value['fpayment'];
			$TotalDebetMandiri += $value['kartu_debit_mandiri'];
			$TotalDebetBRI += $value['kartu_debit_bri'];
			$TotalDebetBNI += $value['kartu_debit_bni'];
			$TotalKartuKredit += $value['kartu_kredit'];
			$TotalKreditAnggota += $value['kredit_anggota'];
			$TotalKupon += $value['fkupon'];
			$TotalSHU += $value['fshu'];
			$TotalKredit += $value['kredit'];
			$TotalVoucher += $value['voucher'];
			$TotalPembulatan += $value['pembulatan'];
		}
		$html .= "<tr>
					<td><strong>TOTAL</strong></td>
					<td align=\"right\"><strong>".number_format($TotalCash,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalDebetMandiri,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalDebetBRI,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalDebetBNI,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalKartuKredit,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalKreditAnggota,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalKupon,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalSHU,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalKredit,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalVoucher,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalPembulatan,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($Total,2)."</strong></td>
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