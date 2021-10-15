function getFileExtension(filename){
    return filename.slice((filename.lastIndexOf(".")-1 >>> 0)+2);
}

function getFileName(filename){
    return filename.slice("",(filename.lastIndexOf(".")));
}

$('#editar_name').on('click',function(){
    $('#editar_name').prop('disabled','disabled');
    var base_url = $('#ruta_url').val();
    $.ajax({
        url: base_url+'listar_dir_archivos',
        type: 'POST',
        data: 'ruta='+ $('#camino_actual').val(),
        beforeSend: function(){
            $('#here_fake').show();
            $('#here_fake').fakeLoader({timeToHide:120000000,spinner:"spinner6"});
        },
        success: function(resp){
            if(resp == 'listo')
            {
                $('#modal_bodyEdit').append('<div id="contenedor-archivos">' +
                '<div id="error_c4">'+
                '</div>' +
                '</div>');
                $.getJSON(base_url+'assets/json/datos.json',function(data){
                    for(var clave in data)
                    {
                        if(getFileExtension(data[clave][0]) == 'txt')
                        {
                            $('#contenedor-archivos').append(
                                '<div class="checkbox">'+
                                    '<label>'+
                                        '<input onchange="prueba(this.id)" type="checkbox" id="'+clave+'">'+
                                        '<img id="img_edicion_name" width="40" height="40" src="'+base_url+'assets/img/text.PNG">'+
                                    '</label>'+
                                    '<input disabled id="text_'+clave+'" type="text" class="form-control name_real" value="'+getFileName(data[clave][0])+'" name="inp[]"  style="width: 80%" placeholder="escriba un nombre">'+
                                '</div>'+
                                '<input disabled  type="hidden" value="'+getFileName(data[clave][0])+'" id="text1_'+clave+'" name="name_old[]">'+
                                '<input disabled type="hidden" value="'+getFileExtension(data[clave][0])+'" class="ext" name="ext[]" id="text2_'+clave+'">');
                        }
                        else if(getFileExtension(data[clave][0]) == 'text')
                        {
                            $('#contenedor-archivos').append(
                                '<div class="checkbox">'+
                                    '<label>'+
                                        '<input onchange="prueba(this.id)"  type="checkbox" id="'+clave+'">'+
                                        '<img id="img_edicion_name" width="40" height="40" src="'+base_url+'assets/img/text.PNG">'+
                                    '</label>'+
                                    '<input disabled id="text_'+clave+'" type="text" class="form-control name_real" value="'+getFileName(data[clave][0])+'" name="inp[]" style="width: 80%" placeholder="escriba un nombre">'+
                                '</div>'+
                                '<input disabled type="hidden" value="'+getFileName(data[clave][0])+'" id="text1_'+clave+'" name="name_old[]">'+
                                '<input disabled type="hidden" value="'+getFileExtension(data[clave][0])+'" class="ext" name="ext[]" id="text2_'+clave+'">');
                        }
                        else if(getFileExtension(data[clave][0]) == 'xml'){
                            $('#contenedor-archivos').append(
                                '<div class="checkbox">'+
                                '<label>'+
                                    '<input onchange="prueba(this.id)" type="checkbox" id="'+clave+'">'+
                                    '<img id="img_edicion_name" width="40" height="40" src="'+base_url+'assets/img/xml.PNG">'+
                                    '</label>'+
                                    '<input disabled id="text_'+clave+'" type="text" class="form-control name_real" value="'+getFileName(data[clave][0])+'" name="inp[]" style="width: 80%" placeholder="escriba un nombre">'+
                                '</div>'+
                                '<input disabled type="hidden" value="'+getFileName(data[clave][0])+'" id="text1_'+clave+'" name="name_old[]">'+
                                '<input disabled type="hidden" value="'+getFileExtension(data[clave][0])+'" class="ext" name="ext[]" id="text2_'+clave+'">');
                        }
                        else if(
                            getFileExtension(data[clave][0]) == 'rar' ||
                            getFileExtension(data[clave][0]) == 'tar' ||
                            getFileExtension(data[clave][0]) == 'zip' ||
                            getFileExtension(data[clave][0]) == '7z'  ||
                            getFileExtension(data[clave][0]) == '7zip'||
                            getFileExtension(data[clave][0]) == 'gz'  ||
                            getFileExtension(data[clave][0]) == 'gzip'||
                            getFileExtension(data[clave][0]) == 'gtar'){
                            $('#contenedor-archivos').append(
                                '<div class="checkbox">'+
                                    '<label>'+
                                        '<input onchange="prueba(this.id)"  type="checkbox" id="'+clave+'">'+
                                        '<img id="img_edicion_name" width="40" height="40" src="'+base_url+'assets/img/carpeta_cerrada.PNG">'+
                                    '</label>'+
                                    '<input disabled id="text_'+clave+'" type="text" class="form-control name_real" value="'+getFileName(data[clave][0])+'" name="inp[]" style="width: 80%" placeholder="escriba un nombre">'+
                                '</div>'+
                                '<input disabled type="hidden" value="'+getFileName(data[clave][0])+'" id="text1_'+clave+'" name="name_old[]">'+
                                '<input disabled type="hidden" value="'+getFileExtension(data[clave][0])+'" class="ext" name="ext[]" id="text2_'+clave+'">');
                        }
                        else{
                            if(data[clave][1]==false)
                            {
                                $('#contenedor-archivos').append(
                                    '<div class="checkbox">'+
                                        '<label>'+
                                            '<input onchange="prueba(this.id)" type="checkbox" id="'+clave+'">'+
                                            '<img id="img_edicion_name" width="40" height="40" src="'+base_url+'assets/img/carpeta_vacia.PNG">'+
                                        '</label>'+
                                        '<input disabled id="text_'+clave+'" type="text" class="form-control name_real"  value="'+data[clave][0]+'" name="inp[]" style="width: 80%" placeholder="escriba un nombre">'+
                                    '</div>'+
                                    '<input disabled type="hidden" value="'+data[clave][0]+'" id="text1_'+clave+'" name="name_old[]">'+
                                    '<input disabled  type="hidden" value="" class="ext" name="ext[]" id="text2_'+clave+'">');
                            }
                            else{
                                $('#contenedor-archivos').append(
                                    '<div class="checkbox">'+
                                        '<label>'+
                                            '<input onchange="prueba(this.id)" type="checkbox" id="'+clave+'">'+
                                            '<img id="img_edicion_name" width="40" height="40" src="'+base_url+'assets/img/carpeta_llena.PNG">'+
                                        '</label>'+
                                        '<input disabled id="text_'+clave+'" type="text" class="form-control name_real"  value="'+data[clave][0]+'" name="inp[]" style="width: 80%" placeholder="escriba un nombre">'+
                                    '</div>'+
                                    '<input  disabled type="hidden" value="'+data[clave][0]+'" id="text1_'+clave+'" name="name_old[]">'+
                                    '<input  disabled type="hidden" value="" class="ext" name="ext[]" id="text2_'+clave+'">');
                            }
                        }
                    }
                });
                $('#myModalEdit').modal('show');
                $('#editar_name').removeAttr('disabled');

            }
            else{
                $.alert({
                    boxWidth: '35%',
                    useBootstrap: false,
                    icon: 'glyphicon glyphicon-warning-sign',
                    type: 'orange',
                    theme: 'dark',
                    title: 'Alerta',
                    closeIcon: true,
                    animation: 'zoom',
                    closeAnimation: 'scale',
                    animationSpeed: 200,
                    animationBounce: 2.5,
                    content: 'Este directorio no contiene archivos para renombrar.',
                    buttons: {
                        ok: {
                            text: 'Aceptar',
                            btnClass: 'btn-default'
                        }
                    }
                });
                $('#editar_name').removeAttr('disabled');
            }
        },
        complete: function(){
            $('#here_fake').hide();
        }
    });
});

