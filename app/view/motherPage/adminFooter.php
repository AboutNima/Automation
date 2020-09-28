

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