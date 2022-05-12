<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kasbank extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('kasbank_model');
		$this->load->model('supplier_model');
		$this->load->model('pelanggan_model');
		$this->load->model('toko_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$DataKB = $this->kasbank_model->getDataKB();
		$DataSupplier = $this->supplier_model->getDataSupplier();
		$DataPelanggan = $this->pelanggan_model->getDataPelanggan();
		$DataToko = $this->toko_model->getAllDataToko();
		
		$Param  = array();
		$Param['DataKB'] = $DataKB;
		$Param['DataSupplier'] = $DataSupplier;
		$Param['DataPelanggan'] = $DataPelanggan;
		$Param['DataToko'] = $DataToko;
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('kasbank/home', $Param);
		$this->load->view('general/footer');
	}
	
	public function getdatakasbank(){
		$DataKasBank = $this->kasbank_model->getDataKasbank($_POST);
		
		$html = "<table class=\"table table-striped table-bordered table-hover\" id=\"dataTables-kasbank\">
                    <thead>
                        <tr>
                       		<th>Tanggal</th>
                       		<th>Bukti</th>
                            <th>KD KB</th>
                            <th>KD CB</th>
                            <th>Dibayarkan/Diterima</th>
                            <th>Keterangan</th>
                            <th>Debet</th>
                            <th>Kredit</th>
                        </tr>
                    </thead>
                    <tbody>";
		foreach ($DataKasBank as $key => $value) {
			$html .= "<tr data=\"".base64_encode(json_encode($value))."\" bukti=\"".$value['bukti']."\" kd_kb=\"".$value['kd_kb']."\" jumlah=\"".$value['jumlah']."\">
						<td>".$value['tanggal']."</td>
						<td>".$value['bukti']."</td>
						<td>".$value['kd_kb']."</td>
						<td>".$value['kd_cb']."</td>
						<td>".$value['nama_subject']."</td>
						<td>".$value['keterangan']."</td>";
			if(substr($value['bukti'], 1, 1) == "K"){
				$html .= "<td></td><td style=\"text-align: right;\">".number_format($value['jumlah'],2,",",".")."</td>";
			}else{
				$html .= "<td style=\"text-align: right;\">".number_format($value['jumlah'],2,",",".")."</td><td></td>";
			}
			$html .= "</tr>";
		}
		
		echo $html;
	}
	
	public function cetakdatakasbankharian(){
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;Filename=rekap_kasbank_".$_GET['tanggal'].".xls");
		
		$DataKasBank = $this->kasbank_model->getDataKasbank($_GET);
		
		$html = "<table>
					<tr>
						<td colspan=\"8\" align=\"center\">Rekap Kasbank Harian</td>
					</tr>
					<tr>
						<td colspan=\"8\" align=\"center\">".$_GET['tanggal']."</td>
					</tr>
					<tr>
						<td colspan=\"8\" align=\"center\"></td>
					</tr>
				 </table>";
		$html .= "<table border=\"1\">
                    <thead>
                        <tr>
                       		<th>Tanggal</th>
                       		<th>Bukti</th>
                            <th>KD KB</th>
                            <th>KD CB</th>
                            <th>Dibayarkan/Diterima</th>
                            <th>Keterangan</th>
                            <th>Debet</th>
                            <th>Kredit</th>
                        </tr>
                    </thead>
                    <tbody>";
		foreach ($DataKasBank as $key => $value) {
			$html .= "<tr>
						<td>".$value['tanggal']."</td>
						<td>".$value['bukti']."</td>
						<td>".$value['kd_kb']."</td>
						<td>".$value['kd_cb']."</td>
						<td>".$value['nama_subject']."</td>
						<td>".$value['keterangan']."</td>";
			if(substr($value['bukti'], 1, 1) == "K"){
				$html .= "<td></td><td style=\"text-align: right;\">".$value['jumlah']."</td>";
			}else{
				$html .= "<td style=\"text-align: right;\">".$value['jumlah']."</td><td></td>";
			}
			$html .= "</tr>";
		}
		
		echo $html;
	}
	
	public function getlistsubject(){
		$DataSubject = $this->kasbank_model->getListDataSubject($_GET);
		$jumlahdata = sizeof($DataSubject);
		$DataResult = array();
		$DataResult['total_count'] = $jumlahdata;
		$DataResult['incomplete_results'] = false;
		$DataResult['items'] = $DataSubject;
		
		echo json_encode($DataResult);
	}
	
	public function getdatacb(){
		$DataKDCB = $this->kasbank_model->getDataCB($_POST);
		
		$html = "<option value=\"-1\">Pilih Kode Cash Budget</option>";
		foreach ($DataKDCB as $key => $value) {
			$html .= "<option value=\"".$value['kd_cb']."\">".$value['kd_cb']."-".$value['keterangan']."</option>";
		}

		echo $html;
	}

	public function getdatanopol(){
		$json_url = "http://101.50.1.205/serviceapp/bbmvmartresto.php?mode=datanopolvmart";
		//echo $json_url;
		$json = file_get_contents($json_url);
		$DataNopol = json_decode($json, TRUE);
		
		$html = "<option value=\"-1\">Pilih Nopol</option>";
		foreach ($DataNopol as $key => $value) {
			$html .= "<option value=\"".base64_encode(json_encode($value))."\">".$value['nopol']."</option>";
		}

		echo $html;
	}
	
	public function cetakkasbank(){
		$DataKasbank = $this->kasbank_model->getDataKasbankCetak($_GET);
		$html = "<style>
				 	table {
				 		font-size: 8px;
				 		font-family: \"Courier New\", Courier, monospace;
				 	}
				 	table.content{
				 		padding: 2px;
				 	}
				 </style>
				 <table>
				 	<tr>
				 		<td>KOPERASI KARYAWAN KELUARGA BESAR PETROKIMIA GRESIK</td>
				 	</tr>
				 	<tr>
				 		<td>UNIT K-MART</td>
				 	</tr>
				 	<tr>
				 		<td>&nbsp;</td>
				 	</tr>
				 	<tr>";
		if(substr($_GET['bukti'], 1, 1) == 'K'){ // kas keluar
			$html .= "<td style=\"font-size: 12px;\"><strong>KAS KELUAR</strong></td>";
		}else{ // kas masuk
			$html .= "<td style=\"font-size: 12px;\"><strong>KAS MASUK</strong></td>";
		}
				 		
		$html .= "	</tr>
				 </table>
				 <br/><br/>
				 <table>
				 	<tr>
				 		<td colspan=\"3\">Kode Kas/Bank &nbsp;&nbsp;&nbsp;&nbsp;: ".$DataKasbank[0]['kd_kb']."/".$DataKasbank[0]['nama_kb']."</td>
				 		<td colspan=\"2\">Tanggal : ".$DataKasbank[0]['tanggal']."</td>
				 	</tr>
				 	<tr>";
		if(substr($_GET['bukti'], 1, 1) == 'K'){ // kas keluar
			$html .= "<td colspan=\"3\">Dibayarkan Kepada : ".$DataKasbank[0]['kode_subject']."/".$DataKasbank[0]['nama_subject']."</td>";
		}else{ // kas masuk
			$html .= "<td colspan=\"3\">Dibayarkan Oleh &nbsp;&nbsp;: ".$DataKasbank[0]['kode_subject']."/".$DataKasbank[0]['nama_subject']."</td>";
		}	 		
		$html .= "	  <td colspan=\"2\">Bukti &nbsp;&nbsp;: ".$DataKasbank[0]['bukti']."</td>
				 	</tr>
				 </table>
				 <br/><br/>
				 <table class=\"content\" width=\"1300px\" border=\"1\">
					 <tr>
						<td align=\"center\" width=\"30px;\">No.</td>
						<td align=\"center\" width=\"40px;\">C.B</td>
						<td align=\"center\">Keterangan</td>
						<td align=\"center\" width=\"80px;\">Bukti Pendukung</td>
						<td align=\"center\" width=\"80px;\">Jumlah</td>
					 </tr>";
		foreach ($DataKasbank as $key => $value) {
			$html .= "<tr>
							<td>001<br/><br/><br/><br/></td>
							<td>".$value['kd_cb']."</td>
							<td>".$value['keterangan']."</td>
							<td>".$value['no_ref']."</td>
							<td align=\"right\">".number_format($value['jumlah'],2,",",".")."</td>
						</tr>
						<tr>
							<td colspan=\"4\">* ".$this->Terbilang($value['jumlah'])." RUPIAH *</td>
							<td align=\"right\">".number_format($value['jumlah'],2,",",".")."</td>
						</tr>";
		}
		$html .= "</table>";
		$html .= "<table class=\"content\" border=\"1\">
					<tr>
						<td width=\"100px\">Disetujui</td>
						<td width=\"100px\">Dibuat</td>
						<td width=\"210px\">Nama :<br/><br/>Alamat :<br/><br/><br/></td>
						<td width=\"80px\">Tanda tangan Penerima</td>
					</tr>
				  </table>";
		$this->load->library('Pdf');
		
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// Add a page
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->AddPage();
		$pdf->writeHTML($html, true, false, true, false, '');
		$pdf->Output('Bukti_Kasbank.pdf', 'I');
	}
	
	function Terbilang($a) {
	    $ambil = array("", "SATU", "DUA", "TIGA", "EMPAT", "LIMA", "ENAM", "TUJUH", "DELAPAN", "SEMBILAN", "SEPULUH", "SEBELAS");
	    if ($a < 12)
	        return " " . $ambil[$a];
	    elseif ($a < 20)
	        return $this->Terbilang($a - 10) . " BELAS";
	    elseif ($a < 100)
	        return $this->Terbilang($a / 10) . " PULUH" . $this->Terbilang($a % 10);
	    elseif ($a < 200)
	        return " SERATUS" . $this->Terbilang($a - 100);
	    elseif ($a < 1000)
	        return $this->Terbilang($a / 100) . " RATUS" . $this->Terbilang($a % 100);
	    elseif ($a < 2000)
	        return " SERIBU" . $this->Terbilang($a - 1000);
	    elseif ($a < 1000000)
	        return $this->Terbilang($a / 1000) . " RIBU" . $this->Terbilang($a % 1000);
	    elseif ($a < 1000000000)
	        return $this->Terbilang($a / 1000000) . " JUTA" . $this->Terbilang($a % 1000000);
	}

	public function simpankasbank(){
		$this->kasbank_model->SimpanKasbank($_POST);
	}
	
	public function hapuskasbank(){
		$this->kasbank_model->HapusKasbank($_POST);
	}
}
