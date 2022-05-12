<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Permintaanpembayaran extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('permintaanpembayaran_model');
		$this->load->model('tukarnota_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('permintaanpembayaran/home');
		$this->load->view('general/footer');
	}
	
	public function getdatapermintaanpembayaran(){
		$DataPermintaanPembayaran = $this->permintaanpembayaran_model->getDataPermintaanPembayaran($_POST);
		
		$Status = "PENGAJUAN";
		$html = "<table class=\"table table-striped table-bordered table-hover\" id=\"dataTables-permintaanpembayaran\">
                    <thead>
                        <tr>
							<th>BUKTI</th>
                       		<th>TANGGAL</th>
							<th>NO REF</th>
                            <th>SUPPLIER</th>
							<th>JUMLAH HUTANG</th>
							<th>JUMLAH RETUR</th>
							<th>JUMLAH LISTING</th>
							<th>SISA HUTANG</th>
							<th>JATUH TEMPO</th>
							<th>STATUS</th>
							<th>WAKTU</th>
                        </tr>
                    </thead>
                    <tbody>";
		foreach ($DataPermintaanPembayaran as $key => $value) {
			$Waktu = $value['waktu_insert'];
			$Status = "PENGAJUAN";
			switch($value['status']){
				case "1" :
					$Waktu = $value['waktu_terima_akuntansi'];
					$Status = "TERIMA AKUNTANSI";
					break;
				case "2" :
					$Waktu = $value['waktu_verifikasi'];
					$Status = "VERIFIKASI";
					break;
				case "3" :
					$Waktu = $value['waktu_ppu'];
					$Status = "PPU";
					break;
				case "4" :
					$Waktu = $value['waktu_transfer'];
					$Status = "TRANSFER";
					break;
			}
			$html .= "<tr data=\"".base64_encode(json_encode($value))."\">
						<td>".$value['bukti']."</td>
						<td>".$value['tanggal']."</td>
						<td>".$value['tukar_nota_bukti']."</td>
						<td>".$value['nama_supplier']."</td>
						<td align='right'>".number_format($value['jumlah_hutang'],2)."</td>
						<td align='right'>".number_format($value['jumlah_potong'],2)."</td>
						<td align='right'>".number_format($value['jumlah_listing'],2)."</td>
						<td align='right'>".number_format($value['sisa_hutang'],2)."</td>
						<td>".$value['jatuh_tempo']."</td>
						<td>".$Status."</td>
						<td>".$Waktu."</td>
					  </tr>";
		}
		
		$html .= "</tbody>
				</table>";
		echo $html;
	}
	
	public function simpanpermintaanpembayaran(){
		$dataArr = json_decode(rawurldecode($_POST['data']));
		for($index=0;$index<sizeof($dataArr);$index = $index + 8){
			$tukar_nota_bukti = $dataArr[$index];
			$_POST['tukar_nota_bukti'] = $tukar_nota_bukti;
			
			$this->permintaanpembayaran_model->SimpanPermintaanPembayaran($_POST);
			$this->tukarnota_model->setStatusTukarNota($tukar_nota_bukti);
		}
	}
	
	public function getdatatukarnota(){
		$dataTukarNota = $this->permintaanpembayaran_model->getDataTukarNota($_POST);
		
		$html = "";
		foreach($dataTukarNota as $key => $value){
			$html .= "<tr>
						<td>".$value['bukti']."</td>
						<td>".$value['tanggal']."</td>
						<td>".$value['nama_supplier']."</td>
						<td align='right'>".number_format($value['jumlah_hutang'],2)."</td>
						<td align='right'>".number_format($value['jumlah_potong'],2)."</td>
						<td align='right'>".number_format($value['jumlah_listing'],2)."</td>
						<td align='right'>".number_format($value['sisa_hutang'],2)."</td>
						<td>
							<button type=\"button\" style=\"padding: 1px 6px;\" onclick=\"HapusRow(this)\" class=\"btn btn-danger btn-sm\"><i class=\"fa fa-times\"></i></button>
						</td>
					 </tr>";
		}
		
		echo $html;
	}

	public function getdetailpermintaanpembayaran(){
		$dataPermintaanPembayaran = $this->permintaanpembayaran_model->getDetailPermintaanPembayaran($_POST);
		
		$html = "<table class=\"table table-striped table-bordered table-hover\">";
		$html .= "<tr>
					<td>Bukti</td>
					<td>".$dataPermintaanPembayaran[0]['bukti']."</td>
				 </tr>
				 <tr>
					<td>Tanggal</td>
					<td>".$dataPermintaanPembayaran[0]['tanggal']."</td>
				 </tr>
				 <tr>
					<td>Supplier</td>
					<td>".$dataPermintaanPembayaran[0]['nama_supplier']."</td>
				 </tr>
				 <tr>
					<td>Jumlah</td>
					<td>".number_format($dataPermintaanPembayaran[0]['sisa_hutang'], 2)."</td>
				 </tr>
				 <tr>
					<td>Terima Akuntansi</td>
					<td>".$dataPermintaanPembayaran[0]['waktu_terima_akuntansi']."</td>
				 </tr>
				 <tr>
					<td>Verifikasi</td>
					<td>".$dataPermintaanPembayaran[0]['waktu_verifikasi']."</td>
				 </tr>
				 <tr>
					<td>PPU</td>
					<td>".$dataPermintaanPembayaran[0]['waktu_ppu']."</td>
				 </tr>
				 <tr>
					<td>Pembayaran</td>
					<td>".$dataPermintaanPembayaran[0]['waktu_transfer']."</td>
				 </tr>";
		$html .= "</table>";
		
		echo $html;
	}
	
	public function hapuspermintaanpembayaran(){
		$this->permintaanpembayaran_model->HapusPermintaanPembayaran($_POST);
	}
	
	public function setstatus(){
		$this->permintaanpembayaran_model->setStatusPermintaanPembayaran($_POST);
	}
	
	public function simpanrealisasi(){
		$this->permintaanpembayaran_model->SimpanRealisasi($_POST);
	}
	
	public function getrekappermintaanpembayaran(){
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;Filename=rekap_faktur_bi_".$_GET['tanggal_awal'].".xls");
		
		$DataPermintaanPembayaran = $this->permintaanpembayaran_model->getRekapPermintaanPembayaran($_GET);
		
		$html = "<table>
					<tr>
						<td colspan=\"6\" align=\"center\">Rekap Setor BI dan Faktur Pajak</td>
					</tr>
					<tr>
						<td colspan=\"6\" align=\"center\">".$_GET['tanggal_awal']." / ".$_GET['tanggal_akhir']."</td>
					</tr>
					<tr>
						<td colspan=\"6\" align=\"center\"></td>
					</tr>
				 </table>";
		$html .= "<table border=\"1\">
                    <thead>
                        <tr>
                       		<th>No</th>
							<th>Nama Supplir</th>
							<th>Bukti</th>
                            <th>Jumlah</th>
                            <th>No Seri Pajak</th>
                            <th>Jumlah PPN</th>
                            <th>Bukti TT</th>
                            <th>Bukti PB</th>
                        </tr>
                    </thead>
                    <tbody>";
		$urut = 1;
		foreach ($DataPermintaanPembayaran as $key => $value) {
			$html .= "<tr>
						<td>".$urut."</td>
						<td>".$value['nama_supplier']."</td>
						<td>".$value['ref_pengadaan']."</td>
						<td align=\"right\">".$value['jumlah']."</td>
						<td>".$value['no_faktur']."</td>
						<td align=\"right\">".$value['ppn']."</td>
						<td>".$value['bukti_tt']."</td>
						<td>".$value['bukti_pb']."</td>
					  </tr>";
			$urut++;
		}

		$html .= "</tbody></table>";
		
		echo $html;
	}
	
	public function cetakpermintaanpembayaran(){
		$dataArr = json_decode(base64_decode($_GET['data']), true);
		$dataParam = array();
		$dataParam['bukti'] = $dataArr['tukar_nota_bukti'];
		$DataTukarNota = $this->tukarnota_model->getLaporanTukarNota($dataParam);
		$JumlahRetur = $this->tukarnota_model->getJumlahRetur($dataParam);
		$JumlahPendapatanLain = $this->tukarnota_model->getJumlahPendapatanLain($dataParam);
		
		$html = "<style>
				 	table {
				 		font-size: 9px;
				 	}
				 </style>";
		$html .= "<table>
					<tr>
						<td><strong>Koperasi karyawan Keluarga Besar Petrokimia Gresik</strong></td>
						<td align=\"right\">Rencana Pembayaran Hutang (PB)</td>
					</tr>
					<tr>
						<td>Jl. ..... Petrokimia Gresik</td>
						<td>&nbsp;</td>
					</tr>
				  </table><br/><br/>";
		$html .= "<table>
					<tr>
						<td width=\"70\">Supplier</td>
						<td width=\"30\"> : </td>
						<td width=\"200\">".$dataArr['supplier_kode']." - ".$dataArr['nama_supplier']."</td>
						<td width=\"70\"></td>
						<td width=\"80\">Tanggal</td>
						<td width=\"30\"> : </td>
						<td width=\"100\">".$dataArr['tanggal']."</td>
					</tr>
					<tr>
						<td width=\"70\">Bank</td>
						<td width=\"30\"> : </td>
						<td width=\"200\">".$DataTukarNota[0]['nama_bank'].";".$DataTukarNota[0]['no_rekening'].";A/N ".$DataTukarNota[0]['atas_nama']."</td>
						<td width=\"70\"></td>
						<td width=\"80\">No Transaksi</td>
						<td width=\"30\"> : </td>
						<td width=\"100\">".$dataArr['bukti']."</td>
					</tr>
					<tr>
						<td width=\"70\"></td>
						<td width=\"30\"></td>
						<td width=\"200\"></td>
						<td width=\"70\"></td>
						<td width=\"80\">Jatuh Tempo</td>
						<td width=\"30\"> : </td>
						<td width=\"100\">".$DataTukarNota[0]['jatuh_tempo']."</td>
					</tr>
				  </table><br/><br/>";
		$html .= "<table>
					<thead>
						<tr>
							<th width=\"20\" height=\"20\">No</th>
							<th width=\"60\">Tanggal</th>
							<th width=\"80\">Bukti</th>
							<th width=\"100\">Faktur</th>
							<th width=\"70\" align=\"right\">Jumlah</th>
							<th width=\"70\" align=\"right\">Penyesuaian</th>
							<th width=\"70\" align=\"right\">Total</th>
							<th width=\"80\" align=\"left\">No Penyesuaian</th>
						</tr>
					</thead>
					<tbody>";
		$inc = 1;
		$Jumlah = 0;
		foreach($DataTukarNota as $key => $value){
			$JumlahPenyesuaian = ($value['jumlah_pembayaran'] * -1) + $value['jumlah_penyesuaian'];
			$jumlahHutang = $value['jumlah'] + $JumlahPenyesuaian;
			$html .= "<tr>
						<td width=\"20\">".$inc."</td>
						<td width=\"60\">".$value['tanggal_pengadaan']."</td>
						<td width=\"80\">".$value['pengadaan_bukti']."</td>
						<td width=\"100\">".$value['no_faktur']."</td>
						<td width=\"70\" align=\"right\">".number_format($value['jumlah'],2)."</td>
						<td width=\"70\" align=\"right\">".number_format($JumlahPenyesuaian,2)."</td>
						<td width=\"70\" align=\"right\">".number_format($jumlahHutang,2)."</td>
						<td width=\"80\">".$value['bukti_penyesuaian']."</td>
					  </tr>";
			$inc++;
			$Jumlah += $jumlahHutang;
		}
		
		$TotalTagihan = $Jumlah - ($DataTukarNota[0]['jumlah_potong'] + $DataTukarNota[0]['jumlah_listing']);
		$html .= "<tr>
					<td colspan=\"6\">&nbsp;</td>
					<td align=\"right\">&nbsp;</td>
				  </tr>";
		$html .= "</tbody></table>";
		$html .= "<table>
					<tr>
						<td width=\"70\">Total</td>
						<td width=\"30\"> : </td>
						<td width=\"100\" align=\"right\">".number_format($Jumlah,2)."</td>
					</tr>
					<tr>
						<td width=\"70\">Retur</td>
						<td width=\"30\"> : </td>
						<td width=\"100\" align=\"right\">".number_format($DataTukarNota[0]['jumlah_potong'],2)."</td>
					</tr>
					<tr>
						<td width=\"70\">Listing</td>
						<td width=\"30\"> : </td>
						<td width=\"100\" align=\"right\">".number_format($DataTukarNota[0]['jumlah_listing'],2)."</td>
					</tr>
					<tr>
						<td width=\"70\">Total Transaksi</td>
						<td width=\"30\"> : </td>
						<td width=\"100\" align=\"right\">".number_format($TotalTagihan,2)."</td>
					</tr>
				  </table><br/><br/><br/><br/>";
		$html .= "<table>
					<tr>
						<td align=\"center\">Adm MD</td>
						<td align=\"center\">Manager Operasional MD/DC</td>
						<td align=\"center\">Manager Retail</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td align=\"center\">( ".$this->session->userdata('nama')." )</td>
						<td align=\"center\">( ..................................... )</td>
						<td align=\"center\">( ..................................... )</td>
					</tr>
				  </table>";

		$this->load->library('Pdf');
		
		$pdf = new TCPDF("P", PDF_UNIT, 'A4', true, 'UTF-8', false);
		// Add a page
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->AddPage();
		$pdf->writeHTML($html, true, false, true, false, '');
		$pdf->Output('PermintaanPembayaran.pdf', 'I');
	}
	
	public function cetakppu(){
		$dataArr = json_decode(base64_decode($_GET['data']), true);
		$dataParam = array();
		$dataParam['bukti'] = $dataArr['tukar_nota_bukti'];
		$DataTukarNota = $this->tukarnota_model->getLaporanTukarNota($dataParam);
		
		$html = "<style>
				 	table {
				 		font-size: 9px;
				 	}
				 </style>";
		$html .= "<table>
					<tr>
						<td><strong>Koperasi karyawan Keluarga Besar Petrokimia Gresik</strong></td>
						<td align=\"right\">Rencana Pembayaran Hutang (PB)</td>
					</tr>
					<tr>
						<td>Jl. ..... Petrokimia Gresik</td>
						<td>&nbsp;</td>
					</tr>
				  </table><br/><br/>";
		$html .= "<table>
					<tr>
						<td width=\"70\">Supplier</td>
						<td width=\"30\"> : </td>
						<td width=\"200\">".$dataArr['supplier_kode']." - ".$dataArr['nama_supplier']."</td>
						<td width=\"70\"></td>
						<td width=\"80\">Tanggal</td>
						<td width=\"30\"> : </td>
						<td width=\"100\">".$dataArr['tanggal']."</td>
					</tr>
					<tr>
						<td width=\"70\">Bank</td>
						<td width=\"30\"> : </td>
						<td width=\"200\">".$DataTukarNota[0]['nama_bank'].";".$DataTukarNota[0]['no_rekening'].";A/N ".$DataTukarNota[0]['atas_nama']."</td>
						<td width=\"70\"></td>
						<td width=\"80\">No Transaksi</td>
						<td width=\"30\"> : </td>
						<td width=\"100\">".$dataArr['bukti']."</td>
					</tr>
					<tr>
						<td width=\"70\"></td>
						<td width=\"30\"></td>
						<td width=\"200\"></td>
						<td width=\"70\"></td>
						<td width=\"80\">Jatuh Tempo</td>
						<td width=\"30\"> : </td>
						<td width=\"100\">".$DataTukarNota[0]['jatuh_tempo']."</td>
					</tr>
				  </table><br/><br/>";
		$html .= "<table>
					<thead>
						<tr>
							<th width=\"20\" height=\"20\">No</th>
							<th width=\"60\">Tanggal</th>
							<th width=\"80\">Bukti</th>
							<th width=\"100\">Faktur</th>
							<th width=\"70\" align=\"right\">Jumlah</th>
							<th width=\"70\" align=\"right\">Penyesuaian</th>
							<th width=\"70\" align=\"right\">Total</th>
							<th width=\"80\" align=\"left\">No Penyesuaian</th>
						</tr>
					</thead>
					<tbody>";
		$inc = 1;
		$Jumlah = 0;
		foreach($DataTukarNota as $key => $value){
			$JumlahPenyesuaian = ($value['jumlah_pembayaran'] * -1) + $value['jumlah_penyesuaian'];
			$jumlahHutang = $value['jumlah'] + $JumlahPenyesuaian;
			$html .= "<tr>
						<td width=\"20\">".$inc."</td>
						<td width=\"60\">".$value['tanggal_pengadaan']."</td>
						<td width=\"80\">".$value['pengadaan_bukti']."</td>
						<td width=\"100\">".$value['no_faktur']."</td>
						<td width=\"70\" align=\"right\">".number_format($value['jumlah'],2)."</td>
						<td width=\"70\" align=\"right\">".number_format($JumlahPenyesuaian,2)."</td>
						<td width=\"70\" align=\"right\">".number_format($jumlahHutang,2)."</td>
						<td width=\"80\">".$value['bukti_penyesuaian']."</td>
					  </tr>";
			$inc++;
			$Jumlah += $jumlahHutang;
		}
		
		$TotalTagihan = $Jumlah - ($DataTukarNota[0]['jumlah_potong'] + $DataTukarNota[0]['jumlah_listing']);
		$html .= "<tr>
					<td colspan=\"6\">&nbsp;</td>
					<td align=\"right\">&nbsp;</td>
				  </tr>";
		$html .= "</tbody></table>";
		$html .= "<table>
					<tr>
						<td width=\"70\">Total</td>
						<td width=\"30\"> : </td>
						<td width=\"100\" align=\"right\">".number_format($Jumlah,2)."</td>
					</tr>
					<tr>
						<td width=\"70\">Retur</td>
						<td width=\"30\"> : </td>
						<td width=\"100\" align=\"right\">".number_format($DataTukarNota[0]['jumlah_potong'],2)."</td>
					</tr>
					<tr>
						<td width=\"70\">Listing</td>
						<td width=\"30\"> : </td>
						<td width=\"100\" align=\"right\">".number_format($DataTukarNota[0]['jumlah_listing'],2)."</td>
					</tr>
					<tr>
						<td width=\"70\">Total Transaksi</td>
						<td width=\"30\"> : </td>
						<td width=\"100\" align=\"right\">".number_format($TotalTagihan,2)."</td>
					</tr>
				  </table><br/><br/><br/><br/>";
		$html .= "<table border=\"1\">
					<tr>
						<td align=\"center\" colspan=\"2\">Menyetujui Pengurus,</td>
						<td align=\"center\">Manager Keuangan</td>
						<td align=\"center\">Manager Akuntansi</td>
					</tr>
					<tr>
						<td height=\"70;\" align=\"center\"><br/><br/><br/><br/><br/><br/>( ........................ )</td>
						<td align=\"center\"><br/><br/><br/><br/><br/><br/>( ........................ )</td>
						<td align=\"center\"><br/><br/><br/><br/><br/><br/>( ........................ )</td>
						<td align=\"center\"><br/><br/><br/><br/><br/><br/>( ........................ )</td>
					</tr>
				  </table>";
		
		$this->load->library('Pdf');
		
		$pdf = new TCPDF("P", PDF_UNIT, 'A4', true, 'UTF-8', false);
		// Add a page
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->AddPage();
		$pdf->writeHTML($html, true, false, true, false, '');
		$pdf->Output('PermintaanPembayaran.pdf', 'I');
	}
	
	public function cetakrealisasi(){
		$dataArr = json_decode(base64_decode($_GET['data']), true);
		$dataParam = array();
		$dataParam['bukti'] = $dataArr['tukar_nota_bukti'];
		$DataTukarNota = $this->tukarnota_model->getLaporanTukarNota($dataParam);
		$DataPermintaanPembayaran = $this->permintaanpembayaran_model->getDataPermintaanPembayaranLaporan($dataArr);
		
		$html = "<style>
				 	table {
				 		font-size: 9px;
				 	}
				 </style>";
		$html .= "<table>
					<tr>
						<td><strong>Koperasi karyawan Keluarga Besar Petrokimia Gresik</strong></td>
						<td align=\"right\">Rencana Pembayaran Hutang (PB)</td>
					</tr>
					<tr>
						<td>Jl. ..... Petrokimia Gresik</td>
						<td>&nbsp;</td>
					</tr>
				  </table><br/><br/>";
		$html .= "<table>
					<tr>
						<td width=\"70\">Supplier</td>
						<td width=\"30\"> : </td>
						<td width=\"200\">".$dataArr['supplier_kode']." - ".$dataArr['nama_supplier']."</td>
						<td width=\"70\"></td>
						<td width=\"80\">Tanggal</td>
						<td width=\"30\"> : </td>
						<td width=\"100\">".$dataArr['tanggal']."</td>
					</tr>
					<tr>
						<td width=\"70\">Bank</td>
						<td width=\"30\"> : </td>
						<td width=\"200\">".$DataTukarNota[0]['nama_bank'].";".$DataTukarNota[0]['no_rekening'].";A/N ".$DataTukarNota[0]['atas_nama']."</td>
						<td width=\"70\"></td>
						<td width=\"80\">No Transaksi</td>
						<td width=\"30\"> : </td>
						<td width=\"100\">".$dataArr['bukti']."</td>
					</tr>
					<tr>
						<td width=\"70\"></td>
						<td width=\"30\"></td>
						<td width=\"200\"></td>
						<td width=\"70\"></td>
						<td width=\"80\">Jatuh Tempo</td>
						<td width=\"30\"> : </td>
						<td width=\"100\">".$DataTukarNota[0]['jatuh_tempo']."</td>
					</tr>
				  </table><br/><br/>";
		$html .= "<table>
					<thead>
						<tr>
							<th width=\"20\" height=\"20\">No</th>
							<th width=\"60\">Tanggal</th>
							<th width=\"80\">Bukti</th>
							<th width=\"100\">Faktur</th>
							<th width=\"70\" align=\"right\">Jumlah</th>
							<th width=\"70\" align=\"right\">Penyesuaian</th>
							<th width=\"70\" align=\"right\">Total</th>
							<th width=\"80\" align=\"left\">No Penyesuaian</th>
						</tr>
					</thead>
					<tbody>";
		$inc = 1;
		$Jumlah = 0;
		foreach($DataTukarNota as $key => $value){
			$JumlahPenyesuaian = ($value['jumlah_pembayaran'] * -1) + $value['jumlah_penyesuaian'];
			$jumlahHutang = $value['jumlah'] + $JumlahPenyesuaian;
			$html .= "<tr>
						<td width=\"20\">".$inc."</td>
						<td width=\"60\">".$value['tanggal_pengadaan']."</td>
						<td width=\"80\">".$value['pengadaan_bukti']."</td>
						<td width=\"100\">".$value['no_faktur']."</td>
						<td width=\"70\" align=\"right\">".number_format($value['jumlah'],2)."</td>
						<td width=\"70\" align=\"right\">".number_format($JumlahPenyesuaian,2)."</td>
						<td width=\"70\" align=\"right\">".number_format($jumlahHutang,2)."</td>
						<td width=\"80\">".$value['bukti_penyesuaian']."</td>
					  </tr>";
			$inc++;
			$Jumlah += $jumlahHutang;
		}
		
		$TotalTagihan = $Jumlah - ($DataTukarNota[0]['jumlah_potong'] + $DataTukarNota[0]['jumlah_listing']);
		$html .= "<tr>
					<td colspan=\"6\">&nbsp;</td>
					<td align=\"right\">&nbsp;</td>
				  </tr>";
		$html .= "</tbody></table>";
		$html .= "<table>
					<tr>
						<td width=\"70\">Total</td>
						<td width=\"30\"> : </td>
						<td width=\"100\" align=\"right\">".number_format($Jumlah,2)."</td>
						<td width=\"30\">&nbsp;</td>
						<td width=\"70\">Cara Bayar</td>
						<td width=\"30\"> : </td>
						<td width=\"100\">".$DataPermintaanPembayaran[0]['realisasi_melalui']."</td>
					</tr>
					<tr>
						<td width=\"70\">Retur</td>
						<td width=\"30\"> : </td>
						<td width=\"100\" align=\"right\">".number_format($DataTukarNota[0]['jumlah_potong'],2)."</td>
						<td width=\"30\">&nbsp;</td>
						<td width=\"70\">Nomor Cek</td>
						<td width=\"30\"> : </td>
						<td width=\"100\">".$DataPermintaanPembayaran[0]['nomor_cek']."</td>
					</tr>
					<tr>
						<td width=\"70\">Listing</td>
						<td width=\"30\"> : </td>
						<td width=\"100\" align=\"right\">".number_format($DataTukarNota[0]['jumlah_listing'],2)."</td>
						<td width=\"30\">&nbsp;</td>
						<td width=\"70\">Nama Bank</td>
						<td width=\"30\"> : </td>
						<td width=\"100\">".$DataPermintaanPembayaran[0]['realisasi_bank']."</td>
					</tr>
					<tr>
						<td width=\"70\">Total Tagihan</td>
						<td width=\"30\"> : </td>
						<td width=\"100\" align=\"right\">".number_format($TotalTagihan,2)."</td>
						<td width=\"30\">&nbsp;</td>
						<td width=\"70\">Tgl Transfer</td>
						<td width=\"30\"> : </td>
						<td width=\"100\">".$DataPermintaanPembayaran[0]['waktu_transfer']."</td>
					</tr>
				  </table><br/><br/><br/><br/>";
		/*$html .= "<table>
					<tr>
						<td align=\"center\">Bendahara Pengurus</td>
						<td align=\"center\">Manager Keuangan</td>
						<td align=\"center\">Manager Akuntansi</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td align=\"center\">( Nur Widjajanti, SE. )</td>
						<td align=\"center\">( Whiwhin Setiawan )</td>
						<td align=\"center\">( Yudi Trisno, SE. )</td>
					</tr>
				  </table>";*/

		$this->load->library('Pdf');
		
		$pdf = new TCPDF("P", PDF_UNIT, 'A4', true, 'UTF-8', false);
		// Add a page
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->AddPage();
		$pdf->writeHTML($html, true, false, true, false, '');
		$pdf->Output('PermintaanPembayaran.pdf', 'I');
	}
	
	public function getrekapharian(){
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;Filename=rekap_harian_".$_GET['tanggal_awal'].".xls");
		$DataPembayaranHutang = $this->permintaanpembayaran_model->getDataRekapHarian($_GET);
		$inc = 1;
		$html = "<table>
					<thead>
						<tr>
							<th>Tanggal Bayar</th>
							<th>bukti</th>
							<th>Kode Supplier</th>
							<th>Nama Supplier</th>
							<th>Jumlah Hutang</th>
							<th>Jumlah Potong</th>
							<th>Jumlah Listing</th>
							<th>Total Bayar</th>
							<th>Pembayaran Melalui</th>
							<th>Nama Bank</th>
						</tr>
					</thead>
					<tbody>";
		foreach($DataPembayaranHutang as $key => $value){
			$html .= "<tr>
						<td>".$value['tanggal']."</td>
						<td>".$value['bukti']."</td>
						<td>".$value['supplier_kode']."</td>
						<td>".$value['nama_supplier']."</td>
						<td>".$value['jumlah_hutang']."</td>
						<td>".$value['jumlah_potong']."</td>
						<td>".$value['jumlah_listing']."</td>
						<td>".$value['total_bayar']."</td>
						<td>".$value['realisasi_melalui']."</td>
						<td>".$value['nama_bank']."</td>
					  </tr>";
		}
		$html .= "</tbody></table>";
		
		echo $html;
	}

	public function cetakdatapermintaanpembayaran(){
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;Filename=permintaan_pembayaran_".$_GET['tanggal_awal'].".xls");
		$DataPermintaanPembayaran = $this->permintaanpembayaran_model->getDataPermintaanPembayaran($_GET);
		
		$Status = "PENGAJUAN";
		$html = "<table border=\"1\">
                    <thead>
                        <tr>
							<th>BUKTI</th>
                       		<th>TANGGAL</th>
							<th>NO REF</th>
                            <th>SUPPLIER</th>
							<th>JUMLAH HUTANG</th>
							<th>JUMLAH RETUR</th>
							<th>JUMLAH LISTING</th>
							<th>SISA HUTANG</th>
							<th>JATUH TEMPO</th>
							<th>STATUS</th>
							<th>WAKTU</th>
                        </tr>
                    </thead>
                    <tbody>";
		foreach ($DataPermintaanPembayaran as $key => $value) {
			$Waktu = $value['waktu_insert'];
			$Status = "PENGAJUAN";
			switch($value['status']){
				case "1" :
					$Waktu = $value['waktu_terima_akuntansi'];
					$Status = "TERIMA AKUNTANSI";
					break;
				case "2" :
					$Waktu = $value['waktu_verifikasi'];
					$Status = "VERIFIKASI";
					break;
				case "3" :
					$Waktu = $value['waktu_ppu'];
					$Status = "PPU";
					break;
				case "4" :
					$Waktu = $value['waktu_transfer'];
					$Status = "TRANSFER";
					break;
			}
			$html .= "<tr>
						<td>".$value['bukti']."</td>
						<td>".$value['tanggal']."</td>
						<td>".$value['tukar_nota_bukti']."</td>
						<td>".$value['nama_supplier']."</td>
						<td align='right'>".$value['jumlah_hutang']."</td>
						<td align='right'>".$value['jumlah_potong']."</td>
						<td align='right'>".$value['jumlah_listing']."</td>
						<td align='right'>".$value['sisa_hutang']."</td>
						<td>".$value['jatuh_tempo']."</td>
						<td>".$Status."</td>
						<td>".$Waktu."</td>
					  </tr>";
		}
		
		$html .= "</tbody>
				</table>";
		echo $html;
	}
}

?>