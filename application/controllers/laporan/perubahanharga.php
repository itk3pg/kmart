<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Perubahanharga extends CI_Controller {
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
		$this->load->view('laporan/perubahanharga', $Param);
		$this->load->view('general/footer');
	}
	
	public function getdataperubahanharga(){
		$DataPerubahanHarga = $this->laporan_model->getDataPerubahanHarga($_POST);
		$html = "";
		$nomor = 1;
		foreach ($DataPerubahanHarga as $key => $value) {
			$HargaArr = explode(',', $value['group_harga']);
			$WaktuArr = explode(',', $value['group_waktu']);
			if(sizeof($HargaArr) > 1){
				if($HargaArr[0] != $HargaArr[1]){
					$html .= "<tr>
						<td>".$nomor."</td>
						<td>".$value['barang_kode']."</td>
						<td>".$value['nama_barang']."</td>
						<td>".number_format($HargaArr[0],2)."</td>
						<td>".$WaktuArr[0]."</td>
						<td>".number_format($HargaArr[1],2)."</td>
						<td>".$WaktuArr[1]."</td>
					  </tr>";

					  $nomor++;
				}else if($_POST['barang_kode'] != ""){
					if($HargaArr == ""){
						$hargabaru = $HargaArr[0];
						$hargalama = $HargaArr[1];

						$waktubaru = $WaktuArr[0];
						$waktulama = $WaktuArr[1];
					}else{
						$hargabaru = $value['harga1'];
						$hargalama = $value['harga1'];

						$waktubaru = "";
						$waktulama = "";
					}

					$html .= "<tr>
								<td>".$nomor."</td>
								<td>".$value['barang_kode']."</td>
								<td>".$value['nama_barang']."</td>
								<td>".number_format($hargabaru,2)."</td>
								<td>".$waktubaru."</td>
								<td>".number_format($hargalama,2)."</td>
								<td>".$waktulama."</td>
							  </tr>";

				  	$nomor++;
				}
			}else{
				if($HargaArr == ""){
					$hargabaru = $HargaArr[0];
					$hargalama = $HargaArr[1];

					$waktubaru = $WaktuArr[0];
					$waktulama = $WaktuArr[1];
				}else{
					$hargabaru = $value['harga1'];
					$hargalama = $value['harga1'];

					$waktubaru = "";
					$waktulama = "";
				}

				$html .= "<tr>
							<td>".$nomor."</td>
							<td>".$value['barang_kode']."</td>
							<td>".$value['nama_barang']."</td>
							<td>".number_format($hargabaru,2)."</td>
							<td>".$waktubaru."</td>
							<td>".number_format($hargalama,2)."</td>
							<td>".$waktulama."</td>
						  </tr>";

			  	$nomor++;
			}
		}
		
		echo $html;
	}

	public function cetakpricetag(){
		$this->load->library('Pdf');
		
		$pdf = new TCPDF("P", PDF_UNIT, 'A4', true, 'UTF-8', false);
		// Add a page
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->SetMargins(10, 5, 10, true);
		$pdf->AddPage();

		$DataPerubahanHarga = $this->laporan_model->getDataPerubahanHarga($_GET);

		$html = "<style>
				 	table {
				 		font-size: 9px;
				 	}

					td {
				 		border:1pt solid black;
					}

					.kotak {
				 		border:1pt solid black;
				 		height: 100%;
					}
				 </style>";
		$html .= "<table>";
		$no = 1;
		$JumlahPerBaris = 3;
		$jumlahBaris = 1;
		foreach ($DataPerubahanHarga as $key => $value) {
			$HargaArr = explode(',', $value['group_harga']);
			$WaktuArr = explode(',', $value['group_waktu']);
			if(sizeof($HargaArr) > 1){
				if($HargaArr[0] != $HargaArr[1]){
					if($no == 1){
						$html .= "<tr>";
					}
					$html .= "<td style=\"width: 5.7cm; height: 2.6cm; background-image:url(".base_url()."images/frame_kotak.png); background-repeat:no-repeat; background-size:5.7cm 2.6cm;\" align=\"center\">&nbsp;<br/>".$value['barang_kode']." - ".$value['barcode']."<br/>".substr($value['nama_barang'],0, 27)."<br/><br/><strong style=\"font-size: 15px;\">Rp. ".number_format($HargaArr[0])."</strong><br/><i style=\"font-size: 7px; text-align: right;\">".date("d-m-Y")."</i></td>";
					if($no == $JumlahPerBaris){
						$html .= "</tr><tr><td style=\"height: 0.2cm;\" colspan=\"5\"></td></tr>";
						$no=0;
						$jumlahBaris++;
					}else{
						$html .= "<td style=\"width: 0.2cm;\">&nbsp;</td>";
					}
					$no++;
				}else if($_GET['barang_kode'] != ""){
					if($no == 1){
						$html .= "<tr>";
					}
					$html .= "<td style=\"width: 5.7cm; height: 2.6cm; background-image:url(".base_url()."images/frame_kotak.png); background-repeat:no-repeat; background-size:5.7cm 2.6cm;\" align=\"center\">&nbsp;<br/>".$value['barang_kode']." - ".$value['barcode']."<br/>".substr($value['nama_barang'],0, 27)."<br/><br/><strong style=\"font-size: 15px;\">Rp. ".number_format($value['harga1'])."</strong><br/><i style=\"font-size: 7px; text-align: right;\">".date("d-m-Y")."</i></td>";
					if($no == $JumlahPerBaris){
						$html .= "</tr><tr><td style=\"height: 0.2cm;\" colspan=\"5\"></td></tr>";
						$no=0;
						$jumlahBaris++;
					}else{
						$html .= "<td style=\"width: 0.2cm;\">&nbsp;</td>";
					}
					$no++;
				}
			}else{
				if($no == 1){
					$html .= "<tr>";
				}
				$html .= "<td style=\"width: 5.7cm; height: 2.6cm; background-image:url(".base_url()."images/frame_kotak.png); background-repeat:no-repeat; background-size:5.7cm 2.6cm;\" align=\"center\">&nbsp;<br/>".$value['barang_kode']." - ".$value['barcode']."<br/>".substr($value['nama_barang'],0, 27)."<br/><br/><strong style=\"font-size: 15px;\">Rp. ".number_format($value['harga1'])."</strong><br/><i style=\"font-size: 7px; text-align: right;\">".date("d-m-Y")."</i></td>";
				if($no == $JumlahPerBaris){
					$html .= "</tr><tr><td style=\"height: 0.2cm;\" colspan=\"5\"></td></tr>";
					$no=0;
					$jumlahBaris++;
				}else{
						$html .= "<td style=\"width: 0.2cm;\">&nbsp;</td>";
					}
				$no++;
			}

			if($jumlahBaris % 10 == 0){
				$html .= "</table>";
				$pdf->writeHTML($html, true, false, true, false, '');
				$pdf->AddPage();
				$no=1;
				// echo $html;
				// exit();
				$html = "<style>
				 	table {
				 		font-size: 9px;
				 	}

				 	table.content {
				 		padding: 1px;
				 	}

					td {
				 		border:1pt solid black;
					}
				 </style>";
				$html .= "<table>";
				$jumlahBaris = 1;
			}
		}

		if($no > 1){
			for($i=0;$i<=($JumlahPerBaris-$no);$i++){
				$html .= "<td>&nbsp;</td>";
			}

			if($no <= $JumlahPerBaris){
				$html .= "</tr>";
			}
		}
		
		$html .= "</table>";
		// echo $html;exit();
		$pdf->writeHTML($html, true, false, true, false, '');
		$pdf->Output('perubahanharga.pdf', 'I');
	}
	
	public function cetakperubahanharga(){
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;Filename=rekap_perubahan_harga_".$_GET['toko_kode'].".xls");
		$DataPerubahanHarga = $this->laporan_model->getDataPerubahanHarga($_GET);
		
		$html = "<table>
					<tr>
						<td colspan=\"10\" align=\"center\">DATA PERUBAHAN HARGA</td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"10\">PERIODE : ".$_GET['tanggal']."</td>
					</tr>
				 </table>";
		$html .= "<table border=\"1\" id=\"table-rekap\">
					<thead>
						<tr>
							<th>No</th>
							<th>Kode Barang</th>
							<th>Nama Barang</th>
							<th>Harga Baru</th>
							<th>Waktu</th>
							<th>Harga Lama</th>
							<th>Waktu</th>
						</tr>
					</thead>
					<tbody>";
		foreach ($DataPerubahanHarga as $key => $value) {
			$HargaArr = explode(',', $value['group_harga']);
			$WaktuArr = explode(',', $value['group_waktu']);
			if(sizeof($HargaArr) > 1){
				if($HargaArr[0] != $HargaArr[1]){
					$html .= "<tr>
						<td>".$nomor."</td>
						<td>".$value['barang_kode']."</td>
						<td>".$value['nama_barang']."</td>
						<td>".number_format($HargaArr[0],2)."</td>
						<td>".$WaktuArr[0]."</td>
						<td>".number_format($HargaArr[1],2)."</td>
						<td>".$WaktuArr[1]."</td>
					  </tr>";

					  $nomor++;
				}
			}
		}
		$html .= "</tbody></table>";		 
		echo $html;
	}
}