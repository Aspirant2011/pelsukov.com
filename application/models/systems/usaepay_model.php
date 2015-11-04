<?php  

if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Usaepay payment system driver model
 * 
 * @package PG_RealEstate
 * @subpackage Payments
 * @category	models
 * @copyright Pilot Group <http://www.pilotgroup.net/>
 * @author Katya Kashkova <katya@pilotgroup.net>
 * @version $Revision: 2 $ $Date: 2010-04-02 15:07:07 +0300 (Ср, 02 апр 2010) $ $Author: kkashkova $
 **/
class Usaepay_model extends Payment_driver_model
{
	public $settings = array(
		"seller_id" => array("type"=>"text", "content"=>"string", "size"=>"middle")
	);

	private $variables = array(
		
	);

	function __construct()
	{
		parent::__construct();
	}
	
	public function func_request($payment_data, $system_settings){
		$return = array("errors" => array(), "info" => array(), "data"=>$payment_data);
		
		$send_data = array(
			"UMkey" => $system_settings["settings_data"]["seller_id"],
			"UMamount" => $payment_data["amount"],
			"UMinvoice" => $payment_data["id_payment"],
			"UMtestmode" => "0",
			"UMredirApproved" => site_url(),
		);
		$this->send_data("https://www.usaepay.com/gate.php", $send_data, "post");
		return $return;
	}

	public function func_responce($payment_data, $system_settings){
		$return = array("errors" => array(), "info" => array(), "data"=>$payment_data, "type"=>"exit");

		return $return;
	}


	public function get_settings_map(){
		foreach($this->settings as $param_id => $param_data){
			$this->settings[$param_id]["name"] = l('system_field_'.$param_id, 'payments');
		}
		return $this->settings;
	}
}
