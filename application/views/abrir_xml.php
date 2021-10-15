<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RUME-FTP Modelo</title>
    <link rel="shortcut icon" href="<?=base_url();?>assets/img/FTP.PNG">

    <link href="<?=base_url();?>assets/css/minifi/bootstrap.min.css" rel='stylesheet' type='text/css' />
    <link href="<?=base_url();?>assets/css/minifi/fakeLoader.min.css" rel='stylesheet' type='text/css' />
    <link href="<?=base_url();?>assets/css/minifi/jquery-confirm.min.css" rel='stylesheet' type='text/css' />
    <link href="<?=base_url();?>assets/css/minifi/bootstrap-datepicker.min.css" rel='stylesheet' type='text/css' />
    <link href="<?=base_url();?>assets/css/minifi/table.min.css" rel='stylesheet' type='text/css' />

</head>
<body  onbeforeunload="window_onload()">

<div id="here_fake"></div>
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <input id="ruta" type="hidden" value="<?=$ruta;?>">
            <div class="row">
                <div class="col-xs-12" id="banner">
                    <h1 class="pull-left">Fichero: <small><?=$titulo;?></small></h1>
                    <button type="button" id="serialize" class="btn btn-warning">Guardar Cambios</button>
                </div>
            </div>
            <div class="table-responsive">
                <table id="example" class="table table-bordered table-hover"></table>
                <?php
                function format_date_Y_mm_dd($date){
                    return date('d-m-Y', strtotime($date));
                }
                function conection($host,$port,$bd,$user,$pass){
                    $dbconection = pg_connect("host=".$host." port=".$port." dbname=".$bd." user=".$user." password=".$pass." options='--client_encoding=UTF8'");
                    if($dbconection == TRUE)
                    {
                        return TRUE;
                    }
                    else{
                        return FALSE;
                    }
                    pg_close($dbconection);
                }

                function getDescriptionbyIndicador($indicador){
                    $indicadores = pg_query("Select nombredescriptivo from tbindicadorpagina where idcodindicador='$indicador';");
                    while($row = pg_fetch_assoc($indicadores)) {
                        return $row['nombredescriptivo'];
                    }
                }

                $tmpl = array ( 'table_open'  => '<table id="example1" class="table table-bordered table-hover">' );
                $this->table->set_template($tmpl);


                if(empty($xml->paginas->pagina->indicador[0])){
                    echo '<div class="contenedor-error">
                        <h2>El modelo est&aacute; en blanco</h2>
                    </div>';
                }
                else{
                    $encabezados = new ArrayObject();
                    $encabezados->append('#');
                    $encabezados->append('Iindicador');
                    $encabezados->append('Fila');
                    foreach ($xml->paginas->pagina->indicador[0] as $rating) {
                        $encabezados->append($rating['alias']);
                    }
                    $list = new ArrayObject();
                    $j=1;
                    $this->table->set_heading($encabezados->getArrayCopy());
                    $sige = $this->users_model->getSige();
                    $pass =  base64_decode($sige->password);
                    if(conection($sige->host,$sige->port,$sige->bd,$sige->username,$pass))
                    {
                        foreach ($xml->paginas->pagina->indicador  as $indicadores)
                        {
                            $list->append($j);
                            $list->append(getDescriptionbyIndicador($indicadores->attributes()->codigoindicador));
                            $list->append($indicadores->attributes()->codigofila);
                            $x=0;
                            foreach ($indicadores as $child)
                            {
                                $list->append($child);
                                $x++;
                            }
                            $j++;
                        }
                    }else{
                        foreach ($xml->paginas->pagina->indicador  as $indicadores)
                        {
                            $list->append($j);
                            $list->append($indicadores->attributes()->codigoindicador);
                            $list->append($indicadores->attributes()->codigofila);
                            $x=0;
                            foreach ($indicadores as $child)
                            {
                                $list->append($child);
                                $x++;
                            }
                            $j++;
                        }
                    }
                    $new_list = $this->table->make_columns($list->getArrayCopy(), $x+3);
                    echo $this->table->generate($new_list);
                }
                ?>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript" src="<?=base_url();?>assets/js/jquery-2.1.3.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/js/fakeLoader.js"></script>

