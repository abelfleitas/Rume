<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RUME-FTP</title>
    <link rel="shortcut icon" href="<?=base_url();?>assets/img/FTP.PNG">

    <link rel='stylesheet' href="<?=base_url();?>assets/css/minifi/bootstrap.min.css" type='text/css' />
    <link rel="stylesheet" href="<?=base_url();?>assets/css/minifi/base.min.css">
    <link rel="stylesheet" href="<?=base_url();?>assets/css/minifi/pc.min.css">
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
        <div class="col-xs-9" id="menuleft">
            <iframe id="iframe" src="<?=base_url()?>fragmento"></iframe>
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
                        <a class="list-group-item active" href="<?=base_url()?>home"><span class="glyphicon glyphicon-cloud"></span> FTP</a>
                        <a class="list-group-item"  href="<?=base_url()?>mis_datos"><span class="glyphicon glyphicon-eye-open"></span> Mis Datos</a>
                        <a class="list-group-item" href="<?=base_url()?>cambiar_contrasena"><span class="glyphicon glyphicon-lock"></span> Cambiar Contrase&ntilde;a</a>
                        <?php if($this->session->userdata('profile')=='administrador'):?>
                            <a class="list-group-item" href="<?=base_url()?>ver_usuario"><span class="glyphicon glyphicon-link"></span> Usuarios</a>
                        <?php endif;?>
                        <?php if($this->session->userdata('profile')=='administrador'):?>
                            <a class="list-group-item" role="button" data-toggle="modal" data-target="#myModal11" ><span class="glyphicon glyphicon-cog"></span> Configuraci&oacute;n</a>
                        <?php endif;?>
                        <a class="list-group-item" href="<?=base_url();?>user_guide"  target="_blank" role="button"><span class="glyphicon glyphicon-question-sign"></span> Ayuda</a>
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

    <?php if($this->session->userdata('profile')=='administrador'):?>
        <div class="modal fade" id="myModal11" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header"  style="border-bottom: 3px solid #f0ad4e;">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-cog"></span><?=nbs(1);?>Configuraci&oacute;n</h4>
                    </div>
                    <form class="form-horizontal" name="config" id="config">
                        <div class="modal-body" style="padding-top:0;padding-bottom:0;margin-top: 0!important;">
                        <div class="row" style="padding: 0;margin-top: 0!important;">
                            <div class="col-xs-12" style="margin-top: 0;margin-bottom: 15px;">
                                <div class="checkbox">
                                    <label class="pull-right">
                                        <input id="edicion" type="checkbox"> Editar
                                    </label>
                                </div>
                                <h5 class="page-header" style="margin-top: 0;text-align: center;margin-bottom: 10px;">Sistema RUME-FTP</h5>
                                <div class="col-xs-4" style="text-align: justify;background-color: rgba(255, 255, 255, 0.8);padding-top: 5px;padding-left: 40px;">
                                    <?php
                                    if(count($lineas)>1 &&  isset($this->pos)){
                                        $html=explode('/',$lineas[$this->pos]);
                                    ?>
                                    <p><strong>FTP Alojado en:</strong>&nbsp;<small>
                                            <select id="particion" name="particion" disabled>
                                                <?php foreach($lineas as $label): $part=$label[0].$label[1];?>
                                                    <?php if($part == $this->particion):?>
                                                        <option value="<?=$part;?>" selected>Disco Local (<?=$label[0];?><?=$label[1];?>)</option>
                                                    <?php else:?>
                                                        <option value="<?=$part;?>">Disco Local (<?=$label[0];?><?=$label[1];?>)</option>
                                                    <?php endif;?>
                                                <?php endforeach;?>
                                            </select>
                                        </small></p>
                                    <p><strong>Espacio Total:</strong>&nbsp;<small><?=$html[1]?></small></p>
                                    <p><strong>Espacio Usado:</strong>&nbsp;<small><?=$html[2]?></small></p>
                                    <p><strong>Espacio Libre:</strong>&nbsp;<small><?=$html[3]?></small></p>
                                    <?php
                                    }else{?>
                                        <input type="hidden" name="particion" id="particion" value="<?=$this->particion;?>">
                                    <?php }
                                    ?>
                                </div>
                                <div class="col-xs-8" style="padding: 0;margin: 0;">
                                    <?php if($this->sistema == 1):?>
                                        <div class="col-xs-6">
                                            <div class="form-group" style="text-align: center;">
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" name="optionsRadios" id="habilitar" value="1" checked disabled>
                                                        Habilitar Sistema
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="form-group" style="text-align: center;">
                                                <div class="radio">
                                                    <label class="">
                                                        <input type="radio" name="optionsRadios" id="desabilitar" value="0" disabled>
                                                        Desabilitar Sistema
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif;?>
                                    <div class="col-xs-12" style="padding-top: 0!important;padding-bottom: 0!important;">
                                        <?php
                                        if(count($lineas)>1){
                                        ?>
                                        <div class="checkbox" style="margin: 0!important;padding: 0;">
                                            <label style="font-family: 'Tahoma'">
                                                <input disabled  type="checkbox" id="disk" name="disk">
                                                Notificar v&iacute;a email cuando el espacio utilizado se encuentre al 98% de su capacidad.
                                            </label>
                                        </div>
                                        <div class="progress  progress-striped" style="margin: 0!important;padding: 0;">
                                            <div class="progress-bar progress-bar-danger"  id="utilizado">
                                                <span class=""><?=$uitilizado?>%</span>
                                            </div>
                                            <div class="progress-bar progress-bar-primary" id="disponible">
                                                <span class=""><?=$freespace_mb?>% </span>
                                            </div>
                                        </div>
                                        <span class="label label-danger">Espacio Utilizado</span>
                                        <span class="label label-primary" style="margin-left: 325px!important;">Espacio Disponible </span>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <h5 class="page-header" style="margin-top: 0;text-align: center;">Servidor FTP</h5>
                                <div class="form-group">
                                    <label for="host" class="col-sm-4 control-label">Host</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="host" name="host" value="<?=$host;?>" placeholder="Nombre del host" disabled/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="port"  class="col-sm-4 control-label">Puerto</label>
                                    <div class="col-sm-8">
                                        <input type="number" class="form-control" id="port" name="port" value="<?=$port;?>" placeholder="Puerto" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="username"  class="col-sm-4 control-label">Usuario</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="username" name="username" value="<?=$username;?>" placeholder="Usuario" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="password"  class="col-sm-4 control-label">Contrase&ntilde;a</label>
                                    <div class="col-sm-8">
                                        <input type="password" class="form-control" id="password" name="password" value="<?=$password;?>" placeholder="Contrase&ntilde;a" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <h5 class="page-header" style="margin-top: 0;text-align: center;">Servidor de Correo</h5>
                                <div class="form-group">
                                    <label for="hostc"  class="col-sm-4 control-label">Host</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" value="<?=$this->hostC;?>" id="hostc" name="hostc" placeholder="Nombre del host" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="portc"  class="col-sm-4 control-label">Puerto</label>
                                    <div class="col-sm-8">
                                        <input type="number" class="form-control" value="<?=$this->portC;?>" id="portc" name="portc" placeholder="Puerto" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="usernamec"  class="col-sm-4 control-label">Usuario</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" value="<?=$this->userC;?>" id="usernamec" name="usernamec" placeholder="Usuario" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="passwordc"  class="col-sm-4 control-label">Contrase&ntilde;a</label>
                                    <div class="col-sm-8">
                                        <input type="password" class="form-control" value="<?=$this->passC;?>" id="passwordc" name="passwordc" placeholder="Contrase&ntilde;a" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <h5 class="page-header" style="margin-top: 0;text-align: center;">Servidor SIGE</h5>
                                <div class="form-group">
                                    <label for="hostsige"  class="col-sm-4 control-label">Host</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" value="<?=$this->hostSige;?>" id="hostsige" name="hostsige" placeholder="Nombre del host" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="portsige"  class="col-sm-4 control-label">Puerto</label>
                                    <div class="col-sm-8">
                                        <input type="number" class="form-control" value="<?=$this->portSige;?>" id="portsige" name="portsige" placeholder="Puerto" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="bdsige"  class="col-sm-4 control-label">BD</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" value="<?=$this->bdSige;?>" id="bdsige" name="bdsige" placeholder="Base de Datos" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="usernamesige"  class="col-sm-4 control-label">Usuario</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" value="<?=$this->userSige;?>" id="usernamesige" name="usernamesige" placeholder="Usuario" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="passwordsige"  class="col-sm-4 control-label">Contrase&ntilde;a</label>
                                    <div class="col-sm-8">
                                        <input type="password" class="form-control" value="<?=$this->passSige;?>" id="passwordsige" name="passwordsige" placeholder="Contrase&ntilde;a" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="submit_update" class="btn btn-info" disabled>Aceptar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    <?php endif;?>

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
            $('#hostsige').prop('disabled','disabled');
            $('#portsige').prop('disabled','disabled');
            $('#bdsige').prop('disabled','disabled');
            $('#usernamesige').prop('disabled','disabled');
            $('#passwordsige').prop('disabled','disabled');
            $('#habilitar').prop('disabled','disabled');
            $('#desabilitar').prop('disabled','disabled');
            $('#disk').prop('disabled','disabled');
            $('#particion').prop('disabled','disabled');
            $('#submit_update').prop('disabled','disabled');
        });
        $('#submit_update').on('click',function(e){
            e.stopPropagation();
            $.ajax({
                url:  '<?=base_url();?>update_ftp',
                type: 'POST',
                data: $('#config').serialize(),
                beforeSend: function()
                {
                    $('#myModal11').modal('hide');
                },
                success: function(resp){
                    if(resp == "listo") {
                        location.reload();
                    }
                    else{
                        alert(resp);
                    }
                }
            });
        });
        $('#disk').on('change',function(){
            if($('#disk').is(':checked')) {
                $('#disk').val(1);
            }
            else{
                $('#disk').val(0);
            }
        });
        $('#myModal11').on('show.bs.modal', function () {
            var valor = '<?=$freespace_mb;?>'+'%';
            $('#disponible').css('width',valor);
            var valor1 = '<?=$uitilizado;?>'+'%';
            $('#utilizado').css('width',valor1);

            <?php if($this->disk == 1):?>
            $('#disk').prop('checked','checked');
            <?php else:?>
            $('#disk').prop('checked','');
            <?php endif;?>

            if($('#disk').is(':checked')) {
                $('#disk').prop('value',1);
            }
            else{
                $('#disk').prop('value',0);
            }
        });
    </script>




</body>
</html>
