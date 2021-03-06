
<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert">&times;</button>
    <?php
    if (isset($message)) {
        echo $message;
    } else {
        echo "Adjunte los archivos correspondientes a subir en el expediente";
    }
    ?>
</div>   
<div class="preload"></div><img class="load" src="<?php echo base_url('img/27.gif'); ?>" width="128" height="128" />
<div class="caja_negra" id="caja_negra" style="width: 60%; background: #F8F8F8; border-color: black; border: 1px solid grey; margin: auto; overflow: hidden;alignment-adjust: central ;padding: 15px 50px 0">
    <?php
    $attributes = array("id" => "myform");
    echo form_open_multipart("remisibilidad/Soporte_Expediente", $attributes);
    ?> 
    <input type="hidden" id="cod_coactivo" name="cod_coactivo" value="<?php echo $cod_coactivo; ?>" readonly> 
    <input type="hidden" id="cod_respuesta" name="cod_respuesta" value="<?php echo $cod_respuesta; ?>"  readonly> 
    <input type="hidden" id="comentario" name="comentario" readonly>  
    <input type="hidden" id="fecha" name="fecha" readonly>  
    <input type="hidden" id="numero" name="numero" readonly >  
    <center>
        <?php
        echo form_label('<b>Tipo de Archivo:</b> <span class="required"></span>', 'cod_tipo');
        echo "<div style=' color: red ;font-size:19px'>$tipo</div>";
        echo form_error('tipo_archivo', '<div>', '</div>');
        ?>
        <br>        
    </center>
    <div id="carga_archivo" class="alert-success"></div><br>    
    <br>
    <center>        
        <?php
        $data = array(
            'name' => 'cargar',
            'id' => 'cargar',
            'content' => '<i class="fa fa-cloud-upload"></i> Anexar Documento Soporte',
            'class' => 'btn btn-warning cargar'
        );
        echo form_button($data);
        ?>
        <br><br>
        <div class="respuesta" id="respuesta"></div>
    </center>
</div>
<br>

<div id="aviso_remate" class="aviso_remate"  style="width: 65%; border-color: black; border: 1px solid grey; margin: auto; overflow: hidden;alignment-adjust: central ;padding: 15px 50px 0">
    <br>
    <center>
        <b>N° Radicado:</b> <input type="text" name="numero_radicacion" id="numero_radicacion" class="span1" /> -
        <b>Fecha de Radicado:</b> <input name="fecha_radicacion" id="fecha_radicacion" type="text" class="span2" readonly/>
    </center>   
    <?php
    echo form_label('<b>Comentarios</b><span class="required"></span>', 'lb_comentarios');
    $datacomentarios = array(
        'name' => 'comentarios',
        'id' => 'comentarios',
        'maxlength' => '300',
        'class' => 'span8 descripcion',
        'rows' => '3',
        'required' => 'required'
    );
    echo form_textarea($datacomentarios);
    echo '<br>';
    ?>   
    <br>
</div>
<div id="resultado"></div>
<input type="hidden" name="documento" id="documento" value="<?php print_r($documento); ?>"/>
<br>
<center>
    <?php
    $data = array(
        'name' => 'button',
        'id' => 'generar',
        'value' => 'seleccionar',
        'onclick' => 'comprobarextension()',
        'content' => '<i class="fa fa-floppy-o"></i> Incluir al Expediente',
        'class' => 'btn btn-success generar'
    );
    $data_2 = array(
        'name' => 'button',
        'id' => 'push',
        'value' => 'seleccionar',
        'content' => '<i class="fa fa-eye"></i> Vista Previa',
        'class' => 'btn btn-info'
    );
    $data_3 = array(
        'name' => 'button',
        'id' => 'imprimir',
        'value' => 'seleccionar',
        'content' => '<i class="fa fa-print"></i> Imprimir',
        'class' => 'btn btn-info'
    );
    $data_4 = array(
        'name' => 'button',
        'id' => 'cancelar',
        'value' => 'info',
        'content' => '<i class="fa fa-minus-circle"></i> Cancelar',
        'class' => 'btn btn-warning'
    );
    echo form_button($data) . " " . form_button($data_2) . " " . form_button($data_3) . " " . form_button($data_4);
    ?>
    <?php echo form_close(); ?>
