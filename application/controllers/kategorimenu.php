<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kategorimenu extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('kategorimenu_model');
	}
	
	public function index(){
		$this->user_model->cekSession('');
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('master/kategorimenu');
		$this->load->view('general/footer');
	}
	
	public function getlistkategori(){
		echo "<ul class=\"sTree2\" id=\"sTree2\">";
		$this->getsubkategori("", "");
		echo "</ul>";
	}
	
	function getsubkategori($kode, $nama){
		$data = $this->kategorimenu_model->getChild($kode);
		
		if(sizeof($data) > 0){
			if($kode != ""){
				echo "<li class=\"sortableListsOpen\" id=\"item_a\" data-module=\"".$kode."\">
						<div>".$nama."
							<button class=\"clickable\" id=\"btn_hapus\" onclick=\"HapusKategori('".$kode."')\" style=\"float: right;\" class=\"btn btn-danger btn-xs\" type=\"button\">
								<i class=\"fa fa-times\"></i>
							</button>
							<button class=\"clickable\" id=\"btn_edit\" onclick=\"EditKategori('".$kode."','".$nama."')\" style=\"float: right; margin-right:5px;\" class=\"btn btn-success btn-xs\" type=\"button\">
								<i class=\"fa fa-edit\"></i>
							</button>
						</div>
						<ul class=\"\">";
			}
			foreach ($data as $key => $value) {
				$this->getsubkategori($value['kode'], $value['nama']);
			}
			if($kode != ""){
				echo "</ul>
					</li>";
			}
		}else{
			if($kode != ""){
				echo "<li id=\"item_a\" data-module=\"".$kode."\">
						<div>".$nama." 
							<button class=\"clickable\" id=\"btn_hapus\" onclick=\"HapusKategori('".$kode."')\" style=\"float: right;\" class=\"btn btn-danger btn-xs\" type=\"button\">
								<i class=\"fa fa-times\"></i>
							</button>
							<button class=\"clickable\" id=\"btn_edit\" onclick=\"EditKategori('".$kode."','".$nama."')\" style=\"float: right; margin-right:5px;\" class=\"btn btn-success btn-xs\" type=\"button\">
								<i class=\"fa fa-edit\"></i>
							</button>
						</div>
					</li>";
			}
		}
	}

	public function getlistkategoriform(){
		echo "<ul>";
		$this->getsubkategoriform("", "");
		echo "</ul>";
	}
	
	function getsubkategoriform($kode, $nama){
		$data = $this->kategorimenu_model->getChild($kode);
		
		if(sizeof($data) > 0){
			if($kode != ""){
				echo "<li>
						<div>".$nama."
							<!--<button id=\"btn_pilih\" onclick=\"PilihKategori('".$kode."','".$nama."')\" class=\"btn btn-success btn-xs\" type=\"button\">
								<i class=\"fa fa-check\"></i>
							</button>-->
						</div>
						<ul>";
			}
			foreach ($data as $key => $value) {
				$this->getsubkategoriform($value['kode'], $value['nama']);
			}
			if($kode != ""){
				echo "</ul>
					</li>";
			}
		}else{
			if($kode != ""){
				echo "<li>
						<div>".$nama." 
							<button id=\"btn_pilih\" onclick=\"PilihKategori('".$kode."','".$nama."')\" class=\"btn btn-success btn-xs\" type=\"button\">
								<i class=\"fa fa-check\"></i>
							</button>
						</div>
					</li>";
			}
		}
	}
	
	public function simpankategori(){
		$this->kategorimenu_model->simpankategori($_POST);
	}
	
	public function setparent(){
		$this->kategorimenu_model->setparent($_POST);
	}
	
	public function hapuskategori(){
		$this->kategorimenu_model->HapusKategori($_POST);
	}
}

?>