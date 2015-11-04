<?php  

if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Robocassa payment system driver model
 * 
 * @package PG_RealEstate
 * @subpackage Payments
 * @category	models
 * @copyright Pilot Group <http://www.pilotgroup.net/>
 * @author Katya Kashkova <katya@pilotgroup.net>
 * @version $Revision: 2 $ $Date: 2010-04-02 15:07:07 +0300 (Ср, 02 апр 2010) $ $Author: kkashkova $
 **/
class  Robokassa_model extends Payment_driver_model{
	public $settings = array(
		'merchant_login' => array('type'=>'text', 'content'=>'string', 'size'=>'middle'),
		'merchant_pass1' => array('type'=>'text', 'content'=>'string', 'size'=>'middle'),
		'merchant_pass2' => array('type'=>'text', 'content'=>'string', 'size'=>'middle'),
	);
	
	private $variables = array(
		"OutSum" => "amount",
		"InvId" => "id_payment",
		"SignatureValue" => "hash",
	);
	
	/**
	 * Abailable languages
	 * @var array
	 */
	private $available_languages = array('en', 'ru');
	
	private $checkout_url = 'https://auth.robokassa.ru/Merchant/Index.aspx';
	private $test_checkout_url = 'http://test.robokassa.ru/Index.aspx';
	
	function __construct(){
		parent::__construct();
	}
	
	public function func_request($payment_data, $system_settings){
		$return = array("errors" => array(), "info" => array(), "data"=>$payment_data);
		
		$user_id = $this->CI->session->userdata('user_id');
		
		$this->CI->load->model('Users_model');
		$this->CI->Users_model->set_format_settings('get_safe', false);
		$user = $this->CI->Users_model->get_user_by_id($user_id);
		$this->CI->Users_model->set_format_settings('get_safe', true);
	
		$send_data = array(
			'MrchLogin' => $system_settings["settings_data"]["merchant_login"],
			'OutSum' => $payment_data["amount"],
			'InvId' => $payment_data["id_payment"],
			'Desc' => $payment_data["payment_data"]["name"],
			'SignatureValue' => md5($system_settings["settings_data"]["merchant_login"].':'.$payment_data["amount"].':'.$payment_data["id_payment"].':'.$system_settings["settings_data"]["merchant_pass1"]),
			'Email' => $user['email'],
		);
	
		$current_lang = $this->CI->pg_language->get_lang_by_id($this->CI->pg_language->current_lang_id);
		$current_lang['code'] = strtolower($current_lang['code']);
		if(in_array($current_lang['code'], $this->available_languages)){
			$send_data['Culture'] = $current_lang['code'];
		}
	
		$this->send_data($this->checkout_url, $send_data, "post"); 
		return $return;
	}
	
	public function func_responce($payment_data, $system_settings){
		$return = array("errors" => array(), "info" => array(), "data"=>array(), "type"=>"exit");
	
		foreach($this->variables as $payment_var => $site_var){
			$data[$site_var] = isset($payment_data[$payment_var])?$this->CI->input->xss_clean($payment_data[$payment_var]):"";
		}
		
		$error = false;

		$this->CI->load->model("Payments_model");
		$site_payment_data = $this->CI->Payments_model->get_payment_by_id($data['id_payment']);
		if(floatval($site_payment_data["amount"]) != floatval($data['amount'])){
			$error = true;
		}
	
		$server_side_hash = $data['amount'].':'.$data['id_payment'].':'.$system_settings["settings_data"]["merchant_pass2"];
		$server_side_hash = strtoupper(trim(md5($server_side_hash)));
		if($server_side_hash != $data['hash']){
			$error = true;
		}

		$return["data"] = $data;
		if($error){
			$return["data"]["status"] = -1; 
		}else{
			$return["data"]["status"] = 1; 
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
