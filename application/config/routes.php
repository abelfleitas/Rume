<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'ftp';
$route['sesion_cerrada'] = 'ftp';
$route['login'] = 'ftp/verificar';
$route['home'] = 'ftp/inicio';
$route['fragmento']= 'ftp/fragmento';
$route['directorio/(:any)'] = 'ftp/entrarDir/$1';
$route['indirectorio/(:any)'] = 'ftp/entrarDir1/$1';
$route['update_ftp'] = 'ftp/actualizar_ftp';
$route['preferencia_vista']='ftp/preferencia_vista';
$route['cerrar_sesion']='ftp/cerrar_session';
$route['nueva_carpeta'] = 'ftp/crearDir';
$route['nuevo_archivo'] = 'ftp/crearFile';
$route['camino_actual'] = 'ftp/ruta_actual';
$route['bajar_archivo_zip']= 'ftp/downloadZip';
$route['recargar']= 'ftp/refresh';
$route['listar_archivos']= 'ftp/listar_archivos';
$route['listar_dir_archivos']= 'ftp/listar_dir_archivos';
$route['listar_files_delete']= 'ftp/listar_files_delete';
$route['listar_archivos_compress']= 'ftp/listar_archivos_compress';
$route['subir_archivo']= 'ftp/do_upload';
$route['editar_archivo']= 'ftp/editarFiles';
$route['eliminar_archivo']= 'ftp/deleteFiles';
$route['load_move']= 'ftp/move_file';
$route['mover_archivos']= 'ftp/moverFiles';
$route['comprimir_archivos']= 'ftp/compressFiles';
$route['sort/(:any)']= 'ftp/changeOrdenamiento/$1';
$route['buscar/(:any)']= 'ftp/searchFile/$1';
$route['buscar_archivo/(:any)/(:any)']= 'ftp/loadSearch/$1/$2';
$route['open/(:any)']= 'ftp/openFile/$1';
$route['guardarFile']= 'ftp/saveFile';
$route['descargarFile/(:any)']= 'ftp/downloadFile/$1';
$route['extraer_archivo']= 'ftp/extraerFiles';
$route['registrarse']='ftp/registro';
$route['guardar_cambios/(:any)']='ftp/save_change/$1';

$route['mis_datos']= 'usuario/mis_datos';
$route['editar_datos']= 'usuario/editar_datos';
$route['cambiar_contrasena']= 'usuario/cambiarPass';
$route['chequear_contrasena']= 'usuario/chequear_contrasena';
$route['ver_usuario']='usuario/ver_usuario';
$route['eliminar_usuario']='usuario/eliminar_usuario';
$route['cambiar_privilegio']='usuario/cambiar_privilegio';
$route['recuperar']='usuario/recuperar';
$route['habilitar']='usuario/habilitar';

$route['user_guide']='guia';
$route['user_guide/(:any)']='guia/loadpage/$1';
$route['load/(:num)'] = 'guia/pagination/$1';

$route['404_override'] = 'ftp/error404';
$route['translate_uri_dashes'] = FALSE;
