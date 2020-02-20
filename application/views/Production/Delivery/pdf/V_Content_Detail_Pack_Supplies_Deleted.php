
<?= $del ?>
</tbody>
</table>
<br>
<table cellpadding="3" width="100%" style="font-size: 7pt;">
    <thead>
    <tr>
        <td colspan="7" style="text-align: center;font-weight: bold;font-size: 12px;">Reemplazados</td>
    </tr>
    <tr>
        <td style="text-align: center;font-size: 120%;">Referencia (Antiguo)</td>
        <td style="text-align: center;font-size: 120%;">Nombre (Antiguo)</td>
        <td style="text-align: center;font-size: 120%;width: 5%;">Cantidad total (Antiguo)</td>
        <?php print_r($new); ?>
        <td style="text-align: center;font-size: 120%;">Referencia (Nuevo)</td>
        <td style="text-align: center;font-size: 120%;">Nombre (Nuevo)</td>
        <td style="text-align: center;font-size: 120%;width: 5%;">Cantidad total (Nuevo)</td>
        <td style="text-align: center;font-size: 120%;">Observación</td>
    </tr>
    </thead>
    <tbody>
        <?= $rp ?>
    </tbody>
</table>