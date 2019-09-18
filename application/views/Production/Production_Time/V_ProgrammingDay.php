<style>
    .campos2{display: none;}
    .regihours{display: none;}
    .updatehours{display: none;}


</style>
<!--$(".regisday").hide();-->
<div class="content-wrapper">
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-fw fa-clock-o"></i>Programar Dia Producción</h3>
            </div>
            <div class="box-footer">
                <button type="button" class="btn btn-default pull-right regihours" onclick="recorder()">Grabar Programación <i class="fa fa-fw fa-save"></i></button> 
                <button type="button" class="btn btn-default pull-right updatehours" onclick="update()">Actualizar Programación <i class="fa fa-fw fa-refresh"></i></button>
            </div> 
            <div class="box-body">
                <div class="row">
                    <form role="form" id="form" name="form">
                        <div class="col-md-6">
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header with-border">

                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Fecha</label>

                                                <div class="input-group date">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input type="text" class="form-control pull-right required"  onchange="registerday()"id="datepicker" name="datepicker">

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>                   
                        <div class="col-md-9">
                            <div class="box campos2"   id="" name="">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Completar los Campos</h3>
                                </div>

                                <div class="box-body" style=" overflow-y:scroll">
                                    <div class="row">
                                        <div class="col-xs-2 ">
                                            <div class="form-group">
                                                <label> # Maquinas de Corte</label>
                                                <select class="form-control select select-hidden-accessible required " id="machines_corte" name="machines_corte" >
                                                    <option selected="selected" value="" >...</option>
                                                    <option>1</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                    <option>4</option>
                                                    <option>5</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-2 ">
                                            <div class="form-group">
                                                <label># Personas de Corte</label>
                                                <select class="form-control select select-hidden-accessible required " id="people_corte" name="people_corte" >
                                                    <option selected="selected" value="" >...</option>
                                                    <option>1</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                    <option>4</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-8">
                                            <table id="table_hours" class="table table-bordered table-striped table-condensed" >
                                                <tr>
                                                    <td>
                                                        <div class="form-group"><label class="check">
                                                                Turno 1&nbsp;&nbsp;
                                                                <input type="checkbox" name="checktc1" id="checktc1" >
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group"><label class="check">
                                                                Turno 2&nbsp;&nbsp;
                                                                <input type="checkbox" name="checktc2" id="checktc2" 
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group"><label class="check">
                                                                Turno 3&nbsp;&nbsp;
                                                                <input type="checkbox" name="checktc3" id="checktc3" >
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group"><label class="check">
                                                                Turno 4&nbsp;&nbsp;
                                                                <input type="checkbox" name="checktc4" id="checktc4" >
                                                            </label>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>                                                                                                                
                                                        <select class="form-control select select-hidden-accessible" id="hcorte1" name="hcorte1" style="display:none"  >
                                                            <option selected="selected" value="" >...</option>
                                                            <option value="1">1 Hr</option>
                                                            <option value="2">2 Hrs</option>
                                                            <option value="3">3 Hrs</option>
                                                            <option value="4">4 Hrs</option>
                                                            <option value="5">5 Hrs</option>
                                                            <option value="6">6 Hrs</option>
                                                            <option value="7">7 Hrs</option>
                                                            <option value="8">8 Hrs</option>
                                                            <option value="9">9 Hrs</option>
                                                            <option value="10">10 Hrs</option>
                                                            <option value="11">11 Hrs</option>
                                                            <option value="12">12 Hrs</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class="form-control select select-hidden-accessible td" id="hcorte2" name="hcorte2" style="display:none" >
                                                            <option selected="selected" value="" >...</option>
                                                            <option value="1">1 Hr</option>
                                                            <option value="2">2 Hrs</option>
                                                            <option value="3">3 Hrs</option>
                                                            <option value="4">4 Hrs</option>
                                                            <option value="5">5 Hrs</option>
                                                            <option value="6">6 Hrs</option>
                                                            <option value="7">7 Hrs</option>
                                                            <option value="8">8 Hrs</option>
                                                            <option value="9">9 Hrs</option>
                                                            <option value="10">10 Hrs</option>
                                                           <option value="11">11 Hrs</option>
                                                            <option value="12">12 Hrs</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class="form-control select select-hidden-accessible required td" id="hcorte3" name="hcorte3" style="display:none" >
                                                            <option selected="selected" value="" >...</option>
                                                            <option value="1">1 Hr</option>
                                                            <option value="2">2 Hrs</option>
                                                            <option value="3">3 Hrs</option>
                                                            <option value="4">4 Hrs</option>
                                                            <option value="5">5 Hrs</option>
                                                            <option value="6">6 Hrs</option>
                                                            <option value="7">7 Hrs</option>
                                                            <option value="8">8 Hrs</option>
                                                            <option value="9">9 Hrs</option>
                                                            <option value="10">10 Hrs</option>
                                                           <option value="11">11 Hrs</option>
                                                            <option value="12">12 Hrs</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class="form-control select select-hidden-accessible required td" id="hcorte4" name="hcorte4" style="display:none" >
                                                            <option selected="selected" value="" >...</option>
                                                            <option value="1">1 Hr</option>
                                                            <option value="2">2 Hrs</option>
                                                            <option value="3">3 Hrs</option>
                                                            <option value="4">4 Hrs</option>
                                                            <option value="5">5 Hrs</option>
                                                            <option value="6">6 Hrs</option>
                                                            <option value="7">7 Hrs</option>
                                                            <option value="8">8 Hrs</option>
                                                            <option value="9">9 Hrs</option>
                                                            <option value="10">10 Hrs</option>
                                                            <option value="11">11 Hrs</option>
                                                            <option value="12">12 Hrs</option>
                                                        </select>
                                                    </td>

                                                </tr>

                                            </table>

                                        </div>

                                        <div class="col-xs-2 ">
                                            <div class="form-group">
                                                <label> # Maquinas de Enchape</label>
                                                <select class="form-control select select-hidden-accessible required " id="machines_enchape" name="machines_enchape" >
                                                    <option selected="selected" value="" >...</option>
                                                    <option>1</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                    <option>4</option>
                                                    <option>5</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-2 ">
                                            <div class="form-group">
                                                <label># Personas de Enchape</label>
                                                <select class="form-control select select-hidden-accessible required " id="people_enchape" name="people_enchape" name="people_enchape" >
                                                    <option selected="selected" value="" >...</option>
                                                    <option>1</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                    <option>4</option>

                                                </select>
                                            </div>
                                        </div>
                                         <div class="col-xs-8">
                                            <table id="table_hours" class="table table-bordered table-striped table-condensed" >
                                                <tr>
                                                    <td>
                                                        <div class="form-group"><label class="check">
                                                                Turno 1&nbsp;&nbsp;
                                                                <input type="checkbox" name="checkte1" id="checkte1" >
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group"><label class="check">
                                                                Turno 2&nbsp;&nbsp;
                                                                <input type="checkbox" name="checkte2" id="checkte2" 
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group"><label class="check">
                                                                Turno 3&nbsp;&nbsp;
                                                                <input type="checkbox" name="checkte3" id="checkte3" >
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group"><label class="check">
                                                                Turno 4&nbsp;&nbsp;
                                                                <input type="checkbox" name="checkte4" id="checkte4" >
                                                            </label>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>                                                                                                                
                                                        <select class="form-control select select-hidden-accessible" id="henchape1" name="henchape1" style="display:none"  >
                                                            <option selected="selected" value="" >...</option>
                                                            <option value="1">1 Hr</option>
                                                            <option value="2">2 Hrs</option>
                                                            <option value="3">3 Hrs</option>
                                                            <option value="4">4 Hrs</option>
                                                            <option value="5">5 Hrs</option>
                                                            <option value="6">6 Hrs</option>
                                                            <option value="7">7 Hrs</option>
                                                            <option value="8">8 Hrs</option>
                                                            <option value="9">9 Hrs</option>
                                                            <option value="10">10 Hrs</option>
                                                            <option value="11">11 Hrs</option>
                                                            <option value="12">12 Hrs</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class="form-control select select-hidden-accessible td" id="henchape2" name="henchape2" style="display:none" >
                                                            <option selected="selected" value="" >...</option>
                                                            <option value="1">1 Hr</option>
                                                            <option value="2">2 Hrs</option>
                                                            <option value="3">3 Hrs</option>
                                                            <option value="4">4 Hrs</option>
                                                            <option value="5">5 Hrs</option>
                                                            <option value="6">6 Hrs</option>
                                                            <option value="7">7 Hrs</option>
                                                            <option value="8">8 Hrs</option>
                                                            <option value="9">9 Hrs</option>
                                                            <option value="10">10 Hrs</option>
                                                           <option value="11">11 Hrs</option>
                                                            <option value="12">12 Hrs</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class="form-control select select-hidden-accessible required td" id="henchape3" name="henchape3" style="display:none" >
                                                            <option selected="selected" value="" >...</option>
                                                            <option value="1">1 Hr</option>
                                                            <option value="2">2 Hrs</option>
                                                            <option value="3">3 Hrs</option>
                                                            <option value="4">4 Hrs</option>
                                                            <option value="5">5 Hrs</option>
                                                            <option value="6">6 Hrs</option>
                                                            <option value="7">7 Hrs</option>
                                                            <option value="8">8 Hrs</option>
                                                            <option value="9">9 Hrs</option>
                                                            <option value="10">10 Hrs</option>
                                                           <option value="11">11 Hrs</option>
                                                            <option value="12">12 Hrs</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class="form-control select select-hidden-accessible required td" id="henchape4" name="henchape4"style="display:none" >
                                                            <option selected="selected" value="" >...</option>
                                                            <option value="1">1 Hr</option>
                                                            <option value="2">2 Hrs</option>
                                                            <option value="3">3 Hrs</option>
                                                            <option value="4">4 Hrs</option>
                                                            <option value="5">5 Hrs</option>
                                                            <option value="6">6 Hrs</option>
                                                            <option value="7">7 Hrs</option>
                                                            <option value="8">8 Hrs</option>
                                                            <option value="9">9 Hrs</option>
                                                            <option value="10">10 Hrs</option>
                                                            <option value="11">11 Hrs</option>
                                                            <option value="12">12 Hrs</option>
                                                        </select>
                                                    </td>

                                                </tr>

                                            </table>

                                        </div> 
