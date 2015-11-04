<?php  

if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Pencepay payment system driver model
 * 
 * @package PG_RealEstate
 * @subpackage Payments
 * @category	models
 * @copyright Pilot Group <http://www.pilotgroup.net/>
 * @author Katya Kashkova <katya@pilotgroup.net>
 * @version $Revision: 2 $ $Date: 2010-04-02 15:07:07 +0300 (Ср, 02 апр 2010) $ $Author: kkashkova $
 **/
class Pencepay_model extends Payment_driver_model
{
	public $settings = array(
		'seller_id' => array('type'=>'text', 'content'=>'string', 'size'=>'middle'),
	);

	private $variables = array(
		'service' => 'seller_id',
		'phone' => 'phone',
		'country' => 'country',
		'mno' => 'mno',
		'amount' => 'amount',
		'status' => 'status',
		'clientid' => 'payment_id',
		'enduserprice' => 'enduserprice',
		'transactionid' => 'transactionid',
	);
	
	/**
	 * Abailable languages
	 * @var array
	 */
	private $available_languages = array(
		'bg', 'bs', 'cg', 'cs', 'da', 'de', 'el', 'en', 'es', 'et', 
		'fi', 'fr', 'hr', 'hu', 'id', 'it', 'ko', 'lt', 'lv', 'mc', 
		'mk', 'ms', 'no', 'sl', 'sq', 'sr', 'sv', 'th', 'tr', 'vi', 
		'zh',
	);
	
	
	private $checkout_url = 'https://service.pencepay.com/widget/WidgetModule';
	
	function __construct()
	{
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
		
		$error = false;

		$this->CI->load->model("Payments_model");
		$site_payment_data = $this->CI->Payments_model->get_payment_by_id($return['data']['id_payment']);
		if(floatval($site_payment_data["amount"]) != floatval($return['data']['amount'])){
			$error = true;
		}
		
		if($return['data']['status'] != 'success'){
			$error = true;
		}
		
		if($error){
			$return["data"]["status"] = -1; 
		}else{
			$return["data"]["status"] = 1; 
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
		$href = $this->checkout_url.'?api='.$system_settings['settings_data']['seller_id'];
		
		$current_lang = $this->CI->pg_language->get_lang_by_id($this->CI->pg_language->current_lang_id);
		$current_lang['code'] = strtolower($current_lang['code']);
		if(in_array($current_lang['code'], $this->available_languages)){
			$href .= '&locale='.$current_lang['code'];
		}
		
		$href .= '&amount='.$payment_data['amount'].'&clientid='.$payment_data['id_payment'];
		
		$user_id = $this->CI->session->userdata('user_id');
		
		$this->CI->load->model('Users_model');
		
		$this->CI->Users_model->set_format_settings('get_safe', false);
		$user = $this->CI->Users_model->get_user_by_id($user_id);
		$this->CI->Users_model->set_format_settings('get_safe', true);
		
		$href .= '&phone='.preg_replace('/[^\d]/i', '', $user['phone']);
		
		return '
	<script type="text/javascript" src="https://service.pencepay.com/widget/js/c-mobile-payment-scripts.js"></script>
	<script>
		$(function(){
			setTimeout(\'$("#c-mobile-payment-widget img").trigger("click");\', 1000);
		});
	</script>
	<a id="c-mobile-payment-widget" href="'.$href.'" class="hide">
		<img src="http://service.pencepay.com/res/css/r/pencepay/button.png"/>
	</a>';
	}
}
