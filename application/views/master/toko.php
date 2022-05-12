<div id="page-wrapper">
	<div class="row">
	    <div class="col-lg-6">
	        <h1 style="margin-top: 15px;" class="page-header">Master Toko</h1>
	    </div>
	    <!-- /.col-lg-12 -->
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<button id="btn_upload" onclick="openFormTambahToko()" class="btn btn-primary btn-sm" type="button">
						<i class="fa fa-plus"></i>
						&nbsp;&nbsp;Tambah
					</button>
					<button id="btn_upload" onclick="openFormEditToko()" class="btn btn-success btn-sm" type="button">
						<i class="fa fa-edit"></i>
						&nbsp;&nbsp;Edit
					</button>
					<button id="btn_upload" fungsi="HapusToko()" class="btn btn-danger btn-sm ask-toko" type="button">
						<i class="fa fa-times"></i>
						&nbsp;&nbsp;Hapus
					</button>
					<div id="progres-main-toko" style="width: 150px; float: right; display: none;">
						<div class="progress progress-striped active">
							<div class="progress-bar progress-bar-info" style="width: 100%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="20" role="progressbar">
								<span class="sr-only">20% Complete</span>
							</div>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<div class="table-responsive table-toko">
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Form popup untuk tambah pelanggan -->
	<div class="modal fade" id="form-toko" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        			<h4 class="modal-title" id="myModalLabel">Form Toko</h4>
				</div>
				<div class="modal-body">
					<table width="100%">
						<tr>
							<td>
								Nama Toko :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<input type="text" placeholder="Nama Toko" name="nama_toko" id="nama_toko" class="form-control">
									<input type="text" placeholder="Kode Toko"name="kode_toko" id="kode_toko" class="form-control">
									<input type="hidden" value="i" name="mode_form_toko" id="mode_form_toko" class="form-control">
								</div>
								Kota :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<input type="text" placeholder="Kota" name="toko_kota" id="toko_kota" class="form-control">
								</div>
								Alamat :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<input type="text" placeholder="Alamat" name="alamat_toko" id="alamat_toko" class="form-control">
								</div>
							</td>
							<td>&nbsp;&nbsp;</td>
							<td valign="top">
								NPWP :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<input type="text" placeholder="NPWP" name="toko_npwp" id="toko_npwp" class="form-control">
								</div>
								No Telp :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<input type="text" placeholder="No Telp" name="toko_notelp" id="toko_notelp" class="form-control">
								</div>
							</td>
						</tr>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" onclick="clearForm()" class="btn btn-default">Reset</button>
					<button type="button" class="btn btn-default" onclick="clearForm()" data-dismiss="modal">Close</button>
					<img src="<?= base_url() ?>/images/loader.gif" id="loader-form"  style="width: 30px; display: none;" />
			        <button type="button" id="btn-simpan" onclick="simpantoko()" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;&nbsp;Simpan</button>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		OpenMenu();
		
		LoadDataToko();
	});
	
	function LoadDataToko(){
		$('#progres-main-toko').show();
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/toko/getdatatoko",
			data: "",
			success: function(msg){
				$(".table-toko").html(msg);
				table_toko = $('#dataTables-toko').dataTable();
				$('#progres-main-toko').hide();
				
				$('#dataTables-toko tbody').on( 'click', 'tr', function () {
			        if ( $(this).hasClass('active') ) {
			            $(this).removeClass('active');
			        }else {
			            table_toko.$('tr.active').removeClass('active');
			            $(this).addClass('active');
			        }
			    } );
			}
		});
	}
	
	function openFormTambahToko(){
		$("#form-toko").modal("show");
	}
	
	function simpantoko(){
		$('#loader-form').show();
		$('#btn-simpan').hide();
		
		var toko_kode = $("#kode_toko").val();
		var toko_nama = $("#nama_toko").val();
		var toko_kota = $("#toko_kota").val();
		var toko_alamat = $("#alamat_toko").val();
		var toko_npwp = $("#toko_npwp").val();
		var toko_notelp = $("#toko_notelp").val();
		var toko_mode = $("#mode_form_toko").val();
		$.ajax({
			type: "POST",
			url: "<?= base_url(); ?>index.php/toko/simpantoko",
			data: "nama="+toko_nama+"&mode="+toko_mode+"&kode="+toko_kode+"&alamat="+toko_alamat+"&kota="+toko_kota+"&npwp="+toko_npwp+"&notelp="+toko_notelp,
			success: function(msg){
				clearForm();
				$('#loader-form').hide();
				$('#btn-simpan').show();
				LoadDataToko();
				
				$("#form-toko").modal("hide");
			}
		});
	}
	
	function HapusToko(){
		var data = table_toko.$('tr.active').attr("data");
		if(typeof data == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var dataArr = json_decode(base64_decode(data));
			
			$.ajax({
				type: "POST",
				url: "<?= base_url() ?>index.php/toko/hapustoko",
				data: "kode="+dataArr['kode'],
				success: function(msg){
					LoadDataToko();
				}
			});
		}
	}
	
	function openFormEditToko(){
		var data = table_toko.$('tr.active').attr("data");
		if(typeof data == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var dataArr = json_decode(base64_decode(data));
			
			$("#kode_toko").val(dataArr['kode']);
			$("#nama_toko").val(dataArr['nama']);
			$("#alamat_toko").val(dataArr['alamat']);
			$("#toko_kota").val(dataArr['kota']);
			$("#toko_npwp").val(dataArr['npwp']);
			$("#toko_notelp").val(dataArr['notelp']);
			$("#mode_form_toko").val("e");
			
			$("#form-toko").modal("show");
		}
	}
	
	function clearForm(){
		$("#kode_toko").val('');
		$("#nama_toko").val('');
		$("#alamat_toko").val('');
		$("#toko_kota").val('');
		$("#toko_npwp").val('');
		$("#toko_notelp").val('');
		$("#mode_form_toko").val("i");
		
		$("#btn_cancel_toko").hide();
	}
</script>