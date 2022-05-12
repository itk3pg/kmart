<style>
	.datepicker{z-index:1151 !important;}
</style>
<div id="page-wrapper">
	<div class="row">
	    <div class="col-lg-12">
	        <h1 style="margin-top: 15px;" class="page-header">Transfer Bad Stock (TB)</h1>
	    </div>
	    <!-- /.col-lg-12 -->
	</div>
	<div class="row" style="margin-bottom: 10px;">
		<div class="col-lg-12">
			<table style="float: right;">
				<tr>
					<td>
						<select class="form-control" name="cari_mode" id="cari_mode">
							<option value="VO0010">Bad Stock Non Retur</option>
							<option value="VO0009">Bad Stock Retur</option>
						</select>
					</td>
					<td>&nbsp;&nbsp;</td>
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
						<button id="btn_upload" onclick="LoadDataTransferBadStock()" class="btn btn-info" type="button">
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
					<?php if($this->session->userdata('group_kode') == "GRU0000" || $this->session->userdata('group_kode') == "GRU0009"){ ?>
					<button id="btn_tambah" onclick="openFormTransferBadStock()" class="btn btn-info btn-sm" type="button">
						<i class="fa fa-plus"></i>
						&nbsp;&nbsp;Tambah
					</button>
					<button id="btn_uedit" onclick="openFormEditTransferBadStock()" class="btn btn-success btn-sm" type="button">
						<i class="fa fa-edit"></i>
						&nbsp;&nbsp;Edit
					</button>
					<button id="btn_hapus" fungsi="HapusTransferBadStock()" class="btn btn-danger btn-sm ask-transferbs" type="button">
						<i class="fa fa-times"></i>
						&nbsp;&nbsp;Hapus
					</button>
					<?php } ?>
					<button id="btn_hapus" onclick="CetakTransferBadStock()" class="btn btn-warning btn-sm" type="button">
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
					<div class="table-responsive table-transferbs">
						
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Popup form untuk input pindah bad stock -->
	<div class="modal fade" id="form-transferbs" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        			<h4 class="modal-title" id="myModalLabel">Form Transfer Bad Stock (TB)</h4>
				</div>
				<div class="modal-body">
					<input type="hidden" name="mode" id="mode" value="i"/>
					<input type="hidden" name="tbs_bukti" id="tbs_bukti"/>
					<table>
						<tr>
							<td>
								Tanggal :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</span>
									<input style="width: 150px;" type="text" value="<?= date("Y-m-d"); ?>" disabled name="tbs_tanggal" id="tbs_tanggal" class="form-control">
								</div>
							</td>
							<td>&nbsp;&nbsp;</td>
							<td>
								Gudang Dari :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<select class="form-control" name="tbs_mode" id="tbs_mode">
										<option value="VO0009">Bad Stock Retur</option>
										<option value="VO0010">Bad Stock Non Retur</option>
									</select>
								</div>
							</td>
							<td>&nbsp;&nbsp;</td>
							<td>
								Tujuan :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<select class="form-control" name="tbs_ispenyesuaian" id="tbs_ispenyesuaian">
										<option value="0">Retur Ke Good Stock</option>
										<!--<option value="1">Penyesuaian BS (Non Retur)</option>-->
									</select>
								</div>
							</td>
						</tr>
					</table>
					<table style="width: 50%; margin-bottom: 5px;">
						<tr>
							<td width="250px">Barang :</td>
							<td>&nbsp;&nbsp;</td>
							<td>HPP :</td>
							<td>&nbsp;&nbsp;</td>
							<td>Jumlah :</td>
							<td>&nbsp;&nbsp;</td>
							<td>&nbsp;&nbsp;</td>
						</tr>
						<tr>
							<td width="250px"><input type="text" class="form-control" name="tbs_barang" id="tbs_barang" /></td>
							<td>&nbsp;&nbsp;</td>
							<td width="150px"><input readonly type="text" style="text-align:right;" class="form-control" name="bs_hpp" id="bs_hpp" /></td>
							<td>&nbsp;&nbsp;</td>
							<td width="70px"><input type="text" style="text-align:right;" class="form-control" name="tbs_kwt" id="tbs_kwt" /></td>
							<td>&nbsp;&nbsp;</td>
							<td>
								<button id="btn_tambah_barang" onclick="TambahBarangBS('')" class="btn btn-success btn-sm" type="button">
									<i class="fa fa-plus"></i>
									&nbsp;&nbsp;Tambah
								</button>
							</td>
						</tr>
					</table>
					<table style="width: 100%" id="table-dummy-transferbs" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th class="text-center">KD Barang</th>
								<th class="text-center">Nama Barang</th>
								<th class="text-center">SATUAN</th>
								<th class="text-center">KWT</th>
								<th class="text-center">HPP</th>
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
			        <button type="button" id="btn-simpan" onclick="SimpanTBS()" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;&nbsp;Simpan</button>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		OpenMenu();
		LoadDataTransferBadStock();
		LoadListDataBarang();
		
		$('.ask-transferbs').jConfirmAction();
		
		$('#tbs_tanggal').datepicker({
			format: 'yyyy-mm-dd'
		});
		
		$('.datepicker tbody').on('click', function(){  $('.datepicker').hide() });
	});
	
	function LoadDataTransferBadStock(){
		$('#progres-main').show();
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/transferbadstock/getdatatransferbadstock",
			data: "bulan="+$("#bulan").val()+"&tahun="+$("#tahun").val()+"&gudang_bs="+$("#cari_mode").val(),
			success: function(msg){
				$(".table-transferbs").html(msg);
				//table = $('#dataTables-transferbs').dataTable();
				$('#progres-main').hide();
				
				$('#dataTables-transferbs tbody').on( 'click', 'tr', function () {
			        if ( $(this).hasClass('active') ) {
			            $(this).removeClass('active');
			        }else {
			            $('#dataTables-transferbs tr.active').removeClass('active');
			            $(this).addClass('active');
			        }
			    } );
			}
		});
	}
	
	function openFormTransferBadStock(){
		$("#form-transferbs").modal("show");
		$("#mode").val("i");
		$("#tbs_bukti").val("");
	}
	
	function LoadListDataBarang(){
	    $("#tbs_barang").select2({
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
	    
	    $("#tbs_barang").on("select2-selecting", function(e) {
	    	// dataperlang = e;
	    	// alert ("selecting val="+ e.choice.satuan_terkecil +" choice="+ JSON.stringify(e.choice));
			$("#btn_tambah_barang").attr("onclick", "TambahBarangBS('"+e.choice.satuan+"')");
			$("#bs_hpp").val(e.choice.hpp);
	    });
	}
	
	function HapusRow(DataObj){
		dataobj = DataObj;
		$(DataObj).parent().parent().remove();
	}
	
	function TambahBarangBS(satuan){
		var kd_barang = $("#tbs_barang").val();
		var nama_barang = $("#s2id_tbs_barang .select2-chosen").html();
		var kwt = $("#tbs_kwt").val();
		
		var dataArr = [];
	    $("#table-dummy-transferbs td").each(function(){
	        dataArr.push($(this).html());
	    });

	    var hpp = $("#bs_hpp").val();
	    var jumlah = parseFloat(kwt) * parseFloat(hpp);
	    var row = "<tr><td>"+kd_barang+"</td><td>"+nama_barang+"</td><td>"+satuan+"</td><td class=\"text-right\">"+kwt+"</td><td class=\"text-right\">"+hpp+"</td><td class=\"text-right\">"+jumlah+"</td><td class=\"text-center\"><button type=\"button\" style=\"padding: 0px 20px;\" onclick=\"HapusRow(this)\" class=\"btn btn-danger btn-sm\"><i class=\"fa fa-times\"></i></button></td></tr>";
				
		if(dataArr.length > 0){
			$('#table-dummy-transferbs > tbody > tr:first').before(row);
		}else{
			$('#table-dummy-transferbs > tbody:last').append(row);
		}
		
		/*$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/transferbadstock/getsaldobarangdc",
			data: "barang_kode="+kd_barang,
			success: function(msg){
				var row = "<tr><td>"+kd_barang+"</td><td>"+nama_barang+"</td><td>"+satuan+"</td><td class=\"text-right\">"+msg+"</td><td class=\"text-right\">"+kwt+"</td><td class=\"text-center\"><button type=\"button\" style=\"padding: 0px 20px;\" onclick=\"HapusRow(this)\" class=\"btn btn-danger btn-sm\"><i class=\"fa fa-times\"></i></button></td></tr>";
				
				if(dataArr.length > 0){
					$('#table-dummy-transferbs > tbody > tr:first').before(row);
				}else{
					$('#table-dummy-transferbs > tbody:last').append(row);
				}
			}
		});*/
	}
	
	function clearForm(){
		$('#table-dummy-transferbs tbody').html("");
		$("#tbs_barang").select2("val", "");
		$("#tbs_kwt").val("");
	}
	
	function SimpanTBS(){
		$('#btn-simpan').hide();
		$('#loader-form').show();
		
		var dataArr = [];
	    $("#table-dummy-transferbs td").each(function(){
	        dataArr.push($(this).html());
	    });
	    var mode = $("#mode").val();
		var bukti = $("#tbs_bukti").val();
		var tanggal = $("#tbs_tanggal").val();
		
		if(mode == "i"){
			var modeBukti = "TB";
			var tanggal_od = $("#tbs_tanggal").val();
			$.ajax({
				type: "POST",
				url: "<?= base_url() ?>index.php/bukti/generatebukti",
				data: "mode="+modeBukti+"&tanggal="+tanggal_od,
				success: function(msg){
					ajaxsimpanbs(msg, dataArr, 0);
				}
			});
		}else{
			$.ajax({
				type: "POST",
				url: "<?= base_url(); ?>index.php/transferbadstock/hapustransferbadstock",
				data: "bukti="+bukti+"&tanggal="+tanggal,
				success: function(msg){
					ajaxsimpanbs(bukti, dataArr, 0);
				}
			});
		}
	}
	
	function ajaxsimpanbs(bukti, dataArr, index){
		var kd_barang = dataArr[index];
		var kwt = dataArr[index+3];
		var hpp = dataArr[index+4];
		var jumlah = dataArr[index+5];
		var tanggal = $("#tbs_tanggal").val();
		var mode = $("#mode").val();
		var gudang_bs = $("#tbs_mode").val();
		var is_penyesuaian = $("#tbs_ispenyesuaian").val();
		
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/transferbadstock/simpantransferbadstock",
			data: "mode="+mode+"&bukti="+bukti+"&barang_kode="+kd_barang+"&kwt="+kwt+"&hpp="+hpp+"&jumlah="+jumlah+"&tanggal="+tanggal+"&gudang_bs="+gudang_bs+"&is_penyesuaian="+is_penyesuaian,
			success: function(msg){
				index = index + 7;
				if(index >= dataArr.length){ // jika sudah sampai index yang terakhir
					$('#btn-simpan').show();
					$('#loader-form').hide();
					
					ShowMessage("success", "Data berhasil disimpan");
					LoadDataTransferBadStock();
					$("#form-transferbs").modal("hide");
				}else{ // jika masih ada data yang dimasukkan
					ajaxsimpanbs(bukti, dataArr, index);
				}
			},
			error: function(xhr,status,error){
				ShowMessage("danger", "Data gagal disimpan");
				$('#btn-simpan').show();
				$('#loader-form').hide();
			}
		});
	}
	
	function HapusTransferBadStock(){
		var data_obj = $('#dataTables-transferbs tr.active').attr("data");
		
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			$('#progres-main').show();
			$.ajax({
				type: "POST",
				url: "<?= base_url(); ?>index.php/transferbadstock/hapustransferbadstock",
				data: "bukti="+data['bukti']+"&tanggal="+data['tanggal'],
				success: function(msg){
					ShowMessage("success", "Data berhasil dihapus");
					LoadDataTransferBadStock();
				}
			});
		}
	}
	
	function openFormEditTransferBadStock(){
		var data_obj = $('#dataTables-transferbs tr.active').attr("data");
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			
			$("#mode").val("e");
			$("#tbs_bukti").val(data['bukti']);
			$("#tbs_tanggal").val(data['tanggal']);
			$("#tbs_mode").val(data['toko_kode']);
			$("#tbs_ispenyesuaian").val(data['is_penyesuaian']);
			
			$.ajax({
				type: "POST",
				url: "<?= base_url() ?>index.php/transferbadstock/getdatabarangtransferbadstock",
				data: "bukti="+data['bukti'],
				success: function(msg){
					$("#table-dummy-transferbs tbody").html(msg);
				}
			});
			
			$("#form-transferbs").modal("show");
		}
	}
	
	function ListBarangSupplier(){
		var supplier_kode = $("#tbs_supplier").val();
		var toko_kode = $("#tbs_toko").val();
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/transferbadstock/getdatabarangsupplier",
			data: "supplier_kode="+supplier_kode+"&toko_kode="+toko_kode,
			success: function(msg){
				$("#table-dummy-transferbs tbody").html(msg);
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
	
	function CetakTransferBadStock(){
		var data_obj = $('#dataTables-transferbs tr.active').attr("data");
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			window.open('<?= base_url('index.php/transferbadstock/cetaktransferbs?') ?>bukti='+data['bukti'],'_blank');
		}
	}
</script>