<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller{
	
    function __construct(){
		
      parent::__construct();  	      
      $this->load->library('session');
      $this->load->library('email');
      $this->load->helper('form');
      $this->load->helper('url');
      $this->load->helper('html');
      $this->load->database();
      $this->load->library('form_validation');
      $this->load->model(array('user_model','common_model'));
      
    }
    
  public function index(){
      
        if($this->session->userdata('adminLogin')){           
           redirect('admin/dashboard','location');   
           exit;
        } 
      
        $this->load->view('admin/login_view');
    }
    
    
  public function process(){
       		
		$this->form_validation->set_rules('username', $this->lang->line('UserName_lbl'), 'trim|required');
		$this->form_validation->set_rules('password', $this->lang->line('Password_lbl'), 'trim|required');

		if ($this->form_validation->run() == FALSE)
		{		 
		   $error = validation_errors();
		   $this->session->set_flashdata('err_message',  $error); 
		   $this->index();
		}
		else
		{    
			// grab user input
			$username = $this->security->xss_clean($this->input->post('username'));
			$password = $this->security->xss_clean($this->input->post('password'));
			
            $result = $this->user_model->validate($username,$password);
                  
             if(!empty($result)){
				 
				 $sessiondata = array(	
				                'adminLogin'=> true,	
								'adminLoginData'=> array(
									'userid' => $result[0]->user_id,
									'username' => $result[0]->user_name,
									'useremail' => $result[0]->user_email,
									'usertype' => $result[0]->user_type
									)
								);
								
                $this->session->set_userdata($sessiondata);             
                $this->user_model->updateUserInfo($result[0]->user_id);
               
                redirect('admin/dashboard');
				        
             }else{
               // If user did not validate, then show them login page again
               $msg = $this->lang->line('err_invalidLogin');                  
			   $this->session->set_flashdata('err_message',  $msg); 
			   $this->index(); 
            } 
		}       
    } 
    
    public function forgetpassword(){
		
		if($this->session->userdata('adminLogin')){           
           redirect('admin/dashboard','location');   
           exit;
        } 
        
        //Check Validation
	    $this->form_validation->set_rules('user_email',$this->lang->line('Email_lbl'),'valid_email|trim|required');
		
	   if($this->form_validation->run() == FALSE) {
		   
		$this->session->set_flashdata('err_message',validation_errors());
		   
	   }else{	
		
	    $email_id= trim($this->input->post('user_email', TRUE));
	    
	    $getUserData = $this->user_model->getUserDetailByEmail($email_id);
	    
	    if(empty($getUserData)) {	
			$this->session->set_flashdata('err_message',$this->lang->line("Invalid_msg").' '.$this->lang->line("Email_lbl"));
		}    
		
		if(!empty($getUserData) && $getUserData[0]->user_status == 1) {	
		
		$encrypt_data = $this->common_model->encryptDecrypt('encrypt',json_encode(array('id'=>$getUserData[0]->user_id,'act'=>'reset'))); 	
		$reset_pass_url = base_url().'admin/login/resetpassword/'.$encrypt_data;	 
		$to = trim($getUserData[0]->user_email);
		$from = 'team@dubaiescorts.com';
		$name = 'Dubai Escorts';
		$message = 'Please <a href="'.$reset_pass_url.'">click</a> here or open url  for reset password <br/><br/> URL = '.$reset_pass_url;
		//echo $message;
		//exit();
	    $this->email->from($from, $name);
		$this->email->to($to);
		$this->email->subject('Reset Password');
		$this->email->message($message);
		$this->email->set_mailtype("html");

		$send = $this->email->send();
		//echo $this->email->print_debugger();
		
		if($send) {			
			$this->session->set_flashdata('resp_message',$this->lang->line("ForgetPassword_msg"));		
		}else{
			$this->session->set_flashdata('err_message',$this->lang->line("Failed_msg"));		
		  }
		
		}
	
	  }
      
        $this->load->view('admin/forget_password_view');
		
  } 
  
   public function resetpassword($encrypt_url=""){
	  
		$new_password = $this->input->post('new_password',true);
		$do_action = $this->input->post('do_action',true);

		if($do_action == 'reset_password') {
			
			  $dencrypt = $this->common_model->encryptDecrypt('decrypt',$encrypt_url);
			  
			  $dataArr = json_decode( $dencrypt);

			  if(!empty($dataArr) && $dataArr->id > 0) {
				  
				   $data['user_id'] = $dataArr->id;
			       $data['user_password'] = $new_password;
				  
					$getUserData = $this->user_model->updateUserPassword($data);
			  
					$this->session->set_flashdata('resp_message',$this->lang->line('PasswordChanged_msg'));
			  }else{
					$this->session->set_flashdata('err_message',$this->lang->line('Invalid_msg'));
				  }
			  
		}
					
		$this->load->view('admin/reset_password_view');   
   
   
   }
    
    public function logout() { 
		
		  $loginData = $this->session->userdata('adminLoginData');
		  
          $this->user_model->logoutTime( $loginData['userid']);
          
		  $this->session->sess_destroy('adminLoginData');
		  $this->session->sess_destroy('adminLogin');
                
		  redirect('admin/login/index/','location');
    }
    
}
?>
