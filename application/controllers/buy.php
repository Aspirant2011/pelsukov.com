<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Buy extends CI_Controller {

	public function index()
	{
		$payment_system = trim(stripslashes($_POST['payment_system']));
		$script = trim(stripslashes($_POST['script']));
		$name = trim(stripslashes($_POST['name']));
		$email = trim(stripslashes($_POST['email']));
		$product = trim(stripslashes($_POST['product']));
		$comment = trim(stripslashes($_POST['comment']));
		$id_transaction = trim(stripslashes($_POST['id_transaction']));
		$pay_rub = intval($_POST['pay_rub']);
		if (empty($id_transaction)) redirect(base_url());
		$error = array();
		$this->load->model('products_model');
		$product_information = $this->products_model->get_product_by_gid($product);
		$this->load->model("Payment_systems_model");
		$payment_data["amount"] = $product_information['price'];
		$payment_data["currency_gid"] = $product_information['currency'];
		$payment_data["id_payment"] = $id_transaction;
		$payment_data["pay_rub"] = $pay_rub;
		$payment_data["payment_data"]["name"] = $product_information["name"];
		$this->Payment_systems_model->action_request($payment_system, $payment_data);
		
	}
	public function response($payment_system=null)
	{
		if(empty($payment_system)) redirect(base_url());
		
		/*$data = $_REQUEST;
		$this->load->helper('payments');
		$return = receive_payment($payment_system, $data);*/
		
		$this->display_lib->view('thanks_page');
	}

}
