
<script src="<?=base_url()?>dist/jquery/jquery.js"></script>
<script src="<?=base_url()?>dist/JsBarcode/dist/barcodes/JsBarcode.code39.min.js"></script>
<script>
$(function(){
    $(".barcode").each(function () {
        if ($(this).attr("code") != 'null' && $(this).attr("code") != '') {
            JsBarcode("#bar-" + $(this).attr("code"), $(this).attr("code"));
        }
    });
}) ;   
</script>

