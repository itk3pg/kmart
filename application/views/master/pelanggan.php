<div id="page-wrapper">
	<div class="row">
	    <div class="col-lg-12">
	        <h1 style="margin-top: 15px;" class="page-header">Data Pelanggan</h1>
	    </div>
	    <!-- /.col-lg-12 -->
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="message"></div>
			<div class="panel panel-default">
				<div class="panel-heading">
					&nbsp;
					<button id="btn_upload" onclick="openFormjenispelanggan()" class="btn btn-success btn-sm" type="button">
						<i class="fa fa-table"></i>
						&nbsp;&nbsp;Jenis Pelanggan
					</button>
                    <button id="btn_upload" onclick="openFormpelanggan(1)" class="btn btn-info btn-sm" type="button">
						<i class="fa fa-plus"></i>
						&nbsp;&nbsp;Tambah
					</button>
					<button id="btn_upload" onclick="openFormpelanggan(2)" class="btn btn-warning btn-sm" type="button">
						<i class="fa fa-edit"></i>
						&nbsp;&nbsp;Edit
					</button>
					<button id="btn_upload" fungsi="Hapuspelanggan()" class="btn btn-danger btn-sm ask" type="button">
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
					<div class="table-responsive table-pelanggan">
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Form popup untuk tambah pelanggan -->
	<div class="modal fade" id="form-pelanggan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        			<h4 class="modal-title" id="myModalLabel">Form pelanggan</h4>
				</div>
				<div class="modal-body">
					<table width="100%">
						<tr>
							<td>
								Kode Pelanggan :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<input type="hidden" name="pelanggan_mode" id="pelanggan_mode" value="1" />
									<input type="text" placeholder="Kode Pelanggan" name="pelanggan_kd_pelanggan" id="pelanggan_kd_pelanggan" class="form-control">
								</div>
								Jenis Pelanggan :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<select style="width: 100%" name="pelanggan_jenis" id="pelanggan_jenis"></select>
								</div>
								Nama Pelanggan :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-money"></i>
									</span>
									<input type="text" placeholder="Nama Pelanggan" name="pelanggan_nama_pelanggan" id="pelanggan_nama_pelanggan" class="form-control">
								</div>
								No Anggota :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-money"></i>
									</span>
									<input type="text" placeholder="No Anggota" name="pelanggan_no_anggota" id="pelanggan_no_anggota" class="form-control">
								</div>
								Alamat :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-money"></i>
									</span>
									<input type="text" placeholder="Alamat" name="pelanggan_alamat" id="pelanggan_alamat" class="form-control">
								</div>
								Perusahaan :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-money"></i>
									</span>
									<select name="pelanggan_kd_prsh" id="pelanggan_kd_prsh" class="form-control">
										<?php foreach($data_prsh as $key => $value){
											echo "<option value=\"".$value['kd_prsh']."\">".$value['nm_prsh']."</option>";
										} ?>
									</select>
								</div>
							</td>
							<td>&nbsp;&nbsp;</td>
							<td valign="top">
								No Pegawai :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-money"></i>
									</span>
									<input type="text" placeholder="No Pegawai" name="pelanggan_no_pegawai" id="pelanggan_no_pegawai" class="form-control">
								</div>
								Kota :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-money"></i>
									</span>
									<input type="text" placeholder="Kota" name="pelanggan_kota" id="pelanggan_kota" class="form-control">
								</div>
								Provinsi :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-money"></i>
									</span>
									<input type="text" placeholder="Provinsi" name="pelanggan_provinsi" id="pelanggan_provinsi" class="form-control">
								</div>
								No Telp :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-money"></i>
									</span>
									<input type="text" placeholder="No Telp" name="pelanggan_no_telp" id="pelanggan_no_telp" class="form-control">
								</div>
								Bagian :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-money"></i>
									</span>
									<input type="text" placeholder="bagian" name="pelanggan_bagian" id="pelanggan_bagian" class="form-control">
								</div>
								Departemen :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-money"></i>
									</span>
									<input type="text" placeholder="Departemen" name="pelanggan_departemen" id="pelanggan_departemen" class="form-control">
								</div>
							</td>
						</tr>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" onclick="clearForm()" class="btn btn-default">Reset</button>
					<button type="button" class="btn btn-default" onclick="clearForm()" data-dismiss="modal">Close</button>
					<img src="<?= base_url() ?>/images/loader.gif" id="loader-form"  style="width: 30px; display: none;" />
			        <button type="button" id="btn-simpan" onclick="simpanpelanggan()" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;&nbsp;Simpan</button>
				</div>
			</div>
		</div>
	</div>
	<!-- Form popup untuk jenis pelanggan -->
	<div class="modal fade" id="form-jenispelanggan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        			<h4 class="modal-title" id="myModalLabel">Data Jenis Pelanggan</h4>
				</div>
				<div class="modal-body">
					<table width="100%">
						<tr>
							<td>
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<input type="text" placeholder="Nama Jenis Pelanggan" name="nama_jenis" id="nama_jenis" class="form-control">
									<input type="hidden" name="kode_jenis" id="kode_jenis" class="form-control">
								</div>
							</td>
							<td>&nbsp;</td>
							<td valign="top">
								<button id="btn_tambah" onclick="simpanjenispelanggan()" class="btn btn-info btn-sm" type="button">
									<i class="fa fa-plus"></i>
									&nbsp;&nbsp;Simpan
								</button>
								<button id="btn_hapus" fungsi="hapusjenispelanggan()" class="btn btn-danger btn-sm ask-jenis" type="button">
									<i class="fa fa-times"></i>
									&nbsp;&nbsp;Hapus
								</button>
							</td>
							<td align="left" valign="top">
								<img style="width: 30px; display: none;" id="loader-jenis" src="<?php echo base_url(); ?>images/loader.gif" />
							</td>
						</tr>
					</table>
					<div id="table-jenispelanggan"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		OpenMenu();
		
		LoadDatapelanggan();
		loadListJenisPelanggan();
		
		$('.ask').jConfirmAction();
		$('.ask-jenis').jConfirmAction();

		$("#pelanggan_kd_prsh").select2();
	});
	
	function LoadDatapelanggan(){
		$('#progres-main').show();
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/pelanggan/getdatapelanggan",
			data: "",
			success: function(msg){
				$(".table-pelanggan").html(msg);
				table = $('#dataTables-pelanggan').dataTable();
				$('#progres-main').hide();
				
				$('#dataTables-pelanggan tbody').on( 'click', 'tr', function () {
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
	
	function LoadDatajenispelanggan(){
		$('#loader-jenis').show();
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/pelanggan/getdatajenispelanggan",
			data: "",
			success: function(msg){
				$("#table-jenispelanggan").html(msg);
				$('#loader-jenis').hide();
				
				$('#dataTables-jenispelanggan tbody').on( 'click', 'tr', function () {
			        if ( $(this).hasClass('active') ) {
			            $(this).removeClass('active');
			        }else {
			            $('#dataTables-jenispelanggan tr.active').removeClass('active');
			            $(this).addClass('active');
			        }
			    } );
			}
		});
	}
	
	function loadListJenisPelanggan(){
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/pelanggan/getselectjenispelanggan",
			data: "",
			success: function(msg){
				$("#pelanggan_jenis").select2("destroy");
				$("#pelanggan_jenis").html(msg);
				$("#pelanggan_jenis").select2();
			}
		});
	}
	
	function openFormpelanggan(mode){
		if(mode == "1"){ // untuk insert
			$("#pelanggan_mode").val("1");
			var ts = Math.round((new Date()).getTime() / 1000);
			// $("#pelanggan_kd_pelanggan").val(ts);
			$("#pelanggan_kd_pelanggan").prop("readonly", false);
			
			$('#form-pelanggan').modal('show');
		}else{ // untuk edit
			var data = table.$('tr.active').attr("data");
			
			if(typeof data == "undefined"){
				alert("Silahkan pilih salah satu data terlebih dahulu");
			}else{
				var dataArr = json_decode(base64_decode(data));
				$("#pelanggan_kd_pelanggan").val(dataArr['kode']);
				$("#pelanggan_kd_pelanggan").prop("readonly", true);
				$("#pelanggan_jenis").val(dataArr['jenis_pelanggan']);
				$("#pelanggan_nama_pelanggan").val(dataArr['nama_pelanggan']);
				$("#pelanggan_alamat").val(dataArr['alamat']);
				$("#pelanggan_kota").val(dataArr['kota']);
				$("#pelanggan_provinsi").val(dataArr['provinsi']);
				$("#pelanggan_no_telp").val(dataArr['no_telp']);

				$("#pelanggan_no_anggota").val(dataArr['no_ang']);
				$("#pelanggan_kd_prsh").select2('val', dataArr['kd_prsh']);
				$("#pelanggan_no_pegawai").val(dataArr['no_peg']);
				$("#pelanggan_bagian").val(dataArr['bagian']);
				$("#pelanggan_departemen").val(dataArr['departemen']);
				
				$("#pelanggan_mode").val("2");
				$('#form-pelanggan').modal('show');
			}
		}
	}
	
	function simpanpelanggan(){
		$("#btn-simpan").hide();
		$("#loader-form").show();
		var kd_pelanggan = $("#pelanggan_kd_pelanggan").val();
		var jenis_pelanggan = $("#pelanggan_jenis").val();
		var nama_pelanggan = $("#pelanggan_nama_pelanggan").val();
		var alamat = $("#pelanggan_alamat").val();
		var kota = $("#pelanggan_kota").val();
		var provinsi = $("#pelanggan_provinsi").val();
		var no_telp = $("#pelanggan_no_telp").val();
		var pelanggan_mode = $("#pelanggan_mode").val();
		var no_anggota = $("#pelanggan_no_anggota").val();
		var perusahaan = $("#pelanggan_kd_prsh").select2('val');
		var no_pegawai = $("#pelanggan_no_pegawai").val();
		var bagian = $("#pelanggan_bagian").val();
		var departemen = $("#pelanggan_departemen").val();
		
		$.ajax({
			type: "POST",
			url: "<?= base_url(); ?>index.php/pelanggan/simpanpelanggan",
			data: "kode="+kd_pelanggan+"&jenis_pelanggan="+jenis_pelanggan+"&nama_pelanggan="+nama_pelanggan+"&alamat="+alamat+"&kota="+kota+"&provinsi="+provinsi+"&no_telp="+no_telp+"&pelanggan_mode="+pelanggan_mode+"&no_anggota="+no_anggota+"&perusahaan="+perusahaan+"&no_pegawai="+no_pegawai+"&bagian="+bagian+"&departemen="+departemen,
			success: function(msg){
				$("#btn-simpan").show();
				$("#loader-form").hide();
				$('#form-pelanggan').modal('hide');
				clearForm();
				ShowMessage('success', 'Data berhasil disimpan');
				LoadDatapelanggan();
			},
			error: function(xhr,status,error){
				alert(status);
				ShowMessage('danger', 'Data gagal disimpan disimpan');
			}
		});
	}
	
	function simpanjenispelanggan(){
		var nama_jenis = $("#nama_jenis").val();
		if(nama_jenis != ""){
			$('#loader-jenis').show();
			$.ajax({
				type: "POST",
				url: "<?= base_url(); ?>index.php/pelanggan/simpanjenispelanggan",
				data: "nama="+nama_jenis,
				success: function(msg){
					$("#nama_jenis").val("");
					LoadDatajenispelanggan();
					loadListJenisPelanggan();
				}
			});
		}
	}
	
	function Hapuspelanggan(){
		var kd_pelanggan = table.$('tr.active').attr("kode");
		
		if(typeof kd_pelanggan == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			$.ajax({
				type: "POST",
				url: "<?= base_url(); ?>index.php/pelanggan/hapuspelanggan",
				data: "kode="+kd_pelanggan,
				success: function(msg){
					ShowMessage('success', 'Data berhasil dihapus');
					LoadDatapelanggan();
				}
			});
		}
	}
	
	function hapusjenispelanggan(){
		var kode_jenis = $('#dataTables-jenispelanggan tr.active').attr("kode");
		
		if(typeof kode_jenis == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			$('#loader-jenis').show();
			$.ajax({
				type: "POST",
				url: "<?= base_url(); ?>index.php/pelanggan/hapusjenispelanggan",
				data: "kode="+kode_jenis,
				success: function(msg){
					LoadDatajenispelanggan();
				}
			});
		}
	}
	
	function openFormjenispelanggan(){
		$('#form-jenispelanggan').modal('show');
		
		LoadDatajenispelanggan();
	}
	
	function clearForm(){
		$("#pelanggan_kd_pelanggan").val("");
		$("#pelanggan_nama_pelanggan").val("");
		$("#pelanggan_alamat").val("");
		$("#pelanggan_kota").val("");
		$("#pelanggan_provinsi").val("");
		$("#pelanggan_no_telp").val("");
		
		$("#pelanggan_mode").val("1");
	}
</script>