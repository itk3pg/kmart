<div id="page-wrapper">
	<div class="row">
	    <div class="col-lg-12">
	        <h1 style="margin-top: 15px;" class="page-header">Master Menu</h1>
	    </div>
	    <!-- /.col-lg-12 -->
	</div>
	<div class="row">
		<div class="col-lg-8">
			<div class="panel panel-default">
				<div class="panel-heading">
					<button id="btn_upload" onclick="openFormMenu(1)" class="btn btn-info btn-sm" type="button">
						<i class="fa fa-plus"></i>
						&nbsp;&nbsp;Tambah
					</button>
					<button id="btn_upload" onclick="openFormEditMenu()" class="btn btn-success btn-sm" type="button">
						<i class="fa fa-edit"></i>
						&nbsp;&nbsp;Edit
					</button>
					<button id="btn_upload" fungsi="HapusMenu()" class="btn btn-danger btn-sm ask-menu" type="button">
						<i class="fa fa-times"></i>
						&nbsp;&nbsp;Hapus
					</button>
					<button id="btn_upload" fungsi="DuplicateMenu()" class="btn btn-info btn-sm ask-menu" type="button">
						<i class="fa fa-times"></i>
						&nbsp;&nbsp;Duplicate
					</button>
					<div id="progres-main" style="width: 150px; float: right; display: none;">
						<div class="progress progress-striped active">
							<div class="progress-bar progress-bar-info" style="width: 100%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="20" role="progressbar">
								<span class="sr-only">20% Complete</span>
							</div>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<div class="table-responsive table-menu">
						
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-4">
			<div id="info_gambar">
				<img id="gambar_view" src="<?= base_url(); ?>images/default.jpg" style="width: 150px; margin-bottom: 10px;" />
				<div id="color_text_view" style="height: 50px; width:50px; float:right; background-color:#fff;" ></div>
			</div>
			<table id="form-bom" style="display: none; margin-bottom: 10px;" width="100%">
				<tr class="menu_biasa">
					<td style="padding: 10px;">
						<input type="hidden" name="bom_barang" id="bom_barang" style="width: 100%" />
					</td>
				</tr>
				<tr class="menu_biasa">
					<td style="padding: 10px;">Takaran <input id="bom_takaran" style="width: 100px; display: inline;" type="text" class="form-control" /> <label id="bom_satuan_terkecil">Satuan</label></td>
				</tr>
				<tr class="menu_paket">
					<td style="padding: 10px;"><input type="text" name="bom_menu" id="bom_menu" style="width: 100%" /></td>
				</tr>
				<tr class="menu_paket">
					<td style="padding: 10px;">Jumlah : <input type="text" name="bom_kwt" id="bom_kwt" class="form-control" style="width: 100px; display: inline; text-align:right;" /></td>
				</tr>
				<tr>
					<td align="right">
						<button id="btn_upload" onclick="CancelBom()" class="btn btn-warning btn-sm" type="button">
							<i class="fa fa-times"></i>
							&nbsp;&nbsp;Cancel
						</button>
						<button id="btn_upload" onclick="SimpanBom()" class="btn btn-success btn-sm" type="button">
							<i class="fa fa-edit"></i>
							&nbsp;&nbsp;Simpan
						</button>
					</td>
				</tr>
			</table>
			<div class="panel panel-default">
				<div class="panel-heading">
					BOM
					<button id="btn_upload" style="float: right; margin-left: 5px; margin-top: -5px;" fungsi="HapusBom()" class="btn btn-danger btn-sm ask-bom" type="button">
						<i class="fa fa-minus"></i>
					</button>
					<button id="btn_upload" style="float: right; margin-top: -5px;" onclick="openFormBom(1)" class="btn btn-info btn-sm" type="button">
						<i class="fa fa-plus"></i>
					</button>
				</div>
				<div class="panel-body">
					<div class="table-responsive table-bom">
						
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Form popup untuk tambah menu -->
	<div class="modal fade" id="form-menu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        			<h4 class="modal-title" id="myModalLabel">Form Menu</h4>
				</div>
				<div class="modal-body">
					<form name="multiform" id="multiform" action="<?= base_url() ?>index.php/menu/simpanmenu" method="POST" enctype="multipart/form-data">
					<table>
						<tr>
							<td valign="top">
								Kode Menu :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<input type="checkbox" checked name="menu_otomatis" onclick="cekOtomatis()" id="menu_otomatis" /> Otomatis
									<input type="hidden" name="menu_mode" id="menu_mode" value="i" />
									<input type="text" placeholder="Kode Menu" readonly name="menu_kode" id="menu_kode" class="form-control">
								</div>
								Tipe Menu :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<select class="form-control" name="menu_tipe" id="menu_tipe">
										<option value="0">Menu Biasa</option>
										<option value="1">Menu Paket</option>
									</select>
								</div>
								Nama Menu :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<input type="text" placeholder="Nama Menu" name="menu_nama_menu" id="menu_nama_menu" class="form-control">
								</div>
								Nama Cetak :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<input type="text" placeholder="Nama Cetak" name="menu_nama_cetak" id="menu_nama_cetak" class="form-control">
								</div>
								File Gambar
								<div style="position:relative;">
									<a class='btn btn-primary' href='javascript:;'>
										Choose File...
										<input type="file" style='position:absolute;z-index:2;top:0;left:0;filter: alpha(opacity=0);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";opacity:0;background-color:transparent;color:transparent;' name="menu_gambar" id="menu_gambar" size="40"  onchange='$("#upload-file-info").html($(this).val());'>
									</a>
									&nbsp;
									<span class='label label-info' id="upload-file-info"></span>
								</div>
							</td>
							<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
							<td valign="top">
								Warna Tulisan
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<input type="text" placeholder="Warna Text" name="menu_color_text" id="menu_color_text" class="form-control color">
								</div>
								Kategori :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<input type="text" readonly placeholder="Kategori Menu" name="menu_kategori_menu" id="menu_kategori_menu" class="form-control">
									<input type="hidden" name="menu_kode_kategori" id="menu_kode_kategori" class="form-control">
									<span onclick="OpenPilihKategori()" style="background-color: #5bc0de; cursor: pointer;" class="input-group-addon">
										<i class="fa fa-plus"></i>
									</span>
								</div>
								Harga : 
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-money"></i>
									</span>
									<input type="text" style="text-align: right;" onkeyup="price('menu_harga'); HitungPajak();" placeholder="Harga jual" name="menu_harga" id="menu_harga" class="form-control">
								</div>
								PPn : 
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-money"></i>
									</span>
									<input type="checkbox" checked name="menu_is_ppn" onclick="HitungPajak()" id="menu_is_ppn" /> Memakai PPn
									<input type="text" readonly style="text-align: right;" name="menu_ppn" id="menu_ppn" class="form-control">
								</div>
								Untuk Kitchen :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<select class="form-control" name="menu_kitchen" id="menu_kitchen">
										
									</select>
								</div>
							</td>
						</tr>
					</table>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" onclick="clearForm(1)" class="btn btn-default">Reset</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<img src="<?= base_url() ?>images/loader.gif" id="loader-form"  style="width: 30px; display: none;" />
			        <button type="button" id="btn-simpan" onclick="simpanmenu()" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;&nbsp;Simpan</button>
				</div>
			</div>
		</div>
	</div>
	<!-- Form popup untuk pilih kategori menu -->
	<div class="modal fade" id="list-kategori" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        			<h4 class="modal-title" id="myModalLabel">Kategori Menu</h4>
				</div>
				<div class="modal-body modal-kategori">
					
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		OpenMenu();
		LoadDataMenu();
		
		loadKategoriMenu();
		loadListKitchen();
		
		LoadListDataBarang();
		LoadListDataMenu();
		$('.ask-menu').jConfirmAction();
		$('.ask-bom').jConfirmAction();
		$("#multiform").submit(function(e){
			var formObj = $(this);
			var formURL = formObj.attr("action");
			var formData = new FormData(this);
			$.ajax({
				url: formURL,
				type: 'POST',
				data:  formData,
				mimeType:"multipart/form-data",
				contentType: false,
				cache: false,
				processData:false,
				success: function(data, textStatus, jqXHR){
					LoadDataMenu();
					$("#loader-form").hide();
					$("#btn-simpan").show();
					$("#menu_mode").val("i");
					$('#form-menu').modal('hide');
				},
				error: function(jqXHR, textStatus, errorThrown){
					alert(textStatus);
					$("#loader-form").hide();
					$("#btn-simpan").show();
				}
			});
			e.preventDefault();
			//e.unbind();
		});
	});
	
	function LoadListDataBarang(){
	    $("#bom_barang").select2({
		    placeholder: "Cari bahan baku",
		    minimumInputLength: 1,
			multiple: true,
		    ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
			    url: "<?php echo base_url(); ?>index.php/barang/getlistbarang",
			    dataType: 'json',
			    quietMillis: 250,
			    data: function (term, page) {
				    return {
				    	q: term, // search term
				    };
			    },
			    results: function (data, page) { // parse the results into the format expected by Select2.
			    	// since we are using custom formatting functions we do not need to alter the remote JSON data
			    	return { results: data.items };
			    },
			    cache: true
		    },
		    id: function(option){
		    	return option.kode;
		    },
		    formatResult: function (option) {
            	return "<span class=\"select2-match\"></span>"+option.nama_barang;
            }, 
		    formatSelection: function (option) {
            	return option.nama_barang;
            }
	    });
	    
	    $("#bom_barang").on("select2-selecting", function(e) {
	    	// dataperlang = e;
	    	// alert ("selecting val="+ e.choice.satuan_terkecil +" choice="+ JSON.stringify(e.choice));
	    	$("#bom_satuan_terkecil").html(e.choice.nama_satuan_terkecil);
	    });
	}
	
	function LoadListDataMenu(){
	    $("#bom_menu").select2({
		    placeholder: "Cari menu",
		    minimumInputLength: 1,
		    ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
			    url: "<?php echo base_url(); ?>index.php/menu/getlistmenu",
			    dataType: 'json',
			    quietMillis: 250,
			    data: function (term, page) {
				    return {
				    	q: term, // search term
				    };
			    },
			    results: function (data, page) { // parse the results into the format expected by Select2.
			    	// since we are using custom formatting functions we do not need to alter the remote JSON data
			    	return { results: data.items };
			    },
			    cache: true
		    },
		    id: function(option){
		    	return option.kode;
		    },
		    formatResult: function (option) {
            	return "<span class=\"select2-match\"></span>"+option.nama_menu;
            }, 
		    formatSelection: function (option) {
            	return option.nama_menu;
            }
	    });
	}
	
	function LoadDataMenu(){
		$('#progres-main').show();
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/menu/getdatamenu",
			data: "",
			success: function(msg){
				$(".table-menu").html(msg);
				table = $('#dataTables-menu').dataTable();
				$('#progres-main').hide();
				
				$('#dataTables-menu tbody').on( 'click', 'tr', function () {
			        if ( $(this).hasClass('active') ) {
			            $(this).removeClass('active');
			        }else {
			            table.$('tr.active').removeClass('active');
			            $(this).addClass('active');
			        }
			        LoadDataBom();
			    } );
			}
		});
	}
	
	function LoadDataBom(){
		var data = table.$('tr.active').attr("data");
		if(typeof data == "undefined"){
			$(".table-bom").html("Pilih salah satu menu");
			
			$("#gambar_view").attr("src", "");
			$("#color_text_view").attr("style", "");
		}else{
			$('#progres-main').show();
			var dataArr = json_decode(base64_decode(data));
			
			if(dataArr['is_paket'] == "0"){
				$(".menu_biasa").show();
				$(".menu_paket").hide();
			}else{
				$(".menu_biasa").hide();
				$(".menu_paket").show();
			}
			if(dataArr['gambar'] == null || dataArr['gambar'] == ""){
				$("#gambar_view").attr("src", "<?= base_url() ?>images/default.jpg");
			}else{
				$("#gambar_view").attr("src", "<?= base_url() ?>gambar_menu/"+dataArr['gambar']);
			}
			$("#color_text_view").attr("style", "height: 50px; width:50px; float:right; background-color:#"+dataArr['color_text']+";");
			$.ajax({
				type: "POST",
				url: "<?= base_url() ?>index.php/menu/getdatabom",
				data: "menu_kode="+dataArr['kode']+"&is_paket="+dataArr['is_paket'],
				success: function(msg){
					$(".table-bom").html(msg);
					$('#progres-main').hide();
				}
			});
		}
	}
	
	function openFormMenu(mode){
		$('#form-menu').modal('show');
		var ts = Math.round((new Date()).getTime() / 1000);
		$("#menu_kode").val(ts);
		$("#menu_mode").val("i");
	}
	
	function cekOtomatis(){
		if($("#menu_mode").val() == "i"){
			if($("#menu_otomatis").is(':checked')){
				var ts = Math.round((new Date()).getTime() / 1000);
				$("#menu_kode").val(ts);
				$("#menu_kode").attr("readonly","readonly");
			}else{
				$("#menu_kode").removeAttr("readonly");
				$("#menu_kode").val("");
			}
		}
	}
	
	function loadKategoriMenu(){
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/kategorimenu/getlistkategoriform",
			data: "",
			success: function(msg){
				$(".modal-kategori").html(msg);
			}
		});
	}
	
	function loadListKitchen(){
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/kitchen/getListKitchen",
			data: "",
			success: function(msg){
				$("#menu_kitchen").html(msg);
			}
		});
	}
	
	function OpenPilihKategori(){
		$('#list-kategori').modal('show');
	}
	
	function PilihKategori(kode, nama){
		$("#menu_kategori_menu").val(nama);
		$("#menu_kode_kategori").val(kode);
		
		$('#list-kategori').modal('hide');
	}
	
	function HitungPajak(){
		if($("#menu_is_ppn").is(':checked')){
			var harga = removeCurrency($("#menu_harga").val());
			var ppn = harga * 0.1;
			
			$("#menu_ppn").val(ppn);
			price("menu_ppn");
		}else{
			$("#menu_ppn").val("0");
		}
	}
	
	function simpanmenu(){
		$("#loader-form").show();
		$("#btn-simpan").hide();
		$("#multiform").submit();
		/*var kode = $("#menu_kode").val();
		var is_paket = $("#menu_tipe").val();
		var nama_menu = $("#menu_nama_menu").val();
		var nama_cetak = $("#menu_nama_cetak").val();
		var kategori = $("#menu_kode_kategori").val();
		var harga = removeCurrency($("#menu_harga").val());
		var ppn = removeCurrency($("#menu_ppn").val());
		var kitchen = $("#menu_kitchen").val();
		var color_text = $("#menu_color_text").val();
		var gambar = $("#menu_gambar").val();
		// alert(gambar);
		// return;
		
		var mode_form = $("#menu_mode").val();
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/menu/simpanmenu",
			data: "kode="+kode+"&is_paket="+is_paket+"&nama_menu="+nama_menu+"&nama_cetak="+nama_cetak+"&kategori="+kategori+"&harga="+harga+"&ppn="+ppn+"&kitchen_kode="+kitchen+"&mode="+mode_form,
			success: function(msg){
				LoadDataMenu();
				$("#loader-form").hide();
				$("#btn-simpan").show();
				$("#menu_mode").val("i");
				$('#form-menu').modal('hide');
			}
		});*/
	}
	
	function openFormEditMenu(){
		var data = table.$('tr.active').attr("data");
		if(typeof data == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var dataArr = json_decode(base64_decode(data));
			
			$("#menu_kode").val(dataArr['kode']);
			$("#menu_tipe").val(dataArr['is_paket']);
			$("#menu_nama_menu").val(dataArr['nama_menu']);
			$("#menu_nama_cetak").val(dataArr['nama_cetak']);
			$("#menu_kode_kategori").val(dataArr['kategori']);
			$("#menu_kategori_menu").val(dataArr['nama_kategori']);
			$("#menu_color_text").val(dataArr['color_text']);
			$("#menu_harga").val(dataArr['harga']);
			$("#menu_ppn").val(dataArr['ppn']);
			$("#menu_kitchen").val(dataArr['kode_kitchen']);
		
			price("menu_harga");
			price("menu_ppn");
			
			$("#menu_mode").val("e");
			$("#menu_kode").attr("readonly","readonly");
			$('#form-menu').modal('show');
		}
	}
	
	function HapusMenu(){
		var data = table.$('tr.active').attr("data");
		if(typeof data == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var dataArr = json_decode(base64_decode(data));
		
			$.ajax({
				type: "POST",
				url: "<?= base_url() ?>index.php/menu/hapusmenu",
				data: "kode="+dataArr['kode'],
				success: function(msg){
					LoadDataMenu();
				}
			});
		}
	}
	
	function clearForm(mode){
		var ts = Math.round((new Date()).getTime() / 1000);
		
		$("#menu_kode").val(ts);
		$("#menu_tipe").val("");
		$("#menu_nama_menu").val("");
		$("#menu_nama_cetak").val("");
		$("#menu_kode_kategori").val("");
		$("#menu_kategori_menu").val("");
		$("#menu_harga").val("0");
		$("#menu_ppn").val("0");
		$("#menu_kitchen").val("");
		
		$("#menu_mode").val("i");
	}
	
	function openFormBom(mode){
		$("#form-bom").show("medium");
	}
	
	function CancelBom(){
		$("#form-bom").hide("medium");
		clearFormBom();
	}
	
	function SimpanBom(){
		var data = table.$('tr.active').attr("data");
		if(typeof data == "undefined"){
			alert("Silahkan pilih salah satu menu");
		}else{
			var dataArr = json_decode(base64_decode(data));
		
			$.ajax({
				type: "POST",
				url: "<?= base_url() ?>index.php/menu/simpanbom",
				data: "menu_kode="+dataArr['kode']+"&barang_kode="+$("#bom_barang").val()+"&takaran="+$("#bom_takaran").val()+"&detail_menu_kode="+$("#bom_menu").val()+"&kwt="+$("#bom_kwt").val()+"&is_paket="+dataArr['is_paket'],
				success: function(msg){
					LoadDataBom();
					$("#form-bom").hide("medium");
					clearFormBom();
				}
			});
		}
	}
	
	function clearFormBom(){
		$("#bom_menu").val("");
		$("#bom_takaran").val("");
		$("#bom_barang").val("");
		$("#bom_kwt").val("");
	}
	
	function HapusBom(){
		$("#loader-form").show();
		var ObjCheckBom = $("#check_item:checked");
		
		var param = "";
		for(var i=0;i<ObjCheckBom.length;i++){
			param += "&data"+i+"="+ObjCheckBom[i].value;
		}
		
		if(param != ""){
			var data = table.$('tr.active').attr("data");
			var dataArr = json_decode(base64_decode(data));
			
			$.ajax({
				type: "POST",
				url: "<?= base_url() ?>index.php/menu/hapusbom",
				data: "is_paket="+dataArr['is_paket']+param+"&jumlahdata="+ObjCheckBom.length,
				success: function(msg){
					LoadDataBom();
				}
			});
		}
	}
	
	function DuplicateMenu(){
		var data = table.$('tr.active').attr("data");
		if(typeof data == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var dataArr = json_decode(base64_decode(data));
			var ts = Math.round((new Date()).getTime() / 1000);
			$.ajax({
				type: "POST",
				url: "<?= base_url() ?>index.php/menu/duplicatemenu",
				data: "kode="+dataArr['kode']+"&is_paket="+dataArr['is_paket']+"&kode_ganti="+ts,
				success: function(msg){
					LoadDataMenu();
					LoadDataBom();
				}
			});
		}
	}
</script>