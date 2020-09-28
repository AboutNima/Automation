$(document).ready(function()
{
    $(document).on('submit','form.ajax-handler',function(e)
    {
        e.preventDefault();
        ajaxHandler($(this)).done(function(data)
        {
            data=$.parseJSON(data)
            validationMessage(false,data.msg,data.type,data.err,'#add .validation-message')
            if(data.err==null) setTimeout(function(){location.reload()},1500)
        })
    })
    $("a[href='#resetPassword']").on('dblclick',function()
    {
        $.post('/ajax/account/admin/manageAdmins/resetPassword',{id:$(this).attr('data-id')},function(data)
        {
            data=$.parseJSON(data)
            validationMessage(false,data.msg,data.type,data.err)
            if(data.err==null) setTimeout(function(){location.reload()},1500)
        })
    })
})