<script type="text/javascript" src="<?=base_url();?>assets/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/js/bootstrap-datepicker.es.min.js" ></script>

<script type="text/javascript" src="<?=base_url();?>assets/js/table.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/js/jquery.base64.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/js/jquery-confirm.min.js"></script>


<script type="text/javascript">
    function window_onload() {
        $('#here_fake').show();
        $('#here_fake').fakeLoader({timeToHide:120000000,spinner: "spinner6",zIndex:"999"});
    }
</script>

<script type="text/javascript">
    var demo = new Table({
        // id of table to attach to
        id: "example",
        // Table header fields, data types and classes
        fields: {
            "Modelo":{
                "class": "edit",
                "type": "string"
            },
            "Submodelo":{
                "class": "edit",
                "type": "string"
            },
            "Variante":{
                "class": "edit",
                "type": "int"
            },
            "Centro Informante":{
                "class": "edit",
                "type": "string"
            },
            "Fecha del informe acumulado":{
                "class": "edit",
                "type": "date"
            },
            "Fecha de confecci&oacute;n":{
                "class": "edit",
                "type": "date"
            },
            "Estado":{
                "class": "edit",
                "type": "int"
            },
            "Oservaciones":{
                "type": "string"
            },
            "Tipo de modelo":{
                "class": "edit",
                "type": "int"
            }
        },
        // Table data
        data: [
            <?php foreach($xml->encabezado as $x):?>
            [
                '<?=$x->idnummodelo;?>',
                '<?=$x->idsubnummodelo;?>',
                '<?=$x->idcodvariante;?>',
                '<?=$x->codcentroinformante;?>',
                '<?=$x->idfechadelinformeacumulado;?>',
                '<?=$x->idfechadeconfeccion;?>',
                '<?=$x->estado;?>',
                '<?=$x->observaciones;?>',
                '<?=$x->idtipodemodelo;?>'
            ]
            <?php endforeach;?>
        ],
        // Position table rows
        direction: "desc",
        // Enable debug output to console
        debug: false
    });
    $(document).ready(function() {
        demo.render();
        $('#datos').prop('value',JSON.stringify(demo.serialize()));
        $("button#serialize").on("click", function() {
            if($('.editcell').val() == ""){
                $.alert({
                    columnClass: 'small',
                    icon: 'glyphicon glyphicon-warning-sign',
                    type: 'orange',
                    theme: 'dark',
                    title: 'Información',
                    closeIcon: true,
                    boxWidth: '400px',
                    useBootstrap: false,
                    animation: 'zoom',
                    closeAnimation: 'scale',
                    animationSpeed: 200,
                    animationBounce: 2.5,
                    content: 'El campo de texto no puede estar vac&iacute;o.',
                    buttons: {
                        ok: {
                            text: 'Aceptar',
                            btnClass: 'btn-default'
                        }
                    }
                });
            }else{
                $.ajax({
                    url:  '<?=base_url();?>guardar_cambios/'+$.base64.encode($('#ruta').val()),
                    type: 'POST',
                    data: {'datos':JSON.stringify(demo.serialize())},
                    beforeSend: function(){
                        $('#here_fake').show();
                        $('#here_fake').fakeLoader({timeToHide:120000000,spinner:"spinner6"});
                    },
                    success: function (resp) {
                        if (resp == 'listo') {
                            $('#here_fake').fadeOut('slow');
                            $.alert({
                                columnClass: 'small',
                                icon: 'glyphicon glyphicon-ok',
                                type: 'green',
                                theme: 'modern',
                                closeIcon: true,
                                animation: 'rotate',
                                closeAnimation: 'scale',
                                title: '&Eacute;xito',
                                content: 'El archivo fue guardado',
                                buttons: {
                                    ok: {
                                        text: 'Aceptar',
                                        btnClass: 'btn-default',
                                        action: function () {
                                            location.reload();
                                        }
                                    }
                                },
                                onClose:function(){
                                    location.reload();
                                }
                            });
                        }else{
                            $('#here_fake').fadeOut('slow');
                            location.href = '<?=base_url();?>login';
                        }
                    }
                });

            }
        });
    });
</script>

</body>
</html>



