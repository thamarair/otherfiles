<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class LanguageLoader
{
	function initialize()
	{		
        $ci =& get_instance();
        $ci->load->helper('language');
		$language_id = $ci->session->userdata('language_id');
		$user_id = $ci->session->userdata('user_id'); 
		 
		if($user_id!="" || isset($user_id))
		{ 			
			if($language_id=='101')
			{
				$ci->lang->load('index_lang','english');
			}
			else if($language_id=='102')
			{
				$ci->lang->load('index_lang','tamil');
			}
			else if($language_id=='103')
			{
				$ci->lang->load('index_lang','kannada');
			}
			else if($language_id=='104')
			{
				$ci->lang->load('index_lang','gujarati');
			}
			else		
			{
				$ci->lang->load('index_lang','english');
			} 			
		} 
    }	
}

?>