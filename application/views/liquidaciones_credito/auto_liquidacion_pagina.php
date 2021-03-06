
<?php
if( ! defined('BASEPATH') ) exit('No direct script access allowed'); 

$attributes = array('id' => 'citacionFrm', 'name' => 'citacionFrm','class' => 'form-inline', 'method' => 'POST', 'enctype' => 'multipart/form-data', );
$cRuta = $rutaTemporal;                         
if (is_dir($cRuta)) {
    $handle = opendir($cRuta);
    while ($file = readdir($handle)) {
     if (is_file($cRuta.$file)) {
        $plantilla = read_template($cRuta.$file);
        $datanotificacion = array('name'=>'notificacion','id'=>'notificacion','value'=>$plantilla,'width'=>'80%','heigth'=>'50%'); 
      }
    }                         
}else {
        $datanotificacion = array('name'=>'notificacion','id'=>'notificacion','value'=>set_value('notificacion'),'width'=>'80%','heigth'=>'50%');
      }                

$attributes     = array('id'=>'citacionFrm','name' =>'citacionFrm','class' =>'form-inline','method'=>'POST','enctype'=>'multipart/form-data');
$data           = array('name'=>'comentarios','id'=>'comentarios','value'=> set_value('comentarios'),'width'=> '100%','heigth'=>'5%','style'=> 'width:98%','required'=>'true');
$dataguardar    = array('name'=>'button','id'=>'guardar','value'=>'Guardar','type'=>'button','content'=>'<i class="fa fa-floppy-o fa-lg"></i> Guardar','class'=>'btn btn-success');
$dataenviar     = array('name'=>'tmp','id'=>'tmp','value'=>'Enviar','type'=>'button','content'=>'<i class="fa fa-file-text-o fa-lg"></i> Enviar','class'=>'btn btn-success');
$dataPDF        = array('name'=>'button','id'=>'pdf','value'=>'Generar PDF','type'=>'button','content'=>'<i class="fa fa-file"></i> Generar PDF','class'=>'btn btn-info');
$datacancel     = array('name'=>'button','id'=>'cancel-button','value'=>'Cancelar','type'=>'button','onclick'=>'window.location=\''.base_url().'index.php/bandejaunificada/procesos\';','content'=>'<i class="fa fa-undo"></i> Cancelar','class'=>'btn btn-warning');

$dataFisc       = array('name'=>'cod_coactivo','id'=>'cod_coactivo','type'=>'hidden','value'=>@$cod_coactivo);
$dataNit        = array('name'=>'cod_nit','id'=>'cod_nit','type'=>'hidden','value'=>$nitempresa);
$dataTipo       = array('name'=>'tipo','id'=>'tipo','type'=>'hidden','value'=>@$tipo);
$dataTemp       = array('name'=>'temporal','id'=>'temporal','type'=>'hidden');
$dataLiquid     = array('name'=>'liquidacion','id'=>'liquidacion','type'=>'hidden');
$dataAuto       = array('name'=>'num_auto','id'=>'num_auto','type'=>'hidden','value'=>@$num_auto);
echo form_open_multipart(current_url(),$attributes); ?>
<?php echo @$custom_error; 
echo @$custom_error; 
echo form_input($dataFisc);
echo form_input($dataNit);
echo form_input($dataTipo);
echo form_input($dataTemp);
echo form_input($dataLiquid);
echo form_input($dataAuto);
@$rutaInac=base_url().'uploads/liquidacion/'.$cod_coactivo.'/pdf/'.@$tipo.'/'.$inactivo->NOMBRE_DOC_CARGADO;
        ?>        
        <div class="center-form-large-20">      
        <table cellspacing="0" cellspading="0" border="0" align="center">
        <tr>
            <td>
            <?php $this->load->view('liquidaciones_credito/cabecera',$this->data); ?>
            </td>
        </tr>
            <?php 
                if (count(@$inactivo)>0){
                    echo "<tr>
                            <td align='right'>
                                <a href='$rutaInac' class='btn-success' target=_blank>
                                    Citaci&oacute;n Anterior
                                </a>
                            </td>
                        </tr>";
                }                
            ?>       
        <tr>
            <td colspan="2">
            <p>
            <?php echo form_textarea($datanotificacion); ?>
            </p>
            </td>
        </tr>
       <tr><td><br></td></tr>
        <tr>
            <td colspan="2">
            <p>
            <?php
                echo form_label('Observaci&oacute;n<span class="required"><font color="red"><b>* </b></font></span>','observacion');
                echo form_textarea($data);
            ?>
            </p>
            </td>
        </tr>
        <tr>
            <td align="center" colspan="2">
            <p>
                <div style="display:none" id="error" class="alert alert-danger"></div>
            </p>
            <p>
            <?php 
            echo form_button($dataguardar)."&nbsp;&nbsp;";            
            echo form_button($dataenviar)."&nbsp;&nbsp;";            
            echo form_button($dataPDF)."&nbsp;&nbsp;";            
            echo form_button($datacancel);
            ?>
            </p>
            </td>
        </tr>
        </table>
        <?php echo form_close(); ?>

