<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Detailpenjualanharian extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('laporan_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('laporan/detailpenjualanharian');
		$this->load->view('general/footer');
	}
	
	public function gettransaksipenjualan(){
		$DataTransaksiPenjualan = $this->laporan_model->RekapDetailPenjualanHarian($_POST);
		
		$html = "<table class=\"table table-striped table-bordered table-hover\">
					<thead>
						<tr>
							<th class='text-center' rowspan='2'>Tanggal</th>
							<th class='text-center' rowspan='2'>Toko</th>
							<th class='text-center' colspan='17'>Tunai</th>
							<th class='text-center' colspan='4'>Kredit</th>
							<th class='text-center' rowspan='2'>Total</th>
						</tr>
						<tr>
							<th class='text-center'>Uang Tunai</th>
							<th class='text-center'>Kupon Belanja</th>
							<th class='text-center'>Kupon Non K3PG</th>
							<th class='text-center'>SHU</th>
							<th class='text-center'>Mandiri</th>
							<th class='text-center'>BNI</th>
							<th class='text-center'>BRI</th>
							<th class='text-center'>BCA</th>
							<th class='text-center'>Bank DKI</th>
							<th class='text-center'>CC Mandiri</th>
							<th class='text-center'>CC BNI</th>
							<th class='text-center'>CC BRI</th>
							<th class='text-center'>CC BCA</th>
							<th class='text-center'>Link Aja</th>
							<th class='text-center'>Transfer BNI</th>
							<th class='text-center'>Transfer MANDIRI</th>
							<th class='text-center'>Total Tunai</th>

							<th class='text-center'>Angsuran</th>
							<th class='text-center'>Buku</th>
							<th class='text-center'>Instansi</th>
							<th class='text-center'>Total Kredit</th>
							<th class='text-center'>&nbsp;</th>
						</tr>
					</thead>
					<tbody>";
		
		foreach ($DataTransaksiPenjualan as $key => $value) {
			$subTotal = $value['UangTunai'] + $value['fkupon'] + $value['fvoucher'] + $value['fshu'] + $value['kartu_debit_mandiri'] + $value['kartu_debit_bni'] + $value['kartu_debit_bri'] + $value['kartu_debit_bca'] + $value['kartu_debit_dki'] + $value['kartu_kredit_mandiri'] + $value['kartu_kredit_bni'] + $value['kartu_kredit_bri'] + $value['kartu_kredit_bca'] + $value['link_aja'] + $value['transfer_bni'] + $value['transfer_mandiri'] + $value['KreditAngs'] + $value['kredit_buku'] + $value['kredit_perusahaan'];

			$subTotalTunai = $value['UangTunai'] + $value['fkupon'] + $value['fvoucher'] + $value['fshu'] + $value['kartu_debit_mandiri'] + $value['kartu_debit_bni'] + $value['kartu_debit_bri'] + $value['kartu_debit_bca'] + $value['kartu_debit_dki'] + $value['kartu_kredit_mandiri'] + $value['kartu_kredit_bni'] + $value['kartu_kredit_bri'] + $value['kartu_kredit_bca'] + $value['link_aja'] + $value['transfer_bni'] + $value['transfer_mandiri'];

			$subTotalKredit = $value['KreditAngs'] + $value['kredit_buku'] + $value['kredit_perusahaan'];

			$html .= "<tr>
						<td>".$value['tanggal']."</td>
						<td>".$value['nama_toko']."</td>
						<td align=\"right\">".number_format($value['UangTunai'],2)."</td>
						<td align=\"right\">".number_format($value['fkupon'],2)."</td>
						<td align=\"right\">".number_format($value['fvoucher'],2)."</td>
						<td align=\"right\">".number_format($value['fshu'],2)."</td>
						<td align=\"right\">".number_format($value['kartu_debit_mandiri'],2)."</td>
						<td align=\"right\">".number_format($value['kartu_debit_bni'],2)."</td>
						<td align=\"right\">".number_format($value['kartu_debit_bri'],2)."</td>
						<td align=\"right\">".number_format($value['kartu_debit_bca'],2)."</td>
						<td align=\"right\">".number_format($value['kartu_debit_dki'],2)."</td>
						<td align=\"right\">".number_format($value['kartu_kredit_mandiri'],2)."</td>
						<td align=\"right\">".number_format($value['kartu_kredit_bni'],2)."</td>
						<td align=\"right\">".number_format($value['kartu_kredit_bri'],2)."</td>
						<td align=\"right\">".number_format($value['kartu_kredit_bca'],2)."</td>
						<td align=\"right\">".number_format($value['link_aja'],2)."</td>
						<td align=\"right\">".number_format($value['transfer_bni'],2)."</td>
						<td align=\"right\">".number_format($value['transfer_mandiri'],2)."</td>
						<td align=\"right\"><strong>".number_format($subTotalTunai,2)."</strong></td>
						<td align=\"right\">".number_format($value['KreditAngs'],2)."</td>
						<td align=\"right\">".number_format($value['kredit_buku'],2)."</td>
						<td align=\"right\">".number_format($value['kredit_perusahaan'],2)."</td>
						<td align=\"right\"><strong>".number_format($subTotalKredit,2)."</strong></td>
						<td align=\"right\"><strong>".number_format($subTotal,2)."</strong></td>
						<td>
							<button onclick=\"CetakDetailPenjualan('".$value['tanggal']."')\" class=\"btn btn-info btn-sm\" type=\"button\">
								<i class=\"fa fa-print\"></i>
							</button>
						</td>
					  </tr>";
		}
	
		// $html .= "<tr>
		// 			<td colspan='4'><strong>TOTAL</strong></td>
		// 			<td align=\"right\"><strong>".number_format($Total,2)."</strong></td>
		// 			<td align=\"right\"><strong>".number_format($TotalCash,2)."</strong></td>
		// 			<td align=\"right\"><strong>".number_format($TotalDebetMandiri,2)."</strong></td>
		// 			<td align=\"right\"><strong>".number_format($TotalDebetBRI,2)."</strong></td>
		// 			<td align=\"right\"><strong>".number_format($TotalDebetBNI,2)."</strong></td>
		// 			<td align=\"right\"><strong>".number_format($TotalKartuKredit,2)."</strong></td>
		// 			<td align=\"right\"><strong>".number_format($TotalKreditAnggota,2)."</strong></td>
		// 			<td align=\"right\"><strong>".number_format($TotalKupon,2)."</strong></td>
		// 			<td align=\"right\"><strong>".number_format($TotalSHU,2)."</strong></td>
		// 			<td align=\"right\"><strong>".number_format($TotalKredit,2)."</strong></td>
		// 			<td align=\"right\"><strong>".number_format($TotalVoucher,2)."</strong></td>
		// 			<td align=\"right\"><strong>".number_format($TotalPembulatan,2)."</strong></td>
		// 		  </tr>";
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
							<th class='text-center' colspan='13'>Pembayaran</th>
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
							<th class='text-center'>Transfer BNI</th>
							<th class='text-center'>Transfer MANDIRI</th>
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
		$TotalTransferBNI = 0;
		$TotalTransferMANDIRI = 0;
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
		$TotalTransferBNIHarian = 0;
		$TotalTransferMANDIRIHarian = 0;
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
							<td align=\"right\"><strong>".number_format($TotalTransferBNIHarian,2)."</strong></td>
							<td align=\"right\"><strong>".number_format($TotalTransferMANDIRIHarian,2)."</strong></td>
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
				$TotalTransferBNIHarian = 0;
				$TotalTransferMANDIRIHarian = 0;
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
						<td align=\"right\">".number_format($value['transfer_bni'],2)."</td>
						<td align=\"right\">".number_format($value['transfer_mandiri'],2)."</td>
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
			$TotalTransferBNI += $value['transfer_bni'];
			$TotalTransferMANDIRI += $value['transfer_mandiri'];
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
			$TotalTransferBNIHarian += $value['transfer_bni'];
			$TotalTransferMANDIRIHarian += $value['transfer_mandiri'];
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
					<td align=\"right\"><strong>".number_format($TotalTransferBNIHarian,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalTransferMANDIRIHarian,2)."</strong></td>
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
					<td align=\"right\"><strong>".number_format($TotalTransferBNI,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalTransferMANDIRI,2)."</strong></td>
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

	public function cetakdetailpenjualan(){
		$DataTransaksiPenjualan = $this->laporan_model->RekapDetailPenjualanHarian($_GET);

		$subTotalTunai = $DataTransaksiPenjualan[0]['UangTunai'] + $DataTransaksiPenjualan[0]['fkupon'] + $DataTransaksiPenjualan[0]['fvoucher'] + $DataTransaksiPenjualan[0]['fshu'] + $DataTransaksiPenjualan[0]['kartu_debit_mandiri'] + $DataTransaksiPenjualan[0]['kartu_debit_bni'] + $DataTransaksiPenjualan[0]['kartu_debit_bri'] + $DataTransaksiPenjualan[0]['kartu_debit_bca'] + $DataTransaksiPenjualan[0]['kartu_debit_dki'] + $DataTransaksiPenjualan[0]['kartu_kredit_mandiri'] + $DataTransaksiPenjualan[0]['kartu_kredit_bni'] + $DataTransaksiPenjualan[0]['kartu_kredit_bri'] + $DataTransaksiPenjualan[0]['kartu_kredit_bca'] + $DataTransaksiPenjualan[0]['link_aja'] + $DataTransaksiPenjualan[0]['transfer_bni'] + $DataTransaksiPenjualan[0]['transfer_mandiri'];

		$subTotalKredit = $DataTransaksiPenjualan[0]['KreditAngs'] + $DataTransaksiPenjualan[0]['kredit_buku'] + $DataTransaksiPenjualan[0]['kredit_perusahaan'];

		$GrandTotal = $subTotalKredit + $subTotalTunai;

		$tglArr = explode('-', $_GET['tanggal_awal']);
		$tglKerja = $tglArr[2]."-".$tglArr[1]."-".$tglArr[0];
		$html = "<style>
					table {
						font-size : 14px;
					}
				 </style>";

		$html .= "<table width=\"100%\">";
		$html .= "<tr>
					<td align=\"center\">LAPORAN PENJUALAN</td>
				  </tr>";
		$html .= "<tr>
					<td align=\"center\">HARIAN KASIR</td>
				  </tr>";
		if ($_GET['kasir_kode'] != ''){
			$html .= "<tr>
					<td align=\"center\">".$DataTransaksiPenjualan[0]['kasir']."</td>
					</tr>";
		}
		$html .= "<tr>
					<td align=\"center\">".$DataTransaksiPenjualan[0]['nama_toko']."</td>
				  </tr>";
		$html .= "</table>";
		$html .= "<hr/>";
		$html .= "<table width=\"100%\">";
		$html .= "<tr>
					<td>TGL KERJA</td>
					<td>".$tglKerja."</td>
				  </tr>";
		$html .= "<tr>
					<td>TGL CETAK</td>
					<td>".date('d-m-Y h:i:s')."</td>
				  </tr>";
		$html .= "</table>";
		$html .= "<hr/>";
		$html .= "<table width=\"100%\">";
		$html .= "<tr>
					<td align=\"center\">TUNAI</td>
				  </tr>";
		$html .= "</table>";
		$html .= "<hr/>";

		$html .= "<table width=\"100%\">";
		$html .= "<tr>
					<td width=\"50\">1101</td>
					<td width=\"150\">UANG TUNAI</td>
					<td width=\"30\"> : </td>
					<td width=\"130\" align=\"right\">".number_format($DataTransaksiPenjualan[0]['UangTunai'], 2)."</td>
				</tr>";
		$html .= "<tr>
					<td width=\"50\">2152</td>
					<td width=\"150\">KUPON BELANJA</td>
					<td width=\"30\"> : </td>
					<td width=\"130\" align=\"right\">".number_format($DataTransaksiPenjualan[0]['fkupon'], 2)."</td>
				</tr>";
		$html .= "<tr>
					<td width=\"50\">2152</td>
					<td width=\"150\">KUPON NON K3PG</td>
					<td width=\"30\"> : </td>
					<td width=\"130\" align=\"right\">".number_format($DataTransaksiPenjualan[0]['fvoucher'], 2)."</td>
				</tr>";
		$html .= "<tr>
					<td width=\"50\">2160</td>
					<td width=\"150\">SHU</td>
					<td width=\"30\"> : </td>
					<td width=\"130\" align=\"right\">".number_format($DataTransaksiPenjualan[0]['fshu'], 2)."</td>
				</tr>";
		$html .= "<tr>
					<td width=\"50\">1199</td>
					<td width=\"150\">DEBET MANDIRI</td>
					<td width=\"30\"> : </td>
					<td width=\"130\" align=\"right\">".number_format($DataTransaksiPenjualan[0]['kartu_debit_mandiri'], 2)."</td>
				</tr>";
		$html .= "<tr>
					<td width=\"50\">1199</td>
					<td width=\"150\">DEBET BNI</td>
					<td width=\"30\"> : </td>
					<td width=\"130\" align=\"right\">".number_format($DataTransaksiPenjualan[0]['kartu_debit_bni'], 2)."</td>
				</tr>";
		$html .= "<tr>
					<td width=\"50\">1199</td>
					<td width=\"150\">DEBET BRI</td>
					<td width=\"30\"> : </td>
					<td width=\"130\" align=\"right\">".number_format($DataTransaksiPenjualan[0]['kartu_debit_bri'], 2)."</td>
				</tr>";
		$html .= "<tr>
					<td width=\"50\">1199</td>
					<td width=\"150\">DEBET BCA</td>
					<td width=\"30\"> : </td>
					<td width=\"130\" align=\"right\">".number_format($DataTransaksiPenjualan[0]['kartu_debit_bca'], 2)."</td>
				</tr>";
		$html .= "<tr>
					<td width=\"50\">1199</td>
					<td width=\"150\">BANK DKI</td>
					<td width=\"30\"> : </td>
					<td width=\"130\" align=\"right\">".number_format($DataTransaksiPenjualan[0]['kartu_debit_dki'], 2)."</td>
				</tr>";
		$html .= "<tr>
					<td width=\"50\">1199</td>
					<td width=\"150\">K. KREDIT MANDIRI</td>
					<td width=\"30\"> : </td>
					<td width=\"130\" align=\"right\">".number_format($DataTransaksiPenjualan[0]['kartu_kredit_mandiri'], 2)."</td>
				</tr>";
		$html .= "<tr>
					<td width=\"50\">1199</td>
					<td width=\"150\">K. KREDIT BNI</td>
					<td width=\"30\"> : </td>
					<td width=\"130\" align=\"right\">".number_format($DataTransaksiPenjualan[0]['kartu_kredit_bni'], 2)."</td>
				</tr>";
		$html .= "<tr>
					<td width=\"50\">1199</td>
					<td width=\"150\">K. KREDIT BRI</td>
					<td width=\"30\"> : </td>
					<td width=\"130\" align=\"right\">".number_format($DataTransaksiPenjualan[0]['kartu_kredit_bri'], 2)."</td>
				</tr>";
		$html .= "<tr>
					<td width=\"50\">1199</td>
					<td width=\"150\">K. KREDIT BCA</td>
					<td width=\"30\"> : </td>
					<td width=\"130\" align=\"right\">".number_format($DataTransaksiPenjualan[0]['kartu_kredit_bca'], 2)."</td>
				</tr>";
		$html .= "<tr>
					<td width=\"50\">1199</td>
					<td width=\"150\">LINK AJA</td>
					<td width=\"30\"> : </td>
					<td width=\"130\" align=\"right\">".number_format($DataTransaksiPenjualan[0]['link_aja'], 2)."</td>
				</tr>";
		$html .= "<tr>
				<td width=\"50\">1199</td>
				<td width=\"150\">TRANSFER BNI</td>
				<td width=\"30\"> : </td>
				<td width=\"130\" align=\"right\">".number_format($DataTransaksiPenjualan[0]['transfer_bni'], 2)."</td>
			</tr>";
		$html .= "<tr>
				<td width=\"50\">1199</td>
				<td width=\"150\">TRANSFER MANDIRI</td>
				<td width=\"30\"> : </td>
				<td width=\"130\" align=\"right\">".number_format($DataTransaksiPenjualan[0]['transfer_mandiri'], 2)."</td>
			</tr>";
		$html .= "</table>";
		$html .= "<hr/>";
		$html .= "<table>";
		$html .= "<tr>
					<td width=\"50\"></td>
					<td width=\"150\">TOTAL</td>
					<td width=\"30\"> : </td>
					<td width=\"130\" align=\"right\"><strong>".number_format($subTotalTunai, 2)."</strong></td>
				</tr>";
		$html .= "</table>";

		$html .= "<hr/>";
		$html .= "<table width=\"100%\">";
		$html .= "<tr>
					<td align=\"center\">KREDIT</td>
				  </tr>";
		$html .= "</table>";
		$html .= "<hr/>";
		$html .= "<table width=\"100%\">";
		$html .= "<tr>
					<td width=\"50\">1141</td>
					<td width=\"150\">KREDIT ANGS</td>
					<td width=\"30\"> : </td>
					<td width=\"130\" align=\"right\">".number_format($DataTransaksiPenjualan[0]['KreditAngs'], 2)."</td>
				</tr>";
		$html .= "<tr>
					<td width=\"50\">1141</td>
					<td width=\"150\">KREDIT BUKU</td>
					<td width=\"30\"> : </td>
					<td width=\"130\" align=\"right\">".number_format($DataTransaksiPenjualan[0]['kredit_buku'], 2)."</td>
				</tr>";
		$html .= "<tr>
					<td width=\"50\">1141</td>
					<td width=\"150\">KREDIT INSTANSI</td>
					<td width=\"30\"> : </td>
					<td width=\"130\" align=\"right\">".number_format($DataTransaksiPenjualan[0]['kredit_perusahaan'], 2)."</td>
				</tr>";
		$html .= "</table>";
		$html .= "<hr/>";
		$html .= "<table>";
		$html .= "<tr>
					<td width=\"50\"></td>
					<td width=\"150\">TOTAL</td>
					<td width=\"30\"> : </td>
					<td width=\"130\" align=\"right\"><strong>".number_format($subTotalKredit, 2)."</strong></td>
				</tr>";
		$html .= "<tr>
					<td width=\"50\"></td>
					<td width=\"150\">GRAND TOTAL</td>
					<td width=\"30\"> : </td>
					<td width=\"130\" align=\"right\"><strong>".number_format($GrandTotal, 2)."</strong></td>
				</tr>";
		$html .= "</table>";
		$html .= "<hr/>";

		$html .= "<table>";
		$html .= "<tr>
					<td width=\"50\"></td>
					<td width=\"150\"></td>
					<td width=\"30\"></td>
					<td width=\"130\" align=\"right\"></td>
				</tr>";
		$html .= "<hr/>";
		$html .= "<tr>
					<td width=\"50\"></td>
					<td width=\"150\"></td>
					<td width=\"30\"></td>
					<td width=\"130\" align=\"right\"></td>
				</tr>";
		$html .= "</table>";

		$html .= "<table width=\"100%\">";
		$html .= "<tr>
					<td width=\"200\">JUMLAH BON TUNAI</td>
					<td width=\"30\"> : </td>
					<td width=\"130\" align=\"right\">".number_format($DataTransaksiPenjualan[0]['Countfcash'])."</td>
				</tr>";
		$html .= "<tr>
					<td width=\"200\">JUMLAH BON KUPON</td>
					<td width=\"30\"> : </td>
					<td width=\"130\" align=\"right\">".number_format($DataTransaksiPenjualan[0]['Countfkupon'])."</td>
				</tr>";
		$html .= "<tr>
					<td width=\"200\">JUMLAH BON SHU</td>
					<td width=\"30\"> : </td>
					<td width=\"130\" align=\"right\">".number_format($DataTransaksiPenjualan[0]['Countfshu'])."</td>
				</tr>";
		$html .= "<tr>
					<td width=\"200\">JUMLAH BON DEBET</td>
					<td width=\"30\"> : </td>
					<td width=\"130\" align=\"right\">".number_format($DataTransaksiPenjualan[0]['Countfdebet'])."</td>
				</tr>";
		$html .= "<tr>
					<td width=\"200\">JUMLAH BON KREDIT</td>
					<td width=\"30\"> : </td>
					<td width=\"130\" align=\"right\">".number_format($DataTransaksiPenjualan[0]['Countfkredit'])."</td>
				</tr>";
		$html .= "<tr>
					<td width=\"200\">JUMLAH BON KREDIT ANGS</td>
					<td width=\"30\"> : </td>
					<td width=\"130\" align=\"right\">".number_format($DataTransaksiPenjualan[0]['Countfjml_kreditAngs'])."</td>
				</tr>";
		$html .= "<tr>
					<td width=\"200\">JUMLAH BON KREDIT BUKU</td>
					<td width=\"30\"> : </td>
					<td width=\"130\" align=\"right\">".number_format($DataTransaksiPenjualan[0]['Countfjml_kreditBuku'])."</td>
				</tr>";
		$html .= "<tr>
					<td width=\"200\">JUMLAH BON KREDIT INS</td>
					<td width=\"30\"> : </td>
					<td width=\"130\" align=\"right\">".number_format($DataTransaksiPenjualan[0]['Countfjml_kreditIns'])."</td>
				</tr>";
		$html .= "<tr>
					<td width=\"200\">JUMLAH BON VOUCHER</td>
					<td width=\"30\"> : </td>
					<td width=\"130\" align=\"right\">".number_format($DataTransaksiPenjualan[0]['Countfvoucher'])."</td>
				</tr>";
		$html .= "</table>";

		$html .= "<table>";
		$html .= "<tr>
					<td width=\"50\"></td>
					<td width=\"120\"></td>
					<td width=\"30\"></td>
					<td width=\"100\" align=\"right\"></td>
				</tr>";
		$html .= "<hr/>";
		$html .= "<tr>
					<td width=\"50\"></td>
					<td width=\"120\"></td>
					<td width=\"30\"></td>
					<td width=\"100\" align=\"right\"></td>
				</tr>";
		$html .= "</table>";

		$text1 = "";
		$text2 = "";
		$text3 = "";
		$text4 = "";
		$text5 = "";
		$DataTransaksiPenjualanBawah = $this->laporan_model->RekapDetailPenjualanHarianBawah($_GET);
		$html .= "<table width=\"100%\">";
		foreach($DataTransaksiPenjualanBawah as $key => $value){
			if($value['total'] > 0){
			$html .= "<tr>
						<td width=\"50\">".$value['kode_akun']."</td>
						<td width=\"150\">".$value['nama_kategori']."</td>
						<td width=\"30\"> : </td>
						<td width=\"130\" align=\"right\">".number_format($value['total'], 2)."</td>
					</tr>";
			}else{
				$text1 = $value['JabatanMgr'];
				$text2 = $value['NamaMgr'];
				$text3 = $value['jabatanKabid'];
				$text4 = $value['NamaKabid'];
				$text5 = $value['jabatanUnit'];
			}
		}
		$html .= "</table>";
		$html .= "<hr/>";
		$html .= "<table>";
		$html .= "<tr>
					<td width=\"50\"></td>
					<td width=\"150\">GRAND TOTAL</td>
					<td width=\"30\"> : </td>
					<td width=\"130\" align=\"right\"><strong>".number_format($GrandTotal, 2)."</strong></td>
				</tr>";
		$html .= "</table>";
		$html .= "<table><tr><td></td></tr><tr><td></td></tr></table>";
		$html .= "<table>";
		$html .= "<tr>
					<td width=\"50\"></td>
					<td width=\"120\"></td>
					<td width=\"30\"></td>
					<td width=\"100\" align=\"right\"></td>
				</tr>";
		$html .= "<tr>
					<td width=\"50\"></td>
					<td width=\"120\"></td>
					<td width=\"30\"></td>
					<td width=\"100\" align=\"right\"></td>
				</tr>";
		$html .= "</table>";

		$html .= "<table>";
		$html .= "<tr>
					<td align=\"center\"><u>".$text1."</u></td>
					<td align=\"center\"><u>".$text3."</u></td>
				</tr>";
		$html .= "<tr>
					<td align=\"center\">".$text2."</td>
					<td align=\"center\">".$text4."</td>
				</tr>";
		$html .= "<tr>
					<td align=\"center\">&nbsp;</td>
					<td align=\"center\">&nbsp;</td>
				</tr>";
		$html .= "<tr>
					<td align=\"center\">&nbsp;</td>
					<td align=\"center\">&nbsp;</td>
				</tr>";
		$html .= "<tr>
					<td align=\"center\">&nbsp;</td>
					<td align=\"center\">&nbsp;</td>
				</tr>";
		$html .= "<tr>
					<td align=\"center\"><u>".$text5."</u></td>
					<td align=\"center\"><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></td>
				</tr>";
		$html .= "<tr>
					<td align=\"center\">&nbsp;</td>
					<td align=\"center\">TTd KASIR</td>
				</tr>";
		$html .= "</table>";

		$this->load->library('Pdf');
		
		$pdf = new TCPDF('p', 'mm', 'a4', true, 'UTF-8', false);
		$pdf->SetFont('Tahoma');
		$pdf->SetMargins(5, 5, 5);
		$pdf->SetHeaderMargin(5);
		$pdf->SetFooterMargin(5);
		// Add a page
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pagesize = array(150, 460);
		$pdf->AddPage('P', $pagesize);
		$pdf->writeHTML($html, true, false, true, false, '');
		$pdf->Output('Bukti_Kasbank.pdf', 'I');
	}
}