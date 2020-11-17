<div class="block">
    <div class="header">
        <div class="title">
            <h6> مجوزات ثبت شده </h6>
            <p> در این قسمت میتوانید مجوزات ثبت شده خود را مدیریت کنید و یا مجوز جدید ایجاد کنید </p>
        </div>
        <div class="more float-left">
            <div class="item">
                <i class="fal fa-ellipsis-h"></i>
            </div>
            <div class="menu">
                <a href="#add" class="popup-active" popup-target="#add"><span><i class="far fa-plus-circle"></i> ایجاد مجوز </span></a>
            </div>
        </div>
    </div>
    <div class="body">
        <div class="table-mask">
            <table>
                <thead>
                <tr>
                    <th>#</th>
                    <th> عنوان </th>
                    <th> تاریخ ایجاد </th>
                    <th> گزینه ها </th>
                </tr>
                </thead>
                <tbody>
				<?php
                if(!empty($data)):
                    $num=1;
                    foreach($data as $item):
                ?>
                    <tr>
                        <td><?php echo $num++ ?></td>
                        <td><?php echo $item->title ?></td>
                        <td><span class="label label-default"><?php echo $calendar->date("j F Y ساعت H:i",$item->createdAt) ?></span></td>
                        <td>
                            <div class="d-inline-block">
                                <div class="more float-left">
                                    <div class="item">
                                        <i class="fal fa-ellipsis-h"></i>
                                    </div>
                                    <div class="menu">
                                        <a href="#edit" data-id="<?php echo $item->id ?>"><span><i class="far fa-edit"></i> ویرایش </span></a>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php
					endforeach;
                else:
                ?>
                <tr>
                    <td colspan="4"> موردی برای نمایش وجود ندارد! </td>
                </tr>
				<?php
				endif
				?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="popup" popup-size="md" popup-title="ایجاد مجوز" id="add">
    <div class="validation-message no-margin top"></div>
    <form action="/ajax/account/admin/certificates/add" class="ajax-handler" method="post">
        <input type="text" name="Token" value="<?php echo $_SESSION['Token'] ?>" hidden>
        <div class="input-mask required" mask-type="" mask-label="عنوان">
            <input type="text" name="data[title]" placeholder="عنوان مجوز را اینجا وارد کنید" autocomplete="off">
        </div>
        <div class="input-mask required" mask-type="" mask-label="توضیحات (حداکثر 175 حرف)">
            <textarea name="data[description]" rows="3"></textarea>
        </div>
        <div class="input-mask required" mask-type="upload:0.25MB,jpeg-jpg-tiff" mask-label="عکس مجوز">
            <input type="file" name="photo">
        </div>
        <div class="clearFix">
            <div class="hr"></div>
            <div class="input-mask no-mask-margin">
                <button class="btn btn-purple float-left"> ایجاد </button>
            </div>
        </div>
    </form>
</div>
<div class="popup" popup-size="md" popup-title="ویرایش مجوز" id="edit">
    <div class="validation-message no-margin top"></div>
    <form action="/ajax/account/admin/certificates/edit" class="ajax-handler" method="post">
        <input type="text" name="Token" value="<?php echo $_SESSION['Token'] ?>" hidden>
        <div class="input-mask required" mask-type="" mask-label="عنوان">
            <input type="text" name="data[title]" placeholder="عنوان مجوز را اینجا وارد کنید" autocomplete="off">
        </div>
        <div class="input-mask required" mask-type="" mask-label="توضیحات (حداکثر 175 حرف)">
            <textarea name="data[description]" rows="3"></textarea>
        </div>
        <div class="input-mask" mask-type="upload:0.25MB,jpeg-jpg-tiff" mask-label="عکس مجوز">
            <input type="file" name="photo">
        </div>
        <p class="text-danger fsize-13 mt-0 fism"> * برای تغییر عکس مجوز، عکس جدید را انتخاب کنید </p>
        <div class="clearFix">
            <div class="hr"></div>
            <div class="input-mask no-mask-margin">
                <button class="btn btn-purple float-left"> ویرایش </button>
            </div>
        </div>
    </form>
</div>
