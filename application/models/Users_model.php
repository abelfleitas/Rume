<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model extends CI_Model {

    function  __construct(){
        parent::__construct();
        $this->load->database('default');
    }

    public function check_user($user,$pass){
        $this->db->where('usuario',$user);
        $this->db->where('password',$pass);
        $consulta = $this->db->get('usuarios');;
        $resultado = $consulta->row();
        return $resultado;
    }

    public function preferencia_vista($id){
        $q=$this->db->get_where('usuarios',array('id'=>$id));
        foreach ($q->result() as $d) {
            return $d->preferencia_vista;
        }
    }

    public function update_preferencia_vista($id,$valor)
    {
        $this->preferencia_vista = $valor;
        $this->db->update('usuarios', $this, array('id' => $id));
    }

    public function editar_datos_usuario($array,$id){
        $this->db->update('usuarios', $array, array('id' => $id));
    }

    public function change_password($array,$id){
        $this->db->update('usuarios', $array, array('id' => $id));
    }

    public function getUsers($id){
        $q = $this->db->get_where('usuarios',array('id <>' => $id));
        return $q->result();
    }

    public function getNameUsers($id){
        $q = $this->db->get_where('usuarios',array('id' => $id));
        $resultado = $q->row();
        return $resultado->usuario;
    }

    public function getEmailProfile(){
        $q = $this->db->get_where('usuarios',array('profile' => 'administrador'));
        $resultado = $q->row();
        return $resultado->email;
    }

    public function getNameProfile(){
        $q = $this->db->get_where('usuarios',array('profile' => 'administrador'));
        $resultado = $q->row();
        return $resultado->nombre;
    }

    public function delete_user($id){
        $this->db->delete('usuarios',array('id' => $id));
    }

    public function changePrivilegio($id,$valor){
        $this->privilegio = $valor;
        $this->db->update('usuarios', $this, array('id' => $id));
    }

    public function changeSort($id,$valor){
        $this->preferencia_ordenamiento = $valor;
        $this->db->update('usuarios', $this, array('id' => $id));
    }

    public function getFtp(){
        $consulta = $this->db->get('ftp');;
        $resultado = $consulta->row();
        return $resultado;
    }

    function updateFtp($array)
    {
        $this->db->update('ftp', $array, array('id' => 1));
    }

    function updateFtpNotificado($value)
    {
        $this->db->update('ftp',array('notificado'=>$value), array('id' => 1));
    }

    function updateEmail($array)
    {
        $this->db->update('correo', $array, array('id' => 1));
    }

    function updateSige($array)
    {
        $this->db->update('sige', $array, array('id' => 1));
    }

    public function getNombreByUsuario($mail){
        $q=$this->db->get_where('usuarios',array('email'=>$mail));
        $resultado = $q->row();
        return $resultado->nombre;
    }

    public function updateClave($cadena,$email){
        $this->db->set('password',md5($cadena));
        $this->db->where('email', $email);
        $this->db->update('usuarios');
    }

    public function existe_email($mail){
        $q=$this->db->get_where('usuarios',array('email'=>$mail));
        if($q->num_rows()>0)
        {
            return true;
        }
        else{
            return false;
        }
    }

    public function getMail(){
        $q = $this->db->get('correo');
        return $q->row();
    }

    public function getSige(){
        $q = $this->db->get('sige');
        return $q->row();
    }

    public function verificate_password($pass_act,$usuario){
        $this->db->where('usuario',$usuario);
        $this->db->where('password',$pass_act);
        $q=$this->db->get('usuarios');
        if($q->num_rows()>0){
            return TRUE;
        }else{
            return FALSE;
        }

    }

    public function valid_mail($id,$mail){
        $q = $this->db->get_where('usuarios',array('id <>' => $id));
        foreach($q->result() as $x){
            if($x->email == $mail)
                return FALSE;
        }
        return TRUE;
    }

}