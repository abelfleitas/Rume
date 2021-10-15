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
    <link href="<?=base_url();?>assets/css/minifi/base.min.css" rel="stylesheet">
    <link href="<?=base_url();?>assets/css/minifi/jquery-confirm.min.css" rel='stylesheet' type='text/css' />
    <link type="text/css" href="<?=base_url()?>assets/css/minifi/main.css" rel="stylesheet" >

    <style type="text/css">
        h1{
            font-family: Tahoma, Verdana, Arial, sans-serif;
            color: #f0ad4e;
            letter-spacing: 3px;
            font-weight: 600;
            text-shadow: 1px 2px 3px black;
        }
        a{
            font-size: 16px;
            color: #000080;
        }
        a:hover{
            color: #000080;
        }
    </style>

</head>
<body>

<div class="banner">
    <img id="logo" src="<?=base_url();?>assets/images/ftp.PNG">
    <div id="caja">
        <h1>RUME-FTP</h1>
        <h2>Repositorio para la Ubicaci&oacute;n de los Modelos Estad&iacute;sticos
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="col-xs-3"></div>
            <div class="col-xs-6" style="
            text-align: center;margin-top: 20%;
            box-shadow: 0 1px 2px 1px #000000;
            padding: 60px;color: #ffffff;background-color: #5bc0de;border: 5px solid #f0ad4e;">
                <h1 style="">Deshabilitado</h1>
                <a role="button" id="habilitar">Click para Habilitar</a>
            </div>
            <div class="col-xs-3"></div>
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


<script type="text/javascript" src="<?=base_url();?>assets/js/jquery-2.1.3.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/js/jquery-confirm.min.js"></script>

<script type="text/javascript">
    $('#habilitar').on('click',function(e){
        $.confirm({
            icon: 'glyphicon glyphicon-user',
            type: 'blue',
            theme: 'modern',
            bgOpacity: 0.9,
            animation: 'rotate',
            closeAnimation: 'scale',
            title: 'Iniciar sesión',
            content: '' +
            '<form class="formName" name="formHabilitar" id="formHabilitar" novalidate style="padding: 5px;">'+
                '<div class="form-group">'+
                    '<input type="text" autocomplete="off" class="form-control" id="username" name="username" placeholder="Usuario">'+
                '</div>'+
                '<div class="form-group">'+
                    '<input type="password"  autocomplete="off" class="form-control" id="password" name="password" placeholder="Contrase&ntilde;a">'+
                '</div>'+
            '</form>',
            closeIcon: true,
            buttons: {
                formSubmit: {
                    text: 'Aceptar',
                    btnClass: 'btn-blue',
                    action: function (formSubmit) {
                        var self = this;
                        formSubmit.disable();
                        $.ajax({
                            url: '<?=base_url();?>habilitar',
                            type: 'POST',
                            data: $('#formHabilitar').serialize()
                        }).done(function (resp) {
                            if(resp != "listo"){
                                if(resp == 'Los datos son incorrectos.'){
                                    $('#formHabilitar')[0].reset();
                                }
                                $.alert({
                                    boxWidth: '25%',
                                    useBootstrap: false,
                                    icon: 'glyphicon glyphicon-remove',
                                    type: 'red',
                                    theme: 'error',
                                    title: 'Error',
                                    closeIcon: true,
                                    animation: 'rotate',
                                    closeAnimation: 'scale',
                                    content: '<div class="error">'+resp+'</div>',
                                    buttons: {
                                        ok: {
                                            text: 'Aceptar',
                                            btnClass: 'btn-default'
                                        }
                                    },
                                    onClose: function(){
                                        formSubmit.enable();
                                    }
                                });
                            }else{
                                self.close();
                                location.href='<?=base_url()?>ftp';
                            }
                        }).fail(function(){
                            $.alert({
                                columnClass: 'small',
                                icon: 'glyphicon glyphicon-warning-sign',
                                type: 'orange',
                                theme: 'dark',
                                title: 'Información',
                                closeIcon: true,
                                animation: 'rotate',
                                closeAnimation: 'scale',
                                content: '<div class="error">No se pudo enviar la petición al servidor.</div>',
                                buttons: {
                                    ok: {
                                        text: 'Aceptar',
                                        btnClass: 'btn-default'
                                    }
                                },
                                onClose: function(){
                                    formSubmit.enable();
                                }
                            });
                        });
                        return false;
                    }
                },
                cancel: {
                    text: 'Cancelar',
                    btnClass: 'btn-default',
                    action:function(){
                        this.close();
                    }
                }
            },
            onContentReady: function () {
                var jc = this;
                this.$content.find('#formRecuperar').on('submit',function(e){
                    e.preventDefault();
                });
            }

        });

    });
</script>


</body>
</html>

