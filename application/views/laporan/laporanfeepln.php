<div id="page-wrapper">
	<div class="row">
	    <div class="col-lg-12">
	        <h1 style="margin-top: 15px;" class="page-header">Data Fee Voucher PLN</h1>
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
							<select name="mutasi_toko" id="mutasi_toko" class="form-control">
								<option value="VO0001">Segunting</option>
								<option value="VO0002">Bogorejo</option>
								<option value="VO0004">GKB</option>
							</select>
						</div>
					</td>
					<td>&nbsp;&nbsp;</td>
					<td>
						Tanggal Awal:
						<div class="form-group input-group">
							<input type="text" style="width: 120px;" value="<?php echo date('Y-m-01'); ?>" name="mutasi_tanggal_awal" id="mutasi_tanggal_awal" class="form-control">
						</div>
					</td>
					<td>&nbsp;&nbsp;</td>
					<td>
						Tanggal Akhir:
						<div class="form-group input-group">
							<input type="text" style="width: 120px;" value="<?php echo date('Y-m-d'); ?>" name="mutasi_tanggal_akhir" id="mutasi_tanggal_akhir" class="form-control">
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
            <div id="table-penjualan"></div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		OpenMenu();
		
		$('#mutasi_tanggal_awal').datepicker({
			format: 'yyyy-mm-dd'
		});
		$('#mutasi_tanggal_akhir').datepicker({
			format: 'yyyy-mm-dd'
		});
		
		$('.datepicker tbody').on('click', function(){  $('.datepicker').hide() });

		$("#mutasi_kategori").select2();
	});
	
	function LoadDataMutasi(){
		var tanggal_awal = $("#mutasi_tanggal_awal").val();
		var tanggal_akhir = $("#mutasi_tanggal_akhir").val();
		var toko_kode = $("#mutasi_toko").val();
		
		$("#progres-main").show();
		$.ajax({
			type: "POST",
			url: "<?= base_url('index.php/laporan/laporanfeepln/getlaporanpulsa') ?>",
			data: "tanggal_awal="+tanggal_awal+"&tanggal_akhir="+tanggal_akhir+"&toko_kode="+toko_kode,
			success: function(msg){
				$("#table-penjualan").html(msg);
				
				$("#progres-main").hide();
			}
		});
	}
	
	function CetakDataMutasi(){
		var tanggal_awal = $("#mutasi_tanggal_awal").val();
		var tanggal_akhir = $("#mutasi_tanggal_akhir").val();
		var toko_kode = $("#mutasi_toko").val();
		var nama_toko = $("#mutasi_toko :selected").text();
		
		window.open('<?= base_url('index.php/laporan/laporanfeepln/cetaklaporanpulsa?') ?>tanggal_awal='+tanggal_awal+'&tanggal_akhir='+tanggal_akhir+'&toko_kode='+toko_kode+'&nama_toko='+nama_toko,'_blank');
	}
</script>