<div class="block">
	<div class="header">
		<div class="title">
			<h6> ابزار های ثبت شده </h6>
			<p> در این قسمت میتوانید ابزار های ثبت شده را مدیریت و یا ابزار جدید ثبت کنید </p>
		</div>
		<div class="more float-left">
			<div class="item">
				<i class="fal fa-ellipsis-h"></i>
			</div>
			<div class="menu">
				<a href="#add" class="popup-active" popup-target="#scan"><span><i class="fas fa-scanner"></i> اسکن ابزار </span></a>
				<a href="#add" class="popup-active" popup-target="#add"><span><i class="fas fa-layer-plus"></i> ثبت ابزار جدید </span></a>
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
					<th> شماره اموال </th>
					<th> موجودی کل </th>
					<th> موجودی فعلی </th>
					<th> توضیحات </th>
					<th> دسته بندی </th>
					<th> اندازه </th>
					<th> شرکت سازنده </th>
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
							<td>
								<?php
								if(empty($item->propertyNumber)):
									?>
									<span class="label label-danger"> ثبت نشده </span>
								<?php
								else: echo $item->propertyNumber; endif;
								?>
							</td>
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
							<td><span class="label label-primary"><?php echo strtr($item->type,ToolsType) ?></span></td>
							<td><?php echo $item->size ?></td>
							<td><?php echo $item->company ?></td>
							<td>
								<div class="more">
									<div class="item">
										<i class="fal fa-ellipsis-h"></i>
									</div>
									<div class="menu">
										<a target="_blank" href="https://chart.apis.google.com/chart?cht=qr&chs=300x300&chl=<?php echo $item->QRCode; if(!empty($item->propertyNumber)) echo '.'.sprintf('%04d', $item->propertyNumber) ?>&chld=H|1"><span><i class="far fa-qrcode"></i> تولید کد QR </span></a>
										<a href="/account/mechanizedScanning/tools/<?php echo $item->id ?>/information"><span><i class="far fa-file-alt"></i> دیگر مشخصات </span></a>
										<a href="/account/mechanizedScanning/tools/<?php echo $item->id ?>/history"><span><i class="fas fa-history"></i> تاریخچه ابزار </span></a>
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
<div class="popup" popup-size="md" popup-title="ثبت ابزار جدید" id="add">
	<div class="validation-message no-margin top"></div>
	<form action="/ajax/account/admin/mechanizedScanning/tools/add" class="ajax-handler" method="post">
		<input type="text" name="Token" value="<?php echo $_SESSION['Token'] ?>" hidden>
		<div class="row">
			<div class="col-sm-6">
				<div class="input-mask required" mask-type="select:search" mask-label="دسته بندی">
					<select name="data[type]">
						<?php
						foreach(ToolsType as $key=>$item):
							?>
							<option value="<?php echo $key ?>"><?php echo $item ?></option>
						<?php
						endforeach;
						?>
					</select>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="input-mask required" mask-type mask-label="سایز">
					<input type="text" name="data[size]" placeholder="سایز را اینجا وارد کنید" autocomplete="off">
				</div>
			</div>
			<div class="col-sm-6">
				<div class="input-mask required" mask-type mask-label="شرکت سازنده">
					<input type="text" name="data[company]" placeholder="شرکت سازنده را اینجا وارد کنید" autocomplete="off">
				</div>
			</div>
			<div class="col-sm-6">
				<div class="input-mask" mask-type mask-label="شماره اموال">
					<input type="text" name="data[propertyNumber]" placeholder="شماره اموال را اینجا وارد کنید" autocomplete="off">
				</div>
			</div>
			<div class="col-12">
				<div class="input-mask" mask-type mask-label="توضیحات">
					<textarea name="data[description]" rows="3"></textarea>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="input-mask required" mask-type mask-label="موجودی">
					<input type="number" name="data[count]" placeholder="موجودی را اینجا وارد کنید" autocomplete="off">
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
	<form action="/ajax/account/admin/mechanizedScanning/tools/edit" class="ajax-handler" method="post">
		<input type="text" name="Token" value="<?php echo $_SESSION['Token'] ?>" hidden>
		<div class="row">
			<div class="col-sm-6">
				<div class="input-mask required type" mask-type="select:search" mask-label="دسته بندی">
					<select name="data[type]">
						<?php
						foreach(ToolsType as $key=>$item):
							?>
							<option value="<?php echo $key ?>"><?php echo $item ?></option>
						<?php
						endforeach;
						?>
					</select>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="input-mask required" mask-type mask-label="سایز">
					<input type="text" name="data[size]" placeholder="سایز را اینجا وارد کنید" autocomplete="off">
				</div>
			</div>
			<div class="col-sm-6">
				<div class="input-mask required" mask-type mask-label="شرکت سازنده">
					<input type="text" name="data[company]" placeholder="شرکت سازنده را اینجا وارد کنید" autocomplete="off">
				</div>
			</div>
			<div class="col-sm-6">
				<div class="input-mask" mask-type mask-label="شماره اموال">
					<input type="text" name="data[propertyNumber]" placeholder="شماره اموال را اینجا وارد کنید" autocomplete="off">
				</div>
			</div>
			<div class="col-12">
				<div class="input-mask" mask-type mask-label="توضیحات">
					<textarea name="data[description]" rows="3"></textarea>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="input-mask required" mask-type mask-label="موجودی">
					<input type="number" name="data[count]" placeholder="موجودی را اینجا وارد کنید" autocomplete="off">
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
<div class="popup" popup-size="md" popup-title="اسکن ابزار" id="scan">
	<div class="validation-message no-margin top"></div>
	.Scan
</div>