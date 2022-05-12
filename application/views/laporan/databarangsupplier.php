<div id="page-wrapper">
	<div class="row">
	    <div class="col-lg-12">
	        <h1 style="margin-top: 15px;" class="page-header">Data Barang Supplier</h1>
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
					<td>
						Barang:
						<div class="form-group input-group">
							<input type="text" style="width: 200px;" name="mutasi_barang" id="mutasi_barang" class="form-control">
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
            <div id="table-barangsupplier"></div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		OpenMenu();

		$("#mutasi_supplier").select2();
	});
	
	function LoadDataMutasi(){
		var barang_kode = $("#mutasi_barang").val();
		var supplier_kode = $("#mutasi_supplier").val();
		
		$("#progres-main").show();
		$.ajax({
			type: "POST",
			url: "<?= base_url('index.php/laporan/databarangsupplier/getdatabarangsupplier') ?>",
			data: "barang_kode="+barang_kode+"&supplier_kode="+supplier_kode,
			success: function(msg){
				$("#table-barangsupplier").html(msg);
				
				$("#progres-main").hide();
			}
		});
	}
	
	function CetakDataMutasi(){
		var barang_kode = $("#mutasi_barang").val();
		var supplier_kode = $("#mutasi_supplier").val();
		
		window.open('<?= base_url('index.php/laporan/databarangsupplier/cetakdatabarangsupplier?') ?>barang_kode='+barang_kode+'&supplier_kode='+supplier_kode,'_blank');
	}
</script>