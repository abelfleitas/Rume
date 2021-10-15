<div class="col-xs-12" style="padding: 0;">
    <div class="col-xs-9" style="padding-right: 20px;">
        <div id="menu_contenido">
            <div id="cajaDatos">
                <h2 class="page-header">Comprimir Archivos</h2>
                <div id="contenido_real">
                    <div class="col-xs-12 ">
                        <div class="media">
                            <h4 class="media-heading">Paso 1:</h4>
                            <a id="aumentar" style="width: 100%;height: auto" href="<?=base_url();?>assets/img/comprimir.png" rel="prettyPhoto[gallery1]" class="img-polaroid pull-left" role="button">
                                <figure>
                                    <img style="width: 100%;height: auto" class="media-object" src="<?=base_url();?>assets/img/comprimir.png" alt="comprimir.png">
                                    <figcaption>
                                        Figura 38
                                    </figcaption>
                                </figure>
                            </a>
                            <div class="media-body">
                                <p class="text-justify">
                                    Hacer clic en el <strong>Panel de Acciones</strong> sobre la opción <strong>Comprimir Archivos</strong> (ver <strong>Figura 38</strong>).
                                    El sistema responderá mostrando una ventana para eliminar los archivos deseados (ver <strong>Figura 39</strong>).
                                </p>
                            </div>
                        </div>
                        <div class="media">
                            <a id="aumentar" href="<?=base_url();?>assets/img/comprimir1.png" rel="prettyPhoto[gallery1]" class="img-polaroid pull-left" role="button">
                                <figure>
                                    <img class="media-object" src="<?=base_url();?>assets/img/comprimir1.png" alt="comprimir1.png" width="180" height="120">
                                    <figcaption>
                                        Figura 39
                                    </figcaption>
                                </figure>
                            </a>
                            <a id="aumentar" href="<?=base_url();?>assets/img/comprimir2.png" rel="prettyPhoto[gallery1]" class="img-polaroid pull-left" role="button">
                                <figure>
                                    <img class="media-object" src="<?=base_url();?>assets/img/comprimir2.png" alt="comprimir2.png" width="180" height="120">
                                    <figcaption>
                                        Figura 40
                                    </figcaption>
                                </figure>
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading">Paso 2:</h4>
                                <p class="text-justify">
                                    Para comprimir archivos marque en la casilla  los que desea comprimir, y si los desea todos seleccione la casilla
                                    <strong>Marcar Todos</strong>, luego haga clic en el botón <strong>Aceptar</strong>,
                                    y espere mientras se comprimen los archivos (ver <strong>Figura 39</strong>).
                                    En caso de que acepte sin marcar ninguno el sistema le notificara  con un error (ver <strong>Figura 40</strong>).
                                </p>
                                <p class="well text-justify">
                                    <strong>Nota:</strong> por defecto el sistema nombrará al archivo reducido con el nombre: <strong>comprimido</strong>,
                                    el formato de compresión será <strong>Zip</strong>. En caso de que exista un archivo con ese nombre
                                    el nuevo comprimido será renombrado con el correlativo que sería de <strong>comprimido - comprimido_0</strong>
                                    y así sucesivamente.
                                </p>
                            </div>
                        </div>
                        <div class="media">
                            <a id="aumentar" href="<?=base_url();?>assets/img/comprimir3.png" rel="prettyPhoto[gallery1]" class="img-polaroid pull-left" role="button">
                                <figure>
                                    <img class="media-object" src="<?=base_url();?>assets/img/comprimir3.png" alt="comprimir3.png" width="180" height="120">
                                    <figcaption>
                                        Figura 41
                                    </figcaption>
                                </figure>
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading">Descompresión:</h4>
                                <p class="text-justify">
                                    Para descomprimir un archivo diríjase sobre él haga clic derecho y
                                    seleccione en el menú opciones la opción Extraer (ver <strong>Figura 41</strong>),
                                    y espere mientras se realiza la extracción.
                                </p>
                                <p class="well text-justify">
                                    <strong>Nota:</strong> Solo se pueden descomprimir archivos <strong>.zip</strong>.
                                    En caso de que a la hora de descomprimir un archivo existan archivos que tienen el
                                    mismo nombre que los que se van a descomprimir el sistema los renombrara con el correlativo y no serán
                                    sobrescrito.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <ul class="pager">
                    <li class="previous"><a href="<?=base_url();?>load/10">&larr; P&aacute;gina Anterior</a></li>
                    <li class="next"><a href="<?=base_url();?>load/12">P&aacute;gina Siguiente &rarr;</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-xs-3" id="menu" style="padding: 0;">
        <div class="list-group" id="menu_lateral">
            <a class="list-group-item" href="<?=base_url()?>user_guide"> Introducci&oacute;n</a>
            <a class="list-group-item" href="<?=base_url()?>user_guide/registrarse"> Registrarse</a>
            <a class="list-group-item" href="<?=base_url()?>user_guide/recuperar_contrasena"> Recuperar Contrase&ntilde;a</a>
            <a class="list-group-item" href="<?=base_url()?>user_guide/editar_mis_datos"> Editar Mis Datos</a>
            <a class="list-group-item" href="<?=base_url()?>user_guide/cambiar_contrasena"> Cambiar Contrase&ntilde;a</a>
            <a class="list-group-item parent" href="#">
                <span data-toggle="collapse" href=".children" class="icon pull-right"><em class="glyphicon glyphicon-s glyphicon-plus"></em></span>
                Servicios FTP
            </a>
            <div class="list-group children collapse">
                <a class="list-group-item" href="<?=base_url()?>user_guide/nueva_carpeta"> Nueva Carpeta</a>
                <a class="list-group-item" href="<?=base_url()?>user_guide/subir_archivos"> Subir Archivos</a>
                <a class="list-group-item" href="<?=base_url()?>user_guide/descargar_archivos"> Descargar Archivos</a>
                <a class="list-group-item" href="<?=base_url()?>user_guide/renombrar_archivos"> Renombrar Archivos</a>
                <a class="list-group-item" href="<?=base_url()?>user_guide/eliminar_archivos"> Eliminar Archivos</a>
                <a class="list-group-item active" href="<?=base_url()?>user_guide/comprimir_archivos"> Comprimir Archivos</a>
                <a class="list-group-item" href="<?=base_url()?>user_guide/mover_archivos"> Mover Archivos</a>
            </div>
            <a class="list-group-item" href="<?=base_url()?>user_guide/edicion_de_modelos"> Edici&oacute;n de Modelos</a>
        </div>
    </div>
</div>


