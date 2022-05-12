<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mutasibarang extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('laporan_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('laporan/mutasibarang');
		$this->load->view('general/footer');
	}

	public function getmutasibarang(){
		$DataMutasiBarang = $this->laporan_model->getSaldoGudangAll($_POST);

		$html = "<table class=\"table table-striped table-bordered table-hover\">
					<thead>
						<tr>
							<th>No</th>
							<th>Kode Barang</th>
							<th>Nama Barang</th>
							<th>Satuan</th>
							<th>Kategori</th>
							<th>Gudang DC</th>
							<th>Toko 1</th>
							<th>Toko 2</th>
							<th>Toko Express</th>
							<th>Toko Bungah</th>
							<th>Toko Express CSR</th>
							<th>Harga Nota</th>
						</tr>
					</thead>
					<tbody>";
		$JumlahGudang = 0;		
		$JumlahToko1 = 0;
		$JumlahToko2 = 0;
		$JumlahToko4 = 0;
		$JumlahToko5 = 0;
		$JumlahToko11 = 0;
		$Nomor = 1;
		foreach ($DataMutasiBarang as $key => $value) {
			$html .= "<tr>
						<td align=\"right\">".$Nomor."</td>
						<td>".$value['barang_kode']."</td>
						<td>".$value['nama_barang']."</td>
						<td>".$value['satuan']."</td>
						<td>".$value['kategori']."</td>
						<td align=\"right\">".round($value['saldo_gudang'],2)."</td>
						<td align=\"right\">".round($value['saldo_toko1'],2)."</td>
						<td align=\"right\">".round($value['saldo_toko2'],2)."</td>
						<td align=\"right\">".round($value['saldo_toko4'],2)."</td>
						<td align=\"right\">".round($value['saldo_toko5'],2)."</td>
						<td align=\"right\">".round($value['saldo_toko11'],2)."</td>
						<td align=\"right\">".round($value['hpp'],2)."</td>
					</tr>";

			$JumlahGudang += $value['saldo_gudang'];
			$JumlahToko1 += $value['saldo_toko1'];
			$JumlahToko2 += $value['saldo_toko2'];
			$JumlahToko4 += $value['saldo_toko4'];
			$JumlahToko5 += $value['saldo_toko5'];
			$JumlahToko11 += $value['saldo_toko11'];
			$Nomor++;
		}
		$html .= "<tr>
					<td colspan=\"5\">Total</td>
					<td align=\"right\">".round($JumlahGudang,2)."</td>
					<td align=\"right\">".round($JumlahToko1,2)."</td>
					<td align=\"right\">".round($JumlahToko2,2)."</td>
					<td align=\"right\">".round($JumlahToko4,2)."</td>
					<td align=\"right\">".round($JumlahToko5,2)."</td>
					<td align=\"right\">".round($JumlahToko11,2)."</td>
					<td align=\"right\">&nbsp;</td>
				  </tr>";
		$html .=    "
					</tbody>
				 </table>";
				 
		echo $html;
	}
	
	public function getmutasibarang_bak(){
		$DataMutasiBarang = $this->laporan_model->getMutasiBarang($_POST);
		
		$jm_saldo_awal_kwt = 0;
		$jm_saldo_awal_hsat = 0;
		$jm_saldo_awal_hrg = 0;
		$jm_kwt_in = 0;
		$jm_hsat_in = 0;
		$jm_jm_hrg_in = 0;
		$jm_kwt_out = 0;
		$jm_kwt_out_tau = 0;
		$jm_hsat_out = 0;
		$jm_jm_hrg_out = 0;
		$jm_jm_hrg_out_tau = 0;
		$jm_saldo_akhir_kwt = 0;
		$jm_saldo_akhir_hsat = 0;
		$jm_saldo_akhir_hrg = 0;
		
		$main_title = "BARANG";
		
		$html = "<table class=\"table table-striped table-bordered table-hover\">
					<thead>
						<tr>
							<th colspan=\"2\">".$main_title."</th>
							<th colspan=\"3\">SALDO AWAL</th>
							<th colspan=\"3\">".$main_title." MASUK</th>
							<th colspan=\"5\">".$main_title." KELUAR</th>
							<th colspan=\"3\">SALDO AKHIR</th>
						</tr>
						<tr>
							<th>KODE</th>
							<th>NAMA</th>
							<th>KWT</th>
							<th>HSAT</th>
							<th>JUMLAH</th>
							<th>KWT</th>
							<th>HSAT</th>
							<th>JUMLAH</th>
							<th>KWT</th>
							<th>KWT TAU</th>
							<th>HSAT</th>
							<th>JUMLAH</th>
							<th>JUMLAH TAU</th>
							<th>KWT</th>
							<th>HSAT</th>
							<th>JUMLAH</th>
						</tr>
					</thead>
					<tbody>";
		
		foreach ($DataMutasiBarang as $key => $value) {
			$kd_item = $value['barang_kode'];
			$nama_item = $value['nama_barang'];
			
			//$hrg_out = $value['kwt_out'] * $value['hsat_out'];
			//$hrg_out_tau = $value['kwt_out_tau'] * $value['hsat_out'];
			// if(($value['jumlah_saldo_awal'] != 0 && $value['jumlah_saldo_awal'] != "") || ($value['jumlah_in'] != 0 && $value['jumlah_in'] != "") || ($value['jumlah_out'] != 0 && $value['jumlah_out'] != "") || ($value['jumlah_tau_out'] != 0 && $value['jumlah_tau_out'] != "") || ($value['jumlah_saldo_akhir'] != 0 && $value['jumlah_saldo_akhir'] != "")){
				$html .= "<tr>
							<td>".$kd_item."</td>
							<td>".$nama_item."</td>
							<td align=\"right\">".number_format($value['saldo_awal_kwt'],2)."</td>
							<td align=\"right\">".number_format($value['saldo_awal_hsat'],2)."</td>
							<td align=\"right\">".number_format($value['jumlah_saldo_awal'],2)."</td>
							<td align=\"right\">".number_format($value['kwt_in'],2)."</td>
							<td align=\"right\">".number_format($value['hsat_in'],2)."</td>
							<td align=\"right\">".number_format($value['jumlah_in'],2)."</td>
							<td align=\"right\">".number_format($value['kwt_out'],2)."</td>
							<td align=\"right\">".number_format($value['tau_out'],2)."</td>
							<td align=\"right\">".number_format($value['hsat_out'],2)."</td>
							<td align=\"right\">".number_format($value['jumlah_out'],2)."</td>
							<td align=\"right\">".number_format($value['jumlah_tau_out'],2)."</td>
							<td align=\"right\">".number_format($value['saldo_akhir_kwt'],2)."</td>
							<td align=\"right\">".number_format($value['saldo_akhir_hsat'],2)."</td>
							<td align=\"right\">".number_format($value['jumlah_saldo_akhir'],2)."</td>
						 </tr>";
						 
				$jm_saldo_awal_kwt += $value['saldo_awal_kwt'];
				$jm_saldo_awal_hsat += $value['saldo_awal_hsat'];
				$jm_saldo_awal_hrg += $value['jumlah_saldo_awal'];
				$jm_kwt_in += $value['kwt_in'];
				$jm_hsat_in += $value['hsat_in'];
				$jm_jm_hrg_in += $value['jumlah_in'];
				$jm_kwt_out += $value['kwt_out'];
				$jm_kwt_out_tau += $value['tau_out'];
				$jm_hsat_out += $value['hsat_out'];
				$jm_jm_hrg_out += $value['jumlah_out'];
				$jm_jm_hrg_out_tau += $value['jumlah_tau_out'];
				$jm_saldo_akhir_kwt += $value['saldo_akhir_kwt'];
				$jm_saldo_akhir_hsat += $value['saldo_akhir_hsat'];
				$jm_saldo_akhir_hrg += $value['jumlah_saldo_akhir'];
			// }
		}
		$html .= "<tr>
					<td colspan=\"2\">Total</td>
					<td align=\"right\">".number_format($jm_saldo_awal_kwt,2)."</td>
					<td align=\"right\">".number_format($jm_saldo_awal_hsat,2)."</td>
					<td align=\"right\">".number_format($jm_saldo_awal_hrg,2)."</td>
					<td align=\"right\">".number_format($jm_kwt_in,2)."</td>
					<td align=\"right\">".number_format($jm_hsat_in,2)."</td>
					<td align=\"right\">".number_format($jm_jm_hrg_in,2)."</td>
					<td align=\"right\">".number_format($jm_kwt_out,2)."</td>
					<td align=\"right\">".number_format($jm_kwt_out_tau,2)."</td>
					<td align=\"right\">".number_format($jm_hsat_out,2)."</td>
					<td align=\"right\">".number_format($jm_jm_hrg_out,2)."</td>
					<td align=\"right\">".number_format($jm_jm_hrg_out_tau,2)."</td>
					<td align=\"right\">".number_format($jm_saldo_akhir_kwt,2)."</td>
					<td align=\"right\">".number_format($jm_saldo_akhir_hsat,2)."</td>
					<td align=\"right\">".number_format($jm_saldo_akhir_hrg,2)."</td>
				 </tr>";
		$html .=    "
					</tbody>
				 </table>";
				 
		echo $html;
	}
	
	/*public function getmutasibarang(){
		$DataMutasiBarang = $this->laporan_model->getDataBarangAll($_POST);
		
		$jm_saldo_awal_kwt = 0;
		$jm_saldo_awal_hsat = 0;
		$jm_saldo_awal_hrg = 0;
		$jm_kwt_in = 0;
		$jm_hsat_in = 0;
		$jm_jm_hrg_in = 0;
		$jm_kwt_out = 0;
		$jm_hsat_out = 0;
		$jm_jm_hrg_out = 0;
		$jm_saldo_akhir_kwt = 0;
		$jm_saldo_akhir_hsat = 0;
		$jm_saldo_akhir_hrg = 0;
		
		$main_title = "BARANG";
		
		$html = "<table class=\"table table-striped table-bordered table-hover\">
					<thead>
						<tr>
							<th colspan=\"2\">".$main_title."</th>
							<th colspan=\"3\">SALDO AWAL</th>
							<th colspan=\"3\">".$main_title." MASUK</th>
							<th colspan=\"3\">".$main_title." KELUAR</th>
							<th colspan=\"3\">SALDO AKHIR</th>
						</tr>
						<tr>
							<th>KODE</th>
							<th>NAMA</th>
							<th>KWT</th>
							<th>HSAT</th>
							<th>JUMLAH</th>
							<th>KWT</th>
							<th>HSAT</th>
							<th>JUMLAH</th>
							<th>KWT</th>
							<th>HSAT</th>
							<th>JUMLAH</th>
							<th>KWT</th>
							<th>HSAT</th>
							<th>JUMLAH</th>
						</tr>
					</thead>
					<tbody>";
		
		foreach ($DataMutasiBarang as $key => $value) {
			$kd_item = $value['kode'];
			$nama_item = $value['nama_barang'];
			
			$_POST['barang_kode'] = $value['kode'];
			$DataKeluarMasuk = $this->laporan_model->getDataKeluarMasukBarang($_POST);
			$DataSaldoAwal = $this->laporan_model->getDataSaldoAwalBarang($_POST);
			$DataSaldoAkhir = $this->laporan_model->getDataSaldoAkhirBarang($_POST);
			
			//$hrg_out = $value['kwt_out'] * $value['hsat_out'];
			//$hrg_out_tau = $value['kwt_out_tau'] * $value['hsat_out'];
			//if(($value['jumlah_saldo_awal'] != 0 && $value['jumlah_saldo_awal'] != "") || ($value['jumlah_in'] != 0 && $value['jumlah_in'] != "") || ($value['jumlah_out'] != 0 && $value['jumlah_out'] != "") || ($value['jumlah_saldo_akhir'] != 0 && $value['jumlah_saldo_akhir'] != "")){
				$html .= "<tr>
							<td>".$kd_item."</td>
							<td>".$nama_item."</td>
							<td align=\"right\">".round($DataSaldoAwal[0]['saldo_awal_kwt'],2)."</td>
							<td align=\"right\">".round($DataSaldoAwal[0]['saldo_awal_hsat'],2)."</td>
							<td align=\"right\">".round($DataSaldoAwal[0]['jumlah_saldo_awal'],2)."</td>
							<td align=\"right\">".round($DataKeluarMasuk[0]['kwt_in'],2)."</td>
							<td align=\"right\">".round($DataKeluarMasuk[0]['hsat_in'],2)."</td>
							<td align=\"right\">".round($DataKeluarMasuk[0]['jumlah_in'],2)."</td>
							<td align=\"right\">".round($DataKeluarMasuk[0]['kwt_out'],2)."</td>
							<td align=\"right\">".round($DataKeluarMasuk[0]['hsat_out'],2)."</td>
							<td align=\"right\">".round($DataKeluarMasuk[0]['jumlah_out'],2)."</td>
							<td align=\"right\">".round($DataSaldoAkhir[0]['saldo_akhir_kwt'],2)."</td>
							<td align=\"right\">".round($DataSaldoAkhir[0]['saldo_akhir_hsat'],2)."</td>
							<td align=\"right\">".round($DataSaldoAkhir[0]['jumlah_saldo_akhir'],2)."</td>
						 </tr>";
						 
				$jm_saldo_awal_kwt += $DataSaldoAwal[0]['saldo_awal_kwt'];
				$jm_saldo_awal_hsat += $DataSaldoAwal[0]['saldo_awal_hsat'];
				$jm_saldo_awal_hrg += $DataSaldoAwal[0]['jumlah_saldo_awal'];
				$jm_kwt_in += $DataKeluarMasuk[0]['kwt_in'];
				$jm_hsat_in += $DataKeluarMasuk[0]['hsat_in'];
				$jm_jm_hrg_in += $DataKeluarMasuk[0]['jumlah_in'];
				$jm_kwt_out += $DataKeluarMasuk[0]['kwt_out'];
				$jm_hsat_out += $DataKeluarMasuk[0]['hsat_out'];
				$jm_jm_hrg_out += $DataKeluarMasuk[0]['jumlah_out'];
				$jm_saldo_akhir_kwt += $DataSaldoAkhir[0]['saldo_akhir_kwt'];
				$jm_saldo_akhir_hsat += $DataSaldoAkhir[0]['saldo_akhir_hsat'];
				$jm_saldo_akhir_hrg += $DataSaldoAkhir[0]['jumlah_saldo_akhir'];
			//}
		}
		$html .= "<tr>
					<td colspan=\"2\">Total</td>
					<td align=\"right\">".round($jm_saldo_awal_kwt,2)."</td>
					<td align=\"right\">".round($jm_saldo_awal_hsat,2)."</td>
					<td align=\"right\">".round($jm_saldo_awal_hrg,2)."</td>
					<td align=\"right\">".round($jm_kwt_in,2)."</td>
					<td align=\"right\">".round($jm_hsat_in,2)."</td>
					<td align=\"right\">".round($jm_jm_hrg_in,2)."</td>
					<td align=\"right\">".round($jm_kwt_out,2)."</td>
					<td align=\"right\">".round($jm_hsat_out,2)."</td>
					<td align=\"right\">".round($jm_jm_hrg_out,2)."</td>
					<td align=\"right\">".round($jm_saldo_akhir_kwt,2)."</td>
					<td align=\"right\">".round($jm_saldo_akhir_hsat,2)."</td>
					<td align=\"right\">".round($jm_saldo_akhir_hrg,2)."</td>
				 </tr>";
		$html .=    "
					</tbody>
				 </table>";
				 
		echo $html;
	}*/

	public function cetakmutasibarang(){
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;Filename=mutasi_barang_".$_GET['bulan']."_".$_GET['tahun'].".xls");
		
		$html = "<table>
					<tr>
						<td colspan=\"5\"><strong>KOPERASI KARYAWAN KELUARGA BESAR PETROKIMIA GRESIK</strong></td>
						<td align=\"right\" colspan=\"3\"><strong>TGL. : ".date("d-m-Y H:i:s")."</strong></th>
					</tr>
					<tr>
						<td colspan=\"5\"><strong>K-Mart</strong></td>
						<td colspan=\"3\"></th>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"8\"><strong>LAPORAN SALDO BARANG GUDANG</strong></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"8\"><strong>PERIODE : ".$_GET['bulan']." - ".$_GET['tahun']."</strong></td>
					</tr>
				 </table>";

		$DataMutasiBarang = $this->laporan_model->getSaldoGudangAll($_GET);

		$html .= "<table border=\"1\">
					<thead>
						<tr>
							<th>No</th>
							<th>Kode Barang</th>
							<th>Nama Barang</th>
							<th>Satuan</th>
							<th>Kategori</th>
							<th>Gudang DC</th>
							<th>Toko 1</th>
							<th>Toko 2</th>
							<th>Toko Express</th>
							<th>Toko Bungah</th>
							<th>Toko Express CSR</th>
							<th>Harga Nota</th>
						</tr>
					</thead>
					<tbody>";
		$JumlahGudang = 0;		
		$JumlahToko1 = 0;
		$JumlahToko2 = 0;
		$JumlahToko4 = 0;
		$JumlahToko5 = 0;
		$JumlahToko11 = 0;
		$Nomor = 1;
		foreach ($DataMutasiBarang as $key => $value) {
			$html .= "<tr>
						<td align=\"right\">".$Nomor."</td>
						<td>".$value['barang_kode']."</td>
						<td>".$value['nama_barang']."</td>
						<td>".$value['satuan']."</td>
						<td>".$value['kategori']."</td>
						<td align=\"right\">".round($value['saldo_gudang'],2)."</td>
						<td align=\"right\">".round($value['saldo_toko1'],2)."</td>
						<td align=\"right\">".round($value['saldo_toko2'],2)."</td>
						<td align=\"right\">".round($value['saldo_toko4'],2)."</td>
						<td align=\"right\">".round($value['saldo_toko5'],2)."</td>
						<td align=\"right\">".round($value['saldo_toko11'],2)."</td>
						<td align=\"right\">".round($value['hpp'],2)."</td>
					</tr>";

			$JumlahGudang += $value['saldo_gudang'];
			$JumlahToko1 += $value['saldo_toko1'];
			$JumlahToko2 += $value['saldo_toko2'];
			$JumlahToko4 += $value['saldo_toko4'];
			$JumlahToko5 += $value['saldo_toko5'];
			$JumlahToko11 += $value['saldo_toko11'];
			$Nomor++;
		}
		$html .= "<tr>
					<td colspan=\"5\">Total</td>
					<td align=\"right\">".round($JumlahGudang,2)."</td>
					<td align=\"right\">".round($JumlahToko1,2)."</td>
					<td align=\"right\">".round($JumlahToko2,2)."</td>
					<td align=\"right\">".round($JumlahToko4,2)."</td>
					<td align=\"right\">".round($JumlahToko5,2)."</td>
					<td align=\"right\">".round($JumlahToko11,2)."</td>
					<td align=\"right\">&nbsp;</td>
				  </tr>";
		$html .=    "
					</tbody>
				 </table>";
		$html .= "<table>
					<tr>
						<td align=\"center\" colspan=\"4\">Mengetahui</td>
						<td align=\"center\" colspan=\"4\">Yang membuat</td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"4\"></td>
						<td align=\"center\" colspan=\"4\"></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"4\"></td>
						<td align=\"center\" colspan=\"4\"></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"4\"></td>
						<td align=\"center\" colspan=\"4\"></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"4\"><strong>(......................)</strong></td>
						<td align=\"center\" colspan=\"4\"><strong>(......................)</strong></td>
					</tr>
				  </table>";
				 
		echo $html;
	}
	
	public function cetakmutasibarang_bak(){
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;Filename=mutasi_barang_".$_GET['bulan']."_".$_GET['tahun'].".xls");
		
		$html = "<table>
					<tr>
						<td colspan=\"5\"><strong>KOPERASI KARYAWAN KELUARGA BESAR PETROKIMIA GRESIK</strong></td>
						<td align=\"right\" colspan=\"3\"><strong>TGL. : ".date("d-m-Y H:i:s")."</strong></th>
					</tr>
					<tr>
						<td colspan=\"5\"><strong>K-Mart</strong></td>
						<td colspan=\"3\"></th>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"8\"><strong>LAPORAN SALDO BARANG GUDANG</strong></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"8\"><strong>PERIODE : ".$_GET['bulan']." - ".$_GET['tahun']."</strong></td>
					</tr>
				 </table>";
		
		$DataMutasiBarang = $this->laporan_model->getMutasiBarang($_GET);
		
		$jm_saldo_awal_kwt = 0;
		$jm_saldo_awal_hsat = 0;
		$jm_saldo_awal_hrg = 0;
		$jm_kwt_in = 0;
		$jm_hsat_in = 0;
		$jm_jm_hrg_in = 0;
		$jm_kwt_out = 0;
		$jm_kwt_out_tau = 0;
		$jm_hsat_out = 0;
		$jm_jm_hrg_out = 0;
		$jm_jm_hrg_out_tau = 0;
		$jm_saldo_akhir_kwt = 0;
		$jm_saldo_akhir_hsat = 0;
		$jm_saldo_akhir_hrg = 0;
		
		$main_title = "BARANG";
		
		$html .= "<table class=\"table table-striped table-bordered table-hover\">
					<thead>
						<tr>
							<th colspan=\"2\">".$main_title."</th>
							<th colspan=\"3\">SALDO AWAL</th>
							<th colspan=\"3\">".$main_title." MASUK</th>
							<th colspan=\"5\">".$main_title." KELUAR</th>
							<th colspan=\"3\">SALDO AKHIR</th>
						</tr>
						<tr>
							<th>KODE</th>
							<th>NAMA</th>
							<th>KWT</th>
							<th>HSAT</th>
							<th>JUMLAH</th>
							<th>KWT</th>
							<th>HSAT</th>
							<th>JUMLAH</th>
							<th>KWT</th>
							<th>KWT TAU</th>
							<th>HSAT</th>
							<th>JUMLAH</th>
							<th>JUMLAH TAU</th>
							<th>KWT</th>
							<th>HSAT</th>
							<th>JUMLAH</th>
						</tr>
					</thead>
					<tbody>";
		
		foreach ($DataMutasiBarang as $key => $value) {
			$kd_item = $value['barang_kode'];
			$nama_item = $value['nama_barang'];
			
			//$hrg_out = $value['kwt_out'] * $value['hsat_out'];
			//$hrg_out_tau = $value['kwt_out_tau'] * $value['hsat_out'];
			// if(($value['jumlah_saldo_awal'] != 0 && $value['jumlah_saldo_awal'] != "") || ($value['jumlah_in'] != 0 && $value['jumlah_in'] != "") || ($value['jumlah_out'] != 0 && $value['jumlah_out'] != "") || ($value['jumlah_tau_out'] != 0 && $value['jumlah_tau_out'] != "") || ($value['jumlah_saldo_akhir'] != 0 && $value['jumlah_saldo_akhir'] != "")){
				$html .= "<tr>
							<td>'".$kd_item."</td>
							<td>".$nama_item."</td>
							<td align=\"right\">".round($value['saldo_awal_kwt'],2)."</td>
							<td align=\"right\">".round($value['saldo_awal_hsat'],2)."</td>
							<td align=\"right\">".round($value['jumlah_saldo_awal'],2)."</td>
							<td align=\"right\">".round($value['kwt_in'],2)."</td>
							<td align=\"right\">".round($value['hsat_in'],2)."</td>
							<td align=\"right\">".round($value['jumlah_in'],2)."</td>
							<td align=\"right\">".round($value['kwt_out'],2)."</td>
							<td align=\"right\">".round($value['tau_out'],2)."</td>
							<td align=\"right\">".round($value['hsat_out'],2)."</td>
							<td align=\"right\">".round($value['jumlah_out'],2)."</td>
							<td align=\"right\">".round($value['jumlah_tau_out'],2)."</td>
							<td align=\"right\">".round($value['saldo_akhir_kwt'],2)."</td>
							<td align=\"right\">".round($value['saldo_akhir_hsat'],2)."</td>
							<td align=\"right\">".round($value['jumlah_saldo_akhir'],2)."</td>
						 </tr>";
						 
				$jm_saldo_awal_kwt += $value['saldo_awal_kwt'];
				$jm_saldo_awal_hsat += $value['saldo_awal_hsat'];
				$jm_saldo_awal_hrg += $value['jumlah_saldo_awal'];
				$jm_kwt_in += $value['kwt_in'];
				$jm_hsat_in += $value['hsat_in'];
				$jm_jm_hrg_in += $value['jumlah_in'];
				$jm_kwt_out += $value['kwt_out'];
				$jm_kwt_out_tau += $value['tau_out'];
				$jm_hsat_out += $value['hsat_out'];
				$jm_jm_hrg_out += $value['jumlah_out'];
				$jm_jm_hrg_out_tau += $value['jumlah_tau_out'];
				$jm_saldo_akhir_kwt += $value['saldo_akhir_kwt'];
				$jm_saldo_akhir_hsat += $value['saldo_akhir_hsat'];
				$jm_saldo_akhir_hrg += $value['jumlah_saldo_akhir'];
			// }
		}
		$html .= "<tr>
					<td colspan=\"2\">Total</td>
					<td align=\"right\">".round($jm_saldo_awal_kwt,2)."</td>
					<td align=\"right\">".round($jm_saldo_awal_hsat,2)."</td>
					<td align=\"right\">".round($jm_saldo_awal_hrg,2)."</td>
					<td align=\"right\">".round($jm_kwt_in,2)."</td>
					<td align=\"right\">".round($jm_hsat_in,2)."</td>
					<td align=\"right\">".round($jm_jm_hrg_in,2)."</td>
					<td align=\"right\">".round($jm_kwt_out,2)."</td>
					<td align=\"right\">".round($jm_kwt_out_tau,2)."</td>
					<td align=\"right\">".round($jm_hsat_out,2)."</td>
					<td align=\"right\">".round($jm_jm_hrg_out,2)."</td>
					<td align=\"right\">".round($jm_jm_hrg_out_tau,2)."</td>
					<td align=\"right\">".round($jm_saldo_akhir_kwt,2)."</td>
					<td align=\"right\">".round($jm_saldo_akhir_hsat,2)."</td>
					<td align=\"right\">".round($jm_saldo_akhir_hrg,2)."</td>
				 </tr>";
		$html .=    "
					</tbody>
				 </table>";
		$html .= "<table>
					<tr>
						<td align=\"center\" colspan=\"4\">Mengetahui</td>
						<td align=\"center\" colspan=\"4\">Yang membuat</td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"4\"></td>
						<td align=\"center\" colspan=\"4\"></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"4\"></td>
						<td align=\"center\" colspan=\"4\"></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"4\"></td>
						<td align=\"center\" colspan=\"4\"></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"4\"><strong>(......................)</strong></td>
						<td align=\"center\" colspan=\"4\"><strong>(......................)</strong></td>
					</tr>
				  </table>";
		echo $html;
	}
}