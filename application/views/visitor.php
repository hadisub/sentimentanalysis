
<!DOCTYPE html>
<html>
<head>
    <title>Sentiment Analysis</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="<?=base_url()?>assets/img/sa.ico" type="image/x-icon" />
    <link rel="stylesheet" href="<?=base_url()?>assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?=base_url()?>assets/css/material-icons.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/css/visitor/visitor.css">
	<link rel="stylesheet" href="<?=base_url()?>assets/css/visitor/font-awesome.min.css">
</head>

<body id="top-page" data-spy="scroll" data-target=".navbar-fixed-top">
<!--NAVBAR-->
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header page-scroll">
            <button class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <a class="navbar-brand page-scroll" href="#top-page">SENTIMENT ANALYSIS</a>
        </div>

        <div class="collapse navbar-collapse navbar-right sa-navbar" id="navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="hidden">
                    <a class="page-scroll" href="#top-page"></a>
                </li>
                <li>
                    <a class="page-scroll" href="#intro">Intro</a>
                </li>
                <li>
                    <a class="page-scroll" href="#analisis">Analisis Sentimen</a>
                </li>
                <li>
                    <a class="page-scroll" href="#about">Tentang</a>
                </li>
            </ul>
            <a class="btn btn-primary navbar-btn" href="https://github.com/hadisub/skripsi.git/fork" target="_blank"><i
                    class="fa fa-github"></i> Fork di Github</a>
        </div>
    </div>
</nav><!--END OF NAVBAR -->

<!--INTRO-->
<div class="jumbotron sa-jumbotron text-center" id="jumbo">
    <div class="container jumbo-vertical-center">
        <h1>Sistem Analisis Sentimen <br> Review Film</h1>
        <p>Lorem ipsum dolor set amet, consectetur adipiscing elit. Mauris ac enim felis.
            Lorem ipsum dolor set amet, consectetur adipiscing elit. Mauris ac enim felis.
        </p>
    </div>
    <a class="btn btn-lg btn-primary page-scroll" href="#analisis">Masukkan Review Anda</a>
</div>

<div class="intro" id="intro">
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-sm-4 intro-container">
				<i class="icon material-icons">library_books</i>
				<div class="intro-wrapper">
					<p class="intro-number" data-stop="<?php echo $total_traindata;?>"><?php echo $total_traindata;?></p>
					<p class="intro-text">Total Review Film</p>
				</div>
			</div>
			<div class="col-md-4 col-sm-4 intro-container">
				<i class="icon material-icons">thumb_up</i>
				<div class="intro-wrapper">
					<p class="intro-number" data-stop="<?php echo $pos_traindata;?>"><?php echo $neg_traindata;?></p>
					<p class="intro-text">Review Positif</p>
				</div>
			</div>
			<div class="col-md-4 col-sm-4 intro-container">
				<i class="icon material-icons">thumb_down</i>
				<div class="intro-wrapper">
					<p class="intro-number" data-stop="<?php echo $neg_traindata;?>"><?php echo $neg_traindata;?></p>
					<p class="intro-text">Review Negatif</p>
				</div>
			</div>

		</div>
	</div>
</div>

<!--ANALISIS SENTIMEN-->
<div class="analisis" id="analisis">
    <p class="analisis-title">ANALISIS SENTIMEN</p>
	<div class="container">
		<form>
			<div class="form-group">
				<textarea type="text" id="visitor_review" class="form-control textarea" rows="10" spellcheck="false" placeholder="Ketik atau paste review di sini..."></textarea>
			</div>
			<button class="btn btn-lg btn-secondary">ANALISIS</button>
		</form>
	</div>
</div>

<!--TENTANG-->
<div class="about" id="about">
    <div class="container about-container">
		<div class="rov">
			<div class="col-sm-4 col=md-4">
				<div class="about-title">
					<h3>LIBRARIES</h3>
				</div>
				<div class="about-wrapper">
					<p><a class="link" href="https://jquery.com">JQuery</a></p>
					<p><a class="link" href="http://imakewebthings.com/waypoints">Waypoints</a></p>
					<p><a class="link" href="http://gsgd.co.uk/sandbox/jquery/easing/">JQuery Easing</a></p>
				</div>
			</div>
			<div class="col-sm-4 col=md-4">
				<div class="about-title">
					<h3>TAUTAN</h3>
				</div>
				<div class="about-wrapper">
					<a class="social-icon icon-twitter" href="https://twitter.com"><i class="fa fa-twitter"></i></a>
					<a class="social-icon icon-email" href="mailto:hadiniizuma@gmail.com"><i class="fa fa-envelope-o"></i></a>
					<a class="social-icon icon-facebook" href="https://facebook.com"><i class="fa fa-facebook"></i></a>
					<a class="social-icon icon-instagram" href="https://instagram.com"><i class="fa fa-instagram"></i></a>
					<a class="social-icon icon-github" href="https://github.com/hadisub" target="_blank"><i class="fa fa-github"></i></a>
				</div>
			</div>
			<div class="col-sm-4 col-md-4">
				<div class="about-title">
					<h3>TENTANG NAIVE BAYES</h3>
				</div>
				<div class="about-wrapper about-us">
					<p>Lorem ipsum dolor set amet, consectetur adipiscing elit. Mauris ac enim felis.
            Lorem ipsum dolor set amet, consectetur adipiscing elit. Mauris ac enim felis.</p>
				</div>
			</div>
		</div>
	</div>
</div>

<footer class="footer" id="footer">
	<p class="footer-text">&copy Copyright Sentiment Analysis. All rights reserved</br>
	Powered by <a class="link-bootstrap" href="http://getbootstrap.com">Bootstrap</a></p>
</footer>

<!--SCRIPTS-->
<script src="<?=base_url()?>assets/js/jquery.js"></script>
<script src="<?=base_url()?>assets/js/bootstrap.min.js"></script>
<script src="<?=base_url()?>assets/js/visitor/jquery.easing.min.js"></script>
<script src="<?=base_url()?>assets/js/visitor/scroll.js"></script>
<script src="<?=base_url()?>assets/js/visitor/jquery.waypoints.js"></script>
<script src="<?=base_url()?>assets/js/visitor/visitor-scripts.js"></script>

</body>
</html>
