<table id="tabla" width="100%" class="text-center table table-bordered table-condensed">
    <thead>
        <tr>
            <th width="35" class='text-center'>NUMERO</th>
            <th width="65" class='text-center'>IMPRIMIR</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $count_print = 0;
        $max_print = MAX_NUM_PACK;
        for ($index = 1; $index <= $buttons; $index++) : 
            
        ?>
        <tr>
            <td><?=$index?></td>
            <td><button onclick='Tags("<?=$this->input->post("order")?>",<?=$count_print?>,<?=$max_print?>,this)' class='btn btn-block btn-default btn-xs'><span class='fa fa-print'></span> IMPRIMIR <?=$count_print?>-<?=$max_print?> </button></td></td>
        </tr>
        <?php 
        $count_print += MAX_NUM_PACK;
        $max_print += MAX_NUM_PACK;
        endfor; 
        
        ?>
    </tbody>
</table>