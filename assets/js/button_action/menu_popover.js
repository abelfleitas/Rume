var urlTo = $('#base_url').val();
$('.popovers').popover({
    container: 'body',
    animation: true,
    placement: 'auto',
    trigger: 'manual',
    html: true,
    title: function () {
        return $("#popover-head").html();
    },
    content: function () {
        return $(".popover-content"+this.id).html();
    }
}).bind('contextmenu',function(e){
    $(this).popover('show');
    $('#vista_archivos').mCustomScrollbar('disable');
    e.stopPropagation();
    return false;
});
$('.popovers').on('contextmenu',function(e){
    $('.popovers').not(this).popover('hide');
});

$(document).click(function(e){
    if(e.button == 0){
        $('.popovers').popover('hide');
        $('#vista_archivos').mCustomScrollbar('update');
    }
});
$(document).keydown(function(e){
    if(e.keyCode == 27){
        $('.popover').popover('hide');
        $('#vista_archivos').mCustomScrollbar('update');
    }
});

var $file = '';


$('#myModalOpen').on('show.bs.modal',function(){
    tinymce.init({
        selector: "textarea",
        theme: "modern",
        height: 262,
        statusbar: false,
        language: 'es',
        toolbar: false,
        setup: function(editor){
            editor.addMenuItem('myitem',{
                text: 'Guardar Archivo',
                context: 'file',
                icon: 'save',
                plugins: 'save',
                onclick: function(){
                    guardar_archivo($file,tinymce.get('text').getContent());
                }
            }),
            editor.addMenuItem('myitem1',{
                text: 'Salir',
                context: 'file',
                icon: '',
                image: urlTo+'assets/img/salir.jpg',
                onclick: function(){
                    salvarFichero();
                }
            });
        }
    });
});

$('#myModalOpen').on('hidden.bs.modal',function(){
    tinymce.remove('textarea');
});

function abrir_file(id_file) {
    $file = id_file;
    $.ajax({
        url: urlTo+'open/' + $.base64.encode(id_file),
        type: 'POST',
        beforeSend: function () {
            $('#here_fake').show();
            $('#here_fake').fakeLoader({timeToHide: 12000000, spinner: "spinner6"});
        },
        success: function (respuesta) {
            $('#here_fake').hide();
            $('textarea').text(respuesta);
            $('#nombre_file_for_modal').html('<strong>Archivo:</strong> '+id_file);
            $('#myModalOpen').modal('show');
        }
    });
}

function open_file(fichero){
    var elemento = document.getElementById(fichero);
    var id_f = elemento.dataset.att;
    $file = id_f;
    $.ajax({
        url: urlTo+'open/' + $.base64.encode($file),
        type: 'POST',
        beforeSend: function () {
            $('#here_fake').show();
            $('#here_fake').fakeLoader({timeToHide: 12000000, spinner: "spinner6"});
        },
        success: function (respuesta) {
            $('#here_fake').hide();
            $('textarea').html(respuesta);
            $('#nombre_file_for_modal').html('<strong>Archivo:</strong> '+id_f);
            $('#myModalOpen').modal('show');
        }
    });
}

function guardar_archivo(archivo,contenido){
    var camin = $('#camino_actual').val();
    $.ajax({
        url: urlTo+'guardarFile',
        type: 'POST',
        data: {'rutaarchivo':archivo,'contenido':contenido,'ruta_actual':camin},
        success: function(resp){
            $.alert({
                columnClass: 'small',
                icon: 'glyphicon glyphicon-ok',
                type: 'green',
                theme: 'modern',
                closeIcon: true,
                animation: 'rotate',
                closeAnimation: 'scale',
                title: '&Eacute;xito',
                content: resp,
                buttons: {
                    ok: {
                        text: 'Aceptar',
                        btnClass: 'btn-default',
                        action: function () {
                        }
                    }
                }
            });
        }
    });
}

$('#close_open_file').on('click',function(e){
    e.stopPropagation();
    salvarFichero();
    return false;
});

