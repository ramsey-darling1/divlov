<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Favorites extends CI_Controller {
//the class to handle the displaying of pages as a user navigates through the site.
			
	

	public function __construct(){
        parent::__construct();
		$this->load->model('User_model','',true);
    }
	
	public function add(){
		//the method to add a user to favorites
		if($this->input->post('fav_user') and $this->session->userdata('user_id')){
			//we have our username from an ajax request, this is the user who is being added to the current users favorites list
			//we also have the current user's id
			$add_fav = $this->User_model->add_fav($this->session->userdata('user_id'),$this->input->post('fav_user'));
			//this switch might not be working, it seems like it might just be returning whatever is the first case.
			switch($add_fav){
				case true:
					$resonse =  '<div class="success">Thanks! '.$this->input->post('fav_user').' was added to your favorites list successfully.</div>';
					break;
				case 'error1':
					$resonse = '<div class="error">We were not able to add that user to your favorites. Please make sure you are logged in and not trying to access a page directly that you should not.</div>';
					break;
				case 'error2':
					$resonse = '<div class="error">Sorry, we were not able to add that user to your favorites at this time. Technical error, please try again later.</div>';
					break;
				default:
					//everything worked as it should
					$resonse =  '<div class="success">Thanks! '.$this->input->post('fav_user').' was added to your favorites list successfully.</div>';
			}
			
			//set a response message
			//we are echoing the resonse directly because it's being returned by the ajax request
			echo @$resonse;
		
		}else{
			//the adjax didn't work or someone is trying to access the page directly.
			$message = '<div class="error">Sorry, this page can not be accessed directly. If you are not trying to access this page directly, then we are sorry for this unexpected error. Try signing in.</div>';
			$this->session->set_userdata('message',$message);
			$this->output->set_header("Location:/index.php");
		}
		
		
		
	}//end add
	
	public function remove(){
		//the method to remove a user from favorites
		//this method id accessed with an ajax request
		if($this->input->post('fid') and $this->session->userdata('user_id')){
			//we only need to fid to remove the fav
			$rem = $this->User_model->remove_fav($this->input->post('fid'));
			if(!$rem){
				echo '<div class="error">Sorry, we were not able to delete that user from your favorites at this time. Please try again later</div>';
			}else{
				echo '<div class="success">Thanks, user deleted succssfully from your favorites</div>';
			}
		}
	}
	
	
	
	
}

