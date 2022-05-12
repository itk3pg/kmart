<div id="page-wrapper">
	<div class="row">
	    <div class="col-lg-12">
	        <h1 class="page-header">Perubahan Kode Barang</h1>
	    </div>
	    <!-- /.col-lg-12 -->
	</div>
	<div class="row">
		<table>
			<tr>
				<td>
					Kode/Barcode Barang Lama:
					<div class="form-group input-group">
						<input type="text" style="width: 300px;" name="kode_lama" id="kode_lama" class="form-control">
					</div>
				</td>
				<td valign="middle">&nbsp;-&nbsp;</td>
				<td>
					Kode/Barcode Barang Baru:
					<div class="form-group input-group">
						<input type="text" style="width: 300px;" name="kode_baru" id="kode_baru" class="form-control">
					</div>
				</td>
				<td valign="middle">&nbsp;&nbsp;&nbsp;</td>
				<td>
					<button class="btn btn-primary" onclick="syncdatasaldo()">
						<span class="glyphicon glyphicon-refresh"></span>
						&nbsp;&nbsp;Proses
					</button>
				</td>
			</tr>
		</table>
	</div>
</div>
<script>
	$(document).ready(function(){
		OpenMenu();
	});
	
	function syncdatasaldo(){
		var kode_lama = $('#kode_lama').val();
		var kode_baru = $('#kode_baru').val();
		
		window.open('<?= base_url(); ?>index.php/gantibarcode/proses?kode_lama='+kode_lama+'&kode_baru='+kode_baru, '_blank');
	}
</script>