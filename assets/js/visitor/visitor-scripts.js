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
});
