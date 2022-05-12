<style>
	.datepicker{z-index:1151 !important;}
</style>
<div id="page-wrapper">
	<div class="row">
	    <div class="col-lg-12">
	        <h1 style="margin-top: 15px;" class="page-header">Transfer Toko (TG)</h1>
	    </div>
	    <!-- /.col-lg-12 -->
	</div>
	<div class="row" style="margin-bottom: 10px;">
		<div class="col-lg-12">
			<table style="float: right;">
				<tr>
					<td style="width: 200px;">
						<select class="form-control" style="width: 190px;" name="transfertoko_cari_toko" id="transfertoko_cari_toko">
							<option value="-1">Pilih Toko</option>
						</select>
					</td>
					<td style="width: 110px;">
						<select class="form-control" style="width: 100px;" name="transfertoko_cari_mode" id="transfertoko_cari_mode">
							<option value="">Semua</option>
							<option value="0">Draft</option>
							<option value="1">Approve</option>
						</select>
					</td>
					<!--<td style="width: 125px;">
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
					</td>-->
					<td>
						Tanggal Awal :
						<div class="form-group input-group">
							<span class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</span>
							<input type="text" value="<?= date('Y-m-d'); ?>" name="search_tanggal_awal" id="search_tanggal_awal" class="form-control">
						</div>
					</td>
					<td>&nbsp;&nbsp;</td>
					<td>
						Tanggal Akhir :
						<div class="form-group input-group">
							<span class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</span>
							<input type="text" value="<?= date('Y-m-d'); ?>" name="search_tanggal_akhir" id="search_tanggal_akhir" class="form-control">
						</div>
					</td>
					<td>&nbsp;&nbsp;</td>
					<td>
						<button id="btn_upload" onclick="LoadDataTG()" class="btn btn-info" type="button">
							<i class="fa fa-search"></i>
							&nbsp;&nbsp;Search
						</button>
					</td>
					<td>&nbsp;&nbsp;</td>
					<td valign="middle">
						<button id="btn_upload" onclick="CetakRekapTransferGudang()" class="btn btn-success" type="button">
							<i class="fa fa-print"></i>
							&nbsp;&nbsp;Rekap Harian (pdf)
						</button>
					</td>
					<td>&nbsp;&nbsp;</td>
					<td valign="middle">
						<button id="btn_upload" onclick="CetakRekapTransferGudangExcel()" class="btn btn-success" type="button">
							<i class="fa fa-print"></i>
							&nbsp;&nbsp;Rekap Harian (xls)
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
					<?php if($this->session->userdata('group_kode') == "GRU0000" || $this->session->userdata('group_kode') == "GRU0009" || $this->session->userdata('group_kode') == "GRU0012"){ ?>
					<button id="btn_tambah" onclick="openFormTG()" class="btn btn-info btn-sm" type="button">
						<i class="fa fa-plus"></i>
						&nbsp;&nbsp;Tambah
					</button>
					<button id="btn_uedit" onclick="openFormEditTG()" class="btn btn-success btn-sm" type="button">
						<i class="fa fa-edit"></i>
						&nbsp;&nbsp;Edit
					</button>
					<button id="btn_hapus" fungsi="HapusTG()" class="btn btn-danger btn-sm ask-tg" type="button">
						<i class="fa fa-times"></i>
						&nbsp;&nbsp;Hapus
					</button>
					<?php } ?>
					<?php if($this->session->userdata('group_kode') == "GRU0000" || $this->session->userdata('group_kode') == "GRU0001" || $this->session->userdata('group_kode') == "GRU0002" || $this->session->userdata('group_kode') == "GRU0004" || $this->session->userdata('group_kode') == "GRU0005" || $this->session->userdata('group_kode') == "GRU0012"){ ?>
					<button id="btn_uedit" onclick="TerimaTransferToko()" class="btn btn-warning btn-sm" type="button">
						<i class="fa fa-check"></i>
						&nbsp;&nbsp;Terima
					</button>
					<?php } ?>
					<?php if($this->session->userdata('group_kode') == "GRU0000" || $this->session->userdata('group_kode') == "GRU0009"){ ?>
					<button id="btn_uedit" onclick="BatalTerimaTransferToko()" class="btn btn-danger btn-sm" type="button">
						<i class="fa fa-check"></i>
						&nbsp;&nbsp;Batal Terima
					</button>
					<?php } ?>
					<button id="btn_hapus" onclick="CetakTransfer()" class="btn btn-warning btn-sm" type="button">
						<i class="fa fa-print"></i>
						&nbsp;&nbsp;Cetak
					</button>
					<button id="btn_hapus" onclick="CetakTransferPlain()" class="btn btn-warning btn-sm" type="button">
						<i class="fa fa-print"></i>
						&nbsp;&nbsp;Cetak Plain Text
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
					<div class="table-responsive table-tg">
						
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Popup form untuk pembelian barang -->
	<div class="modal fade" id="form-tg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        			<h4 class="modal-title" id="myModalLabel">Form Transfer Toko (TT)</h4>
				</div>
				<div class="modal-body">
					<table style="width: 100%;">
						<tr>
							<td style="width: 200px;">Tanggal :</td>
							<td>&nbsp;&nbsp;
								<input type="hidden" name="mode" id="mode" value="i"/>
								<input type="hidden" name="tg_bukti" id="tg_bukti"/>
								<input type="hidden" name="bukti_ot" id="bukti_ot"/>
							</td>
							<td>Ke Toko :</td>
						</tr>
						<tr>
							<td>
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</span>
									<input type="text" value="<?= date("Y-m-d"); ?>" name="tg_tanggal" id="tg_tanggal" class="form-control">
								</div>
							</td>
							<td>&nbsp;&nbsp;</td>
							<td>
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<select class="form-control" name="tg_gudang" id="tg_gudang">
										<option value="-1">Pilih Toko</option>
									</select>
								</div>
							</td>
						</tr>
					</table>
					<button style="margin-bottom:10px;" type="button" id="btn-import-ot" onclick="openformimportot()" class="btn btn-success">Import Order Transfer (OT)</button>
					<!--<table style="width: 100%; margin-bottom: 5px;">
						<tr>
							<td width="250px">Barang :</td>
							<td>&nbsp;&nbsp;</td>
							<td>Jumlah :</td>
							<td>&nbsp;&nbsp;</td>
							<td width="110px">Satuan :</td>
							<td>&nbsp;&nbsp;</td>
							<td>&nbsp;&nbsp;</td>
						</tr>
						<tr>
							<td width="250px"><input type="text" class="form-control" name="tg_barang" id="tg_barang" /></td>
							<td>&nbsp;&nbsp;</td>
							<td><input type="text" class="form-control" name="tg_kwt" id="tg_kwt" /></td>
							<td>&nbsp;&nbsp;</td>
							<td width="110px">
								<input type="text" class="form-control" name="tg_satuan" id="tg_satuan" readonly /></td>
							</td>
							<td>&nbsp;&nbsp;</td>
							<td>
								<button id="btn_tambah_barang" onclick="TambahBarangTG('')" class="btn btn-success btn-sm" type="button">
									<i class="fa fa-plus"></i>
									&nbsp;&nbsp;Tambah
								</button>
							</td>
						</tr>
					</table>-->
					<table style="width: 100%" id="table-dummy-tg" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th class="text-center">KD Barang</th>
								<th class="text-center">Nama Barang</th>
								<th class="text-center">KWT</th>
								<th class="text-center">HPP</th>
								<th class="text-center">Jumlah</th>
								<th class="text-center">SATUAN</th>
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
			        <button type="button" id="btn-simpan" onclick="SimpanTG()" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;&nbsp;Simpan</button>
				</div>
			</div>
		</div>
	</div>
	
	<!-- Popup form untuk piiih OP -->
	<div class="modal fade" id="form-list-ot" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        			<h4 class="modal-title" id="myModalLabel">List Order Transfer (OT)</h4>
				</div>
				<div class="modal-body">
					<table style="margin-bottom: 5px;">
						<tr>
							<td style="width: 125px;">
								<input style="width: 115px;" type="text" name="list_ot_tahun" id="list_ot_tahun" value="<?= date("Y"); ?>" class="form-control" />
							</td>
							<td style="width: 125px;">
								<select style="width: 115px;" class="form-control" name="list_ot_bulan" id="list_ot_bulan">
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
								<button id="btn_upload" onclick="loadListOT()" class="btn btn-info" type="button">
									<i class="fa fa-search"></i>
									&nbsp;&nbsp;Search
								</button>
							</td>
						</tr>
					</table>
					<div id="list_ot"></div>
				</div>
			</div>
		</div>
	</div>
	<!-- Popup form untuk piiih OP -->
	<div class="modal fade" id="form-edit-kwt" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        			<h4 class="modal-title" id="myModalLabel">List Order Transfer (OT)</h4>
				</div>
				<div class="modal-body">
					Kode Barang
					<div class="form-group input-group">
						<span class="input-group-addon">
							<i class="fa fa-file"></i>
						</span>
						<input type="text" class="form-control" name="edit_barang_kode" id="edit_barang_kode" readonly />
					</div>
					Jumlah Barang
					<div class="form-group input-group">
						<span class="input-group-addon">
							<i class="fa fa-file"></i>
						</span>
						<input type="text" class="form-control" style="text-align:right;" name="edit_kwt" id="edit_kwt" />
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<img src="<?= base_url() ?>/images/loader.gif" id="loader-form"  style="width: 30px; display: none;" />
			        <button type="button" id="btn-simpan" onclick="SimpanEditKwt()" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;&nbsp;Simpan</button>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		OpenMenu();
		LoadDataTG();
		LoadListDataBarang();
		loadListToko();
		
		$('.ask-tg').jConfirmAction();
		
		$('#tg_tanggal').datepicker({
			format: 'yyyy-mm-dd'
		});
		$('#search_tanggal_awal').datepicker({
			format: 'yyyy-mm-dd'
		});
		$('#search_tanggal_akhir').datepicker({
			format: 'yyyy-mm-dd'
		});
		
		$('.datepicker tbody').on('click', function(){  $('.datepicker').hide() });
	});
	
	function loadListToko(){
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/toko/getListDataToko",
			data: "",
			success: function(msg){
				$("#tg_gudang").html(msg);
				$("#transfertoko_cari_toko").html(msg);
			}
		});
	}
	
	function LoadDataTG(){
		$('#progres-main').show();
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/transfergudang/getdatatg",
			data: "tanggal_awal="+$("#search_tanggal_awal").val()+"&tanggal_akhir="+$("#search_tanggal_akhir").val()+"&toko_kode="+$("#transfertoko_cari_toko").val()+"&is_approve="+$("#transfertoko_cari_mode").val(),
			success: function(msg){
				$(".table-tg").html(msg);
				//table = $('#dataTables-tg').dataTable();
				$('#progres-main').hide();
				
				$('#dataTables-tg tbody').on( 'click', 'tr', function () {
			        if ( $(this).hasClass('active') ) {
			            $(this).removeClass('active');
			        }else {
			            $('#dataTables-tg tr.active').removeClass('active');
			            $(this).addClass('active');
			        }
			    } );
			}
		});
	}
	
	function openFormTG(){
		$("#form-tg").modal("show");
		$("#mode").val("i");
		$("#tg_bukti").val("");
	}
	
	function openformimportot(){
		$("#form-list-ot").modal("show");
		
		loadListOT();
	}
	
	function loadListOT(){
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/ordertransfer/listpilihot",
			data: "tahun="+$("#list_ot_tahun").val()+"&bulan="+$("#list_ot_bulan").val()+"&toko_kode="+$("#tg_gudang").val(),
			success: function(msg){
				$("#list_ot").html(msg);
			}
		});
	}
	
	function LoadListDataBarang(){
	    $("#tg_barang").select2({
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
            	return "<span class=\"select2-match\"></span>"+option.kode+" - "+option.nama_barang;
            }, 
		    formatSelection: function (option) {
            	return option.nama_barang;
            }
	    });
	    
	    $("#tg_barang").on("select2-selecting", function(e) {
	    	// dataperlang = e;
	    	// alert ("selecting val="+ e.choice.satuan_terkecil +" choice="+ JSON.stringify(e.choice));
			$("#btn_tambah_barang").attr("onclick", "TambahBarangTG('"+e.choice.satuan+"')");
			//$("#tg_satuan_barang").attr("onchange", "HitungKonversiSatuan("+e.choice.nilai_konversi+")");
	    	
			$("#tg_satuan").val(e.choice.satuan);
	    });
	}
	
	/*function HitungKonversiSatuan(nilai_konversi){
		var tipe_satuan = $("#tg_satuan_barang").val();
		var nilai_kwt = $("#tg_kwt").val();
		if(tipe_satuan == "besar"){
			nilai_kwt = nilai_kwt / nilai_konversi;
		}else{
			nilai_kwt = nilai_kwt * nilai_konversi;
		}
		
		$("#tg_kwt").val(nilai_kwt);
	}*/
	
	function HapusRow(DataObj){
		dataobj = DataObj;
		$(DataObj).parent().parent().remove();
	}
	
	function TambahBarangTG(nama_satuan){
		var kd_barang = $("#tg_barang").val();
		var nama_barang = $("#s2id_tg_barang .select2-chosen").html();
		var kwt = $("#tg_kwt").val();
		
		var row = "<tr><td>"+kd_barang+"</td><td>"+nama_barang+"</td><td class=\"text-right\">"+kwt+"</td><td>"+nama_satuan+"</td><td class=\"text-center\"><button type=\"button\" style=\"padding: 0px 20px;\" onclick=\"HapusRow(this)\" class=\"btn btn-danger btn-sm\"><i class=\"fa fa-times\"></i></button></td></tr>";
		$('#table-dummy-tg > tbody:last').append(row);
	}
	
	function clearForm(){
		$('#table-dummy-tg tbody').html("");
		$("#tg_barang").select2("val", "");
		$("#tg_kwt").val("");
	}
	
	function SimpanTG(){
		$('#btn-simpan').hide();
		$('#loader-form').show();
		
		var dataArr = [];
	    $("#table-dummy-tg td").each(function(){
	        dataArr.push($(this).html());
	    });
	    var mode = $("#mode").val();
		var bukti = $("#tg_bukti").val();
		
		if(mode == "i"){
			var modeBukti = "TG";
			var tanggal_tg = $("#tg_tanggal").val();
			$.ajax({
				type: "POST",
				url: "<?= base_url() ?>index.php/bukti/generatebukti",
				data: "mode="+modeBukti+"&tanggal="+tanggal_tg,
				success: function(msg){
					ajaxsimpantg(msg, dataArr, 0);
				}
			});
		}else{
			$.ajax({
				type: "POST",
				url: "<?= base_url(); ?>index.php/transfergudang/hapustg",
				data: "bukti="+bukti+"&ref_ot="+$("#bukti_ot").val(),
				success: function(msg){
					ajaxsimpantg(bukti, dataArr, 0);
				}
			});
		}
	}
	
	function ajaxsimpantg(bukti, dataArr, index){
		var kd_barang = dataArr[index];
		var kwt = dataArr[index+2];
		var harga = dataArr[index+3];
		var jumlah = dataArr[index+4];
		var tanggal = $("#tg_tanggal").val();
		var kd_gudang = $("#tg_gudang").val();
		var ref_ot = $("#bukti_ot").val();
		var mode = $("#mode").val();
		
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/transfergudang/simpantg",
			data: "mode="+mode+"&ref_ot="+ref_ot+"&bukti="+bukti+"&barang_kode="+kd_barang+"&kwt="+kwt+"&harga="+harga+"&jumlah="+jumlah+"&tanggal="+tanggal+"&toko_kode="+kd_gudang,
			success: function(msg){
				index = index + 7;
				if(index >= dataArr.length){ // jika sudah sampai index yang terakhir
					$('#btn-simpan').show();
					$('#loader-form').hide();
					
					ShowMessage("success", "Data berhasil disimpan");
					LoadDataTG();
					$("#form-tg").modal("hide");
				}else{ // jika masih ada data yang dimasukkan
					ajaxsimpantg(bukti, dataArr, index);
				}
			},
			error: function(xhr,status,error){
				ShowMessage("danger", "Data gagal disimpan");
				$('#btn-simpan').show();
				$('#loader-form').hide();
			}
		});
	}
	
	function HapusTG(){
		var data_obj = $('#dataTables-tg tr.active').attr("data");
		
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			if(data['is_approve'] == "1"){
				alert("Transfer toko sudah dilakukan penerimaan");
			}else{
				$('#progres-main').show();
				$.ajax({
					type: "POST",
					url: "<?= base_url(); ?>index.php/transfergudang/hapustg",
					data: "bukti="+data['bukti']+"&ref_ot="+data['ref_ot'],
					success: function(msg){
						ShowMessage("success", "Data berhasil dihapus");
						LoadDataTG();
					}
				});
			}
		}
	}
	
	function openFormEditTG(){
		var data_obj = $('#dataTables-tg tr.active').attr("data");
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			if(data['is_approve'] == "1"){
				alert("Transfer toko sudah dilakukan penerimaan");
			}else{
				$("#mode").val("e");
				$("#tg_bukti").val(data['bukti']);
				$("#tg_tanggal").val(data['tanggal']);
				$("#tg_gudang").val(data['toko_kode']);
				
				$.ajax({
					type: "POST",
					url: "<?= base_url() ?>index.php/transfergudang/getdatabarangtg",
					data: "bukti="+data['bukti'],
					success: function(msg){
						$("#table-dummy-tg tbody").html(msg);
					}
				});
				
				$("#form-tg").modal("show");
			}
		}
	}
	
	function openFormEditKWT(barang_kode, kwt){
		$("#form-edit-kwt").modal("show");
		$("#edit_barang_kode").val(barang_kode);
		$("#edit_kwt").val(kwt);
	}
	
	function PilihOT(bukti){
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/ordertransfer/getdatabarangottg",
			data: "bukti="+bukti,
			success: function(msg){
				$("#bukti_ot").val(bukti);
				$("#table-dummy-tg tbody").html(msg);
				
				$("#form-list-ot").modal("hide");
			}
		});
	}
	
	function Editkwt(barang_kode){
		$("#kwt_edit_"+barang_kode).show();
		$("#btn_edit_kwt_"+barang_kode).show();
		$("#btn_cancel_edit_kwt_"+barang_kode).show();
	}
	
	function CancelEditkwt(barang_kode){
		$("#kwt_edit_"+barang_kode).hide();
		$("#btn_edit_kwt_"+barang_kode).hide();
		$("#btn_cancel_edit_kwt_"+barang_kode).hide();
	}
	
	function SimpanEditKwt(){
		var kwt_edit = $("#edit_kwt").val();
		var barang_kode = $("#edit_barang_kode").val();
		var harga = $("#harga_"+barang_kode).html();
		var jumlah = kwt_edit * harga;
		$("#kwt_"+barang_kode).html(kwt_edit);
		$("#jumlah_"+barang_kode).html(jumlah);
		
		$("#form-edit-kwt").modal("hide");
	}
	
	function TerimaTransferToko(){
		var data_obj = $('#dataTables-tg tr.active').attr("data");
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			if(data['is_approve'] == "1"){
				alert("Transfer toko sudah dilakukan penerimaan");
			}else{
				var ConfirmTerima = confirm("Apakah transfer barang sudah diterima?");
				if(ConfirmTerima){
					$.ajax({
						type: "POST",
						url: "<?= base_url() ?>index.php/transfergudang/terimatransfertoko",
						data: "bukti="+data['bukti']+"&toko_kode="+data['toko_kode'],
						success: function(msg){
							LoadDataTG();
						}
					})
				}
			}
		}
	}

	function BatalTerimaTransferToko(){
		var data_obj = $('#dataTables-tg tr.active').attr("data");
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			if(data['is_approve'] == "1"){
				var ConfirmTerima = confirm("Apakah anda ingin membatalkan approval penerimaan?");
				if(ConfirmTerima){
					$.ajax({
						type: "POST",
						url: "<?= base_url() ?>index.php/transfergudang/batalterimatransfertoko",
						data: "bukti="+data['bukti']+"&toko_kode="+data['toko_kode'],
						success: function(msg){
							LoadDataTG();
						}
					})
				}
			}else{
				alert("Transfer toko belum dilakukan penerimaan");
			}
		}
	}
	
	function CetakTransfer(){
		var data_obj = $('#dataTables-tg tr.active').attr("data");
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			window.open('<?= base_url('index.php/transfergudang/cetaktg?') ?>bukti='+data['bukti'],'_blank');
		}
	}

	function CetakTransferPlain(){
		var data_obj = $('#dataTables-tg tr.active').attr("data");
		if(typeof data_obj == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			var data = json_decode(base64_decode(data_obj));
			window.open('<?= base_url('index.php/transfergudang/cetaktgplain?') ?>bukti='+data['bukti'],'_blank');
		}
	}

	function CetakRekapTransferGudang(){
		var tanggal_awal = $("#search_tanggal_awal").val();
		var tanggal_akhir = $("#search_tanggal_akhir").val();
		var toko_kode = $("#transfertoko_cari_toko").val();
		window.open('<?= base_url('index.php/transfergudang/getrekaptransfergudang?') ?>tanggal_awal='+tanggal_awal+'&tanggal_akhir='+tanggal_akhir+'&toko_kode='+toko_kode,'_blank');
	}

	function CetakRekapTransferGudangExcel(){
		var tanggal_awal = $("#search_tanggal_awal").val();
		var tanggal_akhir = $("#search_tanggal_akhir").val();
		var toko_kode = $("#transfertoko_cari_toko").val();
		window.open('<?= base_url('index.php/transfergudang/getrekaptransfergudang_xls?') ?>tanggal_awal='+tanggal_awal+'&tanggal_akhir='+tanggal_akhir+'&toko_kode='+toko_kode,'_blank');
	}
</script>