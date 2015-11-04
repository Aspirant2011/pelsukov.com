<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Display_lib
{
	public $data_view = array();
	public function assign($name, $value)
	{
		$this->data_view[$name] = $value;
	}
	
	public function view($name)
	{
		$CI =& get_instance();
		$CI->load->view($name,$this->data_view);
	}
	public function ajax_view($name)
	{
		$CI =& get_instance();
		
		$CI->load->view($name,$this->data_view);
	}
}

?>
