<div id="page-wrapper">
	<div class="row">
	    <div class="col-lg-12">
	        <h1 class="page-header">Vmart</h1>
	    </div>
	    <!-- /.col-lg-12 -->
	</div>
	<div class="row">
		<table>
			<tr>
				<td>
					Tanggal:
					<div class="form-group input-group">
						<input type="text" style="width: 100px;" value="<?= date('Y-m-d'); ?>" name="upload_tanggal" id="upload_tanggal" class="form-control">
					</div>
				</td>
				<td valign="middle">&nbsp;-&nbsp;</td>
				<td>
					Toko:
					<div class="form-group input-group">
						<select class="form-control"  name="upload_toko" id="upload_toko">
						</select>
					</div>
				</td>
				<td valign="middle">&nbsp;&nbsp;&nbsp;</td>
				<td>
					<button class="btn btn-primary" onclick="generatefile()">
						<span class="glyphicon glyphicon-refresh"></span>
						&nbsp;&nbsp;Generate File
					</button>
				</td>
			</tr>
		</table>
	</div>
</div>
<script>
	$(document).ready(function(){
		OpenMenu();
		
		loadListToko();
		$('#upload_tanggal').datepicker({
			format: 'yyyy-mm-dd'
		});
	});
	
	function loadListToko(){
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/toko/getListToko",
			data: "",
			success: function(msg){
				$("#upload_toko").html(msg);
			}
		});
	}
	
	function generatefile(){
		window.open('<?= base_url(); ?>index.php/uploaddatapenjualan/generatefile?tanggal='+$('#upload_tanggal').val()+'&toko_kode='+$('#upload_toko').val(), '_blank');
	}
</script>