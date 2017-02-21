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
  "ajax": url + "displayterm/tabeltokenized"
 });
  
});