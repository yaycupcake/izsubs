jQuery(document).ready(function ($) {
    //initialise Stellar.js
    $(window).stellar();
    
    //Cache some variables
    var links = $('.navigation').find('li');
    slide = $('.slide');
    button = $('.button');
    buttonstart = $('.button.start');
    button0 = $('.button0');
    scrolldown = $('.scrolldown');
    mywindow = $(window);
    htmlbody = $('html,body');
    
    //Setup waypoints plugin
    slide.waypoint(function (event, direction) {
        //cache the variable of the data-slide attribute associated with each slide
        dataslide = $(this).attr('data-slide');
        //If the user scrolls up change the navigation link that has the same data-slide attribute as the slide to active and 
        //remove the active class from the previous navigation link 

        if (direction === 'down') {
            $('.navigation li[data-slide="' + dataslide + '"]').addClass('active').prev().removeClass('active');
        }
        // else If the user scrolls down change the navigation link that has the same data-slide attribute as the slide to active and 
        //remove the active class from the next navigation link 
        else {
            $('.navigation li[data-slide="' + (dataslide-1) + '"]').addClass('active').next().removeClass('active');
        }
    });
    
    //waypoints doesnt detect the first slide when user scrolls back up to the top so we add this little bit of code, that removes the class 
    //from navigation link slide 2 and adds it to navigation link slide 1. 
    mywindow.scroll(function () {
        if (mywindow.scrollTop() == 1) {
            $('.navigation li[data-slide="1"]').addClass('active');
            $('.navigation li[data-slide="1"]').removeClass('active');
            
        }
        $('.navigation li[data-slide="13"]').css('border-bottom-width','0')
        $('.navigation li[data-slide="1"]').css('border-bottom-width','0')


        if ($('.navigation li[data-slide="1"],.navigation li[data-slide="3"],.navigation li[data-slide="5"],.navigation li[data-slide="6"],.navigation li[data-slide="8"],.navigation li[data-slide="9"],.navigation li[data-slide="11"]').hasClass('active')) {
            $('.navigation li').addClass('dark-menu');  
            $("#topbar").fadeIn('fast');
            $(".navigation").fadeIn('fast');
            $('.navigation li.noborder').css('display','block');
        }
    });
    
    //Create a function that will be passed a slide number and then will scroll to that slide using jquerys animate. The Jquery
    //easing plugin is also used, so we passed in the easing method of 'easeInOutQuint' which is available throught the plugin.
    function goToByScroll(dataslide) {
        htmlbody.animate({
            scrollTop: $('.slide[data-slide="' + dataslide + '"]').offset().top
        }, 2000, 'easeInOutQuint');

    }
    
    //When the user clicks on the navigation links, get the data-slide attribute value of the link and pass that variable to the goToByScroll function
    links.click(function (e) {
        e.preventDefault();
        dataslide = $(this).attr('data-slide');
        goToByScroll(dataslide);
    });
    
    //When the user clicks on the button, get the get the data-slide attribute value of the button and pass that variable to the goToByScroll function
    button.click(function (e) {
        e.preventDefault();
        dataslide = $(this).attr('data-slide');
        goToByScroll(dataslide);
    });
    scrolldown.click(function (e) {
        e.preventDefault();
        dataslide = $(this).attr('data-slide');
        goToByScroll(dataslide);
    });
    button0.click(function (e) {
        e.preventDefault();
        dataslide = $(this).attr('data-slide');
        goToByScroll(dataslide);
        $('body').removeClass('noscroll');
        $("#start").trigger("play"); // plays the audio
        $(".clickon").remove();

        });

    
    //Mute button on click add class muted, mute and change icon
    $(document).on("click", "#mute", function(){
        $('#mute').addClass('muted');
        $('audio.active').trigger("play");
        $('audio.active').animate({
            volume: 1
        }, 200);

        $('#mute div').css({
            'background': 'url(images/icons/mute_off.png) center center no-repeat'
        });
    })

    //Mute button - if exists turn on the music remove class and change bg
    $(document).on("click", "#mute.muted", function(){
        // Usage
        if ($('#mute').hasClass('muted')) {
            $('audio.active').trigger("mute");
            $('audio').animate({
                volume: 0
            }, 200);
            $('audio.active').trigger("pause");
            $('#mute').removeClass('muted');
            $('#mute div').css({
                'background': 'url(images/icons/mute_on.png) center center no-repeat'
            });
        };
    });
});