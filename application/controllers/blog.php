<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blog extends CI_Controller {
//the class to handle the displaying of blogs
			
	
	public $user_id;

	public function __construct(){
            parent::__construct();
            //bring in vital classes
			$this->load->library('session');
			$this->load->model('Blog_model','',true);
			$this->load->model('User_model','',true);
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
	
	public function new_post(){
		//create a new post
		if($this->input->post('title') and $this->input->post('post')){
			$new_post_data = array(
								'user_id' => $this->user_id,
								'blog_post' => $this->input->post('post'),
								'post_title' => $this->input->post('title'),
								'date_posted' => time(),
								'comments_id' => null
								   );
			$new_post = $this->Blog_model->new_post($new_post_data);
			if(!$new_post){
				//it didn't work
				$message = "<div class='error'>Sorry, we were not able to save your post at this time.</div>";	
			}else{
				$message = "<div class='success'>Thank you, your post was successful.</div>";
			}
		}else{
			$message = "<div class='warning'>You can't leave the title or the post body blank.</div>";
		}
		
		if(isset($message)){
			$this->session->set_userdata('message',$message);
		}
		
		$this->output->set_header("Location:/index.php/pages/blog");
	}
	
	public function read_blog(){
	    //display a single blog to be read
		if($this->uri->segment(3)){
			$bid = $this->uri->segment(3);
		}

	    if(isset($bid)){
			//grab the blog post
			$data['blog_post'] = $this->Blog_model->re_post($bid);
			
			if(!$data['blog_post']){
			    $message = "<div class='error'>Sorry, that post has been deleted or no longer is available.</div>";
			}else{
			    if(isset($data['blog_post'][0]->comments_id)){
					if($data['blog_post'][0]->comments_id != ''){
					    //there are comments attached to this post
					    //grab them
					    $data['comments'] = $this->Blog_model->re_comments($data['blog_post'][0]->comments_id);

					    if(isset($data['comments'][0]->user_id)){
					    	$data['c_username'] = $this->User_model->re_username($data['comments'][0]->user_id);
					    }
					}
			    }
			}
	    }else{
			$message = "<div class='error'>Sorry, we can't find that blog post.</div>";
	    }
	    
	    if(isset($message)){
			$this->session->set_userdata('message',$message);
	    }
	    
	    

	    $this->load->model('User_model','',true);
	    $data['username'] = $this->User_model->re_username($this->user_id);
	    $this->load->view('elements/header',$data);	
	    $this->load->view('pages/post',$data);
	    $this->load->view('elements/footer');
	    
	}//end read blog
	
	public function comment(){
	    //comment on a post
	    if($this->input->post('blog_id') and $this->input->post('comment')){
		//we have the blog_id, that is all we really need
		if($this->input->post('comment') != ''){
		    //making sure the comment is not blank
		    //check to see if the comment_id is set
		    if($this->input->post('comments_id')){
			//this means that there is already a comment id, ther have been previous comments
			$comments_id = $this->input->post('comments_id');
		    }else{
			//there is no comment_id, this is the first comment made
			//create a comment_id
			$comments_id = uniqid($this->input->post('blog_id')).time();//a unique id created with a prefix of the blog it's attached too and ending with the current timestamp
			//now update the blog to reflect that it has comments now
			$update_blog = $this->Blog_model->first_comment($this->input->post('blog_id'),$comments_id);
		    }
		    
		    //now we add the comment itself
		    $new_comment = $this->Blog_model->new_comment($comments_id,$this->input->post('comment'),$this->user_id);
		    
		    if(!$new_comment){
			$message = "<div class='error'>Sorry, we were not able to add your comment due to a database error. Please try again later.</div>";
		    }else{
			
			//success!!
			$message = "<div class='success'>Thank you! Your comment was added successfully.</div>";
			
			//let the owner of the blog know that their blog post was commented on
			$blog_owner_id = $this->Blog_model->re_blog_owner_id($this->input->post('blog_id'));
			$to = $this->User_model->re_user_email($blog_owner_id);//the owner of the blog
			
			$from = $this->User_model->re_username($this->user_id);//the person commenting
			
			$this->User_model->send_notification_email($to,$from,'comment');
		    }
		}else{
		    $message = "<div class='warning'>Sorry, no blank comments.</div>";
		}
	    }else{
		//we can't comment on anything without the blog_id
		$message = "<div class='error'>Sorry, no comments at this time.</div>";
	    }
	    
	    if(isset($message)){
			$this->session->set_userdata('message',$message);
	    }
	    
	    //return to post if id is set
	    if($this->input->post('blog_id')){
		$this->output->set_header("Location:/index.php/blog/read_blog/{$this->input->post('blog_id')}");
	    }else{
		$this->output->set_header("Location:/");//head to front page to see what is going on. 
	    }
	    
	}//end comment
	

	
}

