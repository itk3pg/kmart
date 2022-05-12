<div id="page-wrapper">
	<div class="row">
	    <div class="col-lg-12">
	        <h1 style="margin-top: 15px;" class="page-header">Data Master Bank</h1>
	    </div>
	    <!-- /.col-lg-12 -->
	</div>
	<div class="row">
		<div class="col-lg-8">
			<div class="panel panel-default">
				<div class="panel-heading">
					&nbsp;
                    <button id="btn_tambah" onclick="openFormBank(1)" class="btn btn-info btn-sm" type="button">
						<i class="fa fa-plus"></i>
						&nbsp;&nbsp;Tambah
					</button>
					<button id="btn_hapus" fungsi="HapusBank()" class="btn btn-danger btn-sm ask" type="button">
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
					<div class="table-responsive table-bank">
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Form popup untuk tambah bank -->
	<div class="modal fade" id="form-bank" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        			<h4 class="modal-title" id="myModalLabel">Form Master Bank</h4>
				</div>
				<div class="modal-body">
					Kode Bank :
					<div class="form-group input-group">
						<span class="input-group-addon">
							<i class="fa fa-file"></i>
						</span>
						<input type="hidden" name="bank_mode" id="bank_mode" value="1" />
						<input type="text" style="text-align: right;" placeholder="Kode Bank" name="bank_kd_bank" id="bank_kd_bank" class="form-control">
					</div>
					Nama Bank :
					<div class="form-group input-group">
						<span class="input-group-addon">
							<i class="fa fa-file"></i>
						</span>
						<input type="text" onkeyup="toUpper('bank_keterangan')" style="text-align: right;" placeholder="Keterangan" name="bank_keterangan" id="bank_keterangan" class="form-control">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" onclick="clearForm(1)" class="btn btn-default">Reset</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<img src="<?= base_url() ?>/images/loader.gif" id="loader-form"  style="width: 30px; display: none;" />
			        <button type="button" id="btn-simpan" onclick="simpanbank()" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;&nbsp;Simpan</button>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		OpenMenu();
		
		LoadDataBank();
		
		$('.ask').jConfirmAction();
	});
	
	function LoadDataBank(){
		$('#progres-main').show();
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/m_bank/getdatabank",
			data: "",
			success: function(msg){
				$(".table-bank").html(msg);
				table = $('#dataTables-bank').dataTable();
				$('#progres-main').hide();
				
				$('#dataTables-bank tbody').on( 'click', 'tr', function () {
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
	
	function openFormBank(mode){
		$('#form-bank').modal('show');
	}
	
	function simpanbank(){
		$("#btn-simpan").hide();
		$("#loader-form").show();
		var kd_bank = $("#bank_kd_bank").val();
		var keterangan = $("#bank_keterangan").val();
		
		$.ajax({
			type: "POST",
			url: "<?= base_url(); ?>index.php/m_bank/simpanbank",
			data: "kd_bank="+kd_bank+"&keterangan="+keterangan,
			success: function(msg){
				$("#btn-simpan").show();
				$("#loader-form").hide();
				clearForm(1);
				$('#form-bank').modal('hide');
				
				LoadDataBank();
			}
		});
	}
	
	function HapusBank(){
		var kd_bank = table.$('tr.active').attr("kd_bank");
		
		if(typeof kd_bank == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			$.ajax({
				type: "POST",
				url: "<?= base_url(); ?>index.php/m_bank/hapusbank",
				data: "kd_bank="+kd_bank,
				success: function(msg){
					LoadDataBank();
				}
			});
		}
	}
	
	function clearForm(mode){
		$("#bank_kd_bank").val("");
		$("#bank_keterangan").val("");
	}
</script>