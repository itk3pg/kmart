<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Piutang extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('piutang_model');
		$this->load->model('kasbank_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('piutang/home');
		$this->load->view('general/footer');
	}
	
	public function getdatapiutang(){
		$DataPiutang = $this->piutang_model->getDataPiutang($_POST);
		
		$html = "<table class=\"table table-striped table-bordered table-hover\" id=\"dataTables-piutang\">
                    <thead>
                        <tr>
                       		<th>Tanggal</th>
                       		<th>Pelanggan</th>
                            <th>Bukti Penjualan</th>
							<th>No Kuitansi</th>
                            <th>Jatuh Tempo</th>
                            <th>Piutang</th>
                            <th>Bayar</th>
                            <th>Sisa</th>
                        </tr>
                    </thead>
                    <tbody>";
		foreach ($DataPiutang as $key => $value) {
			$sisa = $value['jumlah'] - $value['jumlah_bayar'];
			$sisaStr = number_format($sisa,2,",",".");
			if($sisa == 0){
				$sisaStr = "Lunas";
			}
			$html .= "<tr no_kuitansi=\"".$value['no_kuitansi']."\" id=\"".$value['ref_penjualan'].$value['pelanggan_kode']."\" bukti=\"".$value['ref_penjualan']."\" pelanggan_kode=\"".$value['pelanggan_kode']."\" nama_pelanggan=\"".$value['nama_pelanggan']."\" piutang=\"".$value['jumlah']."\" sisa=\"".$sisa."\">
						<td>".$value['tanggal']."</td>
						<td>".$value['nama_pelanggan']."</td>
						<td>".$value['ref_penjualan']."</td>
						<td>".$value['no_kuitansi']."</td>
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
	
	public function getdetailpembayaran(){
		$DataPembayaran = $this->piutang_model->getDetailPembayaran($_POST);
		
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
						<td align=\"right\">".number_format($value['jumlah'])."</td>
					  </tr>";
			$jumlahAll += $value['jumlah'];
		}
		$html .= "<tr>
					<td>TOTAL</td>
					<td align=\"right\">".number_format($jumlahAll)."</td>
				  </tr>";
		$html .= "</tbody>
				</table>";
		echo $html;
	}
	
	public function simpanpembayaran(){
		$this->piutang_model->SimpanPembayaran($_POST);
	}
	
	public function simpanpembayarankuitansi(){
		$dataBO = $this->piutang_model->getListBOKuitansi($_POST);
		
		foreach($dataBO as $key => $value){
			$_POST['ref_penjualan'] = $value['ref_penjualan'];
			$_POST['pelanggan_kode'] = $value['pelanggan_kode'];
			$_POST['jumlah'] = $value['jumlah'];
			$_POST['toko_kode'] = $value['toko_kode'];
			$this->piutang_model->SimpanPembayaran($_POST);
		}
		//kasbank
		//transfer ke pusat (290)
		if($_POST['pembayaran_melalui'] == "pusat_kuitansi"){
			if($_POST['pembayaran_ke'] == "112"){ // dari cek/giro
				$paramkasbank['mode'] = "BK";
			}else{
				$paramkasbank['mode'] = "KK";
			}
			$paramkasbank['kd_cb'] = "2802"; // 290
			$paramkasbank['mode_form'] = "i";
			$paramkasbank['unit_kode'] = $this->session->userdata('toko_kode');
			$paramkasbank['kd_kb'] = $_POST['pembayaran_ke']; // dari kas besar
			$paramkasbank['tanggal'] = $_POST['tanggal'];
			$paramkasbank['kd_subject'] = "1111117";
			$paramkasbank['nama_subject'] = "KASIR PUSAT KWSG";
			$paramkasbank['keterangan'] = "TRANSFER PUSAT ATAS PELUNASAN PIUTANG ".$_POST['no_kuitansi'];
			$paramkasbank['jumlah'] = $_POST['jumlah_pelunasan'];
			$paramkasbank['no_ref'] = $_POST['no_kuitansi'];
			
			$this->kasbank_model->SimpanKasbank($paramkasbank);
			//transfer ke pusat (290) ssp
			if($_POST['jumlah_ssp'] > 0){
				$paramkasbank['kd_cb'] = "2802"; // 290
				$paramkasbank['mode_form'] = "i";
				$paramkasbank['unit_kode'] = $this->session->userdata('toko_kode');
				$paramkasbank['kd_kb'] = $_POST['pembayaran_ke']; // dari kas besar
				$paramkasbank['tanggal'] = $_POST['tanggal'];
				$paramkasbank['kd_subject'] = "1111117";
				$paramkasbank['nama_subject'] = "KASIR PUSAT KWSG";
				$paramkasbank['keterangan'] = "TRANSFER PUSAT ATAS SSP PIUTANG ".$_POST['no_kuitansi'];
				$paramkasbank['jumlah'] = $_POST['jumlah_ssp'];
				$paramkasbank['no_ref'] = $_POST['no_kuitansi'];
				
				$this->kasbank_model->SimpanKasbank($paramkasbank);
			}
			
			//transfer ke pusat (290) pph
			if($_POST['jumlah_pph'] > 0){
				$paramkasbank['kd_cb'] = "2802"; // 290
				$paramkasbank['mode_form'] = "i";
				$paramkasbank['unit_kode'] = $this->session->userdata('toko_kode');
				$paramkasbank['kd_kb'] = $_POST['pembayaran_ke']; // dari kas besar
				$paramkasbank['tanggal'] = $_POST['tanggal'];
				$paramkasbank['kd_subject'] = "1111117";
				$paramkasbank['nama_subject'] = "KASIR PUSAT KWSG";
				$paramkasbank['keterangan'] = "TRANSFER PUSAT ATAS PPH PIUTANG ".$_POST['no_kuitansi'];
				$paramkasbank['jumlah'] = $_POST['jumlah_pph'];
				$paramkasbank['no_ref'] = $_POST['no_kuitansi'];
				
				$this->kasbank_model->SimpanKasbank($paramkasbank);
			}
		}
	}
	
	public function hapuspembayaran(){
		$this->piutang_model->HapusPembayaran($_POST);
	}
	
	public function getlistpiutang(){
		$DataPiutang = $this->piutang_model->getListDataPiutang($_GET);
		$jumlahdata = sizeof($DataPiutang);
		$DataResult = array();
		$DataResult['total_count'] = $jumlahdata;
		$DataResult['incomplete_results'] = false;
		$DataResult['items'] = $DataPiutang;
		
		echo json_encode($DataResult);
	}
	
	public function simpankuitansi(){
		$dataArr = json_decode(rawurldecode($_POST['data']));
		if($_POST['no_kuitansi'] != ""){
			$bulan = date('m');
			$tahun = date('Y');
			$_POST['nokuitansi'] = $_POST['no_kuitansi']."/KWSG/".$bulan.".".$tahun;
		}
		for($index=0;$index<sizeof($dataArr);$index = $index + 7){
			$ref_penjualan = $dataArr[$index];
			$kode_pelanggan = $dataArr[$index+2];
			
			$_POST['ref_penjualan'] = $ref_penjualan;
			$_POST['pelanggan_kode'] = $kode_pelanggan;
			$_POST['keterangan_kuitansi'] = base64_decode($_POST['keterangan_kuitansi']);
			
			$this->piutang_model->SimpanKuitansi($_POST);
		}
		
		echo $_POST['nokuitansi'];
	}
	
	public function getJumlahKuitansi(){
		$jumlah = $this->piutang_model->getJumlahKuitansi($_POST);
		
		echo $jumlah[0]['jumlah'];
	}
	
	public function batalkuitansi(){
		$this->piutang_model->BatalKuitansi($_POST);
	}
	
	public function getdatapiutangpelanggan(){
		$DataPiutangPelanggan = $this->piutang_model->getListDataPiutangPelanggan($_POST);
		$html = "";
		foreach($DataPiutangPelanggan as $key => $value){
			$html .= "<tr>
						<td>".$value['ref_penjualan']."</td>
						<td>".$value['tanggal']."</td>
						<td>".$value['pelanggan_kode']."</td>
						<td>".$value['nama_pelanggan']."</td>
						<td>".$value['jatuh_tempo']."</td>
						<td align=\"right\">".number_format($value['jumlah'],2)."</td>
						<td>
							<button type=\"button\" onclick=\"HapusRow(this)\" class=\"btn btn-default\"><i class=\"fa fa-times\"></i>
							</button>
						</td>
					</tr>";
		}
		
		echo $html;
	}
	
	public function cetakkuitansi(){
		$this->load->model('bukti_model');
		$DataBOKuitansi = $this->piutang_model->getDataBOKuitansi($_GET);
		/*if(strpos($DataBOKuitansi[0]['nama_pelanggan'], 'SEMEN INDONESIA') != false){
			$DataBOKuitansi[0]['nama_pelanggan'] = 'PT SEMEN INDONESIA (PERSERO) TBK.';
		}*/
		$DataBOKuitansi[0]['nama_pelanggan'] = $_GET['nama_pelanggan'];
		$TANGGALKWT = $_GET['tanggal_kuitansi'];
		
		$html = "<style>
				 	table {
				 		font-size: 12px;
				 		font-family: \"Courier New\", Courier, monospace;
				 	}
				 </style>
				 <table>
					<tr>
						<td width=\"180\">&nbsp;</td>
						<td width=\"90\">&nbsp;</td>
						<td width=\"130\">&nbsp;</td>
						<td width=\"165\">&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;&nbsp;".$_GET['no_kuitansi']."</td>
					</tr>
					<tr>
						<td height=\"15\">&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td colspan=\"3\">".$DataBOKuitansi[0]['nama_pelanggan']."</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td height=\"30\" colspan=\"3\">#".$this->bukti_model->Terbilang(round($DataBOKuitansi[0]['dpp']) + round($DataBOKuitansi[0]['ppn']))." RUPIAH #</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td colspan=\"3\">".$DataBOKuitansi[0]['keterangan_kuitansi']."</td>
					</tr>";
		if($_GET['mode_metode'] == "1"){ // tunai
			$html .= "<tr>
						<td>&nbsp;</td>
						<td colspan=\"3\">&nbsp;</td>
					</tr>";
		}else{ // transfer
			$html .= "<tr>
						<td>&nbsp;</td>
						<td colspan=\"3\">AC. BANK ......... NO REK. xxx0.xxxxx.xxxxxx</td>
					</tr>";
		}
		if($_GET['mode_ppn'] == "1"){
			$html .= "<tr>
						<td>&nbsp;</td>
						<td>JUMLAH</td>
						<td align=\"right\">RP ".number_format($DataBOKuitansi[0]['dpp'], "2", ",", ".")."</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>PPN 10%</td>
						<td align=\"right\">RP ".number_format($DataBOKuitansi[0]['ppn'], "2", ",", ".")."</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>TOTAL</td>
						<td align=\"right\">RP ".number_format(($DataBOKuitansi[0]['dpp'] + $DataBOKuitansi[0]['ppn']), "2", ",", ".")."</td>
						<td>&nbsp;</td>
					</tr>";
		}else{
			$html .= "<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td align=\"right\">&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>JUMLAH</td>
						<td align=\"right\">RP ".number_format(($DataBOKuitansi[0]['dpp'] + $DataBOKuitansi[0]['ppn']), "2", ",", ".")."</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>TOTAL</td>
						<td align=\"right\">RP ".number_format(($DataBOKuitansi[0]['dpp'] + $DataBOKuitansi[0]['ppn']), "2", ",", ".")."</td>
						<td>&nbsp;</td>
					</tr>";
		}
		$html .= "	<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>".$TANGGALKWT."</td>
					</tr>
					<tr>
						<td colspan=\"2\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".number_format(($DataBOKuitansi[0]['dpp'] + $DataBOKuitansi[0]['ppn']), "2", ",", ".")."</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;......................</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>MANAGER RETAIL</td>
					</tr>
				 </table>";
				 
		//echo $html;
		$this->load->library('Pdf');
		
		$pdf = new TCPDF("P", PDF_UNIT, 'A4', true, 'UTF-8', false);
		// Add a page
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->AddPage();
		$pdf->writeHTML($html, true, false, true, false, '');
		$pdf->Output('kuitansi.pdf', 'I');
	}
	
	public function cetakkuitansisegunting(){
		$this->load->model('bukti_model');
		$DataBOKuitansi = $this->piutang_model->getDataBOKuitansi($_GET);
		/*if(strpos($DataBOKuitansi[0]['nama_pelanggan'], 'SEMEN INDONESIA') != false){
			$DataBOKuitansi[0]['nama_pelanggan'] = 'PT SEMEN INDONESIA (PERSERO) TBK.';
		}*/
		$DataBOKuitansi[0]['nama_pelanggan'] = $_GET['nama_pelanggan'];
		$TANGGALKWT = $_GET['tanggal_kuitansi'];
		
		$html = "<style>
				 	table {
				 		font-size: 12px;
				 		font-family: \"Courier New\", Courier, monospace;
				 	}
				 </style>
				 <table>
					<tr>
						<td width=\"180\">&nbsp;</td>
						<td width=\"90\">&nbsp;</td>
						<td width=\"130\">&nbsp;</td>
						<td width=\"165\">&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>".$_GET['no_kuitansi']."</td>
					</tr>
					<tr>
						<td height=\"15\">&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td colspan=\"3\">".$DataBOKuitansi[0]['nama_pelanggan']."</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td height=\"30\" colspan=\"3\">#".$this->bukti_model->Terbilang(round($DataBOKuitansi[0]['dpp']) + round($DataBOKuitansi[0]['ppn']))." RUPIAH #</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td colspan=\"3\">".$DataBOKuitansi[0]['keterangan_kuitansi']."</td>
					</tr>";
		if($_GET['mode_metode'] == "1"){ // tunai
			$html .= "<tr>
						<td>&nbsp;</td>
						<td colspan=\"3\">&nbsp;</td>
					</tr>";
		}else{ // transfer
			$html .= "<tr>
						<td>&nbsp;</td>
						<td colspan=\"3\">AC. BANK .......... NO REK. 140.xxxxx.xxxxx</td>
					</tr>";
		}
		if($_GET['mode_ppn'] == "1"){
			$html .= "<tr>
						<td>&nbsp;</td>
						<td>JUMLAH</td>
						<td align=\"right\">RP ".number_format(round($DataBOKuitansi[0]['dpp']), "2", ",", ".")."</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>PPN 10%</td>
						<td align=\"right\">RP ".number_format(round($DataBOKuitansi[0]['ppn']), "2", ",", ".")."</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>TOTAL</td>
						<td align=\"right\">RP ".number_format((round($DataBOKuitansi[0]['dpp']) + round($DataBOKuitansi[0]['ppn'])), "2", ",", ".")."</td>
						<td>&nbsp;</td>
					</tr>";
		}else{
			$html .= "<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td align=\"right\">&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>JUMLAH</td>
						<td align=\"right\">RP ".number_format((round($DataBOKuitansi[0]['dpp']) + round($DataBOKuitansi[0]['ppn'])), "2", ",", ".")."</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>TOTAL</td>
						<td align=\"right\">RP ".number_format((round($DataBOKuitansi[0]['dpp']) + round($DataBOKuitansi[0]['ppn'])), "2", ",", ".")."</td>
						<td>&nbsp;</td>
					</tr>";
		}
		$html .= "	<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>".$TANGGALKWT."</td>
					</tr>
					<tr>
						<td colspan=\"2\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".number_format((round($DataBOKuitansi[0]['dpp']) + round($DataBOKuitansi[0]['ppn'])), "2", ",", ".")."</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td height=\"20\">&nbsp;</td>
						<td></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td colspan=\"2\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;...................</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td colspan=\"2\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;MANAGER RETAIL</td>
					</tr>
				 </table>";
				 
		//echo $html;
		$this->load->library('Pdf');
		
		$pdf = new TCPDF("P", PDF_UNIT, 'A4', true, 'UTF-8', false);
		// Add a page
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->AddPage();
		$pdf->writeHTML($html, true, false, true, false, '');
		$pdf->Output('kuitansi.pdf', 'I');
	}
	
	public function cetakrekappiutangkuitansi(){
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;Filename=rekap_piutang_kuitansi.xls");
		$DataRekapPiutangInstansi = $this->piutang_model->getRekapPiutangKuitansi($_GET);
		
		$html = "<table>
					<tr>
						<td colspan=\"10\" align=\"center\">REKAP KUITANSI</td>
					</tr>
					<tr>
						<td colspan=\"10\">No Kuitansi : ".$_GET['no_kuitansi']."</td>
					</tr>
				 </table>";
		$html .= "<table border=\"1\" id=\"table-rekap\">
					<thead>
						<tr>
							<th>Tanggal</th>
							<th>No Transaksi</th>
							<th>Kode Barang</th>
							<th>Nama Barang</th>
							<th>Jumlah</th>
							<th>Harga Jual</th>
							<th>Total</th>
							<th>DPP</th>
							<th>PPn</th>
							<th>Total</th>
						</tr>
					</thead>
					<tbody>";
		$kode_pelanggan = "";
		$bukti = "";
		$TotalPerbukti = 0;
		$TotalDPPPerbukti = 0;
		$TotalPPNPerbukti = 0;
		$TotalTotalPerbukti = 0;
		
		$TotalPerpelanggan = 0;
		$TotalDPPPerpelanggan = 0;
		$TotalPPNPerpelanggan = 0;
		$TotalTotalPerpelanggan = 0;
		foreach ($DataRekapPiutangInstansi as $key => $value) {
			if($bukti == ""){
				$bukti = $value['fcode'];
			}
			if($value['fcode'] != $bukti){
				$html .= "<tr>
							<td colspan=\"6\"><strong>Sub Total :</strong></td>
							<td align=\"right\"><strong>".number_format($TotalPerbukti,2)."</strong></td>
							<td align=\"right\"><strong>".number_format($TotalDPPPerbukti,2)."</strong></td>
							<td align=\"right\"><strong>".number_format($TotalPPNPerbukti,2)."</strong></td>
							<td align=\"right\"><strong>".number_format($TotalTotalPerbukti,2)."</strong></td>
						  </tr>";
				$bukti = $value['fcode'];
				$TotalPerbukti = 0;
				$TotalDPPPerbukti = 0;
				$TotalPPNPerbukti = 0;
				$TotalTotalPerbukti = 0;
			}
			if($value['fcustkey'] != $kode_pelanggan){
				if($kode_pelanggan != ""){
					$html .= "<tr>
								<td colspan=\"6\"><strong>Total :</strong></td>
								<td align=\"right\"><strong>".number_format($TotalPerpelanggan,2)."</strong></td>
								<td align=\"right\"><strong>".number_format($TotalDPPPerpelanggan,2)."</strong></td>
								<td align=\"right\"><strong>".number_format($TotalPPNPerpelanggan,2)."</strong></td>
								<td align=\"right\"><strong>".number_format($TotalTotalPerpelanggan,2)."</strong></td>
							  </tr>";
				}
				$html .= "<tr>
							<td colspan=\"10\"><strong>".$value['fcustkey']." - ".$value['fcustname']."</strong></td>
						  </tr>";
				$kode_pelanggan = $value['fcustkey'];
				
				$TotalPerpelanggan = 0;
				$TotalDPPPerpelanggan = 0;
				$TotalPPNPerpelanggan = 0;
				$TotalTotalPerpelanggan = 0;
			}
			$html .= "<tr>
						<td>".$value['fdate']."</td>
						<td>".$value['fcode']."</td>
						<td align=\"left\">'".$value['fitemkey']."</td>
						<td>".$value['nama_barang']."</td>
						<td align=\"right\">".$value['fqty']."</td>
						<td align=\"right\">".number_format($value['fprice'],2)."</td>
						<td align=\"right\">".number_format($value['ftotal'],2)."</td>
						<td align=\"right\">".number_format($value['dpp'],2)."</td>
						<td align=\"right\">".number_format($value['ppn'],2)."</td>
						<td align=\"right\">".number_format($value['ftotal'],2)."</td>
					 </tr>";
			
			$TotalPerbukti += $value['ftotal'];
			$TotalDPPPerbukti += $value['dpp'];
			$TotalPPNPerbukti += $value['ppn'];
			$TotalTotalPerbukti += $value['ftotal'];
			
			$TotalPerpelanggan += $value['ftotal'];
			$TotalDPPPerpelanggan += $value['dpp'];
			$TotalPPNPerpelanggan += $value['ppn'];
			$TotalTotalPerpelanggan += $value['ftotal'];
		}
		$html .= "<tr>
					<td colspan=\"6\"><strong>Sub Total :</strong></td>
					<td align=\"right\"><strong>".number_format($TotalPerbukti,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalDPPPerbukti,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalPPNPerbukti,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalTotalPerbukti,2)."</strong></td>
				  </tr>";
		$html .= "<tr>
					<td colspan=\"6\"><strong>Total :</strong></td>
					<td align=\"right\"><strong>".number_format($TotalPerpelanggan,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalDPPPerpelanggan,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalPPNPerpelanggan,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalTotalPerpelanggan,2)."</strong></td>
				  </tr>";
		$html .= "</tbody></table>";		 
		echo $html;
	}
	
	function getCurrentDate(){
		$tahun = date("Y");
		$bulan = date("m");
		$tanggal = date("d");
		
		switch($bulan){
			case '01' : $bulan = "Januari";
			break;
			case '02' : $bulan = "Februari";
			break;
			case '03' : $bulan = "Maret";
			break;
			case '04' : $bulan = "April";
			break;
			case '05' : $bulan = "Mei";
			break;
			case '06' : $bulan = "Juni";
			break;
			case '07' : $bulan = "Juli";
			break;
			case '08' : $bulan = "Agustus";
			break;
			case '09' : $bulan = "September";
			break;
			case '10' : $bulan = "Oktober";
			break;
			case '11' : $bulan = "November";
			break;
			case '12' : $bulan = "Desember";
			break;
		}
		
		$strCurrentDate = $tanggal." ".$bulan." ".$tahun;
		return $strCurrentDate;
	}
}
