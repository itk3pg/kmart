<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transfergudangkonsinyasi extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('transfergudangkonsinyasi_model');
		$this->load->model('syncsaldo_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('transfergudangkonsinyasi/home');
		$this->load->view('general/footer');
	}
	
	public function getdatatg(){
		$Datatg = $this->transfergudangkonsinyasi_model->getDataTG($_POST);
		
		$bukti = "";
		$html = "<table class=\"table table-striped table-bordered table-hover\" id=\"dataTables-tg\">
                    <thead>
                        <tr>
							<th>&nbsp;</th>
							<th>Bukti</th>
                       		<th>Tanggal</th>
							<th>Toko</th>
                            <th>Barang</th>
                            <th>Qty</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
							<th>Satuan</th>
                        </tr>
                    </thead>
                    <tbody>";
		foreach ($Datatg as $key => $value) {
			$html .= "<tr data=\"".base64_encode(json_encode($value))."\">";
			if($bukti != $value['bukti']){
				if($value['is_approve'] == "1"){
					$html .= "<td><strong>&#x2713;</strong></td>";
				}else{
					$html .= "<td>-</td>";
				}
				$html .= "<td>".$value['bukti']."</td>
						  <td>".$value['tanggal']."</td>
						  <td>".$value['nama_toko']."</td>";
				$bukti = $value['bukti'];
			}else{
				$html .= "<td></td>
						  <td></td>
						  <td></td>
						  <td></td>";
			}
			$html .= "	<td>".$value['nama_barang']."</td>
						<td align='right'>".$value['kwt']."</td>
						<td align='right'>".number_format($value['harga'], 2)."</td>
						<td align='right'>".number_format($value['jumlah'], 2)."</td>
						<td align='right'>".$value['satuan']."</td>
					  </tr>";
		}
		
		$html .= "</tbody>
				</table>";
		echo $html;
	}
	
	public function listpilihtg(){
		$Datatg = $this->transfergudangkonsinyasi_model->getDataListTG($_POST);
		
		$bukti = "";
		$html = "<table class=\"table table-striped table-bordered table-hover\" id=\"dataTables-tg\">
                    <thead>
                        <tr>
							<th>BUKTI</th>
                       		<th>TANGGAL</th>
							<th>TOKO</th>
							<th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>";
		foreach ($Datatg as $key => $value) {
			$html .= "<tr>
						<td>".$value['bukti']."</td>
						<td>".$value['tanggal']."</td>
						<td>".$value['nama_toko']."</td>
						<td align=\"center\">
							<button id=\"btn_pilih\" class=\"btn btn-info btn-sm\" type=\"button\" onclick=\"PilihOT('".$value['bukti']."')\">
								<i class=\"fa fa-check\"></i>
							</button>
						</td>
					  </tr>";
		}
		
		$html .= "</tbody>
				</table>";
		echo $html;
	}
	
	public function simpantg(){
		$this->transfergudangkonsinyasi_model->SimpanTG($_POST);
		// if($_POST['ref_ot'] != ""){
		// 	$this->transfergudangkonsinyasi_model->setStatusOT($_POST);
		// }
	}
	
	public function hapustg(){
		$this->transfergudangkonsinyasi_model->HapusTG($_POST);
	}
	
	public function getdatabarangtg(){
		$DataBarangtg = $this->transfergudangkonsinyasi_model->getDataBarangTG($_POST);
		
		$html = "";
		foreach ($DataBarangtg as $key => $value) {
			$html .= "<tr>
						<td>".$value['barang_kode']."</td>
						<td>".$value['nama_barang']."</td>
						<td class=\"text-right\" id=\"kwt_".$value['barang_kode']."\">".$value['kwt']."</td>
						<td class=\"text-right\" id=\"harga_".$value['barang_kode']."\">".$value['harga']."</td>
						<td class=\"text-right\" id=\"jumlah_".$value['barang_kode']."\">".$value['jumlah']."</td>
						<td>".$value['satuan']."</td>
						<td class=\"text-center\">
							<button type=\"button\" onclick=\"openFormEditKWT('".$value['barang_kode']."', '".$value['kwt']."')\" class=\"btn btn-warning btn-sm\"><i class=\"fa fa-edit\"></i></button>
							<button type=\"button\" onclick=\"HapusRow(this)\" class=\"btn btn-danger btn-sm\"><i class=\"fa fa-times\"></i></button>
						</td>
					</tr>";
		}
		
		echo $html;
	}
	
	function terimatransfertoko(){
		$this->transfergudangkonsinyasi_model->TerimaTransferToko($_POST);
		
		$dataTransfer = $this->transfergudangkonsinyasi_model->getDataBarangTG($_POST);
		foreach($dataTransfer as $key => $value){
			$TglArr = explode('-', $value['tanggal']);
			$ParamSync = array();
			$ParamSync['bulan'] = $TglArr[1];
			$ParamSync['tahun'] = $TglArr[0];
			$ParamSync['barang_kode'] = $value['barang_kode'];
			$ParamSync['toko_kode'] = $value['toko_kode'];
			$this->syncsaldo_model->SyncSaldoBarangGudangKonsinyasiSpesifik($ParamSync);
			$this->syncsaldo_model->SyncSaldoBarangTokoKonsinyasiSpesifik($ParamSync);
			$ParamSync['toko_kode'] = "VO0001";
			$this->syncsaldo_model->SyncSaldoBarangTokoKonsinyasiSpesifik($ParamSync);
		}
	}
	
	public function cetaktg(){
		$DataBarangtg = $this->transfergudangkonsinyasi_model->getDataBarangTG($_GET);
		
		$html = "<style>
				 	table {
				 		font-size: 9px;
				 	}
				 </style>";
		$html .= "<table>
					<tr>
						<td><strong>Koperasi karyawan Keluarga Besar Petrokimia Gresik</strong></td>
						<td align=\"right\">Transfer Toko Konsinyasi (TN)</td>
					</tr>
					<tr>
						<td>Jl. ..... Petrokimia Gresik</td>
						<td>&nbsp;</td>
					</tr>
				  </table><br/><br/>";
		$Status = "Draft";
		if($DataBarangtg[0]['is_approve'] == "1"){
			$Status = "Approved";
		}
		$html .= "<table>
					<tr>
						<td width=\"70\">Gudang Asal</td>
						<td width=\"30\"> : </td>
						<td width=\"200\">DC</td>
						<td width=\"70\"></td>
						<td width=\"80\">Tanggal</td>
						<td width=\"30\"> : </td>
						<td width=\"100\">".$DataBarangtg[0]['tanggal']."</td>
					</tr>
					<tr>
						<td width=\"70\">Gudang Tujuan</td>
						<td width=\"30\"> : </td>
						<td width=\"200\">".$DataBarangtg[0]['nama_toko']."</td>
						<td width=\"70\"></td>
						<td width=\"80\">No Transaksi</td>
						<td width=\"30\"> : </td>
						<td width=\"100\">".$DataBarangtg[0]['bukti']."</td>
					</tr>
					<tr>
						<td width=\"70\">Uraian</td>
						<td width=\"30\"> : </td>
						<td width=\"200\">Transfer Toko Konsinyasi (TN)</td>
						<td width=\"70\"></td>
						<td width=\"80\">Progress</td>
						<td width=\"30\"> : </td>
						<td width=\"100\">".$Status."</td>
					</tr>
				  </table><br/><br/>";
		$html .= "<table>
					<thead>
						<tr>
							<th width=\"20\">No</th>
							<th width=\"80\">Kode Barang</th>
							<th width=\"200\">Nama Barang</th>
							<th width=\"40\" align=\"right\">Jumlah</th>
							<th width=\"35\">Satuan</th>
							<th width=\"80\" align=\"right\">Catatan</th>
						</tr>
					</thead>
					<tbody>";
		$inc = 1;
		foreach($DataBarangtg as $key => $value){
			$html .= "<tr>
						<td width=\"20\">".$inc."</td>
						<td width=\"80\">".$value['barang_kode']."</td>
						<td width=\"200\">".$value['nama_barang']."</td>
						<td width=\"40\" align=\"right\">".number_format($value['kwt'],2)."</td>
						<td width=\"35\">".$value['satuan']."</td>
						<td width=\"80\" align=\"right\">&nbsp;</td>
					  </tr>";
			$inc++;
		}
		$html .= "</tbody></table><br/><br/><br/><br/>";
		$html .= "<table border=\"1\" width=\"200\">
					<tr>
						<td width=\"100\" align=\"center\">Pengirim</td>
						<td width=\"100\" align=\"center\">Penerima</td>
					</tr>
					<tr>
						<td width=\"100\">&nbsp;<br/></td>
						<td width=\"100\">&nbsp;</td>
					</tr>
				  </table>";

		$this->load->library('Pdf');
		
		$pdf = new TCPDF("P", PDF_UNIT, 'A4', true, 'UTF-8', false);
		// Add a page
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->AddPage();
		$pdf->writeHTML($html, true, false, true, false, '');
		$pdf->Output('TransferToko.pdf', 'I');
	}

	public function cetaktgplain(){
		$DataBarangtg = $this->transfergudangkonsinyasi_model->getDataBarangTG($_GET);
		
		$html = "<style>
				 	table {
				 		font-size: 9px;
				 	}
				 </style>";
		$html .= "<table width=\"100%\">
					<tr>
						<td><strong>Koperasi karyawan Keluarga Besar Petrokimia Gresik</strong></td>
						<td align=\"right\">Transfer Toko (TG)</td>
					</tr>
					<tr>
						<td>Jl. ..... Petrokimia Gresik</td>
						<td>&nbsp;</td>
					</tr>
				  </table><br/><br/>";
		$Status = "Draft";
		if($DataBarangtg[0]['is_approve'] == "1"){
			$Status = "Approved";
		}
		$html .= "<table width=\"100%\">
					<tr>
						<td width=\"70\">Gudang Asal</td>
						<td width=\"30\"> : </td>
						<td width=\"200\">DC</td>
						<td width=\"70\"></td>
						<td width=\"80\">Tanggal</td>
						<td width=\"30\"> : </td>
						<td width=\"100\">".$DataBarangtg[0]['tanggal']."</td>
					</tr>
					<tr>
						<td width=\"70\">Gudang Tujuan</td>
						<td width=\"30\"> : </td>
						<td width=\"200\">".$DataBarangtg[0]['nama_toko']."</td>
						<td width=\"70\"></td>
						<td width=\"80\">No Transaksi</td>
						<td width=\"30\"> : </td>
						<td width=\"100\">".$DataBarangtg[0]['bukti']."</td>
					</tr>
					<tr>
						<td width=\"70\">Uraian</td>
						<td width=\"30\"> : </td>
						<td width=\"200\">Transfer Toko (TG)</td>
						<td width=\"70\"></td>
						<td width=\"80\">Progress</td>
						<td width=\"30\"> : </td>
						<td width=\"100\">".$Status."</td>
					</tr>
				  </table><br/><br/>";
		$html .= "<table width=\"100%\">
					<thead>
						<tr>
							<th width=\"20\">No</th>
							<th width=\"80\">Kode Barang</th>
							<th width=\"200\">Nama Barang</th>
							<th width=\"40\" align=\"right\">Jumlah</th>
							<th width=\"35\">Satuan</th>
							<th width=\"80\" align=\"right\">Catatan</th>
						</tr>
					</thead>
					<tbody>";
		$inc = 1;
		foreach($DataBarangtg as $key => $value){
			$html .= "<tr>
						<td width=\"20\">".$inc."</td>
						<td width=\"80\">".$value['barang_kode']."</td>
						<td width=\"200\">".$value['nama_barang']."</td>
						<td width=\"40\" align=\"right\">".number_format($value['kwt'],2)."</td>
						<td width=\"35\">".$value['satuan']."</td>
						<td width=\"80\" align=\"right\">&nbsp;</td>
					  </tr>";
			$inc++;
		}
		$html .= "</tbody></table><br/><br/><br/><br/>";
		$html .= "<table border=\"1\" width=\"200\">
					<tr>
						<td width=\"100\" align=\"center\">Pengirim</td>
						<td width=\"100\" align=\"center\">Penerima</td>
					</tr>
					<tr>
						<td width=\"100\">&nbsp;<br/></td>
						<td width=\"100\">&nbsp;</td>
					</tr>
				  </table>";
		echo $html;
	}
}