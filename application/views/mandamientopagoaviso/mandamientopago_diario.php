<?php 
/**
 * mandamientopago_diario -- Vista para adicionar aviso publicado en diario.
 *
 * @author		Human Team Technology QA
 * @author		Nicolas Gonzalez R. - nigondo@gmail.com
 * @version		1.3
 * @since		Febrero de 2014
 */
?>
<script type="text/javascript">
    
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
</script>
<?php
if( ! defined('BASEPATH') ) exit('No direct script access allowed'); ?>
<!-- <div class="center-form"> -->
        <?php     

        $attributes = array('id' => 'diarioFrm', 'name' => 'diarioFrm', 
            'class' => 'form-inline', 'method' => 'POST', 'enctype' => 'multipart/form-data',
            'onSubmit' => 'return comprobarextension()');
        echo form_open_multipart(current_url(),$attributes); ?>
        <?php echo $custom_error; ?>
        <center>
        <h2>Notificaci&oacute;n por aviso publicado en diario</h2>
        </center>
        <div class="center-form-large-20">
        <br>
        <br>
        <table cellspacing="0" cellspading="0" border="0" align="center">
        <tr>
            <td>
            <p>
            <input type="hidden" name="vRuta" id="vRuta">
            <input type="hidden" name="vUbicacion" id="vUbicacion">
            <input type="hidden" name="mandamiento" id="mandamiento">
            <?php
                echo form_label('NIT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 'nit');
                $dataNIT = array(
                           'name'        => 'nit',
                           'id'          => 'nit',
                           'value'       => set_value('nit'),
                           'maxlength'   => '30',
                           'disabled'    => 'disabled'
                         );
                echo form_input($dataNIT);
                echo form_error('nit','<div>','</div>');
            ?>
            </p>
            </td>
            <td>
            <p>
            <?php
                echo form_label('Razon Social&nbsp;&nbsp;', 'razon');
                $datarazon = array(
                           'name'        => 'razon',
                           'id'          => 'razon',
                           'value'       => set_value('razon'),
                           'maxlength'   => '30',
                           'size'        => '120',
                           'disabled'    => 'disabled'
                         );
                echo form_input($datarazon);
                echo form_error('razon','<div>','</div>');
            ?>
            </p>
            </td>
        </tr>
        <tr>
            <td>
            <p>
            <?php
                $select = array();
                echo form_label('Concepto', 'concepto');
                $select[''] = "-- Seleccione --";
                foreach($concepto as $row) {
                    $select[$row->COD_CPTO_FISCALIZACION] = $row->NOMBRE_CONCEPTO;
                }
                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                echo form_dropdown('concepto', $select,'','id="concepto" class="chosen" placeholder="-- Seleccione --" ');

                echo form_error('concepto','<div><b><font color="red">','</font></b></div>');
            ?>
            </p>
            </td>
            <td>
            <p>
            <?php
                $select = array();
                echo form_label('Instancia&nbsp;', 'instancia');
                $select[''] = "-- Seleccione --";
                $select['0'] = "Carlos";
                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                echo form_dropdown('instancia', $select,'','id="instancia" class="chosen" placeholder="-- Seleccione --" ');

                echo form_error('instancia','<div><b><font color="red">','</font></b></div>');
            ?>
            </p>
            </td>
        </tr>
        <tr>
            <td>
            <p>
            <?php
                echo form_label('Representante&nbsp;&nbsp;', 'representante');
                $datarepresentante = array(
                           'name'        => 'representante',
                           'id'          => 'representante',
                           'value'       => set_value('representante'),
                           'maxlength'   => '30',
                           'size'        => '120',
                           'disabled'    => 'disabled'
                         );
                echo form_input($datarepresentante);
                echo form_error('representante','<div>','</div>');
            ?>
            </p>
            </td>
            <td>
            <p>
            <?php
                echo form_label('Tel&eacute;fono&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 'telefono');
                $datatelefono = array(
                           'name'        => 'telefono',
                           'id'          => 'telefono',
                           'value'       => set_value('telefono'),
                           'maxlength'   => '30',
                           'disabled'    => 'disabled'
                         );
                echo form_input($datatelefono);
                echo form_error('telefono','<div>','</div>');
            ?>
            </p>
            </td>
        </tr>
        <tr>
            <td>
            <p>
            <?php
                $select = array();
                echo form_label('Estado', 'estado');
                $select[''] = "-- Seleccione --";
                foreach($estados as $row) {
                    $select[$row->IDESTADO] = $row->NOMBREESTADO;
                }
                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                echo form_dropdown('estado', $select,'','id="estado" class="chosen" placeholder="-- Seleccione --" ');

                echo form_error('estado','<div><b><font color="red">','</font></b></div>');
            ?>
            </p>
            </td>
            <td>
            <p>
                &nbsp;
            </p>
            </td>
        </tr>
        </table>
        <br>
        <br>
        <table cellspacing="0" cellspading="0" border="0" align="center">
        <tr>
            <td colspan="2">
            <p>
            <?php
                //echo form_label('Notificacion<span class="required">*</span>', 'notificacion');
                $datanotificacion = array(
                           'name'        => 'notificacion',
                           'id'          => 'notificacion',
                           'value'       => set_value('notificacion'),
                           'width'        => '80%',
                           'heigth'       => '50%'
                         );
                echo form_textarea($datanotificacion);
                echo form_error('notificacion','<div>','</div>');
            ?>
            </p>
            </td>
        </tr>
        <tr>
            <td>
            <p>
            <?php
                echo form_label('N&uacute;mero de radicado Onbase', 'onbase');
                $dataonbase = array(
                           'name'        => 'onbase',
                           'id'          => 'onbase',
                           'value'       => '',
                           'maxlength'   => '10',
                         );
                echo "<br>".form_input($dataonbase);
                echo form_error('onbase','<div>','</div>');
            ?>
            </p>
            </td>
            <td>
            <div class="span3">    
            <?php
                echo form_label('Fecha notificaci&oacute;n', 'fechanotificacion');
                $dataFecha = array(
                          'name'        => 'fechanotificacion',
                          'id'          => 'fechanotificacion',
                          'value'       => date('d/m/Y'),
                          'maxlength'   => '12',
                          'readonly'    => 'readonly',
                          'size'        => '15'
                        );

               echo form_input($dataFecha)."&nbsp;";
               echo form_error('fechanotificacion','<div>','</div>');

               echo form_hidden('fechanotificaciond',date("d/m/Y"));
            ?>
            </div>
            </td>
        </tr>
        <tr>
            <td>
            <p>
            <?php
                echo form_label('Fecha Onbase', 'fechaonbase');
                $dataFechaOn = array(
                          'name'        => 'fechaonbase',
                          'id'          => 'fechaonbase',
                          'value'       => '',
                          'maxlength'   => '12',
                          'readonly'    => 'readonly',
                          'size'        => '15'
                        );

               echo "<br>".form_input($dataFechaOn)."&nbsp;";
               echo form_error('fechaonbase','<div>','</div>');

               echo form_hidden('fechaonbased',date("d/m/Y"));
            ?>
            </p>
            </td>
            <td>
                <div class="span3">
                <?php
                    echo form_label('Cargar colilla<br>', 'filecolilla');
                    $datafile = array(
                               'name'        => 'userfile',
                               'id'          => 'filecolilla',
                               'value'       => '',
                               'maxlength'   => '10',
                             );
                    echo "<br>".form_upload($datafile);
                    echo form_error('filecolilla','<div>','</div>');
                ?>
                </div>
            </td>
        </tr>
        <tr>
            <td align="left">
                <p>
                <?php
                    $selecte = array();
                    echo form_label('Estado&nbsp;&nbsp;<span class="required"><font color="red"><b>*</b></font></span>', 'estado_id');
                    $selecte[''] = "-- Seleccione --";
                    $selecte['1'] = "ELABORADO";
                    $selecte['2'] = "RADICADO";
                    echo "<br>".form_dropdown('estado_id', $selecte, '', 'id="estado_id" class="chosen" data-placeholder="seleccione..." ');

                    echo form_error('estado_id','<div>','</div>');
                ?>
                </p>
            </td>
            <td align="center" nowrap="nowrap">
                <p>
                <div class="span3">
                    <?php
                    $results=array();
                    $cRuta  = "./application/uploads/";
                    $cRuta .= "mandamientos/diario/";
                    //echo $cRuta."<br>";
                    @$handler = opendir($cRuta);
                    if ($handler){
                        while ($file = readdir($handler)) {
                            if ($file != '.' && $file != '..')
                                $results[] = $file;
                        }
                        closedir($handler);
                    }
                    if(count($results)>0){?>
                    <div align="left">
                        <?php
                        $cCadena = "";
                        echo "Lista de Adjuntos<br>";
                        for($x=0; $x<count($results); $x++) {
                              $cCadena  = "&nbsp;"; //<img src='../../img/trash.png' style='cursor:pointer' title='Eliminar'";
                              //$cCadena .= "onclick=javascript:f_DeleteAdj('".$cRuta."{$results[$x]}')>&nbsp;";
                              $cCadena .= ($x+1).". <a href='../../".$cRuta."{$results[$x]}' target=_blank>&nbsp;Colilla"; // $results[$x]
                              $cCadena .= "</a><br>";
                              echo $cCadena;
                        }
                        echo "<br>";?>
                        </div>
                    <?php } ?>
                </div>
                </p>
            </td>
        </tr>
        <tr>
            <td colspan="2">
            <p>
            <?php
                echo form_label('Observaci&oacute;n&nbsp;&nbsp;', 'observacion');
                $data = array(
                            'name'        => 'observacion',
                            'id'          => 'observacion',
                            'value'       => set_value('observacion'),
                            'width'       => '120%',
                            'heigth'      => '5%',
                            'style'       => 'width:83%'
                          );

                echo "&nbsp;&nbsp;".form_textarea($data);
                echo form_error('observacion','<div><b><font color="red">','</font></b></div>');
            ?>
            </p>
            </td>
        </tr>
        <tr>
            <td colspan="2">
            <p>
                <?php
                echo form_label('C&oacute;digo comunicaci&oacute;n', 'comunicacion');
                $datacomunica = array(
                           'name'        => 'comunicacion',
                           'id'          => 'comunicacion',
                           'value'       => set_value('comunicacion'),
                           'maxlength'   => '50'
                         );
                echo "<br>".form_input($datacomunica);
                echo form_error('comunicacion','<div>','</div>');
                ?>
            </p>
            </td>
        </tr>
        <tr>
            <td align="center" colspan="2">
            <p>
                <div id="error"></div>
            </p>
            <div id="bloqueo"></div>
            <p>
            <?php 
            $dataguardar = array(
                   'name' => 'guardar',
                   'id' => 'guardar',
                   'value' => 'Guardar',
                   'type' => 'button',
                   'content' => '<i class="fa fa-floppy-o fa-lg"></i> Guardar',
                   'class' => 'btn btn-success'
                   );
            echo form_button($dataguardar)."&nbsp;&nbsp;";
            $dataPDF = array(
                   'name' => 'button',
                   'id' => 'pdf',
                   'value' => 'Generar PDF',
                   'type' => 'button',
                   'content' => '<i class="fa fa-file"></i> Generar PDF',
                   'class' => 'btn btn-info'
                   );
            echo form_button($dataPDF)."&nbsp;&nbsp;";
            /*$dataprint = array(
                   'name' => 'button',
                   'id' => 'print-button',
                   'value' => 'Imprimir',
                   'type' => 'button',
                   'content' => '<i class="fa fa-print"></i> Imprimir',
                   'class' => 'btn btn-success'
                   );
            echo form_button($dataprint)."&nbsp;&nbsp;";*/
            $datacancel = array(
                   'name' => 'button',
                   'id' => 'cancel-button',
                   'value' => 'Cancelar',
                   'type' => 'button',
                   'onclick' => 'window.location=\''.base_url().'index.php/mandamientopago/manage\';',
                   'content' => '<i class="fa fa-trash-o"></i> Cancelar',
                   'class' => 'btn btn-warning'
                   );
            echo form_button($datacancel);
            ?>
            </p>
            </td>
        </tr>
        </table>
        <?php echo form_close(); ?>

</div>
  <script type="text/javascript">
      $(document).ready(function() {
          $('#fechanotificacion').datepicker({dateFormat: "dd/mm/y"});
          $('#fechaonbase').datepicker({dateFormat: "dd/mm/y"});
      });
      
      $('#guardar').click(function() {
        $('#error').html("");
        tinyMCE.triggerSave();
        var notify = $('#notificacion').val();
        var estado = $('#estado_id').val();
        var onbase = $('#onbase').val();
        var fechaonb = $('#fechaonbase').val();
        var fechanot = $('#fechanotificacion').val();
        var valida = true;
        if (notify == "") {
            $('#error').html("<font color='red'><b>Ingrese Notificaci&oacute;n</b></font>");
            valida = false;
        }
        else if (estado == "") {
            $('#error').html("<font color='red'><b>Seleccione un Estado</b></font>");
            valida = false;
        }
        if (estado == "2" && onbase == "") {
            $('#error').html("<font color='red'><b>Ingrese N&uacute;mero de radicado Onbase</b></font>");
            valida = false;
        }
        if (fechaonb != "" && fechanot != "" && valida == true) {
            anoonb = parseInt(fechaonb.split("/")[2]);
            mesonb = parseInt(fechaonb.split("/")[1]) -1;
            diaonb = parseInt(fechaonb.split("/")[0])
            anonot = parseInt(fechanot.split("/")[2]);
            mesnot = parseInt(fechanot.split("/")[1]) -1;
            dianot = parseInt(fechanot.split("/")[0])
            fechaonbase = new Date(anoonb, mesonb, diaonb);
            fechanotify = new Date(anonot, mesnot, dianot);
            //alert("Not: "+fechanotify);
            //alert("Onbase: "+fechaonbase);
            if (fechanotify < fechaonbase) {
                $('#error').html("<font color='red'><b>La fecha de Notificaci&oacute;n no puede ser menor que la fecha de Onbase</b></font>");
                valida =  false;
            }
        }
        
        if (valida == true) {
            // Llamado al bloqueo de 15 días
            /*var ruta = "<?php echo base_url('index.php/tiempos/bloqueo'); ?>";
            $("#bloqueo").load(ruta,{codfiscalizacion:114, gestion:114, 
                fecha:'19/02/14', mostrar:'SI', si:'http://yeah.com', no:'http://no.com', 
                parametros : 'casa:23C-81A;carro:Hyundai;saludo:Comoestas', BD:''},function(){
                
                });*/
              $("#bloqueo").load(ruta,{codfiscalizacion:510, gestion:510, fecha:'19/02/14', mostrar:'SI', si:'http://yeah.com', no:'http://no.com', parametros : 'casa:23C-81A;carro:Hyundai;saludo:Comoestas', BD:''},function(){});
            $('#guardar').prop("disabled",true);
            $('#diarioFrm').submit();
        }
    });
    
    $('#pdf').click(function() {
        tinyMCE.triggerSave();
        var notify = $('#notificacion').val();
        $('#mandamiento').val(notify);
        $('#diarioFrm').attr("action", "pdf");
        $('#diarioFrm').submit();
        $('#diarioFrm').attr("action", "diario");
    });
    
    function comprobarextension() {
        if ($("#filecolilla").val() != "") {
            $('#error').html();
            var archivo = $("#filecolilla").val();
            var extensiones_permitidas = new Array(".pdf");
            var mierror = "";
            //recupero la extensiÃ³n de este nombre de archivo
            var extension = (archivo.substring(archivo.lastIndexOf("."))).toLowerCase();
            //alert (extension);
            //compruebo si la extensiÃ³n estÃ¡ entre las permitidas
            var permitida = false;
            for (var i = 0; i < extensiones_permitidas.length; i++) {
                if (extensiones_permitidas[i] == extension) {
                  permitida = true;
                  break;
                }
            }
            if (!permitida) {
              jQuery("#filecolilla").val("");
              mierror = "Comprueba la extension de los archivos a subir.<br>Solo se pueden subir archivos con extensiones: " + extensiones_permitidas.join();
            }
            //si estoy aqui es que no se ha podido submitir
            if (mierror != "") {
              $('#error').html("<font color='red'><b>"+mierror+"</b></font>");
              $('#guardar').prop("disabled",false);
              return false;
            }
            return true;
        }
    }
    
    function f_DeleteAdj(xRuta) {
        if (confirm('¿Esta seguro de Eliminar el archivo?')) {
            document.forms['diarioFrm']['vRuta'].value=xRuta;
            document.forms['diarioFrm']['vUbicacion'].value="diario";
            document.forms['diarioFrm'].action="delFile";
            document.forms['diarioFrm'].submit();
            document.forms['diarioFrm'].action="diario";
        }
    }
  </script>