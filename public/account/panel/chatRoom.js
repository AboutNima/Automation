$(document).ready(function()
{
    var receiveAudio=$('#receiveAudio')[0]
    var sendAudio=$('#sendAudio')[0]

    // setInterval(function(){
    //     $.post('/ajax/account/chatRoom/getStatus',function(data)
    //     {
    //         data=$.parseJSON(data)
    //         $.each(data,function(key,data)
    //         {
    //             var manager=$(".chat-room .body .panel ul li[data-id='"+data.id+"']")
    //
    //             var managerClass=manager.hasClass('active') ? 'balloon active '+data.online : 'balloon '+data.online;
    //             manager.attr('class',managerClass)
    //             if(data.unread!=0)
    //             {
    //                 manager.find('i').show(0)
    //                 if(data.unread>99) data.unread='99+'
    //                 manager.find('i').html(data.unread)
    //             }else manager.find('i').hide(0)
    //             manager.find('img').attr('src','/'+data.avatar)
    //             manager.find('span.balloon-elm').html(data.name)
    //         })
    //     })
    // },500)
    // setInterval(function(){
    //     $.post('/ajax/account/chatRoom/getNotification',function(data)
    //     {
    //         data=$.parseJSON(data)
    //         $.each(data,function(key,data)
    //         {
    //             if($(".chat-room .body .panel ul li[data-id='"+data.id+"']").hasClass('active')) return false;
    //             $('.chat-notification ul').append(
    //                 "<li data-id='"+data.id+"'>"+
    //                 "   <img src='/"+data.avatar+"' alt=''>"+
    //                 "   <p>"+data.text+"</p>\n"+
    //                 "</li>"
    //             )
    //             var lastChild=$('.chat-notification ul li:last-child')
    //             lastChild.fadeIn(500)
    //             setTimeout(function(){
    //                 lastChild.addClass('active')
    //             },70)
    //         })
    //     })
    // },500)

    $(document).on('click','.chat-notification ul li',function()
    {
        var dataId=$(this).attr('data-id');
        $(".chat-room .body .panel ul li[data-id='"+dataId+"']").click()
        $(".chat-notification ul li[data-id='"+dataId+"']").remove()
    })
    $('#openChatRoom').click(function()
    {
        $('.chat-room').addClass('open')
    })
    $('#closeChatRoom').click(function()
    {
        $('.chat-room').removeClass('open')
        $('.chat-room .body .profile').hide(0).removeAttr('token')
        $('.chat-room .body .panel,.chat-room .body .chat').css({
            'height':'calc(100% - 60px)',
            'top':'0px'
        })
        $('.chat-room .body .panel ul li').removeClass('active')
        $('.chat-room .chat .body ul').html('')
        resetTextarea()
    })
    $('.chat-room .body .panel ul li').click(function()
    {
        var dataId=$(this).attr('data-id')
        $(".chat-notification ul li[data-id='"+dataId+"']").remove()
        $(this).siblings('li').removeClass('active')
        $(this).addClass('active')
        $('.chat-room').addClass('open')
        resetTextarea()
        $.post('/ajax/account/chatRoom/openChat',{id:dataId},function(data)
        {
            data=$.parseJSON(data)
            $('.chat-room .body .profile').attr('token',data.token)
            $('.chat-room .body .profile div img').attr('src','/'+data.avatar)
            $('.chat-room .body .profile div:first-child').attr('class',data.online)
            $('.chat-room .body .profile div span:first-child').html(data.name)
            $('.chat-room .body .profile div span:last-child').html(data.onlineFrom)
            $('.chat-room .body .profile').show(0)
            $('.chat-room .body .panel,.chat-room .body .chat').css({
                'height':'calc(100% - 122px)',
                'top':'60px'
            })
            loadChat(data.token)
        })
        $(this).find('i').html('').hide(0)
    })
    $('#chatArea').on('keyup',function(e)
    {
        var val=$.trim($(this).val())
        var code=e.keyCode ? e.keyCode : e.which

        if(code==13 && !e.shiftKey)
        {
            var token=$(this).closest('.body').find('.profile').attr('token');
            if(token==typeof undefined) return false;
            sendMessage(val,token)
        }
        $(this).css('height','52px')
        $(this).css('height',$(this)[0].scrollHeight+3+'px')

        // Hide - Show send message and file
        if(val!='')
        {
            $('#sendFile').fadeOut(30)
            setTimeout(function(){
                $('#sendMessage').fadeIn(30)
            },60)
        }else{
            $('#sendMessage').fadeOut(30)
            setTimeout(function(){
                $('#sendFile').fadeIn(30)
            },60)
        }
    })
    $('#sendMessage').click(function()
    {
        var val=$.trim($('#chatArea').val())
        var token=$(this).closest('.body').find('.profile').attr('token');
        if(token==typeof undefined) return false;
        sendMessage(val,token)
    })

    // setInterval(function(){
    //     var token=$('.chat-room .body .profile').attr('token')
    //     if(token==typeof undefined) return false;
    //     getNewMessage(token)
    // },500)
    // setInterval(function(){
    //     var item=$('.chat-room .body .chat ul li .text:not(.seen)')
    //     var token=$('.chat-room .body .profile').attr('token')
    //     var chatId=[];
    //     $.each(item,function(key,elm){
    //         chatId.push($(elm).attr('chat-id'))
    //     })
    //     $.post('/ajax/account/chatRoom/checkSeen',{token:token,data:chatId},function(data)
    //     {
    //         if(data=='') return false;
    //         data=$.parseJSON(data)
    //         $.each(data,function(key,val){
    //             $(".chat-room .body .chat ul li .text[chat-id='"+val+"']").addClass('seen')
    //         })
    //     })
    // },500)

    function loadChat(token)
    {
        $.post('/ajax/account/chatRoom/loadChat',{token:token},function(data)
        {
            $('.chat-room .chat .body ul').html('')
            if(data=='') return false

            resetTextarea()
            data=$.parseJSON(data)
            $.each(data,function(key,data)
            {
                addToChat(data,data.sender===true ? 'me': 'partner',true)
            })
        })
    }
    function addToChat(data,whoSend,goToBottom=false,audio='0')
    {
        var scrollHeight=$('.chat .body').scrollTop()+parseInt($('.chat .body').height())+30
        scrollHeight=scrollHeight>=$('.chat .body ul').height() ? true : false;

        data.seen=data.seen=='1' ? ' seen': ''

        var chatRoom=$('.chat-room .chat .body ul');

        var appendToExistedChat=false;
        if(chatRoom.find('li:last-child').hasClass(whoSend)) appendToExistedChat=true;

        var content=(
            "<li class='"+whoSend+"'>"+
            "<div class='text"+data.seen+"' timestamp='"+data.createdAt+"' chat-id='"+data.id+"'>"+
            "   <p>"+data.text+"</p>"+
            "   <div class='info'>"+
            "   <i class='fal fa-check'></i>"+
            "   <span class='time'>"+data.humanTiming+"</span>"+
            "   </div>"+
            "</div>"+
            "</li>"
        )
        var target=chatRoom;
        if(appendToExistedChat)
        {
            content=(
                "<div class='text"+data.seen+"' timestamp='"+data.createdAt+"' chat-id='"+data.id+"'>"+
                "   <p>"+data.text+"</p>"+
                "   <div class='info'>"+
                "   <i class='fal fa-check'></i>"+
                "   <span class='time'>"+data.humanTiming+"</span>"+
                "   </div>"+
                "</div>"
            );
            target=chatRoom.find('li:last-child')
        }
        target.append(content)

        if(scrollHeight)
        {
            $('.chat .body').scrollTop($('.chat .body ul').height())
        }else{
            // $('#unread').html(parseInt($('#unread').html())+1).fadeIn(150)
        }

        if(goToBottom)
        {
            $('.chat .body').scrollTop($('.chat .body ul').height())
            $('#unread').fadeOut(150).html(0);
        }

        if(audio=='1')
        {
            sendAudio.pause()
            sendAudio.currentTime=0
            sendAudio.play()
        }else if(audio=='2'){
            receiveAudio.pause()
            receiveAudio.currentTime=0
            receiveAudio.play()
        }
    }
    function sendMessage(val,token)
    {
        resetTextarea()
        $.post('/ajax/account/chatRoom/sendMessage',{text:val,token:token},function(data)
        {
            if(data=='') return false;
            addToChat($.parseJSON(data),'me',true,true)
        })
    }
    function getNewMessage(token)
    {
        $.post('/ajax/account/chatRoom/getNewMessage',{token:token},function(data)
        {
            if(data=='') return false;

            data=$.parseJSON(data)
            $.each(data,function(key,data)
            {
                addToChat(data,'partner',false,'2')
            })
        })
    }
    function resetTextarea()
    {
        $('.chat-room .chat .footer textarea').val('').css('height','55px')
    }
})