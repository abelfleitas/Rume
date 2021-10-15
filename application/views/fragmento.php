<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link href="<?=base_url();?>assets/css/minifi/bootstrap.min.css" rel='stylesheet' type='text/css' />
        <link href="<?=base_url();?>assets/css/minifi/iframe.min.css" rel='stylesheet' type='text/css' />
        <link href="<?=base_url();?>assets/css/minifi/fakeLoader.min.css" rel='stylesheet' type='text/css' />
        <link href="<?=base_url();?>assets/css/minifi/jquery.mCustomScrollbar.min.css" rel='stylesheet' type='text/css' />
        <link href="<?=base_url();?>assets/css/minifi/dropzone.min.css" rel='stylesheet' type='text/css' />
        <link href="<?=base_url();?>assets/css/minifi/jquery-confirm.min.css" rel='stylesheet' type='text/css' />

        <script type="text/javascript" src="<?=base_url();?>assets/js/jquery-2.1.3.min.js"></script>
        <script type="text/javascript" src="<?=base_url();?>assets/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?=base_url();?>assets/js/application.js"></script>

    </head>
<body onbeforeunload="window_onload()">
    <?php
        $myArr = new ArrayObject($map);
        $nombres = new ArrayObject();
        for($i=0;$i<$myArr->count();$i++)
        {
            $str = trim($myArr[$i],'/');
            $slash=strrpos($str,'/');
            if($slash)
            {
                $nombres->append(substr($str,$slash+1));
            }
            else{
                $nombres->append($str);
            }
        }
    ?>
    <input type="hidden" value="<?=$camino;?>" id="camino_actual">
    <input type="hidden" value="<?=base_url();?>" id="base_url">
    <div id="popover-head" class="hide">
        Opciones
    </div>
    <div id="here_fake"></div>
    <div class="col-xs-12" >

        <div class="col-xs-12"  style="padding: 0 !important;margin: 0!important;height: 120px;overflow: hidden;">

            <div class="col-xs-12" id="menu">

                <div class="col-xs-2 firsChild">
                    <div id="btngroup" class="btn-group nav-tabs">
                        <a id="li" href="#lista" data-toggle="tab" class="btn btn-default btn-sm <?=$active1;?>" role="button"><img width="20" height="20" src="<?=base_url();?>assets/img/lista.png"></a>
                        <a id="dt" href="#detalle" data-toggle="tab" class="btn btn-default btn-sm <?=$active2;?>" role="button"><img width="20" height="20" src="<?=base_url();?>assets/img/detalle.png"></a>
                        <a id="ic" href="#icono" data-toggle="tab" class="btn btn-default btn-sm <?=$active3;?>" role="button"><img width="20" height="20" src="<?=base_url();?>assets/img/icono.png"></a>
                    </div>
                </div>

                <div class="col-xs-7">
                    <div id="munu_b" class="btn-group">
                        <button type="button" class="btn btn-warning btn-sm" id="new_file" data-toggle="modal" data-target="#myModal0"><span class="glyphicon glyphicon-file"></span></button>
                    </div>

                    <div id="munu_b" class="btn-group">
                        <?php if($this->session->userdata('privilegio')=='3' && $this->session->userdata('profile') =='usuario'):?>
                            <button type="button" class="btn btn-warning btn-sm" disabled><span class="glyphicon glyphicon-folder-open"></button>
                        <?php else:?>
                            <button type="button" class="btn btn-warning btn-sm" id="new_folder" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-folder-open"></button>
                        <?php endif;?>
                    </div>

                    <div id="munu_b" class="btn-group">
                        <?php if($this->session->userdata('privilegio')=='3' && $this->session->userdata('profile') =='usuario'):?>
                            <button type="button" class="btn btn-warning btn-sm" disabled><span class="glyphicon glyphicon-cloud-upload"></button>
                        <?php else:?>
                            <button type="button" class="btn btn-warning btn-sm" id="upload_file" data-toggle="modal" data-target="#myModal1"><span class="glyphicon glyphicon-cloud-upload"></button>
                        <?php endif;?>
                    </div>

                    <div id="munu_b" class="btn-group">
                        <button type="button" class="btn btn-warning btn-sm" id="download_file"><span class="glyphicon glyphicon-cloud-download"></span></button>
                    </div>

                    <div id="munu_b" class="btn-group">
                        <?php if($this->session->userdata('privilegio')=='3' && $this->session->userdata('profile') =='usuario'):?>
                            <button type="button" class="btn btn-warning btn-sm" disabled><span class="glyphicon glyphicon-edit"></span></button>
                        <?php else:?>
                            <button type="button" class="btn btn-warning btn-sm" id="editar_name"><span class="glyphicon glyphicon-edit"></span></button>
                        <?php endif;?>
                    </div>

                    <div id="munu_b" class="btn-group">
                        <?php if($this->session->userdata('privilegio')=='3' && $this->session->userdata('profile') =='usuario'):?>
                            <button type="button" class="btn btn-warning btn-sm" disabled><span class="glyphicon glyphicon-trash"></span></button>
                        <?php else:?>
                            <button type="button" class="btn btn-warning btn-sm" id="delete_name"><span class="glyphicon glyphicon-trash"></span></button>
                        <?php endif;?>
                    </div>

                    <div id="munu_b" class="btn-group">
                        <?php if($this->session->userdata('privilegio')=='3' && $this->session->userdata('profile') =='usuario'):?>
                            <button type="button" class="btn btn-warning btn-sm" disabled><span class="glyphicon glyphicon-compressed"></span></button>
                        <?php else:?>
                            <button type="button" class="btn btn-warning btn-sm" id="comprimir"><span class="glyphicon glyphicon-compressed"></span></button>
                        <?php endif;?>
                    </div>

                    <div id="munu_b" class="btn-group">
                        <?php if($this->session->userdata('privilegio')=='3' && $this->session->userdata('profile') =='usuario'):?>
                            <button type="button" class="btn btn-warning btn-sm" disabled><span class="glyphicon glyphicon-arrow-right"></span></button>
                        <?php else:?>
                            <button type="button" class="btn btn-warning btn-sm" id="buton_move"><span class="glyphicon glyphicon-arrow-right"></span></button>
                        <?php endif;?>
                    </div>

                    <div id="munu_b" class="btn-group">
                        <button type="button" class="btn btn-warning btn-sm" id="file_sort" data-toggle="modal" data-target="#myModal7"><span class="glyphicon glyphicon glyphicon-sort"></span></button>
                    </div>

                    <div id="munu_b" class="btn-group">
                        <button type="button" class="btn btn-warning btn-sm" id="recargar"><span class="glyphicon glyphicon-refresh"></span></button>
                    </div>

                </div>


                <div class="col-xs-3">
                    <form id="buscar"  role="form">
                        <div class="input-group">
                            <input type="search" form="buscar" class="form-control" name="cadena_busqueda" autocomplete="off" id="cadena_busqueda" placeholder="Buscar en FTP...">
                    <span class="input-group-btn">
                        <button class="btn btn-info" type="button" form="buscar" id="search">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
                    </span>
                        </div>
                    </form>
                </div>

            </div>

            <div class="col-xs-12" style="padding:0;">
                <ol class="breadcrumb" style="margin-bottom: 10px;">
                    <?php
                    $str = trim($camino,'/');
                    $aux = new ArrayObject(explode('/',$str));
                    $breadcrumb = new ArrayObject();
                    if($this->session->userdata('profile') =='administrador'||$this->session->userdata('privilegio')=='2'||$this->session->userdata('privilegio')=='3')
                    {
                        $breadcrumb->append('Inicio');
                    }
                    for($j=0;$j<$aux->count();$j++)
                    {
                        $breadcrumb->append($aux[$j]);
                    }
                    $cadena='';
                    for($i=0;$i<$breadcrumb->count();$i++)
                    {
                        $cadena = $cadena.'/'.$breadcrumb[$i];
                        if($i==0)
                        {
                            if($this->session->userdata('profile') =='administrador' ||$this->session->userdata('privilegio')=='2'||$this->session->userdata('privilegio')=='3')
                            {
                                $cadena = "/";
                            }
                            echo '<li><a href="'.base_url().'directorio/'.base64_encode($cadena).'"><i class="glyphicon glyphicon-home"></i>'.nbs(1).$breadcrumb[$i].'</a></li>';

                        }
                        else if($breadcrumb[$i] != ""){

                            echo '<li><a href="'.base_url().'directorio/'.base64_encode($cadena).'"><i class="glyphicon glyphicon-folder-open"></i> '.nbs(1).$breadcrumb[$i].'</a></li>';
                        }
                    }
                    ?>
                </ol>
            </div>

        </div>

        <div class="col-xs-12" id="vista_archivos">
            <div class="tab-content">
                <div class="tab-pane fade <?=$estado1;?>" id="lista">
                    <?php for($i=0;$i<$myArr->count();$i++):?>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 10px;">
                            <?php
                            $nom_e = explode('.',$nombres[$i]);
                            if(is_dir("ftp://".$username.":".$password."@".$host.":".$port."/".$myArr[$i]))//if(get_mime_by_extension($myArr[$i])=='')
                            {
                                $ruta = base64_encode($myArr[$i]);
                                $archivos_dentro = $this->ftp->list_files($myArr[$i]);
                                if(!empty($archivos_dentro))
                                {
                                    echo '<a id="'.md5($myArr[$i]).'" class="lista popovers" href="'.base_url().'directorio/'.$ruta.'" role="button"><img width="40" height="40" src="'.base_url().'assets/img/carpeta_llena.PNG"><span>'.$nombres[$i].'</span></a>';
                                }
                                else{
                                    echo '<a id="'.md5($myArr[$i]).'" class="lista popovers"  href="'.base_url().'directorio/'.$ruta.'" role="button"><img width="40" height="40" src="'.base_url().'assets/img/carpeta_vacia.PNG"><span>'.$nombres[$i].'</span></a>';
                                }
                                if($this->session->userdata('privilegio')=='3' && $this->session->userdata('profile') =='usuario'){
                                    echo '<div id="popover-content" class="hide popover-content'.md5($myArr[$i]).'">
                                        <div id="menu_personalizado">
                                            <a href="'.base_url().'directorio/'.$ruta.'"><span class="glyphicon glyphicon-eye-open"></span> Abrir</a>
                                        </div>
                                    </div>';
                                }
                                else{
                                    echo '<div id="popover-content" class="hide popover-content'.md5($myArr[$i]).'">
                                        <div id="menu_personalizado">
                                            <a href="'.base_url().'directorio/'.$ruta.'"><span class="glyphicon glyphicon-eye-open"></span> Abrir</a>
                                            <a role="button" id="'.$nombres[$i].'" onclick="rename_file(this.id)"><span class="glyphicon glyphicon-edit"></span> Renombrar</a>
                                            <a role="button" id="'.$nombres[$i].'" onclick="delete_file(this.id)"><span class="glyphicon glyphicon-trash"></span> Eliminar</a>
                                        </div>
                                    </div>';
                                }
                            }
                            else if(get_mime_by_extension($myArr[$i])==='text/plain')
                            {
                                echo '<a id="'.md5($myArr[$i]).'" onclick="open_file(this.id)" data-att="'.$myArr[$i].'" role="button" class="lista popovers"><img width="40" height="40" src="'.base_url().'assets/img/text.PNG"><span>'.$nombres[$i].'</span></a>';

                                if($this->session->userdata('privilegio')=='3' && $this->session->userdata('profile') =='usuario'){
                                    echo '<div id="popover-content" class="hide popover-content'.md5($myArr[$i]).'">
                                            <div id="menu_personalizado">
                                                <a role="button" id="'.$myArr[$i].'" onclick="abrir_file(this.id)  "><span class="glyphicon glyphicon-eye-open"></span> Abrir</a>
                                                <a role="button" onclick="test()" href="'.base_url().'descargarFile/'.base64_encode($myArr[$i]).'"><span class="glyphicon glyphicon-cloud-download"></span> Descargar</a>
                                            </div>
                                          </div>';
                                }
                                else{
                                    echo '<div id="popover-content" class="hide popover-content'.md5($myArr[$i]).'">
                                            <div id="menu_personalizado">
                                                <a role="button" id="'.$myArr[$i].'" onclick="abrir_file(this.id)"><span class="glyphicon glyphicon-eye-open"></span> Abrir</a>
                                                <a role="button" id="'.$nombres[$i].'" onclick="rename_file(this.id)"><span class="glyphicon glyphicon-edit"></span> Renombrar</a>
                                                <a role="button" onclick="test()" href="'.base_url().'descargarFile/'.base64_encode($myArr[$i]).'"><span class="glyphicon glyphicon-cloud-download"></span> Descargar</a>
                                                <a role="button" id="'.$nombres[$i].'" onclick="delete_file(this.id)"><span class="glyphicon glyphicon-trash"></span> Eliminar</a>
                                            </div>
                                         </div>';
                                }
                            }
                            else if(get_mime_by_extension($myArr[$i])==='application/xml')
                            {
                                echo '<a id="'.md5($myArr[$i]).'" class="lista popovers" target="_blank" href="'.base_url().'open/'.base64_encode($myArr[$i]).'" role="button"><img width="40" height="40" src="'.base_url().'assets/img/xml.PNG"><span>'.$nombres[$i].'</span></a>';
                                if($this->session->userdata('privilegio')=='3' && $this->session->userdata('profile') =='usuario'){
                                    echo '<div id="popover-content" class="hide popover-content'.md5($myArr[$i]).'">
                                            <div id="menu_personalizado">
                                                <a role="button" target="_blank" href="'.base_url().'open/'.base64_encode($myArr[$i]).'"><span class="glyphicon glyphicon-eye-open"></span> Abrir</a>
                                                <a onclick="test()" role="button" href="'.base_url().'descargarFile/'.base64_encode($myArr[$i]).'"><span class="glyphicon glyphicon-cloud-download"></span> Descargar</a>
                                            </div>
                                          </div>';
                                }
                                else{
                                    echo '<div id="popover-content" class="hide popover-content'.md5($myArr[$i]).'">
                                            <div id="menu_personalizado">
                                                <a role="button" target="_blank" href="'.base_url().'open/'.base64_encode($myArr[$i]).'"><span class="glyphicon glyphicon-eye-open"></span> Abrir</a>
                                                <a role="button" id="'.$nombres[$i].'" onclick="rename_file(this.id)"><span class="glyphicon glyphicon-edit"></span> Renombrar</a>
                                                <a onclick="test()" role="button" href="'.base_url().'descargarFile/'.base64_encode($myArr[$i]).'"><span class="glyphicon glyphicon-cloud-download"></span> Descargar</a>
                                                <a role="button" id="'.$nombres[$i].'" onclick="delete_file(this.id)"><span class="glyphicon glyphicon-trash"></span> Eliminar</a>
                                            </div>
                                         </div>';
                                }
                            }
                            else if(get_mime_by_extension($myArr[$i])==='application/x-zip' || get_mime_by_extension($myArr[$i]) === 'application/x-rar'||get_mime_by_extension($myArr[$i])==='application/x-7z-compressed'||get_mime_by_extension($myArr[$i])==='application/x-tar' || get_mime_by_extension($myArr[$i])==='application/x-gzip' || get_mime_by_extension($myArr[$i])==='application/x-gtar')
                            {
                                echo '<a id="'.md5($myArr[$i]).'" id="lista" class="lista popovers" role="button"><img width="40" height="40" src="'.base_url().'assets/img/carpeta_cerrada.PNG"><span>'.$nombres[$i].'</span></a>';

                                if($this->session->userdata('privilegio')=='3' && $this->session->userdata('profile') =='usuario'){
                                    echo '<div id="popover-content" class="hide popover-content'.md5($myArr[$i]).'">
                                            <div id="menu_personalizado">
                                                <a onclick="test()" role="button" href="'.base_url().'descargarFile/'.base64_encode($myArr[$i]).'"><span class="glyphicon glyphicon-cloud-download"></span> Descargar</a>
                                            </div>
                                        </div>';
                                }
                                else{
                                    echo '<div id="popover-content" class="hide popover-content'.md5($myArr[$i]).'">
                                            <div id="menu_personalizado">
                                                <a role="button" id="'.$nombres[$i].'" onclick="extrac_to(this.id)"><span class="glyphicon glyphicon-compressed"></span> Extraer</a>
                                                <a role="button" id="'.$nombres[$i].'" onclick="rename_file(this.id)"><span class="glyphicon glyphicon-edit"></span> Renombrar</a>
                                                <a onclick="test()" role="button" href="'.base_url().'descargarFile/'.base64_encode($myArr[$i]).'"><span class="glyphicon glyphicon-cloud-download"></span> Descargar</a>
                                                <a role="button" id="'.$nombres[$i].'" onclick="delete_file(this.id)"><span class="glyphicon glyphicon-trash"></span> Eliminar</a>
                                            </div>
                                        </div>';
                                }
                            }
                            ?>
                        </div>
                    <?php endfor;?>
                </div>
                <div class="tab-pane fade <?=$estado2;?>" id="detalle">
                    <?php if($myArr->count()>0):?>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Fecha de Modificaci&oacute;n</th>
                            <th>Tipo</th>
                            <th>Tama&ntilde;o</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php for($i=0;$i<$myArr->count();$i++):?>
                            <tr>
                                <td>
                                    <?php
                                    $ruta = base64_encode($myArr[$i]);
                                    if(is_dir("ftp://".$username.":".$password."@".$host.":".$port."/".$myArr[$i]))//if(get_mime_by_extension($myArr[$i])=="")
                                    {
                                        $archivos_dentro = $this->ftp->list_files($myArr[$i]);
                                        if(!empty($archivos_dentro))
                                        {
                                            echo '<a id="'.md5($myArr[$i]).'" class="detalle popovers" href="'.base_url().'directorio/'.$ruta.'" role="button"><img width="40" height="40" src="'.base_url().'assets/img/carpeta_llena.PNG"><span>'.$nombres[$i].'</span></a>';
                                        }
                                        else{
                                            echo '<a id="'.md5($myArr[$i]).'" class="detalle popovers" href="'.base_url().'directorio/'.$ruta.'" role="button"><img width="40" height="40" src="'.base_url().'assets/img/carpeta_vacia.PNG"><span>'.$nombres[$i].'</span></a>';
                                        }
                                        if($this->session->userdata('privilegio')=='3' && $this->session->userdata('profile') =='usuario'){
                                            echo '<div id="popover-content" class="hide popover-content'.md5($myArr[$i]).'">
                                        <div id="menu_personalizado">
                                            <a href="'.base_url().'directorio/'.$ruta.'"><span class="glyphicon glyphicon-eye-open"></span> Abrir</a>
                                        </div>
                                    </div>';
                                        }
                                        else{
                                            echo '<div id="popover-content" class="hide popover-content'.md5($myArr[$i]).'">
                                        <div id="menu_personalizado">
                                            <a href="'.base_url().'directorio/'.$ruta.'"><span class="glyphicon glyphicon-eye-open"></span> Abrir</a>
                                            <a role="button" id="'.$nombres[$i].'" onclick="rename_file(this.id)"><span class="glyphicon glyphicon-edit"></span> Renombrar</a>
                                            <a role="button" id="'.$nombres[$i].'" onclick="delete_file(this.id)"><span class="glyphicon glyphicon-trash"></span> Eliminar</a>
                                        </div>
                                    </div>';
                                        }
                                    }
                                    if(get_mime_by_extension($myArr[$i])==='text/plain')
                                    {
                                        echo '<a  id="'.md5($myArr[$i]).'" onclick="open_file(this.id)" data-att="'.$myArr[$i].'" role="button" class="detalle popovers"><img width="40" height="40" src="'.base_url().'assets/img/text.PNG"><span>'.$nombres[$i].'</span></a>';
                                        if($this->session->userdata('privilegio')=='3' && $this->session->userdata('profile') =='usuario'){
                                            echo '<div id="popover-content" class="hide popover-content'.md5($myArr[$i]).'">
                                            <div id="menu_personalizado">
                                                <a role="button" id="'.$myArr[$i].'" onclick="abrir_file(this.id)"><span class="glyphicon glyphicon-eye-open"></span> Abrir</a>
                                                <a onclick="test()" role="button" href="'.base_url().'descargarFile/'.base64_encode($myArr[$i]).'"><span class="glyphicon glyphicon-cloud-download"></span> Descargar</a>
                                            </div>
                                          </div>';
                                        }
                                        else{
                                            echo '<div id="popover-content" class="hide popover-content'.md5($myArr[$i]).'">
                                            <div id="menu_personalizado">
                                                <a role="button" id="'.$myArr[$i].'" onclick="abrir_file(this.id)"><span class="glyphicon glyphicon-eye-open"></span> Abrir</a>
                                                <a role="button" id="'.$nombres[$i].'" onclick="rename_file(this.id)"><span class="glyphicon glyphicon-edit"></span> Renombrar</a>
                                                <a onclick="test()" role="button" href="'.base_url().'descargarFile/'.base64_encode($myArr[$i]).'"><span class="glyphicon glyphicon-cloud-download"></span> Descargar</a>
                                                <a role="button" id="'.$nombres[$i].'" onclick="delete_file(this.id)"><span class="glyphicon glyphicon-trash"></span> Eliminar</a>
                                            </div>
                                         </div>';
                                        }
                                    }
                                    else if(get_mime_by_extension($myArr[$i])==='application/xml')
                                    {
                                        echo '<a id="'.md5($myArr[$i]).'" class="detalle popovers"  role="button" target="_blank" href="'.base_url().'open/'.base64_encode($myArr[$i]).'"><img width="40" height="40" src="'.base_url().'assets/img/xml.PNG"><span>'.$nombres[$i].'</span></a>';
                                        if($this->session->userdata('privilegio')=='3' && $this->session->userdata('profile') =='usuario'){
                                            echo '<div id="popover-content" class="hide popover-content'.md5($myArr[$i]).'">
                                            <div id="menu_personalizado">
                                                <a role="button" target="_blank" href="'.base_url().'open/'.base64_encode($myArr[$i]).'"><span class="glyphicon glyphicon-eye-open"></span> Abrir</a>
                                                <a onclick="test()" role="button" href="'.base_url().'descargarFile/'.base64_encode($myArr[$i]).'"><span class="glyphicon glyphicon-cloud-download"></span> Descargar</a>
                                            </div>
                                          </div>';
                                        }
                                        else{
                                            echo '<div id="popover-content" class="hide popover-content'.md5($myArr[$i]).'">
                                            <div id="menu_personalizado">
                                                <a role="button" target="_blank" href="'.base_url().'open/'.base64_encode($myArr[$i]).'"><span class="glyphicon glyphicon-eye-open"></span> Abrir</a>
                                                <a role="button" id="'.$nombres[$i].'" onclick="rename_file(this.id)"><span class="glyphicon glyphicon-edit"></span> Renombrar</a>
                                                <a onclick="test()" role="button" href="'.base_url().'descargarFile/'.base64_encode($myArr[$i]).'"><span class="glyphicon glyphicon-cloud-download"></span> Descargar</a>
                                                <a role="button" id="'.$nombres[$i].'" onclick="delete_file(this.id)"><span class="glyphicon glyphicon-trash"></span> Eliminar</a>
                                            </div>
                                         </div>';
                                        }
                                    }
                                    else if(get_mime_by_extension($myArr[$i])==='application/x-zip' || get_mime_by_extension($myArr[$i]) === 'application/x-rar' || get_mime_by_extension($myArr[$i])==='application/x-7z-compressed'||get_mime_by_extension($myArr[$i])==='application/x-tar' || get_mime_by_extension($myArr[$i])==='application/x-gzip' || get_mime_by_extension($myArr[$i])==='application/x-gtar')
                                    {
                                        echo '<a id="'.md5($myArr[$i]).'" class="detalle popovers" role="button"><img width="40" height="40" src="'.base_url().'assets/img/carpeta_cerrada.PNG"><span>'.$nombres[$i].'</span></a>';

                                        if($this->session->userdata('privilegio')=='3' && $this->session->userdata('profile') =='usuario'){
                                            echo '<div id="popover-content" class="hide popover-content'.md5($myArr[$i]).'">
                                            <div id="menu_personalizado">
                                                <a onclick="test()" role="button" href="'.base_url().'descargarFile/'.base64_encode($myArr[$i]).'"><span class="glyphicon glyphicon-cloud-download"></span> Descargar</a>
                                            </div>
                                        </div>';
                                        }
                                        else{
                                            echo '<div id="popover-content" class="hide popover-content'.md5($myArr[$i]).'">
                                            <div id="menu_personalizado">
                                                <a role="button" id="'.$nombres[$i].'" onclick="extrac_to(this.id)"><span class="glyphicon glyphicon-compressed"></span> Extraer</a>
                                                <a role="button" id="'.$nombres[$i].'" onclick="rename_file(this.id)"><span class="glyphicon glyphicon-edit"></span> Renombrar</a>
                                                <a onclick="test()" role="button" href="'.base_url().'descargarFile/'.base64_encode($myArr[$i]).'"><span class="glyphicon glyphicon-cloud-download"></span> Descargar</a>
                                                <a role="button" id="'.$nombres[$i].'" onclick="delete_file(this.id)"><span class="glyphicon glyphicon-trash"></span> Eliminar</a>
                                            </div>
                                        </div>';
                                        }
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if(is_dir("ftp://".$username.":".$password."@".$host.":".$port."/".$myArr[$i]) || get_mime_by_extension($myArr[$i])==='text/plain'||get_mime_by_extension($myArr[$i])==='application/xml'||get_mime_by_extension($myArr[$i]) ==='application/x-zip' || get_mime_by_extension($myArr[$i]) === 'application/x-rar' || get_mime_by_extension($myArr[$i])==='application/x-7z-compressed' || get_mime_by_extension($myArr[$i])==='application/x-tar' || get_mime_by_extension($myArr[$i])==='application/x-gzip' || get_mime_by_extension($myArr[$i])==='application/x-gtar')
                                    {
                                        $buff = filemtime ("ftp://".$username.":".$password."@".$host.":".$port."/".$myArr[$i]);
                                        if ($buff != -1) {
                                            echo  gmdate( "d/m/Y H:i",$buff);
                                        }
                                        else
                                        {
                                            echo "";
                                        }
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if(is_dir("ftp://".$username.":".$password."@".$host.":".$port."/".$myArr[$i]))//if(get_mime_by_extension($myArr[$i])=="")
                                    {
                                        echo "Carpeta de archivos";
                                    }
                                    if(get_mime_by_extension($myArr[$i])==='text/plain')
                                    {
                                        echo "Documento de texto";
                                    }
                                    else if(get_mime_by_extension($myArr[$i])==='application/xml')
                                    {
                                        echo "Documento XML";
                                    }
                                    else if(get_mime_by_extension($myArr[$i]) ==='application/x-zip' || get_mime_by_extension($myArr[$i]) === 'application/x-rar' || get_mime_by_extension($myArr[$i])==='application/x-7z-compressed' || get_mime_by_extension($myArr[$i])==='application/x-tar' || get_mime_by_extension($myArr[$i])==='application/x-gzip' || get_mime_by_extension($myArr[$i])==='application/x-gtar')
                                    {
                                        echo "Carpeta Comprimida";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    // is_dir("ftp://".$username.":".$password."@".$host.":".$port."/".$myArr[$i]) ||
                                    if(get_mime_by_extension($myArr[$i])==='text/plain'||get_mime_by_extension($myArr[$i])==='application/xml'||get_mime_by_extension($myArr[$i]) ==='application/x-zip' || get_mime_by_extension($myArr[$i]) === 'application/x-rar' || get_mime_by_extension($myArr[$i])==='application/x-7z-compressed' || get_mime_by_extension($myArr[$i])==='application/x-tar' || get_mime_by_extension($myArr[$i])==='application/x-gzip' || get_mime_by_extension($myArr[$i])==='application/x-gtar') {
                                        $res =filesize("ftp://".$username.":".$password."@".$host.":".$port."/".$myArr[$i]);
                                        if ($res != 0) {
                                            echo byte_format($res);
                                        } else {
                                            echo "";
                                        }
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php endfor;?>
                        </tbody>
                    </table>
                    <?php endif;?>
                </div>
                <div class="tab-pane fade <?=$estado3;?>" id="icono">
                    <?php for($i=0;$i<$myArr->count();$i++):?>
                        <?php
                        if(is_dir("ftp://".$username.":".$password."@".$host.":".$port."/".$myArr[$i]))//if(get_mime_by_extension($myArr[$i])=="")
                        {
                            $ruta = base64_encode($myArr[$i]);
                            $archivos_dentro = $this->ftp->list_files($myArr[$i]);
                            if(!empty($archivos_dentro))
                            {
                                echo '<a id="'.md5($myArr[$i]).'" class="icono popovers" href="'.base_url().'directorio/'.$ruta.'" role="button"><img width="90" height="90" src="'.base_url().'assets/img/carpeta_llena.PNG"><span>'.$nombres[$i].'</span></a>';
                            }
                            else{
                                echo '<a id="'.md5($myArr[$i]).'" class="icono popovers" href="'.base_url().'directorio/'.$ruta.'" role="button"><img width="90" height="90" src="'.base_url().'assets/img/carpeta_vacia.PNG"><span>'.$nombres[$i].'</span></a>';
                            }
                            if($this->session->userdata('privilegio')=='3' && $this->session->userdata('profile') =='usuario'){
                                echo '<div id="popover-content" class="hide popover-content'.md5($myArr[$i]).'">
                                        <div id="menu_personalizado">
                                            <a href="'.base_url().'directorio/'.$ruta.'"><span class="glyphicon glyphicon-eye-open"></span> Abrir</a>
                                        </div>
                                    </div>';
                            }
                            else{
                                echo '<div id="popover-content" class="hide popover-content'.md5($myArr[$i]).'">
                                        <div id="menu_personalizado">
                                            <a href="'.base_url().'directorio/'.$ruta.'"><span class="glyphicon glyphicon-eye-open"></span> Abrir</a>
                                            <a role="button" id="'.$nombres[$i].'" onclick="rename_file(this.id)"><span class="glyphicon glyphicon-edit"></span> Renombrar</a>
                                            <a role="button" id="'.$nombres[$i].'" onclick="delete_file(this.id)"><span class="glyphicon glyphicon-trash"></span> Eliminar</a>
                                        </div>
                                    </div>';
                            }
                        }
                        else if(get_mime_by_extension($myArr[$i])==='text/plain')
                        {
                            echo '<a id="'.md5($myArr[$i]).'" role="button" class="icono popovers" onclick="open_file(this.id)" data-att="'.$myArr[$i].'"><img width="90" height="90" src="'.base_url().'assets/img/text.PNG"><span>'.$nombres[$i].'</span></a>';
                            if($this->session->userdata('privilegio')=='3' && $this->session->userdata('profile') =='usuario'){
                                echo '<div id="popover-content" class="hide popover-content'.md5($myArr[$i]).'">
                                            <div id="menu_personalizado">
                                                <a role="button" id="'.$myArr[$i].'" onclick="abrir_file(this.id)"><span class="glyphicon glyphicon-eye-open"></span> Abrir</a>
                                                <a onclick="test()" role="button" href="'.base_url().'descargarFile/'.base64_encode($myArr[$i]).'"><span class="glyphicon glyphicon-cloud-download"></span> Descargar</a>
                                            </div>
                                          </div>';
                            }
                            else{
                                echo '<div id="popover-content" class="hide popover-content'.md5($myArr[$i]).'">
                                            <div id="menu_personalizado">
                                                <a role="button" id="'.$myArr[$i].'" onclick="abrir_file(this.id)"><span class="glyphicon glyphicon-eye-open"></span> Abrir</a>
                                                <a role="button" id="'.$nombres[$i].'" onclick="rename_file(this.id)"><span class="glyphicon glyphicon-edit"></span> Renombrar</a>
                                                <a onclick="test()" role="button" href="'.base_url().'descargarFile/'.base64_encode($myArr[$i]).'"><span class="glyphicon glyphicon-cloud-download"></span> Descargar</a>
                                                <a role="button" id="'.$nombres[$i].'" onclick="delete_file(this.id)"><span class="glyphicon glyphicon-trash"></span> Eliminar</a>
                                            </div>
                                         </div>';
                            }
                        }
                        else if(get_mime_by_extension($myArr[$i])==='application/xml')
                        {
                            echo '<a id="'.md5($myArr[$i]).'" role="button" class="icono popovers" target="_blank" href="'.base_url().'open/'.base64_encode($myArr[$i]).'"><img width="90" height="90" src="'.base_url().'assets/img/xml.PNG"><span>'.$nombres[$i].'</span></a>';
                            if($this->session->userdata('privilegio')=='3' && $this->session->userdata('profile') =='usuario'){
                                echo '<div id="popover-content" class="hide popover-content'.md5($myArr[$i]).'">
                                            <div id="menu_personalizado">
                                                <a role="button" target="_blank" href="'.base_url().'open/'.base64_encode($myArr[$i]).'"><span class="glyphicon glyphicon-eye-open"></span> Abrir</a>
                                                <a onclick="test()" role="button" href="'.base_url().'descargarFile/'.base64_encode($myArr[$i]).'"><span class="glyphicon glyphicon-cloud-download"></span> Descargar</a>
                                            </div>
                                          </div>';
                            }
                            else{
                                echo '<div id="popover-content" class="hide popover-content'.md5($myArr[$i]).'">
                                            <div id="menu_personalizado">
                                                <a role="button" target="_blank" href="'.base_url().'open/'.base64_encode($myArr[$i]).'"><span class="glyphicon glyphicon-eye-open"></span> Abrir</a>
                                                <a role="button" id="'.$nombres[$i].'" onclick="rename_file(this.id)"><span class="glyphicon glyphicon-edit"></span> Renombrar</a>
                                                <a onclick="test()" role="button" href="'.base_url().'descargarFile/'.base64_encode($myArr[$i]).'"><span class="glyphicon glyphicon-cloud-download"></span> Descargar</a>
                                                <a role="button" id="'.$nombres[$i].'" onclick="delete_file(this.id)"><span class="glyphicon glyphicon-trash"></span> Eliminar</a>
                                            </div>
                                         </div>';
                            }
                        }
                        else if(get_mime_by_extension($myArr[$i])==='application/x-zip' || get_mime_by_extension($myArr[$i]) === 'application/x-rar' || get_mime_by_extension($myArr[$i])==='application/x-7z-compressed'|| get_mime_by_extension($myArr[$i])==='application/x-tar'|| get_mime_by_extension($myArr[$i])==='application/x-gzip' ||  get_mime_by_extension($myArr[$i])==='application/x-gtar')
                        {
                            echo '<a id="'.md5($myArr[$i]).'" class="icono popovers" role="button" ><img width="90" height="90" src="'.base_url().'assets/img/carpeta_cerrada.PNG"><span>'.$nombres[$i].'</span></a>';
                            if($this->session->userdata('privilegio')=='3' && $this->session->userdata('profile') =='usuario'){
                                echo '<div id="popover-content" class="hide popover-content'.md5($myArr[$i]).'">
                                            <div id="menu_personalizado">
                                                <a onclick="test()" role="button" href="'.base_url().'descargarFile/'.base64_encode($myArr[$i]).'"><span class="glyphicon glyphicon-cloud-download"></span> Descargar</a>
                                            </div>
                                        </div>';
                            }
                            else{
                                echo '<div id="popover-content" class="hide popover-content'.md5($myArr[$i]).'">
                                            <div id="menu_personalizado">
                                                <a role="button" id="'.$nombres[$i].'" onclick="extrac_to(this.id)"><span class="glyphicon glyphicon-compressed"></span> Extraer</a>
                                                <a role="button" id="'.$nombres[$i].'" onclick="rename_file(this.id)"><span class="glyphicon glyphicon-edit"></span> Renombrar</a>
                                                <a onclick="test()" role="button" href="'.base_url().'descargarFile/'.base64_encode($myArr[$i]).'"><span class="glyphicon glyphicon-cloud-download"></span> Descargar</a>
                                                <a role="button" id="'.$nombres[$i].'" onclick="delete_file(this.id)"><span class="glyphicon glyphicon-trash"></span> Eliminar</a>
                                            </div>
                                        </div>';
                            }
                        }
                        ?>
                    <?php endfor;?>
                </div>
            </div>
        </div>

        <div id="cant_item" class="col-xs-12">
            <?php if($myArr->count() == 1){

                echo '<span class="badge">'.$myArr->count().'</span>'.' elemento';
            }
            else{
                echo '<span class="badge">'.$myArr->count().'</span>'.' elementos';
            }
            ?>
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

    <!-- Modal Upload -->
    <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-cloud-upload"></span><?=nbs(1);?>Subir Archivo</h4>
                </div>
                <div class="modal-body">
                    <div id="contenedor_upload" style="height:240px;overflow-y: auto;">
                        <form method="post" action="<?=base_url();?>subir_archivo" enctype="multipart/form-data" class="dropzone" id="myAwesomeDropzone">
                            <input type="hidden" name="pathdoupload" id="pathdoupload" value="<?=$camino;?>"/>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <div id="error_c41"></div>
                    <button type="button" form="form_upload" class="btn btn-info" id="button_upload">Aceptar</button>
                    <button type="button" form="form_upload" data-dismiss="modal"  class="btn btn-default" id="button_upload_closed">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- ================ Modal Nuevo Archivo ==================== -->
    <div class="modal fade" id="myModal0" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" id="modal0" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-file"></span><?=nbs(1);?>Nuevo Documento de texto</h4>
                </div>
                <form role="form" id="new_file_form">
                    <div class="modal-body" style="padding-bottom:5px;">
                        <div id="error_c"></div>
                        <input type="hidden" value="<?=base_url();?>" id="url_to_file" name="url_to_file" >
                        <input type="text" class="form-control text-lowercase" id="name_file" name="name_file" placeholder="escriba un nombre">
                        <input type="hidden"  value="<?=$camino;?>" class="sr-only" id="camino_actual_file" name="camino_actual_file">
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="nuevo_f" class="btn btn-info">Aceptar</button>
                        <button type="button" id="nuevo_f_close" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- ============================ End Modal Nuevo Archivo ===================== -->

    <!-- ================ Modal Nueva Carpeta ==================== -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" data-remote="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-folder-open"></span><?=nbs(2);?>Nueva Carpeta</h4>
                </div>
                <form role="form" id="new_carpeta">
                    <div class="modal-body" style="padding-bottom:5px;">
                        <div id="error_c1"></div>
                        <input type="hidden" value="<?=base_url();?>" id="url_to_folder" name="url_to_folder">
                        <input type="text"  class="form-control text-lowercase" id="name_folder" name="name_folder" placeholder="Escriba un nombre">
                        <input type="hidden"  value="<?=$camino;?>" id="camino_actual" name="camino_actual">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" id="nueva_c">Aceptar</button>
                        <button type="button" class="btn btn-default" id="nueva_close" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- ============================ End Modal Nueva Carpeta ===================== -->

    <!-- ============================ Modal Download File ===================== -->
    <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-cloud-download"></span><?=nbs(1);?>Descargar Archivos</h4>
                </div>
                <form role="form" id="form_download" name="form_download" method="post" action="<?=base_url();?>bajar_archivo_zip" novalidate="novalidate">
                    <div class="modal-body">
                        <input type="hidden" class="sr-only" name="baseUrl_download" value="<?=base_url();?>" id="baseUrl_download">
                        <div class="checkbox" id="maracar_todos">
                            <label>
                                <input id="all" name="all"  type="checkbox"> Marcar todos
                            </label>
                        </div>
                        <div class="contenedor-download">
                            <div id="error_c3"></div>
                            <input type="text" class="sr-only" name="ruta_download" value="<?=$camino;?>" id="ruta_download">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" onclick="test()" class="btn btn-info" id="button_download">Aceptar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- ============================ End Modal Download File ===================== -->

    <!-- ============================ Modal Editar File ===================== -->
    <div class="modal fade" id="myModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-edit"></span><?=nbs(1);?>Renombrar Archivos</h4>
                </div>
                <form id="form_edit" role="form">
                    <div id="modal_bodyEdit" class="modal-body">
                        <div class="checkbox" id="maracar_todos">
                            <label>
                                <input  id="all2" name="all"  type="checkbox"> Marcar todos
                            </label>
                        </div>
                        <input type="hidden" value="<?=base_url();?>" id="ruta_url">
                        <input type="hidden" value="<?=$camino;?>" name="ruta_edit" id="ruta_edit">
                    </div>
                    <div class="modal-footer">
                        <button type="button"  id="buton_editar_archivos" class="btn btn-info">Aceptar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- ============================ End Modal Editar File ===================== -->

    <!-- ============================ Modal Delete File ===================== -->
    <div class="modal fade" id="myModalDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-trash"></span><?=nbs(1);?>Eliminar Archivos</h4>
                </div>
                <form id="form_delete" role="form">
                    <div class="modal-body">
                        <input type="hidden" value="<?=base_url();?>" id="ruta_delete_url">
                        <input type="hidden" value="<?=$camino;?>" name="ruta_delete" id="ruta_delete">
                        <div class="checkbox" id="maracar_todos">
                            <label>
                                <input id="all1" name="all"  type="checkbox"> Marcar todos
                            </label>
                        </div>
                        <div id="delete_body">
                            <div id="error_c5"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button"  id="eliminar_files" class="btn btn-info">Aceptar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- ============================ End Modal Delete File ===================== -->

    <!-- ============================ Modal Comprimir ===================== -->
    <div class="modal fade" id="myModalCompress" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-compressed"></span><?=nbs(1);?>Comprimir Archivos</h4>
                </div>
                <form id="compress_form" role="form">
                    <div class="modal-body">
                        <input type="hidden" id="url_compress" value="<?=base_url();?>">
                        <input type="hidden" id="ruta_compress" value="<?=$camino;?>" name="ruta_compress">
                        <div class="checkbox" id="maracar_todos">
                            <label>
                                <input id="all4" name="all"  type="checkbox"> Marcar todos
                            </label>
                        </div>
                        <div id="contenedor_archivos_compress">
                            <div id="error_c7"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button"  id="compress_file_button" class="btn btn-info">Aceptar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- ============================ End Modal Comprimir ===================== -->

    <!-- ============================ Modal Move File ===================== -->
    <div class="modal fade" id="myModalMove" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-arrow-right"></span><?=nbs(1);?>Mover Archivos</h4>
                </div>
                <form role="form" id="move_file_form">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="col-xs-6" style="padding: 0;">
                                    <div class="checkbox" id="maracar_todos">
                                        <label>
                                            <input  id="all3" name="all"  type="checkbox"> Marcar todos
                                        </label>
                                    </div>
                                        <input type="hidden" value="<?=base_url();?>" id="ruta_move_url">
                                        <?php if($camino == '/'){$camino = '';}?>
                                        <input type="hidden" value="<?=$camino;?>" name="ruta_move" id="ruta_move">
                                        <input type="hidden" value="" name="ruta_destino" id="ruta_destino">
                                    <div id="archivos_move">
                                        <div id="error_c6"></div>
                                    </div>
                                    <br>
                                    <button type="button" id="move_file_submit" class="btn btn-info">Aceptar</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                </div>
                                <div class="col-xs-6" style="height: 310px;padding:0;">
                                    <iframe id="iframe_in" src="<?=base_url()?>load_move"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- ============================ End Modal Move File ===================== -->

    <!-- ================ Modal Ordenar ==================== -->
    <div class="modal fade" id="myModal7" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-sort"></span><?=nbs(1);?>Ordenar Archivos</h4>
                </div>
                <div class="modal-body">
                    <div id="ordenar_by" class="list-group" style="margin:0;">
                        <a onclick="change_order(this.id)" id="<?=base_url();?>sort/alpha1" role="button" class="list-group-item alpha1">
                            <span class="glyphicon glyphicon-sort-by-alphabet"></span>
                            Ordenar alfab&eacute;ticamente [A-Z]
                        </a>
                        <a onclick="change_order(this.id)" id="<?=base_url();?>sort/alpha2" role="button" class="list-group-item alpha2">
                            <span class="glyphicon glyphicon-sort-by-alphabet-alt"></span>
                            Ordenar alfab&eacute;ticamente [Z-A]
                        </a>
                        <a onclick="change_order(this.id)" id="<?=base_url();?>sort/tipo1" role="button" class="list-group-item tipo1">
                            <span class="glyphicon glyphicon-sort-by-attributes"></span>
                            Ordenar tipo de archivo [ascendente]
                        </a>
                        <a onclick="change_order(this.id)" id="<?=base_url();?>sort/tipo2" role="button" class="list-group-item tipo2">
                            <span class="glyphicon glyphicon-sort-by-attributes-alt"></span>
                            Ordenar tipo de archivo [descendente]
                        </a>
                        <a onclick="change_order(this.id)" id="<?=base_url();?>sort/size1" role="button" class="list-group-item size1">
                            <span class="glyphicon glyphicon-sort-by-order"></span>
                            Ordenar tama&ntilde;o total [1-9]
                        </a>
                        <a onclick="change_order(this.id)" id="<?=base_url();?>sort/size2" role="button" class="list-group-item size2">
                            <span class="glyphicon glyphicon-sort-by-order-alt"></span>
                            Ordenar tama&ntilde;o total [9-1]
                        </a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- ============================ End Modal Ordenar ===================== -->

    <script type="text/javascript" src="<?=base_url();?>assets/js/jquery-confirm.min.js"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/js/jquery.mousewheel-3.0.6.min.js"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/js/dropzone.js"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/js/tooltip.js"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/js/jquery.base64.min.js"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/js/fakeLoader.js"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/js/button_action/buscar_files.min.js"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/js/button_action/new_files.min.js"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/js/button_action/new_folder.min.js"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/js/button_action/upload_files.min.js"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/js/button_action/download_files.min.js"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/js/button_action/edit_files.js"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/js/button_action/delete_files.min.js"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/js/button_action/compress_files.min.js"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/js/button_action/move_files.min.js"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/js/button_action/sort_files.min.js"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/js/button_action/refresh_files.min.js"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/js/button_action/vistas_directory.min.js"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/js/button_action/menu_popover.js"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/tinymce/tinymce.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            $("#vista_archivos").mCustomScrollbar({
                theme:"3d-thick-dark",
                scrollButtons:{
                    enable:true
                },
                advanced:{
                    autoScrollOnFocus:false,
                    UpdateOnContentResize: true
                }
            });
            function actualiza(){
                var tam = window.innerHeight-(120+60-10);
                $('#vista_archivos').css({'height':tam});
            }
            setInterval(actualiza,120);
        });
        $('button').on('click',function(){
            $('.tooltip').tooltip('hide');
        });
        <?php
            switch($this->session->userdata('sort')){
                case "alpha1":
                    ?>
                        $('.alpha1').addClass('active');
                    <?php
                    break;
                case "alpha2":
                    ?>
                        $('.alpha2').addClass('active');
                    <?php
                    break;
                case "tipo1":
                    ?>
                        $('.tipo1').addClass('active');
                    <?php
                    break;
                case "tipo2":
                    ?>
                        $('.tipo2').addClass('active');
                    <?php
                    break;
                case "size1":
                    ?>
                    $('.size1').addClass('active');
                    <?php
                    break;
                case "size2":
                    ?>
                    $('.size2').addClass('active');
                    <?php
                    break;
            }
        ?>
    </script>
    <script type="text/javascript">
        function window_onload() {
            $('#here_fake').show();
            $('#here_fake').fakeLoader({timeToHide:120000000,spinner: "spinner6",zIndex:"999"});
        }
        function test(){
            function eliminarRecargar(){
                $('#here_fake').hide();
            }
            window.onbeforeunload = eliminarRecargar();
        }

        function loadjson(){
            $.getJSON('<?=base_url();?>assets/json/<?=$this->session->userdata('usuario');?>/ruta_forMove.json',function(resp){
                $('#ruta_destino').prop('value',resp);
            });
        }

        $('#myModalMove').on('show.bs.modal', function () {
            setInterval(loadjson,80);
        })


    </script>

</body>
</html>

