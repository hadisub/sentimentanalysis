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
                    <h2 class="page-header">Dashboard</h2>
                </div>
            </div>

            <!-- CARDS -->
            <div class="row">

                <div class="col-md-3 col-sm-12 col-xs-12">
                    <div class="panel panel-primary text-center no-border bg-color-blue">
                        <div class="panel-body">
                            <i class="material-icons material-icons-5x">library_books</i>
                            <h3 id="jumlah-data-latih"><?php echo $total_traindata; ?></h3>
                        </div>
                        <div class="panel-footer back-footer-blue">
                            Jumlah Review Data Latih
                        </div>
                    </div>
                </div>
            
                <div class="col-md-3 col-sm-12 col-xs-12">
                    <div class="panel panel-primary text-center no-border bg-color-green">
                        <div class="panel-body">
                            <i class="material-icons material-icons-5x">thumb_up</i>
                            <h3 id="jumlah-data-latih-positif"><?php echo $pos_traindata; ?></h3>
                        </div>
                        <div class="panel-footer back-footer-green">
                            Review Data Latih Positif
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-12 col-xs-12">
                    <div class="panel panel-primary text-center no-border bg-color-red">
                        <div class="panel-body">
                            <i class="material-icons material-icons-5x">thumb_down</i>
                            <h3 id="jumlah-data-latih-negatif"><?php echo $neg_traindata; ?></h3>
                        </div>
                        <div class="panel-footer back-footer-red">
                            Review Data Latih Negatif
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-12 col-xs-12">
                    <div class="panel panel-primary text-center no-border bg-color-brown">
                        <div class="panel-body">
                            <i class="material-icons material-icons-5x">library_books</i>
                            <h3 id="jumlah-data-uji"><?php echo $total_testdata; ?></h3>
                        </div>
                        <div class="panel-footer back-footer-brown">
                            Jumlah Review Data Uji
                        </div>
                    </div>
                </div>

            </div>
            <!-- AKHIR DARI CARDS -->
			
			<!--CHART-->
			<div class="row">
				<div class="col-md-6 col-sm-12 col-xs-12">
					<div class="panel panel-default text-center no-border">
						<div class="panel-heading-small">
							Perbandingan Data Latih dan Data Uji
						</div>
						<div class="panel-body">
							<div id="latih-dan-uji-chart" class="chart"></div>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-sm-12 col-xs-12">
					<div class="panel panel-default text-center no-border">
						<div class="panel-heading-small">
							Perbandingan Data Latih Positif dan Negatif
						</div>
						<div class="panel-body">
							<div id="pos-neg-chart" class="chart"></div>
						</div>
					</div>
				</div>
			</div>
			<!--AKHIR DARI CHART-->
			
    </div>
    <footer><p class="text-center">Copyright &copy 2017 Sentiment Analysis | All right reserved.</a></p></footer>
</div>

<!-- SCRIPTS -->
	<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/js/bootstrap.js"></script>
	
<!-- METIS MENU SCRIPTS-->
	<script src="<?=base_url()?>assets/js/jquery.metisMenu.js"></script>

<!-- MORRIS JS -->
<script src="<?=base_url()?>assets/js//charts/raphael.min.js"></script>
    <script src="<?=base_url()?>assets/js//charts/morris.min.js"></script>
	
<!-- Custom JS -->
    <script src="<?=base_url()?>assets/js/custom-scripts.js"></script>
	<script src="<?=base_url()?>assets/js/dashboard.js"></script>
	

</body>

</html>