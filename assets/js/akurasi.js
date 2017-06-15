var url = $("meta[name=url]").attr("content");

function loadtabel(){
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
    "ajax": url + "akurasi/tabeltest"
  });
}

function loadmatrix(){
	$.ajax({
		url: url + "akurasi/matrix_akurasi",
		dataType: "json",
		success: function(data){
			//print_matrix_contents(data);
			var arr = [];
			for(var i in data){
				arr.push(data[i]);
			}
			print_matrix_contents(arr);
		},
		error: function(){
			alert("Tidak dapat mengambil matriks");
		}
	});
}

function print_matrix_contents(matrix){
	$("#total-datauji").append(matrix[0]); //total data uji
	$("#true-positives").append(matrix[1]); //true positives
	$("#true-negatives").append(matrix[2]); //true negatives
	$("#false-positives").append(matrix[3]); //false positives
	$("#false-negatives").append(matrix[4]); //false negatives
	$("#akurasi").append(matrix[5]); //akurasi
	$("#error-rate").append(matrix[6]); //error rate
	$("#ppv").append(matrix[7]); //positive predictive value
	$("#npv").append(matrix[8]); //negative predictive value
	$("#sensitivity").append(matrix[9]); //sensitivity
	$("#specificity").append(matrix[10]); //specitivity
	
	$("#akurasi-percentage").append((matrix[5]*100).toFixed(2)); //error rate
	
}

$(document).ready(function () {
	$('#divtabeltest').load(url+'akurasi/displaytabeltest', function(){
    //LOAD DATATABLES
    loadtabel();
	loadmatrix();
    }); 
  
  $('#akurasibtn').click(function(){
    $('#divtabeltest').html('');
	$('#persentase-wrapper').html('');
    $('#divtabeltest').addClass('loader');
	$('#persentase-wrapper').hide();
	//INSERT HASIL PERHITUNGAN DATA UJI
    $.ajax({
       url: url + "akurasi/insert_datauji",
       success: function(){
				loadmatrix();
				$('#divtabeltest').removeClass('loader');
				$('#persentase-wrapper').show();
             },
       error: function(){
                $('#divtabeltest').removeClass('loader');
				$('#persentase-wrapper').show();
				alert("Tidak dapat memperbarui tabel");
             }
    });
    $('#divtabeltest').load(url+'akurasi/displaytabeltest', function(){
      //LOAD DATATABLES
      loadtabel();
    });  
  });
});
