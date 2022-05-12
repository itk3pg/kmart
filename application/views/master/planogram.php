<div id="page-wrapper">
	<div class="row">
	    <div class="col-lg-12">
	        <h1 style="margin-top: 15px;" class="page-header">Master Planogram</h1>
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
							<select class="form-control" style='width: 200px;' name="cari_toko_kode" id="cari_toko_kode">
								<option value="-1">Pilih Toko</option>
							</select>
						</div>
					</td>
					<td>&nbsp;&nbsp;</td>
					<td valign="top">
						<button id="btn_upload" onclick="LoadDataPlanogram()" class="btn btn-info" type="button">
							<i class="fa fa-search"></i>
							&nbsp;&nbsp;Search
						</button>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="row" style="margin-top: 10px;">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<button id="btn_upload" onclick="openFormPlanogram()" class="btn btn-info btn-sm" type="button">
						<i class="fa fa-plus"></i>
						&nbsp;&nbsp;Tambah
					</button>
					<button id="btn_upload" onclick="openFormEditPlanogram()" class="btn btn-success btn-sm" type="button">
						<i class="fa fa-edit"></i>
						&nbsp;&nbsp;Edit
					</button>
					<button id="btn_upload" fungsi="HapusPlanogram()" class="btn btn-danger btn-sm ask-planogram" type="button">
						<i class="fa fa-times"></i>
						&nbsp;&nbsp;Hapus
					</button>
					<button id="btn_upload" onclick="CetakPlanogram()" class="btn btn-warning btn-sm" type="button">
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
					<div class="table-responsive table-planogram">
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Form popup untuk tambah planogram -->
	<div class="modal fade" id="form-planogram" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        			<h4 class="modal-title" id="myModalLabel">Form Planogram</h4>
				</div>
				<div class="modal-body">
					<table>
						<tr>
							<td width='48%' valign='top'>
								Toko :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<input type="hidden" name="planogram_kode" id="planogram_kode"/>
									<input type="hidden" name="planogram_mode" id="planogram_mode" value="i"/>
									<select class="form-control" style='width: 200px;' name="planogram_toko" id="planogram_toko">
										<option value="-1">Pilih Toko</option>
									</select>
								</div>
								Barang :
								<div class="form-group input-group">
									<input type="text" class="form-control" style="width: 260px;" name="planogram_barang" id="planogram_barang" />
								</div>
								Rak :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<input type="text" placeholder="Rak" onkeyup="toUpper('planogram_rak')" name="planogram_rak" id="planogram_rak" class="form-control">
								</div>
								Shlv :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<input type="text" placeholder="Shlv" onkeyup="toUpper('planogram_shlv')" name="planogram_shlv" id="planogram_shlv" class="form-control">
								</div>
							</td>
							<td width='4%'></td>
							<td width='48%' valign='top'>
								Urut :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<input type="text" placeholder="Urut" name="planogram_urut" id="planogram_urut" class="form-control">
								</div>
								Kiri-Kanan :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<input type="text" placeholder="Kiri-Kanan" name="planogram_kirikanan" id="planogram_kirikanan" class="form-control">
								</div>
								Depan-Belakang :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<input type="text" placeholder="Depan-Belakang" name="planogram_depanbelakang" id="planogram_depanbelakang" class="form-control">
								</div>
								Atas-Bawah :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<input type="text" placeholder="Atas-Bawah" name="planogram_atasbawah" id="planogram_atasbawah" class="form-control">
								</div>
							</td>
						</tr>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" onclick="clearForm()" class="btn btn-default">Reset</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<img src="<?= base_url() ?>images/loader.gif" id="loader-form"  style="width: 30px; display: none;" />
			        <button type="button" id="btn-simpan" onclick="simpanplanogram()" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;&nbsp;Simpan</button>
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
		
		$('.ask-planogram').jConfirmAction();
	});
	
	function LoadListDataBarang(){
	    $("#planogram_barang").select2({
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
	}
	
	function openFormPlanogram(){
		ClearForm();
		$("#form-planogram").modal("show");
		
		var cari_toko = $("#cari_toko_kode").val();
		$("#planogram_toko").val(cari_toko);
	}
	
	function LoadDataPlanogram(){
		$('#progres-main').show();
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/planogram/getdataplanogram",
			data: "toko_kode="+$('#cari_toko_kode').val(),
			success: function(msg){
				$(".table-planogram").html(msg);
				//table = $('#dataTables-pembelian-barang').dataTable();
				$('#progres-main').hide();
				
				$('#dataTables-planogram tbody').on( 'click', 'tr', function () {
			        if ( $(this).hasClass('active') ) {
			            $(this).removeClass('active');
			        }else {
			            $('#dataTables-planogram tr.active').removeClass('active');
			            $(this).addClass('active');
			        }
			    } );
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
				$("#planogram_toko").html(msg);
				
				LoadDataPlanogram();
			}
		});
	}
	
	function simpanplanogram(){
		$("#loader-form").show();
		$("#btn-simpan").hide();
		
		var planogram_kode = $("#planogram_kode").val();
		var toko_kode = $("#planogram_toko").val();
		var barang_kode = $("#planogram_barang").val();
		var rak = $("#planogram_rak").val();
		var shlv = $("#planogram_shlv").val();
		var urut = $("#planogram_urut").val();
		var kirikanan = $("#planogram_kirikanan").val();
		var depanbelakang = $("#planogram_depanbelakang").val();
		var atasbawah = $("#planogram_atasbawah").val();
		var mode = $("#planogram_mode").val();
		
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/planogram/simpanplanogram",
			data: "mode="+mode+"&planogram_kode="+planogram_kode+"&toko_kode="+toko_kode+"&barang_kode="+barang_kode+"&rak="+rak+"&shlv="+shlv+"&urut="+urut+"&kirikanan="+kirikanan+"&depanbelakang="+depanbelakang+"&atasbawah="+atasbawah+"",
			success: function(msg){
				$("#loader-form").hide();
				$("#btn-simpan").show();
		
				$("#form-planogram").modal("hide");
				ClearForm();
				
				LoadDataPlanogram();
			}
		});
	}
	
	function openFormEditPlanogram(){
		var data_obj = $('#dataTables-planogram tr.active').attr("data");
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			
			$("#planogram_mode").val("e");
			$("#planogram_kode").val(data['kode']);
			$("#planogram_toko").val(data['toko_kode']);
			$("#planogram_barang").val(data['barang_kode']);
			$("#planogram_rak").val(data['rak']);
			$("#planogram_shlv").val(data['shlv']);
			$("#planogram_urut").val(data['urut']);
			$("#planogram_kirikanan").val(data['kirikanan']);
			$("#planogram_depanbelakang").val(data['depanbelakang']);
			$("#planogram_atasbawah").val(data['atasbawah']);
			
			$("#form-planogram").modal("show");
		}
	}
	
	function HapusPlanogram(){
		var data_obj = $('#dataTables-planogram tr.active').attr("data");
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			$('#progres-main').show();
			$.ajax({
				type: "POST",
				url: "<?= base_url(); ?>index.php/planogram/hapusplanogram",
				data: "kode="+data['kode'],
				success: function(msg){
					ShowMessage("success", "Data berhasil dihapus");
					LoadDataPlanogram();
				}
			});
		}
	}
	
	function CetakPlanogram(){
		var toko_kode = $("#cari_toko_kode").val();
		var nama_toko = $("#cari_toko_kode :selected").text();
		
		window.open('<?= base_url('index.php/planogram/cetakplanogram?') ?>toko_kode='+toko_kode+"&nama_toko="+nama_toko,'_blank');
	}
	
	function ClearForm(){
		$("#planogram_mode").val("i");
		$("#planogram_kode").val("");
		$("#planogram_toko").val("");
		$("#planogram_barang").val("");
		$("#planogram_rak").val("");
		$("#planogram_shlv").val("");
		$("#planogram_urut").val("");
		$("#planogram_kirikanan").val("");
		$("#planogram_depanbelakang").val("");
		$("#planogram_atasbawah").val("");
	}
</script>