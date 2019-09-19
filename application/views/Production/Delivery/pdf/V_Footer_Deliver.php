<br pagebreak="true"/>
<table cellpadding="3" width="100%" style="page-break-inside:avoid; page-break-after: always; font-size: 6pt; page-break-inside:avoid;">
    <tr>

        <td width="42%" style="text-align: center; "><b>GRAN TOTAL CANTIDAD SOLICITADA:</b></td>
        <td width="9%" style="text-align: center;"><b class="total"></b></td>
        <td width="4%" style="text-align: center;"><b class="total-1"></b></td>
        <td width="4%" style="text-align: center;"><b class="total-2"></b></td>
        <td width="4%" style="text-align: center;"><b class="total-3"></b></td>
        <td width="4%" style="text-align: center;"><b class="total-4"></b></td>
        <td width="4%" style="text-align: center;"><b class="total-5"></b></td>
        <td width="4%" style="text-align: center;"><b class="total-6"></b></td>
        <td width="4%" style="text-align: center;"><b class="total-7"></b></td>
        <td width="4%" style="text-align: center;"><b class="total-8"></b></td>
        <td width="4%" style="text-align: center;"><b class="total-9"></b></td>
        <td width="4%" style="text-align: center;"><b class="total-10"></b></td>
        <td width="4%" style="text-align: center;"><b class="total-11"></b></td>
        <td width="5%" style="text-align: center;"><b class="Qtotal"></b></td>
    </tr>
</table>
<br/>
<table cellpadding="4" width="100%" style="font-size:11pt; page-break-inside:avoid;">
    <tbody>
        <tr>
            <td class="cen">NOTA:  Pasados 3 días hábiles de recibo del material antes relacionado, no aceptamos reclamos por faltantes.</td>
        </tr>
    </tbody>
</table>
<br />
<center>
    <table cellpadding="4" width="90%" style="font-size:10pt; page-break-inside:avoid;">
        <tbody><tr><td style="border: none;">Estado de Herrajes:</td></tr>
            <tr><td><br><br><br><br><br><br><br><br></td></tr>
        </tbody></table>
</center>
<br /><br /><br />
<table cellpadding="4" width="100%" style="font-size:9pt; page-break-inside:avoid;    text-align: center;">
    <tbody>
        <tr>
            <td style="border: none;">_____________________________________</td>
            <td style="border: none;">_____________________________________</td>
            <td style="border: none;">_____________________________________</td>            
        </tr>
        <tr>
            <td style="border: none;">ENTREGÓ<br>PLANTA</td>
            <td style="border: none;">RICIBIÓ<br>JEFE DESPACHOS</td>
            <td style="border: none;">RICIBIÓ<br>CLIENTE (Firma y Sello)</td>            
        </tr>
    </tbody>
</table>
<script src="<?= base_url() ?>dist/jquery/jquery.js"></script>
<script>
    $(function () {
        var total = 0;
        $(".qty").each(function () {
            total = total + parseInt($(this).text());
        });
        $(".total").text(total);
        
        var total = 0;
        $(".qtyTotal").each(function () {
            total = total + parseInt($(this).text());
        });
        $(".Qtotal").text(total);

        for (var i = 0; i < 12; i++) {
            var total = 0;
            $(".d-" + i).each(function () {
                total = total + parseInt($(this).text());
            });
            if (total > 0) {
                $(".total-" + i).text(total);
            }
        }





    })
</script>