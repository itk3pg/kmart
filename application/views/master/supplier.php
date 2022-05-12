<div id="page-wrapper">
	<div class="row">
	    <div class="col-lg-12">
	        <h1 style="margin-top: 15px;" class="page-header">Data Supplier</h1>
	    </div>
	    <!-- /.col-lg-12 -->
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="message"></div>
			<div class="panel panel-default">
				<div class="panel-heading">
					&nbsp;
                    <button id="btn_upload" onclick="openFormsupplier(1)" class="btn btn-info btn-sm" type="button">
						<i class="fa fa-plus"></i>
						&nbsp;&nbsp;Tambah
					</button>
					<button id="btn_upload" onclick="openFormsupplier(2)" class="btn btn-warning btn-sm" type="button">
						<i class="fa fa-edit"></i>
						&nbsp;&nbsp;Edit
					</button>
					<button id="btn_upload" fungsi="Hapussupplier()" class="btn btn-danger btn-sm ask" type="button">
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
					<div class="table-responsive table-supplier">
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Form popup untuk tambah pelanggan -->
	<div class="modal fade" id="form-supplier" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        			<h4 class="modal-title" id="myModalLabel">Form Supplier</h4>
				</div>
				<div class="modal-body">
					<table width="100%">
						<tr>
							<td>
								Kode Supplier :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<input type="hidden" name="supplier_mode" id="supplier_mode" value="1" />
									<input type="text" placeholder="Kode Supplier" name="supplier_kd_supplier" id="supplier_kd_supplier" class="form-control">
								</div>
								Nama Supplier :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<input type="text" placeholder="Nama Supplier" name="supplier_nama_supplier" id="supplier_nama_supplier" class="form-control">
								</div>
								Alamat :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<input type="text" placeholder="Alamat" name="supplier_alamat" id="supplier_alamat" class="form-control">
								</div>
								Kota :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<input type="text" placeholder="Kota" name="supplier_kota" id="supplier_kota" class="form-control">
								</div>
								Nama Bank :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<input type="text" placeholder="Nama Bank" name="supplier_nama_bank" id="supplier_nama_bank" class="form-control">
								</div>
								No Rekening :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<input type="text" placeholder="No Rekening" name="supplier_no_rekening" id="supplier_no_rekening" class="form-control">
								</div>
								Bank Atas Nama :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<input type="text" placeholder="Bank atas nama" name="supplier_atas_nama" id="supplier_atas_nama" class="form-control">
								</div>
							</td>
							<td>&nbsp;&nbsp;</td>
							<td valign="top">
								Provinsi :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<input type="text" placeholder="Provinsi" name="supplier_provinsi" id="supplier_provinsi" class="form-control">
								</div>
								No Telp :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<input type="text" placeholder="No Telp" name="supplier_no_telp" id="supplier_no_telp" class="form-control">
								</div>
								NPWP :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<input type="text" placeholder="NPWP" name="supplier_npwp" id="supplier_npwp" class="form-control">
								</div>
								TOP (hari) :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<input type="text" placeholder="TOP (dalam hari)" name="supplier_top" id="supplier_top" class="form-control">
								</div>
								Fee Konsinyasi (%):
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<input type="text" placeholder="Fee Konsinyasi (%)" name="supplier_fee_konsinyasi" id="supplier_fee_konsinyasi" class="form-control">
								</div>
								<input id="supplier_pkp" type="checkbox" checked name="supplier_pkp"> PKP
							</td>
						</tr>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" onclick="clearForm()" class="btn btn-default">Reset</button>
					<button type="button" class="btn btn-default" onclick="clearForm()" data-dismiss="modal">Close</button>
					<img src="<?= base_url() ?>/images/loader.gif" id="loader-form"  style="width: 30px; display: none;" />
			        <button type="button" id="btn-simpan" onclick="simpansupplier()" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;&nbsp;Simpan</button>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		OpenMenu();
		
		LoadDataSupplier();
		
		$('.ask').jConfirmAction();
		$('.ask-jenis').jConfirmAction();
	});
	
	function LoadDataSupplier(){
		$('#progres-main').show();
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/supplier/getdatasupplier",
			data: "",
			success: function(msg){
				$(".table-supplier").html(msg);
				table = $('#dataTables-supplier').dataTable({
					"scrollX": true
				});
				$('#progres-main').hide();
				
				$('#dataTables-supplier tbody').on( 'click', 'tr', function () {
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
	
	function openFormsupplier(mode){
		if(mode == "1"){ // untuk insert
			$("#supplier_mode").val("1");
			var ts = Math.round((new Date()).getTime() / 1000);
			$("#supplier_kd_supplier").val(ts);
			$("#supplier_kd_supplier").prop("readonly", false);
			
			$('#form-supplier').modal('show');
		}else{ // untuk edit
			var data = table.$('tr.active').attr("data");
			
			if(typeof data == "undefined"){
				alert("Silahkan pilih salah satu data terlebih dahulu");
			}else{
				var dataArr = json_decode(base64_decode(data));
				$("#supplier_kd_supplier").val(dataArr['kode']);
				$("#supplier_kd_supplier").prop("readonly", true);
				$("#supplier_nama_supplier").val(dataArr['nama_supplier']);
				$("#supplier_alamat").val(dataArr['alamat']);
				$("#supplier_kota").val(dataArr['kota']);
				$("#supplier_provinsi").val(dataArr['provinsi']);
				$("#supplier_no_telp").val(dataArr['no_telp']);
				$("#supplier_npwp").val(dataArr['npwp']);
				$("#supplier_nama_bank").val(dataArr['nama_bank']);
				$("#supplier_no_rekening").val(dataArr['no_rekening']);
				$("#supplier_atas_nama").val(dataArr['atas_nama']);
				$("#supplier_top").val(dataArr['top']);
				$("#supplier_fee_konsinyasi").val(dataArr['fee_konsinyasi']);
				
				if(dataArr['pkp'] == "1"){
					$("#supplier_pkp").prop("checked", "checked");
				}else{
					$("#supplier_pkp").removeAttr("checked");
				}
				
				$("#supplier_mode").val("2");
				$('#form-supplier').modal('show');
			}
		}
	}
	
	function simpansupplier(){
		$("#btn-simpan").hide();
		$("#loader-form").show();
		var kd_supplier = $("#supplier_kd_supplier").val();
		var nama_supplier = $("#supplier_nama_supplier").val();
		var alamat = $("#supplier_alamat").val();
		var kota = $("#supplier_kota").val();
		var provinsi = $("#supplier_provinsi").val();
		var no_telp = $("#supplier_no_telp").val();
		var npwp = $("#supplier_npwp").val();
		var nama_bank = $("#supplier_nama_bank").val();
		var no_rekening = $("#supplier_no_rekening").val();
		var atas_nama = $("#supplier_atas_nama").val();
		var top = $("#supplier_top").val();
		if(top == ""){
			top = "0";
		}
		var fee_konsinyasi = $("#supplier_fee_konsinyasi").val();
		if(fee_konsinyasi == ""){
			fee_konsinyasi = "0";
		}
		var supplier_mode = $("#supplier_mode").val();
		var pkp = "0";
		if($("#supplier_pkp").is(':checked')){
			pkp = '1';
		}
		
		$.ajax({
			type: "POST",
			url: "<?= base_url(); ?>index.php/supplier/simpansupplier",
			data: "kode="+base64_encode(kd_supplier)+"&nama_supplier="+base64_encode(nama_supplier)+"&alamat="+alamat+"&kota="+kota+"&provinsi="+provinsi+"&no_telp="+no_telp+"&npwp="+npwp+"&supplier_mode="+supplier_mode+"&pkp="+pkp+"&nama_bank="+nama_bank+"&no_rekening="+no_rekening+"&top="+top+"&atas_nama="+atas_nama+"&fee_konsinyasi="+fee_konsinyasi,
			success: function(msg){
				if(msg == "-1"){
					alert("data sudah ada di dalam database");
					$("#btn-simpan").show();
					$("#loader-form").hide();
				}else if(msg == "1"){
					$("#btn-simpan").show();
					$("#loader-form").hide();
					$('#form-supplier').modal('hide');
					clearForm();
					ShowMessage('success', 'Data berhasil disimpan');
					LoadDataSupplier();
				}
			},
			error: function(xhr,status,error){
				alert(status);
				ShowMessage('danger', 'Data gagal disimpan disimpan');
			}
		});
	}
	
	function Hapussupplier(){
		var kd_supplier = table.$('tr.active').attr("kode");
		
		if(typeof kd_supplier == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			$.ajax({
				type: "POST",
				url: "<?= base_url(); ?>index.php/supplier/hapussupplier",
				data: "kode="+base64_encode(kd_supplier),
				success: function(msg){
					if(msg == "-1"){
						alert("data gagal dihapus karena sudah dilakukan transaksi");
					}else if(msg == "1"){
						ShowMessage('success', 'Data berhasil dihapus');
						LoadDataSupplier();
					}else{
						alert(msg);
					}
				}
			});
		}
	}
	
	function clearForm(){
		$("#supplier_kd_supplier").val("");
		$("#supplier_nama_supplier").val("");
		$("#supplier_alamat").val("");
		$("#supplier_kota").val("");
		$("#supplier_provinsi").val("");
		$("#supplier_no_telp").val("");
		$("#supplier_fee_konsinyasi").val("");
		
		$("#supplier_mode").val("1");
	}
</script>