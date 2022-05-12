<style>
	.datepicker{z-index:1151 !important;}
</style>
<div id="page-wrapper">
	<div class="row">
	    <div class="col-lg-12">
	        <h1 style="margin-top: 15px;" class="page-header">Stock Opname</h1>
	    </div>
	    <!-- /.col-lg-12 -->
	</div>
	<div class="row">
		<div class="col-lg-12">
			<table style="float: right;">
				<tr>
					<td style="width: 125px;">
						Toko :
						<div class="form-group input-group">
							<span class="input-group-addon">
								<i class="fa fa-file"></i>
							</span>
							<select onchange="loadListBukti();" class="form-control" style='width: 200px;' name="cari_toko_kode" id="cari_toko_kode">
								<option value="-1">Pilih Toko</option>
							</select>
						</div>
					</td>
					<td>&nbsp;&nbsp;</td>
					<td style="width: 200px;">
						Tanggal :
						<div class="form-group input-group">
							<span class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</span>
							<input type="text" value="<?= date('Y-m-d'); ?>" name="search_tanggal" id="search_tanggal" class="form-control">
						</div>
					</td>
					<td>&nbsp;&nbsp;</td>
					<td>
						<button id="btn_hapus" style="float: right; padding: 7px 11px" fungsi="HapusDataStockopname()" class="btn btn-danger btn-sm ask-hapus" type="button">
							<i class="fa fa-times"></i>
						</button>
						<button id="btn_upload" style="float: right; padding: 7px 11px" onclick="LoadDataStockopname()" class="btn btn-success btn-sm" type="button">
							<i class="fa fa-search"></i>
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
					<button id="btn_upload" onclick="OpenFormImportData()" class="btn btn-success btn-sm" type="button">
						<i class="fa fa-upload"></i>
						&nbsp;&nbsp;Import Data
					</button>
					<button id="btn_upload" onclick="OpenProsesStockSystem()" class="btn btn-success btn-sm" type="button">
						<i class="fa fa-refresh"></i>
						&nbsp;&nbsp;Proses Penyesuaian
					</button>
					<button id="btn_upload" onclick="CetakStockopnameExcel()" class="btn btn-info btn-sm" type="button">
						<i class="fa fa-print"></i>
						&nbsp;&nbsp;Cetak Excel
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
					<div class="table-responsive table-stockopname">
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Form Import from Android -->
	<div class="modal fade" id="import-data" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        			<h4 class="modal-title" id="myModalLabel">Form Import Data</h4>
				</div>
				<div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form id="myForm" action="<?php echo base_url(); ?>index.php/stockopname/importdata" method="post" enctype="multipart/form-data">
                                <table class="table">
									<tr>
										<td>
											Tanggal :
											<div class="form-group input-group">
												<span class="input-group-addon">
													<i class="fa fa-calendar"></i>
												</span>
												<input type="text" style="width : 200px;" value="<?= date('Y-m-d'); ?>" name="tanggal_op" id="tanggal_op" class="form-control">
											</div>
										</td>
									</tr>
                                    <tr>
                                        <td colspan="4"><input type="file" size="60" name="fileupload"></td>
                                        <td align="right"><input class="btn btn-info btn-sm" type="submit" value="Upload File"></td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                    </div>
                    <div id="progress-data" style="display: none;">
                        <div class="progress progress-striped active">
                            <div class="progress-bar progress-bar-info" style="width: 20%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="20" role="progressbar">
                                <span class="sr-only">20% Complete</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
			</div>
		</div>
	</div>

	<!-- Form Proses Stock System -->
	<div class="modal fade" id="form-proses_stock_system" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        			<h4 class="modal-title" id="myModalLabel">Form Proses Stock System dan Penyesuaian</h4>
				</div>
				<div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
							<table class="table">
								<tr>
									<td>
										Bulan Stock:
										<div class="form-group input-group">
											<span class="input-group-addon">
												<i class="fa fa-calendar"></i>
											</span>
											<select name="stock_bulan" id="stock_bulan" class="form-control">
												<option <?php if(date('m')-1 == '01') echo "selected=\"selected\"" ?> value="01">Januari</option>
												<option <?php if(date('m')-1 == '02') echo "selected=\"selected\"" ?> value="02">Februari</option>
												<option <?php if(date('m')-1 == '03') echo "selected=\"selected\"" ?> value="03">Maret</option>
												<option <?php if(date('m')-1 == '04') echo "selected=\"selected\"" ?> value="04">April</option>
												<option <?php if(date('m')-1 == '05') echo "selected=\"selected\"" ?> value="05">Mei</option>
												<option <?php if(date('m')-1 == '06') echo "selected=\"selected\"" ?> value="06">Juni</option>
												<option <?php if(date('m')-1 == '07') echo "selected=\"selected\"" ?> value="07">Juli</option>
												<option <?php if(date('m')-1 == '08') echo "selected=\"selected\"" ?> value="08">Agustus</option>
												<option <?php if(date('m')-1 == '09') echo "selected=\"selected\"" ?> value="09">September</option>
												<option <?php if(date('m')-1 == '10') echo "selected=\"selected\"" ?> value="10">Oktober</option>
												<option <?php if(date('m')-1 == '11') echo "selected=\"selected\"" ?> value="11">November</option>
												<option <?php if(date('m')-1 == '12') echo "selected=\"selected\"" ?> value="12">Desember</option>
											</select>
										</div>
									</td>
									<td>
										Tahun Stock :
										<div class="form-group input-group">
											<span class="input-group-addon">
												<i class="fa fa-calendar"></i>
											</span>
											<input type="text" style="width : 150px;" value="<?php echo date('Y'); ?>" class="form-control" id="stock_tahun" />
										</div>
									</td>
								</tr>
							</table>
                        </div>
                    </div>
                    <div id="progress-data" style="display: none;">
                        <div class="progress progress-striped active">
                            <div class="progress-bar progress-bar-info" style="width: 20%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="20" role="progressbar">
                                <span class="sr-only">20% Complete</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
					<button id="btn_prosesstocksystem" onclick="ProsesStockSystem()" class="btn btn-success btn-sm" type="button">
						<i class="fa fa-refresh"></i>
						&nbsp;&nbsp;Proses Stock System
					</button>
					<img src="<?= base_url() ?>/images/loader.gif" id="loader-formstocksystem"  style="width: 30px; display: none;" />
                </div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		OpenMenu();
		loadListToko();btn_prosesstocksystem
		// LoadListDataBarang();
		//loadListRak();
		
		$('#search_tanggal').datepicker({
			format: 'yyyy-mm-dd'
		});

		$('#tanggal_op').datepicker({
			format: 'yyyy-mm-dd'
		});

		$('.datepicker tbody').on('click', function(){  $('.datepicker').hide() });

		$('.ask-hapus').jConfirmAction();

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
				if(response.responseText == "Import file selesai"){
                    // $("#message").html("<font color='green'>"+response.responseText+"</font>");
                    alert(response.responseText);
					LoadDataStockopname();
				}else{
					// console.log(response.responseText);
					var resArr = json_decode(base64_decode(response.responseText));
					console.log(resArr);
				}
		        
		        $("#progress-data").hide();
		    },
		    error: function(){
		        $("#message").html("<font color='red'> ERROR: unable to upload files</font>");
		 
		    }
		};
		$("#myForm").ajaxForm(options);
	});
	
	function LoadDataStockopname(){
		$('#progres-main').show();
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/stockopname/getdatastockopname",
			data: "toko_kode="+$('#cari_toko_kode').val()+"&tanggal="+$('#search_tanggal').val(),
			success: function(msg){
				$(".table-stockopname").html(msg);
				table = $('#dataTables-stockopname').dataTable();
				$('#progres-main').hide();
				
				/*$('#dataTables-stockopname tbody').on( 'click', 'tr', function () {
			        if ( $(this).hasClass('active') ) {
			            $(this).removeClass('active');
			        }else {
			            $('#dataTables-stockopname tr.active').removeClass('active');
			            $(this).addClass('active');
			        }
			    } );*/
				// $('#btn_edit').show();
				// $('#btn_simpan').hide();
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
				
				loadListBukti();
			}
		});
	}

	function OpenFormImportData(){
		$("#import-data").modal();
	}
	
	function OpenProsesStockSystem(){
		$("#form-proses_stock_system").modal();
	}

	function ProsesStockSystem(){
		$("#btn_prosesstocksystem").hide();
		$("#loader-formstocksystem").show();
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/stockopname/prosesstocksystem",
			data: "bulan="+$("#stock_bulan").val()+"&tahun="+$("#stock_tahun").val()+"&toko_kode="+$('#cari_toko_kode').val()+"&tanggal="+$('#search_tanggal').val(),
			success: function(msg){
				$("#btn_prosesstocksystem").show();
				$("#loader-formstocksystem").hide();

				$("#form-proses_stock_system").modal('hide');
				LoadDataStockopname();
			}
		});
	}

	function HapusDataStockopname(){
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/stockopname/hapusdatastockopname",
			data: "toko_kode="+$('#cari_toko_kode').val()+"&tanggal="+$('#search_tanggal').val(),
			success: function(msg){
				LoadDataStockopname();
			}
		});
	}
</script>