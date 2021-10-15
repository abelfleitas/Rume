
<script type="text/javascript" src="<?=base_url();?>assets/js/jquery-2.1.3.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/js/jquery.mousewheel-3.0.6.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/js/jquery.prettyPhoto.js"></script>
<script type="text/javascript">
    $("a[rel^='prettyPhoto']").prettyPhoto({social_tools: false});
    $("a[rel^='prettyPhoto'] img").hover(function(){$(this).animate({opacity:0.7},300)},function(){$(this).animate({opacity:1},300)});
</script>
<script type="text/javascript">
    $(document).ready(function(){
        var alto = window.innerHeight-270;
        $('#contenido_real').css({'height':alto});

        var alto1 = window.innerHeight-100;
        $('#menu').css({'height':alto1});

        $("#contenido_real").mCustomScrollbar({
            theme:"3d-thick-dark",
            scrollButtons:{
                enable:true
            },
            advanced:{
                autoScrollOnFocus:false,
                UpdateOnContentResize: true
            }
        });
        $("#menu").mCustomScrollbar({
            theme:"3d-thick-dark",
            scrollButtons:{
                enable:true
            },
            advanced:{
                autoScrollOnFocus:false,
                UpdateOnContentResize: true
            }
        });
        <?php if(
                $this->uri->uri_string()=='user_guide/nueva_carpeta' ||
                $this->uri->uri_string()=='user_guide/subir_archivos' ||
                $this->uri->uri_string()=='user_guide/descargar_archivos' ||
                $this->uri->uri_string()=='user_guide/renombrar_archivos' ||
                $this->uri->uri_string()=='user_guide/eliminar_archivos'  ||
                $this->uri->uri_string()=='user_guide/comprimir_archivos' ||
                $this->uri->uri_string()=='user_guide/mover_archivos' ||
                $this->uri->uri_string()=='load/6' ||
                $this->uri->uri_string()=='load/7' ||
                $this->uri->uri_string()=='load/8' ||
                $this->uri->uri_string()=='load/9' ||
                $this->uri->uri_string()=='load/10' ||
                $this->uri->uri_string()=='load/11' ||
                $this->uri->uri_string()=='load/12') :?>
            $('.children').collapse({
                toggle: true
            });
            $(this).find('em:first').toggleClass("glyphicon-minus");
        <?php endif;?>
    });
    $(document).on("click","div>a.parent> span.icon", function(){
        $(this).find('em:first').toggleClass("glyphicon-minus");
    });
    $(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
</script>

</body>
</html>
