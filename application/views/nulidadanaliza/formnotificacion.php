<?php if( ! defined('BASEPATH') ) exit('No direct script access allowed'); ?>
<style>
    div.preload{
        position: fixed;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        background-color: white;
        opacity: 0.8;
        z-index: 10000;
    }

    div img.load{
        position: absolute;
        left: 50%;
        top: 50%;
        margin-left: -64px;
        margin-top: -64px;
        z-index: 15000;
    }
</style>
<script>
    
function subirPantalla(){
    $('html, body').animate({
           scrollTop: '0px'
       },
       1500);
       return false;
}

function toggle(id) {
    
    var ele = document.getElementById(id);
    if(ele.style.display == "block") {
            ele.style.display = "none";
      }
    else {
        ele.style.display = "block";
    }
}

function openDiv(id){
    var ele = document.getElementById(id);
    ele.style.display = "block";
}

function closeDiv(id){
    var ele = document.getElementById(id);
    ele.style.display = "none";
}

function FnVolver(){
    //history.back();
    window.location.href='<?php echo base_url()?>index.php/nulidadanaliza/listNulidadesCoordinadorActoAdmin';

} 
function save(){
    tinyMCE.triggerSave();//asigna el contenido
    var url = "<?php echo base_url()?>index.php/nulidadanaliza/saveNotificacion"; // El script a dónde se realizará la petición.
    $.ajax({
           type: "POST",
           url: url,
           data: $("#form_projuridicos").serialize(), // Adjuntar los campos del formulario enviado.
           success: function(data)
           {
               if($.trim(data) == 'ok'){
                    $("#total_form").toggle();
                    $("#alert").toggle();
                    $(".ajax_load").toggle("slow");
                    if($('#COD_ESTADOAUTO').val() != 3){
                        setTimeout("FnVolver()", 3000);
                    }
               }else{
                   alert('No se pudo almacenar, comuniquese con su proveedor');
                   $(".ajax_load").toggle("slow");
               }
           }
     });
}
 
function validar(){
    openDiv('ajax_load');
    
    var ed = tinyMCE.get('documento');
    var data_documento = ed.getContent();
    
    if($.trim(data_documento) == ''){
        alert('En el campo "Documento" se encuentra vacio');
        $(".ajax_load").toggle();
        return false;
    }
    
    if($.trim($('#COMENTARIOS').val()) == ''){
        alert('El campo "Comentario" se encuentra vacio');
        $(".ajax_load").toggle();
        return false;
    }
    
    if($.trim($('#RADICADO_ONBASE').val()) == ''){
        alert('Debe digitar el numero de on base');
        $(".ajax_load").toggle();
        return false;
    }
    
    if($.trim($('#FECHA_SOLICITUD_PRUEBAS').val()) == ''){
        alert('Debe seleccionar un fecha');
        $(".ajax_load").toggle();
        return false;
    }
    
    if( (<?php echo (($acto_notificacion == null) ? 'false': 'true')?> == true)  ){
        
        if($('#COD_ESTADOAUTO').val() == ''){
            alert('Debe seleccionar un estado');
            $(".ajax_load").toggle();
            return false;
        }
        
        if($.trim($('nombre_doc_firmado_upload').val()) != ''){
            alert('Debe subir la colilla de notificacion');
            $(".ajax_load").toggle();
            return false;
        }else{ 
           return true;
        }    
    }    
    
    if(($('COD_ESTADOAUTO').val() == 3) || ($('COD_ESTADOAUTO').val() == 4)){
     subirPantalla();
     return true;   
    }else{
        subirPantalla();
        save();
        return false;
    }    
    
}

function getPlantilla(id_plantilla, id_fiscalizacion){
    //openDiv('ajax_load');
    //$(".ajax_load").toggle();
    //openDiv('load');
    if(id_plantilla == ''){
        alert('No a seleccionado una plantilla');
    }else{
        $(".ajax_load").toggle("slow");
        var ed = tinyMCE.get('documento');
        if(id_plantilla != 0){
            $.get('<?php echo base_url()?>index.php/verfpagosprojuridicos/getAjaxPlantilla/' + id_plantilla + '/' + id_fiscalizacion, function(data) {
                ed.setContent(data);
                openDiv('display_form');
                $(".ajax_load").toggle("slow");
             });
        }else{
            ed.setContent('');
            openDiv('display_form');
            $(".ajax_load").toggle("slow");
        }
    }
    
    //closeDiv('preload');
    //closeDiv('load');
}

