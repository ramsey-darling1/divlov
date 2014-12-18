<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile_model extends CI_Model {
//a class to manage a users profile
//@rdarling

	public $user_id;
	public $user_details_id;

	public function __construct(){
            parent::__construct();
            //bring in vital classes
		    //$this->load->library('session');
			
    }
	
	public function set_user($user_id){
		$user_details_id = $this->db->get_where('user',array('user_id'=>$user_id));
		$res = $user_details_id->result();
		$this->user_id = $user_id;
		$this->user_details_id = $res[0]->user_details_id;
		return true;
	}
	
	public function re_details($user_id){
		//a method to return the users details for user in the profile
		$this->set_user($user_id);//grabs the user_details_id
		//grab the user details
		if(isset($this->user_details_id)){
			$details = $this->db->get_where('user_details',array('user_details_id'=>$this->user_details_id));
			if(empty($details)){
				return false;//the query didn't work
			}else{
				return $details;//return the users details
			}
		}else{
			return false;
		}
		
	}
	
	public function re_looking4($user_id){
		//a method to return what the user is looking for in the profile
		$this->set_user($user_id);//grabs the user_details_id
		//grab the user details
		if(isset($this->user_details_id)){
			$looking4 = $this->db->get_where('user_looking4',array('user_details_id'=>$this->user_details_id));
			if(empty($details)){
				return false;//the query didn't work
			}else{
				return $looking4;//return what the user is looking for
			}
		}else{
			return false;
		}
		
	}
	
	public function re_bio($user_id){
		//a method to return a users bio
		$dig = $this->db->get_where('user_bio',array('user_id' => $user_id));
		$res = $dig->result();
		if(!$res){
			return false;
		}else{
			return $res;
		}
	}
	
	
	public function edit_bio($user_id,$bio){
		//first test to see if the bio has already been created.
		$check = $this->re_bio($user_id);
		if(!$check or empty($check)){
			//the bio has not been created yet
			//create it
			$bio_action = $this->add_bio($user_id,$bio);
		}else{
			//the bio exists, so edit it
			$this->db->where('user_id',$user_id);
			$bio_action = $this->db->update('user_bio',$bio);
		}
		
		if(isset($bio_action)){
			if($bio_action == false){
				return false;
			}else{
				return true;
			}
		}else{
			return false;
		}
	}
	
	public function add_bio($user_id,$bio){
		
		$bio['user_id'] = $user_id;
		$in = $this->db->insert('user_bio',$bio);
		if(!$in){
			return false;
		}else{
			return true;
		}
	}
	
	public function re_interests($user_id){
		//a method to return a users interests
		$dig = $this->db->get_where('user_interests',array('user_id' => $user_id));
		$res = $dig->result();
		if(!$res){
			return false;
		}else{
			return $res;
		}
	}
	
	public function edit_interests($user_id,$interests){
		//first test to see if the bio has already been created.
		$check = $this->re_interests($user_id);
		if(!$check or empty($check)){
			//the interests have not been created yet
			//create them
			$interests_action = $this->add_interests($user_id,$interests);
		}else{
			//the interests exist, so edit them
			$this->db->where('user_id',$user_id);
			$interests_action = $this->db->update('user_interests',$interests);
		}
		
		if(isset($interests_action)){
			if($interests_action == false){
				return false;
			}else{
				return true;
			}
		}else{
			return false;
		}
	}
	
	public function add_interests($user_id,$interests){
		
		$interests['user_id'] = $user_id;
		$in = $this->db->insert('user_interests',$interests);
		if(!$in){
			return false;
		}else{
			return true;
		}
	}
	
	public function update_details($user_id,$details){
		
		$this->db->where('user_details_id',$user_id);
		
		$up = $this->db->update('user_details',$details);
		
		!$up ? $res = false : $res = true;
		
		return $res;
		
	}
	
	
	
}

