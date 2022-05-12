<style>
	.datepicker{z-index:1151 !important;}
</style>
<div id="page-wrapper">
	<div class="row">
	    <div class="col-lg-12">
	        <h1 style="margin-top: 15px;" class="page-header">Bad Stock (BS)</h1>
	    </div>
	    <!-- /.col-lg-12 -->
	</div>
	<div class="row" style="margin-bottom: 10px;">
		<div class="col-lg-12">
			<table style="float: right;">
				<tr>
					<td>
						<select class="form-control" name="cari_mode" id="cari_mode">
							<option value="VO0009">Bad Stock Retur</option>
							<option value="VO0010">Bad Stock Non Retur</option>
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
						<button id="btn_upload" onclick="LoadDataBadStock()" class="btn btn-info" type="button">
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
					<button id="btn_tambah" onclick="openFormBadStock()" class="btn btn-info btn-sm" type="button">
						<i class="fa fa-plus"></i>
						&nbsp;&nbsp;Tambah
					</button>
					<button id="btn_uedit" onclick="openFormEditBadStock()" class="btn btn-success btn-sm" type="button">
						<i class="fa fa-edit"></i>
						&nbsp;&nbsp;Edit
					</button>
					<button id="btn_hapus" fungsi="HapusBadStock()" class="btn btn-danger btn-sm ask-bs" type="button">
						<i class="fa fa-times"></i>
						&nbsp;&nbsp;Hapus
					</button>
					<?php } ?>
					<button id="btn_hapus" onclick="CetakBadStock()" class="btn btn-warning btn-sm" type="button">
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
					<div class="table-responsive table-bs">
						
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Popup form untuk input pindah bad stock -->
	<div class="modal fade" id="form-bs" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        			<h4 class="modal-title" id="myModalLabel">Form Barang Buruk (BS)</h4>
				</div>
				<div class="modal-body">
					<input type="hidden" name="mode" id="mode" value="i"/>
					<input type="hidden" name="bs_bukti" id="bs_bukti"/>
					<table>
						<tr>
							<td>
								Tanggal :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</span>
									<input style="width: 150px;" type="text" value="<?= date("Y-m-d"); ?>" disabled name="bs_tanggal" id="bs_tanggal" class="form-control">
								</div>
							</td>
							<td>&nbsp;&nbsp;</td>
							<td>
								Gudang Tujuan :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<select class="form-control" name="bs_mode" id="bs_mode">
										<option value="VO0009">Bad Stock Retur</option>
										<option value="VO0010">Bad Stock Non Retur</option>
									</select>
								</div>
							</td>
						</tr>
					</table>
					<table style="width: 80%; margin-bottom: 5px;">
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
							<td width="250px"><input type="text" class="form-control" name="bs_barang" id="bs_barang" /></td>
							<td>&nbsp;&nbsp;</td>
							<td width="150px"><input readonly type="text" style="text-align:right;" class="form-control" name="bs_hpp" id="bs_hpp" /></td>
							<td>&nbsp;&nbsp;</td>
							<td width="70px"><input type="text" style="text-align:right;" class="form-control" name="bs_kwt" id="bs_kwt" /></td>
							<td>&nbsp;&nbsp;</td>
							<td>
								<button id="btn_tambah_barang" onclick="TambahBarangBS('')" class="btn btn-success btn-sm" type="button">
									<i class="fa fa-plus"></i>
									&nbsp;&nbsp;Tambah
								</button>
							</td>
						</tr>
					</table>
					<table style="width: 100%" id="table-dummy-bs" class="table table-bordered table-hover">
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
			        <button type="button" id="btn-simpan" onclick="SimpanBS()" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;&nbsp;Simpan</button>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		OpenMenu();
		LoadDataBadStock();
		LoadListDataBarang();
		
		$('.ask-bs').jConfirmAction();
		
		$('#bs_tanggal').datepicker({
			format: 'yyyy-mm-dd'
		});
		
		$('.datepicker tbody').on('click', function(){  $('.datepicker').hide() });
	});
	
	function LoadDataBadStock(){
		$('#progres-main').show();
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/badstock/getdatabadstock",
			data: "bulan="+$("#bulan").val()+"&tahun="+$("#tahun").val()+"&gudang_bs="+$("#cari_mode").val(),
			success: function(msg){
				$(".table-bs").html(msg);
				//table = $('#dataTables-bs').dataTable();
				$('#progres-main').hide();
				
				$('#dataTables-bs tbody').on( 'click', 'tr', function () {
			        if ( $(this).hasClass('active') ) {
			            $(this).removeClass('active');
			        }else {
			            $('#dataTables-bs tr.active').removeClass('active');
			            $(this).addClass('active');
			        }
			    } );
			}
		});
	}
	
	function openFormBadStock(){
		$("#form-bs").modal("show");
		$("#mode").val("i");
		$("#bs_bukti").val("");
	}
	
	function LoadListDataBarang(){
	    $("#bs_barang").select2({
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
	    
	    $("#bs_barang").on("select2-selecting", function(e) {
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
		var kd_barang = $("#bs_barang").val();
		var nama_barang = $("#s2id_bs_barang .select2-chosen").html();
		var kwt = $("#bs_kwt").val();
		
		var dataArr = [];
	    $("#table-dummy-bs td").each(function(){
	        dataArr.push($(this).html());
	    });

	    var hpp = $("#bs_hpp").val();
	    var jumlah = parseFloat(kwt) * parseFloat(hpp);
	    var row = "<tr><td>"+kd_barang+"</td><td>"+nama_barang+"</td><td>"+satuan+"</td><td class=\"text-right\">"+kwt+"</td><td class=\"text-right\">"+hpp+"</td><td class=\"text-right\">"+jumlah+"</td><td class=\"text-center\"><button type=\"button\" style=\"padding: 0px 20px;\" onclick=\"HapusRow(this)\" class=\"btn btn-danger btn-sm\"><i class=\"fa fa-times\"></i></button></td></tr>";
				
		if(dataArr.length > 0){
			$('#table-dummy-bs > tbody > tr:first').before(row);
		}else{
			$('#table-dummy-bs > tbody:last').append(row);
		}
		
		/*$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/badstock/getsaldobarangdc",
			data: "barang_kode="+kd_barang,
			success: function(msg){
				var row = "<tr><td>"+kd_barang+"</td><td>"+nama_barang+"</td><td>"+satuan+"</td><td class=\"text-right\">"+msg+"</td><td class=\"text-right\">"+kwt+"</td><td class=\"text-center\"><button type=\"button\" style=\"padding: 0px 20px;\" onclick=\"HapusRow(this)\" class=\"btn btn-danger btn-sm\"><i class=\"fa fa-times\"></i></button></td></tr>";
				
				if(dataArr.length > 0){
					$('#table-dummy-bs > tbody > tr:first').before(row);
				}else{
					$('#table-dummy-bs > tbody:last').append(row);
				}
			}
		});*/
	}
	
	function clearForm(){
		$('#table-dummy-bs tbody').html("");
		$("#bs_barang").select2("val", "");
		$("#bs_kwt").val("");
	}
	
	function SimpanBS(){
		$('#btn-simpan').hide();
		$('#loader-form').show();
		
		var dataArr = [];
	    $("#table-dummy-bs td").each(function(){
	        dataArr.push($(this).html());
	    });
	    var mode = $("#mode").val();
		var bukti = $("#bs_bukti").val();
		var tanggal = $("#bs_tanggal").val();
		
		if(mode == "i"){
			var modeBukti = "BS";
			var tanggal_od = $("#bs_tanggal").val();
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
				url: "<?= base_url(); ?>index.php/badstock/hapusbadstock",
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
		var tanggal = $("#bs_tanggal").val();
		var mode = $("#mode").val();
		var gudang_bs = $("#bs_mode").val();
		
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/badstock/simpanbadstock",
			data: "mode="+mode+"&bukti="+bukti+"&barang_kode="+kd_barang+"&kwt="+kwt+"&hpp="+hpp+"&jumlah="+jumlah+"&tanggal="+tanggal+"&gudang_bs="+gudang_bs,
			success: function(msg){
				index = index + 7;
				if(index >= dataArr.length){ // jika sudah sampai index yang terakhir
					$('#btn-simpan').show();
					$('#loader-form').hide();
					
					ShowMessage("success", "Data berhasil disimpan");

					$('#table-dummy-bs tbody').html("");

					LoadDataBadStock();
					$("#form-bs").modal("hide");
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
	
	function HapusBadStock(){
		var data_obj = $('#dataTables-bs tr.active').attr("data");
		
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			$('#progres-main').show();
			$.ajax({
				type: "POST",
				url: "<?= base_url(); ?>index.php/badstock/hapusbadstock",
				data: "bukti="+data['bukti']+"&tanggal="+data['tanggal'],
				success: function(msg){
					ShowMessage("success", "Data berhasil dihapus");
					LoadDataBadStock();
				}
			});
		}
	}
	
	function openFormEditBadStock(){
		var data_obj = $('#dataTables-bs tr.active').attr("data");
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			
			$("#mode").val("e");
			$("#bs_bukti").val(data['bukti']);
			$("#bs_tanggal").val(data['tanggal']);
			$("#bs_mode").val(data['toko_kode']);
			
			$.ajax({
				type: "POST",
				url: "<?= base_url() ?>index.php/badstock/getdatabarangbadstock",
				data: "bukti="+data['bukti'],
				success: function(msg){
					$("#table-dummy-bs tbody").html(msg);
				}
			});
			
			$("#form-bs").modal("show");
		}
	}
	
	function ListBarangSupplier(){
		var supplier_kode = $("#bs_supplier").val();
		var toko_kode = $("#bs_toko").val();
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/badstock/getdatabarangsupplier",
			data: "supplier_kode="+supplier_kode+"&toko_kode="+toko_kode,
			success: function(msg){
				$("#table-dummy-bs tbody").html(msg);
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
	
	function CetakBadStock(){
		var data_obj = $('#dataTables-bs tr.active').attr("data");
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			window.open('<?= base_url('index.php/badstock/cetakbs?') ?>bukti='+data['bukti'],'_blank');
		}
	}
</script>