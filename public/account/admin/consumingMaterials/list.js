$(document).ready(function()
{
    $(document).on('submit','#add form',function(e)
    {
        e.preventDefault();
        ajaxHandler($(this)).done(function(data)
        {
            data=$.parseJSON(data)
            validationMessage(false,data.msg,data.type,data.err,'#add .validation-message')
            if(data.err==null) setTimeout(function(){
                location.reload()
            },1500)
        })
    })

    $("a[href='#edit']").click(function(){
        $.post('/ajax/account/admin/consumingMaterials/getData',{id:$(this).attr('data-id')},function(data){
            data=$.parseJSON(data)[0];
            changeSelect('#edit',$.parseJSON(data.unit))
            $("#edit input[name='data[title]']").val(data.title)
            $("#edit input[name='data[company]']").val(data.company)
            $("#edit input[name='data[count]']").val(data.count)
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

    $("a[href='#delete']").click(function(){
        $('#del').attr('value', $(this).attr('data-id'))
        activePopup('#delete')
    })
    $(document).on('submit','#delete form',function(e)
    {
        e.preventDefault();
        ajaxHandler($(this)).done(function(data)
        {
            data=$.parseJSON(data)
            validationMessage(false,data.msg,data.type,data.err,'#delete .validation-message')
            if(data.err==null) setTimeout(function(){location.reload()},1500)
        })
    })
})