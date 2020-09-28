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
						?>
						<tr>
							<td><?php echo $num++ ?></td>
							<td><?php echo $item->title; ?></td>
							<td><?php echo $item->company; ?></td>
							<td>
								<?php if($item->unit=='0'): ?>
								<span class="label label-primary"> میلی گرم </span>
								<?php elseif($item->unit=='1'): ?>
								<span class="label label-primary"> گرم </span>
								<?php elseif($item->unit=='2'): ?>
								<span class="label label-primary"> کیلوگرم </span>
								<?php elseif($item->unit=='3'): ?>
								<span class="label label-primary"> میلی متر </span>
								<?php elseif($item->unit=='4'): ?>
								<span class="label label-primary"> سانتی متر </span>
								<?php elseif($item->unit=='5'): ?>
								<span class="label label-primary"> متر </span>
								<?php elseif($item->unit=='6'): ?>
								<span class="label label-primary"> میلی لیتر </span>
								<?php elseif($item->unit=='7'): ?>
								<span class="label label-primary"> لیتر </span>
								<?php elseif($item->unit=='8'): ?>
								<span class="label label-primary"> عدد </span>
                                <?php endif; ?>
							</td>
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
										<a href="/account/students/<?php echo $item->id ?>/information"><span><i class="far fa-file-alt"></i> دیگر مشخصات </span></a>
										<a href="/account/students/<?php echo $item->id ?>/history"><span><i class="fas fa-history"></i> تاریخچه مواد مصرفی </span></a>
										<a href="#edit" data-id="<?php echo $item->id ?>"><span><i class="far fa-file-edit"></i> ویرایش </span></a>
										<a href="#edit" data-id="<?php echo $item->id ?>"><span><i class="far fa-trash"></i> حذف </span></a>
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
<div class="popup" popup-size="lg" popup-title="ثبت مواد مصرفی جدید" id="add">
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
						<option value="0">میلی گرم</option>
						<option value="1">گرم</option>
						<option value="2">کیلوگرم</option>
						<option value="3">میلی متر</option>
						<option value="4">سانتی متر</option>
						<option value="5">متر</option>
						<option value="6">میلی لیتر</option>
						<option value="7">لیتر</option>
						<option value="8">عدد</option>
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
				<div class="input-mask required" mask-type mask-label="شماره تلفن همراه">
					<input type="text" name="data[phoneNumber]" placeholder="شماره تلفن همراه کارآموز را وارد کنید" autocomplete="off">
				</div>
			</div>
			<div class="col-sm-4">
				<div class="input-mask" mask-type mask-label="شماره تلفن ثابت">
					<input type="text" name="data[homeNumber]" placeholder="شماره تلفن ثابت کارآموز را وارد کنید" autocomplete="off">
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
<div class="popup" popup-size="md" popup-title="اسکن کارآموز" id="scan">
	<div class="validation-message no-margin top"></div>
	.Scan
</div>