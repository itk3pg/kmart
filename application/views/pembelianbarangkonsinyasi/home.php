<style>
	.datepicker{z-index:1151 !important;}
</style>
<div id="page-wrapper">
	<div class="row">
	    <div class="col-lg-12">
	        <h1 style="margin-top: 15px;" class="page-header">Data Pengadaan Barang Konsinyasi</h1>
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
							&nbsp;&nbsp;Cetak Rekap Harian
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
        			<h4 class="modal-title" id="myModalLabel">Form Pembelian Barang Konsinyasi</h4>
				</div>
				<div class="modal-body">
					<table width="100%">
						<tr>
							<td valign="top" width="45%">
								Tanggal Pembelian :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</span>
									<input type="hidden" name="bukti_op" id="bukti_op" />
									<input type="hidden" name="pembelian_mode" id="pembelian_mode" value="i" />
									<input type="hidden" name="pembelian_bukti" id="pembelian_bukti" />
									<input type="text" value="<?= date("Y-m-d"); ?>" readonly name="pembelian_tanggal" id="pembelian_tanggal" class="form-control">
								</div>
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
							<td width="1%">&nbsp;</td>
							<td valign="top" width="54%">
								Supplier :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-user"></i>
									</span>
									<select class="form-control" onchange="PilihSupplier()" name="pembelian_supplier" id="pembelian_supplier">
										
									</select>
								</div>
							</td>
						</tr>
						<tr id="group_pembelian_jatuh_tempo">
							<td>
								Jatuh Tempo :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</span>
									<input type="text" placeholder="Tanggal Jatuh Tempo" name="pembelian_jatuh_tempo" id="pembelian_jatuh_tempo" class="form-control">
								</div>
							</td>
							<td>&nbsp;</td>
							<td>
								Fee Konsinyasi (%):
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-money"></i>
									</span>
									<input type="text" style="text-align: right;" disabled name="pembelian_fee_konsinyasi" id="pembelian_fee_konsinyasi" class="form-control">
								</div>
							</td>
						</tr>
					</table>
					
					<!-- <button style="margin-bottom:10px;" type="button" id="btn-tambah-barang" onclick="openformtambahitem(1)" class="btn btn-primary">Tambah Item</button> -->
					<!-- <button style="margin-bottom:10px;" type="button" id="btn-tambah-barang" onclick="openformimportop()" class="btn btn-success">Import OP</button> -->
					<!-- Form tambah item -->
					<div id="form-tambah-barang" class="panel panel-default">
						<div class="panel-heading">
							Form Tambah Item
						</div>
						<div class="panel-body">
							<table width="100%">
								<tr>
									<td width="30%" valign="top">
										Barang :
										<div class="form-group input-group">
											<!-- <input type="text" class="form-control" style="width: 250px;" name="pembelian_barang" id="pembelian_barang" /> -->
											<input type="text" class="form-control" onkeypress="return keyEnterBarang(event)" style="width: 250px;" name="pembelian_barang_barcode" id="pembelian_barang_barcode" />
											<input type="text" class="form-control" readonly style="width: 250px;" name="pembelian_barang_nama" id="pembelian_barang_nama" />
										</div>
										<input type="checkbox" name="pembelian_is_ppn" onchange="hitungpembelianjumlah()" id="pembelian_is_ppn" /> PPn Beli @item :
										<div class="form-group input-group">
											<span class="input-group-addon">
												<i class="fa fa-money"></i>
											</span>
											<input type="text" style="text-align: right; width: 200px;" disabled placeholder="PPn" name="pembelian_ppn_beli" id="pembelian_ppn_beli" class="form-control">
										</div>
									</td>
									<td>&nbsp;&nbsp;&nbsp;</td>
									<td valign="top">
										Harga (Include PPn):
										<div class="form-group input-group">
											<span class="input-group-addon">
												<i class="fa fa-money"></i>
											</span>
											<input type="text" readonly style="text-align: right; width: 200px;" onkeypress="return keyEnterNext(event, 'pembelian_kwt')" onkeyup="hitungpembelianjumlah();" placeholder="Harga Beli" name="pembelian_harga_beli" id="pembelian_harga_beli" class="form-control">
										</div>
										Total :
										<div class="form-group input-group">
											<span class="input-group-addon">
												<i class="fa fa-money"></i>
											</span>
											<input type="text" style="text-align: right;" disabled placeholder="Total Harga" name="pembelian_jumlah" id="pembelian_jumlah" class="form-control">
										</div>
									</td>
									<td>&nbsp;&nbsp;&nbsp;</td>
									<td valign="top">
										Jumlah Barang :
										<div class="form-group input-group">
											<span class="input-group-addon">
												<i class="fa fa-shopping-cart"></i>
											</span>
											<input type="text" style="text-align: right;" onkeypress="return keyEnterNext(event, '')" onkeyup="hitungpembelianjumlah();" placeholder="kwt" name="pembelian_kwt" id="pembelian_kwt" class="form-control">
											
											<span class="input-group-addon">
											</span>
											<input type="text" class="form-control" readonly name="satuan" id="satuan" value="PCS" />
										</div>
									</td>
								</tr>
							</table>
							<button style="float: right;" type="button" onclick="clearForm(4)" class="btn btn-default">Reset</button>
							<button style="float: right; margin-right: 5px;" type="button" onclick="openformtambahitem(0)" class="btn btn-default">Cancel</button>
							<button style="float: right; margin-right: 5px;" type="button" onclick="tambahitem()" class="btn btn-primary">Tambahkan</button>
						</div>
					</div>
					<!-- End form tambah item -->
					<table id="table-dummy-pembelian" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th class="text-center">KD Item</th>
								<th class="text-center">NM Item</th>
								<th class="text-center">SATUAN</th>
								<th class="text-center">KWT OP</th>
								<th class="text-center">KWT DATANG</th>
								<th class="text-center">RETUR</th>
								<th class="text-center">Harga</th>
								<th class="text-center">Diskon</th>
								<th class="text-center">PPn @Item</th>
								<th class="text-center">Total Harga</th>
								<th class="text-center">Aksi</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
					<table style="width: 25%; margin-bottom: 5px; margin-top: 5px;">
						<tr>
							<td width="150">Total Transaksi</td>
							<td width="10"> : </td>
							<td width="100" id="total_transaksi" align="right"></td>
						</tr>
						<tr>
							<td>Total Fee</td>
							<td> : </td>
							<td id="total_fee" align="right"></td>
						</tr>
						<tr>
							<td>Total</td>
							<td> : </td>
							<td id="total_all" align="right"></td>
						</tr>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" onclick="clearForm(2)" class="btn btn-default">Reset</button>
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
								<input style="width: 115px;" type="text" name="list_op_tahun" id="list_op_tahun" value="<?= date("Y"); ?>" class="form-control" />
							</td>
							<td style="width: 125px;">
								<select style="width: 115px;" class="form-control" name="list_op_bulan" id="list_op_bulan">
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
						<input type="text" name="op_edit_nama_barang" id="op_edit_nama_barang" class="form-control">
					</div>
					Harga :
					<input type="checkbox" name="op_edit_include" onchange="HitungJumlahEdit()" checked id="op_edit_include" />
					Termasuk PPN
					<div class="form-group input-group">
						<span class="input-group-addon">
							<i class="fa fa-money"></i>
						</span>
						<input type="hidden" style="text-align: right;" name="op_edit_barang_kode" id="op_edit_barang_kode" class="form-control">
						<input type="text" style="text-align: right;" onkeyup="HitungJumlahEdit()" name="op_edit_harga" id="op_edit_harga" class="form-control">
					</div>
					KWT :
					<div class="form-group input-group">
						<span class="input-group-addon">
							<i class="fa fa-money"></i>
						</span>
						<input type="text" style="text-align: right;" onkeyup="HitungJumlahEdit()" value="0" name="op_edit_kwt" id="op_edit_kwt" class="form-control">
					</div>
					Jumlah :
					<div class="form-group input-group">
						<span class="input-group-addon">
							<i class="fa fa-money"></i>
						</span>
						<input type="text" style="text-align: right;" value="0" onkeyup="HitungperSatuanEdit()" name="op_edit_jumlah" id="op_edit_jumlah" class="form-control">
					</div>
					Diskon (%) :
					<div class="form-group input-group">
						<span class="input-group-addon">
							<i class="fa fa-money"></i>
						</span>
						<input type="text" style="text-align: right;" onkeyup="HitungJumlahPpnEdit()" value="0" name="op_edit_diskon" id="op_edit_diskon" class="form-control">
					</div>
					<input type="checkbox" name="op_edit_is_ppn" onchange="HitungJumlahEdit()" id="op_edit_is_ppn" />
					PPN :
					<div class="form-group input-group">
						<span class="input-group-addon">
							<i class="fa fa-money"></i>
						</span>
						<input readonly type="text" style="text-align: right;" value="0" name="op_edit_ppn" id="op_edit_ppn" class="form-control">
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
	
	function loadListToko(){
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/toko/getListToko",
			data: "",
			success: function(msg){
				$("#transfer_toko_kode").html(msg);
				$("#pembelian_transferketoko").html(msg);
			}
		});
	}
	
	function loadListSupplier(){
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/supplier/getselectsupplierkonsinyasi",
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
			url: "<?= base_url() ?>index.php/pembelianbarangkonsinyasi/getdatapembelianbarang",
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
		}
	}
	
	function openformtambahitem(isopen){
		if(isopen == 1){ // open form
			$("#form-tambah-barang").show();
			$("#btn-tambah-barang").hide();
		}else{ // close form
			$("#form-tambah-barang").hide();
			$("#btn-tambah-barang").show();
		}
	}
	
	function hitungpembelianjumlah(){
		var nilai_konversi = $("#nilai_konversi").val();
		var harga = $("#pembelian_harga_beli").val();
		var kwt = $("#pembelian_kwt").val();
		
		if(harga == "") harga = 0;
		if(kwt == "") kwt = 0;
		
		var ppn = 0;
		
		if($('#pembelian_is_ppn').is(':checked')){
			ppn = (parseFloat(harga)/1.11) * 0.11; //k3pg-ppn
		}else{
			ppn = 0;
		}
		
		var totalHarga = parseFloat(harga) * parseFloat(kwt);
		
		$("#pembelian_ppn_beli").val(ppn);
		$("#pembelian_jumlah").val(number_format(totalHarga, 2));
		
		// price_js('pembelian_ppn_beli');
		// price_js('pembelian_jumlah');
	}
	
	function tambahitem(){
		var kd_item = $("#pembelian_barang_barcode").val();
		var nama_item = $("#pembelian_barang_nama").val();
		
		var harga_beli = $("#pembelian_harga_beli").val();
		var kwt = $("#pembelian_kwt").val();
		var satuan = $("#satuan").val();
		var ppn_beli = $("#pembelian_ppn_beli").val();
		var jumlah = $("#pembelian_jumlah").val();
		
		var row = "<tr><td>"+kd_item+"</td><td>"+nama_item+"</td><td>"+satuan+"</td><td class=\"text-right\">"+kwt+"</td><td class=\"text-right\">"+kwt+"</td><td class=\"text-right\">"+0+"</td><td class=\"text-right\">"+harga_beli+"</td><td class=\"text-right\">"+0+"</td><td class=\"text-right\">"+ppn_beli+"</td><td class=\"text-right\">"+jumlah+"</td><td><button type=\"button\" onclick=\"HapusRow(this)\" class=\"btn btn-default\"><i class=\"fa fa-times\"></i></button></td></tr>";
		
		$('#table-dummy-pembelian > tbody:last').append(row);
		
		HitungTotalAll();

		clearForm(4);
	}
	
	function simpanpembelian(){
		$('#btn-simpan').hide();
		$('#loader-form').show();
		
		var dataArr = [];
	    $("#table-dummy-pembelian td").each(function(){
	        dataArr.push($(this).html());
	    });
	    
		var pembelian_mode = $("#pembelian_mode").val();
		
		if(pembelian_mode == "i"){
			var modeBukti = "KN";
			
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
				url: "<?= base_url(); ?>index.php/pembelianbarangkonsinyasi/hapuspembelianbarang",
				data: "bukti="+bukti,
				success: function(msg){
					var jsonData = rawurlencode(json_encode(dataArr));
					SimpanDetailPembelian(bukti, jsonData);
				}
			});
		}
	}
	
	function SimpanDetailPembelian(bukti, jsondata){
		var supplier = $("#pembelian_supplier").val().split("_wecode_");
		var supplier_kode = supplier[0];
		var status_pembayaran = $("input[name=pembelian_status_pembayaran]:checked").val();
		var jatuh_tempo = $("#pembelian_jatuh_tempo").val();
		var tanggal_pembelian = $("#pembelian_tanggal").val();
		var pembelian_mode = $("#pembelian_mode").val();
		var bukti_op = $("#bukti_op").val();
		var fee_konsinyasi = $("#pembelian_fee_konsinyasi").val();
		var is_bkl = '0';
		if($("#pembelian_is_bkl").is(':checked')){
			is_bkl = '1';
		}
		
		$.ajax({
			type: "POST",
			url: "<?= base_url(); ?>index.php/pembelianbarangkonsinyasi/simpanpembelianbarang",
			data: "data="+jsondata+"&bukti="+bukti+"&supplier_kode="+base64_encode(supplier_kode)+"&status_pembayaran="+status_pembayaran+"&jatuh_tempo="+jatuh_tempo+"&tanggal="+tanggal_pembelian+"&pembelian_mode="+pembelian_mode+"&ref_op="+bukti_op+"&is_bkl="+is_bkl+"&fee_konsinyasi="+fee_konsinyasi,
			success: function(msg){
				$('#btn-simpan').show();
				$('#loader-form').hide();
				clearForm(2);
				$('#form-pembelian-barang').modal('hide');
				
				ShowMessage('success', 'Data berhasil disimpan');
				LoadDataPembelianBarang();

				// var alertmsg = confirm("Apakah Anda ingin barang ditransfer ke toko?");
				// if(alertmsg){
				// 	OpenFormTransferkeToko(bukti);
				// }
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
			if(parseFloat(TanggalArr[1]) == parseFloat(TanggalData.getMonth()+1) && (data['tukar_nota_bukti'] == '' || data['tukar_nota_bukti'] == null)){
				$('#progres-main').show();
				$.ajax({
					type: "POST",
					url: "<?= base_url(); ?>index.php/pembelianbarangkonsinyasi/hapuspembelianbarang",
					data: "bukti="+data['bukti'],
					success: function(msg){
						ShowMessage("success", "Data berhasil dihapus");
						LoadDataPembelianBarang();
					}
				});
			}else{
				alert("Transaksi sudah melewati bulan atau Sudah di TT kan");
			}
		}
	}
	
	function cetakNotaPembelian(){
		var data_obj = $('#dataTables-pembelian-barang tr.active').attr("data");
		
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			var bukti = data['bukti'];
			window.open('<?= base_url('index.php/pembelianbarangkonsinyasi/cetakbikonsinyasi?') ?>bukti='+bukti,'_blank');
		}
	}
	
	function HapusRow(DataObj){
		dataobj = DataObj;
		$(DataObj).parent().parent().remove();
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
			if(parseFloat(TanggalArr[1]) == parseFloat(TanggalData.getMonth()+1) && (data['tukar_nota_bukti'] == '' || data['tukar_nota_bukti'] == null)){
				$("#pembelian_mode").val("e");
				$("#pembelian_bukti").val(data['bukti']);
				$("#pembelian_tanggal").val(data['tanggal']);
				$("#pembelian_tanggal").prop("readonly", "readonly");
				$("#pembelian_supplier").select2("val", data['supplier_kode']+"_wecode_"+data['fee_konsinyasi']);
				$("#pembelian_supplier").prop("disabled", true);
				$("#pembelian_fee_konsinyasi").val(data['fee_konsinyasi']);
				if(data['status_pembayaran'] == "K"){
					$("#pembelian_status_pembayaranK").prop("checked", "checked");
					$("#pembelian_status_pembayaranT").removeAttr("checked");
				}else{
					$("#pembelian_status_pembayaranT").prop("checked", "checked");
					$("#pembelian_status_pembayaranK").removeAttr("checked");
				}
				$("#bukti_op").val("");
				
				
				$.ajax({
					type: "POST",
					url: "<?= base_url() ?>index.php/pembelianbarangkonsinyasi/getdatabarangbi",
					data: "bukti="+data['bukti'],
					success: function(msg){
						$("#table-dummy-pembelian tbody").html(msg);

						HitungTotalAll();
					}
				});
				
				$("#form-pembelian-barang").modal("show");
			}else{
				alert("Transaksi sudah melewati bulan atau Sudah di TT kan");
			}
		}
	}
	
	function PilihSupplier(){
		var supplier_kode = $("#pembelian_supplier").val();
		var suppArr = supplier_kode.split("_wecode_");
		$("#pembelian_fee_konsinyasi").val(suppArr[1]);

		$("#pembelian_barang_barcode").focus();
		$("#pembelian_barang_barcode").select();
	}
	
	function openformimportop(){
		$("#form-list-op").modal("show");
		
		loadListOP();
	}
	
	function loadListOP(){
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/orderpembelian/listpilihop",
			data: "tahun="+$("#list_op_tahun").val()+"&bulan="+$("#list_op_bulan").val()+"&supplier_kode="+base64_encode($("#pembelian_supplier").val()),
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
				url: "<?= base_url() ?>index.php/pembelianbarangkonsinyasi/approvebkl",
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
			url: "<?= base_url() ?>index.php/pembelianbarangkonsinyasi/simpantransferketoko",
			data: "bukti_bi="+data['bukti']+"&tanggal="+data['tanggal']+"&toko_kode="+toko_kode,
			success: function(msg){
				var buktiTG = "";
				if(msg.substring(0, 1) == "S"){
					alert("Konsinyasi sudah ditransfer ke toko dg bukti "+msg.substring(1));
					buktiTG = msg.substring(1);
				}else{
					alert("Berhasil ditransfer ke Toko dengan bukti "+msg);
					buktiTG = msg;
				}
				window.open('<?= base_url('index.php/transfergudangkonsinyasi/cetaktg?') ?>bukti='+buktiTG,'_blank');
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
	}
	
	function OpenFormTransferkeToko(bukti=""){
		if(bukti == ""){
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
		}else{
			$("#form-transfer-ketoko").modal("show");
			$("#transfer_bukti_bi").val(bukti);
			
			$("#loader-form-transfer").hide();
			$("#btn-simpan-transfer").show();
		}
	}
	
	function CetakPembelianBarang(){
		var tanggal_awal = $("#search_tanggal_awal").val();
		var tanggal_akhir = $("#search_tanggal_akhir").val();
		window.open('<?= base_url('index.php/pembelianbarangkonsinyasi/getrekappembelianbarang?') ?>tanggal_awal='+tanggal_awal+'&tanggal_akhir='+tanggal_akhir,'_blank');
	}

	function HitungJumlahEdit(){
		var kwt = $("#op_edit_kwt").val();
		var harga = $("#op_edit_harga").val();
		
		var jumlah = parseFloat(harga) * parseFloat(kwt);
		
		$("#op_edit_jumlah").val(round(jumlah,2));
		
		HitungJumlahPpnEdit();
	}

	function HitungperSatuanEdit(){
		var kwt = $("#op_edit_kwt").val();
		var harga = 0;
		var jumlahHarga = $("#op_edit_jumlah").val();
		
		harga = parseFloat(jumlahHarga) / parseFloat(kwt);
		$("#op_edit_harga").val(harga);
		HitungJumlahPpnEdit();
	}

	function HitungJumlahPpnEdit(){
		var ppn = 0;
		var dpp = 0;
		var diskon = $("#op_edit_diskon").val();
		var harga = $("#op_edit_harga").val();
		var nilai_diskon = parseFloat(harga) * (parseFloat(diskon)/100);
		dpp = parseFloat(harga) - nilai_diskon;
		if($('#op_edit_is_ppn').is(':checked')){
			if($('#op_edit_include').is(':checked')){
				dpp = dpp / 1.11; //k3pg-ppn
				ppn = parseFloat(dpp) * 0.11; //k3pg-ppn
			}else{
				ppn = parseFloat(dpp) * 0.11; //k3pg-ppn
			}
		}
		
		$("#op_edit_ppn").val(ppn);
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
		$("#op_edit_nama_barang").val(paramArr['nama_barang']);
		$("#op_edit_harga").val(hargainclude);
		$("#op_edit_include").prop('checked', true);
		$("#op_edit_barang_kode").val(paramArr['barang_kode']);
		$("#op_edit_kwt").val(kwt);
		$("#op_edit_diskon").val(paramArr['diskon1']);
		$("#op_edit_jumlah").val(total);
		
		var ppn = parseFloat($("#ppn_"+paramArr['barang_kode']).html());
		if(ppn == 0){
			$("#op_edit_is_ppn").removeAttr("checked");
		}else{
			$("#op_edit_is_ppn").prop("checked", "checked");
			$("#op_edit_ppn").val(ppn);
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
		// var barang_kode = $("#op_edit_barang_kode").val();
		// var kwt = $("#op_edit_kwt").val();
		// var harga = $("#op_edit_harga").val();
		// var diskon = $("#op_edit_diskon").val();
		// var nilaidiskon = parseFloat(harga) * (parseFloat(diskon) / 100);
		// var hargasetelahdiskon = parseFloat(harga) - parseFloat(nilaidiskon);
		// var ppn = $("#op_edit_ppn").val();
		// if($("#op_edit_include").is(':checked')){
		// 	harga = parseFloat(hargasetelahdiskon) / 1.11; //k3pg-ppn
		// 	ppn = (dpp * 0.11); //k3pg-ppn
		// }
		// var jumlah = $("#op_edit_jumlah").val();
		
		// $("#kwt_"+barang_kode).html(kwt);
		// $("#harga_"+barang_kode).html(harga);
		// $("#diskon1_"+barang_kode).html(diskon);
		// $("#ppn_"+barang_kode).html(ppn);
		// $("#jumlah_"+barang_kode).html(jumlah);
		
		//=====================================
		var barang_kode = $("#op_edit_barang_kode").val();
		//var nama_barang = $("#s2id_op_barang .select2-chosen").html();
		var kwt = $("#op_edit_kwt").val();
		var harga = $("#op_edit_harga").val();
		var diskon = $("#op_edit_diskon").val();
		var ppn = $("#op_edit_ppn").val();
		//var stokdc = $("#op_stok_akhir").val();
		var jumlah = $("#op_edit_jumlah").val();
		var total = 0;
		
		if($('#op_edit_include').is(':checked')){ // include ppn
			if(ppn > 0){
				harga = (parseFloat(harga) / 1.11); //k3pg-ppn
			}
		}else{ // exclude ppn
			
		}
		var nilai_diskon = (parseFloat(harga) * (parseFloat(diskon)/100));
		jumlah = ((parseFloat(harga) - nilai_diskon) * parseFloat(kwt));
		total = jumlah + (parseFloat(ppn) * parseFloat(kwt));
		
		$("#kwt_"+barang_kode).html(kwt);
		$("#harga_"+barang_kode).html(harga);
		$("#diskon1_"+barang_kode).html(diskon);
		$("#jumlah_"+barang_kode).html(round(total,2));
		$("#ppn_"+barang_kode).html(ppn);
		
		// HitungTotalAll();
		
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
			break;
			case 4: // clear form sehabis add item
				$("#pembelian_barang").select2("val", "");
				$("#pembelian_harga_beli").val("");
				$("#pembelian_kwt").val("");
				$("#pembelian_kwt_kecil").val("");
				$("#satuan").val("");
				$("#satuan_kecil").val("");
				$("#pembelian_pph_beli").val("");
				$("#pembelian_ppn_beli").val("");
				$("#pembelian_jumlah").val("");

				$("#pembelian_barang_barcode").val("");
				$("#pembelian_barang_nama").val("");
			break;
		}
	}

	function HitungTotalAll(){
		var dataArr = [];
	    $("#table-dummy-pembelian td").each(function(){
	        dataArr.push($(this).html());
	    });
		
		var TotalTransaksi = 0;
		var TotalFee = 0;
		var Total = 0;
		var PersenFee = $("#pembelian_fee_konsinyasi").val();
		if(PersenFee == ""){
			PersenFee = 0;
		}

		for(var i=0;i<dataArr.length;i = i+11){
			var totalHarga = removeCurrencyNormal(dataArr[i+9]);
			TotalTransaksi += parseFloat(totalHarga);
			TotalFee += (parseFloat(totalHarga) * (parseFloat(PersenFee)/100));
			Total += (parseFloat(totalHarga) - (parseFloat(totalHarga) * (parseFloat(PersenFee)/100)));
		}
		
		$("#total_transaksi").html(number_format(TotalTransaksi,2));
		$("#total_fee").html(number_format(TotalFee,2));
		$("#total_all").html(number_format(Total,2));
	}

	function keyEnterBarang(event){
		if (event.which == 13 || event.keyCode == 13) {
	        $.ajax({
	        	type: "POST",
	        	url: "<?php echo base_url(); ?>index.php/barang/gethargabarangsupplier",
	        	data: "barang_kode="+$("#pembelian_barang_barcode").val(),
	        	success: function(msg){
	        		if(msg == ""){
	        			alert("barang tidak ditemukan");
	        			$("#pembelian_barang_barcode").val("");
	        			// $("#pembelian_barang").show();
	        			// LoadListDataBarang();
	        			// $("#pembelian_barang_barcode").hide();
	        		}else{
						var result = msg.split("_wecode_");
						$("#pembelian_barang_barcode").val(result[2])
						$("#pembelian_harga_beli").val(result[0]);
						// price("pembelian_harga_beli");
						$("#pembelian_kwt").val(1);
						$("#pembelian_ppn_beli").val(result[1]);
						// price("pembelian_ppn_beli");
						$("#pembelian_barang_nama").val(result[3]);
						// if(result[1] == "0"){
						// 	$("#pembelian_is_ppn").prop("checked", false);
						// }else{
						// 	$("#pembelian_is_ppn").prop("checked", true);
						// }
						keyEnterNext(event, "pembelian_harga_beli");
						hitungpembelianjumlah();
					}
				}
	        });
	        return false;
	    }
	    return true;
	}

	function keyEnterNext(event, selector){
		if (event.which == 13 || event.keyCode == 13) {
	       	if(selector == ""){
	       		tambahitem();
	       		$("#pembelian_barang_barcode").focus();
				$("#pembelian_barang_barcode").select();
	       	}else{
		       	$("#"+selector).focus();
				$("#"+selector).select();
			}
	       	return false;
	    }
	    return true;
	}
</script>