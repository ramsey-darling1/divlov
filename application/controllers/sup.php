<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sup extends CI_Controller {
//the class to handle the displaying of supplementary pages
			
	
	public $head;
	public $data;

	public function __construct(){
            parent::__construct();
            //bring in vital classes
			$this->load->library('session');
			//check if logged in
			if($this->session->userdata('loggedin')){
				$this->head = 'header';
				if($this->session->userdata('user_id')){
						$this->load->model('User_model','',true);
						$data['username'] = $this->User_model->re_username($this->session->userdata('user_id'));
				}
			}else{
				$this->head = 'outside_header';
			}
	}
	
	public function legal() {
		//display legal page
		$this->dis_sup_page('legal',$this->head,$this->data);
	}
	
	public function contact() {
		//display contact page
		$this->dis_sup_page('contact',$this->head,$this->data);
	}
	
	public function about() {
		//display about page
		$this->dis_sup_page('about',$this->head,$this->data);
	}
	
	public function tips() {
		//display legal page
		$this->dis_sup_page('tips',$this->head,$this->data);
	}
	
	public function hearts() {
		//display legal page
		$this->dis_sup_page('hearts',$this->head,$this->data);
	}
	
	
	private function dis_sup_page($page,$header,$data=null){
		//display a supplementary page
		$this->load->view('elements/'.$header,$data);
		$this->load->view('sup/'.$page);
		$this->load->view('elements/footer');
	}
	

	
	
}

