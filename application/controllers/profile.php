<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {
//the class to handle the displaying of pages as a user navigates through the site.
			
	
	public $user_id;
	public $response;

	public function __construct(){
            parent::__construct();
            //bring in vital classes
			$this->load->library('session');
			$this->load->model('Profile_model','',true);
			$this->load->model('User_model','',true);
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
	
	public function edit_details(){
        //a method to display the form to edit a bio
		
		$data['details'] = $this->User_model->re_details($this->user_id);
		
		$data['looking4'] = $this->User_model->re_looking4($this->user_id);
		
		$this->views_handler('edit/details',$data);
		
    }
	
	public function edit_details_action(){
		//a method to save changes made to a users bio
		if($this->input->post('edit_details')){
			
			$details = array(
						'orientation' => $this->input->post('orientation'),
						'relationship_status' => $this->input->post('relationship_status'),
						'age' => $this->input->post('age'),
						'state' => $this->input->post('state'),
						'city' => $this->input->post('city'),
						'gender' => $this->input->post('gender')
						 );
		
			$up = $this->Profile_model->update_details($this->user_id,$details);
		
			if(!$up){
		
				$this->response('Sorry, we were not able to save any changes to your details at this time.','error');
		
			}else{
		
				$this->response('Thank you! Your details were updated.','success');
		
			}
			
		}else{
			
			$this->response('Nothing changed.','warning');
		
		}
		
		$this->set_response_message();//set the response message
		$this->output->set_header("Location:/index.php/pages/profile");//head to the users profile page
	}
	
	public function edit_bio(){
        //a method to display the form to edit a bio
		//grab the current bio
		//$data['username'] = $this->User_model->re_username($this->user_id);//grab the username
		$data['bio'] = $this->Profile_model->re_bio($this->user_id);
		$this->views_handler('edit/bio',$data);
    }
	
	public function edit_bio_action(){
		//a method to save changes made to a users bio
		if($this->input->post('bio')){
			$bio = array(
						'bio' => $this->input->post('bio'),
						'date_edit' => time()
						 );
			$up = $this->Profile_model->edit_bio($this->user_id,$bio);
			if(!$up){
				$this->response('Sorry, we were not able to save any changes to your bio at this time.','error');
			}else{
				$this->response('Thank you! Your bio was updated.','success');
			}
		}else{
			$this->response('Sorry, no blank bios allowed','warning');
		}
		
		$this->set_response_message();//set the response message
		$this->output->set_header("Location:/index.php/pages/profile");//head to the users profile page
	}
	
	public function edit_interests(){
		//displays a form that allows the user to edit their interests
		$data['interests'] = $this->Profile_model->re_interests($this->user_id);
		$this->views_handler('edit/interests',$data);
	}
	
	public function edit_interests_action(){
		//a method to save changes made to a users interests
		if($this->input->post('interests')){
			$interests = array(
						'interests' => $this->input->post('interests'),
						'date_edited' => time()
						 );
			$up = $this->Profile_model->edit_interests($this->user_id,$interests);
			if(!$up){
				$this->response('Sorry, we were not able to save any changes to your interests at this time.','error');
			}else{
				$this->response('Thank you! Your interests where updated.','success');
			}
		}else{
			$this->response('Sorry, no blank interests allowed','warning');
		}
		
		$this->set_response_message();//set the response message
		$this->output->set_header("Location:/index.php/pages/profile");//head to the users profile page
	}
	
	public function views_handler($page,$data=null){
		//a method to load the required views
		$this->load->view('elements/header',$data);	
		$this->load->view($page,$data);
		$this->load->view('elements/footer');
	}
	
	public function response($message,$type){
		//the method that prepares the response message
		$this->response = '<div class="'.$type.'">'.$message.'</div>';
	}
	
	public function set_response_message(){
		//the message that sets the response message for the user
		if(isset($this->response)){
			$this->session->set_userdata('message',$this->response);
		}else{
			$this->session->set_userdata('message','<div class="warning">Sorry, we were not able to display the correct response message to you. Technical Error.</div>');
		}
	}

	
}

