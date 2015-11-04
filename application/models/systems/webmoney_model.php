<?php  

if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Webmoney payment system driver model
 * 
 * @package PG_RealEstate
 * @subpackage Payments
 * @category	models
 * @copyright Pilot Group <http://www.pilotgroup.net/>
 * @author Katya Kashkova <katya@pilotgroup.net>
 * @version $Revision: 2 $ $Date: 2010-04-02 15:07:07 +0300 (Ср, 02 апр 2010) $ $Author: kkashkova $
 **/
class  Webmoney_model extends Payment_driver_model
{

	public $settings = array(
		"seller_id" => array("type"=>"text", "content"=>"string", "size"=>"middle"),
		"secret_word" => array("type"=>"text", "content"=>"string", "size"=>"middle"),
	);

	private $variables = array(
		"LMI_PAYEE_PURSE" => "seller_id",
		"LMI_PAYMENT_AMOUNT" => "amount",
		"LMI_PAYMENT_NO" => "id_payment",
		"LMI_MODE" => "test_mode",
		"LMI_PAYER_WM" => "payer_wm",
		"LMI_PAYER_PURSE" => "payer_purse",
		"LMI_SYS_INVS_NO" => "sys_invs_no",
		"LMI_SYS_TRANS_NO" => "sys_trans_no",
		"LMI_SYS_TRANS_DATE" => "sys_trans_date",
		"LMI_HASH" => "hash"
	);

	private $pre_variables = array(
		"LMI_PAYEE_PURSE" => "seller_id",
		"LMI_PAYMENT_AMOUNT" => "amount",
		"LMI_PAYMENT_NO" => "id_payment",
		"LMI_MODE" => "test_mode",
		"LMI_PAYER_WM" => "payer_wm",
		"LMI_PAYER_PURSE" => "payer_purse",
	);

	function __construct()
	{
		parent::__construct();
	}
	
	public function func_request($payment_data){
		$return = array("errors" => array(), "info" => array(), "data"=>$payment_data);
		
		/*if(function_exists('iconv')){
			$desc = substr(iconv('utf-8', 'windows1251', $payment_data["payment_data"]["name"]), 0, 255);
		}else{
			$desc = 'Payment description';
		}*/
		
		$send_data = array(
			"LMI_PAYEE_PURSE" => 'Z294675134020',
			"LMI_PAYMENT_AMOUNT" => $payment_data["amount"],
			"LMI_PAYMENT_NO" => $payment_data["id_payment"],
			"LMI_SIM_MODE" => "0",
			//"LMI_PAYMENT_DESC" => $desc,
			"LMI_PAYMENT_DESC_BASE64" => base64_encode($payment_data["payment_data"]["name"]),
			"LMI_RESULT_URL" => site_url()."buy/response/webmoney",
			"LMI_SUCCESS_URL" => site_url(),
			"LMI_SUCCESS_METHOD" => "POST",
			"LMI_FAIL_URL" => site_url(),
			"LMI_FAIL_METHOD" => "POST",
		);
		$this->send_data("https://merchant.webmoney.ru/lmi/payment.asp", $send_data, "post");
		return $return;
	}

	public function func_responce($payment_data){
		$return = array("errors" => array(), "info" => array(), "data"=>array(), "type"=>"exit");

		if(isset($payment_data["LMI_PREREQUEST"]) && $payment_data["LMI_PREREQUEST"] == 1){
			/// this is pre-order request
		
			foreach($this->pre_variables as $payment_var => $site_var){
				$data[$site_var] = isset($payment_data[$payment_var])?$this->CI->input->xss_clean($payment_data[$payment_var]):"";
			}

			$error = false;

			if($data["seller_id"]!='Z294675134020'){
				$error = true;
			}
			
			$this->CI->load->model("Payments_model");
			$site_payment_data = $this->CI->Payments_model->get_payment_by_id($data['id_payment']);
			if(floatval($site_payment_data["price"]) != floatval($data['amount'])){
				$error = true;
			}
			
			if($error){
				echo "ERROR";
			}else{
				echo "YES";
			}

			exit();
		}else{
			foreach($this->variables as $payment_var => $site_var){
				$data[$site_var] = isset($payment_data[$payment_var])?$this->CI->input->xss_clean($payment_data[$payment_var]):"";
			}

			$error = false;

			if($data["seller_id"] !='Z294675134020'){
				$error = true;
			}
			
			$this->CI->load->model("Payments_model");
			$site_payment_data = $this->CI->Payments_model->get_payment_by_id($data['id_payment']);
			if(floatval($site_payment_data["amount"]) != floatval($data['amount'])){
				$error = true;
			}

			$server_side_hash = $data['seller_id'] . strval($data['amount']) . $data['id_payment'] . 
								$data['test_mode'] . $data['sys_invs_no'] . $data['sys_trans_no'] . 
								$data['sys_trans_date'] . $system_settings["settings_data"]["secret_word"] . 
								$data['payer_purse'] . $data['payer_wm'];
			$server_side_hash = strtoupper(md5($server_side_hash));
			if($server_side_hash != $data["hash"]){
				$error = true;
			}
			
			$return["data"] = $data;
			if($error){
				$return["data"]["status"] = -1; 
			}else{
				$return["data"]["status"] = 1; 
			}
		}

		return $return;
	}

	public function get_settings_map(){
		foreach($this->settings as $param_id => $param_data){
			$this->settings[$param_id]["name"] = l('system_field_'.$param_id, 'payments');
		}
		return $this->settings;
	}
}
