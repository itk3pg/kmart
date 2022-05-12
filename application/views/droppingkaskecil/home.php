<style>
	.datepicker{z-index:1151 !important;}
</style>
<div id="page-wrapper">
	<div class="row">
	    <div class="col-lg-12">
	        <h1 style="margin-top: 15px;" class="page-header">Dropping Kas Kecil</h1>
	    </div>
	    <!-- /.col-lg-12 -->
	</div>
	<div class="row" style="margin-bottom: 10px;">
		<div class="col-lg-12">
			<table style="float: right;">
				<tr>
					<td style="width: 200px;">
						Toko/Unit
						<div class="form-group input-group">
							<span class="input-group-addon">
								<i class="fa fa-user"></i>
							</span>
							<select style="width: 150px;" class="form-control" name="search_unit_kode" id="search_unit_kode">
								<option value="VO0001">TOKO 1</option>
								<option value="VO0002">TOKO 2</option>
								<option value="VO0008">MD</option>
							</select>
						</div>
					</td>
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
						<button id="btn_upload" onclick="LoadDataDroppingKasKecil()" class="btn btn-info" type="button">
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
					<?php if($this->session->userdata('group_kode') == "GRU0000" || $this->session->userdata('group_kode') == "GRU0008" || $this->session->userdata('group_kode') == "GRU0012"){ ?>
					<button id="btn_tambah" onclick="openFormDroppingKasKecil()" class="btn btn-info btn-sm" type="button">
						<i class="fa fa-plus"></i>
						&nbsp;&nbsp;Tambah
					</button>
					<button id="btn_hapus" fungsi="HapusDroppingKasKecil()" class="btn btn-danger btn-sm ask-droppingkaskecil" type="button">
						<i class="fa fa-times"></i>
						&nbsp;&nbsp;Hapus
					</button>
					<button id="btn_tambah" onclick="CetakDroppingKasKecil();" class="btn btn-warning btn-sm" type="button">
						<i class="fa fa-print"></i>
						&nbsp;&nbsp;Cetak Pengajuan
					</button>
					<?php } ?>
					<button id="btn_tambah" onclick="CetakRincianKasbank();" class="btn btn-warning btn-sm" type="button">
						<i class="fa fa-print"></i>
						&nbsp;&nbsp;Cetak Rincian Kasbank
					</button>
					<?php if($this->session->userdata('group_kode') == "GRU0000" || $this->session->userdata('group_kode') == "GRU0006" || $this->session->userdata('group_kode') == "GRU0007"){ ?>
					<button id="btn_tambah" onclick="setappdok()" class="btn btn-success btn-sm" type="button">
						<i class="fa fa-check"></i>
						&nbsp;&nbsp;Set Terima Dok.
					</button>
					<?php } ?>
					<?php if($this->session->userdata('group_kode') == "GRU0000" || $this->session->userdata('group_kode') == "GRU0010"){ ?>
					<button id="btn_tambah" onclick="setverifikasidok()" class="btn btn-success btn-sm" type="button">
						<i class="fa fa-check"></i>
						&nbsp;&nbsp;Set Verifikasi
					</button>
					<button id="btn_tambah" onclick="SetPPU();" class="btn btn-success btn-sm" type="button">
						<i class="fa fa-check"></i>
						&nbsp;&nbsp;Set PPU
					</button>
					<button id="btn_tambah" onclick="CetakPPU();" class="btn btn-warning btn-sm" type="button">
						<i class="fa fa-print"></i>
						&nbsp;&nbsp;Cetak PPU
					</button>
					<?php } ?>
					<?php if($this->session->userdata('group_kode') == "GRU0000" || $this->session->userdata('group_kode') == "GRU0011"){ ?>
					<button id="btn_tambah" onclick="SetRealisasi()" class="btn btn-success btn-sm" type="button">
						<i class="fa fa-check"></i>
						&nbsp;&nbsp;Set Realisasi
					</button>
					<?php } ?>
					<!--<button id="btn_tambah" onclick="CetakRealisasi();" class="btn btn-warning btn-sm" type="button">
						<i class="fa fa-print"></i>
						&nbsp;&nbsp;Cetak Realisasi
					</button>-->
					<!--<button id="btn_hapus" onclick="CetakDroppingKasKecil()" class="btn btn-warning btn-sm" type="button">
						<i class="fa fa-print"></i>
						&nbsp;&nbsp;Cetak
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
					<div class="table-responsive table-droppingkaskecil">
						
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Popup form untuk tukar nota -->
	<div class="modal fade" id="form-droppingkaskecil" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        			<h4 class="modal-title" id="myModalLabel">Form Pengajuan Dropping</h4>
				</div>
				<div class="modal-body">
					<table>
						<tr>
							<td>Waktu Pengajuan</td>
							<td> : </td>
							<td>
								<input class="form-control" type="text" name="ins_tgl_pengajuan" value="<?php echo date('Y-m-d') ?>" id="ins_tgl_pengajuan" disabled="disabled" />
								<input type="hidden" name="ins_bukti_kasbank" id="ins_bukti_kasbank" />
							</td>
						</tr>
						<tr>
							<td>Tahap Pengajuan</td>
							<td> : </td>
							<td><input class="form-control" type="text" name="ins_tahap_pengajuan" id="ins_tahap_pengajuan" disabled="disabled" /></td>
						</tr>
						<tr>
							<td>Saldo Bank Dropping</td>
							<td> : </td>
							<td><input class="form-control" type="text" style="text-align: right;" name="ins_saldo_bankdropping" id="ins_saldo_bankdropping" disabled="disabled" /></td>
						</tr>
						<tr>
							<td>Saldo Kas Kecil</td>
							<td> : </td>
							<td><input class="form-control" type="text" style="text-align: right;" name="ins_saldo_kkecil" id="ins_saldo_kkecil" disabled="disabled" /></td>
						</tr>
						<tr>
							<td>Total Kas Kecil</td>
							<td> : </td>
							<td><input class="form-control" type="text" style="text-align: right;" name="ins_total_kkecil" id="ins_total_kkecil" disabled="disabled" /></td>
						</tr>
						<tr>
							<td>Plafon Maks. Kas Kecil</td>
							<td> : </td>
							<td><input class="form-control" type="text" style="text-align: right;" name="ins_plafon_kkecil" id="ins_plafon_kkecil" disabled="disabled" /></td>
						</tr>
						<tr>
							<td>Jumlah Pengajuan</td>
							<td> : </td>
							<td><input class="form-control" type="text" disabled="disabled" style="text-align: right;" name="ins_jumlah_pengajuan" id="ins_jumlah_pengajuan" /></td>
						</tr>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" onclick="clearForm()" class="btn btn-default">Reset</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<img src="<?= base_url() ?>/images/loader.gif" id="loader-form"  style="width: 30px; display: none;" />
			        <button type="button" id="btn-simpan" onclick="simpanpengajuan()" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;&nbsp;Simpan</button>
				</div>
			</div>
		</div>
	</div>
	
	<!-- Popup form untuk verifikasi -->
	<div class="modal fade" id="form-verifikasi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        			<h4 class="modal-title" id="myModalLabel">Form Verifikasi</h4>
				</div>
				<div class="modal-body">
					Keterangan :
					<div class="form-group input-group">
						<span class="input-group-addon">
							<i class="fa fa-file"></i>
						</span>
						<textarea class="form-control" name="keterangan" id="keterangan"></textarea>
					</div>
					<ul id="table_keterangan">
				
					</ul>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<img src="<?= base_url() ?>/images/loader.gif" id="loader-form"  style="width: 30px; display: none;" />
			        <button type="button" id="btn-simpan" onclick="tambahketerangan()" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;&nbsp;Simpan</button>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		OpenMenu();
		LoadDataDroppingKasKecil();
		
		$('.ask-droppingkaskecil').jConfirmAction();
		
		$('#search_tanggal_awal').datepicker({
			format: 'yyyy-mm-dd'
		});
		$('#search_tanggal_akhir').datepicker({
			format: 'yyyy-mm-dd'
		});
		
		$('.datepicker tbody').on('click', function(){  $('.datepicker').hide() });
	});
	
	function LoadDataDroppingKasKecil(){
		$('#progres-main').show();
		
		var tanggal_awal = $("#search_tanggal_awal").val();
		var tanggal_akhir = $("#search_tanggal_akhir").val();
		var unit_kode = $("#search_unit_kode").val();
		
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/droppingkaskecil/getdatadroppingkaskecil",
			data: "tanggal_awal="+tanggal_awal+"&tanggal_akhir="+tanggal_akhir+"&unit_kode="+unit_kode,
			success: function(msg){
				$(".table-droppingkaskecil").html(msg);
				$('#dataTables-droppingkaskecil').dataTable();
				$('#progres-main').hide();
				
				$('#dataTables-droppingkaskecil tbody').on( 'click', 'tr', function () {
			        if ( $(this).hasClass('active') ) {
			            $(this).removeClass('active');
			        }else {
			            $('#dataTables-droppingkaskecil tr.active').removeClass('active');
			            $(this).addClass('active');
			        }
			    } );
			}
		});
	}
	
	function openFormDroppingKasKecil(){
		$("#form-droppingkaskecil").modal("show");
		$("#mode").val("i");
		$("#droppingkaskecil_bukti").val("");
		
		getTahap();
	}
	
	function HapusRow(DataObj){
		dataobj = DataObj;
		dataobj = DataObj;
		$(DataObj).parent().parent().remove();
	}
	
	function clearForm(){
		$('#table-dummy-droppingkaskecil tbody').html("");
		$("#droppingkaskecil_barang").select2("val", "");
		$("#droppingkaskecil_kwt").val("");
		$("#droppingkaskecil_supplier").select2("val", "-1");
		$("#bukti_od").val("");
	}
	
	function getSaldoKK(){
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/droppingkaskecil/getsaldokk",
			data: "tanggal="+$('#ins_tgl_pengajuan').val()+"&unit_kode="+$("#search_unit_kode").val(),
			success: function(msg){
				$('#ins_saldo_kkecil').val(Math.round(msg));
				//alert("sakk "+msg)
				// price('ins_saldo_kkecil');
				
				//getLastTransaksi();
				getSaldoBankDropping();
			}
		});
	}
	
	function getSaldoBankDropping(){
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/droppingkaskecil/getsaldobankdropping",
			data: "tanggal="+$('#ins_tgl_pengajuan').val()+"&unit_kode="+$("#search_unit_kode").val(),
			success: function(msg){
				//alert(msg)
				$('#ins_saldo_bankdropping').val(Math.round(msg));
				// price('ins_saldo_bankdropping');
				
				var saldokk = parseInt($('#ins_saldo_kkecil').val().replace(/\./g,''));
				var saldobank = parseInt($('#ins_saldo_bankdropping').val().replace(/\./g,''));
				var jumlahkaskecil = saldokk + saldobank;
				$('#ins_total_kkecil').val(jumlahkaskecil);
				getPlafon();
			}
		});
	}
	
	/*function getLastTransaksi(){
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/droppingkaskecil/getlasttransaksi",
			data: "tanggal="+$('#ins_tgl_pengajuan').val(),
			success: function(msg){
				//alert(msg)
				$('#ins_bukti_kasbank').val(msg);
				
				getPlafon();
			}
		});
	}*/
	
	function getPlafon(){
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/droppingkaskecil/getplafon",
			data: "unit_kode="+$("#search_unit_kode").val(),
			success: function(msg){
				//alert(msg);
				$('#ins_plafon_kkecil').val(Math.round(msg));
				
				var saldokk = parseInt($('#ins_total_kkecil').val().replace(/\./g,''));
				var plafon = parseInt($('#ins_plafon_kkecil').val().replace(/\./g,''));
				
				var dropping = plafon - saldokk;
				//alert("plafon "+msg+" saldoKK "+saldokk+" plafond "+plafon+" drop "+dropping);
				if(dropping > plafon){
					dropping = plafon;
				}
				$('#ins_jumlah_pengajuan').val(dropping);
				
				$('#loader-form').hide();
				$('#btn-simpan').show();
			}
		});
	}
	
	function getTahap(){
		$('#loader-form').show();
		$('#btn-simpan').hide();
		
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/droppingkaskecil/gettahap",
			data: "unit_kode="+$("#search_unit_kode").val(),
			success: function(msg){
				var dataarr = msg.split("#");
				$('#ins_tahap_pengajuan').val(dataarr[0]);
				$('#ins_tgl_pengajuan').val(dataarr[1]);
				
				getSaldoKK();
			}
		});
	}
	
	function simpanpengajuan(){
		$('#loader-form').show();
		$('#btn-simpan').hide();
		
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/droppingkaskecil/simpandroppingkaskecil",
			data: "ins_tanggal="+$('#ins_tgl_pengajuan').val()+"&ins_bukti_kasbank="+$('#ins_bukti_kasbank').val()+"&ins_tahap_pengajuan="+$('#ins_tahap_pengajuan').val()+"&ins_saldo_kkecil="+$('#ins_total_kkecil').val().replace(/\./g,'')+"&ins_jumlah="+$('#ins_jumlah_pengajuan').val().replace(/\./g,'')+"&unit_kode="+$("#search_unit_kode").val(),
			success: function(msg){
				var callback = json_decode(msg);
				if(callback.pesan == "gagal"){
					var tahap = parseInt($('#ins_tahap_pengajuan').val());
					alert("Maaf, Dropping tahap "+(tahap - 1)+" belum diselesaikan.");
					
					$('#loader-form').hide();
					$('#btn-simpan').show();
				}else{
					alert(callback.pesan);
					
					$('#loader-form').hide();
					$('#btn-simpan').show();
					
					$("#form-droppingkaskecil").modal("hide");
					
					LoadDataDroppingKasKecil();
					
					// cetakBukti(callback.no_bukti);
				}
			}
		});
	}
	
	function setappdok(){
		var data_obj = $('#dataTables-droppingkaskecil tr.active').attr("data");
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var is_setuju = confirm("Konfirmasi apakah dokumen dropping sebelumnya sudah diterima?");
			if(is_setuju){
				var data = json_decode(base64_decode(data_obj));
				$.ajax({
					type: "POST",
					url: "<?= base_url() ?>index.php/droppingkaskecil/setappdok",
					data: "bukti="+data['bukti']+"&unit_kode="+data['unit_kode'],
					success: function(msg){
						LoadDataDroppingKasKecil();
					}
				});
			}
		}
	}
	
	function setverifikasidok(){
		var data_obj = $('#dataTables-droppingkaskecil tr.active').attr("data");
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			if(data['is_app_dok'] != "Belum"){
				$('#form-verifikasi').modal('show');
				gettemuanket(data['bukti']);
				$('#table_keterangan').html("");
			}else{
				alert("Maaf, dokumen dropping tahap sebelumnya belum diterima");
			}
		}
	}
	
	function simpanverifikasi(){
		var data_obj = $('#dataTables-droppingkaskecil tr.active').attr("data");
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			var datatemuan = $('#table_keterangan li');
			
			var temuanpost = "";
			for(i=0;i<datatemuan.length;i++){
				temuanpost += "&temuan"+i+"="+datatemuan[i].innerHTML;
			}
			
			$.ajax({
				type: "POST",
				url: "<?= base_url() ?>index.php/droppingkaskecil/setverifikasi",
				data: "bukti="+data['bukti']+"&unit_kode="+data['unit_kode']+"&keterangan="+$('#keterangan').val()+temuanpost+"&jumlah_temuan="+datatemuan.length,
				success: function(msg){
					$('#table_keterangan').html("");
					$('#form-verifikasi').modal('hide');
					
					LoadDataDroppingKasKecil();
				}
			});
		}
	}
	
	function gettemuanket(no_bukti){
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/droppingkaskecil/gettemuanket",
			data: "bukti="+no_bukti,
			success: function(msg){
				$('#keterangan').html(msg);
			}
		});
	}
	
	function tambahketerangan(){
		var keterangan = $('#keterangan').val();
		if(keterangan != ""){
			$('#table_keterangan').append("<li>"+keterangan+"</li>");
		}
		
		$('#keterangan').val("");
		// openFormKeterangan(0);
		simpanverifikasi();
	}
	
	function ShowTemuan(data){
		var datadecoded = base64_decode(data);
		alert(datadecoded);
	}
	
	function CetakDroppingKasKecil(){
		var data_obj = $('#dataTables-droppingkaskecil tr.active').attr("data");
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			window.open('<?= base_url('index.php/droppingkaskecil/cetakdroppingkaskecil?') ?>bukti='+data['bukti']+'&unit_kode='+data['unit_kode'],'_blank');
		}
	}
	
	function CetakRincianKasbank(){
		var data_obj = $('#dataTables-droppingkaskecil tr.active').attr("data");
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			window.open('<?= base_url('index.php/droppingkaskecil/cetakrinciankasbank?') ?>bukti='+data['bukti']+'&unit_kode='+data['unit_kode'],'_blank');
		}
	}
	
	function SetPPU(){
		var data_obj = $('#dataTables-droppingkaskecil tr.active').attr("data");
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			if(data.is_verifikasi != "Belum"){
				var is_setuju = confirm("Cetak form ppu?");
				if(is_setuju){
					$.ajax({
						type: "POST",
						url: "<?= base_url() ?>index.php/droppingkaskecil/setppu",
						data: "bukti="+data['bukti']+"&unit_kode="+data['unit_kode'],
						success: function(msg){
							CetakPPU();
							LoadDataDroppingKasKecil();
						}
					});
				}
			}else{
				alert("Maaf, dokumen dropping belum diverifikasi");
			}
		}
	}
	
	function CetakPPU(){
		var data_obj = $('#dataTables-droppingkaskecil tr.active').attr("data");
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			window.open('<?= base_url('index.php/droppingkaskecil/cetakppu?') ?>bukti='+data['bukti']+'&unit_kode='+data['unit_kode'],'_blank');
		}
	}
	
	function SetRealisasi(){
		var data_obj = $('#dataTables-droppingkaskecil tr.active').attr("data");
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			if(data['is_realisasi'] == 'Belum'){
				if(data['is_ppu'] != "Belum"){
					var is_setuju = confirm("Konfirmasi apakah dropping dengan no bukti "+data['bukti']+" sudah dicairkan?");
					if(is_setuju){
						var data = json_decode(base64_decode(data_obj));
						$.ajax({
							type: "POST",
							url: "<?= base_url() ?>index.php/droppingkaskecil/setrealisasi",
							data: "bukti="+data['bukti']+"&unit_kode="+data['unit_kode']+"&jumlah="+data['jumlah'],
							success: function(msg){
								LoadDataDroppingKasKecil();
							}
						});
					}
				}else{
					alert("Maaf, dokumen bukti dropping belum dibuatkan ppu");
				}
			}else{
				alert("Maaf, data dropping sudah dilakukan realisasi");
			}
		}
	}
	
	function HapusDroppingKasKecil(){
		var data_obj = $('#dataTables-droppingkaskecil tr.active').attr("data");
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			if(data['is_realisasi'] == 'Belum'){
				var is_setuju = confirm("Apakah anda ingin menghapus data ini?");
				if(is_setuju){
					$.ajax({
						type: "POST",
						url: "<?= base_url() ?>index.php/droppingkaskecil/hapusdroppingkaskecil",
						data: "bukti="+data['bukti']+"&unit_kode="+data['unit_kode'],
						success: function(msg){
							LoadDataDroppingKasKecil();
						}
					});
				}
			}else{
				alert("Maaf, data dropping sudah dilakukan realisasi");
			}
		}
	}
</script>