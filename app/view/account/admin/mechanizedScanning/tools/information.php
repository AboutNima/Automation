<div class="row">
    <div class="col-lg-3 col-sm-6">
        <div class="block">
            <div class="body">
                <p class="fsize-15 fisb"> شماره اموال </p>
                <?php
                if(!empty($data->propertyNumber)):
                ?>
                    <p class="fsize-15 fism mt-0 text-success"><?php echo sprintf("%04d",$data->propertyNumber) ?></p>
                <?php
                else:
                ?>
                    <p class="fsize-15 fism mt-0 text-danger"> ثبت نشده </p>
                <?php
                endif;
                ?>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6">
        <div class="block">
            <div class="body">
                <p class="fsize-15 fisb"> شرکت سازنده </p>
                <p class="fsize-15 fism mt-0 text-primary"><?php echo $data->company ?></p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6">
        <div class="block">
            <div class="body">
                <p class="fsize-15 fisb"> موجودی کل </p>
                <p class="fsize-15 fism mt-0 text-primary"><?php echo $data->count ?></p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6">
        <div class="block">
            <div class="body">
                <p class="fsize-15 fisb"> موجودی فعلی </p>
                <p class="fsize-15 fism mt-0 text-danger"><?php echo 0 ?></p>
            </div>
        </div>
    </div>
    <?php
    if(!empty($data->description)):
    ?>
    <div class="col-12">
        <div class="block">
            <div class="body">
                <?php echo $data->description ?>
            </div>
        </div>
    </div>
    <?php
    endif;
    ?>
</div>
<div class="block">
    <div class="header">
        <div class="title">
            <h6> مدیریت ابزار <?php echo $data->type ?> </h6>
            <p> در این قسمت میتوانید ابزار های زیر مجموعه را مدیریت کنید و یا ابزار زیر مجموعه جدید ایجاد کنید </p>
        </div>
        <div class="more float-left">
            <div class="item">
                <i class="fal fa-ellipsis-h"></i>
            </div>
            <div class="menu">
                <a href="#add" class="popup-active" popup-target="#add"><span><i class="fas fa-layer-plus"></i> ثبت ابزار جدید </span></a>
            </div>
        </div>
    </div>
    <div class="body">
        <div class="table-mask">
            <table>
                <thead>
                <tr>
                    <th> ردیف </th>
                    <th> موجودی کل </th>
                    <th> موجودی فعلی </th>
                    <th> توضیحات </th>
                    <th> اندازه </th>
                    <th> گزینه ها </th>
                </tr>
                </thead>
                <tbody>
				<?php
				if(!empty($sub)):
					$num=1;
					foreach($sub as $item):
						?>
                        <tr>
                            <td><?php echo $num++ ?></td>
                            <td><?php echo $item->count ?></td>
                            <td>0</td>
                            <td>
								<?php
								if(empty($item->description)):
									?>
                                    <span class="label label-danger"> ثبت نشده </span>
								<?php
								else: echo $item->description; endif;
								?>
                            </td>
                            <td><?php echo $item->size ?></td>
                            <td>
                                <div class="more">
                                    <div class="item">
                                        <i class="fal fa-ellipsis-h"></i>
                                    </div>
                                    <div class="menu">
                                        <a href="#edit" data-id="<?php echo $item->id ?>"><span><i class="far fa-file-edit"></i> ویرایش </span></a>
                                    </div>
                                </div>
                            </td>
                        </tr>
					<?php
					endforeach;
				else:
					?>
                    <tr>
                        <td colspan="6" class="no-data"> موردی برای نمایش وجود ندارد! </td>
                    </tr>
				<?php
				endif;
				?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="popup" popup-size="md" popup-title="ثبت ابزار جدید" id="add">
	<div class="validation-message no-margin top"></div>
	<form action="/ajax/account/admin/mechanizedScanning/tools/addSub" class="ajax-handler" method="post">
		<input type="text" name="Token" value="<?php echo $_SESSION['Token'] ?>" hidden>
		<div class="row">
			<div class="col-sm-6">
				<div class="input-mask required" mask-type mask-label="سایز">
					<input type="text" name="data[size]" placeholder="سایز را اینجا وارد کنید" autocomplete="off">
				</div>
			</div>
            <div class="col-sm-6">
                <div class="input-mask required" mask-type mask-label="موجودی">
                    <input type="number" name="data[count]" placeholder="موجودی را اینجا وارد کنید" autocomplete="off">
                </div>
            </div>
            <div class="col-12">
                <div class="input-mask" mask-type mask-label="توضیحات">
                    <textarea name="data[description]" rows="3"></textarea>
                </div>
            </div>
        </div>
		<div class="clearFix">
			<div class="hr"></div>
			<div class="input-mask no-mask-margin">
				<button class="btn btn-purple float-left"> ثبت ابزار جدید </button>
			</div>
		</div>
	</form>
</div>
<div class="popup" popup-size="md" popup-title="ویرایش ابزار" id="edit">
	<div class="validation-message no-margin top"></div>
	<form action="/ajax/account/admin/mechanizedScanning/tools/editSub" class="ajax-handler" method="post">
		<input type="text" name="Token" value="<?php echo $_SESSION['Token'] ?>" hidden>
		<div class="row">
			<div class="col-sm-6">
				<div class="input-mask required" mask-type mask-label="سایز">
					<input type="text" name="data[size]" placeholder="سایز را اینجا وارد کنید" autocomplete="off">
				</div>
			</div>
            <div class="col-sm-6">
                <div class="input-mask required" mask-type mask-label="موجودی">
                    <input type="number" name="data[count]" placeholder="موجودی را اینجا وارد کنید" autocomplete="off">
                </div>
            </div>
            <div class="col-12">
                <div class="input-mask" mask-type mask-label="توضیحات">
                    <textarea name="data[description]" rows="3"></textarea>
                </div>
            </div>
        </div>
		<div class="clearFix">
			<div class="hr"></div>
			<div class="input-mask no-mask-margin">
				<button class="btn btn-purple float-left"> ویرایش ابزار </button>
			</div>
		</div>
	</form>
</div>