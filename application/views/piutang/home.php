<style>
	.question{z-index:1151 !important;}
	.datepicker{z-index:1151 !important;}
</style>
<div id="page-wrapper">
	<div class="row">
	    <div class="col-lg-12">
	        <h1 style="margin-top: 15px;" class="page-header">Data Piutang</h1>
	    </div>
	    <!-- /.col-lg-12 -->
	</div>
	<div class="row">
		<div class="col-lg-12">
			<table style="float: right;">
				<tr>
					<td>
						<select style="width: 150px;" class="form-control" name="toko_kode" id="toko_kode">
							<option value="VO0001">SEGUNTING</option>
							<option value="VO0002">BOGOREJO</option>
						</select>
					</d>
					<td>&nbsp;&nbsp;</td>
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
						<button id="btn_upload" onclick="LoadDataPiutang()" class="btn btn-info" type="button">
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
					&nbsp;
                    <button id="btn_upload" onclick="openFormPembayaran(1)" class="btn btn-info btn-sm" type="button">
						<i class="fa fa-plus"></i>
						&nbsp;&nbsp;Bayar
					</button>
					<button id="btn_upload" onclick="openDetailPembayaran()" class="btn btn-info btn-sm" type="button">
						<i class="fa fa-table"></i>
						&nbsp;&nbsp;Detail Pembayaran
					</button>
					<button id="btn_upload" onclick="openFormKuitansi()" class="btn btn-warning btn-sm" type="button">
						<i class="fa fa-plus"></i>
						&nbsp;&nbsp;Set Kuitansi
					</button>
					<button id="btn_upload" onclick="BatalKuitansi()" class="btn btn-danger btn-sm" type="button">
						<i class="fa fa-times"></i>
						&nbsp;&nbsp;Batal Kuitansi
					</button>
					<button id="btn_upload" onclick="opencetakkuitansi()" class="btn btn-success btn-sm" type="button">
						<i class="fa fa-print"></i>
						&nbsp;&nbsp;Cetak Kuitansi
					</button>
					<button id="btn_upload" onclick="cetakrekapkuitansi()" class="btn btn-success btn-sm" type="button">
						<i class="fa fa-print"></i>
						&nbsp;&nbsp;Cetak Rekap Kuitansi
					</button>
					<button id="btn_upload" onclick="PelunasanKuitansi()" class="btn btn-success btn-sm" type="button">
						<i class="fa fa-check"></i>
						&nbsp;&nbsp;Pelunasan Kuitansi
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
					<div class="table-responsive table-piutang">
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
							<input type="hidden" name="hidden_id_piutang" id="hidden_id_piutang" value="" />
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
        			<h4 class="modal-title" id="myModalLabel">Form Pembayaran Piutang</h4>
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
								Jumlah Piutang :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-money"></i>
									</span>
									<input type="hidden" name="pembayaran_mode" id="pembayaran_mode" value="1" />
									<input type="text" style="text-align: right;" placeholder="Jumlah Piutang" disabled name="pembayaran_jumlah_piutang" id="pembayaran_jumlah_piutang" class="form-control">
								</div>
								Sisa Piutang :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-money"></i>
									</span>
									<input type="text" style="text-align: right;" placeholder="Sisa Piutang" disabled name="pembayaran_sisa_piutang" id="pembayaran_sisa_piutang" class="form-control">
								</div>
								Jumlah Bayar :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-money"></i>
									</span>
									<input type="text" style="text-align: right;" placeholder="Jumlah Pembayaran" onkeyup="price('pembayaran_pembayaran'); HitungBatas();" name="pembayaran_pembayaran" id="pembayaran_pembayaran" class="form-control">
								</div>
							</td>
							<td>&nbsp;&nbsp;&nbsp;</td>
							<td valign="top">
								Ke:
								<div class="form-group">
									<label class="radio-inline">
										<input id="pembayaran_kas_besar" checked type="radio" value="110" name="pembayaran_ke"> Kas Besar
									</label>
									<label class="radio-inline">
										<input id="pembayaran_giro" type="radio" value="112" name="pembayaran_ke"> Cek / Giro
									</label>
								</div>
								Melalui :
								<div class="radio">
									<label>
										<input checked type="radio" name="pembayaran_melalui" id="pembayaran_melalui_pusat" value="pusat">
										Kasir Pusat KWSG
									</label>
								</div>
								<!--<div class="radio">
									<label>
										<input type="radio" name="pembayaran_melalui" id="pembayaran_melalui_pajak" value="pajak">
										Unit Pajak dan Asusransi
									</label>
								</div>-->
								<div class="radio">
									<label>
										<input type="radio" name="pembayaran_melalui" id="pembayaran_melalui_vmart" value="vmart">
										Kasir Unit VMart
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
	<div class="modal fade" id="form-setkuitansi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        			<h4 class="modal-title" id="myModalLabel">Form Set Kuitansi</h4>
				</div>
				<div class="modal-body">
					<table>
						<tr>
							<td valign="top">
								Pelanggan
							</td>
							<td valign="top">&nbsp; : &nbsp;</td>
							<td valign="top">
								<div class="form-group input-group">
									<input type="text" class="form-control" style="width: 250px;" name="piutang_pelanggan_kode" id="piutang_pelanggan_kode" />
								</div>
							</td>
							<td valign="top">&nbsp;&nbsp;</td>
							<td valign="top">
								Keterangan
							</td>
							<td valign="top">&nbsp; : &nbsp;</td>
							<td valign="top">
								<div class="form-group input-group">
									<input type="text" class="form-control" style="width: 350px;" name="piutang_keterangan_kuitansi" id="piutang_keterangan_kuitansi" />
								</div>
							</td>
							<!--<td valign="top">
								<button onclick="addTransaksi()" class="btn btn-info btn-sm" type="button">
									<i class="fa fa-plus"></i>
								</button>
							</td>-->
						</tr>
						<tr>
							<td valign="top">No Kuitansi</td>
							<td valign="top">&nbsp; : &nbsp;</td>
							<td valign="top">
								<input type="text" class="form-control" style="width: 100px;" name="piutang_no_kuitansi" id="piutang_no_kuitansi" />/K-MART/K3PG/<?php echo date('m').'.'.date('Y'); ?>
							</td>
							<td valign="top">&nbsp;&nbsp;</td>
							<td valign="top" colspan="3">
								*Kosongkan untuk no kuitansi otomatis
							</td>
						</tr>
					</table>
					<table id="table-dummy-kuitansitrans" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th class="text-center">No Trans</th>
								<th class="text-center">Tanggal</th>
								<th class="text-center">Kode Pelanggan</th>
								<th class="text-center">Nama Pelanggan</th>
								<th class="text-center">Jatuh Tempo</th>
								<th class="text-center">Piutang</th>
								<th class="text-center">Hapus</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" onclick="clearForm(1)" class="btn btn-default">Reset</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<img src="<?= base_url() ?>/images/loader.gif" id="loader-form-kuitansi"  style="width: 30px; display: none;" />
			        <button type="button" id="btn-simpan-kuitansi" onclick="simpankuitansi()" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;&nbsp;Simpan</button>
				</div>
			</div>
		</div>
	</div>
	<!-- Popup form untuk bayar hutang kuitansi -->
	<div class="modal fade" id="form-pembayaran-kuitansi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        			<h4 class="modal-title" id="myModalLabel">Form Pembayaran Piutang Kuitansi</h4>
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
									<input type="text" value="<?= date("Y-m-d"); ?>" placeholder="Tanggal Pembayaran" name="pembayaran_kuitansi_tanggal" id="pembayaran_kuitansi_tanggal" class="form-control">
								</div>
								No Kuitansi :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</span>
									<input type="text" name="pembayaran_no_kuitansi" id="pembayaran_no_kuitansi" class="form-control">
								</div>
								Jumlah Piutang :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-money"></i>
									</span>
									<input type="text" style="text-align: right;" disabled name="pembayaran_kuitansi_total_piutang" id="pembayaran_kuitansi_total_piutang" class="form-control">
								</div>
								Pelunasan Piutang :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-money"></i>
									</span>
									<input type="hidden" name="pembayaran_kuitansi_mode" id="pembayaran_kuitansi_mode" value="1" />
									<input type="text" style="text-align: right;" disabled name="pembayaran_kuitansi_jumlah_piutang" id="pembayaran_kuitansi_jumlah_piutang" class="form-control">
								</div>
								Piutang SSP:
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-money"></i>
									</span>
									<input type="text" style="text-align: right;" onkeyup="hitungpiutang();" name="pembayaran_kuitansi_jumlah_ssp" id="pembayaran_kuitansi_jumlah_ssp" class="form-control">
								</div>
								Piutang PPh:
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-money"></i>
									</span>
									<input type="text" style="text-align: right;" onkeyup="hitungpiutang();" value="0" name="pembayaran_kuitansi_jumlah_pph" id="pembayaran_kuitansi_jumlah_pph" class="form-control">
								</div>
							</td>
							<td>&nbsp;&nbsp;&nbsp;</td>
							<td valign="top">
								Ke:
								<div class="form-group">
									<label class="radio-inline">
										<input id="pembayaran_kuitansi_kas_besar" checked type="radio" value="110" name="kuitansi_pembayaran_ke"> Kas Besar
									</label>
									<label class="radio-inline">
										<input id="pembayaran_kuitansi_giro" type="radio" value="112" name="kuitansi_pembayaran_ke"> Cek / Giro
									</label>
								</div>
								Melalui :
								<div class="radio">
									<label>
										<input checked type="radio" name="kuitansi_ppembayaran_melalui" id="pembayaran_kuitansi_melalui_pusat" value="pusat_kuitansi">
										Kasir Pusat KWSG
									</label>
								</div>
								<!--<div class="radio">
									<label>
										<input type="radio" name="pembayaran_melalui" id="pembayaran_melalui_pajak" value="pajak">
										Unit Pajak dan Asusransi
									</label>
								</div>-->
								<div class="radio">
									<label>
										<input type="radio" name="kuitansi_ppembayaran_melalui" id="pembayaran_kuitansi_melalui_vmart" value="vmart">
										Kasir VMart
									</label>
								</div>
							</td>
						</tr>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" onclick="clearForm(1)" class="btn btn-default">Reset</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<img src="<?= base_url() ?>/images/loader.gif" id="loader-form-pembayarankuitansi"  style="width: 30px; display: none;" />
			        <button type="button" id="btn-simpan-pembayarankuitansi" onclick="simpanpembayarankuitansi()" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;&nbsp;Simpan</button>
				</div>
			</div>
		</div>
	</div>
	
	<!-- Popup untuk cetak kuitansi -->
	<div class="modal fade" id="form-cetakkuitansi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        			<h4 class="modal-title" id="myModalLabel">Form Cetak Kuitansi</h4>
				</div>
				<div class="modal-body">
					Tanggal :
					<div class="form-group input-group">
						<span class="input-group-addon">
							<i class="fa fa-calendar"></i>
						</span>
						<input type="text" value="<?= date("d-m-Y"); ?>" placeholder="Tanggal Kuitansi" name="cetak_kuitansi_tanggal" id="cetak_kuitansi_tanggal" class="form-control">
					</div>
					Nama Pelanggan :
					<div class="form-group input-group">
						<span class="input-group-addon">
							<i class="fa fa-file"></i>
						</span>
						<input type="text" name="cetak_kuitansi_pelanggan" id="cetak_kuitansi_pelanggan" class="form-control">
					</div>
					
					<div class="form-group">
						<label class="radio-inline">
							<input id="cetak_kuitansi_ppn" checked type="radio" value="1" name="cetak_kuitansi_mode"> PPN
						</label>
						<label class="radio-inline">
							<input id="cetak_kuitansi_nonppn" type="radio" value="0" name="cetak_kuitansi_mode"> NON PPN
						</label>
					</div>
					<div class="form-group">
						<label class="radio-inline">
							<input id="cetak_kuitansi_tunai" type="radio" value="1" name="cetak_kuitansi_metode"> TUNAI
						</label>
						<label class="radio-inline">
							<input id="cetak_kuitansi_transfer" checked type="radio" value="0" name="cetak_kuitansi_metode"> TRANSFER
						</label>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			        <button type="button" id="btn-simpan-pembayarankuitansi" onclick="cetakkuitansi()" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;&nbsp;Cetak</button>
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
		
		$('#pembayaran_kuitansi_tanggal').datepicker({
			format: 'yyyy-mm-dd'
		});
		
		$('#cetak_kuitansi_tanggal').datepicker({
			format: 'dd-mm-yyyy'
		});
		
		LoadDataPiutang();
		
		$('.ask').jConfirmAction();
		$('.datepicker tbody').on('click', function(){  $('.datepicker').hide() });
	});
	
	function LoadDataPiutang(){
		$('#progres-main').show();
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/piutang/getdatapiutang",
			data: "tahun="+$('#tahun').val()+"&bulan="+$('#bulan').val()+"&toko_kode="+$('#toko_kode').val(),
			success: function(msg){
				$(".table-piutang").html(msg);
				table = $('#dataTables-piutang').dataTable();
				$('#progres-main').hide();
				
				$('#dataTables-piutang tbody').on( 'click', 'tr', function () {
			        if ( $(this).hasClass('active') ) {
			            $(this).removeClass('active');
			        }else {
			            table.$('tr.active').removeClass('active');
			            $(this).addClass('active');
			        }
			        
			        $("#hidden_id_piutang").val(table.$('tr.active').attr("id"));
			    } );
			    
			    var hidden_id_piutang = $("#hidden_id_piutang").val();
			    if(hidden_id_piutang != ""){
			    	setSelection($("#hidden_id_piutang").val());
			    }
				
				LoadListDataTransaksi();
			}
		});
	}
	
	function LoadDetailPembayaran(){
		$(".table-pembayaran").html("");
		$('#progres-pembayaran').show();
		var bukti_order = table.$('tr.active').attr("bukti");
		var pelanggan_kode = table.$('tr.active').attr("pelanggan_kode");
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/piutang/getdetailpembayaran",
			data: "bukti_order="+bukti_order+"&pelanggan_kode="+pelanggan_kode,
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
		var piutang = table.$('tr.active').attr("piutang");
		var sisa = table.$('tr.active').attr("sisa");
		var no_kuitansi = table.$('tr.active').attr("no_kuitansi");
		
		if(no_kuitansi == ""){
			if(typeof piutang == 'undefined'){
				alert("Silahkan pilih salah satu data");
			}else{
				var jumlah = 0;
				if(mode == 2){
					jumlah = table_pembayaran.$('tr.active').attr("jm_bayar");
				}
				
				$("#pembayaran_jumlah_piutang").val(piutang);
				$("#pembayaran_sisa_piutang").val(sisa);
				price_js('pembayaran_jumlah_piutang');
				price_js('pembayaran_sisa_piutang');
				$("#pembayaran_mode").val(mode);
				if(mode == 2){ // untuk edit pembayaran
					$("#pembayaran_pembayaran").val(jumlah);
					price_js("pembayaran_pembayaran");
				}
				
				$('#form-pembayaran').modal('show');
			}
		}else{
			alert("Silahkan melakukan pembayaran melalui menu pelunasan kuitansi");
		}
	}
	
	function openFormKuitansi(){
		$('#form-setkuitansi').modal('show');
	}
	
	function HitungBatas(){
		var sisa = removeCurrency($("#pembayaran_sisa_piutang").val());
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
				$('#table-dummy-kuitansitrans > tbody').html("");
				break;
		}
	}
	
	function simpanpembayaran(){
		$('#btn-simpan').hide();
		$('#loader-form').show();
		
		var pelanggan_kode = table.$('tr.active').attr("pelanggan_kode");
		var nama_pelanggan = table.$('tr.active').attr("nama_pelanggan");
		var bukti_order = table.$('tr.active').attr("bukti");
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
		var pembayaran_ke = $("input[name=pembayaran_ke]:checked").val();
		var pembayaran_melalui = $("input[name=pembayaran_melalui]:checked").val();
		var tanggal = $("#pembayaran_tanggal").val();
		var toko_kode = $("#toko_kode").val();
		// if($("#pembayaran_melalui").is(':checked')){
			// pembayaran_melalui = "pusat";
		// }
		
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/piutang/simpanpembayaran",
			data: "ref_penjualan="+bukti_order+"&jumlah="+jumlah_pembayaran+"&pelanggan_kode="+pelanggan_kode+"&nama_pelanggan="+nama_pelanggan+"&mode_form="+mode_form+"&jumlah_lama="+jumlah_lama+"&id_pembayaran="+id_pembayaran+"&ref_kasbank="+ref_kasbank+"&pembayaran_ke="+pembayaran_ke+"&pembayaran_melalui="+pembayaran_melalui+"&tanggal="+tanggal+"&toko_kode="+toko_kode,
			success: function(msg){
				$('#form-pembayaran').modal('hide');
				LoadDataPiutang();
				
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
		var pelanggan_kode = table.$('tr.active').attr("pelanggan_kode");
		var ref_penjualan = table.$('tr.active').attr("bukti");
		var tanggal = table_pembayaran.$('tr.active').attr("tanggal");
		var toko_kode = $("#toko_kode").val();
		
		$.ajax({
			type: "POST",
			url: "<?= base_url(); ?>index.php/piutang/hapuspembayaran",
			data: "id_pembayaran="+id_pembayaran+"&pelanggan_kode="+pelanggan_kode+"&toko_kode="+toko_kode+"&jumlah="+jumlah+"&ref_penjualan="+ref_penjualan+"&tanggal="+tanggal,
			success: function(msg){
				LoadDataPiutang();
				
				LoadDetailPembayaran();
				$('#form-detail-pembayaran').modal('hide');
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
	
	function LoadListDataTransaksi(){
	    $("#piutang_pelanggan_kode").select2({
		    placeholder: "Cari Pelanggan",
		    minimumInputLength: 1,
		    ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
			    url: "<?php echo base_url(); ?>index.php/pelanggan/getlistpelanggan",
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
            	return option.nama_pelanggan;
            }
	    });
	    
	    $("#piutang_pelanggan_kode").on("select2-selecting", function(e) {
	    	// dataperlang = e;
	    	// alert ("selecting val="+ e.choice.satuan_terkecil +" choice="+ JSON.stringify(e.choice));
			/*var row = "<tr><td>"+e.choice.ref_penjualan+"</td><td>"+e.choice.tanggal+"</td><td>"+e.choice.pelanggan_kode+"</td><td>"+e.choice.nama_pelanggan+"</td><td>"+e.choice.jatuh_tempo+"</td><td>"+e.choice.jumlah+"</td><td><button type=\"button\" onclick=\"HapusRow(this)\" class=\"btn btn-default\"><i class=\"fa fa-times\"></i></button></td></tr>";
			$('#table-dummy-kuitansitrans > tbody:last').append(row);*/
			LoadDataPiutangPelanggan(e.choice.kode);
	    });
	}
	
	function HapusRow(DataObj){
		dataobj = DataObj;
		$(DataObj).parent().parent().remove();
	}
	
	function simpankuitansi(){
		$('#btn-simpan-kuitansi').hide();
		$('#loader-form-kuitansi').show();
		
		var dataArr = [];
	    $("#table-dummy-kuitansitrans td").each(function(){
	        dataArr.push($(this).html());
	    });
		
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/bukti/generatebukti",
			data: "mode=KW",
			success: function(msg){
				var jsonData = rawurlencode(json_encode(dataArr));
				
				$.ajax({
					type: "POST",
					url: "<?= base_url() ?>index.php/piutang/simpankuitansi",
					data: "nokuitansi="+msg+"&keterangan_kuitansi="+base64_encode($("#piutang_keterangan_kuitansi").val())+"&no_kuitansi="+$("#piutang_no_kuitansi").val()+"&toko_kode="+$("#toko_kode").val()+"&data="+jsonData,
					success: function(message){
						$('#btn-simpan-kuitansi').show();
						$('#loader-form-kuitansi').hide();
						
						//cetakkuitansi2(message);
						//cetakrekapkuitansi(message);
						clearForm('1');
						LoadDataPiutang();
						$('#form-setkuitansi').modal('hide');
					}
				});
			}
		});
	}
	
	function LoadDataPiutangPelanggan(pelanggan_kode){
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/piutang/getdatapiutangpelanggan",
			data: "pelanggan_kode="+pelanggan_kode+"&toko_kode="+$('#toko_kode').val(),
			success: function(message){
				$("#table-dummy-kuitansitrans tbody").html(message);
			}
		});
	}
	
	function simpanpembayarankuitansi(){
		$('#btn-simpan-pembayarankuitansi').hide();
		$('#loader-form-pembayarankuitansi').show();
		
		var pelanggan_kode = table.$('tr.active').attr("pelanggan_kode");
		var nama_pelanggan = table.$('tr.active').attr("nama_pelanggan");
		var mode_form = $("#pembayaran_kuitansi_mode").val();
		
		var pembayaran_ke = $("input[name=kuitansi_pembayaran_ke]:checked").val();
		var pembayaran_melalui = $("input[name=kuitansi_ppembayaran_melalui]:checked").val();
		var tanggal = $("#pembayaran_kuitansi_tanggal").val();
		var no_kuitansi = $("#pembayaran_no_kuitansi").val();
		var jumlah_pelunasan = $("#pembayaran_kuitansi_jumlah_piutang").val();
		var jumlah_ssp = $("#pembayaran_kuitansi_jumlah_ssp").val();
		var jumlah_pph = $("#pembayaran_kuitansi_jumlah_pph").val();
		// if($("#pembayaran_melalui").is(':checked')){
			// pembayaran_melalui = "pusat";
		// }
		
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/piutang/simpanpembayarankuitansi",
			data: "pelanggan_kode="+pelanggan_kode+"&nama_pelanggan="+nama_pelanggan+"&mode_form="+mode_form+"&pembayaran_ke="+pembayaran_ke+"&pembayaran_melalui="+pembayaran_melalui+"&tanggal="+tanggal+"&no_kuitansi="+no_kuitansi+"&jumlah_pelunasan="+jumlah_pelunasan+"&jumlah_ssp="+jumlah_ssp+"&jumlah_pph="+jumlah_pph,
			success: function(msg){
				$('#form-pembayaran-kuitansi').modal('hide');
				LoadDataPiutang();
				
				$('#btn-simpan-pembayarankuitansi').show();
				$('#loader-form-pembayarankuitansi').hide();
				clearForm(1);
			},
			error: function(xhr,status,error){
				alert(status);
				$('#btn-simpan').show();
				$('#loader-form').hide();
			}
		});
	}
	
	function PelunasanKuitansi(){
		var no_kuitansi = table.$('tr.active').attr("no_kuitansi");
		if(typeof no_kuitansi == 'undefined'){
			alert("Silahkan pilih salah satu data");
		}else{
			$.ajax({
				type: "POST",
				url: "<?= base_url() ?>index.php/piutang/getJumlahKuitansi",
				data: "no_kuitansi="+no_kuitansi,
				success: function(message){
					$("#form-pembayaran-kuitansi").modal("show");
					$("#pembayaran_no_kuitansi").val(no_kuitansi);
					
					var ssp = parseFloat(message) * 0.11; //k3pg-ppn
					var jumlah_piutang = parseFloat(message) - ssp;
					
					$("#pembayaran_kuitansi_total_piutang").val(message);
					//price("pembayaran_kuitansi_total_piutang");
					$("#pembayaran_kuitansi_jumlah_piutang").val(jumlah_piutang);
					//price("pembayaran_kuitansi_jumlah_piutang");
					$("#pembayaran_kuitansi_jumlah_ssp").val(ssp);
					//price("pembayaran_kuitansi_jumlah_ssp");
				}
			});
		}
	}
	
	function opencetakkuitansi(){
		var no_kuitansi = table.$('tr.active').attr("no_kuitansi");
		var nama_pelanggan = table.$('tr.active').attr("nama_pelanggan");
		if(typeof no_kuitansi == 'undefined'){
			alert("Silahkan pilih salah satu data");
		}else{
			if(nama_pelanggan.includes("KSO SEMEN GRESIK-SEMEN INDONESIA")){
				nama_pelanggan = "KSO SEMEN GRESIK-SEMEN INDONESIA";
			}else if(nama_pelanggan.includes("SEMEN INDONESIA")){
				nama_pelanggan = "PT SEMEN INDONESIA (PERSERO) TBK.";
			}
			$("#cetak_kuitansi_pelanggan").val(nama_pelanggan);
			$("#form-cetakkuitansi").modal("show");
		}
	}
	
	function cetakkuitansi(){
		var no_kuitansi = table.$('tr.active').attr("no_kuitansi");
		var tanggal_kuitansi = $("#cetak_kuitansi_tanggal").val();
		var mode_ppn = $("input[name=cetak_kuitansi_mode]:checked").val();
		var mode_metode = $("input[name=cetak_kuitansi_metode]:checked").val();
		var nama_pelanggan = $("#cetak_kuitansi_pelanggan").val();
		
		if(typeof no_kuitansi == 'undefined'){
			alert("Silahkan pilih salah satu data");
		}else{
			<?php if($this->session->userdata('toko_kode') == "VO0001"){ ?>
				window.open('<?= base_url('index.php/piutang/cetakkuitansisegunting?') ?>no_kuitansi='+no_kuitansi+'&tanggal_kuitansi='+tanggal_kuitansi+'&mode_ppn='+mode_ppn+'&mode_metode='+mode_metode+'&nama_pelanggan='+nama_pelanggan,'_blank');
			<?php }else{ ?>
				window.open('<?= base_url('index.php/piutang/cetakkuitansi?') ?>no_kuitansi='+no_kuitansi+'&tanggal_kuitansi='+tanggal_kuitansi+'&mode_ppn='+mode_ppn+'&mode_metode='+mode_metode+'&nama_pelanggan='+nama_pelanggan,'_blank');
			<?php } ?>
			$("#form-cetakkuitansi").modal("hide");
		}
	}
	
	function BatalKuitansi(){
		var no_kuitansi = table.$('tr.active').attr("no_kuitansi");
		if(typeof no_kuitansi == 'undefined'){
			alert("Silahkan pilih salah satu data");
		}else{
			$.ajax({
				type: "POST",
				url: "<?= base_url() ?>index.php/piutang/batalkuitansi",
				data: "no_kuitansi="+no_kuitansi,
				success: function(message){
					alert("Kuitansi telah dibatalkan");
					LoadDataPiutang();
				}
			});
		}
	}
	
	function hitungpiutang(){
		var totalPiutang = $("#pembayaran_kuitansi_total_piutang").val();
		var jumlahPiutang = $("#pembayaran_kuitansi_jumlah_piutang").val();
		var jumlahSSP = $("#pembayaran_kuitansi_jumlah_ssp").val();
		var jumlahPPh = $("#pembayaran_kuitansi_jumlah_pph").val();
		
		if(jumlahSSP == ""){
			jumlahSSP = 0;
		}
		if(jumlahPPh == ""){
			jumlahPPh = 0;
		}
		
		jumlahPiutang = parseFloat(totalPiutang) - (parseFloat(jumlahSSP) + parseFloat(jumlahPPh));
		$("#pembayaran_kuitansi_jumlah_piutang").val(jumlahPiutang);
		//price('pembayaran_kuitansi_jumlah_piutang');
	}
	
	function cetakkuitansi2(no_kuitansi){
		<?php if($this->session->userdata('toko_kode') == "VO0001"){ ?>
			window.open('<?= base_url('index.php/piutang/cetakkuitansisegunting?') ?>no_kuitansi='+no_kuitansi,'_blank');
		<?php }else{ ?>
			window.open('<?= base_url('index.php/piutang/cetakkuitansi?') ?>no_kuitansi='+no_kuitansi,'_blank');
		<?php } ?>
	}
	
	function cetakrekapkuitansi(){
		var no_kuitansi = table.$('tr.active').attr("no_kuitansi");
		if(typeof no_kuitansi == 'undefined'){
			alert("Silahkan pilih salah satu data");
		}else{
			window.open('<?= base_url('index.php/piutang/cetakrekappiutangkuitansi?') ?>no_kuitansi='+no_kuitansi,'_blank');
		}
	}
</script>