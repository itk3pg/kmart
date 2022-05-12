<div id="page-wrapper">
	<div class="row">
	    <div class="col-lg-12">
	        <h1 class="page-header">Set Stock Opname</h1>
	    </div>
	    <!-- /.col-lg-12 -->
	</div>
	<div class="row">
		<table>
			<tr>
				<td>
					Bukti:
					<div class="form-group input-group">
						<input type="text" readonly style="width: 150px;" value="<?= date('Ymd'); ?>" name="setstockopname_bukti" id="setstockopname_bukti" class="form-control">
					</div>
				</td>
				<td valign="middle">&nbsp;-&nbsp;</td>
				<td>
					Toko:
					<div class="form-group input-group">
						<select class="form-control"  name="setstockopname_toko" id="setstockopname_toko">
						</select>
					</div>
				</td>
				<td valign="middle">&nbsp;&nbsp;&nbsp;</td>
				<td>
					<button id="btn-proses" class="btn btn-primary" onclick="proses()">
						<span class="glyphicon glyphicon-refresh"></span>
						&nbsp;&nbsp;Proses
					</button>
					<img src="<?= base_url() ?>/images/loader.gif" id="loader-form"  style="width: 30px; display: none;" />
				</td>
			</tr>
		</table>
	</div>
</div>
<script>
	$(document).ready(function(){
		OpenMenu();
		
		loadListToko();
	});
	
	function loadListToko(){
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/toko/getListToko",
			data: "",
			success: function(msg){
				$("#setstockopname_toko").html(msg);
			}
		});
	}
	
	function proses(){
		var toko_kode = $("#setstockopname_toko").val();
		var bukti = $('#setstockopname_bukti').val();
		
		$("#loader-form").show();
		$("#btn-proses").hide();
		
		$.ajax({
			type: "POST",
			url: "<?= base_url(); ?>index.php/setstockopname/setdatastockopname",
			data: "toko_kode="+toko_kode+"&bukti="+bukti,
			success: function(msg){
				$("#loader-form").hide();
				$("#btn-proses").show();
			},
			error: function(xhr,status,error){
				alert(status);
				$("#loader-form").hide();
				$("#btn-proses").show();
			}
		});
	}
</script>