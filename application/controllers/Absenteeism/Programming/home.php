
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Home extends CI_Controller {
 
 public function __construct()
 {
 parent::__construct();
 $this->load->helper('mysql_to_excel_helper');
 }
 
 public function programacion() {
 $this->load->model('usuarios');
 to_excel($this->usuarios->get(), "Programacion");
 }
 
 public function Ausentismo() {
 $this->load->model('usuarios');
 to_excel($this->usuarios->Ausentismo(), "Ausentismo");
 }
 
}