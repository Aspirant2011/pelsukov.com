<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Smiles extends CI_Controller {

	public function index()
	{
		$this->load->model('scripts_model');
		$products = $this->scripts_model->get_product_by_module('module_smiles');
		$this->display_lib->assign('products', $products);
		
		$this->load->model('products_model');
		$module = $this->products_model->get_product_by_gid('module_smiles');
		$this->display_lib->assign('module', $module);
		
		$current_lang = $this->display_lib->data_view['current_lang'];
		$news = $this->products_model->get_news_list($current_lang, 'module_smiles', 3);
		$this->display_lib->assign('news', $news);
		
		$this->display_lib->view('smiles_page');
	}
}