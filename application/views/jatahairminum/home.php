<style>
	.question{z-index:1151 !important;}
	.datepicker{z-index:1151 !important;}
</style>
<div id="page-wrapper">
	<div class="row">
	    <div class="col-lg-12">
	        <h1 style="margin-top: 15px;" class="page-header">Data Jatah Air Minum</h1>
	    </div>
	    <!-- /.col-lg-12 -->
	</div>
	<div class="row">
		<div class="col-lg-12">
	    	<div id="message"></div>
	    	<form id="myForm" action="<?php echo base_url(); ?>index.php/jatahairminum/upload" method="post" enctype="multipart/form-data">
				<table width="100%">
					<tr>
						<td style="width: 90px;">
							<input style="width: 80px;" type="text" name="upload_tahun" id="upload_tahun" value="<?= date("Y"); ?>" class="form-control" />
						</td>
						<td style="width: 125px;">
							<select style="width: 115px;" class="form-control" name="upload_bulan" id="upload_tahun">
								<option <?php if(date('m') == '01') echo "selected=\"selected\"" ?> value="01">Januari</option>
								<option <?php if(date('m') == '02') echo "selected=\"selected\"" ?> value="02">Februari</option>
								<option <?php if(date('m') == '03') echo "selected=\"selected\"" ?> value="03">Maret</option>
								<option <?php if(date('m') == '04') echo "selected=\"selected\"" ?> value="04">April</option>
								<option <?php if(date('m') == '05') echo "selected=\"selected\"" ?> value="05">Mei</option>
								<option <?php if(date('m') == '06') echo "selected=\"selected\"" ?> value="06">Juni</option>
								<option <?php if(date('m') == '07') echo "selected=\"selected\"" ?> value="07">Juli</option>
								<option <?php if(date('m') == '08') echo "selected=\"selected\"" ?> value="08">Agustus</option>
								<option <?php if(date('m') == '09') echo "selected=\"selected\"" ?> value="09">September</option>
								<option <?php if(date('m') == '10') echo "selected=\"selected\"" ?> value="10">Oktober</option>
								<option <?php if(date('m') == '11') echo "selected=\"selected\"" ?> value="11">November</option>
								<option <?php if(date('m') == '12') echo "selected=\"selected\"" ?> value="12">Desember</option>
							</select>
						</td>
						<td>&nbsp;</td>
						<td><input type="file" size="60" name="fileupload"></td>
						<td align="right"><input class="btn btn-info btn-sm" type="submit" value="Upload File"></td>
					</tr>
				</table>
			</form>
			<!--<div id="progress">
				<div id="bar"></div>
				<div id="percent">0%</div>
			</div>-->
			<div id="progress-data" style="display: none;">
				<div class="progress progress-striped active">
					<div class="progress-bar progress-bar-info" style="width: 20%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="20" role="progressbar">
						<span class="sr-only">20% Complete</span>
					</div>
				</div>
			</div>
	    </div>
		<div class="col-lg-12">
			<table style="float: right;">
				<tr>
					<td style="width: 125px;">
						<input style="width: 115px;" type="text" name="tahun" id="tahun" value="<?= date("Y"); ?>" class="form-control" />
					</td>
					<td style="width: 125px;">
						<select style="width: 115px;" class="form-control" name="bulan" id="bulan">
							<option <?php if(date('m') == '01') echo "selected=\"selected\"" ?> value="01">Januari</option>
							<option <?php if(date('m') == '02') echo "selected=\"selected\"" ?> value="02">Februari</option>
							<option <?php if(date('m') == '03') echo "selected=\"selected\"" ?> value="03">Maret</option>
							<option <?php if(date('m') == '04') echo "selected=\"selected\"" ?> value="04">April</option>
							<option <?php if(date('m') == '05') echo "selected=\"selected\"" ?> value="05">Mei</option>
							<option <?php if(date('m') == '06') echo "selected=\"selected\"" ?> value="06">Juni</option>
							<option <?php if(date('m') == '07') echo "selected=\"selected\"" ?> value="07">Juli</option>
							<option <?php if(date('m') == '08') echo "selected=\"selected\"" ?> value="08">Agustus</option>
							<option <?php if(date('m') == '09') echo "selected=\"selected\"" ?> value="09">September</option>
							<option <?php if(date('m') == '10') echo "selected=\"selected\"" ?> value="10">Oktober</option>
							<option <?php if(date('m') == '11') echo "selected=\"selected\"" ?> value="11">November</option>
							<option <?php if(date('m') == '12') echo "selected=\"selected\"" ?> value="12">Desember</option>
						</select>
					</td>
					<td>
						<button id="btn_upload" onclick="LoadDataJatahAirMinum()" class="btn btn-info" type="button">
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
					<div id="info-content"></div>
					<div id="progres-main" style="width: 150px; float: right; display: none;">
						<div class="progress progress-striped active">
							<div class="progress-bar progress-bar-info" style="width: 100%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="20" role="progressbar">
								<span class="sr-only">20% Complete</span>
							</div>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<div class="table-responsive table-jatahairminum">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		OpenMenu();
		
		$('#pembayaran_tanggal').datepicker({
			format: 'yyyy-mm-dd'
		});
		
		$('#tanggal').datepicker({
			format: 'yyyy-mm-dd'
		});
		
		LoadDataJatahAirMinum();
		
		$('.ask').jConfirmAction();
		$('.datepicker tbody').on('click', function(){  $('.datepicker').hide() });
		
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
		        $("#message").html(response.responseText);
		        
		        $("#progress-data").hide();
		        LoadDataJatahAirMinum();
		    },
		    error: function(){
		        $("#message").html("<font color='red'> ERROR: unable to upload files</font>");
		 
		    }
		};
		$("#myForm").ajaxForm(options);
	});
	
	function LoadDataJatahAirMinum(){
		$('#progres-main').show();
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/jatahairminum/getdatajatahairminum",
			data: "tahun="+$('#tahun').val()+"&bulan="+$('#bulan').val(),
			success: function(msg){
				getJumlahDataJatahAirMinum();
				$(".table-jatahairminum").html(msg);
				$('#dataTables-jatahairminum').dataTable();
				$('#progres-main').hide();
				
				$('#dataTables-jatahairminum tbody').on( 'click', 'tr', function () {
			        if ( $(this).hasClass('active') ) {
			            $(this).removeClass('active');
			        }else {
			            table.$('tr.active').removeClass('active');
			            $(this).addClass('active');
			        }
			    } );
			}
		});
	}
	
	function getJumlahDataJatahAirMinum(){
		$('#progres-main').show();
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/jatahairminum/getjumlahhari",
			data: "tahun="+$('#tahun').val()+"&bulan="+$('#bulan').val(),
			success: function(msg){
				var result = msg.split("_");
				$("#info-content").html("Jumlah Hari = "+result[0]+" | Jumlah Botol = "+result[1]);
			}
		});
	}
</script>