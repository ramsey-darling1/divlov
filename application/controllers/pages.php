<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends CI_Controller {
//the class to handle the displaying of pages as a user navigates through the site.
			
	
	public $user_id;
	public $message_number;
	

	public function __construct(){
            parent::__construct();

            //bring in vital classes
			$this->load->library('session');
			$this->load->model('User_model','',true);
			
			
			
			//determine if a user is logged in or not, only logged in users should access these pages
			if(!$this->session->userdata('loggedin')){
				//the user is not logged in, send them back to the welcome controller
				$message = "<div class='warning'>Looks like your session has expired.</div>";
				$this->session->set_userdata('message',$message);
				$this->output->set_header("Location:/index.php");
			}else{
				//the user is logged in, grab the username and user_id
				if($this->session->userdata('user_id')){
					//we have all the information we need at this point
					$this->user_id = $this->session->userdata('user_id');
				}else{
					//send them back to the welcome screen with an error message
					$message = "<div class='error'>Sorry, there was an unexpected error</div>";
					$this->session->set_userdata('message',$message);
					$this->output->set_header("Location:/index.php");
				}
				
				$this->message_number = $this->User_model->count_new_messages($this->user_id);
				
			}
        }
	
	public function home(){
		//displays the homepage
		if(isset($this->user_id)){
				//grab some details about the user
				$data['username'] = $this->User_model->re_username($this->user_id);
				$data['profile_pic'] = $this->User_model->re_profile_pic($this->user_id);
				$data['slideshow_users'] = $this->User_model->re_slideshow_users();
				$data['message_num'] = $this->message_number;
				$this->load->view('elements/header',$data);
				$this->load->view('pages/home',$data);
				$this->load->view('elements/footer');
		}else{
			//not logged in, return to index
			$message = "<div class='warning'>Sorry, you are no longer logged in.</div>";
			$this->session->set_userdata('message',$message);
			$this->output->set_header("Location:/index.php");
		}
	}
	
	public function messaging(){
       //displays the messaging area
	   if(isset($this->user_id)){
			$data['username'] = $this->User_model->re_username($this->user_id);
			//grab the messages
			$data['messages'] = $this->User_model->re_messages($this->user_id);
			$data['mod'] =& $this->User_model;//passing a reference to the model into the view
			$data['message_num'] = $this->message_number;
			$this->load->view('elements/header',$data);	
			$this->load->view('pages/messaging',$data);
			$this->load->view('elements/footer');
		}else{
			//not logged in, return to index
			$message = "<div class='warning'>Sorry, you are no longer logged in.</div>";
			$this->session->set_userdata('message',$message);
			$this->output->set_header("Location:/index.php");
		}
	}
	
	public function people(){
		//displays the people page
		if(isset($this->user_id)){
			
			$data['username'] = $this->User_model->re_username($this->user_id);
			
			//we need to grab people for the current user to check out
			$this->load->model('People_model','',true);
			
			if($this->uri->segment(3) == 'custom'){
				//we are displaying something else besides what the user has saved as default
				
				$people = $this->People_model->re_people_custom($_POST);
				
			}else{
				
				$people = $this->People_model->re_people($this->user_id);
					
			}
			
			
			
			//we should have a bunch of people now to display for the user
			if(!empty($people)){
				switch($people){
					//set some error messages if there are no people found
					case 'error1':
						$no_people_response = '<div class="warning">Sorry, we were not able to figure out what you are looking for. Make sure you setup what you are looking for in your profile.</div>';
						break;
					case 'error2':
						$no_people_response = '<div class="warning">We did not find anyone who matches what you are looking for. Maybe try to broaden your horizons.</div>';
						break;
					case 'error3':
						$no_people_response = '<div class="error">Sorry, we messed up. Please try again soon. Enjoy other parts of the site for now!</div>';
						break;
					default:
						//this will run when no errors are found
						foreach($people as $person){
							//$people is an array of user_details_id's
							$user_id = rtrim($person,'de');//remove the 'de' to make the details id a regular Id. is this still needed??
							$p_username = $this->User_model->re_username($user_id);//grab the username
							$p_details = $this->User_model->re_details($user_id);
							$p_looking4 = $this->User_model->re_looking4($user_id);
							$p_profile_pic = $this->User_model->re_profile_pic($user_id);
							$p_couple = null;
							if(isset($p_details[0]->couple)){
								if($p_details[0]->couple == 1){
									$p_couple = $this->User_model->re_partners_details($user_id);
								}
							}
							
							//now put together a multidim array, each main level of the array will be an array of a person with all their information in that array
							$all_people[] = array(
												'p_username' => $p_username,
												'p_details' => $p_details,
												'p_looking4' => $p_looking4,
												'p_profile_pic' => $p_profile_pic,
												'couple' => $p_couple
												  );
						}
				}
				
			}else{
				$no_people_response = '<div class="warning">We did not find anyone who matches exactly what you are looking for.</div>';
			}

			//Here we send to the view a bunch people's data to display, or an error message
			if(isset($all_people)){
				//we have a bunch of people's information we can pass to the view
				$data['all_people'] = $all_people;
			}

			if(isset($no_people_response)){
				//we are not able to load any people, so give the user a clue as to why
				$data['no_people_response'] = $no_people_response;
			}
			
			$this->People_model->re_user_looking4($this->user_id);
			$data['default_looking4'] = $this->People_model->re_looking4();

			$data['message_num'] = $this->message_number;
			
			//load views
			$this->load->view('elements/header',$data);	
			$this->load->view('pages/people',$data);
			$this->load->view('elements/footer');
		}else{
			//not logged in, return to index
			$message = "<div class='warning'>Sorry, you are no longer logged in.</div>";
			$this->session->set_userdata('message',$message);
			$this->output->set_header("Location:/index.php");
		}
	}
	
	public function hearts(){
		//displays the hearts page
		if(isset($this->user_id)){
				
		}else{
			//not logged in, return to index
			$message = "<div class='warning'>Sorry, you are no longer logged in.</div>";
			$this->session->set_userdata('message',$message);
			$this->output->set_header("Location:/index.php");
		}
	}
	
	public function favorites(){
		//displays the favorites page
		if(isset($this->user_id)){
			$data['username'] = $this->User_model->re_username($this->user_id);
			//grab all the users favorites
			$favs = $this->User_model->re_favs($this->user_id);
			if(!empty($favs)){
				foreach($favs as $fav){
					$all_favs[] = array(
									'fid' => $fav->fid,
									'fav_username' => $this->User_model->re_username($fav->fav_id),
									'details' => $this->User_model->re_details($fav->fav_id),
									'looking4' => $this->User_model->re_looking4($fav->fav_id),
									'profile_pic' => $this->User_model->re_profile_pic($fav->fav_id),
										);
				}
			}
			if(isset($all_favs)){
				$data['all_favs'] = $all_favs;
			}
			
			$data['message_num'] = $this->message_number;
			$this->load->view('elements/header',$data);	
			$this->load->view('pages/favorites',$data);
			$this->load->view('elements/footer');
				
		}else{
			//not logged in, return to index
			$message = "<div class='warning'>Sorry, you are no longer logged in.</div>";
			$this->session->set_userdata('message',$message);
			$this->output->set_header("Location:/index.php");
		}
	}
	
	public function blog(){
		//displays the blog page
		if(isset($this->user_id)){
			$data['username'] = $this->User_model->re_username($this->user_id);
			$this->load->model('Blog_model','',true);

			if($this->uri->segment(3)){
				$blogger_id = $this->User_model->re_user_id($this->uri->segment(3));
				if($blogger_id != ''){
					$data['posts'] = $this->Blog_model->re_posts($blogger_id);
					$data['blogger_name'] = $this->uri->segment(3);
				}
				
			}else{
				$data['posts'] = $this->Blog_model->re_posts($this->user_id);	
			}
			
			$data['message_num'] = $this->message_number;
			$this->load->view('elements/header',$data);	
			$this->load->view('pages/blog',$data);
			$this->load->view('elements/footer');
		}else{
			//not logged in, return to index
			$message = "<div class='warning'>Sorry, you are no longer logged in.</div>";
			$this->session->set_userdata('message',$message);
			$this->output->set_header("Location:/index.php");
		}
	}
	
	public function hiwall(){
		//displays the hiwall
		if(isset($this->user_id)){
			$data['username'] = $this->User_model->re_username($this->user_id);
			$this->load->model('Hiwall_model','',true);
			$data['hiposts'] = $this->Hiwall_model->re_hiposts();
			$data['message_num'] = $this->message_number;
			$this->load->view('elements/header',$data);	
			$this->load->view('pages/hiwall',$data);
			$this->load->view('elements/footer');
		}else{
			//not logged in, return to index
			$message = "<div class='warning'>Sorry, you are no longer logged in.</div>";
			$this->session->set_userdata('message',$message);
			$this->output->set_header("Location:/index.php");
		}
		
	}
	
	public function myhitest(){
		//displays myHitest and the scores of people who have taken the test.
		//the Hitest is a personalized test of whatever the user wants to put on it
		if(isset($this->user_id)){
			$data['username'] = $this->User_model->re_username($this->user_id);
			//grab any questions the user has already created.
			$this->load->model('Hitest_model','',true);
			$data['questions'] = $this->Hitest_model->re_questions($this->user_id);
			$data['message_num'] = $this->message_number;
			$this->load->view('elements/header',$data);	
			$this->load->view('pages/hitest',$data);
			$this->load->view('elements/footer');
		}else{
			//not logged in, return to index
			$message = "<div class='warning'>Sorry, you are no longer logged in.</div>";
			$this->session->set_userdata('message',$message);
			$this->output->set_header("Location:/index.php");
		}
		
	}
	
	public function profile(){
		//displays the profile page
		if(isset($this->user_id)){
			//load the models that will be used
			$this->load->model('Profile_model','',true);
			$this->load->model('Images_model','',true);
			$this->load->model('Hitest_model','',true);
			
			if($this->uri->segment(3)){
				//grab the user_id from the username that is being passed through the url
				$user_id = $this->User_model->re_user_id($this->uri->segment(3));
				if(!$user_id){
					//there is no user with that username
					//this could happen if someone types in stuff in the url
					$data = null;
					$message = "<div class='warning'>Sorry, we could not find a user with that username.</div>";
					$this->session->set_userdata('message',$message);
					return $this->output->set_header("Location:/index.php");
					//return $this->home();


				}else{
					//the user is viewing somebody else's profile
					$data['username'] = $this->User_model->re_username($this->user_id);//we still need to grab the current users username
					//grab all the profile info for that user whose profile is being viewed
					$data['p_username'] = $this->User_model->re_username($user_id);//grab the username
					$data['details'] = $this->User_model->re_details($user_id);
					$data['looking4'] = $this->User_model->re_looking4($user_id);
					$data['profile_pic'] = $this->User_model->re_profile_pic($user_id);
					$data['profile_bg'] = $this->Images_model->re_profile_bg($user_id);
					$data['bio'] = $this->Profile_model->re_bio($user_id);
					$data['interests'] = $this->Profile_model->re_interests($user_id);
					$data['pics'] = $this->Images_model->grab_user_pics($user_id);
					$data['hitest'] = $this->Hitest_model->re_questions($user_id);
					if($data['details'][0]->couple == 1){
						//the user being viewed is a couple
						$data['couple'] = true;
						$data['partners_details'] = $this->User_model->re_partners_details($user_id);
					}
				}

			}else{
				//the user is view their own profile
				//grab all the data that will need to be displayed
				$data['username'] = $this->User_model->re_username($this->user_id);//grab the username
				$data['p_username'] = $data['username'];//the name of the profile is the same as the current user, because they are viewing their own profile. 
				$data['details'] = $this->User_model->re_details($this->user_id);
				$data['looking4'] = $this->User_model->re_looking4($this->user_id);
				$data['profile_pic'] = $this->User_model->re_profile_pic($this->user_id);
				$data['profile_bg'] = $this->Images_model->re_profile_bg($this->user_id);
				$data['bio'] = $this->Profile_model->re_bio($this->user_id);
				$data['interests'] = $this->Profile_model->re_interests($this->user_id);
				$data['pics'] = $this->Images_model->grab_user_pics($this->user_id);
				$data['user_id'] = $this->user_id;//passing the user_id to the view
				$data['hitest'] = $this->Hitest_model->re_questions($this->user_id);
				$data['own_profile'] = true;
				if($data['details'][0]->couple == 1){
					//the user is a couple
					$data['couple'] = true;
					$data['partners_details'] = $this->User_model->re_partners_details($this->user_id);
				}
			}
			
			$data['message_num'] = $this->message_number;
			//load the views
			$this->load->view('elements/header',$data);	
			$this->load->view('pages/profile',$data);
			$this->load->view('elements/footer');

		}else{
			//not logged in, return to index
			$message = "<div class='warning'>Sorry, you are no longer logged in.</div>";
			$this->session->set_userdata('message',$message);
			$this->output->set_header("Location:/index.php");
		}
	}
	
	public function upload_images(){
		//a method to display the upload images area
		$data['username'] = $this->User_model->re_username($this->user_id);
		$this->load->model('Images_model','',true);
		$data['pics'] = $this->Images_model->grab_user_pics($this->user_id);
		$data['message_num'] = $this->message_number;
		$this->load->view('elements/header',$data);
		$this->load->view('pages/upload_images',$data);
		$this->load->view('elements/footer');
		
	}
	
	public function random_match(){
		//displays a random profile
		//in an attempt to stay DRY, we will just send the user to a random profile instead of
		//loading up a random profile
		
		$user_id = $this->User_model->random_user_id();//returns an existing valid random user_id
		$username = $this->User_model->re_username($user_id);

		$this->output->set_header("Location:/index.php/pages/profile/{$username}");
		
		
	}	
	
}

/* End of file pages.php */
/* Location: ./application/controllers/pages.php */