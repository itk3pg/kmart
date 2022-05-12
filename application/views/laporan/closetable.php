<div id="page-wrapper">
	<div class="row">
	    <div class="col-lg-12">
	        <h1 style="margin-top: 15px;" class="page-header">Closing Meja</h1>
	    </div>
	    <!-- /.col-lg-12 -->
	</div>
	<div class="row">
		<div class="col-lg-12">
			<table style="float: right;">
				<tr>
					<td>
						Kode Transaksi:
						<div class="form-group input-group">
							<input type="text" style="width: 100px;" name="mutasi_ftranskey" id="mutasi_ftranskey" class="form-control">
						</div>
					</td>
					<td>&nbsp;&nbsp;</td>
					<td>
						<button id="btn_search" onclick="LoadDataTable()" class="btn btn-info" type="button">
							<i class="fa fa-search"></i>
							&nbsp;&nbsp;Search
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
            <div id="table-dataclose"></div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		OpenMenu();
	});
	
	function LoadDataTable(){
		var ftranskey = $("#mutasi_ftranskey").val();
		
		$("#progres-main").show();
		$.ajax({
			type: "POST",
			url: "<?= base_url('index.php/laporan/closetable/getdatatable') ?>",
			data: "key="+ftranskey,
			success: function(msg){
				$("#table-dataclose").html(msg);
				
				$("#progres-main").hide();
			}
		});
	}
	
	function CloseTable(transkey){
		var konfirmasi = confirm("Apakah anda ingin menutup meja tersebut?");
		
		if(konfirmasi){
			$("#progres-main").show();
			$.ajax({
				type: "POST",
				url: "<?= base_url('index.php/laporan/closetable/prosesclosetable') ?>",
				data: "ftranskey="+transkey,
				success: function(msg){
					$("#progres-main").hide();
					alert('Meja berhasil ditutup');
					LoadDataTable();
				}
			});
		}
	}
</script>