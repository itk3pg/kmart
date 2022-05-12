<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
ini_set('max_execution_time', 0);
class Sinkronisasi extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('syncsaldo_model');
		$this->load->model('toko_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$DataToko = $this->toko_model->getAllDataToko();
		$Param  = array();
		$Param['DataToko'] = $DataToko;
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('sinkronisasi', $Param);
		$this->load->view('general/footer');
	}
	
	public function syncsaldo(){
		switch($_GET['mode']){
			case "barang_gudang" :
				$this->syncsaldo_model->SyncSaldoBarangGudangSpesifik($_GET);
				break;
			case "barang_gudang_konsinyasi" :
				$this->syncsaldo_model->SyncSaldoBarangTokoKonsinyasiSpesifik($_GET);
				break;
			case "barang_gudang_utama" :
				$this->syncsaldo_model->SyncSaldoBarangGudangUtamaSpesifik($_GET);
				break;
			case "barang" :
				$this->syncsaldo_model->SyncSaldoBarang($_GET);
				break;
			case "saldo_awal" :
				$this->syncsaldo_model->SyncSaldoAwalBarang($_GET);
				break;
			case "anggota" :
				$this->syncsaldo_model->SyncAnggota();
				break;
			case "hargajual" :
				$this->syncsaldo_model->SyncHargaJualHpp($_GET);
				break;
		}
	}
}

?>