function metodoContacto(seleccion){
    if((seleccion == 1) && ('<?php echo $email?>' == 'N')){
        alert('La empresa no autorizado la notificacion por correo electronico');
        $('#selectPlantilla').hide("slow");
        $('#display_form').hide("slow");
        document.getElementById("form_projuridicos").reset();
    }else{
        $('#selectPlantilla').show("slow");
    }    
}

</script>
<?php 
echo form_open(base_url() . 'index.php/nulidadanaliza/saveNotificacion', 'method="post" id="form_projuridicos" onsubmit="return validar()" enctype="multipart/form-data"');
?>
<div id="ajax_load" class="ajax_load" style="display: none">
<div class="preload" id="preload" ></div><img  id="load" class="load" src="<?php echo base_url('img/27.gif'); ?>" width="128" height="128" />
</div>
<?php echo $custom_error;?>
<h2><?=$action_label?> Notificacion</h2>
<div id="total_form">

<div id="error"></div>
<div  class="center-form-large">
<div id="plantilla_list">
    <?php 
    if($acto_notificacion == null){
    ?>
        <div class="controls controls-row">
            <div class="span4">
            <?php 
                echo form_label('Metodo de contacto', 'COD_METODO_CONTACTO');  
                $data = array(
                    'name'        => 'COD_METODO_CONTACTO',
                    'id'          => 'COD_METODO_CONTACTO1',
                    'value'       => '7',
                    'style'       => 'margin:10px',
                    'onclick'     => 'metodoContacto(this.value)'

                    );

        echo (form_radio($data) . 'Correo Electronico');
        
        $data = array(
            'name'        => 'COD_METODO_CONTACTO',
            'id'          => 'COD_METODO_CONTACTO2',
            'value'       => '8',
            'style'       => 'margin:10px',
            'onclick'     => 'metodoContacto(this.value)'
            );

        echo (form_radio($data) . 'Correo Fisico');
            ?>
            </div>
            <div class="span4">
                <div <?php echo $view?> id="selectPlantilla">
                <?php 
                echo form_label('Plantilla', 'CODPLANTILLA');                            
                     $select = array();
                     $select['']   = 'Seleccione';
                     $select[0]    = 'Sin plantilla';
                     foreach($plantillas as $row) {
                         $select[$row->CODPLANTILLA] = $row->NOMBRE_PLANTILLA;
                      }
                echo form_dropdown('CODPLANTILLA', $select, '','id="cargo" onchange="getPlantilla(this.value,' . $fiscalizacion->COD_FISCALIZACION . ')" class="chosen span3" placeholder="seleccione..." ');
               ?>
               </div>
            </div>
        </div> 
    <?php 
    }
    ?>
</div>

<div id="display_form" <?php echo $view?>>
<?php 

echo form_hidden('COD_FISCALIZACION'    , $fiscalizacion->COD_FISCALIZACION);
echo form_hidden('NUM_AUTOGENERADO'     , (($acto_notificacion != null) ? $acto_notificacion->NUM_AUTOGENERADO : ''));
echo form_hidden('COD_TIPO_AUTO'        , (($acto_notificacion != null) ? $acto_notificacion->COD_TIPO_AUTO : $cod_tipo_auto ));
echo form_hidden('COD_TIPO_PROCESO'     , 1);
//echo form_hidden('ASIGNADO_A'         , $asignado_a);
echo form_hidden('FECHA_CREACION_AUTO'  , (($acto_notificacion != null) ? $acto_notificacion->FECHA_CREACION_AUTO : ''));
echo form_hidden('REVISADO_POR'         , (($acto_notificacion != null) ? $acto_notificacion->REVISADO_POR : 0));
echo form_hidden('APROBADO_POR'         , (($acto_notificacion != null && $acto_notificacion->COD_ESTADOAUTO ==  2) ? $idusuario : 0));
echo form_hidden('COD_GESTIONCOBRO'     , $cod_gestioncobro);
echo form_hidden('COD_NULIDAD'          , $cod_nulidad);
echo form_hidden('COD_ACTOADMINISTRATIVO'       , $cod_acto_administrativo);
?>
<div class="controls controls-row">
<div class="span4">
<?php
 echo form_label('Nit', 'NIT_EMPRESA');
   $data = array(
              'name'        => 'NIT_EMPRESA',
              'id'          => 'NIT_EMPRESA',
              'value'       => $fiscalizacion->NIT_EMPRESA,
               'class'      => 'span3',
               'readonly'   => 'readonly'
            );

   echo form_input($data);
