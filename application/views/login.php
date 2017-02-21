<!DOCTYPE HTML>
<html>
	<head>
		<title>Halaman Login</title>
		<meta charset="utf-8" />
    	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="shortcut icon" href="<?=base_url()?>assets/img/sa.ico" type="image/x-icon" />
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/styles.css">
        <script type="text/javascript" src="<?=base_url()?>assets/js/jquery.js"></script>
		<script type="text/javascript" src="<?=base_url()?>assets/js/bootstrap.js"></script>
	</head>

	<body class="body-color">
		<div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading text-center">
                        <h3 class="panel-title"><strong>Login Administrator</strong></h3>

                    </div>
                    <div class="panel-body">
                        <form role="form" action ="<?=site_url()?>auth/login" method="POST">
                            <fieldset>
                                <div class="form-group">
                                
                            <?php 
                            if($this->session->flashdata('message') != null) 
                            { 
                            echo '<div class="alert alert-'.$this->session->flashdata('type').'" role="alert">'; 
                            echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'; 
                            echo $this->session->flashdata('message') <> '' ? $this->session->flashdata('message') : ''; 
                            echo '</div>'; 
                            }?>
                            
                                <input class="form-control" placeholder="Username" name="username" type="username" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me">Ingat saya
                                    </label>
                                </div>
                                <button type="submit" class="btn btn-lg btn-login btn-block">Login</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
                <!-- FOOTER-->
                <footer><p class="text-center copyright">&copyCopyright Sentiment Analysis.id <br> All right reserved.</a></p></footer>
            </div>
        </div>
    </div>

	</body>

</html>