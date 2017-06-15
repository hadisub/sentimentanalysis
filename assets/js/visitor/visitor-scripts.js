var url = $("meta[name=url]").attr("content");

function extract_review(){
	isi_review = $("#visitor-review").val();
	
	$.ajax({
		url: url + "visitor/process_visitor_review/",
		dataType: "json",
		type: "POST",
		data: {'isi_review':isi_review},
		success: function(results){
			var arr = [];
			for(var i in results){
				arr.push(results[i]);
			}
			$('#loader-wrapper').removeClass("loader");
			print_analysis_contents(arr);
			$('#analisis-wrapper').show();
		},
		error: function(){
			$('#loader-wrapper').removeClass("loader");
			$('#analisis-wrapper').show();
			alert("Tidak dapat memroses hasil analisis.");
		}
	});
}

function print_analysis_contents(contents){
	$("#pos-prob").append(contents[0]);
	$("#neg-prob").append(contents[1]);
	$("#visitor-sentimen").append(contents[2]);
	console.log(contents);
}

$(document).ready(function(){
	var counterZero = '0';	
    $('.intro-number').text(counterZero);

    $('.intro-number').waypoint(function() {
        $('.intro-number').each(function() {
            var $this = $(this);
            $({
                Counter: 0
            }).animate({
                Counter: $this.attr('data-stop')
            }, {
                duration: 2000,
                easing: 'swing',
                step: function(now) {
                    $this.text(Math.ceil(now));
                }
            });
        });
        this.destroy();
    }, {
        offset: '70%'
    });
	
	
	$('#visitor-form').submit(function(e){
		var review_text = document.getElementById("visitor-review").value.length;
		e.preventDefault();
		$('#analisis-wrapper').html('');
		if(review_text==0 || review_text>7500){ //jika textarea tidak diisi atau isi melebihi 7500 karakter
			$('#modal-error').modal('show'); 
		}
		else{
			$('#loader-wrapper').addClass("loader");
			$('#analisis-wrapper').hide();
			$('#analisis-wrapper').load(url+'visitor/display_analisis');
			extract_review();
		}
	});
});