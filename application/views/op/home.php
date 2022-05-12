<style>
	.datepicker{z-index:1151 !important;}
</style>
<div id="page-wrapper">
	<div class="row">
	    <div class="col-lg-12">
	        <h1 style="margin-top: 15px;" class="page-header">Order Pembelian (OP)</h1>
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
					<td>
						<button id="btn_upload" onclick="LoadDataOP()" class="btn btn-info" type="button">
							<i class="fa fa-search"></i>
							&nbsp;&nbsp;Search
						</button>
					</td>
					<td>&nbsp;&nbsp;</td>
					<td valign="middle">
						<button id="btn_upload" onclick="CetakRekapOrderPembelian()" class="btn btn-success" type="button">
							<i class="fa fa-print"></i>
							&nbsp;&nbsp;Rekap Harian (pdf)
						</button>
					</td>
					<td>&nbsp;&nbsp;</td>
					<td valign="middle">
						<button id="btn_upload" onclick="CetakRekapOrderPembelianExcel()" class="btn btn-success" type="button">
							<i class="fa fa-print"></i>
							&nbsp;&nbsp;Rekap Harian (xls)
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
					<button id="btn_tambah" onclick="openFormOP()" class="btn btn-info btn-sm" type="button">
						<i class="fa fa-plus"></i>
						&nbsp;&nbsp;Tambah
					</button>
					<button id="btn_uedit" onclick="openFormEditOP()" class="btn btn-success btn-sm" type="button">
						<i class="fa fa-edit"></i>
						&nbsp;&nbsp;Edit
					</button>
					<button id="btn_hapus" fungsi="HapusOP()" class="btn btn-danger btn-sm ask-op" type="button">
						<i class="fa fa-times"></i>
						&nbsp;&nbsp;Hapus
					</button>
					<button id="btn_hapus" onclick="CetakPP()" class="btn btn-warning btn-sm" type="button">
						<i class="fa fa-print"></i>
						&nbsp;&nbsp;Cetak PP
					</button>
					<button id="btn_hapus" onclick="CetakOP()" class="btn btn-warning btn-sm" type="button">
						<i class="fa fa-print"></i>
						&nbsp;&nbsp;Cetak OP
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
					<div style="max-height: 600px; overflow: scroll;" class="table-responsive table-op">
						
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Popup form untuk pembelian barang -->
	<div class="modal fade" id="form-op" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        			<h4 class="modal-title" id="myModalLabel">Form Order Pembelian (OP)</h4>
				</div>
				<div class="modal-body">
					<table style="width: 93%;">
						<tr>
							<td style="width: 200px;">Tanggal :</td>
							<td>&nbsp;&nbsp;
								<input type="hidden" name="mode" id="mode" value="i"/>
								<input type="hidden" name="op_bukti" id="op_bukti"/>
							</td>
							<td>Supplier :</td>
						</tr>
						<tr>
							<td>
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</span>
									<input type="text" value="<?= date("Y-m-d"); ?>" placeholder="Tanggal OP" name="op_tanggal" id="op_tanggal" class="form-control">
								</div>
							</td>
							<td>&nbsp;&nbsp;</td>
							<td>
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<select class="form-control" style="width: 300px;" name="op_supplier" id="op_supplier">
										<option value="">Pilih Supplier</option>
									</select>
								</div>
							</td>
							<td>&nbsp;&nbsp;</td>
							<td valign="top">
								<button id="btn_tambah" onclick="ListBarangSupplier()" class="btn btn-info btn-sm" type="button">
									<i class="fa fa-check"></i>
									&nbsp;&nbsp;Import Barang
								</button>
							</td>
							<td>&nbsp;&nbsp;</td>
							<td valign="top">
								<button id="btn_cetak" onclick="CetakBarangSupplier()" class="btn btn-success btn-sm" type="button">
									<i class="fa fa-print"></i>
									&nbsp;&nbsp;Cetak Barang
								</button>
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
								<input type="checkbox" name="op_include" checked onchange="HitungJumlah()" id="op_include" />
								Termasuk PPN
							</td>
							<td>&nbsp;&nbsp;</td>
							<td width="150px">Kwt :</td>
						</tr>
						<tr>
							<td width="250px">
								<!-- <input type="text" class="form-control" name="op_barang" id="op_barang" /> -->
								<input type="text" class="form-control" onkeypress="return keyEnterBarang(event)" style="width: 250px;" name="op_barang_barcode" id="op_barang_barcode" />
								<input type="text" class="form-control" readonly style="width: 250px;" name="op_barang_nama" id="op_barang_nama" />
							</td>
							<td>&nbsp;&nbsp;</td>
							<td><input type="text" style="text-align: right;" readonly class="form-control" name="op_harga_terakhir" id="op_harga_terakhir" /></td>
							<td>&nbsp;&nbsp;</td>
							<td><input type="text" style="text-align: right; width: 100px;" readonly class="form-control" name="op_stok_akhir" id="op_stok_akhir" /></td>
							<td>&nbsp;&nbsp;</td>
							<td><input type="text" style="text-align: right;width: 175px;" class="form-control" onkeyup="HitungJumlah()" onkeypress="return keyEnterNext(event, 'op_kwt')" name="op_harga" id="op_harga" /></td>
							<td>&nbsp;&nbsp;</td>
							<td><input type="text" value="0" style="text-align: right; width: 100px;" onkeyup="HitungJumlah()" class="form-control" onkeypress="return keyEnterNext(event, 'op_diskon')" name="op_kwt" id="op_kwt" /></td>
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
							<td><input type="checkbox" name="op_is_ppn" onchange="HitungJumlah()" id="op_is_ppn" checked="checked" />
								PPn :</td>
							<td>&nbsp;&nbsp;</td>
							<td>&nbsp;&nbsp;</td>
						</tr>
						<tr>
							<td width="250px">&nbsp;</td>
							<td>&nbsp;&nbsp;</td>
							<td><input type="text" style="text-align: right;" class="form-control" onkeyup="HitungperSatuan()" value="0" name="op_jumlah" onkeypress="return keyEnterNext(event, 'op_diskon')" id="op_jumlah" /></td>
							<td>&nbsp;&nbsp;</td>
							<td><input type="text" style="text-align: right;" onkeyup="HitungJumlahPpn()" value="0" class="form-control" name="op_diskon" onkeypress="return keyEnterNext(event, '')" id="op_diskon" /></td>
							<td>&nbsp;&nbsp;</td>
							<td><input type="text" style="text-align: right;" readonly class="form-control" name="op_ppn" id="op_ppn" /></td>
							<td>&nbsp;&nbsp;</td>
							<td>
								<button id="btn_tambah_barang" onclick="TambahBarangOP();" class="btn btn-success btn-sm" type="button">
									<i class="fa fa-plus"></i>
									&nbsp;&nbsp;Tambah
								</button>
							</td>
						</tr>
					</table>
					<hr/>
					<form id="FormImport" action="<?php echo base_url(); ?>index.php/orderpembelian/import" method="post" enctype="multipart/form-data">
						<table width="100%">
							<tr>
								<td><input type="file" size="60" name="fileupload"></td>
								<td align="right"><input class="btn btn-info btn-sm" type="submit" value="Import File"></td>
							</tr>
						</table>
					</form>
					<div id="progress-data" style="display: none;">
						<div class="progress progress-striped active">
							<div class="progress-bar progress-bar-info" style="width: 20%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="20" role="progressbar">
								<span class="sr-only">20% Complete</span>
							</div>
						</div>
					</div>
					<hr/>
					<table style="width: 100%" id="table-dummy-op" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th class="text-center">KD Barang</th>
								<th class="text-center">Nama Barang</th>
								<th class="text-center">Satuan</th>
								<th class="text-center">Stok DC</th>
								<th class="text-center">Kwt</th>
								<th class="text-center">Harga</th>
								<th class="text-center">Diskon</th>
								<th class="text-center">Jumlah</th>
								<th class="text-center">PPn</th>
								<th class="text-center">Total</th>
								<th class="text-center">Hapus</th>
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
			        <button type="button" id="btn-simpan" onclick="SimpanOP()" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;&nbsp;Simpan</button>
				</div>
			</div>
		</div>
	</div>
	<!-- Popup form untuk piiih OD -->
	<div class="modal fade" id="form-list-od" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        			<h4 class="modal-title" id="myModalLabel">Form Order Pembelian (OP)</h4>
				</div>
				<div class="modal-body">
					<table style="margin-bottom: 5px;">
						<tr>
							<td style="width: 125px;">
								<input style="width: 115px;" type="text" name="list_od_tahun" id="list_od_tahun" value="<?= date("Y"); ?>" class="form-control" />
							</td>
							<td style="width: 125px;">
								<select style="width: 115px;" class="form-control" name="list_od_bulan" id="list_od_bulan">
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
								<button id="btn_upload" onclick="loadListOD()" class="btn btn-info" type="button">
									<i class="fa fa-search"></i>
									&nbsp;&nbsp;Search
								</button>
							</td>
						</tr>
					</table>
					<div id="list_od"></div>
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
        			<h4 class="modal-title" id="myModalLabel">Form Edit Order Pembelian</h4>
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
		LoadDataOP();
		LoadListDataBarang();
		loadListSupplier();
		
		$('.ask-op').jConfirmAction();
		
		$('#op_tanggal').datepicker({
			format: 'yyyy-mm-dd'
		});
		$('#search_tanggal_awal').datepicker({
			format: 'yyyy-mm-dd'
		});
		$('#search_tanggal_akhir').datepicker({
			format: 'yyyy-mm-dd'
		});
		
		$('.datepicker tbody').on('click', function(){  $('.datepicker').hide() });

		var options = {
		    beforeSend: function(){
		        $("#progress-data").show();
		        //clear everything
		        $("#progress-data .progress-bar").attr("style","width: 80%");
		        //$("#message").html("");
		        //$("#percent").html("0%");
		    },
		    uploadProgress: function(event, position, total, percentComplete){
		        //$("#bar").width(percentComplete+'%');
		        //$("#percent").html(percentComplete+'%');
		 		$("#progress-data .progress-bar").attr("style","width: "+percentComplete+"%");
		    },
		    success: function(){
		        // $("#bar").width('100%');
		        // $("#percent").html('100%');
		        $("#progress-data .progress-bar").attr("style","width: 100%");
		    },
		    complete: function(response){
		        var dataArr = json_decode(base64_decode(response.responseText));
		        for(var i=0;i<dataArr.length;i++){
		        	var row = "<tr><td>"+dataArr[i]['barang_kode']+"</td><td>"+dataArr[i]['nama_barang']+"</td><td>"+dataArr[i]['satuan']+"</td><td class=\"text-right\">-</td><td class=\"text-right\">"+dataArr[i]['kwt']+"</td><td class=\"text-right\">"+dataArr[i]['harga']+"</td><td class=\"text-right\">0</td><td class=\"text-right\">"+round(dataArr[i]['jumlah'],2)+"</td><td class=\"text-right\">"+dataArr[i]['ppn']+"</td><td class=\"text-right\">"+round(dataArr[i]['total'],2)+"</td><td class=\"text-center\"><!--<button type=\"button\" onclick=\"Editkwt('"+dataArr[i]['barang_kode']+"', '"+dataArr[i]['nama_barang']+"', '"+dataArr[i]['kwt']+"', '0')\" class=\"btn btn-warning btn-sm\"><i class=\"fa fa-edit\"></i>--></button><button type=\"button\" onclick=\"HapusRow(this); HitungTotalAll();\" class=\"btn btn-danger btn-sm\"><i class=\"fa fa-times\"></i></button></td></tr>";
					$('#table-dummy-op > tbody:last').append(row);
		        }
		        HitungTotalAll();
		        
		        $("#progress-data").hide();

		    },
		    error: function(){
		        $("#message").html("<font color='red'> ERROR: unable to upload files</font>");
		 
		    }
		};
	 	 	
	    $("#FormImport").ajaxForm(options);
	});
	
	function loadListSupplier(){
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/supplier/getselectsupplier",
			data: "",
			success: function(msg){
				$("#op_supplier").html(msg);
				$("#op_supplier").select2();
			}
		});
	}
	
	function LoadDataOP(){
		$('#progres-main').show();
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/orderpembelian/getdataop",
			data: "tanggal_awal="+$("#search_tanggal_awal").val()+"&tanggal_akhir="+$("#search_tanggal_akhir").val(),
			success: function(msg){
				$(".table-op").html(msg);
				//table = $('#dataTables-od').dataTable();
				$('#progres-main').hide();
				
				$('#dataTables-op tbody').on( 'click', 'tr', function () {
			        if ( $(this).hasClass('active') ) {
			            $(this).removeClass('active');
			        }else {
			            $('#dataTables-op tr.active').removeClass('active');
			            $(this).addClass('active');
			        }
			    } );
			}
		});
	}
	
	function openFormOP(){
		clearForm();
		
		$("#form-op").modal("show");
		$("#mode").val("i");
		$("#op_bukti").val("");
		$("#bukti_od").val("");
	}
	
	function LoadListDataBarang(){
	    $("#op_barang").select2({
		    placeholder: "Cari barang",
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
            	return "<span class=\"select2-match\"></span>"+option.barcode+" - "+option.nama_barang;
            }, 
		    formatSelection: function (option) {
            	return option.nama_barang;
            }
	    });
		
		$("#op_barang").on("select2-selecting", function(e) {
	    	// dataperlang = e;
	    	// alert ("selecting val="+ e.choice.satuan_terkecil +" choice="+ JSON.stringify(e.choice));
			$("#btn_tambah_barang").attr("onclick", "TambahBarangOP('"+e.choice.satuan+"')");
			getHargaBarangSupplier(e.choice.kode);
			getStokDC(e.choice.kode);
	    });
	}
	
	function getHargaBarangSupplier(barang_kode){
		var supplier_kode = $("#op_supplier").val();
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/orderpembelian/gethargabeli",
			data: "supplier_kode="+supplier_kode+"&barang_kode="+barang_kode,
			success: function(msg){
				$("#op_harga").val(msg);
				$("#op_harga_terakhir").val(msg);
				var ppn = 0;
				if($('#op_is_ppn').is(':checked')){
					var dpp = parseFloat(msg) / 1.11; //k3pg-ppn
					ppn = parseFloat(dpp) * 0.11; //k3pg-ppn
				}
				$("#op_ppn").val(ppn);
				//price("op_harga");
				//price("op_ppn");
			}
		});
	}
	
	function getStokDC(barang_kode){
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/orderpembelian/getstokdc",
			data: "barang_kode="+barang_kode,
			success: function(msg){
				$("#op_stok_akhir").val(msg);
			}
		});
	}
	
	function HapusRow(DataObj){
		dataobj = DataObj;
		dataobj = DataObj;
		$(DataObj).parent().parent().remove();
	}
	
	function TambahBarangOP(satuan){
		// var kd_barang = $("#op_barang").val();
		var kd_barang = $("#op_barang_barcode").val();
		// var nama_barang = $("#s2id_op_barang .select2-chosen").html();
		var nama_barang = $("#op_barang_nama").val();
		var kwt = $("#op_kwt").val();
		var harga = $("#op_harga").val();
		var diskon = $("#op_diskon").val();
		var ppn = $("#op_ppn").val();
		var stokdc = $("#op_stok_akhir").val();
		var jumlah = $("#op_jumlah").val();
		var total = 0;
		
		if($('#op_include').is(':checked')){ // include ppn
			harga = (parseFloat(harga) / 1.11); //k3pg-ppn
		}else{ // exclude ppn
			
		}
		var nilai_diskon = (parseFloat(harga) * (parseFloat(diskon)/100));
		jumlah = ((parseFloat(harga) - nilai_diskon) * parseFloat(kwt));
		total = jumlah + (parseFloat(ppn) * parseFloat(kwt));
		var row = "<tr><td>"+kd_barang+"</td><td>"+nama_barang+"</td><td>"+satuan+"</td><td class=\"text-right\">"+stokdc+"</td><td class=\"text-right\">"+kwt+"</td><td class=\"text-right\">"+harga+"</td><td class=\"text-right\">"+diskon+"</td><td class=\"text-right\">"+round(jumlah,2)+"</td><td class=\"text-right\">"+ppn+"</td><td class=\"text-right\">"+round(total,2)+"</td><td class=\"text-center\"><!--<button type=\"button\" onclick=\"Editkwt('"+kd_barang+"', '"+nama_barang+"', '"+kwt+"', '"+diskon+"')\" class=\"btn btn-warning btn-sm\"><i class=\"fa fa-edit\"></i>--></button><button type=\"button\" onclick=\"HapusRow(this); HitungTotalAll();\" class=\"btn btn-danger btn-sm\"><i class=\"fa fa-times\"></i></button></td></tr>";
		$('#table-dummy-op > tbody:last').append(row);
		
		HitungTotalAll();

		$("#op_kwt").val("0");
		$("#op_harga").val("0");
		$("#op_harga_terakhir").val("0");
		// $("#op_diskon").val("0");
		$("#op_ppn").val("0");
		$("#op_stok_akhir").val("0");
		$("#op_jumlah").val("0");

		$("#op_barang_barcode").val("");
		$("#op_barang_nama").val("");
		$("#op_barang_barcode").focus();
	}
	
	function clearForm(){
		$('#table-dummy-op tbody').html("");
		// $("#op_barang").select2("val", "");
		$("#op_kwt").val("");
		$("#op_supplier").select2("val", "-1");
		$("#bukti_od").val("");
	}
	
	function SimpanOP(){
		$('#btn-simpan').hide();
		$('#loader-form').show();
		
		var dataArr = [];
	    $("#table-dummy-op td").each(function(){
	        dataArr.push($(this).html());
	    });
	    var mode = $("#mode").val();
		var bukti = $("#op_bukti").val();
		
		if($("#op_supplier").select2("val") != "" && $("#op_supplier").select2("val") != null){
			if(mode == "i"){
				var modeBukti = "OP";
				var tanggal_op = $("#op_tanggal").val();
				$.ajax({
					type: "POST",
					url: "<?= base_url() ?>index.php/bukti/generatebukti",
					data: "mode="+modeBukti+"&tanggal="+tanggal_op,
					success: function(msg){
						ajaxsimpanop(msg, dataArr, 0);
					}
				});
			}else{
				$.ajax({
					type: "POST",
					url: "<?= base_url(); ?>index.php/orderpembelian/hapusop",
					data: "bukti="+bukti,
					success: function(msg){
						ajaxsimpanop(bukti, dataArr, 0);
					}
				});
			}
		}else{
			alert("supplier belum diisi");
			$('#btn-simpan').show();
			$('#loader-form').hide();
		}
	}
	
	function ajaxsimpanop(bukti, dataArr, index){
		var kd_barang = dataArr[index];
		var kwt = dataArr[index+4];
		var hargaasli = dataArr[index+5];
		var diskon1 = dataArr[index+6];
		var nilaidiskon = hargaasli * (diskon1 / 100);
		var harga = hargaasli - nilaidiskon;
		var ppn = dataArr[index+8];
		var jumlah = dataArr[index+9];
		var tanggal = $("#op_tanggal").val();
		var kd_supplier = $("#op_supplier").val();
		var bukti_od = $("#bukti_od").val();
		var mode = $("#mode").val();
		var mode_include = "0";
		
		if($('#op_include').is(':checked')){
			mode_include = "1";
		}
		
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/orderpembelian/simpanop",
			data: "mode="+mode+"&index="+index+"&bukti="+bukti+"&barang_kode="+kd_barang+"&kwt="+kwt+"&harga="+harga+"&harga_asli="+hargaasli+"&diskon1="+diskon1+"&ppn="+ppn+"&jumlah="+jumlah+"&tanggal="+tanggal+"&supplier_kode="+base64_encode(kd_supplier)+"&bukti_od="+bukti_od+"&mode_include="+mode_include,
			success: function(msg){
				index = index + 11;
				if(index >= dataArr.length){ // jika sudah sampai index yang terakhir
					$('#btn-simpan').show();
					$('#loader-form').hide();
					
					ShowMessage("success", "Data berhasil disimpan");
					LoadDataOP();
					$("#form-op").modal("hide");
					clearForm();
				}else{ // jika masih ada data yang dimasukkan
					ajaxsimpanop(bukti, dataArr, index);
				}
			},
			error: function(xhr,status,error){
				ShowMessage("danger", "Data gagal disimpan");
				$('#btn-simpan').show();
				$('#loader-form').hide();
			}
		});
	}
	
	function HapusOP(){
		var data_obj = $('#dataTables-op tr.active').attr("data");
		
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			
			if(data['is_receive'] == "0"){
				$('#progres-main').show();
				$.ajax({
					type: "POST",
					url: "<?= base_url(); ?>index.php/orderpembelian/hapusop",
					data: "bukti="+data['bukti'],
					success: function(msg){
						ShowMessage("success", "Data berhasil dihapus");
						LoadDataOP();
					}
				});
			}else{
				alert("OP sudah dilakukan penerimaan");
			}
		}
	}
	
	function openFormEditOP(){
		var data_obj = $('#dataTables-op tr.active').attr("data");
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			clearForm();
			var data = json_decode(base64_decode(data_obj));
			
			if(data['is_receive'] == "0"){
				$("#mode").val("e");
				$("#op_bukti").val(data['bukti']);
				$("#op_tanggal").val(data['tanggal']);
				$("#op_supplier").select2("val", data['supplier_kode']);
				$("#bukti_od").val(data['ref_od']);
				
				$.ajax({
					type: "POST",
					url: "<?= base_url() ?>index.php/orderpembelian/getdatabarangeditop",
					data: "bukti="+data['bukti'],
					success: function(msg){
						$("#table-dummy-op tbody").html(msg);
						
						HitungTotalAll();
					}
				});
				
				$("#form-op").modal("show");
			}else{
				alert("OP sudah dilakukan penerimaan");
			}
		}
	}
	
	function OpenImportOD(){
		$("#form-list-od").modal("show");
	}
	
	function PilihOD(bukti){
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/permintaanorder/getdatabarangod",
			data: "bukti="+bukti,
			success: function(msg){
				$("#bukti_od").val(bukti);
				$("#table-dummy-op tbody").html(msg);
				
				$("#form-list-od").modal("hide");
			}
		});
	}
	
	function HitungJumlah(){
		var kwt = $("#op_kwt").val();
		var harga = $("#op_harga").val();
		//var diskon = $("#op_diskon").val();
		//var nilaidiskon = parseFloat(hargaasli) * (parseFloat(diskon) / 100);
		//var harga = parseFloat(hargaasli) - nilaidiskon;
		//var ppn = 0;
		
		/*if($('#op_is_ppn').is(':checked')){
			if($('#op_include').is(':checked')){
				var dpp = parseFloat(harga) / 1.11; //k3pg-ppn
				ppn = parseFloat(dpp) * 0.11; //k3pg-ppn
			}else{
				ppn = parseFloat(harga) * 0.11; //k3pg-ppn
			}
		}*/
		var jumlah = parseFloat(harga) * parseFloat(kwt);
		/*var jumlah = 0;
		if($('#op_include').is(':checked')){
			jumlah = parseFloat(kwt) * parseFloat(harga);
		}else{
			jumlah = parseFloat(kwt) * (parseFloat(harga) + parseFloat(ppn));
		}*/
		
		$("#op_jumlah").val(jumlah);
		//$("#op_ppn").val(round(ppn,2));
		HitungJumlahPpn();
	}
	
	function HitungJumlahEdit(){
		var kwt = $("#op_edit_kwt").val();
		var harga = $("#op_edit_harga").val();
		
		var jumlah = parseFloat(harga) * parseFloat(kwt);
		
		$("#op_edit_jumlah").val(round(jumlah,2));
		
		HitungJumlahPpnEdit();
	}
	
	function HitungperSatuan(){
		var kwt = $("#op_kwt").val();
		//var hargaasli = $("#op_harga").val();
		//var diskon = $("#op_diskon").val();
		//var nilaidiskon = parseFloat(hargaasli) * (parseFloat(diskon) / 100);
		//var harga = parseFloat(hargaasli) - nilaidiskon;
		var harga = 0;
		var jumlahHarga = $("#op_jumlah").val();
		//var ppn = 0;
		
		/*if($('#op_is_ppn').is(':checked')){
			if($('#op_include').is(':checked')){
				harga = parseFloat(jumlahHarga) / parseFloat(kwt);
				var dpp = parseFloat(harga) / 1.11; //k3pg-ppn
				ppn = parseFloat(dpp) * 0.11; //k3pg-ppn
			}else{
				harga = parseFloat(jumlahHarga) / parseFloat(kwt);
				ppn = parseFloat(harga) * 0.11; //k3pg-ppn
			}
		}
		
		var jumlah = 0;
		if($('#op_include').is(':checked')){
			jumlah = parseFloat(kwt) * parseFloat(harga);
		}else{
			jumlah = parseFloat(kwt) * (parseFloat(harga) + parseFloat(ppn));
		}*/
		harga = parseFloat(jumlahHarga) / parseFloat(kwt);
		$("#op_harga").val(harga);
		HitungJumlahPpn();
		//$("#op_ppn").val(round(ppn,2));
	}
	
	function HitungperSatuanEdit(){
		var kwt = $("#op_edit_kwt").val();
		var harga = 0;
		var jumlahHarga = $("#op_edit_jumlah").val();
		
		harga = parseFloat(jumlahHarga) / parseFloat(kwt);
		$("#op_edit_harga").val(harga);
		HitungJumlahPpnEdit();
	}
	
	function HitungHarga(){
		var kwt = $("#op_kwt").val();
		var jumlah = $("#op_jumlah").val();
		var harga = parseFloat(jumlah) / kwt;
		var ppn = 0;
		
		if($('#op_is_ppn').is(':checked')){
			harga = harga / 1.11; //k3pg-ppn
			ppn = parseFloat(harga) * 0.11; //k3pg-ppn
		}
		
		$("#op_harga").val(round(harga,2));
		$("#op_ppn").val(round(ppn,2));
		
		price('op_harga');
		price('op_ppn');
	}
	
	function ListBarangSupplier(){
		var supplier_kode = $("#op_supplier").val();
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/orderpembelian/getdatabarangsupplier",
			data: "supplier_kode="+supplier_kode,
			success: function(msg){
				$("#table-dummy-op tbody").html(msg);
			}
		});
	}
	
	function Editkwt(barang_kode, nama_barang = '', kwt = 0, diskon = 0){
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
		kwt = $("#kwt_"+barang_kode).html();
		var harga = $("#harga_"+barang_kode).html();
		var ppn = $("#ppn_"+barang_kode).html();
		var total = $("#total_"+barang_kode).html();
		var hargainclude = parseFloat(harga) + parseFloat(ppn);
		$("#op_edit_harga").val(hargainclude);
		$("#op_edit_include").prop('checked', true);
		$("#op_edit_barang_kode").val(barang_kode);
		$("#op_edit_nama_barang").val(nama_barang);
		$("#op_edit_kwt").val(kwt);
		$("#op_edit_diskon").val(diskon);
		$("#op_edit_jumlah").val(total);
		
		var ppn = parseFloat($("#ppn_"+barang_kode).html());
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
		var barang_kode = $("#op_edit_barang_kode").val();
		var kwt = $("#op_edit_kwt").val();
		var harga = $("#op_edit_harga").val();
		var diskon = $("#op_edit_diskon").val();
		var nilaidiskon = parseFloat(harga) * (parseFloat(diskon) / 100);
		var hargasetelahdiskon = parseFloat(harga) - parseFloat(nilaidiskon);
		var ppn = 0;
		if($("#op_edit_is_ppn").is(':checked')){
			var dpp = parseFloat(hargasetelahdiskon) / 1.11; //k3pg-ppn
			ppn = (dpp * 0.11); //k3pg-ppn
		}
		var jumlah = parseFloat(kwt) * (hargasetelahdiskon + ppn);
		
		$("#kwt_"+barang_kode).html(kwt);
		$("#harga_"+barang_kode).html(harga);
		$("#diskon1_"+barang_kode).html(diskon);
		$("#ppn_"+barang_kode).html(ppn);
		$("#jumlah_"+barang_kode).html(jumlah);
		
		//=====================================
		var kd_barang = $("#op_edit_barang_kode").val();
		//var nama_barang = $("#s2id_op_barang .select2-chosen").html();
		var kwt = $("#op_edit_kwt").val();
		var harga = $("#op_edit_harga").val();
		var diskon = $("#op_edit_diskon").val();
		var ppn = $("#op_edit_ppn").val();
		//var stokdc = $("#op_stok_akhir").val();
		var jumlah = $("#op_edit_jumlah").val();
		var total = 0;
		
		if($('#op_edit_include').is(':checked')){ // include ppn
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
		$("#ppn_"+barang_kode).html(ppn);
		$("#total_"+barang_kode).html(round(total,2));
		
		HitungTotalAll();
		
		$("#form-edit-kwt").modal("hide");
	}
	
	function HitungTotalAll(){
		var dataArr = [];
	    $("#table-dummy-op td").each(function(){
	        dataArr.push($(this).html());
	    });
		
		var jumlahDPP = 0;
		var jumlahPPN = 0;
		var jumlahTotal = 0;
		for(var i=7;i<dataArr.length;i = i+11){
			jumlahDPP += parseFloat(dataArr[i]);
			jumlahPPN += parseFloat(dataArr[i+1]) * parseFloat(dataArr[i-3]);
			jumlahTotal += parseFloat(dataArr[i+2]);
		}
		
		$("#total_dpp").html(number_format(jumlahDPP,2));
		$("#total_ppn").html(number_format(jumlahPPN,2));
		$("#total_all").html(number_format(jumlahTotal,2));
	}
	
	function HitungJumlahPpn(){
		var ppn = 0;
		var dpp = 0;
		var diskon = $("#op_diskon").val();
		var harga = $("#op_harga").val();
		var nilai_diskon = parseFloat(harga) * (parseFloat(diskon)/100);
		dpp = parseFloat(harga) - nilai_diskon;
		if($('#op_is_ppn').is(':checked')){
			if($('#op_include').is(':checked')){
				dpp = dpp / 1.11; //k3pg-ppn
				ppn = parseFloat(dpp) * 0.11; //k3pg-ppn
			}else{
				ppn = parseFloat(dpp) * 0.11; //k3pg-ppn
			}
		}
		
		$("#op_ppn").val(ppn);
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
	
	function CetakPP(){
		var data_obj = $('#dataTables-op tr.active').attr("data");
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			window.open('<?= base_url('index.php/orderpembelian/cetakpp?') ?>bukti='+data['bukti'],'_blank');
		}
	}

	function CetakOP(){
		var data_obj = $('#dataTables-op tr.active').attr("data");
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			window.open('<?= base_url('index.php/orderpembelian/cetakop?') ?>bukti='+data['bukti'],'_blank');
		}
	}
	
	function CetakBarangSupplier(){
		var supplier_kode = $("#op_supplier").val();
		window.open('<?= base_url('index.php/orderpembelian/cetakbarangsupplier?') ?>supplier_kode='+supplier_kode,'_blank');
	}

	function keyEnterBarang(event){
		if (event.which == 13 || event.keyCode == 13) {
	        $.ajax({
	        	type: "POST",
	        	url: "<?php echo base_url(); ?>index.php/barang/gethargabarangsupplier",
	        	data: "barang_kode="+$("#op_barang_barcode").val(),
	        	success: function(msg){
	        		if(msg == ""){
	        			alert("barang tidak ditemukan / harga beli supplier belum ada");
	        			// $("#pembelian_barang").show();
	        			// LoadListDataBarang();
	        			// $("#pembelian_barang_barcode").hide();
	        		}else{
						var result = msg.split("_wecode_");
						$("#op_barang_barcode").val(result[2])
						$("#op_harga_terakhir").val(result[0]);
						$("#op_harga").val(result[0]);
						// price("pembelian_harga_beli");
						$("#op_kwt").val(1);
						
						$("#op_ppn").val(result[1]);
						// price("pembelian_ppn_beli");
						$("#op_barang_nama").val(result[3]);
						// if(result[1] == "0"){
						// 	$("#op_is_ppn").prop("checked", false);
						// }else{
						// 	$("#op_is_ppn").prop("checked", true);
						// }
						
						$("#op_stok_akhir").val(result[4]);
						$("#op_harga").focus();
						$("#op_harga").select();
						HitungJumlah();
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
	       		TambahBarangOP("");
	       	}else{
		       	$("#"+selector).focus();
				$("#"+selector).select();
			}
	       	return false;
	    }
	    return true;
	}

	function CetakRekapOrderPembelian(){
		var tanggal_awal = $("#search_tanggal_awal").val();
		var tanggal_akhir = $("#search_tanggal_akhir").val();
		window.open('<?= base_url('index.php/orderpembelian/getrekaporderpembelian?') ?>tanggal_awal='+tanggal_awal+'&tanggal_akhir='+tanggal_akhir,'_blank');
	}

	function CetakRekapOrderPembelianExcel(){
		var tanggal_awal = $("#search_tanggal_awal").val();
		var tanggal_akhir = $("#search_tanggal_akhir").val();
		window.open('<?= base_url('index.php/orderpembelian/getrekaporderpembelian_xls?') ?>tanggal_awal='+tanggal_awal+'&tanggal_akhir='+tanggal_akhir,'_blank');
	}

</script>