<style>
	.datepicker{z-index:1151 !important;}
</style>
<div id="page-wrapper">
	<div class="row">
	    <div class="col-lg-12">
	        <h1 style="margin-top: 15px;" class="page-header">Data Pengadaan Barang</h1>
	    </div>
	    <!-- /.col-lg-12 -->
	</div>
	<div class="row">
		<div class="col-lg-12">
			<table style="float: right;">
				<tr>
					<!--<td style="width: 100px;">
						<label class="radio-inline">
							<input id="search_is_bkl" type="checkbox" name="search_is_bkl"> BKL
						</label>
					</td>-->
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
					<td valign="middle">
						<button id="btn_upload" onclick="LoadDataPembelianBarang()" class="btn btn-info" type="button">
							<i class="fa fa-search"></i>
							&nbsp;&nbsp;Search
						</button>
					</td>
					<td>&nbsp;&nbsp;</td>
					<td valign="middle">
						<button id="btn_upload" onclick="CetakPembelianBarang()" class="btn btn-success" type="button">
							<i class="fa fa-print"></i>
							&nbsp;&nbsp;Rekap Harian (pdf)
						</button>
					</td>
					<td>&nbsp;&nbsp;</td>
					<td valign="middle">
						<button id="btn_upload" onclick="CetakPembelianBarangExcel()" class="btn btn-success" type="button">
							<i class="fa fa-print"></i>
							&nbsp;&nbsp;Rekap Harian (xls)
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
                    <button id="btn_open" onclick="openFormPembelianBarang(1)" class="btn btn-info btn-sm" type="button">
						<i class="fa fa-plus"></i>
						&nbsp;&nbsp;Tambah
					</button>
					<button id="btn_uedit" onclick="openFormEditPembelian()" class="btn btn-warning btn-sm" type="button">
						<i class="fa fa-edit"></i>
						&nbsp;&nbsp;Edit
					</button>
					<button id="btn_upload" fungsi="HapusPembelianBarang()" class="btn btn-danger btn-sm ask" type="button">
						<i class="fa fa-times"></i>
						&nbsp;&nbsp;Hapus
					</button>
					<!--<button id="btn_upload" onclick="ApproveBKL()" class="btn btn-success btn-sm" type="button">
						<i class="fa fa-check"></i>
						&nbsp;&nbsp;Approve
					</button>-->
					<button id="btn_cetak" onclick="cetakNotaPembelian()" class="btn btn-success btn-sm" type="button">
						<i class="fa fa-print"></i>
						&nbsp;&nbsp;Cetak Nota
					</button>
					<button id="btn_transfertoko" onclick="OpenFormTransferkeToko()" class="btn btn-success btn-sm" type="button">
						<i class="fa fa-check"></i>
						&nbsp;&nbsp;Transfer Ke Toko
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
					<div style="max-height: 600px; overflow: scroll;" class="table-responsive table-pembelian-barang">
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Popup form untuk pembelian barang -->
	<div class="modal fade" id="form-pembelian-barang" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        			<h4 class="modal-title" id="myModalLabel">Form Pembelian Barang</h4>
				</div>
				<div class="modal-body">
					<table style="width: 93%;">
						<tr>
							<td style="width: 200px;">Tanggal :</td>
							<td>&nbsp;&nbsp;
								<input type="hidden" name="bukti_op" id="bukti_op" />
								<input type="hidden" name="pembelian_mode" id="pembelian_mode" value="i" />
								<input type="hidden" name="pembelian_bukti" id="pembelian_bukti" />
							</td>
							<td>Supplier :</td>
						</tr>
						<tr>
							<td>
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</span>
									<input type="text" value="<?= date("Y-m-d"); ?>" placeholder="Tanggal OP" name="pembelian_tanggal" id="pembelian_tanggal" class="form-control">
								</div>
							</td>
							<td>&nbsp;&nbsp;</td>
							<td>
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<select class="form-control" style="width: 300px;" name="pembelian_supplier" id="pembelian_supplier">
										<option value="">Pilih Supplier</option>
									</select>
								</div>
							</td>
							<td>&nbsp;&nbsp;</td>
							<td valign="top">
								<button id="btn_tambah" onclick="openformimportop()" class="btn btn-info btn-sm" type="button">
									<i class="fa fa-check"></i>
									&nbsp;&nbsp;Import OP
								</button>
							</td>
							<td>&nbsp;&nbsp;</td>
							<td valign="top">
								<!-- <button id="btn_cetak" onclick="CetakBarangSupplier()" class="btn btn-success btn-sm" type="button">
									<i class="fa fa-print"></i>
									&nbsp;&nbsp;Cetak Barang
								</button> -->
							</td>
						</tr>
						<tr>
							<td>
								<div class="form-group">
									<label class="radio-inline">
										<input onclick="changeModePembayaran()" id="pembelian_status_pembayaranT" type="radio" checked="" value="T" name="pembelian_status_pembayaran"> Tunai
									</label>
									<label class="radio-inline">
										<input onclick="changeModePembayaran()" id="pembelian_status_pembayaranK" type="radio" checked="checked" value="K" name="pembelian_status_pembayaran"> Kredit
									</label>
									<!--<label class="radio-inline">
										<input id="pembelian_is_bkl" type="checkbox" name="pembelian_is_bkl"> BKL
									</label>-->
								</div>
							</td>
							<td>&nbsp;</td>
							<td id="group_pembelian_jatuh_tempo">
								Jatuh Tempo :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</span>
									<input type="text" style="width: 200px;" placeholder="Tanggal Jatuh Tempo" name="pembelian_jatuh_tempo" id="pembelian_jatuh_tempo" class="form-control">
								</div>
							</td>
							<td>&nbsp;</td>
							<td>
								<div class="form-group input-group">
									No Referensi :
									<input type="text" name="pembelian_no_ref" id="pembelian_no_ref" class="form-control" />
								</div>
							</td>
						</tr>
					</table>
					<input type="hidden" name="bukti_od" id="bukti_od" />
					<table style="width: 100%; margin-bottom: 5px; margin-top: 5px;">
						<tr>
							<td width="250px">Barang :</td>
							<td>&nbsp;&nbsp;</td>
							<td width="150px">Harga Terakhir :</td>
							<td>&nbsp;&nbsp;</td>
							<td>Stok Akhir :</td>
							<td>&nbsp;&nbsp;</td>
							<td width="150px">
								Harga :
								<input type="checkbox" name="pembelian_include" checked onchange="HitungJumlah()" id="pembelian_include" />
								Termasuk PPN
							</td>
							<td>&nbsp;&nbsp;</td>
							<td width="150px">Kwt :</td>
						</tr>
						<tr>
							<td width="250px">
								<!-- <input type="text" class="form-control" name="pembelian_barang" id="pembelian_barang" /> -->
								<input type="text" class="form-control" onkeypress="return keyEnterBarang(event)" style="width: 250px;" name="pembelian_barang_barcode" id="pembelian_barang_barcode" />
								<input type="text" class="form-control" readonly style="width: 250px;" name="pembelian_barang_nama" id="pembelian_barang_nama" />
							</td>
							<td>&nbsp;&nbsp;</td>
							<td><input type="text" style="text-align: right;" readonly class="form-control" name="pembelian_harga_terakhir" id="pembelian_harga_terakhir" /></td>
							<td>&nbsp;&nbsp;</td>
							<td><input type="text" style="text-align: right; width: 100px;" readonly class="form-control" name="pembelian_stok_akhir" id="pembelian_stok_akhir" /></td>
							<td>&nbsp;&nbsp;</td>
							<td><input type="text" style="text-align: right;width: 175px;" class="form-control" onkeyup="HitungJumlah()" onkeypress="return keyEnterNext(event, 'pembelian_kwt')" name="pembelian_harga" id="pembelian_harga" /></td>
							<td>&nbsp;&nbsp;</td>
							<td><input type="text" value="0" style="text-align: right; width: 100px;" onkeyup="HitungJumlah()" class="form-control" onkeypress="return keyEnterNext(event, 'pembelian_diskon')" name="pembelian_kwt" id="pembelian_kwt" /></td>
						</tr>
						<tr>
							<td width="250px">&nbsp;</td>
							<td>&nbsp;&nbsp;</td>
							<td>Jumlah : 
							</td>
							<td>&nbsp;&nbsp;</td>
							<td>
								Diskon (%) :
							</td>
							<td>&nbsp;&nbsp;</td>
							<td><input type="checkbox" name="pembelian_is_ppn" onchange="HitungJumlah()" id="pembelian_is_ppn" checked="checked" />
								PPn :</td>
							<td>&nbsp;&nbsp;</td>
							<td>&nbsp;&nbsp;</td>
						</tr>
						<tr>
							<td width="250px">&nbsp;</td>
							<td>&nbsp;&nbsp;</td>
							<td><input type="text" style="text-align: right;" class="form-control" onkeyup="HitungperSatuan()" value="0" name="pembelian_jumlah" onkeypress="return keyEnterNext(event, 'pembelian_diskon')" id="pembelian_jumlah" /></td>
							<td>&nbsp;&nbsp;</td>
							<td><input type="text" style="text-align: right;" onkeyup="HitungJumlahPpn()" value="0" class="form-control" name="pembelian_diskon" onkeypress="return keyEnterNext(event, '')" id="pembelian_diskon" /></td>
							<td>&nbsp;&nbsp;</td>
							<td><input type="text" style="text-align: right;" readonly class="form-control" name="pembelian_ppn" id="pembelian_ppn" /></td>
							<td>&nbsp;&nbsp;</td>
							<td>
								<button id="btn_tambah_barang" onclick="TambahBarangOP();" class="btn btn-success btn-sm" type="button">
									<i class="fa fa-plus"></i>
									&nbsp;&nbsp;Tambah
								</button>
							</td>
						</tr>
					</table>
					<div id="progress-data" style="display: none;">
						<div class="progress progress-striped active">
							<div class="progress-bar progress-bar-info" style="width: 20%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="20" role="progressbar">
								<span class="sr-only">20% Complete</span>
							</div>
						</div>
					</div>
					<hr/>
					<table style="width: 100%" id="table-dummy-pembelian" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th class="text-center">KD Barang</th>
								<th class="text-center">Nama Barang</th>
								<th class="text-center">Satuan</th>
								<th class="text-center">Stok DC</th>
								<th class="text-center">Kwt OP</th>
								<th class="text-center">Kwt BI</th>
								<th class="text-center">Harga</th>
								<th class="text-center">Diskon</th>
								<th class="text-center">Jumlah</th>
								<th class="text-center">PPn</th>
								<th class="text-center">Total</th>
								<th class="text-center">Aksi</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
					<table style="width: 20%; margin-bottom: 5px; margin-top: 5px;">
						<tr>
							<td width="50">DPP</td>
							<td width="10"> : </td>
							<td width="100" id="total_dpp" align="right"></td>
						</tr>
						<tr>
							<td>PPN</td>
							<td> : </td>
							<td id="total_ppn" align="right"></td>
						</tr>
						<tr>
							<td>Total</td>
							<td> : </td>
							<td id="total_all" align="right"></td>
						</tr>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" onclick="clearForm()" class="btn btn-default">Reset</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<img src="<?= base_url() ?>/images/loader.gif" id="loader-form"  style="width: 30px; display: none;" />
			        <button type="button" id="btn-simpan" onclick="simpanpembelian()" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;&nbsp;Simpan</button>
				</div>
			</div>
		</div>
	</div>
	
	<!-- Popup form untuk piiih OP -->
	<div class="modal fade" id="form-list-op" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        			<h4 class="modal-title" id="myModalLabel">List Order Pembelian (OP)</h4>
				</div>
				<div class="modal-body">
					<table style="margin-bottom: 5px;">
						<tr>
							<td style="width: 125px;">
								<input style="width: 115px;" type="text" name="list_pembelian_tahun" id="list_pembelian_tahun" value="<?= date("Y"); ?>" class="form-control" />
							</td>
							<td style="width: 125px;">
								<select style="width: 115px;" class="form-control" name="list_pembelian_bulan" id="list_pembelian_bulan">
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
								<button id="btn_upload" onclick="loadListOP()" class="btn btn-info" type="button">
									<i class="fa fa-search"></i>
									&nbsp;&nbsp;Search
								</button>
							</td>
						</tr>
					</table>
					<div id="list_op"></div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal fade" id="form-transfer-ketoko" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        			<h4 class="modal-title" id="myModalLabel">Form Transfer Ke Toko</h4>
				</div>
				<div class="modal-body">
					Bukti BI :
					<div class="form-group input-group">
						<span class="input-group-addon">
							<i class="fa fa-calendar"></i>
						</span>
						<input type="text" readonly name="transfer_bukti_bi" id="transfer_bukti_bi" class="form-control">
					</div>
					Toko :
					<div class="form-group input-group">
						<span class="input-group-addon">
							<i class="fa fa-file"></i>
						</span>
						<select class="form-control" name="transfer_toko_kode" id="transfer_toko_kode">
							<option value="-1">Pilih Toko</option>
						</select>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<img src="<?= base_url() ?>/images/loader.gif" id="loader-form-transfer"  style="width: 30px; display: none;" />
			        <button type="button" id="btn-simpan-transfer" onclick="SimpanTransferToko()" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;&nbsp;Simpan</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Popup form untuk edit kwt -->
	<div class="modal fade" id="form-edit-kwt" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        			<h4 class="modal-title" id="myModalLabel">Form Edit Pengadaan Barang</h4>
				</div>
				<div class="modal-body">
					Barang :
					<div class="form-group input-group">
						<span class="input-group-addon">
							<i class="fa fa-file"></i>
						</span>
						<input type="text" name="pembelian_edit_nama_barang" id="pembelian_edit_nama_barang" class="form-control">
					</div>
					Harga :
					<input type="checkbox" name="pembelian_edit_include" onchange="HitungJumlahEdit()" checked id="pembelian_edit_include" />
					Termasuk PPN
					<div class="form-group input-group">
						<span class="input-group-addon">
							<i class="fa fa-money"></i>
						</span>
						<input type="hidden" style="text-align: right;" name="pembelian_edit_barang_kode" id="pembelian_edit_barang_kode" class="form-control">
						<input type="text" style="text-align: right;" onkeyup="HitungJumlahEdit()" name="pembelian_edit_harga" id="pembelian_edit_harga" class="form-control">
					</div>
					KWT :
					<div class="form-group input-group">
						<span class="input-group-addon">
							<i class="fa fa-money"></i>
						</span>
						<input type="text" style="text-align: right;" onkeyup="HitungJumlahEdit()" value="0" name="pembelian_edit_kwt" id="pembelian_edit_kwt" class="form-control">
					</div>
					Jumlah :
					<div class="form-group input-group">
						<span class="input-group-addon">
							<i class="fa fa-money"></i>
						</span>
						<input type="text" style="text-align: right;" value="0" onkeyup="HitungperSatuanEdit()" name="pembelian_edit_jumlah" id="pembelian_edit_jumlah" class="form-control">
					</div>
					Diskon (%) :
					<div class="form-group input-group">
						<span class="input-group-addon">
							<i class="fa fa-money"></i>
						</span>
						<input type="text" style="text-align: right;" onkeyup="HitungJumlahPpnEdit()" value="0" name="pembelian_edit_diskon" id="pembelian_edit_diskon" class="form-control">
					</div>
					<input type="checkbox" name="pembelian_edit_is_ppn" onchange="HitungJumlahEdit()" id="pembelian_edit_is_ppn" />
					PPN :
					<div class="form-group input-group">
						<span class="input-group-addon">
							<i class="fa fa-money"></i>
						</span>
						<input readonly type="text" style="text-align: right;" value="0" name="pembelian_edit_ppn" id="pembelian_edit_ppn" class="form-control">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" onclick="clearForm(2)" class="btn btn-default">Reset</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<img src="<?= base_url() ?>/images/loader.gif" id="loader-form"  style="width: 30px; display: none;" />
			        <button type="button" id="btn-simpan" onclick="SimpanEditKwt()" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;&nbsp;Simpan</button>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		OpenMenu();
		
		LoadDataPembelianBarang();
		// LoadListDataBarang();
		loadListSupplier();
		loadListToko();
		
		$('#pembelian_jatuh_tempo').datepicker({
			format: 'yyyy-mm-dd'
		});
		$('#pembelian_tanggal').datepicker({
			format: 'yyyy-mm-dd'
		});
		$('#search_tanggal_awal').datepicker({
			format: 'yyyy-mm-dd'
		});
		$('#search_tanggal_akhir').datepicker({
			format: 'yyyy-mm-dd'
		});
		
		$('.ask').jConfirmAction();
		
		$('.datepicker tbody').on('click', function(){  $('.datepicker').hide() });

		$("#pembelian_barang_barcode").focus();
	});
	
	function changeModePembayaran(){
		var mode = $("input[name=pembelian_status_pembayaran]:checked").val();
		
		if(mode == "K"){
			$("#pembelian_jatuh_tempo").val("");
			$("#group_pembelian_jatuh_tempo").show();
		}else{
			$("#pembelian_jatuh_tempo").val("");
			$("#group_pembelian_jatuh_tempo").hide();
			$("#pembelian_is_ppn").removeAttr("checked", "checked");
		}
	}

	function keyEnterBarang(event){
	    if (event.which == 13 || event.keyCode == 13) {
	        $.ajax({
	        	type: "POST",
	        	url: "<?php echo base_url(); ?>index.php/barang/gethargabarangsupplier",
	        	data: "barang_kode="+$("#pembelian_barang_barcode").val(),
	        	success: function(msg){
	        		if(msg == ""){
	        			alert("barang tidak ditemukan / harga beli supplier belum ada");
	        			// $("#pembelian_barang").show();
	        			// LoadListDataBarang();
	        			// $("#pembelian_barang_barcode").hide();
	        		}else{
						var result = msg.split("_wecode_");
						$("#pembelian_barang_barcode").val(result[2])
						$("#pembelian_harga_terakhir").val(result[0]);
						$("#pembelian_harga").val(result[0]);
						// price("pembelian_harga_beli");
						$("#pembelian_kwt").val(1);
						
						$("#pembelian_ppn").val(result[1]);
						// price("pembelian_ppn_beli");
						$("#pembelian_barang_nama").val(result[3]);
						// if(result[1] == "0"){
						// 	$("#pembelian_is_ppn").prop("checked", false);
						// }else{
						// 	$("#pembelian_is_ppn").prop("checked", true);
						// }
						
						$("#pembelian_stok_akhir").val(result[4]);
						$("#pembelian_harga").focus();
						$("#pembelian_harga").select();
						HitungJumlah();
					}
				}
	        });
	        return false;
	    }
	    return true;
	}

	// function keyEnterAddItem(event){
	// 	if (event.which == 13 || event.keyCode == 13) {
	//         tambahitem();
	//         return false;
	//     }
	//     return true;
	// }

	function keyEnterNext(event, selector){
		if (event.which == 13 || event.keyCode == 13) {
	       	if(selector == ""){
	       		TambahBarangOP("");
	       	}else{
		       	$("#"+selector).focus();
				$("#"+selector).select();
			}
	       	return false;
	    }
	    return true;
	}
	
	function loadListToko(){
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/toko/getListToko",
			data: "",
			success: function(msg){
				$("#transfer_toko_kode").html(msg);
			}
		});
	}
	
	function loadListSupplier(){
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/supplier/getselectsupplier",
			data: "",
			success: function(msg){
				$("#pembelian_supplier").html(msg);
				$("#pembelian_supplier").select2();
			}
		});
	}
	
	function LoadListDataBarang(){
	    $("#pembelian_barang").select2({
		    placeholder: "Cari bahan baku",
		    minimumInputLength: 1,
		    ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
			    url: "<?php echo base_url(); ?>index.php/barang/getlistbarang",
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
            	return "<span class=\"select2-match\"></span>"+option.kode+" - "+option.nama_barang;
            }, 
		    formatSelection: function (option) {
            	return option.nama_barang;
            }
	    });
	    
	    $("#pembelian_barang").on("select2-selecting", function(e) {
	    	// dataperlang = e;
	    	// alert ("selecting val="+ e.choice.satuan_terkecil +" choice="+ JSON.stringify(e.choice));
			$("#satuan").val(e.choice.satuan);
	    });
	}
	
	function LoadDataPembelianBarang(){
		$('#progres-main').show();
		
		var is_bkl = '0';
		if($("#search_is_bkl").is(':checked')){
			is_bkl = '1';
		}
		
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/pembelianbarang/getdatapembelianbarang",
			data: "tanggal_awal="+$('#search_tanggal_awal').val()+"&tanggal_akhir="+$('#search_tanggal_akhir').val()+"&is_bkl="+is_bkl,
			success: function(msg){
				$(".table-pembelian-barang").html(msg);
				//table = $('#dataTables-pembelian-barang').dataTable();
				$('#progres-main').hide();
				
				$('#dataTables-pembelian-barang tbody').on( 'click', 'tr', function () {
			        if ( $(this).hasClass('active') ) {
			            $(this).removeClass('active');
			        }else {
			            $('#dataTables-pembelian-barang tr.active').removeClass('active');
			            $(this).addClass('active');
			        }
			    } );
			}
		});
	}
	
	function openFormPembelianBarang(mode){
		if(mode == 1){ // untuk tambah
			$("#form-pembelian-barang").modal("show");
			$("#pembelian_mode").val("i");
			$("#bukti_op").val("");

			getTanggalJatuhTempo();
		}
	}
	
	function openformtambahitem(isopen){
		if(isopen == 1){ // open form
			// $("#form-tambah-barang").show();
			// $("#btn-tambah-barang").hide();
		}else{ // close form
			// $("#form-tambah-barang").hide();
			// $("#btn-tambah-barang").show();
		}
	}
	
	function hitungpembelianjumlah(){
		var nilai_konversi = $("#nilai_konversi").val();
		// var harga = removeCurrency($("#pembelian_harga_beli").val());
		var harga = $("#pembelian_harga_beli").val();
		var kwt = $("#pembelian_kwt").val();
		
		if(harga == "") harga = 0;
		if(kwt == "") kwt = 0;
		
		var ppn = 0;
		
		if($('#pembelian_is_ppn').is(':checked')){
			ppn = parseFloat(harga) * 0.11; //k3pg-ppn
		}else{
			ppn = 0;
		}
		
		var totalHarga = (parseFloat(harga) + ppn) * parseFloat(kwt);
		
		var kwt_kecil = kwt * nilai_konversi;
		$("#pembelian_ppn_beli").val(ppn);
		$("#pembelian_jumlah").val(totalHarga);
		$("#pembelian_kwt_kecil").val(kwt_kecil);
		
		// price_js('pembelian_ppn_beli');
		price_js('pembelian_jumlah');
	}
	
	// function tambahitem(){
	// 	// var kd_item = $("#pembelian_barang").select2("val");
	// 	var kd_item = $("#pembelian_barang_barcode").val();
	// 	// var nama_item = $("#s2id_pembelian_barang .select2-chosen").html();
	// 	var nama_item = $("#pembelian_barang_nama").val();
		
	// 	var harga_beli = $("#pembelian_harga_beli").val();
	// 	// var harga_beli = removeCurrency($("#pembelian_harga_beli").val());
	// 	var kwt = $("#pembelian_kwt").val();
	// 	var satuan = $("#satuan").val();
	// 	// var ppn_beli = removeCurrency($("#pembelian_ppn_beli").val());
	// 	var ppn_beli = $("#pembelian_ppn_beli").val();
	// 	var jumlah = removeCurrency($("#pembelian_jumlah").val());
		
	// 	var row = "<tr><td>"+kd_item+"</td><td>"+nama_item+"</td><td>"+satuan+"</td><td class=\"text-right\">"+kwt+"</td><td class=\"text-right\">"+kwt+"</td><td class=\"text-right\">"+0+"</td><td class=\"text-right\">"+harga_beli+"</td><td class=\"text-right\">"+0+"</td><td class=\"text-right\">"+ppn_beli+"</td><td class=\"text-right\">"+jumlah+"</td><td><button type=\"button\" onclick=\"HapusRow(this)\" class=\"btn btn-default\"><i class=\"fa fa-times\"></i></button></td></tr>";
		
	// 	$('#table-dummy-pembelian > tbody:last').append(row);

	// 	HitungTotalAll();
		
	// 	clearForm(4);
	// 	openformtambahitem(0);
	// }

	function TambahBarangOP(satuan){
		// var kd_barang = $("#pembelian_barang").val();
		var kd_barang = $("#pembelian_barang_barcode").val();
		// var nama_barang = $("#s2id_pembelian_barang .select2-chosen").html();
		var nama_barang = $("#pembelian_barang_nama").val();
		var kwt = $("#pembelian_kwt").val();
		var harga = $("#pembelian_harga").val();
		var diskon = $("#pembelian_diskon").val();
		var ppn = $("#pembelian_ppn").val();
		var stokdc = $("#pembelian_stok_akhir").val();
		var jumlah = $("#pembelian_jumlah").val();
		var total = 0;
		
		if($('#pembelian_include').is(':checked')){ // include ppn
			harga = (parseFloat(harga) / 1.11); //k3pg-ppn
		}else{ // exclude ppn
			
		}
		var nilai_diskon = (parseFloat(harga) * (parseFloat(diskon)/100));
		jumlah = ((parseFloat(harga) - nilai_diskon) * parseFloat(kwt));
		total = jumlah + (parseFloat(ppn) * parseFloat(kwt));
		var row = "<tr><td>"+kd_barang+"</td><td>"+nama_barang+"</td><td>"+satuan+"</td><td class=\"text-right\">"+stokdc+"</td><td class=\"text-right\">0</td><td class=\"text-right\">"+kwt+"</td><td class=\"text-right\">"+harga+"</td><td class=\"text-right\">"+diskon+"</td><td class=\"text-right\">"+round(jumlah,2)+"</td><td class=\"text-right\">"+ppn+"</td><td class=\"text-right\">"+round(total,2)+"</td><td class=\"text-center\"><!--<button type=\"button\" onclick=\"Editkwt('"+kd_barang+"', '"+nama_barang+"', '"+kwt+"', '"+diskon+"')\" class=\"btn btn-warning btn-sm\"><i class=\"fa fa-edit\"></i>--></button><button type=\"button\" onclick=\"HapusRow(this); HitungTotalAll();\" class=\"btn btn-danger btn-sm\"><i class=\"fa fa-times\"></i></button></td></tr>";
		$('#table-dummy-pembelian > tbody:last').append(row);
		
		HitungTotalAll();

		$("#pembelian_kwt").val("0");
		$("#pembelian_harga").val("0");
		$("#pembelian_harga_terakhir").val("0");
		// $("#pembelian_diskon").val("0");
		$("#pembelian_ppn").val("0");
		$("#pembelian_stok_akhir").val("0");
		$("#pembelian_jumlah").val("0");

		$("#pembelian_barang_barcode").val("");
		$("#pembelian_barang_nama").val("");
		$("#pembelian_barang_barcode").focus();
	}
	
	function simpanpembelian(){
		$('#btn-simpan').hide();
		$('#loader-form').show();
		
		var dataArr = [];
	    $("#table-dummy-pembelian td").each(function(){
	        dataArr.push($(this).html());
	    });
	    
		var pembelian_mode = $("#pembelian_mode").val();
		
		if($("#pembelian_supplier").select2("val") != "" && $("#pembelian_supplier").select2("val") != null){
			if(pembelian_mode == "i"){
				var modeBukti = "BI";
				
				var tanggal_pembelian = $("#pembelian_tanggal").val();
				$.ajax({
					type: "POST",
					url: "<?= base_url() ?>index.php/bukti/generatebukti",
					data: "mode="+modeBukti+"&tanggal="+tanggal_pembelian,
					success: function(msg){
						var jsonData = rawurlencode(json_encode(dataArr));
						SimpanDetailPembelian(msg, jsonData);
					}
				});
			}else{
				var bukti = $("#pembelian_bukti").val();
				$.ajax({
					type: "POST",
					url: "<?= base_url(); ?>index.php/pembelianbarang/hapuspembelianbarang",
					data: "bukti="+bukti,
					success: function(msg){
						var jsonData = rawurlencode(json_encode(dataArr));
						SimpanDetailPembelian(bukti, jsonData);
					}
				});
			}
		}else{
			alert("supplier belum diisi");
			$('#btn-simpan').show();
			$('#loader-form').hide();
		}
	}
	
	function SimpanDetailPembelian(bukti, jsondata){
		var supplier = $("#pembelian_supplier").val().split("-");
		var supplier_kode = supplier[0];
		var status_pembayaran = $("input[name=pembelian_status_pembayaran]:checked").val();
		var jatuh_tempo = $("#pembelian_jatuh_tempo").val();
		var tanggal_pembelian = $("#pembelian_tanggal").val();
		var pembelian_mode = $("#pembelian_mode").val();
		var bukti_op = $("#bukti_op").val();
		var no_ref = $("#pembelian_no_ref").val();
		var is_bkl = '0';
		// if($("#pembelian_is_bkl").is(':checked')){
		// 	is_bkl = '1';
		// }
		
		$.ajax({
			type: "POST",
			url: "<?= base_url(); ?>index.php/pembelianbarang/simpanpembelianbarang",
			data: "data="+jsondata+"&bukti="+bukti+"&supplier_kode="+base64_encode(supplier_kode)+"&status_pembayaran="+status_pembayaran+"&jatuh_tempo="+jatuh_tempo+"&tanggal="+tanggal_pembelian+"&pembelian_mode="+pembelian_mode+"&ref_op="+bukti_op+"&is_bkl="+is_bkl+"&no_ref="+no_ref,
			success: function(msg){
				$('#btn-simpan').show();
				$('#loader-form').hide();
				clearForm(2);
				$('#form-pembelian-barang').modal('hide');
				
				ShowMessage('success', 'Data berhasil disimpan');
				LoadDataPembelianBarang();
			},
			error: function(xhr,status,error){
				alert(status);
				$('#btn-simpan').show();
				$('#loader-form').hide();
			}
		});
	}
	
	function pilihbuktium(select2_id, container_id){
		var jumlah_um = $("#"+select2_id).val().split("-");
		var um = jumlah_um[1];
		if(um == "1" || um == ""){
			um = 0;
		}
		$("#"+container_id).val(um);
		price_js(container_id);
	}
	
	function HapusPembelianBarang(){
		var data_obj = $('#dataTables-pembelian-barang tr.active').attr("data");
		
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			var TanggalArr = data['tanggal'].split("-");
			var Today = new Date();
			var TanggalData = new Date();
			var newDate = parseFloat(TanggalArr[2]) + 3;
			
			//TanggalData.setFullYear(TanggalArr[0], TanggalArr[1]-1, newDate);
			// if(parseFloat(TanggalArr[1]) == parseFloat(TanggalData.getMonth()+1) && (data['tukar_nota_bukti'] == '' || data['tukar_nota_bukti'] == null)){
				$('#progres-main').show();
				$.ajax({
					type: "POST",
					url: "<?= base_url(); ?>index.php/pembelianbarang/hapuspembelianbarang",
					data: "bukti="+data['bukti'],
					success: function(msg){
						ShowMessage("success", "Data berhasil dihapus");
						LoadDataPembelianBarang();
					}
				});
			// }else{
			// 	alert("Transaksi sudah melewati bulan atau Sudah di TT kan");
			// }
		}
	}
	
	function cetakNotaPembelian(){
		var data_obj = $('#dataTables-pembelian-barang tr.active').attr("data");
		
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			var bukti = data['bukti'];
			window.open('<?= base_url('index.php/pembelianbarang/cetakbi?') ?>bukti='+bukti,'_blank');
			window.open('<?= base_url('index.php/pembelianbarang/cetakretur?') ?>bukti='+bukti,'_blank');
		}
	}
	
	function HapusRow(DataObj){
		dataobj = DataObj;
		$(DataObj).parent().parent().remove();

		HitungTotalAll();
	}
	
	function openFormEditPembelian(){
		var data_obj = $('#dataTables-pembelian-barang tr.active').attr("data");
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			
			var TanggalArr = data['tanggal'].split("-");
			var Today = new Date();
			var TanggalData = new Date();
			var newDate = parseFloat(TanggalArr[2]) + 3;
			
			//TanggalData.setFullYear(TanggalArr[0], TanggalArr[1]-1, newDate);
			// if(parseFloat(TanggalArr[1]) == parseFloat(TanggalData.getMonth()+1) && (data['tukar_nota_bukti'] == '' || data['tukar_nota_bukti'] == null)){
				$("#pembelian_mode").val("e");
				$("#pembelian_bukti").val(data['bukti']);
				$("#pembelian_tanggal").val(data['tanggal']);
				$("#pembelian_tanggal").prop("readonly", "readonly");
				$("#pembelian_supplier").select2("val", data['supplier_kode']);
				$("#pembelian_supplier").prop("disabled", true);
				if(data['status_pembayaran'] == "K"){
					$("#pembelian_status_pembayaranK").prop("checked", "checked");
					$("#pembelian_status_pembayaranT").removeAttr("checked");
				}else{
					$("#pembelian_status_pembayaranT").prop("checked", "checked");
					$("#pembelian_status_pembayaranK").removeAttr("checked");
				}
				$("#bukti_op").val(data['ref_op']);
				$("#pembelian_no_ref").val(data['no_ref']);
				
				$.ajax({
					type: "POST",
					url: "<?= base_url() ?>index.php/pembelianbarang/getdatabarangbi",
					data: "bukti="+data['bukti'],
					success: function(msg){
						$("#table-dummy-pembelian tbody").html(msg);
						HitungTotalAll();
					}
				});
				
				$("#form-pembelian-barang").modal("show");
			// }else{
			// 	alert("Transaksi sudah melewati bulan atau Sudah di TT kan");
			// }
		}
	}
	
	function PilihSupplier(){
		var supplier_kode = $("#pembelian_supplier").val();
		if(supplier_kode == "0000446"){
			$("#pembelian_status_pembayaranT").prop("checked", "checked");
			$("#pembelian_status_pembayaranK").removeAttr("checked");
		}
	}
	
	function openformimportop(){
		$("#form-list-op").modal("show");
		
		loadListOP();
	}
	
	function loadListOP(){
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/orderpembelian/listpilihop",
			data: "tahun="+$("#list_pembelian_tahun").val()+"&bulan="+$("#list_pembelian_bulan").val()+"&supplier_kode="+base64_encode($("#pembelian_supplier").val()),
			success: function(msg){
				$("#list_op").html(msg);
			}
		});
	}
	
	function PilihOP(bukti){
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/orderpembelian/getdatabarangop",
			data: "bukti="+bukti,
			success: function(msg){
				$("#bukti_op").val(bukti);
				$("#table-dummy-pembelian tbody").html(msg);
				
				$("#form-list-op").modal("hide");

				HitungTotalAll();
			}
		});
	}
	
	function ApproveBKL(){
		var data_obj = $('#dataTables-pembelian-barang tr.active').attr("data");
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			$.ajax({
				type: "POST",
				url: "<?= base_url() ?>index.php/pembelianbarang/approvebkl",
				data: "bukti="+data['bukti'],
				success: function(msg){
					LoadDataPembelianBarang();
				}
			});
		}
	}
	
	function SimpanTransferToko(){
		$("#loader-form-transfer").show();
		$("#btn-simpan-transfer").hide();
			
		var data_obj = $('#dataTables-pembelian-barang tr.active').attr("data");
		var data = json_decode(base64_decode(data_obj));
		
		var toko_kode = $("#transfer_toko_kode").val();
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/pembelianbarang/simpantransferketoko",
			data: "bukti_bi="+data['bukti']+"&tanggal="+data['tanggal']+"&toko_kode="+toko_kode,
			success: function(msg){
				var buktiTG = "";
				if(msg.substring(0, 1) == "S"){
					alert("BI sudah ditransfer ke toko");
					buktiTG = msg.substring(1);
				}else{
					alert("Berhasil ditransfer ke Toko dengan bukti "+msg);
					buktiTG = msg;
				}
				window.open('<?= base_url('index.php/transfergudang/cetaktg?') ?>bukti='+buktiTG,'_blank');
				$("#form-transfer-ketoko").modal("hide");
			}
		});
	}
	
	// function Editkwt(barang_kode){
	// 	$("#retur_edit_"+barang_kode).show();
	// 	$("#btn_edit_kwt_"+barang_kode).show();
	// 	$("#btn_cancel_edit_kwt_"+barang_kode).show();
		
	// 	$("#btnopen_"+barang_kode).hide();
	// 	$("#retur_edit_"+barang_kode).focus();
	// }
	
	function CancelEditkwt(barang_kode){
		$("#retur_edit_"+barang_kode).hide();
		$("#btn_edit_kwt_"+barang_kode).hide();
		$("#btn_cancel_edit_kwt_"+barang_kode).hide();
		
		$("#btnopen_"+barang_kode).show();
	}
	
	function SimpanEditRetur(barang_kode){
		var kwt_op = $("#kwt_"+barang_kode).html();
		var bi_datang = $("#retur_edit_"+barang_kode).val();
		if(bi_datang == ""){
			bi_datang = 0;
		}
		var kwt = parseFloat(bi_datang);
		var harga_asli = $("#harga_"+barang_kode).html();
		var diskon = $("#diskon_"+barang_kode).html();
		var nilaidiskon = parseFloat(harga_asli) * (parseFloat(diskon) / 100);
		var harga = parseFloat(harga_asli) - parseFloat(nilaidiskon);
		var ppn = $("#ppn_"+barang_kode).html();
		var jumlah = parseFloat(kwt) * (parseFloat(harga) + parseFloat(ppn));
		var retur = parseFloat(kwt_op) - parseFloat(bi_datang);
		$("#retur_"+barang_kode).html(retur);
		$("#jumlah_"+barang_kode).html(jumlah);
		$("#kwt_datang_"+barang_kode).html(bi_datang);
		
		CancelEditkwt(barang_kode);

		HitungTotalAll();
	}
	
	function OpenFormTransferkeToko(){
		var data_obj = $('#dataTables-pembelian-barang tr.active').attr("data");
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			$("#form-transfer-ketoko").modal("show");
			$("#transfer_bukti_bi").val(data['bukti']);
			
			$("#loader-form-transfer").hide();
			$("#btn-simpan-transfer").show();
		}
	}
	
	function CetakPembelianBarang(){
		var tanggal_awal = $("#search_tanggal_awal").val();
		var tanggal_akhir = $("#search_tanggal_akhir").val();
		window.open('<?= base_url('index.php/pembelianbarang/getrekappembelianbarang?') ?>tanggal_awal='+tanggal_awal+'&tanggal_akhir='+tanggal_akhir,'_blank');
	}

	function CetakPembelianBarangExcel(){
		var tanggal_awal = $("#search_tanggal_awal").val();
		var tanggal_akhir = $("#search_tanggal_akhir").val();
		window.open('<?= base_url('index.php/pembelianbarang/getrekappembelianbarang_xls?') ?>tanggal_awal='+tanggal_awal+'&tanggal_akhir='+tanggal_akhir,'_blank');
	}

	function HitungJumlahEdit(){
		var kwt = $("#pembelian_edit_kwt").val();
		var harga = $("#pembelian_edit_harga").val();
		
		var jumlah = parseFloat(harga) * parseFloat(kwt);
		
		$("#pembelian_edit_jumlah").val(round(jumlah,2));
		
		HitungJumlahPpnEdit();
	}

	function HitungperSatuanEdit(){
		var kwt = $("#pembelian_edit_kwt").val();
		var harga = 0;
		var jumlahHarga = $("#pembelian_edit_jumlah").val();
		
		harga = parseFloat(jumlahHarga) / parseFloat(kwt);
		$("#pembelian_edit_harga").val(harga);
		HitungJumlahPpnEdit();
	}

	function HitungJumlahPpnEdit(){
		var ppn = 0;
		var dpp = 0;
		var diskon = $("#pembelian_edit_diskon").val();
		var harga = $("#pembelian_edit_harga").val();
		var nilai_diskon = parseFloat(harga) * (parseFloat(diskon)/100);
		dpp = parseFloat(harga) - nilai_diskon;
		if($('#pembelian_edit_is_ppn').is(':checked')){
			if($('#pembelian_edit_include').is(':checked')){
				dpp = dpp / 1.11; //k3pg-ppn
				ppn = parseFloat(dpp) * 0.11; //k3pg-ppn
			}else{
				ppn = parseFloat(dpp) * 0.1; //k3pg-ppn
			}
		}
		
		$("#pembelian_edit_ppn").val(ppn);
	}

	function Editkwt(param){
		/*$("#form-edit-table-"+barang_kode).show();
		
		$("#kwt_edit_"+barang_kode).val($("#kwt_"+barang_kode).html());
		$("#ppn_edit_"+barang_kode).val($("#ppn_"+barang_kode).html());
		if($("#ppn_"+barang_kode).html() == "0" || $("#ppn_"+barang_kode).html() == ""){
			$("#ppn_edit_"+barang_kode).removeAttr("checked");
		}else{
			$("#ppn_edit_"+barang_kode).prop("checked", "checked");
		}*/
		//$("#btn_edit_kwt_"+barang_kode).show();
		//$("#btn_cancel_edit_kwt_"+barang_kode).show();
		var paramArr = json_decode(base64_decode(param));
		kwt = $("#kwt_"+paramArr['barang_kode']).html();
		var harga = $("#harga_"+paramArr['barang_kode']).html();
		var ppn = $("#ppn_"+paramArr['barang_kode']).html();
		var total = $("#jumlah_"+paramArr['barang_kode']).html();
		var hargainclude = parseFloat(harga) + parseFloat(ppn);
		// alert(total);
		$("#pembelian_edit_nama_barang").val(paramArr['nama_barang']);
		$("#pembelian_edit_harga").val(hargainclude);
		$("#pembelian_edit_include").prop('checked', true);
		$("#pembelian_edit_barang_kode").val(paramArr['barang_kode']);
		$("#pembelian_edit_kwt").val(kwt);
		$("#pembelian_edit_diskon").val(paramArr['diskon1']);
		$("#pembelian_edit_jumlah").val(total);
		
		var ppn = parseFloat($("#ppn_"+paramArr['barang_kode']).html());
		if(ppn == 0){
			$("#pembelian_edit_is_ppn").removeAttr("checked");
		}else{
			$("#pembelian_edit_is_ppn").prop("checked", "checked");
			$("#pembelian_edit_ppn").val(ppn);
		}
		$("#form-edit-kwt").modal("show");
	}
	
	function CancelEditkwt(barang_kode){
		$("#form-edit-table-"+barang_kode).hide();
		//$("#kwt_edit_"+barang_kode).hide();
		//$("#btn_edit_kwt_"+barang_kode).hide();
		//$("#btn_cancel_edit_kwt_"+barang_kode).hide();
	}
	
	function SimpanEditKwt(){
		// var barang_kode = $("#pembelian_edit_barang_kode").val();
		// var kwt = $("#pembelian_edit_kwt").val();
		// var harga = $("#pembelian_edit_harga").val();
		// var diskon = $("#pembelian_edit_diskon").val();
		// var nilaidiskon = parseFloat(harga) * (parseFloat(diskon) / 100);
		// var hargasetelahdiskon = parseFloat(harga) - parseFloat(nilaidiskon);
		// var ppn = $("#pembelian_edit_ppn").val();
		// if($("#pembelian_edit_include").is(':checked')){
		// 	harga = parseFloat(hargasetelahdiskon) / 1.11; //k3pg-ppn
		// 	ppn = (dpp * 0.11); //k3pg-ppn
		// }
		// var jumlah = $("#pembelian_edit_jumlah").val();
		
		// $("#kwt_"+barang_kode).html(kwt);
		// $("#harga_"+barang_kode).html(harga);
		// $("#diskon1_"+barang_kode).html(diskon);
		// $("#ppn_"+barang_kode).html(ppn);
		// $("#jumlah_"+barang_kode).html(jumlah);
		
		//=====================================
		var barang_kode = $("#pembelian_edit_barang_kode").val();
		//var nama_barang = $("#s2id_pembelian_barang .select2-chosen").html();
		var kwt = $("#pembelian_edit_kwt").val();
		var harga = $("#pembelian_edit_harga").val();
		var diskon = $("#pembelian_edit_diskon").val();
		var ppn = $("#pembelian_edit_ppn").val();
		//var stokdc = $("#pembelian_stok_akhir").val();
		var jumlah = $("#pembelian_edit_jumlah").val();
		var total = 0;
		
		if($('#pembelian_edit_include').is(':checked')){ // include ppn
			harga = (parseFloat(harga) / 1.11); //k3pg-ppn
		}else{ // exclude ppn
			
		}
		var nilai_diskon = (parseFloat(harga) * (parseFloat(diskon)/100));
		jumlah = ((parseFloat(harga) - nilai_diskon) * parseFloat(kwt));
		total = jumlah + (parseFloat(ppn) * parseFloat(kwt));
		
		$("#kwt_"+barang_kode).html(kwt);
		$("#harga_"+barang_kode).html(harga);
		$("#diskon1_"+barang_kode).html(diskon);
		$("#jumlah_"+barang_kode).html(round(jumlah,2));
		$("#total_"+barang_kode).html(round(total,2));
		$("#ppn_"+barang_kode).html(ppn);
		
		HitungTotalAll();
		
		$("#form-edit-kwt").modal("hide");
	}
	
	function clearForm(mode){
		switch (mode){
			case 2: // Form input pengadaan
				$("#pembelian_supplier").select2("val", "-1");
				$("#pembelian_barang").select2("val", "");
				$("#pembelian_harga").val("");
				$("#pembelian_kwt").val("");
				$("#pembelian_ppn_beli").val("");
				$("#pembelian_jumlah").val("");
				$("#pembelian_jatuh_tempo").val("");
				$("#pembelian_uang_muka").val("");
				$("#pembelian_bukti_um").select2("val", "-1");
				$("#bukti_op").val("");
				
				$('#table-dummy-pembelian tbody').html("");

				$("#total_dpp").html(number_format(0,2));
				$("#total_ppn").html(number_format(0,2));
				$("#total_all").html(number_format(0,2));
			break;
			case 4: // clear form sehabis add item
				$("#pembelian_barang_barcode").val("");
				$("#pembelian_barang_barcode").focus();
				$("#pembelian_harga_beli").val("");
				$("#pembelian_kwt").val("");
				$("#pembelian_kwt_kecil").val("");
				$("#satuan").val("");
				$("#satuan_kecil").val("");
				$("#pembelian_pph_beli").val("");
				$("#pembelian_ppn_beli").val("");
				$("#pembelian_jumlah").val("");
				$("#pembelian_barang_nama").val("");

			break;
		}
	}

	function HitungTotalAll(){
		var dataArr = [];
	    $("#table-dummy-pembelian td").each(function(){
	        dataArr.push($(this).html());
	    });
		
		var jumlahDPP = 0;
		var jumlahPPN = 0;
		var jumlahTotal = 0;
		for(var i=8;i<dataArr.length;i = i+12){
			jumlahDPP += parseFloat(dataArr[i]);
			jumlahPPN += parseFloat(dataArr[i+1]) * parseFloat(dataArr[i-3]);
			jumlahTotal += parseFloat(dataArr[i+2]);
		}
		
		$("#total_dpp").html(number_format(jumlahDPP,2));
		$("#total_ppn").html(number_format(jumlahPPN,2));
		$("#total_all").html(number_format(jumlahTotal,2));
	}

	function HitungJumlah(){
		var kwt = $("#pembelian_kwt").val();
		var harga = $("#pembelian_harga").val();
		//var diskon = $("#pembelian_diskon").val();
		//var nilaidiskon = parseFloat(hargaasli) * (parseFloat(diskon) / 100);
		//var harga = parseFloat(hargaasli) - nilaidiskon;
		//var ppn = 0;
		
		/*if($('#pembelian_is_ppn').is(':checked')){
			if($('#pembelian_include').is(':checked')){
				var dpp = parseFloat(harga) / 1.11; //k3pg-ppn
				ppn = parseFloat(dpp) * 0.11; //k3pg-ppn
			}else{
				ppn = parseFloat(harga) * 0.11; //k3pg-ppn
			}
		}*/
		var jumlah = parseFloat(harga) * parseFloat(kwt);
		/*var jumlah = 0;
		if($('#pembelian_include').is(':checked')){
			jumlah = parseFloat(kwt) * parseFloat(harga);
		}else{
			jumlah = parseFloat(kwt) * (parseFloat(harga) + parseFloat(ppn));
		}*/
		
		$("#pembelian_jumlah").val(jumlah);
		//$("#pembelian_ppn").val(round(ppn,2));
		HitungJumlahPpn();
	}

	function HitungJumlahPpn(){
		var ppn = 0;
		var dpp = 0;
		var diskon = $("#pembelian_diskon").val();
		var harga = $("#pembelian_harga").val();
		var nilai_diskon = parseFloat(harga) * (parseFloat(diskon)/100);
		dpp = parseFloat(harga) - nilai_diskon;
		if($('#pembelian_is_ppn').is(':checked')){
			if($('#pembelian_include').is(':checked')){
				dpp = dpp / 1.11; //k3pg-ppn
				ppn = parseFloat(dpp) * 0.11; //k3pg-ppn
			}else{
				ppn = parseFloat(dpp) * 0.11; //k3pg-ppn
			}
		}
		
		$("#pembelian_ppn").val(ppn);
	}

	function getTanggalJatuhTempo() {
	    var tt = "<?php echo date("Y-m-d"); ?>";

	    var date = new Date(tt);
	    var newdate = new Date(date);

	    newdate.setDate(newdate.getDate() + 10);
	    
	    var dd = newdate.getDate();
	    var mm = newdate.getMonth() + 1;
	    var y = newdate.getFullYear();

	    var someFormattedDate = y + '-' + mm + '-' + dd;
	    $("#pembelian_jatuh_tempo").val(someFormattedDate);
	}

	function HitungperSatuan(){
		var kwt = $("#pembelian_kwt").val();
		//var hargaasli = $("#pembelian_harga").val();
		//var diskon = $("#pembelian_diskon").val();
		//var nilaidiskon = parseFloat(hargaasli) * (parseFloat(diskon) / 100);
		//var harga = parseFloat(hargaasli) - nilaidiskon;
		var harga = 0;
		var jumlahHarga = $("#pembelian_jumlah").val();
		//var ppn = 0;
		
		/*if($('#pembelian_is_ppn').is(':checked')){
			if($('#pembelian_include').is(':checked')){
				harga = parseFloat(jumlahHarga) / parseFloat(kwt);
				var dpp = parseFloat(harga) / 1.11; //k3pg-ppn
				ppn = parseFloat(dpp) * 0.11; //k3pg-ppn
			}else{
				harga = parseFloat(jumlahHarga) / parseFloat(kwt);
				ppn = parseFloat(harga) * 0.11; //k3pg-ppn
			}
		}
		
		var jumlah = 0;
		if($('#pembelian_include').is(':checked')){
			jumlah = parseFloat(kwt) * parseFloat(harga);
		}else{
			jumlah = parseFloat(kwt) * (parseFloat(harga) + parseFloat(ppn));
		}*/
		harga = parseFloat(jumlahHarga) / parseFloat(kwt);
		$("#pembelian_harga").val(harga);
		HitungJumlahPpn();
		//$("#pembelian_ppn").val(round(ppn,2));
	}
</script>