var url = $("meta[name=url]").attr("content");

function loadtabel(){
  $('#dataTables-example').dataTable({
    "language": {
    "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
    "sLengthMenu": "_MENU_  term per halaman",
    "sSearch": "Cari: ",
    "sNext": "Selanjutnya",
    "sPrevious": "Sebelumnya"
     },
    "processing": true,
    "serverSide": true,
    "ajax": url + "akurasi/tabeltest"
  });
}

$(document).ready(function () {
  $('#divtabeltest').load(url+'akurasi/displaytabeltest', function(){
    //LOAD DATATABLES
    loadtabel();
    }); 
  
  $('#akurasibtn').click(function(){
    $("#divtabeltest").hide();
    $("#loader").show();
    //INSERT TERM OCCURENCES
    // $.ajax({
    //   url: url + "train/insert_term_occ",
    //   cache: false,
    //   success: function(){
    //             $("#loader").hide();
    //         },
    //   error: function(){
    //             $("#loader").hide();
    //         }
    // });
    $('#divtabeltest').load(url+'akurasi/displaytabeltest', function(){
      //LOAD DATATABLES
      loadtabel();
      $("#divtabeltest").show();
    });  
  });
});
