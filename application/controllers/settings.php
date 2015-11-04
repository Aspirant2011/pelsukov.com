<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends CI_Controller {

	public function change_language($id_lang=1)
	{
		$this->session->set_userdata('lang_id', $id_lang);
		
		if(strpos($_SERVER["HTTP_REFERER"], base_url()) !== false){
			redirect($_SERVER["HTTP_REFERER"]);
		}else{
			redirect();
		}
	}
}
