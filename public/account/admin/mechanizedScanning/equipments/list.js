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
        $.post('/ajax/account/admin/mechanizedScanning/equipments/getData',{id:$(this).attr('data-id')},function(data)
        {
            data=$.parseJSON(data)[0]
            $("#edit input[name='data[title]']").val(data.title);
            $("#edit input[name='data[company]']").val(data.company);
            $("#edit input[name='data[propertyNumber]']").val(data.propertyNumber);
            $("#edit input[name='data[accessories]']").val(data.accessories);
            $("#edit input[name='data[count]']").val(data.count);
            $("#edit input[name='data[accessories]']").prop('checked',true).click()
            if(data.accessories=='1') $("#edit input[name='data[accessories]']").click()
            $("#edit input[name='data[status]'][value='"+data.status+"']").click()
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
        $.post('/ajax/account/admin/mechanizedScanning/equipments/getScannedData',{code:code},function(data)
        {
            data=$.parseJSON(data)
            if(data.data===null) validationMessage(2000,data.msg,data.type,data.err,'#scan .validation-message')
            else{
                data=$.parseJSON(data.data)
                $('#scan form').show(0)
                $('#scan form h6').html(data.title)
            }
        })
    }
    $(document).on('submit','#scan form',function(e)
    {
        e.preventDefault();
        ajaxHandler($(this),false).done(function(data)
        {
            ajaxT.html(data)
            return false;
            data=$.parseJSON(data)
            validationMessage(false,data.msg,data.type,data.err,'#scan .validation-message')
            if(data.err==null) setTimeout(function(){location.reload()},1500)
        })
    })
})