</!DOCTYPE html>
<html>
<head>
	<title>Sentiment Analysis</title>
	<meta charset="utf-8" />
  <meta name="url" content="<?=base_url()?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" href="<?=base_url()?>assets/img/sa.ico" type="image/x-icon" />
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/styles.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/font-awesome.css">

  	<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/js/bootstrap.js"></script>
</head>
<body>

<div id="wrapper">
	<?php $this->load->view('template'); ?>	

	<div id="page-wrapper">
    	<div id="page-inner">

    		<div class="row">
                <div class="col-md-12">
                    <h2 class="page-header">Dashboard</h2>
                </div>
            </div>

            <!-- CARDS -->
            <div class="row">

                <div class="col-md-3 col-sm-12 col-xs-12">
                    <div class="panel panel-primary text-center no-border bg-color-blue">
                        <div class="panel-body">
                            <i class="fa fa-database fa-5x"></i>
                            <h3><?php echo $total_review; ?></h3>
                        </div>
                        <div class="panel-footer back-footer-blue">
                            Total Review
                        </div>
                    </div>
                </div>
            
                <div class="col-md-3 col-sm-12 col-xs-12">
                    <div class="panel panel-primary text-center no-border bg-color-green">
                        <div class="panel-body">
                            <i class="fa fa-plus-square fa-5x"></i>
                            <h3><?php echo $pos_review; ?></h3>
                        </div>
                        <div class="panel-footer back-footer-green">
                            Review Positif
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-12 col-xs-12">
                    <div class="panel panel-primary text-center no-border bg-color-red">
                        <div class="panel-body">
                            <i class="fa fa-minus-square fa-5x"></i>
                            <h3><?php echo $neg_review; ?></h3>
                        </div>
                        <div class="panel-footer back-footer-red">
                            Review Negatif
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-12 col-xs-12">
                    <div class="panel panel-primary text-center no-border bg-color-brown">
                        <div class="panel-body">
                            <i class="fa fa-pie-chart fa-5x"></i>
                            <h3>78%</h3>
                        </div>
                        <div class="panel-footer back-footer-brown">
                            Akurasi Tes Terakhir
                        </div>
                    </div>
                </div>

            </div>
            <!-- END OF CARDS -->

            <!-- BUTTON HITUNG AKURASI-->
            <div class="text-right">
                <button class="btn btn-lg btn-primary" id="akurasibtn"><i class="fa fa-dashboard"></i> Hitung Akurasi</button>
            </div>

            <!-- TABLE STARTS HERE-->
            <div id="divtabeltest">
                <!--TABLE CONTENTS ARE LOADED HERE -->
            </div>
            <!--TABLE ENDS HERE -->      
    </div>
    <footer><p class="text-center">Copyright &copy 2016 Sentiment Analysis | All right reserved.</a></p></footer>
</div>

<!-- DATA TABLE SCRIPTS -->
    <script src="<?=base_url()?>assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="<?=base_url()?>assets/js/dataTables/dataTables.bootstrap.js"></script>
    <script src="<?=base_url()?>assets/js/dashboard.js"></script>
	
<!-- METIS MENU SCRIPTS-->
	<script src="<?=base_url()?>assets/js/jquery.metisMenu.js"></script>
      <!-- Custom Js -->
    <script src="<?=base_url()?>assets/js/custom-scripts.js"></script>

</body>

</html>