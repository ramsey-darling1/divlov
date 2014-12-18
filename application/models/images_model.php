<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Images_model extends CI_Model {
//a class to manage users images
//@rdarling

	
	public function __construct(){
            parent::__construct();
            //bring in vital classes
		    $this->load->library('session');
    }
	
	public function save_user_pic($user_id,$pic_data){
		//first save the image
		//create a unique image id
		$pic_id = 'pic'.uniqid(time());
		$pic_info = array(
						'pic_id' => $pic_id,
						'full_path' => $pic_data['full_path'],
						'raw_name' => $pic_data['raw_name'],
						'image_type' => $pic_data['image_type'],
						'image_size_str' => $pic_data['image_size_str'],
						'image_width' => $pic_data['image_width'],
						'image_height' => $pic_data['image_height'],
						'file_path' => $pic_data['file_path']
						  );
		$in = $this->db->insert('user_pic_data',$pic_info);
		if(!$in){
			//it didn't work
			return false;
		}else{
			$user_pic_info = array(
								'user_id' => $user_id,
								'pic_id' => $pic_id,
								'is_profile_pic' => 0 //uploaded images are not profile pics by default
								   );
			$in2 = $this->db->insert('user_pics',$user_pic_info);
			if(!$in2){
				//crap.
				return false;
			}else{
				return true;
			}
		}
	}
	
	public function grab_user_pics($user_id){
		//return all of a users pics
		$dig = $this->db->get_where('user_pics',array('user_id'=>$user_id));//grab all the pic_id's that belong to a user
		foreach($dig->result() as $pic){
			$pics[] = $pic->pic_id;
		}
		if(isset($pics)){
			//grab the file paths
			foreach($pics as $pic_id){
				$dig2 = $this->db->get_where('user_pic_data',array('pic_id'=>$pic_id));
				$all_pics[] = $dig2->result();
			}
			if(isset($all_pics)){
				//return an array of all the pic data
				return $all_pics;
			}else{
				//didn't work
				return false;
			}
		}else{
			//no pics
			return false;
		}
		
	}
	
	public function unset_profile_pic($user_id){
		//a method to remove the profile pic
		$up_data = array('is_profile_pic'=>0);
		$this->db->where('user_id',$user_id);
		$this->db->update('user_pics',$up_data);
		return true;//this is happening behind the scenes, if it doesn't work we still want it to return true
	}
	
	
	public function set_profile_pic($user_id,$pic_id){
		//a method to set the profile pic
		$up_data = array('is_profile_pic'=>1);
		$this->db->where('user_id',$user_id);
		$this->db->where('pic_id',$pic_id);
		$up = $this->db->update('user_pics',$up_data);
		if(!$up){
			return false;
		}else{
			return true;	
		}
		
	}
	
	public function unset_profile_pic_background($user_id){
		//a method to remove the profile pic
		$up_data = array('is_profile_bg'=>0);
		$this->db->where('user_id',$user_id);
		$this->db->update('user_pics',$up_data);
		return true;//this is happening behind the scenes, if it doesn't work we still want it to return true
	}
	
	public function set_profile_pic_background($user_id,$pic_id){
		//a method to set the profile pic
		$up_data = array('is_profile_bg'=>1);
		$this->db->where('user_id',$user_id);
		$this->db->where('pic_id',$pic_id);
		$up = $this->db->update('user_pics',$up_data);
		if(!$up){
			return false;
		}else{
			return true;	
		}
		
	}
	
	public function re_profile_bg($user_id){
		//a method to return the profile pic
		$dig = $this->db->select('pic_id');
		$dig = $this->db->where('user_id',$user_id);
		$dig = $this->db->where('is_profile_bg',1);
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
	
	public function delete_pic($pic_id){
		
		$up_data = array('user_id'=>0);//update the user id to 0
		
		$this->db->where('pic_id',$pic_id);
		
		$up = $this->db->update('user_pics',$up_data);
		
		!$up ? $res = false : $res = true;
		
		return $res;
	}
	
	
}

