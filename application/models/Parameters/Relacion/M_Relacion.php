<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Relacion extends VS_Model {

    public function __construct() {
        parent::__construct();
        
        foreach ($_POST as $clave => $valor):
            $this->$clave = $valor;
        endforeach;
    }
    
    public function List_Rol_Menu(){
        $consulta = ("SELECT sys_roles_menu.id_roles_menu,sys_roles.id_roles, sys_roles.description, sys_roles.status,"
                . " sys_status.description as status_desc, sys_menu.title FROM sys_roles_menu INNER JOIN sys_roles INNER JOIN sys_menu "
                . "INNER JOIN sys_status WHERE sys_roles.status = sys_status.id_status AND sys_roles_menu.id_roles = sys_roles.id_roles "
                . "AND sys_roles_menu.id_menu = sys_menu.id_menu ORDER by sys_roles_menu.id_roles_menu");
        $result = $this->db->query($consulta);
        return $result->result();
    }
    
    public function show(){
        $consulta = ("SHOW DATABASES");
        $result = $this->db->query($consulta);
        return $result->result();
    }
    
    public function List_Menu(){
        $consulta = ("SELECT * FROM sys_menu");
        $result = $this->db->query($consulta);
        return $result->result();
    }
    
    public function List_Rol(){
        $consulta = ("SELECT * FROM sys_roles");
        $result = $this->db->query($consulta);
        return $result->result();
    }
    
    public function insert_relacion($menu,$rol){
        $data = array(
            'id_roles'	=> $rol,
            'id_menu'	=> $menu
        );
        $this->db->insert('sys_roles_menu', $data);
        return $this->db->insert_id();
    }
    
    public function get_relacion($menu,$rol){
        $consulta = ("SELECT * FROM sys_roles_menu WHERE id_roles = $rol AND id_menu = $menu");
        $result = $this->db->query($consulta);
        return $result->result();
    }
    
    public function get_roles_menu($id_relacion){
        $consulta = ("SELECT * FROM sys_roles_menu WHERE id_roles_menu = $id_relacion");
        $result = $this->db->query($consulta);
        return $result->result();
    }
    
    public function Update_relacion($id_relacion,$menu,$rol){
        $data = array(
            'id_roles'	=> $rol,
            'id_menu'   => $menu
        );
        $this->db->where('id_roles_menu', $id_relacion);
        return $this->db->update('sys_roles_menu', $data);
    }
    
    public function Delete_relacion($id_relacion){
        $this->db->where('id_roles_menu', $id_relacion);
        $this->db->delete('sys_roles_menu');
    }
}