$('#myModalEdit').on('hidden.bs.modal', function () {
    $('#contenedor-archivos').children('div').remove();
    $('#contenedor-archivos').remove();
    $('#all2').prop('checked','');
    $('#buton_editar_archivos').removeAttr('disabled');
    $('div#error_c4').children('div.alert').remove();
});


$('#buton_editar_archivos').on('click',function(){
    $('#buton_editar_archivos').prop('disabled','disabled');
    hideValidate();
    var cont =0;
    var input = $('input[type="checkbox"]');
    var names = $('.name_real');
    var extensions = $('.ext');
    for(var i=0; i<input.length; i++)
    {
        if($(input[i]).attr('type') == 'checkbox')
        {
            if($(input[i]).is(':checked')) {
                cont++;
            }
        }
    }
    if(cont == 0){
        showValidate("Selecione algún archvo y edite su nombre.");
    }
    else{
        var temp = 0;
        for(var i=0; i<names.length; i++)
        {
            if($(names[i]).val() == ""){
                temp++;
                showValidate("El campo número "+(i+1)+" no puede estar vacío.");
            }
            else if(!$(names[i]).is(':disabled'))
            {
                var re = /^[a-zA-Z0-9]*$/;
                var re1 = /^[a-zA-Z0-9()_-]*$/;
                var reg = /^([a-zA-Z0-9_]+[\s]*)+$/;

                if($(extensions[i]).val() == 'txt' ||
                    $(extensions[i]).val() == 'rar' ||
                    $(extensions[i]).val() == 'tar' ||
                    $(extensions[i]).val() == 'gtar' ||
                    $(extensions[i]).val() == 'zip' ||
                    $(extensions[i]).val() == '7z' ||
                    $(extensions[i]).val() == '7zip' ||
                    $(extensions[i]).val() == 'gz' ||
                    $(extensions[i]).val() == 'gzip'){
                    if(re.test($(names[i]).val()) == false){
                        temp++;
                        showValidate("El campo número "+(i+1)+" solo puede aceptar caracteres de tipo alfanuméricos.");
                    }
                }
                if($(extensions[i]).val() == ''){
                    if(reg.test($(names[i]).val()) == false){
                        temp++;
                        showValidate("El campo número "+(i+1)+" solo puede aceptar caracteres de tipo alfanuméricos, guion bajo y espacios.");
                    }
                }
                if($(extensions[i]).val() == 'xml'){
                    if(re1.test($(names[i]).val()) == false){
                        temp++;
                        showValidate("El campo número "+(i+1)+" solo puede aceptar caracteres de tipo alfanuméricos, paréntesis, guion y guion bajo.");
                    }
                }
            }
        }
        if(temp == 0){
            hideValidate();
            execute();
        }
    }

    function execute(){
        var base_url = $('#ruta_url').val();
        $.ajax({
            url:  base_url+'editar_archivo',
            type: 'POST',
            data: $('#form_edit').serialize(),
            beforeSend: function(){
                $('#myModalEdit').modal('hide');
                $('#here_fake').show();
                $('#here_fake').fakeLoader({timeToHide:120000000,spinner:"spinner6"});
            },
            success: function(resp){
                if(resp == "listo"){
                    location.reload();
                }
                else{
                    $('#here_fake').hide();
                    showValidate(resp);
                }
            }
        });
    }
    function showValidate(msj) {
        $("#contenedor-archivos").mCustomScrollbar("disable",true);
        $('#error_c4').append('<div class="alert alert-warning alert-dismissable">'+
        '<button type="button" class="close" onclick="cerrado2()" data-dismiss="alert" aria-hidden="true">&times;</button>'+
        '<strong><i class="glyphicon glyphicon-warning-sign"></i>&nbsp;</strong>'+msj+
        '</div>');
        $('#buton_editar_archivos').removeAttr('disabled');
    }

    function hideValidate() {
        $('div#error_c4').children('div.alert').remove();
        $("#contenedor-archivos").mCustomScrollbar("update");
    }


});

