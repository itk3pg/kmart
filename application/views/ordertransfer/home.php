<style>
	.datepicker{z-index:1151 !important;}
</style>
<div id="page-wrapper">
	<div class="row">
	    <div class="col-lg-12">
	        <h1 style="margin-top: 15px;" class="page-header">Permintaan Transfer Toko (OT)</h1>
	    </div>
	    <!-- /.col-lg-12 -->
	</div>
	<div class="row" style="margin-bottom: 10px;">
		<div class="col-lg-12">
			<table style="float: right;">
				<tr>
					<td style="width: 200px;">
						<select class="form-control" style="width: 190px;" name="ot_cari_toko" id="ot_cari_toko">
							<option value="-1">Pilih Toko</option>
						</select>
					</td>
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
						<button id="btn_upload" onclick="LoadDataOT()" class="btn btn-info" type="button">
							<i class="fa fa-search"></i>
							&nbsp;&nbsp;Search
						</button>
					</td>
					<td>&nbsp;&nbsp;</td>
					<td valign="middle">
						<button id="btn_upload" onclick="CetakRekapOrderTransfer()" class="btn btn-success" type="button">
							<i class="fa fa-print"></i>
							&nbsp;&nbsp;Rekap Harian (pdf)
						</button>
					</td>
					<td>&nbsp;&nbsp;</td>
					<td valign="middle">
						<button id="btn_upload" onclick="CetakRekapOrderTransferExcel()" class="btn btn-success" type="button">
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
					<?php if($this->session->userdata('group_kode') == "GRU0000" || $this->session->userdata('group_kode') == "GRU0001" || $this->session->userdata('group_kode') == "GRU0002" || $this->session->userdata('group_kode') == "GRU0004" || $this->session->userdata('group_kode') == "GRU0005" || $this->session->userdata('group_kode') == "GRU0012"){ ?>
					<button id="btn_tambah" onclick="openFormOT()" class="btn btn-info btn-sm" type="button">
						<i class="fa fa-plus"></i>
						&nbsp;&nbsp;Tambah
					</button>
					<button id="btn_uedit" onclick="openFormEditOT()" class="btn btn-success btn-sm" type="button">
						<i class="fa fa-edit"></i>
						&nbsp;&nbsp;Edit
					</button>
					<button id="btn_hapus" fungsi="HapusOT()" class="btn btn-danger btn-sm ask-ot" type="button">
						<i class="fa fa-times"></i>
						&nbsp;&nbsp;Hapus
					</button>
					<?php } ?>
					<button id="btn_hapus" onclick="CetakTransfer()" class="btn btn-warning btn-sm" type="button">
						<i class="fa fa-print"></i>
						&nbsp;&nbsp;Cetak
					</button>
					<!-- <button id="btn_hapus" onclick="CetakTransfer2()" class="btn btn-warning btn-sm" type="button">
						<i class="fa fa-print"></i>
						&nbsp;&nbsp;Cetak 2
					</button> -->
					<!-- <button id="btn_hapus" onclick="CetakTransferPlain()" class="btn btn-warning btn-sm" type="button">
						<i class="fa fa-print"></i>
						&nbsp;&nbsp;Cetak Plain Text
					</button> -->
					<button id="btn_fixot" onclick="openFormFixOT()" class="btn btn-success btn-sm" type="button">
						<i class="fa fa-edit"></i>
						&nbsp;&nbsp;Fix OT
					</button>
					<button id="btn_hapus" onclick="CetakDataOT()" class="btn btn-warning btn-sm" type="button">
						<i class="fa fa-print"></i>
						&nbsp;&nbsp;Cetak Rekap
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
					<div class="table-responsive table-ot">
						
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Popup form untuk pembelian barang -->
	<div class="modal fade" id="form-ot" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        			<h4 class="modal-title" id="myModalLabel">Form Permintaan Transfer Toko (OT)</h4>
				</div>
				<div class="modal-body">
					<table style="width: 60%;">
						<tr>
							<td style="width: 200px;">Tanggal :</td>
							<td>&nbsp;&nbsp;
								<input type="hidden" name="mode" id="mode" value="i"/>
								<input type="hidden" name="ot_bukti" id="ot_bukti"/>
							</td>
							<td>Dari Toko :</td>
						</tr>
						<tr>
							<td>
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</span>
									<input type="text" value="<?= date("Y-m-d"); ?>" name="ot_tanggal" id="ot_tanggal" class="form-control">
								</div>
							</td>
							<td>&nbsp;&nbsp;</td>
							<td>
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<select class="form-control" name="ot_toko" id="ot_toko">
										<option value="-1">Pilih Toko</option>
									</select>
								</div>
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
								<!-- <input type="text" class="form-control" name="ot_barang" id="ot_barang" /> -->
								<input type="text" class="form-control" onkeypress="return keyEnterBarang(event)" style="width: 250px;" name="ot_barang_barcode" id="ot_barang_barcode" />
								<input type="text" class="form-control" readonly style="width: 250px;" name="ot_barang_nama" id="ot_barang_nama" />
							</td>
							<td>&nbsp;&nbsp;</td>
							<td><input type="text" style="text-align: right;" class="form-control" onkeyup="merubahkoma('ot_harga'); HitungJumlah();" name="ot_harga" id="ot_harga" /></td>
							<td>&nbsp;&nbsp;</td>
							<td><input type="text" style="text-align: right;" onkeyup="HitungJumlah()" value="0" class="form-control" name="ot_kwt" onkeypress="return keyEnterNext(event, '')" id="ot_kwt" /></td>
							<td>&nbsp;&nbsp;</td>
							<td><input type="text" style="text-align: right;" readonly class="form-control" name="ot_jumlah" id="ot_jumlah" /></td>
							<td>&nbsp;&nbsp;</td>
							<td>
								<button id="btn_tambah_barang" onclick="TambahBarangOT('')" class="btn btn-success btn-sm" type="button">
									<i class="fa fa-plus"></i>
									&nbsp;&nbsp;Tambah
								</button>
							</td>
						</tr>
					</table>
					<table style="width: 100%" id="table-dummy-ot" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th class="text-center">Kode Barang</th>
								<th class="text-center">Nama Barang</th>
								<th class="text-center">Satuan</th>
								<th class="text-center">Saldo Gudang DC</th>
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
			        <button type="button" id="btn-simpan" onclick="SimpanOT()" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;&nbsp;Simpan</button>
				</div>
			</div>
		</div>
	</div>
	
	<!-- Popup form untuk piiih OT -->
	<div class="modal fade" id="form-list-ot" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        			<h4 class="modal-title" id="myModalLabel">List OT Tidak Terealisasi (OT)</h4>
				</div>
				<div class="modal-body">
					<div id="list_ot"></div>
				</div>
			</div>
		</div>
	</div>

	<!-- Popup form untuk fix OT -->
	<div class="modal fade" id="form-fix-ot" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        			<h4 class="modal-title" id="myModalLabel">Fix OT</h4>
				</div>
				<div class="modal-body">
					Toko :
					<select class="form-control" style="width: 190px;" name="fixot_toko" id="fixot_toko">
							<option value="-1">Pilih Toko</option>
						</select>
					Bukti OT :
					<div class="form-group input-group">
						<span class="input-group-addon">
							<i class="fa fa-file"></i>
						</span>
						<input type="text" name="fixot_bukti" id="fixot_bukti" class="form-control">
					</div>
					<button id="btn_simpan_fix_ot" onclick="SimpanFixOT()" class="btn btn-success btn-sm" type="button">
						<i class="fa fa-save"></i>
						&nbsp;&nbsp;Perbaiki
					</button>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		OpenMenu();
		LoadDataOT();
		LoadListDataBarang();
		loadListToko();
		loadListSupplier();
		
		$('.ask-ot').jConfirmAction();
		
		$('#ot_tanggal').datepicker({
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
				$("#ot_supplier").html(msg);
				$("#ot_supplier").select2();
			}
		});
	}
	
	function loadListToko(){
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/toko/getListToko",
			data: "",
			success: function(msg){
				$("#ot_toko").html(msg);
				$("#ot_cari_toko").html(msg);
				$("#fixot_toko").html(msg);
			}
		});
	}
	
	function LoadDataOT(){
		$('#progres-main').show();
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/ordertransfer/getdataot",
			data: "tanggal_awal="+$("#search_tanggal_awal").val()+"&tanggal_akhir="+$("#search_tanggal_akhir").val()+"&toko_kode="+$("#ot_cari_toko").val(),
			success: function(msg){
				$(".table-ot").html(msg);
				//table = $('#dataTables-ot').dataTable();
				$('#progres-main').hide();
				
				$('#dataTables-ot tbody').on( 'click', 'tr', function () {
			        if ( $(this).hasClass('active') ) {
			            $(this).removeClass('active');
			        }else {
			            $('#dataTables-ot tr.active').removeClass('active');
			            $(this).addClass('active');
			        }
			    } );
			}
		});
	}
	
	function openFormOT(){
		$("#form-ot").modal("show");
		$("#mode").val("i");
		$("#ot_bukti").val("");
	}

	function openFormFixOT(){
		$("#form-fix-ot").modal("show");
	}
	
	function LoadListDataBarang(){
	    $("#ot_barang").select2({
		    placeholder: "Cari bahan baku",
		    minimumInputLength: 1,
		    ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
			    url: "<?php echo base_url(); ?>index.php/barang/getlistbarangtoko",
			    dataType: 'json',
			    quietMillis: 250,
			    data: function (term, page) {
				    return {
				    	q: term, // search term
				    	toko_kode: $("#ot_toko").val(),
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
	    
	    $("#ot_barang").on("select2-selecting", function(e) {
	    	// dataperlang = e;
	    	// alert ("selecting val="+ e.choice.satuan_terkecil +" choice="+ JSON.stringify(e.choice));
			$("#btn_tambah_barang").attr("onclick", "TambahBarangOT('"+e.choice.satuan+"')");
			$("#ot_hpp").val(e.choice.hpp);
	    });
	}
	
	function HitungKonversiSatuan(nilai_konversi){
		var tipe_satuan = $("#ot_satuan_barang").val();
		var nilai_kwt = $("#ot_kwt").val();
		if(tipe_satuan == "besar"){
			nilai_kwt = nilai_kwt / nilai_konversi;
		}else{
			nilai_kwt = nilai_kwt * nilai_konversi;
		}
		
		$("#ot_kwt").val(nilai_kwt);
	}
	
	function HapusRow(DataObj){
		dataobj = DataObj;
		$(DataObj).parent().parent().remove();
	}
	
	function TambahBarangOT(satuan){
		var kd_barang = $("#ot_barang_barcode").val();
		var nama_barang = $("#ot_barang_nama").val();
		var kwt = $("#ot_kwt").val();
		var hpp = $("#ot_harga").val();
		var jumlah = kwt * hpp;
		
		var dataArr = [];
	    $("#table-dummy-ot td").each(function(){
	        dataArr.push($(this).html());
	    });
		
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/ordertransfer/getsaldobarangtoko",
			data: "barang_kode="+kd_barang+"&toko_kode="+$("#ot_toko").val(),
			success: function(msg){
				var row = "<tr><td>"+kd_barang+"</td><td>"+nama_barang+"</td><td>"+satuan+"</td><td class=\"text-right\">"+msg+"</td><td class=\"text-right\">"+kwt+"</td><td class=\"text-right\">"+round(hpp,2)+"</td><td class=\"text-right\">"+round(jumlah,2)+"</td><td class=\"text-center\"><button type=\"button\" style=\"padding: 0px 20px;\" onclick=\"HapusRow(this)\" class=\"btn btn-danger btn-sm\"><i class=\"fa fa-times\"></i></button></td></tr>";
				
				if(dataArr.length > 0){
					$('#table-dummy-ot > tbody > tr:first').before(row);
				}else{
					$('#table-dummy-ot > tbody:last').append(row);
				}

				$("#ot_harga").val("0");
				$("#ot_kwt").val("0");
				$("#ot_jumlah").val("0");
				$("#ot_barang_barcode").val("");
				$("#ot_barang_nama").val("");
				$("#ot_barang_barcode").focus();
			}
		});
	}
	
	function clearForm(){
		$('#table-dummy-ot tbody').html("");
		$("#ot_barang").select2("val", "");
		$("#ot_kwt").val("");
	}

	function SimpanFixOT(){
		var fixot_bukti = $("#fixot_bukti").val();
		var fixot_toko = $("#fixot_toko").val();
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/ordertransfer/fixot",
			data: "fixot_bukti="+fixot_bukti+"&fixot_toko="+fixot_toko,
			success: function(msg){
				LoadDataOT();
			}
		});
	}
	
	function SimpanOT(){
		$('#btn-simpan').hide();
		$('#loader-form').show();
		
		var dataArr = [];
	    $("#table-dummy-ot td").each(function(){
	        dataArr.push($(this).html());
	    });
	    var mode = $("#mode").val();
		var bukti = $("#ot_bukti").val();
		
		if(mode == "i"){
			var modeBukti = "OT";
			var tanggal_od = $("#ot_tanggal").val();
			$.ajax({
				type: "POST",
				url: "<?= base_url() ?>index.php/bukti/generatebukti",
				data: "mode="+modeBukti+"&tanggal="+tanggal_od,
				success: function(msg){
					ajaxsimpanot(msg, dataArr, 0);
				}
			});
		}else{
			$.ajax({
				type: "POST",
				url: "<?= base_url(); ?>index.php/ordertransfer/hapusot",
				data: "bukti="+bukti,
				success: function(msg){
					ajaxsimpanot(bukti, dataArr, 0);
				}
			});
		}
	}
	
	function ajaxsimpanot(bukti, dataArr, index){
		var kd_barang = dataArr[index];
		var stok_dc = dataArr[index+3];
		var kwt = dataArr[index+4];
		var harga = dataArr[index+5];
		var jumlah = dataArr[index+6];
		var tanggal = $("#ot_tanggal").val();
		var kd_toko = $("#ot_toko").val();
		var mode = $("#mode").val();
		
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/ordertransfer/simpanot",
			data: "mode="+mode+"&bukti="+bukti+"&barang_kode="+kd_barang+"&kwt="+kwt+"&harga="+harga+"&jumlah="+jumlah+"&tanggal="+tanggal+"&toko_kode="+kd_toko+"&stok_dc="+stok_dc+"&urut="+index,
			success: function(msg){
				index = index + 8;
				if(index >= dataArr.length){ // jika sudah sampai index yang terakhir
					$('#btn-simpan').show();
					$('#loader-form').hide();
					
					ShowMessage("success", "Data berhasil disimpan");
					LoadDataOT();
					$("#form-ot").modal("hide");
					clearForm();
				}else{ // jika masih ada data yang dimasukkan
					ajaxsimpanot(bukti, dataArr, index);
				}
			},
			error: function(xhr,status,error){
				ShowMessage("danger", "Data gagal disimpan");
				$('#btn-simpan').show();
				$('#loader-form').hide();
			}
		});
	}
	
	function HapusOT(){
		var data_obj = $('#dataTables-ot tr.active').attr("data");
		
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			$('#progres-main').show();
			$.ajax({
				type: "POST",
				url: "<?= base_url(); ?>index.php/ordertransfer/hapusot",
				data: "bukti="+data['bukti'],
				success: function(msg){
					ShowMessage("success", "Data berhasil dihapus");
					LoadDataOT();
				}
			});
		}
	}
	
	function openFormEditOT(){
		var data_obj = $('#dataTables-ot tr.active').attr("data");
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			
			$("#mode").val("e");
			$("#ot_bukti").val(data['bukti']);
			$("#ot_tanggal").val(data['tanggal']);
			$("#ot_toko").val(data['toko_kode']);
			
			$.ajax({
				type: "POST",
				url: "<?= base_url() ?>index.php/ordertransfer/getdatabarangot",
				data: "bukti="+data['bukti'],
				success: function(msg){
					$("#table-dummy-ot tbody").html(msg);
				}
			});
			
			$("#form-ot").modal("show");
		}
	}
	
	function ListBarangSupplier(){
		var supplier_kode = $("#ot_supplier").val();
		var toko_kode = $("#ot_toko").val();
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/ordertransfer/getdatabarangsupplier",
			data: "supplier_kode="+supplier_kode+"&toko_kode="+toko_kode,
			success: function(msg){
				$("#table-dummy-ot tbody").html(msg);
			}
		});
	}
	
	function Editkwt(barang_kode){
		$("#form-edit-table-"+barang_kode).show();
		
		$("#kwt_edit_"+barang_kode).val($("#kwt_"+barang_kode).html());
		//$("#btn_edit_kwt_"+barang_kode).show();
		//$("#btn_cancel_edit_kwt_"+barang_kode).show();
	}
	
	function CancelEditkwt(barang_kode){
		$("#form-edit-table-"+barang_kode).hide();
		//$("#kwt_edit_"+barang_kode).hide();
		//$("#btn_edit_kwt_"+barang_kode).hide();
		//$("#btn_cancel_edit_kwt_"+barang_kode).hide();
	}
	
	function SimpanEditKwt(barang_kode){
		var kwt = $("#kwt_edit_"+barang_kode).val();
		if(kwt == ""){
			kwt = 0;
		}
		
		$("#kwt_"+barang_kode).html(kwt);
		
		CancelEditkwt(barang_kode);
	}
	
	function CetakTransfer(){
		var data_obj = $('#dataTables-ot tr.active').attr("data");
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			window.open('<?= base_url('index.php/ordertransfer/cetakot?') ?>bukti='+data['bukti']+'&toko_kode='+data['toko_kode'],'_blank');
		}
	}

	// function CetakTransfer2(){
	// 	var data_obj = $('#dataTables-ot tr.active').attr("data");
	// 	if(typeof data_obj == "undefined"){
	// 		alert("Silahkan pilih salah satu data terlebih dahulu");
	// 	}else{
	// 		var data = json_decode(base64_decode(data_obj));
	// 		window.open('<?= base_url('index.php/ordertransfer/cetakot?') ?>bukti='+data['bukti']+'&cetak=2','_blank');
	// 	}
	// }

	function CetakTransferPlain(){
		var data_obj = $('#dataTables-ot tr.active').attr("data");
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			window.open('<?= base_url('index.php/ordertransfer/cetakotplain?') ?>bukti='+data['bukti'],'_blank');
		}
	}
	
	function openformimportot(){
		$("#form-list-ot").modal("show");
		
		loadListOT();
	}
	
	function loadListOT(){
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/ordertransfer/listpilihotlast",
			data: "",
			success: function(msg){
				$("#list_ot").html(msg);
			}
		});
	}
	
	function PilihOT(bukti){
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/ordertransfer/getdatabarangotlast",
			data: "bukti="+bukti,
			success: function(msg){
				$("#table-dummy-ot tbody").html(msg);
				
				$("#form-list-ot").modal("hide");
			}
		});
	}

	function CetakDataOT(){
		var tanggal_awal = $("#search_tanggal_awal").val();
		var tanggal_akhir = $("#search_tanggal_akhir").val();
		var toko_kode = $("#ot_cari_toko").val();
		var nama_toko = $("#ot_cari_toko option:selected").text();
		
		window.open('<?= base_url('index.php/ordertransfer/cetakdataot?') ?>tanggal_awal='+tanggal_awal+'&tanggal_akhir='+tanggal_akhir+'&toko_kode='+toko_kode+'&nama_toko='+nama_toko,'_blank');
	}

	function HitungJumlah(){
		var harga = parseFloat($("#ot_harga").val());
		var kwt = parseFloat($("#ot_kwt").val());
		
		var jumlah = harga * kwt;
		$("#ot_jumlah").val(jumlah);
	}

	function keyEnterBarang(event){
		if (event.which == 13 || event.keyCode == 13) {
	        $.ajax({
	        	type: "POST",
	        	url: "<?php echo base_url(); ?>index.php/barang/gethargabarangsupplier",
	        	data: "barang_kode="+$("#ot_barang_barcode").val(),
	        	success: function(msg){
	        		if(msg == ""){
	        			alert("barang tidak ditemukan");
	        			// $("#pembelian_barang").show();
	        			// LoadListDataBarang();
	        			// $("#pembelian_barang_barcode").hide();
	        		}else{
						var result = msg.split("_wecode_");
						$("#ot_barang_barcode").val(result[2])
						$("#ot_harga").val(result[0]);
						// price("pembelian_harga_beli");
						$("#ot_kwt").val(1);
						// price("pembelian_ppn_beli");
						$("#ot_barang_nama").val(result[3]);
						
						$("#ot_kwt").focus();
						$("#ot_kwt").select();
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
	       		TambahBarangOT("");
	       	}else{
		       	$("#"+selector).focus();
				$("#"+selector).select();
			}
	       	return false;
	    }
	    return true;
	}

	function CetakRekapOrderTransfer(){
		var tanggal_awal = $("#search_tanggal_awal").val();
		var tanggal_akhir = $("#search_tanggal_akhir").val();
		var toko_kode = $("#ot_cari_toko").val()
		window.open('<?= base_url('index.php/ordertransfer/getrekapordertransfer?') ?>tanggal_awal='+tanggal_awal+'&tanggal_akhir='+tanggal_akhir+'&toko_kode='+toko_kode,'_blank');
	}

	function CetakRekapOrderTransferExcel(){
		var tanggal_awal = $("#search_tanggal_awal").val();
		var tanggal_akhir = $("#search_tanggal_akhir").val();
		var toko_kode = $("#ot_cari_toko").val()
		window.open('<?= base_url('index.php/ordertransfer/getrekapordertransfer_xls?') ?>tanggal_awal='+tanggal_awal+'&tanggal_akhir='+tanggal_akhir+'&toko_kode='+toko_kode,'_blank');
	}
</script>