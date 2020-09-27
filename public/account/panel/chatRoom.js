$(document).ready(function()
{
    window.Token=null;
    var profile
    var receiveAudio=$('#receiveAudio')[0]
    var sendAudio=$('#sendAudio')[0]
    var chatroom=$('.chatroom')

    function openChatroom(){chatroom.addClass('open')}
    function closeChatroom()
    {
        chatroom.removeClass('open')
        chatroom.find('.body .profile').hide(0)
        chatroom.find('> .body,.body .panel ul li').removeClass('active')
        chatroom.find('.chat .body ul').html('')
        window.Token=null;
        resetTextarea()
    }
    function loadChatroom(id)
    {
        openChatroom()
        $.post('/ajax/account/admin/chatroom/loadChat',{id:id},function(data)
        {
            data=$.parseJSON(data)
            window.Token=data.Token

            chatroom.find('.body .profile div').attr('class',data.online)
            chatroom.find('.body .profile div img').attr('src',profile.find('img').attr('src'))
            chatroom.find('.body .profile div span.name').html(profile.find('span').html())
            chatroom.find('.body .profile div span.status').html(data.onlineFrom)
            chatroom.find('.body .profile').show(0)

            chatroom.find('> .body').addClass('active')

            getChatroomReady()
        })

    }
    function getChatroomReady()
    {
        $.post('/ajax/account/admin/chatroom/getChatroomReady',{Token:Token},function(data)
        {
            chatroom.find('.chat .body ul').html('')
            resetTextarea()
            if(data=='') return false
            data=$.parseJSON(data)
            $.each(data,function(i,a){addToChat(a,a.sender===true ? 'me': 'partner',true)})
        })
    }
    function addToChat(data,whoSend,goToBottom=false,audio='0')
    {
        var scrollHeight=chatroom.find('.chat .body').scrollTop()+parseInt(chatroom.find('.chat .body').height())+10
        scrollHeight=scrollHeight>=chatroom.find('.chat > .body ul').height() ? true : false;

        var chatContent=chatroom.find('.chat .body ul')
        var content=(
            "<div class='text"+(data.seen=='1' ? ' seen': '')+"' timestamp='"+data.createdAt+"' chat-id='"+data.id+"'>"+
            "   <p>"+data.text+"</p>"+
            "   <div class='info'>"+
            "      <i class='fal fa-check'></i>"+
            "      <span class='time'>"+data.humanTiming+"</span>"+
            "   </div>"+
            "</div>"
        )
        if(chatContent.find('li:last-child').hasClass(whoSend)) chatContent=chatContent.find('li:last-child')
        else content="<li class='"+whoSend+"'>"+content+"</li>"
        chatContent.append(content)

        if(scrollHeight) chatroom.find('.chat .body').scrollTop(chatroom.find('.chat .body ul').height())
        else{
            // $('#unread').html(parseInt($('#unread').html())+1).fadeIn(150)
        }

        if(goToBottom)
        {
            chatroom.find('.chat .body').scrollTop(chatroom.find('.chat .body ul').height())
            // $('#unread').fadeOut(150).html(0);
        }

        if(audio=='1')
        {
            sendAudio.pause()
            sendAudio.currentTime=0
            sendAudio.play()
        }else if(audio=='2')
        {
            receiveAudio.pause()
            receiveAudio.currentTime=0
            receiveAudio.play()
        }

        resetTextarea()
    }
    function resetTextarea()
    {
        chatroom.find('.chat .footer textarea').val('').css('height','55px')
    }
    function sendMessage(text)
    {
        resetTextarea()
        $.post('/ajax/account/admin/chatroom/sendMessage',{text:text,Token:window.Token},function(data)
        {
            if(data=='') return false;
            addToChat($.parseJSON(data),'me',true,1)
        })
    }

    $('#openChatroom').click(function(){openChatroom()})
    $('#closeChatroom').click(function(){closeChatroom()})

    chatroom.on('click','.body .panel ul li',function()
    {
        var this_=profile=$(this)
        var id=this_.attr('data-id')
        this_.addClass('active').siblings('li').removeClass('active')
        loadChatroom(id)
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
        var text=$.trim($('#chatArea').val())
        if(window.Token===null) return false;
        sendMessage(text)
    })
    function getNewMessage()
    {
        $.post('/ajax/account/admin/chatroom/getNewMessage',{Token:window.Token},function(data)
        {
            if(data=='') return false;
            $.each($.parseJSON(data),function(i,a){addToChat(a,'partner',false,2)})
        })
    }

    // Chatroom interval
    setInterval(function(){
        // Start get status
        $.post('/ajax/account/admin/chatroom/getStatus',function(data)
        {
            data=$.parseJSON(data)
            $.each(data,function(i,a)
            {
                var admin=chatroom.find(".body .panel ul li[data-id='"+a.id+"']")
                if(!admin.hasClass(a.online)) admin.removeClass('online offline away').addClass(a.online)
                if(a.unread>0) admin.find('i.unread').html(a.unread>99 ? '+99' : a.unread).show(0)
                else admin.find('i.unread').hide(0)
            })
        })

        // If chat open and ready
        if(window.Token!==null)
        {
            // Start get new message
            getNewMessage()

            // Start check seen
            var chatId=[];
            $.each(chatroom.find('.body .chat ul li .text:not(.seen)'),function(i,a){chatId.push($(a).attr('chat-id'))})
            $.post('/ajax/account/admin/chatroom/checkSeen',{Token:window.Token,data:chatId},function(data)
            {
                if(data=='') return false;
                $.each($.parseJSON(data),function(i,a){chatroom.find(".body .chat ul li .text[chat-id='"+a+"']").addClass('seen')})
            })
        }
    },500)

    // Stay online interval
    setInterval(function(){$.post('/ajax/account/admin/stayOnline')},1000*60)

    // setInterval(function(){
    //     $.post('/ajax/account/admin/chatroom/getNotification',function(data)
    //     {
    //         data=$.parseJSON(data)
    //         $.each(data,function(key,data)
    //         {
    //             if($(".chatroom .body .panel ul li[data-id='"+data.id+"']").hasClass('active')) return false;
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
    // $(document).on('click','.chat-notification ul li',function()
    // {
    //     var dataId=$(this).attr('data-id');
    //     $(".chatroom .body .panel ul li[data-id='"+dataId+"']").click()
    //     $(".chat-notification ul li[data-id='"+dataId+"']").remove()
    // })
})