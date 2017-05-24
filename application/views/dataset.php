<!DOCTYPE html>
<html>
<head>
	<title>Sentiment Analysis</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="url" content="<?=base_url()?>" />
	<link rel="shortcut icon" href="<?=base_url()?>assets/img/sa.ico" type="image/x-icon" />
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/styles.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/material-icons.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/toastr.css">
</head>
<body>
  <div id="wrapper">
    <!-- SIDEBAR TOP  -->
    <?php $this->load->view('template'); ?>
    
    <!-- AKHIR DARI SIDEBAR  -->
    <div id="page-wrapper">
      <div id="page-inner">

        <div class="row">
          <div class="col-md-12">
              <h2 class="page-header">
                Dataset Review Film
              </h2>
           </div>
        </div>
            
        <!--BUTTON TAMBAH -->
        <div class="btn-fixed">            
          <button data-target="#modaldataset" data-toggle="modal" class="btn btn-primary btn-circle-lg btn-circle btn-circle-lg btn-add"><i class="material-icons material-icons-2x">note_add</i></button>  
        </div>
        
			   <!--TABEL-->   
        <div class="row">
          <div class="col-md-12 panel panel-default">
			<div class="panel-heading text-center">
				Tabel Dataset Review Film
			</div>
            <!-- Datatable -->
					   <div class="panel-body">
  						<div class="table-responsive">
  							<table class="table table-striped table-bordered table-hover" id="dataTables-example">
  								<thead>
  									<tr>
  										<th>No.</th>
  										<th width="25%">Judul</th>
  										<th>Sentimen</th>
  										<th>Kategori</th>
  										<th width="30%">Isi Review</th>
  										<th>Tindakan</th>
  									</tr>
  								</thead>
  							</table>
  						</div>
						
					   </div>
                    <!-- Akhir dari datatable -->
                </div>
            </div>

        <!-- FOOTER-->
        <footer><p class="text-center">Copyright &copy 2016 Sentiment Analysis.id | All right reserved.</a></p></footer>
            </div>
            <!-- PAGE INNER  -->
        </div>
        <!-- PAGE WRAPPER  -->
    </div>

<!-- MODAL FORM TAMBAH DAN EDIT REVIEW-->
            
    <div aria-hidden="true" aria-labelledby="modaldatasetlabel" role="dialog" tabindex="-1" id="modaldataset" class="modal fade"
    data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog">
      <form role="form" action="<?=site_url()?>dataset/inputdataset" method="post" id="formdataset">
          <div class="modal-content">
              <div class="modal-header">
                  <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>
                  <h4 class="modal-title text-center"><span class="modal-action">Tambah</span> Data Review Baru</h4>
              </div>
              <div class="modal-body">
                      <input type="hidden" name="id_review" id="id_review" value="">
                  
                      <div class="form-group">
                          <label for="judulreview">Judul Review</label>
                          <input type="text" class="form-control" id="judulreview" name="judulreview" placeholder="Masukkan judul review">
                      </div>
                    
                      <div class="form-group">
                          <label for="teksreview">Isi Review</label>
                          <textarea id="teksreview" name="teksreview" class="form-control" rows="6" onkeyup="count_review(this);" placeholder="Masukkan atau paste review film di sini"></textarea>
                          <div class="pull-right">
                            <span class="text-muted" id="countreviewchar">0</span>
                            <span class="text-muted">/7500 karakter</span>
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="kategori">Kategori</label>
                          <select class="form-control text-left" name="kategori">
                              <option value="DATA LATIH">DATA LATIH</option>
                              <option value="DATA UJI">DATA UJI</option>
                          </select>
                      </div>
                      <div class="form-group">
                          <label for="sentimenawal">Sentimen</label>
                          <select class="form-control text-left" name="sentimenawal">
                              <option value="POSITIF">POSITIF</option>
                              <option value="NEGATIF">NEGATIF</option>
                          </select>
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
<!--AKHIR DARI MODAL FORM-->

<!-- MODAL FORM HAPUS DATASET-->
            
    <div aria-hidden="true" aria-labelledby="modaldatasetlabel" role="dialog" tabindex="-1" id="deletereviewmodal" class="modal fade"
    data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog">
      <form role="form" action="<?=site_url()?>dataset/deletedataset" method="post">
        <input type="hidden" name="id_review" id="id_review" value="">
          <div class="modal-content">
              <div class="modal-body">
              <p class="text-center"><strong>PERINGATAN:</strong> <br> 
              Review yang anda pilih akan terhapus dan tidak dapat dikembalikan lagi.<br>
              Apakah anda yakin untuk menghapus review ini?</p> 
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger">
                <i class = "material-icons">delete</i>   Hapus</button>
            </div>
          </div>
          </form>
      </div>
    </div>
    <!--AKHIR DARI OF MODAL FORM-->
	
	<!--SCRIPTS-->
	<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/js/bootstrap.js"></script>

    <!-- DATA TABLE SCRIPTS -->
    <script src="<?=base_url()?>assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="<?=base_url()?>assets/js/dataTables/dataTables.bootstrap.js"></script>
    <script src="<?=base_url()?>assets/js/crud/dataset.js"></script>
	
	<!-- METIS MENU SCRIPTS-->
	<script src="<?=base_url()?>assets/js/jquery.metisMenu.js"></script>
  
	<!-- Custom Js -->
	<script src="<?=base_url()?>assets/js/custom-scripts.js"></script>

	<!-- CHARACTER COUNTERS UNTUK TEXTAREA REVIEW-->
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
      if($notification == 'input_review_success'){
    ?>
    
    <script>
    $(document).ready(function(){
      toastr.success('Tambah review film berhasil.','',{closeButton: true, positionClass: "toast-top-center",
      timeOut:2000, showMethod:"fadeIn", hideMethod:"fadeOut"});
    });
    </script>

    <?php
      }
      else if($notification == 'input_review_error'){
    ?>
    
    <script>
    $(document).ready(function(){
      toastr.error('Review film gagal tersimpan. Silahkan coba kembali','',{closeButton: true, positionClass: "toast-top-center",
      timeOut:2000, showMethod:"fadeIn", hideMethod:"fadeOut"});
    });
    </script>
    <?php
      }
      else if($notification=='edit_review_success'){
    ?> 
    <script>
    $(document).ready(function(){
      toastr.success('Edit review film berhasil','',{closeButton: true, positionClass: "toast-top-center",
      timeOut:2000, showMethod:"fadeIn", hideMethod:"fadeOut"});
    });
    </script>

    <?php
    }
    else if($notification=='edit_review_error'){
    ?>
    <script>
    $(document).ready(function(){
      toastr.error('Review film gagal diedit. Silahkan coba kembali','',{closeButton: true, positionClass: "toast-top-center",
      timeOut:2000, showMethod:"fadeIn", hideMethod:"fadeOut"});
    });
    </script>

    <?php
    }
    else if($notification=='delete_review_success'){
    ?>
    <script>
    $(document).ready(function(){
      toastr.success('Hapus review film berhasil','',{closeButton: true, positionClass: "toast-top-center",
      timeOut:2000, showMethod:"fadeIn", hideMethod:"fadeOut"});
    });
    </script>

    <?php
    }
    else if($notification='delete_review_error'){
    ?>
    <script>
    $(document).ready(function(){
      toastr.error('Review film gagal dihapus. Silahkan coba kembali','',{closeButton: true, positionClass: "toast-top-center",
      timeOut:2000, showMethod:"fadeIn", hideMethod:"fadeOut"});
    });
    </script>
    <?php
      }
    }
    ?>

</body>
</html>