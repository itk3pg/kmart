<style>
	.datepicker{z-index:1151 !important;}
</style>
<div id="page-wrapper">
	<div class="row">
	    <div class="col-lg-12">
	        <h1 style="margin-top: 15px;" class="page-header">Retur Supplier Konsinyasi (RN)</h1>
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
						<button id="btn_upload" onclick="LoadDataReturSupplier()" class="btn btn-info" type="button">
							<i class="fa fa-search"></i>
							&nbsp;&nbsp;Search
						</button>
					</td>
					<td>&nbsp;&nbsp;</td>
					<td valign="middle">
						<button id="btn_upload" onclick="CetakRekapHarian()" class="btn btn-success" type="button">
							<i class="fa fa-print"></i>
							&nbsp;&nbsp;Rekap Harian (pdf)
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
					<button id="btn_tambah" onclick="openFormReturSupplier()" class="btn btn-info btn-sm" type="button">
						<i class="fa fa-plus"></i>
						&nbsp;&nbsp;Tambah
					</button>
					<button id="btn_uedit" onclick="openFormEditReturSupplier()" class="btn btn-success btn-sm" type="button">
						<i class="fa fa-edit"></i>
						&nbsp;&nbsp;Edit
					</button>
					<button id="btn_hapus" fungsi="HapusReturSupplier()" class="btn btn-danger btn-sm ask-retursupplier" type="button">
						<i class="fa fa-times"></i>
						&nbsp;&nbsp;Hapus
					</button>
					<button id="btn_hapus" onclick="CetakReturSupplier()" class="btn btn-warning btn-sm" type="button">
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
					<div class="table-responsive table-retursupplier">
						
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Popup form untuk retur barang -->
	<div class="modal fade" id="form-retursupplier" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        			<h4 class="modal-title" id="myModalLabel">Form Retur Barang Supplier Konsinyasi</h4>
				</div>
				<div class="modal-body">
					<table style="width: 80%;">
						<tr>
							<td style="width: 30%;">Tanggal :</td>
							<td>&nbsp;&nbsp;
								<input type="hidden" name="mode" id="mode" value="i"/>
								<input type="hidden" name="retursupplier_bukti" id="retursupplier_bukti"/>
							</td>
							<td style="width: 50%;">Ke Supplier :</td>
						</tr
						<tr>
							<td>
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</span>
									<input type="text" value="<?= date("Y-m-d"); ?>" name="retursupplier_tanggal" id="retursupplier_tanggal" class="form-control">
								</div>
							</td>
							<td>&nbsp;&nbsp;</td>
							<td>
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<select class="form-control" name="retursupplier_supplier" id="retursupplier_supplier">
										<option value="-1">Pilih Supplier</option>
									</select>
									<!-- <button id="btn_tambah" onclick="ListBarangSupplier()" class="btn btn-info btn-sm" type="button">
										<i class="fa fa-check"></i>
										&nbsp;&nbsp;Import Barang
									</button> -->
								</div>
								
							</td>
							<td>&nbsp;&nbsp;</td>
							<td>
								<button style="margin-bottom:10px;" type="button" id="btn-import-ot" onclick="openformimportrt()" class="btn btn-success">Import Dari Retur Toko</button>
							</td>
						</tr>
					</table>
					<table style="width: 100%; margin-bottom: 5px; margin-top: 5px;">
						<tr>
							<td width="250px">Barang :</td>
							<td>&nbsp;&nbsp;</td>
							<td width="150px">Harga :</td>
							<td>&nbsp;&nbsp;</td>
							<td width="75px">Kwt :</td>
							<td>&nbsp;&nbsp;</td>
							<td width="150px">jumlah :</td>
							<td>&nbsp;&nbsp;</td>
							<td>&nbsp;&nbsp;</td>
						</tr>
						<tr>
							<td width="250px">
								<!-- <input type="text" class="form-control" name="retursupplier_barang" id="retursupplier_barang" /> -->
								<input type="text" class="form-control" onkeypress="return keyEnterBarang(event)" style="width: 250px;" name="retursupplier_barang_barcode" id="retursupplier_barang_barcode" />
								<input type="text" class="form-control" readonly style="width: 250px;" name="retursupplier_barang_nama" id="retursupplier_barang_nama" />
							</td>
							<td>&nbsp;&nbsp;</td>
							<td><input type="text" style="text-align: right;" class="form-control" onkeyup="merubahkoma('retursupplier_harga'); HitungJumlah();" name="retursupplier_harga" id="retursupplier_harga" /></td>
							<td>&nbsp;&nbsp;</td>
							<td><input type="text" style="text-align: right;" onkeyup="HitungJumlah()" value="0" class="form-control" name="retursupplier_kwt" onkeypress="return keyEnterNext(event, '')" id="retursupplier_kwt" /></td>
							<td>&nbsp;&nbsp;</td>
							<td><input type="text" style="text-align: right;" readonly class="form-control" name="retursupplier_jumlah" id="retursupplier_jumlah" /></td>
							<td>&nbsp;&nbsp;</td>
							<td>
								<button id="btn_tambah_barang" onclick="TambahBarangReturSupplier('')" class="btn btn-success btn-sm" type="button">
									<i class="fa fa-plus"></i>
									&nbsp;&nbsp;Tambah
								</button>
							</td>
						</tr>
					</table>
					<table style="width: 100%" id="table-dummy-retursupplier" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th class="text-center">Kode</th>
								<th class="text-center">Nama Barang</th>
								<th class="text-center">Qty</th>
								<th class="text-center">Harga</th>
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
			        <button type="button" id="btn-simpan" onclick="SimpanReturSupplier()" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;&nbsp;Simpan</button>
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
        			<h4 class="modal-title" id="myModalLabel">Form Edit Retur Supplier</h4>
				</div>
				<div class="modal-body">
					Barang :
					<div class="form-group input-group">
						<span class="input-group-addon">
							<i class="fa fa-file"></i>
						</span>
						<input type="text" name="rs_edit_nama_barang" id="rs_edit_nama_barang" class="form-control">
					</div>
					Harga (inc) :
					<div class="form-group input-group">
						<span class="input-group-addon">
							<i class="fa fa-money"></i>
						</span>
						<input type="hidden" style="text-align: right;" name="rs_edit_barang_kode" id="rs_edit_barang_kode" class="form-control">
						<input type="text" style="text-align: right;" name="rs_edit_harga" id="rs_edit_harga" class="form-control">
					</div>
					PPN :
					<div class="form-group input-group">
						<input type='checkbox' class='form-control' name='rs_edit_is_ppn' id='rs_edit_is_ppn' /> 
					</div>
					KWT :
					<div class="form-group input-group">
						<span class="input-group-addon">
							<i class="fa fa-money"></i>
						</span>
						<input type="text" style="text-align: right;" value="0" name="rs_edit_kwt" id="rs_edit_kwt" class="form-control">
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

	<!-- Popup form untuk piiih RT -->
	<div class="modal fade" id="form-list-rt" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        			<h4 class="modal-title" id="myModalLabel">List Retur Toko Konsinyasi (UN)</h4>
				</div>
				<div class="modal-body">
					<table style="margin-bottom: 5px;">
						<tr>
							<td style="width: 125px;">
								<input style="width: 115px;" type="text" name="list_rt_tahun" id="list_rt_tahun" value="<?= date("Y"); ?>" class="form-control" />
							</td>
							<td style="width: 125px;">
								<select style="width: 115px;" class="form-control" name="list_rt_bulan" id="list_rt_bulan">
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
								<button id="btn_upload" onclick="loadListRT()" class="btn btn-info" type="button">
									<i class="fa fa-search"></i>
									&nbsp;&nbsp;Search
								</button>
							</td>
						</tr>
					</table>
					<div id="list_rt"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		OpenMenu();
		LoadDataReturSupplier();
		LoadListDataBarang();
		loadListSupplier();
		
		$('.ask-retursupplier').jConfirmAction();
		
		$('#retursupplier_tanggal').datepicker({
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
				$("#retursupplier_supplier").html(msg);
				$("#retursupplier_supplier").select2();
			}
		});
	}
	
	function LoadDataReturSupplier(){
		$('#progres-main').show();
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/retursupplierkonsinyasi/getdataretursupplier",
			data: "tanggal_awal="+$("#search_tanggal_awal").val()+"&tanggal_akhir="+$("#search_tanggal_akhir").val(),
			success: function(msg){
				$(".table-retursupplier").html(msg);
				//table = $('#dataTables-retursupplier').dataTable();
				$('#progres-main').hide();
				
				$('#dataTables-retursupplier tbody').on( 'click', 'tr', function () {
			        if ( $(this).hasClass('active') ) {
			            $(this).removeClass('active');
			        }else {
			            $('#dataTables-retursupplier tr.active').removeClass('active');
			            $(this).addClass('active');
			        }
			    } );
			}
		});
	}
	
	function openFormReturSupplier(){
		$("#form-retursupplier").modal("show");
		$("#mode").val("i");
		$("#retursupplier_bukti").val("");
	}
	
	function LoadListDataBarang(){
	    $("#retursupplier_barang").select2({
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
	    
	    $("#retursupplier_barang").on("select2-selecting", function(e) {
	    	// dataperlang = e;
	    	// alert ("selecting val="+ e.choice.satuan_terkecil +" choice="+ JSON.stringify(e.choice));
			$("#btn_tambah_barang").attr("onclick", "TambahBarangReturSupplier('"+e.choice.satuan+"')");
			getHargaBarangSupplier(e.choice.kode);
	    });
	}
	
	function getHargaBarangSupplier(barang_kode){
		var supplier_kode = $("#retursupplier_supplier").val();
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/orderpembelian/gethargabeli",
			data: "supplier_kode="+supplier_kode+"&barang_kode="+barang_kode,
			success: function(msg){
				$("#retursupplier_harga").val(msg);
			}
		});
	}
	
	function HapusRow(DataObj){
		dataobj = DataObj;
		$(DataObj).parent().parent().remove();
	}
	
	function TambahBarangReturSupplier(satuan){
		var kd_barang = $("#retursupplier_barang_barcode").val();
		var nama_barang = $("#retursupplier_barang_nama").val();
		var kwt = $("#retursupplier_kwt").val();
		var harga = $("#retursupplier_harga").val();
		var jumlah = $("#retursupplier_jumlah").val();
		
		var row = "<tr><td>"+kd_barang+"</td><td>"+nama_barang+"</td><td id=\"kwt_"+kd_barang+"\" class=\"text-right\">"+kwt+"</td><td id=\"harga_"+kd_barang+"\" class=\"text-right\">"+harga+"</td><td id=\"jumlah_"+kd_barang+"\" class=\"text-right\">"+jumlah+"</td><td class=\"text-center\"><button type=\"button\" style=\"padding: 1px 5px;\" onclick=\"HapusRow(this)\" class=\"btn btn-danger btn-sm\"><i class=\"fa fa-times\"></i></button></td></tr>";
		$('#table-dummy-retursupplier > tbody:last').append(row);

		$("#retursupplier_barang_barcode").val("");
		$("#retursupplier_barang_nama").val("");
		$("#retursupplier_kwt").val("0");
		$("#retursupplier_harga").val("0");
		$("#retursupplier_jumlah").val("0");

		$("#retursupplier_barang_barcode").focus();
	}
	
	function clearForm(){
		$('#table-dummy-retursupplier tbody').html("");
		$("#retursupplier_barang").select2("val", "");
		$("#retursupplier_supplier").select2("val", "");
		$("#retursupplier_kwt").val("");
		$("#retursupplier_supplier").removeAttr("disabled");
	}
	
	function SimpanReturSupplier(){
		$('#btn-simpan').hide();
		$('#loader-form').show();
		
		var dataArr = [];
	    $("#table-dummy-retursupplier td").each(function(){
	        dataArr.push($(this).html());
	    });
	    var mode = $("#mode").val();
		var bukti = $("#retursupplier_bukti").val();
		
		if(mode == "i"){
			var modeBukti = "RN";
			var tanggal_od = $("#retursupplier_tanggal").val();
			$.ajax({
				type: "POST",
				url: "<?= base_url() ?>index.php/bukti/generatebukti",
				data: "mode="+modeBukti+"&tanggal="+tanggal_od,
				success: function(msg){
					ajaxsimpanretursupplier(msg, dataArr, 0);
				}
			});
		}else{
			$.ajax({
				type: "POST",
				url: "<?= base_url(); ?>index.php/retursupplierkonsinyasi/hapusretursupplier",
				data: "bukti="+bukti,
				success: function(msg){
					ajaxsimpanretursupplier(bukti, dataArr, 0);
				}
			});
		}
	}
	
	function ajaxsimpanretursupplier(bukti, dataArr, index){
		var kd_barang = dataArr[index];
		var kwt = dataArr[index+2];
		var harga = dataArr[index+3];
		harga = round((parseFloat(harga) / 1.11),2); //k3pg-ppn
		var ppn = harga * 0.11; //k3pg-ppn
		var jumlah = dataArr[index+4];
		var tanggal = $("#retursupplier_tanggal").val();
		var supplier_kode = base64_encode($("#retursupplier_supplier").val());
		var mode = $("#mode").val();
		
		if(kwt > 0){
			$.ajax({
				type: "POST",
				url: "<?= base_url() ?>index.php/retursupplierkonsinyasi/simpanretursupplier",
				data: "mode="+mode+"&bukti="+bukti+"&barang_kode="+kd_barang+"&kwt="+kwt+"&harga="+harga+"&ppn="+ppn+"&jumlah="+jumlah+"&tanggal="+tanggal+"&supplier_kode="+supplier_kode,
				success: function(msg){
					index = index + 6;
					if(index >= dataArr.length){ // jika sudah sampai index yang terakhir
						$('#btn-simpan').show();
						$('#loader-form').hide();
						
						ShowMessage("success", "Data berhasil disimpan");
						LoadDataReturSupplier();
						clearForm();
						$("#form-retursupplier").modal("hide");
						
						syncstokretursupplier(bukti);
					}else{ // jika masih ada data yang dimasukkan
						ajaxsimpanretursupplier(bukti, dataArr, index);
					}
				},
				error: function(xhr,status,error){
					ShowMessage("danger", "Data gagal disimpan");
					$('#btn-simpan').show();
					$('#loader-form').hide();
				}
			});
		}else{
			index = index + 6;
			if(index >= dataArr.length){ // jika sudah sampai index yang terakhir
				$('#btn-simpan').show();
				$('#loader-form').hide();
				
				ShowMessage("success", "Data berhasil disimpan");
				LoadDataReturSupplier();
				clearForm();
				$("#form-retursupplier").modal("hide");
				syncstokretursupplier(bukti);
			}else{ // jika masih ada data yang dimasukkan
				ajaxsimpanretursupplier(bukti, dataArr, index);
			}
		}
	}

	function syncstokretursupplier(bukti){
		$.ajax({
			type: "POST",
			url: "<?= base_url(); ?>index.php/retursupplierkonsinyasi/syncstokretursupplier",
			data: "bukti="+bukti,
			success: function(msg){
				ShowMessage("success", "Data berhasil diupdate");
			}
		});
	}
	
	function HapusReturSupplier(){
		var data_obj = $('#dataTables-retursupplier tr.active').attr("data");
		
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			if(data['tukar_nota_bukti'] != ""){
				$('#progres-main').show();
				$.ajax({
					type: "POST",
					url: "<?= base_url(); ?>index.php/retursupplierkonsinyasi/hapusretursupplier",
					data: "bukti="+data['bukti'],
					success: function(msg){
						ShowMessage("success", "Data berhasil dihapus");
						LoadDataReturSupplier();

						syncstokretursupplier(data['bukti']);
					}
				});
			}else{
				alert("retur sudah di TTkan");
			}
		}
	}
	
	function openFormEditReturSupplier(){
		var data_obj = $('#dataTables-retursupplier tr.active').attr("data");
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			
			if(data['tukar_nota_bukti'] != ""){
				$("#mode").val("e");
				$("#retursupplier_bukti").val(data['bukti']);
				$("#retursupplier_tanggal").val(data['tanggal']);
				$("#retursupplier_supplier").select2("val", data['supplier_kode']);
				$("#select2-chosen-2").html(data['nama_supplier']);
				$("#retursupplier_supplier").prop("disabled", "disabled");
				
				$.ajax({
					type: "POST",
					url: "<?= base_url() ?>index.php/retursupplierkonsinyasi/getdatabarangretursupplier",
					data: "bukti="+data['bukti'],
					success: function(msg){
						$("#table-dummy-retursupplier tbody").html(msg);
					}
				});
				
				$("#form-retursupplier").modal("show");
			}else{
				alert("retur sudah di TTkan");
			}
		}
	}
	
	function ListBarangSupplier(){
		var supplier_kode = $("#retursupplier_supplier").val();
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/retursupplierkonsinyasi/getdatabarangsupplier",
			data: "supplier_kode="+supplier_kode,
			success: function(msg){
				$("#table-dummy-retursupplier tbody").html(msg);
			}
		});
	}
	
	function Editkwt(barang_kode, nama_barang = '', kwt = 0){
		var jumlahharga = parseFloat($("#jumlah_"+barang_kode).html());
		var harga = jumlahharga / parseFloat(kwt);
		$("#rs_edit_harga").val(harga);
		$("#rs_edit_barang_kode").val(barang_kode);
		$("#rs_edit_nama_barang").val(nama_barang);
		$("#rs_edit_kwt").val(kwt);
		var ppn = parseFloat($("#ppn_"+barang_kode).html());
		if(ppn == 0){
			$("#rs_edit_is_ppn").removeAttr("checked");
		}else{
			$("#rs_edit_is_ppn").prop("checked", "checked");
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
		var barang_kode = $("#rs_edit_barang_kode").val();
		var kwt = $("#rs_edit_kwt").val();
		var harga = removeCurrency($("#rs_edit_harga").val());
		var ppn = 0;
		var dpp = harga;
		if($("#rs_edit_is_ppn").is(':checked')){
			dpp = harga / 1.11; //k3pg-ppn
			ppn = round((parseFloat(dpp) * 0.11),2); //k3pg-ppn
		}
		var jumlah = parseFloat(harga) * parseFloat(kwt);
		
		$("#kwt_"+barang_kode).html(kwt);
		$("#harga_"+barang_kode).html(round(dpp,2));
		$("#ppn_"+barang_kode).html(ppn);
		$("#jumlah_"+barang_kode).html(jumlah);
		
		$("#form-edit-kwt").modal("hide");
	}
	
	function CetakReturSupplier(){
		var data_obj = $('#dataTables-retursupplier tr.active').attr("data");
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			window.open('<?= base_url('index.php/retursupplierkonsinyasi/cetakretursupplier?') ?>bukti='+data['bukti'],'_blank');
		}
	}

	function HitungJumlah(){
		var harga = parseFloat($("#retursupplier_harga").val());
		var kwt = parseFloat($("#retursupplier_kwt").val());
		
		var jumlah = harga * kwt;
		$("#retursupplier_jumlah").val(jumlah);
	}

	function keyEnterBarang(event){
		if (event.which == 13 || event.keyCode == 13) {
	        $.ajax({
	        	type: "POST",
	        	url: "<?php echo base_url(); ?>index.php/barang/gethargabarangsupplier",
	        	data: "barang_kode="+$("#retursupplier_barang_barcode").val(),
	        	success: function(msg){
	        		if(msg == ""){
	        			alert("barang tidak ditemukan");
	        			// $("#pembelian_barang").show();
	        			// LoadListDataBarang();
	        			// $("#pembelian_barang_barcode").hide();
	        		}else{
						var result = msg.split("_wecode_");
						$("#retursupplier_barang_barcode").val(result[2])
						$("#retursupplier_harga").val(result[0]);
						// price("pembelian_harga_beli");
						$("#retursupplier_kwt").val(1);
						// price("pembelian_ppn_beli");
						$("#retursupplier_barang_nama").val(result[3]);
						
						$("#retursupplier_kwt").focus();
						$("#retursupplier_kwt").select();
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
	       		TambahBarangReturSupplier("");
	       	}else{
		       	$("#"+selector).focus();
				$("#"+selector).select();
			}
	       	return false;
	    }
	    return true;
	}

	function openformimportrt(){
		$("#form-list-rt").modal("show");
		
		loadListRT();
	}

	function loadListRT(){
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/returtokokonsinyasi/listpilihreturtokoapprove",
			data: "tahun="+$("#list_rt_tahun").val()+"&bulan="+$("#list_rt_bulan").val(),
			success: function(msg){
				$("#list_rt").html(msg);
			}
		});
	}

	function PilihRT(bukti, toko_kode){
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/returtokokonsinyasi/getdatabarangrttk",
			data: "bukti="+bukti+"&toko_kode="+toko_kode,
			success: function(msg){
				$("#table-dummy-retursupplier tbody").html(msg);
				
				$("#form-list-rt").modal("hide");
			}
		});
	}

	function CetakRekapHarian(){
		var tanggal_awal = $("#search_tanggal_awal").val();
		var tanggal_akhir = $("#search_tanggal_akhir").val();
		window.open('<?= base_url('index.php/retursupplierkonsinyasi/getrekapharian?') ?>tanggal_awal='+tanggal_awal+'&tanggal_akhir='+tanggal_akhir,'_blank');
	}
</script>