<?php  

if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Payment system driver main model
 * 
 * @package PG_RealEstate
 * @subpackage Payments
 * @category	models
 * @copyright Pilot Group <http://www.pilotgroup.net/>
 * @author Katya Kashkova <katya@pilotgroup.net>
 * @version $Revision: 2 $ $Date: 2010-04-02 15:07:07 +0300 (Ср, 02 апр 2010) $ $Author: kkashkova $
 **/
class Payment_driver_model extends CI_Model
{
	/**
	 * System settings
	 * 
	 * @var array
	 */
	public $settings = array();

	/**
	 * Fields of html form
	 * 
	 * @var array
	 */
	public $html_fields = array();

	/**
	 * Service variables
	 * 
	 * @var array
	 */
	private $variables = array();
	
	/**
	 * Return action of request 
	 * 
	 * redirect, text
	 * 
	 * @var string
	 */
	public $request_return_type = "redirect";

	/**
	 * Link to CodeIgniter object
	 * 
	 * @var object
	 */
	public $CI;

	/**
	 * Constructor
	 * 
	 * @return Payment_driver_model
	 */
	public function __construct(){
		parent::__construct();
		$this->CI = & get_instance();
	}
	
	/**
	 * Send request to payment system
	 * 
	 * @param array $payment_data payment data
	 * @param array $system_settings system settings
	 * @return array
	 */
	public function func_request($payment_data, $system_settings){
		$return = array("errors" => array(), "data"=>$payment_data);
		return $return;
	}

	/**
	 * Process responce from payment system
	 * 
	 * @param array $payment_data payment data
	 * @param array $system_settings system settings
	 * @return array
	 */
	public function func_responce($payment_data, $system_settings){
		$return = array("errors" => array(), "data"=>$payment_data);
		return $return;
	}
	
	/**
	 * Usage html form
	 * 
	 * @return boolean
	 */
	public function func_html(){
		return false;
	}

	/**
	 * Validate data for payment system
	 * 
	 * @param array $payment_data payment data
	 * @param array $system_settings system settings
	 * @return array
	 */
	public function func_validate($payment_data, $system_settings){
		$return = array("errors" => array(), "data"=>$payment_data);
		return $return;
	}
	
	/**
	 * Validate settings of payment system
	 * 
	 * @param array $data settings data
	 * @return array
	 */
	public function validate_settings($data){
		$return = array("errors"=> array(), "data" => array());

		if(!empty($this->settings)){
			foreach($this->settings as $param_id => $param_data){
				$value = isset($data[$param_id])?$data[$param_id]:"";
				switch($param_data["content"]){
					case "float": $value = floatval($value); break;
					case "int": $value = intval($value); break;
					case "string": $value = trim(strip_tags($value)); break;
					case "html": break;
				}
				$return["data"][$param_id] = $value;
			}
		}

		return $return;
	}
	
	/**
	 * Return settings of payment system
	 * 
	 * @return array
	 */
	public function get_settings_map(){
		return $this->settings;
	}

	/**
	 * Return fields of html form
	 * 
	 * @return array
	 */
	public function get_html_map(){
		return $this->html_fields;
	}

	/**
	 * Send payment data to url
	 * 
	 * @param string $url system url
	 * @param array $data payment data
	 * @param string $method form method
	 * return void/false
	 */
	public function send_data($url, $data=array(), $method="post"){
		if($method === "get"){

			$redirect = "Location: " . $url . "?";
			foreach ($data as $key => $value) {
				$redirect .= $key . "=" . $value . "&";
			}
			header($redirect);
			exit();
		}elseif($method === "post"){

			$retHTML = "<html><body onLoad=\"document.send_form.submit();\">";
			$retHTML .= "<form method=\"post\" name=\"send_form\" action=\"".$url."\">";
			foreach ($data as $key => $value) {
				$retHTML .= "<input type=\"hidden\" name=\"".$key."\" value=\"".$value."\">";
			}
			$retHTML .= "</form></body></html>";
			print $retHTML;
			exit();
		}else{
			return false;
		}

	}
	
	/**
	 * Usage javascipt popup
	 * 
	 * @return boolean
	 */
	public function func_js(){
		return false;
	}
	
	/**
	 * Return code of javascript popup
	 * 
	 * @param array $payment_data peyment data
	 * @param array $system_settings system settings
	 * @return string
	 */
	public function get_js($payment_data, $system_settings){
		return '';
	}
}
