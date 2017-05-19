var url = $("meta[name=url]").attr("content");

function extract_review(){
	$.ajax({
		url: url + "visitor/extract_visitor_review",
		dataType: "json",
		type: "POST",
		success: function(data){
			console.log(data);
			print_analysis_contents(data);
			$('#analisis-wrapper').removeClass('loader');
		},
		error: function(){
			$('#analisis-wrapper').removeClass('loader');
		}
	});
}

function print_analysis_contents(contents){
	$("#isi-review").append(contents);
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
		e.preventDefault();
		$('#analisis-wrapper').html('');
		$('#analisis-wrapper').load(url+'visitor/display_analisis', function(){
			$('#analisis-wrapper').addClass('loader');
			extract_review();
		});
	});
});
