<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="<?=base_url();?>assets/css/minifi/bootstrap.min.css" rel='stylesheet' type='text/css' />
    <link href="<?=base_url();?>assets/css/minifi/iframe.min.css" rel="stylesheet" type="text/css">

</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <?php if($this->session->userdata('profile')=='administrador'):?>
                <div class="mensajes">
                    <p class="text-center"><img src="<?=base_url();?>assets/img/alert.png"></p>
                    <p class="text-center"><?=$msj1;?></p>
                    <p class="text-center"><?=$msj2;?></p>
                    <p class="text-center"><?=$msj3;?></p>
                </div>
            <?php else:?>
            <div class="mensajes">
                <p class="text-center"><img src="<?=base_url();?>assets/img/alert.png"></p>
                <p class="text-center"><?=$msj1;?></p>
                <p class="text-center"><?=$msj2;?></p>
            </div>
            <?php endif;?>
        </div>
    </div>
</div>


<script type="text/javascript" src="<?=base_url();?>assets/js/jquery-2.1.3.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/js/bootstrap.min.js"></script>


</body>
</html>

