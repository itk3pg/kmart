<div id="page-wrapper">
	<div class="row">
	    <div class="col-lg-12">
	        <h1 class="page-header">Sinkronisasi Data</h1>
	    </div>
	    <!-- /.col-lg-12 -->
	</div>
	<div class="row">
		<table>
			<tr>
				<td class="field_toko_kode" style="display: none;">
					Toko :
					<div class="form-group input-group">
						<span class="input-group-addon">
							<i class="fa fa-user"></i>
						</span>
						<select style="width: 150px;" class="form-control" name="search_toko_kode" id="search_toko_kode">
							<option value="">Pilih Toko</option>
							<?php
							foreach ($DataToko as $key => $value) {
								if($value['kode'] == "VO0006" || $value['kode'] == "VO0008"){
									//echo "<option selected=\"true\" value=\"".$value['kode']."\">".$value['nama']."</option>";
								}else{
									echo "<option value=\"".$value['kode']."\">".$value['nama']."</option>";
								}
							}
							?>
						</select>
					</div>
				</td>
				<td class="field_toko_barcode" style="display: none;">
					Kode Barang / Barcode :
					<div class="form-group input-group">
						<span class="input-group-addon">
							<i class="fa fa-box"></i>
						</span>
						<input type="text" name="search_barang" id="search_barang" class="form-control" />
					</div>
				</td>
				<!-- <td id="field_unit_kode" style="display: none;">
					Unit :
					<div class="form-group input-group">
						<span class="input-group-addon">
							<i class="fa fa-user"></i>
						</span>
						<select style="width: 150px;" class="form-control" name="search_unit_kode" id="search_unit_kode">
							<?php
							foreach ($DataToko as $key => $value) {
								echo "<option value=\"".$value['kode']."\">".$value['nama']."</option>";
							}
							?>
						</select>
					</div>
				</td>
				<td valign="middle">&nbsp;-&nbsp;</td> -->
				<td>
					Bulan:
					<div class="form-group input-group">
						<select class="form-control" style="width: 115px;" name="sync_saldo_bulan" id="sync_saldo_bulan">
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
						<input type="text" style="width: 100px;" value="<?= date('Y'); ?>" name="sync_saldo_tahun" id="sync_saldo_tahun" class="form-control">
					</div>
				</td>
				<td valign="middle">&nbsp;-&nbsp;</td>
				<td>
					Jenis Saldo:
					<div class="form-group input-group">
						<select class="form-control" onchange="PilihMode()"  name="sync_saldo_mode" id="sync_saldo_mode">
							<!-- <option value="kasbank">Saldo Kasbank</option>
							<option value="hutang">Saldo Hutang</option>
							<option value="piutang">Saldo Piutang</option>
							<option value="barang_gudang">Saldo Barang Toko</option>
							<option value="barang_gudang_utama">Saldo Barang DC</option> -->
							<option value="saldo_awal">Saldo Barang Awal Bulan</option>
							<option value="anggota">Data Anggota</option>
							<option value="barang">HPP</option>
							<option value="hargajual">Harga Jual</option>
							<option value="barang_gudang">Saldo Barang Toko</option>
							<option value="barang_gudang_konsinyasi">Saldo Barang Toko Konsinyasi</option>
							<option value="barang_gudang_utama">Saldo Barang DC</option>
						</select>
					</div>
				</td>
				<td valign="middle">&nbsp;&nbsp;&nbsp;</td>
				<td>
					<button class="btn btn-primary" onclick="syncdatasaldo()">
						<span class="glyphicon glyphicon-refresh"></span>
						&nbsp;&nbsp;Sync Saldo
					</button>
				</td>
			</tr>
		</table>
	</div>
</div>
<script>
	$(document).ready(function(){
		OpenMenu();
		PilihMode();
	});
	
	function PilihMode(){
		var mode = $("#sync_saldo_mode").val();
		
		if(mode == "barang_gudang" || mode == "barang_gudang_konsinyasi"){
			$(".field_toko_kode").show();
			$(".field_toko_barcode").show();
		}else{
			$(".field_toko_kode").hide();
			$(".field_toko_barcode").hide();
		}
		
		if(mode == "hargajual"){
			$(".field_toko_kode").show();
			$(".field_toko_barcode").hide();
		}
	}
	
	function syncdatasaldo(){
		var unit_kode = $('#search_toko_kode').val();
		var mode = $("#sync_saldo_mode").val();
		var barang_kode =  $('#search_barang').val();

		window.open('<?= base_url(); ?>index.php/sinkronisasi/syncsaldo?bulan='+$('#sync_saldo_bulan').val()+'&tahun='+$('#sync_saldo_tahun').val()+'&mode='+$('#sync_saldo_mode').val()+'&toko_kode='+unit_kode+'&barang_kode='+barang_kode, '_blank');
	}
</script>