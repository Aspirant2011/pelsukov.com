<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
define('LANGUAGES_TABLE', 'languages');
define('LANG_TEXTS_TABLE', 'lang_texts');

class Languages_model extends CI_Model {
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
	private $fields_text = array(
		'id',
		'gid',
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
	
	public function get_language_texts_list($lang_id=1){
		$this->fields_text = array_merge($this->fields_text, array("value_$lang_id"));
		$this->DB->select(implode(", ", $this->fields_text));
		$this->DB->from(LANG_TEXTS_TABLE);

		$results = $this->DB->get()->result_array();
		if(!empty($results) && is_array($results)){
			$return = array();
			foreach ($results as $lang){
				$return[$lang['gid']] = $lang['value_'.$lang_id];
			}
			return $return;
		}
		return array();
	}

}
