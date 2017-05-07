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
		"ajax": url + "train/tabeltrain"
	});
}

$(document).ready(function () {
	$('#divtabeltraining').load(url+'train/displaytabeltrain', function(){
		//LOAD DATATABLES
		loadtabel();
		}); 
	
	$('#trainbtn').click(function(){
		$("#divtabeltraining").hide();
		$("#loader").show();
		//INSERT TERM OCCURENCES
		$.ajax({
			url: url + "train/insert_term_occ",
			cache: false,
			success: function(){
                $("#loader").hide();
            },
			error: function(){
                $("#loader").hide();
            }
		});
 		$('#divtabeltraining').load(url+'train/displaytabeltrain', function(){
			//LOAD DATATABLES
			loadtabel();
			$("#divtabeltraining").show();
		});  
	});
});
