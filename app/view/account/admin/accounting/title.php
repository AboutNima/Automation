<div class="block">
    <div class="header">
        <div class="title">
            <h6> سرفصل های حسابداری ایجاد شده </h6>
            <p> در این قسمت میتوانید سرفصل های حسابداری ایجاد کنید و یا آن ها را مدیریت کنید </p>
        </div>
        <div class="more float-left">
            <div class="item">
                <i class="fal fa-ellipsis-h"></i>
            </div>
            <div class="menu">
                <a href="#add" class="popup-active" popup-target="#add"><span><i class="fas fa-list"></i> ایجاد سرفصل </span></a>
                <a href="#add"><span><i class="fas fa-file-excel"></i> خروجی اکسل </span></a>
            </div>
        </div>
    </div>
    <div class="body">
        <div class="table-mask">
            <table>
                <thead>
                <tr>
                    <th> ردیف </th>
                    <th> عنوان </th>
                    <th> تاریخ ثبت </th>
                    <th> آخرین ویرایش </th>
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
                            <td><?php echo $item->title; ?></td>
                            <td> <?php echo $calendar->date("j F Y ساعت H:i",$item->createdAt); ?></td>
                            <td> <?php echo $calendar->date("j F Y ساعت H:i",$item->updatedAt); ?></td>
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
                        <td colspan="5" class="no-data"> موردی برای نمایش وجود ندارد! </td>
                    </tr>
				<?php
				endif;
				?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="popup" popup-size="sm" popup-title="ایجاد سرفصل جدید" id="add">
    <div class="validation-message no-margin top"></div>
    <form action="/ajax/account/admin/accounting/title/add" class="ajax-handler" method="post">
        <input type="text" name="Token" value="<?php echo $_SESSION['Token'] ?>" hidden>
        <div class="input-mask required" mask-type mask-label="عنوان">
            <input type="text" name="data[title]" placeholder="عنوان سرفصل را وارد کنید" autocomplete="off">
        </div>
        <div class="clearFix">
            <div class="hr"></div>
            <div class="input-mask no-mask-margin">
                <button class="btn btn-purple float-left"> ایجاد سرفصل </button>
            </div>
        </div>
    </form>
</div>
<div class="popup" popup-size="sm" popup-title="ویرایش سرفصل" id="edit">
    <div class="validation-message no-margin top"></div>
    <form action="/ajax/account/admin/accounting/title/edit" class="ajax-handler" method="post">
        <input type="text" name="Token" value="<?php echo $_SESSION['Token'] ?>" hidden>
        <div class="input-mask required" mask-type mask-label="عنوان">
            <input type="text" name="data[title]" placeholder="عنوان سرفصل را وارد کنید" autocomplete="off">
        </div>
        <div class="clearFix">
            <div class="hr"></div>
            <div class="input-mask no-mask-margin">
                <button class="btn btn-purple float-left"> ویرایش سرفصل </button>
            </div>
        </div>
    </form>
</div>