<style>
	.datepicker{z-index:1151 !important;}
</style>
<div id="page-wrapper">
	<div class="row">
	    <div class="col-lg-12">
	        <h1 style="margin-top: 15px;" class="page-header">Pemakaian Bahan Baku (BO)</h1>
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
						<button id="btn_upload" onclick="LoadDataPemakaian()" class="btn btn-info" type="button">
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
					<!--<button id="btn_tambah" onclick="openFormPemakaian()" class="btn btn-info btn-sm" type="button">
						<i class="fa fa-plus"></i>
						&nbsp;&nbsp;Tambah
					</button>
					<button id="btn_uedit" onclick="openFormEditPemakaian()" class="btn btn-success btn-sm" type="button">
						<i class="fa fa-edit"></i>
						&nbsp;&nbsp;Edit
					</button>
					<button id="btn_hapus" fungsi="HapusPemakaian()" class="btn btn-danger btn-sm ask-pemakaian" type="button">
						<i class="fa fa-times"></i>
						&nbsp;&nbsp;Hapus
					</button>-->
					<div id="progres-main" style="width: 150px; float: right; display: none;">
						<div class="progress progress-striped active">
							<div class="progress-bar progress-bar-info" style="width: 100%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="20" role="progressbar">
								<span class="sr-only">20% Complete</span>
							</div>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<div class="table-responsive table-pemakaian">
						
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Popup form untuk pembelian barang -->
	<div class="modal fade" id="form-pemakaian" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        			<h4 class="modal-title" id="myModalLabel">Form Pemakaian Bahan Baku (BO)</h4>
				</div>
				<div class="modal-body">
					<table style="width: 100%;">
						<tr>
							<td style="width: 200px;">Tanggal :</td>
							<td>&nbsp;&nbsp;
								<input type="hidden" name="mode" id="mode" value="i"/>
								<input type="hidden" name="pemakaian_bukti" id="pemakaian_bukti"/>
							</td>
							<td>Dari Gudang/Kitchen :</td>
						</tr>
						<tr>
							<td>
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</span>
									<input type="text" value="<?= date("Y-m-d"); ?>" placeholder="Tanggal OD" name="pemakaian_tanggal" id="pemakaian_tanggal" class="form-control">
								</div>
							</td>
							<td>&nbsp;&nbsp;</td>
							<td>
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<select class="form-control" name="pemakaian_kitchen" id="pemakaian_kitchen">
										<option value="-1">Pilih Gudang</option>
									</select>
								</div>
							</td>
						</tr>
					</table>
					<table style="width: 100%; margin-bottom: 5px;">
						<tr>
							<td width="250px">Barang :</td>
							<td>&nbsp;&nbsp;</td>
							<td>Jumlah :</td>
							<td>&nbsp;&nbsp;</td>
							<td width="110px">Satuan :</td>
							<td>&nbsp;&nbsp;</td>
							<td>&nbsp;&nbsp;</td>
						</tr>
						<tr>
							<td width="250px"><input type="text" class="form-control" name="pemakaian_barang" id="pemakaian_barang" /></td>
							<td>&nbsp;&nbsp;</td>
							<td><input type="text" class="form-control" name="pemakaian_kwt" id="pemakaian_kwt" /></td>
							<td>&nbsp;&nbsp;</td>
							<td width="110px">
								<select class="form-control" onchange="HitungKonversiSatuan(0)" name="pemakaian_satuan_barang" id="pemakaian_satuan_barang"></select>
							</td>
							<td>&nbsp;&nbsp;</td>
							<td>
								<button id="btn_tambah_barang" onclick="TambahBarangPemakaian(0, '')" class="btn btn-success btn-sm" type="button">
									<i class="fa fa-plus"></i>
									&nbsp;&nbsp;Tambah
								</button>
							</td>
						</tr>
					</table>
					<table style="width: 100%" id="table-dummy-pemakaian" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th class="text-center">KD Barang</th>
								<th class="text-center">Nama Barang</th>
								<th class="text-center">KWT SB</th>
								<th class="text-center">KWT SK</th>
								<th class="text-center">SATUAN</th>
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
			        <button type="button" id="btn-simpan" onclick="SimpanPemakaian()" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;&nbsp;Simpan</button>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		OpenMenu();
		LoadDataPemakaian();
		LoadListDataBarang();
		loadListKitchen();
		
		$('.ask-pemakaian').jConfirmAction();
		
		$('#pemakaian_tanggal').datepicker({
			format: 'yyyy-mm-dd'
		});
		
		$('.datepicker tbody').on('click', function(){  $('.datepicker').hide() });
	});
	
	function loadListKitchen(){
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/kitchen/getListKitchen",
			data: "",
			success: function(msg){
				$("#pemakaian_kitchen").html(msg);
			}
		});
	}
	
	function LoadDataPemakaian(){
		$('#progres-main').show();
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/pemakaianbarang/getdatapemakaian",
			data: "tahun="+$("#tahun").val()+"&bulan="+$("#bulan").val(),
			success: function(msg){
				$(".table-pemakaian").html(msg);
				//table = $('#dataTables-od').dataTable();
				$('#progres-main').hide();
				
				$('#dataTables-pemakaian tbody').on( 'click', 'tr', function () {
			        if ( $(this).hasClass('active') ) {
			            $(this).removeClass('active');
			        }else {
			            $('#dataTables-pemakaian tr.active').removeClass('active');
			            $(this).addClass('active');
			        }
			    } );
			}
		});
	}
	
	function openFormPemakaian(){
		$("#form-pemakaian").modal("show");
		$("#mode").val("i");
		$("#pemakaian_bukti").val("");
	}
	
	function LoadListDataBarang(){
	    $("#pemakaian_barang").select2({
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
            	return "<span class=\"select2-match\"></span>"+option.nama_barang;
            }, 
		    formatSelection: function (option) {
            	return option.nama_barang;
            }
	    });
	    
	    $("#pemakaian_barang").on("select2-selecting", function(e) {
	    	// dataperlang = e;
	    	// alert ("selecting val="+ e.choice.satuan_terkecil +" choice="+ JSON.stringify(e.choice));
			$("#btn_tambah_barang").attr("onclick", "TambahBarangPemakaian("+e.choice.nilai_konversi+", '"+e.choice.nama_satuan_terkecil+"')");
			$("#pemakaian_satuan_barang").attr("onchange", "HitungKonversiSatuan("+e.choice.nilai_konversi+")");
	    	$("#pemakaian_satuan_barang").html("<option value='besar'>"+e.choice.nama_satuan+"</option><option value='kecil'>"+e.choice.nama_satuan_terkecil+"</option>");
	    });
	}
	
	function HitungKonversiSatuan(nilai_konversi){
		var tipe_satuan = $("#pemakaian_satuan_barang").val();
		var nilai_kwt = $("#pemakaian_kwt").val();
		if(tipe_satuan == "besar"){
			nilai_kwt = nilai_kwt / nilai_konversi;
		}else{
			nilai_kwt = nilai_kwt * nilai_konversi;
		}
		
		$("#pemakaian_kwt").val(nilai_kwt);
	}
	
	function HapusRow(DataObj){
		dataobj = DataObj;
		$(DataObj).parent().parent().remove();
	}
	
	function TambahBarangPemakaian(nilai_konversi, nama_satuan_terkecil){
		var kd_barang = $("#pemakaian_barang").val();
		var nama_barang = $("#s2id_pemakaian_barang .select2-chosen").html();
		var kwt_besar = 0;
		var kwt_kecil = 0;
		var tipe_satuan = $("#pemakaian_satuan_barang").val();
		if(tipe_satuan == "besar"){
			kwt_besar = $("#pemakaian_kwt").val();
			kwt_kecil = kwt_besar * nilai_konversi;
		}else{
			kwt_kecil = $("#pemakaian_kwt").val();
			kwt_besar = kwt_kecil / nilai_konversi;
		}
		
		var row = "<tr><td>"+kd_barang+"</td><td>"+nama_barang+"</td><td class=\"text-right\">"+kwt_besar+"</td><td class=\"text-right\">"+kwt_kecil+"</td><td>"+nama_satuan_terkecil+"</td><td class=\"text-center\"><button type=\"button\" style=\"padding: 0px 20px;\" onclick=\"HapusRow(this)\" class=\"btn btn-danger btn-sm\"><i class=\"fa fa-times\"></i></button></td></tr>";
		$('#table-dummy-pemakaian > tbody:last').append(row);
	}
	
	function clearForm(){
		$('#table-dummy-pemakaian tbody').html("");
		$("#pemakaian_barang").select2("val", "");
		$("#pemakaian_kwt").val("");
	}
	
	function SimpanPemakaian(){
		$('#btn-simpan').hide();
		$('#loader-form').show();
		
		var dataArr = [];
	    $("#table-dummy-pemakaian td").each(function(){
	        dataArr.push($(this).html());
	    });
	    var mode = $("#mode").val();
		var bukti = $("#pemakaian_bukti").val();
		
		if(mode == "i"){
			var modeBukti = "BO";
			var tanggal_pemakaian = $("#pemakaian_tanggal").val();
			$.ajax({
				type: "POST",
				url: "<?= base_url() ?>index.php/bukti/generatebukti",
				data: "mode="+modeBukti+"&tanggal="+tanggal_pemakaian,
				success: function(msg){
					ajaxsimpanpemakaian(msg, dataArr, 0);
				}
			});
		}else{
			$.ajax({
				type: "POST",
				url: "<?= base_url(); ?>index.php/pemakaianbarang/hapuspemakaian",
				data: "bukti="+bukti,
				success: function(msg){
					ajaxsimpanpemakaian(bukti, dataArr, 0);
				}
			});
		}
	}
	
	function ajaxsimpanpemakaian(bukti, dataArr, index){
		var kd_barang = dataArr[index];
		var kwt_besar = dataArr[index+2];
		var kwt_kecil = dataArr[index+3];
		var tanggal = $("#pemakaian_tanggal").val();
		var kd_kitchen = $("#pemakaian_kitchen").val();
		var mode = $("#mode").val();
		
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/pemakaianbarang/simpanpemakaian",
			data: "mode="+mode+"&bukti="+bukti+"&barang_kode="+kd_barang+"&kwt_besar="+kwt_besar+"&kwt_kecil="+kwt_kecil+"&tanggal="+tanggal+"&kitchen_kode="+kd_kitchen,
			success: function(msg){
				index = index + 6;
				if(index >= dataArr.length){ // jika sudah sampai index yang terakhir
					$('#btn-simpan').show();
					$('#loader-form').hide();
					
					ShowMessage("success", "Data berhasil disimpan");
					LoadDataPemakaian();
					$("#form-pemakaian").modal("hide");
				}else{ // jika masih ada data yang dimasukkan
					ajaxsimpanpemakaian(bukti, dataArr, index);
				}
			},
			error: function(xhr,status,error){
				ShowMessage("danger", "Data gagal disimpan");
				$('#btn-simpan').show();
				$('#loader-form').hide();
			}
		});
	}
	
	function HapusPemakaian(){
		var data_obj = $('#dataTables-pemakaian tr.active').attr("data");
		
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			$('#progres-main').show();
			$.ajax({
				type: "POST",
				url: "<?= base_url(); ?>index.php/pemakaianbarang/hapuspemakaian",
				data: "bukti="+data['bukti'],
				success: function(msg){
					ShowMessage("success", "Data berhasil dihapus");
					LoadDataPemakaian();
				}
			});
		}
	}
	
	function openFormEditPemakaian(){
		var data_obj = $('#dataTables-pemakaian tr.active').attr("data");
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			
			$("#mode").val("e");
			$("#pemakaian_bukti").val(data['bukti']);
			$("#pemakaian_tanggal").val(data['tanggal']);
			$("#pemakaian_kitchen").val(data['kitchen_kode']);
			
			$.ajax({
				type: "POST",
				url: "<?= base_url() ?>index.php/pemakaianbarang/getdatabarangpemakaian",
				data: "bukti="+data['bukti'],
				success: function(msg){
					$("#table-dummy-pemakaian tbody").html(msg);
				}
			});
			
			$("#form-pemakaian").modal("show");
		}
	}
</script>