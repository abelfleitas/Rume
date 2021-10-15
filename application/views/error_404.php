<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RUME-FTP</title>
    <link rel="shortcut icon" href="<?=base_url();?>assets/img/FTP.PNG">

    <link href="<?=base_url();?>assets/css/minifi/bootstrap.min.css" rel='stylesheet' type='text/css' />
    <link href="<?=base_url();?>assets/css/minifi/base.min.css" rel="stylesheet">
    <link href="<?=base_url();?>assets/css/minifi/pc.min.css" rel="stylesheet">
    <link href="<?=base_url();?>assets/css/minifi/jquery-confirm.min.css" rel='stylesheet' type='text/css' />


</head>
<body>

<div class="banner">
    <img id="logo" src="<?=base_url();?>assets/images/ftp.PNG">
    <div id="caja">
        <h1>RUME-FTP</h1>
        <h2>Repositorio para la Ubicaci&oacute;n de los Modelos Estad&iacute;sticos</h2>
    </div>
</div>
<div class="col-xs-12" id="principal">
    <div class="col-xs-9" id="menuleft" style="background: #FFFFFF;">
        <div class="col-xs-12" style="text-align: center;">
            <img src="<?=base_url();?>assets/img/404.png" style="margin-top: 5%!important;;">
        </div>
    </div>
    <div class="col-xs-3" id="menurigth">
        <div class="col-xs- 12">

            <div id="profile">
                <div id="profile_box">
                    <span role="button" class="glyphicon glyphicon-user"></span>
                    <p role="button">
                        <?php
                        $cadena = new ArrayObject();
                        $nom = explode(" ",$nombre);
                        $cadena->exchangeArray($nom);
                        if($cadena->count()>3){
                            echo $nom[0]." ".$nom[1];
                        }
                        else{
                            echo $nom[0];
                        }
                        ?></p>
                </div>

                <div id="menu_lateral" class="list-group">
                    <a class="list-group-item" href="<?=base_url()?>home"><span class="glyphicon glyphicon-cloud"></span> FTP</a>
                    <a class="list-group-item"  href="<?=base_url()?>mis_datos"><span class="glyphicon glyphicon-eye-open"></span> Mis Datos</a>
                    <a class="list-group-item" href="<?=base_url()?>cambiar_contrasena"><span class="glyphicon glyphicon-lock"></span> Cambiar Contrase&ntilde;a</a>
                    <?php if($this->session->userdata('profile')=='administrador'):?>
                        <a class="list-group-item" href="<?=base_url()?>ver_usuario"><span class="glyphicon glyphicon-link"></span> Usuarios</a>
                    <?php endif;?>
                    <a class="list-group-item" href="<?=base_url();?>user_guide" target="_blank" role="button"><span class="glyphicon glyphicon-question-sign"></span> Ayuda</a>
                    <a class="list-group-item" href="<?=base_url()?>cerrar_sesion"><span class="glyphicon glyphicon-log-out"></span> Cerrar Cesi&oacute;n</a>
                </div>
            </div>

        </div>
        <div class="col-xs-12" style="text-align: center;position: absolute;bottom: 10px!important;">
            <a id="about_rume" data-toggle="modal" data-target="#myModalAbout"  role="button">Sobre RUME-FTP</a>
        </div>
    </div>
</div>
<footer>
    <div id="footer">
        <p>Oficina Nacional de Estad&iacute;sticas e Informaci&oacute;n</p>
        <img src="<?=base_url();?>assets/img/onei.png">
        <p>Todos los derechos reservados &copy; <?=date('Y');?></p>
    </div>
</footer>

<div class="modal fade" id="myModalAbout" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom: 3px solid #f0ad4e;">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-exclamation-sign"></span><?=nbs(1);?>Sobre RUME-FTP</h4>
            </div>
            <div class="modal-body">
                <div id="cont">
                    <img id="logo1" src="<?=base_url();?>assets/images/ftp.PNG">
                    <div id="cont1">
                        <h1>RUME-FTP</h1>
                    </div>
                    <label>Descripci&oacute;n:</label>
                    <p>
                        RUME-FTP es un cliente FTP que permite conectarse a un servidor para realizar transferencias de archivos entre sistemas conectados a una red TCP.
                        El sistema permite transferir bidireccionalmente archivos de tipo .txt, .xml,
                        y cualquier tipo de archivo comprimido (<strong>.zip, .tar, .rar, .gz, .7z</strong> etc..),
                        además cuenta con diversas funcionalidades para el trabajo con archivos,
                        para mayor información consulte su <a aria-disabled="false" role="button" href="<?=base_url();?>user_guide" target="_blank">ayuda</a>.
                    </p>
                    <label></label>
                    <p><strong>Autor: </strong> Ing. Abel Alejandro Fleitas Perdomo</p>
                    <p><strong>Año: </strong>2018</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript" src="<?=base_url();?>assets/js/jquery-2.1.3.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/js/application.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/js/utils.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/js/jquery-confirm.min.js"></script>

<script type="text/javascript">
    $(document).ready(function(){

        function actualiza(){
            if(screen.height <= 768 && screen.height < 864){
                var alto = (window.innerHeight-140-5);
                $('#principal').css({'height':alto,'margin-top':73});
            }
            else if(screen.height <= 864 && screen.height < 900){
                var alto = (window.innerHeight-140-5);
                $('#principal').css({'height':alto,'margin-top':73});
            }
            else{
                var alto = (window.innerHeight-160-5);
                $('#principal').css({'height':alto,'margin-top':83});
            }
        }
        setInterval(actualiza,300);
    });
    $('#myModal11').on('hidden.bs.modal', function () {
        $('#edicion').prop('checked','');
        $('#host').prop('disabled','disabled');
        $('#port').prop('disabled','disabled');
        $('#username').prop('disabled','disabled');
        $('#password').prop('disabled','disabled');
        $('#hostc').prop('disabled','disabled');
        $('#portc').prop('disabled','disabled');
        $('#usernamec').prop('disabled','disabled');
        $('#passwordc').prop('disabled','disabled');
        $('#habilitar').prop('disabled','disabled');
        $('#desabilitar').prop('disabled','disabled');
        $('#submit_update').prop('disabled','disabled');
    });
</script>


</body>
</html>