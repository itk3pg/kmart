<style>
	.datepicker{z-index:1151 !important;}
</style>
<div id="page-wrapper">
	<div class="row">
	    <div class="col-lg-12">
	        <h1 style="margin-top: 15px;" class="page-header">Pengajuan Pembayaran (PB)</h1>
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
						<button id="btn_upload" onclick="LoadDataPermintaanPembayaran()" class="btn btn-info" type="button">
							<i class="fa fa-search"></i>
							&nbsp;&nbsp;Search
						</button>
					</td>
					<td>&nbsp;&nbsp;</td>
					<td valign="top">
						<button id="btn_upload" onclick="CetakDataPermintaanPembayaran()" class="btn btn-success" type="button">
							<i class="fa fa-print"></i>
							&nbsp;&nbsp;Cetak
						</button>
					</td>
					<td>&nbsp;&nbsp;</td>
					<td valign="top">
						<button id="btn_upload" onclick="CetakRekapPermintaanPembayaran()" class="btn btn-warning" type="button">
							<i class="fa fa-print"></i>
							&nbsp;&nbsp;Cetak Faktur Pajak 
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
					<?php if($this->session->userdata('group_kode') == "GRU0000" || $this->session->userdata('group_kode') == "GRU0008" || $this->session->userdata('username') == "402" || $this->session->userdata('username') == "403"){ ?>
					<button id="btn_tambah" onclick="openFormPermintaanPembayaran()" class="btn btn-info btn-sm" type="button">
						<i class="fa fa-plus"></i>
						&nbsp;&nbsp;Tambah
					</button>
					<!--<button id="btn_uedit" onclick="openFormEditPermintaanPembayaran()" class="btn btn-success btn-sm" type="button">
						<i class="fa fa-edit"></i>
						&nbsp;&nbsp;Edit
					</button>-->
					<button id="btn_hapus" fungsi="HapusPermintaanPembayaran()" class="btn btn-danger btn-sm ask-permintaanpembayaran" type="button">
						<i class="fa fa-times"></i>
						&nbsp;&nbsp;Hapus
					</button>
					<button id="btn_tambah" onclick="CetakPermintaanPembayaran();" class="btn btn-warning btn-sm" type="button">
						<i class="fa fa-print"></i>
						&nbsp;&nbsp;Cetak Pengajuan
					</button>
					<?php } ?>
					<?php if($this->session->userdata('group_kode') == "GRU0000" || $this->session->userdata('group_kode') == "GRU0010"){ ?>
					<button id="btn_tambah" onclick="SetStatus('1')" class="btn btn-success btn-sm" type="button">
						<i class="fa fa-check"></i>
						&nbsp;&nbsp;Terima Dok Akunt
					</button>
					<button id="btn_tambah" onclick="SetStatus('2')" class="btn btn-success btn-sm" type="button">
						<i class="fa fa-check"></i>
						&nbsp;&nbsp;Set Verifikasi
					</button>
					<button id="btn_tambah" onclick="SetStatus('3');" class="btn btn-success btn-sm" type="button">
						<i class="fa fa-check"></i>
						&nbsp;&nbsp;Set PPU
					</button>
					<button id="btn_tambah" onclick="CetakPPU();" class="btn btn-warning btn-sm" type="button">
						<i class="fa fa-print"></i>
						&nbsp;&nbsp;Cetak PPU
					</button>
					<?php } ?>
					<?php if($this->session->userdata('group_kode') == "GRU0000" || $this->session->userdata('group_kode') == "GRU0011"){ ?>
					<button id="btn_tambah" onclick="OpenFormRealisasi()" class="btn btn-success btn-sm" type="button">
						<i class="fa fa-check"></i>
						&nbsp;&nbsp;Set Realisasi
					</button>
					<button id="btn_tambah" onclick="CetakRealisasi();" class="btn btn-warning btn-sm" type="button">
						<i class="fa fa-print"></i>
						&nbsp;&nbsp;Cetak Realisasi
					</button>
					<button id="btn_tambah" onclick="CetakRekapHarian();" class="btn btn-warning btn-sm" type="button">
						<i class="fa fa-print"></i>
						&nbsp;&nbsp;Rekap Pembayaran
					</button>
					<?php } ?>
					<!--<button id="btn_hapus" onclick="CetakPermintaanPembayaran()" class="btn btn-warning btn-sm" type="button">
						<i class="fa fa-print"></i>
						&nbsp;&nbsp;Cetak
					</button>-->
					<button id="btn_status" onclick="DetailStatus();" class="btn btn-info btn-sm" type="button">
						<i class="fa fa-table"></i>
						&nbsp;&nbsp;Detail Status
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
					<div class="table-responsive table-permintaanpembayaran">
						
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Popup form untuk tukar nota -->
	<div class="modal fade" id="form-permintaanpembayaran" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        			<h4 class="modal-title" id="myModalLabel">Form Permintaan Pembayaran (PB)</h4>
				</div>
				<div class="modal-body">
					<table style="width: 69%;">
						<tr>
							<td style="width: 200px;">Tanggal :</td>
							<td>&nbsp;&nbsp;
								<input type="hidden" name="mode" id="mode" value="i"/>
								<input type="hidden" name="permintaanpembayaran_bukti" id="permintaanpembayaran_bukti"/>
							</td>
							<td>Bukti Tukar Nota :</td>
						</tr>
						<tr>
							<td>
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</span>
									<input type="text" value="<?= date("Y-m-d"); ?>" placeholder="Tanggal Tukar Nota" name="permintaanpembayaran_tanggal" id="permintaanpembayaran_tanggal" class="form-control">
								</div>
							</td>
							<td>&nbsp;&nbsp;</td>
							<td>
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<select class="form-control" onchange="GetDataTukarNota();" name="permintaanpembayaran_tukarnota" id="permintaanpembayaran_tukarnota">
										<option value="-1">Pilih Bukti</option>
									</select>
								</div>
							</td>
						</tr>
					</table>
					<table style="width: 100%" id="table-dummy-permintaanpembayaran" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th class="text-center">Bukti TT</th>
								<th class="text-center">Tanggal</th>
								<th class="text-center">Supplier</th>
								<th class="text-center">Hutang</th>
								<th class="text-center">Potongan</th>
								<th class="text-center">Listing</th>
								<th class="text-center">Jumlah</th>
								<th class="text-center">Hapus</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" onclick="clearForm()" class="btn btn-default">Reset</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<img src="<?= base_url() ?>/images/loader.gif" id="loader-form"  style="width: 30px; display: none;" />
			        <button type="button" id="btn-simpan" onclick="SimpanPermintaanPembayaran()" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;&nbsp;Simpan</button>
				</div>
			</div>
		</div>
	</div>
	
	<!-- Popup form untuk realisasi -->
	<div class="modal fade" id="form-realisasi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        			<h4 class="modal-title" id="myModalLabel">Form Realisasi Permintaan Pembayaran (PB)</h4>
				</div>
				<div class="modal-body">
					Tanggal Transfer :
					<div class="form-group input-group">
						<span class="input-group-addon">
							<i class="fa fa-calendar"></i>
						</span>
						<input type="text" value="<?= date('Y-m-d'); ?>" name="realisasi_tanggal" id="realisasi_tanggal" class="form-control">
					</div>
					Melalui :
					<div class="form-group input-group">
						<span class="input-group-addon">
							<i class="fa fa-file"></i>
						</span>
						<select name="realisasi_melalui" id="realisasi_melalui" class="form-control">
							<option value="TRANSFER">TRANSFER</option>
							<option value="CEK">CEK</option>
							<option value="TUNAI">TUNAI</option>
						</select>
					</div>
					Nomor Cek :
					<div class="form-group input-group">
						<span class="input-group-addon">
							<i class="fa fa-file"></i>
						</span>
						<input name="realisasi_no_cek" id="realisasi_no_cek" class="form-control" />
					</div>
					Nama Bank :
					<div class="form-group input-group">
						<span class="input-group-addon">
							<i class="fa fa-file"></i>
						</span>
						<select name="realisasi_namabank" id="realisasi_namabank" class="form-control">
							<option value="KB PUSAT">KB PUSAT</option>
							<option value="REK. BRI ADM">REK. BRI ADM</option>
							<option value="REK. BNI PUSAT">REK. BNI PUSAT</option>
							<option value="REK. NIAGA PUSAT">REK. NIAGA PUSAT</option>
							<option value="REK. MANDIRI">REK. MANDIRI</option>
							<option value="REK. BPD JATIM PUSAT">REK. BPD JATIM PUSAT</option>
							<option value="REK. LIPPO PUSAT">REK. LIPPO PUSAT</option>
							<option value="REK. BCA PUSAT">REK. BCA PUSAT</option>
							<option value="REK. DANAMON PUSAT">REK. DANAMON PUSAT</option>
							<option value="REK. MUAMALAT PUSAT">REK. MUAMALAT PUSAT</option>
							<option value="REK. BII PUSAT">REK. BII PUSAT</option>
							<option value="REK. SYARIAH MANDIRI">REK. SYARIAH MANDIRI</option>
							<option value="REK. DANAMON SYARIAH">REK. DANAMON SYARIAH</option>
						</select>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" onclick="clearForm()" class="btn btn-default">Reset</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<img src="<?= base_url() ?>/images/loader.gif" id="loader-form"  style="width: 30px; display: none;" />
			        <button type="button" id="btn-simpan" onclick="SimpanRealisasi()" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;&nbsp;Simpan</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Popup form untuk detail status -->
	<div class="modal fade" id="form-detailstatus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        			<h4 class="modal-title" id="myModalLabel">Detail Status</h4>
				</div>
				<div class="modal-body">
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<img src="<?= base_url() ?>/images/loader.gif" id="loader-detailstatus"  style="width: 30px; display: none;" />
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		OpenMenu();
		LoadDataPermintaanPembayaran();
		loadListTT();
		
		$('.ask-permintaanpembayaran').jConfirmAction();
		
		$('#permintaanpembayaran_tanggal').datepicker({
			format: 'yyyy-mm-dd'
		});
		$('#search_tanggal_awal').datepicker({
			format: 'yyyy-mm-dd'
		});
		$('#search_tanggal_akhir').datepicker({
			format: 'yyyy-mm-dd'
		});
		$('#realisasi_tanggal').datepicker({
			format: 'yyyy-mm-dd'
		});
		
		$('.datepicker tbody').on('click', function(){  $('.datepicker').hide() });
	});
	
	function loadListTT(){
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/tukarnota/getselecttukarnota",
			data: "",
			success: function(msg){
				$("#permintaanpembayaran_tukarnota").html(msg);
				$("#permintaanpembayaran_tukarnota").select2();
			}
		});
	}
	
	function LoadDataPermintaanPembayaran(){
		$('#progres-main').show();
		
		var tanggal_awal = $("#search_tanggal_awal").val();
		var tanggal_akhir = $("#search_tanggal_akhir").val();
		var search_value = $('#dataTables-permintaanpembayaran_filter input').val();
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/permintaanpembayaran/getdatapermintaanpembayaran",
			data: "tanggal_awal="+tanggal_awal+"&tanggal_akhir="+tanggal_akhir,
			success: function(msg){
				$(".table-permintaanpembayaran").html(msg);
				$('#dataTables-permintaanpembayaran').dataTable();
				$('#progres-main').hide();
				
				$('#dataTables-permintaanpembayaran tbody').on( 'click', 'tr', function () {
			        if ( $(this).hasClass('active') ) {
			            $(this).removeClass('active');
			        }else {
			            $('#dataTables-permintaanpembayaran tr.active').removeClass('active');
			            $(this).addClass('active');
			        }
			    } );

			    $('#dataTables-permintaanpembayaran_filter input').val(search_value);
			    $('#dataTables-permintaanpembayaran_filter input').keyup();
			}
		});
	}
	
	function openFormPermintaanPembayaran(){
		$("#form-permintaanpembayaran").modal("show");
		$("#mode").val("i");
		$("#permintaanpembayaran_bukti").val("");
	}
	
	function HapusRow(DataObj){
		dataobj = DataObj;
		dataobj = DataObj;
		$(DataObj).parent().parent().remove();
	}
	
	function GetDataTukarNota(){
		var tukar_nota_kode = $("#permintaanpembayaran_tukarnota").select2('val');
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/permintaanpembayaran/getdatatukarnota",
			data: "tukar_nota_kode="+tukar_nota_kode,
			success: function(msg){
				$('#table-dummy-permintaanpembayaran > tbody').html(msg);
				//$('#table-dummy-permintaanpembayaran > tbody:last').append(msg);
			}
		});
	}
	
	function clearForm(){
		$('#table-dummy-permintaanpembayaran tbody').html("");
		$("#permintaanpembayaran_barang").select2("val", "");
		$("#permintaanpembayaran_kwt").val("");
		$("#permintaanpembayaran_supplier").select2("val", "-1");
		$("#bukti_od").val("");
	}
	
	function SimpanPermintaanPembayaran(){
		$('#btn-simpan').hide();
		$('#loader-form').show();
		
		var dataArr = [];
	    $("#table-dummy-permintaanpembayaran td").each(function(){
	        dataArr.push($(this).html());
	    });
	    var mode = $("#mode").val();
		var bukti = $("#permintaanpembayaran_bukti").val();
		
		if(mode == "i"){
			var modeBukti = "PB";
			var tanggal_permintaanpembayaran = $("#permintaanpembayaran_tanggal").val();
			$.ajax({
				type: "POST",
				url: "<?= base_url() ?>index.php/bukti/generatebukti",
				data: "mode="+modeBukti+"&tanggal="+tanggal_permintaanpembayaran,
				success: function(msg){
					var jsonData = rawurlencode(json_encode(dataArr));
					ajaxsimpanpermintaanpembayaran(msg, jsonData);
				}
			});
		}else{
			$.ajax({
				type: "POST",
				url: "<?= base_url(); ?>index.php/permintaanpembayaran/hapuspermintaanpembayaran",
				data: "bukti="+bukti,
				success: function(msg){
					var jsonData = rawurlencode(json_encode(dataArr));
					ajaxsimpanpermintaanpembayaran(bukti, jsonData);
				}
			});
		}
	}
	
	function ajaxsimpanpermintaanpembayaran(bukti, jsondata){
		var tanggal = $("#permintaanpembayaran_tanggal").val();
		var mode = $("#mode").val();
		
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/permintaanpembayaran/simpanpermintaanpembayaran",
			data: "data="+jsondata+"&mode="+mode+"&bukti="+bukti+"&tanggal="+tanggal,
			success: function(msg){
				$('#btn-simpan').show();
				$('#loader-form').hide();
				
				ShowMessage("success", "Data berhasil disimpan");
				LoadDataPermintaanPembayaran();
				$("#form-permintaanpembayaran").modal("hide");
				clearForm();
			},
			error: function(xhr,status,error){
				ShowMessage("danger", "Data gagal disimpan");
				$('#btn-simpan').show();
				$('#loader-form').hide();
			}
		});
	}
	
	function HapusPermintaanPembayaran(){
		var data_obj = $('#dataTables-permintaanpembayaran tr.active').attr("data");
		
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			
			if(data['status'] == "0"){
				$('#progres-main').show();
				$.ajax({
					type: "POST",
					url: "<?= base_url(); ?>index.php/permintaanpembayaran/hapuspermintaanpembayaran",
					data: "bukti="+data['bukti']+"&tukar_nota_bukti="+data['tukar_nota_bukti'],
					success: function(msg){
						ShowMessage("success", "Data berhasil dihapus");
						LoadDataPermintaanPembayaran();
					}
				});
			}else{
				alert("Permintaan pembayaran sedang diproses");
			}
		}
	}

	function DetailStatus(){
		var data_obj = $('#dataTables-permintaanpembayaran tr.active').attr("data");
		
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			
			$.ajax({
				type: "POST",
				url: "<?= base_url(); ?>index.php/permintaanpembayaran/getdetailpermintaanpembayaran",
				data: "bukti="+data['bukti'],
				success: function(msg){
					$("#form-detailstatus .modal-body").html(msg);
					$("#form-detailstatus").modal("show");
				}
			});
		}
	}
	
	function openFormEditPermintaanPembayaran(){
		var data_obj = $('#dataTables-permintaanpembayaran tr.active').attr("data");
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			
			if(data['status'] == "0"){
				$("#mode").val("e");
				$("#permintaanpembayaran_tanggal").val(data['tanggal']);
				
				$.ajax({
					type: "POST",
					url: "<?= base_url() ?>index.php/permintaanpembayaran/getdatapermintaanpembayaran",
					data: "bukti="+data['bukti'],
					success: function(msg){
						$("#table-dummy-permintaanpembayaran tbody").html(msg);
					}
				});
				
				$("#form-permintaanpembayaran").modal("show");
			}else{
				alert("Permintaan pembayaran sedang diproses");
			}
		}
	}
	
	function CetakPermintaanPembayaran(){
		var data_obj = $('#dataTables-permintaanpembayaran tr.active').attr("data");
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			//var data = json_decode(base64_decode(data_obj));
			window.open('<?= base_url('index.php/permintaanpembayaran/cetakpermintaanpembayaran?') ?>data='+data_obj,'_blank');
		}
	}
	
	function SetStatus(status){
		var data_obj = $('#dataTables-permintaanpembayaran tr.active').attr("data");
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			var addStatus = parseFloat(data['status']) + 1;
			//alert(addStatus+" | "+data['status']+" | "+status);
			if(addStatus == status){
				$.ajax({
					type: "POST",
					url: "<?= base_url() ?>index.php/permintaanpembayaran/setstatus",
					data: "bukti="+data['bukti']+"&status="+status,
					success: function(msg){
						LoadDataPermintaanPembayaran();
						// $('#dataTables-permintaanpembayaran').DataTable().ajax.reload();
						if(status == "3"){
							window.open('<?= base_url('index.php/permintaanpembayaran/cetakppu?') ?>data='+data_obj,'_blank');
						}
					}
				});
			}else if(status <= data['status']){
				switch(status){
					case '1' :
						alert('Permintaan pembayaran sudah diterima akuntansi');
						break;
					case '2' :
						alert('Permintaan pembayaran sudah diverifikasi');
						break;
					case '3' :
						alert('Permintaan pembayaran sudah diajukan PPU');
						break;
					case '4' :
						alert('Permintaan pembayaran sudah direalisasi');
						break;
				}
			}else{
				switch(addStatus){
					case 1 :
						alert('Permintaan pembayaran belum diterima akuntansi');
						break;
					case 2 :
						alert('Permintaan pembayaran belum diverifikasi');
						break;
					case 3 :
						alert('Permintaan pembayaran belum diajukan PPU');
						break;
				}
			}
		}
	}
	
	function CetakPPU(){
		var data_obj = $('#dataTables-permintaanpembayaran tr.active').attr("data");
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			if(data['status'] == "3"){
				window.open('<?= base_url('index.php/permintaanpembayaran/cetakppu?') ?>data='+data_obj,'_blank');
			}else{
				alert('Permintaan pembayaran belum diverifikasi / belum set PPU');
			}
		}
	}
	
	function OpenFormRealisasi(){
		var data_obj = $('#dataTables-permintaanpembayaran tr.active').attr("data");
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			/*if(data['status'] == "3"){
				alert('Permintaan pembayaran sudah direalisasi');
			}else */
			if(data['status'] == "3" || data['status'] == "4"){
				$("#form-realisasi").modal("show");
				$("#realisasi_melalui").val("TRANSFER");
				$("#realisasi_no_cek").val("");
				$("#realisasi_namabank").val("KB PUSAT");
			}else{
				alert('Permintaan pembayaran belum dibuat ppu');
			}
		}
	}
	
	function SimpanRealisasi(){
		var data_obj = $('#dataTables-permintaanpembayaran tr.active').attr("data");
		var data = json_decode(base64_decode(data_obj));
		var tanggal_transfer = $("#realisasi_tanggal").val();
		var melalui = $("#realisasi_melalui").val();
		var nomor_cek = $("#realisasi_no_cek").val();
		var bank = $("#realisasi_namabank").val();
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/permintaanpembayaran/simpanrealisasi",
			data: "bukti="+data['bukti']+"&tanggal_transfer="+tanggal_transfer+"&melalui="+melalui+"&nomor_cek="+nomor_cek+"&bank="+bank+"&tukar_nota_bukti="+data['tukar_nota_bukti'],
			success: function(msg){
				LoadDataPermintaanPembayaran();
				$("#form-realisasi").modal("hide");
			}
		});
	}
	
	function CetakRealisasi(){
		var data_obj = $('#dataTables-permintaanpembayaran tr.active').attr("data");
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			//var data = json_decode(base64_decode(data_obj));
			window.open('<?= base_url('index.php/permintaanpembayaran/cetakrealisasi?') ?>data='+data_obj,'_blank');
		}
	}
	
	function CetakRekapHarian(){
		var tanggal_awal = $("#search_tanggal_awal").val();
		var tanggal_akhir = $("#search_tanggal_akhir").val();
		window.open('<?= base_url('index.php/permintaanpembayaran/getrekapharian?') ?>tanggal_awal='+tanggal_awal+'&tanggal_akhir='+tanggal_akhir,'_blank');
	}
	
	function CetakRekapPermintaanPembayaran(){
		var tanggal_awal = $("#search_tanggal_awal").val();
		var tanggal_akhir = $("#search_tanggal_akhir").val();
		window.open('<?= base_url('index.php/permintaanpembayaran/getrekappermintaanpembayaran?') ?>tanggal_awal='+tanggal_awal+'&tanggal_akhir='+tanggal_akhir,'_blank');
	}

	function CetakDataPermintaanPembayaran(){
		var tanggal_awal = $("#search_tanggal_awal").val();
		var tanggal_akhir = $("#search_tanggal_akhir").val();
		window.open('<?= base_url('index.php/permintaanpembayaran/cetakdatapermintaanpembayaran?') ?>tanggal_awal='+tanggal_awal+'&tanggal_akhir='+tanggal_akhir,'_blank');
	}
</script>