<!--                                        <div class="col-xs-3 ">
                                            <div class="form-group">
                                                <label># Turnos de Enchape </label>
                                                <select class="form-control select select-hidden-accessible required " id="turns_enchape" name="turns_enchape" >
                                                    <option selected="selected" value="" >...</option>
                                                    <option>1</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                    <option>4</option>
                                                </select>
                                            </div>
                                        </div>-->

                                        <br><br><br>
                                        <div class="col-xs-2 ">
                                            <div class="form-group">
                                                <label> # Maq de Maquinado</label>
                                                <select class="form-control select select-hidden-accessible required " id="machines_maquinado" name="machines_maquinado" >
                                                    <option selected="selected" value="" >...</option>
                                                    <option>1</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                    <option>4</option>
                                                    <option>5</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-2 ">
                                            <div class="form-group">
                                                <label># Pers de Maquinado</label>
                                                <select class="form-control select select-hidden-accessible required " id="people_maquinado" name="people_maquinado" >
                                                    <option selected="selected" value="" >...</option>
                                                    <option>1</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                    <option>4</option>

                                                </select>
                                            </div>
                                        </div>
                                         <div class="col-xs-8">
                                            <table id="table_hours" class="table table-bordered table-striped table-condensed" >
                                                <tr>
                                                    <td>
                                                        <div class="form-group"><label class="check">
                                                                Turno 1&nbsp;&nbsp;
                                                                <input type="checkbox" name="checktmq" id="checktmq" >
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group"><label class="check">
                                                                Turno 2&nbsp;&nbsp;
                                                                <input type="checkbox" name="checktmq1" id="checktmq1" 
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group"><label class="check">
                                                                Turno 3&nbsp;&nbsp;
                                                                <input type="checkbox" name="checktmq2" id="checktmq2" >
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group"><label class="check">
                                                                Turno 4&nbsp;&nbsp;
                                                                <input type="checkbox" name="checktmq4" id="checktmq4" >
                                                            </label>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>                                                                                                                
                                                        <select class="form-control select select-hidden-accessible" id="hmq1" name="hmq1" style="display:none"  >
                                                            <option selected="selected" value="" >...</option>
                                                            <option value="1">1 Hr</option>
                                                            <option value="2">2 Hrs</option>
                                                            <option value="3">3 Hrs</option>
                                                            <option value="4">4 Hrs</option>
                                                            <option value="5">5 Hrs</option>
                                                            <option value="6">6 Hrs</option>
                                                            <option value="7">7 Hrs</option>
                                                            <option value="8">8 Hrs</option>
                                                            <option value="9">9 Hrs</option>
                                                            <option value="10">10 Hrs</option>
                                                            <option value="11">11 Hrs</option>
                                                            <option value="12">12 Hrs</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class="form-control select select-hidden-accessible td" id="hmq2" name="hmq2"style="display:none" >
                                                            <option selected="selected" value="" >...</option>
                                                            <option value="1">1 Hr</option>
                                                            <option value="2">2 Hrs</option>
                                                            <option value="3">3 Hrs</option>
                                                            <option value="4">4 Hrs</option>
                                                            <option value="5">5 Hrs</option>
                                                            <option value="6">6 Hrs</option>
                                                            <option value="7">7 Hrs</option>
                                                            <option value="8">8 Hrs</option>
                                                            <option value="9">9 Hrs</option>
                                                            <option value="10">10 Hrs</option>
                                                           <option value="11">11 Hrs</option>
                                                            <option value="12">12 Hrs</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class="form-control select select-hidden-accessible required td" id="hmq3" name="hmq3" style="display:none" >
                                                            <option selected="selected" value="" >...</option>
                                                            <option value="1">1 Hr</option>
                                                            <option value="2">2 Hrs</option>
                                                            <option value="3">3 Hrs</option>
                                                            <option value="4">4 Hrs</option>
                                                            <option value="5">5 Hrs</option>
                                                            <option value="6">6 Hrs</option>
                                                            <option value="7">7 Hrs</option>
                                                            <option value="8">8 Hrs</option>
                                                            <option value="9">9 Hrs</option>
                                                            <option value="10">10 Hrs</option>
                                                           <option value="11">11 Hrs</option>
                                                            <option value="12">12 Hrs</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class="form-control select select-hidden-accessible required td" id="hmq4" name="hmq4" style="display:none" >
                                                            <option selected="selected" value="" >...</option>
                                                            <option value="1">1 Hr</option>
                                                            <option value="2">2 Hrs</option>
                                                            <option value="3">3 Hrs</option>
                                                            <option value="4">4 Hrs</option>
                                                            <option value="5">5 Hrs</option>
                                                            <option value="6">6 Hrs</option>
                                                            <option value="7">7 Hrs</option>
                                                            <option value="8">8 Hrs</option>
                                                            <option value="9">9 Hrs</option>
                                                            <option value="10">10 Hrs</option>
                                                            <option value="11">11 Hrs</option>
                                                            <option value="12">12 Hrs</option>
                                                        </select>
                                                    </td>

                                                </tr>

                                            </table>

                                        </div>