?>
</div>
<div class="span4">
<?php
echo form_label('Razon Social', 'RAZON_SOCIAL');
$data = array(
           'name'        => 'RAZON_SOCIAL',
           'id'          => 'RAZON_SOCIAL',
           'value'       => $fiscalizacion->RAZON_SOCIAL,
           'class'       => 'span3',
           'readonly'    => 'readonly'
         );

   echo form_email($data);
?>
</div>
</div>
<div class="controls controls-row">
<div class="span4">
<?php
echo form_label('Consepto', 'consepto');
$data = array(
           'name'        => 'consepto',
           'id'          => 'consepto',
           'value'       => $fiscalizacion->NOMBRE_CONCEPTO,
           'class'       => 'span3',
           'readonly'    => 'readonly'
         );

   echo form_email($data);
?>
</div>    
      
<div class="span4">
<?php
echo form_label('Instancia', 'instancia');
$data = array(
           'name'        => 'instancia',
           'id'          => 'instancia',
           'value'       => 'Cobro Coactivo',
           'class'       => 'span3',
           'readonly'    => 'readonly'
         );

   echo form_email($data);
?>
</div>
</div>
<div class="controls controls-row">
<div class="span4">
<?php
echo form_label('Representante Legal', 'representante_legal');
$data = array(
           'name'        => 'representante_legal',
           'id'          => 'representante_legal',
           'value'       => $fiscalizacion->REPRESENTANTE_LEGAL,
           'class'       => 'span3',
           'readonly'    => 'readonly'
         );

   echo form_email($data);
?>
</div>
      
<div class="span4">
<?php
echo form_label('Telefono', 'telefono');
$data = array(
           'name'        => 'telefono',
           'id'          => 'telefono',
           'value'       => $fiscalizacion->TELEFONO_FIJO,
           'class'       => 'span3',
           'readonly'    => 'readonly'
         );

   echo form_email($data);
?>
</div>
</div>
<div class="controls controls-row">
<div class="span1">
<?php
echo form_label('Documento<span class="required">*</span>', 'documento');
?>
</div>
<div class="span4">
<?php
$data = array(
           'name'        => 'documento',
           'id'          => 'documento',
           'value'       => $documento,
           'class'       => 'span3',
         );

   echo form_textarea($data);
?>
</div>
</div>
<br>
<div class="controls controls-row">
<div class="span1">
<?php
echo form_label('Comentarios<span class="required">*</span>', 'COMENTARIOS');
?>
</div>
<div class="span4">
<textarea id="COMENTARIOS" style="width: 560px; height: 150px;"  name="COMENTARIOS"><?php echo (isset($acto_notificacion) ? $acto_notificacion->COMENTARIOS : '')?></textarea>
</div>
</div>

<?php 
if($acto_notificacion != null){
?>
<div class="controls controls-row">
<div class="span4">
    
    <?php 
    echo form_label('Estado', 'COD_ESTADOAUTO');                            
    echo form_dropdown('COD_ESTADOAUTO', $estados, '','id="COD_ESTADOAUTO" class="chosen span3" placeholder="seleccione..." ');
   ?>

</div>
<div class="span4">

</div>
</div>
<?php 
}
?>
<div class="controls controls-row">
    <div class="span4">
        <?php
        echo form_label('Numero de radicando onBase', 'RADICADO_ONBASE');
        $data = array(
                   'name'        => 'RADICADO_ONBASE',
                   'id'          => 'RADICADO_ONBASE',
                   'value'       => (isset($acto_notificacion) ? $acto_notificacion->RADICADO_ONBASE : ''),
                   'class'       => 'span3'
                 );

           echo form_input($data);
        ?>
    </div>
    <div class="span4">
        <?php
        echo form_label('Fecha de radicacion', 'FECHA_SOLICITUD_PRUEBAS');
        $data = array(
                   'name'        => 'FECHA_SOLICITUD_PRUEBAS',
                   'id'          => 'FECHA_SOLICITUD_PRUEBAS',
                   'value'       => (isset($acto_notificacion) ? $acto_notificacion->FECHA_SOLICITUD_PRUEBAS : ''),
                   'class'       => 'span3',
                   'readonly'    => 'readonly'
                 );

           echo form_input($data);
        ?>
    </div>
