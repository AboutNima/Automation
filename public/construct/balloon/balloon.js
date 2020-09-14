$(document).ready(function()
{
    var timeOut=250
    $('.balloon').each(function()
    {
        var position=$(this).attr('balloon-position')
        var text=$(this).attr('balloon-text')
        $(this).removeAttr('balloon-text')
        if(typeof position==typeof undefined || position==false || position==''){alert('missing balloon position');return false;}
        if(typeof text==typeof undefined || text==false || text==''){alert('missing balloon text');return false;}
        $(this).append(
            "<span class='balloon-elm "+position+"' style='display: none'>"+text+"</span>"
        )
    })
    $(document).on('mouseover focus','.balloon',function()
    {
        var elm=$(this).find('.balloon-elm')
        var position=$(this).attr('balloon-position')
        timeOut=$(this).attr('balloon-timeout')!='' && $(this).attr('balloon-timeout')!=undefined ? parseInt($(this).attr('balloon-timeout')) : 250
        if(typeof position==typeof undefined || position==false || position==''){alert('missing balloon position');return false;}
        switch(position)
        {
            case 'top':
                position='bottom';
                break;
            case 'right':
                position='left';
                break;
            case 'bottom':
                position='top';
                break;
            case 'left':
                position='right';
                break;
        }
        setTimer=setTimeout(function(){
            elm.stop().fadeIn(150).css(position,'calc(100% + 12px)')
        },timeOut)
    }).on('mouseleave focusout','.balloon',function()
    {
        clearTimeout(setTimer)
        var elm=$(this).find('.balloon-elm')
        var position=$(this).attr('balloon-position')
        timeOut=$(this).attr('balloon-timeout')!='' && $(this).attr('balloon-timeout')!=undefined ? parseInt($(this).attr('balloon-timeout')) : 250
        if(typeof position==typeof undefined || position==false || position==''){alert('missing balloon position');return false;}
        switch(position)
        {
            case 'top':
                position='bottom';
                break;
            case 'right':
                position='left';
                break;
            case 'bottom':
                position='top';
                break;
            case 'left':
                position='right';
                break;
        }
        setTimer=setTimeout(function(){
            elm.stop().fadeOut(150).css(position,'100%')
        },timeOut)
    })
})