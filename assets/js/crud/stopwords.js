$(document).ready(function () {
var url = $("meta[name=url]").attr("content");

 $('#dataTables-example').dataTable({
  "language": {
       "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
       "sLengthMenu": "_MENU_  kata per halaman",
       "sSearch": "Cari: ",
       "sNext": "Selanjutnya",
       "sPrevious": "Sebelumnya"
     },
  "processing": true,
  "serverSide": true,
  "ajax": url + "stopwords/kata"
 });
  $(document).on('click', ".btn-delete", function(e){
  var idStopwords = $(this).data('id');
  $('#deletestopwordsmodal #id_stopwords').val(idStopwords);
 });

  $(".btn-add").on('click', function(){
  $(".modal-action").text("Tambah");
  $("#modalstopwords form").attr("action", url + "stopwords/inputstopwords");
  $('#modalstopwords #id_stopwords').val("");
  
  //kosongkan form setiap klik button tambah
  $("#modalstopwords input[name=stopwordsbaru]").val('');
  $("#countstopwordschar").text("0");
  document.getElementById('countstopwordschar').style.color = 'grey';
 });

  $(document).on('click', ".btn-edit", function(e){              
  $(".modal-action").text("Edit");
  $("#modalstopwords form").attr("action", url+ "stopwords/editstopwords");
  var idStopwords = $(this).data('id');
  $('#modalstopwords #id_stopwords').val(idStopwords);
    $.ajax({
      method:'post',
      url: url + "stopwords/ambilkata",
      data:{id:idStopwords},
      success:function(data){
        var stopwords = JSON.parse(data);
        $("#modalstopwords input[name=stopwordsbaru]").val(stopwords.kata_stopwords);

        var count = $("#modalstopwords input[name=stopwordsbaru]").val().length;
        $("#countstopwordschar").text(count);
        document.getElementById('countstopwordschar').style.color = 'grey';
      },
      error:function(e){
        alert(e)
      }
    });
 });
});