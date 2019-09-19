<br />
<table cellpadding="4" width="100%" style="font-size:9pt;text-align: center;" >
    <tbody>
        <tr>
            <td style="border:none">TOTAL PAQUETES</td><td style="border:none"><input type="text" style="border:none" id="total-packs"></td>
            <td style="border:none">PESO TOTAL INTEGRAL</td><td style="border:none"><input type="text" style="border:none" id="total-weight"></td>          
        </tr>
    </tbody>
</table>
<br />
<table cellpadding="4" width="100%" style="font-size:11pt;">
    <tbody>
        <tr>
            <td class="cen">NOTA:  Pasados 3 días hábiles de recibo del material antes relacionado, no aceptamos reclamos por faltantes.</td>
        </tr>
    </tbody>
</table>
<br />
<center>
    <table cellpadding="4" width="90%" style="font-size:10pt;">
        <tbody><tr><td style="border: none;">Observaciones:</td></tr>
            <tr><td><br><br><br><br><br><br><br><br></td></tr>
        </tbody></table>
</center>
<br /><br /><br />
<table cellpadding="4" width="100%" style="font-size:9pt;text-align: center;">
    <tbody>
        <tr>
            <td style="border: none;">_____________________________________</td>
            <td style="border: none;">_____________________________________</td>
            <td style="border: none;">_____________________________________</td>            
        </tr>
        <tr>
            <td style="border: none;">FIRMA AUTORIZACIÓN</td>
            <td style="border: none;">JEFE DESPACHOS</td>
            <td style="border: none;">RICIBIÓ<br>CLIENTE (Firma y Sello)</td>            
        </tr>
    </tbody>
</table>
<br class="no-print"><hr class="no-print" style="border:1px dashed; width:100%;" /><br class="no-print">
<script src="<?=base_url()?>dist/jquery/jquery.js"></script>
<script>
    $(function(){
        var total = 0;
        $(".total-packs").each(function(){
            total = total + parseInt($(this).text());
        });
        $("#total-packs").val(total);
        
        var total = 0;
        $(".total-integral").each(function(){
            total = total + parseInt($(this).text());
        });
        $("#total-weight").val(total);
    })
</script>