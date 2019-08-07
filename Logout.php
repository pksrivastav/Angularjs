<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 class Logout extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('authentication');
        $this->authentication->isLoggedIn();
    }
    
    public function index(){
    	$logSessArr = $this->session->userdata;
    	$logSessArr['Message'] = 'Logged out';
    	$this->userlog->write_log_db('1',json_encode($logSessArr), 2);
        $this->session->sess_destroy();
        redirect('login');
    }        
 }
 ?>