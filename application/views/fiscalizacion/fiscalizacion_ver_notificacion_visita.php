<?php if( ! defined('BASEPATH') ) exit('No direct script access allowed'); ?>

<div class="center-form" width='450' height= '300'>
 
 <?php     

        echo form_open(current_url()); ?>
 
	
 
 
<center><h3>Documento Oficial Visita</h3></center>

<p>
DOCUMENTO: &nbsp<?=$notificacion['NOMBRE_ARCHIVO_NOTIFICACION']?>
  <a class="button" id="doc" name="doc">
	Ver
</a>
</p>	




     <?php echo form_close(); ?>	
    


</div>
<style>
    .ui-widget-overlay{z-index: 10000;}
    .ui-dialog{
        z-index: 15000;
    }

 </style>


<script type="text/javascript" language="javascript" charset="utf-8">
$(".preload, .load").hide();
 $('#ver_notificacion_visita').dialog({
                autoOpen: true,
                width: 450,
                height: 300,
                modal:true,
                title:'Ver Documento Oficial Visita',
                close: function() {
                    $('#ver_notificacion_visita *').remove();
                }
            });	
            
$('#doc').click(function(){

	var url="<?=base_url()?>uploads/fiscalizaciones/<?=$notificacion['COD_FISCALIZACION_EMPRESA']?>/comunicacionoficialvisita/<?=$notificacion['NOMBRE_ARCHIVO_NOTIFICACION']?>";
	
	redirect_by_post(url, true);
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
            
                function ajaxValidationCallback(status, form, json, options) {
	
}
</script>

   