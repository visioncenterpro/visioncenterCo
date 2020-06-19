<div class="col-md-6">
    <div class=" table-wrapper-scroll-y">
        <table id="dispatch_all" class="table table-bordered table-striped table-condensed ">
            <thead>
                <tr>
                    <th colspan="6" style="text-align:center" class="bg-info">REMISIONES DESPACHO</th>
                </tr>
                <tr>
                    <th><button class="btn btn-block btn-success btn-xs btn-all" onclick="AddAll(<?=$id_request_cargo?>)"><span class="fa fa-forward" aria-hidden="true"></span> All</button></th>
                    <th style="text-align:center">CNT</th>
                    <th style="text-align:center">ORDER</th>
                    <th style="text-align:center">CLIENTE</th>
                    <th style="text-align:center">PROYECTO</th>
                    <th style="text-align:center">REPORTE REMISIÓN</th>
                </tr>
            </thead>
            <tbody>
               <?php foreach ($remissions as $key => $value): ?>
                  <tr>
                      <th><button class="btn btn-block btn-success btn-xs btn-all" onclick="AddRemission(<?=$id_request_cargo?>,<?=$value->id_remission?>,<?=$value->id_request_sd?>)"><span class="fa fa-forward" aria-hidden="true"></span></button></th>
                      <th><?=$value->id_remission?></th>
                      <th><?=$value->order?></th>
                      <th><?=$value->client?></th>
                      <th><?=$value->project?></th>
                      <th><button class="btn btn-primary" onclick="pdf_requisition(<?=$value->id_remission?>,<?=$value->id_request_sd?>)"><span class="fa fa-print" aria-hidden="true"></span></button></th>
                  </tr> 
               <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>
<div class="col-md-6">
    <div class=" table-wrapper-scroll-y">
        <table id="dispatch_r" class="table table-bordered table-striped table-condensed ">
            <thead>
                <tr>
                    <th colspan="6" style="text-align:center" class="bg-info">REMISIONES DESPACHO RELACIONADAS</th>
                </tr>
                <tr>
                    <th><button class="btn btn-block btn-danger btn-xs btn-all" onclick="DeleteAll(<?=$id_request_cargo?>)"><span class="fa fa-trash" aria-hidden="true"></span> All</button></th>
                    <th style="text-align:center">CNT</th>
                    <th style="text-align:center">ORDER</th>
                    <th style="text-align:center">CLIENTE</th>
                    <th style="text-align:center">PROYECTO</th>
                    <th style="text-align:center">REPORTE REMISIÓN</th>
                </tr>
            </thead>
            <tbody>
               <?php foreach ($detail as $key => $value): ?>
                   <tr>
                       <th><button class="btn btn-block btn-danger btn-xs btn-all" onclick="delete_remission(<?=$value->id_request_cargue_detail?>,<?=$value->id_remission?>,<?=$value->id_request_sd?>)"><span class="fa fa-trash" aria-hidden="true"></span></button></th>
                       <th style="text-align:center"><?=$value->id_remission?></th>
                       <th style="text-align:center"><?=$value->order?></th>
                       <th style="text-align:center"><?=$value->client?></th>
                       <th style="text-align:center"><?=$value->project?></th>
                       <th><button class="btn btn-primary" onclick="pdf_requisition(<?=$value->id_remission?>,<?=$value->id_request_sd?>)"><span class="fa fa-print" aria-hidden="true"></span></button></th>
                   </tr>
               <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>