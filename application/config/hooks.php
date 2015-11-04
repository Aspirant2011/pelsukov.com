<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$hook['post_controller_constructor'][] = array(
			'class' => '',
			'function' => 'GetLangContent',
			'filename' => 'language.php',
			'filepath' => 'hooks'
		);