<!--                                       <div class="col-xs-3 ">
                                            <div class="form-group">
                                                <label># Turnos de Maquinado </label>
                                                <select class="form-control select select-hidden-accessible required " id="turns_maquinado" name="turns_maquinado" >
                                                    <option selected="selected" value="" >...</option>
                                                    <option>1</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                    <option>4</option>
                                                </select>
                                            </div>
                                        </div>-->

                                        <br><br><br><br>
                                        <div class="col-xs-2 ">
                                            <div class="form-group">
                                                <label> # Maquinas de Rta</label>
                                                <select class="form-control select select-hidden-accessible required " id="machines_rta" name="machines_rta" >
                                                    <option selected="selected" value="" >...</option>
                                                    <option>1</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                    <option>4</option>
                                                    <option>5</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-2 ">
                                            <div class="form-group">
                                                <label># Personas de Rta</label>
                                                <select class="form-control select select-hidden-accessible required " id="people_rta" name="people_rta" >
                                                    <option selected="selected" value="" >...</option>
                                                    <option>1</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                    <option>4</option>

                                                </select>
                                            </div>
                                        </div>
                                         <div class="col-xs-8">
                                            <table id="table_hours" class="table table-bordered table-striped table-condensed" >
                                                <tr>
                                                    <td>
                                                        <div class="form-group"><label class="check">
                                                                Turno 1&nbsp;&nbsp;
                                                                <input type="checkbox" name="checktrta" id="checktrta" >
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group"><label class="check">
                                                                Turno 2&nbsp;&nbsp;
                                                                <input type="checkbox" name="checktrta1" id="checktrta1" 
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group"><label class="check">
                                                                Turno 3&nbsp;&nbsp;
                                                                <input type="checkbox" name="checktrta2" id="checktrta2" >
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group"><label class="check">
                                                                Turno 4&nbsp;&nbsp;
                                                                <input type="checkbox" name="checktrta4" id="checktrta4" >
                                                            </label>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>                                                                                                                
                                                        <select class="form-control select select-hidden-accessible" id="hrta1" name="hrta1" style="display:none"  >
                                                            <option selected="selected" value="" >...</option>
                                                            <option value="1">1 Hr</option>
                                                            <option value="2">2 Hrs</option>
                                                            <option value="3">3 Hrs</option>
                                                            <option value="4">4 Hrs</option>
                                                            <option value="5">5 Hrs</option>
                                                            <option value="6">6 Hrs</option>
                                                            <option value="7">7 Hrs</option>
                                                            <option value="8">8 Hrs</option>
                                                            <option value="9">9 Hrs</option>
                                                            <option value="10">10 Hrs</option>
                                                            <option value="11">11 Hrs</option>
                                                            <option value="12">12 Hrs</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class="form-control select select-hidden-accessible td" id="hrta2" name="hrta2" style="display:none" >
                                                            <option selected="selected" value="" >...</option>
                                                            <option value="1">1 Hr</option>
                                                            <option value="2">2 Hrs</option>
                                                            <option value="3">3 Hrs</option>
                                                            <option value="4">4 Hrs</option>
                                                            <option value="5">5 Hrs</option>
                                                            <option value="6">6 Hrs</option>
                                                            <option value="7">7 Hrs</option>
                                                            <option value="8">8 Hrs</option>
                                                            <option value="9">9 Hrs</option>
                                                            <option value="10">10 Hrs</option>
                                                           <option value="11">11 Hrs</option>
                                                            <option value="12">12 Hrs</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class="form-control select select-hidden-accessible required td" id="hrta3" name="hrta3"  style="display:none" >
                                                            <option selected="selected" value="" >...</option>
                                                            <option value="1">1 Hr</option>
                                                            <option value="2">2 Hrs</option>
                                                            <option value="3">3 Hrs</option>
                                                            <option value="4">4 Hrs</option>
                                                            <option value="5">5 Hrs</option>
                                                            <option value="6">6 Hrs</option>
                                                            <option value="7">7 Hrs</option>
                                                            <option value="8">8 Hrs</option>
                                                            <option value="9">9 Hrs</option>
                                                            <option value="10">10 Hrs</option>
                                                           <option value="11">11 Hrs</option>
                                                            <option value="12">12 Hrs</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class="form-control select select-hidden-accessible required td" id="hrta4" name="hrta4" style="display:none" >
                                                            <option selected="selected" value="" >...</option>
                                                            <option value="1">1 Hr</option>
                                                            <option value="2">2 Hrs</option>
                                                            <option value="3">3 Hrs</option>
                                                            <option value="4">4 Hrs</option>
                                                            <option value="5">5 Hrs</option>
                                                            <option value="6">6 Hrs</option>
                                                            <option value="7">7 Hrs</option>
                                                            <option value="8">8 Hrs</option>
                                                            <option value="9">9 Hrs</option>
                                                            <option value="10">10 Hrs</option>
                                                            <option value="11">11 Hrs</option>
                                                            <option value="12">12 Hrs</option>
                                                        </select>
                                                    </td>

                                                </tr>

                                            </table>

                                        </div>
