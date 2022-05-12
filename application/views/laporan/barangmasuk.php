<div id="page-wrapper">
	<div class="row">
	    <div class="col-lg-12">
	        <h1 style="margin-top: 15px;" class="page-header">Data Barang Masuk</h1>
	    </div>
	    <!-- /.col-lg-12 -->
	</div>
	<div class="row">
		<div class="col-lg-12">
			<table style="float: right;">
				<tr>
					<td>
						<input type="checkbox" name="is_per_supplier" id="is_per_supplier" class="form-control"/> Per Supplier
					</td>
					<td>&nbsp;&nbsp;</td>
					<td>
						Tanggal Awal :
						<div class="form-group input-group">
							<span class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</span>
							<input type="text" value="<?= date('Y-m-01'); ?>" name="search_tanggal_awal" id="search_tanggal_awal" class="form-control">
						</div>
					</td>
					<td>&nbsp;&nbsp;</td>
					<td>
						Tanggal Akhir :
						<div class="form-group input-group">
							<span class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</span>
							<input type="text" value="<?= date('Y-m-d'); ?>" name="search_tanggal_akhir" id="search_tanggal_akhir" class="form-control">
						</div>
					</td>
					<td>&nbsp;&nbsp;</td>
					<td>
						<button id="btn_search" onclick="LoadAllDataMutasi()" class="btn btn-info" type="button">
							<i class="fa fa-search"></i>
							&nbsp;&nbsp;Search
						</button>
						<!--<button id="btn_search" onclick="CetakDataMutasi('all')" class="btn btn-info" type="button">
							<i class="fa fa-print"></i>
							&nbsp;&nbsp;cetak All
						</button>-->
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
               	<li class="active"><a style="background-color: lightblue;" href="#tab_barang" data-toggle="tab">Barang</a>
                </li>
                <!-- <li><a style="background-color: lightblue;" href="#tab_jasa" data-toggle="tab">Voucher PLN</a>
                </li> -->
            </ul>
            <div class="tab-content">
            	<div class="tab-pane fade in active" id="tab_barang">
            		<button id="btn_search" onclick="CetakDataMutasi('barang')" class="btn btn-info" type="button">
						<i class="fa fa-print"></i>
						&nbsp;&nbsp;cetak
					</button>
					<button id="btn_search" onclick="CetakDataMutasiExcel('barang')" class="btn btn-info" type="button">
						<i class="fa fa-print"></i>
						&nbsp;&nbsp;Cetak Excel
					</button>
            		<div style="margin-top: 5px;" id="table-barangmasuk"></div>
            	</div>
            	<!-- <div class="tab-pane fade" id="tab_jasa">
            		<button id="btn_search" onclick="CetakDataMutasi('pln')" class="btn btn-info" type="button">
						<i class="fa fa-print"></i>
						&nbsp;&nbsp;cetak
					</button>
            		<div style="margin-top: 5px;" id="table-plnmasuk"></div>
            	</div> -->
            </div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		OpenMenu();

		$('#search_tanggal_awal').datepicker({
			format: 'yyyy-mm-dd'
		});
		$('#search_tanggal_akhir').datepicker({
			format: 'yyyy-mm-dd'
		});

		LoadAllDataMutasi();
	});
	
	function LoadDataMutasi(mode){
		$("#table-barangmasuk").html("");
		var tanggal_awal = $("#search_tanggal_awal").val();
		var tanggal_akhir = $("#search_tanggal_akhir").val();
		var is_per_supplier = "0";
		if($('#is_per_supplier').is(':checked')){
			is_per_supplier = "1";
		}
		
		$("#progres-main").show();
		
		$.ajax({
			type: "POST",
			url: "<?= base_url('index.php/laporan/barangmasuk/getbarangmasuk') ?>",
			data: "tanggal_awal="+tanggal_awal+"&tanggal_akhir="+tanggal_akhir+"&mode="+mode+"&is_per_supplier="+is_per_supplier,
			success: function(msg){
				if(mode == "barang"){
					$("#table-barangmasuk").html(msg);
				}else{
					$("#table-plnmasuk").html(msg);
				}
				
				$("#progres-main").hide();
			}
		});
	}
	
	function LoadAllDataMutasi(){
		LoadDataMutasi("barang");
		// LoadDataMutasi("pln");
	}
	
	function CetakDataMutasi(mode){
		var tanggal_awal = $("#search_tanggal_awal").val();
		var tanggal_akhir = $("#search_tanggal_akhir").val();
		var is_per_supplier = "0";
		if($('#is_per_supplier').is(':checked')){
			is_per_supplier = "1";
		}
		
		window.open('<?= base_url('index.php/laporan/barangmasuk/cetakbarangmasuk?') ?>tanggal_awal='+tanggal_awal+'&tanggal_akhir='+tanggal_akhir+"&mode="+mode+"&is_per_supplier="+is_per_supplier,'_blank');
	}

	function CetakDataMutasiExcel(mode){
		var tanggal_awal = $("#search_tanggal_awal").val();
		var tanggal_akhir = $("#search_tanggal_akhir").val();
		var is_per_supplier = "0";
		if($('#is_per_supplier').is(':checked')){
			is_per_supplier = "1";
		}
		
		window.open('<?= base_url('index.php/laporan/barangmasuk/cetakbarangmasukexcel?') ?>tanggal_awal='+tanggal_awal+'&tanggal_akhir='+tanggal_akhir+"&mode="+mode+"&is_per_supplier="+is_per_supplier,'_blank');
	}
</script>