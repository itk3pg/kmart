<div id="page-wrapper">
	<div class="row">
	    <div class="col-lg-12">
	        <h1 style="margin-top: 15px;" class="page-header">Jasa</h1>
	    </div>
	    <!-- /.col-lg-12 -->
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<button id="btn_upload" onclick="openFormJasa(1)" class="btn btn-info btn-sm" type="button">
						<i class="fa fa-plus"></i>
						&nbsp;&nbsp;Tambah
					</button>
					<button id="btn_upload" onclick="openFormEditJasa()" class="btn btn-success btn-sm" type="button">
						<i class="fa fa-edit"></i>
						&nbsp;&nbsp;Edit
					</button>
					<button id="btn_upload" fungsi="HapusJasa()" class="btn btn-danger btn-sm ask-jasa" type="button">
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
					<div class="table-responsive table-jasa">
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Form popup untuk tambah barang -->
	<div class="modal fade" id="form-jasa" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        			<h4 class="modal-title" id="myModalLabel">Form Jasa</h4>
				</div>
				<div class="modal-body">
					Kode Jasa :
					<div class="form-group input-group">
						<span class="input-group-addon">
							<i class="fa fa-file"></i>
						</span>
						<input type="checkbox" checked name="jasa_otomatis" onclick="cekOtomatis()" id="jasa_otomatis" /> Otomatis
						<input type="hidden" name="jasa_mode" id="jasa_mode" value="i" />
						<input type="text" placeholder="Kode Jasa" readonly name="jasa_kd_jasa" id="jasa_kd_jasa" class="form-control">
					</div>
					Nama Jasa :
					<div class="form-group input-group">
						<span class="input-group-addon">
							<i class="fa fa-file"></i>
						</span>
						<input type="text" placeholder="Nama Jasa" name="jasa_nama_jasa" id="jasa_nama_jasa" class="form-control">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" onclick="clearForm(1)" class="btn btn-default">Reset</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<img src="<?= base_url() ?>images/loader.gif" id="loader-form"  style="width: 30px; display: none;" />
			        <button type="button" id="btn-simpan" onclick="simpanjasa()" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;&nbsp;Simpan</button>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		OpenMenu();
		LoadDataJasa();
		
		$('.ask-jasa').jConfirmAction();
	});
	
	function LoadDataJasa(){
		$('#progres-main').show();
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/jasa/getdatajasa",
			data: "",
			success: function(msg){
				$(".table-jasa").html(msg);
				table = $('#dataTables-jasa').dataTable();
				$('#progres-main').hide();
				
				$('#dataTables-jasa tbody').on( 'click', 'tr', function () {
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
	
	function openFormJasa(mode){
		$('#form-jasa').modal('show');
		var ts = Math.round((new Date()).getTime() / 1000);
		$("#jasa_kd_jasa").val(ts);
		$("#jasa_mode").val("i");
	}
	
	function cekOtomatis(){
		if($("#jasa_mode").val() == "i"){
			if($("#jasa_otomatis").is(':checked')){
				var ts = Math.round((new Date()).getTime() / 1000);
				$("#jasa_kd_jasa").val(ts);
				$("#jasa_kd_jasa").attr("readonly","readonly");
			}else{
				$("#jasa_kd_jasa").removeAttr("readonly");
				$("#jasa_kd_jasa").val("");
			}
		}
	}
	
	function simpanjasa(){
		$("#loader-form").show();
		$("#btn-simpan").hide();
		
		var kode = $("#jasa_kd_jasa").val();
		var nama_jasa = $("#jasa_nama_jasa").val();
		
		var mode_form = $("#jasa_mode").val();
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/jasa/simpanjasa",
			data: "kode="+kode+"&nama_jasa="+nama_jasa+"&mode="+mode_form,
			success: function(msg){
				LoadDataJasa();
				$("#loader-form").hide();
				$("#btn-simpan").show();
				$("#jasa_mode").val("i");
				$('#form-jasa').modal('hide');
			}
		});
	}
	
	function HapusJasa(){
		var data = table.$('tr.active').attr("data");
		if(typeof data == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var dataArr = json_decode(base64_decode(data));
			
			$.ajax({
				type: "POST",
				url: "<?= base_url() ?>index.php/jasa/hapusjasa",
				data: "kode="+dataArr['kode'],
				success: function(msg){
					LoadDataJasa();
				}
			});
		}
	}
	
	function openFormEditJasa(){
		var data = table.$('tr.active').attr("data");
		if(typeof data == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var dataArr = json_decode(base64_decode(data));
			
			$("#jasa_kd_jasa").val(dataArr['kode']);
			$("#jasa_nama_jasa").val(dataArr['nama_jasa']);
			$("#jasa_mode").val("e");
			
			$("#jasa_kd_jasa").attr("readonly","readonly");
			$('#form-jasa').modal('show');
		}
	}
	
	function clearForm(mode){
		var ts = Math.round((new Date()).getTime() / 1000);
		
		$("#jasa_kd_jasa").val(ts);
		$("#jasa_nama_jasa").val("");
		$("#jasa_mode").val("i");
	}
</script>