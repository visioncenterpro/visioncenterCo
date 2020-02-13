<?php if($val->replaced_supplies == ""){ ?>
    <tr>
        <td><?=$val->code?></td>
        <td><?=$val->name?></td>
        <td style="text-align: center;"><?=$val->quantity?></td>
        <td style="text-align: center;"><?=$packed?></td>
        <td style="text-align: center;"><?=$val->quantity - $packed?></td>
    </tr>
<?php } ?>