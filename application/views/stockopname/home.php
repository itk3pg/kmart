<div id="page-wrapper">
	<div class="row">
	    <div class="col-lg-12">
	        <h1 style="margin-top: 15px;" class="page-header">Stock Opname</h1>
	    </div>
	    <!-- /.col-lg-12 -->
	</div>
	<div class="row">
		<div class="col-lg-12">
			<table style="float: right;">
				<tr>
					<td style="width: 125px;">
						Toko :
						<div class="form-group input-group">
							<span class="input-group-addon">
								<i class="fa fa-file"></i>
							</span>
							<select onchange="loadListBukti();" class="form-control" style='width: 200px;' name="cari_toko_kode" id="cari_toko_kode">
								<option value="-1">Pilih Toko</option>
							</select>
						</div>
					</td>
					<td>&nbsp;&nbsp;</td>
					<td style="width: 125px;">
						Bukti :
						<div class="form-group input-group">
							<span class="input-group-addon">
								<i class="fa fa-file"></i>
							</span>
							<select class="form-control" style='width: 150px;' name="cari_bukti" id="cari_bukti">
								<option value="-1">Pilih Bukti</option>
							</select>
						</div>
					</td>
					<td>&nbsp;&nbsp;</td>
					<td style="width: 200px;">
						<button id="btn_upload" style="float: right; padding: 7px 11px" onclick="FirstLoadDataBarang()" class="btn btn-success btn-sm" type="button">
							<i class="fa fa-search"></i>
						</button>
						<input style="width: 150px; float: right;" type="text" onkeypress="runScript(event)" name="cari_barang" id="cari_barang" class="form-control" />
					</td>
				</tr>
			</table>
		</div>
	</div>
	<!--<div class="row" style="margin-top: 10px;">
		<div class="col-lg-12">
			<table>
				<tr>
					<td>
						Bukti :
						<div class="form-group input-group">
							<span class="input-group-addon">
								<i class="fa fa-file"></i>
							</span>
							<input type="text" style="width: 150px;" value="SO<?php echo date('Ymd'); ?>" name="stockopname_bukti" id="stockopname_bukti" readonly class="form-control">
						</div>
					</td>
					<td>&nbsp;&nbsp;</td>
					<td>
						Toko :
						<div class="form-group input-group">
							<span class="input-group-addon">
								<i class="fa fa-file"></i>
							</span>
							<input type="text" style="width: 100px;" value="<?php echo $this->session->userdata('toko_kode') ?>" name="stockopname_toko" id="stockopname_toko" readonly class="form-control">
						</div>
					</td>
					<td>&nbsp;&nbsp;</td>
					<td>
						Rak :
						<div class="form-group input-group">
							<span class="input-group-addon">
								<i class="fa fa-file"></i>
							</span>
							<select class="form-control" style='width: 100px;' name="cari_rak" id="cari_rak">
								<option value="-1">Pilih Rak</option>
							</select>
						</div>
					</td>
					<td>&nbsp;&nbsp;</td>
					<!--<td>
						Stok Sistem :
						<div class="form-group input-group">
							<input type="text" readonly class="form-control" style="width: 100px;" name="stockopname_sistem" id="stockopname_sistem" />
						</div>
					</td>
					<td>&nbsp;&nbsp;</td>
					<td>
						Stok Opname :
						<div class="form-group input-group">
							<input type="text" class="form-control" style="width: 100px;" name="stockopname_opname" id="stockopname_opname" />
						</div>
					</td>
					<td>&nbsp;&nbsp;</td>
					<td valign="middle">
						<button id="btn-simpan" onclick="loadbarangrak()" class="btn btn-success" type="button">
							<i class="fa fa-refresh"></i>
							&nbsp;&nbsp;Load Barang
						</button>
						<img src="<?= base_url() ?>images/loader.gif" id="loader-form"  style="width: 30px; display: none;" />
					</td>
				</tr>
			</table>
		</div>
		<div class="col-lg-12">
			
		</div>
	</div>-->
	<div class="row" style="margin-top: 10px;">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<!--<button id="btn_upload" fungsi="HapusStockopname()" class="btn btn-danger btn-sm ask-stockopname" type="button">
						<i class="fa fa-times"></i>
						&nbsp;&nbsp;Hapus
					</button>-->
					<button id="btn_upload" onclick="CetakStockopname()" class="btn btn-info btn-sm" type="button">
						<i class="fa fa-print"></i>
						&nbsp;&nbsp;Cetak PDF
					</button>
					<button id="btn_upload" onclick="CetakStockopnameExcel()" class="btn btn-info btn-sm" type="button">
						<i class="fa fa-print"></i>
						&nbsp;&nbsp;Cetak Excel
					</button>
					<button id="btn_edit" onclick="EditStockopname()" class="btn btn-warning btn-sm" type="button">
						<i class="fa fa-edit"></i>
						&nbsp;&nbsp;Edit
					</button>
					<button style="display: none;" id="btn_simpan" onclick="SimpanStockopname()" class="btn btn-success btn-sm" type="button">
						<i class="fa fa-save"></i>
						&nbsp;&nbsp;Simpan
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
					<div class="table-responsive table-stockopname">
					</div>
					<table>
						<tr>
							<td>
								Kode Barang :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<input type="text"  style="width: 250px;" class="form-control" id="tambah_barang_kode" name="tambah_barang_kode" />
									<input type="hidden" name="tambah_stok_sys" id="tambah_stok_sys" />
								</div>
							</td>
							<td>&nbsp;</td>
							<td>
								Stok Fisik (OP) :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<input type="text"  style="width: 100px;" class="form-control" id="tambah_stok_op" name="tambah_stok_op" />
								</div>
							</td>
							<td>&nbsp;</td>
							<td>
								<button id="btn_tambah" onclick="TambahBarang()" class="btn btn-info btn-sm" type="button">
									<i class="fa fa-plus"></i>
									&nbsp;&nbsp;Tambah
								</button>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		OpenMenu();
		loadListToko();
		LoadListDataBarang();
		//loadListRak();
		
		$('.ask-stockopname').jConfirmAction();
	});
	
	function LoadListDataBarang(){
	    $("#tambah_barang_kode").select2({
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
		
		$("#tambah_barang_kode").on("select2-selecting", function(e) {
			getStokToko(e.choice.kode);
	    });
	}
	
	function getStokToko(barang_kode){
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/stockopname/getstoktoko",
			data: "barang_kode="+barang_kode+"&toko_kode="+$("#cari_toko_kode").val(),
			success: function(msg){
				$("#tambah_stok_sys").val(msg);
			}
		});
	}
	
	function TambahBarang(){
		var toko_kode = $("#cari_toko_kode").val();
		var bukti = $("#cari_bukti").val();
		var rak = $("#cari_rak").val();
		var stok_op = $("#tambah_stok_op").val();
		var barang_kode = $("#tambah_barang_kode").val();
		var nama_barang = $("#tambah_barang_kode").select2('data').nama_barang;
		var stok_sys = $("#tambah_stok_sys").val();
		var hpp = $("#tambah_barang_kode").select2('data').hpp;
		
		if(bukti !== null && rak !== null){
			$.ajax({
				type: "POST",
				url: "<?= base_url() ?>index.php/stockopname/tambahbarang",
				data: "toko_kode="+toko_kode+"&bukti="+bukti+"&rak="+rak+"&stok_op="+stok_op+"&barang_kode="+barang_kode+"&stok_sys="+stok_sys+"&hpp="+hpp,
				success: function(msg){
					var row = "<tr><td>"+rak+"</td><td></td><td></td><td>"+barang_kode+"</td><td>"+nama_barang+"</td><td>"+stok_sys+"</td><td>"+stok_op+"</td><td><?php echo $this->session->userdata('username'); ?></td></tr>";
					
					$('#dataTables-stockopname > tbody:last').append(row);
				}
			});
		}else{
			alert('bukti atau dan rak kosong');
		}
	}
	
	function LoadDataStockopname(){
		$('#progres-main').show();
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/stockopname/getdatastockopname",
			data: "toko_kode="+$('#cari_toko_kode').val()+"&bukti="+$('#cari_bukti').val()+"&rak="+$('#cari_rak').val(),
			success: function(msg){
				$(".table-stockopname").html(msg);
				//table = $('#dataTables-pembelian-barang').dataTable();
				$('#progres-main').hide();
				
				/*$('#dataTables-stockopname tbody').on( 'click', 'tr', function () {
			        if ( $(this).hasClass('active') ) {
			            $(this).removeClass('active');
			        }else {
			            $('#dataTables-stockopname tr.active').removeClass('active');
			            $(this).addClass('active');
			        }
			    } );*/
				$('#btn_edit').show();
				$('#btn_simpan').hide();
			}
		});
	}
	
	function loadListToko(){
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/toko/getListToko",
			data: "",
			success: function(msg){
				$("#cari_toko_kode").html(msg);
				
				loadListBukti();
			}
		});
	}
	
	function loadListBukti(){
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/stockopname/getlistdatabukti",
			data: "toko_kode="+$("#cari_toko_kode").val(),
			success: function(msg){
				$("#cari_bukti").html(msg);
				
				loadListRak();
			}
		});
	}
	
	function loadListRak(){
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/stockopname/getlistdatarak",
			data: "toko_kode="+$("#cari_toko_kode").val()+"&bukti="+$("#cari_bukti").val(),
			success: function(msg){
				$("#cari_rak").html(msg);
				$("#cari_rak").select2();
			}
		});
	}
	
	function SimpanStockopname(){
		$("#loader-form").show();
		$("#btn-simpan").hide();
		
		var DataStockOpname = $('input.input-so');
		var banyakdata = DataStockOpname.length;
		var dataParam = [];
		var i=0;
		for(i=0 ; i<banyakdata ; i++){
			var dataID = DataStockOpname[i].getAttribute('id');
			var dataValue = DataStockOpname[i].value;
			
			var dataArr = dataID.split("_");
			
			if(dataValue != ''){
				var bukti = dataArr[2];
				var toko_kode = dataArr[3];
				var barang_kode = dataArr[1];
				var stok_sistem = dataArr[4];
				var rak = dataArr[5];
				var shlv = dataArr[6];
				var urut = dataArr[7];
				var stok_opname = dataValue;
				var selisih = parseFloat(stok_sistem) - parseFloat(stok_opname);
				//var rak = $("#cari_rak").val();
				
				var subParam = [];
				subParam.push(bukti);
				subParam.push(toko_kode);
				subParam.push(barang_kode);
				subParam.push(stok_opname);
				subParam.push(selisih);
				subParam.push(rak);
				subParam.push(shlv);
				subParam.push(urut);
				
				dataParam.push(subParam);
			}
		}
		var jsonData = rawurlencode(json_encode(dataParam));
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/stockopname/simpanstockopname",
			data: "data="+jsonData,
			success: function(msg){
				$("#loader-form").hide();
				$("#btn-simpan").show();
		
				//ClearForm();
				
				LoadDataStockopname();
			}
		});
	}

	function SimpanStockopnameSatu(DataStockOpname){
		var dataParam = [];
		// Dataaaaa = DataStockOpname;
		var dataID = DataStockOpname.attr('id');
		// alert(dataID);
		var dataValue = DataStockOpname.val();
		
		var dataArr = dataID.split("_");
		
		if(dataValue != ''){
			var bukti = dataArr[2];
			var toko_kode = dataArr[3];
			var barang_kode = dataArr[1];
			var stok_sistem = dataArr[4];
			var rak = dataArr[5];
			var shlv = dataArr[6];
			var urut = dataArr[7];
			var stok_opname = dataValue;
			var selisih = parseFloat(stok_sistem) - parseFloat(stok_opname);
			//var rak = $("#cari_rak").val();
			
			var subParam = [];
			subParam.push(bukti);
			subParam.push(toko_kode);
			subParam.push(barang_kode);
			subParam.push(stok_opname);
			subParam.push(selisih);
			subParam.push(rak);
			subParam.push(shlv);
			subParam.push(urut);
			
			dataParam.push(subParam);
		}

		var jsonData = rawurlencode(json_encode(dataParam));
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/stockopname/simpanstockopname",
			data: "data="+jsonData,
			success: function(msg){
				$("#loader-form").hide();
				$("#btn-simpan").show();
		
				//ClearForm();
				
				// LoadDataStockopname();
			}
		});
	}
	
	function HapusStockopname(){
		var data_obj = $('#dataTables-stockopname tr.active').attr("data");
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			$('#progres-main').show();
			$.ajax({
				type: "POST",
				url: "<?= base_url(); ?>index.php/stockopname/HapusStockopname",
				data: "kode="+data['kode'],
				success: function(msg){
					ShowMessage("success", "Data berhasil dihapus");
					LoadDataStockopname();
				}
			});
		}
	}
	
	function ClearForm(){
		
	}
	
	function EditStockopname(){
		$('#progres-main').show();
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/stockopname/geteditstockopname",
			data: "toko_kode="+$('#cari_toko_kode').val()+"&bukti="+$('#cari_bukti').val()+"&rak="+$('#cari_rak').val(),
			success: function(msg){
				$(".table-stockopname").html(msg);
				//table = $('#dataTables-pembelian-barang').dataTable();
				$('#progres-main').hide();
				
				$('#btn_edit').hide();
				$('#btn_simpan').show();
				
				$('input.input-so').on('keyup', function (e){
					if(e.which == 13){
						$(this).parent('td').parent('tr').next('tr').find('input').focus();
						$(this).parent('td').parent('tr').next('tr').find('input').select();

						$data = $(this).parent('td').parent('tr').find('input');
						SimpanStockopnameSatu($data);
					}
				});
			}
		});
	}
	
	function CetakStockopname(){
		var bukti = $("#cari_bukti").val();
		var toko_kode = $("#cari_toko_kode").val();
		var nama_toko = $("#cari_toko_kode :selected").text();
		var rak = $("#cari_rak").val();
		
		window.open('<?= base_url('index.php/stockopname/cetakstockopname?') ?>bukti='+bukti+'&toko_kode='+toko_kode+"&nama_toko="+nama_toko+"&rak="+rak,'_blank');
	}
	
	function CetakStockopnameExcel(){
		var bukti = $("#cari_bukti").val();
		var toko_kode = $("#cari_toko_kode").val();
		var nama_toko = $("#cari_toko_kode :selected").text();
		var rak = $("#cari_rak").val();
		
		window.open('<?= base_url('index.php/stockopname/cetakstockopnameexcel?') ?>bukti='+bukti+'&toko_kode='+toko_kode+"&nama_toko="+nama_toko+"&rak="+rak,'_blank');
	}
</script>