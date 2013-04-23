<script src="<?php echo $this->uri->config->item('base_url'); ?>layout/js/app/auth/index.js"></script>
<?php
$login = array(
	'name'	=> 'login',
	'id'	=> 'login',
	'value' => set_value('login'),
	'maxlength'	=> 80,
	'size'	=> 30,
	'placeholder'=>'Username',
	'class'=>"span4"
);
$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'size'	=> 30,
	'placeholder'=>'Password',
	'class'=>"span4"
);
$submit = array(
	'class'=>"btn btn-info btn-block",
	'type'=>'submit',
	'name'=>'submit',
	'value'=>'Sign in'
		
);
?>
<?php echo form_open($this->uri->uri_string(),array('id'=>'myFormId')); ?>
<div class="container">
	<div class="row">
		<div class="span4 offset4 well">
			<legend>Please Sign In</legend>
			<?php if(isset($error) && $error){ ?>
          	<div class="alert alert-error">
                Incorrect Username or Password!
            </div>
            <?php } ?>
			<?php echo form_input($login); ?>
			<?php echo form_password($password); ?>
			<?php echo form_submit($submit); ?>
			
		</div>
	</div>
</div>

