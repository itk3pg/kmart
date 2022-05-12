<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/ico" href="<?php echo base_url(); ?>images/favicon.ico">
    <title>Aplikasi Back Office Retail</title>

    <!-- Core CSS - Include with every page -->
    <link href="<?php echo base_url(); ?>css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Page-Level Plugin CSS - Dashboard -->
    <link href="<?php echo base_url(); ?>css/plugins/morris/morris-0.4.3.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/plugins/timeline/timeline.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/plugins/jconfirm/jconfirm.css" rel="stylesheet">

    <!-- SB Admin CSS - Include with every page -->
    <link href="<?php echo base_url(); ?>css/sb-admin.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/datepicker.css" rel="stylesheet">
    
    <link href="<?php echo base_url(); ?>css/plugins/select2/select2.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/plugins/select2/select2-bootstrap.css" rel="stylesheet">
    
    <!-- Page-Level Plugin CSS - Tables -->
    <link href="<?php echo base_url(); ?>css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
    
    <!-- Core Scripts - Include with every page -->
    <script src="<?php echo base_url(); ?>js/jquery-1.10.2.js"></script>
    <script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="<?php echo base_url(); ?>js/jquery.form.js"></script>
    
    <!-- SB Admin Scripts - Include with every page -->
    <script src="<?php echo base_url(); ?>js/sb-admin.js"></script>
    <script src="<?php echo base_url(); ?>js/bootstrap-datepicker.js"></script>
    
    <!-- Page-Level Plugin Scripts - Tables -->
    <script src="<?php echo base_url(); ?>js/plugins/dataTables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>js/plugins/dataTables/dataTables.bootstrap.js"></script>
    <script src="<?php echo base_url(); ?>js/plugins/select2/select2.min.js"></script>
    <script src="<?php echo base_url(); ?>js/plugins/jconfirm/jconfirmaction.jquery.js"></script>
    
    <script src="<?php echo base_url(); ?>js/plugins/phpjs/json_decode.js"></script>
	<script src="<?php echo base_url(); ?>js/plugins/phpjs/json_encode.js"></script>
    <script src="<?php echo base_url(); ?>js/plugins/phpjs/base64_encode.js"></script>
    <script src="<?php echo base_url(); ?>js/plugins/phpjs/base64_decode.js"></script>
    <script src="<?php echo base_url(); ?>js/plugins/phpjs/number_format.js"></script>
	<script src="<?php echo base_url(); ?>js/plugins/phpjs/rawurlencode.js"></script>
	<script src="<?php echo base_url(); ?>js/plugins/phpjs/round.js"></script>
    
    <script src="<?php echo base_url(); ?>js/jquery-sortable-lists.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/jscolor/jscolor.js"></script>
    <style type="text/css">
    	.clickable{color:#000;}
		.list-drag ul, .list-drag li { margin:0; padding:0; }
		.list-drag ul, .list-drag li { list-style-type:none; color:#fff; border:1px solid #3f3f3f; }
		.list-drag ul { padding:0px; background-color:#151515; }
		ul.sTree2 li, ul#sortableListsBase li { padding-left:50px; margin:5px; border:1px solid #3f3f3f; background-color:#3f3f3f; }
		.list-drag li div { padding:7px; background-color:#222; Nborder:1px solid #3f3f3f; }
		.red { background-color:#ff9999; }
		.blue { background-color:#aaaaff;}
		.green { background-color:#99ff99; }
		.gree2 { background-color:#bbffbb; }
		.yellow { background-color:#ff8; }
		.brown { background-color:#c26b2b; }
		.pT20 { padding-top:20px; }
		.pV10 { padding-top:10px; padding-bottom:10px; }
		.dN { display:none; }
		.zI1000 { z-index:1000; }
		.c1 { color:#b5e853; }
		.c2 { color:#63c0f5; }
		.c3 { color: #f77720; }
		.c4 { color: #888; }
		.bgC1 { background-color:#ccc; }
		.bgC2 { background-color:#ff8; }
		.small1 { font-size:0.8em; }
		.small2 { font-size:0.7em; }
		.small3 { font-size:0.6em; }
		.tAR { text-align:right; }
		.clear { clear:both; }
		img.descPicture { display:block; width:100%; margin:0 7px 30px 0; float:left; cursor:pointer; /*transition: all 0.5s ease;*/ }
		img.descPicture.descPictureClose { width:150px; }
		#sTree2 { margin:10px auto; }
	</style>
</head>

<body>

    <div id="wrapper">

        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <button status="tutup" id="button-toggle" style="float: left; margin-left: 5px; margin-top: 7px;" type="button" class="btn btn-outline btn-default"><i class="fa fa-align-justify"></i></button>
                <!-- <img src="<?php echo base_url(); ?>images/logokwsg.png" style="width: 80px; float: left; margin-left: 10px; padding: 5px;" /> -->
                <!-- <a class="navbar-brand" href="<?php echo base_url(); ?>index.php/home">KOPERASI KARYAWAN KELUARGA BESAR PETROKIMIA GRESIK (K3PG)</a> -->
                <!-- <img src="<?php echo base_url(); ?>images/vmart.png" style="width: 90px; float: left; margin-left: 10px; padding: 5px;" /> -->
                <a class="navbar-brand" href="<?php echo base_url(); ?>index.php/home">Aplikasi Back Office Retail</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <?php echo $this->session->userdata('nama')." (".$this->session->userdata('username').")"; ?> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="javascript:void(0)" onclick="$('#form-profile').modal('show');"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url(); ?>index.php/user/logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

        </nav>
        <!-- /.navbar-static-top -->
        <div class="modal fade" id="form-profile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        	<div class="modal-dialog modal-sm">
        		<div class="modal-content">
        			<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	        			<h4 class="modal-title" id="myModalLabel">User Profile</h4>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label>Nama Lengkap : </label>
							<input type="text" class="form-control" name="profile_nama" id="profile_nama" value="<?= $this->session->userdata('nama'); ?>"/>
						</div>
						<div class="form-group">
							<label>Username : </label>
							<input type="text" class="form-control" disabled="" name="profile_username" id="profile_username" value="<?= $this->session->userdata('username'); ?>"/>
						</div>
						<div class="form-group f_password">
							<label>Password : </label>
							<input type="password" value="password" class="form-control" disabled="" name="profile_password" id="profile_password"/>
						</div>
						<div class="form-group new_f_password" style="display: none;">
							<label>New Password : </label>
							<input type="password" class="form-control" name="new_profile_password" id="new_profile_password"/>
						</div>
						<div class="form-group btn-ganti" style="height: 15px;">
							<button id="btngantipass" style="float: right;" class="btn btn-primary" onclick="gantipassword(1)"><span class="glyphicon glyphicon-edit"></span>&nbsp;&nbsp;Ganti Password</button>
						</div>
						<div class="form-group btn-form" style="display: none; height: 15px;">
							<button id="btnsimpanpass" onclick="gantipassword(0)" style="float: right;" class="btn btn-primary" onclick="simpanpassword()"><span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;Batal</button>
							<button id="btnsimpanpass" style="float: right; margin-right: 10px;" class="btn btn-primary" onclick="simpanpassword()"><span class="glyphicon glyphicon-save"></span>&nbsp;&nbsp;Simpan</button>&nbsp;&nbsp;
						</div>
					</div>
        		</div>
        	</div>
        </div>
        <script>
        	$(document).ready(function(){
				var URL_Cur = document.URL;
				var mode = URL_Cur.split("/");
				
				var numIndex = mode.indexOf("index.php");

				if(mode[numIndex+1] == "laporan"){
					$("#laporan").attr("class", "active");
					var classm = $("#ullaporan").attr("class");
					$("#ullaporan").attr("class", classm+" in");
					$("#"+mode[numIndex+2]).attr("class", "active-menu");
					
					var LapPenjualan = ["penjualankreditanggota", "penjualankreditinstansi", "omzetppn", "omzethpp", "penjualanperbarang", "barangtidakterjual", "transaksipenjualan", "penjualanpelanggan", "detailpenjualanbulanan", "rekapbarangpenjualan", "promoaktif", "rekappenjualannonanggota"];
					var LapKasbank = ["mutasikasbank", "mutasicashbudget", "kaskecilmini"];
					var LapHutang = ["mutasihutang", "kartuhutang"];
					var LapPiutang = ["rekappiutanginstansi", "mutasipiutang", "rincianpiutang", "umurpiutang"];
					var LapPersediaan = ["mutasibarang", "saldobaranggudang", "hargabarangtoko", "perubahanharga", "databarangpos", "barangmasuk", "detailmutasibarang", "rekapretursupplier", "taukeluar", "analisapembeliantunai", "laporanpulsa", "databarangsupplier", "perubahanhargabeli"];
					var LapKonsinyasi = ["saldobarangkonsinyasi", "rekapitulasibarangkonsinyasi", "baranglakukonsinyasi"];
					
					if(LapPenjualan.indexOf(mode[numIndex+2]) >= 0){
						$("#lappenjualan").attr("class", "active");
						var classm = $("#lappenjualan ul").attr("class");
						$("#lappenjualan ul").attr("class", classm+" in");
					}else if(LapKasbank.indexOf(mode[numIndex+2]) >= 0){
						$("#lapkasbank").attr("class", "active");
						var classm = $("#lapkasbank ul").attr("class");
						$("#lapkasbank ul").attr("class", classm+" in");
					}else if(LapHutang.indexOf(mode[numIndex+2]) >= 0){
						$("#laphutang").attr("class", "active");
						var classm = $("#laphutang ul").attr("class");
						$("#laphutang ul").attr("class", classm+" in");
					}else if(LapPiutang.indexOf(mode[numIndex+2]) >= 0){
						$("#lappiutang").attr("class", "active");
						var classm = $("#lappiutang ul").attr("class");
						$("#lappiutang ul").attr("class", classm+" in");
					}else if(LapPersediaan.indexOf(mode[numIndex+2]) >= 0){
						$("#lappersediaan").attr("class", "active");
						var classm = $("#lappersediaan ul").attr("class");
						$("#lappersediaan ul").attr("class", classm+" in");
					}else if(LapKonsinyasi.indexOf(mode[numIndex+2]) >= 0){
						$("#lappersediaankonsinyasi").attr("class", "active");
						var classm = $("#lappersediaankonsinyasi ul").attr("class");
						$("#lappersediaankonsinyasi ul").attr("class", classm+" in");
					}
				}else if(mode[numIndex+1] == "jurnal"){
					$("#jurnal").attr("class", "active");
					var classm = $("#jurnal ul").attr("class");
					$("#jurnal ul").attr("class", classm+" in");
					$("#"+mode[numIndex+2]).attr("class", "active-menu");
				}else{
					$("#"+mode[numIndex+1]).attr("class", "active-menu");
					var mastermenu = ["kategoribarang", "tipepembayaran", "promo", "pelanggan", "supplier", 
					"toko", "barang", "m_kasbank", "m_cashbudget", "planogram", "minmax", "user", "m_bank", "m_alasanretur"];
					var transaksimenu = ["pembelianbarang", "returtoko", "retursupplier", "hutang", "tukarnota", "piutang", "kasbank", "ordertransfer", "orderpembelian", "pendapatanlain", "hutangpenyesuaian", "droppingkaskecil", "jatahairminum", 
					"transfergudang", "pemakaianbarang", "penjualannontunai", "permintaanpembayaran", "taukeluar", "taumasuk", "penjualan", "badstock", "transferbadstock", "stockopname"];
					var settingmenu = ["exportdbf", "sinkronisasi", "uploaddatatoko", "importdatatoko", "uploaddatapenjualan", "importdatapenjualan", "setstockopname", "gantibarcode"];
					var konsinyasimenu = ["pembelianbarangkonsinyasi", "transfergudangkonsinyasi", "retursupplierkonsinyasi", "returtokokonsinyasi", "taukeluarkonsinyasi"];
					if(mastermenu.indexOf(mode[numIndex+1]) >= 0){
						$("#master").attr("class", "active");
						
						var classm = $("#master ul").attr("class");
						$("#master ul").attr("class", classm+" in");
					}else if(transaksimenu.indexOf(mode[numIndex+1]) >= 0){
						$("#transaksi").attr("class", "active");
						
						var classm = $("#transaksi ul").attr("class");
						$("#transaksi ul").attr("class", classm+" in");
					}else if(settingmenu.indexOf(mode[numIndex+1]) >= 0){
						$("#setting").attr("class", "active");
						
						var classm = $("#setting ul").attr("class");
						$("#setting ul").attr("class", classm+" in");
					}else if(konsinyasimenu.indexOf(mode[numIndex+1]) >= 0){
						$("#konsinyasi").attr("class", "active");
						
						var classm = $("#konsinyasi ul").attr("class");
						$("#konsinyasi ul").attr("class", classm+" in");
					}
				}
			});
			
        	function gantipassword(mode){
        		if(mode == 0){ // cancel
					$('.f_password').show();
					$('.new_f_password').hide();
					$('.btn-ganti').show();
					$('.btn-form').hide();
				}else{ // edit password
					$('.f_password').hide();
					$('.new_f_password').show();
					$('.btn-ganti').hide();
					$('.btn-form').show();
				}
			}
			
			function setUpper(id){
				var content = $('#'+id).val();
				var res = content.toUpperCase();
				$('#'+id).val(res);
			}
			
			function simpanpassword(){
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>index.php/user/gantipassword",
					data: "username="+$('#profile_username').val()+"&nama="+$('#profile_nama').val()+"&password="+$('#new_profile_password').val(),
					success: function(msg){
						alert('Password berhasil disimpan');
						gantipassword(0);
					}
				});
			}
			
			function price(nmobjek){
				a = $('#'+nmobjek).val();
				b = a.replace(/[^\d,-]/g,"");
				// b = b.replace(".",",");
				posisimin = b.indexOf("-");
				
				b0 = "";
				b1 = "";
				b2 = "";
				if(posisimin > 0){
					b = b.replace('-', '');
					posisimin = -1;
				}else if(posisimin == 0){
					b0 = b.substring(0, 1);
				}
				posisikoma = b.indexOf(",");
				// console.log("setelah - :"+b);
				if(posisikoma == -1){
					posisikoma = b.length;
				}else{
					b2 = b.substring(posisikoma, b.length);
				}
				b1 = b.substring((posisimin+1), posisikoma);
				
				// console.log("b0 : "+b0);
				// console.log("b1 : "+b1);
				// console.log("b2 : "+b2);
				c = "";
				panjang = b1.length;
				j = 0;
				for (i = panjang; i > 0; i--) {
					j = j + 1;
					if (((j % 3) == 1) && (j != 1)) {
						c = b1.substr(i-1,1) + "." + c ;
					} else {
						c = b1.substr(i-1,1) + c;
					}
				}
				// console.log("komposisi : "+b0+" "+c+" "+b2)
				$('#'+nmobjek).val(b0+c+b2);
				//$('#'+nmobjek).val(number_format(a,2,",","."));
			}
			
			function price_js(nmobjek){
				a = $('#'+nmobjek).val();
				
				$('#'+nmobjek).val(number_format(a,2,",","."));
			}
			
			function removeCurrency(currency){
				var b = currency.replace(/\./g,'');
				b = b.replace(',','.');
				
				return b;
			}
			
			function removeCurrencyNormal(currency){
				b = currency.replace(/,/g,'');
				
				return b;
			}
			
			function toUpper(nama_id){
				var text = $("#"+nama_id).val();
				var textUpper = text.toUpperCase();
				
				$("#"+nama_id).val(textUpper);
			}
			
			// function ShowMessage(){
				// $(".message").html("<div class=\"alert alert-info alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>Data berhasil disimpan.</div>");
				// setTimeout(function(){ $(".message").html(""); }, 5000);
			// }
			
			function ShowMessage(kelas, pesan){
				$(".message").html("<div class=\"alert alert-"+kelas+" alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>"+pesan+"</div>");
				setTimeout(function(){ $(".message").html(""); }, 5000);
			}
        </script>