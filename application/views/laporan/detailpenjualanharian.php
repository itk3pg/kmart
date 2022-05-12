<div id="page-wrapper">
	<div class="row">
	    <div class="col-lg-12">
	        <h1 style="margin-top: 15px;" class="page-header">Data Detail Penjualan Harian</h1>
	    </div>
	    <!-- /.col-lg-12 -->
	</div>
	<div class="row">
		<div class="col-lg-12">
			<table style="float: right;">
				<tr>
					<td style="width: 200px;">
						<select class="form-control" style="width: 190px;" name="cari_toko_kode" id="cari_toko_kode">
							<option value="-1">Pilih Toko</option>
						</select>
					</td>
					<td>
						<input type="text" style="width: 100px;" value="<?= date('Y-m-d'); ?>" name="mutasi_tanggal_awal" id="mutasi_tanggal_awal" class="form-control">
					</td>
					<td>&nbsp;&nbsp;-&nbsp;&nbsp;</td>
					<td>
						<input type="text" style="width: 100px;" value="<?= date('Y-m-d'); ?>" name="mutasi_tanggal_akhir" id="mutasi_tanggal_akhir" class="form-control">
					</td>
					<td>&nbsp;&nbsp;</td>
					<td>
						<button id="btn_search" onclick="LoadDataMutasi()" class="btn btn-info" type="button">
							<i class="fa fa-search"></i>
							&nbsp;&nbsp;Search
						</button>
						<button id="btn_search" onclick="CetakDataMutasi()" class="btn btn-info" type="button">
							<i class="fa fa-print"></i>
							&nbsp;&nbsp;cetak (xls)
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
			<div id="lap_penjualan" style="max-height: 600px; overflow: scroll;"></div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		OpenMenu();
		loadListToko();
		
		$('#mutasi_tanggal_awal').datepicker({
			format: 'yyyy-mm-dd'
		});
		
		$('#mutasi_tanggal_akhir').datepicker({
			format: 'yyyy-mm-dd'
		});
		
		$('.datepicker tbody').on('click', function(){  $('.datepicker').hide() });
	});
	
	function loadListToko(){
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/toko/getListToko",
			data: "",
			success: function(msg){
				$("#cari_toko_kode").html(msg);
			}
		});
	}
	
	function LoadDataMutasi(){
		var tanggal_awal = $("#mutasi_tanggal_awal").val();
		var tanggal_akhir = $("#mutasi_tanggal_akhir").val();
		var toko_kode = $("#cari_toko_kode").val();

		$("#progres-main").show();
		$.ajax({
			type: "POST",
			url: "<?= base_url('index.php/laporan/detailpenjualanharian/gettransaksipenjualan') ?>",
			data: "tanggal_awal="+tanggal_awal+"&tanggal_akhir="+tanggal_akhir+"&toko_kode="+toko_kode,
			success: function(msg){
				$("#lap_penjualan").html(msg);
				
				$("#progres-main").hide();
			}
		});
	}

	function CetakDataMutasi(){
		var tanggal_awal = $("#mutasi_tanggal_awal").val();
		var tanggal_akhir = $("#mutasi_tanggal_akhir").val();
		var toko_kode = $("#cari_toko_kode").val();
		var kasir_kode = $("#cari_kasir_kode").select2("val");
		
		window.open('<?= base_url('index.php/laporan/detailpenjualanharian/cetaktransaksipenjualan?') ?>tanggal_awal='+tanggal_awal+'&tanggal_akhir='+tanggal_akhir+"&toko_kode="+toko_kode+"&kasir_kode="+kasir_kode,'_blank');
	}

	function CetakDetailPenjualan(tanggal){
		var toko_kode = $("#cari_toko_kode").val();

		window.open('<?= base_url('index.php/laporan/detailpenjualanharian/cetakdetailpenjualan?') ?>tanggal_awal='+tanggal+'&tanggal_akhir='+tanggal+"&toko_kode="+toko_kode,'_blank');
	}
</script>