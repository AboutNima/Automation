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
            $("#edit input[name='data[propertyNumber]']").val(data.propertyNumber)
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
    $("a[href='#changeRate']").click(function(){
        $.post('/ajax/account/admin/consumingMaterials/getData',{id:$(this).attr('data-id')},function(data){
            data=$.parseJSON(data)[0];
            if(data.unit=='0'){
                data.unit='عدد'
            } else if(data.unit=='1'){
                data.unit='گرم'
            } else if(data.unit=='2'){
                data.unit='متر'
            }else if(data.unit=='3'){
                data.unit='لیتر'
            }
            $('#changeRate .information h6').html(
                "<span>"+data.title+"</span></br><span class='text-success'>موجودی فعلی: "+data.count+" "+data.unit+"</span>"
            )
            $('#count').attr('value', data.count)
            activePopup('#changeRate')
        })
    })
    $(document).on('submit','#changeRate form',function(e)
    {
        e.preventDefault();
        ajaxHandler($(this),false).done(function(data)
        {
            ajaxT.html(data)
            return false
            data=$.parseJSON(data)
            validationMessage(false,data.msg,data.type,data.err,'#delete .validation-message')
            if(data.err==null) setTimeout(function(){location.reload()},1500)
        })
    })
})