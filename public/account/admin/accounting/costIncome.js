$(document).ready(function()
{
    $(document).on('submit','#add form.ajax-handler',function(e)
    {
        e.preventDefault();
        ajaxHandler($(this)).done(function(data)
        {
            data=$.parseJSON(data)
            validationMessage(false,data.msg,data.type,data.err,'#add .validation-message')
            if(data.err==null) setTimeout(function(){location.reload()},1500)
        })
    })
    $("a[href='#edit']").on('click',function()
    {
        $.post('/ajax/account/admin/accounting/costIncome/getData',{id:$(this).attr('data-id')},function(data)
        {
            data=$.parseJSON(data)[0]
            $("#edit input[name='data[subject]']").val(data.subject);
            changeSelect('#edit',data.titleId)
            $("#edit input[name='data[price]']").val((data.price).toLocaleString());
            $("#edit textarea").val(data.description);
            $("#edit input[name='data[income]'][value='0']").click()
            if(data.income=='1') $("#edit input[name='data[income]'][value='1']").click()
            activePopup('#edit')
        })
    })
    $(document).on('submit','#edit form.ajax-handler',function(e)
    {
        e.preventDefault();
        ajaxHandler($(this)).done(function(data)
        {
            data=$.parseJSON(data)
            validationMessage(false,data.msg,data.type,data.err,'#edit .validation-message')
            if(data.err==null) setTimeout(function(){location.reload()},1500)
        })
    })
    $("a[href='#remove']").on('dblclick',function()
    {
        $.post('/ajax/account/admin/accounting/costIncome/remove',{id:$(this).attr('data-id')},function(data)
        {
            data=$.parseJSON(data)
            validationMessage(false,data.msg,data.type,data.err,'.validation-message')
            if(data.err==null) setTimeout(function(){location.reload()},1500)
        })
    })
})