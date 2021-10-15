<?php defined('BASEPATH') OR exit('No direct script access allowed');

class FTP extends SuperController {

    #variables FTP
    public $host;
    public $port;
    public $username;
    public $password;
    public $sistema;
    public $disk;
    public $notificado;
    public $particion;
    #variables Correo
    public $login;
    public $hostC;
    public $portC;
    public $userC;
    public $passC;
    #variables Sige
    public $hostSige;
    public $portSige;
    public $bdSige;
    public $userSige;
    public $passSige;
    #variables Dsico
    private $spaceUtilizado;
    private $spaceDisponible;
    public $pos;

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('url', 'form', 'html', 'number', 'file', 'path','directory','download'));
        $this->load->library(array('ftp', 'form_validation', 'session','zip','upload','table','typography','email'));
        $this->load->model('users_model');

        $datos = $this->users_model->getFtp();
        if ($datos) {
            $this->host = $datos->host;
            $this->port = $datos->port;
            $this->username = $datos->username;
            $this->password = base64_decode($datos->password);
            $this->sistema = $datos->sistema;
            $this->disk = $datos->disk;
            $this->notificado = $datos->notificado;
            $this->particion = $datos->particion;
        }

        $lineas = file("./assets/json/resultado.txt");
        if(count($lineas)>1){
            $pos=0;
            foreach($lineas as $ls){
                if(stristr($lineas[$pos],$this->particion)){
                    $html = explode("/",$lineas[$pos]);
                    $this->spaceDisponible = intval($html[4]);
                    $this->pos = $pos;
                }else{
                    $pos++;
                }
            }
            if($this->spaceDisponible  == ''){
                $this->spaceDisponible = 0;
            }
        }else{
            $this->spaceDisponible = 0;
        }
        $this->spaceUtilizado = 100 - $this->spaceDisponible;

        if($this->sistema == 1) {
            $config['hostname'] = $this->host;
            $config['port'] = $this->port;
            $config['username'] = $this->username;
            $config['password'] = $this->password;
            $config['debug'] = FALSE;
            if($this->ftp->connect($config) === FALSE)
            {
                $this->login = 0;
            }
            else{
                $this->login = 1;
            }
        }
        else{
            redirect('usuario/desabilitar');
        }

        $this->removeCache();
    }

	public function index(){

        $this->load->view('login');
	}

    public function verificar()
    {
        $this->form_validation->set_rules('usuario', 'usuario', 'required');
        $this->form_validation->set_rules('password', 'contrase&ntilde;a', 'required');

        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $this->form_validation->set_message('required', 'El campo %s es requerido');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('login');
        } else {
            $usuario = $this->users_model->check_user($this->input->post('usuario'), md5($this->input->post('password')));
            if($usuario) {
                $usuario_data = array(
                    'id' => $usuario->id,
                    'nombre' => $usuario->nombre,
                    'email' => $usuario->email,
                    'usuario' => $usuario->usuario,
                    'profile' => $usuario->profile,
                    'privilegio'=>$usuario->privilegio,
                    'sort' => $usuario->preferencia_ordenamiento,
                    'logueado' => TRUE
                );
                $this->session->set_userdata($usuario_data);
                redirect('home');
            }
            else
            {
                $msj = 'Los datos son incorrectos.';
                $this->session->set_flashdata('error', $msj);
                redirect('login');
            }
        }
    }

    public function cerrar_session()
    {
        if ($this->session->userdata('logueado')) {
            $usuario_data = array(
                'id' => "",
                'nombre' => "",
                'usuario'=> "",
                'logueado' => FALSE
            );
            $this->session->set_userdata($usuario_data);
            $this->session->sess_destroy();
            $this->removeCache();
            redirect('sesion_cerrada');
        } else {
            redirect('login');
        }
    }

    public function inicio()
    {
        if ($this->session->userdata('logueado'))
        {
            $data['host'] = $this->host;
            $data['port'] = $this->port;
            $data['username'] = $this->username;
            $data['password'] = base64_encode($this->password);
            $data['nombre'] = $this->session->userdata('nombre');
            $mail = $this->users_model->getMail();
            $this->hostC = $mail->host;
            $this->portC = $mail->port;
            $this->userC = $mail->user;
            $this->passC = $mail->pass;
            $sige = $this->users_model->getSige();
            $this->hostSige = $sige->host;
            $this->portSige = $sige->port;
            $this->bdSige = $sige->bd;
            $this->userSige = $sige->username;
            $this->passSige = $sige->password;

            if($this->spaceUtilizado >= 95 && $this->disk == 1 && $this->notificado == 0){
                $config['protocol'] = 'smtp';
                $config['smtp_host'] = $this->hostC;
                $config['smtp_port'] = $this->portC;
                $config['smtp_user'] = $this->userC;
                $config['smtp_pass'] = base64_decode($this->passC);
                $config['charset'] = 'utf-8';
                $config['mailtype'] = 'html';
                $config['wordwrap'] = TRUE;
                $config['validate'] = TRUE;
                $this->email->initialize($config);

                $email  = $this->users_model->getEmailProfile();
                $nombreAdmin  = $this->users_model->getNameProfile();
                $this->email->from($email,$nombreAdmin);
                $this->email->to($email);
                $this->email->subject('RUME-FTP');
                $this->email->message('Hola: '.$nombreAdmin.' Usted ha sido notificado porque el almacenamiento
                del FTP se encuentra al 98% de su capacidad.'.br(2));
                if($this->email->send()){};
                $this->users_model->updateFtpNotificado(1);
            }else if($this->spaceUtilizado < 95 && $this->notificado == 1){
                $this->users_model->updateFtpNotificado(0);
            }

            $data['freespace_mb'] = $this->spaceDisponible;
            $data['uitilizado']= $this->spaceUtilizado;
            $data['lineas'] = file("./assets/json/resultado.txt");

            $this->load->view('inicio', $data);
        }
        else {
            redirect('login');
        }
    }

    public function fragmento()
    {
        if ($this->session->userdata('logueado') && $this->login == 1 && $this->spaceUtilizado<100)
        {
            if ($this->users_model->preferencia_vista($this->session->userdata('id')) == "lista") {
                $data['active1'] = "active";
                $data['active2'] = "";
                $data['active3'] = "";

                $data['estado1'] = "in active";
                $data['estado2'] = "";
                $data['estado3'] = "";

            } else if ($this->users_model->preferencia_vista($this->session->userdata('id')) == "detalle") {
                $data['active1'] = "";
                $data['active2'] = "active";
                $data['active3'] = "";

                $data['estado1'] = "";
                $data['estado2'] = "in active";
                $data['estado3'] = "";
            } else {
                $data['active1'] = "";
                $data['active2'] = "";
                $data['active3'] = "active";

                $data['estado1'] = "";
                $data['estado2'] = "";
                $data['estado3'] = "in active";
            }

            $data['host'] = $this->host;
            $data['port'] = $this->port;
            $data['username'] = $this->username;
            $data['password'] = $this->password;
            if($this->session->userdata('profile') == 'administrador'||$this->session->userdata('privilegio')=='2'||$this->session->userdata('privilegio')=='3')
            {
                $this->createDir($this->session->userdata('usuario'));
                $data['map'] = $this->sort_by($this->session->userdata('sort'),$this->ftp->list_files('/'));
                $data['camino'] = "";
            }
            else{
                $this->createDir($this->session->userdata('usuario'));
                if(!in_array('/'.$this->session->userdata('usuario'),$this->ftp->list_files('/'))){
                    $this->createDirTrabajo($this->session->userdata('usuario'));
                    redirect('ftp/fragmento');
                }
                else{
                    $data['map'] = $this->sort_by($this->session->userdata('sort'),$this->ftp->list_files('/'.$this->session->userdata('usuario')));
                    $data['camino'] = '/'.$this->session->userdata('usuario');
                }
            }
            $array = array(
                'camino_actual' => $data['camino'],
            );
            $this->session->set_userdata($array);
            $this->load->view('fragmento', $data);
        }
        else if($this->session->userdata('logueado') && $this->login == 1 && $this->spaceUtilizado == 100){
            if($this->session->userdata('profile')=='administrador'){
                $data['msj1'] = 'El FTP se encuentra al 100% de su capacidad de almacenamiento';
                $data['msj2'] = '';
                $data['msj3'] = '<code>Revise la configuraci&oacute;n</code>';
            }else{
                $data['msj1'] = 'El FTP se encuentra al 100% de su capacidad de almacenamiento';
                $data['msj2'] = '<code>Consulte con su administrador</code>';
            }
            $this->load->view('error_ftp',$data);
        }
        else if($this->session->userdata('logueado') && $this->login != 1){
            if($this->session->userdata('profile')=='administrador'){
                $data['msj1'] = 'Se han encontrado errores en los datos de conexión';
                $data['msj2'] = 'No es posible establecer conexi&oacute;n con el FTP';
                $data['msj3'] = '<code>Revise la configuraci&oacute;n</code>';
            }else{
                $data['msj1'] = 'No es posible establecer conexi&oacute;n con el FTP';
                $data['msj2'] = '<code>Consulte con su administrador</code>';
            }
            $this->load->view('error_ftp',$data);
        }else if(!$this->session->userdata('logueado')){
            if($this->session->userdata('profile')=='administrador'){
                $data['msj1'] = 'Su sesi&oacute;n ha expirado';
                $data['msj2'] = 'Vuelva a iniciar sesi&oacute;n';
            }else{
                $data['msj1'] = 'Su sesi&oacute;n ha expirado';
                $data['msj2'] = 'Vuelva a iniciar sesi&oacute;n';
            }
            $this->load->view('error_ftp',$data);
        }
    }

    public function move_file()
    {
        if ($this->session->userdata('logueado'))
        {
            if($this->session->userdata('profile') == 'administrador'|| $this->session->userdata('privilegio')=='2'|| $this->session->userdata('privilegio')=='3')
            {
                $data['map'] = $this->ftp->list_files('/');
                $data['camino'] = "";
            }
            else{
                $data['map'] = $this->ftp->list_files('/'.$this->session->userdata('usuario'));
                $data['camino'] = '/'.$this->session->userdata('usuario');
            }
            file_put_contents('./assets/json/'.$this->session->userdata('usuario').'/ruta_forMove.json',json_encode($data['camino'],TRUE));
            $this->load->view('move_file', $data);
        }
        else
        {
            redirect('login');
        }
    }

    public function preferencia_vista()
    {
        if ($this->session->userdata('logueado')) {
            $this->users_model->update_preferencia_vista($this->session->userdata('id'), $this->input->post('valor'));
            echo 'ok';
        }
        else {
            redirect('login');
        }
    }

    public function entrarDir($folder)
    {
        if($this->input->request_headers())
        {
            if ($this->users_model->preferencia_vista($this->session->userdata('id')) == "lista") {
                $data['active1'] = "active";
                $data['active2'] = "";
                $data['active3'] = "";

                $data['estado1'] = "in active";
                $data['estado2'] = "";
                $data['estado3'] = "";

            } else if ($this->users_model->preferencia_vista($this->session->userdata('id')) == "detalle") {
                $data['active1'] = "";
                $data['active2'] = "active";
                $data['active3'] = "";

                $data['estado1'] = "";
                $data['estado2'] = "in active";
                $data['estado3'] = "";
            } else {
                $data['active1'] = "";
                $data['active2'] = "";
                $data['active3'] = "active";

                $data['estado1'] = "";
                $data['estado2'] = "";
                $data['estado3'] = "in active";
            }
            $data['host'] = $this->host;
            $data['port'] = $this->port;
            $data['username'] = $this->username;
            $data['password'] = $this->password;
            $data['map'] =  $this->sort_by($this->session->userdata('sort'),$this->ftp->list_files(base64_decode($folder)));
            $data['camino'] = base64_decode($folder);

            $array = array('camino_actual' => $data['camino']);
            $this->session->set_userdata($array);

            $this->load->view('fragmento', $data);
        }
        else{
            redirect(404);
        }
    }

    public function entrarDir1($folder)
    {
        $data['host'] = $this->host;
        $data['port'] = $this->port;
        $data['username'] = $this->username;
        $data['password'] = $this->password;
        $data['map'] = $this->ftp->list_files(base64_decode($folder));
        $data['camino'] = base64_decode($folder);
        file_put_contents('./assets/json/'.$this->session->userdata('usuario').'/ruta_forMove.json',json_encode($data['camino'],TRUE));
        $this->load->view('move_file', $data);
    }

    public function ruta_actual()
    {
        if ($this->session->userdata('logueado'))
        {
            if ($this->input->is_ajax_request())
            {
                echo $this->session->userdata('camino_actual');
            }
            else {
                redirect(404);
            }
        }
        else {
            redirect('login');
        }

    }

    public function crearDir()
    {
        if ($this->session->userdata('logueado'))
        {
            if ($this->input->is_ajax_request())
            {
                $this->form_validation->set_rules('name_folder', 'directorio ', 'required|alpha_numeric_spaces');
                $this->form_validation->set_error_delimiters('', '');
                $this->form_validation->set_message('required', 'El nombre del %s es requerido.');
                $this->form_validation->set_message('alpha_numeric_spaces', 'El campo solo puede contener caracteres alfa-num&eacute;ricos,guion bajo  y espacios.');
                if($this->form_validation->run() === FALSE)
                {
                    echo form_error('name_folder');
                }
                else{
                    $dir = set_realpath($this->input->post('camino_actual') . '/' . strtolower($this->input->post('name_folder')));
                    if(file_exists("ftp://".$this->username.":".$this->password."@".$this->host."/".$dir))
                    {

                        echo "Ya existe un directorio con el mismo nombre.";
                    }
                    else
                    {
                        $this->ftp->mkdir($dir,DIR_WRITE_MODE);
                        $this->ftp->close();
                        echo "fue creada";
                    }
                }
            }
            else
            {
                redirect(404);
            }
        }
        else
        {
            redirect('login');
        }
    }

    public function crearFile()
    {
        if ($this->session->userdata('logueado'))
        {
            if ($this->input->is_ajax_request())
            {

                $this->form_validation->set_rules('name_file', 'archivo', 'required|alpha_numeric');
                $this->form_validation->set_error_delimiters('', '');
                $this->form_validation->set_message('required', 'El nombre del %s es requerido.');
                $this->form_validation->set_message('alpha_numeric', 'El campo %s solo puede contener caracteres alpha-num&eacute;ricos.');
                if($this->form_validation->run() === FALSE)
                {
                    echo form_error('name_file');
                }
                else{
                    $nombre_file = strtolower($this->input->post('name_file'));
                    $lista = $this->ftp->list_files($this->input->post('camino_actual_file').'/');
                    if(!in_array($this->input->post('camino_actual_file').'/'.$nombre_file.'.txt',$lista))
                    {
                        if(!write_file('./usuarios/'.$this->session->userdata('usuario').'/'.$nombre_file.'.txt',""))
                        {
                            echo "no fue creada";
                        }
                        else
                        {
                            $this->ftp->mirror('./usuarios/'.$this->session->userdata('usuario').'/',$this->input->post('camino_actual_file').'/');
                            unlink('./usuarios/'.$this->session->userdata('usuario').'/'.$nombre_file.'.txt');
                            echo "fue creada";
                        }
                    }
                    else{
                        echo "Ya existe un archivo con el mismo nombre.";
                    }
                }
            }
            else
            {
                redirect(404);
            }
        }
        else
        {
            redirect('login');
        }
    }

    public function downloadZip()
    {
        if ($this->session->userdata('logueado'))
        {
            foreach($this->input->post('ficheros[]') as $x)
            {
                $this->ftp->download($this->input->post('ruta_download').'/'.$x,'./usuarios/'.$this->session->userdata('usuario').'/'.$x, 'auto');
                $this->zip->read_file('./usuarios/'.$this->session->userdata('usuario').'/'.$x);
            }
            $this->clearDir('./usuarios/'.$this->session->userdata('usuario').'/');
            $this->zip->download('my_backup.zip');
        }
        else{
            redirect('login');
        }
    }

    public function downloadFile($valor)
    {
        if ($this->session->userdata('logueado')){

            $ruta = base64_decode($valor);
            $slash=strrpos($ruta,'/');
            $x = substr($ruta,$slash+1);
            $this->ftp->download($ruta,'./usuarios/'.$this->session->userdata('usuario').'/'.$x, 'auto');
            $data = file_get_contents('./usuarios/'.$this->session->userdata('usuario').'/'.$x);
            $this->clearDir('./usuarios/'.$this->session->userdata('usuario').'/');
            if($data == ""){
                $texto = "<p></p>";
                force_download($x,"'");
            }
            else{
                force_download($x,$data);
            }
        }
        else{
            redirect('login');
        }
    }

    public function listar_archivos()
    {
        if ($this->session->userdata('logueado'))
        {
            if ($this->input->is_ajax_request())
            {
                $myA = new ArrayObject($this->sort_by($this->session->userdata('sort'),$this->ftp->list_files($this->input->post('ruta'))));
                $files = new ArrayObject();
                foreach($myA as $x){
                    if(get_mime_by_extension($x)==='text/plain'||get_mime_by_extension($x)==='application/xml'||
                        get_mime_by_extension($x)==='application/x-zip' || get_mime_by_extension($x) === 'application/x-rar'||
                        get_mime_by_extension($x)==='application/x-7z-compressed'||get_mime_by_extension($x)==='application/x-tar'||
                        get_mime_by_extension($x)==='application/x-gzip' || get_mime_by_extension($x)==='application/x-gtar')
                    {
                        $str = trim($x,'/');
                        $slash=strrpos($str,'/');
                        if($slash)
                        {
                            $files->append(substr($str,$slash+1));
                        }
                        else{
                            $files->append($str);
                        }
                    }
                }
                if($files->count()>0)
                {
                    file_put_contents('./assets/json/datos.json',json_encode($files,TRUE));
                    echo "listo";
                }
                else{
                    echo "no listo";
                }
            }
            else{
                redirect(404);
            }
        }
        else{
            redirect('login');
        }
    }

    public function listar_archivos_compress()
    {
        if ($this->session->userdata('logueado'))
        {
            if ($this->input->is_ajax_request())
            {
                $myA = new ArrayObject($this->sort_by($this->session->userdata('sort'),$this->ftp->list_files($this->input->post('ruta'))));
                $files = new ArrayObject();
                foreach($myA as $x){
                    if(get_mime_by_extension($x)==='text/plain'||get_mime_by_extension($x)==='application/xml')
                    {
                        $str = trim($x,'/');
                        $slash=strrpos($str,'/');
                        if($slash)
                        {
                            $files->append(substr($str,$slash+1));
                        }
                        else{
                            $files->append($str);
                        }
                    }
                }
                if($files->count()>0)
                {
                    file_put_contents('./assets/json/datos.json',json_encode($files,TRUE));
                    echo "listo";
                }
                else{
                    echo "no listo";
                }
            }
            else{
                redirect(404);
            }
        }
        else{
            redirect('login');
        }
    }

    public function listar_dir_archivos()
    {
        if ($this->session->userdata('logueado'))
        {
            if ($this->input->is_ajax_request())
            {
                $myA = new ArrayObject($this->sort_by($this->session->userdata('sort'),$this->ftp->list_files($this->input->post('ruta'))));
                $files = new ArrayObject();
                foreach($myA as $x){
                    $str = trim($x,'/');
                    $slash=strrpos($str,'/');
                    if($slash)
                    {
                        $files->append(substr($str,$slash+1));
                    }
                    else{
                        $files->append($str);
                    }
                }

                $i=0;
                $params = array();
                $aux = new ArrayObject();
                foreach($files as $x){
                    if(is_dir("ftp://".$this->username.":".$this->password."@".$this->host.":".$this->port."/".$x))
                    {

                        if(count($this->ftp->list_files($this->input->post('ruta').'/'.$x),0)>0)
                        {
                            $params[0] = $x;
                            $params[1] = TRUE;
                            $aux->append($params);
                        }
                        else{
                            $params[0] = $x;
                            $params[1] = FALSE;
                            $aux->append($params);
                        }
                    }
                    else{
                        $params[0] = $x;
                        $params[1] = NULL;
                        $aux->append($params);
                    }
                    $i++;
                }
                if($files->count()>0){
                    file_put_contents('./assets/json/datos.json',json_encode($aux,TRUE));
                    echo "listo";
                }
                else{
                    echo "no listo";
                }
            }
            else{
                redirect(404);
            }
        }
        else{
            redirect('login');
        }
    }

    public function listar_files_delete()
    {
        if ($this->session->userdata('logueado'))
        {
            if ($this->input->is_ajax_request())
            {
                $myA = new ArrayObject($this->sort_by($this->session->userdata('sort'),$this->ftp->list_files($this->input->post('ruta'))));
                $files = new ArrayObject();
                foreach($myA as $x){
                    if(is_dir("ftp://".$this->username.":".$this->password."@".$this->host.":".$this->port."/".$x))
                    {
                        $aux = new ArrayObject($this->ftp->list_files($x));
                        if($aux->count() == 0)
                        {
                            $str = trim($x,'/');
                            $slash=strrpos($str,'/');
                            if($slash)
                            {
                                $files->append(substr($str,$slash+1));
                            }
                            else{
                                $files->append($str);
                            }
                        }
                    }
                    else{
                        $str = trim($x,'/');
                        $slash=strrpos($str,'/');
                        if($slash)
                        {
                            $files->append(substr($str,$slash+1));
                        }
                        else{
                            $files->append($str);
                        }
                    }
                }
                if($files->count()>0){
                    file_put_contents('./assets/json/datos.json',json_encode($files,TRUE));
                    echo "listo";
                }
                else{
                    echo "no listo";
                }
            }
            else{
                redirect(404);
            }
        }
        else{
            redirect('login');
        }
    }

    public function deleteFiles(){

        if($this->session->userdata('logueado')){

            if($this->input->is_ajax_request()) {

                $data = new ArrayObject($this->input->post('checkbox_delete[]'));

                for($i=0;$i<$data->count();$i++)
                {
                    if(is_dir("ftp://".$this->username.":".$this->password."@".$this->host.":".$this->port."/".$data[$i]))
                    {
                        $aux = new ArrayObject($this->ftp->list_files($this->input->post('ruta_delete').'/'.$data[$i].'/'));
                        if($aux->count()>0)
                        {
                           $this->rmdir_recursive($this->input->post('ruta_delete').'/'.$data[$i]);
                        }
                        else{
                            $this->ftp->delete_dir($this->input->post('ruta_delete').'/'.$data[$i].'/');
                        }
                    }
                    else{
                        $this->ftp->delete_file($this->input->post('ruta_delete').'/'.$data[$i]);
                    }
                }
                echo "listo";
            }
            else{
                redirect(404);
            }
        }
        else{
            redirect('login');
        }
    }

    public function rmdir_recursive($dir){
        $files = new ArrayObject($this->ftp->list_files($dir));
        foreach($files as $file)
        {
            if(is_dir("ftp://".$this->username.":".$this->password."@".$this->host.":".$this->port."/".$file))
            {
                $this->rmdir_recursive($file);
            }
            else{
                $this->ftp->delete_file($file);
            }
        }
        $this->ftp->delete_dir($dir);
    }

    public function editarFiles(){

        if($this->session->userdata('logueado')){

            if($this->input->is_ajax_request())
            {
                $myNombres = new ArrayObject($this->input->post('inp[]'));
                $myNameActuales = new ArrayObject($this->input->post('name_old[]'));
                $myExt = new ArrayObject($this->input->post('ext[]'));

                if(in_array("",$myNombres->getArrayCopy()))
                {
                    echo "El campo nombre es requerido";
                }
                else{
                    $dir = $this->input->post('ruta_edit').'/';
                    for($i=0;$i<$myNombres->count();$i++)
                    {
                        $this->rename_files(strtolower($myNameActuales[$i]),strtolower($myNombres[$i]),$myExt[$i],$dir,0);
                    }
                    echo "listo";
                }
            }
            else{
                redirect(404);
            }
        }
        else
        {
            redirect('login');
        }
    }

    public function rename_files($nameOld,$nameNew,$ext,$ruta,$incr){
        $k=$incr;
        if($nameOld != $nameNew)
        {
            if($ext == "")
            {
                if(in_array($ruta.$nameNew,$this->ftp->list_files($ruta)))
                {
                    $name = str_replace('_'.($k-1),'',$nameNew).'_'.$k;
                    $nameAux = trim(basename(stripslashes($name)),".\x00..\x20");
                    $k = $k+1;
                    $this->rename_files($nameOld,$nameAux,$ext,$ruta,$k);
                }
                else
                {
                    $this->ftp->rename($ruta.$nameOld,$ruta.$nameNew);
                }
            }
            else{
                if(in_array($ruta.$nameNew.'.'.$ext,$this->ftp->list_files($ruta)))
                {
                    $name = str_replace('_'.($k-1),'',$nameNew).'_'.$k;
                    $nameAux = trim(basename(stripslashes($name)),".\x00..\x20");
                    $k = $k+1;
                    $this->rename_files($nameOld,$nameAux,$ext,$ruta,$k);
                }
                else
                {
                    $this->ftp->rename($ruta.$nameOld.'.'.$ext,$ruta.$nameNew.'.'.$ext);
                }
            }
        }
    }

    public function renameFilesAndmove($nameOld,$nameNew,$ext,$ruta,$rutad,$incr){
        $k=$incr;
        if(in_array($rutad.$nameNew.'.'.$ext,$this->ftp->list_files($rutad)))
        {
            $name = str_replace('_'.($k-1),'',$nameNew).'_'.$k;
            $nameAux = trim(basename(stripslashes($name)),".\x00..\x20");
            $k = $k+1;
            $this->renameFilesAndmove($nameOld,$nameAux,$ext,$ruta,$rutad,$k);
        }
        else
        {
            $this->ftp->rename($ruta.$nameOld.'.'.$ext,$ruta.$nameNew.'.'.$ext);
            $this->ftp->move($ruta.$nameNew.'.'.$ext,$rutad.$nameNew.'.'.$ext);
        }
    }

    public function moverFiles(){
        if($this->session->userdata('logueado')){

            if($this->input->is_ajax_request()){
                $ruta_actual = $this->input->post('ruta_move').'/';
                $ruta_destino = $this->input->post('ruta_destino').'/';

                $myArr = new ArrayObject($this->input->post('name_move[]'));
                $names = new ArrayObject($this->input->post('nombre[]'));
                $ext = new ArrayObject($this->input->post('ext[]'));
                if($ruta_actual == $ruta_destino)
                {
                    echo "La carpeta de origen y la carpeta de destino es la misma.";
                }
                else{
                    for($i=0;$i<$myArr->count();$i++) {
                        if(in_array($ruta_destino.$myArr[$i],$this->ftp->list_files($ruta_destino)))
                        {
                            $this->renameFilesAndmove($names[$i],$names[$i],$ext[$i],$ruta_actual,$ruta_destino,0);
                        }
                        else{
                            $this->ftp->move($ruta_actual.$myArr[$i],$ruta_destino.$myArr[$i]);
                        }
                    }
                    file_put_contents('./assets/json/'.$this->session->userdata('usuario').'/ruta_forMove.json',json_encode('',TRUE));
                    echo "listo";
                }
            }
            else{
                redirect(404);
            }
        }
        else
        {
            redirect('login');
        }
    }

    public function clearDir($path){
        delete_files($path, TRUE);
    }

    public function renameFilesZip($nameOld,$nameNew,$ext,$ruta,$incr){
        $k=$incr;
        if(in_array($ruta.$nameNew.'.'.$ext,$this->ftp->list_files($ruta)))
        {
            $name = str_replace('_'.($k-1),'',$nameNew).'_'.$k;
            $nameAux = trim(basename(stripslashes($name)),".\x00..\x20");
            $k = $k+1;
            $this->renameFilesZip($nameOld,$nameAux,$ext,$ruta,$k);
        }
        else{
            $this->ftp->rename($ruta.$nameOld.'.'.$ext,$ruta.$nameNew.'.'.$ext);
        }
    }

    public function compressFiles(){
        $myArr = new ArrayObject($this->input->post('compress[]'));
        $ruta = $this->input->post('ruta_compress').'/';
        $path = './usuarios/'.$this->session->userdata('usuario').'/';
        foreach($myArr as $name)
        {
            $this->ftp->download($ruta.$name,$path.$name, 'auto');
        }
        $map = directory_map('./usuarios/'.$this->session->userdata('usuario').'/', 1);
        $zip = new ZipArchive();
        if($zip->open('./usuarios/'.$this->session->userdata('usuario').'/'.'comprimido.zip',ZipArchive::CREATE) === TRUE)
        {
            foreach($map as $file)
            {
                $zip->addFile('./usuarios/'.$this->session->userdata('usuario').'/'.$file,$file);
            }
            $zip->close();
        }
        if(in_array($ruta.'comprimido.zip',$this->ftp->list_files($ruta)))
        {
            $nom = 'comprimido';
            $this->renameFilesZip($nom,'comprimido','zip',$ruta,0);
        }
        $this->ftp->mirror($path,$ruta);
        $this->clearDir($path);
        echo "listo";
    }

    public function renameExtracto($nameOld,$nameNew,$ruta,$incr){
        $k=$incr;
        if(in_array($ruta.$nameNew,$this->ftp->list_files($ruta)))
        {
            $name = str_replace('_'.($k-1),'',$nameNew).'_'.$k;
            $nameAux = trim(basename(stripslashes($name)),".\x00..\x20");
            $k = $k+1;
            $this->renameExtracto($nameOld,$nameAux,$ruta,$k);
        }
        else{
            rename($nameOld,'./usuarios/'.$this->session->userdata('usuario').'/'.$nameNew);
        }
    }

    public function renameExtractoArchive($nameOld,$nameNew,$ruta,$ext,$incr){
        $k=$incr;
        if(in_array($ruta.$nameNew.$ext,$this->ftp->list_files($ruta)))
        {
            $name = str_replace('_'.($k-1),'',$nameNew).'_'.$k;
            $nameAux = trim(basename(stripslashes($name)),".\x00..\x20");
            $k = $k+1;
            $this->renameExtractoArchive($nameOld,$nameAux,$ruta,$ext,$k);
        }
        else{
            rename('./usuarios/'.$this->session->userdata('usuario').'/'.$nameOld.$ext,'./usuarios/'.$this->session->userdata('usuario').'/'.$nameNew.$ext);
        }
    }

    public function changeOrdenamiento($sort)
    {
        if($this->session->userdata('logueado'))
        {
            if ($this->input->is_ajax_request()) {
                $this->users_model->changeSort($this->session->userdata('id'), $sort);
                $this->session->set_userdata('sort',$sort);
                echo "listo";
            }else{
                redirect(404);
            }
        }
        else
        {
            redirect('login');
        }
    }

    public function do_upload()
    {
        if ($this->session->userdata('logueado'))
        {
            $path = './usuarios/'.$this->session->userdata('usuario').'/';
            $config['upload_path'] = $path;
            $config['allowed_types'] = 'xml|rar|gz|tar|zip|7z|7zip|gzip|gtar';
            $config['max_size'] = 50000000;
            $config['overrite'] = FALSE;
            $config['remove_spaces'] = FALSE;
            $config['file_ext_tolower']= TRUE;
            $config['detect_mime']=TRUE;

            $this->upload->initialize($config);
            $ruta = $this->input->post('pathdoupload').'/';

            if (!empty($_FILES['file']['name']))
            {
                $filesCount = count($_FILES['file']['name']);
                for ($i = 0; $i < $filesCount; $i++) {
                    $_FILES['uploadFile']['name'] = str_replace(",","_",$_FILES['file']['name'][$i]);
                    $_FILES['uploadFile']['type'] = $_FILES['file']['type'][$i];
                    $_FILES['uploadFile']['tmp_name'] = $_FILES['file']['tmp_name'][$i];
                    $_FILES['uploadFile']['error'] = $_FILES['file']['error'][$i];
                    $_FILES['uploadFile']['size'] = $_FILES['file']['size'][$i];
                    if ($this->upload->do_upload('uploadFile')) {
                        $fileData = $this->upload->data();
                        $nombre = $fileData["raw_name"];
                        $ext = $fileData["file_ext"];
                        $p = explode('.',$ext);
                        $ext = $p[1];
                        $archivo = $ruta.$nombre.'.'.$ext;
                        if(in_array($archivo,$this->ftp->list_files($ruta))) {
                            $nom = base64_encode($nombre);
                            rename($path.$fileData['file_name'],$path.$nom.$fileData["file_ext"]);
                            $this->ftp->mirror($path,$ruta);
                            $this->clearDir($path);
                            $this->renameFilesZip($nom,$nombre,$ext,$ruta,0);
                        }
                        else{
                            $this->ftp->mirror($path,$ruta);
                            $this->clearDir($path);
                        }
                    }
                }
                $this->clearDir($path);
            }
        }
        else{
            redirect('login');
        }
    }

    public function actualizar_ftp(){

        if($this->input->is_ajax_request()) {
            $disk = '';
            if($this->input->post('disk') == ''){
                $disk = '0';
            }else{
                $disk = $this->input->post('disk');
            }

            $ftpArray = array();
            $datos = $this->users_model->getFtp();
            if($datos->password != $this->input->post('password'))
            {
                $ftpArray = array(
                    'host'=>$this->input->post('host'),
                    'port'=>$this->input->post('port'),
                    'username'=>$this->input->post('username'),
                    'password'=>base64_encode($this->input->post('password')),
                    'sistema'=>$this->input->post('optionsRadios[]'),
                    'disk' => $disk,
                    'particion' => $this->input->post('particion'),
                );
            }
            else{
                $ftpArray = array(
                    'host'=>$this->input->post('host'),
                    'port'=>$this->input->post('port'),
                    'username'=>$this->input->post('username'),
                    'sistema'=>$this->input->post('optionsRadios[]'),
                    'disk' => $disk,
                    'particion' => $this->input->post('particion'),
                );
            }

            $mailArray = array();
            $mail = $this->users_model->getMail();
            if($mail->pass != $this->input->post('passwordc')){
                $mailArray  = array(
                    'host'=>$this->input->post('hostc'),
                    'port'=>$this->input->post('portc'),
                    'user'=>$this->input->post('usernamec'),
                    'pass'=>base64_encode($this->input->post('passwordc')),
                );
            }
            else{
                $mailArray  = array(
                    'host'=>$this->input->post('hostc'),
                    'port'=>$this->input->post('portc'),
                    'user'=>$this->input->post('usernamec'),
                );
            }

            $sigeArray = array();
            $sige = $this->users_model->getSige();
            if($sige->password != $this->input->post('passwordsige')){
                $sigeArray  = array(
                    'host'=>$this->input->post('hostsige'),
                    'port'=>$this->input->post('portsige'),
                    'bd'=>$this->input->post('bdsige'),
                    'username'=>$this->input->post('usernamesige'),
                    'password'=>base64_encode($this->input->post('passwordsige')),
                );
            }
            else{
                $sigeArray  = array(
                    'host'=>$this->input->post('hostsige'),
                    'port'=>$this->input->post('portsige'),
                    'bd'=>$this->input->post('bdsige'),
                    'username'=>$this->input->post('usernamesige'),
                );
            }

            $this->db->trans_start();
            $this->users_model->updateFtp($ftpArray);
            $this->users_model->updateEmail($mailArray);
            $this->users_model->updateSige($sigeArray);
            $this->db->trans_complete();

            $fichero = fopen('./assets/json/equipo.txt','w');
            fwrite($fichero,$this->input->post('host'));
            fclose($fichero);

            $resultado = realpath('./assets/json/resultado.txt');
            $equipo = realpath('./assets/json/equipo.txt');

            $data = 'Option Explicit
        const strReport = "'.$resultado.'"
        const sFile = "'.$equipo.'"

        Dim objWMIService, objItem, colItems
        Dim strDriveType, strDiskSize, txt

        Dim oFSO, oFile, sText,strComputer
        Set oFSO = CreateObject("Scripting.FileSystemObject")

        Dim objFSO,objTextFile
        Set objFSO = createobject("Scripting.FileSystemObject")
        Set objTextFile = objFSO.CreateTextFile(strReport)

        If oFSO.FileExists(sFile) Then
            Set oFile = oFSO.OpenTextFile(sFile, 1)
            Do While Not oFile.AtEndOfStream
                sText = oFile.ReadLine
                If Trim(sText) <> "" Then
                    strComputer=sText
                        Set objWMIService = GetObject("winmgmts://" & strComputer & "\root\cimv2")
                        Set colItems = objWMIService.ExecQuery("Select * from Win32_LogicalDisk WHERE DriveType=3")

                    For Each objItem in colItems
                        DIM pctFreeSpace,strFreeSpace,strusedSpace
                        pctFreeSpace = INT((objItem.FreeSpace / objItem.Size) * 1000)/10
                        pctFreeSpace = INT(pctFreeSpace)

                        strDiskSize = Int(objItem.Size /1073741824) & "Gb"
                        strFreeSpace = Int(objItem.FreeSpace /1073741824) & "Gb"
                        strUsedSpace = Int((objItem.Size-objItem.FreeSpace)/1073741824) & "Gb"
                        txt = txt &  objItem.Name & "/" & strDiskSize & "/" & strUsedSpace & "/" & strFreeSpace & "/" & pctFreeSpace & vbcrlf
                    Next
                    objTextFile.Write(txt)
                End If
            Loop
            objTextFile.Close
            oFile.Close
        Else
            WScript.Echo "No se encuentra el archivo."
        End If';

            write_file('./assets/json/disk.vbs', $data);

            $obj = new COM("WScript.Shell");
            if(is_object($obj)){
                $obj->Run('wscript.exe '.realpath('./assets/json/disk.vbs'),0,TRUE);
            }
            $obj= NULL;

            echo "listo";
        }else{
            redirect(404);
        }
    }

    public function saveFile(){

        if ($this->session->userdata('logueado'))
        {
            if($this->input->is_ajax_request()) {

                $path = './usuarios/'.$this->session->userdata('usuario').'/';
                $slash=strrpos($this->input->post('rutaarchivo'),'/');
                $file = substr($this->input->post('rutaarchivo'),$slash+1);
                $this->ftp->download($this->input->post('rutaarchivo'),$path.$file, 'auto');
                $fichero = fopen($path.$file,'w');
                fwrite($fichero,$this->input->post('contenido'));
                fclose($fichero);
                $ruta = '';
                if($this->input->post('ruta_actual') == '')
                {
                    $ruta= '/';
                }
                else{
                    $ruta = $this->input->post('ruta_actual').'/';
                }
                $this->ftp->mirror($path,$ruta);
                $this->clearDir($path);
                echo "El archivo fue guardado";
            }else{
                redirect(404);
            }

        }
    }

    public function sort_by($type,$array){
        switch($type){
            case 'alpha1':
                sort($array,3);
                break;
            case 'alpha2':
                rsort($array,3);
                break;
            case 'tipo1':
                $array = $this->sortType($array);
                break;
            case 'tipo2':
                $array = $this->rsortType($array);
                 break;
            case 'size1':
                $array = $this->sizeFileMenor($array);
                break;
            case 'size2':
                $array = $this->sizeFileMayor($array);
                break;
        }
        return $array;
    }

    public function sortType($array){
        $myAux = new ArrayObject();
        foreach($array as $item)
        {
            if(is_dir("ftp://".$this->username.":".$this->password."@".$this->host.":".$this->port."/".$item))
            {
                $myAux->append($item);
            }
        }
        foreach($array as $item)
        {
            if(!is_dir("ftp://".$this->username.":".$this->password."@".$this->host.":".$this->port."/".$item) && get_mime_by_extension($item) == "text/plain")
            {
                $myAux->append($item);
            }
        }
        foreach($array as $item)
        {
            if(!is_dir("ftp://".$this->username.":".$this->password."@".$this->host.":".$this->port."/".$item) && get_mime_by_extension($item) != "text/plain" && get_mime_by_extension($item) == "application/xml")
            {
                $myAux->append($item);
            }
        }
        foreach($array as $item)
        {
            if(!is_dir("ftp://".$this->username.":".$this->password."@".$this->host.":".$this->port."/".$item) && get_mime_by_extension($item) != "text/plain" && get_mime_by_extension($item) != "application/xml")
            {
                $myAux->append($item);
            }
        }
        return $myAux->getArrayCopy();
    }

    public function rsortType($array){
        $myAux = new ArrayObject();
        foreach($array as $item)
        {
            if(!is_dir("ftp://".$this->username.":".$this->password."@".$this->host.":".$this->port."/".$item) && get_mime_by_extension($item) != "text/plain" && get_mime_by_extension($item) != "application/xml")
            {
                $myAux->append($item);
            }
        }
        foreach($array as $item)
        {
            if(!is_dir("ftp://".$this->username.":".$this->password."@".$this->host.":".$this->port."/".$item)  && get_mime_by_extension($item) != "text/plain" && get_mime_by_extension($item) == "application/xml")
            {
                $myAux->append($item);
            }
        }
        foreach($array as $item)
        {
            if(!is_dir("ftp://".$this->username.":".$this->password."@".$this->host.":".$this->port."/".$item) && get_mime_by_extension($item) == "text/plain")
            {
                $myAux->append($item);
            }
        }
        foreach($array as $item)
        {
            if(is_dir("ftp://".$this->username.":".$this->password."@".$this->host.":".$this->port."/".$item))
            {
                $myAux->append($item);
            }
        }
        return $myAux->getArrayCopy();
    }

    public function sizeFileMenor($array){
        $myAux = new ArrayObject($array);
        $arr= new ArrayObject();
        for($i=0;$i<$myAux->count();$i++)
        {
            $arr->append(filesize("ftp://".$this->username.":".$this->password."@".$this->host.":".$this->port."/".$myAux[$i]));
        }
        for($i=1;$i<$arr->count();$i++)
        {
            for($j=0;$j<$arr->count()-$i;$j++)
            {
                if($arr[$j] > $arr[$j+1])
                {
                    $aux = $arr[$j+1];
                    $aux1 = $myAux[$j+1];
                    $arr[$j+1] = $arr[$j];
                    $myAux[$j+1] = $myAux[$j];
                    $arr[$j] = $aux;
                    $myAux[$j] = $aux1;
                }
            }
        }
        return $myAux->getArrayCopy();
    }

    public function sizeFileMayor($array){
        $myarr = $array;
        $myAux = new ArrayObject($myarr);
        $arr= new ArrayObject();
        for($i=0;$i<$myAux->count();$i++)
        {
            $arr->append(filesize("ftp://".$this->username.":".$this->password."@".$this->host.":".$this->port."/".$myAux[$i]));
        }
        for($i=1;$i<$arr->count();$i++)
        {
            for($j=0;$j<$arr->count()-$i;$j++)
            {
                if($arr[$j] < $arr[$j+1])
                {
                    $aux = $arr[$j+1];
                    $aux1 = $myAux[$j+1];
                    $arr[$j+1] = $arr[$j];
                    $myAux[$j+1] = $myAux[$j];
                    $arr[$j] = $aux;
                    $myAux[$j] = $aux1;
                }
            }
        }
        return $myAux->getArrayCopy();
    }

    public function searchFile($ruta)
    {
        if ($this->input->is_ajax_request())
        {
            $resultados = new ArrayObject();
            $cadena = $this->input->post('cadena_busqueda');
            $ruta = base64_decode($ruta);
            $myArr = new ArrayObject($this->ftp->list_files($ruta));
            if($myArr->count()>0){
                for($i=0;$i<$myArr->count();$i++)
                {
                    $slash=strrpos($myArr[$i],'/');
                    $archivo = substr($myArr[$i],$slash+1);
                    if(is_dir("ftp://".$this->username.":".$this->password."@".$this->host.":".$this->port."/".$myArr[$i]))
                    {
                        if(strlen(stristr($archivo,$cadena))>0) {

                            $araray = array(
                                'nombre' => $archivo,
                                'ruta' => $ruta,
                            );

                            $resultados->append($araray);
                        }
                        $this->metodo_recursivo($myArr[$i],$cadena,$resultados);
                    }
                    else{
                        if(strlen(stristr($archivo,$cadena))>0) {
                            $araray = array(
                                'nombre' => $archivo,
                                'ruta' => $ruta,
                            );
                            $resultados->append($araray);
                        }
                    }
                }
                if($resultados->count()>0)
                {
                    file_put_contents('./assets/json/'.$this->session->userdata('usuario').'/busqueda.json',json_encode($resultados));
                    echo "listo";
                }
                else{
                    $resp = '"'.$cadena.'"';
                    echo "La búsqueda no arrojo ningún resultado para <strong id='resultadado_search'>".$resp."</strong>.";
                }
            }
            else{
                echo "Este directorio no contiene archivos para buscar.";
            }
        }else{
           redirect(404);
        }
    }

    public function metodo_recursivo($dir,$cadena,$resultado){
        $res = $resultado;
        $files = new ArrayObject($this->ftp->list_files($dir));
        foreach($files as $file)
        {
            $slash=strrpos($file,'/');
            $archivo = substr($file,$slash+1);
            if(!is_dir("ftp://".$this->username.":".$this->password."@".$this->host.":".$this->port."/".$file))
            {
                if(strlen(stristr($archivo,$cadena))>0)
                {
                    $araray= array(
                        'nombre'=> $archivo,
                        'ruta'=> $dir,
                    );
                    $res->append($araray);
                }
            }
            else{
                if(strlen(stristr($archivo,$cadena))>0)
                {
                    $araray= array(
                        'nombre'=> $archivo,
                        'ruta'=> $dir,
                    );
                    $res->append($araray);
                    $this->metodo_recursivo($file,$cadena,$res);
                }
                else{
                    $this->metodo_recursivo($file,$cadena,$res);
                }
            }
        }
    }

    public function loadSearch($ruta,$cadena){
        $json = file_get_contents('./assets/json/'.$this->session->userdata('usuario').'/busqueda.json');
        $total = new ArrayObject(json_decode($json));
        $data['ruta']=$ruta;
        $data['cadena'] = $cadena;
        $data['cant']= $total->count();
        $data['datos']= $json;
        $this->load->view('buscar',$data);
    }

    public function registro()
    {
        if($this->input->is_ajax_request())
        {
            $this->form_validation->set_rules('nombre', 'Nombre y Apellidos', 'required|name_people');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[usuarios.email]');
            $this->form_validation->set_rules('user', 'Usuario', 'required|alpha_numeric|is_unique[usuarios.usuario]|min_length[5]|max_length[16]');
            $this->form_validation->set_rules('contra', 'Contrase&ntilde;a', 'required|min_length[5]|max_length[16]');
            $this->form_validation->set_rules('contrac', 'Confirmar Contrase&ntilde;a', 'required|matches[contra]');
            $this->form_validation->set_rules('rol', 'Rol', 'required');

            $this->form_validation->set_error_delimiters('<p>', '</p>');

            $this->form_validation->set_message('required', 'El campo %s es requerido.');
            $this->form_validation->set_message('name_people', 'El campo %s no contiene un valor válido.');
            $this->form_validation->set_message('valid_email', 'El campo %s no contiene un valor válido.');
            $this->form_validation->set_message('is_unique', 'El campo %s contiene un valor que ya existe.');
            $this->form_validation->set_message('alpha_numeric', 'El campo %s solo puede contener caracteres alfanuméricos.');
            $this->form_validation->set_message('min_length', 'El mínimo de caracteres para el campo %s es %d.');
            $this->form_validation->set_message('max_length', 'El máximo de caracteres para el campo %s es %d.');
            $this->form_validation->set_message('matches', 'El campo %s no coincide con el campo %s.');


            if($this->form_validation->run() == FALSE)
            {
                echo validation_errors();
            }
            else {
                $arrA = array(
                    'nombre' =>$this->input->post('nombre'),
                    'email' =>$this->input->post('email'),
                    'usuario' =>$this->input->post('user'),
                    'password' => md5($this->input->post('contra')),
                    'profile' => 'usuario',
                    'privilegio' => $this->input->post('rol'),
                    'preferencia_vista' => 'detalle',
                    'preferencia_ordenamiento' => 'alpha1'
                );
                $this->db->insert('usuarios',$arrA);
                $this->createDir($this->input->post('user'));
                if($this->input->post('rol') == '1')
                {
                    $this->createDirTrabajo($this->input->post('user'));
                }
                echo "listo";
            }
        }
        else{
            redirect(404);
        }

    }

    public function createDir($name){
        if(!file_exists('./usuarios/'.$name) ) {
            mkdir('./usuarios/'.$name,DIR_WRITE_MODE);
            mkdir('./assets/json/'.$name,DIR_WRITE_MODE);
        }
    }

    public function createDirTrabajo($name){
        $dir = set_realpath('/'.strtolower($name));
        if(!file_exists("ftp://".$this->username.":".$this->password."@".$this->host.":".$this->port."/".$dir)){
            $this->ftp->mkdir($dir, DIR_WRITE_MODE);
        }
    }

    public function error404(){
        if ($this->session->userdata('logueado')) {
            $data['nombre'] = $this->session->userdata('nombre');
            $this->load->view('error_404',$data);
        }
        else{
            redirect('login');
        }
    }

    public function save_change($parm)
    {
        if($this->session->userdata('logueado'))
        {
            if ($this->input->is_ajax_request())
            {
                $path = './usuarios/' . $this->session->userdata('usuario') . '/';
                $ruta = base64_decode($parm, TRUE);
                $slash = strrpos($ruta, '/');
                $file = substr($ruta, $slash + 1);
                $rutaA = substr($ruta,0,$slash+1);
                $this->ftp->download($ruta,$path.$file, 'auto');

                $xml = new SimpleXMLElement($path.$file,0,true);
                foreach(json_decode($this->input->post('datos'),TRUE) as $x)
                {
                    $xml->encabezado->idnummodelo = $x['Modelo'];
                    $xml->encabezado->idsubnummodelo = $x['Submodelo'];
                    $xml->encabezado->idcodvariante = $x['Variante'];
                    $xml->encabezado->codcentroinformante = $x['Centro Informante'];
                    $xml->encabezado->idfechadelinformeacumulado = $x['Fecha del informe acumulado'];
                    $xml->encabezado->idfechadeconfeccion = $x['Fecha de confecci&oacute;n'];
                    $xml->encabezado->estado = $x['Estado'];
                    $xml->encabezado->observaciones = $x['Oservaciones'];
                    $xml->encabezado->idtipodemodelo = $x['Tipo de modelo'];
                }
                $xml->saveXML($path.$file);
                $this->ftp->mirror($path,$rutaA);
                $this->clearDir($path);
                echo "listo";
            }
            else
            {
                redirect(404);
            }
        }
        else
        {
            echo "cession cerrada";
        }
    }

    public function openFile($parm)
    {
        if($this->session->userdata('logueado')) {
            $path = './usuarios/'.$this->session->userdata('usuario').'/';
            $ruta = base64_decode($parm,TRUE);
            $slash=strrpos($ruta,'/');
            $file = substr($ruta,$slash+1);
            $this->ftp->download($ruta,$path.$file, 'auto');
            if(get_mime_by_extension($file) === 'text/plain')
            {
                $texto = file_get_contents($path.$file);
                $string = $this->typography->auto_typography($texto);
                $this->clearDir($path);
                echo  $string;
            }
            else{
                $xmlFile = file_get_contents($path.$file);
                libxml_use_internal_errors(true);
                $data['xml'] = simplexml_load_string($xmlFile);
                if($data['xml'] === FALSE)
                {
                    $data['titulo']= $file;
                    $data['ruta']= $ruta;
                    $data['error']="El archivo no es valido";
                    $this->load->view('abrir_xml_error',$data);
                    $this->clearDir($path);
                }
                else{
                    $data['ruta'] = $ruta;
                    $data['titulo']= $file;
                    $data['ruta']= $ruta;
                    $this->clearDir($path);
                    $this->load->view('abrir_xml',$data);
                }
            }
        }else{
            redirect('login');
        }
    }

    public function extraerFiles(){
        $nomb = $this->input->post('nombre');
        $ruta = $this->input->post('ruta').'/';
        $this->ftp->download($ruta.$nomb,'./usuarios/'.$this->session->userdata('usuario').'/'.$nomb, 'auto');
        $archive = './usuarios/'.$this->session->userdata('usuario').'/'.$nomb;
        $ext = pathinfo($archive,PATHINFO_EXTENSION);
        $res = '';
        switch($ext){
            case 'zip':
                if(!class_exists("ZipArchive")){
                    $res = "Esta versi&oacute;n de php no soporta la extraci&oacute;n de archivos .".$ext;
                }
                else{
                    $zip = new ZipArchive;
                    if($zip->open($archive,ZipArchive::CREATE) === TRUE) {
                        $zip->extractTo('./usuarios/'.$this->session->userdata('usuario').'/');
                        $zip->close();
                    }
                    $res = "listo";
                }
                break;
            default:
                $res = "Solo se puede descomprimir archivos .zip";
                break;
        }
        if(file_exists($archive))
        {
            unlink($archive);
            $map = directory_map('./usuarios/'.$this->session->userdata('usuario').'/', 1);
            foreach($map as $file){
                if(is_dir('./usuarios/'.$this->session->userdata('usuario').'/'.$file)){
                    $aux = substr($file,0,strlen($file)-1);
                    if(in_array($ruta.$aux,$this->ftp->list_files($ruta))){
                        $this->renameExtracto('./usuarios/'.$this->session->userdata('usuario').'/'.$aux,$aux,$ruta,0);
                    }
                }
                else{
                    $aux = substr($file,0,strrpos($file,'.'));
                    if(in_array($ruta.$file,$this->ftp->list_files($ruta))){
                        $ext_f = '.'.pathinfo($file,PATHINFO_EXTENSION);
                        $this->renameExtractoArchive($aux,$aux,$ruta,$ext_f,0);
                    }
                }
            }
            $this->ftp->mirror('./usuarios/'.$this->session->userdata('usuario').'/',$ruta);
            $this->clearDir('./usuarios/'.$this->session->userdata('usuario').'/');
        }
        echo $res;
    }

}
