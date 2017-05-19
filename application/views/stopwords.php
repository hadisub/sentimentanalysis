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
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/toastr.css">
</head>
<body>
<div id="wrapper">
    
        <!--/. SIDEBAR TOP  -->
        <?php $this->load->view('template'); ?>
        <!-- /. END OF SIDEBAR  -->
        <div id="page-wrapper">
            <div id="page-inner">

                <div class="row">
                    <div class="col-md-12">
                        <h2 class="page-header">
                            Stop Words Review Film
                        </h2>
                    </div>

                </div>
                <!-- TABLE LABEL-->

            <!--BUTTON TAMBAH -->
            <div class="btn-fixed">            
            <button a href="#modalstopwords" data-toggle ="modal" class="btn btn-circle btn-circle-lg btn-primary btn-add text-right"><i class="material-icons material-icons-2x">playlist_add</i></button>   
            </div>

				<!--TABLE-->
				     <!-- /. ROW  -->
               
            <div class="row">
                <div class="col-md-12 panel panel-default">
					<div class="panel-heading text-center">
						Tabel Kumpulan Kata-Kata yang Dapat Dihilangkan (Stop Words)
					</div>
                    <!-- Advanced Tables -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Kata</th>
                                            <th>Tindakan</th>
                                        </tr>
                                    </thead>
                                    
                                </table>
                            </div>
                            
                        </div>
                    </div>
                    <!--End Advanced Tables -->
                </div>
            </div>
				<!-- END OF TABLE-->
        <!-- FOOTER-->
        <footer><p class="text-center">Copyright &copy 2016 Sentiment Analysis | All right reserved.</a></p></footer>
            </div>
            </div>
            <!-- /. PAGE INNER  -->
        </div>
        <!-- /. PAGE WRAPPER  -->

<!-- MODAL FORM TAMBAH DAN EDIT STOP WORDS-->
            
    <div aria-hidden="true" aria-labelledby="modalstopwordlabel" role="dialog" tabindex="-1" id="modalstopwords" class="modal fade"
    data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog">
      <form role="form" action="<?=site_url()?>stopwords/inputstopwords" method="post" id="formstopwords">
          <div class="modal-content">
              <div class="modal-header">
                  <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>
                  <h4 class="modal-title text-center"><span class="modal-action">Tambah</span> Stop Words</h4>
              </div>
              <div class="modal-body">
                  <input type="hidden" name="id_stopwords" id="id_stopwords" value="">
                  
                      <div class="form-group">
                          <label for="stopwordsbaru">Stop Words</label>
                          <input type="text" class="form-control" id="stopwordsbaru" name="stopwordsbaru" onkeyup="count_stopwords(this);" placeholder="Masukkan stop words baru">
                          <div class="pull-right">
                            <span class="text-muted" id="countstopwordschar">0</span>
                            <span class="text-muted">/30 karakter</span>
                          </div>
                      </div>                  
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-success">
                <i class = "material-icons">save</i>   Simpan</button>
            </div>
          </div>
          </form>
      </div>
    </div>
    <!--END OF MODAL FORM-->

<!-- MODAL FORM HAPUS STOP WORDS-->
            
    <div aria-hidden="true" aria-labelledby="modalstopwordslabel" role="dialog" tabindex="-1" id="deletestopwordsmodal" class="modal fade"
    data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog">
      <form role="form" action="<?=site_url()?>stopwords/deletestopwords" method="post">
      <input type="hidden" name="id_stopwords" id="id_stopwords" value="">
          <div class="modal-content">
              <div class="modal-body">
              <p class="text-center"><strong>PERINGATAN:</strong> <br> 
              Kata yang anda pilih akan terhapus dan tidak dapat dikembalikan lagi.<br>
              Apakah anda yakin untuk menghapus kata ini?</p> 
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger">
                <i class = "material-icons">delete</i>   Ya</button>
            </div>
          </div>
          </form>
      </div>
    </div>
    <!--END OF MODAL FORM-->
	
	<!-- SCRIPTS -->
	<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/js/bootstrap.js"></script>

    <!-- DATA TABLE SCRIPTS -->
    <script src="<?=base_url()?>assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="<?=base_url()?>assets/js/dataTables/dataTables.bootstrap.js"></script>
    <script src="<?=base_url()?>assets/js/crud/stopwords.js"></script>
	
	   <!-- METIS MENU SCRIPTS-->
	   <script src="<?=base_url()?>assets/js/jquery.metisMenu.js"></script>
      <!-- Custom Js -->
    <script src="<?=base_url()?>assets/js/custom-scripts.js"></script>

    <!-- CHARACTER COUNTERS FOR INPUT-->
    <script src="<?=base_url()?>assets/js/countcharacters.js"></script>

    <!-- FORM VALIDATION-->
    <script src="assets/js/validation/jquery.validate.js"></script>
    <script src="assets/js/validation/additional-methods.min.js"></script>
    <script src="assets/js/validation/formvalidation.js"></script>

    <!-- TOASTR NOTIFICATIONS-->
    <script src="<?=base_url()?>assets/js/toastr.js"></script>
    
    <?php
    $notification= $this->session->flashdata('notification');
    if(isset($notification)){
      if($notification == 'input_sw_success'){
    ?>
    
    <script>
    $(document).ready(function(){
      toastr.success('Tambah stop word baru berhasil.','',{closeButton: true, positionClass: "toast-top-center",
      timeOut:2000, showMethod:"fadeIn", hideMethod:"fadeOut"});
    });
    </script>

    <?php
      }
      else if($notification == 'input_sw_error'){
    ?>
    
    <script>
    $(document).ready(function(){
      toastr.error('Stop word gagal tersimpan. Silahkan coba kembali','',{closeButton: true, positionClass: "toast-top-center",
      timeOut:2000, showMethod:"fadeIn", hideMethod:"fadeOut"});
    });
    </script>
    <?php
      }
      else if($notification=='edit_sw_success'){
    ?> 
    <script>
    $(document).ready(function(){
      toastr.success('Edit stop word berhasil','',{closeButton: true, positionClass: "toast-top-center",
      timeOut:2000, showMethod:"fadeIn", hideMethod:"fadeOut"});
    });
    </script>

    <?php
    }
    else if($notification=='edit_sw_error'){
    ?>
    <script>
    $(document).ready(function(){
      toastr.error('Stop word gagal diedit. Silahkan coba kembali','',{closeButton: true, positionClass: "toast-top-center",
      timeOut:2000, showMethod:"fadeIn", hideMethod:"fadeOut"});
    });
    </script>

    <?php
    }
    else if($notification=='delete_sw_success'){
    ?>
    <script>
    $(document).ready(function(){
      toastr.success('Hapus stop word berhasil','',{closeButton: true, positionClass: "toast-top-center",
      timeOut:2000, showMethod:"fadeIn", hideMethod:"fadeOut"});
    });
    </script>

    <?php
    }
    else if($notification='delete_sw_error'){
    ?>
    <script>
    $(document).ready(function(){
      toastr.error('Stop word gagal dihapus. Silahkan coba kembali','',{closeButton: true, positionClass: "toast-top-center",
      timeOut:2000, showMethod:"fadeIn", hideMethod:"fadeOut"});
    });
    </script>
    <?php
      }
    }
    ?>

</body>
</html>