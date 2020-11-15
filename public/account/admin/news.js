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
    $("a[href='#edit']").click(function(){
        $.post('/ajax/account/admin/news/getData',{id:$(this).attr('data-id')},function(data){
            data=$.parseJSON(data)[0];
            $("#edit input[name='data[title]']").val(data.title)
            $("#edit input[name='data[demo]']").val(data.demo)
            $("#edit input[name='data[link]']").val(data.link)
            $("#edit input[name='data[keywords]']").val($.parseJSON(data.keywords)[0])
            $("#edit input[name='data[archiveDate]']").val(data.archiveDate)
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
    $("input.date-picker").pDatepicker({
        minDate: new persianDate().valueOf(),
        format: 'YYYY/MM/DD',
        autoClose: true,
        toolbox:{
            enabled: false
        }
    });
    CKEDITOR.replace('description');
    $('input[name="data[title]"]').keyup(function(){
        $('input[name="data[link]"]').val($(this).val().split(' ').join('-'))
    });
})