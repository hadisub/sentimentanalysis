<?php

$dashboard_active = "";
$dataset_active = "";
$katadasar_active = "";
$stopwords_active = "";
$termtokenized_active = "";
$termfiltered_active = "";
$termstemmed_active = "";

if(isset($title)){
    switch ($title) {
        case 'dashboard':
            $dashboard_active = "active-menu";
            break;

        case 'dataset':
            $dataset_active = "active-menu";
            break;
        
        case 'katadasar':
            $katadasar_active = "active-menu";
            break;

        case 'stopwords':
            $stopwords_active = "active-menu";
            break;

        case 'termtokenized':
            $termtokenized_active = "active-menu";
            break;

        case 'termfiltered':
            $termfiltered_active = "active-menu";
            break;

        case 'termstemmed':
            $termstemmed_active = "active-menu";
            break;
    }
}

?>


<!-- HEADER-->
<nav class="navbar navbar-default top-navbar" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"><small>Sentiment Analysis</small></a>
            </div>

            <ul class="nav navbar-top-links navbar-right">
                <!-- /.dropdown -->
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                        <i class="fa fa-user fa-fw"></i><?php echo $this->session->userdata('username')?> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li class="divider"></li>
                        <li><a href="<?=site_url()?>auth/logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                <!-- /.dropdown -->
            </ul>
        </nav>
<!-- END OF HEADER-->


<!-- SIDEBAR-->

<nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
                    <li>
                        <a class="<?=$dashboard_active?>" href="<?=site_url()?>dashboard"><i class="fa fa-dashboard"></i>Dashboard</a>
                    </li>
                    <li>
                        <a class="<?=$dataset_active?>" href="<?=site_url()?>dataset"><i class="fa fa-tasks"></i> Dataset</a>
                    </li>
                    <li>
                        <a class="<?=$katadasar_active?>" href="<?=site_url()?>katadasar"><i class="fa fa-comments"></i> Kata Dasar</a>
                    </li>
                    <li>
                        <a class="<?=$stopwords_active?>" href="<?=site_url()?>stopwords"><i class="fa fa-ban"></i> Stop Words</a>
                    </li>
                    
                    <li>
                       <a href="#"><i class="fa fa-clipboard" ></i> Kumpulan Term<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a class="<?=$termtokenized_active?>" href="<?=site_url()?>displayterm/displaytokenized">1. Setelah Tokenizing</a>
                            </li>
                            <li>
                                <a class="<?=$termfiltered_active?>" href="<?=site_url()?>displayterm/displayfiltered">2. Setelah Filtering</a>
                            </li>
                            <li>
                                <a class="<?=$termstemmed_active?>" href="<?=site_url()?>displayterm/displaystemmed">3. Setelah Stemming</a>
                            </li>
                        </ul>
                    </li>
                    
                    <li>
                    <a href="#myModal" data-toggle="modal"><i class="fa fa-info-circle"></i> Tentang</a>
                    </li>
                </ul>

            </div>
        
        </nav>

 <!-- END OF SIDEBAR-->

 <!-- MODAL TENTANG -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title text-center" id="labelmodaltentang"><strong>Sentiment Analysis for Movie Reviews in Bahasa</strong></h4>
                        </div>
                        <div class="modal-body text-center">
                             versi p.1 (prototype)
                            <br>
                            Copyright &copy 2016 Sentiment Analysis
                            <br>
                            All rights reserved
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
<!--END OF MODAL TENTANG-->