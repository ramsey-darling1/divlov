<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hiwall extends CI_Controller {
//the class to handle the displaying of pages as a user navigates through the site.
			
	
	public $user_id;

	public function __construct(){
            parent::__construct();
            //bring in vital classes
			$this->load->library('session');
			$this->load->model('Hiwall_model','',true);
			if($this->session->userdata('user_id')){
				//we have all the information we need at this point
				$this->user_id = $this->session->userdata('user_id');
			}else{
				//send them back to the welcome screen with an error message
				$message = "<div class='error'>Sorry, there was an unexpected error</div>";
				$this->session->set_userdata('message',$message);
				$this->output->set_header("Location:/index.php");
			}
			
        }
	
	public function new_hipost(){
		//create a new post
		if($this->input->post('hipost')){
			$new_hipost_data = array(
						    'user_id' => $this->user_id,
						    'hipost' => $this->input->post('hipost'),
						    'date_posted' => time(),
						);
			$new_hipost = $this->Hiwall_model->new_hipost($new_hipost_data);
			if(!$new_hipost){
				//it didn't work
				$message = "<div class='error'>Sorry, we were not able to save your Hipost at this time.</div>";	
			}else{
				$message = "<div class='success'>Thank you, your Hipost was successful.</div>";
			}
		}else{
			$message = "<div class='warning'>You can't leave the Hipost body blank.</div>";
		}
		
		if(isset($message)){
			$this->session->set_userdata('message',$message);
		}
		
		$this->output->set_header("Location:/index.php/pages/hiwall");
	}

	
}