<!--                                        <div class="col-xs-3 ">
                                            <div class="form-group">
                                                <label># Turnos de Rta </label>
                                                <select class="form-control select select-hidden-accessible required " id="turns_rta" name="turns_rta" >
                                                    <option selected="selected" value="" >...</option>
                                                    <option>1</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                    <option>4</option>
                                                </select>
                                            </div>
                                        </div>-->

                                        <br><br><br><br>
                                        <div class="col-xs-2 ">
                                            <div class="form-group">
                                                <label> # Maquinas de Marcos</label>
                                                <select class="form-control select select-hidden-accessible required " id="machines_marcos" name="machines_marcos" >
                                                    <option selected="selected" value="" >...</option>
                                                    <option>1</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                    <option>4</option>
                                                    <option>5</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-2 ">
                                            <div class="form-group">
                                                <label># Personas de Marcos</label>
                                                <select class="form-control select select-hidden-accessible required " id="people_marcos" name="people_marcos" >
                                                    <option selected="selected" value="" >...</option>
                                                    <option>1</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                    <option>4</option>

                                                </select>
                                            </div>
                                        </div>
                                         <div class="col-xs-8">
                                            <table id="table_hours" class="table table-bordered table-striped table-condensed" >
                                                <tr>
                                                    <td>
                                                        <div class="form-group"><label class="check">
                                                                Turno 1&nbsp;&nbsp;
                                                                <input type="checkbox" name="checktmc" id="checktmc" >
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group"><label class="check">
                                                                Turno 2&nbsp;&nbsp;
                                                                <input type="checkbox" name="checktmc1" id="checktmc1" 
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group"><label class="check">
                                                                Turno 3&nbsp;&nbsp;
                                                                <input type="checkbox" name="checktmc2" id="checktmc2" >
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group"><label class="check">
                                                                Turno 4&nbsp;&nbsp;
                                                                <input type="checkbox" name="checktmc4" id="checktmc4" >
                                                            </label>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>                                                                                                                
                                                        <select class="form-control select select-hidden-accessible" id="hmc1" name="hmc1" style="display:none"  >
                                                            <option selected="selected" value="" >...</option>
                                                            <option value="1">1 Hr</option>
                                                            <option value="2">2 Hrs</option>
                                                            <option value="3">3 Hrs</option>
                                                            <option value="4">4 Hrs</option>
                                                            <option value="5">5 Hrs</option>
                                                            <option value="6">6 Hrs</option>
                                                            <option value="7">7 Hrs</option>
                                                            <option value="8">8 Hrs</option>
                                                            <option value="9">9 Hrs</option>
                                                            <option value="10">10 Hrs</option>
                                                            <option value="11">11 Hrs</option>
                                                            <option value="12">12 Hrs</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class="form-control select select-hidden-accessible td" id="hmc2" name="hmc2" style="display:none" >
                                                            <option selected="selected" value="" >...</option>
                                                            <option value="1">1 Hr</option>
                                                            <option value="2">2 Hrs</option>
                                                            <option value="3">3 Hrs</option>
                                                            <option value="4">4 Hrs</option>
                                                            <option value="5">5 Hrs</option>
                                                            <option value="6">6 Hrs</option>
                                                            <option value="7">7 Hrs</option>
                                                            <option value="8">8 Hrs</option>
                                                            <option value="9">9 Hrs</option>
                                                            <option value="10">10 Hrs</option>
                                                           <option value="11">11 Hrs</option>
                                                            <option value="12">12 Hrs</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class="form-control select select-hidden-accessible required td" id="hmc3" name="hmc3" style="display:none" >
                                                            <option selected="selected" value="" >...</option>
                                                            <option value="1">1 Hr</option>
                                                            <option value="2">2 Hrs</option>
                                                            <option value="3">3 Hrs</option>
                                                            <option value="4">4 Hrs</option>
                                                            <option value="5">5 Hrs</option>
                                                            <option value="6">6 Hrs</option>
                                                            <option value="7">7 Hrs</option>
                                                            <option value="8">8 Hrs</option>
                                                            <option value="9">9 Hrs</option>
                                                            <option value="10">10 Hrs</option>
                                                           <option value="11">11 Hrs</option>
                                                            <option value="12">12 Hrs</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class="form-control select select-hidden-accessible required td" id="hmc4" name="hmc4" style="display:none" >
                                                            <option selected="selected" value="" >...</option>
                                                            <option value="1">1 Hr</option>
                                                            <option value="2">2 Hrs</option>
                                                            <option value="3">3 Hrs</option>
                                                            <option value="4">4 Hrs</option>
                                                            <option value="5">5 Hrs</option>
                                                            <option value="6">6 Hrs</option>
                                                            <option value="7">7 Hrs</option>
                                                            <option value="8">8 Hrs</option>
                                                            <option value="9">9 Hrs</option>
                                                            <option value="10">10 Hrs</option>
                                                            <option value="11">11 Hrs</option>
                                                            <option value="12">12 Hrs</option>
                                                        </select>
                                                    </td>

                                                </tr>

                                            </table>

                                        </div>
