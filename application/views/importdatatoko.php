<style>
form { display: block; margin: 20px auto; background: #eee; border-radius: 10px; padding: 15px }
#progress { position:relative; width:100%; border: 1px solid #ddd; padding: 1px; border-radius: 3px; }
#bar { background-color: #B4F5B4; width:0%; height:20px; border-radius: 3px; }
#percent { position:absolute; display:inline-block; top:3px; left:48%; }
</style>
<div id="page-wrapper">
	<div class="row">
	    <div class="col-lg-12">
	        <h1 class="page-header">Vmart</h1>
	    </div>
	    <!-- /.col-lg-12 -->
	</div>
	<div class="row">
		<div class="col-lg-12">
	    	<div id="message"></div>
	    	<form id="myForm" action="<?php echo base_url(); ?>index.php/importdatatoko/importfile" method="post" enctype="multipart/form-data">
				<table width="100%">
					<tr>
						<td><input type="file" size="60" name="fileupload"></td>
						<td align="right"><input class="btn btn-info btn-sm" type="submit" value="Upload File"></td>
					</tr>
				</table>
			</form>
			<!--<div id="progress">
				<div id="bar"></div>
				<div id="percent">0%</div>
			</div>-->
			<div id="progress-data" style="display: none;">
				<div class="progress progress-striped active">
					<div class="progress-bar progress-bar-info" style="width: 20%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="20" role="progressbar">
						<span class="sr-only">20% Complete</span>
					</div>
				</div>
			</div>
	    </div>
	</div>
</div>
<script>
	$(document).ready(function(){
		OpenMenu();
		
		var options = {
		    beforeSend: function(){
		        $("#progress-data").show();
		        //clear everything
		        $("#progress-data .progress-bar").attr("style","width: 80%");
		        //$("#message").html("");
		        //$("#percent").html("0%");
		    },
		    uploadProgress: function(event, position, total, percentComplete){
		        //$("#bar").width(percentComplete+'%');
		        //$("#percent").html(percentComplete+'%');
				console.log(position+", "+total+", "+percentComplete);
		 		$("#progress-data .progress-bar").attr("style","width: "+percentComplete+"%");
		    },
		    success: function(){
		        // $("#bar").width('100%');
		        // $("#percent").html('100%');
		        $("#progress-data .progress-bar").attr("style","width: 100%");
		    },
		    complete: function(response){
		        $("#message").html("<font color='green'>"+response.responseText+"</font>");
		        
		        $("#progress-data").hide();
		    },
		    error: function(){
		        $("#message").html("<font color='red'> ERROR: unable to upload files</font>");
		 
		    }
		};
		$("#myForm").ajaxForm(options);
	});
</script>