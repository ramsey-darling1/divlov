<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Images extends CI_Controller {
//the class to handle the displaying of pages as a user navigates through the site.
			
	
	public $user_id;
	

	public function __construct(){
            parent::__construct();
            //bring in vital classes
			$this->load->library('session');
			$this->load->model('Images_model','',true);
			
    }
	
	public function upload(){
		
		$config['upload_path'] = './assets/userimages/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size']	= '4000';
		$config['max_width']  = '1360';
		$config['max_height']  = '1360';

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload()){
			//the upload didn't work
			$message = "<div class='error'>Sorry, we were not able to upload your image at this time. Please make sure that it's not too big and that it's a valid image type.</div>";
		}else{
			//the upload was successful
			$message = "<div class='success'>Thanks, image was uploaded successfully.</div>";
			//save the image data for the user
			if($this->session->userdata('user_id')){
				$save_image = $this->Images_model->save_user_pic($this->session->userdata('user_id'),$this->upload->data());
				if(!$save_image){
					$message = "<div class='error'>Sorry, we were not able to save your image. Please try again.</div>";
				}
			}else{
				$message = "<div class='error'>Sorry, you must be logged in to upload an image.</div>";
			}
		}
		
		if(isset($message)){
			$this->session->set_userdata('message',$message);
		}
		
		$this->output->set_header("Location:/index.php/pages/upload_images");
	}
	
	public function make_profile_pic($pic_id){
		//make the image the profile pic
		
		if($this->session->userdata('user_id')){
			//first unset the current profile pic, if there is one.
			$unset = $this->Images_model->unset_profile_pic($this->session->userdata('user_id'));
			//now set the new image as the profile pic
			if(isset($pic_id)){
				$set_profile_pic = $this->Images_model->set_profile_pic($this->session->userdata('user_id'),$pic_id);
				if(!$set_profile_pic){
					$message = "<div class='error'>Sorry, we were not able to update your profile pic at this time.</div>";
				}else{
					$message = "<div class='success'>Thank You! Your profile pic was updated successfully.</div>";
				}
			}else{
				$message = "<div class='warning'>Sorry, you must select a pic to update your profile pic.</div>";
			}
		}else{
			//opps, not logged in
			$message = "<div class='error'>Sorry, you must be logged in to update your profile pic.</div>";
		}
		//set the message
		if(isset($message)){
			$this->session->set_userdata('message',$message);
		}
		//head to home
		$this->output->set_header("Location:/index.php");
	}
	
	public function set_profile_bg_image($pic_id){
		
		if($this->session->userdata('user_id')){
			//first unset the current bg profile pic, if there is one.
			$unset = $this->Images_model->unset_profile_pic_background($this->session->userdata('user_id'));
			//now set the new image as the profile bg pic
			if(isset($pic_id)){
				$set_profile_pic = $this->Images_model->set_profile_pic_background($this->session->userdata('user_id'),$pic_id);
				if(!$set_profile_pic){
					$message = "<div class='error'>Sorry, we were not able to update your profile pic background at this time.</div>";
				}else{
					$message = "<div class='success'>Thank You! Your profile pic background was updated successfully.</div>";
				}
			}else{
				$message = "<div class='warning'>Sorry, you must select a pic to update your profile pic background.</div>";
			}
		}else{
			//opps, not logged in
			$message = "<div class='error'>Sorry, you must be logged in to update your profile pic background.</div>";
		}
		//set the message
		if(isset($message)){
			$this->session->set_userdata('message',$message);
		}
		//head to profile
		$this->output->set_header("Location:/index.php/pages/profile/");
		
	}
	
	
	public function delete_pic($pic_id){
		
		$del = $this->Images_model->delete_pic($pic_id);
		
		if(!$del){
			$message = "<div class='error'>Sorry, we were not able to delete your image at this time.</div>";
		}else{
			$message = "<div class='success'>Thanks, we deleted that image.</div>";
		}
		
		if(isset($message)){
			$this->session->set_userdata('message',$message);
		}
		
		$this->output->set_header("Location:/index.php/pages/upload_images/");
		
	}
	

	
	
}

