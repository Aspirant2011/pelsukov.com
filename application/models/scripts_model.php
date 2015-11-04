<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
define('PG_PRODUCTS_TABLE', 'pg_scripts');

class Scripts_model extends CI_Model {
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
	 * Attributes of contact_us object
	 * 
	 * @var array
	 */
	private $fields = array(
		'id',
		'gid',
		'name',
	);

	/**
	 * Constructor
	 * 
	 * @return Contact_us_model
	 */
	public function __construct(){
		parent::__construct();
		$this->CI = & get_instance();
		$this->DB = &$this->CI->db;
	}

	/**
	 * Return reason object by identifier
	 * 
	 * @param integer $reason_id reason identifier
	 * @return array
	 */
	public function get_product_by_id($product_id){
		$result = $this->DB->select(implode(", ", $this->fields))->from(PG_PRODUCTS_TABLE)->where("id", $product_id)->get()->result_array();
		if(!empty($result)){
			$data = $result[0];
			return $data;
		}
		return array();
	}
	
	public function get_product_by_gid($gid){
		$result = $this->DB->select(implode(", ", $this->fields))->from(PG_PRODUCTS_TABLE)->where("gid", $gid)->get()->result_array();
		if(!empty($result)){
			$data = $result[0];
			return $data;
		}
		return array();
	}
	
	public function get_product_by_module($name){
		$results = $this->DB->select(implode(", ", $this->fields))->from(PG_PRODUCTS_TABLE)->where($name, '1')->order_by('name')->get()->result_array();
		if(!empty($results) && is_array($results)){
			return $results;
		}
		return array();
	}

	/**
	 * Return filteres reason objects as array
	 * 
	 * @param array $params filters parameters
	 * @param array $filter_object_ids filters identifiers
	 * @param array $order_by sorting data
	 * @return array
	 */
	public function get_product_list($params=array(), $filter_object_ids=null, $order_by=null){
		$this->DB->select(implode(", ", $this->fields));
		$this->DB->from(PG_PRODUCTS_TABLE);

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
			return $results;
		}
		return array();
	}

	/**
	 * Return number of filtered reason objects
	 * @param array $params filters parameters
	 * @param array $filter_object_ids filters identifiers
	 * @return integer
	 */
	public function get_product_count($params=array(), $filter_object_ids=null){
		$this->DB->select("COUNT(*) AS cnt");
		$this->DB->from(PG_PRODUCTS_TABLE);

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
	 * Save reason object to data source
	 * 
	 * @param integer $reason_id reason identifier
	 * @param array $data reason data
	 * @param array $langs languages data
	 * @return integer
	 */
	public function save_product($product_id, $data, $langs=null){
		if (is_null($product_id)){
			$data["date_add"] = date("Y-m-d H:i:s");
			$this->DB->insert(PG_PRODUCTS_TABLE, $data);
			$product_id = $this->DB->insert_id();
		}else{
			$this->DB->where('id', $product_id);
			$this->DB->update(PG_PRODUCTS_TABLE, $data);
		}
		return $product_id;
	}

	/**
	 * Validate reason data for saving to data source
	 * 
	 * @param integer $reason_id reason identifier
	 * @param array $data reason data
	 * @param array $langs languages data
	 * @return array
	 */
	public function validate_product($product_id, $data, $langs=null){
		$return = array("errors"=> array(), "data" => array(), 'temp' => array(), 'langs' => array());

		return $return;
	}

	/**
	 * Remove reason data from data source
	 * 
	 * @param integer $reason_id reason identifier
	 * @return void
	 */
	public function delete_product($product_id){
		$this->DB->where("id", $product_id);
		$this->DB->delete(PG_PRODUCTS_TABLE);

	}

	/**
	 * Format reasons data
	 * 
	 * @param array $data reasons data
	 * @return array
	 */
	public function format_reasons($data){
		foreach($data as $k => $reason){
			$reason["name"] = l('contact_us_reason_'.$reason["id"], 'contact_us');
			
			foreach($this->CI->pg_language->languages as $lang_id=>$lang_data){
				$reason["name_".$lang_id] = l('contact_us_reason_'.$reason["id"], 'contact_us', $lang_id);
			}
			
			$reason["mails"] = unserialize($reason["mails"]);
			if(!empty($reason["mails"]) && is_array($reason["mails"])){
				$reason["mails_string"] = implode(", ", $reason["mails"]);
			}else{
				$reason["mails_string"] = "";
			}
			$data[$k] = $reason;
		}
		return $data;
	}
}
