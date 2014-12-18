<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blog_model extends CI_Model {
//a class to manage users images
//@rdarling

	
	public function __construct(){
            parent::__construct();
            //bring in vital classes
		    //$this->load->library('session');
    }
	
	public function new_post($new_post_data){
		//save a new post
		$in = $this->db->insert('blog',$new_post_data);
		if(!$in){
			return false;
		}else{
			return true;
		}
	}
	
	public function re_posts($user_id){
		//grab all of a user's blog posts and return them
		$this->db->order_by("bid", "desc");
		$dig = $this->db->get_where('blog',array('user_id'=>$user_id));
		foreach($dig->result() as $post){
			$posts[] =  $post;
		}
		
		if(isset($posts)){
			return $posts;
		}else{
			return false;
		}
	}
	
	public function re_post($bid){
	    //a method to return a blog post
	    $dig = $this->db->get_where('blog',array('bid'=>$bid));
	    $post =  $dig->result();
	    if(!$post){
		return false;
	    }else{
		return $post;
	    }
	}
	
	public function re_comments($comments_id){
	    $this->db->order_by("cid", "desc");
	    $dig = $this->db->get_where('comments',array('comments_id'=>$comments_id));
	    foreach($dig->result() as $comment){
		$comments[] = $comment;
	    }
	    if(isset($comments)){
		return $comments;
	    }else{
		return false;
	    }
	}
	
	public function first_comment($bid,$comments_id){
	    //a method to update a blog post to reflect that it now has comments.
	    //note, this does not actually save the first comment, it just updates the blog post
	    $up = array('comments_id'=>$comments_id);
	    $this->db->where('bid',$bid);
	    $this->db->update('blog',$up);
	    return true;//even if it doesn't work we want to return true here
	}
	
	public function new_comment($comments_id,$comment,$user_id){
	    $comment_data = array(
				'comments_id' => $comments_id,
				'comment' => $comment,
				'date_commented' => time(),
				'user_id' => $user_id
				  );
	    $in = $this->db->insert('comments',$comment_data);
	    if(!$in){
		return false;
	    }else{
		return true;
	    }
	}
	
	public function re_blog_owner_id($bid){
	    //this method returns the user id of the user who owns the blog in question
	    
	    $dig = $this->db->get_where('blog',array('bid'=>$bid));
	    
	    $blog = $dig->result();
	    
	    if(!empty($blog)){
		$res = $blog[0]->user_id;
	    }else{
		$res = false;
	    }
	    
	    return $res;
	}
	
}//end of blog_model

