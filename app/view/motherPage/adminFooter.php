

	</div>
</div>
<script>
    less={
        env:'development'
    }
</script>
<script src="/public/construct/less.min.js"></script>
<script src="/public/construct/jquery.min.js"></script>
<script src="/public/construct/jalaliDate.js"></script>
<script src="/public/construct/datepicker/datepicker.min.js"></script>
<script src="/public/construct/ckeditor/ckeditor.js"></script>
<script>
    var ajaxT=$('#ajax')
</script>
<script src="/public/construct/balloon/balloon.js"></script>
<script src="/public/construct/input/ajax-handler.js"></script>
<script src="/public/construct/popup/popup.js"></script>
<script src="/public/construct/input/input.js"></script>
<script src="/public/construct/validationMessage/validation.js"></script>
<script src="/public/construct/table/table.js"></script>
<script src="/public/account/panel/script.js"></script>
<script src="/public/account/panel/chatroom.js"></script>
<?php
if(@$tableExport):
?>
    <script type="text/javascript" src="/public/construct/table2excel.js"></script>
    <script>
        $(document).ready(function()
        {
            $(document).on('click','.exportTable',function()
            {
                var this_=$(this)
                var target=this_.attr('e-target')
                var fileName=this_.attr('e-filename')
                if(typeof fileName==typeof undefined || fileName==false || fileName==''){alert('missing file name');return false;}
                if(typeof target==typeof undefined || target==false || target==''){alert('missing target');return false;}
                table2excel(target,fileName)
            })
            function table2excel(target,fileName,preserveColors=true,img=false,link=true,inputs=true)
            {
                var options={
                    exclude: '.noExl',
                    filename: fileName,
                    exclude_img: img,
                    exclude_links: link,
                    exclude_inputs: inputs,
                    preserveColors: preserveColors
                }
                $(target).table2excel(options);
            }
        })
    </script>
<?php
endif;
if(isset($script))
{
	if(!is_array($script)) $script=[$script];
    foreach($script as $script)
    {
        echo "<script type='text/javascript' src='{$script}.js'></script>";
    }
}
?>
</body>
</html>