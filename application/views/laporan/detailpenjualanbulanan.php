<div id="page-wrapper">
	<div class="row">
	    <div class="col-lg-12">
	        <h1 style="margin-top: 15px;" class="page-header">Data Penjualan Bulanan</h1>
	    </div>
	    <!-- /.col-lg-12 -->
	</div>
	<div class="row">
		<div class="col-lg-12">
			<table style="float: right;">
				<tr>
					<td>
						Toko:
						<div class="form-group input-group">
							<select class="form-control" style="width: 190px;" name="mutasi_toko" id="mutasi_toko">
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
						Bulan:
						<div class="form-group input-group">
							<select class="form-control" style="width: 115px;" name="mutasi_bulan" id="mutasi_bulan">
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
							<input type="text" style="width: 100px;" value="<?= date('Y'); ?>" name="mutasi_tahun" id="mutasi_tahun" class="form-control">
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
            <div id="table-penjualanpelanggan"></div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		OpenMenu();
	});
	
	function LoadDataMutasi(){
		var bulan = $("#mutasi_bulan").val();
		var tahun = $("#mutasi_tahun").val();
		var toko_kode = $("#mutasi_toko").val();
		
		if(bulan <= 7 && tahun <= 2015){
			alert("Laporan tidak tersedia");
		}else{
			$("#progres-main").show();
			$.ajax({
				type: "POST",
				url: "<?= base_url('index.php/laporan/detailpenjualanbulanan/getpenjualanbulanan') ?>",
				data: "bulan="+bulan+"&tahun="+tahun+"&toko_kode="+toko_kode,
				success: function(msg){
					$("#table-penjualanpelanggan").html(msg);
					
					$("#progres-main").hide();
				}
			});
		}
	}
	
	function CetakDataMutasi(){
		var bulan = $("#mutasi_bulan").val();
		var tahun = $("#mutasi_tahun").val();
		var toko_kode = $("#mutasi_toko").val();
		var nama_toko = $("#mutasi_toko :selected").text();
		
		window.open('<?= base_url('index.php/laporan/detailpenjualanbulanan/cetakpenjualanpelanggan?') ?>bulan='+bulan+'&tahun='+tahun+"&toko_kode="+toko_kode+"&nama_toko="+nama_toko,'_blank');
	}
</script>