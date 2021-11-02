<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class StudentModule_lib {

    private $allModules = array();
    protected $modules;
    var $perm_category;
 
    function __construct() {
        $this->CI = & get_instance();
        $this->modules = array();
        self::loadModule(); //Initiate the userroles
         $this->CI->load->library('session');
         
    }

    function loadModule() {
        $this->student=$this->CI->session->userdata('student');
        
        $this->allModules = $this->CI->Module_model->get_userpermission($this->student['role']);
        $role_name=$this->student['role'];

        if (!empty($this->allModules)) {
            foreach ($this->allModules as $mod_key => $mod_value) {
                
                if ($mod_value->$role_name==1) {
                    $this->modules[$mod_value->short_code] = true;
                } else {

                    $this->modules[$mod_value->short_code] = false;
                }
            }
        }
        

    }

    function hasActive($module = null) {
        //print_r($this->CI->session->userdata('student'));die;
        //print_r($module);die;
        if ($this->modules[$module]) {
            return true;
        }

        return false;
    }

}
