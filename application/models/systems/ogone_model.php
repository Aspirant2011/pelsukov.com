<?php  

if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Ogone payment system driver model
 * 
 * send data only,
 * TODO: integarate server responce (test account needed)
 * 
 * @package PG_RealEstate
 * @subpackage Payments
 * @category	models
 * @copyright Pilot Group <http://www.pilotgroup.net/>
 * @author Katya Kashkova <katya@pilotgroup.net>
 * @version $Revision: 2 $ $Date: 2010-04-02 15:07:07 +0300 (Ср, 02 апр 2010) $ $Author: kkashkova $
 **/
class  Ogone_model extends Payment_driver_model
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
			"pspid" => $system_settings["settings_data"]["seller_id"],
			"amount" => $payment_data["amount"],
			"currency" => $payment_data["currency_gid"],
			"orderID" => $payment_data["id_payment"],
			"accept_url" => site_url(),
			"decline_url" => site_url(),
			"TITLE" => $payment_data["payment_data"]["name"],
		);

		$this->send_data("https://secure.ogone.com/ncol/prod/orderstandard.asp", $send_data, "post");
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
