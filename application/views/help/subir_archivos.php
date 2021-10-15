<div class="col-xs-12" style="padding: 0;">
    <div class="col-xs-9" style="padding-right: 20px;">
        <div id="menu_contenido">
            <div id="cajaDatos">
                <h2 class="page-header">Subir Archivos</h2>
                <div id="contenido_real">
                    <div class="col-xs-12 ">
                        <div class="media">
                            <h4 class="media-heading">Paso 1:</h4>
                            <a id="aumentar" style="width: 100%;height: auto" href="<?=base_url();?>assets/img/uploadfile.png" rel="prettyPhoto[gallery1]" class="img-polaroid pull-left" role="button">
                                <figure>
                                    <img style="width: 100%;height: auto" class="media-object" src="<?=base_url();?>assets/img/uploadfile.png" alt="uploadfile.png">
                                    <figcaption>
                                        Figura 18
                                    </figcaption>
                                </figure>
                            </a>
                            <div class="media-body">
                                <p class="text-justify">
                                    Hacer clic en el <strong>Panel de Acciones</strong> sobre la opci&oacute;n <strong>Subir Archivos</strong> (ver <strong>Figura 18</strong>).
                                    El sistema responderá mostrando una ventana para subir los archivos deseados (ver <strong>Figura 19</strong>).
                                </p>
                            </div>
                        </div>

                        <div class="media">
                            <a id="aumentar" href="<?=base_url();?>assets/img/uploadfile1.png" rel="prettyPhoto[gallery1]" class="img-polaroid pull-left" role="button">
                                <figure>
                                    <img  class="media-object" src="<?=base_url();?>assets/img/uploadfile1.png" alt="uploadfile1.png" width="180" height="120">
                                    <figcaption>
                                        Figura 19
                                    </figcaption>
                                </figure>
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading">Paso 2:</h4>
                                <p class="text-justify">
                                    Sobre la región subrayada por líneas discontinuas haga clic y el sistema le permitirá buscar la ubicación de los archivos y seleccionarlos (la selección se pude realizar múltiple), también pude utilizar la variante de arrastrar los archivos hacia la región subrayada y soltarlos de igual manera serán cargados,
                                </p>
                            </div>
                        </div>

                        <div class="media">
                            <a id="aumentar" href="<?=base_url();?>assets/img/uploadfile2.png" rel="prettyPhoto[gallery1]" class="img-polaroid pull-left" role="button">
                                <figure>
                                    <img  class="media-object" src="<?=base_url();?>assets/img/uploadfile2.png" alt="uploadfile2.png" width="180" height="120">
                                    <figcaption>
                                        Figura 20
                                    </figcaption>
                                </figure>
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading">Paso 3:</h4>
                                <p class="text-justify">
                                    Una vez cargado los archivos el sistema notificara si alguno tiene error, los errores que se tienen en cuenta son los siguientes:<br>
                                    - La extensión del archivo no está permitido subirlo al servidor.<br>
                                    - No se pueden subir archivos en blanco, es decir, archivos de tamaño de 0 bytes.<br>
                                    - No se puede subir archivos con un tamaño mayor de 10 MB.<br>
                                    - El límite de cantidad máxima de archivos que puede subir es 20.<br>
                                    En cualquiera de estos casos usted podrá ignorar los errores y hacer clic en el botón <strong>Aceptar</strong> y esperar al que el sistema suba los archivos válidos, los erróneos simplemente no se subirán al servidor.
                                </p>
                            </div>
                        </div>

                        <div class="media">
                            <a id="aumentar" href="<?=base_url();?>assets/img/uploadfile3.png" rel="prettyPhoto[gallery1]" class="img-polaroid pull-left" role="button">
                                <figure>
                                    <img  class="media-object" src="<?=base_url();?>assets/img/uploadfile3.png" alt="uploadfile3.png" width="180" height="120">
                                    <figcaption>
                                        Figura 21
                                    </figcaption>
                                </figure>
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading">Alternativa:</h4>
                                <p class="text-justify">
                                    En caso de que haya subido un archivo no deseado usted pude simplemente eliminarlo haciendo clic en el botón <strong>Eliminar</strong>
                                    debajo al archivo correspondiente (ver <strong>Figura 20</strong>), confirme el cuadro de notificación que el sistema le mostrara
                                    (ver <strong>Figura 21</strong>) y continúe con la subida.
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
                <ul class="pager">
                    <li class="previous"><a href="<?=base_url();?>load/6">&larr; P&aacute;gina Anterior</a></li>
                    <li class="next"><a href="<?=base_url();?>load/8">P&aacute;gina Siguiente &rarr;</a></li>
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
                <a class="list-group-item" href="<?=base_url()?>user_guide/nueva_carpeta"><span class="glyphicon glyphicon-share-alt"></span> Nueva Carpeta</a>
                <a class="list-group-item active" href="<?=base_url()?>user_guide/subir_archivos"><span class="glyphicon glyphicon-share-alt"></span> Subir Archivos</a>
                <a class="list-group-item" href="<?=base_url()?>user_guide/descargar_archivos"><span class="glyphicon glyphicon-share-alt"></span> Descargar Archivos</a>
                <a class="list-group-item" href="<?=base_url()?>user_guide/renombrar_archivos"><span class="glyphicon glyphicon-share-alt"></span> Renombrar Archivos</a>
                <a class="list-group-item" href="<?=base_url()?>user_guide/eliminar_archivos"><span class="glyphicon glyphicon-share-alt"></span> Eliminar Archivos</a>
                <a class="list-group-item" href="<?=base_url()?>user_guide/comprimir_archivos"><span class="glyphicon glyphicon-share-alt"></span> Comprimir Archivos</a>
                <a class="list-group-item" href="<?=base_url()?>user_guide/mover_archivos"><span class="glyphicon glyphicon-share-alt"></span> Mover Archivos</a>
            </div>
            <a class="list-group-item" href="<?=base_url()?>user_guide/edicion_de_modelos"> Edici&oacute;n de Modelos</a>
        </div>
    </div>
</div>


