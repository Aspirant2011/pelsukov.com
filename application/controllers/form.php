<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Form extends CI_Controller {

	public function sendemail()
	{
		$siteOwnersEmail = 'pavel_aleksan@mail.ru';
		$langs = $this->display_lib->data_view['langs'];
		if($_POST) {
			$name = trim(stripslashes($_POST['contactName']));
			$email = trim(stripslashes($_POST['contactEmail']));
			$subject = trim(stripslashes($_POST['contactSubject']));
			$contact_message = trim(stripslashes($_POST['contactMessage']));
			$recaptcha_code = $_POST['recaptcha'];

			$error = array();
			
			// Check captcha
			if (!empty($recaptcha_code)){
				$this->load->library('recaptcha');
				$resp = $this->recaptcha->verifyResponse($_SERVER["REMOTE_ADDR"],$recaptcha_code);
				if (!$resp->success) {
					$error['captcha'] = $langs['form_error_captcha'];
				}
			} else{
				$error['captcha'] = $langs['form_error_captcha'];
			}
			
		   // Check Name
			if (strlen($name) < 2) {
				$error['name'] = $langs['form_error_your_name'];
			}
			// Check Email
			if (!preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is', $email)) {
				$error['email'] = $langs['form_error_email'];
			}
			// Check Message
			if (strlen($contact_message) < 15) {
				$error['message'] = $langs['form_error_message'];
			}
			// Subject
			if ($subject == '') { $subject = "Новое письмо с формы контакта"; }




			if (empty($error)) {

				// Set Message
				$message = "Email from: " . $name . "<br />";
				$message .= "Email address: " . $email . "<br />";
				$message .= "Message: <br />";
				$message .= $contact_message;
				$message .= "<br /> ----- <br /> This email was sent from your site's contact form. <br />";

				// Set From: header
				$from =  $name . " <admin@pelsukov.com>";

				// Email Headers
				$headers = "From: " . $from . "\r\n";
				$headers .= "Reply-To: ". $email . "\r\n";
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

				ini_set("sendmail_from", $siteOwnersEmail); // for windows server
				$mail = mail($siteOwnersEmail, $subject, $message, $headers);

				if ($mail) { echo "OK"; }
			  else { echo "Something went wrong. Please try again."; }
				
			} # end if - no validation error

			else {

				$response = (isset($error['name'])) ? $error['name'] . "<br/> \n" : null;
				$response .= (isset($error['email'])) ? $error['email'] . "<br/> \n" : null;
				$response .= (isset($error['message'])) ? $error['message'] . "<br/>" : null;
				$response .= (isset($error['captcha'])) ? $error['captcha'] . "<br/>" : null;
				
				echo $response;

			} # end if - there was a validation error

		}
	}

	public function checkPaymentform()
	{	
		$langs = $this->display_lib->data_view['langs'];
		$result = array();
		if($_POST) {
			$payment_system = trim(stripslashes($_POST['payment_system']));
			$script = trim(stripslashes($_POST['script']));
			$name = trim(stripslashes($_POST['name']));
			$email = trim(stripslashes($_POST['email']));
			$product = trim(stripslashes($_POST['product']));
			$comment = trim(stripslashes($_POST['comment']));
			$recaptcha_code = $_POST['recaptcha'];

			$error = array();
			$this->load->model('products_model');
			$product_information = $this->products_model->get_product_by_gid($product);
			
			if (empty($product_information)) {
				$error[] = $langs['form_error_product_is_not_avaliable'];
			}
			if (empty($script)) {
				$error[] = $langs['form_error_select_pg_script'];
			}
			if (strlen($name) < 2) {
				$error[] = $langs['form_error_your_name'];
			}
			if (!preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is', $email)) {
				$error[] = $langs['form_error_email'];
			}
			if (empty($payment_system)) {
				$error[] = $langs['form_error_select_payment_system'];
			}
			// Check captcha
			if (!empty($recaptcha_code)){
				$this->load->library('recaptcha');
				$resp = $this->recaptcha->verifyResponse($_SERVER["REMOTE_ADDR"],$recaptcha_code);
				if (!$resp->success) {
					$error[] = $langs['form_error_captcha'];
				}
			} else{
				$error[] = $langs['form_error_captcha'];
			}


			if (empty($error)) {
				$comment = "Скрипт: ".$script."<br/>".$comment."<br/>Язык: ".$this->session->userdata('lang_id');
				$this->load->model('payments_model');
				$insert_data = array();
				$insert_data['product'] = $product;
				$insert_data['name'] = $name;
				$insert_data['email'] = $email;
				$insert_data['comment'] = $comment;
				$insert_data['payment_system'] = $payment_system;
				$insert_data['price'] = $product_information['price'];
				$insert_data['currency'] = $product_information['currency'];
				$result['id_transaction'] = $this->payments_model->save_payment(null, $insert_data);
			} else {
				$response = implode("<br/> \n", $error);
				$result['error'] = $response;
			}
			echo json_encode($result);
			exit();
		}
	}
}
