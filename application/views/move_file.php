<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="<?=base_url();?>assets/css/minifi/bootstrap.min.css" rel='stylesheet' type='text/css' />
        <link href="<?=base_url();?>assets/css/minifi/jquery.mCustomScrollbar.min.css" rel='stylesheet' type='text/css' />
        <link href="<?=base_url();?>assets/css/minifi/move_file.min.css" rel='stylesheet' type='text/css' />
    </head>
<body>
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
    <div class="col-xs-12">
        <?php
        $str = trim($camino,'/');
        $aux = new ArrayObject(explode('/',$str));
        $breadAux = new ArrayObject();
        if($this->session->userdata('profile') =='administrador'||$this->session->userdata('privilegio')=='2'||$this->session->userdata('privilegio')=='3')
        {
            $breadAux->append('Inicio');
        }
        for($j=0;$j<$aux->count();$j++)
        {
            $breadAux->append($aux[$j]);
        }
        ?>
    </div>
    <div class="col-xs-10">
        <ol class="breadcrumb" id="breadcrumb">
            <?php
            $cadena='';
            for($i=0;$i<$breadAux->count();$i++)
            {
                $cadena = $cadena.'/'.$breadAux[$i];
                if($i==0)
                {
                    if($this->session->userdata('profile') =='administrador'||$this->session->userdata('privilegio')=='2'||$this->session->userdata('privilegio')=='3')
                    {
                        $cadena = "/";
                    }
                    echo '<li><a href="'.base_url().'indirectorio/'.base64_encode($cadena).'"><i class="glyphicon glyphicon-home"></i>'.nbs(1).$breadAux[$i].'</a></li>';
                }
                else if($breadAux->count()<=2)
                {
                    if($i==$breadAux->count()-1)
                    {
                        if($breadAux[$i] !="")
                        {
                            echo '<li><a href="'.base_url().'indirectorio/'.base64_encode($cadena).'"><i class="glyphicon glyphicon-folder-open"></i> '.nbs(1).$breadAux[$breadAux->count()-1].'</a></li>';
                        }
                    }
                }
                else if($breadAux->count()>=2){

                    if($i==$breadAux->count()-2 || $i==$breadAux->count()-1)
                    {
                        if($breadAux[$i] !="")
                        {
                            echo '<li><a href="'.base_url().'indirectorio/'.base64_encode($cadena).'"><i class="glyphicon glyphicon-folder-open"></i> '.nbs(1).$breadAux[$i].'</a></li>';
                        }
                    }
                }
            }
            ?>
        </ol>
    </div>
    <div class="col-xs-2">
        <button id="new_folder" data-toggle="modal" data-target="#myModal" class="btn btn-warning"><span class="glyphicon glyphicon-folder-open"></span></button>

        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" data-remote="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-folder-open"></span><?=nbs(2);?>Nueva Carpeta</h4>
                    </div>
                    <form role="form" id="new_carpeta">
                        <div class="modal-body">
                            <div class="form-group">
                                <div id="error_c1"></div>
                                <input type="hidden" value="<?=base_url();?>" id="url_to_folder" name="url_to_folder">
                                <input type="text"  class="form-control text-lowercase" id="name_folder" name="name_folder" placeholder="Escriba un nombre">
                                <input type="hidden"  value="<?=$camino;?>" id="camino_actual" name="camino_actual">
                            </div>
                            <button type="button" class="btn btn-info" id="nueva_c">Aceptar</button>
                            <button type="button" class="btn btn-default" id="nueva_close" data-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

    </div>
    <div class="col-xs-12">
        <div class="col-xs-12" id="myScroll" style="height:230px;overflow-y: auto;">
                <?php
                for($i=0;$i<$myArr->count();$i++):
                    if(get_mime_by_extension($myArr[$i])=='')
                    {
                        $ruta = base64_encode($myArr[$i]);
                        $archivos_dentro = $this->ftp->list_files($myArr[$i]);
                        if(!empty($archivos_dentro))
                        {
                            echo '<div class="col-xs-12"><a id="listax" href="'.base_url().'indirectorio/'.$ruta.'"><img width="32" height="32" src="'.base_url().'assets/img/carpeta_llena.PNG"><span>'.$nombres[$i].'</span></a></div>';
                        }
                        else{
                            echo '<div class="col-xs-12"><a id="listax" href="'.base_url().'indirectorio/'.$ruta.'"><img width="32" height="32" src="'.base_url().'assets/img/carpeta_vacia.PNG"><span>'.$nombres[$i].'</span></a></div>';
                        }
                    }
                endfor;
                ?>
        </div>
    </div>

    <script type="text/javascript" src="<?=base_url();?>assets/js/jquery-2.1.3.min.js"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/js/application.js"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/js/button_action/new_folder.min.js"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/js/jquery.mousewheel-3.0.6.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#myScroll").mCustomScrollbar({
                theme:"3d-thick-dark",
                scrollButtons:{
                    enable:true,
                    scrollType: "stepped"
                }
            });
        });
    </script>
</body>
</html>

