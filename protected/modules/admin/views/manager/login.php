<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
      <head>
           <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
             <title>USHO登录</title>
	<!--- CSS --->
        <link rel="stylesheet" href="<?php echo ADMIN_CSS_URL ?>style.css" type="text/css" />
	<!--- Javascript libraries (jQuery and Selectivizr) used for the custom checkbox --->
	<!--[if (gte IE 6)&(lte IE 8)]>
		<script type="text/javascript" src="<?php echo ADMIN_CSS_URL?>jquery-1.7.1.min.js"></script>
		<script type="text/javascript" src="<?php echo ADMIN_CSS_URL?>selectivizr.js"></script>
		<noscript><link rel="stylesheet" href="<?php echo ADMIN_CSS_URL?>fallback.css" /></noscript>
	<![endif]-->
	</head>
	<body>
            
		<div id="container">
                    <?php $form=$this->beginWidget('CActiveForm');?>
	                           <div class="login">LOGIN</div>
		           <div class="username-text"><?php echo $form->labelEx($login_model, 'account');?></div>
		            <div class="password-text"><?php echo $form->labelEx($login_model,'password');?></div>
			<div class="username-field">
				<?php echo $form->textField($login_model,'account',  array('class'=>'TxtUserNameCssClass','maxlength'=>20));?>
                                                   </div>
			<div class="password-field">
				<?php echo $form -> passwordField($login_model,'password',array('class'=>'TxtPasswordCssClass','maxlength'=>20)); ?>
			</div>
                                                  <div style="margin-top: 10px;float: left; margin-left: 20px;">
                                                                <?php echo $form->error($login_model,'account');?>
                                                                <?php echo $form->error($login_model,'password');?>
                                                  </div>
			<input type="checkbox" name="remember-me" id="remember-me" /><label for="remember-me">Remember me</label>
                                                 <input type="submit" name="submit" value="GO" />
                                          
                     <?php $this->endWidget()?>
		</div>
           
		<div id="footer">
			 <a href="http://www.usho.cn/" target="_blank" >usho</a>
		</div>
	</body>
</html>
