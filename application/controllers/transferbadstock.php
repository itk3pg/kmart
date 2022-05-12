<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transferbadstock extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('transferbadstock_model');
		$this->load->model('orderpembelian_model');
		$this->load->model('syncsaldo_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('transferbadstock/home');
		$this->load->view('general/footer');
	}
	
	public function getdatatransferbadstock(){
		$Databs = $this->transferbadstock_model->getDataTransferBadStock($_POST);
		
		$bukti = "";
		$html = "<table class=\"table table-striped table-bordered table-hover\" id=\"dataTables-transferbs\">
                    <thead>
                        <tr>
							<th>BUKTI</th>
                       		<th>TANGGAL</th>
							<th>KODE BARANG</th>
                            <th>BARANG</th>
							<th>SATUAN</th>
                            <th>KWT</th>
                            <th>HPP</th>
                            <th>JUMLAH</th>
                        </tr>
                    </thead>
                    <tbody>";
		foreach ($Databs as $key => $value) {
			$html .= "<tr data=\"".base64_encode(json_encode($value))."\">";
			if($bukti != $value['bukti']){
				$html .= "<td>".$value['bukti']."</td>
						  <td>".$value['tanggal']."</td>";
				$bukti = $value['bukti'];
			}else{
				$html .= "<td></td>
						  <td></td>";
			}
			$html .= "	<td>".$value['barang_kode']."</td>
						<td>".$value['nama_barang']."</td>
						<td>".$value['satuan']."</td>
						<td align='right'>".$value['kwt']."</td>
						<td align='right'>".$value['hpp']."</td>
						<td align='right'>".$value['jumlah']."</td>
					  </tr>";
		}
		
		$html .= "</tbody>
				</table>";
		echo $html;
	}
	
	public function simpantransferbadstock(){
		if($_POST['kwt'] > 0){
			$this->transferbadstock_model->SimpanTransferBadStock($_POST);
			
			$TglArr = explode('-', $_POST['tanggal']);
			$ParamSync = array();
			$ParamSync['bulan'] = $TglArr[1];
			$ParamSync['tahun'] = $TglArr[0];
			$ParamSync['barang_kode'] = $_POST['barang_kode'];
			$ParamSync['gudang_bs'] = $_POST['gudang_bs'];
			$this->syncsaldo_model->SyncSaldoBarangGudangUtamaSpesifik($ParamSync);
			$this->syncsaldo_model->SyncSaldoBarangBadStockSpesifik($ParamSync);
		}
	}
	
	public function hapustransferbadstock(){
		$this->transferbadstock_model->HapusTransferBadStock($_POST);

		$DataBarangbs = $this->transferbadstock_model->getDataBarangTransferBadStockHapus($_POST);
		foreach ($DataBarangbs as $key => $value) {
			$TglArr = explode('-', $value['tanggal']);
			$ParamSync = array();
			$ParamSync['bulan'] = $TglArr[1];
			$ParamSync['tahun'] = $TglArr[0];
			$ParamSync['barang_kode'] = $value['barang_kode'];
			$ParamSync['gudang_bs'] = $value['toko_kode'];

			$this->syncsaldo_model->SyncSaldoBarangGudangUtamaSpesifik($ParamSync);
			$this->syncsaldo_model->SyncSaldoBarangBadStockSpesifik($ParamSync);
		}
	}
	
	public function getsaldobarangdc(){
		$DataStokDC = $this->orderpembelian_model->getStokDC($_POST);
		
		$saldo_kwt = 0;
		if(sizeof($DataStokDC) > 0){
			$saldo_kwt = $DataStokDC[0]['saldo_akhir_kwt'];
		}
		
		echo $saldo_kwt;
	}
	
	public function getdatabarangtransferbadstock(){
		$DataBarangbs = $this->transferbadstock_model->getDataBarangTransferBadStock($_POST);
		
		$html = "";
		foreach ($DataBarangbs as $key => $value) {
			$html .= "<tr>
						<td>".$value['barang_kode']."</td>
						<td>".$value['nama_barang']."</td>
						<td>".$value['satuan']."</td>
						<td id=\"kwt_".$value['barang_kode']."\" class=\"text-right\">".$value['kwt']."</td>
						<td id=\"hpp_".$value['barang_kode']."\" class=\"text-right\">".$value['hpp']."</td>
						<td id=\"jumlah_".$value['barang_kode']."\" class=\"text-right\">".$value['jumlah']."</td>
						<td class=\"text-center\"><button type=\"button\" style=\"padding: 0px 20px;\" onclick=\"HapusRow(this)\" class=\"btn btn-danger btn-sm\"><i class=\"fa fa-times\"></i></button></td>
					</tr>";
		}
		
		echo $html;
	}
	
	public function cetaktransferbs(){
		$DataBarangot = $this->transferbadstock_model->getDataBarangTransferBadStock($_GET);
		
		$html = "<style>
				 	table {
				 		font-size: 9px;
				 	}
				 </style>";
		$html .= "<table>
					<tr>
						<td><strong>Koperasi karyawan Keluarga Besar Petrokimia Gresik</strong></td>
						<td align=\"right\">Transfer Bad Stock (TB)</td>
					</tr>
					<tr>
						<td>Jl. ..... Petrokimia Gresik</td>
						<td>&nbsp;</td>
					</tr>
				  </table><br/><br/>";
		$Status = "Bad Stock (Retur)";
		if($DataBarangot[0]['toko_kode'] == "VO0010"){
			$Status = "Bad Stock (Non Retur)";
		}
		$html .= "<table>
					<tr>
						<td width=\"70\">Gudang Asal</td>
						<td width=\"30\"> : </td>
						<td width=\"200\">".$Status."</td>
						<td width=\"70\"></td>
						<td width=\"80\">Tanggal</td>
						<td width=\"30\"> : </td>
						<td width=\"100\">".$DataBarangot[0]['tanggal']."</td>
					</tr>
					<tr>
						<td width=\"70\">Gudang Tujuan</td>
						<td width=\"30\"> : </td>
						<td width=\"200\">DC</td>
						<td width=\"70\"></td>
						<td width=\"80\">No Transaksi</td>
						<td width=\"30\"> : </td>
						<td width=\"100\">".$DataBarangot[0]['bukti']."</td>
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
		foreach($DataBarangot as $key => $value){
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
		$html .= "<table>
					<tr>
						<td align=\"center\">Dibuat oleh</td>
						<td align=\"center\">Manager Ops. DC</td>
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
						<td align=\"center\">( ".$this->session->userdata('nama')." )</td>
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
		$pdf->Output('OrderTransfer.pdf', 'I');
	}
}