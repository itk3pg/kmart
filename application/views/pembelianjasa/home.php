<style>
	.datepicker{z-index:1151 !important;}
</style>
<div id="page-wrapper">
	<div class="row">
	    <div class="col-lg-12">
	        <h1 style="margin-top: 15px;" class="page-header">Data Pembelian Jasa</h1>
	    </div>
	    <!-- /.col-lg-12 -->
	</div>
	<div class="row">
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
						<button id="btn_upload" onclick="LoadDataPembelianJasa()" class="btn btn-info" type="button">
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
                    <button id="btn_open" onclick="openFormPembelianJasa(1)" class="btn btn-info btn-sm" type="button">
						<i class="fa fa-plus"></i>
						&nbsp;&nbsp;Tambah
					</button>
					<button id="btn_uedit" onclick="openFormEditPembelian()" class="btn btn-success btn-sm" type="button">
						<i class="fa fa-edit"></i>
						&nbsp;&nbsp;Edit
					</button>
					<button id="btn_upload" fungsi="HapusPembelianJasa()" class="btn btn-danger btn-sm ask" type="button">
						<i class="fa fa-times"></i>
						&nbsp;&nbsp;Hapus
					</button>
					<button id="btn_cetak" onclick="cetakNotaPembelian()" class="btn btn-success btn-sm" type="button">
						<i class="fa fa-print"></i>
						&nbsp;&nbsp;Cetak Nota
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
					<div class="table-responsive table-pembelian-jasa">
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Popup form untuk pembelian jasa -->
	<div class="modal fade" id="form-pembelian-jasa" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        			<h4 class="modal-title" id="myModalLabel">Form Pembelian Jasa</h4>
				</div>
				<div class="modal-body">
					<table width="100%">
						<tr>
							<td valign="top" width="45%">
								Bukti Order :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<input type="text" placeholder="No bukti order event" name="pembelian_bukti_order" id="pembelian_bukti_order" class="form-control">
								</div>
								Tanggal Pembelian :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</span>
									<input type="hidden" name="pembelian_mode" id="pembelian_mode" value="i" />
									<input type="hidden" name="pembelian_bukti" id="pembelian_bukti" />
									<input type="text" value="<?= date("Y-m-d"); ?>" placeholder="Tanggal Pembelian" name="pembelian_tanggal" id="pembelian_tanggal" class="form-control">
								</div>
								<div class="form-group">
									<label class="radio-inline">
										<input onclick="changeModePembayaran()" id="pembelian_status_pembayaranT" type="radio" checked="" value="T" name="pembelian_status_pembayaran"> Tunai
									</label>
									<label class="radio-inline">
										<input onclick="changeModePembayaran()" id="pembelian_status_pembayaranK" type="radio" checked="checked" value="K" name="pembelian_status_pembayaran"> Kredit
									</label>
								</div>
							</td>
							<td width="1%">&nbsp;</td>
							<td valign="top" width="54%">
								Supplier :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-user"></i>
									</span>
									<select onchange="getbuktiumpembelian();" class="form-control" name="pembelian_supplier" id="pembelian_supplier">
										
									</select>
								</div>
							</td>
						</tr>
						<tr id="group_pembelian_jatuh_tempo">
							<td>
								Jatuh Tempo :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</span>
									<input type="text" placeholder="Tanggal Jatuh Tempo" name="pembelian_jatuh_tempo" id="pembelian_jatuh_tempo" class="form-control">
								</div>
							</td>
							<td>&nbsp;</td>
							<td>
								Uang Muka : 
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-money"></i>
									</span>
									<select class="form-control" onchange="pilihbuktium('pembelian_bukti_um', 'pembelian_uang_muka')" name="pembelian_bukti_um" id="pembelian_bukti_um">
										
									</select>
									<span class="input-group-addon">
										<i class="fa fa-money"></i>
									</span>
									<input type="text" disabled placeholder="Uang Muka" onkeyup="price('pembelian_uang_muka')" name="pembelian_uang_muka" id="pembelian_uang_muka" class="form-control">
								</div>
							</td>
						</tr>
					</table>
					
					<button style="margin-bottom:10px;" type="button" id="btn-tambah-jasa" onclick="openformtambahitem(1)" class="btn btn-primary">Tambah Item</button>
					<!-- Form tambah item -->
					<div id="form-tambah-jasa" style="display: none;" class="panel panel-default">
						<div class="panel-heading">
							Form Tambah Item
						</div>
						<div class="panel-body">
							<table width="70%">
								<tr>
									<td valign="top" width="40%">
										Barang :
										<div class="form-group input-group">
											<input type="text" class="form-control" style="width: 250px;" name="pembelian_jasa" id="pembelian_jasa" />
										</div>
										Harga Beli :
										<div class="form-group input-group">
											<span class="input-group-addon">
												<i class="fa fa-money"></i>
											</span>
											<input type="text" style="text-align: right;" onkeyup="price('pembelian_harga_beli'); hitungpembelianjumlah();" placeholder="Harga Beli" name="pembelian_harga_beli" id="pembelian_harga_beli" class="form-control">
										</div>
										Jumlah Barang :
										<div class="form-group input-group">
											<span class="input-group-addon">
												<i class="fa fa-shopping-cart"></i>
											</span>
											<input type="text" style="text-align: right;" onkeyup="hitungpembelianjumlah();" placeholder="kwt" name="pembelian_kwt" id="pembelian_kwt" class="form-control">
										</div>
									</td>
									<td>&nbsp;&nbsp;&nbsp;</td>
									<td valign="top">
										<input type="checkbox" name="pembelian_is_ppn" onchange="hitungpembelianjumlah()" id="pembelian_is_ppn" checked="checked" /> PPn Beli @item :
										<div class="form-group input-group">
											<span class="input-group-addon">
												<i class="fa fa-money"></i>
											</span>
											<input type="text" style="text-align: right;" disabled placeholder="PPn" name="pembelian_ppn_beli" id="pembelian_ppn_beli" class="form-control">
										</div>
										PPh Beli @item :
										<div class="form-group input-group">
											<span class="input-group-addon">
												<i class="fa fa-money"></i>
											</span>
											<input type="text" onkeyup="hitungpphbeli()" style="text-align: right; width: 80px;" placeholder="PPh %" name="pembelian_pph_persen" id="pembelian_pph_persen" class="form-control">
											<input type="text" style="text-align: right;" disabled placeholder="PPh" name="pembelian_pph_beli" id="pembelian_pph_beli" class="form-control">
										</div>
										Total Harga Beli :
										<div class="form-group input-group">
											<span class="input-group-addon">
												<i class="fa fa-money"></i>
											</span>
											<input type="text" style="text-align: right;" disabled placeholder="Total Harga" name="pembelian_jumlah" id="pembelian_jumlah" class="form-control">
										</div>
									</td>
								</tr>
							</table>
							<button style="float: right;" type="button" onclick="clearForm(4)" class="btn btn-default">Reset</button>
							<button style="float: right; margin-right: 5px;" type="button" onclick="openformtambahitem(0)" class="btn btn-default">Cancel</button>
							<button style="float: right; margin-right: 5px;" type="button" onclick="tambahitem()" class="btn btn-primary">Tambahkan</button>
						</div>
					</div>
					<!-- End form tambah item -->
					<table id="table-dummy-pembelian" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th class="text-center">KD Item</th>
								<th class="text-center">NM Item</th>
								<th class="text-center">KWT</th>
								<th class="text-center">Harga</th>
								<th class="text-center">PPn @Item</th>
								<th class="text-center">PPh @Item</th>
								<th class="text-center">Total Harga</th>
								<th class="text-center">Hapus</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" onclick="clearForm(2)" class="btn btn-default">Reset</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<img src="<?= base_url() ?>/images/loader.gif" id="loader-form"  style="width: 30px; display: none;" />
			        <button type="button" id="btn-simpan" onclick="simpanpembelian()" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;&nbsp;Simpan</button>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		OpenMenu();
		
		LoadDataPembelianJasa();
		LoadListDataJasa();
		loadListSupplier();
		
		$('#pembelian_jatuh_tempo').datepicker({
			format: 'yyyy-mm-dd'
		});
		$('#pembelian_tanggal').datepicker({
			format: 'yyyy-mm-dd'
		});
		
		$('.ask').jConfirmAction();
		
		$('.datepicker tbody').on('click', function(){  $('.datepicker').hide() });
	});
	
	function changeModePembayaran(){
		var mode = $("input[name=pembelian_status_pembayaran]:checked").val();
		
		if(mode == "K"){
			$("#pembelian_jatuh_tempo").val("");
			$("#group_pembelian_jatuh_tempo").show();
		}else{
			$("#pembelian_jatuh_tempo").val("");
			$("#group_pembelian_jatuh_tempo").hide();
		}
	}
	
	function loadListSupplier(){
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/supplier/getselectsupplier",
			data: "",
			success: function(msg){
				$("#pembelian_supplier").html(msg);
				$("#pembelian_supplier").select2();
				
				getbuktiumpembelian();
			}
		});
	}
	
	function LoadListDataJasa(){
	    $("#pembelian_jasa").select2({
		    placeholder: "Cari jasa",
		    minimumInputLength: 1,
		    ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
			    url: "<?php echo base_url(); ?>index.php/jasa/getlistjasa",
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
            	return "<span class=\"select2-match\"></span>"+option.nama_jasa;
            }, 
		    formatSelection: function (option) {
            	return option.nama_jasa;
            }
	    });
	    
	    /*$("#pembelian_jasa").on("select2-selecting", function(e) {
	    	// dataperlang = e;
	    	// alert ("selecting val="+ e.choice.satuan_terkecil +" choice="+ JSON.stringify(e.choice));
			$("#satuan_besar").val(e.choice.nama_satuan);
			$("#satuan_kecil").val(e.choice.nama_satuan_terkecil);
			$("#nilai_konversi").val(e.choice.nilai_konversi);
	    });*/
	}
	
	function LoadDataPembelianJasa(){
		$('#progres-main').show();
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/pembelianjasa/getdatapembelianjasa",
			data: "tahun="+$('#tahun').val()+"&bulan="+$('#bulan').val(),
			success: function(msg){
				$(".table-pembelian-jasa").html(msg);
				//table = $('#dataTables-pembelian-jasa').dataTable();
				$('#progres-main').hide();
				
				$('#dataTables-pembelian-jasa tbody').on( 'click', 'tr', function () {
			        if ( $(this).hasClass('active') ) {
			            $(this).removeClass('active');
			        }else {
			            $('#dataTables-pembelian-jasa tr.active').removeClass('active');
			            $(this).addClass('active');
			        }
			    } );
			}
		});
	}
	
	function openFormPembelianJasa(mode){
		if(mode == 1){ // untuk tambah
			$("#form-pembelian-jasa").modal("show");
			$("#pembelian_mode").val("i");
		}
	}
	
	function openformtambahitem(isopen){
		if(isopen == 1){ // open form
			$("#form-tambah-jasa").show();
			$("#btn-tambah-jasa").hide();
		}else{ // close form
			$("#form-tambah-jasa").hide();
			$("#btn-tambah-jasa").show();
		}
	}
	
	function getbuktiumpembelian(){
		var kode_subject = $("#pembelian_supplier").val().split("-");
		$.ajax({
			type: "POST",
			url: "<?= base_url(); ?>index.php/pembelianjasa/getbuktiuangmuka",
			data: "mode=pembelian&kode_subject="+kode_subject[0]+"&pengadaan_mode=1",
			success: function(msg){
				$("#pembelian_bukti_um").html(msg);
				$("#pembelian_bukti_um").select2();
			}
		});
	}
	
	function hitungpembelianjumlah(){
		var harga = removeCurrency($("#pembelian_harga_beli").val());
		var kwt = $("#pembelian_kwt").val();
		
		if(harga == "") harga = 0;
		if(kwt == "") kwt = 0;
		
		var ppn = 0;
		var pph = 0;
		
		if($('#pembelian_is_ppn').is(':checked')){
			ppn = parseFloat(harga) * 0.11; //k3pg-ppn
		}else{
			ppn = 0;
		}
		
		var totalHarga = (parseFloat(harga) + ppn) * parseFloat(kwt);
		
		$("#pembelian_ppn_beli").val(ppn);
		$("#pembelian_jumlah").val(totalHarga);
		
		price_js('pembelian_ppn_beli');
		price_js('pembelian_jumlah');
	}
	
	function tambahitem(){
		var kd_item = $("#pembelian_jasa").val();
		var nama_item = $("#s2id_pembelian_jasa .select2-chosen").html();
		
		var harga_beli = $("#pembelian_harga_beli").val();
		var kwt = $("#pembelian_kwt").val();
		var ppn_beli = $("#pembelian_ppn_beli").val();
		var pph_beli = $("#pembelian_pph_beli").val();
		var jumlah = $("#pembelian_jumlah").val();
		
		var row = "<tr><td>"+kd_item+"</td><td>"+nama_item+"</td><td class=\"text-right\">"+kwt+"</td><td class=\"text-right\">"+harga_beli+"</td><td class=\"text-right\">"+ppn_beli+"</td><td class=\"text-right\">"+pph_beli+"</td><td class=\"text-right\">"+jumlah+"</td><td><button type=\"button\" onclick=\"HapusRow(this)\" class=\"btn btn-default\"><i class=\"fa fa-times\"></i></button></td></tr>";
		
		$('#table-dummy-pembelian > tbody:last').append(row);
		
		clearForm(4);
		openformtambahitem(0);
	}
	
	function simpanpembelian(){
		$('#btn-simpan').hide();
		$('#loader-form').show();
		
		var dataArr = [];
	    $("#table-dummy-pembelian td").each(function(){
	        dataArr.push($(this).html());
	    });
	    
		var pembelian_mode = $("#pembelian_mode").val();
		
		if(pembelian_mode == "i"){
			var modeBukti = "JI";
			
			var tanggal_pembelian = $("#pembelian_tanggal").val();
			$.ajax({
				type: "POST",
				url: "<?= base_url() ?>index.php/bukti/generatebukti",
				data: "mode="+modeBukti+"&tanggal="+tanggal_pembelian,
				success: function(msg){
					var jsonData = rawurlencode(json_encode(dataArr));
					SimpanDetailPembelian(msg, jsonData);
				}
			});
		}else{
			var bukti = $("#pembelian_bukti").val();
			$.ajax({
				type: "POST",
				url: "<?= base_url(); ?>index.php/pembelianjasa/hapuspembelianjasa",
				data: "bukti="+bukti,
				success: function(msg){
					var jsonData = rawurlencode(json_encode(dataArr));
					SimpanDetailPembelian(bukti, jsonData);
				}
			});
		}
	}
	
	function SimpanDetailPembelian(bukti, jsondata){
		var supplier = $("#pembelian_supplier").val().split("-");
		var supplier_kode = supplier[0];
		var status_pembayaran = $("input[name=pembelian_status_pembayaran]:checked").val();
		var jatuh_tempo = $("#pembelian_jatuh_tempo").val();
		var tanggal_pembelian = $("#pembelian_tanggal").val();
		var pembelian_mode = $("#pembelian_mode").val();
		var ref_order = $("#pembelian_bukti_order").val();
		
		var uang_muka = removeCurrency($("#pembelian_uang_muka").val());
		var bukti_um = $("#pembelian_bukti_um").val().split("-");
		
		$.ajax({
			type: "POST",
			url: "<?= base_url(); ?>index.php/pembelianjasa/simpanpembelianjasa",
			data: "data="+jsondata+"&bukti="+bukti+"&supplier_kode="+supplier_kode+"&status_pembayaran="+status_pembayaran+"&jatuh_tempo="+jatuh_tempo+"&tanggal="+tanggal_pembelian+"&pembelian_mode="+pembelian_mode+"&uang_muka="+uang_muka+"&bukti_um="+bukti_um[0]+"&ref_order="+ref_order,
			success: function(msg){
				$('#btn-simpan').show();
				$('#loader-form').hide();
				clearForm(2);
				$('#form-pembelian-jasa').modal('hide');
				
				ShowMessage('success', 'Data berhasil disimpan');
				LoadDataPembelianJasa();
			},
			error: function(xhr,status,error){
				alert(status);
				$('#btn-simpan').show();
				$('#loader-form').hide();
			}
		});
	}
	
	function pilihbuktium(select2_id, container_id){
		var jumlah_um = $("#"+select2_id).val().split("-");
		var um = jumlah_um[1];
		if(um == "1" || um == ""){
			um = 0;
		}
		$("#"+container_id).val(um);
		price_js(container_id);
	}
	
	function HapusPembelianJasa(){
		var data_obj = $('#dataTables-pembelian-jasa tr.active').attr("data");
		
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			$('#progres-main').show();
			$.ajax({
				type: "POST",
				url: "<?= base_url(); ?>index.php/pembelianjasa/hapuspembelianjasa",
				data: "bukti="+data['bukti'],
				success: function(msg){
					ShowMessage("success", "Data berhasil dihapus");
					LoadDataPembelianJasa();
				}
			});
		}
	}
	
	function cetakNotaPembelian(){
		var data_obj = $('#dataTables-pembelian-jasa tr.active').attr("data");
		
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			var bukti = data['bukti'];
			window.open('<?= base_url('index.php/cetak/buktipenerimaan?') ?>mode=1&bukti_pengadaan='+bukti,'_blank');
		}
	}
	
	function HapusRow(DataObj){
		dataobj = DataObj;
		$(DataObj).parent().parent().remove();
	}
	
	function hitungpphbeli(){
		var harga_beli = removeCurrency($("#pembelian_harga_beli").val());
		var persen_pph = $("#pembelian_pph_persen").val();
		
		var pph = harga_beli * (persen_pph / 100);
		$("#pembelian_harga_beli").val(pph);
		price_js("pembelian_harga_beli");
	}
	
	function openFormEditPembelian(){
		var data_obj = $('#dataTables-pembelian-jasa tr.active').attr("data");
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			
			$("#pembelian_mode").val("e");
			$("#pembelian_bukti").val(data['bukti']);
			$("#pembelian_bukti_order").val(data['ref_order']);
			$("#pembelian_tanggal").val(data['tanggal']);
			$("#pembelian_supplier").select2("val", data['supplier_kode']);
			
			$.ajax({
				type: "POST",
				url: "<?= base_url() ?>index.php/pembelianjasa/getdatajasaji",
				data: "bukti="+data['bukti'],
				success: function(msg){
					$("#table-dummy-pembelian tbody").html(msg);
				}
			});
			
			$("#form-pembelian-jasa").modal("show");
		}
	}
	
	function clearForm(mode){
		switch (mode){
			case 2: // Form input pengadaan
				$("#pembelian_supplier").select2("val", "-1");
				$("#pembelian_jasa").select2("val", "");
				$("#pembelian_harga").val("");
				$("#pembelian_kwt").val("");
				$("#pembelian_ppn_beli").val("");
				$("#pembelian_pph_beli").val("");
				$("#pembelian_pph_persen").val("");
				$("#pembelian_jumlah").val("");
				$("#pembelian_jatuh_tempo").val("");
				$("#pembelian_uang_muka").val("");
				$("#pembelian_bukti_um").select2("val", "-1");
				
				$('#table-dummy-pembelian tbody').html("");
			break;
			case 4: // clear form sehabis add item
				$("#pembelian_jasa").select2("val", "");
				$("#pembelian_harga_beli").val("");
				$("#pembelian_kwt").val("");
				$("#pembelian_pph_beli").val("");
				$("#pembelian_ppn_beli").val("");
				$("#pembelian_pph_persen").val("");
				$("#pembelian_jumlah").val("");
			break;
		}
	}
</script>