function salvarFichero(){
    $.ajax({
        url: urlTo+'open/' + $.base64.encode($file),
        type: 'POST',
        success: function (respuesta) {
            if(tinymce.get('text').getContent() != respuesta) {
                $.confirm({
                    boxWidth: '35%',
                    useBootstrap: false,
                    icon: 'glyphicon glyphicon-warning-sign',
                    title: 'Información',
                    content: 'Desea guardar los cambios realizados.',
                    type: 'orange',
                    theme: 'dark',
                    closeIcon: true,
                    buttons: {
                        save: {
                            text: 'Guardar',
                            keys: ['enter', 'shift'],
                            btnClass: 'btn-warning',
                            action: function(){
                                $.ajax({
                                    url: urlTo+'guardarFile',
                                    type: 'POST',
                                    data: {'rutaarchivo':$file,'contenido':tinymce.get('text').getContent(),'ruta_actual':$('#camino_actual').val()},
                                    success: function(resp){
                                        $('#myModalOpen').modal('hide');
                                        location.reload();
                                    }
                                });
                            }
                        },
                        no_save: {
                            text: 'No Guardar',
                            btnClass: 'btn-default',
                            action: function(){
                                $('#myModalOpen').modal('hide');
                                location.reload();
                            }
                        },
                        cancel: {
                            text: 'Cancelar',
                            btnClass: 'btn-default',
                            action: function(){
                            }
                        }
                    }
                });
            }
            else{
                $('#myModalOpen').modal('hide');
                location.reload();
            }
        }
    });
}

