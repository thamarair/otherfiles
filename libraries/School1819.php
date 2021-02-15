<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class School1819 {
  var $db = NULL;
  function __construct(){
    $CI = &get_instance();
    $this->db = $CI->load->database('db4', TRUE);  
  }
  
}
?>