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
            $("#edit input[name='data[name]']").val(data.name);
            $("#edit input[name='data[brand]']").val(data.brand);
            $("#edit input[name='data[propertyNumber]']").val(data.propertyNumber);
            $("#edit input[name='data[accessories]']").val(data.accessories);
            $("#edit input[name='data[count]']").val(data.count);
            $("#edit input[name='data[status]']").val(data.status);
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
})