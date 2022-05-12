<div id="page-wrapper">
	<div class="row">
	    <div class="col-lg-12">
	        <h1 style="margin-top: 15px;" class="page-header">Data Mutasi Kas/Bank</h1>
	    </div>
	    <!-- /.col-lg-12 -->
	</div>
	<div class="row">
		<div class="col-lg-12">
			<table style="float: right;">
				<tr>
					<td style="width: 200px;">
						Toko/Unit :
						<div class="form-group input-group">
							<span class="input-group-addon">
								<i class="fa fa-user"></i>
							</span>
							<?php
								$Disable = "disabled";
								if($this->session->userdata('toko_kode') == 'VO0008' || $this->session->userdata('username') == "800"){
									$Disable = "";
								}
							?>
							<select style="width: 150px;" <?php echo $Disable; ?> class="form-control" name="search_toko_kode" id="search_toko_kode">
								<?php
								if($this->session->userdata('toko_kode') == 'VO0008'){
									foreach ($DataToko as $key => $value) {
										if($value['kode'] != "VO0006" && $value['kode'] != "VO0009"){
											if($this->session->userdata('toko_kode') == $value['kode']){
												echo "<option selected=\"true\" value=\"".$value['kode']."\">".$value['nama']."</option>";
											}else{
												echo "<option value=\"".$value['kode']."\">".$value['nama']."</option>";
											}
										}
									}
								}else if($this->session->userdata('username') == "800"){
									echo "<option selected=\"true\" value=\"VO0003\">MINI K-MART GELURAN</option>";
									echo "<option selected=\"true\" value=\"VO0004\">MINI K-MART GKB</option>";
									echo "<option selected=\"true\" value=\"VO0005\">MINI K-MART PANJUNAN</option>";
								}else{
									foreach ($DataToko as $key => $value) {
										if($this->session->userdata('toko_kode') == $value['kode']){
											echo "<option selected=\"true\" value=\"".$value['kode']."\">".$value['nama']."</option>";
										}else{
											echo "<option value=\"".$value['kode']."\">".$value['nama']."</option>";
										}
									}
								}
								?>
							</select>
						</div>
					</td>
					<td style="width: 200px;">
						KasBank :
						<div class="form-group input-group">
							<span class="input-group-addon">
								<i class="fa fa-user"></i>
							</span>
							<select style="width: 150px;" class="form-control" name="search_kd_kb" id="search_kd_kb">
								<?php 
									//if($this->session->userdata('toko_kode') == 'VO0008'){
										foreach ($DataKasBank as $key => $value) {
											echo "<option value=\"".$value['kd_kb']."\">".$value['keterangan']."</option>";
										}
									//}else{
									//	foreach ($DataKasBank as $key => $value) {
									//		echo "<option value=\"".$value['kd_kb']."\">".$value['keterangan']."</option>";
									//	}
									//}
								?>
							</select>
						</div>
					</td>
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
			<table class="table table-striped table-bordered table-hover" id="table-kasbank">
				<thead>
					<tr>
						<th>Tanggal</th>
						<th>No. Bukti</th>
						<th>Kode Subject</th>
						<th>Dibayarkan/Diterima</th>
						<th>Keterangan</th>
						<th>CB</th>
						<th>Saldo Awal</th>
						<th>Debet</th>
						<th>Kredit</th>
						<th>Saldo Akhir</th>
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
		
		$('#mutasi_tanggal_awal').datepicker({
			format: 'yyyy-mm-dd'
		});
		$('#mutasi_tanggal_akhir').datepicker({
			format: 'yyyy-mm-dd'
		});
		
		$('.datepicker tbody').on('click', function(){  $('.datepicker').hide() });
	});
	
	function LoadDataMutasi(){
		$("#progres-main").show();
		
		var tanggal_awal = $("#mutasi_tanggal_awal").val();
		var tanggal_akhir = $("#mutasi_tanggal_akhir").val();
		var unit_kode = $("#search_toko_kode").val();
		var kd_kb = $("#search_kd_kb").val();
		$.ajax({
			type: "POST",
			url: "<?= base_url('index.php/laporan/mutasikasbank/getmutasikasbank') ?>",
			data: "kd_kb="+kd_kb+"&tanggal_awal="+tanggal_awal+"&tanggal_akhir="+tanggal_akhir+"&unit_kode="+unit_kode,
			success: function(msg){
				$("#table-kasbank").html(msg);
				
				$("#progres-main").hide();
			}
		});
	}
	
	function CetakDataMutasi(){
		var tanggal_awal = $("#mutasi_tanggal_awal").val();
		var tanggal_akhir = $("#mutasi_tanggal_akhir").val();
		var unit_kode = $("#search_toko_kode").val();
		var nama_toko = $("#search_toko_kode option:selected").text();
		var kd_kb = $("#search_kd_kb").val();
		var nama_kb = $("#search_kd_kb option:selected").text();
		
		window.open('<?= base_url('index.php/laporan/mutasikasbank/cetakmutasikasbank?') ?>kd_kb='+kd_kb+'&tanggal_awal='+tanggal_awal+'&tanggal_akhir='+tanggal_akhir+'&unit_kode='+unit_kode+'&nama_kb='+nama_kb+'&nama_toko='+nama_toko,'_blank');
	}
</script>