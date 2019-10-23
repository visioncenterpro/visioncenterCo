<script>
$(function(){
    $(".qr").each(function () {
        //var id = $(this).attr("id");
        var code = $(this).attr("code");
        jQuery($(this)).qrcode({
//		render	: "table",
		text	: code
	});
    });
}) ;   
</script>

