<div id="page-wrapper">
	<div class="row">
	    <div class="col-lg-6">
	        <h1 style="margin-top: 15px;" class="page-header">Master Kelompok Barang</h1>
	    </div>
	    <!-- /.col-lg-12 -->
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<button id="btn_upload" onclick="openFormTambahKelompokBarang()" class="btn btn-primary btn-sm" type="button">
						<i class="fa fa-plus"></i>
						&nbsp;&nbsp;Tambah
					</button>
					<button id="btn_upload" onclick="openFormEditKelompokBarang()" class="btn btn-success btn-sm" type="button">
						<i class="fa fa-edit"></i>
						&nbsp;&nbsp;Edit
					</button>
					<button id="btn_upload" fungsi="HapusKelompokBarang()" class="btn btn-danger btn-sm ask-kelbarang" type="button">
						<i class="fa fa-times"></i>
						&nbsp;&nbsp;Hapus
					</button>
					<button id="btn_upload" onclick="openFormKodeAkun()" class="btn btn-warning btn-sm" type="button">
						<i class="fa fa-edit"></i>
						&nbsp;&nbsp;Kode Akun
					</button>
					<div id="progres-main-kelbarang" style="width: 150px; float: right; display: none;">
						<div class="progress progress-striped active">
							<div class="progress-bar progress-bar-info" style="width: 100%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="20" role="progressbar">
								<span class="sr-only">20% Complete</span>
							</div>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<div class="table-responsive table-kelbarang">
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Form popup untuk tambah pelanggan -->
	<div class="modal fade" id="form-kelbarang" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        			<h4 class="modal-title" id="myModalLabel">Form Kelompok Barang</h4>
				</div>
				<div class="modal-body">
					Kode Kelompok Barang :
					<div class="form-group input-group">
						<span class="input-group-addon">
							<i class="fa fa-file"></i>
						</span>
						<input type="text" style="display: none;" name="mode_kelbarang" id="mode_kelbarang">
						<input type="text" placeholder="Kode Kelompok Barang" name="kode_kelbarang" id="kode_kelbarang" class="form-control">
					</div>
					Nama Kelompok Barang :
					<div class="form-group input-group">
						<span class="input-group-addon">
							<i class="fa fa-file"></i>
						</span>
						<input type="text" placeholder="Nama Kelompok Barang" name="nama_kelbarang" id="nama_kelbarang" class="form-control">
					</div>
					Margin Harga 1 (%):
					<div class="form-group input-group">
						<span class="input-group-addon">
							<i class="fa fa-file"></i>
						</span>
						<input type="text" placeholder="Margin Harga 1" name="kelbarang_margin1" id="kelbarang_margin1" class="form-control">
					</div>
					Margin Harga 2 (%):
					<div class="form-group input-group">
						<span class="input-group-addon">
							<i class="fa fa-file"></i>
						</span>
						<input type="text" placeholder="Margin Harga 2" name="kelbarang_margin2" id="kelbarang_margin2" class="form-control">
					</div>
					Kode Akun :
					<div class="form-group input-group">
						<span class="input-group-addon">
							<i class="fa fa-file"></i>
						</span>
						<input type="text" placeholder="Kode Akun" name="kelbarang_akun" id="kelbarang_akun" class="form-control">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" onclick="clearForm()" class="btn btn-default">Reset</button>
					<button type="button" class="btn btn-default" onclick="clearForm()" data-dismiss="modal">Close</button>
					<img src="<?= base_url() ?>/images/loader.gif" id="loader-form"  style="width: 30px; display: none;" />
			        <button type="button" id="btn-simpan" onclick="simpankelbarang()" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;&nbsp;Simpan</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="form-akunkelbarang" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        			<h4 class="modal-title" id="myModalLabel">Form Kode Akun Kelompok Barang</h4>
				</div>
				<div class="modal-body">
					Kode Kelompok Barang :
					<div class="form-group input-group">
						<span class="input-group-addon">
							<i class="fa fa-file"></i>
						</span>
						<input type="text" readonly name="akun_kodekel" id="akun_kodekel" class="form-control">
					</div>
					Nama Kelompok Barang :
					<div class="form-group input-group">
						<span class="input-group-addon">
							<i class="fa fa-file"></i>
						</span>
						<input type="text" readonly name="akun_namakel" id="akun_namakel" class="form-control">
					</div>
					Toko :
					<div class="form-group input-group">
						<span class="input-group-addon">
							<i class="fa fa-file"></i>
						</span>
						<select class="form-control" id="akun_toko" name="akun_toko">
							
						</select>
					</div>
					Kode Akun :
					<div class="form-group input-group">
						<span class="input-group-addon">
							<i class="fa fa-file"></i>
						</span>
						<input type="text" name="akun_kodeakun" id="akun_kodeakun" class="form-control">
					</div>
					<button type="button" id="btn-simpan" onclick="simpanakunkelbarang()" class="btn btn-primary btn-sm"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;&nbsp;Simpan</button>
					<table id="table_dataakun" class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th>Toko</th>
								<th>Kode Akun</th>
							</tr>
						</thead>
						<tbody>
							
						</tbody>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" onclick="clearForm()" data-dismiss="modal">Close</button>
					<img src="<?= base_url() ?>/images/loader.gif" id="loader-form"  style="width: 30px; display: none;" />
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		OpenMenu();
		
		LoadDataKelompokBarang();
		loadListToko();

		$('.ask-kelbarang').jConfirmAction();
	});
	
	function LoadDataKelompokBarang(){
		$('#progres-main-kelbarang').show();
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/kategoribarang/getdatakelbarang",
			data: "",
			success: function(msg){
				$(".table-kelbarang").html(msg);
				table_kelbarang = $('#dataTables-kelbarang').dataTable();
				$('#progres-main-kelbarang').hide();
				
				$('#dataTables-kelbarang tbody').on( 'click', 'tr', function () {
			        if ( $(this).hasClass('active') ) {
			            $(this).removeClass('active');
			        }else {
			            table_kelbarang.$('tr.active').removeClass('active');
			            $(this).addClass('active');
			        }
			    } );
			}
		});
	}
	
	function openFormTambahKelompokBarang(){
		$("#form-kelbarang").modal("show");
		$("#kode_kelbarang").prop("readonly", false);
		$("#mode_kelbarang").val("i");
	}
	
	function simpankelbarang(){
		$('#loader-form').show();
		$('#btn-simpan').hide();
		
		var kelbarang_kode = $("#kode_kelbarang").val();
		var kelbarang_nama = $("#nama_kelbarang").val();
		var kelbarang_margin1 = $("#kelbarang_margin1").val();
		var kelbarang_margin2 = $("#kelbarang_margin2").val();
		var kelbarang_akun = $("#kelbarang_akun").val();
		var mode = $("#mode_kelbarang").val();
		$.ajax({
			type: "POST",
			url: "<?= base_url(); ?>index.php/kategoribarang/simpankelbarang",
			data: "kode="+kelbarang_kode+"&nama="+kelbarang_nama+"&margin1="+kelbarang_margin1+"&margin2="+kelbarang_margin2+"&mode="+mode+"&kode_akun="+kelbarang_akun,
			success: function(msg){
				if(msg == "-1"){
					alert("kode kelompok barang sudah ada dalam data");
					$('#loader-form').hide();
					$('#btn-simpan').show();
				}else{
					clearForm();
					$('#loader-form').hide();
					$('#btn-simpan').show();
					LoadDataKelompokBarang();
					
					$("#form-kelbarang").modal("hide");
				}
			},
			error: function(xhr,status,error){
				alert(status);
				$('#loader-form').show();
				$('#btn-simpan').hide();
			}
		});
	}
	
	function HapusKelompokBarang(){
		var data = table_kelbarang.$('tr.active').attr("data");
		if(typeof data == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var dataArr = json_decode(base64_decode(data));
			
			$.ajax({
				type: "POST",
				url: "<?= base_url() ?>index.php/kategoribarang/hapuskelbarang",
				data: "kode="+dataArr['kode'],
				success: function(msg){
					if(msg == "1"){
						alert("data berhasil dihapus");
						LoadDataKelompokBarang();
					}else if(msg == "-1"){
						alert("data gagal dihapus karena kategori masih digunakan");
					}else{
						alert(msg);
					}
				}
			});
		}
	}
	
	function openFormEditKelompokBarang(){
		var data = table_kelbarang.$('tr.active').attr("data");
		if(typeof data == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			$("#mode_kelbarang").val("e");
			var dataArr = json_decode(base64_decode(data));
			
			$("#kode_kelbarang").val(dataArr['kode']);
			$("#kode_kelbarang").prop("readonly", true);
			$("#nama_kelbarang").val(dataArr['nama']);
			$("#kelbarang_margin1").val(dataArr['margin_harga']);
			$("#kelbarang_margin2").val(dataArr['margin_harga2']);
			$("#kelbarang_akun").val(dataArr['kode_akun']);
			
			$("#form-kelbarang").modal("show");
		}
	}
	
	function clearForm(){
		$("#kode_kelbarang").val('');
		$("#nama_kelbarang").val('');
		$("#kelbarang_margin1").val('0');
		$("#kelbarang_margin2").val('0');
		$("#kode_kelbarang").prop("readonly", false);
	}

	function openFormKodeAkun(){
		var data = table_kelbarang.$('tr.active').attr("data");
		if(typeof data == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var dataArr = json_decode(base64_decode(data));
			$("#akun_kodekel").val(dataArr['kode']);
			$("#akun_namakel").val(dataArr['nama']);
			$("#akun_toko").val("VO0001");
			$("#akun_kodeakun").val("");
			
			loadKodeAkun(dataArr['kode']);
		}
	}

	function loadKodeAkun(kategori_kode){
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/kategoribarang/getdataakun",
			data: "kode="+kategori_kode,
			success: function(msg){
				$("#table_dataakun tbody").html(msg);
				$("#form-akunkelbarang").modal("show");
			}
		});
	}

	function loadListToko(){
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/toko/getListDataToko",
			data: "",
			success: function(msg){
				$("#akun_toko").html(msg);
			}
		});
	}

	function simpanakunkelbarang(){
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/kategoribarang/simpankodeakun",
			data: "kategori_barang_kode="+$("#akun_kodekel").val()+"&toko_kode="+$("#akun_toko").val()+"&kode_akun="+$("#akun_kodeakun").val(),
			success: function(msg){
				loadKodeAkun($("#akun_kodekel").val());
				$("#akun_toko").val("VO0001");
				$("#akun_kodeakun").val("");
			}
		});
	}
</script>