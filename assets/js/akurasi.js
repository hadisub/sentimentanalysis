$(document).ready(function () {
var url = $("meta[name=url]").attr("content");

 //SHOW TABEL TEST WHEN CLICKED
 $('#akurasibtn').click(function(){
 $('#divtabeltest').load(url+'akurasi/displaytabeltest', function(){
    //LOAD DATATABLES
    $('#dataTables-example').dataTable({
    "language": {
       "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
       "sLengthMenu": "_MENU_  data uji per halaman",
       "sSearch": "Cari: ",
       "sNext": "Selanjutnya",
       "sPrevious": "Sebelumnya"
     },
    "processing": true,
    "serverSide": true,
    "ajax": url + "akurasi/tabeltest"
      });
    });  
  });
});