$('#myModalEdit').on('hide.bs.modal', function () {
    $("#contenedor-archivos").mCustomScrollbar("destroy");
});

$('#myModalEdit').on('shown.bs.modal', function () {
    $("#contenedor-archivos").mCustomScrollbar({
        theme:"3d-thick-dark",
        scrollButtons:{
            enable:true
        },
        advanced:{
            autoScrollOnFocus:false,
            UpdateOnContentResize: true
        }
    });

    var base_url = $('#ruta_url').val();
    $('input[type="text"]').on('keyup',function(){
        $('div#error_c4').children('div.alert').remove();
        $("#contenedor-archivos").mCustomScrollbar("update");
    });

    $('#all2').on('change',function(){
        if($('#all2').is(':checked'))
        {
            $('div#error_c4').children('div.alert').remove();
            $("#contenedor-archivos").mCustomScrollbar("update");
            $('#contenedor-archivos').children('div').children('div').children('div.checkbox').children('label').children('input').prop('checked','checked');
            $('#contenedor-archivos').children('div').children('div').children('div.checkbox').children('input[type="text"]').removeAttr('disabled');
            $('#contenedor-archivos').children('div').children('div').children('input[type="hidden"]').removeAttr('disabled');
        }
        else{
            $('#contenedor-archivos').children('div').children('div').children('div.checkbox').children('label').children('input').prop('checked','');
            $('#contenedor-archivos').children('div').children('div').children('div.checkbox').children('input[type="text"]').prop('disabled','disabled');
            $('#contenedor-archivos').children('div').children('div').children('input[type="hidden"]').prop('disabled','disabled');
        }
    });

    $('#contenedor-archivos').children('div').children('div').children('div.checkbox').children('label').children('input').on('change',function(){
        if($('#contenedor-archivos').children('div').children('div').children('div.checkbox').children('label').children('input').is(':checked'))
        {
            $('#all2').prop('checked','');
            $('div#error_c4').children('div.alert').remove();
            $("#contenedor-archivos").mCustomScrollbar("update");
        }
    });


});

function prueba(response){
    $('#'+response).on('change',function(){
        if($('#'+response).is(':checked'))
        {
            $('#text_'+response).removeAttr('disabled');
            $('#text1_'+response).removeAttr('disabled');
            $('#text2_'+response).removeAttr('disabled');
            $('div#error_c4').children('div.alert').remove();
            $("#contenedor-archivos").mCustomScrollbar("update");
        }
        else{
            $('#text_'+response).prop('disabled','disabled');
            $('#text1_'+response).prop('disabled','disabled');
            $('#text2_'+response).prop('disabled','disabled');
            $('div#error_c4').children('div.alert').remove();
            $("#contenedor-archivos").mCustomScrollbar("update");
        }
    });
}

function cerrado2(){
    $("#contenedor-archivos").mCustomScrollbar("update");
}