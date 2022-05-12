<div id="page-wrapper">
	<div class="row">
	    <div class="col-lg-12">
	        <h1 style="margin-top: 15px;" class="page-header">Master Minmax</h1>
	    </div>
	    <!-- /.col-lg-12 -->
	</div>
	<div class="row">
		<div class="col-lg-12">
			<table style="float: right;">
				<tr>
					<td style="width: 125px;">
						<div class="form-group input-group">
							<span class="input-group-addon">
								<i class="fa fa-file"></i>
							</span>
							<select class="form-control" style='width: 200px;' name="cari_toko_kode" id="cari_toko_kode">
								<option value="-1">Pilih Toko</option>
							</select>
						</div>
					</td>
					<td>&nbsp;&nbsp;</td>
					<td valign="top">
						<button id="btn_upload" onclick="LoadDataMinmax()" class="btn btn-info" type="button">
							<i class="fa fa-search"></i>
							&nbsp;&nbsp;Search
						</button>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="row" style="margin-top: 10px;">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<button id="btn_upload" onclick="openFormImportMinmax()" class="btn btn-info btn-sm" type="button">
						<i class="fa fa-plus"></i>
						&nbsp;&nbsp;Import
					</button>
					<!-- <button id="btn_upload" onclick="openFormEditMinmax()" class="btn btn-success btn-sm" type="button">
						<i class="fa fa-edit"></i>
						&nbsp;&nbsp;Edit
					</button>
					<button id="btn_upload" fungsi="HapusMinmax()" class="btn btn-danger btn-sm ask-minmax" type="button">
						<i class="fa fa-times"></i>
						&nbsp;&nbsp;Hapus
					</button> -->
					<button id="btn_upload" onclick="CetakMinmax()" class="btn btn-warning btn-sm" type="button">
						<i class="fa fa-print"></i>
						&nbsp;&nbsp;Cetak
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
					<div class="table-responsive table-minmax">
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Form popup untuk tambah minmax -->
	<div class="modal fade" id="form-minmax" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        			<h4 class="modal-title" id="myModalLabel">Form Minmax</h4>
				</div>
				<div class="modal-body">
					<table>
						<tr>
							<td width='48%' valign='top'>
								Toko :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<input type="hidden" name="minmax_kode" id="minmax_kode"/>
									<input type="hidden" name="minmax_mode" id="minmax_mode" value="i"/>
									<select class="form-control" style='width: 200px;' name="minmax_toko" id="minmax_toko">
										<option value="-1">Pilih Toko</option>
									</select>
								</div>
								Barang :
								<div class="form-group input-group">
									<input type="text" class="form-control" style="width: 260px;" name="minmax_barang" id="minmax_barang" />
								</div>
								Rak :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<input type="text" placeholder="Rak" onkeyup="toUpper('minmax_rak')" name="minmax_rak" id="minmax_rak" class="form-control">
								</div>
								Shlv :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<input type="text" placeholder="Shlv" onkeyup="toUpper('minmax_shlv')" name="minmax_shlv" id="minmax_shlv" class="form-control">
								</div>
							</td>
							<td width='4%'></td>
							<td width='48%' valign='top'>
								Urut :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<input type="text" placeholder="Urut" name="minmax_urut" id="minmax_urut" class="form-control">
								</div>
								Kiri-Kanan :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<input type="text" placeholder="Kiri-Kanan" name="minmax_kirikanan" id="minmax_kirikanan" class="form-control">
								</div>
								Depan-Belakang :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<input type="text" placeholder="Depan-Belakang" name="minmax_depanbelakang" id="minmax_depanbelakang" class="form-control">
								</div>
								Atas-Bawah :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<input type="text" placeholder="Atas-Bawah" name="minmax_atasbawah" id="minmax_atasbawah" class="form-control">
								</div>
							</td>
						</tr>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" onclick="clearForm()" class="btn btn-default">Reset</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<img src="<?= base_url() ?>images/loader.gif" id="loader-form"  style="width: 30px; display: none;" />
			        <button type="button" id="btn-simpan" onclick="simpanminmax()" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;&nbsp;Simpan</button>
				</div>
			</div>
		</div>
	</div>
	<!-- Form popup untuk import minmax -->
	<div class="modal fade" id="form-importminmax" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        			<h4 class="modal-title" id="myModalLabel">Form Import Min-Max</h4>
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
					<form id="FormImport" action="<?php echo base_url(); ?>index.php/minmax/importminmax" method="post" enctype="multipart/form-data">
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
					<table style="width: 100%" id="table-dummy-minmax" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th class="text-center">KD Barang</th>
								<th class="text-center">Nama Barang</th>
								<th class="text-right">Min</th>
								<th class="text-right">Max</th>
								<th class="text-right">Minor</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" onclick="" class="btn btn-default">Reset</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<img src="<?= base_url() ?>/images/loader.gif" id="loader-form-import"  style="width: 30px; display: none;" />
			        <button type="button" id="btn-simpan-import" onclick="simpanimportminmax()" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;&nbsp;Simpan</button>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		OpenMenu();
		LoadListDataBarang();
		loadListToko();
		
		$('.ask-minmax').jConfirmAction();

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
		        	var row = "<tr><td>"+dataArr[i]['barang_kode']+"</td><td>"+dataArr[i]['nama_barang']+"</td><td class=\"text-right\">"+dataArr[i]['min']+"</td><td class=\"text-right\">"+dataArr[i]['max']+"</td><td class=\"text-right\">"+dataArr[i]['minor']+"</td></tr>";
					$('#table-dummy-minmax > tbody:last').append(row);
		        }
		        
		        $("#progress-data").hide();

		    },
		    error: function(){
		        $("#message").html("<font color='red'> ERROR: unable to upload files</font>");
		 
		    }
		};
	 	 	
	    $("#FormImport").ajaxForm(options);
	});
	
	function LoadListDataBarang(){
	    $("#minmax_barang").select2({
		    placeholder: "Cari bahan baku",
		    minimumInputLength: 1,
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
	}
	
	function openFormMinmax(){
		ClearForm();
		$("#form-minmax").modal("show");
		
		var cari_toko = $("#cari_toko_kode").val();
		$("#minmax_toko").val(cari_toko);
	}
	
	function LoadDataMinmax(){
		$('#progres-main').show();
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/minmax/getdataminmax",
			data: "toko_kode="+$('#cari_toko_kode').val(),
			success: function(msg){
				$(".table-minmax").html(msg);
				//table = $('#dataTables-pembelian-barang').dataTable();
				$('#progres-main').hide();
				
				$('#dataTables-minmax tbody').on( 'click', 'tr', function () {
			        if ( $(this).hasClass('active') ) {
			            $(this).removeClass('active');
			        }else {
			            $('#dataTables-minmax tr.active').removeClass('active');
			            $(this).addClass('active');
			        }
			    } );
			}
		});
	}
	
	function loadListToko(){
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/toko/getListToko",
			data: "",
			success: function(msg){
				$("#cari_toko_kode").html(msg);
				$("#minmax_toko").html(msg);
				$("#import_toko").html(msg);
				
				LoadDataMinmax();
			}
		});
	}

	function openFormImportMinmax(){
		$('#form-importminmax').modal('show');
	}
	
	function simpanminmax(){
		$("#loader-form").show();
		$("#btn-simpan").hide();
		
		var minmax_kode = $("#minmax_kode").val();
		var toko_kode = $("#minmax_toko").val();
		var barang_kode = $("#minmax_barang").val();
		var rak = $("#minmax_rak").val();
		var shlv = $("#minmax_shlv").val();
		var urut = $("#minmax_urut").val();
		var kirikanan = $("#minmax_kirikanan").val();
		var depanbelakang = $("#minmax_depanbelakang").val();
		var atasbawah = $("#minmax_atasbawah").val();
		var mode = $("#minmax_mode").val();
		
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/minmax/simpanminmax",
			data: "mode="+mode+"&minmax_kode="+minmax_kode+"&toko_kode="+toko_kode+"&barang_kode="+barang_kode+"&rak="+rak+"&shlv="+shlv+"&urut="+urut+"&kirikanan="+kirikanan+"&depanbelakang="+depanbelakang+"&atasbawah="+atasbawah+"",
			success: function(msg){
				$("#loader-form").hide();
				$("#btn-simpan").show();
		
				$("#form-minmax").modal("hide");
				ClearForm();
				
				LoadDataMinmax();
			}
		});
	}
	
	function openFormEditMinmax(){
		var data_obj = $('#dataTables-minmax tr.active').attr("data");
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			
			$("#minmax_mode").val("e");
			$("#minmax_kode").val(data['kode']);
			$("#minmax_toko").val(data['toko_kode']);
			$("#minmax_barang").val(data['barang_kode']);
			$("#minmax_rak").val(data['rak']);
			$("#minmax_shlv").val(data['shlv']);
			$("#minmax_urut").val(data['urut']);
			$("#minmax_kirikanan").val(data['kirikanan']);
			$("#minmax_depanbelakang").val(data['depanbelakang']);
			$("#minmax_atasbawah").val(data['atasbawah']);
			
			$("#form-minmax").modal("show");
		}
	}
	
	function HapusMinmax(){
		var data_obj = $('#dataTables-minmax tr.active').attr("data");
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			$('#progres-main').show();
			$.ajax({
				type: "POST",
				url: "<?= base_url(); ?>index.php/minmax/hapusminmax",
				data: "kode="+data['kode'],
				success: function(msg){
					ShowMessage("success", "Data berhasil dihapus");
					LoadDataMinmax();
				}
			});
		}
	}
	
	function CetakMinmax(){
		var toko_kode = $("#cari_toko_kode").val();
		var nama_toko = $("#cari_toko_kode :selected").text();
		
		window.open('<?= base_url('index.php/minmax/cetakminmax?') ?>toko_kode='+toko_kode+"&nama_toko="+nama_toko,'_blank');
	}
	
	function ClearForm(){
		$("#minmax_mode").val("i");
		$("#minmax_kode").val("");
		$("#minmax_toko").val("");
		$("#minmax_barang").val("");
		$("#minmax_rak").val("");
		$("#minmax_shlv").val("");
		$("#minmax_urut").val("");
		$("#minmax_kirikanan").val("");
		$("#minmax_depanbelakang").val("");
		$("#minmax_atasbawah").val("");
	}

	function simpanimportminmax(){
		$('#btn-simpan-import').hide();
		$('#loader-form-import').show();

		var dataArr = [];
	    $("#table-dummy-minmax td").each(function(){
	        dataArr.push($(this).html());
	    });
		var jsonData = rawurlencode(json_encode(dataArr));
		
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/minmax/simpanimportminmax",
			data: "toko_kode="+$("#import_toko").val()+"&data="+jsonData,
			success: function(msg){
				alert('data berhasil disimpan');

				$('#btn-simpan-import').show();
				$('#loader-form-import').hide();
				$("#form-importminmax").modal("hide");
			}
		});
	}
</script>