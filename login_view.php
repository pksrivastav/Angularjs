<?php 
$attributes = 'name="login" autocomplete="off"';
?>
<!DOCTYPE html>
<html>
  <head>
    <title><?php echo $this->lang->line('Login_title_lbl'); ?>   </title>
    <!-- Bootstrap -->
    <link href="<?php echo base_url();?>assets/admin/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="<?php echo base_url();?>assets/admin/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
    <link href="<?php echo base_url();?>assets/admin/styles.css" rel="stylesheet" media="screen">
     <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <script src="<?php echo base_url();?>assets/admin/vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
  </head>
  
  <body id="login">
	  
    <div class="container">	 
    
      <?php  echo form_open(base_url().'admin/login/process/','id="form_sample_1" class="form-signin"'); ?>
      
       <?php $err_message = $this->session->flashdata('err_message'); 
	   if($err_message) { ?>
		 <div class="alert" ><?php echo $err_message; ?></div>
		<?php } ?>
      
        <h2 class="form-signin-heading"><?php echo $this->lang->line('Signin_lbl'); ?></h2>
       
        <input type="text" name="username" class="input-block-level" placeholder="<?php echo $this->lang->line('Email_lbl'); ?>">
       
        <input type="password" name="password" class="input-block-level" placeholder="<?php echo $this->lang->line('Password_lbl'); ?>">
        
        <label class="checkbox">
          <input type="checkbox" value="remember-me"><?php echo $this->lang->line('Remember_lbl'); ?> 
        </label>
        
        <select onchange="javascript:window.location.href='<?php echo base_url(); ?>LanguageSwitcher/switchLang/'+this.value;">
			<option value="english" <?php if($this->session->userdata('site_lang') == 'english') echo 'selected="selected"'; ?>>English</option>
			<option value="arabic" <?php if($this->session->userdata('site_lang') == 'arabic') echo 'selected="selected"'; ?>>Arabic</option>
			<!-- <option value="french" <?php if($this->session->userdata('site_lang') == 'french') echo 'selected="selected"'; ?>>French</option>
			<option value="german" <?php if($this->session->userdata('site_lang') == 'german') echo 'selected="selected"'; ?>>German</option>   -->
		</select>
		
		 <div class="control-group">
			<button class="btn btn-large btn-primary" type="submit"><?php echo $this->lang->line('Signin_lbl'); ?></button>
         </div>
         
         <div class="controler">
           <label><a href="<?php echo base_url().'admin/login/forgetpassword/'; ?>" ><?php echo $this->lang->line('LostPassword_lbl'); ?></a></label>                             
          </div>
          
      </form>
    </div> <!-- /container -->
    
    <script src="<?php echo base_url();?>assets/admin/vendors/jquery-1.9.1.min.js"></script>
    <script src="<?php echo base_url();?>assets/admin/bootstrap/js/bootstrap.min.js"></script>
    
  </body>
</html>
