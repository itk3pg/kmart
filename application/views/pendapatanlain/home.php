<style>
	.datepicker{z-index:1151 !important;}
</style>
<div id="page-wrapper">
	<div class="row">
	    <div class="col-lg-12">
	        <h1 style="margin-top: 15px;" class="page-header">Pendapatan Lain-Lain (PL)</h1>
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
						<button id="btn_upload" onclick="LoadDataPendapatanLain()" class="btn btn-info" type="button">
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
					<?php if($this->session->userdata('group_kode') != "GRU0010"){ ?>
					<button id="btn_tambah" onclick="openFormPendapatanLain()" class="btn btn-info btn-sm" type="button">
						<i class="fa fa-plus"></i>
						&nbsp;&nbsp;Tambah
					</button>
					<button id="btn_uedit" onclick="openFormEditPendapatanLain()" class="btn btn-success btn-sm" type="button">
						<i class="fa fa-edit"></i>
						&nbsp;&nbsp;Edit
					</button>
					<button id="btn_hapus" fungsi="HapusPendapatanLain()" class="btn btn-danger btn-sm ask-pendapatanlain" type="button">
						<i class="fa fa-times"></i>
						&nbsp;&nbsp;Hapus
					</button>
					<?php } ?>
					<?php if($this->session->userdata('username') == "100"){ ?>
					<button id="btn_uedit" onclick="BukaAkses()" class="btn btn-warning btn-sm" type="button">
						<i class="fa fa-edit"></i>
						&nbsp;&nbsp;Buka Akses Edit/Hapus
					</button>
					<?php } ?>
					<button id="btn_tambah" onclick="CetakRekap();" class="btn btn-warning btn-sm" type="button">
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
					<div class="table-responsive table-pendapatanlain">
						
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Popup form untuk retur barang -->
	<div class="modal fade" id="form-pendapatanlain" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        			<h4 class="modal-title" id="myModalLabel">Form Pendapatan Lain-Lain (PL)</h4>
				</div>
				<div class="modal-body">
					<table style="width: 100%;">
						<tr>
							<td style="width: 200px;">Tanggal :</td>
							<td>&nbsp;&nbsp;
								<input type="hidden" name="mode" id="mode" value="i"/>
								<input type="hidden" name="pendapatanlain_bukti" id="pendapatanlain_bukti"/>
							</td>
							<td>Supplier :</td>
						</tr>
						<tr>
							<td>
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</span>
									<input type="text" value="<?= date("Y-m-d"); ?>" placeholder="Tanggal OT" name="pendapatanlain_tanggal" id="pendapatanlain_tanggal" class="form-control">
								</div>
							</td>
							<td>&nbsp;&nbsp;</td>
							<td>
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<select class="form-control" name="pendapatanlain_supplier" id="pendapatanlain_supplier">
										<option value="-1">Pilih Supplier</option>
									</select>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<select class="form-control" name="pendapatanlain_toko_kode" id="pendapatanlain_toko_kode">
										<option value="VO0001">SEGUNTING</option>
										<option value="VO0002">BOGOREJO</option>
										<option value="VO0003">MINI K-MART GELURAN</option>
										<option value="VO0004">MINI K-MART GKB</option>
										<option value="VO0005">MINI K-MART PANJUNAN</option>
									</select>
								</div>
							</td>
							<td>&nbsp;&nbsp;</td>
							<td>
								
							</td>
						</tr>
					</table>
					<label class="radio-inline">
						<input id="pendapatanlain_status_potong" checked type="radio" value="0" name="pendapatanlain_status"> Potong Hutang
					</label>
					<label class="radio-inline">
						<input id="pendapatanlain_status_tunai" type="radio" value="1" name="pendapatanlain_status"> Tunai
					</label>
					<table style="width: 100%; margin-bottom: 5px;">
						<tr>
							<td style="width: 200px;">Keterangan :</td>
							<td>&nbsp;&nbsp;</td>
							<td>
								Jumlah :
								<input type="checkbox" name="pendapatanlain_include" checked id="pendapatanlain_include" />
								Termasuk PPN
							</td>
						</tr>
						<tr>
							<td width="250px">
								<input type="text" class="form-control" onkeyup="setUpper('pendapatanlain_keterangan')" name="pendapatanlain_keterangan" id="pendapatanlain_keterangan" />
							</td>
							<td>&nbsp;&nbsp;</td>
							<td><input type="text" style="text-align:right;" class="form-control" name="pendapatanlain_jumlah" id="pendapatanlain_jumlah" /></td>
							<td>&nbsp;&nbsp;</td>
							<td>
								<button id="btn_tambah_barang" onclick="TambahBarangPendapatanLain()" class="btn btn-success btn-sm" type="button">
									<i class="fa fa-plus"></i>
									&nbsp;&nbsp;Tambah
								</button>
							</td>
						</tr>
					</table>
					<table style="width: 100%" id="table-dummy-pendapatanlain" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th class="text-center">Keterangan</th>
								<th class="text-center">DPP</th>
								<th class="text-center">PPN</th>
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
			        <button type="button" id="btn-simpan" onclick="SimpanPendapatanLain()" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;&nbsp;Simpan</button>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		OpenMenu();
		LoadDataPendapatanLain();
		loadListSupplier();
		
		$('.ask-pendapatanlain').jConfirmAction();
		
		$('#pendapatanlain_tanggal').datepicker({
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
				$("#pendapatanlain_supplier").html(msg);
				$("#pendapatanlain_supplier").select2();
			}
		});
	}
	
	function LoadDataPendapatanLain(){
		$('#progres-main').show();
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/pendapatanlain/getdatapendapatanlain",
			data: "tahun="+$("#tahun").val()+"&bulan="+$("#bulan").val(),
			success: function(msg){
				$(".table-pendapatanlain").html(msg);
				//table = $('#dataTables-pendapatanlain').dataTable();
				$('#progres-main').hide();
				
				$('#dataTables-pendapatanlain tbody').on( 'click', 'tr', function () {
			        if ( $(this).hasClass('active') ) {
			            $(this).removeClass('active');
			        }else {
			            $('#dataTables-pendapatanlain tr.active').removeClass('active');
			            $(this).addClass('active');
			        }
			    } );
			}
		});
	}
	
	function openFormPendapatanLain(){
		clearForm();
		$("#form-pendapatanlain").modal("show");
		$("#mode").val("i");
		$("#pendapatanlain_bukti").val("");
		$("#pendapatanlain_supplier").prop("disabled", false);
	}
	
	function HapusRow(DataObj){
		dataobj = DataObj;
		$(DataObj).parent().parent().remove();
	}
	
	function TambahBarangPendapatanLain(){
		var keterangan = $("#pendapatanlain_keterangan").val();
		var jumlah = $("#pendapatanlain_jumlah").val();
		var dpp = $("#pendapatanlain_jumlah").val();
		var ppn = parseFloat(jumlah) * 0.11; //k3pg-ppn
		jumlah = parseFloat(dpp) + parseFloat(ppn);
		
		if($('#pendapatanlain_include').is(':checked')){
			jumlah = $("#pendapatanlain_jumlah").val();
			dpp = parseFloat(jumlah) / 1.11; //k3pg-ppn
			ppn = dpp * 0.11; //k3pg-ppn
		}
		
		var row = "<tr><td>"+keterangan+"</td><td class=\"text-right\">"+round(dpp,2)+"</td><td class=\"text-right\">"+round(ppn,2)+"</td><td class=\"text-right\">"+round(jumlah,2)+"</td><td class=\"text-center\"><button type=\"button\" style=\"padding: 0px 20px;\" onclick=\"HapusRow(this)\" class=\"btn btn-danger btn-sm\"><i class=\"fa fa-times\"></i></button></td></tr>";
		$('#table-dummy-pendapatanlain > tbody:last').append(row);
	}
	
	function clearForm(){
		$('#table-dummy-pendapatanlain tbody').html("");
		$("#pendapatanlain_keterangan").val("");
		$("#pendapatanlain_jumlah").val("");
		$("#pendapatanlain_supplier").select2("val", "-1");
	}
	
	function SimpanPendapatanLain(){
		$('#btn-simpan').hide();
		$('#loader-form').show();
		
		var dataArr = [];
	    $("#table-dummy-pendapatanlain td").each(function(){
	        dataArr.push($(this).html());
	    });
	    var mode = $("#mode").val();
		var bukti = $("#pendapatanlain_bukti").val();
		var supplier_kode = $("#pendapatanlain_supplier").val();
		
		if(mode == "i"){
			var modeBukti = "PL";
			var tanggal_pendapatanlain = $("#pendapatanlain_tanggal").val();
			$.ajax({
				type: "POST",
				url: "<?= base_url() ?>index.php/bukti/generatebukti",
				data: "mode="+modeBukti+"&tanggal="+tanggal_pendapatanlain,
				success: function(msg){
					ajaxsimpanpendapatanlain(msg, dataArr, 0);
				}
			});
		}else{
			$.ajax({
				type: "POST",
				url: "<?= base_url(); ?>index.php/pendapatanlain/hapuspendapatanlain",
				data: "bukti="+bukti+"&supplier_kode="+supplier_kode,
				success: function(msg){
					ajaxsimpanpendapatanlain(bukti, dataArr, 0);
				}
			});
		}
	}
	
	function ajaxsimpanpendapatanlain(bukti, dataArr, index){
		var keterangan = dataArr[index];
		var dpp = dataArr[index+1];
		var ppn = dataArr[index+2];
		var jumlah = dataArr[index+3];
		var tanggal = $("#pendapatanlain_tanggal").val();
		var supplier_kode = $("#pendapatanlain_supplier").val();
		var toko_kode = $("#pendapatanlain_toko_kode").val();
		var status_pembayaran = $("input[name=pendapatanlain_status]:checked").val();
		var mode = $("#mode").val();
		
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/pendapatanlain/simpanpendapatanlain",
			data: "mode="+mode+"&bukti="+bukti+"&keterangan="+keterangan+"&dpp="+dpp+"&ppn="+ppn+"&jumlah="+jumlah+"&tanggal="+tanggal+"&supplier_kode="+supplier_kode+"&toko_kode="+toko_kode+"&status_pembayaran="+status_pembayaran,
			success: function(msg){
				index = index + 5;
				if(index >= dataArr.length){ // jika sudah sampai index yang terakhir
					$('#btn-simpan').show();
					$('#loader-form').hide();
					
					ShowMessage("success", "Data berhasil disimpan");
					LoadDataPendapatanLain();
					$("#form-pendapatanlain").modal("hide");
					clearForm();
				}else{ // jika masih ada data yang dimasukkan
					ajaxsimpanpendapatanlain(bukti, dataArr, index);
				}
			},
			error: function(xhr,status,error){
				ShowMessage("danger", "Data gagal disimpan");
				$('#btn-simpan').show();
				$('#loader-form').hide();
			}
		});
	}
	
	function HapusPendapatanLain(){
		var data_obj = $('#dataTables-pendapatanlain tr.active').attr("data");
		
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			
			if(data['status_pembayaran'] == "0" && data['tukar_nota_bukti'] != "" && data['tukar_nota_bukti'] != "null"){
				alert("Pendapatan lain-lain sudah dipotongkan hutang (tukar nota)");
			}else if(data['status_tanggal'] == "1"){
				alert("tidak bisa diedit/hapus karena sudah melewati tanggal");
			}else{
				$('#progres-main').show();
				$.ajax({
					type: "POST",
					url: "<?= base_url(); ?>index.php/pendapatanlain/hapuspendapatanlain",
					data: "bukti="+data['bukti']+"&supplier_kode="+data['supplier_kode'],
					success: function(msg){
						ShowMessage("success", "Data berhasil dihapus");
						LoadDataPendapatanLain();
					}
				});
			}
		}
	}

	function BukaAkses(){
		var data_obj = $('#dataTables-pendapatanlain tr.active').attr("data");
		
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var isconfirm = confirm("Apakah anda akan mengijinkan transaksi untuk di edit/dihapus?");
			if(isconfirm){
				var data = json_decode(base64_decode(data_obj));
				
				$('#progres-main').show();
				$.ajax({
					type: "POST",
					url: "<?= base_url(); ?>index.php/pendapatanlain/bukaakses",
					data: "bukti="+data['bukti']+"&supplier_kode="+data['supplier_kode'],
					success: function(msg){
						ShowMessage("success", "Akses berhasil dibuka");
						LoadDataPendapatanLain();
					}
				});
			}
		}
	}
	
	function openFormEditPendapatanLain(){
		var data_obj = $('#dataTables-pendapatanlain tr.active').attr("data");
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			if(data['status_pembayaran'] == "0" && data['tukar_nota_bukti'] != "" && data['tukar_nota_bukti'] != "null"){
				alert("Pendapatan lain-lain sudah dipotongkan hutang (tukar nota)");
			}else if(data['status_tanggal'] == "1"){
				alert("tidak bisa diedit/hapus karena sudah melewati tanggal");
			}else{
				$("#mode").val("e");
				$("#pendapatanlain_bukti").val(data['bukti']);
				$("#pendapatanlain_tanggal").val(data['tanggal']);
				$("#pendapatanlain_supplier").select2("val", data['supplier_kode']);
				$("#pendapatanlain_supplier").prop("disabled", true);
				$("#pendapatanlain_toko_kode").val(data['toko_kode']);
				$("#pendapatanlain_toko_kode").prop("disabled", true);
				if(data['status_pembayaran'] == "0"){
					$("#pendapatanlain_status_potong").prop("checked", "checked");
				}else if(data['status_pembayaran'] == "1"){
					$("#pendapatanlain_status_tunai").prop("checked", "checked");
				}
				
				$.ajax({
					type: "POST",
					url: "<?= base_url() ?>index.php/pendapatanlain/getdetailpendapatanlain",
					data: "bukti="+data['bukti']+"&supplier_kode="+data['supplier_kode'],
					success: function(msg){
						$("#table-dummy-pendapatanlain tbody").html(msg);
					}
				});
				
				$("#form-pendapatanlain").modal("show");
			}
		}
	}

	function CetakRekap(){
		var bulan = $("#bulan").val();
		var tahun = $("#tahun").val();
		window.open('<?= base_url('index.php/pendapatanlain/cetakpendapatanlain?') ?>bulan='+bulan+'&tahun='+tahun,'_blank');
	}
</script>