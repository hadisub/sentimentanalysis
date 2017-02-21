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
  "ajax": url + "katadasar/kata"
 });
  $(document).on('click', ".btn-delete", function(e){
  var idKatadasar = $(this).data('id');
  $('#deletekatadasarmodal #id_katadasar').val(idKatadasar);
 });

  $(".btn-add").on('click', function(){
  $(".modal-action").text("Tambah");
  $("#modalkatadasar form").attr("action", url + "katadasar/inputkatadasar");
  $('#modalkatadasar #id_katadasar').val("");
  
  //kosongkan form setiap klik button tambah
  $("#modalkatadasar input[name=katadasarbaru]").val('');
  $("#countkatdaschar").text("0");
  document.getElementById('countkatdaschar').style.color = 'grey';
 });

  $(document).on('click', ".btn-edit", function(e){              
  $(".modal-action").text("Edit");
  $("#modalkatadasar form").attr("action", url+ "katadasar/editkatadasar");
  var idKatadasar = $(this).data('id');
  $('#modalkatadasar #id_katadasar').val(idKatadasar);
    $.ajax({
      method:'post',
      url: url + "katadasar/ambilkata",
      data:{id:idKatadasar},
      success:function(data){
        var katadasar = JSON.parse(data);
        $("#modalkatadasar input[name=katadasarbaru]").val(katadasar.kata_katadasar);

        var count = $("#modalkatadasar input[name=katadasarbaru]").val().length;
        $("#countkatdaschar").text(count);
        document.getElementById('countkatdaschar').style.color = 'grey';
      },
      error:function(e){
        alert(e)
      }
    });
 });
});