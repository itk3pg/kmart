<style>
	.datepicker{z-index:1151 !important;}
</style>
<div id="page-wrapper">
	<div class="row">
	    <div class="col-lg-12">
	        <h1 style="margin-top: 15px;" class="page-header">Data KasBank</h1>
	    </div>
	    <!-- /.col-lg-12 -->
	</div>
	<div class="row">
		<div class="col-lg-12">
			<table style="float: right;">
				<tr>
					<td style="width: 200px;">
						<div class="form-group input-group">
							<span class="input-group-addon">
								<i class="fa fa-user"></i>
							</span>
							<?php
								$Disable = "disabled";
								if($this->session->userdata('toko_kode') == 'VO0006' || $this->session->userdata('toko_kode') == 'VO0008' || $this->session->userdata('username') == "800"){
									$Disable = "";
								}
							?>
							<select style="width: 150px;" <?php echo $Disable; ?> class="form-control" name="search_toko_kode" id="search_toko_kode">
								<?php
								if($this->session->userdata('toko_kode') == 'VO0006' || $this->session->userdata('toko_kode') == 'VO0008'){
									foreach ($DataToko as $key => $value) {
										if($value['kode'] == "VO0008" || $value['kode'] == "VO0001" || $value['kode'] == "VO0002"){
											echo "<option value=\"".$value['kode']."\">".$value['nama']."</option>";
										}
									}
								}else if($this->session->userdata('username') == "800"){
									echo "<option selected=\"true\" value=\"VO0003\">MINI K-MART GELURAN</option>";
									echo "<option selected=\"true\" value=\"VO0004\">MINI K-MART GKB</option>";
									echo "<option selected=\"true\" value=\"VO0005\">MINI K-MART PANJUNAN</option>";
								}else{
									foreach ($DataToko as $key => $value) {
										if($this->session->userdata('toko_kode') == $value['kode']){
											echo "<option selected=\"true\" value=\"".$value['kode']."\">".$value['nama']."</option>";
										}else{
											echo "<option value=\"".$value['kode']."\">".$value['nama']."</option>";
										}
									}
								}
								?>
							</select>
						</div>
					</td>
					<!--<td style="width: 125px;">
						<input style="width: 115px;" type="text" name="tahun" id="tahun" value="<?= date("Y"); ?>" class="form-control" />
					</td>
					<td style="width: 125px;">
						<select class="form-control" style="width: 115px;" name="bulan" id="bulan">
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
						<div class="form-group input-group">
							<span class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</span>
							<input type="text" value="<?= date('Y-m-d'); ?>" name="search_tanggal" id="search_tanggal" class="form-control">
						</div>
					</td>
					<td>&nbsp;&nbsp;</td>
					<td valign="top">
						<button id="btn_upload" onclick="LoadDataKasbank()" class="btn btn-info" type="button">
							<i class="fa fa-search"></i>
							&nbsp;&nbsp;Search
						</button>
					</td>
					<td>&nbsp;&nbsp;</td>
					<td valign="top">
						<button id="btn_upload" onclick="CetakRekapKasbank()" class="btn btn-warning" type="button">
							<i class="fa fa-print"></i>
							&nbsp;&nbsp;Cetak Rekap Harian 
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
                    <button id="btn_upload" onclick="openformkasbank(1)" class="btn btn-info btn-sm" type="button">
						<i class="fa fa-plus"></i>
						&nbsp;&nbsp;Tambah
					</button>
					<button id="btn_upload" onclick="openformkasbank(2)" class="btn btn-info btn-sm" type="button">
						<i class="fa fa-edit"></i>
						&nbsp;&nbsp;Edit
					</button>
					<button id="btn_upload" fungsi="HapusKasbank()" class="btn btn-danger btn-sm ask" type="button">
						<i class="fa fa-times"></i>
						&nbsp;&nbsp;Hapus
					</button>
					<button id="btn_upload" onclick="cetakBukti()" class="btn btn-success btn-sm" type="button">
						<i class="fa fa-print"></i>
						&nbsp;&nbsp;Cetak Bukti
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
					<div class="table-responsive table-kasbank">
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Popup input kasbank -->
	<div class="modal fade" id="form-kasbank" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        			<h4 class="modal-title" id="myModalLabel">Form Kas/Bank</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label class="radio-inline">
							<input onchange="changemodekasbank('-1')" id="kasbank_status_km" type="radio" value="KM" name="kasbank_status"> Kas Masuk
						</label>
						<label class="radio-inline">
							<input onchange="changemodekasbank('-1')" id="kasbank_status_kk" type="radio" value="KK" name="kasbank_status"> Kas Keluar
						</label>
						&nbsp;&nbsp;&nbsp;|
						<label class="radio-inline">
							<input onchange="changemodekasbank('-1')" id="kasbank_status_bm" type="radio" value="BM" name="kasbank_status"> Bank Masuk
						</label>
						<label class="radio-inline">
							<input onchange="changemodekasbank('-1')" id="kasbank_status_bk" type="radio" value="BK" name="kasbank_status"> Bank Keluar
						</label>
					</div>
					<table width="100%">
						<tr>
							<td width="47%" valign="top">
								Unit :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-book"></i>
									</span>
									<?php
										$Disabled = "disabled";
										if($this->session->userdata('username') == "800"){
											$Disabled = "";
										}
									?>
									<select class="form-control" <?php echo $Disabled; ?> name="kasbank_unit_kode" id="kasbank_unit_kode">
										<?php
										if($this->session->userdata('username') == "800"){
											echo "<option selected=\"true\" value=\"VO0003\">MINI K-MART GELURAN</option>";
											echo "<option selected=\"true\" value=\"VO0004\">MINI K-MART GKB</option>";
											echo "<option selected=\"true\" value=\"VO0005\">MINI K-MART PANJUNAN</option>";
										}else{
											foreach ($DataToko as $key => $value) {											
												if($this->session->userdata('toko_kode') == $value['kode']){
													echo "<option selected=\"true\" value=\"".$value['kode']."\">".$value['nama']."</option>";
												}else{
													echo "<option value=\"".$value['kode']."\">".$value['nama']."</option>";
												}
											}
										}
										?>
									</select>
								</div>
								Tanggal :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</span>
									<input type="hidden" name="kasbank_form_mode" id="kasbank_form_mode" value="i" />
									<input type="text" value="<?= date("Y-m-d") ?>" placeholder="tanggal" name="kasbank_tanggal" id="kasbank_tanggal" class="form-control">
								</div>
								Kode Kas/Bank :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-book"></i>
									</span>
									<select class="form-control" name="kasbank_kd_kb" id="kasbank_kd_kb">
										<option value="-1">Pilih Kode Kas/Bank</option>
										<?php
										foreach ($DataKB as $key => $value) {
											echo "<option value=\"".$value['kd_kb']."\">".$value['kd_kb']."-".$value['keterangan']."</option>";
										}
										?>
									</select>
								</div>
								Kode Cash Budget :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-book"></i>
									</span>
									<select style="width: 240px;" onchange="pilih_kdcb()" class="form-control" name="kasbank_kd_cb" id="kasbank_kd_cb">
										<option value="-1">Pilih Kode Cash Budget</option>
									</select>
								</div>
								<div class="bbm">
								No Polisi :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-book"></i>
									</span>
									<select class="form-control" onchange="PilihNopol()" name="kasbank_nopol" id="kasbank_nopol">
										<option value="-1">Pilih Nopol</option>
									</select>
								</div>
								Plafon BBM :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file-text"></i>
									</span>
									<input type="text" readonly style="text-align: right;" name="kasbank_plafonbbm" id="kasbank_plafonbbm" class="form-control">
								</div>
								Sisa Plafon BBM :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file-text"></i>
									</span>
									<input type="text" readonly style="text-align: right;" name="kasbank_sisaplafonbbm" id="kasbank_sisaplafonbbm" class="form-control">
								</div>
								</div>
							</td>
							<td width="6%">&nbsp;&nbsp;&nbsp;&nbsp;</td>
							<td width="47%" valign="top">
								Dibayarkan/Diterima :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-user"></i>
									</span>
									<input type="hidden" class="form-control" name="kasbank_namasubject" id="kasbank_namasubject" />
									<input type="text" style="width: 240px;" class="form-control" name="kasbank_subject" id="kasbank_subject" />
								</div>
								Toko :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-user"></i>
									</span>
									<select class="form-control" name="kasbank_toko_kode" id="kasbank_toko_kode">
										<option value="">Pilih Toko</option>
										<?php
										if($this->session->userdata('toko_kode') == 'VO0006' || $this->session->userdata('toko_kode') == 'VO0008'){
											foreach ($DataToko as $key => $value) {
												echo "<option value=\"".$value['kode']."\">".$value['nama']."</option>";
											}
										}else if($this->session->userdata('username') == "800"){
											echo "<option selected=\"true\" value=\"VO0003\">MINI K-MART GELURAN</option>";
											echo "<option selected=\"true\" value=\"VO0004\">MINI K-MART GKB</option>";
											echo "<option selected=\"true\" value=\"VO0005\">MINI K-MART PANJUNAN</option>";
										}else{
											foreach ($DataToko as $key => $value) {
												if($this->session->userdata('toko_kode') == $value['kode']){
													echo "<option selected=\"true\" value=\"".$value['kode']."\">".$value['nama']."</option>";
												}else{
													echo "<option value=\"".$value['kode']."\">".$value['nama']."</option>";
												}
											}
										}
										?>
									</select>
								</div>
								Keterangan :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file-text"></i>
									</span>
									<input type="text" onkeyup="toUpper('kasbank_keterangan')" placeholder="Keterangan" name="kasbank_keterangan" id="kasbank_keterangan" class="form-control">
								</div>
								Jumlah :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-money"></i>
									</span>
									<input type="text" style="text-align: right;" onkeyup="price('kasbank_jumlah'); hitungplafonbbm();" placeholder="Jumlah" name="kasbank_jumlah" id="kasbank_jumlah" class="form-control">
								</div>
								No Referensi :
								<div class="form-group input-group">
									<span class="input-group-addon">
										<i class="fa fa-file-text"></i>
									</span>
									<input type="text" placeholder="Bukti Referensi" name="kasbank_referensi" id="kasbank_referensi" class="form-control">
								</div>
							</td>
						</tr>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" onclick="clearForm(1)" class="btn btn-default">Reset</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<img src="<?= base_url() ?>/images/loader.gif" id="loader-form"  style="width: 30px; display: none;" />
			        <button type="button" id="btn-simpan" onclick="simpankasbank()" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;&nbsp;Simpan</button>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		OpenMenu();
		LoadDataKasbank();
		LoadListDataSubject();
		
		$('#kasbank_tanggal').datepicker({
			format: 'yyyy-mm-dd'
		});
		$('#search_tanggal').datepicker({
			format: 'yyyy-mm-dd'
		});
		
		$("#kasbank_kd_kb").select2();
		$('.datepicker tbody').on('click', function(){  $('.datepicker').hide() });
		
		$('.ask').jConfirmAction();

		$(".bbm").hide();
	});
	
	function LoadDataKasbank(){
		$('#progres-main').show();
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/kasbank/getdatakasbank",
			data: "tanggal="+$('#search_tanggal').val()+"&unit_kode="+$("#search_toko_kode").val(),
			success: function(msg){
				$(".table-kasbank").html(msg);
				table = $('#dataTables-kasbank').dataTable();
				$('#progres-main').hide();
				
				$('#dataTables-kasbank tbody').on( 'click', 'tr', function () {
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

	function LoadListNopol(){
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>index.php/kasbank/getdatanopol",
			data: "",
			success: function(msg){
				$("#kasbank_nopol").html(msg);
			}
		});
	}

	function pilih_kdcb(){
		var kd_cb = $("#kasbank_kd_cb").val();
		if(kd_cb == "2607"){ // 276
			$(".bbm").show();
		}else{
			$(".bbm").hide();
		}
	}

	function PilihNopol(){
		var DataNopol = $("#kasbank_nopol").val();

		var DataArr = json_decode(base64_decode(DataNopol));
		var plafon = DataArr['plafon_liter'] * DataArr['harga_bbm'];
		var pemakaian = DataArr['pemakaian'];
		var sisa_plafon = plafon - pemakaian;

		$("#kasbank_plafonbbm").val(plafon);
		$("#kasbank_sisaplafonbbm").val(sisa_plafon);

		price('kasbank_plafonbbm');
		price('kasbank_sisaplafonbbm');
	}
	
	function LoadListDataSubject(){
	    $("#kasbank_subject").select2({
		    placeholder: "Cari Pelanggan",
		    minimumInputLength: 1,
		    ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
			    url: "<?php echo base_url(); ?>index.php/kasbank/getlistsubject",
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
		    	return option.kd_subject;
		    },
		    formatResult: function (option) {
            	return "<span class=\"select2-match\"></span>"+option.kd_subject+" - "+option.nama_subject;
            }, 
		    formatSelection: function (option) {
            	return option.kd_subject+" - "+option.nama_subject;
            }
	    });
	    
	    $("#kasbank_subject").on("select2-selecting", function(e) {
	    	// dataperlang = e;
	    	// alert ("selecting val="+ e.choice.satuan_terkecil +" choice="+ JSON.stringify(e.choice));
			$("#kasbank_namasubject").val(e.choice.nama_subject);
	    });
	}
	
	function openformkasbank(mode){
		LoadListNopol();

		if(mode == 1){ //insert kasbank
			$("#kasbank_form_mode").val("i");
			$('#form-kasbank').modal('show');
		}else{ // edit kasbank
			var data = table.$('tr.active').attr("data");
			
			if(typeof data == "undefined"){
				alert("Silahkan pilih salah satu data terlebih dahulu");
			}else{
				dataArr = json_decode(base64_decode(data));
				var TanggalArr = dataArr['tanggal'].split("-");
				// var Today = new Date();
				var TanggalData = new Date();
				// var newDate = parseFloat(TanggalArr[2]) + 3;
			
				//TanggalData.setFullYear(TanggalArr[0], TanggalArr[1]-1, newDate);
				if(parseFloat(TanggalArr[1]) == parseFloat(TanggalData.getMonth()+1)){
					// alert(dataArr['no_ref_dropping']);
					if(dataArr['kd_cb'] == "2607"){ // 276
						alert("biaya bbm tidak bisa diedit");
					}else if(dataArr['no_ref_dropping'] != ""){
						alert("biaya sudah diajukan dropping dengan no "+dataArr['no_ref_dropping']);
					}else{
						$("#kasbank_tanggal").val(dataArr['tanggal']);
						
						$("#kasbank_kd_kb").select2("val", dataArr['kd_kb']);
						$("#kasbank_subject").val(dataArr['kode_subject']);
						$("#select2-chosen-1").html(dataArr['nama_subject']);
						
						var bukti = dataArr['bukti'].substring(0, 2);
						if(bukti == "KK"){
							$("#kasbank_status_kk").attr('checked', 'checked');
						}else if(bukti == "KM"){
							$("#kasbank_status_km").attr('checked', 'checked');
						}else if(bukti == "BK"){
							$("#kasbank_status_bk").attr('checked', 'checked');
						}else if(bukti == "BM"){
							$("#kasbank_status_bm").attr('checked', 'checked');
						}
						
						changemodekasbank(dataArr['kd_cb']);
						$("#kasbank_keterangan").val(dataArr['keterangan']);
						$("#kasbank_jumlah").val(dataArr['jumlah']);
						price_js("kasbank_jumlah");
						$("#kasbank_referensi").val(dataArr['no_ref']);
						$("#kasbank_unit_kode").val(dataArr['unit_kode']);
						$("#kasbank_toko_kode").val(dataArr['toko_kode']);
						
						$("#kasbank_form_mode").val("u");
						
						$('#form-kasbank').modal('show');
					}
				}else{
					alert("sudah melebihi batas bulan");
				}
			}
		}
	}
	
	function changemodekasbank(kd_cb){
		var mode = $("input[name=kasbank_status]:checked").val();
		
		$("#kasbank_kd_cb").select2("destroy");
		$.ajax({
			type: "POST",
			url: "<?= base_url(); ?>index.php/kasbank/getdatacb",
			data: "mode="+mode,
			success: function(msg){
				$("#kasbank_kd_cb").html(msg);
				$("#kasbank_kd_cb").select2();
				$("#kasbank_kd_cb").select2("val", kd_cb);
			}
		});
	}
	
	function simpankasbank(){
		$('#btn-simpan').hide();
		$('#loader-form').show();
		
		var tanggal = $("#kasbank_tanggal").val();
		var kd_kb = $("#kasbank_kd_kb").val();
		var kd_cb = $("#kasbank_kd_cb").val();
		var kd_subject = $("#kasbank_subject").val();
		var nama_subject = $("#s2id_kasbank_subject .select2-chosen").html();
		if(kd_subject == ""){
			nama_subject = "";
		}
		var keterangan = $("#kasbank_keterangan").val();
		var jumlah = removeCurrency($("#kasbank_jumlah").val());
		var no_ref = $("#kasbank_referensi").val();
		var unit_kode = $("#kasbank_unit_kode").val();
		var toko_kode = $("#kasbank_toko_kode").val();
		var mode = $("input[name=kasbank_status]:checked").val();
		var bukti_kasbank = "x";
		var jumlah_lama = 0;
		var mode_form = $("#kasbank_form_mode").val();
		if(mode_form == "u"){
			bukti_kasbank = table.$('tr.active').attr("bukti");
			jumlah_lama = table.$('tr.active').attr("jumlah");
		}
		
		var nopol = "";
		if(kd_cb == '2607'){ //276
			var nopolObj = json_decode(base64_decode($("#kasbank_nopol").val()));
			nopol = nopolObj['nopol'];
		}

		$.ajax({
			type: "POST",
			url: "<?= base_url(); ?>index.php/kasbank/simpankasbank",
			data: "bukti_kasbank="+bukti_kasbank+"&tanggal="+tanggal+"&kd_kb="+kd_kb+"&kd_cb="+kd_cb+"&unit_kode="+unit_kode+"&toko_kode="+toko_kode+"&kd_subject="+kd_subject+"&nama_subject="+nama_subject+"&keterangan="+keterangan+"&jumlah="+jumlah+"&no_ref="+no_ref+"&nama_subject="+nama_subject+"&mode="+mode+"&mode_form="+mode_form+"&jumlah_lama="+jumlah_lama+"&nopol="+nopol,
			success: function(msg){
				$('#btn-simpan').show();
				$('#loader-form').hide();
				$('#form-kasbank').modal('hide');
				clearForm(1);
				LoadDataKasbank();
				
				ShowMessage("info", "Data berhasil disimpan.");
			},
			error: function(xhr,status,error){
				alert("Maaf, data gagal disimpan");
				
				$('#btn-simpan').show();
				$('#loader-form').hide();
			}
		});
	}
	
	function HapusKasbank(){
		var data = table.$('tr.active').attr("data");
		
		if(typeof data == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			dataArr = json_decode(base64_decode(data));
			var TanggalArr = dataArr['tanggal'].split("-");
			// var Today = new Date();
			var TanggalData = new Date();
			// var newDate = parseFloat(TanggalArr[2]) + 3;
		
			//TanggalData.setFullYear(TanggalArr[0], TanggalArr[1]-1, newDate);
			if(parseFloat(TanggalArr[1]) == parseFloat(TanggalData.getMonth()+1)){
				if(dataArr['kd_cb'] == "1201"){ // 102
					alert("pelunasan piutang tidak bisa dihapus melalui kasbank");
					return;
				}else if(dataArr['no_ref_dropping'] != ""){
					alert("biaya sudah diajukan dropping");
					return;
				}
				var bukti = dataArr['bukti'];
				var kd_kb = dataArr['kd_kb'];
				var kd_cb = dataArr['kd_cb'];
				var jumlah = dataArr['jumlah'];
				var tanggal = dataArr['tanggal'];
				var unit_kode = dataArr['unit_kode'];
				var nopol = dataArr['nopol'];
				$.ajax({
					type: "POST",
					url: "<?= base_url() ?>index.php/kasbank/hapuskasbank",
					data: "bukti="+bukti+"&kd_kb="+kd_kb+"&kd_cb="+kd_cb+"&jumlah="+jumlah+"&tanggal="+tanggal+"&nopol="+nopol,
					success: function(msg){
						LoadDataKasbank();
					}
				});
			}else{
				alert("sudah melebihi batas bulan");
			}
		}
	}
	
	function cetakBukti(){
		var data = table.$('tr.active').attr("data");
		
		if(typeof data == "undefined"){
			alert("Silahkan pilih salah satu data terlebih dahulu");
		}else{
			dataArr = json_decode(base64_decode(data));
			var bukti = dataArr['bukti'];
			var unit_kode = dataArr['unit_kode'];
			window.open('<?= base_url(); ?>index.php/kasbank/cetakkasbank?bukti='+bukti+'&unit_kode='+unit_kode,'_blank');
		}
	}
	
	function CetakRekapKasbank(){
		var tanggal = $("#search_tanggal").val();
		window.open('<?= base_url(); ?>index.php/kasbank/cetakdatakasbankharian?tanggal='+$('#search_tanggal').val()+'&unit_kode='+$("#search_toko_kode").val(),'_blank');
	}

	function hitungplafonbbm(){
		var kd_cb = $("#kasbank_kd_cb").val();
		if(kd_cb == "2607"){ // 276
			var sisa_plafon = removeCurrency($("#kasbank_sisaplafonbbm").val());
			var entry = removeCurrency($("#kasbank_jumlah").val());

			if(parseFloat(entry) > parseFloat(sisa_plafon)){
				alert('tidak boleh melebihi sisa plafon bbm '+entry+' > '+sisa_plafon);
				$("#kasbank_jumlah").val(sisa_plafon);
				price("kasbank_jumlah");
			}
		}
	}
	
	function clearForm(mode){
		switch(mode){
			case 1 :
				$("#kasbank_tanggal").val("<?= date("Y-m-d"); ?>");
				$("#kasbank_kd_kb").select2("val", "-1");
				$("#kasbank_kd_cb").select2("val", "-1");
				$("#kasbank_subject").val("");
				$("#kasbank_keterangan").val("");
				$("#kasbank_jumlah").val("");
				$("#kasbank_referensi").val("");
				$("#kasbank_toko_kode").val("");
				
				$("input[name=kasbank_status]:checked").removeAttr("checked");
				$("#kasbank_nopol").html("");
				$("#kasbank_plafonbbm").val("0");
				$("#kasbank_sisaplafonbbm").val("0");
				$(".bbm").hide();
				break;
		}
	}
</script>