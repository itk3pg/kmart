<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rekapbarangpenjualan extends CI_Controller {
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
		$this->load->view('laporan/rekapbarangpenjualan', $Param);
		$this->load->view('general/footer');
	}
	
	public function getrekapbarangpenjualan(){
		$DataRekapBarangPenjualan = $this->laporan_model->getRekapBarangPenjualan($_POST);
		
		$html = "";
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
		foreach ($DataRekapBarangPenjualan as $key => $value) {
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
						<td>".$value['fitemkey']."</td>
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
				 
		echo $html;
	}
	
	public function cetakrekapbarangpenjualan(){
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;Filename=rekap_piutang_instansi.xls");
		$DataRekapBarangPenjualan = $this->laporan_model->getRekapBarangPenjualan($_GET);
		
		$html = "<table>
					<tr>
						<td colspan=\"10\" align=\"center\">REKAP DETAIL PENJUALAN</td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"10\">".$_GET['tanggal_awal']." / ".$_GET['tanggal_akhir']."</td>
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
		foreach ($DataRekapBarangPenjualan as $key => $value) {
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
}