<?php  

if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Fortumo payment system driver model
 * 
 * @package PG_RealEstate
 * @subpackage Payments
 * @category	models
 * @copyright Pilot Group <http://www.pilotgroup.net/>
 * @author Katya Kashkova <katya@pilotgroup.net>
 * @version $Revision: 2 $ $Date: 2010-04-02 15:07:07 +0300 (Ср, 02 апр 2010) $ $Author: kkashkova $
 **/
class  Fortumo_model extends Payment_driver_model{
	public $settings = array(
		'seller_id' => array('type'=>'text', 'content'=>'string', 'size'=>'middle'),
		'secret_word' => array('type'=>'text', 'content'=>'string', 'size'=>'middle'),
		'amount_rate' => array('type'=>'text', 'content'=>'string', 'size'=>'middle'),
	);
	
	private $variables = array(
		'service_id' => 'seller_id',
		'cuid' => 'payment_id',
		'price' => 'amount',
		'currency' => 'currency',
		'sig' => 'hash',
		'payment_id' => 'transaction_id',
		'sender' => 'sender',
		'operator' => 'operator',
		'status' => 'status',
	);
	
	private $available_ips = array('81.20.151.38', '81.20.148.122', '79.125.125.1', '209.20.83.207');
	
	private $test = false;
	
	function __construct(){
		parent::__construct();
	}
	
	public function func_request($payment_data, $system_settings){
		$return = array("errors" => array(), "info" => array(), "data"=>$payment_data);
		return $return;
	}
	
	public function func_responce($payment_data, $system_settings){
		$return = array("errors" => array(), "info" => array(), "data"=>array(), "type"=>"exit");
	
		foreach($this->variables as $payment_var => $site_var){
			$return['data'][$site_var] = isset($payment_data[$payment_var])?$this->CI->input->xss_clean($payment_data[$payment_var]):"";
		}
		
		unset($payment_data['sig']);
		
		if(!in_array($_SERVER['REMOTE_ADDR'], $this->available_ips)){
			exit;
		}
		
		if($system_settings["settings_data"]["seller_id"] != $return["data"]["seller_id"]){
			$error = true;
		}
		
		$this->CI->load->model("Payments_model");
		$site_payment_data = $this->CI->Payments_model->get_payment_by_id($return["data"]['id_payment']);
		$server_side_amount = $site_payment_data["amount"]*max(intval($system_settings['settings_data']['amount_rate']), 1);
		if(floatval($server_side_amount) > floatval($return["data"]['amount']) || 
			$site_payment_data["currency_gid"] != $return["data"]['currency']){
			$error = true;
		}
		
		$server_side_hash = $this->get_signature($payment_data, $system_settings['settings_data']['secret_word']);
		if(!empty($system_settings['settings_data']['secret_word']) && $server_side_hash != $return['data']['hash']){
			$error = true;
		}
		
		if($return['data']['status'] != 'completed') $error = true;
		
		if($error){
			$return["data"]["status"] = -1; 
		}else{
			$return["data"]["status"] = 1; 
			
			echo('OK');
		}
		
		return $return;
	}
	
	public function func_js(){
		return true;
	}

	public function get_settings_map(){
		foreach($this->settings as $param_id => $param_data){
			$this->settings[$param_id]["name"] = l('system_field_'.$param_id, 'payments');
		}
		return $this->settings;
	}
	
	public function get_js($payment_data, $system_settings){
		$service_url = 'http://fortumo.com/mobile_payments/'.$system_settings['settings_data']['seller_id'].'.xml';
		
		$amount = $payment_data['amount']*max(intval($system_settings['settings_data']['amount_rate']), 1);
		
		$tc = array();
		
		if(function_exists('curl_init')){
			$ch = curl_init($service_url);
			curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
			$file_content = curl_exec($ch);
			curl_close($ch);
		}else{
			$file_content = file_get_contents($service_url);
		}
		
		try{
			$xml = simplexml_load_string($file_content);
	
			$countries = $xml->countrues->children();
			
			foreach($countries->xpath('//price_point') as $price_point){
				$attrs = $price_point->attributes();
				if(strval($attrs['currency']) == $payment_data['currency_gid'] && 
				   floatval($attrs['amount']) == floatval($amount)){
					$tc[] = intval($attrs['id']);
				}
			}
	
			unset($xml);
		}catch(Exception $e){
			
		}

		$params = array(
			'cuid' => $payment_data['id_payment'],
			'tc_amount' => $amount,
			'callback_url' => urlencode(site_url()),
		);
		
		if(!empty($tc)){
			$params['tc_id'] = current($tc);
		}
		
		if($this->test){
			$params['test'] = 'ok';
		}
		
		$user_id = $this->CI->session->userdata('user_id');
		
		$this->CI->load->model('Users_model');
		
		$this->CI->Users_model->set_format_settings('get_safe', false);
		$user = $this->CI->Users_model->get_user_by_id($user_id);
		$this->CI->Users_model->set_format_settings('get_safe', true);
		
		$params['msisdn'] = preg_replace('/[^\d]/i', '', $user['phone']);
		
		$params['hash'] = $this->get_signature($params, $system_settings['settings_data']['secret_word']);
		 
		foreach($params as $k=>$v){
			$params[$k] = $k.'='.$v;
		}
		 
		$rel = $system_settings['settings_data']['seller_id'].'?'.implode('&', $params);
	
		return '
	<script type="text/javascript" src="http://fortumo.com/javascripts/fortumopay.js"></script>
	<script>
		$(function(){
			setTimeout(\'$("#fmp-button img").trigger("click");\', 1000);
		});
	</script>
	<a id="fmp-button" href="#" rel="'.$rel.'" class="hide">
		<img src="http://fortumo.com/images/fmp/fortumopay_96x47.png" width="96" height="47" alt="Mobile Payments by Fortumo" border="0" />
	</a>';
	}
	
	private function get_signature($params, $secret){
		ksort($params);
		$sig = '';
		foreach($params as $k=>$v){
			$sig .= $k.'='.$v;
		}
		$sig .= $secret;
		return md5($sig);
	}
}
