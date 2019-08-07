<!---Adding Header----------->
<?php $this->load->view('admin/common/header_view'); ?>
<!------------End--------------->
<!---Adding Header----------->
<?php $this->load->view('admin/common/headmenu_view'); ?>
<!------------End--------------->
<!---Adding Header----------->
<?php $this->load->view('admin/common/left_view'); ?> 
<?php 
$error = validation_errors();

    if($error != ''){
        $errblock = 'block';
     }else{
        $errblock = 'none'; 
    }
//	print_r($categoryDetail);
	
	
?>
<div class="span9" id="content">
<div class="row-fluid">
<!-- block -->
<div class="block">
    <div class="navbar navbar-inner block-header">
        <div class="muted pull-left"><?php echo $this->lang->line('Category_lbl'); ?> </div>
    </div>
    <div class="block-content collapse in">
        <div class="span12">
                <!-- BEGIN FORM-->
    
        <?php  echo form_open('','id="form_sample_1" class="form-horizontal" enctype="multipart/form-data" onsubmit="customValidate()"'); ?>
                        
                        <fieldset>
                            <div class="alert" style="display:<?php echo $errblock;?>" ><?php echo $error; ?></div>
                            
                                <div class="control-group">
                                    <label class="control-label"><?php echo $this->lang->line('CategoryName_lbl'); ?><span class="required">*</span></label>
                                    <div class="controls">
                                        <input type="text" name="category_name" id="category_name" value="<?php echo (isset($categoryDetail->category_name)) ? $categoryDetail->category_name : set_value('category_name'); ?>" data-required="1" onblur="if(this.value!=''){checkCategory(this.value);}" class="span6 m-wrap"/>
                                        <div id="businessunique"></div>
                                    </div>
                                </div>
                                
                                <div class="control-group" id="maincategory" style="<?php if(isset($categoryDetail->p_category_id) && $categoryDetail->p_category_id!='0') echo 'display:none'; ?>">
									<label class="control-label"><?php echo $this->lang->line('MainCategory_lbl'); ?></label>
									<div class="controls">
										<input type="checkbox" id="main_cat" name="main_cat" class="main_cat mygroup" value="1"  <?php if( $categoryDetail->p_category_id=='0') echo 'checked="checked"'; ?> />                            
									</div>
                                </div>
                                
                                <div class="control-group" id="p_cat" style="<?php if( $categoryDetail->p_category_id=='0') echo 'display:none'; ?>" >
									<label class="control-label"><?php echo $this->lang->line('Category_lbl'); ?><span class="required">*</span></label>
									<div class="controls">
										<select class="span6 m-wrap mygroup" name="category" id="category" >
											<option value=""><?php echo $this->lang->line('Select_lbl'); ?></option>
											<?php
											foreach($categorylist as $val) { ?>
											<option value="<?php echo $val->category_id;?>" <?php echo ( $categoryDetail->p_category_id==$val->category_id )?'selected="selected"' : "" ;?>><?php echo $val->category_name;?></option>
											<?php  }  ?>
											
										</select>
									</div>
                                </div>
                                
                                <div class="control-group">
									<label class="control-label"><?php echo $this->lang->line('SeoUrl_lbl'); ?><span class="required">*</span></label>
									<div class="controls">
										<input type="text" name="seo_url" id="seo_url" data-required="1" value="<?php echo (isset($categoryDetail->seo_url)) ? $categoryDetail->seo_url : set_value('seo_url'); ?>"  onblur="if(this.value!=''){checkSeoUrl(this.value);}" class="span6 m-wrap"/> <div id="seounique"></div>
									</div>
                                </div>
                                
                                <div class="control-group">
                                   <label class="control-label"><?php echo $this->lang->line('MetaTitle_lbl'); ?></label>
                                   <div class="controls">
                                      <input type="text" name="meta_title" data-required="1" value="<?php echo (isset($categoryDetail->meta_title)) ? $categoryDetail->meta_title : set_value('meta_title'); ?>" class="span6 m-wrap"/>                           
                                   </div>
                               </div>
                               
                                <div class="control-group">
									<label class="control-label"><?php echo $this->lang->line('MetaDescription_lbl'); ?></label>
									<div class="controls">
										<input type="text" name="meta_description" data-required="1" value="<?php echo (isset($categoryDetail->meta_description)) ? $categoryDetail->meta_description : set_value('meta_description') ; ?>" class="span6 m-wrap"/>
									</div>
                                </div>
                                
                                <div class="control-group">
                                    <label class="control-label"><?php echo $this->lang->line('MetaKeywords_lbl'); ?></label>
                                    <div class="controls">
                                       <input type="text" name="meta_keywords" data-required="1"  value="<?php echo (isset($categoryDetail->meta_keywords)) ? $categoryDetail->meta_keywords : set_value('meta_keywords'); ?>"class="span6 m-wrap"/>                              
                                    </div>
                                </div>
                                
                                <div class="control-group">
									<label class="control-label"><?php echo $this->lang->line('MobileMetaTitle_lbl'); ?></label>
									<div class="controls">
										<input type="text" name="mobile_meta_title" data-required="1" value="<?php echo (isset($categoryDetail->mobile_meta_title)) ? $categoryDetail->mobile_meta_title : set_value('mobile_meta_title'); ?>" class="span6 m-wrap">
									</div>
                                </div>
                                
                                <div class="control-group">
                                   <label class="control-label"><?php echo $this->lang->line('MobileMetaDescription_lbl'); ?></label>
                                   <div class="controls">
                                       <input type="text" name="mobile_meta_description" data-required="1"  value="<?php echo (isset($categoryDetail->mobile_meta_description)) ? $categoryDetail->mobile_meta_description :  set_value('mobile_meta_description'); ?>"class="span6 m-wrap" />                          
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label"><?php echo $this->lang->line('MobileMetaKeywords_lbl'); ?></label>
                                    <div class="controls">
                                       <input type="text" name="mobile_meta_keywords" data-required="1" value="<?php echo (isset($categoryDetail->mobile_meta_keywords)) ? $categoryDetail->mobile_meta_keywords : set_value('mobile_meta_keywords'); ?>" class="span6 m-wrap">
                                    </div>
                                </div>
                                
                                <div class="control-group">
									<label class="control-label"><?php echo $this->lang->line('CategoryPageContent_lbl'); ?></label>
									<div class="controls">
										<textarea name="category_page_content" id="category_page_content" data-required="1" class="span6 m-wrap"><?php echo (isset($categoryDetail->category_page_content)) ? $categoryDetail->category_page_content : set_value('category_page_content'); ?></textarea>                            
									</div>
                                </div>
                
                                <div class="control-group">
                                     <label class="control-label"><?php echo $this->lang->line('Status_lbl'); ?></label>
                                     <div class="controls">
                                        <input type="checkbox" name="status" value="1" <?php if( $categoryDetail->status=='1') echo 'checked="checked"'; ?> />                            
                                     </div>
                                </div>
                                
                                <div class="form-actions">
                                   <button type="submit" name="submit" value="Validate" class="btn btn-primary"><?php echo $this->lang->line('Validate_lbl'); ?></button>
                                   <button type="button" class="btn"><?php echo $this->lang->line('Cancel_lbl'); ?></button>
                                </div>
                                
                        </fieldset>
                </form>
                <!-- END FORM-->
        </div>
    </div>
