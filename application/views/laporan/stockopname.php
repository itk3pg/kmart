<div id="page-wrapper">
	<div class="row">
	    <div class="col-lg-12">
	        <h1 style="margin-top: 15px;" class="page-header">Laporan Stock Opname</h1>
	    </div>
	    <!-- /.col-lg-12 -->
	</div>
	<div class="row">
		<div class="col-lg-12">
			<table style="float: right;">
				<tr>
					<td style="width: 125px;">
						Toko :
						<div class="form-group input-group">
							<span class="input-group-addon">
								<i class="fa fa-file"></i>
							</span>
							<select onchange="loadListBukti();" class="form-control" style='width: 200px;' name="cari_toko_kode" id="cari_toko_kode">
								<option value="-1">Pilih Toko</option>
							</select>
						</div>
					</td>
					<td>&nbsp;&nbsp;</td>
					<td style="width: 125px;">
						Bukti :
						<div class="form-group input-group">
							<span class="input-group-addon">
								<i class="fa fa-file"></i>
							</span>
							<select class="form-control" style='width: 150px;' name="cari_bukti" id="cari_bukti">
								<option value="-1">Pilih Bukti</option>
							</select>
						</div>
					</td>
					<td>&nbsp;&nbsp;</td>
					<td valign="middle">
						<button id="btn_upload" onclick="LoadDataStockopname()" class="btn btn-info" type="button">
							<i class="fa fa-search"></i>
							&nbsp;&nbsp;Search
						</button>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="row" style="margin-top: 10px;">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<!--<button id="btn_upload" fungsi="HapusStockopname()" class="btn btn-danger btn-sm ask-stockopname" type="button">
						<i class="fa fa-times"></i>
						&nbsp;&nbsp;Hapus
					</button>-->
					<button id="btn_upload" onclick="CetakStockopname()" class="btn btn-info btn-sm" type="button">
						<i class="fa fa-print"></i>
						&nbsp;&nbsp;Cetak
					</button>
					<div id="progres-main" style="width: 150px; float: right; display: none;">
						<div class="progress progress-striped active">
							<div class="progress-bar progress-bar-info" style="width: 100%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="20" role="progressbar">
								<span class="sr-only">20% Complete</span>
							</div>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<div class="table-responsive table-stockopname">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		OpenMenu();
		loadListToko();
	});
	
	function LoadDataStockopname(){
		$('#progres-main').show();
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/laporan/stockopname/getstockopname",
			data: "toko_kode="+$('#cari_toko_kode').val()+"&bukti="+$('#cari_bukti').val(),
			success: function(msg){
				$(".table-stockopname").html(msg);
				$('#dataTables-stockopname').dataTable();
				$('#progres-main').hide();
			}
		});
	}
	
	function loadListToko(){
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/toko/getListToko",
			data: "",
			success: function(msg){
				$("#cari_toko_kode").html(msg);
				
				loadListBukti();
			}
		});
	}
	
	function loadListBukti(){
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/stockopname/getlistdatabukti",
			data: "toko_kode="+$("#cari_toko_kode").val(),
			success: function(msg){
				$("#cari_bukti").html(msg);
			}
		});
	}
	
	function CetakStockopname(){
		var bukti = $("#cari_bukti").val();
		var toko_kode = $("#cari_toko_kode").val();
		var nama_toko = $("#cari_toko_kode :selected").text();
		
		window.open('<?= base_url('index.php/laporan/stockopname/cetakstockopname?') ?>bukti='+bukti+'&toko_kode='+toko_kode+"&nama_toko="+nama_toko,'_blank');
	}
</script>