<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RUME-FTP Modelo</title>
    <link rel="shortcut icon" href="<?=base_url();?>assets/img/FTP.PNG">

    <link href="<?=base_url();?>assets/css/minifi/bootstrap.min.css" rel='stylesheet' type='text/css' />

    <style type="text/css">
        .container{
            width: 95%;
        }
        .contenedor-error{
            background: #5bc0de;
            border: 5px solid #f0ad4e !important;
            padding: 10px;
            text-align: center;
        }
        h2{
            font-family: Tahoma, Verdana, Arial, sans-serif;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-12">
                    <h1 class="pull-left">Fichero: <small><?=$titulo;?></small></h1>
                </div>
            </div>
            <div class="contenedor-error">
                <h2><?=$error;?></h2>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript" src="<?=base_url();?>assets/js/jquery-2.1.3.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/js/bootstrap.min.js"></script>

</body>
</html>



