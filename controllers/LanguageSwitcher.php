<?php
defined('BASEPATH') OR exit('No direct script access allowed');

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class LanguageSwitcher extends CI_Controller
{
    public function __construct() {
        parent::__construct();     
    }
 
    function switchLang($language = "")
	{
        
        $language = ($language != "") ? $language : "english";
        $language = ($language != "") ? $language : "tamil";
        $language = ($language != "") ? $language : "kannada";
        $language = ($language != "") ? $language : "gujarati";
        $this->session->set_userdata('language_id', $language);
        
        redirect('/');
        
    }
}