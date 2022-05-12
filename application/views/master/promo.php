<style>
	.datepicker{z-index:1151 !important;}
</style>
<div id="page-wrapper">
	<div class="row">
	    <div class="col-lg-12">
	        <h1 style="margin-top: 15px;" class="page-header">Master Promo Barang</h1>
	    </div>
	    <!-- /.col-lg-12 -->
	</div>
	<div class="row">
		<div class="col-lg-12">
			<table style="float: right;">
				<tr>
					<td style="width: 125px;">
						<div class="form-group input-group">
							<span class="input-group-addon">
								<i class="fa fa-file"></i>
							</span>
							<select class="form-control" style='width: 200px;' name="cari_is_aktif" id="cari_is_aktif">
								<option value="1">Aktif</option>
								<option value="0">Non Aktif</option>
							</select>
						</div>
					</td>
					<td>&nbsp;&nbsp;</td>
					<td style="width: 125px;">
						<div class="form-group input-group">
							<span class="input-group-addon">
								<i class="fa fa-file"></i>
							</span>
							<select class="form-control" style='width: 200px;' name="cari_toko_kode" id="cari_toko_kode">
								<option value="-1">Pilih Toko</option>
							</select>
						</div>
					</td>
					<td>&nbsp;&nbsp;</td>
					<td valign="top">
						<button id="btn_upload" onclick="LoadDataPromo()" class="btn btn-info" type="button">
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
			<div class="panel panel-default">
				<div class="panel-heading">
					<button id="btn_upload" onclick="openFormPromo()" class="btn btn-info btn-sm" type="button">
						<i class="fa fa-plus"></i>
						&nbsp;&nbsp;Tambah
					</button>
					<button id="btn_upload" onclick="openFormEditPromo()" class="btn btn-success btn-sm" type="button">
						<i class="fa fa-edit"></i>
						&nbsp;&nbsp;Edit
					</button>
					<button id="btn_upload" fungsi="HapusPromo()" class="btn btn-danger btn-sm ask-menu" type="button">
						<i class="fa fa-times"></i>
						&nbsp;&nbsp;Hapus
					</button>
					<button id="btn_upload" onclick="RestorePromo()" class="btn btn-success btn-sm" type="button">
						<i class="fa fa-edit"></i>
						&nbsp;&nbsp;Restore
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
					<div class="table-responsive table-promo">
						
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="form-promo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        			<h4 class="modal-title" id="myModalLabel">Form Promo</h4>
				</div>
				<div class="modal-body">
					<table width="60%">
						<tr>
							<td width='40%'>
								Kode Promo :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<input type="checkbox" checked name="promo_otomatis" onclick="cekOtomatis()" id="promo_otomatis" /> Otomatis
									<input type="hidden" name="promo_mode" id="promo_mode" value="i" />
									<input type="text" placeholder="Kode Promo" readonly name="promo_kode" id="promo_kode" class="form-control">
								</div>
								Toko :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<select class="form-control" style='width: 200px;' name="promo_toko" id="promo_toko">
										<option value="-1">Pilih Toko</option>
									</select>
								</div>
							</td>
							<td>&nbsp;</td>
							<td width='48%'>
								Tanggal Mulai :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</span>
									<input type="text" placeholder="tanggal mulai" name="promo_tgl_awal" id="promo_tgl_awal" class="form-control">
								</div>
								Tanggal Akhir :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</span>
									<input type="text" placeholder="tanggal akhir" name="promo_tgl_akhir" id="promo_tgl_akhir" class="form-control">
								</div>
							</td>
						</tr>
					</table>
					<hr/>
					<table width="70%">
						<tr>
							<td width='48%' valign="top">
								Barang :
								<div class="form-group input-group">
									<input type="text" class="form-control" style="width: 250px;" name="promo_barang" id="promo_barang" />
								</div>
								Harga :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-money"></i>
									</span>
									<input readonly type="text" style="text-align: right;" placeholder="harga barang" name="promo_harga_barang" id="promo_harga_barang" class="form-control">
								</div>
								Kelipatan :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-money"></i>
									</span>
									<input type="text" style="text-align: right;" onkeyup="HitungHargaPromo()" placeholder="Kelipatan KWT Promo" name="promo_kelipatan_barang" id="promo_kelipatan_barang" value="1" class="form-control">
								</div>
							</td>
							<td>&nbsp;</td>
							<td width='48%'>
								Persentase Promo (%) :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-money"></i>
									</span>
									<input type="text" style="text-align: right;" onkeyup="HitungHargaPromo()" placeholder="Persentase promo" name="promo_persentase_promo" id="promo_persentase_promo" class="form-control">
								</div>
								Potongan Harga :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-money"></i>
									</span>
									<input type="text" style="text-align: right;" readonly onkeyup="HitungPersentasePromo(); price('promo_harga_promo')" placeholder="Potongan Harga" name="promo_harga_promo" id="promo_harga_promo" class="form-control">
								</div>
								<button style="float: right; margin-right: 5px;" type="button" onclick="tambahitem()" class="btn btn-primary">Tambahkan</button>
							</td>
						</tr>
					</table>
					<table id="table-dummy-promo" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th class="text-center">KD Barang</th>
								<th class="text-center">NM Barang</th>
								<th class="text-center">Promo (%)</th>
								<th class="text-center">Potongan Harga</th>
								<th class="text-center">Kelipatan</th>
								<th class="text-center">Aksi</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" onclick="clearForm()" class="btn btn-default">Reset</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<img src="<?= base_url() ?>images/loader.gif" id="loader-form"  style="width: 30px; display: none;" />
			        <button type="button" id="btn-simpan" onclick="simpanpromo()" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;&nbsp;Simpan</button>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		OpenMenu();
		LoadListDataBarang();
		loadListToko();
		
		LoadDataPromo();
		
		$('.ask-menu').jConfirmAction();
		
		$('#promo_tgl_awal').datepicker({
			format: 'yyyy-mm-dd'
		});
		$('#promo_tgl_akhir').datepicker({
			format: 'yyyy-mm-dd'
		});
		
		$('.datepicker tbody').on('click', function(){  $('.datepicker').hide() });
	});
	
	function loadListToko(){
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/toko/getListToko",
			data: "",
			success: function(msg){
				$("#cari_toko_kode").html(msg);
				$("#promo_toko").html("<option value=\"-\">SEMUA TOKO</option>"+msg);
			}
		});
	}
	
	function LoadListDataBarang(){
	    $("#promo_barang").select2({
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
            	return "<span class=\"select2-match\"></span>"+option.nama_barang;
            }, 
		    formatSelection: function (option) {
            	return option.nama_barang;
            }
	    });
		
		$("#promo_barang").on("select2-selecting", function(e) {
	    	// dataperlang = e;
	    	// alert ("selecting val="+ e.choice.satuan_terkecil +" choice="+ JSON.stringify(e.choice));
			var toko_kode = $("#promo_toko").val();
			if(toko_kode != "-"){
				getHargaBarang(e.choice.kode, $("#promo_toko").val());
			}
	    });
	}
	
	function getHargaBarang(barang_kode, toko_kode){
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/barang/gethargabarangtoko",
			data: "barang_kode="+barang_kode+"&toko_kode="+toko_kode,
			success: function(msg){
				$("#promo_harga_barang").val(msg);
				//price("promo_harga_barang");
			}
		});
	}
	
	function LoadDataPromo(){
		$('#progres-main').show();
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/promo/getdatapromo",
			data: "toko_kode="+$('#cari_toko_kode').val()+"&is_aktif="+$('#cari_is_aktif').val(),
			success: function(msg){
				$(".table-promo").html(msg);
				table = $('#dataTables-promo').dataTable();
				$('#progres-main').hide();
				
				$('#dataTables-promo tbody').on( 'click', 'tr', function () {
			        if ( $(this).hasClass('active') ) {
			            $(this).removeClass('active');
			        }else {
			            table.$('tr.active').removeClass('active');
			            $(this).addClass('active');
			        }
			    } );
			}
		});
	}
	
	function HitungHargaPromo(){
		var toko_kode = $("#promo_toko").val();
		if(toko_kode != "-"){
			var Harga = removeCurrency($("#promo_harga_barang").val());
			var Persentase = removeCurrency($("#promo_persentase_promo").val());
			var kelipatan = $("#promo_kelipatan_barang").val();
			
			var HargaPromo = (parseFloat(Harga) * (parseFloat(Persentase)/100)) * parseFloat(kelipatan);
			// var HargaPromo = parseFloat(Harga) - parseFloat(PotonganHarga);
			
			$("#promo_harga_promo").val(HargaPromo);
			//price("promo_harga_promo");
		}else{
			$("#promo_harga_promo").val("");
		}
	}
	
	function HitungPersentasePromo(){
		var toko_kode = $("#promo_toko").val();
		if(toko_kode != "-"){
			var Harga = removeCurrency($("#promo_harga_barang").val());
			var HargaPromo = removeCurrency($("#promo_harga_promo").val());
			
			// var PotonganHarga = parseFloat(Harga) - parseFloat(HargaPromo);
			var Persentase = (parseFloat(HargaPromo)/parseFloat(Harga)) * 100;
			
			$("#promo_persentase_promo").val(round(Persentase,2));
		}else{
			$("#promo_persentase_promo").val("");
		}
	}
	
	function openFormPromo(){
		$('#form-promo').modal('show');
		var ts = Math.round((new Date()).getTime() / 1000);
		$("#promo_kode").val(ts);
		$("#promo_mode").val("i");
		
		$("#promo_toko").val($("#cari_toko_kode").val());
	}
	
	function cekOtomatis(){
		if($("#promo_mode").val() == "i"){
			if($("#promo_otomatis").is(':checked')){
				var ts = Math.round((new Date()).getTime() / 1000);
				$("#promo_kode").val(ts);
				$("#promo_kode").attr("readonly","readonly");
			}else{
				$("#promo_kode").removeAttr("readonly");
				$("#promo_kode").val("");
			}
		}
	}
	
	function simpanpromo(){
		$("#loader-form").show();
		$("#btn-simpan").hide();
		
		var kode = $("#promo_kode").val();
		var toko_kode = $("#promo_toko").val();
		var tanggal_awal = $("#promo_tgl_awal").val();
		var tanggal_akhir = $("#promo_tgl_akhir").val();
		var mode = $("#promo_mode").val();
		
		var dataArr = [];
	    $("#table-dummy-promo td").each(function(){
	        dataArr.push($(this).html());
	    });
		var jsonData = rawurlencode(json_encode(dataArr));
		
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/promo/simpanpromo",
			data: "data="+jsonData+"&kode="+kode+"&toko_kode="+toko_kode+"&tanggal_awal="+tanggal_awal+"&tanggal_akhir="+tanggal_akhir+"&mode="+mode,
			success: function(msg){
				LoadDataPromo();
				clearForm();
				
				$('#form-promo').modal('hide');
				
				$("#loader-form").hide();
				$("#btn-simpan").show();
			}
		});
	}
	
	function openFormEditPromo(){
		var data = table.$('tr.active').attr("data");
		if(typeof data == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var dataArr = json_decode(base64_decode(data));
			
			$("#promo_kode").val(dataArr['kode']);
			$("#promo_toko").val(dataArr['toko_kode']);
			$("#promo_tgl_awal").val(dataArr['tanggal_awal']);
			$("#promo_tgl_akhir").val(dataArr['tanggal_akhir']);
			$("#promo_mode").val("e");
			
			$.ajax({
				type: "POST",
				url: "<?= base_url() ?>index.php/promo/getdatabarangpromo",
				data: "kode_promo="+dataArr['kode']+"&toko_kode="+dataArr['toko_kode'],
				success: function(msg){
					$("#table-dummy-promo tbody").html(msg);
				}
			});
			
			$("#promo_kode").attr("readonly","readonly");
			$('#form-promo').modal('show');
		}
	}
	
	function RestorePromo(){
		var data = table.$('tr.active').attr("data");
		if(typeof data == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var dataArr = json_decode(base64_decode(data));
			
			$.ajax({
				type: "POST",
				url: "<?= base_url() ?>index.php/promo/restorepromo",
				data: "kode_promo="+dataArr['kode']+"&toko_kode="+dataArr['toko_kode'],
				success: function(msg){
					LoadDataPromo();
				}
			});
		}
	}

	function HapusPromo(){
		var data = table.$('tr.active').attr("data");
		if(typeof data == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var dataArr = json_decode(base64_decode(data));
			
			$.ajax({
				type: "POST",
				url: "<?= base_url() ?>index.php/promo/hapuspromo",
				data: "kode="+dataArr['kode'],
				success: function(msg){
					LoadDataPromo();
				}
			});
		}
	}
	
	function tambahitem(){
		var kd_barang = $("#promo_barang").val();
		var nama_barang = $("#s2id_promo_barang .select2-chosen").html();
		var kelipatan_barang = $("#promo_kelipatan_barang").val();
		var persentase_promo = $("#promo_persentase_promo").val();
		var harga_promo = $("#promo_harga_promo").val();
		
		var row = "<tr><td>"+kd_barang+"</td><td>"+nama_barang+"</td><td class=\"text-right\">"+persentase_promo+"</td><td class=\"text-right\">"+harga_promo+"</td><td class=\"text-right\">"+kelipatan_barang+"</td><td><button type=\"button\" onclick=\"HapusRow(this)\" class=\"btn btn-default\"><i class=\"fa fa-times\"></i></button></td></tr>";
		
		$('#table-dummy-promo > tbody:last').append(row);
		
		$("#promo_barang").select2("val", "");
		$("#promo_kelipatan_barang").val("1");
		$("#promo_persentase_promo").val("");
		$("#promo_harga_promo").val("");
		$("#promo_harga_barang").val("");
	}
	
	function HapusRow(DataObj){
		dataobj = DataObj;
		$(DataObj).parent().parent().remove();
	}
	
	function clearForm(){
		var ts = Math.round((new Date()).getTime() / 1000);
		$("#promo_kode").val("");
		$("#promo_toko").val("");
		$("#promo_barang").val("");
		$("#promo_tgl_awal").val("");
		$("#promo_tgl_akhir").val("");
		$("#promo_persentase_promo").val("");
		$("#promo_harga_promo").val("");
		$("#promo_harga_barang").val("");
		$("#promo_mode").val("i");
		$('#table-dummy-promo tbody').html("");
	}
</script>