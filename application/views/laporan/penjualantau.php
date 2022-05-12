<div id="page-wrapper">
	<div class="row">
	    <div class="col-lg-12">
	        <h1 style="margin-top: 15px;" class="page-header">Data Penjualan TAU</h1>
	    </div>
	    <!-- /.col-lg-12 -->
	</div>
	<div class="row">
		<div class="col-lg-12">
			<table style="float: right;">
				<tr>
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
						<button id="btn_search" onclick="LoadAllDataMutasi()" class="btn btn-info" type="button">
							<i class="fa fa-search"></i>
							&nbsp;&nbsp;Search
						</button>
						<button id="btn_search" onclick="CetakDataMutasi('all')" class="btn btn-info" type="button">
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
            <ul class="nav nav-tabs">
               	<li class="active"><a href="#tab_barang" data-toggle="tab">Barang</a>
                </li>
                <li><a href="#tab_jasa" data-toggle="tab">Jasa</a>
                </li>
            </ul>
            <div class="tab-content">
            	<div class="tab-pane fade in active" id="tab_barang">
            		<button id="btn_search" onclick="CetakDataMutasi('barang')" class="btn btn-info" type="button">
						<i class="fa fa-print"></i>
						&nbsp;&nbsp;cetak
					</button>
            		<div style="margin-top: 5px;" id="table-penjualantau-barang"></div>
            	</div>
            	<div class="tab-pane fade" id="tab_jasa">
            		<button id="btn_search" onclick="CetakDataMutasi('jasa')" class="btn btn-info" type="button">
						<i class="fa fa-print"></i>
						&nbsp;&nbsp;cetak
					</button>
            		<div style="margin-top: 5px;" id="table-penjualantau-jasa"></div>
            	</div>
            </div>
            <div id="table-penjualantau"></div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		OpenMenu();
		LoadAllDataMutasi();
	});
	
	function LoadDataMutasi(mode){
		var bulan = $("#mutasi_bulan").val();
		var tahun = $("#mutasi_tahun").val();
		
		if(bulan <= 7 && tahun <= 2015){
			alert("Laporan tidak tersedia");
		}else{
			$("#progres-main").show();
			$.ajax({
				type: "POST",
				url: "<?= base_url('index.php/laporan/getpenjualantau') ?>",
				data: "bulan="+bulan+"&tahun="+tahun+"&mode="+mode,
				success: function(msg){
					$("#table-penjualantau-"+mode).html(msg);
					
					$("#progres-main").hide();
				}
			});
		}
	}
	
	function LoadAllDataMutasi(){
		LoadDataMutasi("barang");
		LoadDataMutasi("jasa");
	}
	
	function CetakDataMutasi(mode){
		var bulan = $("#mutasi_bulan").val();
		var tahun = $("#mutasi_tahun").val();
		
		window.open('<?= base_url('index.php/download_excel/getpenjualantau?') ?>bulan='+bulan+'&tahun='+tahun+"&mode="+mode,'_blank');
	}
</script>