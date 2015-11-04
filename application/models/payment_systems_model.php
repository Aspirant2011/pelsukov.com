<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

define('PAYMENTS_SYSTEMS_TABLE', 'payments_systems');
define('PAYMENTS_LOG_TABLE', 'payments_log');

class Payment_systems_model extends CI_Model
{
	/**
	 * Link to CodeIgniter object
	 * 
	 * @var object
	 */
	private $CI;
	
	/**
	 * Link to database object
	 * 
	 * @var object
	 */
	private $DB;

	/**
	 * Properties of payment system object in data source
	 * 
	 * @var array
	 */
	private $fields = array(
		'id',
		'gid',
		'name',
		'in_use',
		'date_add',
		'settings_data',
	);

	/**
	 * Name of current driver object
	 * 
	 * @var string
	 */
	private $current_driver_name = "";
	
	/**
	 * Current driver object
	 * 
	 * @var array
	 */
	private $driver;

	/**
	 * Cache of payment system's objects
	 * 
	 * @var array
	 */
	private $systems_cache = array();

	/**
	 * Use logging
	 * 
	 * @var boolean 
	 */
	private $log_data = true;

	/**
	 * Constructor
	 * 
	 * @return Payment_systems_model
	 */
	public function __construct(){
		parent::__construct();
		$this->CI = & get_instance();
		$this->DB = &$this->CI->db;
	}

	/**
	 * Return payment system object by GUID
	 * 
	 * @param string $gid system GUID
	 * @return array
	 */
	public function get_system_by_gid($gid){
		if(empty($this->systems_cache[$gid])){
			$result = $this->DB->select(implode(", ", $this->fields))->from(PAYMENTS_SYSTEMS_TABLE)->where("gid", $gid)->get()->result_array();
			if(!empty($result)){
				$this->systems_cache[$gid] = $this->format_system($result[0]);
			}else{
				$this->systems_cache[$gid] = array();
			}
		}
		return $this->systems_cache[$gid];
	}

	/**
	 * Format payment system object
	 * 
	 * @param array $data system data
	 * @return array
	 */
	public function format_system($data){
		$data["settings_data"] = unserialize($data["settings_data"]);
		$data["info_data"] = $data["info_data_".$this->pg_language->current_lang_id];
		return $data;
	}

	/**
	 * Return payment system's objects as array
	 * 
	 * @param array $params sql criteria of query to data source
	 * @param array $filter_object_ids filters identifiers
	 * @param array $order_by sorting data
	 * @return array
	 */
	public function get_system_list($params=array(), $filter_object_ids=null, $order_by=null){
		$this->DB->select(implode(", ", $this->fields));
		$this->DB->from(PAYMENTS_SYSTEMS_TABLE);

		if(isset($params["where"]) && is_array($params["where"]) && count($params["where"])){
			foreach($params["where"] as $field=>$value){
				$this->DB->where($field, $value);
			}
		}

		if(isset($params["where_in"]) && is_array($params["where_in"]) && count($params["where_in"])){
			foreach($params["where_in"] as $field=>$value){
				$this->DB->where_in($field, $value);
			}
		}

		if(isset($params["where_sql"]) && is_array($params["where_sql"]) && count($params["where_sql"])){
			foreach($params["where_sql"] as $value){
				$this->DB->where($value);
			}
		}

		if(isset($filter_object_ids) && is_array($filter_object_ids) && count($filter_object_ids)){
			$this->DB->where_in("id", $filter_object_ids);
		}

		if(is_array($order_by) && count($order_by)>0){
			foreach($order_by as $field => $dir){
				if(in_array($field, $this->fields)){
					$this->DB->order_by($field." ".$dir);
				}
			}
		}

		$results = $this->DB->get()->result_array();
		if(!empty($results) && is_array($results)){
			foreach($results as $r){
				$data[] = $this->systems_cache[$r["gid"]] = $this->format_system($r);
			}
			return $data;
		}
		return array();

	}

