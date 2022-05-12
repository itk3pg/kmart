<div id="page-wrapper">
	<div class="row">
	    <div class="col-lg-12">
	        <h1 style="margin-top: 15px;" class="page-header">Master Satuan Bahan Baku</h1>
	    </div>
	    <!-- /.col-lg-12 -->
	</div>
	<div class="row">
		<div class="col-lg-6">
			<table width="100%">
				<tr>
					<td>
						<div class="form-group input-group">
							<span class="input-group-addon">
								<i class="fa fa-file"></i>
							</span>
							<input type="text" placeholder="Nama Satuan" name="nama_satuan" id="nama_satuan" class="form-control">
							<input type="hidden" name="kode_satuan" id="kode_satuan" class="form-control">
							<input type="hidden" value="i" name="mode_form" id="mode_form" class="form-control">
						</div>
					</td>
					<td>&nbsp;</td>
					<td valign="top">
						<button id="btn_tambah" onclick="simpansatuan()" class="btn btn-info btn-sm" type="button">
							<i class="fa fa-plus"></i>
							&nbsp;&nbsp;Simpan
						</button>
						<button style="display: none;" id="btn_cancel" onclick="canceledit()" class="btn btn-danger btn-sm" type="button">
							<i class="fa fa-times"></i>
							&nbsp;&nbsp;Cancel
						</button>
					</td>
					<td align="left" valign="top">
						<img style="width: 30px; display: none;" id="loader-tambah" src="<?php echo base_url(); ?>images/loader.gif" />
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<button id="btn_upload" onclick="openFormEditSatuan()" class="btn btn-success btn-sm" type="button">
						<i class="fa fa-edit"></i>
						&nbsp;&nbsp;Edit
					</button>
					<button id="btn_upload" fungsi="HapusSatuan()" class="btn btn-danger btn-sm ask-satuan" type="button">
						<i class="fa fa-times"></i>
						&nbsp;&nbsp;Hapus
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
					<div class="table-responsive table-satuan">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		OpenMenu();
		LoadDataSatuan();
		
		$('.ask-satuan').jConfirmAction();
	});
	
	function LoadDataSatuan(){
		$('#progres-main').show();
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/satuanbarang/getdatasatuan",
			data: "",
			success: function(msg){
				$(".table-satuan").html(msg);
				table = $('#dataTables-satuan').dataTable();
				$('#progres-main').hide();
				
				$('#dataTables-satuan tbody').on( 'click', 'tr', function () {
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
	
	function simpansatuan(){
		$('#loader-tambah').show();
		$.ajax({
			type: "POST",
			url: "<?= base_url(); ?>index.php/satuanbarang/simpansatuan",
			data: "nama="+$("#nama_satuan").val()+"&mode="+$("#mode_form").val()+"&kode="+$("#kode_satuan").val(),
			success: function(msg){
				$("#nama_satuan").val("");
				$("#mode_form").val("i");
				$("#btn_cancel").hide();
				$('#loader-tambah').hide();
				LoadDataSatuan();
			}
		});
	}
	
	function HapusSatuan(){
		var data = table.$('tr.active').attr("data");
		if(typeof data == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var dataArr = json_decode(base64_decode(data));
			
			$.ajax({
				type: "POST",
				url: "<?= base_url() ?>index.php/satuanbarang/hapussatuan",
				data: "kode="+dataArr['kode'],
				success: function(msg){
					LoadDataSatuan();
				}
			});
		}
	}
	
	function openFormEditSatuan(){
		var data = table.$('tr.active').attr("data");
		if(typeof data == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var dataArr = json_decode(base64_decode(data));
			
			$("#kode_satuan").val(dataArr['kode']);
			$("#nama_satuan").val(dataArr['nama']);
			$("#mode_form").val("e");
			
			$("#btn_cancel").show();
		}
	}
</script>