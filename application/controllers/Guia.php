<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Guia extends CI_Controller
{

    public function __construct(){
        parent::__construct();
        $this->load->helper(array('url', 'form', 'html'));
    }

    public function index(){
        $this->load->view('help/header');
        $this->load->view('help/index');
        $this->load->view('help/footer');
    }

    public function loadpage($page){
        $this->load->view('help/header');
        $this->load->view('help/'.$page);
        $this->load->view('help/footer');
    }

    public function pagination($num){
        switch($num){
            case '1':
                $page = 'index';
                break;
            case '2':
                $page = 'registrarse';
                break;
            case '3':
                $page = 'recuperar_contrasena';
                break;
            case '4':
                $page = 'editar_mis_datos';
                break;
            case '5':
                $page = 'cambiar_contrasena';
                break;
            case '6':
                $page = 'nueva_carpeta';
                break;
            case '7':
                $page = 'subir_archivos';
                break;
            case '8':
                $page = 'descargar_archivos';
                break;
            case '9':
                $page = 'renombrar_archivos';
                break;
            case '10':
                $page = 'eliminar_archivos';
                break;
            case '11':
                $page = 'comprimir_archivos';
                break;
            case '12':
                $page = 'mover_archivos';
                break;
            case '13':
                $page = 'edicion_de_modelos';
                break;
        }
        $this->load->view('help/header');
        $this->load->view('help/'.$page);
        $this->load->view('help/footer');
    }






}