	/**
	 * Return actived payment system's objects as array
	 * 
	 * @param array $order_by sorting data
	 * @return array
	 */
	public function get_active_system_list($order_by=array("name"=>"ASC")){
		$params["where"]["in_use"] = 1;
		return $this->get_system_list($params, null, $order_by);
	}

	/**
	 * Return number of payment system's objects
	 * 
	 * @param array $params sql criteria of query to data source
	 * @param array $filter_object_ids filters identifiers
	 * @return integer
	 */
	public function get_system_count($params=array(), $filter_object_ids=null){
		$this->DB->select("COUNT(*) AS cnt");
		$this->DB->from(PAYMENTS_SYSTEMS_TABLE);

		if(isset($params["where"]) && is_array($params["where"]) && count($params["where"])){
			foreach($params["where"] as $field=>$value){
				$this->DB->where($field, $value);
			}
		}

		if(isset($params["where_in"]) && is_array($params["where_in"]) && count($params["where_in"])){
			foreach($params["where_in"] as $field=>$value){
				$this->DB->where_in($field, $value);
			}
		}

		if(isset($params["where_sql"]) && is_array($params["where_sql"]) && count($params["where_sql"])){
			foreach($params["where_sql"] as $value){
				$this->DB->where($value);
			}
		}

		if(isset($filter_object_ids) && is_array($filter_object_ids) && count($filter_object_ids)){
			$this->DB->where_in("id", $filter_object_ids);
		}

		$results = $this->DB->get()->result_array();
		if(!empty($results) && is_array($results)){
			return intval($results[0]["cnt"]);
		}
		return 0;
	}

	/**
	 * Validate payment system's object for saving to data source
	 * 
	 * @param integer $id system identifier
	 * @param array $system data
	 * @return array
	 */
	public function validate_system($id, $data){
		$return = array("errors"=> array(), "data" => array());

		if(isset($data["gid"])){
			$data["gid"] = strip_tags($data["gid"]);
			$data["gid"] = preg_replace("/[^a-z0-9]+/i", '', $data["gid"]);

			$return["data"]["gid"] = $data["gid"];

			if(empty($return["data"]["gid"]) ){
				$return["errors"][] = l('error_system_gid_incorrect', 'payments');
			}

			$param["where"]["gid"] = $return["data"]["gid"];
			if(!empty($id)) $param["where"]["id <>"] = $id;
			$gid_count = $this->get_system_count($param);
			if($gid_count > 0){
				$return["errors"][] = l('error_system_gid_already_exists', 'payments');
			}
		}

		if(isset($data["name"])){
			$return["data"]["name"] = strip_tags($data["name"]);
			if(empty($return["data"]["name"]) ){
				$return["errors"][] = l('error_system_name_incorrect', 'payments');
			}
		}

		if(isset($data["settings_data"])){
			$return["data"]["settings_data"] = serialize($data["settings_data"]);
		}
		
		

		if(isset($data["in_use"])){
			$return["data"]["in_use"] = intval($data["in_use"]);
		}
		
		if(isset($data["info_data"])){
			$return['data'] = array_merge($return['data'], $data["info_data"]);
		}

		return $return;
	}
	
	/**
	 * Validate data of information fields
	 * 
	 * @param array $data information data
	 * @return array
	 */
	public function validate_info_data($data){
		$return = array("errors"=> array(), "data" => array());
		
		$default_lang_id = $this->CI->pg_language->current_lang_id;
		if(isset($data['info_data_'.$default_lang_id])){
			$return['data']['info_data_'.$default_lang_id] = trim(strip_tags($data['info_data_'.$default_lang_id]));
			foreach($this->pg_language->languages as $lid=>$lang_data){
				if($lid == $default_lang_id) continue;
				if(!isset($data['info_data_'.$lid]) || empty($data['info_data_'.$lid])){
					$return['data']['info_data_'.$lid] = $return['data']['info_data_'.$default_lang_id];
				}else{
					$return['data']['info_data_'.$lid] = trim(strip_tags($data['info_data_'.$lid]));
				}
			}
		}
		
		return $return;
	}

