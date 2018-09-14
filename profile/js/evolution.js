$(document).ready(function () {
    $(document).keydown(function(e){
        if (e.keyCode == 40) { 
            //alert('#' + dataslide4N + '')
           $("html, body").animate({

                    scrollTop: $('#' + dataslide4N + '').offset().top
                }, 1500, 'easeInOutQuint');
           $('section[id="' + dataslide1C + '"] .button').addClass('flash');
           return false;
           event.preventDefault();
        }

        if (e.keyCode == 38) { 
            //alert('#' + dataslide4N + '')
           $("html, body").animate({

                    scrollTop: $('#' + dataslide2P + '').offset().top
                }, 1500, 'easeInOutQuint');
           return false;
           event.preventDefault();
        }

        if (e.keyCode == 32) { 
           $(".button0").click()
        }
    });

    slide1 = $('.slide');
    slide1.waypoint(function (event, direction) {
        //cache the variable of the data-slide attribute associated with each slide
        dataslide0 = $(this).attr('data-slide');
        dataslide1C = 'slide' + dataslide0; //Current
        dataslide2P = 'slide' + (dataslide0 - 1); //Previous
        dataslide3 = parseInt(dataslide0) + 1;
        dataslide4N = 'slide' + dataslide3; //Next
        profilehashtag = $('section[id="' + dataslide1C + '"]').attr('id')
        $('section[id="' + dataslide1C + '"] div.profile').fadeIn(2000);
    }, {
        offset: '50%'
    });
});