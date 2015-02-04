<br><div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>
    <?php
    if (isset($message)) {
        ?>
        <?php
        echo $message;
    } else {
        echo "Seleccione la Nulidad a Notificar";
    }
    ?>
</div>
<div class="preload"></div><img class="load" src="<?php echo base_url('img/27.gif'); ?>" width="128" height="128" />
<br><br>
<center>
    <h1>NULIDADES</h1>
    <h2><?php echo $titulo; ?></h2>
</center>
<br>

<table id="tablaq">
    <thead>
        <tr>        
            <th>NIT</th>
            <th>Razon Social</th>
            <th>Concepto</th>
            <th>Instancia</th>
            <th>Representante Legal</th>
            <th>Telefono</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        <?php
        //var_dump($nulidad_seleccionados);die;
        if (!empty($nulidad_seleccionada)) {
            foreach ($nulidad_seleccionada as $data) {
                ?> 
                <tr>          
                    <td><div style="cursor: pointer" class="push" cr="<?= $data->COD_RESPUESTA ?>" at="<?= $data->COD_NULIDAD ?>"><?= $data->CODEMPRESA ?></div></td>
                    <td><div style="cursor: pointer" class="push" cr="<?= $data->COD_RESPUESTA ?>" at="<?= $data->COD_NULIDAD ?>"><?= $data->NOMBRE_EMPRESA ?></div></td> 
                    <td><div style="cursor: pointer" class="push" cr="<?= $data->COD_RESPUESTA ?>" at="<?= $data->COD_NULIDAD ?>"><?= $data->NOMBRE_CONCEPTO ?></div></td> 
                    <td><div style="cursor: pointer" class="push" cr="<?= $data->COD_RESPUESTA ?>" at="<?= $data->COD_NULIDAD ?>"><?php echo 'Nulidad'; ?></div></td> 
                    <td><div style="cursor: pointer" class="push" cr="<?= $data->COD_RESPUESTA ?>" at="<?= $data->COD_NULIDAD ?>"><?= $data->REPRESENTANTE_LEGAL ?></div></td> 
                    <td><div style="cursor: pointer" class="push" cr="<?= $data->COD_RESPUESTA ?>" at="<?= $data->COD_NULIDAD ?>"><?= $data->TELEFONO_FIJO ?></div></td> 
                    <td><div style="cursor: pointer" class="push" cr="<?= $data->COD_RESPUESTA ?>" at="<?= $data->COD_NULIDAD ?>"><?= $data->RESPUESTA ?></div></td> 
                </tr>
                <?php
            }
        }
        ?>
    </tbody>     
</table>
<form id="form1" action="<?= base_url($ruta) ?>" method="post" >
    <input type="hidden" id="cod_nulidad" name="cod_nulidad" >    
    <input type="hidden" id="cod_respuesta" name="cod_respuesta" > 
</form>
<br>


<script type="text/javascript" language="javascript" charset="utf-8">

//generación de la tabla mediante json
    jQuery(".preload, .load").hide();

    $('#tablaq').dataTable({
        "bJQueryUI": true,
        "sPaginationType": "full_numbers",
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
            },
            "fnInfoCallback": null,
        },
        "sServerMethod": "POST",
        "aoColumns": [
            {"sClass": "center"}, /*id 0*/
            {"sClass": "center"},
            {"sClass": "center"},
            {"sClass": "center"},
            {"sClass": "center"},
            {"sClass": "center"},
            {"sClass": "center"},
        ],
    });
    $('.push').click(function() {
        $(".preload, .load").show();
        var cod_respuesta = $(this).attr('cr');
        $('#cod_respuesta').val(cod_respuesta);
        var cod_nulidad = $(this).attr('at');
        $('#cod_nulidad').val(cod_nulidad);
        $('#form1').submit();
        setTimeout(function() {
            jQuery(".preload, .load").hide();
        }, 2000);
    });


</script> 