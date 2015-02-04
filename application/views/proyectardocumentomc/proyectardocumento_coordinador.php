<?php
if (isset($message)) {
    echo $message;
}
?>
<div class="preload"></div><img class="load" src="<?php echo base_url('img/27.gif'); ?>" width="128" height="128" />
<br><br>
<h1>Gestionar Medidas Cautelares<br><?php echo $titu ?></h1>
<br>
<br><br>
<table id="tablaq">
    <thead>
        <tr>
            <th>Proceso</th>
            <th>Identificacion</th>
            <th>Ejecutado</th>
            <th>Concepto</th>
            <th>Proceso Dineros</th>
            <th>Gesti&oacute;n</th>
            <th>Proceso Bienes</th>
            <th>Gesti&oacute;n</th>
            <th>Trazabilidad</th>
            <th>Documentos Generados</th>
        </tr>
    </thead>
    <tbody>
<!--    <pre>
        <?php print_r($consulta) ?>
    </pre>-->
        <?php
        // if (!empty($titulos_seleccionados)) {
        foreach ($consulta as $data) {
            ?> 
            <tr> 
                <td><?php echo $data['PROCESOPJ']?></td>
                <td><?php echo $data['CODEMPRESA'] ?></td>
                <td><?php echo $data['NOMBRE_EMPRESA'] ?></td>
                <td><?php echo $data['NOMBRE_CONCEPTO'] ?></td>
                <td><?php echo $data['TIPOGESTION'] ?></td>
                <td align="center">
                    <?php 
//                    echo $data['COD_MEDIDACAUTELAR'];
                   // echo $data['COD_RESPUESTAGESTION'];
                    switch ($data['COD_RESPUESTAGESTION']) {
                        // AUTO
                        case INICIO_COORDINADOR:
                            ?>
                            <input class="push" type="radio" name="gestion" onclick="coordinador('<?php echo $data['COD_MEDIDACAUTELAR'] ?>', '<?php echo $data['COD_FISCALIZACION'] ?>', '<?php echo $data['CODEMPRESA'] ?>', '<?php echo $data['COD_MEDIDACAUTELAR'] ?>', '<?php echo AUTO1; ?>', '1', '<?php echo DEVOLUCION; ?>', '<?php echo $respuesta="" ?>','<?php echo SUBIR_ARCHIVO; ?>')"  />
                            
                            <?php
                            break;
                        // auto de levantamiento de medidas cautelarias
                        case AUTO_LEVANTAMIENTO:
                            ?>
                            <input class="push" type="radio" name="gestion" onclick="gestion('<?php echo $data['COD_MEDIDACAUTELAR'] ?>', '<?php echo $data['COD_FISCALIZACION'] ?>', '<?php echo $data['CODEMPRESA'] ?>', '<?php echo AUTO1; ?>', '<?php echo AUTO_INICIO_SECRETARIO; ?>', '3', '<?php echo $respuesta="" ?>')"  />
                            <?php
                            break;
                        case AUTO_DEVOLUCION:
                            ?>
                            <input class="push" type="radio" name="gestion" onclick="gestion('<?php echo $data['COD_MEDIDACAUTELAR'] ?>', '<?php echo $data['COD_FISCALIZACION'] ?>', '<?php echo $data['CODEMPRESA'] ?>', '<?php echo AUTO2; ?>', '<?php echo AUTO_ENVIAR_MODIFICACIONES; ?>', '3', '<?php echo $respuesta="" ?>')"  />
                            <?php
                            break;
                        case AUTO_INICIO_SECRETARIO:
                            ?>
                            <input class="push" type="radio" name="gestion" onclick="secretaria('<?php echo $data['COD_MEDIDACAUTELAR'] ?>', '<?php echo $data['COD_FISCALIZACION'] ?>', '<?php echo $data['CODEMPRESA'] ?>', '<?php echo $data['COD_MEDIDACAUTELAR'] ?>', '<?php echo AUTO2; ?>', '3', '<?php echo AUTO_DEVOLUCION; ?>', '<?php echo $respuesta="" ?>','<?php echo AUTO_INICIO_COORDINADOR; ?>')"  />
                            <?php
                            break;
                        case AUTO_INICIO_COORDINADOR:
                            ?>
                            <input class="push" type="radio" name="gestion" onclick="coordinador('<?php echo $data['COD_MEDIDACAUTELAR'] ?>', '<?php echo $data['COD_FISCALIZACION'] ?>', '<?php echo $data['CODEMPRESA'] ?>', '<?php echo $data['COD_MEDIDACAUTELAR'] ?>', '<?php echo AUTO2; ?>', '3', '<?php echo AUTO_DEVOLUCION; ?>', '<?php echo $respuesta="" ?>','<?php echo AUTO_SUBIR_ARCHIVO; ?>')"  />
                            <?php
                            break;
                        case AUTO_SUBIR_ARCHIVO:
                            ?>
                            <a href="javascript:" title="" class="fa fa-archive" onclick="subir_acta('<?php echo $data['COD_MEDIDACAUTELAR'] ?>', '<?php echo $data['COD_FISCALIZACION'] ?>', '<?php echo $data['CODEMPRESA'] ?>', '<?php echo $data['COD_MEDIDACAUTELAR'] ?>', '<?php echo base_url('index.php/mcinvestigacion/subir_documento_doc1'); ?>', '<?php echo AUTO2; ?>', '1', '<?php echo AUTO_ARCHIVO_APROBADO; ?>')"></a>
                            
                            <?php
                            break;
                        case AUTO_ARCHIVO_APROBADO:
                            ?>
                            <input class="push" type="radio" name="gestion" onclick="confirmar_valores('<?php echo $data['COD_MEDIDACAUTELAR'] ?>', '<?php echo $data['COD_FISCALIZACION'] ?>', '<?php echo $data['CODEMPRESA'] ?>', '<?php echo ""; ?>', '<?php echo GENERAR_FRACCIONAMIENTO; ?>','0')"  />
                            
                            <?php
                            break;
                        //Oficio Orden de Investigacion y Envargo de Dinero ****************************************************+
                        // Generar oficio bienes
                        case APROVACION_BIENES_GENERALES:
                            ?>
                            <input class="push" type="radio" name="gestion" onclick="prelacion('<?php echo $data['COD_MEDIDACAUTELAR'] ?>', '<?php echo $data['COD_FISCALIZACION'] ?>', '<?php echo $data['CODEMPRESA'] ?>', '<?php echo PRELACION; ?>', '<?php echo APROVACION_BIENES_GENERALES; ?>','<?php echo $informacion; ?>')"  />
                            
                            <?php
                            break;
                        //Fin Generar oficio bienes ****************************************************+
                        // Fraccionamiento de titulo
                        case GENERAR_FRACCIONAMIENTO:
                            ?>
                            <input class="push" type="radio" name="gestion" onclick="gestion('<?php echo $data['COD_MEDIDACAUTELAR'] ?>', '<?php echo $data['COD_FISCALIZACION'] ?>', '<?php echo $data['CODEMPRESA'] ?>', '<?php echo FRACCIONAMIENTO; ?>', '<?php echo FRACCIONAMIENTO_INICIO_SECRETARIO; ?>', '4', '<?php echo $respuesta="" ?>')"  />
                            
                            <?php
                            break;
                        case FRACCIONAMIENTO_DEVOLUCION:
                            ?>
                            <input class="push" type="radio" name="gestion" onclick="gestion('<?php echo $data['COD_MEDIDACAUTELAR'] ?>', '<?php echo $data['COD_FISCALIZACION'] ?>', '<?php echo $data['CODEMPRESA'] ?>', '<?php echo FRACCIONAMIENTO; ?>', '<?php echo FRACCIONAMIENTO_ENVIAR_MODIFICACIONES; ?>', '4', '<?php echo $respuesta="" ?>')"  />
                            
                            <?php
                            break;
                        case FRACCIONAMIENTO_INICIO_SECRETARIO:
                            ?>
                            <input class="push" type="radio" name="gestion" onclick="secretaria('<?php echo $data['COD_MEDIDACAUTELAR'] ?>', '<?php echo $data['COD_FISCALIZACION'] ?>', '<?php echo $data['CODEMPRESA'] ?>', '<?php echo $data['COD_MEDIDACAUTELAR'] ?>', '<?php echo FRACCIONAMIENTO; ?>', '4', '<?php echo FRACCIONAMIENTO_DEVOLUCION; ?>', '<?php echo $respuesta="" ?>','<?php echo FRACCIONAMIENTO_INICIO_COORDINADOR; ?>')"  />
                            
                                <?php
                            break;
                        case FRACCIONAMIENTO_INICIO_COORDINADOR:
                            ?>
                            <input class="push" type="radio" name="gestion" onclick="coordinador('<?php echo $data['COD_MEDIDACAUTELAR'] ?>', '<?php echo $data['COD_FISCALIZACION'] ?>', '<?php echo $data['CODEMPRESA'] ?>', '<?php echo $data['COD_MEDIDACAUTELAR'] ?>', '<?php echo FRACCIONAMIENTO; ?>', '4', '<?php echo FRACCIONAMIENTO_DEVOLUCION; ?>', '<?php echo $respuesta="" ?>','<?php echo FRACCIONAMIENTO_SUBIR_ARCHIVO; ?>')"  />
                            
                            <?php
                            break;
                        case FRACCIONAMIENTO_SUBIR_ARCHIVO:
                            ?>
                            <a href="javascript:" title="" class="fa fa-archive" onclick="subir_acta('<?php echo $data['COD_MEDIDACAUTELAR'] ?>', '<?php echo $data['COD_FISCALIZACION'] ?>', '<?php echo $data['CODEMPRESA'] ?>', '<?php echo $data['COD_MEDIDACAUTELAR'] ?>', '<?php echo base_url('index.php/mcinvestigacion/subir_documento_doc1'); ?>', '<?php echo FRACCIONAMIENTO; ?>', '1', '<?php echo FRACCIONAMIENTO_ARCHIVO_APROBADO; ?>')"></a>
                            
                            <?php
                            break;
                        case FRACCIONAMIENTO_ARCHIVO_APROBADO:
                            ?>
                            <input class="push" type="radio" name="gestion" onclick="confirmar_valores('<?php echo $data['COD_MEDIDACAUTELAR'] ?>', '<?php echo $data['COD_FISCALIZACION'] ?>', '<?php echo $data['CODEMPRESA'] ?>', '<?php echo ""; ?>', '<?php echo OFICIO_SECRETARIO; ?>','1')"  />
                            
                            <?php
                            break;
                        //Fin Fraccionamiento de titulo ****************************************************+
                        case OFICIO_COORDINADOR:
                            ?>
                            <input class="push" type="radio" name="gestion" onclick="coordinador('<?php echo $data['COD_MEDIDACAUTELAR'] ?>', '<?php echo $data['COD_FISCALIZACION'] ?>', '<?php echo $data['CODEMPRESA'] ?>', '<?php echo $data['COD_MEDIDACAUTELAR'] ?>', '<?php echo OFICIO; ?>', '2', '<?php echo OFICIO_DEVOLUCION; ?>', '<?php echo $respuesta="" ?>','<?php echo OFICIO_SUBIR_ARCHIVO; ?>')"  />
                            
                            <?php
                            break;
                        case OFICIO_COORDINADOR2:
                            ?>
                            <input class="push" type="radio" name="gestion" onclick="coordinador('<?php echo $data['COD_MEDIDACAUTELAR'] ?>', '<?php echo $data['COD_FISCALIZACION'] ?>', '<?php echo $data['CODEMPRESA'] ?>', '<?php echo $data['COD_MEDIDACAUTELAR'] ?>', '<?php echo OFICIO2; ?>', '55', '<?php echo OFICIO_DEVOLUCION2; ?>', '<?php echo $respuesta="" ?>','<?php echo OFICIO_SUBIR_ARCHIVO2; ?>')"  />
                            
                            <?php
                            break;
                        case APRUEBA_DINEROS_BANCOS://aparecen los documentos donde van hacer debitados los valores
                            ?>
                            <a href="javascript:" title="Respuesta" class="fa fa-bookmark-o" onclick="bancarios('<?php echo $data['COD_MEDIDACAUTELAR'] ?>', '<?php echo $data['COD_FISCALIZACION'] ?>', '<?php echo $data['CODEMPRESA'] ?>', '<?php echo RESPUESTA; ?>','<?php echo APRUEBA_DINEROS_BANCOS_CONFIRMAR; ?>')"></a>
                            
                            <?php
                            break;
                        case APRUEBA_DINEROS_BANCOS_CONFIRMAR://aparecen los documentos donde van hacer debitados los valores
                            ?>
                            <a href="javascript:" title="Respuesta" class="fa fa-bookmark-o" onclick="confirmar_pago('<?php echo $data['COD_MEDIDACAUTELAR'] ?>', '<?php echo $data['COD_FISCALIZACION'] ?>', '<?php echo $data['CODEMPRESA'] ?>', '<?php echo RESPUESTA; ?>','<?php echo APRUEBA_DINEROS_BANCOS_CONFIRMAR; ?>')"></a>
                            
                            <?php
                            break;
                    }
                    ?>
                </td>
                <td><?php echo $data['TIPOGESTION2'] ?></td>
                <td align="center">
                    <?php 
//                    echo $data['COD_MEDIDACAUTELAR'];
//                    echo $data['COD_RESPUESTAGESTION_BIENES'];
                    switch ($data['COD_RESPUESTAGESTION_BIENES']) {
                        // auto de levantamiento de medidas cautelarias
                        case AUTO_LEVANTAMIENTO:
                            ?>
                            <input class="push" type="radio" name="gestion" onclick="gestion('<?php echo $data['COD_MEDIDACAUTELAR'] ?>', '<?php echo $data['COD_FISCALIZACION'] ?>', '<?php echo $data['CODEMPRESA'] ?>', '<?php echo AUTO1; ?>', '<?php echo AUTO_INICIO_SECRETARIO; ?>', '3', '<?php echo $respuesta="" ?>')"  />
                            <?php
                            break;
                        case AUTO_DEVOLUCION:
                            ?>
                            <input class="push" type="radio" name="gestion" onclick="gestion('<?php echo $data['COD_MEDIDACAUTELAR'] ?>', '<?php echo $data['COD_FISCALIZACION'] ?>', '<?php echo $data['CODEMPRESA'] ?>', '<?php echo AUTO2; ?>', '<?php echo AUTO_ENVIAR_MODIFICACIONES; ?>', '3', '<?php echo $respuesta="" ?>')"  />
                            <?php
                            break;
                        case AUTO_INICIO_SECRETARIO:
                            ?>
                            <input class="push" type="radio" name="gestion" onclick="secretaria('<?php echo $data['COD_MEDIDACAUTELAR'] ?>', '<?php echo $data['COD_FISCALIZACION'] ?>', '<?php echo $data['CODEMPRESA'] ?>', '<?php echo $data['COD_MEDIDACAUTELAR'] ?>', '<?php echo AUTO2; ?>', '3', '<?php echo AUTO_DEVOLUCION; ?>', '<?php echo $respuesta="" ?>','<?php echo AUTO_INICIO_COORDINADOR; ?>')"  />
                            <?php
                            break;
                        case AUTO_INICIO_COORDINADOR:
                            ?>
                            <input class="push" type="radio" name="gestion" onclick="coordinador('<?php echo $data['COD_MEDIDACAUTELAR'] ?>', '<?php echo $data['COD_FISCALIZACION'] ?>', '<?php echo $data['CODEMPRESA'] ?>', '<?php echo $data['COD_MEDIDACAUTELAR'] ?>', '<?php echo AUTO2; ?>', '3', '<?php echo AUTO_DEVOLUCION; ?>', '<?php echo $respuesta="" ?>','<?php echo AUTO_SUBIR_ARCHIVO; ?>')"  />
                            <?php
                            break;
                        case AUTO_SUBIR_ARCHIVO:
                            ?>
                            <a href="javascript:" title="" class="fa fa-archive" onclick="subir_acta('<?php echo $data['COD_MEDIDACAUTELAR'] ?>', '<?php echo $data['COD_FISCALIZACION'] ?>', '<?php echo $data['CODEMPRESA'] ?>', '<?php echo $data['COD_MEDIDACAUTELAR'] ?>', '<?php echo base_url('index.php/mcinvestigacion/subir_documento_doc1'); ?>', '<?php echo AUTO2; ?>', '1', '<?php echo AUTO_ARCHIVO_APROBADO; ?>')"></a>
                            
                            <?php
                            break;
                        case AUTO_ARCHIVO_APROBADO:
                            ?>
                            <input class="push" type="radio" name="gestion" onclick="confirmar_valores('<?php echo $data['COD_MEDIDACAUTELAR'] ?>', '<?php echo $data['COD_FISCALIZACION'] ?>', '<?php echo $data['CODEMPRESA'] ?>', '<?php echo ""; ?>', '<?php echo GENERAR_FRACCIONAMIENTO; ?>','0')"  />
                            
                            <?php
                            break;
                        //Oficio Orden de Investigacion y Envargo de Dinero ****************************************************+
                        // Generar oficio bienes
                        case OFICIO_BIENES_INICIO_COORDINADOR:
                            ?>
                            <input class="push" type="radio" name="gestion" onclick="coordinador('<?php echo $data['COD_MEDIDACAUTELAR'] ?>', '<?php echo $data['COD_FISCALIZACION'] ?>', '<?php echo $data['CODEMPRESA'] ?>', '<?php echo $data['COD_MEDIDACAUTELAR'] ?>', '<?php echo OFICIO1; ?>', '5', '<?php echo OFICIO_BIENES_DEVOLUCION; ?>', '<?php echo $respuesta="" ?>','<?php echo OFICIO_BIENES_SUBIR_ARCHIVO; ?>')"  />
                            
                            <?php
                            break;
                        case APROVACION_BIENES_GENERALES:
                            ?>
                            <input class="push" type="radio" name="gestion" onclick="prelacion('<?php echo $data['COD_MEDIDACAUTELAR'] ?>', '<?php echo $data['COD_FISCALIZACION'] ?>', '<?php echo $data['CODEMPRESA'] ?>', '<?php echo PRELACION; ?>', '<?php echo APROVACION_BIENES_GENERALES; ?>','<?php echo $informacion; ?>')"  />
                            
                            <?php
                            break;
                        //Fin Generar oficio bienes ****************************************************+
                        // Fraccionamiento de titulo
                        case GENERAR_FRACCIONAMIENTO:
                            ?>
                            <input class="push" type="radio" name="gestion" onclick="gestion('<?php echo $data['COD_MEDIDACAUTELAR'] ?>', '<?php echo $data['COD_FISCALIZACION'] ?>', '<?php echo $data['CODEMPRESA'] ?>', '<?php echo FRACCIONAMIENTO; ?>', '<?php echo FRACCIONAMIENTO_INICIO_SECRETARIO; ?>', '4', '<?php echo $respuesta="" ?>')"  />
                            
                            <?php
                            break;
                        case FRACCIONAMIENTO_DEVOLUCION:
                            ?>
                            <input class="push" type="radio" name="gestion" onclick="gestion('<?php echo $data['COD_MEDIDACAUTELAR'] ?>', '<?php echo $data['COD_FISCALIZACION'] ?>', '<?php echo $data['CODEMPRESA'] ?>', '<?php echo FRACCIONAMIENTO; ?>', '<?php echo FRACCIONAMIENTO_ENVIAR_MODIFICACIONES; ?>', '4', '<?php echo $respuesta="" ?>')"  />
                            
                            <?php
                            break;
                        case FRACCIONAMIENTO_INICIO_SECRETARIO:
                            ?>
                            <input class="push" type="radio" name="gestion" onclick="secretaria('<?php echo $data['COD_MEDIDACAUTELAR'] ?>', '<?php echo $data['COD_FISCALIZACION'] ?>', '<?php echo $data['CODEMPRESA'] ?>', '<?php echo $data['COD_MEDIDACAUTELAR'] ?>', '<?php echo FRACCIONAMIENTO; ?>', '4', '<?php echo FRACCIONAMIENTO_DEVOLUCION; ?>', '<?php echo $respuesta="" ?>','<?php echo FRACCIONAMIENTO_INICIO_COORDINADOR; ?>')"  />
                            
                                <?php
                            break;
                        case FRACCIONAMIENTO_INICIO_COORDINADOR:
                            ?>
                            <input class="push" type="radio" name="gestion" onclick="coordinador('<?php echo $data['COD_MEDIDACAUTELAR'] ?>', '<?php echo $data['COD_FISCALIZACION'] ?>', '<?php echo $data['CODEMPRESA'] ?>', '<?php echo $data['COD_MEDIDACAUTELAR'] ?>', '<?php echo FRACCIONAMIENTO; ?>', '4', '<?php echo FRACCIONAMIENTO_DEVOLUCION; ?>', '<?php echo $respuesta="" ?>','<?php echo FRACCIONAMIENTO_SUBIR_ARCHIVO; ?>')"  />
                            
                            <?php
                            break;
                        case FRACCIONAMIENTO_SUBIR_ARCHIVO:
                            ?>
                            <a href="javascript:" title="" class="fa fa-archive" onclick="subir_acta('<?php echo $data['COD_MEDIDACAUTELAR'] ?>', '<?php echo $data['COD_FISCALIZACION'] ?>', '<?php echo $data['CODEMPRESA'] ?>', '<?php echo $data['COD_MEDIDACAUTELAR'] ?>', '<?php echo base_url('index.php/mcinvestigacion/subir_documento_doc1'); ?>', '<?php echo FRACCIONAMIENTO; ?>', '1', '<?php echo FRACCIONAMIENTO_ARCHIVO_APROBADO; ?>')"></a>
                            
                            <?php
                            break;
                        case FRACCIONAMIENTO_ARCHIVO_APROBADO:
                            ?>
                            <input class="push" type="radio" name="gestion" onclick="confirmar_valores('<?php echo $data['COD_MEDIDACAUTELAR'] ?>', '<?php echo $data['COD_FISCALIZACION'] ?>', '<?php echo $data['CODEMPRESA'] ?>', '<?php echo ""; ?>', '<?php echo OFICIO_SECRETARIO; ?>','1')"  />
                            
                            <?php
                            break;
                    }
                    ?>
                </td>
                <td><button class="traza btn btn-success" fisca="<?php echo $data['COD_FISCALIZACION'];  ?>">Abrir</button></td>
                <td align="center"><button class="fa fa-folder-open-o" onclick="view_documentos('<?php echo $data['COD_MEDIDACAUTELAR'] ?>', '<?php echo $data['COD_FISCALIZACION']; ?>')"></button></td>
            </tr>

            <?php
        }
