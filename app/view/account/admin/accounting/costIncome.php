<div class="block">
    <div class="header">
        <div class="title">
            <h6> هزینه و درآمد ها </h6>
            <p> در این قسمت میتوانید هزینه و درآمد ها جدید ثبت کنید </p>
        </div>
        <div class="more float-left">
            <div class="item">
                <i class="fal fa-ellipsis-h"></i>
            </div>
            <div class="menu">
                <a href="#add" class="popup-active" popup-target="#add"><span><i class="fas fa-list"></i> ثبت مورد جدید </span></a>
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
                    <th> موضوع </th>
                    <th> سرفصل </th>
                    <th> مبلغ </th>
                    <th> نوع </th>
                    <th> توضیحات </th>
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
                            <td><?php echo $item->subject ?></td>
                            <td><?php echo $item->title ?></td>
                            <td><?php echo number_format($item->price) ?></td>
                            <td>
                                <?php
                                if($item->income=='1'):
                                ?>
                                    <span class="label label-primary"> درآمد (بستانکار) </span>
                                <?php
                                else:
                                ?>
                                    <span class="label label-warning"> هزینه (بدهکار) </span>
								<?php
                                endif;
                                ?>
                            </td>
                            <td class="hidden-text" title="<?php echo $item->description ?>"><?php echo $item->description ?></td>
                            <td><?php echo $calendar->date("j F Y ساعت H:i",$item->createdAt); ?></td>
                            <td><?php echo $calendar->date("j F Y ساعت H:i",$item->updatedAt); ?></td>
                            <td>
                                <div class="more">
                                    <div class="item">
                                        <i class="fal fa-ellipsis-h"></i>
                                    </div>
                                    <div class="menu">
                                        <a href="#edit" data-id="<?php echo $item->id ?>"><span><i class="far fa-file-edit"></i> ویرایش </span></a>
                                        <a href="#remove" class="balloon" balloon-timeout="0" balloon-position="right" balloon-text="دوبار کلیک کنید" data-id="<?php echo $item->id ?>"><span><i class="far fa-trash"></i> حذف </span></a>
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
<div class="popup" popup-size="md" popup-title="ثبت مورد جدید" id="add">
    <div class="validation-message no-margin top"></div>
    <form action="/ajax/account/admin/accounting/costIncome/add" class="ajax-handler" method="post">
        <input type="text" name="Token" value="<?php echo $_SESSION['Token'] ?>" hidden>
        <div class="row">
            <div class="col-lg-6">
                <div class="input-mask required" mask-type mask-label="موضوع">
                    <input type="text" name="data[subject]" placeholder="موضوع را وارد کنید" autocomplete="off">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="input-mask required" mask-type="select:search" mask-label="سرفصل">
                    <select name="data[titleId]">
						<?php
						foreach($title as $item):
							?>
                            <option value="<?php echo $item->id ?>"><?php echo $item->title ?></option>
						<?php
						endforeach;
						?>
                    </select>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="input-mask required" mask-type="currency" mask-label="مبلغ(ریال)">
                    <input type="text" name="data[price]" placeholder="مبلغ را به ریال وارد کنید" autocomplete="off">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="input-mask required" mask-type="radio" mask-label="نوع">
                    <input type="radio" checked name="data[income]" value="0" label="هزینه (بدهکار)">
                    <input type="radio" name="data[income]" value="1" label="درآمد (بستانکار)">
                </div>
            </div>
            <div class="col-12">
                <div class="input-mask required" mask-type mask-label="توضیحات (بابت)">
                    <textarea name="data[description]" rows="5"></textarea>
                </div>
            </div>
        </div>
        <div class="clearFix">
            <div class="hr"></div>
            <div class="input-mask no-mask-margin">
                <button class="btn btn-purple float-left"> ثبت </button>
            </div>
        </div>
    </form>
</div>
<div class="popup" popup-size="md" popup-title="ویرایش" id="edit">
    <div class="validation-message no-margin top"></div>
    <form action="/ajax/account/admin/accounting/costIncome/edit" class="ajax-handler" method="post">
        <input type="text" name="Token" value="<?php echo $_SESSION['Token'] ?>" hidden>
        <div class="row">
            <div class="col-lg-6">
                <div class="input-mask required" mask-type mask-label="موضوع">
                    <input type="text" name="data[subject]" placeholder="موضوع را وارد کنید" autocomplete="off">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="input-mask required" mask-type="select:search" mask-label="سرفصل">
                    <select name="data[titleId]">
						<?php
						foreach($title as $item):
							?>
                            <option value="<?php echo $item->id ?>"><?php echo $item->title ?></option>
						<?php
						endforeach;
						?>
                    </select>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="input-mask required" mask-type="currency" mask-label="مبلغ(ریال)">
                    <input type="text" name="data[price]" placeholder="مبلغ را به ریال وارد کنید" autocomplete="off">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="input-mask required" mask-type="radio" mask-label="نوع">
                    <input type="radio" checked name="data[income]" value="0" label="هزینه (بدهکار)">
                    <input type="radio" name="data[income]" value="1" label="درآمد (بستانکار)">
                </div>
            </div>
            <div class="col-12">
                <div class="input-mask required" mask-type mask-label="توضیحات (بابت)">
                    <textarea name="data[description]" rows="5"></textarea>
                </div>
            </div>
        </div>
        <div class="clearFix">
            <div class="hr"></div>
            <div class="input-mask no-mask-margin">
                <button class="btn btn-purple float-left"> ویرایش </button>
            </div>
        </div>
    </form>
</div>