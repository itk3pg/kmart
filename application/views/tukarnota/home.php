<style>
	.datepicker{z-index:1151 !important;}
</style>
<div id="page-wrapper">
	<div class="row">
	    <div class="col-lg-12">
	        <h1 style="margin-top: 15px;" class="page-header">Tukar Nota (TT)</h1>
	    </div>
	    <!-- /.col-lg-12 -->
	</div>
	<div class="row" style="margin-bottom: 10px;">
		<div class="col-lg-12">
			<table style="float: right;">
				<tr>
					<!--<td style="width: 125px;">
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
					</td>-->
					<td>
						Tanggal Awal :
						<div class="form-group input-group">
							<span class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</span>
							<input type="text" value="<?= date('Y-m-d'); ?>" name="search_tanggal_awal" id="search_tanggal_awal" class="form-control">
						</div>
					</td>
					<td>&nbsp;&nbsp;</td>
					<td>
						Tanggal Akhir :
						<div class="form-group input-group">
							<span class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</span>
							<input type="text" value="<?= date('Y-m-d'); ?>" name="search_tanggal_akhir" id="search_tanggal_akhir" class="form-control">
						</div>
					</td>
					<td>&nbsp;&nbsp;</td>
					<td valign="top">
						<button id="btn_upload" onclick="LoadDataTukarNota()" class="btn btn-info" type="button">
							<i class="fa fa-search"></i>
							&nbsp;&nbsp;Search
						</button>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="message"></div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<button id="btn_tambah" onclick="openFormTukarNota()" class="btn btn-info btn-sm" type="button">
						<i class="fa fa-plus"></i>
						&nbsp;&nbsp;Tambah
					</button>
					<button id="btn_uedit" onclick="openFormEditTukarNota()" class="btn btn-success btn-sm" type="button">
						<i class="fa fa-edit"></i>
						&nbsp;&nbsp;Edit
					</button>
					<!--<button id="btn_uedit" onclick="openDetailTukarNota()" class="btn btn-success btn-sm" type="button">
						<i class="fa fa-check"></i>
						&nbsp;&nbsp;Detail
					</button>-->
					<button id="btn_hapus" fungsi="HapusTukarNota()" class="btn btn-danger btn-sm ask-tukarnota" type="button">
						<i class="fa fa-times"></i>
						&nbsp;&nbsp;Hapus
					</button>
					<button id="btn_hapus" onclick="CetakTukarNota()" class="btn btn-warning btn-sm" type="button">
						<i class="fa fa-print"></i>
						&nbsp;&nbsp;Cetak
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
					<div class="table-responsive table-tukarnota">
						
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Popup form untuk tukar nota -->
	<div class="modal fade" id="form-tukarnota" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        			<h4 class="modal-title" id="myModalLabel">Form Tukar Nota (TT)</h4>
				</div>
				<div class="modal-body">
					<table style="width: 69%;">
						<tr>
							<td style="width: 200px;">Tanggal :</td>
							<td>&nbsp;&nbsp;
								<input type="hidden" name="mode" id="mode" value="i"/>
								<input type="hidden" name="tukarnota_bukti" id="tukarnota_bukti"/>
							</td>
							<td>Supplier :</td>
						</tr>
						<tr>
							<td>
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</span>
									<input type="text" value="<?= date("Y-m-d"); ?>" placeholder="Tanggal Tukar Nota" name="tukarnota_tanggal" id="tukarnota_tanggal" class="form-control">
								</div>
							</td>
							<td>&nbsp;&nbsp;</td>
							<td>
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<select class="form-control" onchange="ListPengadaanSupplier();getJatuhTempo();" name="tukarnota_supplier" id="tukarnota_supplier">
										<option value="-1">Pilih Supplier</option>
									</select>
								</div>
							</td>
						</tr>
					</table>
					<input type="hidden" name="bukti_od" id="bukti_od" />
					<table style="width: 100%; margin-bottom: 5px; margin-top: 5px;">
						<tr>
							<!--<td width="250px">Bukti Pengadaan :</td>
							<td>&nbsp;&nbsp;</td>-->
							<td width="170px">Jumlah Hutang :</td>
							<td>&nbsp;&nbsp;</td>
							<td width="170px">Jumlah Retur :</td>
							<td>&nbsp;&nbsp;</td>
							<td width="170px">Jumlah Listing :</td>
							<td>&nbsp;&nbsp;</td>
							<td width="170px">Sisa Hutang :</td>
							<td>&nbsp;&nbsp;</td>
							<td>Jatuh Tempo</td>
						</tr>
						<tr>
							<!--<td width="250px"><input type="text" class="form-control" name="tukarnota_pengadaan" id="tukarnota_pengadaan" /></td>
							<td>&nbsp;&nbsp;</td>-->
							<td><input type="text" style="text-align: right;" readonly class="form-control" name="tukarnota_jumlah_hutang" id="tukarnota_jumlah_hutang" /></td>
							<td>&nbsp;&nbsp;</td>
							<td>
								<input type="text" style="text-align: right;" readonly onclick="openFormEditTotalRetur()" onkeyup="price('tukarnota_jumlah_potongan');" class="form-control" name="tukarnota_jumlah_potongan" id="tukarnota_jumlah_potongan" />
							</td>
							<td>&nbsp;&nbsp;</td>
							<td>
								<input type="text" style="text-align: right;" readonly onclick="openFormEditTotalListing()" onkeyup="price('tukarnota_jumlah_listing');" class="form-control" name="tukarnota_jumlah_listing" id="tukarnota_jumlah_listing" />
							</td>
							<td>&nbsp;&nbsp;</td>
							<td><input type="text" style="text-align: right;" class="form-control" readonly name="tukarnota_sisa_hutang" id="tukarnota_sisa_hutang" /></td>
							<td>&nbsp;&nbsp;</td>
							<td>
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</span>
									<input type="text" value="<?= date("Y-m-d"); ?>" placeholder="Jatuh Tempo" name="tukarnota_jatuh_tempo" id="tukarnota_jatuh_tempo" class="form-control">
								</div>
							</td>
						</tr>
					</table>
					<strong>Daftar Penerimaan</strong>
					<table style="width: 100%" id="table-dummy-tukarnota" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th class="text-center">Bukti</th>
								<th class="text-center">Tanggal</th>
								<th class="text-center">Jumlah</th>
								<th class="text-center">Penyesuaian</th>
								<th class="text-center">Total</th>
								<th class="text-center">Bukti Penyesuaian</th>
								<th class="text-center">No Faktur</th>
								<th class="text-center">Hapus</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
					<strong>Daftar Retur</strong>
					<table style="width: 100%" id="table-dummy-retur" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th class="text-center">Bukti</th>
								<th class="text-center">Tanggal</th>
								<th class="text-center">Jumlah</th>
								<th class="text-center">Hapus</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
					<strong>Daftar Potongan Lain</strong>
					<table style="width: 100%" id="table-dummy-pendapatan" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th class="text-center">Bukti</th>
								<th class="text-center">Tanggal</th>
								<th class="text-center">Keterangan</th>
								<th class="text-center">Jumlah</th>
								<th class="text-center">Hapus</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" onclick="clearForm()" id="btn-reset" class="btn btn-default">Reset</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<img src="<?= base_url() ?>/images/loader.gif" id="loader-form"  style="width: 30px; display: none;" />
			        <button type="button" id="btn-simpan" onclick="SimpanTukarNota()" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;&nbsp;Simpan</button>
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal fade" id="form-nofaktur" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        			<h4 class="modal-title" id="myModalLabel">Form Nomor Faktur Pajak</h4>
				</div>
				<div class="modal-body">
					Bukti Pengadaan (BI)
					<div class="form-group input-group">
						<span class="input-group-addon">
							<i class="fa fa-file"></i>
						</span>
						<input type="text" name="tukarnota_pengadaan_bukti" id="tukarnota_pengadaan_bukti" readonly class="form-control">
					</div>
					No Faktur Pajak
					<div class="form-group input-group">
						<span class="input-group-addon">
							<i class="fa fa-file"></i>
						</span>
						<input type="text" placeholder="Nomor Faktur Pajak" name="tukarnota_nofaktur" id="tukarnota_nofaktur" class="form-control">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" onclick="clearFormFaktur()" id="btn-reset" class="btn btn-default">Reset</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<img src="<?= base_url() ?>/images/loader.gif" id="loader-form"  style="width: 30px; display: none;" />
			        <button type="button" id="btn-simpan" onclick="SimpanNoFakturPajak()" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;&nbsp;Simpan</button>
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal fade" id="form-edit-total-retur" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        			<h4 class="modal-title" id="myModalLabel">Edit Jumlah Retur</h4>
				</div>
				<div class="modal-body">
					Total Retur
					<div class="form-group input-group">
						<span class="input-group-addon">
							<i class="fa fa-file"></i>
						</span>
						<input type="text" class="form-control" onkeyup="price('edit_total_retur')" style="text-align:right;" name="edit_total_retur" id="edit_total_retur" />
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<img src="<?= base_url() ?>/images/loader.gif" id="loader-form"  style="width: 30px; display: none;" />
			        <button type="button" id="btn-simpan" onclick="SimpanEditTotalRetur()" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;&nbsp;Simpan</button>
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal fade" id="form-edit-total-listing" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        			<h4 class="modal-title" id="myModalLabel">Edit Jumlah Listing</h4>
				</div>
				<div class="modal-body">
					Total Listing
					<div class="form-group input-group">
						<span class="input-group-addon">
							<i class="fa fa-file"></i>
						</span>
						<input type="text" class="form-control" onkeyup="price('edit_total_listing')" style="text-align:right;" name="edit_total_listing" id="edit_total_listing" />
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<img src="<?= base_url() ?>/images/loader.gif" id="loader-form"  style="width: 30px; display: none;" />
			        <button type="button" id="btn-simpan" onclick="SimpanEditTotalListing()" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;&nbsp;Simpan</button>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		OpenMenu();
		LoadDataTukarNota();
		//LoadListDataBarang();
		loadListSupplier();
		
		$('.ask-tukarnota').jConfirmAction();
		
		$('#tukarnota_tanggal').datepicker({
			format: 'yyyy-mm-dd'
		});
		$('#tukarnota_jatuh_tempo').datepicker({
			format: 'yyyy-mm-dd'
		});
		$('#search_tanggal_awal').datepicker({
			format: 'yyyy-mm-dd'
		});
		$('#search_tanggal_akhir').datepicker({
			format: 'yyyy-mm-dd'
		});
		
		$('.datepicker tbody').on('click', function(){  $('.datepicker').hide() });
	});
	
	function loadListSupplier(){
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/supplier/getselectsupplier",
			data: "",
			success: function(msg){
				$("#tukarnota_supplier").html(msg);
				$("#tukarnota_supplier").select2();
			}
		});
	}
	
	function LoadDataTukarNota(){
		$('#progres-main').show();
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/tukarnota/getdatatukarnota",
			data: "tanggal_awal="+$("#search_tanggal_awal").val()+"&tanggal_akhir="+$("#search_tanggal_akhir").val(),
			success: function(msg){
				$(".table-tukarnota").html(msg);
				$('#dataTables-tukarnota').dataTable();
				$('#progres-main').hide();
				
				$('#dataTables-tukarnota tbody').on( 'click', 'tr', function () {
			        if ( $(this).hasClass('active') ) {
			            $(this).removeClass('active');
			        }else {
			            $('#dataTables-tukarnota tr.active').removeClass('active');
			            $(this).addClass('active');
			        }
			    } );
			}
		});
	}
	
	function openFormTukarNota(){
		$("#form-tukarnota").modal("show");
		$("#mode").val("i");
		$("#tukarnota_bukti").val("");
		
		$("#btn-reset").show();
		$("#btn-simpan").show();
	}
	
	function HapusRow(DataObj){
		dataobj = DataObj;
		dataobj = DataObj;
		$(DataObj).parent().parent().remove();
		
		HitungJumlah();
	}
	
	function clearForm(){
		$('#table-dummy-tukarnota tbody').html("");
		$('#table-dummy-retur tbody').html("");
		$('#table-dummy-pendapatan tbody').html("");
		$("#tukarnota_jumlah_hutang").val("");
		$("#tukarnota_jumlah_potongan").val("");
		$("#tukarnota_supplier").select2("val", "");
		$("#tukarnota_bukti").val("");
		$("#tukarnota_sisa_hutang").val("");
		$("#tukarnota_jatuh_tempo").val('<?php echo date('Y-m-d'); ?>');
	}
	
	function SimpanTukarNota(){
		$('#btn-simpan').hide();
		$('#loader-form').show();
		
		var dataArr = [];
	    $("#table-dummy-tukarnota td").each(function(){
	        dataArr.push($(this).html());
	    });
		var dataArrRetur = [];
	    $("#table-dummy-retur td").each(function(){
	        dataArrRetur.push($(this).html());
	    });
		var dataArrPendapatan = [];
	    $("#table-dummy-pendapatan td").each(function(){
	        dataArrPendapatan.push($(this).html());
	    });
	    var mode = $("#mode").val();
		var bukti = $("#tukarnota_bukti").val();
		
		if(mode == "i"){
			var modeBukti = "TT";
			var tanggal_tukarnota = $("#tukarnota_tanggal").val();
			$.ajax({
				type: "POST",
				url: "<?= base_url() ?>index.php/bukti/generatebukti",
				data: "mode="+modeBukti+"&tanggal="+tanggal_tukarnota,
				success: function(msg){
					var jsonData = rawurlencode(json_encode(dataArr));
					var jsonDataRetur = rawurlencode(json_encode(dataArrRetur));
					var jsonDataPendapatan = rawurlencode(json_encode(dataArrPendapatan));
					ajaxsimpantukarnota(msg, jsonData, jsonDataRetur, jsonDataPendapatan);
				}
			});
		}else{
			$.ajax({
				type: "POST",
				url: "<?= base_url(); ?>index.php/tukarnota/hapusdetailtukarnota",
				data: "bukti="+bukti,
				success: function(msg){
					var jsonData = rawurlencode(json_encode(dataArr));
					var jsonDataRetur = rawurlencode(json_encode(dataArrRetur));
					var jsonDataPendapatan = rawurlencode(json_encode(dataArrPendapatan));
					ajaxsimpantukarnota(bukti, jsonData, jsonDataRetur, jsonDataPendapatan);
				}
			});
		}
	}
	
	function ajaxsimpantukarnota(bukti, jsondata, jsondataretur, jsondatapendapatan){
		var tanggal = $("#tukarnota_tanggal").val();
		var jumlah_potongan = removeCurrency($("#tukarnota_jumlah_potongan").val());
		var jumlah_listing = removeCurrency($("#tukarnota_jumlah_listing").val());
		var jumlah_hutang = removeCurrency($("#tukarnota_jumlah_hutang").val());
		var sisa_hutang = removeCurrency($("#tukarnota_sisa_hutang").val());
		var jatuh_tempo = $("#tukarnota_jatuh_tempo").val();
		var supplier_kode = $("#tukarnota_supplier").val();
		var mode = $("#mode").val();
		
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/tukarnota/simpantukarnota",
			data: "data="+jsondata+"&dataretur="+jsondataretur+"&datapendapatan="+jsondatapendapatan+"&mode="+mode+"&bukti="+bukti+"&tanggal="+tanggal+"&jumlah_potong="+jumlah_potongan+"&jumlah_listing="+jumlah_listing+"&jumlah_hutang="+jumlah_hutang+"&sisa_hutang="+sisa_hutang+"&jatuh_tempo="+jatuh_tempo+"&supplier_kode="+supplier_kode,
			success: function(msg){
				$('#btn-simpan').show();
				$('#loader-form').hide();
				
				ShowMessage("success", "Data berhasil disimpan");
				LoadDataTukarNota();
				$("#form-tukarnota").modal("hide");
				clearForm();
			},
			error: function(xhr,status,error){
				ShowMessage("danger", "Data gagal disimpan");
				$('#btn-simpan').show();
				$('#loader-form').hide();
			}
		});
	}
	
	function HapusTukarNota(){
		var data_obj = $('#dataTables-tukarnota tr.active').attr("data");
		
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			
			if(data['status'] == "0"){
				$('#progres-main').show();
				$.ajax({
					type: "POST",
					url: "<?= base_url(); ?>index.php/tukarnota/hapustukarnota",
					data: "bukti="+data['bukti'],
					success: function(msg){
						ShowMessage("success", "Data berhasil dihapus");
						LoadDataTukarNota();
					}
				});
			}else{
				alert("Tukar nota sudah dilakukan pengajuan pembayaran");
			}
		}
	}
	
	function openFormEditTukarNota(){
		var data_obj = $('#dataTables-tukarnota tr.active').attr("data");
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			
			if(data['status'] == "0"){
				$("#mode").val("e");
				$("#tukarnota_bukti").val(data['bukti']);
				$("#tukarnota_tanggal").val(data['tanggal']);
				$("#tukarnota_jatuh_tempo").val(data['jatuh_tempo']);
				$("#tukarnota_jumlah_potongan").val(data['jumlah_potong']);
				price("tukarnota_jumlah_potongan");
				$("#tukarnota_jumlah_hutang").val(data['jumlah_hutang']);
				price("tukarnota_jumlah_hutang");
				$("#tukarnota_jumlah_listing").val(data['jumlah_listing']);
				price("tukarnota_jumlah_listing");
				$("#tukarnota_sisa_hutang").val(data['sisa_hutang']);
				price("tukarnota_sisa_hutang");
				$("#tukarnota_supplier").select2("val", data['supplier_kode']);
				
				$.ajax({
					type: "POST",
					url: "<?= base_url() ?>index.php/tukarnota/getdatapengadaantukarnota",
					data: "tukar_nota_bukti="+data['bukti'],
					success: function(msg){
						$("#table-dummy-tukarnota tbody").html(msg);
					}
				});
				
				ListReturSupplierEdit(data['bukti']);
				ListPendapatanLainEdit(data['bukti']);
				
				$("#form-tukarnota").modal("show");
			}else{
				alert("Tukar nota sudah dilakukan pengajuan pembayaran");
			}
		}
	}
	
	function openDetailTukarNota(){
		var data_obj = $('#dataTables-tukarnota tr.active').attr("data");
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			
			if(data['status'] == "0"){
				$("#mode").val("e");
				$("#tukarnota_bukti").val(data['bukti']);
				$("#tukarnota_tanggal").val(data['tanggal']);
				$("#tukarnota_jatuh_tempo").val(data['jatuh_tempo']);
				$("#tukarnota_jumlah_potongan").val(data['jumlah_potong']);
				price("tukarnota_jumlah_potongan");
				$("#tukarnota_supplier").select2("val", data['supplier_kode']);
				
				$("#btn-reset").hide();
				$("#btn-simpan").hide();
				
				$.ajax({
					type: "POST",
					url: "<?= base_url() ?>index.php/tukarnota/getdatapengadaantukarnota",
					data: "tukar_nota_bukti="+data['bukti'],
					success: function(msg){
						$("#table-dummy-tukarnota tbody").html(msg);
						$.ajax({
							type: "POST",
							url: "<?= base_url() ?>index.php/retursupplier/getrekapretursupplier",
							data: "tukar_nota_bukti="+data['bukti'],
							success: function(msg){
								$("#table-dummy-retur tbody").html(msg);
								$.ajax({
									type: "POST",
									url: "<?= base_url() ?>index.php/pendapatanlain/getdatapendapatanlainpotongan",
									data: "tukar_nota_bukti="+data['bukti'],
									success: function(msg){
										$("#table-dummy-pendapatan tbody").html(msg);
										HitungJumlah();
									}
								});
							}
						});
					}
				});
				
				$("#form-tukarnota").modal("show");
			}else{
				alert("Tukar nota sudah dilakukan pengajuan pembayaran");
			}
		}
	}
	
	function HitungJumlah(){
		var dataArr = [];
	    $("#table-dummy-tukarnota td").each(function(){
	        dataArr.push($(this).html());
	    });
		var dataArrRetur = [];
	    $("#table-dummy-retur td").each(function(){
	        dataArrRetur.push($(this).html());
	    });
		var dataArrPendapatan = [];
	    $("#table-dummy-pendapatan td").each(function(){
	        dataArrPendapatan.push($(this).html());
	    });
		
		var jumlah = 0;
		for(i=4;i<dataArr.length;i=i+8){
			jumlah += parseFloat(removeCurrencyNormal(dataArr[i]));
		}
		var jumlahretur = 0;
		for(i=2;i<dataArrRetur.length;i=i+4){
			jumlahretur += parseFloat(removeCurrencyNormal(dataArrRetur[i]));
		}
		var jumlahpendapatan = 0;
		for(i=3;i<dataArrPendapatan.length;i=i+5){
			jumlahpendapatan += parseFloat(removeCurrencyNormal(dataArrPendapatan[i]));
		}
		
		var jumlah_potongan = parseFloat(jumlahretur);
		var jumlah_listing = parseFloat(jumlahpendapatan);
		$("#tukarnota_jumlah_potongan").val(jumlah_potongan);
		price_js("tukarnota_jumlah_potongan");
		$("#tukarnota_jumlah_listing").val(jumlah_listing);
		price_js("tukarnota_jumlah_listing");
		var sisa_hutang = jumlah - (jumlah_potongan+jumlah_listing);
		$("#tukarnota_jumlah_hutang").val(jumlah);
		price_js("tukarnota_jumlah_hutang");
		$("#tukarnota_sisa_hutang").val(sisa_hutang);
		price_js("tukarnota_sisa_hutang");
		
		alert(jumlah);
	}
	
	function ListPengadaanSupplier(){
		var supplier_kode = $("#tukarnota_supplier").val();
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/tukarnota/getdatapengadaansupplier",
			data: "supplier_kode="+supplier_kode,
			success: function(msg){
				$("#table-dummy-tukarnota tbody").html(msg);
				ListReturSupplier();
			}
		});
	}
	
	function getJatuhTempo(){
		var supplier_kode = $("#tukarnota_supplier").val();
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/tukarnota/getjatuhtempo",
			data: "supplier_kode="+supplier_kode,
			success: function(msg){
				$("#tukarnota_jatuh_tempo").val(msg);
			}
		});
	}
	
	function ListReturSupplier(){
		var supplier_kode = $("#tukarnota_supplier").val();
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/retursupplier/getrekapretursupplier",
			data: "supplier_kode="+supplier_kode,
			success: function(msg){
				$("#table-dummy-retur tbody").html(msg);
				ListPendapatanLain();
			}
		});
	}
	
	function ListReturSupplierEdit(tukar_nota_bukti){
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/retursupplier/getrekapretursupplier",
			data: "tukar_nota_bukti="+tukar_nota_bukti,
			success: function(msg){
				$("#table-dummy-retur tbody").html(msg);
			}
		});
	}
	
	function ListPendapatanLain(){
		var supplier_kode = $("#tukarnota_supplier").val();
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/pendapatanlain/getdatapendapatanlainpotongan",
			data: "supplier_kode="+supplier_kode,
			success: function(msg){
				$("#table-dummy-pendapatan tbody").html(msg);
				HitungJumlah();
			}
		});
	}
	
	function ListPendapatanLainEdit(tukar_nota_bukti){
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/pendapatanlain/getdatapendapatanlainpotongan",
			data: "tukar_nota_bukti="+tukar_nota_bukti,
			success: function(msg){
				$("#table-dummy-pendapatan tbody").html(msg);
			}
		});
	}
	
	function CetakTukarNota(){
		var data_obj = $('#dataTables-tukarnota tr.active').attr("data");
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			window.open('<?= base_url('index.php/tukarnota/cetaktukarnota?') ?>bukti='+data['bukti'],'_blank');
		}
	}
	
	function OpenFormNoFaktur(pengadaan_bukti){
		$("#tukarnota_pengadaan_bukti").val(pengadaan_bukti);
		$("#form-nofaktur").modal("show");
	}
	
	function openFormEditTotalRetur(){
		//$("#form-edit-total-retur").modal("show");
		//$("#edit_total_retur").val($("#tukarnota_jumlah_potongan").val());
	}
	
	function openFormEditTotalListing(){
		//$("#form-edit-total-listing").modal("show");
		//$("#edit_total_listing").val($("#tukarnota_jumlah_listing").val());
	}
	
	function SimpanEditTotalRetur(){
		var total_retur = $("#edit_total_retur").val();
		
		$("#tukarnota_jumlah_potongan").val(total_retur);
		
		var JumlahHutang = removeCurrency($("#tukarnota_jumlah_hutang").val());
		var JumlahListing = removeCurrency($("#tukarnota_jumlah_listing").val())
		var sisaHutang = parseFloat(JumlahHutang) - (parseFloat(removeCurrency(total_retur)) + parseFloat(JumlahListing));
		$("#tukarnota_sisa_hutang").val(number_format(sisaHutang,2,',','.'));
		
		$("#form-edit-total-retur").modal("hide");
	}
	
	function SimpanEditTotalListing(){
		var total_listing = $("#edit_total_listing").val();
		
		$("#tukarnota_jumlah_listing").val(total_listing);
		
		var JumlahHutang = removeCurrency($("#tukarnota_jumlah_hutang").val());
		var JumlahPotongan = removeCurrency($("#tukarnota_jumlah_potongan").val());
		var sisaHutang = parseFloat(JumlahHutang) - (parseFloat(removeCurrency(total_listing)) + parseFloat(JumlahPotongan));
		$("#tukarnota_sisa_hutang").val(number_format(sisaHutang,2,',','.'));
		
		$("#form-edit-total-listing").modal("hide");
	}
	
	function SimpanNoFakturPajak(){
		var pengadaan_bukti = $("#tukarnota_pengadaan_bukti").val();
		var no_faktur = $("#tukarnota_nofaktur").val();
		$("#nofaktur_"+pengadaan_bukti).html(no_faktur);
		$("#tukarnota_nofaktur").val("");
		$("#form-nofaktur").modal("hide");
	}
</script>