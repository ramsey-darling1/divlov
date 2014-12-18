<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {
//the class to users and how they interact with the database
//@rdarling

	public $user_id;
	public $user_details_id;

	public function __construct(){
            parent::__construct();
            //bring in vital classes
		    $this->load->library('session');
    }
	
	public function is_username_unique($username){
		//check to see if a username exists, return true if it does, false if it doesn't
		$dig = $this->db->get_where('user',array('username'=>$username));
		$res = $dig->result();
		if(!$dig or !$res or empty($res)){
			return false;//it doesn't exist
		}else{
			return true;//it does exist
		}

	}
	
	public function create_new_tmp_user($tmp_user_data,$tmp_user_details){
		//save new user data temporarily
		$in = $this->db->insert('tmp_reg',$tmp_user_data);
		$in2 = $this->db->insert('tmp_details',$tmp_user_details);
		return true;//this is going on behind the scenes, so no need to send any responses or anything
	}
	
	public function grab_tmp_user_details_id($user_id){
		$dig = $this->db->get_where('tmp_reg',array('user_id'=>$user_id));
		$res = $dig->result();
		$tmp_details_id = $res[0]->tmp_details_id;
		return $tmp_details_id;
	}
	
	public function update_tmp_details($tmp_details_id,$tmp_details){
		$this->db->where('tmp_details_id',$tmp_details_id);
		$up = $this->db->update('tmp_details',$tmp_details);
		return true;//behind the scenes, so just return true
	}
	
	public function save_tmp_couple($tmp_couple){
		//a method to temp save data if user is signing up as a couple
		$in = $this->db->insert('tmp_couple',$tmp_couple);
		return true;
	}
	
	public function save_looking4($tmp_details_id,$seeking){
		//a method to save the last details, what the user is seeking
		$in = $this->db->insert('tmp_looking4',$seeking);
		return true;
	}
	
	public function new_user($user_id){
		//the main method to create a new user
		//grab all data associated with the user account from the tmp tables
		$dig_user_data = $this->db->get_where('tmp_reg',array('user_id'=>$user_id));
		$res_user_data = $dig_user_data->result();
		
		$tmp_details_id = $res_user_data[0]->tmp_details_id;
		
		$dig_user_details = $this->db->get_where('tmp_details',array('tmp_details_id'=>$tmp_details_id));
		$res_user_details = $dig_user_details->result();
		
		$dig_user_couple = $this->db->get_where('tmp_couple',array('tmp_details_id'=>$tmp_details_id));
		$res_user_couple = $dig_user_couple->result();
		
		$dig_user_looking4 = $this->db->get_where('tmp_looking4',array('tmp_details_id'=>$tmp_details_id));
		$res_user_looking4 = $dig_user_looking4->result();
		
		//now that all the data has been gather, insert it into the real tables
		//first the user data
		$user_data = array(
						'user_id' =>$user_id,
						'username' => $res_user_details[0]->username,
						'password' => $res_user_data[0]->tmp_password,
						'date_created' => time(),
						'user_details_id' => $tmp_details_id,
						'active' => 1
						   );
		$in = $this->db->insert('user',$user_data);
		if(!$in){
			//this is a major error, the new account was not able to be created at all, so return here 
			return 'error1';
		}else{
			//save the user details
			$user_details = array(
								'user_details_id' => $tmp_details_id,
								'email' => $res_user_details[0]->email,
								'orientation' => $res_user_details[0]->orientation,
								'gender' => $res_user_details[0]->gender,
								'relationship_status' => $res_user_details[0]->relationship_status,
								'age' => $res_user_details[0]->age,
								'city' => $res_user_details[0]->city,
								'state' => $res_user_details[0]->state
								  );
			//add a flag if the user is registering as a couple
			if(!empty($res_user_couple)){
				$user_details['couple'] = 1;
			}

			$in2 = $this->db->insert('user_details',$user_details);
			if(!$in2){
				//this is not as bad of an error, the account can still be created, just the user's details will not be saved
				$error = 'error2';
			}else{
				//save what the user is looking for
				$user_looking4 = array(
									'user_details_id' => $tmp_details_id,
									'gender' => $res_user_looking4[0]->gender,
									'orientation' => $res_user_looking4[0]->orientation,
									'age' => $res_user_looking4[0]->age,
									'age2' => $res_user_looking4[0]->age2,
									'status' => $res_user_looking4[0]->status,
									'looking_for' => $res_user_looking4[0]->looking_for,
									'alternatives' => $res_user_looking4[0]->alternatives
									   );
				$in3 = $this->db->insert('user_looking4',$user_looking4);
				if(!$in3){
					//what the user is looking for was not saved
					$error = 'error3';
				}
				if(!empty($res_user_couple)){
					//the user is registering as a couple, so save the couple data
					$user_couple = array(
										'user_details_id' => $tmp_details_id,
										'gender' => $res_user_couple[0]->gender,
										'age' => $res_user_couple[0]->age,
										'orientation' => $res_user_couple[0]->orientation,
										 );
					$in4 = $this->db->insert('user_couple',$user_couple);
					if(!$in4){
						$error = 'error4';
					}
				}
			}
			
			if(isset($error)){
				//an error happened so the response is already set
				return $error;
			}else{
				//everything went awesomely
				return 'success';
			}
		}
		
	}//end new_user method
	
	public function re_username($user_id){
		//a method to return the username based on the user_id
		$dig = $this->db->get_where('user',array('user_id'=>$user_id));
		$res = $dig->result();
		$username = @$res[0]->username;
		return $username;
	}
	
	public function delete_tmp_data($user_id){
		//remove the tmp data after having created a new user
		$this->db->where('user_id', $user_id);
		$this->db->delete('tmp_reg');
		
		$this->db->where('tmp_details_id', $user_id);
		$this->db->delete('tmp_details');
		
		$this->db->where('tmp_details_id', $user_id);
		$this->db->delete('tmp_looking4');
		
		$this->db->where('tmp_details_id', $user_id);
		$this->db->delete('tmp_couple');
		
		return true;
	}
	
	public function login_user($username,$password){
		//a method to see if a username exists, if the password is right and if it is, return the user_id
		$dig = $this->db->get_where('user',array('username'=>$username));
		if(!$dig){
			//doesn't exist
			return false;
		}else{
			$res = $dig->result();
			if(empty($res)){
				//no result
				return false;
			}else{
				//the username exists, test the password
				$pass = $this->encrypt->decode($res[0]->password);
				if($pass == $password){
					//the passwords match, the user can log in
					return $res[0]->user_id;
				}else{
					//the passwords do not match
					return false;
				}
			}
		}
	}
	
	public function re_details($user_id){
		//a method to return the users details for user in the profile
		$this->set_user($user_id);//grabs the user_details_id
		//grab the user details
		
		if(isset($this->user_details_id)){
			$details = $this->db->get_where('user_details',array('user_details_id'=>$this->user_details_id));
			$res = $details->result();
			if(empty($details)){
				return false;//the query didn't work
			}else{
				return $res;//return the users details
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
			$res = $looking4->result();
			if(empty($res)){
				return false;//the query didn't work
			}else{
				return $res;//return what the user is looking for
			}
		}else{
			return false;
		}
		
	}
	
	public function set_user($user_id){
		$user_details_id = $this->db->get_where('user',array('user_id'=>$user_id));
		$res = $user_details_id->result();
		$this->user_id = $user_id;
		$this->user_details_id = @$res[0]->user_details_id;
		return true;
	}
	
	public function send_message($to,$subject,$message,$from){
		//send a message to a user
		//$to is a username, so grab the user_id
		$this->set_user_id_from_username($to);
		if(isset($this->user_id)){
			//the username was found and we have a user id
			$message = array(
						'from_id' => $from,
						'to_id' => $this->user_id,
						'date_sent' => time(),
						'date_read' => null,
						'active' => 1,
						'unread' => 1,
						'message' => $message,
						'message_subject' => $subject
							 );
			$in = $this->db->insert('message',$message);
			if(!$in){
				//it failed to save
				return false;
			}else{
				//it worked!
				return true;
			}
		}else{
			return false;
		}
	}
	
	public function set_user_id_from_username($username){
		//a method to set the user_id from a username
		$dig = $this->db->get_where('user',array('username'=>$username));
		$res = $dig->result();
		if(isset($res[0]->user_id)){
			$this->user_id = $res[0]->user_id;
			return true;
		}else{
			return false;
		}
	}
	
	public function re_messages($user_id){
		//a method to return a users messages
		$this->db->order_by("mid", "desc");
		$dig = $this->db->get_where('message',array('to_id'=>$user_id));
		foreach($dig->result() as $message){
			
			if($message->active == 1){
				$messages[] = $message;	
			}
		}
		
		if(isset($messages)){
			if(!empty($messages)){
				return $messages;
			}else{
				return false;//no messages
			}
		}else{
			return false;//no messages
		}
	}
	
	public function re_message($mid){
		//a method to return one message
		$dig = $this->db->get_where('message',array('mid'=>$mid));
		$res = $dig->result();
		if(!$res or empty($res)){
			return false;
		}else{
			return $res;
		}
	}
	
	public function message_is_read($mid){
		//a method to show that a message has been read
		$up = array('unread'=>0);
		$this->db->where('mid',$mid);
		$this->db->update('message',$up);
		return true;//this happens behind the scenes so no need for responses
	}
	
	public function del_message($mid){
		//a method to delete a message
		$del = array('active'=>0);
		$this->db->where('mid',$mid);
		$up = $this->db->update('message',$del);
		if(!$up){
			return false;
		}else{
			return true;
		}
	}
	
	public function re_profile_pic($user_id){
		//a method to return the profile pic
		$dig = $this->db->select('pic_id');
		$dig = $this->db->where('user_id',$user_id);
		$dig = $this->db->where('is_profile_pic',1);
		$dig = $this->db->get('user_pics');
		$res = $dig->result();
		if(!empty($res)){
			if(isset($res[0]->pic_id)){
				$dig2 = $this->db->get_where('user_pic_data',array('pic_id'=>$res[0]->pic_id));
				$res2 = $dig2->result();
				if(!$res2){
					return false;
				}else{
					//it worked! return an array of all the pic info
					return $res2;
				}
			}else{
				//there is no profile pic set
				return false;
			}
		}else{
			//there is no profile pic set
			return false;
		}

	}
	
	public function re_user_id($username){
		// a simple method to return a user_id
		$this->set_user_id_from_username($username);
		if(isset($this->user_id)){
			return $this->user_id;
		}else{
			return false;
		}
	}
	
	public function send_response($to,$subject,$message,$from){
		//save a response
			//the username was found and we have a user id
			$message = array(
					    'from_id' => $from,
					    'to_id' => $to,
					    'date_sent' => time(),
					    'date_read' => null,
					    'active' => 1,
					    'unread' => 1,
					    'message' => $message,
					    'message_subject' => $subject
					);
			$in = $this->db->insert('message',$message);
			if(!$in){
				//it failed to save
				return false;
			}else{
				//it worked!
				return true;
			}
		
	}
	
	public function random_user_id(){
	    //return a random user_id from valid user_ids
	    $dig = $this->db->get_where('user',array('active'=>'1'));
	    foreach($dig->result() as $user){
			$user_ids[] = $user->user_id;//create an array of all user ids
	    }
	    //randomly pick a user_id from the array and return it.
		$user_id_key = array_rand($user_ids,1);
		if(isset($user_ids[$user_id_key])){
			return $user_ids[$user_id_key];
		}else{
			return false;
		}
	}
	
	public function re_slideshow_users(){
		//return random users for the homepage slideshow.
		$dig = $this->db->get_where('user',array('active'=>'1'));
		foreach($dig->result() as $user){
			//loop through and grab all users
			//put all the user_ids into an array
			$user_ids[] = $user->user_id;
		}
		
		//randomly grab 8 users
		$users8 = @array_rand($user_ids,8);
		
		//create a master array of 8 users
		$theUsers = array(
						'u1' => array('user_id' => $user_ids[$users8[0]]),
						'u2' => array('user_id' => $user_ids[$users8[1]]),
						'u3' => array('user_id' => $user_ids[$users8[2]]),
						'u4' => array('user_id' => $user_ids[$users8[3]]),
						'u5' => array('user_id' => $user_ids[$users8[4]]),
						'u6' => array('user_id' => $user_ids[$users8[5]]),
						'u7' => array('user_id' => $user_ids[$users8[6]]),
						'u8' => array('user_id' => $user_ids[$users8[7]]),
						  );
		
		
		
		//grab the profile pic for each user
		
		if(isset($theUsers['u1']['user_id'])){
			$pic_id1 = $this->db->select('pic_id');
			$pic_id1 = $this->db->where('user_id',$theUsers['u1']['user_id']);//use the key to grab a user id from the array of user ids
			$pic_id1 = $this->db->where('is_profile_pic',1);
			$pic_id1 = $this->db->get('user_pics');
			$theUsers['u1']['pic_id'] = $pic_id1->result();//adds pic id to master array
		}
		
		if(isset($theUsers['u2']['user_id'])){
			$pic_id2 = $this->db->select('pic_id');
			$pic_id2 = $this->db->where('user_id',$theUsers['u2']['user_id']);//use the key to grab a user id from the array of user ids
			$pic_id2 = $this->db->where('is_profile_pic',1);
			$pic_id2 = $this->db->get('user_pics');
			$theUsers['u2']['pic_id'] = $pic_id2->result();//adds pic id to master array
		}
		
		if(isset($theUsers['u3']['user_id'])){
			$pic_id3 = $this->db->select('pic_id');
			$pic_id3 = $this->db->where('user_id',$theUsers['u3']['user_id']);//use the key to grab a user id from the array of user ids
			$pic_id3 = $this->db->where('is_profile_pic',1);
			$pic_id3 = $this->db->get('user_pics');
			$theUsers['u3']['pic_id'] = $pic_id3->result();//adds pic id to master array
		}
		
		if(isset($theUsers['u4']['user_id'])){
			$pic_id4 = $this->db->select('pic_id');
			$pic_id4 = $this->db->where('user_id',$theUsers['u4']['user_id']);//use the key to grab a user id from the array of user ids
			$pic_id4 = $this->db->where('is_profile_pic',1);
			$pic_id4 = $this->db->get('user_pics');
			$theUsers['u4']['pic_id'] = $pic_id4->result();//adds pic id to master array
		}
		
		if(isset($theUsers['u5']['user_id'])){
			$pic_id5 = $this->db->select('pic_id');
			$pic_id5 = $this->db->where('user_id',$theUsers['u5']['user_id']);//use the key to grab a user id from the array of user ids
			$pic_id5 = $this->db->where('is_profile_pic',1);
			$pic_id5 = $this->db->get('user_pics');
			$theUsers['u5']['pic_id'] = $pic_id5->result();//adds pic id to master array
		}
		
		if(isset($theUsers['u6']['user_id'])){
			$pic_id6 = $this->db->select('pic_id');
			$pic_id6 = $this->db->where('user_id',$theUsers['u6']['user_id']);//use the key to grab a user id from the array of user ids
			$pic_id6 = $this->db->where('is_profile_pic',1);
			$pic_id6 = $this->db->get('user_pics');
			$theUsers['u6']['pic_id'] = $pic_id6->result();//adds pic id to master array
		}
		
		if(isset($theUsers['u7']['user_id'])){
			$pic_id7 = $this->db->select('pic_id');
			$pic_id7 = $this->db->where('user_id',$theUsers['u7']['user_id']);//use the key to grab a user id from the array of user ids
			$pic_id7 = $this->db->where('is_profile_pic',1);
			$pic_id7 = $this->db->get('user_pics');
			$theUsers['u7']['pic_id'] = $pic_id7->result();//adds pic id to master array
		}
		
		if(isset($theUsers['u8']['user_id'])){
			$pic_id8 = $this->db->select('pic_id');
			$pic_id8 = $this->db->where('user_id',$theUsers['u8']['user_id']);//use the key to grab a user id from the array of user ids
			$pic_id8 = $this->db->where('is_profile_pic',1);
			$pic_id8 = $this->db->get('user_pics');
			$theUsers['u8']['pic_id'] = $pic_id8->result();//adds pic id to master array
		}
		
		//now we grab the actual profile pics
		
		if(!empty($theUsers['u1']['pic_id'])){
			$pp1 = $this->db->select('raw_name');
			$pp1 = $this->db->select('image_type');
			$pp1 = $this->db->where('pic_id',$theUsers['u1']['pic_id'][0]->pic_id);
			$pp1 = $this->db->get('user_pic_data');
			$theUsers['u1']['profile_pic']= $pp1->result();//grab the actual image to return
			if(!$theUsers['u1']['profile_pic'] or $theUsers['u1']['profile_pic'] == ''){
				$theUsers['u1']['profile_pic'] = 'default';//the user doesn't have a profile pic or we were not able to grab it
			}
		}else{
			//the user doesn't have a profile pic
			$theUsers['u1']['pic_id'] = 'default';
			$theUsers['u1']['profile_pic'] = 'default';
		}
		
		if(!empty($theUsers['u2']['pic_id'])){
			$pp2 = $this->db->select('raw_name');
			$pp2 = $this->db->select('image_type');
			$pp2 = $this->db->where('pic_id',$theUsers['u2']['pic_id'][0]->pic_id);
			$pp2 = $this->db->get('user_pic_data');
			$theUsers['u2']['profile_pic']= $pp2->result();//grab the actual image to return
			if(!$theUsers['u2']['profile_pic'] or $theUsers['u2']['profile_pic'] == ''){
				$theUsers['u2']['profile_pic'] = 'default';//the user doesn't have a profile pic or we were not able to grab it
			}
		}else{
			//the user doesn't have a profile pic
			$theUsers['u2']['pic_id'] = 'default';
			$theUsers['u2']['profile_pic'] = 'default';
		}
		
		if(!empty($theUsers['u3']['pic_id'])){
			$pp3 = $this->db->select('raw_name');
			$pp3 = $this->db->select('image_type');
			$pp3 = $this->db->where('pic_id',$theUsers['u3']['pic_id'][0]->pic_id);
			$pp3 = $this->db->get('user_pic_data');
			$theUsers['u3']['profile_pic']= $pp3->result();//grab the actual image to return
			if(!$theUsers['u3']['profile_pic'] or $theUsers['u3']['profile_pic'] == ''){
				$theUsers['u3']['profile_pic'] = 'default';//the user doesn't have a profile pic or we were not able to grab it
			}
		}else{
			//the user doesn't have a profile pic
			$theUsers['u3']['pic_id'] = 'default';
			$theUsers['u3']['profile_pic'] = 'default';
		}
		
		if(!empty($theUsers['u4']['pic_id'])){
			$pp4 = $this->db->select('raw_name');
			$pp4 = $this->db->select('image_type');
			$pp4 = $this->db->where('pic_id',$theUsers['u4']['pic_id'][0]->pic_id);
			$pp4 = $this->db->get('user_pic_data');
			$theUsers['u4']['profile_pic']= $pp4->result();//grab the actual image to return
			if(!$theUsers['u4']['profile_pic'] or $theUsers['u4']['profile_pic'] == ''){
				$theUsers['u4']['profile_pic'] = 'default';//the user doesn't have a profile pic or we were not able to grab it
			}
		}else{
			//the user doesn't have a profile pic
			$theUsers['u4']['pic_id'] = 'default';
			$theUsers['u4']['profile_pic'] = 'default';
		}
		
		if(!empty($theUsers['u5']['pic_id'])){
			$pp5 = $this->db->select('raw_name');
			$pp5 = $this->db->select('image_type');
			$pp5 = $this->db->where('pic_id',$theUsers['u5']['pic_id'][0]->pic_id);
			$pp5 = $this->db->get('user_pic_data');
			$theUsers['u5']['profile_pic']= $pp5->result();//grab the actual image to return
			if(!$theUsers['u5']['profile_pic'] or $theUsers['u5']['profile_pic'] == ''){
				$theUsers['u5']['profile_pic'] = 'default';//the user doesn't have a profile pic or we were not able to grab it
			}
		}else{
			//the user doesn't have a profile pic
			$theUsers['u5']['pic_id'] = 'default';
			$theUsers['u5']['profile_pic'] = 'default';
		}
		
		if(!empty($theUsers['u6']['pic_id'])){
			$pp6 = $this->db->select('raw_name');
			$pp6 = $this->db->select('image_type');
			$pp6 = $this->db->where('pic_id',$theUsers['u6']['pic_id'][0]->pic_id);
			$pp6 = $this->db->get('user_pic_data');
			$theUsers['u6']['profile_pic']= $pp6->result();//grab the actual image to return
			if(!$theUsers['u6']['profile_pic'] or $theUsers['u1']['profile_pic'] == ''){
				$theUsers['u6']['profile_pic'] = 'default';//the user doesn't have a profile pic or we were not able to grab it
			}
		}else{
			//the user doesn't have a profile pic
			$theUsers['u6']['pic_id'] = 'default';
			$theUsers['u6']['profile_pic'] = 'default';
		}
		
		if(!empty($theUsers['u7']['pic_id'])){
			$pp7 = $this->db->select('raw_name');
			$pp7 = $this->db->select('image_type');
			$pp7 = $this->db->where('pic_id',$theUsers['u7']['pic_id'][0]->pic_id);
			$pp7 = $this->db->get('user_pic_data');
			$theUsers['u7']['profile_pic']= $pp7->result();//grab the actual image to return
			if(!$theUsers['u7']['profile_pic'] or $theUsers['u7']['profile_pic'] == ''){
				$theUsers['u7']['profile_pic'] = 'default';//the user doesn't have a profile pic or we were not able to grab it
			}
		}else{
			//the user doesn't have a profile pic
			$theUsers['u7']['pic_id'] = 'default';
			$theUsers['u7']['profile_pic'] = 'default';
		}
		
		if(!empty($theUsers['u8']['pic_id'])){
			$pp8 = $this->db->select('raw_name');
			$pp8 = $this->db->select('image_type');
			$pp8 = $this->db->where('pic_id',$theUsers['u8']['pic_id'][0]->pic_id);
			$pp8 = $this->db->get('user_pic_data');
			$theUsers['u8']['profile_pic']= $pp8->result();//grab the actual image to return
			if(!$theUsers['u8']['profile_pic'] or $theUsers['u1']['profile_pic'] == ''){
				$theUsers['u8']['profile_pic'] = 'default';//the user doesn't have a profile pic or we were not able to grab it
			}
		}else{
			//the user doesn't have a profile pic
			$theUsers['u8']['pic_id'] = 'default';
			$theUsers['u8']['profile_pic'] = 'default';
		}
		
		//grab the usernames
		if(isset($theUsers['u1']['user_id'])){
			$username1 = $this->re_username($theUsers['u1']['user_id']);
			$theUsers['u1']['username'] = $username1;//adds the username to the array
		}
		
		if(isset($theUsers['u2']['user_id'])){
			$username2 = $this->re_username($theUsers['u2']['user_id']);
			$theUsers['u2']['username'] = $username2;//adds the username to the array
		}
		
		if(isset($theUsers['u3']['user_id'])){
			$username3 = $this->re_username($theUsers['u3']['user_id']);
			$theUsers['u3']['username'] = $username3;//adds the username to the array
		}
		
		if(isset($theUsers['u4']['user_id'])){
			$username4 = $this->re_username($theUsers['u4']['user_id']);
			$theUsers['u4']['username'] = $username4;//adds the username to the array
		}
		
		if(isset($theUsers['u5']['user_id'])){
			$username5 = $this->re_username($theUsers['u5']['user_id']);
			$theUsers['u5']['username'] = $username5;//adds the username to the array
		}
		
		if(isset($theUsers['u6']['user_id'])){
			$username6 = $this->re_username($theUsers['u6']['user_id']);
			$theUsers['u6']['username'] = $username6;//adds the username to the array
		}
		
		if(isset($theUsers['u7']['user_id'])){
			$username7 = $this->re_username($theUsers['u7']['user_id']);
			$theUsers['u7']['username'] = $username7;//adds the username to the array
		}
		
		if(isset($theUsers['u8']['user_id'])){
			$username8 = $this->re_username($theUsers['u8']['user_id']);
			$theUsers['u8']['username'] = $username8;//adds the username to the array
		}
				
			
		//send back the master array
		return $theUsers;
		
	}
	
	public function re_user_email($user_id){
		//a method to return a user's email
		$dig = $this->db->get_where('user',array('user_id'=>$user_id));
		$res = $dig->result();//grab the user details id
		if(isset($res)){
			if(!empty($res[0]->user_details_id)){
				
				//grab the email with the user_details_id
				$dig_email = $this->db->get_where('user_details',array('user_details_id'=>$res[0]->user_details_id));
				$res_email = $dig_email->result();
				if(!empty($res_email[0]->email)){
					//we have the email address
					$email = $res_email[0]->email;
				}
			}
		}
		
		//return the email address if it was successful
		if(isset($email)){
			return $email;
		}else{
			return false;
		}
		
	}
	
	public function re_username_from_user_details_id($user_details_id){
		//a method to return the username based on the user_id
		$dig = $this->db->get_where('user',array('user_details_id'=>$user_details_id));
		$res = $dig->result();
		$username = $res[0]->username;
		return $username;
	}
	
	public function email_to_username($email){
		//a method to see if an email has only one username tied to it, and if so, return the username
		//we allow one person using the same email address to create multiple accounts, so long as the usernames are unique.
		//however, for security reasons, we can only return a username based on the email address if there is only one username tied to that
		//email address.
		$dig = $this->db->get_where('user_details',array('email'=>$email));
		foreach($dig->result() as $res){
			$num[] = $res;
		}
		if(isset($num)){
			if(!empty($num)){
				if(count($num) > 1){
					//there is more than one username tied to this email, we can't return the username
					$error = "error3";
				}else{
					//there is only one username tied to the email. it's safe to return it
					//grab the username from the user_details_id
					$username = $this->re_username_from_user_details_id($num[0]->user_details_id);
					if(!$username){
						//we were not able to grab the actual username from the user_details_id, even though we totally should be able to
						$error = "error5";
					}else{
						$re = true;
					}
				}
			}else{
				$error = "error2";//result didn't find anything, email is not in the system
			}
		}else{
			$error = "error1";//result didn't work at all. unkown error or email not in the system
		}
		
		//return with whatever response we have
		if(isset($error)){
			return $error;
		}elseif(isset($re) and isset($username)){
			//return the username
			return $username;
		}else{
			return 'error4';//this should never happen.
		}
		
	}
	
	public function save_reset_pass($user_id,$reset_pass_key){
		//a method to save the unique hash and user_id that will be used to reset the users password
		$reset_data = array(
						'user_id' => $user_id,
						'reset_pass_key' => $reset_pass_key,
						'created' => time()
							);
		$in = $this->db->insert('reset_pass',$reset_data);
		if(!$in){
			//opps, we won't be able to reset the password
			return false;
		}else{
			return true;
		}
	}
	
	public function comp_reset_pass_key($reset_pass_key){
		//a method to compaire the reset pass_key from the link with the one saved in the database
		//if it's valid, return a user id
		
		//see if the reset pass key is stored in the database
		$dig = $this->db->get_where('reset_pass',array('reset_pass_key'=>$reset_pass_key));
		$res = $dig->result();
		if(!empty($res)){
			//we found it!
			//make sure that it is not expired. expires in 24 hours, 86400 seconds
			$current_time = time();
			
			$time_passed = $current_time - $res[0]->created;
			if($time_passed > 86400 ){
				//it's been more than 24 hours
				return 'expired';
			}else{
				//it's all good, we can reset the password. return the user_id
				return $res[0]->user_id;
			}
			
		}else{
			return 'nopass';//return with an error code that says we could not find the reset pass key
		}
	}
	
	public function update_pass($user_id,$password){
		//update a password
		$data = array('password'=>$password);
		$this->db->where('user_id', $user_id);
		$up = $this->db->update('user', $data);
		if(!$up){
			return false;
		}else{
			return true;
		}
		
	}
	
	public function add_fav($user_id,$fav_username){
		//first we have to grab the fav's ID from their username
		$fav_user_id = $this->re_user_id($fav_username);
		if(!$fav_user_id){
			$error = "error1";//we were not able to find a user_id for that username
		}else{
			//we have the fav's ID, add it to the current user
			$fav_data = array(
							'user_id' => $user_id,
							'fav_id' => $fav_user_id,
							'date_added' => time()
							  );
			$in = $this->db->insert('favorites',$fav_data);
			if(!$in){
				$error = 'error2';//we were not able to insert the data into the database
			}else{
				
				//send email notification
				$to = $this->re_user_email($fav_user_id);
				
				$from = $this->re_username($user_id);
				
				$this->send_notification_email($to,$from,'fav');
				
			}
			
		}
		
		if(isset($error)){
			return $error;//something went wrong
		}else{
			return true;//it's all good!
		}
	}
	
	public function re_favs($user_id){
		//a method to return all the a users favorites
		$dig = $this->db->get_where('favorites',array('user_id'=>$user_id));
		foreach($dig->result() as $fav){
			$favs[] = $fav;//loop through and get everybody
		}
		if(isset($favs)){
			return $favs;
		}else{
			return false;
		}
	}
	
	public function remove_fav($fid){
		//a method to delete a user's fav from the database
		$this->db->delete('favorites',array('fid'=>$fid));
		return true;
	}

	public function re_partners_details($user_id){
		$dig = $this->db->get_where('user_couple', array('user_details_id' => $user_id));
		$res = $dig->result();
		return $res;
	}
	
	public function count_new_messages($user_id){
		//this method returns the number of new messages that a user has.
		$this->db->where('to_id',$user_id);
		$this->db->where('active',1);
		$this->db->where('unread',1);
		$dig = $this->db->get('message');
		foreach($dig->result() as $message){
				$messages[] = $message;
		}
		
		!empty($messages) ? $num = count($messages) : $num = false;
		
		return $num;
	}
	
	public function send_notification_email($to,$from,$type){
		//this method will send an email to a user notifying them of something happening on the site.
		
		switch($type){
			case 'message':
				$message = 'Awesome! You recieved a new message from '.$from.'.';
				break;
			case 'divlov_wall_response':
				$message = $from.' responded to your DivLov Wall post. Fun!';
				break;
			case 'fav':
				$message = 'Congratulations! '.$from.' favored you.';
				break;
			case 'comment':
				$message = 'Huzzah! '.$from.' commented on your blog post.';
				break;
		}
		
		$message .= ' Sincerely, your friends at DivLov.com';
		
		$this->load->library('email');
		$this->email->from('service@frugaldevelopment.com', 'DivLov Team');
		$this->email->to($to); 
		$this->email->subject('Alert from Divlov');
		$this->email->message($message); 
		$this->email->send();
		
		return true;
				
	}
	
	public function re_email_from_username($username){
		
		$uid = $this->re_user_id($username);
		
		$email = $this->re_user_email($uid);		
		
		return $email;
		
	}
	
}//end user model

