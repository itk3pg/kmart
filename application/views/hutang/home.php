<style>
	.question{z-index:1151 !important;}
	.datepicker{z-index:1151 !important;}
</style>
<div id="page-wrapper">
	<div class="row">
	    <div class="col-lg-12">
	        <h1 style="margin-top: 15px;" class="page-header">Data Hutang</h1>
	    </div>
	    <!-- /.col-lg-12 -->
	</div>
	<div class="row">
		<div class="col-lg-12">
			<table style="float: right;">
				<tr>
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
						<button id="btn_upload" onclick="LoadDataHutang()" class="btn btn-info" type="button">
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
			<div class="panel panel-default">
				<div class="panel-heading">
					<!--&nbsp;
                    <button id="btn_upload" onclick="openFormPembayaran(1)" class="btn btn-info btn-sm" type="button">
						<i class="fa fa-plus"></i>
						&nbsp;&nbsp;Bayar
					</button>
					<button id="btn_upload" onclick="openDetailPembayaran()" class="btn btn-info btn-sm" type="button">
						<i class="fa fa-table"></i>
						&nbsp;&nbsp;Detail Pembayaran
					</button>-->
					<div id="progres-main" style="width: 150px; float: right; display: none;">
						<div class="progress progress-striped active">
							<div class="progress-bar progress-bar-info" style="width: 100%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="20" role="progressbar">
								<span class="sr-only">20% Complete</span>
							</div>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<div class="table-responsive table-hutang">
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Popup form untuk detail pembayaran -->
	<div class="modal fade" id="form-detail-pembayaran" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        			<h4 class="modal-title" id="myModalLabel">Detail Pembayaran</h4>
				</div>
				<div class="modal-body">
					<div class="panel panel-default">
						<div class="panel-heading">
							<button style="margin-top: -5px;" onclick="openFormPembayaran(1)" class="btn btn-info btn-sm" type="button">
								<i class="fa fa-plus"></i>
								&nbsp;&nbsp;Bayar
							</button>
							<!-- <button style="margin-top: -5px;" onclick="openFormPembayaran(2)" class="btn btn-info btn-sm" type="button">
								<i class="fa fa-edit"></i>
								&nbsp;&nbsp;Edit
							</button> -->
							<button style="margin-top: -5px;" fungsi="HapusPembayaran()" class="btn btn-danger btn-sm ask" type="button">
								<i class="fa fa-times"></i>
								&nbsp;&nbsp;Hapus
							</button>
							<div id="progres-pembayaran" style="width: 150px; float: right; display: none;">
								<div class="progress progress-striped active">
									<div class="progress-bar progress-bar-info" style="width: 100%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="20" role="progressbar">
										<span class="sr-only">20% Complete</span>
									</div>
								</div>
							</div>
						</div>
						<div class="panel-body">
							<input type="hidden" name="hidden_kd_pengadaan" id="hidden_kd_pengadaan" value="" />
							<div class="table-responsive table-pembayaran">
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Popup form untuk bayar hutang -->
	<div class="modal fade" id="form-pembayaran" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        			<h4 class="modal-title" id="myModalLabel">Form Pembayaran Hutang</h4>
				</div>
				<div class="modal-body">
					<table width="100%">
						<tr>
							<td valign="top">
								Tanggal :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</span>
									<input type="text" value="<?= date("Y-m-d"); ?>" placeholder="Tanggal Pembayaran" name="pembayaran_tanggal" id="pembayaran_tanggal" class="form-control">
								</div>
								Jumlah Hutang :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-money"></i>
									</span>
									<input type="hidden" name="pembayaran_mode" id="pembayaran_mode" value="1" />
									<input type="text" style="text-align: right;" placeholder="Jumlah Hutang" disabled name="pembayaran_jumlah_hutang" id="pembayaran_jumlah_hutang" class="form-control">
								</div>
								Sisa Hutang :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-money"></i>
									</span>
									<input type="text" style="text-align: right;" placeholder="Sisa Hutang" disabled name="pembayaran_sisa_hutang" id="pembayaran_sisa_hutang" class="form-control">
								</div>
							</td>
							<td>&nbsp;&nbsp;&nbsp;</td>
							<td valign="top">
								Jumlah Bayar:
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-money"></i>
									</span>
									<input type="text" style="text-align: right;" placeholder="Jumlah Pembayaran" onkeyup="price('pembayaran_pembayaran'); HitungBatas();" name="pembayaran_pembayaran" id="pembayaran_pembayaran" class="form-control">
								</div>
								Dari:
								<div class="form-group">
									<label class="radio-inline">
										<input id="pembayaran_kas_kecil" type="radio" checked value="111" name="pembayaran_dari"> Kas Kecil
									</label>
									<label class="radio-inline">
										<input id="pembayaran_kas_besar" type="radio" value="110" name="pembayaran_dari"> Kas Besar
									</label>
									<label class="radio-inline">
										<input id="pembayaran_giro" type="radio" value="222" name="pembayaran_dari"> Cek / Giro
									</label>
								</div>
							</td>
						</tr>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" onclick="clearForm(1)" class="btn btn-default">Reset</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<img src="<?= base_url() ?>/images/loader.gif" id="loader-form"  style="width: 30px; display: none;" />
			        <button type="button" id="btn-simpan" onclick="simpanpembayaran()" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;&nbsp;Simpan</button>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		OpenMenu();
		
		$('#pembayaran_tanggal').datepicker({
			format: 'yyyy-mm-dd'
		});
		
		LoadDataHutang();
		
		$('.ask').jConfirmAction();
		$('.datepicker tbody').on('click', function(){  $('.datepicker').hide() });
	});
	
	function LoadDataHutang(){
		$('#progres-main').show();
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/hutang/getdatahutang",
			data: "tahun="+$('#tahun').val()+"&bulan="+$('#bulan').val(),
			success: function(msg){
				$(".table-hutang").html(msg);
				table = $('#dataTables-hutang').dataTable();
				$('#progres-main').hide();
				
				$('#dataTables-hutang tbody').on( 'click', 'tr', function () {
			        if ( $(this).hasClass('active') ) {
			            $(this).removeClass('active');
			        }else {
			            table.$('tr.active').removeClass('active');
			            $(this).addClass('active');
			        }
			        
			        $("#hidden_kd_pengadaan").val(table.$('tr.active').attr("bukti"));
			    } );
			    
			    var hidden_kd_pengadaan = $("#hidden_kd_pengadaan").val();
			    if(hidden_kd_pengadaan != ""){
			    	setSelection($("#hidden_kd_pengadaan").val());
			    }
			}
		});
	}
	
	function LoadDetailPembayaran(){
		$(".table-pembayaran").html("");
		$('#progres-pembayaran').show();
		var kd_pengadaan = table.$('tr.active').attr("bukti");
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/hutang/getdetailpembayaran",
			data: "kd_pengadaan="+kd_pengadaan,
			success: function(msg){
				$(".table-pembayaran").html(msg);
				table_pembayaran = $('#dataTables-pembayaran').dataTable();
				
				$('#progres-pembayaran').hide();
				
				$('#dataTables-pembayaran tbody').on( 'click', 'tr', function () {
			        if ( $(this).hasClass('active') ) {
			            $(this).removeClass('active');
			        }else {
			            table_pembayaran.$('tr.active').removeClass('active');
			            $(this).addClass('active');
			        }
			    } );
			}
		});
	}
	
	function openFormPembayaran(mode){
		var hutang = table.$('tr.active').attr("hutang");
		var sisa = table.$('tr.active').attr("sisa");
		
		if(typeof hutang == 'undefined'){
			alert("Silahkan pilih salah satu data");
		}else{
			var jumlah = 0;
			if(mode == 2){
				jumlah = table_pembayaran.$('tr.active').attr("jm_bayar");
			}
			
			$("#pembayaran_jumlah_hutang").val(hutang);
			$("#pembayaran_sisa_hutang").val(sisa);
			price_js('pembayaran_jumlah_hutang');
			price_js('pembayaran_sisa_hutang');
			$("#pembayaran_mode").val(mode);
			if(mode == 2){ // untuk edit pembayaran
				$("#pembayaran_pembayaran").val(jumlah);
				price_js("pembayaran_pembayaran");
			}
			
			$('#form-pembayaran').modal('show');
		}
	}
	
	function HitungBatas(){
		var sisa = removeCurrency($("#pembayaran_sisa_hutang").val());
		var bayar = removeCurrency($("#pembayaran_pembayaran").val());
		
		if(bayar > 0){
			if(parseFloat(bayar) > parseFloat(sisa)){
				$("#pembayaran_pembayaran").val(sisa);
				price_js("pembayaran_pembayaran");
			}
		}else{
			$("#pembayaran_pembayaran").val("");
		}
	}
	
	function clearForm(mode){
		switch (mode){
			case 1:
				$("#pembayaran_pembayaran").val("");
				break;
		}
	}
	
	function simpanpembayaran(){
		$('#btn-simpan').hide();
		$('#loader-form').show();
		
		var supplier_kode = table.$('tr.active').attr("supplier_kode");
		var nama_supplier = table.$('tr.active').attr("nama_supplier");
		var kd_pengadaan = table.$('tr.active').attr("bukti");
		var jumlah_pembayaran = removeCurrency($("#pembayaran_pembayaran").val());
		var mode_form = $("#pembayaran_mode").val();
		var id_pembayaran = "";
		var jumlah_lama = 0;
		var ref_kasbank = "";
		if(mode_form == 2){
			id_pembayaran = table_pembayaran.$('tr.active').attr("id_pembayaran");
			jumlah_lama = table_pembayaran.$('tr.active').attr("jm_bayar");
			ref_kasbank = table_pembayaran.$('tr.active').attr("ref_kasbank");
		}
		var pembayaran_dari = $("input[name=pembayaran_dari]:checked").val();
		var tanggal = $("#pembayaran_tanggal").val();
		
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/hutang/simpanpembayaran",
			data: "ref_pengadaan="+kd_pengadaan+"&jumlah="+jumlah_pembayaran+"&supplier_kode="+supplier_kode+"&nama_supplier="+nama_supplier+"&mode_form="+mode_form+"&jumlah_lama="+jumlah_lama+"&id_pembayaran="+id_pembayaran+"&pembayaran_dari="+pembayaran_dari+"&ref_kasbank="+ref_kasbank+"&tanggal="+tanggal,
			success: function(msg){
				$('#form-pembayaran').modal('hide');
				LoadDataHutang();
				
				LoadDetailPembayaran();
				$('#btn-simpan').show();
				$('#loader-form').hide();
				clearForm(1);
			},
			error: function(xhr,status,error){
				alert(status);
				$('#btn-simpan').show();
				$('#loader-form').hide();
			}
		});
	}
	
	function HapusPembayaran(){
		var id_pembayaran = table_pembayaran.$('tr.active').attr("id_pembayaran");
		var jumlah = table_pembayaran.$('tr.active').attr("jm_bayar");
		var supplier_kode = table.$('tr.active').attr("supplier_kode");
		var ref_pengadaan = table.$('tr.active').attr("bukti");
		var tanggal = table_pembayaran.$('tr.active').attr("tanggal");
		
		$.ajax({
			type: "POST",
			url: "<?= base_url(); ?>index.php/hutang/hapuspembayaran",
			data: "id_pembayaran="+id_pembayaran+"&supplier_kode="+supplier_kode+"&jumlah="+jumlah+"&ref_pengadaan="+ref_pengadaan+"&tanggal="+tanggal,
			success: function(msg){
				LoadDataHutang();
				
				LoadDetailPembayaran();
			}
		});
	}
	
	function setSelection(nama_id){
		$('tr.active').removeClass('active');
		$('tr#'+nama_id).addClass('active');
	}
	
	function openDetailPembayaran(){
		$('#form-detail-pembayaran').modal('show');
		// var kd_pengadaan = table.$('tr.active').attr("bukti");
		// $("#hidden_kd_pengadaan").val(kd_pengadaan);
		
		LoadDetailPembayaran();
	}
</script>