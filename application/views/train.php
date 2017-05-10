<!DOCTYPE html>
<html>
<head>
	<title>Sentiment Analysis</title>
	<meta charset="utf-8" />
	<meta name="url" content="<?=base_url()?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="shortcut icon" href="<?=base_url()?>assets/img/sa.ico" type="image/x-icon" />
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/styles.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/material-icons.css">
</head>
<body>
<div id="wrapper">
	<?php $this->load->view('template');?>	

	<div id="page-wrapper">
    	<div id="page-inner">

    		<div class="row">
                <div class="col-md-12">
                    <h2 class="page-header">Latih Sistem</h2>
                </div>
            </div>

            <!-- BUTTON TRAIN DATA-->
            <div class="text-right">
                <button class="btn btn-lg btn-primary" id="trainbtn"><i class="material-icons material-icons-1-5x">playlist_play</i> Latih Sistem</button>
            </div>
				
            <!-- TABLE STARTS HERE-->
            <div id="divtabeltraining">
				<!--TABLE CONTENTS ARE LOADED HERE -->
            </div>
            <!--TABLE ENDS HERE -->   
		</div>
		<footer><p class="text-center">Copyright &copy 2016 Sentiment Analysis | All right reserved.</a></p></footer>
	</div>

</div>

<!-- SCRIPTS -->
	<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/js/bootstrap.js"></script>
	
<!-- DATA TABLE SCRIPTS -->
    <script src="<?=base_url()?>assets/js/train.js"></script>
    <script src="<?=base_url()?>assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="<?=base_url()?>assets/js/dataTables/dataTables.bootstrap.js"></script>

	
<!-- METIS MENU SCRIPTS-->
	<script src="<?=base_url()?>assets/js/jquery.metisMenu.js"></script>
      <!-- Custom Js -->
    <script src="<?=base_url()?>assets/js/custom-scripts.js"></script>

</body>

</html>