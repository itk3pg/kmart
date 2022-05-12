<div id="page-wrapper">
	<div class="row">
	    <div class="col-lg-12">
	        <h1 style="margin-top: 15px;" class="page-header">Laporan Perubahan Harga</h1>
	    </div>
	    <!-- /.col-lg-12 -->
	</div>
	<div class="row">
		<div class="col-lg-12">
			<table style="float: right;">
				<tr>
					<td style="width: 200px;">
						Toko :
						<div class="form-group input-group">
							<span class="input-group-addon">
								<i class="fa fa-user"></i>
							</span>
							<select style="width: 150px;" class="form-control" name="search_toko_kode" id="search_toko_kode">
								<?php
								foreach ($DataToko as $key => $value) {
									echo "<option value=\"".$value['kode']."\">".$value['nama']."</option>";
								}
								?>
							</select>
						</div>
					</td>
					<td>
						Tanggal:
						<div class="form-group input-group">
							<span class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</span>
							<input type="text" style="width: 100px;" value="<?= date('Y-m-'); ?>1" name="mutasi_tanggal" id="mutasi_tanggal" class="form-control">
						</div>
					</td>
					<td>&nbsp;&nbsp;</td>
					<td>
						Kode/Barcode : 
						<div class="form-group input-group">
							<input type="text" style="width: 300px;" placeholder="pisahkan tiap kode dengan tanda ';'" class="form-control" name="mutasi_barang_kode" id="mutasi_barang_kode" />
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
			<table class="table table-striped table-bordered table-hover" id="table-rekap">
				<thead>
					<tr>
						<th>No</th>
						<th>Kode Barang</th>
						<th>Nama Barang</th>
						<th>Harga Baru</th>
						<th>Waktu</th>
						<th>Harga Lama</th>
						<th>Waktu</th>
					</tr>
				</thead>
				<tbody>
					
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		OpenMenu();
		//LoadDataMutasi('111');
		
		$('#mutasi_tanggal').datepicker({
			format: 'yyyy-mm-dd'
		});
		
		$('.datepicker tbody').on('click', function(){  $('.datepicker').hide() });
	});
	
	function LoadDataMutasi(kd_kb, container){
		$("#progres-main").show();
		
		var tanggal = $("#mutasi_tanggal").val();
		var toko_kode = $("#search_toko_kode").val();
		var barang_kode = $("#mutasi_barang_kode").val();
		$.ajax({
			type: "POST",
			url: "<?= base_url('index.php/laporan/perubahanharga/getdataperubahanharga') ?>",
			data: "tanggal="+tanggal+"&toko_kode="+toko_kode+"&barang_kode="+barang_kode,
			success: function(msg){
				$("#table-rekap tbody").html(msg);
				
				$("#progres-main").hide();
			}
		});
	}
	
	function CetakDataMutasi(){
		var tanggal = $("#mutasi_tanggal").val();
		var toko_kode = $("#search_toko_kode").val();
		var barang_kode = $("#mutasi_barang_kode").val();
		
		window.open('<?= base_url('index.php/laporan/perubahanharga/cetakpricetag?') ?>tanggal='+tanggal+'&toko_kode='+toko_kode+"&barang_kode="+barang_kode,'_blank');
	}
</script>