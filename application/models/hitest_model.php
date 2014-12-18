<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hitest_model extends CI_Model {
//@rdarling

	
	public function __construct(){
            parent::__construct();
            //bring in vital classes
		    //$this->load->library('session');
    }
	
	public function add_quest($user_id,$quest){
		//a method to save a users custom question
		$quest['user_id'] = $user_id; //add the user_id to the array, the data has already been confirmed
		$in = $this->db->insert('hitest',$quest);
		if(!$in){
			return false;
		}else{
			return true;	
		}
	}
	
	public function re_questions($user_id){
		//a method to grab all of a users questions
		$dig = $this->db->get_where('hitest',array('user_id'=>$user_id,'active'=>1));
		foreach($dig->result() as $quest){
			$questions[] = $quest;
		}
		if(isset($questions)){
			return $questions;
		}else{
			return false;
		}
	}
	
	public function save_results($user_id,$hitest_owner_id,$res,$correct,$percent){
		//a method to save results of a hitest
		//create a res_id
		$res_id = 'res'.uniqid(time());
		$score_data = array(
						'res_id' => $res_id,
						'user_asking_id' => $hitest_owner_id,
						'user_testing_id' => $user_id,
						'score' => $correct,
						'percent' => $percent
							);
		$in = $this->db->insert('hitest_score',$score_data);//right now, we are not going to worry about what happens if this doesn't save. 
		
		if(!empty($res)){
			foreach($res as $r){
				$result_data = array(
						'res_id' => $res_id,
						'qid' => $r['qid'],
						'ans' => $r['ans']
							 );
				$this->db->insert('hitest_results',$result_data);//right now we are not going to worry about if this doesn't save
			}	
		}//right now, wer are not going to worry about doing anything if this empty
		
		return true;
	}
	
	
}

