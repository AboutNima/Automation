function ajaxHandler(form,jsonErr=true){
    var action=form.attr('action')
    var method=form.attr('method')
    if(typeof action==typeof undefined || action==false || action=='')
    {
        alert('missing action request')
        return false
    }
    if(typeof method==typeof undefined || method==false || method=='')
    {
        alert('missing method request')
        return false;
    }

    var formData=new FormData(form.get(0));
    var formButton=form.find('button')

    formButton.append("<i class='far fa-spinner form-process'></i>")
    formButton.prop('disabled', true);

    return $.ajax({
        url: action,
        type: method,
        cache: false,
        processData: false,
        contentType: false,
        data: formData,
        dataType: 'text',
        success:function(data){
            formButton.prop('disabled',true)
            if(jsonErr)
            {
                data=$.parseJSON(data)
                if(data.err!==null) formButton.removeAttr('disabled')
            }else formButton.removeAttr('disabled')
            formButton.find('i.form-process').remove()
        }
    })
}