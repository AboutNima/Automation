$(document).ready(function()
{
    $('.popup').each(function()
    {
        $(this).hide(0)
        var title=$(this).attr('popup-title')
        var size=$(this).attr('popup-size')
        size=typeof size!==typeof undefined && size!==false && size!='' ? ' '+size : '';
        if(typeof title==typeof undefined || title==false || title==''){alert('missing popup title');return false;}
        $(this).html(
            "<div class='popup-content"+size+"'>\n"+
            "    <div class='popup-header'>\n"+
            "        <p>"+title+"</p>\n"+
            "        <span class='close'><i class='fal fa-times-circle'></i></span>\n"+
            "    </div>\n"+
            "    <div class='popup-body'>\n"+$(this).html()+"</div>\n"+
            "</div>"
        )
    })
    $(document).on('keydown','body',function(e)
    {
        if(e.keyCode==27)
        {
            deactivatePopup($('.popup'))
        }
    })
    $(document).on('click','.popup-active',function()
    {
        var popup=$(this).attr('popup-target')
        if(typeof popup==typeof undefined || popup==false || popup==''){alert('missing popup target');return false;}
        activePopup($(popup))
    })
    $(document).on('click','.popup .popup-content .popup-header .close',function()
    {
        deactivatePopup($(this).closest('.popup'))
    })
    $(document).on('click','.popup',function(e){if(e.target == e.currentTarget){deactivatePopup($(this).closest('.popup'))}})
})
function activePopup(popup)
{
    popup=$(popup)
    popup.fadeIn(100)
    setTimeout(function(){
        popup.find('.popup-content').css({'top':'75px','transform':'translateX(-50%) scale(1)'})
    },0 )
}
function deactivatePopup(popup)
{
    popup=$(popup)
    popup.find('.popup-content').css({'top':'125px','transform':'translateX(-50%) scale(0.9)'})
    setTimeout(function(){
        popup.fadeOut(100)
    },0)
}
// setTimeout(function(){
//     activePopup('.popup')
// },100)