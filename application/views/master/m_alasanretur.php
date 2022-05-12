<div id="page-wrapper">
	<div class="row">
	    <div class="col-lg-12">
	        <h1 style="margin-top: 15px;" class="page-header">Data Master Alasan Retur</h1>
	    </div>
	    <!-- /.col-lg-12 -->
	</div>
	<div class="row">
		<div class="col-lg-8">
			<div class="panel panel-default">
				<div class="panel-heading">
					&nbsp;
                    <button id="btn_tambah" onclick="openFormAlasanretur(1)" class="btn btn-info btn-sm" type="button">
						<i class="fa fa-plus"></i>
						&nbsp;&nbsp;Tambah
					</button>
					<button id="btn_hapus" fungsi="HapusAlasanretur()" class="btn btn-danger btn-sm ask" type="button">
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
					<div class="table-responsive table-alasanretur">
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Form popup untuk tambah alasanretur -->
	<div class="modal fade" id="form-alasanretur" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        			<h4 class="modal-title" id="myModalLabel">Form Master Alasan Retur</h4>
				</div>
				<div class="modal-body">
					Kode Alasan Retur :
					<div class="form-group input-group">
						<span class="input-group-addon">
							<i class="fa fa-file"></i>
						</span>
						<input type="hidden" name="alasanretur_mode" id="alasanretur_mode" value="1" />
						<input type="text" style="text-align: right;" placeholder="Kode Alasan Retur" name="alasanretur_kd_alasanretur" id="alasanretur_kd_alasanretur" class="form-control">
					</div>
					Nama Alasan Retur :
					<div class="form-group input-group">
						<span class="input-group-addon">
							<i class="fa fa-file"></i>
						</span>
						<input type="text" onkeyup="toUpper('alasanretur_keterangan')" style="text-align: right;" placeholder="Keterangan" name="alasanretur_keterangan" id="alasanretur_keterangan" class="form-control">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" onclick="clearForm(1)" class="btn btn-default">Reset</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<img src="<?= base_url() ?>/images/loader.gif" id="loader-form"  style="width: 30px; display: none;" />
			        <button type="button" id="btn-simpan" onclick="simpanalasanretur()" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;&nbsp;Simpan</button>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		OpenMenu();
		
		LoadDataAlasanretur();
		
		$('.ask').jConfirmAction();
	});
	
	function LoadDataAlasanretur(){
		$('#progres-main').show();
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/m_alasanretur/getdataalasanretur",
			data: "",
			success: function(msg){
				$(".table-alasanretur").html(msg);
				table = $('#dataTables-alasanretur').dataTable();
				$('#progres-main').hide();
				
				$('#dataTables-alasanretur tbody').on( 'click', 'tr', function () {
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
	
	function openFormAlasanretur(mode){
		$('#form-alasanretur').modal('show');
	}
	
	function simpanalasanretur(){
		$("#btn-simpan").hide();
		$("#loader-form").show();
		var kd_alasanretur = $("#alasanretur_kd_alasanretur").val();
		var keterangan = $("#alasanretur_keterangan").val();
		
		$.ajax({
			type: "POST",
			url: "<?= base_url(); ?>index.php/m_alasanretur/simpanalasanretur",
			data: "kode="+kd_alasanretur+"&keterangan="+keterangan,
			success: function(msg){
				$("#btn-simpan").show();
				$("#loader-form").hide();
				clearForm(1);
				$('#form-alasanretur').modal('hide');
				
				LoadDataAlasanretur();
			}
		});
	}
	
	function HapusAlasanretur(){
		var kd_alasanretur = table.$('tr.active').attr("kd_alasanretur");
		
		if(typeof kd_alasanretur == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			$.ajax({
				type: "POST",
				url: "<?= base_url(); ?>index.php/m_alasanretur/hapusalasanretur",
				data: "kode="+kd_alasanretur,
				success: function(msg){
					LoadDataAlasanretur();
				}
			});
		}
	}
	
	function clearForm(mode){
		$("#alasanretur_kd_alasanretur").val("");
		$("#alasanretur_keterangan").val("");
	}
</script>