</center>
<script>
    $("#preloadmini").hide();
    $("#fecha_aviso").hide();
    jQuery(".preload, .load").hide();
    $("#push").click(function() {
        $(".preload, .load").show();
        var coactivo = <?php echo $cod_coactivo; ?>;
        var url5 = "<?php echo base_url("index.php/remisibilidad/VistaPrevia_Documento"); ?>";
        $("#resultado").load(url5, {cod_coactivo: coactivo}, function() {
            $(".preload, .load").hide();
        });
        //jQuery(".preload, .load").hide();
    });
    function comprobarextension() {
        if (cantidad_documentos == 0) {
            alert('Debe adjuntar como minimo un soporte al expediente');
        } else {
            if ($("#userfile").val() != "") {
                var archivo = $("#userfile").val();
                var extensiones_permitidas = new Array(".pdf", ".jpg", ".png", ".jpeg");
                var mierror = "";
                //recupero la extensiÃ³n de este nombre de archivo
                var extension = (archivo.substring(archivo.lastIndexOf("."))).toLowerCase();
                //compruebo si la extensiÃ³n estÃ¡ entre las permitidas
                var permitida = false;
                for (var i = 0; i < extensiones_permitidas.length; i++) {
                    if (extensiones_permitidas[i] == extension) {
                        permitida = true;
                    }
                }
                if (!permitida) {
                    jQuery("#userfile").val("");
                    mierror = '<div  class="alert alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button>' + 'Comprueba la extensión de los archivos a subir.\nSólo se pueden subir archivos con extensiones: ' + extensiones_permitidas.join() + '</div>';
                    $("#respuesta").css('display', 'block');
                    document.getElementById("respuesta").innerHTML = mierror;
                }
                //si estoy aqui es que no se ha podido submitir
                else {
                    	var file = $("#userfile")[0].files[0];
					var fileSize = file.size;
					var resultado = 0;
					if(fileSize > 5242880) {
						$('#userfile').val('');
						resultado = (fileSize/1024)/1024;
						var resultado1 = Math.round(resultado*100)/100 ; 
						mierror = "";
						mierror = '<div  class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>' + 'El archivo (' + archivo + ') a superado el limite de tamaño para adjuntos de 5Mb. Tamaño archivo de: ' + resultado1 + ' Mb </div>';

						$("#respuesta").css('display', 'block');
						document.getElementById("respuesta").innerHTML = mierror;
						$("#respuesta");
					} else {
							var file = $("#userfile")[0].files[0];
							var fileSize = file.size;
							var resultado = 0;
							if(fileSize > 5242880) {
								$('#userfile').val('');
								resultado = (fileSize/1024)/1024;
								var resultado1 = Math.round(resultado*100)/100 ; 
								mierror = "";
								mierror = '<div  class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>' + 'El archivo (' + archivo + ') a superado el limite de tamaño para adjuntos de 5Mb. Tamaño archivo de: ' + resultado1 + ' Mb </div>';

								$("#respuesta").css('display', 'block');
								document.getElementById("respuesta").innerHTML = mierror;
								$("#respuesta");
							} else {
								enviar();
							}
					}
                }
            } else {
                alert('Debe seleccionar un documento');

            }
        }
    }
    $("#fecha_radicacion").datepicker({
        dateFormat: "yy/mm/dd",
        dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
        dayNamesShort: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
        monthNames:
                ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
                    "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
        monthNamesShort:
                ["Ene", "Feb", "Mar", "Abr", "May", "Jun",
                    "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
        maxDate: "0"
    });
    function enviar() {
        if (cantidad_documentos == 0) {
            alert('Debe adjuntar como minimo un soporte al expediente');
        } else {
            if ($("#userfile").val().length > 0) {
                var Descripcion = $('#descripcion').val();
                $('#comentario').val(Descripcion);
                var Fecha = $('#fecha_radicacion').val();
                $('#fecha').val(Fecha);
                var Numero = $('#numero_radicacion').val();
                $('#numero').val(Numero);
                $('#myform').submit();
            } else {
                alert('Debe adjuntar como minimo un soporte al expediente');
            }
        }
    }
    var cantidad_documentos = 0;
    $("#cargar").click(function() {
        if (cantidad_documentos == 1) {
            alert('Solo se permite la subida de un archivo');
        } else {
            cantidad_documentos++;
            caja = document.createElement("input");
            caja.setAttribute("type", "file");
            caja.setAttribute("id", "userfile");
            caja.setAttribute("name", "userfile[]");
            document.getElementById("carga_archivo").appendChild(caja);
        }
    });
    $('#imprimir').click(function() {
        var tipo = '2';
        var informacion = $('#documento').val();
        var nombre = "<?php echo $tipo . "-" . $cod_coactivo; ?>";
        var encabezado = "<?php echo $titulo_encabezado; ?>";
        var estado = "<?php echo $cod_respuesta; ?>";
        if (informacion == "" || nombre == "" || encabezado == "") {
            alert('No se puede continuar hasta que haya realizado en cuerpo del documento');
            return false;
        }
        $(".preload, .load").show();
        var url = '<?php echo base_url('index.php/remisibilidad/pdf') ?>';
        redirect_by_post(url, {
            html: informacion,
            nombre: nombre,
            titulo: encabezado,
            tipo: tipo
        }, true);
        $(".preload, .load").hide();
    });
    $('#cancelar').click(function() {
        window.history.back(-1);
    });
    function redirect_by_post(purl, pparameters, in_new_tab) {
        pparameters = (typeof pparameters == 'undefined') ? {} : pparameters;
        in_new_tab = (typeof in_new_tab == 'undefined') ? true : in_new_tab;
        var form = document.createElement("form");
        $(form).attr("id", "reg-form").attr("name", "reg-form").attr("action", purl).attr("method", "post").attr("enctype", "multipart/form-data");
        if (in_new_tab) {
            $(form).attr("target", "_blank");
        }
        $.each(pparameters, function(key) {
            $(form).append('<textarea name="' + key + '" >' + this + '</textarea>');
        });
        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
        return false;
    }


</script> 
<style>
    .columna_derecha {
        float:right; /* Alineación a la derecha */
        width:20%;        
        //  border:solid lightblue 1px;
    }

    .columna_izquierda {
        float:left; /* Alineación a la izquierda */
        width:50%;
        margin-left:10%;
        // border:solid lightblue 1px;
    }

    .columna_central {
        margin-left:20%; /* Espacio para la columna izquierda */
        margin-right:10%; /* Espacio para la columna derecha */
        //  border:solid navy 1px;
    }
</style>