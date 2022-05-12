<div id="page-wrapper">
	<div class="row">
	    <div class="col-lg-12">
	        <h1 style="margin-top: 15px;" class="page-header">Penjualan Non Tunai</h1>
	    </div>
	    <!-- /.col-lg-12 -->
	</div>
	<div class="row">
		<div class="col-lg-12">
			<table style="float: right;">
				<tr>
					<td style="width: 200px;">
						<select class="form-control" disabled style="width: 190px;" name="cari_toko_kode" id="cari_toko_kode">
							<option value="-1">Pilih Toko</option>
						</select>
					</td>
					<td style="width: 125px;">
						<input style="width: 115px;" type="text" name="tahun" id="tahun" value="<?= date("Y"); ?>" class="form-control" />
					</td>
					<td style="width: 125px;">
						<select style="width: 115px;" class="form-control" name="bulan" id="bulan">
							<option <?php if(date('m') == '01') echo "selected=\"selected\"" ?> value="01">Januari</option>
							<option <?php if(date('m') == '02') echo "selected=\"selected\"" ?> value="02">Februari</option>
							<option <?php if(date('m') == '03') echo "selected=\"selected\"" ?> value="03">Maret</option>
							<option <?php if(date('m') == '04') echo "selected=\"selected\"" ?> value="04">April</option>
							<option <?php if(date('m') == '05') echo "selected=\"selected\"" ?> value="05">Mei</option>
							<option <?php if(date('m') == '06') echo "selected=\"selected\"" ?> value="06">Juni</option>
							<option <?php if(date('m') == '07') echo "selected=\"selected\"" ?> value="07">Juli</option>
							<option <?php if(date('m') == '08') echo "selected=\"selected\"" ?> value="08">Agustus</option>
							<option <?php if(date('m') == '09') echo "selected=\"selected\"" ?> value="09">September</option>
							<option <?php if(date('m') == '10') echo "selected=\"selected\"" ?> value="10">Oktober</option>
							<option <?php if(date('m') == '11') echo "selected=\"selected\"" ?> value="11">November</option>
							<option <?php if(date('m') == '12') echo "selected=\"selected\"" ?> value="12">Desember</option>
						</select>
					</td>
					<td>
						<button id="btn_upload" onclick="LoadDataPenjualanNonTunai()" class="btn btn-info" type="button">
							<i class="fa fa-search"></i>
							&nbsp;&nbsp;Search
						</button>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="row" style="margin-top: 10px;">
		<div class="col-lg-12">
			<div class="message">
				
            </div>
			<div class="panel panel-default">
				<div class="panel-heading">
					&nbsp;
					<button id="btn_uedit" onclick="ApproveHarga()" class="btn btn-success btn-sm" type="button">
						<i class="fa fa-check"></i>
						&nbsp;&nbsp;Approve
					</button>
					<div id="progres-main" style="width: 150px; float: right; display: none;">
						<div class="progress progress-striped active">
							<div class="progress-bar progress-bar-info" style="width: 100%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="20" role="progressbar">
								<span class="sr-only">20% Complete</span>
							</div>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<div class="table-responsive table-penjualannontunai">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		OpenMenu();
		loadListToko();
		LoadDataPenjualanNonTunai();
	});
	
	function loadListToko(){
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>/index.php/toko/getListToko",
			data: "",
			success: function(msg){
				$("#cari_toko_kode").html(msg);
				
				$("#cari_toko_kode").val('<?php echo $this->session->userdata('toko_kode'); ?>');
			}
		});
	}
	
	function LoadDataPenjualanNonTunai(){
		$('#progres-main').show();
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>/index.php/penjualannontunai/getdatapenjualannontunai",
			data: "tahun="+$('#tahun').val()+"&bulan="+$('#bulan').val()+"&toko_kode="+$('#cari_toko_kode').val(),
			success: function(msg){
				$(".table-penjualannontunai").html(msg);
				//table = $('#dataTables-pembelian-barang').dataTable();
				$('#progres-main').hide();
				
				$('#dataTables-penjualannontunai tbody').on( 'click', 'tr', function () {
			        if ( $(this).hasClass('active') ) {
			            $(this).removeClass('active');
			        }else {
			            $('#dataTables-penjualannontunai tr.active').removeClass('active');
			            $(this).addClass('active');
			        }
			    } );
			}
		});
	}
	
	function Editharga(bukti, barang_kode){
		$("#form-edit-table-"+bukti+"-"+barang_kode).show();
		
		var harga = $("#harga_"+bukti+"_"+barang_kode).html();
		
		$("#harga_edit_"+bukti+"_"+barang_kode).val(removeCurrencyNormal(harga));
	}
	
	function CancelEditharga(bukti, barang_kode){
		$("#form-edit-table-"+bukti+"-"+barang_kode).hide();
	}
	
	function SimpanEditHarga(bukti, barang_kode){
		var barang_kode_arr = barang_kode.split(" ");
		var harga = $("#harga_edit_"+bukti+"_"+barang_kode_arr[0]).val();
		var kwt = removeCurrencyNormal($("#kwt_"+bukti+"_"+barang_kode_arr[0]).html());
		if(harga == ""){
			harga = 0;
		}
		var total = parseFloat(harga) * parseFloat(kwt);
		
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>/index.php/penjualannontunai/simpaneditharga",
			data: "bukti="+bukti+"&barang_kode="+barang_kode+"&harga="+harga+"&total="+total,
			success: function(msg){
				$("#harga_"+bukti+"_"+barang_kode_arr[0]).html(number_format(harga));
				$("#total_"+bukti+"_"+barang_kode_arr[0]).html(number_format(total));
			}
		});
		
		CancelEditharga(bukti, barang_kode_arr[0]);
	}
	
	function ApproveHarga(){
		var data_obj = $('#dataTables-penjualannontunai tr.active').attr("data");
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			$.ajax({
				type: "POST",
				url: "<?= base_url() ?>/index.php/penjualannontunai/approveharga",
				data: "bukti="+data['fcode'],
				success: function(msg){
					LoadDataPenjualanNonTunai();
				}
			});
		}
	}
</script>