<br><br>
<table cellpadding="4" width="100%" style="font-size:11pt; page-break-inside:avoid;text-align: center" >
    <tr>
        <td class="cen">NOTA:  Pasados 3 días hábiles de recibo del material antes relacionado, no aceptamos reclamos por faltantes.</td>
    </tr>
</table>
<br /><br /><br />
<table cellpadding="4" width="100%" style="font-size:9pt; page-break-inside:avoid;text-align: center;" >
    <tr>
        <td style="border: none;">_____________________________________</td>
        <td style="border: none;">_____________________________________</td>
        <td style="border: none;">_____________________________________</td>            
        <td style="border: none;">_____________________________________</td>            
    </tr>
    <tr>
        <td style="border: none;">FIRMA AUTORIZACI&Oacute;N<br></td>
        <td style="border: none;">ENTREG&Oacute; PLANTA</td>
        <td style="border: none;">RECIBI&Oacute<br>DESPACHOS</td>            
        <td style="border: none;">RECIBI&Oacute<br>CLIENTE (Firma y Sello)</td>            
    </tr>
</table>
<br />
</div>
<script src="<?= base_url() ?>dist/jquery/jquery.js"></script>
<script>
    var i;
    var sum;
    for (i = 1; i <= 9; i++) {
        sum = 0;
        $(".d-h-"+i).each(function(){
            sum = sum + parseFloat($(this).val());
        });
        if(sum > 0){
            $(".colL_"+i).text(Math.round(sum * 100) / 100);
        }
        sum = 0;
        $(".u-h-"+i).each(function(){
            sum = sum + parseFloat($(this).val());
        });
        if(sum > 0){
            $(".colR_"+i).text(Math.round(sum * 100) / 100);
        }
    }
</script>