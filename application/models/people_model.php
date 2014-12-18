<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class People_model extends CI_Model {
//a class to help users search for people
//@rdarling

	public $looking4;
    public $people;

	public function __construct(){
            parent::__construct();
            //bring in vital classes
		    $this->load->library('session');
    }
	
	public function re_looking4(){
		if(isset($this->looking4)){
			$res = $this->looking4;
		}else{
			$res = false;
		}
		
		return $res;
	}
	
    public function re_people($user_details_id){
        //a method to search for users and return the users that the current user wants to see.
        $this->re_user_looking4($user_details_id);//grab what the current user is looking for
		
        if(!$this->looking4){
            $error = 'error1';
        }else{
            //map out what the user is looking for and search for people
            
			$search = $this->search_people();
            
			if(!$search){
				$error = 'error2';
			}
			
        }
		
		//by now, the property people should be set
		if(isset($this->people)){
			
			$res = $this->people;//we successfully returned all the users
		
		}elseif(isset($error)){
		
			$res = $error;//something bad happened
		
		}else{
		
			$res = 'error3';//something impossible happened
		
		}
		
		return $res;
		
    }
	
	public function re_people_custom($post_data){
        //a method to search for users and return the users that the current user wants to see.
        
		$search = $this->search_people_custom($post_data);	
    
		
		//by now, the property people should be set
		if(isset($this->people)){
			
			$res = $this->people;//we successfully returned all the users
		
		}else{
		
			$res = 'error3';
		
		}
		
		return $res;
		
    }
    
    public function re_user_looking4($user_details_id){
        //a method to return what the current user is looking for
        $dig = $this->db->get_where('user_looking4',array('user_details_id' => $user_details_id));
        $res = $dig->result();
		
        if(!$res){
        
		    $res =  false;
        
		}else{
        
		    $this->looking4 = $res;//put what the user is looking for into a global property
			
			$res = true;
        }
		
		return $res;
    }
    
    private function search_people(){
		//this method will never be called unless $this->looking4 is already set.
		if(isset($this->looking4)){
			
			//start the massive task of digging for people
			
			switch($this->looking4[0]->gender){
				//search by desired gender
				case 'female':
					$this->db->where('gender','female');
					break;
				case 'male':
					$this->db->where('gender','male');
					break;
			}
			switch($this->looking4[0]->orientation){
				case 'lesbian':
					$this->db->where('orientation','lesbian');
					break;
				case 'gay':
					$this->db->where('orientation','gay');
					break;
				case 'bi':
					$this->db->where('orientation','bi');
					break;
				case 'straight':
					$this->db->where('orientation','straight');
					break;
				case 'transgender':
					$this->db->where('orientation','transgender');
					break;
			}
			switch($this->looking4[0]->status){
				case 'poly':
					$this->db->where('relationship_status','poly');
					break;
				case 'single':
					$this->db->where('relationship_status','single');
					break;
				case 'dating':
					$this->db->where('relationship_status','dating');
					break;
				case 'married':
					$this->db->where('relationship_status','married');
					break;
			}
			$dig = $this->db->get('user_details');

			//now that the query is set up, loop through and grab all the people
			foreach($dig->result() as $person){
				$people[] = $person->user_details_id;
			}


			//now we have to stupidly clear out code igniters db connection, without doing this the where statements from above don't go away. this is stupid. lol
			//$dig = $this->db->get('user_details');//this does nothing functional, but it resets the database connection
			
			if(isset($people)){
				if(!empty($people)){
			
					$this->people = $people;
					$res = true;
			
				}else{
					$res = false;//the query was run but with no results
				}
			
			}else{
				$res = false;//the var people was not set
			}
			
		}else{
			$res = false;//$this->looking4 was not set
		}
		
		return $res;
	}//end search people method
	
	public function search_people_custom($data){
		//start digging for people
			
		switch($data['gender']){
			//search by desired gender
			case 'female':
				$this->db->where('gender','female');
				break;
			case 'male':
				$this->db->where('gender','male');
				break;
		}
		
		switch($data['orientation']){
			case 'lesbian':
				$this->db->where('orientation','lesbian');
				break;
			case 'gay':
				$this->db->where('orientation','gay');
				break;
			case 'bi':
				$this->db->where('orientation','bi');
				break;
			case 'straight':
				$this->db->where('orientation','straight');
				break;
			case 'transgender':
				$this->db->where('orientation','transgender');
				break;
		}
		
		switch($data['status']){
			case 'poly':
				$this->db->where('relationship_status','poly');
				break;
			case 'single':
				$this->db->where('relationship_status','single');
				break;
			case 'dating':
				$this->db->where('relationship_status','dating');
				break;
			case 'married':
				$this->db->where('relationship_status','married');
				break;
		}
			$dig = $this->db->get('user_details');

			//now that the query is set up, loop through and grab all the people
			foreach($dig->result() as $person){
				$people[] = $person->user_details_id;
			}


			//now we have to stupidly clear out code igniters db connection, without doing this the where statements from above don't go away. this is stupid. lol
			//$dig = $this->db->get('user_details');//this does nothing functional, but it resets the database connection
			
			
		if(!empty($people)){
	
			$this->people = $people;
			$res = true;
	
		}else{
			$res = false;//the query was run but with no results
		}
			
		
		return $res;
	}//end search people custom method
	
	
	
}//end people_model class

