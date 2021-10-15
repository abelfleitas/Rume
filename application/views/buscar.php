<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="<?=base_url();?>assets/css/minifi/bootstrap.min.css" rel='stylesheet' type='text/css' />
    <link href="<?=base_url();?>assets/css/minifi/jquery.mCustomScrollbar.min.css" rel='stylesheet' type='text/css' />
    <link href="<?=base_url();?>assets/css/minifi/fakeLoader.min.css" rel='stylesheet' type='text/css' />
    <link href="<?=base_url();?>assets/css/minifi/jquery-confirm.min.css" rel='stylesheet' type='text/css' />
    <link href="<?=base_url();?>assets/css/minifi/buscar.min.css" rel='stylesheet' type='text/css' />

</head>
<body>

<div class="col-xs-12">
    <div id="popover-head" class="hide">
        Opciones
    </div>
    <div id="here_fake"></div>
    <input type="hidden" value="<?=base_url();?>" id="base_url">
    <div class="col-xs-12">
        <a  href="<?=base_url();?>directorio/<?=$ruta;?>" class="btn btn-danger pull-right" id="close_search">&times;</a>
        <h4 class="pull-left">Resultados de la búsqueda para: <?php echo '"'.urldecode($cadena).'"';?>
            <?php if($cant == 1){echo '<span class="badge">'.$cant.'</span>'.' elemento';}
            else{echo '<span class="badge">'.$cant.'</span>'.' elementos';}?></h4>
    </div>
    <div class="col-xs-12">
        <div class="list-group">
            <?php
                $i=0;
               foreach (json_decode($datos)  as $x):
                   if(get_mime_by_extension($x->nombre) === 'text/plain')
                   {
                       if($x->ruta == "/")
                       {
                           $rutaTxt = $x->ruta.$x->nombre;
                       }
                       else{
                           $rutaTxt = $x->ruta.'/'.$x->nombre;
                       }
                       echo '<a id="'.$i.'" class="lista popovers" onclick="open_file(this.id)" data-att="'.$rutaTxt.'" data-ruta="'.$x->ruta.'" role="button"><img width="32" height="32" src="'.base_url().'assets/img/text.PNG"><span class="uno'.$i.'">'.$x->nombre.'</span></a>
                          <br>
                          '.nbs(10).'<span class="glyphicon glyphicon-folder-open"> '.$x->ruta.'</span>
                          <br><br>';

                       echo '<div id="popover-content" class="hide popover-content'.$i.'">
                                <div id="menu_personalizado">
                                    <a href="'.base_url().'directorio/'.base64_encode($x->ruta).'"role="button"><span class="glyphicon glyphicon-folder-close"></span> Abrir la ubicaci&oacute;n del archivo</a>
                                    <a role="button" id="'.$rutaTxt.'" onclick="abrirFile(this.id)"><span class="glyphicon glyphicon-eye-open"></span> Abrir</a>
                                    <a href="'.base_url().'descargarFile/'.base64_encode($rutaTxt).'"><span class="glyphicon glyphicon-cloud-download"></span> Descargar</a>
                                </div>
                                </div>';
                   }
                   else if(get_mime_by_extension($x->nombre) === 'application/xml')
                   {
                       $rutaXml = $x->ruta.'/'.$x->nombre;
                       echo '<a id="'.$i.'" class="lista popovers" role="button" target="_blank" href="'.base_url().'open/'.base64_encode($rutaXml).'"><img width="32" height="32" src="'.base_url().'assets/img/xml.PNG"><span class="uno'.$i.'">'.$x->nombre.'</span></a>
                          <br>
                          '.nbs(10).'<span class="glyphicon glyphicon-folder-open"> '.$x->ruta.'</span>
                          <br><br>';

                       echo '<div id="popover-content" class="hide popover-content'.$i.'">
                            <div id="menu_personalizado">
                                <a href="'.base_url().'directorio/'.base64_encode($x->ruta).'" role="button"><span class="glyphicon glyphicon-folder-close"></span> Abrir la ubicaci&oacute;n del archivo</a>
                                <a target="_blank" href="'.base_url().'open/'.base64_encode($rutaXml).'"><span class="glyphicon glyphicon-eye-open"></span> Abrir</a>
                                <a href="'.base_url().'descargarFile/'.base64_encode($rutaXml).'"><span class="glyphicon glyphicon-cloud-download"></span> Descargar</a>
                            </div>
                          </div>';
                   }
                   else if(get_mime_by_extension($x->nombre)==='application/x-zip' || get_mime_by_extension($x->nombre) === 'application/x-rar'||get_mime_by_extension($x->nombre)==='application/x-7z-compressed'||get_mime_by_extension($x->nombre)==='application/x-tar' || get_mime_by_extension($x->nombre)==='application/x-gzip' || get_mime_by_extension($x->nombre)==='application/x-gtar') {

                       $rutaComp = $x->ruta.'/'.$x->nombre;;
                       echo '<a  id="'.$i.'" class="lista popovers" role="button"><img width="32" height="32" src="' . base_url() . 'assets/img/carpeta_cerrada.PNG"><span class="uno'.$i.'">'.$x->nombre.'</span></a>
                                  <br>
                                  ' . nbs(10) . '<span class="glyphicon glyphicon-folder-open"> ' . $x->ruta . '</span>
                                  <br><br>';
                       echo '<div id="popover-content" class="hide popover-content'.$i.'">
                            <div id="menu_personalizado">
                                <a href="'.base_url().'directorio/'.base64_encode($x->ruta).'" role="button"><span class="glyphicon glyphicon-folder-close"></span> Abrir la ubicaci&oacute;n del archivo</a>
                                <a href="'.base_url().'descargarFile/'.base64_encode($rutaComp).'"><span class="glyphicon glyphicon-cloud-download"></span> Descargar</a>
                            </div>
                          </div>';
                   }
                   else if(is_dir("ftp://".$this->username.":".$this->password."@".$this->host.":".$this->port."/".$x->ruta.'/'.$x->nombre)){
                       $archivos_dentro = $this->ftp->list_files($x->ruta.'/'.$x->nombre);
                       if(!empty($archivos_dentro))
                       {
                           $rutaFolder = $x->ruta.'/'.$x->nombre;
                           echo '<a id="'.$i.'" class="lista popovers" href="'.base_url().'directorio/'.base64_encode($rutaFolder).'" role="button"><img width="32" height="32" src="'.base_url().'assets/img/carpeta_llena.PNG"><span class="uno'.$i.'">'.$x->nombre.'</span></a>
                              <br>
                              '.nbs(10).'<span class="glyphicon glyphicon-folder-open"> '.$x->ruta.'</span>
                              <br><br>';
                       }
                       else{
                           $rutaFolderEmpty = $x->ruta.'/'.$x->nombre;
                           echo '<a id="'.$i.'" class="lista popovers" href="'.base_url().'directorio/'.base64_encode($rutaFolderEmpty).'" role="button"><img width="32" height="32" src="'.base_url().'assets/img/carpeta_vacia.PNG"><span class="uno'.$i.'">'.$x->nombre.'</span></a>
                              <br>
                              '.nbs(10).'<span class="glyphicon glyphicon-folder-open"> '.$x->ruta.'</span>
                              <br><br>';
                       }
                       echo '<div id="popover-content" class="hide popover-content'.$i.'">
                                <div id="menu_personalizado">
                                    <a href="'.base_url().'directorio/'.base64_encode($x->ruta).'" role="button"><span class="glyphicon glyphicon-folder-close"></span> Abrir la ubicaci&oacute;n del archivo</a>
                                    <a href="'.base_url().'directorio/'.base64_encode($x->ruta.'/'.$x->nombre).'"><span class="glyphicon glyphicon-eye-open"></span> Abrir</a>
                                </div>
                            </div>';
                   }
               $i++;endforeach;
            ?>
        </div>
    </div>
