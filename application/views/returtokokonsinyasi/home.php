<style>
	.datepicker{z-index:1151 !important;}
</style>
<div id="page-wrapper">
	<div class="row">
	    <div class="col-lg-12">
	        <h1 style="margin-top: 15px;" class="page-header">Retur Toko Konsinyasi (UN)</h1>
	    </div>
	    <!-- /.col-lg-12 -->
	</div>
	<div class="row" style="margin-bottom: 10px;">
		<div class="col-lg-12">
			<table style="float: right;">
				<tr>
					<td style="width: 200px;">
						<select class="form-control" style="width: 190px;" name="returtoko_cari_toko" id="returtoko_cari_toko">
							<option value="-1">Pilih Toko</option>
						</select>
					</td>
					<td style="width: 110px;">
						<select class="form-control" style="width: 100px;" name="returtoko_cari_mode" id="returtoko_cari_mode">
							<option value="">Semua</option>
							<option value="0">Draft</option>
							<option value="1">Approve</option>
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
						<button id="btn_upload" onclick="LoadDataReturToko()" class="btn btn-info" type="button">
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
					<?php if($this->session->userdata('group_kode') == "GRU0000" || $this->session->userdata('group_kode') == "GRU0001" || $this->session->userdata('group_kode') == "GRU0002"|| $this->session->userdata('group_kode') == "GRU0004" || $this->session->userdata('group_kode') == "GRU0005" || $this->session->userdata('group_kode') == "GRU0012"){ ?>
					<button id="btn_tambah" onclick="openFormReturToko()" class="btn btn-info btn-sm" type="button">
						<i class="fa fa-plus"></i>
						&nbsp;&nbsp;Tambah
					</button>
					<button id="btn_uedit" onclick="openFormEditReturToko()" class="btn btn-success btn-sm" type="button">
						<i class="fa fa-edit"></i>
						&nbsp;&nbsp;Edit
					</button>
					<button id="btn_hapus" fungsi="HapusReturToko()" class="btn btn-danger btn-sm ask-returtoko" type="button">
						<i class="fa fa-times"></i>
						&nbsp;&nbsp;Hapus
					</button>
					<?php } ?>
					<?php if($this->session->userdata('group_kode') == "GRU0000" || $this->session->userdata('group_kode') == "GRU0012" || $this->session->userdata('group_kode') == "GRU0009"){ ?>
					<button id="btn_uedit" onclick="TerimaRetur()" class="btn btn-warning btn-sm" type="button">
						<i class="fa fa-check"></i>
						&nbsp;&nbsp;Terima
					</button>
					<button id="btn_transfertoko" onclick="OpenFormTransferkeToko()" class="btn btn-success btn-sm" type="button">
						<i class="fa fa-check"></i>
						&nbsp;&nbsp;Transfer Ke Toko
					</button>
					<?php } ?>
					<button id="btn_hapus" onclick="CetakTransfer()" class="btn btn-warning btn-sm" type="button">
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
					<div class="table-responsive table-returtoko">
						
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Popup form untuk retur barang -->
	<div class="modal fade" id="form-returtoko" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        			<h4 class="modal-title" id="myModalLabel">Form Retur Barang Toko Konsinyasi</h4>
				</div>
				<div class="modal-body">
					<table style="width: 100%;">
						<tr>
							<td style="width: 200px;">Tanggal :</td>
							<td>&nbsp;&nbsp;
								<input type="hidden" name="mode" id="mode" value="i"/>
								<input type="hidden" name="returtoko_bukti" id="returtoko_bukti"/>
							</td>
							<td>Dari Toko :</td>
							<td>&nbsp;&nbsp;</td>
							<td>Keterangan</td>
						</tr>
						<tr>
							<td>
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</span>
									<input type="text" value="<?= date("Y-m-d"); ?>" name="returtoko_tanggal" id="returtoko_tanggal" class="form-control">
								</div>
							</td>
							<td>&nbsp;&nbsp;</td>
							<td>
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<select class="form-control" name="returtoko_toko" id="returtoko_toko">
										<option value="-1">Pilih Toko</option>
									</select>
								</div>
							</td>
							<td>&nbsp;&nbsp;</td>
							<td>
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<input type="text" name="returtoko_keterangan" id="returtoko_keterangan" class="form-control" />
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
								<!-- <input type="text" class="form-control" name="returtoko_barang" id="returtoko_barang" /> -->
								<input type="text" class="form-control" onkeypress="return keyEnterBarang(event)" style="width: 250px;" name="returtoko_barang_barcode" id="returtoko_barang_barcode" />
								<input type="text" class="form-control" readonly style="width: 250px;" name="returtoko_barang_nama" id="returtoko_barang_nama" />
							</td>
							<td>&nbsp;&nbsp;</td>
							<td><input type="text" style="text-align: right;" class="form-control" onkeyup="merubahkoma('returtoko_harga'); HitungJumlah();" name="returtoko_harga" id="returtoko_harga" /></td>
							<td>&nbsp;&nbsp;</td>
							<td><input type="text" style="text-align: right;" onkeyup="HitungJumlah()" value="0" class="form-control" name="returtoko_kwt" onkeypress="return keyEnterNext(event, '')" id="returtoko_kwt" /></td>
							<td>&nbsp;&nbsp;</td>
							<td><input type="text" style="text-align: right;" readonly class="form-control" name="returtoko_jumlah" id="returtoko_jumlah" /></td>
							<td>&nbsp;&nbsp;</td>
							<td>
								<button id="btn_tambah_barang" onclick="TambahBarangReturToko('')" class="btn btn-success btn-sm" type="button">
									<i class="fa fa-plus"></i>
									&nbsp;&nbsp;Tambah
								</button>
							</td>
						</tr>
					</table>
					<table style="width: 100%" id="table-dummy-returtoko" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th class="text-center">KD Barang</th>
								<th class="text-center">Nama Barang</th>
								<th class="text-center">Saldo Toko</th>
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
			        <button type="button" id="btn-simpan" onclick="SimpanReturToko()" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;&nbsp;Simpan</button>
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
					Bukti Retur Toko :
					<div class="form-group input-group">
						<span class="input-group-addon">
							<i class="fa fa-calendar"></i>
						</span>
						<input type="text" readonly name="transfer_bukti_rt" id="transfer_bukti_rt" class="form-control">
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
</div>
<script>
	$(document).ready(function(){
		OpenMenu();
		LoadDataReturToko();
		LoadListDataBarang();
		loadListToko();
		loadListSupplier();
		
		$('.ask-returtoko').jConfirmAction();
		
		$('#returtoko_tanggal').datepicker({
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

	function AddBarcode(e){
		if (e.keyCode == 13 || e.which == 13) {
	        alert($("#scan_barcode").val());
	        return false;
	    }
	}
	
	function loadListSupplier(){
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/supplier/getselectsupplier",
			data: "",
			success: function(msg){
				$("#returtoko_supplier").html(msg);
				$("#returtoko_supplier").select2();
			}
		});
	}
	
	function loadListToko(){
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/toko/getListDataToko",
			data: "",
			success: function(msg){
				$("#returtoko_toko").html(msg);
				$("#returtoko_cari_toko").html(msg);
				$("#transfer_toko_kode").html(msg);
			}
		});
	}
	
	function LoadDataReturToko(){
		$('#progres-main').show();
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/returtokokonsinyasi/getdatareturtoko",
			data: "tanggal_awal="+$("#search_tanggal_awal").val()+"&tanggal_akhir="+$("#search_tanggal_akhir").val()+"&toko_kode="+$("#returtoko_cari_toko").val()+"&is_approve="+$("#returtoko_cari_mode").val(),
			success: function(msg){
				$(".table-returtoko").html(msg);
				//table = $('#dataTables-returtoko').dataTable();
				$('#progres-main').hide();
				
				$('#dataTables-returtoko tbody').on( 'click', 'tr', function () {
			        if ( $(this).hasClass('active') ) {
			            $(this).removeClass('active');
			        }else {
			            $('#dataTables-returtoko tr.active').removeClass('active');
			            $(this).addClass('active');
			        }
			    } );
			}
		});
	}
	
	function openFormReturToko(){
		$("#form-returtoko").modal("show");
		$("#mode").val("i");
		$("#returtoko_bukti").val("");
	}
	
	function LoadListDataBarang(){
	    $("#returtoko_barang").select2({
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
	    
	    $("#returtoko_barang").on("select2-selecting", function(e) {
	    	// dataperlang = e;
	    	// alert ("selecting val="+ e.choice.satuan_terkecil +" choice="+ JSON.stringify(e.choice));
			$("#btn_tambah_barang").attr("onclick", "TambahBarangReturToko('"+e.choice.satuan+"')");
	    });
	}
	
	function HapusRow(DataObj){
		dataobj = DataObj;
		$(DataObj).parent().parent().remove();
	}
	
	function TambahBarangReturToko(satuan){
		var kd_barang = $("#returtoko_barang_barcode").val();
		var nama_barang = $("#returtoko_barang_nama").val();
		var kwt = $("#returtoko_kwt").val();
		var harga = $("#returtoko_harga").val();
		var jumlah = $("#returtoko_jumlah").val();
		
		var dataArr = [];
	    $("#table-dummy-returtoko td").each(function(){
	        dataArr.push($(this).html());
	    });
		
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/returtokokonsinyasi/getsaldobarangtoko",
			data: "barang_kode="+kd_barang+"&toko_kode="+$("#returtoko_toko").val(),
			success: function(msg){
				var row = "<tr><td>"+kd_barang+"</td><td>"+nama_barang+"</td><td class=\"text-right\">"+msg+"</td><td class=\"text-right\">"+kwt+"</td><td class=\"text-right\">"+harga+"</td><td class=\"text-right\">"+jumlah+"</td><td class=\"text-center\"><button type=\"button\" style=\"padding: 0px 20px;\" onclick=\"HapusRow(this)\" class=\"btn btn-danger btn-sm\"><i class=\"fa fa-times\"></i></button></td></tr>";
				
				if(dataArr.length > 0){
					$('#table-dummy-returtoko > tbody > tr:first').before(row);
				}else{
					$('#table-dummy-returtoko > tbody:last').append(row);
				}

				$("#returtoko_barang_barcode").val("");
				$("#returtoko_barang_nama").val("");
				$("#returtoko_kwt").val("0");
				$("#returtoko_harga").val("0");
				$("#returtoko_jumlah").val("0");
				$("#returtoko_barang_barcode").focus();
			}
		});
	}
	
	function clearForm(){
		$('#table-dummy-returtoko tbody').html("");
		$("#returtoko_barang").select2("val", "");
		$("#returtoko_kwt").val("");
	}
	
	function SimpanReturToko(){
		$('#btn-simpan').hide();
		$('#loader-form').show();
		
		var dataArr = [];
	    $("#table-dummy-returtoko td").each(function(){
	        dataArr.push($(this).html());
	    });
	    var mode = $("#mode").val();
		var bukti = $("#returtoko_bukti").val();
		
		if(mode == "i"){
			var modeBukti = "UN";
			var tanggal_od = $("#returtoko_tanggal").val();
			$.ajax({
				type: "POST",
				url: "<?= base_url() ?>index.php/bukti/generatebukti",
				data: "mode="+modeBukti+"&tanggal="+tanggal_od,
				success: function(msg){
					ajaxsimpanreturtoko(msg, dataArr, 0);
				}
			});
		}else{
			$.ajax({
				type: "POST",
				url: "<?= base_url(); ?>index.php/returtokokonsinyasi/hapusreturtoko",
				data: "bukti="+bukti,
				success: function(msg){
					ajaxsimpanreturtoko(bukti, dataArr, 0);
				}
			});
		}
	}
	
	function ajaxsimpanreturtoko(bukti, dataArr, index){
		var kd_barang = dataArr[index];
		var kwt = dataArr[index+3];
		var harga = dataArr[index+4];
		var jumlah = dataArr[index+5];
		var tanggal = $("#returtoko_tanggal").val();
		var kd_toko = $("#returtoko_toko").val();
		var keterangan = $("#returtoko_keterangan").val();
		var mode = $("#mode").val();
		
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/returtokokonsinyasi/simpanreturtoko",
			data: "mode="+mode+"&bukti="+bukti+"&barang_kode="+kd_barang+"&kwt="+kwt+"&harga="+harga+"&jumlah="+jumlah+"&tanggal="+tanggal+"&toko_kode="+kd_toko+"&keterangan="+keterangan,
			success: function(msg){
				index = index + 7;
				if(index >= dataArr.length){ // jika sudah sampai index yang terakhir
					$('#btn-simpan').show();
					$('#loader-form').hide();
					
					ShowMessage("success", "Data berhasil disimpan");
					LoadDataReturToko();
					$("#form-returtoko").modal("hide");
				}else{ // jika masih ada data yang dimasukkan
					ajaxsimpanreturtoko(bukti, dataArr, index);
				}
			},
			error: function(xhr,status,error){
				ShowMessage("danger", "Data gagal disimpan");
				$('#btn-simpan').show();
				$('#loader-form').hide();
			}
		});
	}
	
	function HapusReturToko(){
		var data_obj = $('#dataTables-returtoko tr.active').attr("data");
		
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			if(data['is_approve'] == "1"){
				alert("Retur tidak bisa dihapus kerena sudah dilakukan penerimaan");
			}else{
				$('#progres-main').show();
				$.ajax({
					type: "POST",
					url: "<?= base_url(); ?>index.php/returtokokonsinyasi/hapusreturtoko",
					data: "bukti="+data['bukti'],
					success: function(msg){
						ShowMessage("success", "Data berhasil dihapus");
						LoadDataReturToko();
					}
				});
			}
		}
	}
	
	function openFormEditReturToko(){
		var data_obj = $('#dataTables-returtoko tr.active').attr("data");
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			if(data['is_approve'] == "1"){
				alert("Retur tidak bisa diedit kerena sudah dilakukan penerimaan");
			}else{
				$("#mode").val("e");
				$("#returtoko_bukti").val(data['bukti']);
				$("#returtoko_keterangan").val(data['keterangan']);
				$("#returtoko_tanggal").val(data['tanggal']);
				$("#returtoko_toko").val(data['toko_kode']);
				
				$.ajax({
					type: "POST",
					url: "<?= base_url() ?>index.php/returtokokonsinyasi/getdatabarangreturtoko",
					data: "bukti="+data['bukti']+"&toko_kode="+data['toko_kode'],
					success: function(msg){
						$("#table-dummy-returtoko tbody").html(msg);
					}
				});
				
				$("#form-returtoko").modal("show");
			}
		}
	}
	
	function ListBarangSupplier(){
		var supplier_kode = $("#returtoko_supplier").val();
		var toko_kode = $("#returtoko_toko").val();
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/returtokokonsinyasi/getdatabarangsupplier",
			data: "supplier_kode="+supplier_kode+"&toko_kode="+toko_kode,
			success: function(msg){
				$("#table-dummy-returtoko tbody").html(msg);
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
	
	function TerimaRetur(){
		var data_obj = $('#dataTables-returtoko tr.active').attr("data");
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			if(data['is_approve'] == "1"){
				alert("Retur sudah dilakukan penerimaan");
			}else{
				var ConfirmTerima = confirm("Apakah retur barang dari toko sudah diterima?");
				if(ConfirmTerima){
					$.ajax({
						type: "POST",
						url: "<?= base_url() ?>index.php/returtokokonsinyasi/terimaretur",
						data: "bukti="+data['bukti']+"&toko_kode="+data['toko_kode'],
						success: function(msg){
							LoadDataReturToko();
						}
					})
				}
			}
		}
	}
	
	function CetakTransfer(){
		var data_obj = $('#dataTables-returtoko tr.active').attr("data");
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			window.open('<?= base_url('index.php/returtokokonsinyasi/cetakreturtoko?') ?>bukti='+data['bukti']+'&toko_kode='+data['toko_kode'],'_blank');
		}
	}

	function HitungJumlah(){
		var harga = parseFloat($("#returtoko_harga").val());
		var kwt = parseFloat($("#returtoko_kwt").val());
		
		var jumlah = harga * kwt;
		$("#returtoko_jumlah").val(jumlah);
	}

	function keyEnterBarang(event){
		if (event.which == 13 || event.keyCode == 13) {
	        $.ajax({
	        	type: "POST",
	        	url: "<?php echo base_url(); ?>index.php/barang/gethargabarangsupplier",
	        	data: "barang_kode="+$("#returtoko_barang_barcode").val(),
	        	success: function(msg){
	        		if(msg == ""){
	        			alert("barang tidak ditemukan");
	        			// $("#pembelian_barang").show();
	        			// LoadListDataBarang();
	        			// $("#pembelian_barang_barcode").hide();
	        		}else{
						var result = msg.split("_wecode_");
						$("#returtoko_barang_barcode").val(result[2])
						$("#returtoko_harga").val(result[0]);
						// price("pembelian_harga_beli");
						$("#returtoko_kwt").val(1);
						// price("pembelian_ppn_beli");
						$("#returtoko_barang_nama").val(result[3]);
						
						$("#returtoko_kwt").focus();
						$("#returtoko_kwt").select();
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
	       		TambahBarangReturToko("");
	       	}else{
		       	$("#"+selector).focus();
				$("#"+selector).select();
			}
	       	return false;
	    }
	    return true;
	}

	function OpenFormTransferkeToko(){
		var data_obj = $('#dataTables-returtoko tr.active').attr("data");
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			if(data['is_approve'] == "1"){
				$("#form-transfer-ketoko").modal("show");
				$("#transfer_bukti_rt").val(data['bukti']);
				
				$("#loader-form-transfer").hide();
				$("#btn-simpan-transfer").show();
			}else{
				alert("Retur toko belum diapprove");
			}
		}
	}

	function SimpanTransferToko(){
		$("#loader-form-transfer").show();
		$("#btn-simpan-transfer").hide();
			
		var data_obj = $('#dataTables-returtoko tr.active').attr("data");
		var data = json_decode(base64_decode(data_obj));
		
		var toko_kode = $("#transfer_toko_kode").val();
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/returtokokonsinyasi/simpantransferketoko",
			data: "bukti_rt="+data['bukti']+"&tanggal="+data['tanggal']+"&toko_kode="+toko_kode,
			success: function(msg){
				var buktiTG = "";
				if(msg.substring(0, 1) == "S"){
					alert("Retur Toko sudah ditransfer ke toko");
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
</script>