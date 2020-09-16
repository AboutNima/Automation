<div class="block">
	<div class="header">
		<div class="title">
			<h6> تجهیزات و امکانات ثبت شده </h6>
			<p> در این قسمت میتوانید تجهیزات و امکانات ثبت شده را مدیریت و یا تجهیزات و امکانات جدید ثبت کنید </p>
		</div>
		<div class="more float-left">
			<div class="item">
				<i class="fal fa-ellipsis-h"></i>
			</div>
			<div class="menu">
				<a href="#add" class="popup-active" popup-target="#scan"><span><i class="fas fa-scanner"></i> اسکن کارآموز </span></a>
				<a href="#add" class="popup-active" popup-target="#add"><span><i class="fas fa-layer-plus"></i> ثبت کارآموز جدید </span></a>
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
					<th> کد ملی </th>
					<th> شماره تلفن </th>
					<th> تاریخ تولد </th>
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
							<td><?php echo $item->name; ?></td>
							<td><?php echo $item->nationalCode; ?></td>
							<td><?php echo $item->phoneNumber; ?></td>
							<td><?php echo $calendar->date("j F Y",$item->birthDay); ?></td>
							<td><?php echo $calendar->date("j F Y",$item->createdAt); ?></td>
							<td>
								<div class="more">
									<div class="item">
										<i class="fal fa-ellipsis-h"></i>
									</div>
									<div class="menu">
										<a target="_blank" href="https://chart.apis.google.com/chart?cht=qr&chs=300x300&chl=<?php echo $item->QRCode; if(!empty($item->propertyNumber)) echo '.'.sprintf('%04d', $item->propertyNumber) ?>&chld=H|1"><span><i class="far fa-qrcode"></i> تولید کد QR </span></a>
										<a href="/account/students/<?php echo $item->id ?>/history"><span><i class="fas fa-history"></i> تاریخچه کارآموز </span></a>
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
<div class="popup" popup-size="md" popup-title="ثبت تجهیزات و امکانات جدید" id="add">
	<div class="validation-message no-margin top"></div>
	<form action="/ajax/account/admin/mechanizedScanning/equipments/add" class="ajax-handler" method="post">
		<input type="text" name="Token" value="<?php echo $_SESSION['Token'] ?>" hidden>
		<div class="row">
			<div class="col-sm-6">
				<div class="input-mask required" mask-type mask-label="نام">
					<input type="text" name="data[title]" placeholder="نام تجهیزات را وارد کنید" autocomplete="off">
				</div>
			</div>
			<div class="col-sm-6">
				<div class="input-mask" mask-type mask-label="شرکت سازنده (نام تجاری)">
					<input type="text" name="data[company]" placeholder="شرکت سازنده را اینجا وارد کنید" autocomplete="off">
				</div>
			</div>
			<div class="col-sm-6">
				<div class="input-mask required" mask-type mask-label="شماره اموال">
					<input type="text" name="data[propertyNumber]" placeholder="شماره اموال را اینجا وارد کنید" autocomplete="off">
				</div>
			</div>
			<div class="col-sm-6">
				<div class="input-mask" mask-type="radio" mask-label="وضعیت">
					<input type="radio" name="data[status]" value="1" label="سالم" checked>
					<input type="radio" name="data[status]" value="0" label="خراب">
				</div>
			</div>
			<div class="col-12">
				<div class="input-mask" mask-type mask-label="توضیحات">
					<textarea name="data[description]" rows="3"></textarea>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="input-mask" mask-type mask-label="تعداد">
					<input type="number" name="data[count]" placeholder="تعداد را اینجا وارد کنید" autocomplete="off">
				</div>
			</div>
			<div class="col-sm-6">
				<div class="input-mask" mask-type="checkbox">
					<input type="checkbox" name="data[accessories]" value="1" label="لوازم جانبی">
				</div>
			</div>
		</div>
		<div class="clearFix">
			<div class="hr"></div>
			<div class="input-mask no-mask-margin">
				<button class="btn btn-purple float-left"> ثبت تجهیزات جدید </button>
			</div>
		</div>
	</form>
</div>
<div class="popup" popup-size="md" popup-title="ویرایش تجهیزات و امکانات" id="edit">
	<div class="validation-message no-margin top"></div>
	<form action="/ajax/account/admin/mechanizedScanning/equipments/edit" class="ajax-handler" method="post">
		<input type="text" name="Token" value="<?php echo $_SESSION['Token'] ?>" hidden>
		<div class="row">
			<div class="col-sm-6">
				<div class="input-mask required" mask-type mask-label="نام">
					<input type="text" name="data[title]" placeholder="نام تجهیزات را وارد کنید" autocomplete="off">
				</div>
			</div>
			<div class="col-sm-6">
				<div class="input-mask" mask-type mask-label="شرکت سازنده (نام تجاری)">
					<input type="text" name="data[company]" placeholder="شرکت سازنده را اینجا وارد کنید" autocomplete="off">
				</div>
			</div>
			<div class="col-sm-6">
				<div class="input-mask required" mask-type mask-label="شماره اموال">
					<input type="text" name="data[propertyNumber]" placeholder="شماره اموال را اینجا وارد کنید" autocomplete="off">
				</div>
			</div>
			<div class="col-sm-6">
				<div class="input-mask" mask-type="radio" mask-label="وضعیت">
					<input type="radio" name="data[status]" value="1" label="سالم" checked>
					<input type="radio" name="data[status]" value="0" label="خراب">
				</div>
			</div>
			<div class="col-12">
				<div class="input-mask" mask-type mask-label="توضیحات">
					<textarea name="data[description]" rows="3"></textarea>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="input-mask" mask-type mask-label="تعداد">
					<input type="number" name="data[count]" placeholder="تعداد را اینجا وارد کنید" autocomplete="off">
				</div>
			</div>
			<div class="col-sm-6">
				<div class="input-mask" mask-type="checkbox">
					<input type="checkbox" name="data[accessories]" value="1" label="لوازم جانبی">
				</div>
			</div>
		</div>
		<div class="clearFix">
			<div class="hr"></div>
			<div class="input-mask no-mask-margin">
				<button class="btn btn-purple float-left"> ویرایش تجهیزات </button>
			</div>
		</div>
	</form>
</div>
<div class="popup" popup-size="md" popup-title="اسکن تجهیزات" id="scan">
	<div class="validation-message no-margin top"></div>
	.Scan
</div>