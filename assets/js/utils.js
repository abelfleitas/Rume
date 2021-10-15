$('#edicion').on('click',function(){
    if($(this).is(':checked'))
    {
        $('#host').removeAttr('disabled');
        $('#port').removeAttr('disabled');
        $('#username').removeAttr('disabled');
        $('#password').removeAttr('disabled');
        $('#hostc').removeAttr('disabled');
        $('#portc').removeAttr('disabled');
        $('#usernamec').removeAttr('disabled');
        $('#passwordc').removeAttr('disabled');
        $('#hostsige').removeAttr('disabled');
        $('#portsige').removeAttr('disabled');
        $('#bdsige').removeAttr('disabled');
        $('#usernamesige').removeAttr('disabled');
        $('#passwordsige').removeAttr('disabled');
        $('#habilitar').removeAttr('disabled');
        $('#desabilitar').removeAttr('disabled');
        $('#disk').removeAttr('disabled');
        $('#particion').removeAttr('disabled');
        $('#submit_update').removeAttr('disabled');
    }
    else
    {
        $('#host').prop('disabled','disabled');
        $('#port').prop('disabled','disabled');
        $('#username').prop('disabled','disabled');
        $('#password').prop('disabled','disabled');
        $('#hostc').prop('disabled','disabled');
        $('#portc').prop('disabled','disabled');
        $('#usernamec').prop('disabled','disabled');
        $('#passwordc').prop('disabled','disabled');
        $('#hostsige').prop('disabled','disabled');
        $('#portsige').prop('disabled','disabled');
        $('#bdsige').prop('disabled','disabled');
        $('#usernamesige').prop('disabled','disabled');
        $('#passwordsige').prop('disabled','disabled');
        $('#habilitar').prop('disabled','disabled');
        $('#desabilitar').prop('disabled','disabled');
        $('#disk').prop('disabled','disabled');
        $('#particion').prop('disabled','disabled');
        $('#submit_update').prop('disabled','disabled');
    }
});











