<?php  

if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Manual payment driver model
 * 
 * @package PG_RealEstate
 * @subpackage Payments
 * @category	models
 * @copyright Pilot Group <http://www.pilotgroup.net/>
 * @author Katya Kashkova <katya@pilotgroup.net>
 * @version $Revision: 2 $ $Date: 2010-04-02 15:07:07 +0300 (Ср, 02 апр 2010) $ $Author: kkashkova $
 **/
class Manual_model extends Payment_driver_model
{

	public $settings = array(
	);

	private $variables = array(
		
	);

	function __construct()
	{
		parent::__construct();
	}
	
	public function func_request($payment_data, $system_settings){
		$return = array("errors" => array(), "info" => array(), "data"=>$payment_data);
		return $return;
	}

	public function func_responce($payment_data, $system_settings){
		$return = array("errors" => array(), "info" => array(), "data"=>$payment_data, "type"=>"html");
		return $return;
	}
	
	public function get_settings_map(){
		return array();
	}
}
