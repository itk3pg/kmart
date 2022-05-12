<div id="page-wrapper">
	<div class="row">
	    <div class="col-lg-12">
	        <h1 class="page-header">Export Data ke DBF</h1>
	    </div>
	    <!-- /.col-lg-12 -->
	</div>
	<div class="row">
		<table>
			<tr>
				<td>
					Bulan:
					<div class="form-group input-group">
						<select class="form-control" style="width: 115px;" name="downloaddbf_bulan" id="downloaddbf_bulan">
							<option <?php if(date("m") == 1) echo "selected=\"true\"" ?> value="01">Januari</option><option <?php if(date("m") == 2) echo "selected=\"true\"" ?> value="02">Februari</option>
							<option <?php if(date("m") == 3) echo "selected=\"true\"" ?> value="03">Maret</option><option <?php if(date("m") == 4) echo "selected=\"true\"" ?> value="04">April</option>
							<option <?php if(date("m") == 5) echo "selected=\"true\"" ?> value="05">Mei</option><option <?php if(date("m") == 6) echo "selected=\"true\"" ?> value="06">Juni</option>
							<option <?php if(date("m") == 7) echo "selected=\"true\"" ?> value="07">Juli</option><option <?php if(date("m") == 8) echo "selected=\"true\"" ?> value="08">Agustus</option>
							<option <?php if(date("m") == 9) echo "selected=\"true\"" ?> value="09">September</option><option <?php if(date("m") == 10) echo "selected=\"true\"" ?> value="10">Oktober</option>
							<option <?php if(date("m") == 11) echo "selected=\"true\"" ?> value="11">November</option><option <?php if(date("m") == 12) echo "selected=\"true\"" ?> value="12">Desember</option>
						</select>
					</div>
				</td>
				<td valign="middle">&nbsp;-&nbsp;</td>
				<td>
					Tahun:
					<div class="form-group input-group">
						<input type="text" style="width: 100px;" value="<?= date('Y'); ?>" name="downloaddbf_tahun" id="downloaddbf_tahun" class="form-control">
					</div>
				</td>
				<td valign="middle">&nbsp;-&nbsp;</td>
				<td>
					Jenis Data:
					<div class="form-group input-group">
						<select class="form-control"  name="downloaddbf_mode" id="downloaddbf_mode">
							<option value="pembelian_tunai">Pembelian Tunai</option>
							<option value="pembelian_kredit">Pembelian Kredit</option>
							<option value="retur_barang_dc">Retur Barang DC</option>
							<option value="pembayaran_hutang">Pembayaran Hutang</option>
							<option value="dropping_kaskecil">Dropping Kas Kecil</option>
						</select>
					</div>
				</td>
				<td valign="middle">&nbsp;&nbsp;&nbsp;</td>
				<td>
					<button class="btn btn-primary" onclick="downloaddbf()">
						<span class="glyphicon glyphicon-refresh"></span>
						&nbsp;&nbsp;Download DBF
					</button>
				</td>
			</tr>
		</table>
	</div>
</div>
<script>
	$(document).ready(function(){
		OpenMenu();
	});
	
	function downloaddbf(){
		var mode = $("#downloaddbf_mode").val();
		var bulan = $('#downloaddbf_bulan').val();
		var tahun = $('#downloaddbf_tahun').val();
		
		var url = "";
		switch(mode){
			case "pembelian_kredit" :
				url = "pembeliankredit";
				break;
			case "pembelian_tunai" :
				url = "pembeliantunai";
				break;
			case "retur_barang_dc" :
				url = "retursupplier";
				break;
			case "pembayaran_hutang" :
				url = "pembayaranhutang";
				break;
			case "dropping_kaskecil" :
				url = "droppingkaskecil";
				break;
		}
		
		$.ajax({
			type: "POST",
			url: "<?= base_url(); ?>index.php/exportdbf/"+url,
			data: "bulan="+bulan+"&tahun="+tahun+"&mode="+mode,
			success: function(msg){
				window.open("<?= base_url(); ?>dbfdir/"+msg,"_blank");
			}
		});
	}
</script>