<div id="page-wrapper">
	<div class="row">
	    <div class="col-lg-12">
	        <h1 style="margin-top: 15px;" class="page-header">Saldo Barang Konsinyasi</h1>
	    </div>
	    <!-- /.col-lg-12 -->
	</div>
	<div class="row">
		<div class="col-lg-12">
			<table style="float: right;">
				<tr>
					<td>
						Supplier : 
						<div class="form-group input-group">
							<select class="form-control" style="width: 215px;" name="mutasi_supplier" id="mutasi_supplier">
								<?php 
									foreach($datasupplier as $key => $value){
										echo "<option value='".$value['kode']."'>(".$value['kode'].") ".$value['nama_supplier']."</optioan>";
									}
								?>
							</select>
						</div>
					</td>
					<td valign="middle">&nbsp;-&nbsp;</td>
					<td>
						Toko / Unit : 
						<div class="form-group input-group">
							<select class="form-control" style="width: 215px;" name="mutasi_toko" id="mutasi_toko">
								<?php 
									foreach($datatoko as $key => $value){
										echo "<option value='".$value['kode']."'>".$value['nama']."</optioan>";
									}
									echo "<option value='VO0006'>DC (GOOD STOCK)</optioan>";
								?>
							</select>
						</div>
					</td>
					<td valign="middle">&nbsp;-&nbsp;</td>
					<td>
						Kode/Nama Barang : 
						<div class="form-group input-group">
							<input type="text" class="form-control" name="mutasi_barang_kode" id="mutasi_barang_kode" />
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
							&nbsp;&nbsp;Cetak PDF
						</button>
						<button id="btn_search" onclick="CetakDataMutasiXLS()" class="btn btn-success" type="button">
							<i class="fa fa-print"></i>
							&nbsp;&nbsp;Cetak XLS
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
            <div id="table-baranggudang"></div>
		</div>
	</div>
	<div class="modal fade" id="form-detail-saldo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        			<h4 class="modal-title" id="myModalLabel">Detail Saldo Barang</h4>
				</div>
				<div class="modal-body">
					<div id="table-detail"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		OpenMenu();
		$("#mutasi_supplier").select2();
	});
	
	function LoadDataMutasi(){
		var bulan = $("#mutasi_bulan").val();
		var tahun = $("#mutasi_tahun").val();
		var toko_kode = $("#mutasi_toko").val();
		var supplier_kode = $("#mutasi_supplier").val();
		var barang_kode = $("#mutasi_barang_kode").val();
		var mode = $("#mutasi_mode").val();
		
		if(bulan <= 7 && tahun <= 2015){
			alert("Laporan tidak tersedia");
		}else{
			$("#progres-main").show();
			$.ajax({
				type: "POST",
				url: "<?= base_url('index.php/laporan/saldobaranggudangkonsinyasi/getsaldobaranggudang') ?>",
				data: "bulan="+bulan+"&tahun="+tahun+"&toko_kode="+toko_kode+"&supplier_kode="+supplier_kode+"&barang_kode="+barang_kode+"&mode="+mode,
				success: function(msg){
					$("#table-baranggudang").html(msg);
					
					$("#progres-main").hide();
				}
			});
		}
	}
	
	function openformdetail(barang_kode){
		$("#form-detail-saldo").modal("show");
		
		var bulan = $("#mutasi_bulan").val();
		var tahun = $("#mutasi_tahun").val();
		var toko_kode = $("#mutasi_toko").val();
		
		$.ajax({
			type: "POST",
			url: "<?= base_url('index.php/laporan/saldobaranggudangkonsinyasi/getdetailbarang') ?>",
			data: "bulan="+bulan+"&tahun="+tahun+"&toko_kode="+toko_kode+"&barang_kode="+barang_kode,
			success: function(msg){
				$("#table-detail").html(msg);
			}
		});
	}
	
	function CetakDataMutasi(){
		var bulan = $("#mutasi_bulan").val();
		var tahun = $("#mutasi_tahun").val();
		var toko_kode = $("#mutasi_toko").val();
		var supplier_kode = $("#mutasi_supplier").val();
		var nama_supplier = base64_encode($("#mutasi_supplier").select2("data").text);
		var nama_toko = $("#mutasi_toko :selected").text();
		var barang_kode = $("#mutasi_barang_kode").val();
		var mode = $("#mutasi_mode").val();
		
		window.open('<?= base_url('index.php/laporan/saldobaranggudangkonsinyasi/cetaksaldobaranggudang?') ?>bulan='+bulan+'&tahun='+tahun+"&toko_kode="+toko_kode+"&supplier_kode="+supplier_kode+"&nama_supplier="+nama_supplier+"&nama_toko="+nama_toko+"&barang_kode="+barang_kode+"&mode="+mode,'_blank');
	}

	function CetakDataMutasiXLS(){
		var bulan = $("#mutasi_bulan").val();
		var tahun = $("#mutasi_tahun").val();
		var toko_kode = $("#mutasi_toko").val();
		var supplier_kode = $("#mutasi_supplier").select2("val");
		var nama_supplier = base64_encode($("#mutasi_supplier").select2("data").text);
		var nama_toko = $("#mutasi_toko :selected").text();
		var barang_kode = $("#mutasi_barang_kode").val();
		var mode = $("#mutasi_mode").val();
		
		window.open('<?= base_url('index.php/laporan/saldobaranggudangkonsinyasi/cetaksaldobaranggudang_xls?') ?>bulan='+bulan+'&tahun='+tahun+"&toko_kode="+toko_kode+"&supplier_kode="+supplier_kode+"&nama_supplier="+nama_supplier+"&nama_toko="+nama_toko+"&barang_kode="+barang_kode+"&mode="+mode,'_blank');
	}
</script>