	/**
	 * Save payment system object to data source
	 * 
	 * @param integer $id system identifier
	 * @param array $data system data
	 * @return integer
	 */
	public function save_system($id, $data){
		if (is_null($id)){
			$data["date_add"] = date("Y-m-d H:i:s");
			$this->DB->insert(PAYMENTS_SYSTEMS_TABLE, $data);
			$id = $this->DB->insert_id();
		}else{
			$this->DB->where('id', $id);
			$this->DB->update(PAYMENTS_SYSTEMS_TABLE, $data);
		}
		unset($this->systems_cache[$data["gid"]]);

		return $id;
	}

	/**
	 * Make payment system is used
	 * 
	 * @param string @gid system GUID
	 * @param integer $use used status
	 */
	public function use_system($gid, $use){
		$data["in_use"] = intval($use);
		$this->DB->where('gid', $gid);
		$this->DB->update(PAYMENTS_SYSTEMS_TABLE, $data);
		unset($this->systems_cache[$gid]);
	}

	/**
	 * Remove payment system object by identifier
	 * 
	 * @param integer $id system identifier
	 * @return void
	 */
	public function delete_system($id){
		$this->DB->where("id", $id);
		$this->DB->delete(PAYMENTS_SYSTEMS_TABLE);
		return;
	}

	/**
	 * Remove payment system object by GUID
	 * 
	 * @param string $gid system GUID
	 * @return void
	 */
	public function delete_system_by_gid($gid){
		$this->DB->where("gid", $gid);
		$this->DB->delete(PAYMENTS_SYSTEMS_TABLE);
		unset($this->systems_cache[$gid]);
		return;
	}

	///// drivers methods
	
	/**
	 * Load payment system model
	 * 
	 * @param string $system_gid system GUID
	 * @return boolean
	 */
	public function load_driver($system_gid){
		if(!empty($this->current_driver_name) && $this->current_driver_name == $system_gid){
			return true;
		}

		include_once(APPPATH . "models/payment_driver_model".EXT);
		$driver = strtolower($system_gid)."_model";
		$driver_file = APPPATH . "models/systems/".$driver.EXT;
		if(file_exists($driver_file)){
			include_once($driver_file);
			$this->driver = new $driver();
			$this->current_driver_name = $system_gid;
		}else{
			$this->current_driver_name = "";
			$this->driver = "";
			return false;
		}
	}

	/**
	 * Validate settings of payment system object for saving to data source
	 * 
	 * @param array $data settings data
	 * @return array
	 */
	public function validate_system_settings($data){
		if(empty($this->current_driver_name)){
			return false;
		}
		return $this->driver->validate_settings($data);
	}
	
	/**
	 * Return fields data of payment system object
	 * 
	 * @return array/false
	 */
	public function get_system_data_map(){
		if(empty($this->current_driver_name)){
			return false;
		}
		return $this->driver->get_settings_map();
	}

	/**
	 * Return html data of payment system object
	 * 
	 * @return array/false
	 */
	public function get_html_data_map(){
		if(empty($this->current_driver_name)){
			return false;
		}
		return $this->driver->get_html_map();
	}
	
	/**
	 * Send request to payment system
	 * 
	 * @param string $system_gid system GUID
	 * @param array $payment_data payment data
	 * @return void/false
	 */
	public function action_request($system_gid, $payment_data){
		if(empty($this->current_driver_name) || $this->current_driver_name != $system_gid){
			$this->load_driver($system_gid);
		}
		if(method_exists($this->driver, 'func_request')) {
			return $this->driver->func_request($payment_data);
		} else {
			return false;
		}
	}

	/**
	 * Process responce from payment system
	 * 
	 * @param string $system_gid system GUID
	 * @param array $payment_data payment data
	 * @return array
	 */
	public function action_responce($system_gid, $payment_data){
		if(empty($this->current_driver_name) || $this->current_driver_name != $system_gid){
			$this->load_driver($system_gid);
		}
		return $this->driver->func_responce($payment_data);
	}

