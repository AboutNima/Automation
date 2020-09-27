<div class="block">
    <div class="header">
        <div class="title">
            <h6> مدیریت مدیران </h6>
            <p> در این قسمت میتوانید مدیران ثبت شده را مدیریت و یا حساب مدیریت جدید ایجاد کنید </p>
        </div>
        <div class="more float-left">
            <div class="item">
                <i class="fal fa-ellipsis-h"></i>
            </div>
            <div class="menu">
                <a href="#add" class="popup-active" popup-target="#add"><span><i class="fas fa-layer-plus"></i> ایجاد حساب مدیریت </span></a>
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
                    <th> نام و نام خانوادگی </th>
                    <th> نام کاربری </th>
                    <th> شماره همراه </th>
                    <th> آخرین ورود </th>
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
                            <td><?php echo $item->name; ?></td>
                            <td><span class="label label-warning"><?php echo $item->username; ?></span></td>
                            <td><?php echo $item->phoneNumber; ?></td>
                            <td><?php echo empty($item->onlineFrom) ? "<span class='label label-warning'> ثبت نشده </span>" : $item->onlineFrom  ?></td>
                            <td>
                                <div class="more">
                                    <div class="item">
                                        <i class="fal fa-ellipsis-h"></i>
                                    </div>
                                    <div class="menu">
                                        <a href="#edit" data-id="<?php echo $item->id ?>"><span><i class="far fa-file-edit"></i> ویرایش </span></a>
                                        <a href="#resetPassword" class="balloon" balloon-timeout="0" balloon-position="right" balloon-text="دوبار کلیک کنید" data-id="<?php echo $item->id ?>"><span><i class="far fa-redo"></i> بازنشانی گذرواژه </span></a>
                                    </div>
                                </div>
                            </td>
                        </tr>
					<?php
					endforeach;
				else:
					?>
                    <tr>
                        <td colspan="9" class="no-data"> موردی برای نمایش وجود ندارد! </td>
                    </tr>
				<?php
				endif;
				?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="popup" popup-size="md" popup-title="ایجاد حساب مدیریت" id="add">
    <div class="validation-message no-margin top"></div>
    <form action="/ajax/account/admin/manageAdmins/add" class="ajax-handler" method="post">
        <input type="text" name="Token" value="<?php echo $_SESSION['Token'] ?>" hidden>
        <div class="row">
            <div class="col-sm-6">
                <div class="input-mask required" mask-type mask-label="نام">
                    <input type="text" name="data[name]" placeholder="نام را وارد کنید" autocomplete="off">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="input-mask required" mask-type mask-label="نام خانوادگی">
                    <input type="text" name="data[surname]" placeholder="نام خانوادگی را وارد کنید" autocomplete="off">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="input-mask required" mask-type mask-label="کد ملی">
                    <input type="text" name="data[nationalCode]" placeholder="کد ملی را وارد کنید" autocomplete="off">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="input-mask required" mask-type mask-label="شماره همراه">
                    <input type="text" name="data[phoneNumber]" placeholder="شماره همراه را وارد کنید" autocomplete="off">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="input-mask required" mask-type mask-label="نام کاربری">
                    <input type="text" name="data[username]" placeholder="نام کاربری را وارد کنید" autocomplete="off">
                </div>
            </div>
        </div>
        <p class="text-danger fsize-13 mt-0 fism"> * پس از ایجاد حساب مدیریت، گذرواژه همان نام کاربری خواهد بود </p>
        <div class="clearFix">
            <div class="hr"></div>
            <div class="input-mask no-mask-margin">
                <button class="btn btn-purple float-left"> ایجاد حساب مدیریت </button>
            </div>
        </div>
    </form>
</div>
<div class="popup" popup-size="lg" popup-title="ویرایش کارآموز" id="edit">
    <div class="validation-message no-margin top"></div>
    <form action="/ajax/account/admin/students/edit" class="ajax-handler" method="post">
        <input type="text" name="Token" value="<?php echo $_SESSION['Token'] ?>" hidden>
        <div class="row">
            <div class="col-sm-4">
                <div class="input-mask required" mask-type mask-label="نام">
                    <input type="text" name="data[name]" placeholder="نام کارآموز را وارد کنید" autocomplete="off">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="input-mask required" mask-type mask-label="نام خانوادگی">
                    <input type="text" name="data[surname]" placeholder="نام خانوادگی کارآموز را وارد کنید" autocomplete="off">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="input-mask required" mask-type mask-label="نام (انگلیسی)">
                    <input type="text" name="data[name_en]" placeholder="نام انگلیسی کارآموز را وارد کنید" autocomplete="off">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="input-mask required" mask-type mask-label="نام خانوادگی (انگلیسی)">
                    <input type="text" name="data[surname_en]" placeholder="نام خانوادگی انگلیسی کارآموز را وارد کنید" autocomplete="off">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="input-mask required" mask-type mask-label="نام پدر">
                    <input type="text" name="data[fatherName]" placeholder="نام پدر کارآموز را وارد کنید" autocomplete="off">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="input-mask required" mask-type mask-label="تاریخ تولد">
                    <input type="text" name="data[birthDay]" placeholder="کلیک کنید" autocomplete="off">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="input-mask required" mask-type mask-label="کد ملی">
                    <input type="text" name="data[nationalCode]" placeholder="کد ملی کارآموز را وارد کنید" autocomplete="off">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="input-mask required" mask-type mask-label="شماره شناسنامه">
                    <input type="text" name="data[birthCNumber]" placeholder="شماره شناسنامه کارآموز را وارد کنید" autocomplete="off">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="input-mask required" mask-type mask-label="شماره همراه">
                    <input type="text" name="data[phoneNumber]" placeholder="شماره همراه کارآموز را وارد کنید" autocomplete="off">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="input-mask" mask-type mask-label="تلفن ثابت">
                    <input type="text" name="data[homeNumber]" placeholder="تلفن ثابت کارآموز را وارد کنید" autocomplete="off">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="input-mask required" mask-type="select:search" mask-label="میزان تحصیلات">
                    <select name="data[education]">
                        <option value="0">راهنمایی</option>
                        <option value="1">دیپلم</option>
                        <option value="2">فوق دیپلم</option>
                        <option value="3">لیسانس</option>
                        <option value="4">فوق لیسانس</option>
                        <option value="5">دکتری</option>
                        <option value="6">فوق دکتری</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="input-mask" mask-type mask-label="شغل">
                    <input type="text" name="data[job]" placeholder="شغل کارآموز را وارد کنید" autocomplete="off">
                </div>
            </div>
            <div class="col-12">
                <div class="input-mask required" mask-type mask-label="آدرس">
                    <input type="text" name="data[address]" placeholder="آدرس کارآموز را وارد کنید" autocomplete="off">
                </div>
            </div>
        </div>
        <div class="clearFix">
            <div class="hr"></div>
            <div class="input-mask no-mask-margin">
                <button class="btn btn-purple float-left"> ویرایش کارآموز </button>
            </div>
        </div>
    </form>
</div>