function rename_file(nombre) {
    if(getFileExtension(nombre) != '') {
        $.confirm({
            title: 'Renombrar Archivo',
            icon: 'glyphicon glyphicon-edit',
            type: 'blue',
            closeIcon: true,
            content: '' +
            '<form id="formRename" name="formRename" class="formName" novalidate>' +
            '<div class="form-group">' +
            '<label>Archivo:&nbsp;</label><small>'+nombre+'</small>'+
            '<input type="hidden" name="ruta_edit" value="'+$('#camino_actual').val()+'"/>'+
            '<input type="text" placeholder="escribe un nombre" class="name form-control" name="inp[]" required="required" />' +
            '<input type="hidden" value="'+getFileName(nombre)+'" name="name_old[]">'+
            '<input type="hidden" value="'+getFileExtension(nombre)+'" class="ext_file" name="ext[]">'+
            '</div>' +
            '</form>',
            buttons: {
                formSubmit: {
                    text: 'Aceptar',
                    btnClass: 'btn-blue',
                    keys: ['enter', 'shift'],
                    action: function () {
                        var name = this.$content.find('.name').val();
                        if(!name){
                            $.alert({
                                columnClass: 'small',
                                icon: 'glyphicon glyphicon-warning-sign',
                                closeIcon: true,
                                type: 'orange',
                                theme: 'dark',
                                title: 'Información',
                                boxWidth: '360px',
                                useBootstrap: false,
                                animation: 'zoom',
                                closeAnimation: 'scale',
                                animationSpeed: 200,
                                animationBounce: 2.5,
                                content: "Escriba un texto para renombrar el archivo.",
                                buttons: {
                                    ok: {
                                        text: 'Aceptar',
                                        btnClass: 'btn-default'
                                    }
                                }
                            });
                            return false;
                        }
                        else{
                            var re = /^[a-zA-Z0-9]*$/;
                            var re12 = /^[a-zA-Z0-9()_-]*$/;
                            var ext = this.$content.find('.ext_file').val();
                            if(ext == 'txt'||ext == 'zip'||ext == 'rar'||ext == 'gz'||ext == '7zip'||ext == '7z'||ext == 'tar'|| ext == 'gtar'||ext == 'gzip'){
                                if(re.test(name) == false){
                                    $.alert({
                                        columnClass: 'small',
                                        icon: 'glyphicon glyphicon-warning-sign',
                                        closeIcon: true,
                                        type: 'orange',
                                        theme: 'dark',
                                        title: 'Información',
                                        boxWidth: '360px',
                                        useBootstrap: false,
                                        animation: 'zoom',
                                        closeAnimation: 'scale',
                                        animationSpeed: 200,
                                        animationBounce: 2.5,
                                        content: "El campo solo puede aceptar caracteres de tipo alfanuméricos.",
                                        buttons: {
                                            ok: {
                                                text: 'Aceptar',
                                                btnClass: 'btn-default'
                                            }
                                        }
                                    });
                                    return false;
                                }else{
                                    $.ajax({
                                        url:  urlTo+'editar_archivo',
                                        type: 'POST',
                                        data: $('#formRename').serialize(),
                                        beforeSend: function(){
                                            $('#here_fake').show();
                                            $('#here_fake').fakeLoader({timeToHide:120000000,spinner:"spinner6"});
                                        },
                                        success: function(resp){
                                            if(resp == "listo"){
                                                location.reload();
                                            }
                                        }
                                    });
                                }
                            }else if(ext == 'xml'){
                                if(re12.test(name) == false){
                                    $.alert({
                                        columnClass: 'small',
                                        icon: 'glyphicon glyphicon-warning-sign',
                                        closeIcon: true,
                                        type: 'orange',
                                        theme: 'dark',
                                        title: 'Información',
                                        boxWidth: '360px',
                                        useBootstrap: false,
                                        animation: 'zoom',
                                        closeAnimation: 'scale',
                                        animationSpeed: 200,
                                        animationBounce: 2.5,
                                        content: "El campo solo puede aceptar caracteres de tipo alfanuméricos, paréntesis, guion y guion bajo.",
                                        buttons: {
                                            ok: {
                                                text: 'Aceptar',
                                                btnClass: 'btn-default'
                                            }
                                        }
                                    });
                                    return false;
                                }
                                else{
                                    $.ajax({
                                        url:  urlTo+'editar_archivo',
                                        type: 'POST',
                                        data: $('#formRename').serialize(),
                                        beforeSend: function(){
                                            $('#here_fake').show();
                                            $('#here_fake').fakeLoader({timeToHide:120000000,spinner:"spinner6"});
                                        },
                                        success: function(resp){
                                            if(resp == "listo"){
                                                location.reload();
                                            }
                                        }
                                    });
                                }
                            }
                        }
                    }
                },
                cancel: {
                    text: 'Cancelar',
                    btnClass: 'btn-default'
                }
            },
            onContentReady: function () {
                // bind to events
                var jc = this;
                this.$content.find('#formRename').on('submit', function (e) {
                    e.preventDefault();
                    var name = $('.name').val();
                    if(!name){
                        $.alert({
                            columnClass: 'small',
                            icon: 'glyphicon glyphicon-warning-sign',
                            closeIcon: true,
                            type: 'orange',
                            theme: 'dark',
                            title: 'Información',
                            boxWidth: '360px',
                            useBootstrap: false,
                            animation: 'zoom',
                            closeAnimation: 'scale',
                            animationSpeed: 200,
                            animationBounce: 2.5,
                            content: "Escriba un texto para renombrar el archivo.",
                            buttons: {
                                ok: {
                                    text: 'Aceptar',
                                    btnClass: 'btn-default'
                                }
                            }
                        });
                        return false;
                    }
                    else{
                        jc.$$formSubmit.trigger('click');
                    }
                });
            }
        });
    }
    else{
        $.confirm({
            columnClass: 'small',
            title: 'Renombrar Archivo',
            icon: 'glyphicon glyphicon-edit',
            type: 'blue',
            closeIcon: true,
            content: '' +
            '<form id="formRename" name="formRename" class="formName" novalidate>' +
            '<div class="form-group">' +
            '<label>Carpeta:&nbsp;</label><small>'+nombre+'</small>'+
            '<input type="hidden" name="ruta_edit" value="'+$('#camino_actual').val()+'"/>'+
            '<input type="text" placeholder="escribe un nombre" class="name form-control" name="inp[]" required="required" />' +
            '<input type="hidden" value="'+nombre+'" name="name_old[]">'+
            '<input type="hidden" value="" name="ext[]" class="ext_file">'+
            '</div>' +
            '</form>',
            buttons: {
                formSubmit: {
                    text: 'Aceptar',
                    btnClass: 'btn-blue',
                    keys: ['enter', 'shift'],
                    action: function () {
                        var name = this.$content.find('.name').val();
                        if(!name){
                            $.alert({
                                columnClass: 'small',
                                icon: 'glyphicon glyphicon-warning-sign',
                                closeIcon: true,
                                type: 'orange',
                                theme: 'dark',
                                title: 'Información',
                                boxWidth: '360px',
                                useBootstrap: false,
                                animation: 'zoom',
                                closeAnimation: 'scale',
                                animationSpeed: 200,
                                animationBounce: 2.5,
                                content: "Escriba un texto para renombrar el archivo.",
                                buttons: {
                                    ok: {
                                        text: 'Aceptar',
                                        btnClass: 'btn-default'
                                    }
                                }
                            });
                            return false;
                        }
                        else{
                            var reg = /^([a-zA-Z0-9_]+[\s]*)+$/;
                            var ext = this.$content.find('.ext_file').val();
                            if(ext == ''){
                                if(reg.test(name) == false){
                                    $.alert({
                                        columnClass: 'small',
                                        icon: 'glyphicon glyphicon-warning-sign',
                                        closeIcon: true,
                                        type: 'orange',
                                        theme: 'dark',
                                        title: 'Información',
                                        boxWidth: '360px',
                                        useBootstrap: false,
                                        animation: 'zoom',
                                        closeAnimation: 'scale',
                                        animationSpeed: 200,
                                        animationBounce: 2.5,
                                        content: "El campo solo puede aceptar caracteres de tipo alfanuméricos, guion bajo y espacios.",
                                        buttons: {
                                            ok: {
                                                text: 'Aceptar',
                                                btnClass: 'btn-default'
                                            }
                                        }
                                    });
                                    return false;
                                }else{
                                    $.ajax({
                                        url:  urlTo+'editar_archivo',
                                        type: 'POST',
                                        data: $('#formRename').serialize(),
                                        beforeSend: function(){
                                            $('#here_fake').show();
                                            $('#here_fake').fakeLoader({timeToHide:120000000,spinner:"spinner6"});
                                        },
                                        success: function(resp){
                                            if(resp == "listo"){
                                                location.reload();
                                            }
                                        }
                                    });
                                }
                            }
                        }
                    }
                },
                cancel: {
                    text: 'Cancelar',
                    btnClass: 'btn-default'
                }
            },
            onContentReady: function () {
                // bind to events
                var jc = this;
                this.$content.find('#formRename').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    var name = $('.name').val();
                    if(!name){
                        $.alert({
                            columnClass: 'small',
                            icon: 'glyphicon glyphicon-warning-sign',
                            closeIcon: true,
                            type: 'orange',
                            theme: 'dark',
                            title: 'Información',
                            boxWidth: '360px',
                            useBootstrap: false,
                            animation: 'zoom',
                            closeAnimation: 'scale',
                            animationSpeed: 200,
                            animationBounce: 2.5,
                            content: "Escriba un texto para renombrar el archivo.",
                            buttons: {
                                ok: {
                                    text: 'Aceptar',
                                    btnClass: 'btn-default'
                                }
                            }
                        });
                        return false;
                    }
                    else{
                        jc.$$formSubmit.trigger('click'); // reference the button and click it
                    }
                });
            }
        });
    }
}

