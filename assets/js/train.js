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
		"ajax": url + "train/tabeltrain"
	});
}

$(document).ready(function () {
	$('#divtabeltraining').load(url+'train/displaytabeltrain', function(){
		//LOAD DATATABLES
		loadtabel();
		}); 
	
	$('#trainbtn').click(function(){
		$('#divtabeltraining').html('');
		$('#divtabeltraining').addClass('loader');
		//INSERT TERM OCCURENCES
		$.ajax({
			url: url + "train/insert_train",
			success: function(){
                $('#divtabeltraining').removeClass('loader');
            },
			error: function(){
                 $('#divtabeltraining').removeClass('loader');
				 alert('Tidak dapat memperbarui tabel');
            }
		});
 		$('#divtabeltraining').load(url+'train/displaytabeltrain', function(){
			//LOAD DATATABLES
			loadtabel();
		});  
	});
});
