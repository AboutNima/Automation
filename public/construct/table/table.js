$(document).ready(function()
{
    $('.table-mask').each(function()
    {
        var table=$(this)
        rows=table.attr('page-rows')
        if(rows==undefined || rows==false || rows=='')
        {
            table.attr('page-rows',5)
            rows=5
        }
        table.prepend(
            "<div class='table-header'>\n"+
            "   <div class='page-search'>" +
            "       <input type='text' placeholder='جست و جو ...'>"+
            "   </div>"+
            "   <div class='page-rows'>\n"+
            "       <select>\n"+
            "           <option value='-1'> نمایش همه </option>\n"+
            "       </select>\n"+
            "   </div>\n"+
            "</div>"
        )
        table.append(
            "<div class='table-footer'></div>"
        )
        var showInPage=[5,10,15,25,50]
        if(jQuery.inArray(parseInt(rows),showInPage)===-1){showInPage.push(rows)}
        showInPage.sort(function(a,b){return b-a})
        $(showInPage).each(function(e,a)
        {
            var selected=a==rows ? 'selected ' : '';
            table.find('.table-header .page-rows select').prepend(
                "<option "+selected+"value='"+a+"'>"+a+"</option>"
            )
        })
        if(rows==-1){
            table.find('.table-header .page-rows select option[value=-1]').prop('selected',true)
            table.find('.table-header .page-rows select option:first-child').remove()
        }
        pageSwitcher(table)
    })
    $(document).on('change','.table-mask .table-header .page-rows select',function()
    {
        var table=$(this).closest('.table-mask');
        table.attr('page-rows',$(this).val())
        pageSwitcher(table)
    })
    function pageSwitcher(table)
    {
        rows=table.attr('page-rows')
        var tr=table.find('tbody tr:not([search-hidden])');
        table.find('.page-switcher').remove()
        if(rows!=-1 && tr.length>rows)
        {
            tr.hide(0)
            table.find('.table-footer').append(
                "<div class='page-switcher'></div>"
            )
            var pageSwitcher=table.find('.page-switcher')
            var page=Math.ceil(tr.length/rows)
            for(i=1;i<=page;i++)
            {
                var active=''
                if(i==1)
                {
                    for(a=0;a<=1*rows-1;a++)
                    {
                        $(tr[a]).show()
                    }
                    active="class='active'"
                }
                pageSwitcher.append(
                    "<span "+active+" style='display: none' page-id='"+i+"'>"+i+"</span>"
                )
            }
            for(i=0;i<=5;i++)
            {
                $(pageSwitcher.find('span')[i]).show(0)
            }
            if(pageSwitcher.find('span').length>5)
            {
                if(pageSwitcher.find('span.active').nextAll().length>=4)
                {
                    $('<i class="fal fa-ellipsis-h" disabled></i>').insertBefore(pageSwitcher.find('span:last-child'))
                }
            }
            pageSwitcher.find('span:last-child').show(0)
        }else{
            tr.show(0)
        }
    }
    $(document).on('click','.table-mask .table-footer .page-switcher span',function()
    {
        var scrollTop=$(window).scrollTop();

        var table=$(this).closest('.table-mask')

        var pageSwitcher=$(this).parent()
        pageSwitcher.find('span.active').removeClass('active')
        $(this).addClass('active')

        rows=table.attr('page-rows')
        rows=typeof rows==typeof undefined || rows==false || rows=='' ? 10 : rows
        var tr=table.find('table tbody tr:not([search-hidden])')
        var pageId=$(this).attr('page-id')
        tr.hide(0)
        for(i=rows*pageId-rows;i<=rows*pageId-1;i++)
        {
            $(tr[i]).show(0)
        }
        pageSwitcher.find('span').hide(0)
        var c=b=2
        var n=pageSwitcher.children('span').index($(this))
        var m=pageSwitcher.find('span').length-1
        if(n==0){b=5;c=0}
        else if(n<=1){b=4;c=0}
        else if(n==2){b=3;c=1}
        else if(n==m){b=0;c=5}
        else if(n>=m-1){b=0;c=4}
        else if(n==m-2){b=1;c=3}
        for(i=0;i<=b;i++)
        {
            $(pageSwitcher.find('span')[n+i]).show()
        }
        for(i=0;i<=c;i++)
        {
            $(pageSwitcher.find('span')[n-i]).show()
        }
        pageSwitcher.find('i').remove()
        if(m>5)
        {
            if($(this).prevAll().length>=4)
            {
                $('<i class="fal fa-ellipsis-h" disabled></i>').insertAfter(pageSwitcher.find('span:first-child'))
            }
            if($(this).nextAll().length>=4)
            {
                $('<i class="fal fa-ellipsis-h" disabled></i>').insertBefore(pageSwitcher.find('span:last-child'))
            }
        }
        pageSwitcher.find('span:first-child,span:last-child').show()

        $(window).scrollTop(scrollTop)

    })
    $(document).on('keyup','.table-mask .table-header .page-search input',function()
    {
        var value=$(this).val();
        var table=$(this).closest('.table-mask')
        $.each(table.find('table tbody tr'),function()
        {
            var rowText=$(this).children().clone().children().remove().end().text().toLowerCase()
            if(rowText.indexOf(value.toLowerCase())===-1)
            {
                $(this).attr('search-hidden','');
                $(this).hide()
            }else{
                $(this).removeAttr('search-hidden')
                $(this).show();
            }
        });
        pageSwitcher(table)
    })
    $(document).on('click','.table-mask.table-sort table thead th',function()
    {
        var table=$(this).closest('table');
        var td=[];
        var sortAsc=$(this).attr('sort');
        table.find('thead th').not($(this)).removeAttr('sort')
        if(typeof sortAsc==typeof undefined || sortAsc==false || sortAsc=='')
        {
            $(this).attr('sort','DESC')
            sortAsc=true;
        }else{
            if(sortAsc=='ASC')
            {
                sortAsc=true;
                $(this).attr('sort','DESC')
            }else{
                sortAsc=false;
                $(this).attr('sort','ASC')
            }
        }
        $(table.find('tbody tr td:nth-child('+($(this).index()+1)+')')).each(function()
        {
            td.push({
                key: $(this).parent().index(),
                elm: $(this)
            })
        })
        if(sortAsc)
        {
            td.sort(function(a,b)
            {
                if(a.elm.text()<b.elm.text()) return -1;
                if(a.elm.text()>b.elm.text()) return 1;
                return 0;
            })
        }else{
            td.sort(function(a,b)
            {
                if(a.elm.text()<b.elm.text()) return 1;
                if(a.elm.text()>b.elm.text()) return -1;
                return 0;
            })
        }
        $(td).each(function(key,obj){
            table.find('tbody tr').eq(key).after(obj.elm.parent())
        })
        pageSwitcher(table.closest('.table-mask'))
    })
})