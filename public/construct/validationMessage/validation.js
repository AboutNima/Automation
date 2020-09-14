function validationMessage(hide,msg,type='danger',err,target='.validation-message')
{
    target=$(target).first()
    if($.inArray(type,['primary','success','warning','purple'])===-1) type='danger'
    if(target.hasClass('no-margin')) type+=' no-margin'
    if(target.hasClass('top')) type+=' top'
    if(target.hasClass('bottom')) type+=' bottom'
    target.attr('class','validation-message '+type)
    target.html('<ul></ul>')
    if($.isArray(msg))
    {
        $.each(msg,function(key,val)
        {
            target.find('ul').append(
                '<li>'+val+'</li>'
            )
        })
    }else{
        target.find('ul').append(
            "<li>"+msg+"</li>"
        )
    }
    target.fadeIn(350)
    if(hide)
    {
        setTimeout(function(){
            target.fadeOut(350)
        },2500)
    }
}