<div id="page-wrapper">
	<div class="row">
	    <div class="col-lg-12">
	        <h1 class="page-header">Data Pengguna</h1>
	    </div>
	    <!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-8">
			<div class="panel panel-default">
				<div class="panel-heading">
					<strong>Pengguna</strong>
					<button type="button" class="btn btn-success btn-circle" onclick="showformuser('i', '')" style="float: right; margin-top: -5px;"><i class="fa fa-plus"></i></button>
				</div>
				<div class="panel-body">
					<div id="data-user"></div>
				</div>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<strong>Group Pengguna</strong>
					<!-- <button type="button" class="btn btn-success btn-circle" onclick="showformgroup('i', '')" style="float: right; margin-top: -5px;"><i class="fa fa-plus"></i></button> -->
				</div>
				<div class="panel-body">
					<div id="data-group"></div>
				</div>
			</div>
		</div>
	</div>
	
	<!-- modal untuk form user -->
	<div class="modal fade" id="form-user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        			<h4 class="modal-title" id="myModalLabel">Form Pengguna</h4>
				</div>
				<div class="modal-body">
					<table width="100%">
						<tr>
							<td valign="top">
								<div class="form-group">
									<label>Nama Lengkap</label>
									<input type="text" name="ins_nama" id="ins_nama" class="form-control">
								</div>
								<div class="form-group">
									<label>Username</label>
									<input type="hidden" name="ins_mode" id="ins_mode" value="i" />
									<input type="text" name="ins_username" id="ins_username" class="form-control">
								</div>
								<div class="form-group">
									<label>Password</label>
									<input type="password" name="ins_password" id="ins_password" class="form-control">
								</div>
							</td>
							<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
							<td valign="top">
								<div class="form-group">
									<label>No Kasir</label>
									<input type="text" name="ins_no_kasir" id="ins_no_kasir" class="form-control">
								</div>
								<div class="form-group">
									<label>Group</label>
									<select class="form-control" name="ins_k_group" id="ins_k_group"></select>
								</div>
								<div class="form-group">
									<label>Toko / Unit</label>
									<select class="form-control" name="ins_k_toko" id="ins_k_toko"></select>
								</div>
								<div style="display: none;"  id="progress-form-user" class="progress progress-striped active">
									<div id="obj_progressbar" class="progress-bar progress-bar-info" role="progressbar" style="width: 100%">
									</div>
								</div>
							</td>
						</tr>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			        <button type="button" onclick="simpanuser()" class="btn btn-primary">Simpan</button>
				</div>
			</div>
		</div>
	</div>
	<!-- modal untuk form group -->
	<div class="modal fade" id="form-group" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        			<h4 class="modal-title" id="myModalLabel">Form Group</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>Kode Group</label>
						<input type="hidden" name="insgroup_mode" id="insgroup_mode" value="i" />
						<input type="text" name="insgroup_k_group" id="insgroup_k_group" class="form-control">
					</div>
					<div class="form-group">
						<label>Nama Group</label>
						<input type="text" name="insgroup_nama_group" id="insgroup_nama_group" class="form-control">
					</div>
					<div class="form-group">
						<label>Keterangan</label>
						<input type="text" name="insgroup_keterangan" id="insgroup_keterangan" class="form-control">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			        <button type="button" onclick="simpangroup()" class="btn btn-primary">Simpan</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /#page-wrapper -->