</div>

<div class="controls controls-row">
<div class="span4">
<?php 
if(($acto_notificacion != null)){
    echo form_label('Colilla de pago', 'nombre_doc_firmado_upload');
    $data = array(
               'name'        => 'nombre_doc_firmado_upload',
               'id'          => 'nombre_doc_firmado_upload',
               'class'       => 'span3',
             );

    echo form_upload($data);
}

?>
</div>
<div class="span4">
<?php 
/*$data = array(
    'name' => 'causalesNulidad',
    'id' => 'causalesNulidad',
    'value' => 'causalesNulidad',
    'type' => 'button',
    'content' => 'Ver causales de la nulidad',
    'data-target' => '#myModal',
    'data-toggle' => 'modal'
);

echo form_button($data);*/
?>    
<?php 
$data = array(
       'name' => 'button',
       'id' => 'submit-button',
       'value' => 'Guardar',
       'type' => 'submit',
       'content' => '<i class="fa fa-floppy-o fa-lg"></i> Guardar',
       'class' => 'btn btn-success'
       );

echo form_button($data);    
?>
</div>
</div>

</div>
</div>
</div>

<div class="alert alert-success" id="alert" style="display: none">
<button class="close" data-dismiss="alert" type="button">×</button>
El auto se <?php echo ( ($acto_notificacion == null) ? ' almaceno' : 'actualizo' )?> con exito.
</div>
<hr>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" data-target="bs-example-modal-lg" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Causales de la nulidad</h4>
      </div>
      <div class="modal-body">
          <div class="controls controls-row">
                  <div class="controls controls-row">
    <input type="hidden" name="numCaul" id="numCaul" value=""/>
    <table  border="0" id="tablaCausalidades">
    <?php 
    for($count = 0; $count < count($causales); $count = $count + 2){
        $causal = $causales[$count];
    ?>
    <tr valign="TOP">
        <td>&nbsp;&nbsp;&nbsp;</td>
        <td style="width: 45%"  align="justify">
            <?php echo $causal->NOMBRE_CAUSAL?>
            <br>
            <br>
        </td>
        <td>&nbsp;&nbsp;&nbsp;</td>
        <?php 
        if(isset($causales[$count + 1])){
            $causal = $causales[$count + 1];
        ?>
        <td style="width: 45%" align="justify">
            <?php echo $causal->NOMBRE_CAUSAL?>
            <br>
            <br>
        </td>
        <?php 
        }else{
            ?>
            <td></td>
            <td></td>
            <?php
        }
        ?>
        <td>&nbsp;&nbsp;&nbsp;</td>
    </tr>  
    <?php 
    }
    ?>
    </table>
    </div>
          </div>
        
      </div>
      <div class="modal-footer">    
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<?php 
echo form_close();
?>
 <script>
$(function(){
    var pickerOpts = {
            showOn: "button"
    };	
    $("#FECHA_SOLICITUD_PRUEBAS").datepicker(pickerOpts);
    
   $("#RADICADO_ONBASE").keydown(function(event) {
   if(event.shiftKey)
   {
        event.preventDefault();
   }
 
   if (event.keyCode == 46 || event.keyCode == 8)    {
   }
   else {
        if (event.keyCode < 95) {
          if (event.keyCode < 48 || event.keyCode > 57) {
                event.preventDefault();
          }
        }
        else {
              if (event.keyCode < 96 || event.keyCode > 105) {
                  event.preventDefault();
              }
        }
      }
   });
});


tinymce.init({
        language : 'es',
        selector: "textarea#documento",
        theme: "modern",
        width: "570px",
        height: "600px",
        plugins: [
         "advlist autolink lists link  charmap print preview hr anchor pagebreak",
         "searchreplace wordcount visualblocks visualchars code fullscreen",
         //"insertdatetime media nonbreaking save table contextmenu directionality",
         //"emoticons template paste textcolor moxiemanager"
        ],
        toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
        toolbar2: "print preview media | forecolor backcolor emoticons",
        image_advtab: true,
        templates: [
         {title: 'Test template 1', content: '<b>Test 1</b>'},
         {title: 'Test template 2', content: '<em>Test 2</em>'}
        ],
        autosave_ask_before_unload: false
 });
</script>
   