<div id="page-wrapper">
	<div class="row">
	    <div class="col-lg-12">
	        <h1 style="margin-top: 15px;" class="page-header">Master Kategori Barang</h1>
	    </div>
	    <div id="progres-main" style="width: 450px; float: left; display: none;">
			<div class="progress progress-striped active">
				<div class="progress-bar progress-bar-info" style="width: 100%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="20" role="progressbar">
					<span class="sr-only">20% Complete</span>
				</div>
			</div>
		</div>
	    <!-- /.col-lg-12 -->
	</div>
	<div class="row">
		<div class="col-lg-6">
			<table width="100%">
				<tr>
					<td>
						<div class="form-group input-group">
							<span class="input-group-addon">
								<i class="fa fa-file"></i>
							</span>
							<input type="text" placeholder="Nama kategori" name="nama_kategori" id="nama_kategori" class="form-control">
							<input type="text" style="text-align: right;" placeholder="Margin Harga Jual (%)" name="margin" id="margin" class="form-control">
							<input type="hidden" name="kode_kategori" id="kode_kategori" class="form-control">
							<input type="hidden" value="i" name="mode_form" id="mode_form" class="form-control">
						</div>
					</td>
					<td>&nbsp;</td>
					<td valign="top">
						<button id="btn_tambah" onclick="simpankategori()" class="btn btn-info btn-sm" type="button">
							<i class="fa fa-plus"></i>
							&nbsp;&nbsp;Simpan
						</button>
						<button style="display: none;" id="btn_cancel" onclick="canceledit()" class="btn btn-danger btn-sm" type="button">
							<i class="fa fa-times"></i>
							&nbsp;&nbsp;Cancel
						</button>
					</td>
					<td align="left" valign="top">
						<img style="width: 30px; display: none;" id="loader-tambah" src="<?php echo base_url(); ?>images/loader.gif" />
					</td>
				</tr>
			</table>
		</div>
	</div>	
	<div class="row">
		<div class="col-lg-6 list-drag">
			
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		OpenMenu();
		getList();
	});
	
	function InitializedList(){
		parentFirst = "null";
		var options = {
			placeholderCss: {'background-color': '#ff8'},
			hintCss: {'background-color':'#bbf'},
			opener: {
				 active: true,
				 close: '/vmart/images/Remove2.png',
				 open: '/vmart/images/Add2.png',
				 openerCss: {
					 'display': 'inline-block',
					 'width': '18px',
					 'height': '18px',
					 'float': 'left',
					 'margin-left': '-35px',
					 'margin-right': '5px',
					 'background-position': 'center center',
					 'background-repeat': 'no-repeat'
				 },
				 openerClass: ''
			},
			ignoreClass: 'clickable',
			onDragStart: function(e, el){
				parentFirst = el.parents('li').data('module');
			},
			complete: function(currEl){
				var current = currEl.data('module');
				var parent = currEl.parents('li').data('module');
				
				if(parentFirst != parent){
					setParent(current, parent);
				}
			}
		};
	
		$('#sTree2, #sTree').sortableLists(options);
	}
	
	function getList(){
		$('#loader-tambah').show();
		$.ajax({
			type: "POST",
			url: "<?= base_url(); ?>index.php/kategoribarang/getlistkategori",
			data: "",
			success: function(msg){
				$(".list-drag").html(msg);
				InitializedList();
				$('#loader-tambah').hide();
			}
		});
	}
	
	function simpankategori(){
		$('#loader-tambah').show();
		$.ajax({
			type: "POST",
			url: "<?= base_url(); ?>index.php/kategoribarang/simpankategori",
			data: "nama="+$("#nama_kategori").val()+"&margin_harga="+$("#margin").val()+"&mode="+$("#mode_form").val()+"&kode="+$("#kode_kategori").val(),
			success: function(msg){
				$("#nama_kategori").val("");
				$("#margin").val("0");
				$("#mode_form").val("i");
				$("#btn_cancel").hide();
				getList();
			}
		});
	}
	
	function setParent(current, parent){
		$('#loader-tambah').show();
		$.ajax({
			type: "POST",
			url: "<?= base_url(); ?>index.php/kategoribarang/setparent",
			data: "kode="+current+"&parent="+parent,
			success: function(msg){
				$('#loader-tambah').hide();
			}
		});
	}
	
	function HapusKategori(kode){
		var conf = confirm("Apakah Anda ingin menghapus kategori ini?");
		if(conf){
			$('#loader-tambah').show();
			$.ajax({
				type: "POST",
				url: "<?= base_url(); ?>index.php/kategoribarang/hapuskategori",
				data: "kode="+kode,
				success: function(msg){
					getList();
				}
			});
		}
	}
	
	function canceledit(){
		$("#btn_cancel").hide();
		$("#mode_form").val("i");
		$("#nama_kategori").val("");
		$("#margin").val("0");
	}
	
	function EditKategori(kode, nama, margin_harga){
		$("#btn_cancel").show();
		$("#kode_kategori").val(kode);
		$("#mode_form").val("e");
		$("#nama_kategori").val(nama);
		$("#margin").val(margin_harga);
	}
</script>