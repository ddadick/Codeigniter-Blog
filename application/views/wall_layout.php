<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>
	<script type="text/javascript">
		var Test ={
			baseUrl:'<?php echo $this->uri->config->item('base_url') ?>'
		}
	</script>
	<script src="<?php echo $this->uri->config->item('base_url'); ?>layout/js/jquery.min.js"></script>
	<link href="<?php echo $this->uri->config->item('base_url'); ?>layout/js/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<script src="<?php echo $this->uri->config->item('base_url'); ?>layout/js/plugins/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?php echo $this->uri->config->item('base_url'); ?>layout/js/app/wall/index.js"></script>
	<script src="<?php echo $this->uri->config->item('base_url'); ?>layout/js/app/comment/default.js"></script>
</head>
<body>

<div class="navbar">
	<div class="navbar-inner">
		<div class="container-fluid">
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			<a class="brand" href="#" name="top">Brand Name</a>
			<div class="nav-collapse collapse">
				<ul class="nav">
					<li><a href="#"><i class="icon-home"></i> Home</a></li>
					<li class="divider-vertical"></li>
					<li class="active"><a href="#"><i class="icon-file"></i> Pages</a></li>
					<li class="divider-vertical"></li>
					<li><a href="#"><i class="icon-envelope"></i> Messages</a></li>
					<li class="divider-vertical"></li>
                  	<li><a href="#"><i class="icon-signal"></i> Stats</a></li>
					<li class="divider-vertical"></li>
					<li><a href="#"><i class="icon-lock"></i> Permissions</a></li>
					<li class="divider-vertical"></li>
				</ul>
				<div class="btn-group pull-right">
				<?php if(false!==($name=_if_auth($this))){?>
					<a class="btn dropdown-toggle" data-toggle="dropdown" href="<?php echo $this->uri->config->item('base_url'); ?>logout"><i class="icon-user"></i> Logout(<?php echo $name;?>)</a>
				<?php }else{ ?>
				<a class="btn dropdown-toggle" data-toggle="dropdown" href="<?php echo $this->uri->config->item('base_url'); ?>auth"><i class="icon-user"></i> Login(<?php echo $a=_find_user_from_id_auth($this,_get_id_guest_auth($this)); ?>)</a>
				<?php }?>
				</div>
			</div>
			<!--/.nav-collapse -->
		</div>
		<!--/.container-fluid -->
	</div>
	<!--/.navbar-inner -->
</div>
<!--/.navbar -->


<div>
<?php if(_is_create_post($this)){?>
<div>
<a href="#">Create Post</a>
</div>
<?php } ?>
<?php if(false!==($name=_if_auth($this))){?>
<p><a href="logout">Logout(<?php echo $name;?>)</a></p>
<?php }else{ ?>
<p><a href="auth">Login(<?php echo $a=_find_user_from_id_auth($this,_get_id_guest_auth($this)); ?>)</a></p>
<?php }?>
</div>


<?php echo (isset($content)?$content:''); ?>
<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>


</body>
</html>