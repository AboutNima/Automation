$(document).ready(function(){
    $(document).on('submit','#add form',function(e){
        e.preventDefault();
        ajaxHandler($(this),false).done(function(data){
            ajaxT.html(data)
            return false
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
            changeSelect('#edit .education',$.parseJSON(data.education))
            $("#edit input[name='data[name]']").val(data.name);
            $("#edit input[name='data[surname]']").val(data.surname);
            $("#edit input[name='data[name(en)]']").val(data.name(en));
            $("#edit input[name='data[surname(en)]']").val(data.surname(en));
            $("#edit input[name='data[fatherName]']").val(data.fatherName);
            $("#edit input[name='data[nationalCode]']").val(data.nationalCode);
            $("#edit input[name='data[birthCNumber]']").val(data.birthCNumber);
            $("#edit input[name='data[phoneNumber]']").val(data.phoneNumber);
            $("#edit input[name='data[homeNumber]']").val(data.homeNumber);
            $("#edit input[name='data[birthDay]']").val(data.birthDay);
            $("#edit input[name='data[address]']").val(data.address);
            $("#edit input[name='data[job]']").val(data.job);
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
    })
})