<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
class Category extends CI_Controller{
	
    function __construct(){
		
        parent::__construct(); 
        if(!$this->session->userdata('adminLogin')){           
           redirect('admin/login/','location');   
           exit;
        } 
      $this->load->model(array('category_model','common_model'));
	
      $this->load->library('session');
      $this->load->helper('form');
      $this->load->helper('url');
      $this->load->helper('html');
      $this->load->database();
      $this->load->library('form_validation');
        //$this->lang->load(array('error', 'label'),'english');
    }
    
    public function categoryList(){
		
        $sessiondata = $this->session->all_userdata('sessiondata');
        
        $allCategory = $this->category_model->getAllCategory(array('status'=>''));
        
        $data['sessiondata'] = $sessiondata;
        $data['allcategory'] = $allCategory;
        
    	$this->load->view('admin/categorylist_view', $data);
    }
    
    public function editCategory($categoryid='0'){ 
		
        $categoryid = (int)$categoryid;
        $data = array();
        
        $sessiondata = $this->session->all_userdata('sessiondata');
		
		if($this->input->post('submit') == 'Validate') {

		$this->form_validation->set_rules('category_name', $this->lang->line('CategoryName_lbl'), 'trim|required|callback_validate_Category['.$categoryid.']');
		$this->form_validation->set_message('validate_Category',$this->lang->line('CategoryNameAlreadyExists_msg'));

		if($this->input->post('main_cat')==1) {
			$this->form_validation->set_rules('main_cat', $this->lang->line('MainCategory_lbl'),'trim');       
		}else{
			$this->form_validation->set_rules('category', $this->lang->line('Category_lbl'), 'trim|required');
		}

		$this->form_validation->set_rules('seo_url', $this->lang->line('SeoUrl_lbl'), 'trim|required|callback_validate_seo['.$categoryid.']');
		$this->form_validation->set_message('validate_seo',$this->lang->line('SeoUrlAlreadyExists_msg'));
	   // $this->form_validation->set_rules('meta_title', 'Meta title', 'trim|required');
	   // $this->form_validation->set_rules('meta_description', 'Meta Description', 'trim|required');
	   // $this->form_validation->set_rules('meta_keywords', 'Meta Keywords', 'trim|required');
	   // $this->form_validation->set_rules('mobile_meta_title', 'Mobile Title', 'trim|required');
	   // $this->form_validation->set_rules('mobile_meta_description', 'Mobile Description','trim|required');
	   // $this->form_validation->set_rules('mobile_meta_keywords', 'Mobile Description', 'trim|required');    
	   $this->form_validation->set_rules('category_page_content', 'Description', 'trim|callback_getnumwords');
           $this->form_validation->set_message('getnumwords','Category Content '.$this->lang->line('maxword20_msg'));

	//var_dump(validation_errors());die;	
		if ($this->form_validation->run() == TRUE)
		{                    
			$data['categoryid']  				= $this->security->xss_clean($categoryid);
			$data['category_name']  			= $this->security->xss_clean($this->input->post('category_name'));
			
		 if($this->input->post('main_cat')==1){
			$data['p_category_id']  			= 0;
		 }else{
			$data['p_category_id']  			= $this->security->xss_clean($this->input->post('category'));
		 } 
			$data['seo_url']        			= $this->common_model->makePretyUrl($this->security->xss_clean($this->input->post('seo_url')));
			$data['meta_title']     			= $this->security->xss_clean($this->input->post('meta_title'));
			$data['meta_description']        	= $this->security->xss_clean($this->input->post('meta_description'));
			$data['meta_keywords']          	= $this->security->xss_clean($this->input->post('meta_keywords'));
			$data['mobile_meta_title']      	= $this->security->xss_clean($this->input->post('mobile_meta_title'));
			$data['mobile_meta_description']    = $this->security->xss_clean($this->input->post('mobile_meta_description'));
			$data['mobile_meta_keywords']      	= $this->security->xss_clean($this->input->post('mobile_meta_keywords'));
			$data['category_page_content']      = $this->security->xss_clean($this->input->post('category_page_content'));
			$data['status']       				= $this->security->xss_clean($this->input->post('status'));
		  
			$result = $this->category_model->addCategoryDetails($data);							
			// Now we verify the result
				if($result)
				{     
				  $action = ($categoryid) ? $this->lang->line('Update_msg') : $this->lang->line('Add_msg');
				  $this->session->set_flashdata('resp_message', $this->lang->line('Successful_msg').' '.$action);                          
				  redirect('admin/category/categoryList/');
				}
		 }
		}
        
        $autoCategory = $this->category_model->getCategory($categoryid);
		$categoryDetail = $this->category_model->getCategoryDetail(array('cat_id'=>$categoryid));
		
        $data['sessiondata'] = $sessiondata;
        $data['categorylist'] = $autoCategory;
		$data['categoryDetail'] = $categoryDetail;
		
        $this->load->view('admin/editcategory_view',$data);
    } 
  
  
  
 public function checkCategory($id='0'){
	 
	 if($id>0){
		$sql = "select category_name  from escort_category where category_name='".$_GET['txt_name']."' and  category_id!='".$id."'";	
	 }else{
		$sql = "select category_name  from escort_category where  category_name='".$_GET['txt_name']."' "; 	 
	 }
		 
	$query=$this->db->query($sql);
       if ($query->num_rows() > 0){
			echo '0';//alreadyexist
		}
		else{
			echo '1';//"Available";	
		}
       
	 }
	 
 public function checkSeoUrl($id='0'){
	 
	 if($id>0){
		$sql = "select seo_url  from escort_category where seo_url='".$this->common_model->makePretyUrl($_GET['seo'])."' and  category_id!='".$id."'";
	 }else{
		$sql = "select seo_url  from escort_category where  seo_url='".$this->common_model->makePretyUrl($_GET['seo'])."' ";  
	 }
		 
	 $query=$this->db->query($sql);
       if ($query->num_rows() > 0){
			echo '0';//alreadyexist
		}else{
			echo '1';//"Available";	
			}
       
	 }
	 
function validate_Category($str,$id) {
	
  if($id>0){
		$sql = "select category_name  from escort_category where category_name='".$str."' and  category_id!='".$id."'";	
	 }else{
		$sql = "select category_name  from escort_category where  category_name='".$str."' "; 		 
	 }
		 
	$query=$this->db->query($sql);
       if ($query->num_rows() > 0){
		 return FALSE;
		}else{
		 return TRUE;	
		}

}

 function validate_seo($str,$id)
{
	if($id>0){
		$sql = "select seo_url  from escort_category where seo_url='".$this->common_model->makePretyUrl($str)."' and  category_id!='".$id."'";	
	 }else{
		$sql = "select seo_url  from escort_category where  seo_url='".$this->common_model->makePretyUrl($str)."' "; 	 
	 }
		 
	$query=$this->db->query($sql);
       if ($query->num_rows() > 0){
		 return FALSE;
		}
		else{
		 return TRUE;	
			}

}

function getnumwords($string) {
     
    $string = preg_replace('/\s+/', ' ', trim($string));
    $words = explode(" ", $string);
   
    if(count($words) > 20){       
    return false;
    }else{
       return true; 
    }
   }
 
}    
