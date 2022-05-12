<div id="page-wrapper">
	<div class="row">
	    <div class="col-lg-12">
	        <h1 style="margin-top: 15px;" class="page-header">Data Penjualan</h1>
	    </div>
	    <!-- /.col-lg-12 -->
	</div>
	<div class="row">
		<div class="col-lg-12">
			<table style="float: right;">
				<tr>
					<td style="width: 200px;">
						<select class="form-control" style="width: 190px;" name="cari_toko_kode" id="cari_toko_kode">
							<option value="-1">Pilih Toko</option>
						</select>
					</td>
					<td style="width: 100px;">
						<select style="width: 90px;" class="form-control" name="mode_penjualan" id="mode_penjualan">
							<option selected value="Kredit">Kredit</option>
							<option value="Tunai">Tunai</option>
						</select>
					</td>
					<td style="width: 125px;">
						<input style="width: 115px;" type="text" name="tanggal" id="tanggal" value="<?= date("Y-m-d"); ?>" class="form-control" />
					</td>
					<td>
						<button id="btn_upload" onclick="LoadDataPenjualan()" class="btn btn-info" type="button">
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
			<div class="message">
				
            </div>
			<div class="panel panel-default">
				<div class="panel-heading">
					&nbsp;
                    <button id="btn_open" onclick="openFormEditPelanggan()" class="btn btn-info btn-sm" type="button">
						<i class="fa fa-plus"></i>
						&nbsp;&nbsp;Edit Pelanggan
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
					<div class="table-responsive table-penjualan">
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- form untuk edit pelanggan semen -->
	<div class="modal fade" id="form-edit-pelanggan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        			<h4 class="modal-title" id="myModalLabel">Form Edit Pelanggan</h4>
				</div>
				<div class="modal-body">
					Tanggal :
					<div class="form-group input-group">
						<span class="input-group-addon">
							<i class="fa fa-file"></i>
						</span>
						<input type="text" readonly name="penjualan_tanggal" id="penjualan_tanggal" class="form-control">
					</div>
					Kode Transaksi :
					<div class="form-group input-group">
						<span class="input-group-addon">
							<i class="fa fa-file"></i>
						</span>
						<input type="text" readonly name="penjualan_kode_transaksi" id="penjualan_kode_transaksi" class="form-control">
					</div>
					Pelanggan :
					<div class="form-group input-group">
						<span class="input-group-addon">
							<i class="fa fa-file"></i>
						</span>
						<input type="text" readonly name="penjualan_nama_pelanggan" id="penjualan_nama_pelanggan" class="form-control">
					</div>
					Total Harga :
					<div class="form-group input-group">
						<span class="input-group-addon">
							<i class="fa fa-money"></i>
						</span>
						<input type="text" readonly style="text-align: right;" name="penjualan_harga" id="penjualan_harga" class="form-control">
					</div>
					Pelanggan Ganti :
					<div class="form-group input-group">
						<span class="input-group-addon">
							<i class="fa fa-user"></i>
						</span>
						<input type="text" class="form-control" style="width: 250px;" name="penjualan_pelanggan_ganti" id="penjualan_pelanggan_ganti" />
						<input type="hidden" name="penjualan_nama_pelanggan_ganti" id="penjualan_nama_pelanggan_ganti" />
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" onclick="clearForm()" class="btn btn-default">Reset</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<img src="<?= base_url() ?>/images/loader.gif" id="loader-form"  style="width: 30px; display: none;" />
			        <button type="button" id="btn-simpan" onclick="simpaneditpelanggan()" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;&nbsp;Simpan</button>
				</div>
			</div>
		</div>
	</div>
	<!-- end form -->
</div>
<script>
	$(document).ready(function(){
		OpenMenu();
		
		$('#tanggal').datepicker({
			format: 'yyyy-mm-dd'
		});
		
		$('.datepicker tbody').on('click', function(){  $('.datepicker').hide() });
		
		LoadDataPenjualan();
		loadListPelanggan();
		loadListToko();
	});
	
	function loadListToko(){
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/toko/getListToko",
			data: "",
			success: function(msg){
				$("#cari_toko_kode").html(msg);
			}
		});
	}
	
	function LoadDataPenjualan(){
		$('#progres-main').show();
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/penjualan/getdatapenjualan",
			data: "tanggal="+$('#tanggal').val()+"&mode="+$("#mode_penjualan").val()+"&toko_kode="+$("#cari_toko_kode").val(),
			success: function(msg){
				$(".table-penjualan").html(msg);
				//table = $('#dataTables-pembelian-barang').dataTable();
				$('#progres-main').hide();
				
				$('#dataTables-penjualan tbody').on( 'click', 'tr', function () {
			        if ( $(this).hasClass('active') ) {
			            $(this).removeClass('active');
			        }else {
			            $('#dataTables-penjualan tr.active').removeClass('active');
			            $(this).addClass('active');
			        }
			    } );
			}
		});
	}
	
	function openFormEditPelanggan(){
		var data_obj = $('#dataTables-penjualan tr.active').attr("data");
		
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			$('#form-edit-pelanggan').modal('show');
			
			$("#penjualan_tanggal").val(data['fdate']);
			$("#penjualan_kode_transaksi").val(data['fcode']);
			$("#penjualan_nama_pelanggan").val(data['fcustname']);
			$("#penjualan_harga").val(data['fbill_amount']);
			price('penjualan_harga');
		}
	}
	
	function loadListPelanggan(){
		$("#penjualan_pelanggan_ganti").select2({
		    placeholder: "Cari Pelanggan",
		    minimumInputLength: 1,
		    ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
			    url: "<?php echo base_url(); ?>index.php/pelanggan/getlistpelanggan",
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
            	return "<span class=\"select2-match\"></span>"+option.nama_pelanggan;
            }, 
		    formatSelection: function (option) {
            	return option.nama_pelanggan;
            }
	    });
		
		$("#penjualan_pelanggan_ganti").on("select2-selecting", function(e) {
			$("#penjualan_nama_pelanggan_ganti").val(e.choice.nama_pelanggan);
	    });
	}
	
	function simpaneditpelanggan(){
		var fcode = $("#penjualan_kode_transaksi").val();
		var fcustname = $("#penjualan_nama_pelanggan_ganti").val();
		var fcustkey = $("#penjualan_pelanggan_ganti").val();
		
		$.ajax({
			type: "post",
			url: "<?= base_url() ?>index.php/penjualan/simpaneditpelanggan",
			data: "fcode="+fcode+"&fcustkey="+fcustkey+"&fcustname="+fcustname,
			success: function(msg){
				alert("Data berhasil disimpan");
				
				$('#form-edit-pelanggan').modal('hide');
				LoadDataPenjualan();
			}
		});
	}
</script>