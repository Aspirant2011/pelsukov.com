<?php  

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Paypal_model extends Payment_driver_model
{

	public $settings = array(
		"seller_id" => array("type"=>"text", "content"=>"string", "size"=>"middle")
	);

	private $variables = array(
		"business" => "seller_id",
		"mc_gross" => "amount",
		"mc_currency" => "currency",
		"custom" => "id_payment",
		"test_ipn" => "test_mode",
	);
	
	function __construct()
	{
		parent::__construct();
	}
	
	public function func_request($payment_data){
		$return = array("errors" => array(), "info" => array(), "data"=>$payment_data);
		$payment_data["pay_rub"]=1;
		if ($payment_data["pay_rub"]==1){
			$send_data = array(
				"business" => "pavel_aleksan@mail.ru",
				//"business" => "pavel.elsukov@gmail.com",
				//"business" => "pavel_aleksan-facilitator@mail.ru",
				//"business" => "pavel.elsukov-facilitator@gmail.com",
				"amount" => $payment_data["amount"]*60,
				"currency_code" => "RUB",
				"custom" => $payment_data["id_payment"],
				"test_ipn" => "1",
				"rm" => "2",
				"return" => base_url(),
				//"notify_url" => base_url()."buy/response/paypal",
				"notify_url" => base_url()."buy/response/paypal",
				"cancel_return" => base_url(),
				"cmd" => "_xclick",
				"item_name" => $payment_data["payment_data"]["name"],
			);
		} else{
			$send_data = array(
				"business" => "pavel_aleksan@mail.ru",
				//"business" => "pavel.elsukov@gmail.com",
				//"business" => "pavel_aleksan-facilitator@mail.ru",
				//"business" => "pavel.elsukov-facilitator@gmail.com",
				/*"amount" => $payment_data["amount"]*50,
				"currency_code" => "RUB",*/
				"amount" => $payment_data["amount"],
				"currency_code" => $payment_data["currency_gid"],
				"custom" => $payment_data["id_payment"],
				"test_ipn" => "1",
				"rm" => "2",
				"return" => base_url(),
				//"notify_url" => base_url()."buy/response/paypal",
				"notify_url" => base_url()."buy/response/paypal",
				"cancel_return" => base_url(),
				"cmd" => "_xclick",
				"item_name" => $payment_data["payment_data"]["name"],
			);
		}
		
		$this->send_data("https://www.paypal.com/cgi-bin/webscr", $send_data, "post");
		//$this->send_data("https://sandbox.paypal.com/cgi-bin/webscr", $send_data, "post");
		return $return;
	}

	public function func_responce($payment_data){
		$return = array("errors" => array(), "info" => array(), "data"=>array(), "type"=>"exit");

		// verify
		$verify = $this->verify_data($payment_data);
		
		if(!$verify) exit;
		
		foreach($this->variables as $payment_var => $site_var){
			$return["data"][$site_var] = isset($payment_data[$payment_var])?$this->CI->input->xss_clean($payment_data[$payment_var]):"";
		}
		
		$this->CI->load->model("Payments_model");
		$site_payment_data = $this->CI->Payments_model->get_payment_by_id($return["data"]['id_payment']);
		if(floatval($site_payment_data["price"]) != floatval($return["data"]['amount']) || 
			$site_payment_data["currency"] != $return["data"]['currency']){
			$error = true;
		}

		//// get status
		$return["data"]["status"] = 0;
		if(isset($payment_data['payment_status'])){
			switch($payment_data['payment_status']){
				case "Completed": $return["data"]["status"] = "success"; break;
				case "Pending": $return["data"]["status"] = "error"; break;
				default: $return["data"]["status"] = "send"; break;
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

	private function verify_data($payment_data){
		$req = 'cmd=_notify-validate';
	
		foreach($payment_data as $key=>$value){
			$req  .= '&'.$key.'='.urlencode(stripslashes($value)); 
		}
		
		$verify_url = 'www.paypal.com';
		//$verify_url = 'www.sandbox.paypal.com';
		
		if(function_exists('curl_init')){
			$ch = curl_init('https://'.$verify_url.'/cgi-bin/webscr');
			curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
			curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
			$res = curl_exec($ch);
			curl_close($ch);
		}else{
			$header  = "POST /cgi-bin/webscr HTTP/1.1\r\n";
			$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
			$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
  
			$fp = fsockopen('ssl://'.$verify_url, 443, $errno, $errstr, 10);
			fputs($fp, $header . $req);

			while (!feof($fp)){
				$res = fgets($fp, 1024);
				break;				
			}
		}

		if(strcmp($res, "VERIFIED") == 0){
			return true;
		}elseif(strcmp($res, "INVALID") == 0){
					
		}
		
		return false;
	}
}
