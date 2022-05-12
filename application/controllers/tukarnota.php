<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tukarnota extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('tukarnota_model');
		$this->load->model('retursupplier_model');
		$this->load->model('pendapatanlain_model');
		$this->load->model('supplier_model');
		$this->load->model('hutang_model');
		$this->load->model('hutangpenyesuaian_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('tukarnota/home');
		$this->load->view('general/footer');
	}
	
	public function getdatatukarnota(){
		$DataTukarNota = $this->tukarnota_model->getDataTukarNota($_POST);
		
		$html = "<table class=\"table table-striped table-bordered table-hover\" id=\"dataTables-tukarnota\">
                    <thead>
                        <tr>
							<th>BUKTI</th>
                       		<th>TANGGAL</th>
							<th>SUPPLIER</th>
                            <th>JUMLAH</th>
							<th>RETUR</th>
							<th>LISTING</th>
							<th>SALDO</th>
							<th>JATUH TEMPO</th>
							<th>STATUS</th>
                        </tr>
                    </thead>
                    <tbody>";
		foreach ($DataTukarNota as $key => $value) {
			$html .= "<tr data=\"".base64_encode(json_encode($value))."\">
						<td>".$value['bukti']."</td>
						<td>".$value['tanggal']."</td>
						<td>".$value['nama_supplier']."</td>
						<td align='right'>".number_format($value['jumlah_hutang'],2)."</td>
						<td align='right'>".number_format($value['jumlah_potong'],2)."</td>
						<td align='right'>".number_format($value['jumlah_listing'],2)."</td>
						<td align='right'>".number_format($value['sisa_hutang'],2)."</td>
						<td>".$value['jatuh_tempo']."</td>
						<td>".($value['status']=='1' ? '<strong>&#x2713;</strong>' : '<strong>-</strong>')."</td>
					  </tr>";
		}
		
		$html .= "</tbody>
				</table>";
		echo $html;
	}
	
	public function simpantukarnota(){
		$dataArr = json_decode(rawurldecode($_POST['data']));
		$dataArrRetur = json_decode(rawurldecode($_POST['dataretur']));
		$dataArrPendapatan = json_decode(rawurldecode($_POST['datapendapatan']));
		$this->tukarnota_model->SimpanTukarNota($_POST);
		
		for($index=0;$index<sizeof($dataArr);$index = $index + 8){
			$pengadaan_bukti = $dataArr[$index];
			$no_faktur = $dataArr[$index+6];
			$bukti_penyesuaian = $dataArr[$index+5];
			$_POST['pengadaan_bukti'] = $pengadaan_bukti;
			$_POST['no_faktur'] = $no_faktur;
			
			$this->tukarnota_model->SimpanDetailTukarNota($_POST);
			// update jatuh tempo piutang
			$ParamPiutang = array();
			$ParamPiutang['jatuh_tempo'] = $_POST['jatuh_tempo'];
			$ParamPiutang['pengadaan_bukti'] = $pengadaan_bukti;
			$ParamPiutang['supplier_kode'] = $_POST['supplier_kode'];
			$ParamPiutang['tukar_nota_bukti'] = $_POST['bukti'];
			
			$this->hutang_model->setStatusTukarNota($ParamPiutang);
			
			$ParamPenyesuaian = array();
			$ParamPenyesuaian['tukar_nota_bukti'] = $_POST['bukti'];
			$ParamPenyesuaian['supplier_kode'] = $_POST['supplier_kode'];
			$ParamPenyesuaian['hutangpenyesuaian_bukti'] = $bukti_penyesuaian;
			$this->hutangpenyesuaian_model->setStatusHutangPenyesuaian($ParamPenyesuaian);
		}
		// update retur
		for($indexretur=0;$indexretur<sizeof($dataArrRetur);$indexretur = $indexretur + 4){
			$retur_bukti = $dataArrRetur[$indexretur];
			$data['retur_bukti'] = $retur_bukti;
			$data['tukar_nota_bukti'] = $_POST['bukti'];
			$data['supplier_kode'] = $_POST['supplier_kode'];
			
			$this->retursupplier_model->setStatusReturSupplier($data);
		}
		// update pendapatan lain
		for($indexpendapatan=0;$indexpendapatan<sizeof($dataArrPendapatan);$indexpendapatan = $indexpendapatan + 5){
			$pendapatanlain_bukti = $dataArrPendapatan[$indexpendapatan];
			$data['pendapatanlain_bukti'] = $pendapatanlain_bukti;
			$data['tukar_nota_bukti'] = $_POST['bukti'];
			$data['supplier_kode'] = $_POST['supplier_kode'];
			
			$this->pendapatanlain_model->setStatusPendapatanLain($data);
		}
	}
	
	public function hapustukarnota(){
		$this->tukarnota_model->HapusTukarNota($_POST);
		$this->tukarnota_model->HapusDetailTukarNota($_POST);
		
		$this->hutang_model->HapusStatusTukarNota($_POST);
		$this->retursupplier_model->HapusStatusReturSupplier($_POST);
		$this->pendapatanlain_model->HapusStatusPendapatanLain($_POST);
	}
	
	public function hapusdetailtukarnota(){
		$this->tukarnota_model->HapusDetailTukarNota($_POST);
		
		$this->hutang_model->HapusStatusTukarNota($_POST);
		$this->retursupplier_model->HapusStatusReturSupplier($_POST);
		$this->pendapatanlain_model->HapusStatusPendapatanLain($_POST);
	}
	
	public function getdatapengadaansupplier(){
		$DataPengadaanSupplier = $this->tukarnota_model->getDataPenerimaanSupplier($_POST);
		
		$html = "";
		foreach ($DataPengadaanSupplier as $key => $value) {
			//$jumlah = $value['jumlah'] - $value['jumlah_pembayaran'];
			$jumlahPenyesuaian = ($value['jumlah_pembayaran'] * -1) + $value['jumlah_penyesuaian'];
			$jumlah = $value['jumlah'] + $jumlahPenyesuaian;
			$html .= "<tr>
						<td>".$value['ref_pengadaan']."</td>
						<td>".$value['tanggal']."</td>
						<td align='right'>".number_format($value['jumlah'],2)."</td>
						<td align='right'>".number_format($jumlahPenyesuaian,2)."</td>
						<td align='right'>".number_format($jumlah,2)."</td>
						<td>".$value['bukti_penyesuaian']."</td>
						<td id=\"nofaktur_".$value['ref_pengadaan']."\"></td>
						<td>
							<button type=\"button\" style=\"padding: 1px 6px;\" onclick=\"OpenFormNoFaktur('".$value['ref_pengadaan']."')\" class=\"btn btn-warning btn-sm\"><i class=\"fa fa-edit\"></i></button>
							<button type=\"button\" style=\"padding: 1px 6px;\" onclick=\"HapusRow(this)\" class=\"btn btn-danger btn-sm\"><i class=\"fa fa-times\"></i></button>
						</td>
					</tr>";
		}
		
		echo $html;
	}
	
	public function getdatapengadaantukarnota(){
		$DataPengadaanSupplier = $this->tukarnota_model->getDataPenerimaanTukarNota($_POST);
		
		$html = "";
		foreach ($DataPengadaanSupplier as $key => $value) {
			$jumlahPenyesuaian = $value['jumlah_penyesuaian'];
			$jumlah = $value['jumlah'] + $jumlahPenyesuaian;
			
			$html .= "<tr>
						<td>".$value['pengadaan_bukti']."</td>
						<td>".$value['tanggal']."</td>
						<td align='right'>".number_format($value['jumlah'],2)."</td>
						<td align='right'>".number_format($jumlahPenyesuaian,2)."</td>
						<td align='right'>".number_format($jumlah,2)."</td>
						<td>".$value['bukti_penyesuaian']."</td>
						<td id=\"nofaktur_".$value['pengadaan_bukti']."\">".$value['no_faktur']."</td>";
			if(isset($_POST['supplier_kode'])){
				$html .= "<td>
							<button type=\"button\" style=\"padding: 1px 6px;\" onclick=\"HapusRow(this)\" class=\"btn btn-danger btn-sm\"><i class=\"fa fa-times\"></i></button>
						</td>";
			}else{
				$html .= "<td></td>";
			}
			$html .= "</tr>";
		}
		
		echo $html;
	}
	
	public function getselecttukarnota(){
		$DataTukarNota = $this->tukarnota_model->getDataSelectTukarNota();
		
		$html = "<option value=\"\">Pilih Bukti</option>";
		foreach ($DataTukarNota as $key => $value) {
			$html .= "<option value=\"".$value['bukti']."\">".$value['bukti']." (".$value['nama_supplier'].")</option>";
		}
		
		echo $html;
	}
	
	public function getjatuhtempo(){
		$DataTOP = $this->supplier_model->getDataTOP($_POST);
		
		$jatuh_tempo = date('Y-m-d', strtotime($DataTOP[0]['top'].' days', strtotime(date('Y-m-d'))));
		echo $jatuh_tempo;
	}
	
	public function cetaktukarnota(){
		$DataTukarNota = $this->tukarnota_model->getLaporanTukarNota($_GET);
		$DataRetur = $this->tukarnota_model->getLaporanRetur($_GET);
		$DataListing = $this->tukarnota_model->getLaporanListing($_GET);
		$JumlahRetur = $this->tukarnota_model->getJumlahRetur($_GET);
		$JumlahPendapatanLain = $this->tukarnota_model->getJumlahPendapatanLain($_GET);
		
		$html = "<style>
				 	table {
				 		font-size: 9px;
				 	}
				 </style>";
		$html .= "<table>
					<tr>
						<td><strong>Koperasi karyawan Keluarga Besar Petrokimia Gresik</strong></td>
						<td align=\"right\">Tukar Faktur (TT)</td>
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
						<td width=\"200\">".$DataTukarNota[0]['supplier_kode']." - ".$DataTukarNota[0]['nama_supplier']."</td>
						<td width=\"70\"></td>
						<td width=\"80\">Tanggal</td>
						<td width=\"30\"> : </td>
						<td width=\"100\">".$DataTukarNota[0]['tanggal']."</td>
					</tr>
					<tr>
						<td width=\"70\">Bank</td>
						<td width=\"30\"> : </td>
						<td width=\"200\">".$DataTukarNota[0]['nama_bank'].";".$DataTukarNota[0]['no_rekening'].";A/N ".$DataTukarNota[0]['atas_nama']."</td>
						<td width=\"70\"></td>
						<td width=\"80\">No Transaksi</td>
						<td width=\"30\"> : </td>
						<td width=\"100\">".$DataTukarNota[0]['bukti']."</td>
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
		$html .= "<table border=\"1\">
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
		$html .= "";
		$html .= "</tbody></table>";
		
		$html .= "<table>
					<tr>
						<td><strong>Data Retur</strong></td>
						<td><strong>Data Listing</strong></td>
					</tr>
					<tr>
						<td>";		
		$html .= "<table border=\"1\">
					<thead>
						<tr>
							<th width=\"20\" height=\"20\">No</th>
							<th width=\"60\">Tanggal</th>
							<th width=\"80\">Bukti</th>
							<th width=\"70\" align=\"right\">Jumlah</th>
						</tr>
					</thead>
					<tbody>";
		$inc = 1;
		foreach($DataRetur as $key => $value){
			$html .= "<tr>
						<td width=\"20\">".$inc."</td>
						<td width=\"60\">".$value['tanggal']."</td>
						<td width=\"80\">".$value['bukti']."</td>
						<td width=\"70\" align=\"right\">".number_format($value['jumlah'],2)."</td>
					  </tr>";
			$inc++;
		}
		
		$html .= "";
		$html .= "</tbody></table></td><td>";
		
		$html .= "<table border=\"1\">
					<thead>
						<tr>
							<th width=\"20\" height=\"20\">No</th>
							<th width=\"60\">Tanggal</th>
							<th width=\"80\">Bukti</th>
							<th width=\"70\" align=\"right\">Jumlah</th>
						</tr>
					</thead>
					<tbody>";
		$inc = 1;
		foreach($DataListing as $key => $value){
			$html .= "<tr>
						<td width=\"20\">".$inc."</td>
						<td width=\"60\">".$value['tanggal']."</td>
						<td width=\"80\">".$value['bukti']."</td>
						<td width=\"70\" align=\"right\">".number_format($value['jumlah'],2)."</td>
					  </tr>";
			$inc++;
		}
		
		$html .= "";
		$html .= "</tbody></table></td></tr></table>";
		
		$html .= "<table>
					<tr>
						<td width=\"70\">Jumlah Hutang</td>
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
						<td width=\"70\">Total Hutang</td>
						<td width=\"30\"> : </td>
						<td width=\"100\" align=\"right\">".number_format($TotalTagihan,2)."</td>
					</tr>
				  </table><br/><br/><br/><br/>";
		$html .= "<table>
					<tr>
						<td align=\"center\">Disetujui Oleh</td>
						<td align=\"center\">Diketahui Oleh</td>
						<td align=\"center\">Diperiksa Oleh</td>
						<td align=\"center\">Diterima Oleh</td>
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
						<td align=\"center\">( Manager Ops MD/DC )</td>
						<td align=\"center\">( .......................... )</td>
						<td align=\"center\">".$this->session->userdata('nama')."</td>
						<td align=\"center\">( Sales / Penagihan )</td>
					</tr>
				  </table>";

		$this->load->library('Pdf');
		
		$pdf = new TCPDF("P", PDF_UNIT, 'A4', true, 'UTF-8', false);
		// Add a page
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->AddPage();
		$pdf->writeHTML($html, true, false, true, false, '');
		$pdf->Output('TukarNota.pdf', 'I');
	}
}