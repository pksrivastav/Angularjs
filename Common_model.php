<?php 
Class Common_model extends CI_Model{

function __construct(){

 parent::__construct();

} 
	public function get_result_where($table='', $where='') 

	{          

		$query = $this->db->query("SELECT * FROM $table WHERE $where");

		return $query->result();

	}

	

	public function get_result_whereg($table='', $field='*', $where='') 

	{ 

	$query = $this->db->query("SELECT $field FROM $table WHERE $where");

	// echo $this->db->last_query(); 

	return $query->result();

	}



	public function get_single_field($field =array(), $table= '', $where='') 

	{ 

		$query = $this->db->query("SELECT $field FROM $table WHERE $where");

		 //echo $this->db->last_query(); di();

		return $query->result();

	}

		

	public function update_data($table='',$data=array(),$where='')

	{

		return $this->db->update($table, $data, $where);

		 //echo $this->db->last_query(); di();
        
	}

	

	public function insert_record($table='',$data=array()){

		$this->db->insert($table, $data);

		//echo $this->db->last_query(); die('<br>testing');

		return $this->db->insert_id();

	}

	

	public function delete_record($table='',$where=''){

		return $this->db->delete($table, $where); 

	 }

	

	 

	 

	public function uploadFile($files=array(), $input_field='', $upload_path='', $create_thumb=FALSE,$thumb_path='',$thumb_width=200,$thumb_height=100){


		$limit = count($files[$input_field]['tmp_name']);	

		chmod($upload_path, DIR_WRITE_MODE);

		$return_msg = array();



		$config['upload_path'] = $upload_path; 
		$config['allowed_types'] = 'pdf|doc|docx';
		$config['encrypt_name'] = TRUE;

		for($i = 0;$i<$limit;$i++)

		{
			if( $files[$input_field]['name'][$i]!='' ){

			$_FILES[$input_field]['name']= $files[$input_field]['name'][$i];
			$_FILES[$input_field]['type']= $files[$input_field]['type'][$i];
			$_FILES[$input_field]['tmp_name']= $files[$input_field]['tmp_name'][$i];
			$_FILES[$input_field]['error']= $files[$input_field]['error'][$i];
			$_FILES[$input_field]['size']= $files[$input_field]['size'][$i]; 

			$this->load->library('upload', $config);
			$this->upload->do_upload($input_field);
			$upload_info = $this->upload->data();

			$return_msg[$i]['uploaded_file_name'] = $upload_info['file_name'];
			$return_msg[$i]['uploaded_file_name_without_ext'] = $upload_info['raw_name'];
			$return_msg[$i]['uploaded_file__ext'] = $upload_info['file_ext'];

		// pr($return_msg); di();

		}

	}


	if($create_thumb===TRUE) {

		$config['create_thumb'] = TRUE;
		$config['maintain_ratio'] = TRUE;
		$config['width'] = $thumb_width;
		$config['height'] = $thumb_height;

		$limit = count($return_msg);

		for($i=0;$i<$limit;$i++){

		//0b67ba70f0a362c2e49f8773a2731adc_thumb

		$config['source_image'] = $upload_path.$return_msg[$i]['uploaded_file_name']; 
		$config['new_image'] = $thumb_path.$return_msg[$i]['uploaded_file_name']; 
		
		$this->load->library('image_lib', $config); 
		$this->image_lib->initialize($config);
		$this->image_lib->resize();

		$return_msg[$i]['thumb_image'] = $return_msg[$i]['uploaded_file_name_without_ext'].$return_msg[$i]['uploaded_file__ext'];

		}

	}


  // di();

   return $return_msg;

}



public function uploadImage($files=array(), $input_field='', $upload_path='', $create_thumb=FALSE, $thumb_path='', $thumb_width=80, $thumb_height=60,$create_icon=FALSE,$icon_width=20,$icon_height=20,$icon_path = '')

{

	//print_r($files);	

	$limit = count($files[$input_field]['tmp_name']);

	chmod($upload_path, DIR_WRITE_MODE);

	$return_msg = array();

	$config['upload_path'] = $upload_path; 
	$config['file_name'] = 'pic-'.time();
	$config['allowed_types'] = '*';
	$config['encrypt_name'] = false;
	$config['max_size']	= '6024';  // 1MB
	$config['max_width']  = '0';
	$config['max_height']  = '0';

	
	
	if( $files[$input_field]['name']!='' ) {

		$_FILES[$input_field]['name']= $files[$input_field]['name'];
		$_FILES[$input_field]['type']= $files[$input_field]['type'][$i];
		$_FILES[$input_field]['tmp_name']= $files[$input_field]['tmp_name'];
		$_FILES[$input_field]['error']= $files[$input_field]['error'];
		$_FILES[$input_field]['size']= $files[$input_field]['size']; 
		
		$this->load->library('upload');
		$this->upload->initialize($config);
		
		if(! $this->upload->do_upload($input_field)) {
				$error = array('error' => $this->upload->display_errors());
				 echo '<p class="error"> *Please upload only .jpg,.png,.jpeg. files or max upload size less than 1 Mb</p>';
				print_r($error);
				exit();
			 }

		$upload_info = $this->upload->data();

		$return_msg['uploaded_file_name'] = $upload_info['file_name'];
		$return_msg['uploaded_file_name_without_ext'] = $upload_info['raw_name'];
		$return_msg['uploaded_file__ext'] = $upload_info['file_ext'];	

	}


//--------------

//print_r($return_msg); die();

		if($create_thumb===TRUE) {

			chmod($thumb_path, DIR_WRITE_MODE);

			$config['create_thumb'] = TRUE;
			$config['maintain_ratio'] = TRUE;
			$config['width'] = $thumb_width;
			$config['height'] = $thumb_height;

			$limit = count($return_msg);

		
			//0b67ba70f0a362c2e49f8773a2731adc_thumb

			$config['source_image'] = $upload_path.$return_msg['uploaded_file_name']; 
			$config['new_image'] = $thumb_path.$return_msg['uploaded_file_name']; 

			$this->load->library('image_lib', $config); 
			$this->image_lib->initialize($config);
			$this->image_lib->resize();

			$return_msg['thumb_image'] = $return_msg['uploaded_file_name_without_ext'].$return_msg['uploaded_file__ext'];			
		}
		
	 if($create_icon===TRUE) {

		chmod($icon_path, DIR_WRITE_MODE);

		$config_value['create_thumb'] = false;
		$config_value['maintain_ratio'] = TRUE;
		$config_value['width'] = $icon_width;
		$config_value['height'] = $icon_height;
		$limit = count($return_msg);

			//0b67ba70f0a362c2e49f8773a2731adc_thumb

		$config_value['source_image'] = $upload_path.$return_msg['uploaded_file_name']; 
		$config_value['new_image'] = $icon_path.$return_msg['uploaded_file_name']; 
		$this->load->library('image_lib', $config_value); 
		$this->image_lib->initialize($config_value);
		$this->image_lib->resize();

		$return_msg['icon_image'] = $return_msg['uploaded_file_name_without_ext'].$return_msg['uploaded_file__ext'];

	}

// di();

 return $return_msg;

}





public function uploadGalleryImage($files=array(), $input_field='', $upload_path='',$create_thumb=FALSE, $thumb_path='', $thumb_width=80, $thumb_height=60,$create_icon=FALSE,$icon_width=20,$icon_height=20,$icon_path = '')

{

	//print_r($files);	

	$limit = count($files[$input_field]['tmp_name']);

	chmod($upload_path, DIR_WRITE_MODE);

	$return_msg = array();

	$config['upload_path'] = $upload_path; 
	$config['file_name'] = 'pic-'.time();
	$config['allowed_types'] = 'gif|jpg|jpeg|png';
	$config['encrypt_name'] = false;
	$config['max_size']	= '1024';  // 1MB
	$config['max_width']  = '0';
	$config['max_height']  = '0';



for($i = 0;$i<$limit;$i++)

{	

	if( $files[$input_field]['name'][$i]!='' )

	{

		$_FILES[$input_field]['name']= $files[$input_field]['name'][$i];
		$_FILES[$input_field]['type']= $files[$input_field]['type'][$i];
		$_FILES[$input_field]['tmp_name']= $files[$input_field]['tmp_name'][$i];
		$_FILES[$input_field]['error']= $files[$input_field]['error'][$i];
		$_FILES[$input_field]['size']= $files[$input_field]['size'][$i]; 
		
		$this->load->library('upload');
		$this->upload->initialize($config);
            
		if(! $this->upload->do_upload($input_field)) {
				$error = array('error' => $this->upload->display_errors());
				 echo '<p class="error"> *Please upload only .jpg,.png,.jpeg. files or max upload size less than 50 Mb</p>';
				print_r($error);
				exit();
			 }
		

		$upload_info = $this->upload->data();

		$return_msg[$i]['uploaded_file_name'] = $upload_info['file_name'];
		$return_msg[$i]['uploaded_file_name_without_ext'] = $upload_info['raw_name'];
		$return_msg[$i]['uploaded_file__ext'] = $upload_info['file_ext'];

	}

}

//--------------

//print_r($return_msg); die();

if($create_thumb===TRUE) {

	chmod($thumb_path, DIR_WRITE_MODE);

	$config['create_thumb'] = TRUE;
	$config['maintain_ratio'] = TRUE;
	$config['width'] = $thumb_width;
	$config['height'] = $thumb_height;

	$limit = count($return_msg);

		for($i=0;$i<$limit;$i++)  {

			//0b67ba70f0a362c2e49f8773a2731adc_thumb

			$config['source_image'] = $upload_path.$return_msg[$i]['uploaded_file_name']; 
			$config['new_image'] = $thumb_path.$return_msg[$i]['uploaded_file_name']; 

			$this->load->library('image_lib', $config); 
			$this->image_lib->initialize($config);
			$this->image_lib->resize();

			$return_msg[$i]['thumb_image'] = $return_msg[$i]['uploaded_file_name_without_ext'].$return_msg[$i]['uploaded_file__ext'];

		}

}

if($create_icon===TRUE){

	chmod($icon_path, DIR_WRITE_MODE);

	$config_value['create_thumb'] = false;
	$config_value['maintain_ratio'] = TRUE;
	$config_value['width'] = $icon_width;
	$config_value['height'] = $icon_height;
	$limit = count($return_msg);

	for($i=0;$i<$limit;$i++)

	{

		//0b67ba70f0a362c2e49f8773a2731adc_thumb

		$config_value['source_image'] = $upload_path.$return_msg[$i]['uploaded_file_name']; 
		$config_value['new_image'] = $icon_path.$return_msg[$i]['uploaded_file_name']; 
		$this->load->library('image_lib', $config_value); 
		$this->image_lib->initialize($config_value);
		$this->image_lib->resize();

		$return_msg[$i]['icon_image'] = $return_msg[$i]['uploaded_file_name_without_ext'].$return_msg[$i]['uploaded_file__ext'];

	}

}

 return $return_msg;

}













//----------------   modules---------------------------------

public function getSingle($table,$field,$id,$idvalue,$extratext='')

{

$text="select $field from $table where $id='$idvalue' $extratext";

$query = $this->db->query($text);

if($query->row()>0)

{

return $query->row()->$field;

}

}

//----------------

public function getSingleResult($sql)

{

$query = $this->db->query($sql);

return $query->row()->newval;

}

//----------------

public function updateField($table,$field,$fieldvalue,$id,$idvalue)

{

echo $sql="update $table set $field='$fieldvalue' where $id='$idvalue'";

$query = $this->db->query($sql);

//return $query->result();

}

//----------------

 public function count_record ($table,$condition="")

 {

if($table!="" && $condition!="") 

{

 $this->db->from($table);

 $this->db->where($condition); 

 $num = $this->db->count_all_results();

 // echo $this->db->last_query();

 }

 else

 {

 $num = $this->db->count_all($table);

 //echo $this->db->last_query();

}

return $num;

 }

 //----------------

public function getq($sql)

{

$query = $this->db->query($sql);

return $query->result();

} 

public function queryonly($sql)

{

$query = $this->db->query($sql);

} 

//----------------

public function totalNum($table,$field,$value,$extratext='')

{

$sql="select count(*) as newval from $table where $field='$value' $extratext ";

$query = $this->db->query($sql);

return $query->row()->newval;

}

//----------------

public function delRow($table,$id,$idvalue, $extratext='')

{

$query = $this->db->query(" delete from $table where $id='$idvalue' $extratext "); 

//return $query->result();

}

//----------------

public function firstUpper($string)

{

return ucwords(strtolower($string));

} 

	public function DateFormat($datetime,$i=0)

	{

	if($i==0) return date('d M, Y',strtotime($datetime));

	elseif($i==1) return date('d M Y, H:i',strtotime($datetime));

	else return date('d M Y, H:i:s',strtotime($datetime));

	}

	//---------------------

	

	public function redir($page)

	{

	header("location: $page");

	exit();

	}

	//---------------------

	

	public function numf($value)

	{

	if (is_numeric($value)) return number_format($value, 2, '.', '');

	}

	//---------------------

	

	public function delete_cache($uri_string=null)

	{}

	//---------------

	public function server_date()

	{}

	//-------------

	public function onClickBlur($value)

	{}

	//---------------------

	

	public function call_button_div($give_delete=0, $give_active=0, $give_sort=0, $give_back=0, $give_addnew='#')

	{}

//------------ 

	public function admin_paging($all=0,$firstval=0)

		{}

//-----------------------------------		

	public	function removefromQS()

{    

	$qry_str=$HTTP_SERVER_VARS['argv'][0];	

	$m=$_GET;	

	$numargs = func_num_args();

    $arg_list = func_get_args();	

	for ($i = 0; $i < $numargs; $i++) 

	{

       unset($m[$arg_list[$i]]);			

    }

	$qry_str=$this->common_model->qry_str($m);

	return $qry_str;

}

//--------------------------------

	public function qry_str($arr, $skip = '')

	{

	$s = "?";

	$i = 0;

	foreach($arr as $key => $value) {

	if ($key != $skip) {

	if ($i == 0) {

	$s .= "$key=$value";

	$i = 1;

	} else {

	$s .= "&$key=$value";

	} 

	} 

	} 

	return $s;

	} 	

//--------------------------------------------



public function back($val=1)

	{

	echo 

	"<script type='text/javascript'>

	history.go(-$val);

	</script>";

	exit();

	}

//------------------------------------

public function getcat($id)

{ return 	$this->common_model->getSingle(TBL_CAT,'category','id',$id); }

//------------------------------

public function getparent($parent)

{ return 	$this->common_model->getSingle(TBL_CAT,'parent','id',$parent); }

//----------------------------------------------

public function parentlink($parent)

{

$currparent= $this->common_model->getparent($parent);			

if($currparent>0)

{	              			

?>

<a href="<?php echo ADMIN_URL."categories/subcategories/$currparent".URL_EXT; ?>"><?php echo  $this->common_model->getcat($currparent); ?></a><span class="divider"> &laquo;</span>

<?php			

return $this->common_model->parentlink($currparent);

}			

}


public function makePretyUrl($str){
	  
	if($str !== mb_convert_encoding( mb_convert_encoding($str, 'UTF-32', 'UTF-8'), 'UTF-8', 'UTF-32') )
		$str = mb_convert_encoding($str, 'UTF-8', mb_detect_encoding($str));
	$str = htmlentities($str, ENT_NOQUOTES, 'UTF-8');
	$str = preg_replace('`&([a-z]{1,2})(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i', '\1', $str);
	$str = html_entity_decode($str, ENT_NOQUOTES, 'UTF-8');
	$str = preg_replace(array('`[^a-z0-9]`i','`[-]+`'), '-', $str);
	$str = strtolower( trim($str, '-') );
	return $str;
	
	} 
	
 function encryptDecrypt($action, $string) {
	 
    $output = false;

    $encrypt_method = "AES-256-CBC";
    $secret_key = '#45FRD@#$%';
    $secret_iv = '#hvdj^7ikh';

    // hash
    $key = hash('sha256', $secret_key);
    
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    if( $action == 'encrypt' ) {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    }
    else if( $action == 'decrypt' ){
		try{
			$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
			}catch(Exception $e) {
				echo 'Caught exception: ',  $e->getMessage(), "\n";
				exit;
				}
         
    }

    return $output;
}
	
/*//-----------------------------

public function all_category($all_category, $category)

	{

		foreach($all_category as $cat)

		{

			?>

            <option value="<?php echo $cat->id; ?>" <?php if($cat->id==$category) echo 'selected';?>><?php if($cat->parent!=0) echo '&raquo;'; echo $cat->category; ?></option>

            <?php

            if(($cat->parent)==0)

            {

            $where="where parent='$cat->id' ";

            $all_category1= $this->common_model->get_result_whereg(TBL_CAT,' `id`,`category`,`parent` ',$where);

            echo $this->common_model->all_category($all_category1, $category);

			}			

		}									

}	

//----------------------------	

public function root_cat($cat)	

{

	$curr=$this->common_model->getSingle(TBL_CAT,'parent','id',$cat);

	if($this->common_model->getSingle(TBL_CAT,'parent','id',$curr)>0) return $this->common_model->root_cat($curr);	

	else return $curr;

}

//-----------------------

*/
public function getPageDetail($slug =""){
        $page_slug = (isset($slug['page_slug'])) ? $slug['page_slug'] : "";
        $this->db->select('*');
        $this->db->from('escort_pages');
        if($page_slug!="") {
            $this->db->where('page_slug',$page_slug);
	
	}        
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

}
?>