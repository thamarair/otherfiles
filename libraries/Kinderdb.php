<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Kinderdb {
  var $db = NULL;
  function __construct(){
    $CI = &get_instance();
    $this->db = $CI->load->database('db3', TRUE);  
  }
  
}
?>