	/**
	 * Used html form
	 * 
	 * @param string $system_gid system GUID
	 * @return boolean
	 */
	public function action_html($system_gid){
		if(empty($this->current_driver_name) || $this->current_driver_name != $system_gid){
			$this->load_driver($system_gid);
		}
		if(method_exists($this->driver, 'func_html')) {
			return $this->driver->func_html();
		} else {
			return false;
		}
	}

	/**
	 * Validate payment data for sending to payment system
	 * 
	 * @param string $system_gid system GUID
	 * @param array $payment_data payment data
	 * @return array
	 */
	public function action_validate($system_gid, $payment_data){
		if(empty($this->current_driver_name) || $this->current_driver_name != $system_gid){
			$this->load_driver($system_gid);
		}
		if(!empty($this->current_driver_name)){
			$system_settings = $this->get_system_by_gid($this->current_driver_name);
		}else{
			$system_settings = array();
		}
		return $this->driver->func_validate($payment_data, $system_settings);
	}

	/**
	 * Logging payment
	 * 
	 * @param string $system_gid system GUID
	 * @param string $log_type action type
	 * @param array $log_data logging data
	 * @return void
	 */
	public function log_data($system_gid, $log_type="request", $log_data=array()){
		$data["system_gid"] = $system_gid;
		$data["date_add"] = date("Y-m-d H:i:s");
		$data["log_type"] = $log_type;
		$data["payment_data"] = serialize($log_data);
		$this->DB->insert(PAYMENTS_LOG_TABLE, $data);
		return;
	}
	
	/**
	 * Add information data field of payment system by language
	 * 
	 * @param integer $lang_id language identifier
	 * @return void
	 */
	public function lang_dedicate_module_callback_add($lang_id=false){
		if(!$lang_id) return;
		
		$this->CI->load->dbforge();
		
		$fields['info_data_'.$lang_id] = array('type'=>'TEXT', 'null'=>TRUE);
		$this->CI->dbforge->add_column(PAYMENTS_SYSTEMS_TABLE, $fields);
		
		$default_lang_id = $this->CI->pg_language->get_default_lang_id();
		if($lang_id != $default_lang_id){
			$this->CI->db->set('info_data_'.$lang_id, 'info_data_'.$default_lang_id, false);
			$this->CI->db->update(PAYMENTS_SYSTEMS_TABLE);
		}
	}
	
	/**
	 * Remove information data field of payment system by language 
	 * 
	 * @param integer $lang_id language identifier
	 * @return void
	 */
	public function lang_dedicate_module_callback_delete($lang_id=false){
		if(!$lang_id) return;
		
		$this->CI->load->dbforge();
		
		$table_query = $this->CI->db->get(PAYMENTS_SYSTEMS_TABLE);
		$fields_exists = $table_query->list_fields();
		
		$fields = array('info_data_'.$lang_id);
		foreach($fields as $field_name){
			if(!in_array($field_name, $fields_exists)) continue;
			$this->CI->dbforge->drop_column(PAYMENTS_SYSTEMS_TABLE, $field_name);
		}
	}
	
	/**
	 * Use javascript popup
	 * 
	 * @param string $system_gid system GUID
	 * @return boolean
	 */
	public function action_js($system_gid){
		if(empty($this->current_driver_name) || $this->current_driver_name != $system_gid){
			$this->load_driver($system_gid);
		}
		if(method_exists($this->driver, 'func_js')) {
			return $this->driver->func_js();
		} else {
			return false;
		}
	}
	
	/**
	 * Return javascript code
	 * 
	 * @param array $payment_data payment data
	 * @param array $system_settings system settings
	 * @return string
	 */
	public function get_js($payment_data, $system_settings){
		if(empty($this->current_driver_name)){
			return false;
		}
		return $this->driver->get_js($payment_data, $system_settings);
	}
}
