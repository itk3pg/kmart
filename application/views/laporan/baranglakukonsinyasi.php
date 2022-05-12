<div id="page-wrapper">
	<div class="row">
	    <div class="col-lg-12">
	        <h1 style="margin-top: 15px;" class="page-header">Barang Laku</h1>
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
				</tr>
				<tr>
					<td>
						Kode/Nama Barang : 
						<div class="form-group input-group">
							<input type="text" class="form-control" name="mutasi_barang_kode" id="mutasi_barang_kode" />
						</div>
					</td>
					<td valign="middle">&nbsp;-&nbsp;</td>
					<td>
						Tanggal Awal:
						<div class="form-group input-group">
							<span class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</span>
							<input type="text" value="<?= date('Y-m-'); ?>1" name="mutasi_tanggal_awal" id="mutasi_tanggal_awal" class="form-control">
						</div>
					</td>
					<td valign="middle">&nbsp;-&nbsp;</td>
					<td>
						Tanggal Akhir:
						<div class="form-group input-group">
							<span class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</span>
							<input type="text" value="<?= date('Y-m-d'); ?>" name="mutasi_tanggal_akhir" id="mutasi_tanggal_akhir" class="form-control">
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
							&nbsp;&nbsp;Cetak
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

		$('#mutasi_tanggal_awal').datepicker({
			format: 'yyyy-mm-dd'
		});
		$('#mutasi_tanggal_akhir').datepicker({
			format: 'yyyy-mm-dd'
		});
		
		$('.datepicker tbody').on('click', function(){  $('.datepicker').hide() });
	});
	
	function LoadDataMutasi(){
		var tanggal_awal = $("#mutasi_tanggal_awal").val();
		var tanggal_akhir = $("#mutasi_tanggal_akhir").val();
		var toko_kode = $("#mutasi_toko").val();
		var supplier_kode = $("#mutasi_supplier").val();
		var barang_kode = $("#mutasi_barang_kode").val();
		
		$("#progres-main").show();
		$.ajax({
			type: "POST",
			url: "<?= base_url('index.php/laporan/baranglakukonsinyasi/getbaranglakukonsinyasi') ?>",
			data: "tanggal_awal="+tanggal_awal+"&tanggal_akhir="+tanggal_akhir+"&toko_kode="+toko_kode+"&supplier_kode="+supplier_kode+"&barang_kode="+barang_kode,
			success: function(msg){
				$("#table-baranggudang").html(msg);
				
				$("#progres-main").hide();
			}
		});
	}
	
	function CetakDataMutasi(){
		var tanggal_awal = $("#mutasi_tanggal_awal").val();
		var tanggal_akhir = $("#mutasi_tanggal_akhir").val();
		var toko_kode = $("#mutasi_toko").val();
		var supplier_kode = $("#mutasi_supplier").val();
		var nama_toko = $("#mutasi_toko :selected").text();
		var barang_kode = $("#mutasi_barang_kode").val();
		
		window.open('<?= base_url('index.php/laporan/baranglakukonsinyasi/cetakbaranglakukonsinyasi?') ?>tanggal_awal='+tanggal_awal+'&tanggal_akhir='+tanggal_akhir+"&toko_kode="+toko_kode+"&supplier_kode="+supplier_kode+"&nama_toko="+nama_toko+"&barang_kode="+barang_kode,'_blank');
	}
</script>