<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Usuario extends SuperController
{
    public $conexion;

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('url', 'form', 'html','file'));
        $this->load->library(array('ftp', 'form_validation', 'session','email'));
        $this->load->model('users_model');
        $this->removeCache();

        $datos = $this->users_model->getFtp();
        if ($datos) {
            $config['hostname'] = $datos->host;
            $config['port'] = $datos->port;
            $config['username'] = $datos->username;
            $config['password'] = base64_decode($datos->password);
            $this->conexion = $this->ftp->connect($config);
        }

    }

    public function mis_datos()
    {
        if ($this->session->userdata('logueado'))
        {
            $data['nombre'] = $this->session->userdata('nombre');
            $data['email'] = $this->session->userdata('email');
            $data['usuario'] = $this->session->userdata('usuario');
            $data['perfil'] = $this->session->userdata('profile');
            $this->load->view('editar_perfil',$data);
        }
        else{
            redirect('login');
        }
    }

    public function editar_datos()
    {
        if ($this->session->userdata('logueado'))
        {
            if ($this->input->is_ajax_request())
            {
                $this->form_validation->set_rules('editname', 'Nombre', 'required|name_people');
                $this->form_validation->set_rules('editemail', 'Email', 'required|valid_email');
                $this->form_validation->set_rules('editusuario', 'Usuario', 'required|alpha_numeric|min_length[5]|max_length[16]');
                $this->form_validation->set_message('required', 'El campo %s es requerido.');
                $this->form_validation->set_message('name_people', 'El campo %s no contiene un nombre v&aacute;lido.');
                $this->form_validation->set_message('valid_email', 'El campo %s no posee una direcci&oacute;n de correo v&aacute;lida.');
                $this->form_validation->set_message('alpha_numeric', 'El campo %s solo puede contener caracteres alpha-num&eacute;ricos.');
                $this->form_validation->set_message('min_length', 'El m&iacute;nimo de caracteres para el campo %s es %d.');
                $this->form_validation->set_message('max_length', 'El m&aacute;ximo de caracteres para el campo %s es %d.');
                if ($this->form_validation->run() == FALSE)
                {
                    $data= array(
                        '1'=>form_error('editname'),
                        '2'=>form_error('editemail'),
                        '3'=>form_error('editusuario')
                    );
                    echo json_encode($data);
                }
                else
                {
                    if($this->users_model->valid_mail($this->session->userdata('id'),$this->input->post('editemail'))){

                        if($this->session->userdata('usuario') != $this->input->post('editusuario'))
                        {
                            rename('./usuarios/'.$this->session->userdata('usuario'),'./usuarios/'.$this->input->post('editusuario'));
                            rename('./assets/json/'.$this->session->userdata('usuario'),'./assets/json/'.$this->input->post('editusuario'));

                            if($this->session->userdata('privilegio')=='1') {
                                $this->ftp->rename('/'.$this->session->userdata('usuario'),'/'.$this->input->post('editusuario'));
                            }
                        }
                        $data=array(
                            'nombre' => $this->input->post('editname'),
                            'email' => $this->input->post('editemail'),
                            'usuario' => $this->input->post('editusuario')
                        );
                        $this->users_model->editar_datos_usuario($data,$this->session->userdata('id'));
                        $usuario_data = array(
                            'id' => $this->session->userdata('id'),
                            'nombre' => $this->input->post('editname'),
                            'email' => $this->input->post('editemail'),
                            'usuario' =>$this->input->post('editusuario'),
                            'profile' => $this->session->userdata('profile'),
                            'logueado' => $this->session->userdata('logueado')
                        );
                        $this->session->set_userdata($usuario_data);
                        echo "listo";
                    }
                    else{
                        $data= array(
                            '2'=>"<p>El campo Email contiene un valor que ya existe</p>",
                        );
                        echo json_encode($data);
                    }
                }
            }
            else
            {
                redirect(404);
            }
        }
        else{
            redirect('login');
        }
    }

    public function cambiarPass()
    {
        if ($this->session->userdata('logueado'))
        {
            $data['nombre'] = $this->session->userdata('nombre');
            $this->load->view('cambiar_password',$data);
        }
        else
        {
            redirect('login');
        }

    }

    public function chequear_contrasena(){
        if ($this->session->userdata('logueado'))
        {
            if ($this->input->is_ajax_request())
            {
                $this->form_validation->set_rules('pass_ac', 'Contrase&ntilde;a Actual', 'callback_verificate_pass');
                $this->form_validation->set_rules('new_pass', 'Nueva Contrase&ntilde;a', 'required|min_length[5]|max_length[16]');
                $this->form_validation->set_rules('c_new_pass', 'Confirmar Contrase&ntilde;a', 'required|matches[new_pass]');

                $this->form_validation->set_message('required', 'El campo %s es requerido.');
                $this->form_validation->set_message('min_length', 'El m&iacute;nimo de caracteres para el campo %s es %d.');
                $this->form_validation->set_message('max_length', 'El m&aacute;ximo de caracteres para el campo %s es %d.');
                $this->form_validation->set_message('matches', 'El campo %s no coincide con el campo %s.');

                if ($this->form_validation->run() == FALSE)
                {
                    $data= array(
                        '1'=>form_error('pass_ac'),
                        '2'=>form_error('new_pass'),
                        '3'=>form_error('c_new_pass'),
                    );
                    echo json_encode($data);
                }
                else
                {
                    $data=array(
                        'password' => md5($this->input->post('new_pass')),
                    );
                    $this->users_model->change_password($data,$this->session->userdata('id'));
                    echo "listo";
                }
            }
            else
            {
                redirect(404);
            }
        }
        else{
            redirect('login');
        }
    }

    function verificate_pass($str) {
        if($str == '')
        {
            $this->form_validation->set_message('verificate_pass', 'El campo %s es requerido.');
            return FALSE;
        }
        else{
            if(!$this->users_model->verificate_password(md5($str),$this->session->userdata('usuario')))
            {
                $this->form_validation->set_message('verificate_pass','EL campo %s es incorrecto');
                return FALSE;
            }
            else {
                return TRUE;
            }
        }

    }

    public function ver_usuario()
    {
        if ($this->session->userdata('logueado'))
        {
            $data['nombre'] = $this->session->userdata('nombre');
            $data['datos'] = $this->users_model->getUsers($this->session->userdata('id'));
            $this->load->view('usuarios',$data);
        }
        else{
            redirect('login');
        }
    }

    public function eliminar_usuario()
    {
        if ($this->session->userdata('logueado'))
        {
            if ($this->input->is_ajax_request())
            {
                if($this->input->post('id_usuario') != "")
                {
                    $folder = $this->users_model->getNameUsers($this->input->post('id_usuario'));
                    $this->users_model->delete_user($this->input->post('id_usuario'));
                    if(file_exists('./usuarios/'.$folder)){
                        delete_files('./assets/json/'.$folder,TRUE);
                        rmdir('./usuarios/'.$folder);
                        echo "listo";
                    }else{
                        echo "listo";
                    }
                }
                else{
                    echo "no se pudo eliminar al usuario";
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

    public function cambiar_privilegio()
    {
        if ($this->session->userdata('logueado'))
        {
            if ($this->input->is_ajax_request())
            {
                if($this->input->post('id_usuario_p') != "")
                {

                    if($this->input->post('privilegio')==1){
                        $dir = '/'.strtolower($this->users_model->getNameUsers($this->input->post('id_usuario_p')));
                        $this->ftp->mkdir($dir, DIR_WRITE_MODE);
                    }
                    $this->users_model->changePrivilegio($this->input->post('id_usuario_p'),$this->input->post('privilegio'));
                    echo "listo";
                }
                else{
                    echo "la acción no fue realizada";
                }
            }
            else
            {
                redirect('login');
            }
        }
        else
        {
            redirect('login');
        }
    }

    public function recuperar()
    {
        if ($this->input->is_ajax_request()){
            $this->form_validation->set_rules('emailr', 'Email', 'required|valid_email');

            $this->form_validation->set_error_delimiters('<p>', '</p>');

            $this->form_validation->set_message('required', 'El campo %s es requerido.');
            $this->form_validation->set_message('valid_email', 'El campo %s no contiene un valor válido.');
            if($this->form_validation->run() == FALSE)
            {
                echo validation_errors();
            }
            else{
                if($this->users_model->existe_email($this->input->post('emailr')))
                {
                    $mail = $this->users_model->getMail();
                    $config['protocol'] = 'smtp';
                    $config['smtp_host'] = $mail->host;
                    $config['smtp_port'] = $mail->port;
                    $config['smtp_user'] = $mail->user;
                    $config['smtp_pass'] = base64_decode($mail->pass);
                    $config['charset'] = 'utf-8';
                    $config['mailtype'] = 'html';
                    $config['wordwrap'] = TRUE;
                    $config['validate'] = TRUE;
                    $this->email->initialize($config);

                    $cadena = $this->generarAleatorio(8);
                    $email  = $this->users_model->getEmailProfile();
                    $nombreAdmin  = $this->users_model->getNameProfile();
                    $this->email->from($email,$nombreAdmin);
                    $this->email->to($this->input->post('emailr'));
                    $this->email->subject('RUME-FTP');
                    $people = $this->users_model->getNombreByUsuario($this->input->post('emailr'));
                    $this->email->message('Hola:'.$people.br(2).'Su contrase&ntilde;a ha sido reiniciada,
                    para iniciar sesi&oacute;n utilize la siguiente contrase&ntilde;a:'.'<strong>'.$cadena.'</strong>'.br(2));
                    if($this->email->send()){

                      $this->users_model->updateClave($cadena,$this->input->post('emailr'));
                      echo "listo";

                    }else{
                        echo "En estos momentos no se pudo establecer la conexi&oacute;n con el servidor de correo,
                        vuelva a intentarlo m&aacute;s tarde o consulte con su administrador.";
                    }
                }
                else{
                    echo "El email enviado no se encuentra registrado.";
                }

            }
        }
        else{
            redirect('login');
        }
    }

    public function generarAleatorio($longitud)
    {
        $key = '';
        $pattern = '1234567890abcdefghijklmnopqrstuxuzw';
        $max = strlen($pattern)-1;
        for($i=0;$i<$longitud;$i++)
        {
            $key.=$pattern{mt_rand(0,$max)};
        }
        return $key;
    }

    public function desabilitar()
    {
        $q=$this->users_model->getFtp();
        if($q->sistema ==  0)
        {
            $usuario_data = array(
                'id' => "",
                'nombre' => "",
                'usuario'=> "",
                'logueado' => FALSE
            );
            $this->session->set_userdata($usuario_data);
            $this->session->sess_destroy();
            $this->removeCache();
            $this->load->view('desabilitado');
        }
        else{
            if ($this->session->userdata('logueado')){
                redirect(404);
            }else{
                redirect('login');
            }
        }
    }

    public function habilitar()
    {
        if($this->input->is_ajax_request()){
            $this->form_validation->set_rules('username', 'Usuario', 'required');
            $this->form_validation->set_rules('password', 'Contrase&ntilde;a', 'required');
            $this->form_validation->set_message('required', 'El campo %s es requerido.');
            $this->form_validation->set_error_delimiters('<p>', '</p>');
            if ($this->form_validation->run() == FALSE)
            {
                echo validation_errors();
            }
            else
            {
                $usuario = $this->users_model->check_user($this->input->post('username'), md5($this->input->post('password')));
                if($usuario) {
                    if($usuario->profile == 'administrador') {
                        $this->db->update('ftp',array('sistema'=>1));
                        echo "listo";
                    }
                    else {
                        $msj = 'Los datos son incorrectos.';
                        echo $msj;
                    }
                }
                else {
                    $msj = 'Los datos son incorrectos.';
                    echo $msj;
                }
            }
        }
        else{
            redirect(404);
        }
    }

}
