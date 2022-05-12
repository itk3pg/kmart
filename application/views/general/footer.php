	</div>
    <!-- /#wrapper -->

    <!-- Page-Level Plugin Scripts - Dashboard -->
    <script src="<?php echo base_url(); ?>js/plugins/morris/raphael-2.1.0.min.js"></script>
    <script src="<?php echo base_url(); ?>js/plugins/morris/morris.js"></script>

    <!-- Page-Level Demo Scripts - Dashboard - Use for reference -->
    <!-- <script src="<?php echo base_url(); ?>js/demo/dashboard-demo.js"></script> -->
	<script>
		$("#button-toggle").click(function(){
			var status = $("#button-toggle").attr("status");
			
			if(status == "tutup"){
				OpenMenu();
			}else{
				CloseMenu();
			}
		});
		
		function OpenMenu(){
			$(".navbar-static-side").attr("style", "margin-left: 0px");
			$("#page-wrapper").attr("style","margin-left: 250px");
			$("#button-toggle").attr("status", "buka");
		}
		
		function CloseMenu(){
			$(".navbar-static-side").attr("style","margin-left: -250px");
			$("#page-wrapper").attr("style","margin-left: 0px");
			$("#button-toggle").attr("status", "tutup");
		}
	</script>
</body>

</html>