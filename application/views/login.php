<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta charset="x-IBM1097">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RUME-FTP</title>
    <link rel="shortcut icon" href="<?=base_url();?>assets/img/FTP.PNG">

    <link href="<?=base_url();?>assets/css/minifi/bootstrap.min.css" rel='stylesheet' type='text/css' />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/vendor/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/vendor/daterangepicker/daterangepicker.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/util.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/main.css">
    <!--===============================================================================================-->
    <link href="<?=base_url();?>assets/css/minifi/jquery-confirm.min.css" rel='stylesheet' type='text/css' />
    <link rel="stylesheet" href="<?=base_url();?>assets/css/minifi/base.min.css">



</head>
<body>

<div class="banner">
    <img id="logo" src="<?=base_url();?>assets/images/ftp.PNG">
    <div id="caja">
        <h1>RUME-FTP</h1>
        <h2>Repositorio para la Ubicaci&oacute;n de los Modelos Estad&iacute;sticos
    </div>
</div>

<div class="col-xs-12">
<div class="col-xs-4">
    <input type="hidden" id="urlTo" value="<?=base_url();?>">
</div>
<div class="col-xs-4" style="padding: 0;">
    <div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-50" id="login">
        <form class="login100-form validate-form" action="<?=base_url();?>login" method="post">
            <span class="login100-form-title p-b-33">
                Iniciar Sesi&oacute;n
            </span>

            <div class="wrap-input100 validate-input" data-validate = "Usuario es requerido">
                <input class="input100" type="text" name="usuario" id="usuario" placeholder="Usuario">
                <span class="focus-input100-1"></span>
                <span class="focus-input100-2"></span>
            </div>
            <?=form_error('usuario');?>

            <div class="wrap-input100 rs1 validate-input" data-validate="Contrase&ntilde;a es requerido">
                <input class="input100" type="password" name="password" placeholder="Contrase&ntilde;a">
                <span class="focus-input100-1"></span>
                <span class="focus-input100-2"></span>
            </div>
            <?=form_error('password');?>

            <div class="container-login100-form-btn m-t-20">
                <button class="login100-form-btn btn" id="enviar">
                    Aceptar
                </button>
            </div>

            <div class="text-center p-t-45 p-b-4">
                <span class="txt1">
                    Olvid&eacute; mi
                </span>

                <a role="button" id="forgot" class="txt2 hov1">
                    Contrase&ntilde;a
                </a>
            </div>

            <div class="text-center">
                <span class="txt1">
                    ¿Crear una nueva cuenta?
                </span>
                <a role="button" class="txt2 hov1" data-toggle="modal" data-target="#myModal">
                    Registrarse
                </a>
            </div>

            <div class="text-center">
                <span class="txt1">
                    Obtener
                </span>

                <a role="button" target="_blank" href="<?=base_url();?>user_guide" class="txt2 hov1">
                    Ayuda
                </a>
            </div>
        </form>
    </div>
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-certificate"></span><?=nbs(1);?>Registro</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" name="formRegistro" id="formRegistro" >
                        <div class="form-group">
                            <label for="nombre" class="col-sm-4 control-label">Nombre y Apellidos</label>
                            <div class="col-sm-8">
                                <input type="text" autocomplete="off" class="form-control" name="nombre" id="nombre" placeholder="Nombre y Apellidos">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-sm-4 control-label">Email</label>
                            <div class="col-sm-8">
                                <input type="text" autocomplete="off"  class="form-control" name="email" id="email" placeholder="Email">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="user" class="col-sm-4 control-label">Usuario</label>
                            <div class="col-sm-8">
                                <input type="text" autocomplete="off"  class="form-control" name="user" id="user" placeholder="Usuario">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="contra" class="col-sm-4 control-label">Contrase&ntilde;a</label>
                            <div class="col-sm-8">
                                <input type="password" autocomplete="off"  class="form-control" name="contra" id="contra" placeholder="Contrase&ntilde;a">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="contrac" class="col-sm-4 control-label">Confirmar Contrase&ntilde;a</label>
                            <div class="col-sm-8">
                                <input type="password" autocomplete="off" class="form-control" name="contrac" id="contrac" placeholder="Confirmar Contrase&ntilde;a">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="rol" class="col-sm-4 control-label">Rol</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="rol" id="rol">
                                    <option value="1" selected>Técnico Municipio</option>
                                    <option value="2">Informático Municipio</option>
                                    <option value="3">Provincia</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" name="send" id="send"  class="btn btn-info">Aceptar</button>
                    <button type="reset" id="reset" name="reset" class="btn btn-default">Cancelar</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

</div>
<div class="col-xs-4"></div>
</div>





<footer>
    <div id="footer">
        <p>Oficina Nacional de Estad&iacute;sticas e Informaci&oacute;n</p>
        <img src="<?=base_url();?>assets/img/onei.png">
        <p>Todos los derechos reservados &copy; <?=date('Y');?></p>
    </div>
</footer>


<script type="text/javascript" src="<?=base_url();?>assets/js/jquery-2.1.3.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/js/jquery-confirm.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/main.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/button_action/login.min.js"></script>




<script type="text/javascript">
    $(document).ready(function() {
        $('input[type="password"]').keypress(function(){
            $('div.error').fadeOut(400);
        });
        $('input[type="text"]').keypress(function(){
            $('div.error').fadeOut(400);
        });
    });

    <?php if($this->session->flashdata('error')):?>
        $.alert({
            boxWidth: '20%',
            useBootstrap: false,
            icon: 'glyphicon glyphicon-remove',
            type: 'red',
            theme: 'error',
            title: 'Error',
            closeIcon: true,
            animation: 'rotate',
            closeAnimation: 'scale',
            content: '<div class="error">'+'<?=$this->session->flashdata('error');?>'+'</div>',
            buttons: {
                ok: {
                    text: 'Aceptar',
                    btnClass: 'btn-default'
                }
            },
            onClose: function(){
                $('#enviar').removeAttr('disabled');
            }
        },'show');
    <?php endif;?>

</script>

</body>
</html>