<!--                                        <div class="col-xs-3 ">
                                            <div class="form-group">
                                                <label># Turnos de Marcos </label>
                                                <select class="form-control select select-hidden-accessible required " id="turns_marcos" name="turns_marcos" >
                                                    <option selected="selected" value="" >...</option>
                                                    <option>1</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                    <option>4</option>
                                                </select>
                                            </div>
                                        </div>-->

                                        <br><br><br><br>
                                        <div class="col-xs-2 ">
                                            <div class="form-group">
                                                <label> # Maquinas de Repizas</label>
                                                <select class="form-control select select-hidden-accessible required " id="machines_repizas" name="machines_repizas" >
                                                    <option selected="selected" value="" >...</option>
                                                    <option>1</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                    <option>4</option>
                                                    <option>5</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-2 ">
                                            <div class="form-group">
                                                <label># Personas de Repizas</label>
                                                <select class="form-control select select-hidden-accessible required " id="people_repizas" name="people_repizas" >
                                                    <option selected="selected" value="" >...</option>
                                                    <option>1</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                    <option>4</option>

                                                </select>
                                            </div>
                                        </div>
                                         <div class="col-xs-8">
                                            <table id="table_hours" class="table table-bordered table-striped table-condensed" >
                                                <tr>
                                                    <td>
                                                        <div class="form-group"><label class="check">
                                                                Turno 1&nbsp;&nbsp;
                                                                <input type="checkbox" name="checktrpz" id="checktrpz" >
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group"><label class="check">
                                                                Turno 2&nbsp;&nbsp;
                                                                <input type="checkbox" name="checktrpz1" id="checktrpz1" 
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group"><label class="check">
                                                                Turno 3&nbsp;&nbsp;
                                                                <input type="checkbox" name="checktrpz2" id="checktrpz2" >
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group"><label class="check">
                                                                Turno 4&nbsp;&nbsp;
                                                                <input type="checkbox" name="checktrpz4" id="checktrpz4" >
                                                            </label>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>                                                                                                                
                                                        <select class="form-control select select-hidden-accessible" id="hrpz1" name="hrpz1" style="display:none"  >
                                                            <option selected="selected" value="" >...</option>
                                                            <option value="1">1 Hr</option>
                                                            <option value="2">2 Hrs</option>
                                                            <option value="3">3 Hrs</option>
                                                            <option value="4">4 Hrs</option>
                                                            <option value="5">5 Hrs</option>
                                                            <option value="6">6 Hrs</option>
                                                            <option value="7">7 Hrs</option>
                                                            <option value="8">8 Hrs</option>
                                                            <option value="9">9 Hrs</option>
                                                            <option value="10">10 Hrs</option>
                                                            <option value="11">11 Hrs</option>
                                                            <option value="12">12 Hrs</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class="form-control select select-hidden-accessible td" id="hrpz2" name="hrpz2" style="display:none" >
                                                            <option selected="selected" value="" >...</option>
                                                            <option value="1">1 Hr</option>
                                                            <option value="2">2 Hrs</option>
                                                            <option value="3">3 Hrs</option>
                                                            <option value="4">4 Hrs</option>
                                                            <option value="5">5 Hrs</option>
                                                            <option value="6">6 Hrs</option>
                                                            <option value="7">7 Hrs</option>
                                                            <option value="8">8 Hrs</option>
                                                            <option value="9">9 Hrs</option>
                                                            <option value="10">10 Hrs</option>
                                                           <option value="11">11 Hrs</option>
                                                            <option value="12">12 Hrs</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class="form-control select select-hidden-accessible required td" id="hrpz3" name="hrpz3" style="display:none" >
                                                            <option selected="selected" value="" >...</option>
                                                            <option value="1">1 Hr</option>
                                                            <option value="2">2 Hrs</option>
                                                            <option value="3">3 Hrs</option>
                                                            <option value="4">4 Hrs</option>
                                                            <option value="5">5 Hrs</option>
                                                            <option value="6">6 Hrs</option>
                                                            <option value="7">7 Hrs</option>
                                                            <option value="8">8 Hrs</option>
                                                            <option value="9">9 Hrs</option>
                                                            <option value="10">10 Hrs</option>
                                                           <option value="11">11 Hrs</option>
                                                            <option value="12">12 Hrs</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class="form-control select select-hidden-accessible required td" id="hrpz4" name="hrpz4" style="display:none" >
                                                            <option selected="selected" value="" >...</option>
                                                            <option value="1">1 Hr</option>
                                                            <option value="2">2 Hrs</option>
                                                            <option value="3">3 Hrs</option>
                                                            <option value="4">4 Hrs</option>
                                                            <option value="5">5 Hrs</option>
                                                            <option value="6">6 Hrs</option>
                                                            <option value="7">7 Hrs</option>
                                                            <option value="8">8 Hrs</option>
                                                            <option value="9">9 Hrs</option>
                                                            <option value="10">10 Hrs</option>
                                                            <option value="11">11 Hrs</option>
                                                            <option value="12">12 Hrs</option>
                                                        </select>
                                                    </td>

                                                </tr>

                                            </table>

                                        </div>
