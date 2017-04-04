<!DOCTYPE HTML>
<html>
	<head>
		<title>Halaman Login</title>
		<meta charset="utf-8" />
    	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="shortcut icon" href="<?=base_url()?>assets/img/sa.ico" type="image/x-icon" />
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/styles.css">
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/material-icons.css">
	</head>

	<body class="body-color">
		<div class="container">
			<div class="row">
				<div class="col-md-4 col-md-offset-4">
					<div class="login-panel panel panel-default">
						<div class="panel-heading text-center">
							<h4 class="panel-title">Login Administrator</h4>

						</div>
						<div class="panel-body">
							<form role="form" action ="<?=site_url()?>auth/login" method="POST">
								<?php 
									if($this->session->flashdata('message') != null) 
									{ 
									echo '<div class="alert alert-'.$this->session->flashdata('type').'" role="alert">'; 
									echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'; 
									echo $this->session->flashdata('message') <> '' ? $this->session->flashdata('message') : ''; 
									echo '</div>'; 
									}
								?>
								<div class="form-group has-feedback">
						<span class="form-control-feedback">
							<i class="material-icons">account_circle</i>
						</span>
						<input class="form-control" placeholder="Username" name="username" type="text" autofocus>
					</div>
					<div class="form-group has-feedback">
						<span class="form-control-feedback">
							<i class="material-icons">https</i>
						</span>
						<input class="form-control" placeholder="Password" name="password" type="password" autofocus>
					</div>
								<br>
								<button type="submit" class="btn btn-lg btn-login btn-block">Login</button>
							</form>
						</div>
					</div>
					<!-- FOOTER-->
					<footer><p class="text-center copyright">&copyCopyright Sentiment Analysis.id <br> All right reserved.</a></p></footer>
				</div>
			</div>
		</div>
		
		<!--SCRIPTS-->
		<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.js"></script>
		<script type="text/javascript" src="<?=base_url()?>assets/js/bootstrap.js"></script>
	</body>

</html>