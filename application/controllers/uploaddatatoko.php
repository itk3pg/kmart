<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Uploaddatatoko extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		// $this->load->model('user_model');
		$this->load->model('syncdata_model');
	}
	
	public function index(){
		// $this->user_model->cekSession('');
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('uploaddatatoko');
		$this->load->view('general/footer');
	}
	
	public function generatefile(){
		$TextAll = "";
		if($_GET['mode'] == "all"){
			$dataKategoriBarang = $this->syncdata_model->getDataKategoriBarang();
			$dataBarang = $this->syncdata_model->getDataBarang();
			$dataPelanggan = $this->syncdata_model->getDataPelanggan();
			$dataToko = $this->syncdata_model->getDataToko();
			$dataGroup = $this->syncdata_model->getDataGroup();
			$dataUser = $this->syncdata_model->getDataUser($_GET);
			// Data pelanggan
			$dataHarga = $this->syncdata_model->getDataHargaBarangToko($_GET);
			$dataPromo = $this->syncdata_model->getDataPromo($_GET);
			$dataStok = $this->syncdata_model->getDataStokToko($_GET);
			
			$TextAll = $dataKategoriBarang."".$dataBarang."".$dataPelanggan."".$dataHarga."".$dataPromo."".$dataStok."".$dataToko."".$dataGroup."".$dataUser;
		}else if($_GET['mode'] == "master_barang"){
			$dataKategoriBarang = $this->syncdata_model->getDataKategoriBarang();
			$dataBarang = $this->syncdata_model->getDataBarang();
			$dataHarga = $this->syncdata_model->getDataHargaBarangToko($_GET);
			
			$TextAll = $dataKategoriBarang."".$dataBarang."".$dataHarga;
		}else if($_GET['mode'] == "master_pelanggan"){
			$dataPelanggan = $this->syncdata_model->getDataPelanggan();
			
			$TextAll = $dataPelanggan;
		}else if($_GET['mode'] == "user"){
			$dataGroup = $this->syncdata_model->getDataGroup();
			$dataUser = $this->syncdata_model->getDataUser($_GET);
			
			$TextAll = $dataGroup."".$dataUser;
		}else if($_GET['mode'] == "master_promo"){
			$dataPromo = $this->syncdata_model->getDataPromo($_GET);
			
			$TextAll = $dataPromo;
		}else if($_GET['mode'] == "master_akrindo"){
			$dataKategoriBarang = $this->syncdata_model->getDataKategoriBarang();
			$dataBarang = $this->syncdata_model->getDataBarang();
			$dataPelanggan = $this->syncdata_model->getDataPelanggan();
			
			// Data pelanggan
			$dataHarga = $this->syncdata_model->getDataHargaBarangToko($_GET);
			$dataStok = $this->syncdata_model->getDataStokToko($_GET);
			
			$TextAll = $dataKategoriBarang."".$dataBarang."".$dataPelanggan."".$dataHarga."".$dataStok;
		}else if($_GET['mode'] == "fix_data"){
			$queryInsert = "INSERT INTO `barang` (`kode`, `barcode`, `kategori`, `nama_barang`, `satuan`, `is_ppn`, `bkl`, `print`, `hpp`, `waktu_hpp`, `waktu_insert`, `waktu_update`, `is_hapus`, `user_id`, `is_aktif`) VALUES ('4902750320567', '4902750320567', 'POCKET CAN', 'PER.UHA CANDY STRAW 37GR', 'EA', '1', '0', 0, 9800, '2016-09-25 23:02:05', '2016-09-05 14:32:11', '2016-09-05 14:32:11', '1', '402', '1');";
			$queryUpdate1 = "update rst_fc_trans_detail a set a.fitemkey='4902750320567' where a.fitemkey='1473061038';";
			$queryUpdate2 = "update harga_barang_toko a set a.barang_kode='4902750320567' where a.barang_kode='1473061038';";
			$queryUpdate3 = "update saldo_barang_toko a set a.barang_kode='4902750320567' where a.barang_kode='1473061038';";
			$queryUpdate4 = "delete from barang kode='1473061038';";
			
			$TextAll = $queryInsert."".$queryUpdate1."".$queryUpdate2."".$queryUpdate3."".$queryUpdate4;
		}
		$Compressed = base64_encode(gzcompress($TextAll, 9));
		//$Uncompresses = gzuncompress(base64_decode($Compressed));
		//echo $Uncompresses;
		//exit;
		$output_dir = 'imports/';
		$namaFile = $output_dir.'toko'.$_GET['toko_kode'].date('Ymd').'.vmart';
		$handle = fopen($namaFile, "w");
		fwrite($handle, $Compressed);
		fclose($handle);

		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename='.basename($namaFile));
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($namaFile));
		readfile($namaFile);
		exit;
	}

	public function generatefilecommand(){
		$_GET['bulan'] = date('m');
		$_GET['tahun'] = date('Y');
 		$TextAll = "";
		$dataKategoriBarang = $this->syncdata_model->getDataKategoriBarang();
		$dataBarang = $this->syncdata_model->getDataBarang();
		$dataPelanggan = $this->syncdata_model->getDataPelanggan();
		//$dataToko = $this->syncdata_model->getDataToko();
		//$dataGroup = $this->syncdata_model->getDataGroup();
		//$dataUser = $this->syncdata_model->getDataUser();
		// Data pelanggan
		$dataHarga = $this->syncdata_model->getDataHargaBarangToko($_GET);
		$dataPromo = $this->syncdata_model->getDataPromo($_GET);
		$dataStok = $this->syncdata_model->getDataStokToko($_GET);
		
		$TextAll = $dataKategoriBarang."".$dataBarang."".$dataPelanggan."".$dataHarga."".$dataPromo."".$dataStok;
		$Compressed = base64_encode(gzcompress($TextAll, 9));
		//$Uncompresses = gzuncompress(base64_decode($Compressed));
		//echo $Uncompresses;
		//exit;
		$output_dir = 'imports/';
		$namaFile = $output_dir.'toko'.$_GET['toko_kode'].date('Ymd').'.vmart';
		$handle = fopen($namaFile, "w");
		fwrite($handle, $Compressed);
		fclose($handle);

		echo 'toko'.$_GET['toko_kode'].date('Ymd').'.vmart';
	}
}

?>