<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transaksipenjualan extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('laporan_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('laporan/transaksipenjualan');
		$this->load->view('general/footer');
	}
	
	public function gettransaksipenjualan(){
		$DataTransaksiPenjualan = $this->laporan_model->getTransaksiPenjualan($_POST);
		
		$html = "<table class=\"table table-striped table-bordered table-hover\">
					<thead>
						<tr>
							<th style='vertical-align: middle;' class='text-center' rowspan='2'>Tanggal</th>
							<th style='vertical-align: middle;' class='text-center' rowspan='2'>Kode Trans</th>
							<th style='vertical-align: middle;' class='text-center' rowspan='2'>Pelanggan</th>
							<th style='vertical-align: middle;' class='text-center' rowspan='2'>Kasir</th>
							<th style='vertical-align: middle;' class='text-center' rowspan='2'>Total</th>
							<th class='text-center' colspan='10'>Pembayaran</th>
						</tr>
						<tr>
							<th class='text-center'>Tunai</th>
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
		
		$TotalHarian = 0;
		$TotalCashHarian = 0;
		$TotalDebetMandiriHarian = 0;
		$TotalDebetBRIHarian = 0;
		$TotalDebetBNIHarian = 0;
		$TotalKartuKreditHarian = 0;
		$TotalKreditAnggotaHarian = 0;
		$TotalKuponHarian = 0;
		$TotalSHUHarian = 0;
		$TotalKreditHarian = 0;
		$TotalVoucherHarian = 0;
		$TotalPembulatanHarian = 0;
		
		$fcreatedby = "";
		$tanggal = "";
		foreach ($DataTransaksiPenjualan as $key => $value) {
			$Tunai = $value['fpayment'];
			if($fcreatedby == "" && $tanggal == ""){
				$fcreatedby = $value['fcreatedby'];
				$tanggal = $value['fdate'];
			}
			if($fcreatedby != $value['fcreatedby'] || $tanggal != $value['fdate']){
				$html .= "<tr>
							<td colspan='4'><strong>SUB TOTAL</strong></td>
							<td align=\"right\"><strong>".number_format($TotalHarian,2)."</strong></td>
							<td align=\"right\"><strong>".number_format($TotalCashHarian,2)."</strong></td>
							<td align=\"right\"><strong>".number_format($TotalDebetMandiriHarian,2)."</strong></td>
							<td align=\"right\"><strong>".number_format($TotalDebetBRIHarian,2)."</strong></td>
							<td align=\"right\"><strong>".number_format($TotalDebetBNIHarian,2)."</strong></td>
							<td align=\"right\"><strong>".number_format($TotalKartuKreditHarian,2)."</strong></td>
							<td align=\"right\"><strong>".number_format($TotalKreditAnggotaHarian,2)."</strong></td>
							<td align=\"right\"><strong>".number_format($TotalKuponHarian,2)."</strong></td>
							<td align=\"right\"><strong>".number_format($TotalSHUHarian,2)."</strong></td>
							<td align=\"right\"><strong>".number_format($TotalKreditHarian,2)."</strong></td>
							<td align=\"right\"><strong>".number_format($TotalVoucherHarian,2)."</strong></td>
							<td align=\"right\"><strong>".number_format($TotalPembulatanHarian,2)."</strong></td>
						  </tr>";
						  
				$TotalHarian = 0;
				$TotalCashHarian = 0;
				$TotalDebetMandiriHarian = 0;
				$TotalDebetBRIHarian = 0;
				$TotalDebetBNIHarian = 0;
				$TotalKartuKreditHarian = 0;
				$TotalKreditAnggotaHarian = 0;
				$TotalKuponHarian = 0;
				$TotalSHUHarian = 0;
				$TotalKreditHarian = 0;
				$TotalVoucherHarian = 0;
				$TotalPembulatanHarian = 0;
				
				$fcreatedby = $value['fcreatedby'];
				$tanggal = $value['fdate'];
			}
			
			$html .= "<tr>
						<td>".$value['fdate']."</td>
						<td>".$value['fcode']."</td>
						<td>".$value['fcustname']."</td>
						<td>".$value['fcreatedby']." - ".$value['nama_kasir']."</td>
						<td align=\"right\">".number_format($value['fbill_amount'],2)."</td>
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
			
			$TotalHarian += $value['fbill_amount'];
			$TotalCashHarian += $value['fpayment'];
			$TotalDebetMandiriHarian += $value['kartu_debit_mandiri'];
			$TotalDebetBRIHarian += $value['kartu_debit_bri'];
			$TotalDebetBNIHarian += $value['kartu_debit_bni'];
			$TotalKartuKreditHarian += $value['kartu_kredit'];
			$TotalKreditAnggotaHarian += $value['kredit_anggota'];
			$TotalKuponHarian += $value['fkupon'];
			$TotalSHUHarian += $value['fshu'];
			$TotalKreditHarian += $value['kredit'];
			$TotalVoucherHarian += $value['voucher'];
			$TotalPembulatanHarian += $value['pembulatan'];
		}
		
		$html .= "<tr>
					<td colspan='4'><strong>SUB TOTAL</strong></td>
					<td align=\"right\"><strong>".number_format($TotalHarian,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalCashHarian,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalDebetMandiriHarian,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalDebetBRIHarian,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalDebetBNIHarian,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalKartuKreditHarian,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalKreditAnggotaHarian,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalKuponHarian,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalSHUHarian,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalKreditHarian,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalVoucherHarian,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalPembulatanHarian,2)."</strong></td>
				  </tr>";
		$html .= "<tr>
					<td colspan='4'><strong>TOTAL</strong></td>
					<td align=\"right\"><strong>".number_format($Total,2)."</strong></td>
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
				  </tr>";
		$html .= "</tbody></table>";
		
		echo $html;
	}
	
	public function cetaktransaksipenjualan(){
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;Filename=transaksi_penjualan.xls");
		
		$DataTransaksiPenjualan = $this->laporan_model->getTransaksiPenjualan($_GET);
		
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
						<td align=\"center\" colspan=\"6\"><strong>LAPORAN TRANSAKSI PENJUALAN</strong></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"6\"><strong>PERIODE : ".$_GET['tanggal_awal']." - ".$_GET['tanggal_akhir']."</strong></td>
					</tr>
				 </table>";
		$html .= "<table border=\"1\">
					<thead>
						<tr>
							<th style='vertical-align: middle;' class='text-center' rowspan='2'>Tanggal</th>
							<th style='vertical-align: middle;' class='text-center' rowspan='2'>Kode Trans</th>
							<th style='vertical-align: middle;' class='text-center' rowspan='2'>Pelanggan</th>
							<th style='vertical-align: middle;' class='text-center' rowspan='2'>Kasir</th>
							<th style='vertical-align: middle;' class='text-center' rowspan='2'>Total</th>
							<th class='text-center' colspan='10'>Pembayaran</th>
						</tr>
						<tr>
							<th class='text-center'>Tunai</th>
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
		
		$TotalHarian = 0;
		$TotalCashHarian = 0;
		$TotalDebetMandiriHarian = 0;
		$TotalDebetBRIHarian = 0;
		$TotalDebetBNIHarian = 0;
		$TotalKartuKreditHarian = 0;
		$TotalKreditAnggotaHarian = 0;
		$TotalKuponHarian = 0;
		$TotalSHUHarian = 0;
		$TotalKreditHarian = 0;
		$TotalVoucherHarian = 0;
		$TotalPembulatanHarian = 0;
		
		$fcreatedby = "";
		$tanggal = "";
		foreach ($DataTransaksiPenjualan as $key => $value) {
			$Tunai = $value['fpayment'];
			if($fcreatedby == "" && $tanggal == ""){
				$fcreatedby = $value['fcreatedby'];
				$tanggal = $value['fdate'];
			}
			if($fcreatedby != $value['fcreatedby'] || $tanggal != $value['fdate']){
				$html .= "<tr>
							<td colspan='4'><strong>SUB TOTAL</strong></td>
							<td align=\"right\"><strong>".number_format($TotalHarian,2)."</strong></td>
							<td align=\"right\"><strong>".number_format($TotalCashHarian,2)."</strong></td>
							<td align=\"right\"><strong>".number_format($TotalDebetMandiriHarian,2)."</strong></td>
							<td align=\"right\"><strong>".number_format($TotalDebetBRIHarian,2)."</strong></td>
							<td align=\"right\"><strong>".number_format($TotalDebetBNIHarian,2)."</strong></td>
							<td align=\"right\"><strong>".number_format($TotalKartuKreditHarian,2)."</strong></td>
							<td align=\"right\"><strong>".number_format($TotalKreditAnggotaHarian,2)."</strong></td>
							<td align=\"right\"><strong>".number_format($TotalKuponHarian,2)."</strong></td>
							<td align=\"right\"><strong>".number_format($TotalSHUHarian,2)."</strong></td>
							<td align=\"right\"><strong>".number_format($TotalKreditHarian,2)."</strong></td>
							<td align=\"right\"><strong>".number_format($TotalVoucherHarian,2)."</strong></td>
							<td align=\"right\"><strong>".number_format($TotalPembulatanHarian,2)."</strong></td>
						  </tr>";
						  
				$TotalHarian = 0;
				$TotalCashHarian = 0;
				$TotalDebetMandiriHarian = 0;
				$TotalDebetBRIHarian = 0;
				$TotalDebetBNIHarian = 0;
				$TotalKartuKreditHarian = 0;
				$TotalKreditAnggotaHarian = 0;
				$TotalKuponHarian = 0;
				$TotalSHUHarian = 0;
				$TotalKreditHarian = 0;
				$TotalVoucherHarian = 0;
				$TotalPembulatanHarian = 0;
				
				$fcreatedby = $value['fcreatedby'];
				$tanggal = $value['fdate'];
			}
			
			$html .= "<tr>
						<td>".$value['fdate']."</td>
						<td>".$value['fcode']."</td>
						<td>".$value['fcustname']."</td>
						<td>".$value['fcreatedby']." - ".$value['nama_kasir']."</td>
						<td align=\"right\">".number_format($value['fbill_amount'],2)."</td>
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
			
			$TotalHarian += $value['fbill_amount'];
			$TotalCashHarian += $value['fpayment'];
			$TotalDebetMandiriHarian += $value['kartu_debit_mandiri'];
			$TotalDebetBRIHarian += $value['kartu_debit_bri'];
			$TotalDebetBNIHarian += $value['kartu_debit_bni'];
			$TotalKartuKreditHarian += $value['kartu_kredit'];
			$TotalKreditAnggotaHarian += $value['kredit_anggota'];
			$TotalKuponHarian += $value['fkupon'];
			$TotalSHUHarian += $value['fshu'];
			$TotalKreditHarian += $value['kredit'];
			$TotalVoucherHarian += $value['voucher'];
			$TotalPembulatanHarian += $value['pembulatan'];
		}
		
		$html .= "<tr>
					<td colspan='4'><strong>SUB TOTAL</strong></td>
					<td align=\"right\"><strong>".number_format($TotalHarian,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalCashHarian,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalDebetMandiriHarian,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalDebetBRIHarian,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalDebetBNIHarian,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalKartuKreditHarian,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalKreditAnggotaHarian,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalKuponHarian,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalSHUHarian,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalKreditHarian,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalVoucherHarian,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalPembulatanHarian,2)."</strong></td>
				  </tr>";
		$html .= "<tr>
					<td colspan='4'><strong>TOTAL</strong></td>
					<td align=\"right\"><strong>".number_format($Total,2)."</strong></td>
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
				  </tr>";
		$html .= "</tbody></table>";
		echo $html;
	}
	
	public function cetaktransaksipenjualanall(){
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;Filename=transaksi_penjualan_all_".$_GET['tanggal_awal']."_".$_GET['tanggal_akhir'].".xls");
		
		$DataTransaksiPenjualan = $this->laporan_model->getTransaksiPenjualanAll($_GET);
		
		$html = "<table>
					<tr>
						<td colspan=\"3\"><strong>KOPERASI KARYAWAN KELUARGA BESAR PETROKIMIA GRESIK</strong></td>
						<td align=\"right\" colspan=\"3\"><strong>TGL. : ".date("d-m-Y")."</strong></th>
					</tr>
					<tr>
						<td colspan=\"3\"><strong>K-Mart</strong></td>
						<td colspan=\"3\"></th>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"6\"><strong>LAPORAN TRANSAKSI PENJUALAN</strong></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"6\"><strong>PERIODE : ".$_GET['tanggal_awal']." / ".$_GET['tanggal_akhir']."</strong></td>
					</tr>
				 </table>";
		$html .= "<table border=\"1\">
					<thead>
						<tr>
							<th style='vertical-align: middle;' class='text-center' rowspan='2'>Tanggal</th>
							<th style='vertical-align: middle;' class='text-center' rowspan='2'>Kode Trans</th>
							<th style='vertical-align: middle;' class='text-center' rowspan='2'>Pelanggan</th>
							<th style='vertical-align: middle;' class='text-center' rowspan='2'>Kasir</th>
							<th style='vertical-align: middle;' class='text-center' rowspan='2'>Status</th>
							<th style='vertical-align: middle;' class='text-center' rowspan='2'>Total</th>
							<th class='text-center' colspan='4'>Pembayaran</th>
						</tr>
						<tr>
							<th class='text-center'>Tunai</th>
							<th class='text-center'>Kupon</th>
							<th class='text-center'>Debit Card</th>
							<th class='text-center'>Credit Card</th>
						</tr>
					</thead>
					<tbody>";
		
		$Total = 0;
		$TotalTunai = 0;
		$TotalKupon = 0;
		$TotalSHU = 0;
		$TotalDebit = 0;
		$TotalKredit = 0;
		
		$TotalHarian = 0;
		$TotalTunaiHarian = 0;
		$TotalKuponHarian = 0;
		$TotalSHUHarian = 0;
		$TotalDebitHarian = 0;
		$TotalKreditHarian = 0;
		
		$fcreatedby = "";
		$tanggal = "";
		foreach ($DataTransaksiPenjualan as $key => $value) {
			$Tunai = $value['fpayment'];
			if($fcreatedby == "" && $tanggal == ""){
				$fcreatedby = $value['fcreatedby'];
				$tanggal = $value['fdate'];
			}
			if($fcreatedby != $value['fcreatedby'] || $tanggal != $value['fdate']){
				$html .= "<tr>
							<td colspan='5'><strong>SUB TOTAL</strong></td>
							<td align=\"right\"><strong>".round($TotalHarian,2)."</strong></td>
							<td align=\"right\"><strong>".round($TotalTunaiHarian,2)."</strong></td>
							<td align=\"right\"><strong>".round($TotalKuponHarian + $TotalSHUHarian,2)."</strong></td>
							<td align=\"right\"><strong>".round($TotalDebitHarian,2)."</strong></td>
							<td align=\"right\"><strong>".round($TotalKreditHarian,2)."</strong></td>
						  </tr>";
						  
				$TotalHarian = 0;
				$TotalTunaiHarian = 0;
				$TotalKuponHarian = 0;
				$TotalSHUHarian = 0;
				$TotalDebitHarian = 0;
				$TotalKreditHarian = 0;
				
				$fcreatedby = $value['fcreatedby'];
				$tanggal = $value['fdate'];
			}
			
			if($value['fchange'] > 0){
				$Tunai = $value['fpayment'] - $value['fchange'];
			}
			
			$html .= "<tr>
						<td>".$value['fdate']."</td>
						<td>".$value['fcode']."</td>
						<td>".$value['fcustname']."</td>
						<td>".$value['fname_payment']."</td>
						<td>".$value['nama_kasir']."</td>
						<td align=\"right\">".round($value['fbill_amount'],2)."</td>
						<td align=\"right\">".round($Tunai,2)."</td>
						<td align=\"right\">".round($value['fkupon'] + $value['fshu'],2)."</td>
						<td align=\"right\">".round($value['fdebet'],2)."</td>
						<td align=\"right\">".round($value['fkredit'],2)."</td>
					  </tr>";
			
			$TotalHarian += $value['fbill_amount'];
			$TotalTunaiHarian += $Tunai;
			$TotalKuponHarian += $value['fkupon'];
			$TotalSHUHarian += $value['fshu'];
			$TotalDebitHarian += $value['fdebet'];
			$TotalKreditHarian += $value['fkredit'];
			
			$Total += $value['fbill_amount'];
			$TotalTunai += $Tunai;
			$TotalKupon += $value['fkupon'];
			$TotalSHU += $value['fshu'];
			$TotalDebit += $value['fdebet'];
			$TotalKredit += $value['fkredit'];
		}
		
		$html .= "<tr>
					<td colspan='5'><strong>SUB TOTAL</strong></td>
					<td align=\"right\"><strong>".round($TotalHarian,2)."</strong></td>
					<td align=\"right\"><strong>".round($TotalTunaiHarian,2)."</strong></td>
					<td align=\"right\"><strong>".round($TotalKuponHarian + $TotalSHUHarian,2)."</strong></td>
					<td align=\"right\"><strong>".round($TotalDebitHarian,2)."</strong></td>
					<td align=\"right\"><strong>".round($TotalKreditHarian,2)."</strong></td>
				  </tr>";
		$html .= "<tr>
					<td colspan='5'><strong>TOTAL</strong></td>
					<td align=\"right\"><strong>".round($Total,2)."</strong></td>
					<td align=\"right\"><strong>".round($TotalTunai,2)."</strong></td>
					<td align=\"right\"><strong>".round($TotalKupon + $TotalSHU,2)."</strong></td>
					<td align=\"right\"><strong>".round($TotalDebit,2)."</strong></td>
					<td align=\"right\"><strong>".round($TotalKredit,2)."</strong></td>
				  </tr>";
		$html .= "</tbody></table>";
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
						<td align=\"center\" colspan=\"3\"><strong>( ............................. )</strong></td>
						<td align=\"center\" colspan=\"3\"><strong>( ............................. )</strong></td>
					</tr>
				  </table>";
		echo $html;
	}

	public function cetakpenjualankasir(){
		$DataPenjualan = $this->laporan_model->getPenjualanKasir($_GET);
		if(sizeof($DataPenjualan) > 0){
			$html = "<table>
						<tr>
							<td>Tunai</td>
							<td>Mandiri</td>
							<td>BNI</td>
							<td>BRI</td>
							<td>SHU</td>
							<td>Kupon</td>
							<td>Kredit Anggota</td>
							<td>Kartu Kredit</td>
							<td>Kredit Instansi</td>
						</tr>
					 </table>";
		}
	}
}