function delete_file(nombre) {
    var nom_b ='';
    if(getFileExtension(nombre) !='')
    {
        nom_b = 'archivo';
    }
    else{
        nom_b = 'carpeta';
    }
    $.confirm({
        columnClass: 'small',
        title: 'Informacion',
        icon: 'glyphicon glyphicon-trash',
        type: 'red',
        theme: 'dark',
        content: '¿Estas seguro de eliminar el '+nom_b+' <strong id="resultadado_search">'+nombre+'</strong>?'+
        '<form id="formDelete" name="formDelete" class="formDelete">' +
        '<div class="form-group">' +
        '<input type="hidden" value="'+nombre+'" name="checkbox_delete[]"/>' +
        '<input type="hidden" value="'+$('#camino_actual').val()+'" name="ruta_delete"/>' +
        '</div>' +
        '</form>',
        buttons: {
            formSubmit: {
                text: 'Aceptar',
                btnClass: 'btn-danger',
                action: function () {
                    $.ajax({
                        url:  urlTo +'eliminar_archivo',
                        type: 'POST',
                        data: $('#formDelete').serialize(),
                        beforeSend: function(){
                            $('#here_fake').show();
                            $('#here_fake').fakeLoader({timeToHide:120000000,spinner:"spinner6"});
                        },
                        success: function (resp) {
                            if (resp == 'listo') {
                                location.reload();
                            }
                        }
                    });
                }
            },
            cancelar: {
                text: 'Cancelar',
                btnClass: 'btn-default'
            }
        }
    });
}

function extrac_to(nombre){
    $.ajax({
        url:  urlTo +'extraer_archivo',
        type: 'POST',
        data: {'nombre':nombre,'ruta':$('#camino_actual').val()},
        beforeSend: function(){
            $('#here_fake').show();
            $('#here_fake').fakeLoader({timeToHide:120000000,spinner:"spinner6"});
        },
        success: function (resp) {
            if (resp == 'listo') {
                location.reload();
            }
            else{
                $('#here_fake').hide();
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
                    content: resp,
                    buttons: {
                        ok: {
                            text: 'Aceptar',
                            btnClass: 'btn-default'
                        }
                    }
                });
            }
        }
    });
}