</div>

<!-- Modal Open FIle -->
<div class="modal fade" id="myModalOpen" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close"  id="close_open_file" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-file"></span><?=nbs(1);?>Editar Archivo</h4>
            </div>
            <div class="modal-body" style="padding:0;">
                <div id="contenedor_edicion" style="width: 100%;height: 100%">
                    <textarea name="text" id="text"></textarea>
                </div>
            </div>
            <div class="modal-footer" style="background: #ebebeb;padding: 0;">
                <h5 id="nombre_file_for_modal" style="float: right;margin-right: 10px;"></h5>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="<?=base_url();?>assets/js/jquery-2.1.3.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/js/jquery-latest.min.js"></script>

<script type="text/javascript" src="<?=base_url();?>assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/js/application.js"></script>

<script type="text/javascript" src="<?=base_url();?>assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/js/button_action/menu_popover_search.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/js/jquery.base64.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/js/fakeLoader.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/tinymce/tinymce.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/js/jquery-confirm.min.js"></script>



<script type="text/javascript">
    var tam = window.innerHeight-120;
    $('div.list-group').css({'height':tam});

    $('.list-group').mCustomScrollbar({
        theme:"3d-thick-dark",
        scrollButtons:{
            enable:true
        },
        advanced:{
            autoScrollOnFocus:false,
            UpdateOnContentResize: true
        }
    });

    var options13 = {
        animation: true,
        placement: 'bottom',
        selector: false,
        template: '<div class="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>',
        trigger: 'hover',
        title: 'cerrar',
        delay: 0,
        html: false,
        container: 'body'
    };
    $('#close_search').tooltip(options13);

</script>


<script type="text/javascript">
    $(document).ready(function(){
        resaltarTexto();
    });

    jQuery.fn.extend({
        resaltar: function(busqueda, claseCSSbusqueda){
            var regex = new RegExp("(<[^>]*>)|("+ busqueda.replace(/([-.*+?^${}()|[\]\/\\])/g,"\\$1") +')', 'ig');
            var nuevoHtml = this.html(this.html().replace(regex, function(a, b, c){
                return (a.charAt(0) == "<") ? a : "<span class=\""+ claseCSSbusqueda +"\">" + c + "</span>";
            }));
            return nuevoHtml;
        }
    });

    function resaltarTexto(){
        <?php $j=0;foreach (json_decode($datos) as $x):?>
            $("span.uno<?=$j;?>").resaltar('<?=urldecode($cadena);?>',"resaltarTexto");
        <?php $j++;endforeach;?>
    }
</script>

</body>
</html>

