<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Messaging extends CI_Controller {
//the class to handle the displaying of pages as a user navigates through the site.
			
	
	public $user_id;
	public $re_des;

	public function __construct(){
            parent::__construct();
            
			$this->load->library('session');
			
			if($this->input->post('re_des')){
				//this is the return path, where the user was when they sent the message
				$this->re_des = $this->input->post('re_des');
			}
			
			if($this->session->userdata('user_id')){
			
				$this->user_id = $this->session->userdata('user_id');
			
			}else{
			
				//send them back to the welcome screen with an error message
				$message = "<div class='error'>Sorry, there was an unexpected error</div>";
				$this->session->set_userdata('message',$message);
				$this->output->set_header("Location:/index.php");
			
			}
			
			$this->load->model('User_model','',true);
			
			
    }
	
	public function send_message(){
		//a method to send a message to a user
		if($this->input->post('to') and $this->input->post('message')){
			//first check the the username exists
			$does_username_exists = $this->User_model->is_username_unique($this->input->post('to'));//returns true if the username exists
			
			if($does_username_exists){
			
				//the username does exists!
				//send the message
				$send_message = $this->User_model->send_message($this->input->post('to'),$this->input->post('subject'),$this->input->post('message'),$this->user_id);
				
				if($send_message){
					//it worked!
				    
					//send email notification to recipiant that they got a new message
					
					$to = $this->User_model->re_email_from_username($this->input->post('to'));
					
					$from = $this->User_model->re_username($this->user_id);
					
					$this->User_model->send_notification_email($to,$from,'message');
					
					//set the response message for the user
					$message = "<div class='success'>Thank you! Your message was sent successfully.</div>";
				
				}else{
				
					$message = "<div class='error'>Sorry, we were not able to send your message at this time.</div>";
				
				}
			
			}else{
			
				//the username does not exist
				$message = "<div class='error'>Sorry, that username does not exist.</div>";	
			}
			
		}else{
			//say that a message needs to have all the information
			$message = "<div class='warning'>Sorry, your message was not able to be sent. Please make sure you are not trying to send a blank message</div>";
			
		}
		
		if(isset($message)){
			//set the message
			$this->session->set_userdata('message',$message);
		}
		
		//head back
		if(isset($this->re_des)){
			$this->output->set_header("Location:{$this->re_des}");
		}else{
			//just head home because for some reason we don't have the return destination
			$this->output->set_header("Location:/index.php");
		}
		
	}
	
	public function read_message($mid){
		//a method to display the message
		if(isset($mid)){
			//first update the message to reflect that it's being read
			$this->User_model->message_is_read($mid);
			//now get the message
			$data['mess'] = $this->User_model->re_message($mid);
			$data['username'] = $this->User_model->re_username($this->user_id);//grab the username
			$data['mod'] =& $this->User_model;//passing a reference to the model into the view
			$this->load->view('elements/header',$data);	
			$this->load->view('pages/read_message',$data);
			$this->load->view('elements/footer');
		}else{
			$message = "<div class='warning'>Sorry, we can't find that message.</div>";
		}
		
	}
	
	public function delete_messages(){
		
		//a method to render messages inactive
		if($this->input->post('mess_del')){
			//loop through and update each message as inactive
			foreach($this->input->post('mess_del') as $mid){
				$up_del = $this->User_model->del_message($mid);
				if(!$up_del){
					$message = "<div class='error'>Sorry, we were not able to delete your message at this time. Please try again later.</div>";		
				}else{
					$message = "<div class='success'>Thank you, message deleted successfully.</div>";		
				}
			}
		}else{
			$message = "<div class='warning'>Sorry, you must select at least one message to delete.</div>";
		}
		
		if(isset($message)){
			$this->session->set_userdata('message',$message);
		}
		
		$this->output->set_header("Location:/index.php/pages/messaging");
		
	}
	
	public function response(){
	    //send a response from the hiwall to a user
	    if($this->input->post('to_id') and $this->input->post('response')){
		//we have the data we need
		$subject = "A response from your Hipost";
		$send_reponse = $this->User_model->send_response($this->input->post('to_id'),$subject,$this->input->post('response'),$this->user_id);
		if(!$send_reponse){
		   $message = "<div class='error'>Sorry, we were not able to send your response at this time.</div>";
		}else{
			
			//send email notification to recipiant that they got a new message
					
			$to = $this->User_model->re_user_email($this->input->post('to_id'));
					
			$from = $this->User_model->re_username($this->user_id);
					
			$this->User_model->send_notification_email($to,$from,'divlov_wall_response');
			
		    $message = "<div class='success'>Thank you! Your response was sent successfully.</div>";
		}
	    }else{
		//can't send blank responses
		$message = "<div class='warning'>Sorry, you can't send blank responses.</div>";
	    }
	    
	    if(isset($message)){
		$this->session->set_userdata('message',$message);
	    }
		
	    $this->output->set_header("Location:/index.php/pages/hiwall");
		
	}
	
	
	
}

