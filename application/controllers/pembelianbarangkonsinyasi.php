<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pembelianbarangkonsinyasi extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('pembelianbarangkonsinyasi_model');
		$this->load->model('syncsaldo_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('pembelianbarangkonsinyasi/home');
		$this->load->view('general/footer');
	}
	
	public function getdatapembelianbarang(){
		$DataPembelianBarang = $this->pembelianbarangkonsinyasi_model->getDataPembelianBarang($_POST);
		
		$bukti = "";
		$html = "<table class=\"table table-striped table-bordered table-hover\" id=\"dataTables-pembelian-barang\">
                    <thead>
                        <tr>
							<th>Bukti</th>
                       		<th>Tanggal</th>
							<th>Supplier</th>
							<th>Kd Barang</th>
                            <th>Barang</th>
                            <th>Qty</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Fee</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>";
        $JumlahPerBukti = 0;
        $FeePerBukti = 0;
        $TotalPerBukti = 0;
		foreach ($DataPembelianBarang as $key => $value) {
			$jumlah = ($value['harga'] + $value['ppn']) * $value['kwt'];
			$fee = $jumlah * ($value['fee_konsinyasi']/100);

			if($bukti != $value['bukti']){
				if($bukti != ""){
					$html .= "<tr>
								<td colspan=\"7\"><strong>Sub Total</strong></td>
								<td align=\"right\"><strong>".number_format($JumlahPerBukti,2)."</strong></td>
								<td align=\"right\"><strong>".number_format($FeePerBukti,2)."</strong></td>
								<td align=\"right\"><strong>".number_format($TotalPerBukti,2)."</strong></td>
							  </tr>";
				}
				$html .= "<tr data=\"".base64_encode(json_encode($value))."\">";
				$html .= "<td>".$value['bukti']."</td>
						  <td>".$value['tanggal']."</td>
						  <td>".$value['nama_supplier']."</td>";
				$bukti = $value['bukti'];
				$JumlahPerBukti = 0;
		        $FeePerBukti = 0;
		        $TotalPerBukti = 0;
			}else{
				$html .= "<tr>";
				$html .= "<td></td>
						  <td></td>
						  <td></td>";
			}
			$html .= "	<td>".$value['barang_kode']."</td>
						<td>".$value['nama_barang']."</td>
						<td align='right'>".$value['kwt']."</td>
						<td align=\"right\">".number_format(($value['harga'] + $value['ppn']),2)."</td>
						<td align=\"right\">".number_format($jumlah,2)."</td>
						<td align=\"right\">".number_format($fee,2)."</td>
						<td align=\"right\">".number_format(($jumlah - $fee),2)."</td>
					  </tr>";

			$JumlahPerBukti += $jumlah;
	        $FeePerBukti += $fee;
	        $TotalPerBukti += ($jumlah - $fee);
		}
		$html .= "<tr>
					<td colspan=\"7\"><strong>Sub Total</strong></td>
					<td align=\"right\"><strong>".number_format($JumlahPerBukti,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($FeePerBukti,2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalPerBukti,2)."</strong></td>
				  </tr>";
		$html .= "</tbody></table>";
		
		echo $html;
	}
	
	public function getbuktiuangmuka(){
		$DataBuktiUM = $this->pembelianbarangkonsinyasi_model->getBuktiUangMuka($_POST);
		
		$html = "<option value=\"-1\">Cari Bukti</option>";
		foreach ($DataBuktiUM as $key => $value) {
			$html .= "<option value=\"".$value['bukti']."-".$value['jumlah']."\">".$value['bukti']."</option>";
		}
		
		echo $html;
	}
	
	function removeCurrency($currency){
		$b = str_replace(".","",$currency);;
		$b = str_replace(',', '.', $b);
		
		return $b;
	}
	
	public function simpanpembelianbarang(){
		$this->load->model('hutang_model');
		$this->load->model('kasbank_model');
		$this->load->model('orderpembelian_model');
		
		$dataArr = json_decode(rawurldecode($_POST['data']));
		$_POST['supplier_kode'] = base64_decode($_POST['supplier_kode']);
		//$index = 0;
		for($index=0;$index<sizeof($dataArr);$index = $index + 11){
			$barang_kode = $dataArr[$index];
			$kwt_op = $dataArr[$index+3];
			$retur = $dataArr[$index+5];
			$harga_asli = $dataArr[$index+6];
			$diskon = $dataArr[$index+7];
			$nilaidiskon = $harga_asli * ($diskon / 100);
			$harga_beli = $harga_asli - $nilaidiskon;
			
			$ppn_beli = $dataArr[$index+8];
			$total = str_replace(',', '', $dataArr[$index+9]);;
			
			$_POST['barang_kode'] = $barang_kode;
			$_POST['retur'] = $retur;
			$_POST['kwt_op'] = $kwt_op;
			$_POST['kwt'] = $_POST['kwt_op'] - $_POST['retur'];
			$_POST['harga'] = $harga_beli;
			$_POST['diskon1'] = $diskon;
			$_POST['harga_asli'] = $harga_asli;
			$_POST['ppn'] = $ppn_beli;
			$_POST['jumlah'] = $total;
			$_POST['index'] = $index;
			
			$this->pembelianbarangkonsinyasi_model->SimpanPembelianBarang($_POST);
			
			// if($_POST['is_bkl'] == "0"){
				$TglArr = explode('-', $_POST['tanggal']);
				$ParamSync = array();
				$ParamSync['bulan'] = $TglArr[1];
				$ParamSync['tahun'] = $TglArr[0];
				$ParamSync['barang_kode'] = $barang_kode;
				//$this->syncsaldo_model->SyncSaldoBarangSpesifik($ParamSync);
				$this->syncsaldo_model->SyncSaldoBarangGudangKonsinyasiSpesifik($ParamSync);
			// }
		}
		// $this->simpantransferketoko($_POST);
		// if($_POST['ref_op'] != ""){
		// 	$this->orderpembelian_model->setStatusOP($_POST['ref_op']);
		// }
		$DataPembelian = $this->pembelianbarangkonsinyasi_model->checkData($_POST['bukti']);
		//print_r($DataPembelian);
		if(sizeof($DataPembelian) > 0){
			$this->hutang_model->HapusHutang($_POST);
			
			$ParamKasbank = array();
			$ParamKasbank['kd_kb'] = "110";
			$ParamKasbank['unit_kode'] = 'VO0008';
			$ParamKasbank['bukti'] = $_POST['bukti'];
			$ParamKasbank['tanggal'] = $_POST['tanggal'];
			// $this->kasbank_model->HapusKasbank($ParamKasbank);
			
			if($_POST['status_pembayaran'] == "K"){ // kredit
				// insert hutang
				if($DataPembelian[0]['jumlah'] > 0){
					if($_POST['jatuh_tempo'] == ""){
						$_POST['jatuh_tempo'] = $_POST['tanggal'];
					}
					$DataPembelian[0]['jatuh_tempo'] = $_POST['jatuh_tempo'];
					$this->hutang_model->SimpanHutang($DataPembelian[0]);
				}
			}else{ // tunai
				// insert kasbank pembelian tunai
				$ParamKasbank = array();
				$ParamKasbank['mode_form'] = "i";
				$ParamKasbank['mode'] = "KK";
				$ParamKasbank['kd_kb'] = "110";
				$ParamKasbank['kd_cb'] = "2012"; // 202
				$ParamKasbank['tanggal'] = $DataPembelian[0]['tanggal'];
				$ParamKasbank['kd_subject'] = $DataPembelian[0]['supplier_kode'];
				$ParamKasbank['nama_subject'] = $DataPembelian[0]['nama_supplier'];
				$ParamKasbank['keterangan'] = "PEMBELIAN TUNAI ATAS BUKTI ".$DataPembelian[0]['bukti'];
				$ParamKasbank['jumlah'] = $DataPembelian[0]['jumlah'];
				$ParamKasbank['no_ref'] = $DataPembelian[0]['bukti'];
				$ParamKasbank['unit_kode'] = 'VO0008';
				
				// $this->kasbank_model->SimpanKasbank($ParamKasbank);
			}
		}
	}
	
	public function hapuspembelianbarang(){
		$this->load->model('hutang_model');
		$this->load->model('kasbank_model');
		
		$DataPembelian = $this->pembelianbarangkonsinyasi_model->checkData($_POST['bukti']);
		$_POST['tanggal'] = $DataPembelian[0]['tanggal'];
		$_POST['supplier_kode'] = $DataPembelian[0]['supplier_kode'];
		$_POST['unit_kode'] = $DataPembelian[0]['unit_kode'];
		// $_POST['ref_op'] = $DataPembelian[0]['ref_op'];$Param = array();
		$Param['bukti'] = $_POST['bukti'];
		$Param['is_hapus'] = "";
		$DataBarangBI = $this->pembelianbarangkonsinyasi_model->getDataBarangBI($Param);

		$this->pembelianbarangkonsinyasi_model->HapusPembelianBarang($_POST);
		
		foreach($DataBarangBI as $key => $value){
			$this->pembelianbarangkonsinyasi_model->SyncHargaJualHpp($value);
			
			$TglArr = explode('-', $value['tanggal']);
			$ParamSync = array();
			$ParamSync['bulan'] = $TglArr[1];
			$ParamSync['tahun'] = $TglArr[0];
			$ParamSync['barang_kode'] = $value['barang_kode'];
			$ParamSync['toko_kode'] = $value['toko_kode'];
			$this->syncsaldo_model->SyncSaldoBarangGudangKonsinyasiSpesifik($ParamSync);
			if($ParamSync['toko_kode'] != ""){
				$this->syncsaldo_model->SyncSaldoBarangTokoKonsinyasiSpesifik($ParamSync);
			}
		}
		
		// hapus hutang, pembayaran
		$this->hutang_model->HapusSemuaPembayaran($_POST);
		$this->hutang_model->HapusHutang($_POST);
		// hapus kasabank pembelian tunai
		
		$_POST['kd_kb'] = "110";
		$_POST['kd_cb'] = "202";
		$this->kasbank_model->HapusKasbank($_POST);
	}
	
	public function getdatabarangbi(){
		$_POST['is_hapus'] = "0";
		$DataBarangBI = $this->pembelianbarangkonsinyasi_model->getDataBarangBI($_POST);
		
		$html = "";
		foreach ($DataBarangBI as $key => $value) {
			$html .= "<tr>
						<td>".$value['barang_kode']."</td>
						<td>".$value['nama_barang']."</td>
						<td>".$value['satuan']."</td>
						<td id=\"kwt_".$value['barang_kode']."\" class=\"text-right\">".$value['kwt_op']."</td>
						<td id=\"kwt_datang_".$value['barang_kode']."\" class=\"text-right\">".($value['kwt_op'] - $value['retur'])."</td>
						<td id=\"retur_".$value['barang_kode']."\" class=\"text-right\">".$value['retur']."</td>
						<td id=\"harga_".$value['barang_kode']."\" class=\"text-right\">".($value['harga_asli'] + $value['ppn'])."</td>
						<td id=\"harga_".$value['barang_kode']."\" class=\"text-right\">".$value['diskon1']."</td>
						<td id=\"ppn_".$value['barang_kode']."\" class=\"text-right\">".$value['ppn']."</td>
						<td id=\"jumlah_".$value['barang_kode']."\" class=\"text-right\">".$value['jumlah']."</td>
						<td class=\"text-center\">
							<button type=\"button\" id=\"btnopen_".$value['barang_kode']."\" style=\"padding: 1px 5px;\" onclick=\"Editkwt('".base64_encode(json_encode($value))."')\" class=\"btn btn-warning btn-sm\">
								<i class=\"fa fa-edit\"></i>
							</button>
							<input type='text' style='width: 80px; text-align: right; float: left; display: none;' class='form-control' id='retur_edit_".$value['barang_kode']."' name='retur_edit_".$value['barang_kode']."' />
							<button id='btn_cancel_edit_kwt_".$value['barang_kode']."' onclick=\"CancelEditkwt('".$value['barang_kode']."')\" name='btn_cancel_edit_kwt_".$value['barang_kode']."' type=\"button\" style=\"padding: 6px 5px; float: left; display: none;\" onclick=\"SimpanEditKwt(this)\" class=\"btn btn-danger btn-sm\">
								<i class=\"fa fa-times\"></i>
							</button>
							<button id='btn_edit_kwt_".$value['barang_kode']."' onclick=\"SimpanEditRetur('".$value['barang_kode']."')\" name='btn_edit_kwt_".$value['barang_kode']."' type=\"button\" style=\"padding: 6px 5px; float: left; display: none;\" class=\"btn btn-success btn-sm\">
								<i class=\"fa fa-check\"></i>
							</button>
							<!--<button type=\"button\" style=\"padding: 1px 6px;\" onclick=\"HapusRow(this)\" class=\"btn btn-danger btn-sm\"><i class=\"fa fa-times\"></i></button>-->
						</td>
					</tr>";
		}
		
		echo $html;
	}
	
	public function approvebkl(){
		$this->pembelianbarangkonsinyasi_model->ApproveBKL($_POST);
	}
	
	public function simpantransferketoko(){
		$DataTransferGudang = $this->pembelianbarangkonsinyasi_model->getDataTransferGudang($_POST);
		
		if(sizeof($DataTransferGudang) > 0){
			$BuktiTG = "S".$DataTransferGudang[0]['bukti'];
			$this->pembelianbarangkonsinyasi_model->hapusTransferGudang($DataTransferGudang[0]);
		}else{
			$BuktiTG = $this->pembelianbarangkonsinyasi_model->SimpanTransferKeToko($_POST);
			$Param = array();
			$Param['bukti'] = $_POST['bukti_bi'];
			$Param['is_hapus'] = "";
			$DataBarangBI = $this->pembelianbarangkonsinyasi_model->getDataBarangBI($Param);
			foreach($DataBarangBI as $key => $value){
				$TglArr = explode('-', $value['tanggal']);
				$ParamSync = array();
				$ParamSync['bulan'] = $TglArr[1];
				$ParamSync['tahun'] = $TglArr[0];
				$ParamSync['barang_kode'] = $value['barang_kode'];
				$ParamSync['toko_kode'] = $_POST['toko_kode'];
				$this->syncsaldo_model->SyncSaldoBarangGudangKonsinyasiSpesifik($ParamSync);
				$this->syncsaldo_model->SyncSaldoBarangTokoKonsinyasiSpesifik($ParamSync);
			}
		}
		
		echo $BuktiTG;
	}
	
	public function getrekappembelianbarang(){
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;Filename=rekap_harian_bi_".$_GET['tanggal_awal'].".xls");
		
		$DataPembelianBarang = $this->pembelianbarangkonsinyasi_model->getRekapPembelianBarang($_GET);
		
		$html = "<table>
					<tr>
						<td colspan=\"6\" align=\"center\">Rekap Harian Pengadaan Barang</td>
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
                       		<th>Tanggal</th>
							<th>Bukti</th>
							<th>Supplier</th>
                            <th>DPP</th>
                            <th>PPN</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>";
		foreach ($DataPembelianBarang as $key => $value) {
			$html .= "<tr>
						<td>".$value['tanggal']."</td>
						<td>".$value['bukti']."</td>
						<td>".$value['nama_supplier']."</td>
						<td align=\"right\">".$value['dpp']."</td>
						<td align=\"right\">".$value['ppn']."</td>
						<td align=\"right\">".$value['jumlah']."</td>
					  </tr>";
		}

		$html .= "</tbody></table>";
		
		echo $html;
	}
	
	public function cetakbikonsinyasi(){
		$_GET['is_hapus'] = "0";
		$DataBarangBI = $this->pembelianbarangkonsinyasi_model->getDataBarangBI($_GET);
		
		$html = "<style>
				 	table {
				 		font-size: 8px;
				 		font-family: \"Courier New\", Courier, monospace;
				 	}

				 	table.content {
				 		padding: 1px;
				 	}

				 	tr.border_bottom th {
				 		border-bottom:0.5pt dashed black;
				 		border-top:0.5pt dashed black;
					}

					tr.border_top td {
				 		border-top:0.5pt dashed black;
					}
				 </style>";
		$html .= "<table>
					<tr>
						<td><strong>Koperasi karyawan Keluarga Besar Petrokimia Gresik</strong></td>
						<td align=\"right\">Bukti Penerimaan Barang Konsinyasi</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				  </table>";
		$caraBayar = "TUNAI";
		if($DataBarangBI[0]['status_pembayaran'] == "K"){
			$caraBayar = "KREDIT";
		}
		$html .= "<table>
					<tr>
						<td width=\"70\">Supplier</td>
						<td width=\"30\"> : </td>
						<td width=\"200\">".$DataBarangBI[0]['supplier_kode']."</td>
						<td width=\"70\"></td>
						<td width=\"80\">Tanggal</td>
						<td width=\"30\"> : </td>
						<td width=\"100\">".$DataBarangBI[0]['tanggal']."</td>
					</tr>
					<tr>
						<td width=\"70\"></td>
						<td width=\"30\"></td>
						<td width=\"200\">".$DataBarangBI[0]['nama_supplier']."</td>
						<td width=\"70\"></td>
						<td width=\"80\">No Transaksi</td>
						<td width=\"30\"> : </td>
						<td width=\"100\">".$DataBarangBI[0]['bukti']."</td>
					</tr>
					<tr>
						<td width=\"70\">Uraian</td>
						<td width=\"30\"> : </td>
						<td width=\"200\">Penerimaan Barang Konsinyasi</td>
						<td width=\"70\"></td>
						<td width=\"80\">Fee Konsinyasi</td>
						<td width=\"30\"> : </td>
						<td width=\"100\">".$DataBarangBI[0]['fee_konsinyasi']." %</td>
					</tr>
				  </table><br/><br/>";
		$html .= "<table class=\"content\">
					<thead>
						<tr class=\"border_bottom\">
							<th width=\"20\">No</th>
							<th width=\"60\">Kode Barang</th>
							<th width=\"80\">Barcode</th>
							<th width=\"150\">Nama Barang</th>
							<th width=\"40\" align=\"right\">Jumlah</th>
							<th width=\"35\">Satuan</th>
							<th width=\"70\" align=\"right\">Harga @</th>
							<th width=\"100\" align=\"right\">Total</th>
						</tr>
					</thead>
					<tbody>";
		$inc = 1;
		$TotalHarga = 0;
		$TotalFee = 0;
		$TotalTransaksi = 0;
		foreach($DataBarangBI as $key => $value){
			$JumlahHarga = ($value['harga'] + $value['ppn']) * $value['kwt'];
			$html .= "<tr>
						<td width=\"20\">".$inc."</td>
						<td width=\"60\">".$value['barang_kode']."</td>
						<td width=\"80\">".$value['barcode']."</td>
						<td width=\"150\">".$value['nama_barang']."</td>
						<td width=\"40\" align=\"right\">".number_format($value['kwt'],2)."</td>
						<td width=\"35\">".$value['satuan']."</td>
						<td width=\"70\" align=\"right\">".number_format($value['harga_asli'],2)."</td>
						<td width=\"100\" align=\"right\">".number_format($JumlahHarga,2)."</td>
					  </tr>";
			$inc++;
			$TotalHarga += $JumlahHarga;
			$TotalFee += ($JumlahHarga * ($value['fee_konsinyasi']/100));
			$TotalTransaksi += ($JumlahHarga - ($JumlahHarga * ($value['fee_konsinyasi']/100)));
		}
		$html .= "<tr class=\"border_top\">
					<td colspan=\"7\">&nbsp;</td>
					<td align=\"right\">&nbsp;</td>
				  </tr>";
		$html .= "</tbody></table>";
		$html .= "<table>
					<tr>
						<td width=\"100\">Total Transaksi</td>
						<td width=\"30\"> : </td>
						<td width=\"100\" align=\"right\">".number_format($TotalHarga,2)."</td>
					</tr>
					<tr>
						<td width=\"100\">Total Fee</td>
						<td width=\"30\"> : </td>
						<td width=\"100\" align=\"right\">".number_format($TotalFee,2)."</td>
					</tr><tr>
						<td width=\"100\">Total</td>
						<td width=\"30\"> : </td>
						<td width=\"100\" align=\"right\">".number_format($TotalTransaksi,2)."</td>
					</tr>
				  </table><br/><br/><br/><br/>";
		$html .= "<table>
					<tr>
						<td align=\"center\">Dibuat oleh</td>
						<td align=\"center\">&nbsp;</td>
						<td align=\"center\">&nbsp;</td>
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
						<td align=\"center\">&nbsp;</td>
						<td align=\"center\">&nbsp;</td>
					</tr>
				  </table>";
		
		$this->load->library('Pdf');
		
		$pdf = new TCPDF("P", PDF_UNIT, 'A4', true, 'UTF-8', false);
		// Add a page
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->AddPage();
		$pdf->writeHTML($html, true, false, true, false, '');
		$pdf->Output('ReceiveInvoice.pdf', 'I');
	}
	
	public function cetakretur(){
		$DataBarangBI = $this->pembelianbarangkonsinyasi_model->getDataBarangBI($_GET);
		
		$html = "<style>
				 	table {
				 		font-size: 9px;
				 	}
				 </style>";
		$html .= "<table>
					<tr>
						<td><strong>Koperasi karyawan Keluarga Besar Petrokimia Gresik</strong></td>
						<td align=\"right\">Retur Pembelian</td>
					</tr>
					<tr>
						<td>Jl. ..... Petrokimia Gresik</td>
						<td>&nbsp;</td>
					</tr>
				  </table>";
		$caraBayar = "TUNAI";
		if($DataBarangBI[0]['status_pembayaran'] == "K"){
			$caraBayar = "KREDIT";
		}
		$html .= "<table>
					<tr>
						<td width=\"70\">Supplier</td>
						<td width=\"30\"> : </td>
						<td width=\"200\">".$DataBarangBI[0]['supplier_kode']."</td>
						<td width=\"70\"></td>
						<td width=\"80\">Tanggal</td>
						<td width=\"30\"> : </td>
						<td width=\"100\">".$DataBarangBI[0]['tanggal']."</td>
					</tr>
					<tr>
						<td width=\"70\"></td>
						<td width=\"30\"></td>
						<td width=\"200\">".$DataBarangBI[0]['nama_supplier']."</td>
						<td width=\"70\"></td>
						<td width=\"80\">No Transaksi</td>
						<td width=\"30\"> : </td>
						<td width=\"100\">".$DataBarangBI[0]['bukti']."</td>
					</tr>
					<tr>
						<td width=\"70\">Uraian</td>
						<td width=\"30\"> : </td>
						<td width=\"200\">Purchase Return</td>
						<td width=\"70\"></td>
						<td width=\"80\"></td>
						<td width=\"30\"></td>
						<td width=\"100\"></td>
					</tr>
				  </table><br/><br/>";
		$html .= "<table>
					<thead>
						<tr>
							<th width=\"20\">No</th>
							<th width=\"80\">Kode Barang</th>
							<th width=\"150\">Nama Barang</th>
							<th width=\"40\" align=\"right\">Jumlah</th>
							<th width=\"35\">Satuan</th>
							<th width=\"80\" align=\"right\">Harga @</th>
							<th width=\"45\" align=\"right\">Disc %</th>
							<th width=\"100\" align=\"right\">Total</th>
						</tr>
					</thead>
					<tbody>";
		$inc = 1;
		$TotalHarga = 0;
		$TotalPPN = 0;
		$TotalTransaksi = 0;
		foreach($DataBarangBI as $key => $value){
			if($value['retur'] > 0){
				$JumlahHarga = $value['retur'] * $value['harga'];
				$html .= "<tr>
							<td width=\"20\">".$inc."</td>
							<td width=\"80\">".$value['barang_kode']."</td>
							<td width=\"150\">".$value['nama_barang']."</td>
							<td width=\"40\" align=\"right\">".number_format($value['retur'],2)."</td>
							<td width=\"35\">".$value['satuan']."</td>
							<td width=\"80\" align=\"right\">".number_format($value['harga_asli'],2)."</td>
							<td width=\"45\" align=\"right\">".number_format($value['diskon1'],2)."</td>
							<td width=\"100\" align=\"right\">".number_format($JumlahHarga,2)."</td>
						  </tr>";
				$inc++;
				$TotalPPN += ($value['ppn'] * $value['retur']);
				$TotalHarga += $JumlahHarga;
				$TotalTransaksi += $value['jumlah'];
			}
		}
		if($TotalHarga == 0){
			echo "<script>window.close();</script>";
		}
		$html .= "<tr>
					<td colspan=\"7\">&nbsp;</td>
					<td align=\"right\">&nbsp;</td>
				  </tr>";
		$html .= "</tbody></table>";
		$html .= "<table>
					<tr>
						<td width=\"70\">Total</td>
						<td width=\"30\"> : </td>
						<td width=\"100\" align=\"right\">".number_format($TotalHarga,2)."</td>
					</tr>
					<tr>
						<td width=\"70\">Pajak</td>
						<td width=\"30\"> : </td>
						<td width=\"100\" align=\"right\">".number_format($TotalPPN,2)."</td>
					</tr><tr>
						<td width=\"70\">Total Transaksi</td>
						<td width=\"30\"> : </td>
						<td width=\"100\" align=\"right\">".number_format($TotalTransaksi,2)."</td>
					</tr>
				  </table><br/><br/><br/><br/>";
		$html .= "<table>
					<tr>
						<td align=\"center\">Dibuat oleh</td>
						<td align=\"center\">&nbsp;</td>
						<td align=\"center\">Manager Ops. MD/DC</td>
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
						<td align=\"center\">&nbsp;</td>
						<td align=\"center\">( .................................. )</td>
					</tr>
				  </table>";
		
		$this->load->library('Pdf');
		
		$pdf = new TCPDF("P", PDF_UNIT, 'A4', true, 'UTF-8', false);
		// Add a page
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->AddPage();
		$pdf->writeHTML($html, true, false, true, false, '');
		$pdf->Output('PurchaseReturn.pdf', 'I');
	}
}
