<?php 

/**
 * Load menu indicators hook
 * 
 * @package PG_Core
 * @subpackage application
 * @category	hooks
 * @copyright Pilot Group <http://www.pilotgroup.net/>
 * @author Irina Lebedeva <irina@pilotgroup.net>
 * @version $Revision: 2 $ $Date: 2009-12-02 15:07:07 +0300 (Ср, 02 дек 2009) $ $Author: irina $
 **/
 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('GetLangContent')){

	function GetLangContent(){
		$CI = & get_instance();
		if (!$CI->session->userdata('lang_id')){
			$lang_id = 1;
			$CI->session->set_userdata('lang_id', 1);
		} else{
			$lang_id = $CI->session->userdata('lang_id');
			if (!$lang_id){
				$lang_id = 1;
				$CI->session->set_userdata('lang_id', 1);
			}
		}
		$CI->display_lib->assign('current_lang',$lang_id);
		
		$CI->load->model('languages_model');
		$CI->display_lib->assign('langs',$CI->languages_model->get_language_texts_list($lang_id));
	}

}
