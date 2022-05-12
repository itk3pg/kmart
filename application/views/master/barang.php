<div id="page-wrapper">
	<div class="row">
	    <div class="col-lg-12">
	        <h1 style="margin-top: 15px;" class="page-header">Master Barang</h1>
	    </div>
	    <!-- /.col-lg-12 -->
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<table width="100%">
						<tr>
							<td width="50%">
								<button id="btn_upload" onclick="openFormBarang()" class="btn btn-info btn-sm" type="button">
									<i class="fa fa-plus"></i>
									&nbsp;&nbsp;Tambah
								</button>
								<button id="btn_upload" onclick="openFormEditBarang()" class="btn btn-success btn-sm" type="button">
									<i class="fa fa-edit"></i>
									&nbsp;&nbsp;Edit
								</button>
								<button id="btn_upload" fungsi="HapusBarang()" class="btn btn-danger btn-sm ask-barang" type="button">
									<i class="fa fa-times"></i>
									&nbsp;&nbsp;Hapus
								</button>
								<button id="btn_upload" fungsi="TidakAktifBarang()" class="btn btn-warning btn-sm ask-barang" type="button">
									<i class="fa fa-times"></i>
									&nbsp;&nbsp;Tidak Aktif
								</button>
								<button id="btn_upload" fungsi="AktifkanBarang()" class="btn btn-success btn-sm ask-barang" type="button">
									<i class="fa fa-check"></i>
									&nbsp;&nbsp;Aktifkan
								</button>
								<!-- <button id="btn_upload" onclick="openFormImportHarga()" class="btn btn-warning btn-sm" type="button">
									<i class="fa fa-edit"></i>
									&nbsp;&nbsp;Import Harga Jual
								</button> -->
								<!-- <button id="btn_upload" onclick="openFormSetSupplier()" class="btn btn-warning btn-sm" type="button">
									<i class="fa fa-edit"></i>
									&nbsp;&nbsp;Harga Beli
								</button> -->
								<button id="btn_upload" onclick="openFormSetToko()" class="btn btn-info btn-sm" type="button">
									<i class="fa fa-edit"></i>
									&nbsp;&nbsp;Margin Harga Jual
								</button>
							</td>
							<td>
								<button id="btn_upload" style="float: right; padding: 7px 11px" onclick="FirstLoadDataBarang()" class="btn btn-success btn-sm" type="button">
									<i class="fa fa-search"></i>
								</button>
								<input style="width: 150px; float: right;" type="text" onkeypress="runScript(event)" name="cari_barang" id="cari_barang" class="form-control" />
								<select name="cari_kategori" style="float: right; width: 200px;" id="cari_kategori" class="form-control">
										
								</select>
								<select name="mode_is_aktif" style="float: right; width: 100px;" id="mode_is_aktif" class="form-control">
										<option value="1">Aktif</option>
										<option value="0">Non Aktif</option>
								</select>
								<select name="mode_urut" style="float: right; width: 200px;" id="mode_urut" class="form-control">
										<option value="">Urut Berdasarkan</option>
										<option value="nama_barang">Nama Barang</option>
										<option value="kode">Kode Barang</option>
								</select>
							</td>
						</tr>
					</table>
					<div id="progres-main" style="width: 150px; float: right; display: none;">
						<div class="progress progress-striped active">
							<div class="progress-bar progress-bar-info" style="width: 100%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="20" role="progressbar">
								<span class="sr-only">20% Complete</span>
							</div>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<table width="100%" style="margin-bottom: 10px;">
						<tr>
							<td style="width: 90px;">
								Halaman ke :
							</td>
							<td style="width: 70px;" id="halaman_ke">1</td>
							<td>
								<button id="btn_next" style="float: right; margin-left: 10px;" onclick="NextDataBarang()" class="btn btn-success btn-sm" type="button">
									<i class="fa fa-arrow-right"></i>
								</button>
								<button id="btn_next" style="float: right;" onclick="PreviousDataBarang()" class="btn btn-success btn-sm" type="button">
									<i class="fa fa-arrow-left"></i>
								</button>
							</td>
						</tr>
					</table>
					<div class="table-responsive table-barang">
						<table class="table table-striped table-bordered table-hover" id="dataTables-barang">
							<thead>
								<tr>
									<th>KODE BARANG</th>
									<th>BARCODE</th>
									<th>NAMA BARANG</th>
									<th>KODE KATEGORI</th>
									<th>KATEGORI</th>
									<th>SATUAN</th>
									<th>HPP</th>
									<th>BKP</th>
									<th>BKL</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Form popup untuk tambah barang -->
	<div class="modal fade" id="form-barang" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        			<h4 class="modal-title" id="myModalLabel">Form Barang</h4>
				</div>
				<div class="modal-body">
					<table>
						<tr>
							<td width='48%' valign='top'>
								Kategori :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<select name="barang_kode_kategori" style="width: 230px;" id="barang_kode_kategori" class="form-control">
										
									</select>
									<!--<input type="text" readonly placeholder="Kategori Barang" name="barang_kategori_barang" id="barang_kategori_barang" class="form-control">
									<input type="hidden" name="barang_kode_kategori" id="barang_kode_kategori" class="form-control">
									<span onclick="OpenPilihKategori()" style="background-color: #5bc0de; cursor: pointer;" class="input-group-addon">
										<i class="fa fa-plus"></i>
									</span>-->
								</div>
								Kode Barang :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<input type="hidden" name="barang_mode" id="barang_mode" value="i" />
									<input type="text" readonly name="barang_kd_barang" id="barang_kd_barang" class="form-control">
								</div>
								<div class="checkbox">
									<label>
										<input type="checkbox" name="barang_is_ppn" id="barang_is_ppn" checked="checked" /> BKP
									</label>
								</div>
								<div class="checkbox">
									<label>
										<input type="checkbox" name="barang_is_bkl" id="barang_is_bkl" /> BKL
									</label>
								</div>
								<div class="checkbox">
									<label>
										<input type="checkbox" name="barang_is_aktif" id="barang_is_aktif" checked="checked" /> Aktif
									</label>
								</div>
								Barcode :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<input type="text" placeholder="Barcode" name="barang_barcode" id="barang_barcode" class="form-control">
								</div>
								Nama Barang :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<input type="text" placeholder="Nama Barang" onkeyup="toUpper('barang_nama_barang')" name="barang_nama_barang" id="barang_nama_barang" class="form-control">
								</div>
								
								Margin Harga Jual (%) :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<input type="text" readonly name="barang_margin" id="barang_margin" class="form-control">
								</div>
								Satuan :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<input type="text" placeholder="Satuan" onkeyup="toUpper('barang_satuan')" name="barang_satuan" id="barang_satuan" class="form-control">
								</div>
							</td>
							<td width='4%'></td>
							<td width='48%' valign='top'>
								Supplier :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<select class="form-control" name="barang_supplier" id="barang_supplier">
										<option value="-1">Pilih Supplier</option>
									</select>
								</div>
								Harga Beli Terakhir :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-money"></i>
									</span>
									<input type="text" style="text-align:right;" onkeyup="HitungHargaJual()" value="0" name="barang_harga_terakhir" id="barang_harga_terakhir" class="form-control">
								</div>
								<!--Average HPP :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-money"></i>
									</span>
									<input type="text" style="text-align:right;" value="0" readonly name="barang_average_hpp" id="barang_average_hpp" class="form-control">
								</div>-->
								Harga Jual Barang :
								<table id="form_harga_toko">
								</table>
							</td>
						</tr>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" onclick="clearForm(1)" class="btn btn-default">Reset</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<img src="<?= base_url() ?>images/loader.gif" id="loader-form"  style="width: 30px; display: none;" />
			        <button type="button" id="btn-simpan" onclick="simpanbarang()" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;&nbsp;Simpan</button>
				</div>
			</div>
		</div>
	</div>
	<!-- Form popup untuk pilih kategori barang -->
	<div class="modal fade" id="list-kategori" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        			<h4 class="modal-title" id="myModalLabel">Kategori Barang</h4>
				</div>
				<div class="modal-body modal-kategori">
					
				</div>
			</div>
		</div>
	</div>
	<!-- Form popup untuk set supplier -->
	<div class="modal fade" id="form-setsupplier" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        			<h4 class="modal-title" id="myModalLabel">Form Set Supplier</h4>
				</div>
				<div class="modal-body">
					<table>
						<tr>
							<td>Supplier</td>
							<td>Harga Beli</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<select class="form-control" style="width: 250px;" name="barang_setsupplier" id="barang_setsupplier">
										<option value="-1">Pilih Supplier</option>
									</select>
								</div>
							</td>
							<td>
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-money"></i>
									</span>
									<input type="text" style="text-align:right; width: 100px;" value="0" name="barang_harga_supplier" id="barang_harga_supplier" class="form-control">
								</div>
							</td>
							<td valign="top">
								<button onclick="addSupplier()" class="btn btn-info btn-sm" type="button">
									<i class="fa fa-plus"></i>
								</button>
							</td>
						</tr>
					</table>
					<table id="table-dummy-supplierbarang" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th class="text-center">Kode Supplier</th>
								<th class="text-center">Nama Supplier</th>
								<th class="text-center">Harga Beli</th>
								<th class="text-center">Hapus</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" onclick="clearForm(1)" class="btn btn-default">Reset</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<img src="<?= base_url() ?>/images/loader.gif" id="loader-form-setsupplier"  style="width: 30px; display: none;" />
			        <button type="button" id="btn-simpan-setsupplier" onclick="simpansetsupplier()" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;&nbsp;Simpan</button>
				</div>
			</div>
		</div>
	</div>
	
	<!-- Form popup untuk set toko -->
	<div class="modal fade" id="form-settoko" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        			<h4 class="modal-title" id="myModalLabel">Form Set Margin Harga Jual</h4>
				</div>
				<div class="modal-body">
					<table>
						<tr>
							<td>Kode Barang</td>
							<td>&nbsp;</td>
							<td><input type="text" class="form-control" readonly name="info_kode_barang" id="info_kode_barang" /></td>
							<td>&nbsp;</td>
							<td>Nama Barang</td>
							<td>&nbsp;</td>
							<td><input type="text" class="form-control" readonly name="info_nama_barang" id="info_nama_barang" /></td>
						</tr>
					</table>
					<hr/>
					<table width="100%">
						<tr>
							<td>Toko</td>
							<td>HPP</td>
							<td>Margin Harga (%)</td>
							<td>Harga Jual</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<select class="form-control" style="width: 200px;" name="barang_toko" id="barang_toko">
										<option value="">Semua Toko</option>
									</select>
								</div>
							</td>
							<td>
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-money"></i>
									</span>
									<input type="text" style="text-align:right; width: 100px;" readonly value="0" name="barang_hpp" id="barang_hpp" class="form-control">
								</div>
							</td>
							<td>
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-money"></i>
									</span>
									<input type="text" style="text-align:right; width: 100px;" value="0" name="barang_margin_harga" onkeyup="HitungHargaJualDariMargin()" id="barang_margin_harga" class="form-control">
								</div>
							</td>
							<td>
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-money"></i>
									</span>
									<input type="text" readonly style="text-align:right; width: 100px;" value="0" name="barang_harga_jual" id="barang_harga_jual" class="form-control">
								</div>
							</td>
							<td valign="top">
								<button type="button" id="btn-simpan-settoko" onclick="simpansettoko()" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;&nbsp;Simpan</button>
							</td>
						</tr>
					</table>
					<table id="table-dummy-tokobarang" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th class="text-left">Kode Toko</th>
								<th class="text-left">Nama Toko</th>
								<th class="text-right">HPP</th>
								<th class="text-right">Margin Harga</th>
								<th class="text-right">Harga Jual</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
				<div class="modal-footer">
					
				</div>
			</div>
		</div>
	</div>
	<!-- Form popup untuk import harga jual -->
	<div class="modal fade" id="form-importhargajual" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        			<h4 class="modal-title" id="myModalLabel">Form Import Harga Jual</h4>
				</div>
				<div class="modal-body">
					<div class="form-group input-group">
						<span class="input-group-addon">
							<i class="fa fa-file"></i>
						</span>
						<select class="form-control" style="width: 200px;" name="import_toko" id="import_toko">
							<option value="-1">Pilih Toko</option>
						</select>
					</div>
					<form id="FormImport" action="<?php echo base_url(); ?>index.php/barang/importhargajual" method="post" enctype="multipart/form-data">
						<table width="100%">
							<tr>
								<td><input type="file" size="60" name="fileupload"></td>
								<td align="right"><input class="btn btn-info btn-sm" type="submit" value="Import File"></td>
							</tr>
						</table>
					</form>
					<div id="progress-data" style="display: none;">
						<div class="progress progress-striped active">
							<div class="progress-bar progress-bar-info" style="width: 20%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="20" role="progressbar">
								<span class="sr-only">20% Complete</span>
							</div>
						</div>
					</div>
					<table style="width: 100%" id="table-dummy-hargajual" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th class="text-center">KD Barang</th>
								<th class="text-center">Nama Barang</th>
								<th class="text-center">Harga 1</th>
								<th class="text-center">Harga 2</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" onclick="" class="btn btn-default">Reset</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<img src="<?= base_url() ?>/images/loader.gif" id="loader-form-import"  style="width: 30px; display: none;" />
			        <button type="button" id="btn-simpan-import" onclick="simpanimporthargajual()" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;&nbsp;Simpan</button>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		OpenMenu();
		loadKategoriBarang();
		loadListSupplier();
		// loadListToko();
		
		$('.ask-barang').jConfirmAction();
		
		$('#dataTables-barang tbody').on( 'click', 'tr', function () {
			if ( $(this).hasClass('active') ) {
				$(this).removeClass('active');
			}else {
				$('#dataTables-barang tr.active').removeClass('active');
				$(this).addClass('active');
			}
		} );

		var options = {
		    beforeSend: function(){
		        $("#progress-data").show();
		        //clear everything
		        $("#progress-data .progress-bar").attr("style","width: 80%");
		        //$("#message").html("");
		        //$("#percent").html("0%");
		    },
		    uploadProgress: function(event, position, total, percentComplete){
		        //$("#bar").width(percentComplete+'%');
		        //$("#percent").html(percentComplete+'%');
		 		$("#progress-data .progress-bar").attr("style","width: "+percentComplete+"%");
		    },
		    success: function(){
		        // $("#bar").width('100%');
		        // $("#percent").html('100%');
		        $("#progress-data .progress-bar").attr("style","width: 100%");
		    },
		    complete: function(response){
		        var dataArr = json_decode(base64_decode(response.responseText));
		        for(var i=0;i<dataArr.length;i++){
		        	var row = "<tr><td>"+dataArr[i]['barang_kode']+"</td><td>"+dataArr[i]['nama_barang']+"</td><td class=\"text-right\">"+dataArr[i]['harga1']+"</td><td class=\"text-right\">"+dataArr[i]['harga2']+"</td></tr>";
					$('#table-dummy-hargajual > tbody:last').append(row);
		        }
		        
		        $("#progress-data").hide();

		    },
		    error: function(){
		        $("#message").html("<font color='red'> ERROR: unable to upload files</font>");
		 
		    }
		};
	 	 	
	    $("#FormImport").ajaxForm(options);
	});
	
	function ChekBarang(barang_kode){
		$('input[name=barang_check]').removeAttr("checked");
		$('#barang_'+barang_kode).prop("checked", "checked");
		/*if($('#barang_'+barang_kode).is(':checked')){
			$('#barang_'+barang_kode).removeAttr("checked");
		}else{
			ppn = 0;
		}*/
	}

	function NextDataBarang(){
		var halaman = $("#halaman_ke").html();
		halaman = parseFloat(halaman) + 1;
		$("#halaman_ke").html(halaman);

		LoadDataBarang();
	}

	function PreviousDataBarang(){
		var halaman = $("#halaman_ke").html();
		halaman = parseFloat(halaman) - 1;
		$("#halaman_ke").html(halaman);

		if(halaman > 0){
			LoadDataBarang();
		}else{
			alert("sudah mencapai akhir halaman");
			halaman += 1;
			$("#halaman_ke").html(halaman);
		}
	}
	
	function LoadDataBarang(){
		$("#progres-main").show();
		var keyword = $("#cari_barang").val();
		var kategori_kode = $("#cari_kategori").select2("val");
		var halaman = $("#halaman_ke").html();
		var mode_urut = $("#mode_urut").val();
		var mode_is_aktif = $("#mode_is_aktif").val();
		// if(keyword == ""){
		// 	alert("tidak boleh dikosongi");
		// }else{
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/barang/getdatabarang",
			data: "keyword="+keyword+"&kategori_kode="+kategori_kode+"&halaman="+halaman+"&mode_urut="+mode_urut+"&mode_is_aktif="+mode_is_aktif,
			success: function(msg){
				$("#dataTables-barang tbody").html(msg);
				// $('#dataTables-barang').dataTable();
			}
		});
		// }
		$("#progres-main").hide();
		/*table = $('#dataTables-barang').dataTable({
			"bProcessing": true,
			"sAjaxSource": "<?= base_url() ?>index.php/barang/getdatabarang",
			"aoColumns": [
							{ mData: 'check'} ,
							{ mData: 'kode'} ,
							{ mData: 'nama_barang'}, 
							{ mData: 'nama_kategori'},
							{ mData: 'satuan'},
							{ mData: 'is_ppn'},
							{ mData: 'bkl'},
							{ mData: 'is_aktif'}
						 ]
		});*/
	}
	
	function loadListSupplier(){
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/supplier/getselectsupplier",
			data: "",
			success: function(msg){
				$("#barang_supplier").html(msg);
				$("#barang_supplier").select2();
				
				$("#barang_setsupplier").html(msg);
				$("#barang_setsupplier").select2();
			}
		});
	}
	
	function loadListToko(){
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/toko/getListDataToko",
			data: "mode=aktif",
			success: function(msg){
				var textList = "<option value=\"\">Semua Toko</option>"+msg;
				$("#barang_toko").html(textList);
				$("#import_toko").html(textList);
			}
		});
	}
	
	function openFormBarang(){
		clearForm(1);
		
		$('#form-barang').modal('show');
		//var ts = Math.round((new Date()).getTime() / 1000);
		$("#barang_kd_barang").val("");
		$("#barang_mode").val("i");
		
		LoadFormHargaToko();
	}

	function openFormImportHarga(){
		$('#form-importhargajual').modal('show');
	}
	
	function cekOtomatis(){
		if($("#barang_mode").val() == "i"){
			if($("#barang_otomatis").is(':checked')){
				var ts = Math.round((new Date()).getTime() / 1000);
				$("#barang_kd_barang").val(ts);
				$("#barang_kd_barang").attr("readonly","readonly");
			}else{
				$("#barang_kd_barang").removeAttr("readonly");
				$("#barang_kd_barang").val("");
			}
		}
	}
	
	function loadKategoriBarang(){
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/kategoribarang/getlistkategoriform",
			data: "",
			success: function(msg){
				$("#barang_kode_kategori").html(msg);
				$("#barang_kode_kategori").select2();

				var select = "<option value=\"-1\">Semua Kelompok</option>"+msg;
				$("#cari_kategori").html(select);
				$("#cari_kategori").select2();

				$('#barang_kode_kategori').on('select2-selecting', function (e) {
					SelectKategoriBarang(e.val);
					GenerateKodeBarang(e.val);
				});

				LoadDataBarang();
			}
		});
	}
	
	function OpenPilihKategori(){
		$('#list-kategori').modal('show');
	}
	
	function PilihKategori(kode, nama){
		$("#barang_kategori_barang").val(nama);
		$("#barang_kode_kategori").val(kode);
		
		$('#list-kategori').modal('hide');
	}
	
	function simpanbarang(){
		$("#loader-form").show();
		$("#btn-simpan").hide();
		
		var kode = $("#barang_kd_barang").val();
		var kategori = base64_encode($("#barang_kode_kategori").val());
		var nama_barang = $("#barang_nama_barang").val();
		var satuan = $("#barang_satuan").val();
		var barcode = $("#barang_barcode").val();
		var supplier_kode = base64_encode($("#barang_supplier").val());
		var harga_beli_supplier = $("#barang_harga_terakhir").val();
		
		var is_ppn = "1";
		if($('#barang_is_ppn').is(':checked')){
			is_ppn = "1";
		}else{
			is_ppn = "0";
		}
		
		var is_bkl = "1";
		if($('#barang_is_bkl').is(':checked')){
			is_bkl = "1";
		}else{
			is_bkl = "0";
		}
		
		var is_aktif = "1";
		if($('#barang_is_aktif').is(':checked')){
			is_aktif = "1";
		}else{
			is_aktif = "0";
		}
		
		var toko = $(".harga_barang_toko");
		var dataToko = [];
		var dataHarga = [];
		for(var i=0;i<toko.length;i++){
			var kode_toko = toko[i].attributes.toko_kode.value;
			var harga = removeCurrency(toko[i].value);
			
			dataToko.push(kode_toko);
			dataHarga.push(harga);
		}
		
		var jsonDataToko = rawurlencode(json_encode(dataToko));
		var jsonDataHarga = rawurlencode(json_encode(dataHarga));
		var mode_form = $("#barang_mode").val();

		if(kode == ""){
			alert("Kode barang harus diisi");

			$("#loader-form").hide();
			$("#btn-simpan").show();
		}else if(nama_barang == "" || kategori == ""){
			alert("Nama barang dan kategori harus diisi");

			$("#loader-form").hide();
			$("#btn-simpan").show();
		}else if(harga_beli_supplier == "" || supplier_kode == ""){
			alert("supplier dan harga beli supplier harus diisi");

			$("#loader-form").hide();
			$("#btn-simpan").show();
		}else{
			$.ajax({
				type: "POST",
				url: "<?= base_url() ?>index.php/barang/simpanbarang",
				data: "kode="+kode+"&barcode="+barcode+"&kategori="+kategori+"&nama_barang="+base64_encode(nama_barang)+"&satuan="+satuan+"&is_ppn="+is_ppn+"&is_bkl="+is_bkl+"&harga_beli_supplier="+harga_beli_supplier+"&supplier_kode="+supplier_kode+"&is_aktif="+is_aktif+"&mode="+mode_form+"&datatoko="+jsonDataToko+"&dataharga="+jsonDataHarga,
				success: function(msg){
					alert('data berhasil disimpan');
					//table.api().ajax.reload();
					LoadDataBarang();
					$("#loader-form").hide();
					$("#btn-simpan").show();
					$("#barang_mode").val("i");
					$('#form-barang').modal('hide');

					clearForm(1);
				},
				error: function(xhr,status,error){
					var responseText = xhr.responseText;
					if(responseText.indexOf("Duplicate") >= 0){
						alert("Error Database : Data sudah ada di database");
					}else{
						alert(responseText);
					}
					$("#loader-form").hide();
					$("#btn-simpan").show();

					clearForm(1);
				}
			});
		}
	}
	
	function HapusBarang(){
		var data = $('#dataTables-barang tr.active').attr("data");
		if(typeof data == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var dataArr = json_decode(base64_decode(data));
			
			$.ajax({
				type: "POST",
				url: "<?= base_url() ?>index.php/barang/hapusbarang",
				data: "kode="+dataArr['kode'],
				success: function(msg){
					if(msg == "1"){
						alert('data berhasil dihapus');
						//table.api().ajax.reload();
						LoadDataBarang();
					}else if(msg == "-1"){
						alert('data gagal dihapus karena barang tersebut sudah digunakan untuk transaksi');
					}else{
						alert(msg);
					}
				}
			});
		}
	}

	function TidakAktifBarang(){
		var data = $('#dataTables-barang tr.active').attr("data");
		if(typeof data == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var dataArr = json_decode(base64_decode(data));
			
			$.ajax({
				type: "POST",
				url: "<?= base_url() ?>index.php/barang/tidakaktifbarang",
				data: "kode="+dataArr['kode'],
				success: function(msg){
					alert('data berhasil dinon aktif kan');
					//table.api().ajax.reload();
					LoadDataBarang();
				}
			});
		}
	}

	function AktifkanBarang(){
		var data = $('#dataTables-barang tr.active').attr("data");
		if(typeof data == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var dataArr = json_decode(base64_decode(data));
			if(dataArr['is_aktif'] == "0"){
				$.ajax({
					type: "POST",
					url: "<?= base_url() ?>index.php/barang/aktifkanbarang",
					data: "kode="+dataArr['kode'],
					success: function(msg){
						alert('data berhasil diaktifkan');
						//table.api().ajax.reload();
						LoadDataBarang();
					}
				});
			}else{
				alert("barang sudah aktif");
			}
		}
	}
	
	function openFormEditBarang(){
		var data = $('#dataTables-barang tr.active').attr("data");;
		if(typeof data == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var dataArr = json_decode(base64_decode(data));
			
			$("#barang_kd_barang").val(dataArr['kode']);
			$("#barang_barcode").val(dataArr['barcode']);
			$("#barang_kode_kategori").select2('val', dataArr['kategori']);
			$("#barang_kategori_barang").val(dataArr['nama_kategori']);
			$("#barang_nama_barang").val(dataArr['nama_barang']);
			$("#barang_satuan").val(dataArr['satuan']);
			$("#barang_margin").val(dataArr['margin_harga']);
			$("#barang_mode").val("e");
			
			if(dataArr['is_ppn'] == "1"){
				$('#barang_is_ppn').attr("checked", "checked");
			}else{
				$('#barang_is_ppn').removeAttr("checked");
			}
			if(dataArr['bkl'] == "1"){
				$('#barang_is_bkl').attr("checked", "checked");
			}else{
				$('#barang_is_bkl').removeAttr("checked");
			}
			if(dataArr['is_aktif'] == "1"){
				$('#barang_is_aktif').attr("checked", "checked");
			}else{
				$('#barang_is_aktif').removeAttr("checked");
			}
			
			$("#barang_kd_barang").attr("readonly","readonly");
			
			LoadFormEditHargaToko(dataArr['kode']);
			LoadFormEditHargaSupplier(dataArr['kode']);
			$('#form-barang').modal('show');
		}
	}
	
	function clearForm(mode){
		//var ts = Math.round((new Date()).getTime() / 1000);
		
		$("#barang_kd_barang").val("");
		$("#barang_barcode").val("");
		$("#barang_is_ppn").prop("checked", "checked");
		$("#barang_is_bkl").removeAttr("checked");
		$("#barang_is_aktif").prop("checked", "checked");
		$("#barang_kode_kategori").select2("val", "");
		// $("#barang_kategori_barang").val("");
		$("#barang_nama_barang").val("");
		$("#barang_margin").val("");
		$("#barang_satuan").val("");
		$("#barang_supplier").select2("val", "");
		$("#barang_harga_terakhir").val("");
		$("#barang_mode").val("i");

		LoadFormHargaToko();
	}
	
	function LoadFormHargaToko(){
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/barang/getFormHargaToko",
			success: function(msg){
				$("#form_harga_toko").html(msg);
			}
		});
	}
	
	function LoadFormEditHargaToko(barang_kode){
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/barang/getFormEditHargaToko",
			data: "barang_kode="+barang_kode,
			success: function(msg){
				$("#form_harga_toko").html(msg);
			}
		});
	}
	
	function LoadFormEditHargaSupplier(barang_kode){
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/barang/getFormEditHargaSupplier",
			data: "barang_kode="+barang_kode,
			success: function(msg){
				var dataArr = msg.split("_");
				
				$("#barang_harga_terakhir").val(dataArr[1]);
				$("#barang_supplier").select2("val", dataArr[0]);
			}
		});
	}
	
	function openHargaTable(kode_barang){
		$("#div_harga_"+kode_barang).show();
		$("#btn_show_harga_"+kode_barang).hide();
		$("#btn_hide_harga_"+kode_barang).show();
	}
	
	function closeHargaTable(kode_barang){
		$("#div_harga_"+kode_barang).hide();
		$("#btn_show_harga_"+kode_barang).show();
		$("#btn_hide_harga_"+kode_barang).hide();
	}
	
	function openFormSetSupplier(){
		var data = $('#dataTables-barang tr.active').attr("data");;
		if(typeof data == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			$("#form-setsupplier").modal("show");
			var dataBarangArr = json_decode(base64_decode(data));
			
			$.ajax({
				type: "POST",
				url: "<?= base_url() ?>index.php/barang/loadbarangsupplier",
				data: "barang_kode="+dataBarangArr['kode'],
				success: function(msg){
					$('#table-dummy-supplierbarang > tbody').html(msg);
				}
			});
		}
	}
	
	function openFormSetToko(){
		var data = $('#dataTables-barang tr.active').attr("data");;
		if(typeof data == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			$("#form-settoko").modal("show");
			var dataBarangArr = json_decode(base64_decode(data));
			
			$("#info_kode_barang").val(dataBarangArr['kode']);
			$("#info_nama_barang").val(dataBarangArr['nama_barang']);
			$("#barang_hpp").val(dataBarangArr['hpp']);
			$("#barang_margin_harga").val(dataBarangArr['margin_harga']);
			HitungHargaJualDariMargin();
			$.ajax({
				type: "POST",
				url: "<?= base_url() ?>index.php/barang/loadbarangtoko",
				data: "barang_kode="+dataBarangArr['kode'],
				success: function(msg){
					$('#table-dummy-tokobarang > tbody').html(msg);
				}
			});
		}
	}
	
	function addSupplier(){
		var supplier_kode = $("#barang_setsupplier").val();
		var nama_supplier = $("#s2id_barang_setsupplier .select2-chosen").html();
		var harga_supplier = $("#barang_harga_supplier").val();
		var row = "<tr><td>"+supplier_kode+"</td><td>"+nama_supplier+"</td><td align=\"right\">"+harga_supplier+"</td><td class=\"text-center\"><button type=\"button\" onclick=\"EditRow(this)\" class=\"btn btn-success btn-sm\"><i class=\"fa fa-edit\"></i></button><button type=\"button\" onclick=\"HapusRow(this)\" class=\"btn btn-danger btn-sm\"><i class=\"fa fa-times\"></i></button></td></tr>";
		$('#table-dummy-supplierbarang > tbody:last').append(row);
	}
	
	function addToko(){
		var toko_kode = $("#barang_toko").val();
		var nama_toko = $("#barang_toko").find('option:selected').text();
		var harga1 = number_format($("#barang_harga1_toko").val(), 2);
		var harga2 = number_format($("#barang_harga2_toko").val(), 2);
		var harga3 = number_format($("#barang_harga3_toko").val(), 2);
		var row = "<tr><td>"+toko_kode+"</td><td>"+nama_toko+"</td><td align=\"right\">"+harga1+"</td><td align=\"right\">"+harga2+"</td><td align=\"right\">"+harga3+"</td><td class=\"text-center\"><button type=\"button\" onclick=\"EditRowHargaToko(this)\" class=\"btn btn-success btn-sm\"><i class=\"fa fa-edit\"></i></button><button type=\"button\" onclick=\"HapusRow(this)\" class=\"btn btn-danger btn-sm\"><i class=\"fa fa-times\"></i></button></td></tr>";
		$('#table-dummy-tokobarang > tbody:last').append(row);
	}
	
	function HapusRow(DataObj){
		$(DataObj).parent().parent().remove();
	}
	
	function EditRowHargaToko(DataObj){
		var Datahtml = $(DataObj).parent().parent().html();
		
		var dataArr = [];
	    $(DataObj).parent().parent().find('td').each(function(){
	        dataArr.push($(this).html());
	    });
		
		$("#barang_toko").val(dataArr[0]);
		$("#barang_harga1_toko").val(dataArr[2]);
		$("#barang_harga2_toko").val(dataArr[3]);
		$("#barang_harga3_toko").val(dataArr[4]);
		
		$(DataObj).parent().parent().remove();
	}
	
	function EditRowHargaSupplier(DataObj){
		var Datahtml = $(DataObj).parent().parent().html();
		
		var dataArr = [];
	    $(DataObj).parent().parent().find('td').each(function(){
	        dataArr.push($(this).html());
	    });
		
		$("#barang_setsupplier").select2("val", dataArr[0]);
		$("#barang_harga_supplier").val(dataArr[2]);
		
		$(DataObj).parent().parent().remove();
	}
	
	function simpansetsupplier(){
		var data = $('#dataTables-barang tr.active').attr("data");
		var dataBarangArr = json_decode(base64_decode(data));
		var dataArr = [];
	    $("#table-dummy-supplierbarang td").each(function(){
	        dataArr.push($(this).html());
	    });
		var jsonData = rawurlencode(json_encode(dataArr));
		
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/barang/simpanbarangsupplier",
			data: "barang_kode="+dataBarangArr['kode']+"&data="+jsonData,
			success: function(msg){
				$("#form-setsupplier").modal("hide");
				alert('data berhasil disimpan');
			}
		});
	}
	
	function simpansettoko(){
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/barang/simpanmarginharga",
			data: "barang_kode="+$("#info_kode_barang").val()+"&margin1="+$("#barang_margin_harga").val()+"&harga_jual="+$("#barang_harga_jual").val(),
			success: function(msg){
				openFormSetToko();
				LoadDataBarang();
			}
		});
	}
	
	function runScript(e) {
		if (e.keyCode == 13) {
			$("#halaman_ke").html("1");
			LoadDataBarang();
		}
	}

	function FirstLoadDataBarang(){
		$("#halaman_ke").html("1");
		LoadDataBarang();
	}

	function simpanimporthargajual(){
		$('#btn-simpan-import').hide();
		$('#loader-form-import').show();

		var dataArr = [];
	    $("#table-dummy-hargajual td").each(function(){
	        dataArr.push($(this).html());
	    });
		var jsonData = rawurlencode(json_encode(dataArr));
		
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/barang/simpanimporthargajual",
			data: "toko_kode="+$("#import_toko").val()+"&data="+jsonData,
			success: function(msg){
				alert('data berhasil disimpan');

				$('#btn-simpan-import').show();
				$('#loader-form-import').hide();
				$("#form-importhargajual").modal("hide");
			}
		});
	}

	function SelectKategoriBarang(data){
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/barang/getmarginkategori",
			data: "kategori_kode="+data,
			success: function(msg){
				$("#barang_margin").val(msg);
			}
		});
	}

	function HitungHargaJual(){
		var margin = $("#barang_margin").val();
		if(margin == ""){
			margin = 0;
		}

		var harga_beli = $("#barang_harga_terakhir").val();

		var harga_margin = Math.round(parseFloat(harga_beli) * (margin/100));
		var harga_fix = parseFloat(harga_beli) + harga_margin;
		harga_fix = pembulatan(""+harga_fix);

		$("#barang_harga_VO0001").val(harga_fix);
		$("#barang_harga_VO0002").val(harga_fix);
		$("#barang_harga_VO0004").val(harga_fix);
		$("#barang_harga_VO0011").val(harga_fix);
		
		var harga_margin_1 = Math.round(parseFloat(harga_beli) * ((parseFloat(margin)+5)/100));
		var harga_fix_1 = parseFloat(harga_beli) + harga_margin_1;
		harga_fix_1 = pembulatan(""+harga_fix_1);
		
		$("#barang_harga_VO0005").val(harga_fix_1);
	}

	function HitungHargaJualDariMargin(){
		var margin = $("#barang_margin_harga").val();
		if(margin == ""){
			margin = 0;
		}

		var harga_beli = $("#barang_hpp").val();

		var harga_margin = Math.round(parseFloat(harga_beli) * (margin/100));
		var harga_fix = Math.round(parseFloat(harga_beli)) + harga_margin;
		harga_fix = pembulatan(""+harga_fix);

		$("#barang_harga_jual").val(harga_fix);
	}

	function pembulatan(uang){
		var puluhan = uang.substring(uang.length - 2, uang.length);
		puluhan = parseFloat(puluhan);
		var akhir = parseFloat(uang);
		if(puluhan <= 50){
			if(puluhan > 0){
				akhir = parseFloat(uang) + (50 - puluhan);
			}
		}else{
			akhir = parseFloat(uang) + (100 - puluhan);
		}

		return akhir;
	}

	function GenerateKodeBarang(data){
		var barang_mode = $("#barang_mode").val();
		if(barang_mode == "i"){
			$.ajax({
				type: "POST",
				url: "<?= base_url() ?>index.php/barang/generatekodebarang",
				data: "kategori_kode="+data,
				success: function(msg){
					$("#barang_kd_barang").val(msg);
				}
			});
		}
	}
</script>