</div>
<!-- /block -->
</div>
</div>       
            
        
        <!--/.fluid-container-->
        <link href="<?php echo base_url();?>assets/admin/vendors/datepicker.css" rel="stylesheet" media="screen">
        <link href="<?php echo base_url();?>assets/admin/vendors/uniform.default.css" rel="stylesheet" media="screen">
        <link href="<?php echo base_url();?>assets/admin/vendors/chosen.min.css" rel="stylesheet" media="screen">

        <link href="<?php echo base_url();?>assets/admin/vendors/wysiwyg/bootstrap-wysihtml5.css" rel="stylesheet" media="screen">

        <script src="<?php echo base_url();?>assets/admin/vendors/jquery-1.9.1.js"></script>
        <script src="<?php echo base_url();?>assets/admin/bootstrap/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url();?>assets/admin/vendors/jquery.uniform.min.js"></script>
        <script src="<?php echo base_url();?>assets/admin/vendors/chosen.jquery.min.js"></script>
        <script src="<?php echo base_url();?>assets/admin/vendors/bootstrap-datepicker.js"></script>
        <script src="<?php echo base_url();?>assets/admin/vendors/ckeditor/ckeditor.js"></script>
        <script src="<?php echo base_url();?>assets/admin/vendors/ckeditor/adapters/jquery.js"></script>

        <script src="<?php echo base_url();?>assets/admin/vendors/wysiwyg/wysihtml5-0.3.0.js"></script>
        <script src="<?php echo base_url();?>assets/admin/vendors/wysiwyg/bootstrap-wysihtml5.js"></script>

        <script src="<?php echo base_url();?>assets/admin/vendors/wizard/jquery.bootstrap.wizard.min.js"></script>

	<script type="text/javascript" src="<?php echo base_url();?>assets/admin/vendors/jquery-validation/dist/jquery.validate.min.js"></script>
    <script src="<?php echo base_url();?>assets/admin/additional-methods.min.js"></script>
	<script src="<?php echo base_url();?>assets/admin/form-validation.js"></script>
        
	<script src="<?php echo base_url();?>assets/admin/scripts.js"></script>
