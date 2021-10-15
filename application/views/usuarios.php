<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RUME-FTP</title>
    <link rel="shortcut icon" href="<?=base_url();?>assets/img/FTP.PNG">

    <link href="<?=base_url();?>assets/css/minifi/bootstrap.min.css" rel='stylesheet' type='text/css' />
    <link href="<?=base_url();?>assets/css/minifi/bootstrap-table.min.css" rel='stylesheet' type='text/css' />
    <link href="<?=base_url();?>assets/css/minifi/base.min.css" rel="stylesheet">
    <link href="<?=base_url();?>assets/css/minifi/pc.min.css" rel="stylesheet">
    <link href="<?=base_url();?>assets/css/minifi/jquery.mCustomScrollbar.min.css" rel='stylesheet' type='text/css' />
    <link href="<?=base_url();?>assets/css/minifi/jquery-confirm.min.css" rel='stylesheet' type='text/css' />

    <script type="text/javascript" src="<?=base_url();?>assets/js/jquery-2.1.3.min.js"></script>
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
    <div class="col-xs-9" id="menuleft" style="background: #FFFFFF;padding: 0;">
        <div id="cajaDatos">
            <h2 class="page-header">Usuarios</h2>
            <div class="contenedor-table">
                <table  class="table table-bordered"
                        id="example"
                        data-toggle="table"
                        data-search="true"
                        data-select-item-name="toolbar1"
                        data-pagination="true"
                        data-sort-name="name"
                        data-show-refresh="true"
                        data-show-toggle="true"
                        data-show-columns="true"
                        data-sort-order="desc">
                    <thead>
                    <tr>
                        <th class="text-center text-uppercase" data-field="nombre"  data-sortable="true">Nombre</th>
                        <th class="text-center text-uppercase" data-field="email"  data-sortable="true">Email</th>
                        <th class="text-center text-uppercase" data-field="usuario"  data-sortable="true">Usuario</th>
                        <th class="text-center text-uppercase" data-field="privilegio"  data-sortable="true">Nivel</th>
                        <?php if($this->conexion):?>
                        <th class="text-center text-uppercase">Cambiar Nivel</th>
                        <?php endif;?>
                        <th class="text-center text-uppercase">Eliminar</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php foreach($datos as $x):?>
                        <tr>
                            <td class="text-center"><?=$x->nombre;?></td>
                            <td class="text-center"><?=$x->email;?></td>
                            <td class="text-center"><?=$x->usuario;?></td>
                            <td class="text-center"><?=$x->privilegio;?></td>
                            <?php if($this->conexion):?>
                            <td class="text-center">
                                <button  class="btn btn-primary"  id="new_folder" data-toggle="modal" data-target="#myModal<?=$x->id;?>"><span class="glyphicon glyphicon-wrench"></span></button>
                                <div class="modal fade modalUser" id="myModal<?=$x->id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header" style="background: #286090;border: 1px solid #286090;">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-wrench"></span><?=nbs(1);?>Cambiar Nievel</h4>
                                            </div>
                                            <div class="modal-body text-left">
                                                <form role="form" id="change_privilegio<?=$x->id;?>">
                                                    <input type="number" name="id_usuario_p" id="id_usuario_p" value="<?=$x->id;?>" class="form-control sr-only">

                                                    <div class="radio">
                                                        <label>
                                                            <input type="radio" name="privilegio" id="optionsRadios1<?=$x->id;?>" value="1">
                                                            Nivel 1 [ T&eacute;cnico Municipio ]
                                                        </label>
                                                    </div>
                                                    <div class="radio">
                                                        <label>
                                                            <input type="radio" name="privilegio" id="optionsRadios2<?=$x->id;?>" value="2">
                                                            Nivel 2 [ Inform&aacute;tico Municipio ]
                                                        </label>
                                                    </div>
                                                    <div class="radio">
                                                        <label>
                                                            <input type="radio" name="privilegio" id="optionsRadios3<?=$x->id;?>" value="3">
                                                            Nivel 3 [ Provincia ]
                                                        </label>
                                                    </div>
                                                    <button type="button" class="btn btn-primary" id="change_p<?=$x->id;?>">Aceptar</button>
                                                    <button type="button" class="btn btn-default" id="change_p_close<?=$x->id;?>" data-dismiss="modal">Cancelar</button>
                                                </form>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->
                                <script type="text/javascript">
                                    var know = '<?=$x->privilegio;?>';
                                    if(know == '1')
                                    {
                                        $('#optionsRadios1<?=$x->id;?>').prop('checked','checked');
                                    }
                                    else if(know == '2')
                                    {
                                        $('#optionsRadios2<?=$x->id;?>').prop('checked','checked');
                                    }
                                    else
                                    {
                                        $('#optionsRadios3<?=$x->id;?>').prop('checked','checked');
                                    }

                                    $('#change_p_close<?=$x->id;?>').on('click',function(){
                                        $('#change_privilegio<?=$x->id;?>')[0].reset();
                                        var know = '<?=$x->privilegio;?>';
                                        if(know == '1')
                                        {
                                            $('#optionsRadios1<?=$x->id;?>').prop('checked','checked');
                                        }
                                        else if(know == '2')
                                        {
                                            $('#optionsRadios2<?=$x->id;?>').prop('checked','checked');
                                        }
                                        else
                                        {
                                            $('#optionsRadios3<?=$x->id;?>').prop('checked','checked');
                                        }
                                    });


                                    $('#change_p<?=$x->id;?>').on('click',function(){
                                        $.ajax({
                                            url: '<?=base_url();?>cambiar_privilegio',
                                            type: 'POST',
                                            data: $('#change_privilegio<?=$x->id;?>').serialize(),
                                            success: function(resp){
                                                if(resp == "listo")
                                                {
                                                    $('#myModal<?=$x->id;?>').modal('hide');
                                                    location.reload();
                                                }
                                                else{
                                                    $('#myModal<?=$x->id;?>').modal('hide');
                                                    $.alert({
                                                        icon: 'glyphicon glyphicon-warning-sign',
                                                        type: 'orange',
                                                        theme: 'modern',
                                                        closeIcon: true,
                                                        animation: 'rotate',
                                                        closeAnimation: 'scale',
                                                        title: 'Mensaje',
                                                        content: '<p> Ha ocurrido un error '+resp+'</p>',
                                                        buttons: {
                                                            ok: {
                                                                text: 'Aceptar',
                                                                btnClass: 'btn-default',
                                                                action: function () {
                                                                    this.close();
                                                                }
                                                            }
                                                        }
                                                    });
                                                }
                                            }
                                        });
                                    });

                                </script>
                            </td>
                            <?php endif;?>
                            <td class="text-center">
                                <button class="btn btn-danger" id="delete<?=$x->id;?>" data-toggle="modal" data-target="#myModal1<?=$x->id;?>"><span class="glyphicon glyphicon-trash"></span></button>

                                <div class="modal fade modalUser1" id="myModal1<?=$x->id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header" style="background: #843534;border: 1px solid #843534;">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h5 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-trash"></span><?=nbs(1);?> Eliminar</h5>
                                            </div>
                                            <form role="form" id="eliminar_usuario<?=$x->id?>">
                                                <input type="number" name="id_usuario" id="id_usuario" value="<?=$x->id?>" class="form-control sr-only">
                                                <div class="modal-body text-left" style="background: #a94442;">
                                                    <h4 style="color: #FFFFFF;">¿ Est&aacute;s seguro de eliminar al usuario :<br>
                                                        <small style="color: #FFFFFF;"><?=$x->nombre;?></small> ?</h4>
                                                    <button type="button" class="btn btn-danger" id="delete_user<?=$x->id?>">Aceptar</button>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                                </div>
                                            </form>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->

                                <script type="text/javascript">
                                    $('#delete_user<?=$x->id?>').on('click',function(){
                                        $('div.alert').addClass('sr-only');
                                        $.ajax({
                                            url: '<?=base_url();?>eliminar_usuario',
                                            type: 'POST',
                                            data: $('#eliminar_usuario<?=$x->id?>').serialize(),
                                            success: function(resp){
                                                if(resp == 'listo')
                                                {
                                                    $('#myModal1<?=$x->id;?>').modal('hide');
                                                    $.alert({
                                                        icon: 'glyphicon glyphicon-ok',
                                                        type: 'green',
                                                        theme: 'modern',
                                                        closeIcon: true,
                                                        closeAnimation: 'scale',
                                                        title: '&Eacute;xito',
                                                        content: '<p>El usuario fue eliminado satisfactoriamente.</p>',
                                                        buttons: {
                                                            ok: {
                                                                text: 'Aceptar',
                                                                btnClass: 'btn-default',
                                                                action: function () {
                                                                }
                                                            }
                                                        },
                                                        onClose: function(){
                                                            location.reload();
                                                        }
                                                    });
                                                }
                                                else{
                                                    $('#myModal1<?=$x->id;?>').modal('hide');
                                                    $.alert({
                                                        icon: 'glyphicon glyphicon-warning-sign',
                                                        type: 'orange',
                                                        theme: 'modern',
                                                        closeIcon: true,
                                                        animation: 'rotate',
                                                        closeAnimation: 'scale',
                                                        title: 'Mensaje',
                                                        content: '<p> Ha ocurrido un error '+resp+'</p>',
                                                        buttons: {
                                                            ok: {
                                                                text: 'Aceptar',
                                                                btnClass: 'btn-default',
                                                                action: function () {
                                                                    this.close();
                                                                }
                                                            }
                                                        }
                                                    });
                                                }
                                            }
                                        });
                                    });
                                </script>


                            </td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div>
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
                        <a class="list-group-item active" href="<?=base_url()?>ver_usuario"><span class="glyphicon glyphicon-link"></span> Usuarios</a>
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


<script type="text/javascript" src="<?=base_url();?>assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/js/bootstrap-table.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/js/application.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/js/jquery-confirm.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/js/jquery.mousewheel-3.0.6.min.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
        if(screen.height <= 768 || screen.height <= 864){
            var alto = (window.innerHeight-140-5);
            $('#principal').css({'height':alto,'margin-top':73});
            var tam = window.innerHeight-(70+200);
            $('.contenedor-table').css({'height':tam});
        }
        else{
            var alto = (window.innerHeight-160-5);
            $('#principal').css({'height':alto,'margin-top':83});
            var tam = window.innerHeight-(70+200);
            $('.contenedor-table').css({'height':tam});
        }
    });

    $(".contenedor-table").mCustomScrollbar({
        theme:"3d-thick-dark",
        scrollButtons:{
            enable:true,
            scrollType: "stepped"
        },
        advanced:{
            autoScrollOnFocus:false,
            UpdateOnContentResize: true
        }
    });
</script>



</body>
</html>
