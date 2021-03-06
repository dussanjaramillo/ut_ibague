<?php

if (isset($message)){
    echo $message;
   }

if ($perfil == 41){
    $perfiles = 'Secretario';
    $icono = "fa-user";
}else if ($perfil == 42){
    $perfiles = 'Coordinador';
    $icono = "fa-users";
}else if ($perfil == 43){
    $perfiles = 'Abogado';
    $icono = "fa-male";
}   
   
   
?>
<br>
    <h1>Liquidación de Crédito</h1>
<br><br>
<div style="display:none" id="alert" class="alert alert-danger">
    
</div>
<br><br>
<div class="alert alert-info">
<h4 align="left">
        <i class="fa <?php echo @$icono; ?> "> <?php echo @$perfiles ?></i> 
</h4>
</div>    
<div class="modal hide fade in" id="viewDocumento" style="display: none; width: 60%; margin-left: -30%;">
  <div class="viewDocumento-dialog">
    <div class="viewDocumento-content">
      <div class="viewDocumento-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <div id="subtitle" name="subtitle"></div>
      </div>
      <div class="viewDocumento-body conn">
        Cargando datos...
      </div>
      <div align="right" class="viewDocumento-footer">
          <a href="#" class="btn btn-success" data-dismiss="modal"><i class="fa fa-trash-o"></i> Cerrar</a>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<table id="tablaq">
    <thead>      
       <tr>
        <th>Identificaci&oacute;n</th>
        <th>Ejecutado</th>
        <th>Num. Proceso</th>                
        <th>Ver Estado</th>
        <th>Tipo Auto</th>
      </tr>
    </thead>
    <tbody>
            <?php   
            if (isset($registros)){
                foreach ($registros as $value) {                
                ?>
                    <tr>
                        <td align="center"><?= @$value['CODEMPRESA'] ?></td>
                        <td align="center"><?= @$value['NOMBRE_EMPRESA'] ?></td>
                        <td align="center"><?= @$value['COD_FISCALIZACION'] ?></td>            
                        <td align="center"><?= @$value['NOMBRE_GESTION'] ?></td>
                        <td align="center"><?= @$value['DESCRIPCION_AUTO'] ?></td>
                    </tr>
                <?php                
                }
            }else {
                echo "No Existe";
            }
            ?>
    </tbody>     
</table>
<br>

<br>

<div id="ajax_load" class="ajax_load" style="display: none">
        <div class="preload" id="preload" >
            <img  id="load" class="load" src="<?php echo base_url('img/27.gif'); ?>" width="128" height="128" />
        </div>
</div>

<form id="frmTmp" method="POST" enctype='multipart/form-data'>
    <input type="hidden" id="nit" name="nit">
    <input type="hidden" id="cod_coactivo" name="cod_coactivo">
    <input type="hidden" id="nombre" name="nombre">
    <input type="hidden" id="clave" name="clave">
    <input type="hidden" id="gestion" name="gestion">
    <input type="hidden" id="tipo_auto" name="tipo_auto">
    <input type="hidden" id="tipo" name="tipo">
    <input type="hidden" id="perfil" name="perfil" value="<?php echo $perfil ?>">  
    
<div id='dialog' style="display: none;">
    <center>
        <p><b>Se Objetó la Liquidación?</b></p>
    </center>  
    <?php
         $datafile = array('name'=>'filecolilla','id'=>'filecolilla','value'=>'','maxlength'=>'10',);
    ?>        
            <div id='cargarDocumento' style="display: none;">
                <table>
                    <tr>
                        <td>Numero Radicado</td>
                        <td><input id='radicado' name='radicado' type='text'></td>
                    </tr>
                    <tr>
                        <td>Fecha Radicado</td>
                        <td><input id='fecharadicado' name='fecharadicado' type='text' readonly></td>
                    </tr>
                    <tr>
                        <td colspan='2'>                            
                            <?php echo form_label('Cargar Documento', 'filecolilla');                    
                                echo "<br>".form_upload($datafile);
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan='2'>
                            <div style="display: none;" align='center' class="alert alert-danger" id='error'></div>
                        </td>
                    </tr>
                </table>                               
            </div>        
