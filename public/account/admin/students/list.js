$(document).ready(function(){
    $(document).on('submit','#add form',function(e){
        e.preventDefault();
        ajaxHandler($(this)).done(function(data){
            data=$.parseJSON(data)
            validationMessage(false,data.msg,data.type,data.err,'#add .validation-message')
            if(data.err==null) setTimeout(function(){
                location.reload()
            },1500)
        })
    })
    $("a[href='#edit']").click(function(){
        $.post('/ajax/account/admin/students/getData',{id:$(this).attr('data-id')},function(data){
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
    $(document).on('submit','#edit form',function(e){
        e.preventDefault();
        ajaxHandler($(this)).done(function(data){
            data=$.parseJSON(data)
            validationMessage(false,data.msg,data.type,data.err,'#edit .validation-message')
            if(data.err==null) setTimeout(function(){
                location.reload()
            },1500)
        })
    })}