$(document).ready(function () {
  var url = $("meta[name=url]").attr("content");

    $('#dataTables-example').dataTable({
   	"language": {
         "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
         "sLengthMenu": "_MENU_  review per halaman",
         "sSearch": "Cari: ",
         "sNext": "Selanjutnya",
         "sPrevious": "Sebelumnya"
       },
    "processing": true,
    "serverSide": true,
    "ajax": url +"dataset/review"
   });

   $(document).on('click', ".btn-delete", function(e){
      var idReview = $(this).data('id');
      $('#deletereviewmodal #id_review').val(idReview);
   });

   $(".btn-add").on('click', function(){
      $(".modal-action").text("Tambah");
      $("#modaldataset form").attr("action", url + "dataset/inputdataset");
      $('#modaldataset #id_review').val("");
      
      //kosongkan form setiap klik button tambah
      $("#modaldataset input[name=judulreview]").val('');
      $("#modaldataset textarea[name=teksreview]").val('');
      $("#countreviewchar").text("0");
	    $("#modaldataset select[name=kategori]").val('DATA LATIH');
      $("#modaldataset select[name=sentimenawal]").val('POSITIF');

      document.getElementById('countreviewchar').style.color = 'grey';
   });

   $(document).on('click', ".btn-edit", function(e){
      $(".modal-action").text("Edit");
      $("#modaldataset form").attr("action", url + "dataset/editdataset");
      var idReview = $(this).data('id');
      $('#modaldataset #id_review').val(idReview);
      $.ajax({
        method:'post',
        url: url + "dataset/fetchid",
        data:{id:idReview},
        success:function(data){
          var review = JSON.parse(data);
          $("#modaldataset input[name=judulreview]").val(review.judul_review);
          $("#modaldataset textarea[name=teksreview]").val(review.isi_review);
		      $("#modaldataset select[name=kategori]").val(review.kategori_review);
          $("#modaldataset select[name=sentimenawal]").val(review.sentimen_review);

          var count = $("#modaldataset textarea[name=teksreview]").val().length;
          $("#countreviewchar").text(count);
          document.getElementById('countreviewchar').style.color = 'grey';
        },
        error:function(e){
          alert(e)
        }
      });
   });
});