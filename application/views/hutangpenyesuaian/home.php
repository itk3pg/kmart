<style>
	.datepicker{z-index:1151 !important;}
</style>
<div id="page-wrapper">
	<div class="row">
	    <div class="col-lg-12">
	        <h1 style="margin-top: 15px;" class="page-header">Penyesuaian Hutang</h1>
	    </div>
	    <!-- /.col-lg-12 -->
	</div>
	<div class="row" style="margin-bottom: 10px;">
		<div class="col-lg-12">
			<table style="float: right;">
				<tr>
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
						<button id="btn_upload" onclick="LoadDataHutangPenyesuaian()" class="btn btn-info" type="button">
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
					<button id="btn_tambah" onclick="openFormHutangPenyesuaian()" class="btn btn-info btn-sm" type="button">
						<i class="fa fa-plus"></i>
						&nbsp;&nbsp;Tambah
					</button>
					<!--<button id="btn_uedit" onclick="openFormEditHutangPenyesuaian()" class="btn btn-success btn-sm" type="button">
						<i class="fa fa-edit"></i>
						&nbsp;&nbsp;Edit
					</button>-->
					<button id="btn_hapus" fungsi="HapusHutangPenyesuaian()" class="btn btn-danger btn-sm ask-hutangpenyesuaian" type="button">
						<i class="fa fa-times"></i>
						&nbsp;&nbsp;Hapus
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
					<div class="table-responsive table-hutangpenyesuaian">
						
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Popup form untuk retur barang -->
	<div class="modal fade" id="form-hutangpenyesuaian" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        			<h4 class="modal-title" id="myModalLabel">Form Penyesuaian Hutang</h4>
				</div>
				<div class="modal-body">
					<table style="width: 100%;">
						<tr>
							<td style="width: 200px;">Tanggal :</td>
							<td>&nbsp;&nbsp;
								<input type="hidden" name="mode" id="mode" value="i"/>
								<input type="hidden" name="hutangpenyesuaian_bukti" id="hutangpenyesuaian_bukti"/>
							</td>
							<td>Supplier :</td>
						</tr>
						<tr>
							<td>
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</span>
									<input type="text" value="<?= date("Y-m-d"); ?>" placeholder="Tanggal OT" name="hutangpenyesuaian_tanggal" id="hutangpenyesuaian_tanggal" class="form-control">
								</div>
							</td>
							<td>&nbsp;&nbsp;</td>
							<td>
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<select class="form-control" name="hutangpenyesuaian_supplier" id="hutangpenyesuaian_supplier">
										<option value="-1">Pilih Supplier</option>
									</select>
								</div>
							</td>
						</tr>
					</table>
					<label class="radio-inline">
						<input id="hutangpenyesuaian_status_tambah" checked type="radio" value="HM" name="hutangpenyesuaian_status"> Penambahan Hutang
					</label>
					<label class="radio-inline">
						<input id="hutangpenyesuaian_status_kurang" type="radio" value="HK" name="hutangpenyesuaian_status"> Pengurangan Hutang
					</label>
					<br/>
					<br/>
					<table>
						<tr>
							<td>
								Bukti Pengadaan Barang :
								<div class="form-group input-group">
									<input type="text" class="form-control" style="width: 250px;" name="hutangpenyesuaian_buktibi" id="hutangpenyesuaian_buktibi" />
								</div>
								Penyesuaian :
								<div class="form-group input-group">
									<input type="text" class="form-control" onkeyup="HitungTotalHutang()" style="width: 250px; text-align: right;" name="hutangpenyesuaian_penyesuaian" id="hutangpenyesuaian_penyesuaian" />
								</div>
								
							</td>
							<td>&nbsp;&nbsp;</td>
							<td>
								Jumlah Hutang :
								<div class="form-group input-group">
									<input type="text" class="form-control" readonly style="width: 250px; text-align: right;" name="hutangpenyesuaian_jumlahbi" id="hutangpenyesuaian_jumlahbi" />
								</div>
								Total Hutang :
								<div class="form-group input-group">
									<input type="text" class="form-control" readonly style="width: 250px; text-align: right;" name="hutangpenyesuaian_totalhutang" id="hutangpenyesuaian_totalhutang" />
								</div>
							</td>
						</tr>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" onclick="clearForm()" class="btn btn-default">Reset</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<img src="<?= base_url() ?>/images/loader.gif" id="loader-form"  style="width: 30px; display: none;" />
			        <button type="button" id="btn-simpan" onclick="SimpanHutangPenyesuaian()" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;&nbsp;Simpan</button>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		OpenMenu();
		LoadDataHutangPenyesuaian();
		loadListSupplier();
		LoadListDataTransaksi();
		
		$('.ask-hutangpenyesuaian').jConfirmAction();
		
		$('#hutangpenyesuaian_tanggal').datepicker({
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
				$("#hutangpenyesuaian_supplier").html(msg);
				$("#hutangpenyesuaian_supplier").select2();
			}
		});
	}
	
	function LoadListDataTransaksi(){
	    $("#hutangpenyesuaian_buktibi").select2({
		    placeholder: "Cari Bukti Pengadaan",
		    minimumInputLength: 1,
		    ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
			    url: "<?php echo base_url(); ?>index.php/hutang/getlisthutangpenyesuaian",
			    dataType: 'json',
			    quietMillis: 250,
			    data: function (term, page) {
				    return {
				    	q: term, // search term
						supplier_kode: $("#hutangpenyesuaian_supplier").val(),
				    };
			    },
			    results: function (data, page) { // parse the results into the format expected by Select2.
			    	// since we are using custom formatting functions we do not need to alter the remote JSON data
			    	return { results: data.items };
			    },
			    cache: true
		    },
		    id: function(option){
		    	return option.ref_pengadaan;
		    },
		    formatResult: function (option) {
            	return "<span class=\"select2-match\"></span>"+option.ref_pengadaan;
            }, 
		    formatSelection: function (option) {
            	return option.ref_pengadaan;
            }
	    });
	    
	    $("#hutangpenyesuaian_buktibi").on("select2-selecting", function(e) {
	    	// dataperlang = e;
	    	// alert ("selecting val="+ e.choice.satuan_terkecil +" choice="+ JSON.stringify(e.choice));
			/*var row = "<tr><td>"+e.choice.ref_penjualan+"</td><td>"+e.choice.tanggal+"</td><td>"+e.choice.pelanggan_kode+"</td><td>"+e.choice.nama_pelanggan+"</td><td>"+e.choice.jatuh_tempo+"</td><td>"+e.choice.jumlah+"</td><td><button type=\"button\" onclick=\"HapusRow(this)\" class=\"btn btn-default\"><i class=\"fa fa-times\"></i></button></td></tr>";
			$('#table-dummy-kuitansitrans > tbody:last').append(row);*/
			$("#hutangpenyesuaian_jumlahbi").val(e.choice.jumlah);
	    });
	}
	
	function LoadDataHutangPenyesuaian(){
		$('#progres-main').show();
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/hutangpenyesuaian/getdatahutangpenyesuaian",
			data: "tahun="+$("#tahun").val()+"&bulan="+$("#bulan").val(),
			success: function(msg){
				$(".table-hutangpenyesuaian").html(msg);
				//table = $('#dataTables-hutangpenyesuaian').dataTable();
				$('#progres-main').hide();
				
				$('#dataTables-hutangpenyesuaian tbody').on( 'click', 'tr', function () {
			        if ( $(this).hasClass('active') ) {
			            $(this).removeClass('active');
			        }else {
			            $('#dataTables-hutangpenyesuaian tr.active').removeClass('active');
			            $(this).addClass('active');
			        }
			    } );
			}
		});
	}
	
	function openFormHutangPenyesuaian(){
		$("#form-hutangpenyesuaian").modal("show");
		$("#mode").val("i");
		$("#hutangpenyesuaian_bukti").val("");
	}
	
	function clearForm(){
		
	}
	
	function SimpanHutangPenyesuaian(){
		$('#btn-simpan').hide();
		$('#loader-form').show();
		
	    var mode = $("#mode").val();
		var bukti = $("#hutangpenyesuaian_bukti").val();
		var supplier_kode = $("#hutangpenyesuaian_supplier").val();
		var modePenyesuaian = $("input[name=hutangpenyesuaian_status]:checked").val();
		
		if(mode == "i"){
			var tanggal_hutangpenyesuaian = $("#hutangpenyesuaian_tanggal").val();
			$.ajax({
				type: "POST",
				url: "<?= base_url() ?>index.php/bukti/generatebukti",
				data: "mode="+modePenyesuaian+"&tanggal="+tanggal_hutangpenyesuaian,
				success: function(msg){
					ajaxsimpanhutangpenyesuaian(msg);
				}
			});
		}else{
			$.ajax({
				type: "POST",
				url: "<?= base_url(); ?>index.php/hutangpenyesuaian/hapushutangpenyesuaian",
				data: "bukti="+bukti+"&supplier_kode="+supplier_kode,
				success: function(msg){
					ajaxsimpanhutangpenyesuaian(bukti);
				}
			});
		}
	}
	
	function ajaxsimpanhutangpenyesuaian(bukti){
		var jumlah = $("#hutangpenyesuaian_penyesuaian").val()
		var tanggal = $("#hutangpenyesuaian_tanggal").val();
		var supplier_kode = $("#hutangpenyesuaian_supplier").val();
		var pengadaan_barang_bukti = $("#hutangpenyesuaian_buktibi").val();
		var mode = $("#mode").val();
		
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/hutangpenyesuaian/simpanhutangpenyesuaian",
			data: "mode="+mode+"&bukti="+bukti+"&pengadaan_barang_bukti="+pengadaan_barang_bukti+"&jumlah="+jumlah+"&tanggal="+tanggal+"&supplier_kode="+supplier_kode,
			success: function(msg){
				$('#btn-simpan').show();
				$('#loader-form').hide();
				
				ShowMessage("success", "Data berhasil disimpan");
				LoadDataHutangPenyesuaian();
				$("#form-hutangpenyesuaian").modal("hide");
			},
			error: function(xhr,status,error){
				ShowMessage("danger", "Data gagal disimpan");
				$('#btn-simpan').show();
				$('#loader-form').hide();
			}
		});
	}
	
	function HapusHutangPenyesuaian(){
		var data_obj = $('#dataTables-hutangpenyesuaian tr.active').attr("data");
		
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			
			if(data['tukar_nota_bukti'] != "" && data['tukar_nota_bukti'] == "null"){
				alert("Penyesuaian Hutang sudah direalisasikan");
			}else{
				$('#progres-main').show();
				$.ajax({
					type: "POST",
					url: "<?= base_url(); ?>index.php/hutangpenyesuaian/hapushutangpenyesuaian",
					data: "bukti="+data['bukti']+"&supplier_kode="+data['supplier_kode'],
					success: function(msg){
						ShowMessage("success", "Data berhasil dihapus");
						LoadDataHutangPenyesuaian();
					}
				});
			}
		}
	}
	
	function HitungTotalHutang(){
		var jumlahhutang = $("#hutangpenyesuaian_jumlahbi").val();
		var penyesuaian = $("#hutangpenyesuaian_penyesuaian").val();
		
		var modePenyesuaian = $("input[name=hutangpenyesuaian_status]:checked").val();
		var totalhutang = parseFloat(jumlahhutang) - parseFloat(penyesuaian);
		if(modePenyesuaian == "HM"){
			totalhutang = parseFloat(jumlahhutang) + parseFloat(penyesuaian);
		}
		
		$("#hutangpenyesuaian_totalhutang").val(totalhutang);
	}
	
	function openFormEditHutangPenyesuaian(){
		var data_obj = $('#dataTables-hutangpenyesuaian tr.active').attr("data");
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			if(data['tukar_nota_bukti'] != "" && data['tukar_nota_bukti'] == "null"){
				alert("Penyesuaian Hutang sudah direalisasikan");
			}else{
				$("#mode").val("e");
				$("#hutangpenyesuaian_bukti").val(data['bukti']);
				$("#hutangpenyesuaian_tanggal").val(data['tanggal']);
				$("#hutangpenyesuaian_supplier").select2("val", data['supplier_kode']);
				if(data['bukti'].substr(0,2) == "HK"){
					$("#hutangpenyesuaian_status_kurang").prop("checked", "checked");
				}else if(data['bukti'].substr(0,2) == "HM"){
					$("#hutangpenyesuaian_status_tambah").prop("checked", "checked");
				}
				
				$.ajax({
					type: "POST",
					url: "<?= base_url() ?>index.php/hutangpenyesuaian/getdetailhutangpenyesuaian",
					data: "bukti="+data['bukti']+"&supplier_kode="+data['supplier_kode'],
					success: function(msg){
						$("#table-dummy-hutangpenyesuaian tbody").html(msg);
					}
				});
				
				$("#form-hutangpenyesuaian").modal("show");
			}
		}
	}
</script>