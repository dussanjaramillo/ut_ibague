<div class="preload"></div><img class="load" src="<?php echo base_url('img/27.gif'); ?>" width="128" height="128" />

<table align="center" width="100%">
    <tr align="center">
        <td>SI</td>
        <td>NO</td>
    </tr>
    <tr align="center">
        <td><input type="radio" name="acct" class="actuar" value="1"></td>
        <td><input type="radio" name="acct" class="actuar" value="2"></td>
    </tr>
</table>


<script>
    cod_fis = "<?php echo $post['cod_fis']; ?>";
    id = "<?php echo $post['id']; ?>";
    id_prelacion = "<?php echo $post['id_prelacion']; ?>";
    nit = "<?php echo $post['id_prelacion']; ?>";
    titulo = "<?php echo $post['id_prelacion']; ?>";
    cod_siguiente = "<?php echo $post['cod_siguiente']; ?>";

    jQuery(".preload, .load").hide();
    $('#resultado').dialog({
        autoOpen: true,
        width: 300,
        modal: true,
        title: "<?php echo $post['titulo']; ?>",
        close: function() {
            $('#resultado *').remove();
        }
    });
    $('.actuar').click(function() {
        if (this.value == 1) {
            if (cod_siguiente == "<?php echo INMUEBLE_COMISIONAR1; ?>") {
                var dato = "<?php echo INMUEBLES_COMISION_SECUESTRO_INICIO; ?>";
            } else if (cod_siguiente == "<?php echo MUEBLE_COMISIONAR1; ?>") {
                var dato = "<?php echo MUEBLES_COM_SECUESTRO_INICIO; ?>";
            } else if (cod_siguiente == "<?php echo VEHICULO_COMISIONAR1; ?>") {
                var dato = "<?php echo VEHICULO_COMISION_INICIO; ?>";
            } else {
                return false;
            }
            enviar(dato);
        } else if (this.value == 2) {
            if (cod_siguiente == "<?php echo INMUEBLE_COMISIONAR1; ?>") {
                var dato = "<?php echo INMUEBLES_FECHA_INICIO; ?>";
            } else if (cod_siguiente == "<?php echo MUEBLE_COMISIONAR1; ?>") {
                var dato = "<?php echo MUEBLES_DILIGENCIA_INICIO; ?>";
            } else if (cod_siguiente == "<?php echo VEHICULO_COMISIONAR1; ?>") {
                var dato = "<?php echo VEHICULO_FECHA_INICIO; ?>";
            } else {
                return false;
            }
            enviar(dato);
        }
    })
    function enviar(dato) {
        jQuery(".preload, .load").show();
        var url = "<?php echo base_url('index.php/mcinvestigacion/avance') ?>";
        $.post(url, {cod_fis: cod_fis, id: id, id_prelacion: id_prelacion, nit: nit, titulo: titulo, dato: dato})
                .done(function() {
                    window.location.reload();
                }).fail(function() {
            jQuery(".preload, .load").hide();
            alert("<?php echo ERROR; ?>");
        })
    }
</script>
<style>
    .ui-widget-overlay{z-index: 10000;}
    .ui-dialog{
        z-index: 15000;
    }
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