<!--                                        <div class="col-xs-3 ">
                                            <div class="form-group">
                                                <label># Turnos de Repizas </label>
                                                <select class="form-control select select-hidden-accessible required " id="turns_repizas" name="turns_repizas" >
                                                    <option selected="selected" value="" >...</option>
                                                    <option>1</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                    <option>4</option>
                                                </select>
                                            </div>
                                        </div>-->

                                        <br><br><br><br>
                                        <div class="col-xs-2 ">
                                            <div class="form-group">
                                                <label> # Maquinas de Puertas</label>
                                                <select class="form-control select select-hidden-accessible required " id="machines_puertas" name="machines_puertas" >
                                                    <option selected="selected" value="" >...</option>
                                                    <option>1</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                    <option>4</option>
                                                    <option>5</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-2 ">
                                            <div class="form-group">
                                                <label># Personas de Puertas</label>
                                                <select class="form-control select select-hidden-accessible required " id="people_puertas" name="people_puertas" >
                                                    <option selected="selected" value="" >...</option>
                                                    <option>1</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                    <option>4</option>

                                                </select>
                                            </div>
                                        </div>
                                         <div class="col-xs-8">
                                            <table id="table_hours" class="table table-bordered table-striped table-condensed" >
                                                <tr>
                                                    <td>
                                                        <div class="form-group"><label class="check">
                                                                Turno 1&nbsp;&nbsp;
                                                                <input type="checkbox" name="checktpt" id="checktpt" >
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group"><label class="check">
                                                                Turno 2&nbsp;&nbsp;
                                                                <input type="checkbox" name="checktpt1" id="checktpt1" 
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group"><label class="check">
                                                                Turno 3&nbsp;&nbsp;
                                                                <input type="checkbox" name="checktpt2" id="checktpt2" >
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group"><label class="check">
                                                                Turno 4&nbsp;&nbsp;
                                                                <input type="checkbox" name="checktpt4" id="checktpt4" >
                                                            </label>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>                                                                                                                
                                                        <select class="form-control select select-hidden-accessible" id="hpt1" name="hpt1" style="display:none"  >
                                                            <option selected="selected" value="" >...</option>
                                                            <option value="1">1 Hr</option>
                                                            <option value="2">2 Hrs</option>
                                                            <option value="3">3 Hrs</option>
                                                            <option value="4">4 Hrs</option>
                                                            <option value="5">5 Hrs</option>
                                                            <option value="6">6 Hrs</option>
                                                            <option value="7">7 Hrs</option>
                                                            <option value="8">8 Hrs</option>
                                                            <option value="9">9 Hrs</option>
                                                            <option value="10">10 Hrs</option>
                                                            <option value="11">11 Hrs</option>
                                                            <option value="12">12 Hrs</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class="form-control select select-hidden-accessible td" id="hpt2" name="hpt2" style="display:none" >
                                                            <option selected="selected" value="" >...</option>
                                                            <option value="1">1 Hr</option>
                                                            <option value="2">2 Hrs</option>
                                                            <option value="3">3 Hrs</option>
                                                            <option value="4">4 Hrs</option>
                                                            <option value="5">5 Hrs</option>
                                                            <option value="6">6 Hrs</option>
                                                            <option value="7">7 Hrs</option>
                                                            <option value="8">8 Hrs</option>
                                                            <option value="9">9 Hrs</option>
                                                            <option value="10">10 Hrs</option>
                                                           <option value="11">11 Hrs</option>
                                                            <option value="12">12 Hrs</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class="form-control select select-hidden-accessible required td" id="hpt3" name="hpt3" style="display:none" >
                                                            <option selected="selected" value="" >...</option>
                                                            <option value="1">1 Hr</option>
                                                            <option value="2">2 Hrs</option>
                                                            <option value="3">3 Hrs</option>
                                                            <option value="4">4 Hrs</option>
                                                            <option value="5">5 Hrs</option>
                                                            <option value="6">6 Hrs</option>
                                                            <option value="7">7 Hrs</option>
                                                            <option value="8">8 Hrs</option>
                                                            <option value="9">9 Hrs</option>
                                                            <option value="10">10 Hrs</option>
                                                           <option value="11">11 Hrs</option>
                                                            <option value="12">12 Hrs</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class="form-control select select-hidden-accessible required td" id="hpt4" name="hpt4" style="display:none" >
                                                            <option selected="selected" value="" >...</option>
                                                            <option value="1">1 Hr</option>
                                                            <option value="2">2 Hrs</option>
                                                            <option value="3">3 Hrs</option>
                                                            <option value="4">4 Hrs</option>
                                                            <option value="5">5 Hrs</option>
                                                            <option value="6">6 Hrs</option>
                                                            <option value="7">7 Hrs</option>
                                                            <option value="8">8 Hrs</option>
                                                            <option value="9">9 Hrs</option>
                                                            <option value="10">10 Hrs</option>
                                                            <option value="11">11 Hrs</option>
                                                            <option value="12">12 Hrs</option>
                                                        </select>
                                                    </td>

                                                </tr>

                                            </table>

                                        </div>
<!--                                        <div class="col-xs-3 ">
                                            <div class="form-group">
                                                <label># Turnos de Puertas </label>
                                                <select class="form-control select select-hidden-accessible required " id="turns_puertas" name="turns_puertas" >
                                                    <option selected="selected" value="" >...</option>
                                                    <option>1</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                    <option>4</option>
                                                </select>
                                            </div>
                                        </div>-->

                                    </div>
                                </div>

                            </div>

                        </div>
                    </form>

                </div>
                <br><br>

            </div>

        </div>
    </section>
</div>