<script>
	$(document).ready(function(){
		getdatauser();
		getdatagroup('select');
		getdatagroup('table');
		
		OpenMenu();
		loadListToko();
	});
	
	function getdatauser(){
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>index.php/user/getdatauser",
			success: function(msg){
				$('#data-user').html(msg);
				
				$('#dataTables-user').dataTable();
			}
		});
	}
	
	function loadListToko(){
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/toko/getListToko",
			data: "",
			success: function(msg){
				$("#ins_k_toko").html(msg);
			}
		});
	}
	
	function getdatagroup(mode){
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>index.php/user/getdatagroup",
			data: "mode="+mode,
			success: function(msg){
				if(mode == 'select'){
					$('#ins_k_group').html(msg);
				}else{
					$('#data-group').html(msg);
					//$('#dataTables-group').dataTable();
				}
			}
		});
	}
	
	function showformuser(mode, content){
		clearformuser();
		$('#form-user').modal('show');
		$('#ins_mode').val(mode);
		if(mode == 'u'){
			var data = json_decode(base64_decode(content));
			
			$('#ins_nama').val(data['nama']);
			$('#ins_username').val(data['username']);
			$('#ins_username').attr('disabled', true);
			$('#ins_password').val(data['password']);
			$('#ins_k_toko').val(data['toko_kode']);
			$('#ins_no_kasir').val(data['no_kasir']);
			//$('#ins_password').attr('disabled', true);
			$('#ins_k_group').val(data['group_kode']);
		}
	}
	
	function showformgroup(mode, content){
		clearformgroup();
		$('#form-group').modal('show');
		$('#insgroup_mode').val(mode);
		if(mode == 'u'){
			var data = json_decode(base64_decode(content));
			
			$('#insgroup_k_group').val(data['kode']);
			$('#insgroup_k_group').attr('disabled', true);
			$('#insgroup_nama_group').val(data['nama']);
		}
	}
	
	function simpanuser(){
		$('#progress-form-user').show();
		$.ajax({
			type: 'POST',
			url: '<?php echo base_url(); ?>index.php/user/simpanuser',
			data: 'mode='+$('#ins_mode').val()+'&username='+$('#ins_username').val()+'&password='+$('#ins_password').val()+'&group_kode='+$('#ins_k_group').val()+'&nama='+$('#ins_nama').val()+'&toko_kode='+$('#ins_k_toko').val()+'&no_kasir='+$('#ins_no_kasir').val(),
			success: function(msg){
				if(msg == "-1"){
					alert("username sudah ada dalam data");
					$('#progress-form-user').hide();
				}else{
					$('#progress-form-user').hide();
					$('#form-user').modal('hide');
					
					getdatauser();
				}
			}
		});
	}
	
	function simpangroup(){
		$('#progress-form-group').show();
		$.ajax({
			type: 'POST',
			url: '<?php echo base_url(); ?>index.php/user/simpangroup',
			data: 'mode='+$('#insgroup_mode').val()+'&kode='+$('#insgroup_k_group').val()+'&nama='+$('#insgroup_nama_group').val()+'&keterangan='+$('#insgroup_keterangan').val(),
			success: function(msg){
				if(msg == "-1"){
					alert("kode group sudah ada dalam data");
					$('#progress-form-group').hide();
				}else{
					$('#progress-form-group').hide();
					$('#form-group').modal('hide');
					
					getdatagroup('table');
					getdatagroup('select');
				}
			}
		});
	}
	
	function proseshapususer(username, group_kode){
		$.ajax({
			type: 'POST',
			url: '<?php echo base_url(); ?>index.php/user/hapususer',
			data: 'username='+username+'&group_kode='+group_kode,
			success: function(msg){
				getdatauser();
			}
		});
	}
	
	function proseshapusgroup(k_group){
		$.ajax({
			type: 'POST',
			url: '<?php echo base_url(); ?>index.php/user/hapusgroup',
			data: 'kode='+k_group,
			success: function(msg){
				getdatagroup('table');
				getdatagroup('select');
			}
		});
	}
	
	function hapususer(username, group_kode){
		var konfirm = confirm('hapus data ini?');
		
		if(konfirm){
			proseshapususer(username, group_kode);
		}
	}
	
	function hapusgroup(k_group){
		var konfirm = confirm('hapus data ini?');
		
		if(konfirm){
			proseshapusgroup(k_group);
		}
	}
	
	function clearformuser(){
		$('#ins_username').val('');
		$('#ins_password').val('');
		
		$('#ins_username').removeAttr('disabled');
		$('#ins_password').removeAttr('disabled');
	}
	
	function clearformgroup(){
		$('#insgroup_k_group').val('');
		$('#insgroup_nama_group').val('');
		
		$('#insgroup_k_group').removeAttr('disabled');
	}
</script>