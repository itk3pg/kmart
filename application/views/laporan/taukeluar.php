<div id="page-wrapper">
	<div class="row">
	    <div class="col-lg-12">
	        <h1 style="margin-top: 15px;" class="page-header">Data TAU Keluar</h1>
	    </div>
	    <!-- /.col-lg-12 -->
	</div>
	<div class="row">
		<div class="col-lg-12">
			<table style="float: right;">
				<tr>
					<td>
						<input type="checkbox" onchange="ChangePelanggan()" checked name="mode_pelanggan" id="mode_pelanggan" /> Semua
						<input type="text" class="form-control" style="width: 300px;" name="taukeluar_pelanggan" id="taukeluar_pelanggan" />
					</td>
					<td valign="middle">&nbsp;-&nbsp;</td>
					<td>
						Bulan:
						<div class="form-group input-group">
							<select class="form-control" style="width: 115px;" name="mutasi_bulan" id="mutasi_bulan">
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
							<input type="text" style="width: 100px;" value="<?= date('Y'); ?>" name="mutasi_tahun" id="mutasi_tahun" class="form-control">
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
            <div id="table-taukeluar"></div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		OpenMenu();
		LoadDataMutasi();
		LoadListPelanggan();
	});
	
	function LoadListPelanggan(){
	    $("#taukeluar_pelanggan").select2({
		    placeholder: "Cari Pelanggan",
		    minimumInputLength: 1,
		    ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
			    url: "<?php echo base_url(); ?>index.php/barang/getlistpelanggan",
			    dataType: 'json',
			    quietMillis: 250,
			    data: function (term, page) {
				    return {
				    	q: term, // search term
				    };
			    },
			    results: function (data, page) { // parse the results into the format expected by Select2.
			    	// since we are using custom formatting functions we do not need to alter the remote JSON data
			    	return { results: data.items };
			    },
			    cache: true
		    },
		    id: function(option){
		    	return option.kode;
		    },
		    formatResult: function (option) {
            	return "<span class=\"select2-match\"></span>"+option.nama_pelanggan;
            }, 
		    formatSelection: function (option) {
				$("#mode_pelanggan").removeAttr("checked");
            	return option.nama_pelanggan;
            }
	    });
	}
	
	function ChangePelanggan(){
		if($("#mode_pelanggan").is(':checked')){
			LoadListPelanggan();
		}
	}
	
	function LoadDataMutasi(){
		var bulan = $("#mutasi_bulan").val();
		var tahun = $("#mutasi_tahun").val();
		var pelanggan_kode = $("#taukeluar_pelanggan").val();
		
		if($("#mode_pelanggan").is(':checked')){
			pelanggan_kode = '';
		}
		
		if(bulan <= 7 && tahun <= 2015){
			alert("Laporan tidak tersedia");
		}else{
			$("#progres-main").show();
			$.ajax({
				type: "POST",
				url: "<?= base_url('index.php/laporan/taukeluar/getmutasitaukeluar') ?>",
				data: "bulan="+bulan+"&tahun="+tahun+"&pelanggan_kode="+pelanggan_kode,
				success: function(msg){
					$("#table-taukeluar").html(msg);
					
					$("#progres-main").hide();
				}
			});
		}
	}
	
	function CetakDataMutasi(){
		var bulan = $("#mutasi_bulan").val();
		var tahun = $("#mutasi_tahun").val();
		var pelanggan_kode = $("#taukeluar_pelanggan").val();
		
		window.open('<?= base_url('index.php/laporan/taukeluar/cetakmutasitaukeluar?') ?>bulan='+bulan+'&tahun='+tahun+'&pelanggan_kode='+pelanggan_kode,'_blank');
	}
</script>