<script>

    $(function () {

        //Initialize Select2 Elements
        $(".select2").select2();
        $('.timepicker').timepicker({
            showInputs: false,
            maxHours: 24,
            showSeconds: false,
            showMeridian: false



        })
        //datepicker
        var fecha = new Date();
        var dias = 3; // Número de días a agregar
        fecha.setDate(fecha.getDate());
        $("#datepicker").datepicker({
            format: "mm/dd/yyyy",
            //startDate: fecha
        });


        $('.check').iCheck({
            checkboxClass: 'icheckbox_minimal-red'
        }).on('ifChanged', function (e) {
            if ($('#checktc1').prop('checked')) {
                document.getElementById('hcorte1').style.display = "block";
            } else {
                document.getElementById('hcorte1').style.display = "none";
                $("#hcorte1").val("")
            }
            if ($('#checktc2').prop('checked')) {
                document.getElementById('hcorte2').style.display = "block";
            } else {
                document.getElementById('hcorte2').style.display = "none";
                $("#hcorte2").val("")
            }
              if ($('#checktc3').prop('checked')) {
               document.getElementById('hcorte3').style.display = "block";
            } else {
                document.getElementById('hcorte3').style.display = "none";
                $("#hcorte3").val("")
            }
              if ($('#checktc4').prop('checked')) {
               document.getElementById('hcorte4').style.display = "block";
            } else {
                document.getElementById('hcorte4').style.display = "none";
                $("#hcorte4").val("")
            }
         /*icheck enchape*/ 
         if ($('#checkte1').prop('checked')) {
                document.getElementById('henchape1').style.display = "block";
            } else {
                document.getElementById('henchape1').style.display = "none";
                $("#henchape1").val("")
            }
            if ($('#checkte2').prop('checked')) {
                document.getElementById('henchape2').style.display = "block";
            } else {
                document.getElementById('henchape2').style.display = "none";
                $("#henchape2").val("")
            }
              if ($('#checkte3').prop('checked')) {
               document.getElementById('henchape3').style.display = "block";
            } else {
                document.getElementById('henchape3').style.display = "none";
                $("#henchape3").val("")
            }
              if ($('#checkte4').prop('checked')) {
               document.getElementById('henchape4').style.display = "block";
            } else {
                document.getElementById('henchape4').style.display = "none";
                $("#henchape4").val("")
            }
         /*icheck maquinado*/ 
         if ($('#checktmq').prop('checked')) {
                document.getElementById('hmq1').style.display = "block";
            } else {
                document.getElementById('hmq1').style.display = "none";
                $("#henchape1").val("")
            }
            if ($('#checktmq1').prop('checked')) {
                document.getElementById('hmq2').style.display = "block";
            } else {
                document.getElementById('hmq2').style.display = "none";
                $("#hmq2").val("")
            }
              if ($('#checktmq2').prop('checked')) {
               document.getElementById('hmq3').style.display = "block";
            } else {
                document.getElementById('hmq3').style.display = "none";
                $("#hmq3").val("")
            }
              if ($('#checktmq4').prop('checked')) {
               document.getElementById('hmq4').style.display = "block";
            } else {
                document.getElementById('hmq4').style.display = "none";
                $("#hmq4").val("")
            }
         /*icheck rta*/ 
         if ($('#checktrta').prop('checked')) {
                document.getElementById('hrta1').style.display = "block";
            } else {
                document.getElementById('hrta1').style.display = "none";
                $("#hrta1").val("")
            }
            if ($('#checktrta1').prop('checked')) {
                document.getElementById('hrta2').style.display = "block";
            } else {
                document.getElementById('hrta2').style.display = "none";
                $("#hrta2").val("")
            }
              if ($('#checktrta2').prop('checked')) {
               document.getElementById('hrta3').style.display = "block";
            } else {
                document.getElementById('hrta3').style.display = "none";
                $("#hrta3").val("")
            }
              if ($('#checktrta4').prop('checked')) {
               document.getElementById('hrta4').style.display = "block";
            } else {
                document.getElementById('hrta4').style.display = "none";
                $("#hrta4").val("")
            }
         
          /*icheck marcos*/ 
         if ($('#checktmc').prop('checked')) {
                document.getElementById('hmc1').style.display = "block";
            } else {
                document.getElementById('hmc1').style.display = "none";
                $("#hmc1").val("")
            }
            if ($('#checktmc1').prop('checked')) {
                document.getElementById('hmc2').style.display = "block";
            } else {
                document.getElementById('hmc2').style.display = "none";
                $("#hmc2").val("")
            }
              if ($('#checktmc2').prop('checked')) {
               document.getElementById('hmc3').style.display = "block";
            } else {
                document.getElementById('hmc3').style.display = "none";
                $("#hmc3").val("")
            }
              if ($('#checktmc4').prop('checked')) {
               document.getElementById('hmc4').style.display = "block";
            } else {
                document.getElementById('hmc4').style.display = "none";
                $("#hmc4").val("")
            }
            /*icheck marcos*/ 
         if ($('#checktmc').prop('checked')) {
                document.getElementById('hmc1').style.display = "block";
            } else {
                document.getElementById('hmc1').style.display = "none";
                $("#hmc1").val("")
            }
            if ($('#checktmc1').prop('checked')) {
                document.getElementById('hmc2').style.display = "block";
            } else {
                document.getElementById('hmc2').style.display = "none";
                $("#hmc2").val("")
            }
              if ($('#checktmc2').prop('checked')) {
               document.getElementById('hmc3').style.display = "block";
            } else {
                document.getElementById('hmc3').style.display = "none";
                $("#hmc3").val("")
            }
              if ($('#checktmc4').prop('checked')) {
               document.getElementById('hmc4').style.display = "block";
            } else {
                document.getElementById('hmc4').style.display = "none";
                $("#hmc4").val("")
            }
          /*icheck repizas*/ 
         if ($('#checktrpz').prop('checked')) {
                document.getElementById('hrpz1').style.display = "block";
            } else {
                document.getElementById('hrpz1').style.display = "none";
                $("#hrpz1").val("")
            }
            if ($('#checktrpz1').prop('checked')) {
                document.getElementById('hrpz2').style.display = "block";
            } else {
                document.getElementById('hrpz2').style.display = "none";
                $("#hrpz2").val("")
            }
              if ($('#checktrpz2').prop('checked')) {
               document.getElementById('hrpz3').style.display = "block";
            } else {
                document.getElementById('hrpz3').style.display = "none";
                $("#hrpz3").val("")
            }
              if ($('#checktrpz4').prop('checked')) {
               document.getElementById('hrpz4').style.display = "block";
            } else {
                document.getElementById('hrpz4').style.display = "none";
                $("#hrpz4").val("")
            }
            
            /*icheck puertas*/ 
         if ($('#checktpt').prop('checked')) {
                document.getElementById('hpt1').style.display = "block";
            } else {
                document.getElementById('hpt1').style.display = "none";
                $("#hpt1").val("")
            }
            if ($('#checktpt1').prop('checked')) {
                document.getElementById('hpt2').style.display = "block";
            } else {
                document.getElementById('hpt2').style.display = "none";
                $("#hpt2").val("")
            }
              if ($('#checktpt2').prop('checked')) {
               document.getElementById('hpt3').style.display = "block";
            } else {
                document.getElementById('hpt3').style.display = "none";
                $("#hpt3").val("")
            }
              if ($('#checktpt4').prop('checked')) {
               document.getElementById('hpt4').style.display = "block";
            } else {
                document.getElementById('hpt4').style.display = "none";
                $("#hpt4").val("")
            }


        })


    })

