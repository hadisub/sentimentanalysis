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

function loadmatrix(){
	$.ajax({
		url: url + "akurasi/matrix_akurasi",
		dataType: "json",
		success: function(data){
			$data = JSON.stringify(data);
			print_matrix_contents(data);
			console.log(data);
		},
		error: function(){
			alert("Tidak dapat mengambil matriks");
		}
	});
}

function print_matrix_contents(matrix){
	document.getElementById("akurasi-percentage").innerHTML = matrix;
}

$(document).ready(function () {
	$('#divtabeltest').load(url+'akurasi/displaytabeltest', function(){
    //LOAD DATATABLES
    loadtabel();
	loadmatrix();
    }); 
  
  $('#akurasibtn').click(function(){
    $('#divtabeltest').html('');
    $('#divtabeltest').addClass('loader');
	//INSERT HASIL PERHITUNGAN DATA UJI
    $.ajax({
       url: url + "akurasi/insert_datauji",
       success: function(){
				loadmatrix();
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
