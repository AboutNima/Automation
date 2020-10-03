<div class="block">
	<div class="header">
		<div class="title">
			<h6> مواد مصرفی ثبت شده </h6>
			<p> در این قسمت میتوانید مواد مصرفی ثبت شده را مدیریت و یا مواد مصرفی جدید ثبت کنید </p>
		</div>
		<div class="more float-left">
			<div class="item">
				<i class="fal fa-ellipsis-h"></i>
			</div>
			<div class="menu">
				<a href="#add" class="popup-active" popup-target="#add"><span><i class="fas fa-layer-plus"></i> ثبت مواد جدید </span></a>
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
					<th> نام </th>
					<th> شرکت سازنده </th>
					<th> واحد شمارش </th>
					<th> تعداد </th>
					<th> توضیحات </th>
					<th> تاریخ ثبت </th>
					<th> گزینه ها </th>
				</tr>
				</thead>
				<tbody>
				<?php
				if(!empty($data)):
					$num=1;
					foreach($data as $item):
						$item->unit=strtr($item->unit,[
							'0'=>'عدد',
                            '1'=>'گرم',
                            '2'=>'متر',
                            '3'=>'لیتر'
						])
						?>
						<tr>
							<td><?php echo $num++ ?></td>
							<td><?php echo $item->title; ?></td>
							<td>
								<?php if(empty($item->company)): ?>
                                    <span class="label label-warning"> ثبت نشده </span>
								<?php else: echo $item->company; endif; ?>
                            </td>
							<td><span class="label label-primary"><?php echo $item->unit; ?></span></td>
							<td><?php echo $item->count; ?></td>
							<td>
								<?php if(empty($item->description)): ?>
								<span class="label label-warning"> ثبت نشده </span>
								<?php else: echo $item->description; endif; ?>
							</td>
							<td> <?php echo $calendar->date("j F Y",$item->createdAt); ?></td>
							<td>
								<div class="more">
									<div class="item">
										<i class="fal fa-ellipsis-h"></i>
									</div>
									<div class="menu">
                                        <a href="#changeRate" data-id="<?php echo $item->id ?>"><span><i class="fas fa-exchange"></i> تغییر موجودی </span></a>
										<a href="/account/consumingMaterials/<?php echo $item->id ?>/history"><span><i class="fas fa-history"></i> تاریخچه مواد مصرفی </span></a>
										<a href="#edit" data-id="<?php echo $item->id ?>"><span><i class="far fa-file-edit"></i> ویرایش </span></a>
										<a href="#delete" data-id="<?php echo $item->id ?>"><span><i class="far fa-trash"></i> حذف </span></a>
									</div>
								</div>
							</td>
						</tr>
					<?php
					endforeach;
				else:
					?>
					<tr>
						<td colspan="8" class="no-data"> موردی برای نمایش وجود ندارد! </td>
					</tr>
				<?php
				endif;
				?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="popup" popup-size="sm" popup-title="ثبت مواد مصرفی جدید" id="add">
	<div class="validation-message no-margin top"></div>
	<form action="/ajax/account/admin/consumingMaterials/add" class="ajax-handler" method="post">
		<input type="text" name="Token" value="<?php echo $_SESSION['Token'] ?>" hidden>
		<div class="row">
			<div class="col-sm-6">
				<div class="input-mask required" mask-type mask-label="نام">
					<input type="text" name="data[title]" placeholder="نام مواد را وارد کنید" autocomplete="off">
				</div>
			</div>
			<div class="col-sm-6">
				<div class="input-mask" mask-type mask-label="شرکت سازنده">
					<input type="text" name="data[company]" placeholder="شرکت سازنده مواد را وارد کنید" autocomplete="off">
				</div>
			</div>
			<div class="col-sm-6">
				<div class="input-mask required" mask-type="select:search" mask-label="واحد شمارش">
					<select name="data[unit]">
						<option value="0">عدد</option>
						<option value="1">گرم</option>
						<option value="2">متر</option>
						<option value="3">لیتر</option>
					</select>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="input-mask required" mask-type mask-label="تعداد">
					<input type="text" name="data[count]" placeholder="تعداد مواد را وارد کنید" autocomplete="off">
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
				<button class="btn btn-purple float-left"> ثبت مواد جدید </button>
			</div>
		</div>
	</form>
