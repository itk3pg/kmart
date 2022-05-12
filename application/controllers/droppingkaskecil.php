<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Droppingkaskecil extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('droppingkaskecil_model');
		$this->load->model('toko_model');
		$this->load->model('bukti_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$DataToko = $this->toko_model->getAllDataToko();
		
		$Param  = array();
		$Param['DataToko'] = $DataToko;
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('droppingkaskecil/home', $Param);
		$this->load->view('general/footer');
	}
	
	public function getdatadroppingkaskecil(){
		$DataDroppingKasKecil = $this->droppingkaskecil_model->getDataDroppingKasKecil($_POST);
		
		$Status = "PENGAJUAN";
		$html = "<table class=\"table table-striped table-bordered table-hover\" id=\"dataTables-droppingkaskecil\">
                    <thead>
                        <tr>
							<th>TANGGAL</th>
                       		<th>BUKTI</th>
							<th>UNIT</th>
                            <th>SALDO KK</th>
							<th>JUMLAH</th>
							<th>TAHAP</th>
							<th>STATUS APP DOK</th>
							<th>STATUS VERIFIKASI</th>
							<th>JML TEMUAN</th>
							<th>STATUS PPU</th>
							<th>STATUS REALISASI</th>
                        </tr>
                    </thead>
                    <tbody>";
		foreach ($DataDroppingKasKecil as $key => $value) {
			$DataTemuan = $this->droppingkaskecil_model->getDataTemuan($value);
			if($value['is_app_dok'] == '0'){
				$value['is_app_dok'] = 'Belum';
			}else{
				$value['is_app_dok'] = $value['waktu_app_dok'];
			}
			if($value['is_verifikasi'] == '0'){
				$value['is_verifikasi'] = 'Belum';
			}else{
				if(sizeof($DataTemuan) > 0){
					$value['is_verifikasi'] = "<p style=\"color: red;\">".$value['waktu_verifikasi']."</p>";
				}else{
					$value['is_verifikasi'] = $value['waktu_verifikasi'];
				}
			}
			if($value['is_ppu'] == '0'){
				$value['is_ppu'] = 'Belum';
			}else{
				$value['is_ppu'] = $value['waktu_ppu'];
			}
			if($value['is_realisasi'] == '0'){
				$value['is_realisasi'] = 'Belum';
			}else{
				$value['is_realisasi'] = $value['waktu_realisasi'];
			}
				
			if(sizeof($DataTemuan) > 0){
				$value['jumlah_temuan'] = "<button onclick=\"ShowTemuan('".$value['bukti']."')\">".sizeof($DataTemuan)."</button>";
				$value['jumlah_temuan'] = "<button id=\"btn_hapus\" onclick=\"ShowTemuan('".base64_encode($DataTemuan[0]['keterangan'])."')\" class=\"btn btn-danger btn-sm\" type=\"button\">
						".sizeof($DataTemuan)."
					</button>";
			}else{
				$value['jumlah_temuan'] = sizeof($DataTemuan);
			}
			$html .= "<tr data=\"".base64_encode(json_encode($value))."\">
						<td>".$value['tanggal']."</td>
						<td>".$value['bukti']."</td>
						<td>".$value['nama']."</td>
						<td>".number_format($value['saldo_kas_kecil'],2)."</td>
						<td>".number_format($value['jumlah'],2)."</td>
						<td>".$value['tahap_pengajuan']."</td>
						<td>".$value['is_app_dok']."</td>
						<td>".$value['is_verifikasi']."</td>
						<td>".$value['jumlah_temuan']."</td>
						<td>".$value['is_ppu']."</td>
						<td>".$value['is_realisasi']."</td>
					  </tr>";
		}
		
		$html .= "</tbody>
				</table>";
		echo $html;
	}
	
	public function gettahap(){
		$Tahap = $this->droppingkaskecil_model->getTahap($_POST);
		
		echo $Tahap;
	}
	
	public function getsaldokk(){
		$saldokk = $this->droppingkaskecil_model->getSaldoKK($_POST);
		
		echo $saldokk;
	}
	
	public function getsaldobankdropping(){
		$saldobankdropping = $this->droppingkaskecil_model->getSaldoBankDropping($_POST);
		
		echo $saldobankdropping;
	}
	
	public function getplafon(){
		$plafon = $this->droppingkaskecil_model->getPlafon($_POST);
		
		echo $plafon;
	}
	
	public function simpandroppingkaskecil(){
		$Pesan = $this->droppingkaskecil_model->SimpanDroppingKasKecil($_POST);
		
		echo $Pesan;
	}
	
	public function setappdok(){
		$this->droppingkaskecil_model->setApproveDok($_POST);
	}
	
	public function setverifikasi(){
		$this->droppingkaskecil_model->setVerifikasi($_POST);
	}
	
	public function setppu(){
		$this->droppingkaskecil_model->setPPU($_POST);
	}
	
	public function setrealisasi(){
		$this->droppingkaskecil_model->setRealisasi($_POST);
	}
	
	public function hapusdroppingkaskecil(){
		$this->droppingkaskecil_model->HapusDroppingKasKecil($_POST);
	}
	
	public function cetakdroppingkaskecil(){
		$DataDropping = $this->droppingkaskecil_model->getDataDropping($_GET);
		$DataBankDropping = $this->droppingkaskecil_model->getDataBankDropping($_GET);
		$DataPlafon = $this->droppingkaskecil_model->getPlafon($_GET);
		$html = "<p style=\"font-size: 10px;\" align=\"center\"><strong>Form Pengajuan Dropping Kas Kecil</strong></p>";
		$html .= "<table width=\"300px\" style=\"font-size: 10px;\">
					<tr>
						<td width=\"100px;\">No Bukti</td>
						<td width=\"30px;\"> : </td>
						<td align=\"right\">".$DataDropping[0]['bukti']."</td>
					</tr>
					<tr>
						<td width=\"100px;\">Saldo Kas Kecil</td>
						<td width=\"30px;\"> : </td>
						<td align=\"right\">".number_format($DataDropping[0]['saldo_kas_kecil'])."</td>
					</tr>
					<tr>
						<td width=\"100px;\">Plafon Maksimal</td>
						<td width=\"30px;\"> : </td>
						<td align=\"right\">".number_format($DataPlafon)."</td>
					</tr>
				  </table><br/><br/><br/>";
		$html .= "<table border=\"1\" style=\"font-size: 10px; padding: 5px;\">
				  	<thead>
				  		<tr>
				  			<th align=\"center\" width=\"110px\">Tanggal</th>
				  			<th align=\"center\" width=\"180px\">Keterangan</th>
				  			<th align=\"center\" width=\"110px\">Nama Unit</th>
				  			<th align=\"center\">Jumlah (Rp.)</th>
				  		</tr>
				  	</thead>
				  	<tbody>
				  		<tr>
				  			<td width=\"110px\">".$DataDropping[0]['tanggal']."</td>
				  			<td width=\"180px\">Pengajuan dropping kas kecil tahap ".$DataDropping[0]['tahap_pengajuan']."</td>
				  			<td width=\"110px\">".$DataDropping[0]['nama_unit']."</td>
				  			<td align=\"right\">".number_format($DataDropping[0]['jumlah'])."</td>
				  		</tr>
				  		<tr>
				  			<td colspan=\"3\">Jumlah</td>
				  			<td align=\"right\">".number_format($DataDropping[0]['jumlah'])."</td>
				  		</tr>
				  		<tr>
				  			<td colspan=\"4\">Terbilang &nbsp; : &nbsp;&nbsp;<i><strong>".$this->bukti_model->Terbilang($DataDropping[0]['jumlah'])."</strong></i>
				  			</td>
				  		</tr>
				  	</tbody>
				 </table>
				 <br/><br/>
				 <table width=\"370px\" style=\"font-size: 10px;\" border=\"1\">
				 	<tbody>
				 		<tr>
				 			<td colspan=\"3\">Keterangan :</td>
				 		</tr>
					 	<tr>
				  			<td width=\"300px\">Tambahan pemasukan Bank Dropping</td>
				  			<td width=\"10px\">:</td>
				  			<td align=\"right\" width=\"60px\">".number_format($DataBankDropping['saldo_bank_masuk'])."</td>
				  		</tr>
				  		<tr>
				  			<td width=\"300px\">Tambahan pengeluaran Bank Dropping</td>
				  			<td width=\"10px\">:</td>
				  			<td align=\"right\" width=\"60px\">".number_format($DataBankDropping['saldo_bank_keluar'])."</td>
				  		</tr>
				  		<tr>
				  			<td width=\"300px\"><strong>Jumlah</strong></td>
				  			<td width=\"10px\"><strong>:</strong></td>
							<td align=\"right\" width=\"60px\"><strong>".number_format($DataBankDropping['saldo_bank_masuk'] - $DataBankDropping['saldo_bank_keluar'])."</strong></td>
				  		</tr>
			  		</tbody>
				 </table>
				 <br/><br/>";
		$html .= "<table style=\"font-size: 10px;\">
				  	<tr>
				  		<td align=\"center\">SPV Adm & Keuangan</td>
				  		<td align=\"center\">MO DC</td>
				  		<td align=\"center\">MO Operation</td>
				  		<td align=\"center\">MO Merchandising</td>
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
				  		<td>&nbsp;</td>
				  	</tr>
				  	<tr>
				  		<td>&nbsp;</td>
				  		<td>&nbsp;</td>
				  		<td>&nbsp;</td>
				  		<td>&nbsp;</td>
				  	</tr>
				  	<tr>
				  		<td align=\"center\">( .............................. )</td>
				  		<td align=\"center\">( .............................. )</td>
				  		<td align=\"center\">( .............................. )</td>
				  		<td align=\"center\">( .............................. )</td>
				  	</tr>
				  </table>";

		$this->load->library('Pdf');
		
		$pdf = new TCPDF("P", PDF_UNIT, 'A4', true, 'UTF-8', false);
		// Add a page
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->AddPage();
		$pdf->writeHTML($html, true, false, true, false, '');
		$pdf->Output('DroppingKasKecil.pdf', 'I');
	}
	
	public function cetakppu(){
		$DataDropping = $this->droppingkaskecil_model->getDataDropping($_GET);
		$html = "<p style=\"font-size: 10px;\" align=\"center\"><strong>Form PPU</strong></p>";
		$html .= "<table width=\"300px\" style=\"font-size: 10px;\">
					<tr>
						<td width=\"50px;\">Tanggal</td>
						<td width=\"30px;\"> : </td>
						<td>".date('d-m-Y')."</td>
					</tr>
				  </table><br/><br/><br/>";
		$html .= "<table border=\"1\" style=\"font-size: 10px; padding: 5px;\">
				  	<thead>
				  		<tr>
				  			<th align=\"center\">Tanggal</th>
				  			<th align=\"center\" width=\"70px\">No Bukti</th>
				  			<th align=\"center\" width=\"150px\">Keterangan</th>
				  			<th align=\"center\">Nama Unit</th>
				  			<th align=\"center\">Jumlah (Rp.)</th>
				  		</tr>
				  	</thead>
				  	<tbody>
				  		<tr>
				  			<td>".$DataDropping[0]['tanggal']."</td>
				  			<td width=\"70px\">".$DataDropping[0]['bukti']."</td>
				  			<td width=\"150px\">Pengajuan dropping kas kecil tahap ".$DataDropping[0]['tahap_pengajuan']."</td>
				  			<td>".$DataDropping[0]['nama_unit']."</td>
				  			<td align=\"right\">".number_format($DataDropping[0]['jumlah'])."</td>
				  		</tr>
				  		<tr>
				  			<td colspan=\"4\">Jumlah</td>
				  			<td align=\"right\">".number_format($DataDropping[0]['jumlah'])."</td>
				  		</tr>
				  	</tbody>
				 </table><br/><br/>";
		$html .= "<table style=\"font-size: 10px;\">
				  	<tr>
				  		<td align=\"center\">Manager Keuangan</td>
				  		<td align=\"center\">Manager Akuntansi</td>
				  		<td align=\"center\">Verifikator</td>
				  	</tr>
				  	<tr>
				  		<td>&nbsp;</td>
				  		<td>&nbsp;</td>
				  	</tr>
				  	<tr>
				  		<td>&nbsp;</td>
				  		<td>&nbsp;</td>
				  	</tr>
				  	<tr>
				  		<td>&nbsp;</td>
				  		<td>&nbsp;</td>
				  	</tr>
				  	<tr>
				  		<td>&nbsp;</td>
				  		<td>&nbsp;</td>
				  	</tr>
				  	<tr>
				  		<td>&nbsp;</td>
				  		<td>&nbsp;</td>
				  	</tr>
				  	<tr>
				  		<td align=\"center\">(&nbsp;&nbsp;Whiwhin Setiawan&nbsp;&nbsp;)</td>
				  		<td align=\"center\">(&nbsp;&nbsp;Yudi Trisno, SE.&nbsp;&nbsp;)</td>
				  		<td align=\"center\">(&nbsp;&nbsp;Retno Setiarin, SE.&nbsp;&nbsp;)</td>
				  	</tr>
				  </table>";
		
		$this->load->library('Pdf');
		$pdf = new TCPDF("P", PDF_UNIT, 'A4', true, 'UTF-8', false);
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->AddPage();
		$pdf->writeHTML($html, true, false, true, false, '');
		
		$DataTemuan = $this->droppingkaskecil_model->getDataTemuan($_GET);
		$html2 = "<p>Daftar Temuan : </p>
					<ul>";
		foreach($DataTemuan as $key => $value){
			$html2 .= "<li>".$value['keterangan']."</li>";
		}
		$html2 .= "</ul>";
			
		$pdf->AddPage();
		$pdf->writeHTML($html2, true, false, true, false, '');
		$pdf->Output('ppu_dropping_kaskecil'.$_GET['bukti'].'.pdf', 'I');
	}
	
	public function cetakrinciankasbank(){
		$DataRincianKasKecil = $this->droppingkaskecil_model->getrinciankaskecil($_GET);
		$DataPengeluaranBankDropping = $this->droppingkaskecil_model->getpengeluaranbankdropping($_GET);
		$DataPemasukanBankDropping = $this->droppingkaskecil_model->getpemasukanbankdropping($_GET);
		$html = "<table border=\"1\" style=\"font-size: 10px; padding: 5px;\">
					<thead>
						<tr>
							<th align=\"center\">Tanggal</th>
							<th align=\"center\">Bukti</th>
							<th align=\"center\">Kode Subject</th>
							<th align=\"center\">Keterangan</th>
							<th align=\"center\">C.B</th>
							<th align=\"center\">Jumlah</th>
						</tr>
					</thead>
					<tbody>";
		$i		= 1;
		$tanggal = "";
		$jumlahpertanggal = 0;
		$totalAll1 = 0;
		foreach($DataRincianKasKecil as $key => $value){
			if($tanggal != $value['tanggal'] && $tanggal != ""){
				$html .= "<tr>
							<td colspan=\"5\"><strong>Sub Total</strong></td>
							<td align=\"right\"><strong>".number_format($jumlahpertanggal)."</strong></td>
						  </tr>";
				$html .= "<tr>
							<td>".$value['tanggal']."</td>
							<td>".$value['bukti']."</td>
							<td>".$value['kode_subject']."</td>
							<td>".$value['keterangan']."</td>
							<td>".$value['kd_cb']."</td>
							<td align=\"right\">".number_format($value['jumlah'])."</td>
						  </tr>";
				$jumlahpertanggal = $value['jumlah'];
				$tanggal = $value['tanggal'];
			}else{
				$html .= "<tr>
							<td>".$value['tanggal']."</td>
							<td>".$value['bukti']."</td>
							<td>".$value['kode_subject']."</td>
							<td>".$value['keterangan']."</td>
							<td>".$value['kd_cb']."</td>
							<td align=\"right\">".number_format($value['jumlah'])."</td>
						  </tr>";
				$jumlahpertanggal += $value['jumlah'];
				$tanggal = $value['tanggal'];
			}
			$totalAll1 += $value['jumlah'];
			$i++;
		}
		$html .= "<tr>
					<td colspan=\"5\"><strong>Sub Total</strong></td>
					<td align=\"right\"><strong>".number_format($jumlahpertanggal)."</strong></td>
				  </tr>
				  <tr>
					<td colspan=\"5\"><strong>Total</strong></td>
					<td align=\"right\"><strong>".number_format($totalAll1)."</strong></td>
				  </tr>";
		$html .= "<tr>
					<td colspan=\"6\">&nbsp;</td>
				  </tr>
				  <tr>
					<td colspan=\"6\"><strong>TAMBAHAN PENGELUARAN DARI BANK DROPPING</strong></td>
				  </tr>";
		$i		= 1;
		$tanggal = "";
		$jumlahpertanggal = 0;
		$totalAll2 = 0;
		foreach($DataPengeluaranBankDropping as $key => $value){
			if($tanggal != $value['tanggal'] && $tanggal != ""){
				$html .= "<tr>
							<td colspan=\"5\"><strong>Sub Total</strong></td>
							<td align=\"right\"><strong>".number_format($jumlahpertanggal)."</strong></td>
						  </tr>";
				$html .= "<tr>
							<td>".$value['tanggal']."</td>
							<td>".$value['bukti']."</td>
							<td>".$value['kode_subject']."</td>
							<td>".$value['keterangan']."</td>
							<td>".$value['kd_cb']."</td>
							<td align=\"right\">".number_format($value['jumlah'])."</td>
						  </tr>";
				$jumlahpertanggal = $value['jumlah'];
				$tanggal = $value['tanggal'];
			}else{
				$html .= "<tr>
							<td>".$value['tanggal']."</td>
							<td>".$value['bukti']."</td>
							<td>".$value['kode_subject']."</td>
							<td>".$value['keterangan']."</td>
							<td>".$value['kd_cb']."</td>
							<td align=\"right\">".number_format($value['jumlah'])."</td>
						  </tr>";
				$jumlahpertanggal += $value['jumlah'];
				$tanggal = $value['tanggal'];
			}
			$totalAll2 += $value['jumlah'];
			$i++;
		}
		$html .= "<tr>
					<td colspan=\"5\"><strong>Sub Total</strong></td>
					<td align=\"right\"><strong>".number_format($jumlahpertanggal)."</strong></td>
				  </tr>
				  <tr>
					<td colspan=\"5\"><strong>Total</strong></td>
					<td align=\"right\"><strong>".number_format($totalAll2)."</strong></td>
				  </tr>";
		$html .= "<tr>
					<td colspan=\"6\">&nbsp;</td>
				  </tr>
				  <tr>
					<td colspan=\"6\"><strong>TAMBAHAN PEMASUKAN DARI BANK DROPPING</strong></td>
				  </tr>";
		$i		= 1;
		$tanggal = "";
		$jumlahpertanggal = 0;
		$totalAll3 = 0;
		foreach($DataPemasukanBankDropping as $key => $value){
			if($tanggal != $value['tanggal'] && $tanggal != ""){
				$html .= "<tr>
							<td colspan=\"5\"><strong>Sub Total</strong></td>
							<td align=\"right\"><strong>".number_format($jumlahpertanggal)."</strong></td>
						  </tr>";
				$html .= "<tr>
							<td>".$value['tanggal']."</td>
							<td>".$value['bukti']."</td>
							<td>".$value['kode_subject']."</td>
							<td>".$value['keterangan']."</td>
							<td>".$value['kd_cb']."</td>
							<td align=\"right\">".number_format($value['jumlah'])."</td>
						  </tr>";
				$jumlahpertanggal = $value['jumlah'];
				$tanggal = $value['tanggal'];
				//$jumlahpertanggal = 0;
			}else{
				$html .= "<tr>
							<td>".$value['tanggal']."</td>
							<td>".$value['bukti']."</td>
							<td>".$value['kode_subject']."</td>
							<td>".$value['keterangan']."</td>
							<td>".$value['kd_cb']."</td>
							<td align=\"right\">".number_format($value['jumlah'])."</td>
						  </tr>";
				$jumlahpertanggal += $value['jumlah'];
				$tanggal = $value['tanggal'];
			}
			$totalAll3 += $value['jumlah'];
			$i++;
		}
		$html .= "<tr>
					<td colspan=\"5\"><strong>Sub Total</strong></td>
					<td align=\"right\"><strong>".number_format($jumlahpertanggal)."</strong></td>
				  </tr>
				  <tr>
					<td colspan=\"5\"><strong>Total</strong></td>
					<td align=\"right\"><strong>".number_format($totalAll3)."</strong></td>
				  </tr>
				  <tr>
					<td colspan=\"5\"><strong>Grand Total</strong></td>
					<td align=\"right\"><strong>".number_format($totalAll1 + $totalAll2 - $totalAll3)."</strong></td>
				  </tr>
				</tbody>
			</table>";
		
		$this->load->library('Pdf');
		
		$pdf = new TCPDF("P", PDF_UNIT, 'A4', true, 'UTF-8', false);
		// Add a page
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->AddPage();
		$pdf->writeHTML($html, true, false, true, false, '');
		$pdf->Output('RincianDroppingKasKecil.pdf', 'I');
	}
}

?>