<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {
//the class to handle user registrations, user creation, logging in and logging out
//@rdarling

	public function __construct(){
            parent::__construct();
            //bring in vital classes
			$this->load->library('session');
			$this->load->model('User_model','',true);
        }
       
	public function register(){
		//a method to begin the registration process
		//display the registration pages
		$this->load->view('elements/outside_header');
		$this->load->view('register/register');
		$this->load->view('elements/outside_footer');
	}
	
	public function reg_step_2(){
		//a method to continue the registration process into step 2
		//also to begin to save tmp data
		//first check to see if post data exists
		if(!$this->input->post('username') or !$this->input->post('email')){
			//set error message and return to register page
			$message = "<div class='error'>You must enter a valid email and a unique username</div>";
			$path = 'goback';
		}else{
			
			$username = preg_replace('/ /','',$this->input->post('username'));//strip out whitespace in the middle
			
			//check to make sure that the username is unique. the email doesn't need to be unique
			$does_username_exist = $this->User_model->is_username_unique($username);
			
			if($does_username_exist){
				//the username does exist, so go back and tell the user they need to pick a new username
				$message = "<div class='warning'>Sorry, that username is already in use. Please choose a different one.</div>";
				$path = 'goback';
			
			}else{
			
				//check that the password has been entered and is atleast 6 characters long
				$count_pass = strlen($this->input->post('password'));
			
				if($count_pass == 0 or $count_pass < 8){
					//the password was not entered or is not long enough
					$message = "<div class='warning'>Sorry, your password must be atleast 8 characters long.</div>";
					$path = 'goback';
			
				}else{
					//the username is fine, so create a user_id
					$timestamp = time();
					$user_id = 'hi'.uniqid($timestamp);//now there is a totally unique id created.
					//encrypt the password
					//$this->load->library('encrypt');
					$pass = $this->encrypt->encode($this->input->post('password'));
					$tmp_user_data = array(
										'user_id' => $user_id,
										'time_started' => $timestamp,
										'process' => 1,
										'tmp_details_id' => $user_id,//details_id is now going to be the exact same as user_id
										'tmp_password' => $pass
										   );
					$tmp_user_details = array(
											'tmp_details_id' => $user_id,
											'username' => $username,
											'email' => $this->input->post('email'),
											  );
					//save the data as a new tmp_user
					$new_tmp_user = $this->User_model->create_new_tmp_user($tmp_user_data,$tmp_user_details);
					//create tmp session
					$this->session->set_userdata('tmp_user',$user_id);
					$path = 'goforward';
				}
			
			}
		}
		//wrap it up
			if(isset($message)){
				//set the message if there is one
				$this->session->set_userdata('message',$message);
			}
			switch($path){
				//go back or load the views
				case 'goback':
					$this->output->set_header("Location:/index.php/users/register");
					break;
				case 'goforward':
					$this->output->set_header("Location:/index.php/users/register_step2");
					break;
			}
		
	}
	
	public function register_step2(){
		//load the views for step2
		$this->load->view('elements/outside_header');
		$this->load->view('register/register_step2');
		$this->load->view('elements/outside_footer');
	}
	
	public function reg_step_3(){
		//grab the user_id from the session
		$user_id = $this->session->userdata('tmp_user');
		//grab the user_details_id
		$tmp_details_id = $this->User_model->grab_tmp_user_details_id($user_id);
		if(isset($tmp_details_id)){
			$tmp_details = array(
							'age' => $this->input->post('age'),
							'gender' => $this->input->post('gender'),
							'city' => $this->input->post('city'),
							'state' => $this->input->post('state'),
							'orientation' => $this->input->post('orientation'),
							'relationship_status' => $this->input->post('relationship_status')
								 );
			$save_details = $this->User_model->update_tmp_details($tmp_details_id,$tmp_details);
			if($this->input->post('couple')){
				$tmp_couple = array(
								'tmp_details_id' =>$tmp_details_id,
								'gender' => $this->input->post('gender2'),
								'age' => $this->input->post('age2'),
								'orientation' => $this->input->post('orientation2')
									);
				$save_tmp_couple = $this->User_model->save_tmp_couple($tmp_couple);
				
			}
			
			//head on to the last step
			$this->output->set_header("Location:/index.php/users/register_step3");
		}else{
			//opps, something bad happened, send the user back and start all over
			$message = "<div class='error'>Sorry, something unexpected happened and we were not able to create your accound. Please try again.</div>";
			$this->output->set_header("Location:/index.php");
		}
		
		
	}
	
	public function register_step3(){
		//load the views for step3
		$this->load->view('elements/outside_header');
		$this->load->view('register/register_step3');
		$this->load->view('elements/outside_footer');
	}
	
	public function save_last_step(){
		//a method to save the last step of the registration process
		$user_id = $this->session->userdata('tmp_user');
		//grab the user_details_id
		$tmp_details_id = $this->User_model->grab_tmp_user_details_id($user_id);
		if(isset($tmp_details_id)){
			$seeking = array(
					'tmp_details_id' => $tmp_details_id,
					'gender' => $this->input->post('seekinggender'),
					'orientation' => $this->input->post('seekingorientation'),
					'age' => $this->input->post('seekingage'),
					'age2' => $this->input->post('seekingage2'),
					'status' => $this->input->post('seekingstatus'),
					'looking_for' => $this->input->post('for'),
					'alternatives' => $this->input->post('alternatives')
						 );
			$save_last_details = $this->User_model->save_looking4($tmp_details_id,$seeking);
			//now we have saved all the data.
			//time to create a new user
			$this->create_new_user($user_id);
		}else{
			//opps, something bad happened, send the user back and start all over
			$message = "<div class='error'>Sorry, something unexpected happened and we were not able to create your accound. Please try again.</div>";
			$this->output->set_header("Location:/index.php");
		}
		
	}
	
	public function login(){
		//a method to log a user in
		$data['login'] = true;
		$this->load->view('elements/outside_header',$data);
		$this->load->view('logging/login');
		$this->load->view('elements/outside_footer');
	}
	
	public function login_action(){
		//make sure password and username are both there
		if($this->input->post('username') and $this->input->post('password')){
			//test username and password
			$user_id = $this->User_model->login_user($this->input->post('username'),$this->input->post('password'));
			if(!$user_id){
				//the method returned false, the username or password is wrong
				$message = "<div class='warning'>Sorry, that was the wrong username and password combination</div>";
				$this->session->set_userdata('message',$message);
				$this->output->set_header("Location:/index.php/users/login");
			}else{
				//success,log in the user and send them to their homepage
				$message = "<div class='success'>Welcome Back!</div>";
				$this->session->set_userdata('message',$message);
				$this->session->set_userdata('loggedin',true);
				$this->session->set_userdata('user_id',$user_id);
				$this->output->set_header("Location:/index.php/pages/home");
			}
			
		}else{
			//error, need both username and password
			$message = "<div class='error'>You must enter a valid password and a real username</div>";
			$this->session->set_userdata('message',$message);
			$this->output->set_header("Location:/index.php/users/login");
		}
	}
	
	public function logout(){
		//a method to log a user out
		$this->session->unset_userdata('loggedin');
		$this->session->unset_userdata('user_id');
		$message = "<div class='success'>You logged out successfully. Come back soon!</div>";
		$this->session->set_userdata('message',$message);
		$this->output->set_header("Location:/index.php");
	}
	
	public function create_new_user($user_id){
		//a method to create a new user
		//and send to homepage after
		$new_user = $this->User_model->new_user($user_id);
		switch($new_user){
			case 'error1':
				//this is the worst error, no new user was created
				$message = "<div class='error'>Sorry, we were not able to create an account for you at this time. Please try again later</div>";
				$this->session->set_userdata('message',$message);
				$this->output->set_header("Location:/index.php");
				break;
			case 'error2':
				//the user's account was created, but no other information was saved
				$message = "<div class='error'>Sorry, while we were able to create your account, your personal details were not able to be saved. Please edit your profile and fill in the missing data.</div>";
				break;
			case 'error3':
				$message = "<div class='warning'>Sorry, while we were able to create your account, we were not able to save what you are interested in finding on Hihearts. Please edit your profile and fill in the missing data.</div>";
				break;
			case 'error4':
				$message = "<div class='warning'>Sorry, it looks like you were tring to join as a couple, however we were not able to save your partners information. Please edit your profile to fill in your partners data</div>";
				break;
			case 'success':
				$message = "<div class='success'>Thank you for joining Hihearts! We hope you have lots of fun here.</div>";
				break;
			default:
				//this should never happen
				$message = "<div class='warning'>Sorry, something unexpected and weird happend. Please forgive us. Try registering again. </div>";
				$this->session->set_userdata('message',$message);
				$this->output->set_header("Location:/index.php");
		}
		//if we are here, everything hopefully has gone smoothly and a user account has been created.
		//now we can delete the tmp data
		$this->User_model->delete_tmp_data($user_id);
		//unset the tmp session
		$this->session->unset_userdata('tmp_user');
		//start the logged in session
		$this->session->set_userdata('loggedin',true);
		$this->session->set_userdata('user_id',$user_id);
		
		//try to send a welcome email
		$this->email_new_user($user_id);
		
		//send the user to their homepage with a message if their is one
		if(isset($message)){
			$this->session->set_userdata('message',$message);
		}
		
		$this->output->set_header("Location:/index.php/pages/home");
		
		
	}
	
	public function email_new_user($user_id){
		//a method to send out a email notification to a new user once they have signed up
		$email = $this->User_model->re_user_email($user_id);
		if(!$email){
			//we were not able to find the email address. Just return true and allow the user to continue on with no error message. They just don't get the welcome email, no big deal.
			echo "crap";
			die;
			//return true;
		}else{
			//we have the email address, send the welcome email
			$this->load->library('email');
			$this->email->from('service@frugaldevelopment.com', 'DivLov Team');
			$this->email->to($email); 
			$this->email->bcc('rdarling42@gmail.com.com'); 
			$this->email->subject('Welcome to DivLov!');
			$this->email->message('Welcome to DivLov! We are so glad that you decided to sign up. We are sure you will have lots of fun, and hopefully meet someone special.'); 
			$this->email->send();
			return true;//even if the email doesn't actually send, we just want to go on like it did. 
		}
	}
	
	public function forgot_pass(){
		//a method to display the forgot password page
		$data['login'] = true;
		$this->load->view('elements/outside_header',$data);
		$this->load->view('logging/forgot_pass');
		$this->load->view('elements/outside_footer');
	}
	
	public function forgot_user(){
		//a method to display the forgot username page
		$data['login'] = true;
		$this->load->view('elements/outside_header',$data);
		$this->load->view('logging/forgot_user');
		$this->load->view('elements/outside_footer');
	}
	
	public function send_username(){
		//a method to email a users username to them
		if($this->input->post('email')){
			//see if it's ok the send the username, and if it is, grab the username
			$username_test = $this->User_model->email_to_username($this->input->post('email'));
			if(!$username_test){
				//holy crap, it returned false meaning it didn't work AT ALL. this should not happen. it should instead return either a username or an error code.
				$message = "<div class='error'>We are sorry, we ran into an unexpected error. Please try again later.</div>";
			}else{
				switch($username_test){
					case 'error1':
						$message = "<div class='error'>We are sorry, we ran into an unexpected error. Please make sure you are using a valid email.</div>";
						break;
					case 'error2':
						$message = "<div class='warning'>The email address you entered was not found in our system. Please make sure you are using a valid email address.</div>";
						break;
					case 'error3':
						//this is going to be the most common error, and this should be returned if email is tied to more than one username
						$message = "<div class='warning'>We are sorry, that email address is being used by more than one username. For security reasons, we can not email you your username.</div>";
						break;
					case 'error4':
						//this should not ever get returned. but stranger things have happened.
						$message = "<div class='error'>We are sorry, hit the wall. We are experianceing technical problems. Our fault. Please try again later.</div>";
						break;
					case 'error5':
						$message = "<div class='error'>We are having technical issues. We can not find your username at this time. Please try again later.</div>";//it almost worked. 
						break;
					default:
						//no error codes were returned, so it must be the username that has been returned.
						//it's safe to trust it at this point.
						//send the email
						$this->load->library('email');
						$this->email->from('service@frugaldevelopment.com', 'DivLov Team');
						$this->email->to($this->input->post('email')); 
						$this->email->subject('Here is your Username');
						$this->email->message('We all forget something, sometime. Here is your forgotten username:'.$username_test); 
						$send = $this->email->send();
						if(!$send){
							$message = "<div class='error'>We are sorry, we were not able to send your username at this time. Please try again later.</div>";
						}else{
							$message = "<div class='success'>Thank you! Please check your email for your username.</div>";
						}
				}
			}
			
			
		}else{
			//the email address was not set
			$message = "<div class='warning'>You must enter a valid email address</div>";
		}
		
		//set the message
		if(isset($message)){
			$this->session->set_userdata('message',$message);
		}
		//return to the forgot user page
		$this->output->set_header("Location:/index.php/users/forgot_user");
	}
	
	
	public function send_password_reset(){
		//a method to send a reset password link
		if($this->input->post('username')){
			//check to see if it's a valid username
			$user_id = $this->User_model->re_user_id($this->input->post('username'));
			if(!$user_id){
				//the username doesn't exist in the system
				$message = "<div class'error'>Sorry, that username doesn't seem to exist.</div>";
			}else{
				//we have a valid username. Grab the email
				$email = $this->User_model->re_user_email($user_id);
				if(!$email){
					//we could not find the email address
					$message = "<div class'error'>Sorry, we were not able to find the email address that is tied to your username. We can not reset your password at this time. Please email info@hihearts.com to proceed.</div>";
				}else{
					//we have a valid email.
					//we can send a reset link but first we need set up the unique code.
					$reset_pass_key = md5($user_id.time());//takes the unique user_id and creates a unique md5 hash
					$save_reset_pass_key = $this->User_model->save_reset_pass($user_id,$reset_pass_key);
					if(!$save_reset_pass_key){
						$message = "<div class'error'>Sorry, we are not able to reset your password at this time.</div>";//we were not able to save the information 
					}else{
						//send the link
						$this->load->library('email');
						$this->email->from('service@frugaldevelopment.com', 'DivLov Team');
						$this->email->to($email); 
						$this->email->subject('Reset Password Link');
						$this->email->message('To reset your password, please follow this link: http://divlov.com/index.php/users/reset_pass/'.$reset_pass_key); //this will need to be switched to the real link after launch
						$send = $this->email->send();
						if(!$send){
							$message = "<div class='error'>We are sorry, we were not able to send your password reset link at this time. Please try again later.</div>";
						}else{
							$message = "<div class='success'>Thank you! Please check your email for your reset password link.</div>";
						}
					}
				}
			}
		}else{
			//there isn't even a username to work with
			$message = "<div class'warning'>Sorry, you must enter a valid username.</div>";
		}
		
		//set the message
		if(isset($message)){
			$this->session->set_userdata('message',$message);
		}
		//return to the forgot user page
		$this->output->set_header("Location:/index.php/users/forgot_pass");
	}
	
	public function reset_pass($reset_pass_key){
		//reset_pass_key is passed through the url. if it's not preset, head to the home page.
		if(isset($reset_pass_key)){
			//we have the reset password key
			$test_reset_pass_key = $this->User_model->comp_reset_pass_key($reset_pass_key);
			switch($test_reset_pass_key){
				case 'nopass':
					//the key wasn't found
					$message = "<div class='error'>Sorry. That doesn't seem to be a valid link.</div>";
					$path = 'tryagain';
					break;
				case 'expired':
					$message = "<div class='warning'>Sorry. That link has expired. Please try again and this time use the link within 24 hours</div>";
					$path = 'tryagain';
					break;
				case null:
					$message = "<div class='warning'>Sorry. We had an unexpected error. Please try again.</div>";
					$path = 'tryagain';
					break;
				default:
					//we have the user id to reset the password!
					$user_id = $test_reset_pass_key;
					
			}
			
			if(isset($user_id)){
				//send the user to the choose a new password page.
				$path = 'newpasspage';
				//set a tmp session to save the user_id
				$this->session->set_userdata('reset_pass',$user_id);
			}
		}else{
			//there was no password reset key in the link
			$message = "<div class='error'>Sorry. You must have a valid password reset key.</div>";
			$path = 'tryagain';
		}
		
		//set response message
		if(isset($message)){
			$this->session->set_userdata('message',$message);
		}
		//return path
		if(isset($path)){
			switch($path){
				case 'tryagain':
					$this->output->set_header("Location:/index.php/users/forgot_pass");
					break;
				case 'newpasspage':
					$this->output->set_header("Location:/index.php/users/set_new_pass");
					break;
				default:
					$this->output->set_header("Location:/index.php");		
			}
		}else{
			$this->output->set_header("Location:/index.php");
		}
		
		
	}//end reset_pass method
	
	public function set_new_pass(){
		//a method to display the form to set a new password
		//make sure that a reset password session has been started
		if($this->session->userdata('reset_pass')){
			$data['login'] = true;
			$this->load->view('elements/outside_header',$data);
			$this->load->view('logging/set_new_pass');
			$this->load->view('elements/outside_footer');
		}else{
			$message = "<div class='error'>Sorry, you will not be able to reset your password at this time. Please try again later.</div>";
			$this->output->set_header("Location:/index.php");
		}
	}
	
	public function update_password(){
		//make sure the session is started, and password data is here
		if($this->input->post('pass1') and $this->input->post('pass2') and $this->session->userdata('reset_pass')){
			//make sure the password has atleast 6 characters
			if(strlen($this->input->post('pass1')) > 6){
				//make sure the passwords match
				if($this->input->post('pass1') == $this->input->post('pass2')){
					//update the password
					$password = $this->encrypt->encode($this->input->post('password'));
					$update_pass = $this->User_model->update_pass($this->session->userdata('reset_pass'),$password);
					if(!$update_pass){
						$message = "<div class='error'>Sorry, we were not able to update your password at this time.</div>";
						$path = 'tryagain';
					}else{
						$message = "<div class='success'>Password updated successfully. You may now login with your new password.</div>";
						$path = 'login';
					}
					
				}else{
					$message = "<div class='warning'>Passwords do not match.</div>";
					$path = 'tryagain';
				}
			}else{
				$message = "<div class='warning'>Passwords must contain 6 characters or more</div>";
				$path = 'tryagain';
			}	
		}else{
			$message = "<div class='warning'>Please make sure you have filled out both password fields. If you keep getting this error, your session may have expired.</div>";
			$path = 'tryagain';
		}
		
		//set response message
		if(isset($message)){
			$this->session->set_userdata('message',$message);
		}
		
		//head out
		if(isset($path)){
			switch($path){
				case 'tryagain':
					$this->output->set_header("Location:/index.php/users/set_new_pass");
					break;
				case 'login':
					//end the reset_password session
					$this->session->unset_userdata('reset_pass');
					$this->output->set_header("Location:/index.php/users/login");
					break;
				default:
					$this->output->set_header("Location:/index.php");		
			}
		}else{
			$this->output->set_header("Location:/index.php");
		}
		
		
	}
	
}

/* End of file users.php */
/* Location: ./application/controllers/users.php */
