<div id="page-wrapper">
	<div class="row">
	    <div class="col-lg-12">
	        <h1 style="margin-top: 15px;" class="page-header">Data Master Cash Budget</h1>
	    </div>
	    <!-- /.col-lg-12 -->
	</div>
	<div class="row">
		<div class="col-lg-8">
			<div class="panel panel-default">
				<div class="panel-heading">
					&nbsp;
                    <button id="btn_tambah" onclick="openFormCashbudget(1)" class="btn btn-info btn-sm" type="button">
						<i class="fa fa-plus"></i>
						&nbsp;&nbsp;Tambah
					</button>
					<button id="btn_tambah" onclick="openFormCashbudget(2)" class="btn btn-warning btn-sm" type="button">
						<i class="fa fa-edit"></i>
						&nbsp;&nbsp;Edit
					</button>
					<button id="btn_hapus" fungsi="HapusCashbudget()" class="btn btn-danger btn-sm ask" type="button">
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
					<div class="table-responsive table-cashbudget">
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Form popup untuk tambah cashbudget -->
	<div class="modal fade" id="form-cashbudget" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        			<h4 class="modal-title" id="myModalLabel">Form Master Cash Budget</h4>
				</div>
				<div class="modal-body">
					Kode Cash Budget :
					<div class="form-group input-group">
						<span class="input-group-addon">
							<i class="fa fa-file"></i>
						</span>
						<input type="hidden" name="cashbudget_mode" id="cashbudget_mode" value="1" />
						<input type="text" style="text-align: right;" placeholder="Kode Cash Budget" name="cashbudget_kd_cb" id="cashbudget_kd_cb" class="form-control">
					</div>
					Keterangan :
					<div class="form-group input-group">
						<span class="input-group-addon">
							<i class="fa fa-file"></i>
						</span>
						<input type="text" onkeyup="toUpper('cashbudget_keterangan')" style="text-align: right;" placeholder="Keterangan" name="cashbudget_keterangan" id="cashbudget_keterangan" class="form-control">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" onclick="clearForm(1)" class="btn btn-default">Reset</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<img src="<?= base_url() ?>/images/loader.gif" id="loader-form"  style="width: 30px; display: none;" />
			        <button type="button" id="btn-simpan" onclick="simpancashbudget()" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;&nbsp;Simpan</button>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		OpenMenu();
		
		LoadDataCashbudget();
		
		$('.ask').jConfirmAction();
	});
	
	function LoadDataCashbudget(){
		$('#progres-main').show();
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/m_cashbudget/getdatacashbudget",
			data: "",
			success: function(msg){
				$(".table-cashbudget").html(msg);
				table = $('#dataTables-cashbudget').dataTable();
				$('#progres-main').hide();
				
				$('#dataTables-cashbudget tbody').on( 'click', 'tr', function () {
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
	
	function openFormCashbudget(mode){
		$('#form-cashbudget').modal('show');
		if(mode == "2"){
			var kd_cb = table.$('tr.active').attr("kd_cb");
			$("#cashbudget_kd_cb").val(kd_cb);
		}
	}
	
	function simpancashbudget(){
		$("#btn-simpan").hide();
		$("#loader-form").show();
		var kd_cb = $("#cashbudget_kd_cb").val();
		var keterangan = $("#cashbudget_keterangan").val();
		
		$.ajax({
			type: "POST",
			url: "<?= base_url(); ?>index.php/m_cashbudget/simpancashbudget",
			data: "kd_cb="+kd_cb+"&keterangan="+encodeURIComponent(keterangan),
			success: function(msg){
				$("#btn-simpan").show();
				$("#loader-form").hide();
				clearForm(1);
				$('#form-cashbudget').modal('hide');
				
				LoadDataCashbudget();
			},
			error: function(xhr,status,error){
				alert("Data gagal disimpan");
				
				$("#btn-simpan").show();
				$("#loader-form").hide();
			}
		});
	}
	
	function HapusCashbudget(){
		var kd_cb = table.$('tr.active').attr("kd_cb");
		
		if(typeof kd_cb == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			$.ajax({
				type: "POST",
				url: "<?= base_url(); ?>index.php/m_cashbudget/hapuscashbudget",
				data: "kd_cb="+kd_cb,
				success: function(msg){
					LoadDataCashbudget();
				}
			});
		}
	}
	
	function clearForm(mode){
		$("#cashbudget_kd_cb").val("");
		$("#cashbudget_keterangan").val("");
	}
</script>