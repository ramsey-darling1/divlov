<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {
//the default controller, determines if the user is logged in or not
//@rdarling

	public function __construct(){
            parent::__construct();
            //bring in vital classes
	    $this->load->library('session');
        }
       
	public function index(){
		//the method to decide greet the user and determine if the user is already logged in.
		//if the user is logged in they are sent to their homepage
		if($this->session->userdata('loggedin')){
			//the user is logged in, redirect to homepage
			$this->output->set_header("Location:/index.php/pages/home");
		}else{
			//the user is not logged in, send to register page
			$this->output->set_header("Location:/index.php/users/register");
		}
		//$this->load->view('welcome_message');
	}

	public function mail(){
		
		//send the email from the contact form in the footer
		if($this->input->post('contact_form_action')){
			if($this->input->post('contact_form_action') == 'send_email'){
				//filter the email
				if($this->input->post('no_send')){
					$this->mail_return('f3');
				}
				if($this->input->post('honey')){
					$this->mail_return('f4');
				}
				if(!$this->input->post('email')){
					$this->mail_return('f5');
				}
				if(!$this->input->post('message')){
					$this->mail_return('f6');
				}
				$email = filter_var($this->input->post('email'),FILTER_VALIDATE_EMAIL);
				if(!$email){
					$this->mail_return('f7');
				}
				if($this->input->post('message') == ''){
					$this->mail_return('f8');
				}

				//actually send the email if we are still here
				$to = 'rdarling42@gmail.com';
				$from = 'service@frugaldevelopment.com';
				$subject = "Contact from divlov contact form";
				$message = "Contact from DivLov!\r\n";
				$message .= "Email given: {$email}\r\n";
				$message .= "Message given".htmlspecialchars($this->input->post('message'))."\r\n";
				$message .= "Please respond back from hihearts.com email address";

				$send = mail($to,$from,$message,'FROM:'.$from);

				if(!$send){
					$this->mail_return('f9');
				}else{
					$this->mail_return('s');//success!
				}


			}else{
				$this->mail_return('f2');
			}
		}else{
			$this->mail_return('f1');//fail 1
		}
	}

	private function mail_return($response){
		//set the response message and head back to the contact form 
		switch ($response) {
			case 'f1':
				$message = '<div class="error">Sorry, this page can not be accessed directly.</div>';
				break;

			case 'f2':
				$message = '<div class="error">Sorry, do not try to access this page directly.</div>';
				break;
			case 'f3':
				$message = '<div class="error">Hum..you might be trying to spam us.</div>';
				break;
			case 'f4':
				$message = '<div class="error">We do not like spam.</div>';
				break;
			case 'f5':
				$message = '<div class="warning">Please make sure you include your email</div>';
				break;
			case 'f6':
				$message = '<div class="error">Hum..you might be trying to spam us.</div>';
				break;
			case 'f7':
				$message = '<div class="warning">Please make sure you are using a valid email address.</div>';
				break;
			case 'f8':
				$message = '<div class="warning">Please make sure you fill out the message box.</div>';
				break;
			case 'f9':
				$message = '<div class="error">Sorry, we were not able to send your email at this time. Please try again later.</div>';
				break;
			case 's':
				$message = '<div class="success">Thanks! Your feedback is awesome. We will contact you soon.</div>';
				break;			
			
			default:
				$message = '<div class="error">Sorry, something weird happened. Please try again later. </div>';
				break;
		}

		$this->session->set_userdata('message',$message);
		$this->output->set_header("Location:/index.php/sup/contact");

	}



}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */