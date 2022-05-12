<style>
	.datepicker{z-index:1151 !important;}
</style>
<div id="page-wrapper">
	<div class="row">
	    <div class="col-lg-12">
	        <h1 style="margin-top: 15px;" class="page-header">Data Biaya Keluar</h1>
	    </div>
	    <!-- /.col-lg-12 -->
	</div>
	<div class="row">
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
						<button id="btn_upload" onclick="LoadDataTAUKeluar()" class="btn btn-info" type="button">
							<i class="fa fa-search"></i>
							&nbsp;&nbsp;Search
						</button>
					</td>
					<td>&nbsp;&nbsp;</td>
					<td valign="middle">
						<button id="btn_upload" onclick="CetakRekapTAUKeluar()" class="btn btn-success" type="button">
							<i class="fa fa-print"></i>
							&nbsp;&nbsp;Rekap Harian (pdf)
						</button>
					</td>
					<td>&nbsp;&nbsp;</td>
					<td valign="middle">
						<button id="btn_upload" onclick="CetakRekapTAUKeluarExcel()" class="btn btn-success" type="button">
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
                    <button id="btn_open" onclick="openFormTAUKeluar()" class="btn btn-info btn-sm" type="button">
						<i class="fa fa-plus"></i>
						&nbsp;&nbsp;Tambah
					</button>
					<button id="btn_uedit" onclick="openFormEditTAUKeluar()" class="btn btn-success btn-sm" type="button">
						<i class="fa fa-edit"></i>
						&nbsp;&nbsp;Edit
					</button>
					<button id="btn_upload" fungsi="HapusTAUKeluar()" class="btn btn-danger btn-sm ask" type="button">
						<i class="fa fa-times"></i>
						&nbsp;&nbsp;Hapus
					</button>
					<button id="btn_cetak" onclick="cetakNotaTAUKeluar()" class="btn btn-success btn-sm" type="button">
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
					<div class="table-responsive table-taukeluar">
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Popup form untuk TAU Keluar	-->
	<div class="modal fade" id="form-taukeluar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        			<h4 class="modal-title" id="myModalLabel">Form TAU Keluar (TK)</h4>
				</div>
				<div class="modal-body">
					<table style="width: 80%;">
						<tr>
							<td style="width: 200px;">Tanggal :</td>
							<td>&nbsp;&nbsp;
								<input type="hidden" name="mode" id="mode" value="i"/>
								<input type="hidden" name="taukeluar_bukti" id="taukeluar_bukti"/>
							</td>
							<td style="width: 250px;">Pelanggan :</td>
						</tr>
						<tr>
							<td>
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</span>
									<input type="text" readonly value="<?= date("Y-m-d"); ?>" name="taukeluar_tanggal" id="taukeluar_tanggal" class="form-control">
								</div>
							</td>
							<td>&nbsp;&nbsp;</td>
							<td>
								<input type="text" class="form-control" name="taukeluar_pelanggan" id="taukeluar_pelanggan" />
							</td>
							<td>&nbsp;&nbsp;</td>
							<td>
								<button style="margin-bottom:10px;" type="button" id="btn-import-ot" onclick="openformimportrt()" class="btn btn-success">Import Dari Retur Toko</button>
							</td>
						</tr>
					</table>
					<input type="hidden" name="bukti_od" id="bukti_od" />
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
								<!-- <input type="text" class="form-control" name="taukeluar_barang" id="taukeluar_barang" /> -->
								<input type="text" class="form-control" onkeypress="return keyEnterBarang(event)" style="width: 250px;" name="taukeluar_barang_barcode" id="taukeluar_barang_barcode" />
								<input type="text" class="form-control" readonly style="width: 250px;" name="taukeluar_barang_nama" id="taukeluar_barang_nama" />
							</td>
							<td>&nbsp;&nbsp;</td>
							<td><input type="text" style="text-align: right;" class="form-control" onkeyup="merubahkoma('taukeluar_harga'); HitungJumlah();" name="taukeluar_harga" id="taukeluar_harga" /></td>
							<td>&nbsp;&nbsp;</td>
							<td><input type="text" style="text-align: right;" onkeyup="HitungJumlah()" value="0" class="form-control" name="taukeluar_kwt" onkeypress="return keyEnterNext(event, '')" id="taukeluar_kwt" /></td>
							<td>&nbsp;&nbsp;</td>
							<td><input type="text" style="text-align: right;" readonly class="form-control" name="taukeluar_jumlah" id="taukeluar_jumlah" /></td>
							<td>&nbsp;&nbsp;</td>
							<td>
								<button id="btn_tambah_barang" onclick="TambahBarangTAUKeluar('')" class="btn btn-success btn-sm" type="button">
									<i class="fa fa-plus"></i>
									&nbsp;&nbsp;Tambah
								</button>
							</td>
						</tr>
					</table>
					<table style="width: 100%" id="table-dummy-taukeluar" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th class="text-center">KD Barang</th>
								<th class="text-center">Nama Barang</th>
								<th class="text-center">Satuan</th>
								<th class="text-center">Kwt</th>
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
			        <button type="button" id="btn-simpan" onclick="SimpanTAUKeluar()" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;&nbsp;Simpan</button>
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
        			<h4 class="modal-title" id="myModalLabel">List Retur Toko (RT)</h4>
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
		
		LoadDataTAUKeluar();
		LoadListDataBarang();
		LoadListPelanggan();
		
		$('#taukeluar_tanggal').datepicker({
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
	
	function LoadDataTAUKeluar(){
		$('#progres-main').show();
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/taukeluar/getdatataukeluar",
			data: "tanggal_awal="+$("#search_tanggal_awal").val()+"&tanggal_akhir="+$("#search_tanggal_akhir").val(),
			success: function(msg){
				$(".table-taukeluar").html(msg);
				//table = $('#dataTables-od').dataTable();
				$('#progres-main').hide();
				
				$('#dataTables-taukeluar tbody').on( 'click', 'tr', function () {
			        if ( $(this).hasClass('active') ) {
			            $(this).removeClass('active');
			        }else {
			            $('#dataTables-taukeluar tr.active').removeClass('active');
			            $(this).addClass('active');
			        }
			    } );
			}
		});
	}
	
	function LoadListDataBarang(){
	    $("#taukeluar_barang").select2({
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
            	return "<span class=\"select2-match\"></span>"+option.kode+" - "+option.nama_barang;
            }, 
		    formatSelection: function (option) {
            	return option.nama_barang;
            }
	    });
		
		$("#taukeluar_barang").on("select2-selecting", function(e) {
	    	// dataperlang = e;
	    	// alert ("selecting val="+ e.choice.satuan_terkecil +" choice="+ JSON.stringify(e.choice));
			$("#btn_tambah_barang").attr("onclick", "TambahBarangTAUKeluar('"+e.choice.satuan+"')");
			getHPPBarang(e.choice.kode, e.choice.hpp);
	    });
	}

	function LoadListPelanggan(){
	    $("#taukeluar_pelanggan").select2({
		    placeholder: "Cari Pelanggan",
		    minimumInputLength: 1,
		    ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
			    url: "<?php echo base_url(); ?>index.php/barang/getlistpelanggan",
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
	}
	
	function openFormTAUKeluar(){
		$("#mode").val("i");
		$("#form-taukeluar").modal("show");

		$("#taukeluar_barang_barcode").focus();
	}
	
	function getHPPBarang(barang_kode, hpp){
		$("#taukeluar_harga").val(round(hpp,2));
		/*$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/barang/gethppbarang",
			data: "barang_kode="+barang_kode,
			success: function(msg){
				$("#taukeluar_harga").val('10000');
			}
		});*/
	}
	
	function HitungJumlah(){
		var harga = parseFloat($("#taukeluar_harga").val());
		var kwt = parseFloat($("#taukeluar_kwt").val());
		
		var jumlah = harga * kwt;
		$("#taukeluar_jumlah").val(jumlah);
	}
	
	function TambahBarangTAUKeluar(satuan){
		var barang_kode = $("#taukeluar_barang_barcode").val();
		var nama_barang = $("#taukeluar_barang_nama").val();
		var kwt = $("#taukeluar_kwt").val();
		var harga = $("#taukeluar_harga").val();
		var jumlah = $("#taukeluar_jumlah").val();
		
		var row = "<tr><td>"+barang_kode+"</td><td>"+nama_barang+"</td><td>"+satuan+"</td><td class=\"text-right\">"+kwt+"</td><td class=\"text-right\">"+harga+"</td><td class=\"text-right\">"+jumlah+"</td><td class=\"text-center\"><button type=\"button\" onclick=\"HapusRow(this)\" class=\"btn btn-danger btn-sm\"><i class=\"fa fa-times\"></i></button></td></tr>";
		$('#table-dummy-taukeluar > tbody:last').append(row);

		$("#taukeluar_barang_barcode").val("");
		$("#taukeluar_barang_nama").val("");
		$("#taukeluar_kwt").val("0");
		$("#taukeluar_harga").val("0");
		$("#taukeluar_jumlah").val("0");

		$("#taukeluar_barang_barcode").focus();
	}
	
	function HapusRow(DataObj){
		dataobj = DataObj;
		dataobj = DataObj;
		$(DataObj).parent().parent().remove();
	}
	
	function SimpanTAUKeluar(){
		$('#btn-simpan').hide();
		$('#loader-form').show();
		
		var dataArr = [];
	    $("#table-dummy-taukeluar td").each(function(){
	        dataArr.push($(this).html());
	    });
	    
		var taukeluar_mode = $("#mode").val();
		
		if(taukeluar_mode == "i"){
			var modeBukti = "TK";
			
			var tanggal_taukeluar = $("#taukeluar_tanggal").val();
			$.ajax({
				type: "POST",
				url: "<?= base_url() ?>index.php/bukti/generatebukti",
				data: "mode="+modeBukti+"&tanggal="+tanggal_taukeluar,
				success: function(msg){
					var jsonData = rawurlencode(json_encode(dataArr));
					SimpanDetailTAUKeluar(msg, jsonData);
				}
			});
		}else{
			var bukti = $("#taukeluar_bukti").val();
			$.ajax({
				type: "POST",
				url: "<?= base_url(); ?>index.php/taukeluar/hapustaukeluar",
				data: "bukti="+bukti,
				success: function(msg){
					var jsonData = rawurlencode(json_encode(dataArr));
					SimpanDetailTAUKeluar(bukti, jsonData);
				}
			});
		}
	}
	
	function SimpanDetailTAUKeluar(bukti, jsondata){
		var pelanggan_kode = $("#taukeluar_pelanggan").val();
		var tanggal_taukeluar = $("#taukeluar_tanggal").val();
		var taukeluar_mode = $("#mode").val();
		
		$.ajax({
			type: "POST",
			url: "<?= base_url(); ?>index.php/taukeluar/simpantaukeluar",
			data: "data="+jsondata+"&bukti="+bukti+"&pelanggan_kode="+pelanggan_kode+"&tanggal="+tanggal_taukeluar+"&taukeluar_mode="+taukeluar_mode,
			success: function(msg){
				$('#btn-simpan').show();
				$('#loader-form').hide();
				clearForm();
				$('#form-taukeluar').modal('hide');
				
				ShowMessage('success', 'Data berhasil disimpan');
				LoadDataTAUKeluar();
			},
			error: function(xhr,status,error){
				alert(status);
				$('#btn-simpan').show();
				$('#loader-form').hide();
			}
		});
	}
	
	function openFormEditTAUKeluar(){
		var data_obj = $('#dataTables-taukeluar tr.active').attr("data");
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			
			$("#mode").val("e");
			$("#taukeluar_bukti").val(data['bukti']);
			$("#taukeluar_tanggal").val(data['tanggal']);
			$("#taukeluar_pelanggan").val(data['pelanggan_kode']);
			$("#select2-chosen-2").html(data['nama_pelanggan']);
			
			$.ajax({
				type: "POST",
				url: "<?= base_url() ?>index.php/taukeluar/getdatabarangtaukeluar",
				data: "bukti="+data['bukti'],
				success: function(msg){
					$("#table-dummy-taukeluar tbody").html(msg);
				}
			});
			
			$("#form-taukeluar").modal("show");
		}
	}
	
	function clearForm(){
		$("#mode").val("i");
		$("#taukeluar_bukti").val("");
		$("#taukeluar_pelanggan").select2("val", "");
		$("#select2-chosen-2").html("Cari pelanggan");
		$("#taukeluar_barang").select2("val", "");
		$("#select2-chosen-1").html("Cari barang");
		$("#taukeluar_harga").val("0");
		$("#taukeluar_kwt").val("0");
		$("#taukeluar_jumlah").val("0");
		
		$('#table-dummy-taukeluar tbody').html("");
	}
	
	function HapusTAUKeluar(){
		var data_obj = $('#dataTables-taukeluar tr.active').attr("data");
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			
			$.ajax({
				type: "POST",
				url: "<?= base_url(); ?>index.php/taukeluar/hapustaukeluar",
				data: "bukti="+data['bukti'],
				success: function(msg){
					LoadDataTAUKeluar();
				},
				error: function(xhr,status,error){
					alert(status);
				}
			});
		}
	}
	
	function merubahkoma(id){
		var content = $("#"+id).val();
		var edit = content.replace(",", ".");
		$("#"+id).val(edit);
	}
	
	function cetakNotaTAUKeluar(){
		var data_obj = $('#dataTables-taukeluar tr.active').attr("data");
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			window.open('<?= base_url('index.php/taukeluar/cetaktaukeluar?') ?>bukti='+data['bukti'],'_blank');
		}
	}

	function keyEnterBarang(event){
		if (event.which == 13 || event.keyCode == 13) {
	        $.ajax({
	        	type: "POST",
	        	url: "<?php echo base_url(); ?>index.php/barang/gethargabarangsupplier",
	        	data: "barang_kode="+$("#taukeluar_barang_barcode").val(),
	        	success: function(msg){
	        		if(msg == ""){
	        			alert("barang tidak ditemukan");
	        			// $("#pembelian_barang").show();
	        			// LoadListDataBarang();
	        			// $("#pembelian_barang_barcode").hide();
	        		}else{
						var result = msg.split("_wecode_");
						$("#taukeluar_barang_barcode").val(result[2])
						$("#taukeluar_harga").val(result[0]);
						// price("pembelian_harga_beli");
						$("#taukeluar_kwt").val(1);
						// price("pembelian_ppn_beli");
						$("#taukeluar_barang_nama").val(result[3]);
						
						$("#taukeluar_kwt").focus();
						$("#taukeluar_kwt").select();
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
	       		TambahBarangTAUKeluar("");
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
			url: "<?= base_url() ?>index.php/returtoko/listpilihreturtokoapprove",
			data: "tahun="+$("#list_rt_tahun").val()+"&bulan="+$("#list_rt_bulan").val(),
			success: function(msg){
				$("#list_rt").html(msg);
			}
		});
	}

	function PilihRT(bukti, toko_kode){
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/returtoko/getdatabarangrttk",
			data: "bukti="+bukti+"&toko_kode="+toko_kode,
			success: function(msg){
				$("#table-dummy-taukeluar tbody").html(msg);
				
				$("#form-list-rt").modal("hide");
			}
		});
	}

	function CetakRekapTAUKeluar(){
		var tanggal_awal = $("#search_tanggal_awal").val();
		var tanggal_akhir = $("#search_tanggal_akhir").val();
		window.open('<?= base_url('index.php/taukeluar/getrekaptaukeluar?') ?>tanggal_awal='+tanggal_awal+'&tanggal_akhir='+tanggal_akhir,'_blank');
	}

	function CetakRekapTAUKeluarExcel(){
		var tanggal_awal = $("#search_tanggal_awal").val();
		var tanggal_akhir = $("#search_tanggal_akhir").val();
		window.open('<?= base_url('index.php/taukeluar/getrekaptaukeluar_xls?') ?>tanggal_awal='+tanggal_awal+'&tanggal_akhir='+tanggal_akhir,'_blank');
	}
</script>