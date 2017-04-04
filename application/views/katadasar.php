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
                            Kata Dasar Review Film
                        </h2>
                    </div>

                </div>

            <!--BUTTON TAMBAH -->
            <div class="btn-fixed">            
				<button a href="#modalkatadasar" data-toggle = "modal" class="btn btn-circle btn-circle-lg btn-primary btn-add text-right"><i class="material-icons material-icons-2x">playlist_add</i></button>   
            </div>
				    <!--TABLE-->
				     <!-- /. ROW  -->
            <div class="row">

                <div class="col-md-12">
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
            <!-- /. PAGE INNER  -->
        </div>
        <!-- /. PAGE WRAPPER  -->
</div>

<!-- MODAL FORM TAMBAH DAN EDIT KATA DASAR-->
            
    <div aria-hidden="true" aria-labelledby="modalkatadasarlabel" role="dialog" tabindex="-1" id="modalkatadasar" class="modal fade"
    data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog">
      <form role="form" action="<?=site_url()?>katadasar/inputkatadasar" method="post" id="formkatadasar">
          <div class="modal-content">
              <div class="modal-header">
                  <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>
                  <h4 class="modal-title text-center"><span class="modal-action">Tambah</span> Kata Dasar</h4>
              </div>
              <div class="modal-body">
                  <input type="hidden" name="id_katadasar" id="id_katadasar" value="">
                  
                      <div class="form-group">
                          <label for="katadasarbaru">Kata Dasar</label>
                          <input type="text" class="form-control" id="katadasarbaru" name="katadasarbaru" onkeyup="count_katdas(this);" placeholder="Masukkan kata dasar baru">
                          <div class="pull-right">
                            <span class="text-muted" id="countkatdaschar">0</span>
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

    <!-- MODAL FORM HAPUS KATA DASAR-->
            
    <div aria-hidden="true" aria-labelledby="modalkatadasarlabel" role="dialog" tabindex="-1" id="deletekatadasarmodal" class="modal fade"
    data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog">
      <form role="form" action="<?=site_url()?>katadasar/deletekatadasar" method="post">
      <input type="hidden" name="id_katadasar" id="id_katadasar" value="">
          <div class="modal-content">
              <div class="modal-body">
              <p class="text-center"><strong>PERINGATAN:</strong> <br> 
              Kata yang anda pilih akan terhapus dan tidak dapat dikembalikan lagi.<br>
              Apakah anda yakin untuk menghapus kata ini?</p> 
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
    <!--END OF MODAL FORM-->
	
	<!-- SCRIPTS -->
	<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/js/bootstrap.js"></script>
	
    <!-- DATA TABLE SCRIPTS -->
    <script src="<?=base_url()?>assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="<?=base_url()?>assets/js/dataTables/dataTables.bootstrap.js"></script>
    <script src="<?=base_url()?>assets/js/crud/katadasar.js"></script>
	
	 <!-- METIS MENU SCRIPTS-->
	   <script src="<?=base_url()?>assets/js/jquery.metisMenu.js"></script>
      <!-- Custom Js -->
    <script src="<?=base_url()?>assets/js/custom-scripts.js"></script>

    <!-- CHARACTER COUNTERS FOR INPUT-->
    <script src="<?=base_url()?>assets/js/countcharacters.js"></script>

    <!-- FORM VALIDATION-->
    <script src="<?=base_url()?>assets/js/validation/jquery.validate.js"></script>
    <script src="<?=base_url()?>assets/js/validation/additional-methods.min.js"></script>
    <script src="<?=base_url()?>assets/js/validation/formvalidation.js"></script>

    <!-- TOASTR NOTIFICATIONS-->
    <script src="<?=base_url()?>assets/js/toastr.js"></script>
    
    <?php
    $notification= $this->session->flashdata('notification');
    if(isset($notification)){
      if($notification == 'input_kd_success'){
    ?>
    
    <script>
    $(document).ready(function(){
      toastr.success('Tambah kata dasar baru berhasil.','',{closeButton: true, positionClass: "toast-top-center",
      timeOut:2000, showMethod:"fadeIn", hideMethod:"fadeOut"});
    });
    </script>

    <?php
      }
      else if($notification == 'input_kd_error'){
    ?>
    
    <script>
    $(document).ready(function(){
      toastr.error('Kata gagal tersimpan. Silahkan coba kembali','',{closeButton: true, positionClass: "toast-top-center",
      timeOut:2000, showMethod:"fadeIn", hideMethod:"fadeOut"});
    });
    </script>
    <?php
      }
      else if($notification=='edit_kd_success'){
    ?> 
    <script>
    $(document).ready(function(){
      toastr.success('Edit kata dasar berhasil','',{closeButton: true, positionClass: "toast-top-center",
      timeOut:2000, showMethod:"fadeIn", hideMethod:"fadeOut"});
    });
    </script>

    <?php
    }
    else if($notification=='edit_kd_error'){
    ?>
    <script>
    $(document).ready(function(){
      toastr.error('Kata gagal diedit. Silahkan coba kembali','',{closeButton: true, positionClass: "toast-top-center",
      timeOut:2000, showMethod:"fadeIn", hideMethod:"fadeOut"});
    });
    </script>

    <?php
    }
    else if($notification=='delete_kd_success'){
    ?>
    <script>
    $(document).ready(function(){
      toastr.success('Hapus kata dasar berhasil','',{closeButton: true, positionClass: "toast-top-center",
      timeOut:2000, showMethod:"fadeIn", hideMethod:"fadeOut"});
    });
    </script>

    <?php
    }
    else if($notification='delete_kd_error'){
    ?>
    <script>
    $(document).ready(function(){
      toastr.error('Kata gagal dihapus. Silahkan coba kembali','',{closeButton: true, positionClass: "toast-top-center",
      timeOut:2000, showMethod:"fadeIn", hideMethod:"fadeOut"});
    });
    </script>
    <?php
      }
    }
    ?>

</body>
</html>