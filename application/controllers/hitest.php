<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hitest extends CI_Controller {
//the class to handle the functionality of the hitest
			
	
	public $user_id;
	public $val_add;
	public $error;

	public function __construct(){
            parent::__construct();
            //bring in vital classes
			$this->load->library('session');
			$this->load->model('Hitest_model','',true);
			if($this->session->userdata('user_id')){
				//we have all the information we need at this point
				$this->user_id = $this->session->userdata('user_id');
				
			}else{
				//send them back to the welcome screen with an error message
				$message = "<div class='error'>Sorry, there was an unexpected error</div>";
				$this->session->set_userdata('message',$message);
				$this->output->set_header("Location:/index.php");
			}
			
    }
	
	public function add_question(){
		if($this->user_id){
			//we've made sure the user is logged in
			$this->val_question_form();//validate the post data, make sure it's all there
			if($this->val_add){
				//the data was validated successfully
				$add_quest = $this->Hitest_model->add_quest($this->user_id,$this->val_add);
				if(!$add_quest){
					$message = "<div class='error'>Sorry, we were not able to add your question at this time.</div>";//saving the question to the database didn't work
				}else{
					$message = '<div class="success">Thanks! Your question was added successfully.</div>';
				}
			}elseif($this->error){
				//some error handling. We like to have unique, specific error messages. 
				switch($this->error){
					case 'error1':
						$message = "<div class='warning'>You must fill out the question.</div>";
						break;
					case 'error2':
						$message = "<div class='warning'>You must fill out all four possible answers.</div>";
						break;
					case 'error3':
						$message = "<div class='warning'>You must fill out the correct answer</div>";
						break;
					default:
						$message = "<div class='error'>Sorry, something strange and unexpected happend.</div>";
				}
			}else{
				//this would be error4, this should never happen
				$message = "<div class='error'>Sorry, something really weird happened. Please try again.</div>";
			}
		}else{
			$message = "<div class='error'>Sorry, you might not be logged in.</div>";
		}
		
		
		$this->session->set_userdata('message',$message);
		$this->output->set_header("Location:/index.php/pages/myhitest");
	}
	
	private function val_question_form(){
		//just make sure that all the post data that is supposed to be here is here
		//set an error message if it's not
		if(!$this->input->post('question')){
			$this->error = 'error1';//the user didn't fill out the question
		}elseif(!$this->input->post('ans1') or !$this->input->post('ans2') or !$this->input->post('ans3') or !$this->input->post('ans4')){
			$this->error = 'error2';//all answers were not filled out
		}elseif(!$this->input->post('correct_ans')){
			$this->error = 'error3';//the answer was not filled out
		}else{
			$this->val_add = $_POST;//pass all of the post data to this->val_add
		}
		
	}
	
	public function take_myhitest(){
		//a method to display a user's hitest when another user is going to take it
		if($this->session->userdata('loggedin')){
			//we've made sure that the user is logged in
			if($this->uri->segment(3)){
				//we've made sure that we have a username, or a supposed username, to work with.
				//grab the models we will need
				$this->load->model("User_model","",true);
				$user_id = $this->User_model->re_user_id($this->uri->segment(3));
				if(!$user_id){
					//there is no user with that username
					$this->error_response("Location:/index.php/","<div class='error'>Sorry, there doesn't seem to be a user with that username</div>");	
				}else{
					//now $user_id is the user who's test is being taken, $this->user_id is the user taking the test
					//grab the user's questions and display that users hitest
					$data['username'] = $this->User_model->re_username($this->user_id);//we still need to grab the current users username
					$data['hitest'] = $this->Hitest_model->re_questions($user_id);//grab the questions
					$data['hitest_name'] = $this->uri->segment(3);//the hitest's username is being passed through the url
					$data['hitest_owner'] = $user_id;
					$this->display_views('pages/takehitest',$data);//success!
				}
			}else{
				$this->error_response("Location:/index.php/","<div class='error'>Sorry, you have to select a user to take that user's Hitest</div>");	
			}
		}else{
			$this->error_response("Location:/index.php","<div class='warning'>Sorry, you are no longer logged in.</div>");
		}
	}
	
	public function calc_hitest(){
		//a method to calculate the results of someone taking someone's hitest
		$path = null;//just setting up a variable
		if($this->input->post('hitest_owner')){
			//we have the user_id of the user who's hitest is was just taken
			//grab the questions so we can sort the answers
			$questions = $this->Hitest_model->re_questions($this->input->post('hitest_owner'));
			$num_questions = 0;//start a counter
			$correct = 0;//start another counter
			if(!empty($questions)){
				//we have questions to work with
				foreach($questions as $question){
					//we are looping through the questions
					$num_questions = $num_questions + 1;//counting the number of questions as we go
					if(!empty($_POST)){
						//we made sure that the post array is not empty
						if($_POST[$question->qid] == $question->correct_ans){
							//the question was answered correctly!
							$ans = 1;
							$correct = $correct + 1;//count the correct answers
						}else{
							//opps, not the right answer
							$ans = 0;
						}
						//gather the results into an array
						$res[] = array(
										'qid' => $question->qid,
										'ans' => $ans
										   );
					}
				}
				//now we have the results
				if(isset($res)){
					//save results of test
					if(isset($correct)){
						//how many correct answers do we have?
						$data['correct'] = $correct;
						$data['percent'] = $this->percentage($num_questions,$correct);//grab the percentage correct
						if($data['percent'] > 80){
							$message = "<div class='success'>Wonderful! Really good score. You might be a good match!</div>";
						}elseif($data['percent'] > 50){
							$message = "<div class='success'>Not bad. You still might be compatible</div>";
						}else{
							$message = "<div class='warning'>Hum...there is a chance that you might not be that compatable. However, these tests should not be taken that seriously.</div>";
						}
						
						$save_results = $this->Hitest_model->save_results($this->user_id,$this->input->post('hitest_owner'),$res,$correct,$data['percent']);
						
						
					}
				}else{
					//oh, we don't have the results
					$message = "<div class='warning'>Sorry, we were not able to calculate your results at this time. Please try again.</div>";
					
				}
				
			}else{
				//we don't have questions
				$message = "<div class='warning'>Sorry, something went wrong. Please try again.</div>";
				
			}
			
		}else{
			//we can't do anything here
			$message = "<div class='error'>Sorry, we ran into an error. Please try again.</div>";
			
			
		}
		
		$this->load->model("User_model","",true);
		$data['username'] = $this->User_model->re_username($this->user_id);//we still need to grab the current users username
		
		//display messages and results
		if(isset($message)){
			$this->session->set_userdata('message',$message);	
		}
		
		$this->display_views('pages/hitest_results',$data);
		
	}
	
	public function display_views($view,$data){
		//a method to display the views
		$this->load->view('elements/header',$data);	
		$this->load->view($view,$data);
		$this->load->view('elements/footer');
	}
	
	public function error_response($location,$message){
		//a method to handle when drastic errors
		$this->session->set_userdata('message',$message);
		$this->output->set_header($location);
	}
	
	private function percentage($num1, $num2) {
		if($num1 <= 0 or $num2 <= 0){
			return 0;
		}else{
			$count1 = $num1 / $num2;
			$count2 = $count1 * 100;
			$count = number_format($count2, 0);
			return $count;
		}
		
	}
	
	
	
	
	
	
}

