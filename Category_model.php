<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category_model extends CI_Model{
	
    function __construct(){
        parent::__construct();
    }
    
    public function addCategoryDetails($data){ 
	//print_r($data);die; 
    $sql = "insert into escort_category (category_id, p_category_id,category_name,seo_url,meta_title,meta_description,
        meta_keywords,mobile_meta_title,mobile_meta_description,mobile_meta_keywords,category_page_content,status,creation_date) 
        values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,now())
        ON DUPLICATE KEY UPDATE p_category_id = VALUES(p_category_id),category_name = VALUES(category_name),
        seo_url = VALUES(seo_url),meta_title = VALUES(meta_title),
        meta_description = VALUES(meta_description),meta_keywords = VALUES(meta_keywords),
        mobile_meta_title = VALUES(mobile_meta_title),mobile_meta_description = VALUES(mobile_meta_description),
        mobile_meta_keywords=VALUES(mobile_meta_keywords),category_page_content = VALUES(category_page_content),status = VALUES(status),creation_date= now()";		
        $this->db->query($sql, array($data['categoryid'],$data['p_category_id'],$data['category_name'],
        $data['seo_url'], $data['meta_title'], $data['meta_description'], $data['meta_keywords'],
        $data['mobile_meta_title'],$data['mobile_meta_description'],$data['mobile_meta_keywords'],$data['category_page_content'],
            $data['status']));	
        if(!$data['categoryid']){
                return $this->db->insert_id();
        }else{
                return $data['categoryid'];
        }		
    }

    
    public function getCategory($id=0){
		
        $this->db->select('category_id,category_name');
        $this->db->from('escort_category');
        $this->db->where('p_category_id', 0);
		if($id>0){
		$this->db->where('category_id !=', $id);
			}
        $query = $this->db->get();
            if ($query->num_rows() > 0){
		foreach ($query->result() as $row)
		{
                    $data[] = $row;
		}
               
		return $data;
	  }
        return false;	
    }
	
	  public function getCategoryDetail($args=""){
		
		$cat_id = (isset($args['cat_id']) && $args['cat_id'] > 0) ? $args['cat_id'] : "";
		$seo_url = (isset($args['seo_url'])) ? $args['seo_url'] : "";
	 
	   if($cat_id!="" || $seo_url!="") {	
		  
        $this->db->select('*');
        $this->db->from('escort_category');
        
       if($cat_id > 0) {	 
        $this->db->where('category_id',$cat_id);
       }
       
       if($seo_url!="") {	 
        $this->db->where('seo_url',$seo_url);
       }
        
        $query = $this->db->get();
       if ($query->num_rows() > 0){
		foreach ($query->result() as $row) {
                    $data[] = $row;
		   }        
		return $data['0'];
	   }
	   
	  } 
	
       return false;	
    }
	 public function getCategoryName($id){
		 
        $this->db->select('category_name');
        $this->db->from('escort_category');
        $this->db->where('category_id',$id);
        $query = $this->db->get();
            if ($query->num_rows() > 0){
		foreach ($query->result() as $row)
		{
                    $data[] = $row;
		}
               
		return $data['0'];
	}
        return false;	
    }
    
    public function getCategoryNameBySeo($seo_url){
		 
        $this->db->select('category_name');
        $this->db->from('escort_category');
        $this->db->where('seo_url',$seo_url);
        $query = $this->db->get();
       if ($query->num_rows() > 0){
		foreach ($query->result() as $row) {
              $data[] = $row;
		}
               
		return $data['0'];
	   }
        return false;	
    }
    
    public function getAllCategory($args=""){
		
		$status = isset($args['status']) ? $args['status'] : "";
		
		$this->db->select('cat.category_id,cat.p_category_id,cat.category_name,cat.seo_url,cat.meta_title,cat.status,cat.creation_date,(SELECT category_name FROM escort_category WHERE category_id = cat.p_category_id) as parent_category_name');
		$this->db->from('escort_category as cat');

     if($status!="") {	 
		$this->db->where('cat.status',$status);
	  }
	  	
      $query = $this->db->get();    
      if ($query->num_rows() > 0){	         
		return $query->result();
	   }
        return false;
    }
    
}
?>
