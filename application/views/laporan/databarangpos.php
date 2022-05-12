<div id="page-wrapper">
	<div class="row">
	    <div class="col-lg-12">
	        <h1 style="margin-top: 15px;" class="page-header">Data Barang POS</h1>
	    </div>
	    <!-- /.col-lg-12 -->
	</div>
	<div class="row">
		<div class="col-lg-12">
			<table style="float: right;">
				<tr>
					<td>
						Mode:
						<div class="form-group input-group">
							<select class="form-control" style="width: 200px;" name="mutasi_mode" id="mutasi_mode">
								<option value="semua">SEMUA</option>
								<option value="dibawah_hargabeli">Dibawah Harga Beli</option>
							</select>
						</div>
					</td>
					<td>
						Toko:
						<div class="form-group input-group">
							<select class="form-control" style="width: 200px;" name="mutasi_toko" id="mutasi_toko">
								<?php
								foreach ($DataToko as $key => $value) {
									echo "<option value=\"".$value['kode']."\">".$value['nama']."</option>";
								}
								?>
							</select>
						</div>
					</td>
					<td valign="middle">&nbsp;-&nbsp;</td>
					<td>
						Barang:
						<div class="form-group input-group">
							<input type="text" style="width: 200px;" name="mutasi_barang" id="mutasi_barang" class="form-control">
						</div>
					</td>
					<td>&nbsp;&nbsp;</td>
					<td>
						<button id="btn_search" onclick="LoadDataMutasi()" class="btn btn-info" type="button">
							<i class="fa fa-search"></i>
							&nbsp;&nbsp;Search
						</button>
						<button id="btn_search" onclick="CetakDataMutasi()" class="btn btn-info" type="button">
							<i class="fa fa-print"></i>
							&nbsp;&nbsp;cetak
						</button>
					</td>
				</tr>
			</table>
			<div id="progres-main" style="width: 535px; float: right; display: none;">
				<div class="progress progress-striped active">
					<div class="progress-bar progress-bar-info" style="width: 100%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="20" role="progressbar">
						<span class="sr-only">20% Complete</span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row" style="margin-top: 10px;">
		<div class="col-lg-12">
			<div class="message">
				
            </div>
            <div id="table-barangpos"></div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		OpenMenu();
	});
	
	function LoadDataMutasi(){
		var toko_kode = $("#mutasi_toko").val();
		var barang_kode = $("#mutasi_barang").val();
		var mode = $("#mutasi_mode").val();
		
		$("#progres-main").show();
		$.ajax({
			type: "POST",
			url: "<?= base_url('index.php/laporan/databarangpos/getdatabarangpos') ?>",
			data: "toko_kode="+toko_kode+"&barang_kode="+barang_kode+"&mode="+mode,
			success: function(msg){
				$("#table-barangpos").html(msg);
				
				$("#progres-main").hide();
			}
		});
	}
	
	function CetakDataMutasi(){
		var toko_kode = $("#mutasi_toko").val();
		var nama_toko = $("#mutasi_toko :selected").text();
		var barang_kode = $("#mutasi_barang").val();
		var mode = $("#mutasi_mode").val();
		
		window.open('<?= base_url('index.php/laporan/databarangpos/cetakdatabarangpos?') ?>toko_kode='+toko_kode+'&nama_toko='+nama_toko+'&barang_kode='+barang_kode+'&mode='+mode,'_blank');
	}
</script>