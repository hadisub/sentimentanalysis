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
    $('#divtabeltest').html('');
    $('#divtabeltest').addClass('loader');
	//INSERT HASIL PERHITUNGAN DATA UJI
    $.ajax({
       url: url + "akurasi/insert_datauji",
       success: function(){
                $('#divtabeltest').removeClass('loader');
             },
       error: function(){
                $('#divtabeltest').removeClass('loader');
             }
    });
    $('#divtabeltest').load(url+'akurasi/displaytabeltest', function(){
      //LOAD DATATABLES
      loadtabel();
    });  
  });
});
