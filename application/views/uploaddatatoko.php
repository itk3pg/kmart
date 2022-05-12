<div id="page-wrapper">
	<div class="row">
	    <div class="col-lg-12">
	        <h1 class="page-header">Generate Data Toko</h1>
	    </div>
	    <!-- /.col-lg-12 -->
	</div>
	<div class="row">
		<table>
			<tr>
				<td>
					Mode :
					<div class="form-group input-group">
						<select class="form-control" style="width: 200px;" name="upload_mode" id="upload_mode">
							<option value="all">ALL</option>
							<option value="master_barang">MASTER BARANG</option>
							<option value="user">MASTER USER</option>
							<option value="master_pelanggan">MASTER PELANGGAN</option>
							<option value="master_promo">MASTER PROMO</option>
							<option value="fix_data">FIX DATA</option>
							<option value="master_akrindo">MASTER AKRINDO</option>
						</select>
					</div>
				</td>
				<td valign="middle">&nbsp;-&nbsp;</td>
				<td>
					Bulan:
					<div class="form-group input-group">
						<select class="form-control" disabled style="width: 115px;" name="upload_bulan" id="upload_bulan">
							<option <?php if(date("m") == 1) echo "selected=\"true\"" ?> value="1">Januari</option><option <?php if(date("m") == 2) echo "selected=\"true\"" ?> value="2">Februari</option>
							<option <?php if(date("m") == 3) echo "selected=\"true\"" ?> value="3">Maret</option><option <?php if(date("m") == 4) echo "selected=\"true\"" ?> value="4">April</option>
							<option <?php if(date("m") == 5) echo "selected=\"true\"" ?> value="5">Mei</option><option <?php if(date("m") == 6) echo "selected=\"true\"" ?> value="6">Juni</option>
							<option <?php if(date("m") == 7) echo "selected=\"true\"" ?> value="7">Juli</option><option <?php if(date("m") == 8) echo "selected=\"true\"" ?> value="8">Agustus</option>
							<option <?php if(date("m") == 9) echo "selected=\"true\"" ?> value="9">September</option><option <?php if(date("m") == 10) echo "selected=\"true\"" ?> value="10">Oktober</option>
							<option <?php if(date("m") == 11) echo "selected=\"true\"" ?> value="11">November</option><option <?php if(date("m") == 12) echo "selected=\"true\"" ?> value="12">Desember</option>
						</select>
					</div>
				</td>
				<td valign="middle">&nbsp;-&nbsp;</td>
				<td>
					Tahun:
					<div class="form-group input-group">
						<input type="text" readonly style="width: 100px;" value="<?= date('Y'); ?>" name="upload_tahun" id="upload_tahun" class="form-control">
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
		window.open('<?= base_url(); ?>index.php/uploaddatatoko/generatefile?bulan='+$('#upload_bulan').val()+'&tahun='+$('#upload_tahun').val()+'&toko_kode='+$('#upload_toko').val()+'&mode='+$('#upload_mode').val(), '_blank');
	}
</script>