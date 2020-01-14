<div class="content-wrapper">
    <section class="content">
        <?php print_r($count); ?>
        <input type="hidden" id="count" value="<?=$count?>">
    </section>

</div>
<script type="text/javascript">
	$(document).ready(function(){
		var ct = $("#count").val();
		for (var i = 1; i <= ct; i++) {
			$.post("<?= base_url() ?>Imos/Order/C_Pdf/get_ini_order", {ct:i}, function (data) {
           		console.log(data);
           		if (data.vali == "0") {
           			window.open('<?= base_url() ?>Imos/Order/C_Pdf/ExportLMAT?name='+data.res, '_blank');
           		}
	          
	        }, 'json').fail(function (error) {
	            swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
	        });	
		}
	})
</script>