//}
        ?>
    </tbody>     
</table>
<div id="resultado"></div>

<form id="form_traza" target="_blank" action="<?php echo base_url('index.php/consultarprocesos/actualizatraza'); ?>" method="post">
    <input type="hidden" id="FISCALIZACION" name="FISCALIZACION">
</form>
<script type = "text/javascript" language = "javascript" charset = "utf-8">
    function  ajaxValidationCallback(){}

    $('.traza').click(function(){
        var FISCALIZACION=$(this).attr('fisca');
        $('#FISCALIZACION').val(FISCALIZACION);
        $('#form_traza').submit();
    });
    function gestion(id, cod_fis, nit, titulo, cod_siguiente, tipo_doc, respuesta,cod_siguiente_prelacion,id_prelacion) {
        if(!id_prelacion)
            id_prelacion="";
        if(!cod_siguiente_prelacion)
            cod_siguiente_prelacion="";
        jQuery(".preload, .load").show();
        var url = "<?php echo base_url('index.php/mcinvestigacion/gestion') ?>";
        $('#resultado').load(url, {id: id, cod_fis: cod_fis, nit: nit, titulo: titulo, cod_siguiente: cod_siguiente, tipo_doc: tipo_doc, respuesta: respuesta,id_prelacion:id_prelacion,cod_siguiente_prelacion:cod_siguiente_prelacion});
    }
    function secretaria(id, cod_fis, nit, id_mc, titulo, tipo_doc, devol, respuesta,cod_siguiente,cod_siguiente_prelacion,id_prelacion) {
        if(!id_prelacion)
            id_prelacion="";
        if(!cod_siguiente_prelacion)
            cod_siguiente_prelacion="";
        $(".preload, .load").show();
        var url = "<?php echo base_url('index.php/mcinvestigacion/documento') ?>";
        $('#resultado').load(url, {id: id, cod_fis: cod_fis, nit: nit, titulo: titulo, cod_siguiente: cod_siguiente, tipo_doc: tipo_doc, 
            respuesta: respuesta, id_mc: id_mc, devol: devol,id_prelacion:id_prelacion,cod_siguiente_prelacion:cod_siguiente_prelacion});
    }
    function coordinador(id, cod_fis, nit, id_mc, titulo, tipo_doc, devol, respuesta,cod_siguiente,cod_siguiente_prelacion,id_prelacion) {
        if(!id_prelacion)
            id_prelacion="";
        if(!cod_siguiente_prelacion)
            cod_siguiente_prelacion="";
        $(".preload, .load").show();
        var url = "<?php echo base_url('index.php/mcinvestigacion/documento') ?>";
        $('#resultado').load(url, {id: id, cod_fis: cod_fis, nit: nit, cod_siguiente: cod_siguiente, id_mc: id_mc, titulo: titulo, 
            tipo_doc: tipo_doc, devol: devol, respuesta: respuesta,id_prelacion:id_prelacion,cod_siguiente_prelacion:cod_siguiente_prelacion});
    }
    function view_documentos(id, id_mc) {
        $(".preload, .load").show();
        var url = "<?php echo base_url('index.php/mcinvestigacion/view_documentos') ?>";
        $('#resultado').load(url, {id: id, id_mc: id_mc});
    }
    function subir_acta(id, cod_fis, nit, id_mc, ruta, titulo, tipo, cod_siguiente,cod_siguiente_prelacion,id_prelacion) {
        if(!id_prelacion)
            id_prelacion="";
        if(!cod_siguiente_prelacion)
            cod_siguiente_prelacion="";
        $(".preload, .load").show();
        var url = "<?php echo base_url('index.php/mcinvestigacion/subir_doc') ?>";
        $('#resultado').load(url, {id: id, cod_fis: cod_fis, nit: nit, id_mc: id_mc, ruta: ruta, cod_siguiente: cod_siguiente, titulo: titulo, 
            tipo: tipo,id_prelacion:id_prelacion,cod_siguiente_prelacion:cod_siguiente_prelacion});
    }
    function respuesta(id,cod_fis, nit,titulo,cod_siguiente) {
        $(".preload, .load").show();
        var url = "<?php echo base_url('index.php/mcinvestigacion/respuesta') ?>";
        $('#resultado').load(url, {id: id,cod_fis: cod_fis, nit: nit,titulo:titulo,cod_siguiente:cod_siguiente});
    }
    function bancarios(id,cod_fis, nit,titulo,cod_siguiente) {
        $(".preload, .load").show();
        var url = "<?php echo base_url('index.php/mcinvestigacion/bancarios') ?>";
        $('#resultado').load(url, {id: id,cod_fis: cod_fis, nit: nit,titulo:titulo,cod_siguiente:cod_siguiente});
    }
    function confirmar_pago(id,cod_fis, nit,titulo,cod_siguiente) {
        $(".preload, .load").show();
        var url = "<?php echo base_url('index.php/mcinvestigacion/confirmar_pago') ?>";
        $('#resultado').load(url, {id: id,cod_fis: cod_fis, nit: nit,titulo:titulo,cod_siguiente:cod_siguiente});
    }
    function confirmar_valores(id,cod_fis, nit,titulo,cod_siguiente,fin) {
        $(".preload, .load").show();
        var url = "<?php echo base_url('index.php/mcinvestigacion/confirmar_valores') ?>";
        $('#resultado').load(url, {id: id,cod_fis: cod_fis, nit: nit,titulo:titulo,cod_siguiente:cod_siguiente,fin:fin});
    }
    function prelacion(id,cod_fis, nit,titulo,cod_siguiente,permiso) {
        $(".preload, .load").show();
        var url = "<?php echo base_url('index.php/mcinvestigacion/prelacion') ?>";
        $('#resultado').load(url, {id: id,cod_fis: cod_fis, nit: nit,titulo:titulo,cod_siguiente:cod_siguiente,permiso:permiso});
    }
    function comision(id,cod_fis, nit,titulo,cod_siguiente,id_prelacion) {
        $(".preload, .load").show();
        var url = "<?php echo base_url('index.php/mcinvestigacion/comision') ?>";
        $('#resultado').load(url, {id: id,cod_fis: cod_fis, nit: nit,titulo:titulo,cod_siguiente:cod_siguiente,id_prelacion:id_prelacion});
    }
    function oposicion(id,cod_fis, nit,titulo,cod_siguiente,id_prelacion) {
        $(".preload, .load").show();
        var url = "<?php echo base_url('index.php/mcinvestigacion/oposicion') ?>";
        $('#resultado').load(url, {id: id,cod_fis: cod_fis, nit: nit,titulo:titulo,cod_siguiente:cod_siguiente,id_prelacion:id_prelacion});
    }
    function favorable(id,cod_fis, nit,titulo,cod_siguiente,id_prelacion) {
        $(".preload, .load").show();
        var url = "<?php echo base_url('index.php/mcinvestigacion/favorable') ?>";
        $('#resultado').load(url, {id: id,cod_fis: cod_fis, nit: nit,titulo:titulo,cod_siguiente:cod_siguiente,id_prelacion:id_prelacion});
    }
    function favorable2(id,cod_fis, nit,titulo,cod_siguiente,id_prelacion) {
        $(".preload, .load").show();
        var url = "<?php echo base_url('index.php/mcinvestigacion/favorable2') ?>";
        $('#resultado').load(url, {id: id,cod_fis: cod_fis, nit: nit,titulo:titulo,cod_siguiente:cod_siguiente,id_prelacion:id_prelacion});
    }
    function insistir(id,cod_fis, nit,titulo,cod_siguiente,id_prelacion) {
        $(".preload, .load").show();
        var url = "<?php echo base_url('index.php/mcinvestigacion/insistir') ?>";
        $('#resultado').load(url, {id: id,cod_fis: cod_fis, nit: nit,titulo:titulo,cod_siguiente:cod_siguiente,id_prelacion:id_prelacion});
    }
    function presenta(id, cod_fis, nit, id_mc, titulo,cod_siguiente_prelacion,id_prelacion) {
        if(!id_prelacion)
            id_prelacion="";
        if(!cod_siguiente_prelacion)
            cod_siguiente_prelacion="";
        $(".preload, .load").show();
        var url = "<?php echo base_url('index.php/mcinvestigacion/presenta') ?>";
        $('#resultado').load(url, {id: id, cod_fis: cod_fis, nit: nit, titulo: titulo,
             id_mc: id_mc, id_prelacion:id_prelacion,cod_siguiente_prelacion:cod_siguiente_prelacion});
    }
   $('#tablaq').dataTable({
        "bJQueryUI": true,
        "sPaginationType": "full_numbers",
         "oLanguage": {
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla",
            "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
            "sFirst":    "Primero",
            "sLast":     "Último",
            "sNext":     "Siguiente",
            "sPrevious": "Anterior"
             },
    "fnInfoCallback": null,
            },
    });
    jQuery(".preload, .load").hide();

</script> 
<style>
    .ui-widget-overlay{z-index: 10000;}
    .ui-dialog{
        z-index: 15000;
    }
</style>