</div>
<div id="ajax_load" class="ajax_load" style="display: none">
        <div class="preload" id="preload" >
            <img  id="load" class="load" src="<?php echo base_url('img/27.gif'); ?>" width="128" height="128" />
        </div>
</div>


  <script type="text/javascript">
  $(document).ready(function() {
        window.history.forward(-1);
        tinymce.init({
        language : "es",
        selector: "textarea#notificacion",
        theme: "modern",
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace visualblocks wordcount visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
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
        tinyMCE.triggerSave();
        $('#fechanotificacion').datepicker({dateFormat: "dd/mm/y"});
        $('#fechaonbase').datepicker({dateFormat: "dd/mm/y"});
      });
      
$('#observacion').keyup(function() {
    var max_chars = 200;
    var chars = $(this).val().length;
    var diff = max_chars - chars;
    if (diff <= 0){
        $('#error').show();
        $('#error').html('Excedio el limite de carácteres en el campo comentarios');
        $('#guardar').attr('disabled',true);   
    }else{
        $('#guardar').attr('disabled',false); 
        $('#error').hide();
    }
}); 
    
function char_especiales(string){
    var comentarios=string.replace(/[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi,'');
    $('#comentarios').val(comentarios);
}      
      
      $('#guardar').click(function() {
        $('#error').html("");
        tinyMCE.triggerSave();
        var notify = $('#notificacion').val();
        var observa = $('#comentarios').val();
        var valida = true;
        var tipo = $('#tipo').val();
        var url = '<?php echo base_url('index.php/liquidaciones_credito/guardar_notif')?>';                
        char_especiales(observa);
        if (notify == "") {
            $('#error').show();
            $('#error').html("<b>Ingrese Notificaci&oacute;n</b>");
            $("#notificacion").focus();
            valida = false;
        }else if (observa == "") {
            $('#error').show();
            $('#error').html("<b>Ingrese Comentarios</b>");
            valida = false;
        }
        if (valida == true) {
            $(".ajax_load").show("slow");
            $('#guardar').prop("disabled",true);
            $("#citacionFrm").attr("action", url);
            $('#citacionFrm').removeAttr('target');
            $('#citacionFrm').submit();
              //alert ("ok");
        }
    });
    
    $('#pdf').click(function() {
        tinyMCE.triggerSave();
        var notify = $('#notificacion').val();
        $('#liquidacion').val(notify);
        $("#citacionFrm").attr("action", "<?= base_url('index.php/liquidaciones_credito/pdf')?>");
        $('#citacionFrm').attr('target', '_blank');
        $('#citacionFrm').submit();
    });
    
    
    $('#tmp').click(function() {
        tinyMCE.triggerSave();
        var temp = $('#notificacion').val();
        var tipo = $('#tipo').val();
        $(".ajax_load").show("slow");
        $('#citacionFrm').removeAttr('target');
        $('#temporal').val(temp);
        $('#tipo').val(tipo);
        $('#citacionFrm').attr("action", "temp");
        $('#citacionFrm').submit();
    });


</script>