</div>
<div class="popup" popup-size="sm" popup-title="ویرایش مواد مصرفی" id="edit">
	<div class="validation-message no-margin top"></div>
	<form action="/ajax/account/admin/consumingMaterials/edit" class="ajax-handler" method="post">
		<input type="text" name="Token" value="<?php echo $_SESSION['Token'] ?>" hidden>
		<div class="row">
            <div class="col-sm-6">
                <div class="input-mask required" mask-type mask-label="نام">
                    <input type="text" name="data[title]" placeholder="نام مواد را وارد کنید" autocomplete="off">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="input-mask" mask-type mask-label="شرکت سازنده">
                    <input type="text" name="data[company]" placeholder="شرکت سازنده مواد را وارد کنید" autocomplete="off">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="input-mask required" mask-type="select:search" mask-label="واحد شمارش">
                    <select name="data[unit]">
                        <option value="0">عدد</option>
                        <option value="1">گرم</option>
                        <option value="2">متر</option>
                        <option value="3">لیتر</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="input-mask required" mask-type mask-label="تعداد">
                    <input type="text" name="data[count]" placeholder="تعداد مواد را وارد کنید" autocomplete="off">
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
				<button class="btn btn-purple float-left"> ویرایش مواد </button>
			</div>
		</div>
	</form>
</div>
<div class="popup" popup-size="sm" popup-title="حذف مواد مصرفی" id="delete">
    <div class="validation-message no-margin top"></div>
    <form action="/ajax/account/admin/consumingMaterials/delete" class="ajax-handler" method="post">
        <input type="text" name="Token" value="<?php echo $_SESSION['Token'] ?>" hidden>
        <input id="del" type="text" name="id" value="" hidden>
        <div class="row">
            <h6>آیا از حذف این مورد اطمینان دارید؟</h6>
        </div>
        <div class="clearFix">
            <div class="hr"></div>
            <div class="input-mask no-mask-margin">
                <button class="btn btn-danger float-left"> حذف مواد </button>
            </div>
        </div>
    </form>
</div>
<div class="popup" popup-size="sm" popup-title="تغییر موجودی" id="changeRate">
    <div class="validation-message no-margin top"></div>
    <form action="/ajax/account/admin/consumingMaterials/changeRate" class="ajax-handler" method="post">
        <input type="text" name="Token" value="<?php echo $_SESSION['Token'] ?>" hidden>
        <input type="text" name="data[count]" id="count"  hidden>
        <div class="informaton">
            <p class="fism" id="title"> عنوان مواد مصرفی: <span class="float-left fisr"> چای گلستان عراقی محصول پاکستان </span> </p>
            <p class="mt-2 fism" id="countUsed"> مصرف شده: <span class="float-left text-danger fisr"> 20 متر </span> </p>
            <p class="mt-2 fism" id="countLeft"> باقی مانده: <span class="float-left text-success fisr"> 2 متر </span> </p>
        </div>
        <div class="hr no-margin"></div>
        <div class="row">
            <div class="col-12">
                <div class="input-mask required" mask-type="radio" mask-label="نوع تغییرات">
                    <input type="radio" name="data[type]" value="0" label="افزایش" checked>
                    <input type="radio" name="data[type]" value="1" label="کاهش">
                </div>
            </div>
            <div class="col-12">
                <div class="input-mask required" mask-type mask-label="میزان تغییرت">
                    <input type="text" name="data[changeRate]" placeholder="میزان تغییرات را وارد کنید" autocomplete="off">
                </div>
            </div>
        </div>
        <div class="clearFix">
            <div class="hr"></div>
            <div class="input-mask no-mask-margin">
                <button class="btn btn-primary float-left"> تغییر موجودی </button>
            </div>
        </div>
    </form>
</div>