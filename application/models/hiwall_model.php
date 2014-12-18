<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hiwall_model extends CI_Model {
//@rdarling

	
	public function __construct(){
            parent::__construct();
            //bring in vital classes
		    //$this->load->library('session');
    }
	
	public function new_hipost($new_hipost_data){
		//save a new post
		$in = $this->db->insert('hiwall',$new_hipost_data);
		if(!$in){
			return false;
		}else{
			return true;
		}
	}
	
	public function re_hiposts(){
		//grab all of a user's blog posts and return them
		
		$this->load->model('User_model','',true);//grab the user model so we can use a method that we need

		//start the query
		$this->db->order_by("pid", "desc");
		$dig = $this->db->get('hiwall'); 
		foreach($dig->result() as $hipost){
			$username = $this->User_model->re_username($hipost->user_id);//grab each user's username
			$hipost->username = $username;
			$hiposts[] =  $hipost;
		}
		
		if(isset($hiposts)){
			return $hiposts;
		}else{
			return false;
		}
	}
	
}