</div>
    
</form>

<script type="text/javascript" language="javascript" charset="utf-8"> 
    $('#tablaq').dataTable({
        "bJQueryUI": true,
        "oLanguage": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            }
        }
   });

$(document).ready(function() {
       $('#fecharadicado').datepicker({
        dateFormat: "dd/mm/y",
        maxDate: "0"
    });  
})
   
window.onload = function ()
{
        $('#gestion').val(<?= $cod_respuesta ?>);
        $('#nit').val(<?= $nit ?>);
        $('#cod_coactivo').val('<?= $cod_coactivo ?>');
        $('#nombre').val('<?= $razon ?>');
        $('#clave').val('<?= $num_auto ?>');   
        $('#tipo_auto').val('<?= $tipo_auto ?>');        
        var gestion         = '<?= $cod_respuesta ?>';
        var nit             = '<?= $nit ?>';
        var cod_coactivo    = '<?= $cod_coactivo ?>';
        var name            = '<?= $razon ?>';
        var clave           = '<?= $num_auto ?>';        
        var tipo_auto       = '<?= $tipo_auto ?>';  
        var perfil          = '<?php echo $perfil ?>';
        //alert (gestion+tipo_auto);
         switch (tipo_auto){
            case '3':
                if (gestion == '1132' || gestion == '1473' || gestion == '1474' || gestion == '1475' || gestion == '1476'){   
                $(".ajax_load").show("slow");
                $("#frmTmp").attr("action", "<?= base_url('index.php/liquidaciones_credito/editAuto')?>");
                $('#frmTmp').submit();
                }else if (gestion == '1477' || gestion == '1160'){
                    $(".ajax_load").show("slow");
                    $("#frmTmp").attr("action", "<?= base_url('index.php/liquidaciones_credito/correo')?>");
                    $('#frmTmp').submit();
                }else if (gestion == '450' || gestion == '451' || gestion == '1153' || gestion == '1152'){
                    $(".ajax_load").show("slow");
                    $("#frmTmp").attr("action", "<?= base_url('index.php/liquidaciones_credito/editCorreo')?>");
                    $('#frmTmp').submit();
                }else if (gestion == '452'){
                    $(".ajax_load").show("slow");
                    $("#frmTmp").attr("action", "<?= base_url('index.php/liquidaciones_credito/pagina')?>");
                    $('#frmTmp').submit();
                }else if (gestion == '453' || gestion == '1155' || gestion == '1154'){
                    $(".ajax_load").show("slow");
                    $("#frmTmp").attr("action", "<?= base_url('index.php/liquidaciones_credito/editPagina')?>");
                    $('#frmTmp').submit();
                }else if(gestion == '454' || gestion == '800'){                                         
                    var url         = "<?=base_url()?>index.php/liquidaciones_credito/guardar_objecion";
                    $("#dialog").dialog({width: 500, height: 350, show: "slide", hide: "scale", resizable: "false", position: "center", modal: "true"});    
                    $("#dialog").dialog({
                    buttons: [{
                        id: "si",
                        text: "Si",
                        class: "btn btn-success",
                        click: function() {  
                            $('#cargarDocumento').show();  
                            $('#si').click(function(){
                                var filecolilla = $('#filecolilla').val();
                                var radicado = $('#radicado').val();
                                var fecharadicado = $('#fecharadicado').val();
                                if (filecolilla == ''){
                                    $('#error').show();
                                    $('#error').html('Por Favor Adjuntar Archivo');
                                    $('#filecolilla').focus();
                                }else if (radicado == ''){
                                    $('#error').show();
                                    $('#error').html('Por Favor Adjuntar Numero Radicado');
                                    $('#radicado').focus();
                                }else if (fecharadicado == ''){
                                    $('#error').show();
                                    $('#error').html('Por Favor Adjuntar Fecha Radicado');
                                    $('#fecharadicado').focus();
                                }else{                                 
                                    $(".ajax_load").show("slow");
                                    $('#tipo').val('s');    
                                    $("#frmTmp").attr("action", url);
                                    $('#frmTmp').submit();
                                }
                            })
                        }
                    },
                    {
                        id: "no",
                        text: "No",
                        class: "btn btn-success",
                        click: function() {    
                                $(".ajax_load").show("slow");
                                $('#tipo').val('n');                                
                                $("#frmTmp").attr("action", url);
                                $('#frmTmp').submit();                               
                           }                                            
                        }]
                    });
                }else if (gestion == '840'){
                    $(".ajax_load").show("slow");
                    $("#frmTmp").attr("action", "<?= base_url('index.php/liquidaciones_credito/addAutoObj')?>");
                    $('#frmTmp').submit();
                }else if (gestion == '1471'){
                    $(".ajax_load").show("slow");
                    $("#frmTmp").attr("action", "<?= base_url('index.php/liquidaciones_credito/addAutoLiq')?>");
                    $('#frmTmp').submit();
                }
               break;
            case '24':
                if (gestion == '1132' || gestion == '1473' || gestion == '1474' || gestion == '1475' || gestion == '1476'){   
                    $(".ajax_load").show("slow");
                    $("#frmTmp").attr("action", "<?= base_url('index.php/liquidaciones_credito/editAutoObj')?>");
                    $('#frmTmp').submit();
                }else if (gestion == '1477' || gestion == '1160'){
                    $(".ajax_load").show("slow");
                    $("#frmTmp").attr("action", "<?= base_url('index.php/liquidaciones_credito/correoObjec')?>");
                    $('#frmTmp').submit();
                }else if (gestion == '450' || gestion == '451' || gestion == '1153' || gestion == '1152'){
                    $(".ajax_load").show("slow");
                    $("#frmTmp").attr("action", "<?= base_url('index.php/liquidaciones_credito/editCorreoObjec')?>");
                    $('#frmTmp').submit();
                }else if (gestion == '452'){
                    $(".ajax_load").show("slow");
                    $("#frmTmp").attr("action", "<?= base_url('index.php/liquidaciones_credito/paginaObjec')?>");
                    $('#frmTmp').submit();
                }else if (gestion == '453' || gestion == '1155' || gestion == '1154'){
                    $(".ajax_load").show("slow");
                    $("#frmTmp").attr("action", "<?= base_url('index.php/liquidaciones_credito/editPaginaObjec')?>");
                    $('#frmTmp').submit();
                }else if(gestion == '454' || gestion == '800'){                      
                     $(".ajax_load").show("slow");
                    $("#frmTmp").attr("action", "<?= base_url('index.php/liquidaciones_credito/addAutoLiq')?>");
                    $('#frmTmp').submit();               
                }
                break;
             case '25':
                 if (gestion == '1132' || gestion == '1473' || gestion == '1474' || gestion == '1475' || gestion == '1476'){   
                    $(".ajax_load").show("slow");
                    $("#frmTmp").attr("action", "<?= base_url('index.php/liquidaciones_credito/editAutoLiq')?>");
                    $('#frmTmp').submit();
                }else if (gestion == '1477'){
                    alert ('El Proceso se encuentra en Medidas Cautelares - Remate');
                    window.location = "<?= base_url().'index.php/bandejaunificada/procesos' ?>";
                }
                 break;
        } 
        
}
    
$('#filecolilla').change(function(){ 
        var extensiones_permitidas = new Array(".pdf"); 
        var archivo = $('#filecolilla').val();
        var extension = (archivo.substring(archivo.lastIndexOf("."))).toLowerCase();
        var permitida = false;
        
        for (var i = 0; i < extensiones_permitidas.length; i++) {
            if (extensiones_permitidas[i] == extension) {
            permitida = true;
            break;
            }
        } 
            if (!permitida) {
                $('#filecolilla').val('');
                $('#error').show();
                $('#error').html("<b>Comprueba la extensión de los archivos a subir. \nSólo se pueden subir archivos con extensiones: " + extensiones_permitidas.join()+"</b>");
                $("#filecolilla").focus();
            }else{
                $('#error').show();
                $('#error').html("<b>Archivo Subido Correctamente</b>");
                return 1;
            } 
      });       
     
    
</script>