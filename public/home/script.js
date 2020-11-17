$(document).ready(function()
{
    // Start nav setting
    $(window).scroll(function(){
        if($(this).scrollTop()>25) $('nav').addClass('active')
        else $('nav').removeClass('active')
    });

    // Start best course slick
    $('.best-course .slick-slider').slick({
        rtl: true,
        slidesToShow: 3,
        slidesToScroll: 3,
        dots: true,
        arrows: false,
        appendDots: $('.best-course div[slick-dots]'),
        focusOnSelect: false,
        autoplay: true,
        autoplaySpeed: 4000,
        responsive: [
            {
                breakpoint: 1200,
                settings:{
                    slidesToShow: 3
                }
            },{
                breakpoint: 960,
                settings:{
                    slidesToShow: 2
                }
            },{
                breakpoint: 576,
                settings:{
                    slidesToShow: 1
                }
            }
        ]
    })

    // Start they say
    $('.they-say .slick-slider').slick({
        rtl: true,
        slidesToShow: 4,
        slidesToScroll: 4,
        dots: true,
        arrows: false,
        appendDots: $('.they-say div[slick-dots]'),
        focusOnSelect: false,
        autoplay: true,
        autoplaySpeed: 4000,
        responsive: [
            {
                breakpoint: 1200,
                settings:{
                    slidesToShow: 3
                }
            },{
                breakpoint: 960,
                settings:{
                    slidesToShow: 2
                }
            },{
                breakpoint: 576,
                settings:{
                    slidesToShow: 1
                }
            }
        ]
    })

})