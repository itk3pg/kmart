<div id="page-wrapper">
	<div class="row">
	    <div class="col-lg-12">
	        <h1 style="margin-top: 15px;" class="page-header">Harga Jual Barang</h1>
	    </div>
	    <!-- /.col-lg-12 -->
	</div>
	<div class="row">
		<div class="col-lg-12">
			<table style="float: right;">
				<tr>
					<td>
						Kategori Barang : 
						<div class="form-group input-group">
							<select class="form-control" style="width: 215px;" name="search_kategori" id="search_kategori">
								
							</select>
						</div>
					</td>
					<td valign="middle">&nbsp;-&nbsp;</td>
					<td>
						Kode/Nama Barang : 
						<div class="form-group input-group">
							<input type="text" class="form-control" name="search_barang_kode" id="search_barang_kode" />
						</div>
					</td>
					<td valign="middle">&nbsp;-&nbsp;</td>
					<td>
						<button id="btn_search" onclick="LoadDataBarang()" class="btn btn-info" type="button">
							<i class="fa fa-search"></i>
							&nbsp;&nbsp;Search
						</button>
						<!--<button id="btn_search" onclick="CetakDataMutasi()" class="btn btn-info" type="button">
							<i class="fa fa-print"></i>
							&nbsp;&nbsp;Cetak
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
			<table id="table-barang" class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th>Kode Barang</th>
						<th>Barcode</th>
						<th>Nama Barang</th>
						<th>Satuan</th>
						<th>HPP</th>
						<th>Harga Jual</th>
						<th>Persentase (%)</th>
					</tr>
				</thead>
				<tbody></tbody>
			</table>
		</div>
		<!-- <div class="col-lg-6">
			<table id="table-harga" class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th>Nama Toko</th>
						<th>HPP</th>
						<th>Harga Jual</th>
						<th>Persentase (%)</th>
					</tr>
				</thead>
				<tbody></tbody>
			</table>
		</div> -->
	</div>
</div>
<script>
	$(document).ready(function(){
		OpenMenu();
		LoadDataKategori();
		$('#table-barang tbody').on( 'click', 'tr', function () {
			if ( $(this).hasClass('active') ) {
				$(this).removeClass('active');
				
				$("#table-harga tbody").html("");
			}else {
				$('#table-barang tr.active').removeClass('active');
				$(this).addClass('active');
				
				// LoadDataHarga();
			}
		} );
	});
	
	function LoadDataKategori(){
		$.ajax({
			type: "POST",
			url: "<?= base_url('index.php/laporan/hargabarangtoko/getkategoribarang') ?>",
			data: "",
			success: function(msg){
				$("#search_kategori").html(msg);
				$("#search_kategori").select2();
			}
		});
	}
	
	function LoadDataBarang(){
		$("#progres-main").show();
		var kategori_kode = $("#search_kategori").val();
		var barang_kode = $("#search_barang_kode").val();
		$.ajax({
			type: "POST",
			url: "<?= base_url('index.php/laporan/hargabarangtoko/getdatabarang') ?>",
			data: "kategori_kode="+kategori_kode+"&barang_kode="+barang_kode,
			success: function(msg){
				$("#table-barang tbody").html(msg);
				$("#progres-main").hide();
			}
		});
	}
	
	function LoadDataHarga(){
		var data_obj = $('#table-barang tr.active').attr("data");
		var data = json_decode(base64_decode(data_obj));
		$.ajax({
			type: "POST",
			url: "<?= base_url('index.php/laporan/hargabarangtoko/getdataharga') ?>",
			data: "barang_kode="+data['kode'],
			success: function(msg){
				$("#table-harga tbody").html(msg);
			}
		});
	}
</script>