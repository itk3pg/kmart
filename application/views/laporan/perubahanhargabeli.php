<div id="page-wrapper">
	<div class="row">
	    <div class="col-lg-12">
	        <h1 style="margin-top: 15px;" class="page-header">Data Perubahan Harga Beli</h1>
	    </div>
	    <!-- /.col-lg-12 -->
		<!-- <div class="form-group input-group"> -->
	</div>
	<div class="row">
		<div class="col-lg-12">
			<table style="float: right;">
				<tr>	
					<td>
						Periode:
						<div class="row form-inline" style="margin: 0px;">	
						<input type="text" id="tgl_awal" name="tgl_awal" class="form-control" value="01" size="2" required="" /> s.d.
                                <input type="text" id="tgl_akhir" name="tgl_akhir" class="form-control" value="<?=date('d'); ?>" size="2"
								required="" />
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
							<input type="text" style="width: 100px;" value="<?= date('Y'); ?>" name="mutasi_tahun" id="mutasi_tahun" 
							class="form-control">
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
            <div id="table-data"></div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		OpenMenu();
		LoadDataMutasi();
	});
	
	function LoadDataMutasi(){
		var awal  = $("#tgl_awal").val();
		var akhir = $("#tgl_akhir").val();
		var bulan = $("#mutasi_bulan").val();
		var tahun = $("#mutasi_tahun").val();
		
		//day(tanggal)="+awal+"&day(tanggal)="+akhir+"&
		
		$("#progres-main").show();
		$.ajax({
			type: "POST",
			url: "<?= base_url('index.php/laporan/perubahanhargabeli/getperubahanhargabeli') ?>",
			data: "awal="+awal+"&akhir="+akhir+"&bulan="+bulan+"&tahun="+tahun,
			success: function(msg){
				$("#table-data").html(msg);
				
				$("#progres-main").hide();
			}
		});
	}
	
	function CetakDataMutasi(){
		var awal  = $("#tgl_awal").val();
		var akhir = $("#tgl_akhir").val();
		var bulan = $("#mutasi_bulan").val();
		var tahun = $("#mutasi_tahun").val();
		
		window.open('<?= base_url('index.php/laporan/perubahanhargabeli/cetakperubahanhargabeli?') ?>bulan='+bulan+'&tahun='+tahun,'_blank');
	}
</script>