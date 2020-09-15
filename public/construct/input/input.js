function changeSelect(input,data)
{
    input=$(input).find('.input-select');
    if($.isArray(data))
    {
        var option=input.find('.option > div').removeClass('active')
        option.find('input').prop('checked',false)
        $.each(data,function(i,data){
            option.find("input[value='"+data+"']").prop('checked',true).parent().addClass('active')
        })
        input.find('> p').html(input.find('.option div.active').length+' مورد انتخاب شده')
    }else{
        input.find('> p').html(input.find('.option span[value='+data+']').clone().children().remove().end().text())
        input.find('.menu > input').val(input.find('.option span[value='+data+']').attr('value'))
    }
}
$(document).ready(function()
{
    $.fn.inputMask=function(a)
    {
        var this_=$(this)

        var maskType=this_.attr('mask-type')
        if(maskType==undefined) return false;

        var maskOption=[''];
        maskType=maskType.split(':')
        maskOption=maskType[1]==undefined || maskType[1]=='' ? [''] : maskType[1].split(',');
        maskType=maskType[0]
        this_.removeAttr('mask-type')
        var elmAttr=''
        function getAttr($node,except=''){
            elmAttr=''
            $.each($node[0].attributes,function(index,attribute){
                if(attribute.name==except) return false;
                elmAttr=elmAttr+' '+attribute.name+"='"+attribute.value+"'"
            });
        }
        function searchIN(input,targets,closest=''){
            var filter=input.val().trim()
            targets.each(function()
            {
                var this_=closest!='' ? $(this).closest(closest) : $(this)
                if($(this).text().search(new RegExp(filter,'i'))<0) this_.hide(); else this_.show();
            })
        }
        function randomText(){
            return Math.random().toString(36).substr(3).toLocaleUpperCase();
        }

        // Start input label
        if(this_.is('[mask-label]'))
        {
            var label=$(this).attr('mask-label');
            label=($(this).hasClass('required') ? '<i class="fas fa-star-of-life"></i>' : '')+label;
            $(this).prepend(
                ""+
                "<div class='input-label'>"+
                "   <p>"+label+"</p>"+
                "</div>"
            )
            $(this).removeAttr('mask-label')
        }

        // Start switch mask type
        switch(maskType)
        {
            case 'select':
                var select=this_.find('select')
                var option=select.find('option')
                var selected=false
                getAttr(select)

                this_.append(
                    "" +
                    "<div class='input-select'>"+
                    "   <i class='fal fa-chevron-down'></i>"+
                    "   <p> -- هیچ موردی انتخاب نشده -- </p>"+
                    "   <div class='menu'>"+
                    ($.inArray('search',maskOption)!==-1 ? "<div class='search'><input type='text' placeholder='جست و جو ...'></div>" : "")+
                    "       <div class='option'></div>"+($.inArray('multi',maskOption)===-1 ? "<input type='text'"+elmAttr+">" : "")+
                    "   </div>" +
                    "</div>"
                )

                if(option.length>0)
                {
                    option.each(function()
                    {
                        if($(this).attr('selected')!=undefined)
                        {
                            if($.inArray('multi',maskOption)===-1)
                            {
                                selected=$(this).attr('value');
                            }else{
                                if(selected==false) selected=[];
                                selected.push($(this))
                            }
                        }
                        var string=$.inArray('multi',maskOption)!==-1 ?
                            "<div>"+
                            ($(this).attr('toolbar')!==undefined ? "<p class='toolbar'>"+$(this).attr('toolbar')+"</p>" : "")+
                            "<p>"+$(this).html()+"</p>"+
                            "<span></span>"+
                            "<input type='checkbox' value='"+$(this).val()+"' "+elmAttr+">"+
                            "</div>" :
                            "<span value='"+$(this).val()+"'>"+
                            ($(this).attr('toolbar')!==undefined ? "<p class='toolbar'>"+$(this).attr('toolbar')+"</p>" : "")+
                            $(this).html()+
                            "</span>"
                        this_.find('.menu .option').append(string)
                    })
                }else{
                    this_.find('.menu .option').append("<p> -- موردی برای نمایش وجود ندارد -- </p>")
                }
                select.remove();
                select=this_.find('.input-select')

                if($.inArray('multi',maskOption)===-1)
                {
                    this_.find('.search input').on('keyup',function(){searchIN($(this),this_.find('.menu .option span'))})
                    this_.click(function(){
                        select.toggleClass('active')
                    }).on('click','.menu',function(e){
                        e.stopPropagation()
                    })
                    select.on('click','.menu .option span',function(){
                        select.find('> p').html($(this).clone().children().remove().end().text())
                        select.find('.menu > input').val($(this).attr('value'))
                        $(this).closest('.input-select').removeClass('active')
                    })
                }else{
                    this_.find('.search input').on('keyup',function(){searchIN($(this),this_.find('.menu .option div p'),'div')})
                    this_.click(function(){
                        select.addClass('active')
                    })
                    option=select.find('.menu .option div')
                    select.on('click','.menu .option div',function(){
                        var input=$(this).find('input')
                        if(input.is(':checked'))
                        {
                            input.prop('checked',false)
                            $(this).removeClass('active')
                        }else{
                            input.prop('checked',true)
                            $(this).addClass('active')
                        };
                        var ln=option.find('input:checked').siblings('p:not(.toolbar)').length
                        select.find('> p').html(
                            ln > 0 ? ln+" مورد انتخاب شده " : '-- هیچ موردی انتخاب نشده --'
                        )
                    })
                }

                $('body,html').click(function(e){
                    if(!select.is(e.target) && select.has(e.target).length===0) select.removeClass('active');
                })

                if(selected!==false)
                {
                    if($.inArray('multi',maskOption)===-1) changeSelect(select,selected);else{
                        for(var i=0;i<selected.length;i++)
                        {
                            var thisSelected=selected[i]
                            this_.find(".menu div input[value='"+thisSelected.val()+"']").prop('checked',true).closest('div').addClass('active');
                        }
                        select.find('> p').html(selected.length+' مورد انتخاب شده')
                    }
                }
                break;
            case 'radio':
                var input=this_.find('input[type=radio]')
                input.remove()

                this_.append("<div class='radio'></div>")
                var radio=this_.find('.radio')

                input.each(function(){
                    var label=$(this).attr('label')
                    var id=randomText()
                    var checked=$(this).attr('checked') ? 'active' : ''
                    if(label==undefined || label=='') label='عنوان برچسب'
                    getAttr($(this))
                    radio.append(
                        "<div class='item "+checked+"'>"+
                        "    <label for='"+id+"'>"+
                        "<span></span>"+
                        "<p>"+label+"</p>"+
                        "    </label>"+
                        "    <input type='radio'"+elmAttr+" id='"+id+"'>"+
                        "</div>"
                    )
                })
                input=this_.find('input[type=radio]')

                input.on('change',function()
                {
                    $("input[name='"+$(this).attr('name')+"']").prop('checked',false).closest('.item').removeClass('active')
                    $(this).prop('checked',true).closest('.item').addClass('active')
                })

                break;
            case 'checkbox':
                var input=this_.find('input[type=checkbox]')
                input.remove()

                this_.append("<div class='checkbox'></div>")
                var checkbox=this_.find('.checkbox')

                input.each(function(){
                    var label=$(this).attr('label')
                    var id=randomText()
                    var checked=$(this).attr('checked') ? 'active' : ''
                    if(label==undefined || label=='') label='عنوان برچسب'
                    getAttr($(this))
                    checkbox.append(
                        "<div class='item "+checked+"'>"+
                        "    <label for='"+id+"'>"+
                        "<span></span>"+
                        "<p>"+label+"</p>"+
                        "    </label>"+
                        "    <input type='checkbox'"+elmAttr+" id='"+id+"'>"+
                        "</div>"
                    )
                })
                input=this_.find('input[type=checkbox]')

                input.on('change',function(){
                    if($(this).is(':checked'))
                    {
                        $(this).prop('checked',true).closest('.item').addClass('active')
                    }else{
                        $(this).prop('checked',false).closest('.item').removeClass('active')
                    }
                })

                break;
            case 'currency':
                this_.find('input[type=text]').on('keyup',function(){
                    $(this).val(Number($(this).val().split(',').join('')).toLocaleString())
                })
                break;
            case 'tag':
                this_.append("<div class='tag'><ul></ul></div>")
                var tagList=this_.find('.tag ul')
                var input=this_.find('input[type=text]')
                getAttr(input,'value')
                if(input.val()!='')
                {
                    var a=input.val().split('  ')
                    input.removeAttr('value')
                    for(var i=0;i<a.length;i++)
                    {
                        tagList.append(
                            "<li>" +
                            "   <span class='label label-default'>"+a[i]+"</span>" +
                            "   <input type='text'"+elmAttr+" value='"+a[i]+"'>"+
                            "</li>"
                        )
                    }
                }
                input.removeAttr('name')
                input.on('keyup',function()
                {
                    var a=input.val()
                    var check=a.substr(a.length-2,a.length)
                    if(check=='  ' && a.trim()!='')
                    {
                        tagList.append(
                            "<li>" +
                            "   <span class='label label-default'>"+a.trim()+"</span>" +
                            "   <input type='text' "+elmAttr+" value='"+a.trim()+"' >"+
                            "</li>"
                        )
                        input.val('')
                    }
                })
                tagList.on('click','li',function()
                {
                    $(this).remove();
                })
                break;
            case 'upload':
                var input=this_.find('input[type=file]');
                var multiple=input.attr('multiple')===undefined ? false : true;
                var nameAttr=input.attr('name')
                input.removeAttr('name')
                var selectedFile=null;
                this_.append(
                    "<div class='upload'>"+
                    "    <div class='drop-zone'>"+
                    "        <div class='body'>"+
                    "            <i class='fal fa-cloud-upload'></i>"+
                    "            <p> پیوست را اینجا رها کنید و یا کلیک کنید </p>"+
                    "            <div class='info'>"+
                    "                <p><span>"+maskOption[0]+"</span> :حداکثر حجم فایل </p>"+
                    "                <p><span>"+maskOption[1]+"</span> :فرمت های مجاز </p>"+
                    "            </div>"+
                    "        </div>"+
                    "    </div>"+
                    "    <div class='list'>"+
                    "        <ul></ul>"+
                    "    </div>"+
                    "</div>"
                );
                input.appendTo(this_.find('.upload'))
                var dropZone=this_.find('.drop-zone')
                var filesList=this_.find('.list ul')

                var draggingStatus=0
                $(dropZone).on({
                    dragenter:function(e){
                        e.preventDefault();
                        e.stopPropagation();
                        $(this).parent().addClass('active')
                        draggingStatus++
                    },
                    dragleave:function(){
                        draggingStatus--
                        if(draggingStatus==0) $(this).parent().removeClass('active')
                    },
                    dragover:function(e){
                        e.preventDefault()
                    },
                    drop:function(e){
                        e.preventDefault();
                        e.stopPropagation();
                        $(this).parent().removeClass('active')
                        draggingStatus--
                        addFile(e.originalEvent.dataTransfer.files);
                    },
                    click:function()
                    {
                        input.click()
                    }
                })
                input.on('change',function(){if(input.val()!='') addFile(input[0].files)})
            function addFile(selectedFile)
            {
                var name=selectedFile[0].name
                var size=selectedFile[0].size
                if(multiple===false && selectedFile.length>1) return false;
                if(selectedFile.length>1)
                {
                    for(i=1;i<selectedFile.length;i++)
                    {
                        name+=','+selectedFile[i].name
                        size+=selectedFile[i].size
                    }
                }
                var content="<li><div><p>"+name+"</p></div><div><i class='far fa-times discard'></i><span>"+(size/1024/1024).toFixed(3)+"MB</span></div><input type='file' name='"+nameAttr+"'></li>"
                if(multiple) filesList.append(content)
                else filesList.html(content)
                filesList.find("li:last-child input[type='file']").prop('files',selectedFile)
                filesList.parent().addClass('active')
            }
                filesList.on('click','li .discard',function()
                {
                    $(this).closest('li').remove()
                    if(filesList.find('li').length==0) filesList.parent().removeClass('active')
                })
                break;
        }
    }

    $('.input-mask').each(function(){
        $(this).inputMask();
    })
})