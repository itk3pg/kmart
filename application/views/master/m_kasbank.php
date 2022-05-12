<div id="page-wrapper">
	<div class="row">
	    <div class="col-lg-12">
	        <h1 style="margin-top: 15px;" class="page-header">Data Master Kas/Bank</h1>
	    </div>
	    <!-- /.col-lg-12 -->
	</div>
	<div class="row">
		<div class="col-lg-8">
			<div class="panel panel-default">
				<div class="panel-heading">
					&nbsp;
                    <button id="btn_tambah" onclick="openFormKasbank(1)" class="btn btn-info btn-sm" type="button">
						<i class="fa fa-plus"></i>
						&nbsp;&nbsp;Tambah
					</button>
					<button id="btn_hapus" fungsi="HapusKasbank()" class="btn btn-danger btn-sm ask" type="button">
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
					<div class="table-responsive table-kasbank">
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Form popup untuk tambah kasbank -->
	<div class="modal fade" id="form-kasbank" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        			<h4 class="modal-title" id="myModalLabel">Form Master Kas/Bank</h4>
				</div>
				<div class="modal-body">
					Kode Kas/Bank :
					<div class="form-group input-group">
						<span class="input-group-addon">
							<i class="fa fa-file"></i>
						</span>
						<input type="hidden" name="kasbank_mode" id="kasbank_mode" value="1" />
						<input type="text" style="text-align: right;" placeholder="Kode Kas/Bank" name="kasbank_kd_kb" id="kasbank_kd_kb" class="form-control">
					</div>
					Keterangan :
					<div class="form-group input-group">
						<span class="input-group-addon">
							<i class="fa fa-file"></i>
						</span>
						<input type="text" onkeyup="toUpper('kasbank_keterangan')" style="text-align: right;" placeholder="Keterangan" name="kasbank_keterangan" id="kasbank_keterangan" class="form-control">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" onclick="clearForm(1)" class="btn btn-default">Reset</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<img src="<?= base_url() ?>/images/loader.gif" id="loader-form"  style="width: 30px; display: none;" />
			        <button type="button" id="btn-simpan" onclick="simpankasbank()" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;&nbsp;Simpan</button>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		OpenMenu();
		
		LoadDataKasbank();
		
		$('.ask').jConfirmAction();
	});
	
	function LoadDataKasbank(){
		$('#progres-main').show();
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/m_kasbank/getdatakasbank",
			data: "",
			success: function(msg){
				$(".table-kasbank").html(msg);
				table = $('#dataTables-kasbank').dataTable();
				$('#progres-main').hide();
				
				$('#dataTables-kasbank tbody').on( 'click', 'tr', function () {
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
	
	function openFormKasbank(mode){
		$('#form-kasbank').modal('show');
	}
	
	function simpankasbank(){
		$("#btn-simpan").hide();
		$("#loader-form").show();
		var kd_kb = $("#kasbank_kd_kb").val();
		var keterangan = $("#kasbank_keterangan").val();
		
		$.ajax({
			type: "POST",
			url: "<?= base_url(); ?>index.php/m_kasbank/simpankasbank",
			data: "kd_kb="+kd_kb+"&keterangan="+keterangan,
			success: function(msg){
				$("#btn-simpan").show();
				$("#loader-form").hide();
				clearForm(1);
				$('#form-kasbank').modal('hide');
				
				LoadDataKasbank();
			}
		});
	}
	
	function HapusKasbank(){
		var kd_kb = table.$('tr.active').attr("kd_kb");
		
		if(typeof kd_kb == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			$.ajax({
				type: "POST",
				url: "<?= base_url(); ?>index.php/m_kasbank/hapuskasbank",
				data: "kd_kb="+kd_kb,
				success: function(msg){
					LoadDataKasbank();
				}
			});
		}
	}
	
	function clearForm(mode){
		$("#kasbank_kd_kb").val("");
		$("#kasbank_keterangan").val("");
	}
</script>