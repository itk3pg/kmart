<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pembelianbarang extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('pembelianbarang_model');
		$this->load->model('syncsaldo_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('pembelianbarang/home2');
		$this->load->view('general/footer');
	}
	
	public function getdatapembelianbarang(){
		$DataPembelianBarang = $this->pembelianbarang_model->getDataPembelianBarang($_POST);
		
		$bukti = "";
		$html = "<table class=\"table table-striped table-bordered table-hover\" id=\"dataTables-pembelian-barang\">
                    <thead>
                        <tr>
							<th>Bukti</th>
							<th>Ref OP</th>
							<th>No Ref</th>
                       		<th>Tanggal</th>
                       		<th>User</th>
							<th>Supplier</th>
							<th>Pembayaran</th>
                            <th>Barang</th>
                            <th>KWT OP</th>
							<th>Retur</th>
							<th>KWT Terima</th>
                            <th>Harga</th>
                            <th>PPn</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>";
		foreach ($DataPembelianBarang as $key => $value) {
			$jumlah = ($value['harga'] + $value['ppn']) * $value['kwt'];
			
			$html .= "<tr data=\"".base64_encode(json_encode($value))."\">";
			if($bukti != $value['bukti']){
				$StatusPembayaran = "TUNAI";
				if($value['status_pembayaran'] == "K"){
					$StatusPembayaran = "KREDIT";
				}
				$html .= "<td>".$value['bukti']."</td>
						  <td>".$value['ref_op']."</td>
						  <td>".$value['no_ref']."</td>
						  <td>".$value['tanggal']."</td>
						  <td>".$value['nama_user']."</td>
						  <td>".$value['nama_supplier']."</td>
						  <td>".$StatusPembayaran."</td>";
				$bukti = $value['bukti'];
			}else{
				$html .= "<td></td>
						  <td></td>
						  <td></td>
						  <td></td>
						  <td></td>
						  <td></td>
						  <td></td>";
			}
			$html .= "	<td>".$value['nama_barang']."</td>
						<td align='right'>".$value['kwt_op']."</td>
						<td align='right'>".$value['retur']."</td>
						<td align='right'>".$value['kwt']."</td>
						<td align=\"right\">".number_format($value['harga'],2)."</td>
						<td align=\"right\">".number_format($value['ppn'],2)."</td>
						<td align=\"right\">".number_format($jumlah,2)."</td>
					  </tr>";
		}

		$html .= "</tbody></table>";
		
		echo $html;
	}
	
	public function getbuktiuangmuka(){
		$DataBuktiUM = $this->pembelianbarang_model->getBuktiUangMuka($_POST);
		
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
		for($index=0;$index<sizeof($dataArr);$index = $index + 12){
			$barang_kode = $dataArr[$index];
			$kwt_op = $dataArr[$index+4];
			$kwt_bi = $dataArr[$index+5];
			$retur = $kwt_op - $kwt_bi;
			if($retur < 0){
				$retur = 0;
			}
			$harga_asli = $dataArr[$index+6];
			$diskon = $dataArr[$index+7];
			$nilaidiskon = $harga_asli * ($diskon / 100);
			$harga_beli = $harga_asli - $nilaidiskon;
			
			$ppn_beli = $dataArr[$index+9];
			$total = $dataArr[$index+10];
			
			$_POST['barang_kode'] = $barang_kode;
			$_POST['retur'] = $retur;
			$_POST['kwt_op'] = $kwt_op;
			$_POST['kwt'] = $kwt_bi;
			$_POST['harga'] = $harga_beli;
			$_POST['diskon1'] = $diskon;
			$_POST['harga_asli'] = $harga_asli;
			$_POST['ppn'] = $ppn_beli;
			$_POST['jumlah'] = $total;
			$_POST['index'] = $index;
			
			$this->pembelianbarang_model->SimpanPembelianBarang($_POST);
			
			if($_POST['is_bkl'] == "0"){
				$TglArr = explode('-', $_POST['tanggal']);
				$ParamSync = array();
				$ParamSync['bulan'] = $TglArr[1];
				$ParamSync['tahun'] = $TglArr[0];
				$ParamSync['barang_kode'] = $barang_kode;
				//$this->syncsaldo_model->SyncSaldoBarangSpesifik($ParamSync);
				$this->syncsaldo_model->SyncSaldoBarangGudangUtamaSpesifik($ParamSync);
			}
		}
		if($_POST['ref_op'] != ""){
			$this->orderpembelian_model->setStatusOP($_POST['ref_op']);
		}
		$DataPembelian = $this->pembelianbarang_model->checkData($_POST['bukti']);
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
		
		$DataPembelian = $this->pembelianbarang_model->checkData($_POST['bukti']);
		$_POST['tanggal'] = $DataPembelian[0]['tanggal'];
		$_POST['supplier_kode'] = $DataPembelian[0]['supplier_kode'];
		$_POST['ref_op'] = $DataPembelian[0]['ref_op'];
		$this->pembelianbarang_model->HapusPembelianBarang($_POST);

		// Sync harga jual dan hpp
		$DataBarangBI = $this->pembelianbarang_model->getAllBarangBI($_POST);
		foreach ($DataBarangBI as $key => $value) {
			$this->pembelianbarang_model->SyncHargaJualHpp($value);

			$TglArr = explode('-', $value['tanggal']);
			$ParamSync = array();
			$ParamSync['bulan'] = $TglArr[1];
			$ParamSync['tahun'] = $TglArr[0];
			$ParamSync['barang_kode'] = $value['barang_kode'];
			$this->syncsaldo_model->SyncSaldoBarangGudangUtamaSpesifik($ParamSync);
		}
		
		// hapus hutang, pembayaran
		$this->hutang_model->HapusSemuaPembayaran($_POST);
		$this->hutang_model->HapusHutang($_POST);
		// hapus kasabank pembelian tunai
		
		$_POST['kd_kb'] = "110";
		$this->kasbank_model->HapusKasbank($_POST);
	}
	
	public function getdatabarangbi(){
		$DataBarangBI = $this->pembelianbarang_model->getDataBarangEditBI($_POST);
		
		$html = "";
		foreach ($DataBarangBI as $key => $value) {
			$JumlahSebelumPajak = $value['harga'] * $value['kwt'];
			$ppn = $value['ppn'];
			$html .= "<tr>
						<td>".$value['barang_kode']."</td>
						<td>".$value['nama_barang']."</td>
						<td>".$value['satuan']."</td>
						<td id=\"saldo_akhir_ket_".$value['barang_kode']."\" class=\"text-right\">".$value['saldo_akhir_kwt']."</td>
						<td id=\"kwt_op_".$value['barang_kode']."\" class=\"text-right\">".$value['kwt_op']."</td>
						<td id=\"kwt_".$value['barang_kode']."\" class=\"text-right\">".$value['kwt']."</td>
						<td id=\"harga_".$value['barang_kode']."\" class=\"text-right\">".$value['harga_asli']."</td>
						<td id=\"harga_".$value['barang_kode']."\" class=\"text-right\">".$value['diskon1']."</td>
						<td id=\"jumlah_".$value['barang_kode']."\" class=\"text-right\">".$JumlahSebelumPajak."</td>
						<td id=\"ppn_".$value['barang_kode']."\" class=\"text-right\">".$ppn."</td>
						<td id=\"total_".$value['barang_kode']."\" class=\"text-right\">".$value['jumlah']."</td>
						<td class=\"text-center\">
							<button type=\"button\" style=\"padding: 1px 5px;\" onclick=\"Editkwt('".base64_encode(json_encode($value))."')\" class=\"btn btn-warning btn-sm\">
								<i class=\"fa fa-edit\"></i>
							</button>
							<button type=\"button\" style=\"padding: 1px 6px;\" onclick=\"HapusRow(this)\" class=\"btn btn-danger btn-sm\"><i class=\"fa fa-times\"></i></button>
						</td>
					</tr>";
		}
		
		echo $html;
	}
	
	public function approvebkl(){
		$this->pembelianbarang_model->ApproveBKL($_POST);
	}
	
	public function simpantransferketoko(){
		$DataTransferGudang = $this->pembelianbarang_model->getDataTransferGudang($_POST);
		
		if(sizeof($DataTransferGudang) > 0){
			$BuktiTG = "S".$DataTransferGudang[0]['bukti'];
		}else{
			$BuktiTG = $this->pembelianbarang_model->SimpanTransferKeToko($_POST);
			$Param = array();
			$Param['bukti'] = $_POST['bukti_bi'];
			$DataBarangBI = $this->pembelianbarang_model->getDataBarangBI($Param);
			foreach($DataBarangBI as $key => $value){
				$TglArr = explode('-', $value['tanggal']);
				$ParamSync = array();
				$ParamSync['bulan'] = $TglArr[1];
				$ParamSync['tahun'] = $TglArr[0];
				$ParamSync['barang_kode'] = $value['barang_kode'];
				$ParamSync['toko_kode'] = $_POST['toko_kode'];
				$this->syncsaldo_model->SyncSaldoBarangGudangUtamaSpesifik($ParamSync);
				$this->syncsaldo_model->SyncSaldoBarangGudangSpesifik($ParamSync);
			}
		}
		
		echo $BuktiTG;
	}
	
	public function getrekappembelianbarang(){
		// header("Content-type: application/vnd.ms-excel");
		// header("Content-Disposition: attachment;Filename=rekap_harian_bi_".$_GET['tanggal_awal'].".xls");
		
		$html = "<style>
				 	table {
				 		font-size: 8px;
				 	}

				 	table.content {
				 		padding: 1px;
				 	}

				 	tr.border_bottom th {
				 		border-bottom:0.5pt dashed black;
					}

					tr.border_top td {
				 		border-top:0.5pt dashed black;
				 		border-bottom:0.5pt dashed black;
					}
				 </style>";
		$html .= "<table>
					<tr>
						<td><strong>Koperasi karyawan Keluarga Besar Petrokimia Gresik</strong></td>
						<td align=\"right\">".date('d-m-Y H:m:s')."</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				  </table>";

		$DataPembelianBarang = $this->pembelianbarang_model->getRekapPembelianBarang($_GET);
		
		$html .= "<table>
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
		$html .= "<table class=\"content\">
                    <thead>
                        <tr class=\"border_bottom\">
                       		<th width=\"15\" align=\"right\">No</th>
                       		<th>Tanggal</th>
							<th>Bukti</th>
							<th>Ref OP</th>
							<th>No Ref</th>
							<th width=\"130\">Kode Supplier</th>
							<th align=\"left\" width=\"55\">Supplier</th>
                            <th align=\"right\">DPP</th>
                            <th align=\"right\">PPN</th>
                            <th align=\"right\">Total</th>
                        </tr>
                    </thead>
                    <tbody>";
        $inc = 1;
        $tanggal = "";
        $TotalDPP = 0;
        $TotalPPn = 0;
        $TotalJumlah = 0;
        $TotalDPPAll = 0;
        $TotalPPnAll = 0;
        $TotalJumlahAll = 0;
		foreach ($DataPembelianBarang as $key => $value) {
			if($tanggal == ""){
				$tanggal = $value['tanggal'];
			}
			if($tanggal != $value['tanggal']){
				$html .= "<tr class=\"border_top\">
							<td colspan=\"7\">Sub Total</td>
							<td align=\"right\"><strong>".number_format($TotalDPP, 2)."</strong></td>
							<td align=\"right\"><strong>".number_format($TotalPPn, 2)."</strong></td>
							<td align=\"right\"><strong>".number_format($TotalJumlah, 2)."</strong></td>
						  </tr>";
				$tanggal = $value['tanggal'];
				$TotalDPP = 0;
		        $TotalPPn = 0;
		        $TotalJumlah = 0;
		        $inc = 1;
			}
			$html .= "<tr>
						<td width=\"15\" align=\"right\">".$inc."</td>
						<td>".$value['tanggal']."</td>
						<td>".$value['bukti']."</td>
						<td>".$value['ref_op']."</td>
						<td>".$value['no_ref']."</td>
						<td>".$value['supplier_kode']."</td>
						<td width=\"130\">".$value['nama_supplier']."</td>
						<td align=\"right\">".number_format($value['dpp'], 2)."</td>
						<td align=\"right\">".number_format($value['ppn'], 2)."</td>
						<td align=\"right\">".number_format($value['jumlah'], 2)."</td>
					  </tr>";
			$inc++;
			$TotalDPP += $value['dpp'];
	        $TotalPPn += $value['ppn'];
	        $TotalJumlah += $value['jumlah'];
	        $TotalDPPAll += $value['dpp'];
	        $TotalPPnAll += $value['ppn'];
	        $TotalJumlahAll += $value['jumlah'];
		}
		$html .= "<tr class=\"border_top\">
					<td colspan=\"7\">Sub Total</td>
					<td align=\"right\"><strong>".number_format($TotalDPP, 2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalPPn, 2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalJumlah, 2)."</strong></td>
				  </tr>
				  <tr class=\"border_top\">
					<td colspan=\"7\">Total</td>
					<td align=\"right\"><strong>".number_format($TotalDPPAll, 2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalPPnAll, 2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalJumlahAll, 2)."</strong></td>
				  </tr>";

		$html .= "</tbody></table><br/><br/>";

		$DataKelompokPembelianBarang = $this->pembelianbarang_model->getRekapKelompokPembelianBarang($_GET);
		$html .= "<table width=\"30%\">";
		$TotalAll = 0;
		foreach ($DataKelompokPembelianBarang as $key => $value) {
			$html .= "<tr>
						<td>(".$value['kategori'].") ".$value['nama']."</td>
						<td align=\"right\">".number_format($value['jumlah'])."</td>
					  </tr>";
			$TotalAll += $value['jumlah'];
		}
		$html .= "<tr>
					<td>Total</td>
					<td align=\"right\"><strong>".number_format($TotalAll)."</strong></td>
				  </tr>";
					
		$html .= "</table>";
		
		$this->load->library('Pdf');
		
		$pdf = new TCPDF("P", PDF_UNIT, 'A4', true, 'UTF-8', false);
		// Add a page
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->AddPage();
		$pdf->writeHTML($html, true, false, true, false, '');
		$pdf->Output('RekapHarianPengadaanBarang.pdf', 'I');
	}

	public function getrekappembelianbarang_xls(){
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;Filename=rekap_harian_bi_".$_GET['tanggal_awal'].".xls");

		$html = "<table>
					<tr>
						<td><strong>Koperasi karyawan Keluarga Besar Petrokimia Gresik</strong></td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td align=\"right\">".date('d-m-Y H:m:s')."</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				  </table>";

		$DataPembelianBarang = $this->pembelianbarang_model->getRekapPembelianBarang($_GET);
		
		$html .= "<table>
					<tr>
						<td colspan=\"8\" align=\"center\">Rekap Harian Pengadaan Barang</td>
					</tr>
					<tr>
						<td colspan=\"8\" align=\"center\">".$_GET['tanggal_awal']." / ".$_GET['tanggal_akhir']."</td>
					</tr>
					<tr>
						<td colspan=\"8\" align=\"center\"></td>
					</tr>
				 </table>";
		$html .= "<table border=\"1\">
                    <thead>
                        <tr class=\"border_bottom\">
                       		<th width=\"15\" align=\"right\">No</th>
                       		<th>Tanggal</th>
							<th>Bukti</th>
							<th>Ref OP</th>
							<th>No Ref</th>
							<th width=\"130\">Kode Supplier</th>
							<th align=\"left\" width=\"55\">Supplier</th>
                            <th align=\"right\">DPP</th>
                            <th align=\"right\">PPN</th>
                            <th align=\"right\">Total</th>
                        </tr>
                    </thead>
                    <tbody>";
        $inc = 1;
        $tanggal = "";
        $TotalDPP = 0;
        $TotalPPn = 0;
        $TotalJumlah = 0;
        $TotalDPPAll = 0;
        $TotalPPnAll = 0;
        $TotalJumlahAll = 0;
		foreach ($DataPembelianBarang as $key => $value) {
			if($tanggal == ""){
				$tanggal = $value['tanggal'];
			}
			if($tanggal != $value['tanggal']){
				$html .= "<tr class=\"border_top\">
							<td colspan=\"7\">Sub Total</td>
							<td align=\"right\"><strong>".number_format($TotalDPP, 2)."</strong></td>
							<td align=\"right\"><strong>".number_format($TotalPPn, 2)."</strong></td>
							<td align=\"right\"><strong>".number_format($TotalJumlah, 2)."</strong></td>
						  </tr>";
				$tanggal = $value['tanggal'];
				$TotalDPP = 0;
		        $TotalPPn = 0;
		        $TotalJumlah = 0;
		        $inc = 1;
			}
			$html .= "<tr>
						<td width=\"15\" align=\"right\">".$inc."</td>
						<td>".$value['tanggal']."</td>
						<td>".$value['bukti']."</td>
						<td>".$value['ref_op']."</td>
						<td>".$value['no_ref']."</td>
						<td>".$value['supplier_kode']."</td>
						<td width=\"130\">".$value['nama_supplier']."</td>
						<td align=\"right\">".number_format($value['dpp'], 2)."</td>
						<td align=\"right\">".number_format($value['ppn'], 2)."</td>
						<td align=\"right\">".number_format($value['jumlah'], 2)."</td>
					  </tr>";
			$inc++;
			$TotalDPP += $value['dpp'];
	        $TotalPPn += $value['ppn'];
	        $TotalJumlah += $value['jumlah'];
	        $TotalDPPAll += $value['dpp'];
	        $TotalPPnAll += $value['ppn'];
	        $TotalJumlahAll += $value['jumlah'];
		}
		$html .= "<tr class=\"border_top\">
					<td colspan=\"7\">Sub Total</td>
					<td align=\"right\"><strong>".number_format($TotalDPP, 2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalPPn, 2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalJumlah, 2)."</strong></td>
				  </tr>
				  <tr class=\"border_top\">
					<td colspan=\"7\">Total</td>
					<td align=\"right\"><strong>".number_format($TotalDPPAll, 2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalPPnAll, 2)."</strong></td>
					<td align=\"right\"><strong>".number_format($TotalJumlahAll, 2)."</strong></td>
				  </tr>";

		$html .= "</tbody></table><br/><br/>";

		$DataKelompokPembelianBarang = $this->pembelianbarang_model->getRekapKelompokPembelianBarang($_GET);
		$html .= "<table width=\"30%\">";
		$TotalAll = 0;
		foreach ($DataKelompokPembelianBarang as $key => $value) {
			$html .= "<tr>
						<td>(".$value['kategori'].") ".$value['nama']."</td>
						<td align=\"right\">".number_format($value['jumlah'])."</td>
					  </tr>";
			$TotalAll += $value['jumlah'];
		}
		$html .= "<tr>
					<td>Total</td>
					<td align=\"right\"><strong>".number_format($TotalJumlahAll)."</strong></td>
				  </tr>";
					
		$html .= "</table>";

		echo $html;
	}
	
	public function cetakbi(){
		$DataBarangBI = $this->pembelianbarang_model->getDataBarangBI($_GET);
		
		$html = "<style>
				 	table {
				 		font-size: 9px;
				 	}
				 </style>";
		$html .= "<table>
					<tr>
						<td><strong>Koperasi karyawan Keluarga Besar Petrokimia Gresik</strong></td>
						<td align=\"right\">Bukti Penerimaan Barang</td>
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
						<td width=\"70\">No Ref</td>
						<td width=\"30\"> : </td>
						<td width=\"200\">".$DataBarangBI[0]['ref_op']." / ".$DataBarangBI[0]['no_ref']."</td>
						<td width=\"70\"></td>
						<td width=\"80\">Cara Bayar</td>
						<td width=\"30\"> : </td>
						<td width=\"100\">".$caraBayar."</td>
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
							<th width=\"45\" align=\"right\">Disc %</th>
							<th width=\"80\" align=\"right\">Harga @</th>
							<th width=\"100\" align=\"right\">Total</th>
						</tr>
					</thead>
					<tbody>";
		$inc = 1;
		$TotalHarga = 0;
		$TotalPPN = 0;
		$TotalTransaksi = 0;
		foreach($DataBarangBI as $key => $value){
			$html .= "<tr>
						<td width=\"20\">".$inc."</td>
						<td width=\"80\">".$value['barang_kode']."</td>
						<td width=\"150\">".$value['nama_barang']."</td>
						<td width=\"40\" align=\"right\">".number_format($value['kwt'],2)."</td>
						<td width=\"35\">".$value['satuan']."</td>
						<td width=\"45\" align=\"right\">".number_format($value['diskon1'],2)."</td>
						<td width=\"80\" align=\"right\">".number_format($value['harga'] + $value['ppn'] ,2)."</td>
						<td width=\"100\" align=\"right\">".number_format($value['jumlah'],2)."</td>
					  </tr>";
			$inc++;
			$TotalPPN += ($value['ppn'] * $value['kwt']);
			$TotalHarga += ($value['harga']) * $value['kwt'];
			$TotalTransaksi += $value['jumlah'];
		}
		$html .= "<tr>
					<td colspan=\"7\">&nbsp;</td>
					<td align=\"right\">&nbsp;</td>
				  </tr>";
		$html .= "</tbody></table>";
		$html .= "<table>
					<tr>
						<td width=\"70\">DPP</td>
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
						<td align=\"center\">( ......................................... )</td>
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
		$DataBarangBI = $this->pembelianbarang_model->getDataBarangBI($_GET);
		
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
