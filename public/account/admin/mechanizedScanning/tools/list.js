$(document).ready(function()
{
    $(document).on('submit','#add form',function(e)
    {
        e.preventDefault();
        ajaxHandler($(this)).done(function(data)
        {
            data=$.parseJSON(data)
            validationMessage(false,data.msg,data.type,data.err,'#add .validation-message')
            if(data.err==null) setTimeout(function(){location.reload()},1500)
        })
    })
    $("a[href='#edit']").click(function()
    {
        $.post('/ajax/account/admin/mechanizedScanning/tools/getData',{id:$(this).attr('data-id')},function(data)
        {
            data=$.parseJSON(data)[0]
            changeSelect('#edit .type',$.parseJSON(data.type))
            $("#edit input[name='data[size]']").val(data.size);
            $("#edit input[name='data[company]']").val(data.company);
            $("#edit input[name='data[propertyNumber]']").val(data.propertyNumber);
            $("#edit input[name='data[count]']").val(data.count);
            $("#edit textarea").val(data.description);
            activePopup('#edit')
        })
    })
    $(document).on('submit','#edit form',function(e)
    {
        e.preventDefault();
        ajaxHandler($(this)).done(function(data)
        {
            data=$.parseJSON(data)
            validationMessage(false,data.msg,data.type,data.err,'#edit .validation-message')
            if(data.err==null) setTimeout(function(){location.reload()},1500)
        })
    })

    $('#startScan').qrCodeReader({
        callback: function(code)
        {
            sendQRCode(code)
        }
    })
    function sendQRCode(code)
    {
        $.post('/ajax/account/admin/mechanizedScanning/tools/getScannedData',{code:code},function(data)
        {
            data=$.parseJSON(data)
            if(data.data===null) validationMessage(2000,data.msg,data.type,data.err,'#scan .validation-message')
            else{
                data=$.parseJSON(data.data)
                if(Array.isArray(data))
                {
                    var sub=data[1];
                    $('#sub .option').html('').closest('#sub').show()
                    $.each(sub,function(i,a)
                    {
                        $('#sub .option').append(
                            "<span value='"+a.id+"'>"+a.size+"</span>"
                        )
                    })
                    data=data[0];
                }else{
                    $('#sub').hide()
                }
                $('#scan form').show(0)
                $('#scan form h6').html(data.type)
            }
        })
    }
    $(document).on('submit','#scan form',function(e)
    {
        e.preventDefault();
        ajaxHandler($(this)).done(function(data)
        {
            data=$.parseJSON(data)
            validationMessage(false,data.msg,data.type,data.err,'#scan .validation-message')
            if(data.err==null) setTimeout(function(){location.reload()},1500)
        })
    })
})
