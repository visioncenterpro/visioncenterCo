<table id="tabla2" width="100%" class="text-center table table-bordered table-condensed">
    <thead>
        <tr>
            <th width="35" class='text-center'>NUMERO</th>
            <th width="65" class='text-center'>IMPRIMIR</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $count_print = 1;
        $max_print = MAX_NUM_PACK;
        //for ($index = 1; $index <= $buttons; $index++) : 
            
        ?>
        <tr>
            <td><?=$count_print?></td>
            <td><button onclick='Tags2("<?=$this->input->post("order")?>",<?=$count_print?>,<?=$max_print?>,this)' class='btn btn-block btn-default btn-xs'><span class='fa fa-print'></span> IMPRIMIR</button></td></td>
        </tr>
        <?php 
        $count_print += MAX_NUM_PACK;
        $max_print += MAX_NUM_PACK;
        //endfor; 
        
        ?>
    </tbody>
</table>