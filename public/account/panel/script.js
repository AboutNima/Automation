$(document).ready(function()
{

    // Start menu drop down
    $('.aside-right .menu .dropdown').hide(0)
    $('.aside-right .menu li span').click(function()
    {
        if($(this).attr('class')=='active')
        {
            $(this).find('.dropdown').hide(0)
            $(this).removeClass('active')
        }else{
            $('.aside-right .menu li span').removeClass('active')
            $('.aside-right .menu .dropdown').hide(0)
            $(this).find('.dropdown').show(0)
            $(this).addClass('active')
        }
    })

    // Start aside right
    $('.page .aside-right .body .menu')
    $('#minimizeAside').click(function()
    {
        $('header').toggleClass('minimize')
        $('.aside-right').toggleClass('minimize')
        $('.page-content').toggleClass('minimize')
    })
    $('#showAside').click(function()
    {
        $('.page .aside-right').css('right','0')
        $('#asideOpacity').fadeIn(300)
    })
    $('#hideAside,#asideOpacity').click(function(){
        $('.page .aside-right').css('right','-300px')
        $('#asideOpacity').fadeOut(300)
    })
    $('.page .aside-right .body').scroll(function()
    {
        if($(this).scrollTop()>20) $(this).css('box-shadow','0px 15px 35px -30px rgba(0,0,0,0.65) inset')
        else $(this).css('box-shadow','none')
    })

    // Start more
    $('.more .menu').fadeOut(0)
    $('.more .item').click(function()
    {
        var target_=$(this).parent().find('.menu')
        target_.fadeIn(300)
        target_.css({'top':'calc(5px + 100%)'})
    })
    $(document).mouseup(function(e)
    {
        var element_=$('.more .menu');
        if (!element_.is(e.target) && element_.has(e.target).length === 0){
            element_.fadeOut(200);
            element_.closest('.input-select').css('border-color','#e9e9e9')
            element_.css({'top':'calc(25px + 100%)'})
        }
    });

    // Start show time
    var date=gregorianToJalaliDate()
    var today=new Date();
    var minute_=today.getMinutes()<10 ? '0'+today.getMinutes() : today.getMinutes()
    $('#showTime').html(date.weekDay+' '+date.day+' '+date.month+' ساعت '+today.getHours()+':'+minute_)
    setInterval(function(){
        today=new Date()
        minute_=today.getMinutes()<10 ? '0'+today.getMinutes() : today.getMinutes()
        $('#showTime').html(date.weekDay+' '+date.day+' '+date.month+' ساعت '+today.getHours()+':'+minute_)
    },1000)

})