</script>
<script>


    function registerday() {
        var dayOpen = $("#datepicker").val();
        $.post("<?= base_url() ?>Production/Production_Time/C_ProgrammingDay/valideprogrammingday", {dayOpen: dayOpen}, function (data) {

            if (data.res != null) {
                $(".updatehours").show();
                $(".regihours").hide();
                $("#machines_corte").val(data.res.machines_corte);
                $("#people_corte").val(data.res.people_corte);
                $("#turns_corte").val(data.res.turns_corte);

                $("#machines_enchape").val(data.res.machines_enchape);
                $("#people_enchape").val(data.res.people_enchape);
                $("#turns_enchape").val(data.res.turns_enchape);

                $("#machines_maquinado").val(data.res.machines_maquinado);
                $("#people_maquinado").val(data.res.people_maquinado);
                $("#turns_maquinado").val(data.res.turns_maquinado);

                $("#machines_rta").val(data.res.machines_rta);
                $("#people_rta").val(data.res.people_rta);
                $("#turns_rta").val(data.res.turns_rta);

                $("#machines_marcos").val(data.res.machines_marcos);
                $("#people_marcos").val(data.res.people_marcos);
                $("#turns_marcos").val(data.res.turns_marcos);

                $("#machines_repizas").val(data.res.machines_repizas);
                $("#people_repizas").val(data.res.people_repizas);
                $("#turns_repizas").val(data.res.turns_repizas);

                $("#machines_puertas").val(data.res.machines_puertas);
                $("#people_puertas").val(data.res.people_puertas);
                $("#turns_puertas").val(data.res.turns_puertas);



            } else {
                $(".regihours").show();
                $(".updatehours").hide();
                $("#machines_corte").val("");
                $("#people_corte").val("");
                $("#turns_corte").val("");
                $("#machines_enchape").val("");
                $("#people_enchape").val("");
                $("#turns_enchape").val("");
                $("#machines_maquinado").val("");
                $("#people_maquinado").val("");
                $("#turns_maquinado").val("");
                $("#machines_rta").val("");
                $("#people_rta").val("");
                $("#turns_rta").val("");
                $("#machines_marcos").val("");
                $("#people_marcos").val("");
                $("#turns_marcos").val("");
                $("#machines_repizas").val("");
                $("#people_repizas").val("");
                $("#turns_repizas").val("");
                $("#machines_puertas").val("");
                $("#people_puertas").val("");
                $("#turns_puertas").val("");
            }
            $(".campos2").show();
            alertify.success('PROGRAMACION DIA ');

        }, 'json').fail(function (error) {
            swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
        });


    }


    function recorder() {
        if (validatefield()) {
            var formData = new FormData($('#form')[0]);
            $.ajax({
                url: "<?= base_url() ?>Production/Production_Time/C_ProgrammingDay/Createprogrammingday",
                type: 'POST',
                data: formData,
                async: false,
                success: function (data) {
                    var obj = jQuery.parseJSON(data);
                    if (obj.res == "OK") {
                        swal({
                            title: 'Operacion Exitosa!',
                            text: "El registro ha sido creado.",
                            type: 'success'
                        });
                        $("#datepicker").val("");
                        $(".campos2").hide();
                        $('#checktc1').iCheck('uncheck');
                            $('#checktc2').iCheck('uncheck');
                            $('#checktc3').iCheck('uncheck');
                            $('#checktc4').iCheck('uncheck');

                            $('#checkte1').iCheck('uncheck');
                            $('#checkte2').iCheck('uncheck');
                            $('#checkte3').iCheck('uncheck');
                            $('#checkte4').iCheck('uncheck');

                            $('#checktmq').iCheck('uncheck');
                            $('#checktmq1').iCheck('uncheck');
                            $('#checktmq2').iCheck('uncheck');
                            $('#checktmq4').iCheck('uncheck');
                            
                            $('#checktrta').iCheck('uncheck');
                            $('#checktrta1').iCheck('uncheck');
                            $('#checktrta2').iCheck('uncheck');
                            $('#checktrta4').iCheck('uncheck');
                           
                            $('#checktmc').iCheck('uncheck');
                            $('#checktmc1').iCheck('uncheck');
                            $('#checktmc2').iCheck('uncheck');
                            $('#checktmc4').iCheck('uncheck');
                            
                            $('#checktrpz').iCheck('uncheck');
                            $('#checktrpz1').iCheck('uncheck');
                            $('#checktrpz2').iCheck('uncheck');
                            $('#checktrpz4').iCheck('uncheck');
                            
                            $('#checktpt').iCheck('uncheck');
                            $('#checktpt1').iCheck('uncheck');
                            $('#checktpt2').iCheck('uncheck');
                            $('#checktpt4').iCheck('uncheck');
                            

                        $("#form")[0].reset();


                    } else {
                        swal({title: 'Error!', text: obj.res, type: 'error'});
                    }
                },

                cache: false,
                contentType: false,
                processData: false
            }).fail(function (error) {
                if (error.status == 200) {
                    RedirectLogin();
                } else {
                    swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
                }
            });
        }
        if (!error) {
            alertify.error('DEBE REGISTRAR LOS CAMPOS REQUERIDOS');
        }

    }
    function update() {
        swal({
            title: 'Esta seguro de Actualizar este dia  ',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Actualizar!'
        }).then((result) => {
            if (result) {

                var formData = new FormData($('#form')[0]);
                $.ajax({
                    url: "<?= base_url() ?>Production/Production_Time/C_ProgrammingDay/updateProgrammingDay",
                    type: 'POST',
                    data: formData,
                    async: false,
                    success: function (data) {
                        var obj = jQuery.parseJSON(data);
                        if (obj.res == "OK") {

                            $(".regihours").hide();
                            $(".updatehours").hide();
                            $("#datepicker").val("");
                            $("#form")[0].reset();
                            
                            $(".campos2").hide();

                            swal({
                                title: 'Operacion Exitosa!',
                                text: "El registro ha sido creado.",
                                type: 'success'
                            });

                            $("#form")[0].reset();
                            $(".campos2").hide();
                            
                            $('#checktc1').iCheck('uncheck');
                            $('#checktc2').iCheck('uncheck');
                            $('#checktc3').iCheck('uncheck');
                            $('#checktc4').iCheck('uncheck');

                            $('#checkte1').iCheck('uncheck');
                            $('#checkte2').iCheck('uncheck');
                            $('#checkte3').iCheck('uncheck');
                            $('#checkte4').iCheck('uncheck');

                            $('#checktmq').iCheck('uncheck');
                            $('#checktmq1').iCheck('uncheck');
                            $('#checktmq2').iCheck('uncheck');
                            $('#checktmq4').iCheck('uncheck');
                            
                            $('#checktrta').iCheck('uncheck');
                            $('#checktrta1').iCheck('uncheck');
                            $('#checktrta2').iCheck('uncheck');
                            $('#checktrta4').iCheck('uncheck');
                           
                            $('#checktmc').iCheck('uncheck');
                            $('#checktmc1').iCheck('uncheck');
                            $('#checktmc2').iCheck('uncheck');
                            $('#checktmc4').iCheck('uncheck');
                            
                            $('#checktrpz').iCheck('uncheck');
                            $('#checktrpz1').iCheck('uncheck');
                            $('#checktrpz2').iCheck('uncheck');
                            $('#checktrpz4').iCheck('uncheck');
                            
                            $('#checktpt').iCheck('uncheck');
                            $('#checktpt1').iCheck('uncheck');
                            $('#checktpt2').iCheck('uncheck');
                            $('#checktpt4').iCheck('uncheck');
                            
                            
                            

                        } else {
                            swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});

                        }
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                }).fail(function (error) {
                    if (error.status == 200) {
                        RedirectLogin();
                    } else {
                        swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
                    }
                });

            }
        }).catch(swal.noop)
    }



</script>