<script>

	jQuery(document).ready(function() {   
	  // FormValidation.init();
	});
$(function() {
     $( 'textarea#category_page_content' ).ckeditor({width:'98%', height: '150px'});
 });	    
        
  $('.main_cat').click(function() {
    if($(this).is(":checked")) {
        $("#p_cat").hide(300);
    } else {
        $("#p_cat").show(200);
    }
}); 

$('#category').on('change',function(){
    if($(this).val()!=''){
        $('#maincategory').hide(300);
    } else {
        $('#maincategory').show(200);
    }
});
 $(function() {
            $(".datepicker").datepicker();
            $(".uniform_on").uniform();
            $(".chzn-select").chosen();
            $('.textarea').wysihtml5();

            $('#rootwizard').bootstrapWizard({onTabShow: function(tab, navigation, index) {
                var $total = navigation.find('li').length;
                var $current = index+1;
                var $percent = ($current/$total) * 100;
                $('#rootwizard').find('.bar').css({width:$percent+'%'});
                // If it's the last tab then hide the last button and show the finish instead
                if($current >= $total) {
                    $('#rootwizard').find('.pager .next').hide();
                    $('#rootwizard').find('.pager .finish').show();
                    $('#rootwizard').find('.pager .finish').removeClass('disabled');
                } else {
                    $('#rootwizard').find('.pager .next').show();
                    $('#rootwizard').find('.pager .finish').hide();
                }
            }});
            $('#rootwizard .finish').click(function() {
                alert('Finished!, Starting over!');
                $('#rootwizard').find("a[href*='tab1']").trigger('click');
            });
        });
       
        </script>
        <script>
/*function customValidate(){
	 if (document.getElementById("category_name_temp").value=='0') {
	document.getElementById("businessunique").innerHTML = "Category Name Already Exists Please try different";
	document.getElementById("category_name").value = "";
	 return false;
	 }
	 return false;
		
}*/
		
function checkCategory(txt_name){
	
 $.ajax({
	      url: "<?php echo base_url();?>admin/category/checkCategory/<?php echo $categoryDetail->category_id; ?>",
	      type:'get',
	      data : {txt_name:txt_name},
	      dataType:'json',
	      success : function(data) {

			if(data=='0'){
				$('#businessunique').html("<?php echo $this->lang->line('CategoryNameAlreadyExists_msg') ?>"); 
				$('#category_name').delay(50000).val('');
		    } else{
				$('#businessunique').html("<?php echo $this->lang->line('CategoryNameAvailable_msg') ?>");  
			}
	    }
   } );
    
 }
 function checkSeoUrl(seo){

  $.ajax({
	      url: "<?php echo base_url();?>admin/category/checkSeoUrl/<?php echo $categoryDetail->category_id; ?>",
	      type:'get',
	      data : {seo:seo},
	      dataType:'json',
	      success : function(data) {

			 if(data=='0'){
				$('#seounique').html("<?php echo $this->lang->line('SeoUrlAlreadyExists_msg') ?>"); 
				$('#seo_url').delay(50000).val('');
			 }else{
				$('#seounique').html("<?php echo $this->lang->line('SeoUrlAvailable_msg') ?>");  
		      }			 
	     }
   });
    
 }
</script>
<!---Adding Header----------->
<?php $this->load->view('admin/common/footer_view'); ?>
<!------------End--------------->        
