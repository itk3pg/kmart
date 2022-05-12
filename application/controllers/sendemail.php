<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sendemail extends CI_Controller {
	public function __construct(){
		parent::__construct();
	}
	
	public function index(){

	}
	
	public function send($file){
		$email = "";
		if (strpos($file, 'VO0001') !== false) {
		    $email = "vmartsegunting10@gmail.com";
		}
		if (strpos($file, 'VO0002') !== false) {
		    $email = "tokobogorejo@gmail.com";
		}
		if (strpos($file, 'VO0003') !== false) {
		    $email = "vmartgeluran@gmail.com";
		}
		if (strpos($file, 'VO0004') !== false) {
		    $email = "vmartgkb@gmail.com";
		}
		if (strpos($file, 'VO0005') !== false) {
		    $email = "vmartpanjunan@gmail.com";
		}
		//$email = "ikhwandeveloper@gmail.com";
		$this->load->library('email'); // load email library
	    $this->email->from('pusatinformasikwsg@gmail.com', 'Koperasi karyawan Keluarga Besar Petrokimia Gresik');
	    $this->email->to($email);
	    $this->email->cc('aprasetyo85@gmail.com'); 
	    $this->email->subject('Data Upload Toko');
	    $this->email->message('Data master untuk buka toko');
	    $this->email->attach('/var/www/vmart/imports/'.$file); // attach file
	    if ($this->email->send())
	        echo "Mail Sent to ".$email;
	    else
	        echo "There is error in sending mail!";
	}

	public function sendprivateemail(){
		//$email = "ikhwandeveloper@gmail.com";
		// print_r(json_decode(base64_decode($_GET['q']), true));exit;
		$ParamArray = json_decode(base64_decode($_GET['q']), true);

		$this->load->library('email'); // load email library
	    $this->email->from('pusatinformasikwsg@gmail.com', 'Admin KWSG');
	    $this->email->to($ParamArray['email_receiver']);
	    // $this->email->cc('aprasetyo85@gmail.com');
	    $this->email->subject('Approval SPPD & PJK SPPD');
	    $this->email->message($ParamArray['content']);
	    // $this->email->attach('/var/www/vmart/imports/'.$file); // attach file
	    if ($this->email->send())
	        echo "Mail Sent to ".$ParamArray['email_receiver'];
	    else
	        echo "There is error in sending mail!";
	}
}