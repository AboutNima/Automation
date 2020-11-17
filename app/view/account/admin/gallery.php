<div class="block">
	<div class="header">
		<div class="title">
			<h6> گالری عکس ها </h6>
			<p> در این قسمت میتوانید عکس های ثبت شده را مدیریت و یا عکس جدید ثبت کنید </p>
		</div>
		<div class="more float-left">
			<div class="item">
				<i class="fal fa-ellipsis-h"></i>
			</div>
			<div class="menu">
				<a href="#add" class="popup-active" popup-target="#add"><span><i class="fas fa-layer-plus"></i> ثبت عکس جدید </span></a>
			</div>
		</div>
	</div>
	<div class="body">
		<div class="table-mask">
			<table>
				<thead>
				<tr>
					<th> ردیف </th>
					<th> عکس </th>
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
							<td><img src="/<?php echo $item->image ?>" style="width: 100px;"></td>
							<td><?php echo $item->title; ?></td>
							<td><?php echo  $calendar->date("j F Y",$item->createdAt)  ?></td>
							<td>
								<div class="more">
									<div class="item">
										<i class="fal fa-ellipsis-h"></i>
									</div>
									<div class="menu">
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
						<td colspan="4" class="no-data"> موردی برای نمایش وجود ندارد! </td>
					</tr>
				<?php
				endif;
				?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="popup" popup-size="md" popup-title="ثبت عکس جدید" id="add">
	<div class="validation-message no-margin top"></div>
	<form action="/ajax/account/admin/gallery/add" class="ajax-handler" method="post">
		<input type="text" name="Token" value="<?php echo $_SESSION['Token'] ?>" hidden>
		<div class="row">
			<div class="col-12">
				<div class="input-mask required" mask-type mask-label="عنوان">
					<input type="text" name="data[title]" placeholder="عنوان را وارد کنید" autocomplete="off">
				</div>
			</div>
			<div class="col-12">
				<div class="input-mask required" mask-type="upload:0.5MB,jpg-jpeg-png-tiff" mask-label="عکس">
					<input type="file" name="file">
				</div>
			</div>
		</div>
		<div class="clearFix">
			<div class="hr"></div>
			<div class="input-mask no-mask-margin">
				<button class="btn btn-purple float-left"> ثبت عکس جدید </button>
			</div>
		</div>
	</form>
</div>
<div class="popup" popup-size="md" popup-title="ویرایش عکس" id="edit">
	<div class="validation-message no-margin top"></div>
	<form action="/ajax/account/admin/gallery/edit" class="ajax-handler" method="post">
		<input type="text" name="Token" value="<?php echo $_SESSION['Token'] ?>" hidden>
		<div class="row">
			<div class="col-sm-6">
				<div class="input-mask required" mask-type mask-label="عنوان">
					<input type="text" name="data[title]" placeholder="عنوان را وارد کنید" autocomplete="off">
				</div>
			</div>
			<div class="col-12">
				<div class="input-mask required" mask-type="upload:0.5MB,jpg-jpeg-png-tiff" mask-label="عکس">
					<input type="file" name="file">
				</div>
			</div>
		</div>
		<div class="clearFix">
			<div class="hr"></div>
			<div class="input-mask no-mask-margin">
				<button class="btn btn-purple float-left"> ویرایش عکس </button>
			</div>
		</div>
	</form>
</div>
<div class="popup" popup-size="sm" popup-title="حذف عکس" id="delete">
	<div class="validation-message no-margin top"></div>
	<form action="/ajax/account/admin/gallery/delete" class="ajax-handler" method="post">
		<input type="text" name="Token" value="<?php echo $_SESSION['Token'] ?>" hidden>
		<input id="del" type="text" name="id" value="" hidden>
		<div class="row">
			<h6>آیا از حذف این مورد اطمینان دارید؟</h6>
		</div>
		<div class="clearFix">
			<div class="hr"></div>
			<div class="input-mask no-mask-margin">
				<button class="btn btn-danger float-left"> حذف عکس </button>
			</div>
		</div>
	</form>
</div>