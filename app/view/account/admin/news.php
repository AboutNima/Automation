<div class="block">
	<div class="header">
		<div class="title">
			<h6> اخبار </h6>
			<p> در این قسمت میتوانید اخبار ثبت شده را مدیریت و یا اخبار جدید ثبت کنید </p>
		</div>
		<div class="more float-left">
			<div class="item">
				<i class="fal fa-ellipsis-h"></i>
			</div>
			<div class="menu">
				<a href="#add" class="popup-active" popup-target="#add"><span><i class="fas fa-layer-plus"></i> ثبت خبر جدید </span></a>
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
					<th> خلاصه </th>
					<th> کلید واژه ها </th>
					<th> تاریخ آرشیو </th>
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
							<td><?php echo $item->demo; ?></td>
							<td><?php echo join('، ',json_decode($item->keywords)) ?></td>
							<td><span class="label label-warning"><?php echo  $calendar->date("j F Y",$item->archiveDate)  ?></span></td>
							<td><?php echo  $calendar->date("j F Y",$item->createdAt)  ?></td>
							<td>
								<div class="more">
									<div class="item">
										<i class="fal fa-ellipsis-h"></i>
									</div>
									<div class="menu">
										<a href="/news/<?php echo $item->link ?>"><span><i class="far fa-file-alt"></i> نمایش </span></a>
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
						<td colspan="7" class="no-data"> موردی برای نمایش وجود ندارد! </td>
					</tr>
				<?php
				endif;
				?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="popup" popup-size="lg" popup-title="ثبت خبر جدید" id="add">
	<div class="validation-message no-margin top"></div>
	<form action="/ajax/account/admin/news/add" class="ajax-handler" method="post">
		<input type="text" name="Token" value="<?php echo $_SESSION['Token'] ?>" hidden>
		<div class="row">
			<div class="col-sm-6">
				<div class="input-mask required" mask-type mask-label="عنوان">
					<input type="text" name="data[title]" placeholder="عنوان خبر را وارد کنید" autocomplete="off">
				</div>
			</div>
			<div class="col-sm-6">
				<div class="input-mask required" mask-type mask-label="لینک">
					<input type="text" name="data[link]" placeholder="لینک خبر را وارد کنید" autocomplete="off">
				</div>
			</div>
			<div class="col-12">
				<div class="input-mask required" mask-type mask-label="خلاصه">
					<input type="text" name="data[demo]" placeholder="خلاصه خبر را وارد کنید" autocomplete="off">
				</div>
			</div>
			<div class="col-12">
				<div class="input-mask required" mask-type mask-label="متن">
					<textarea name="data[description]" id="description" rows="3" placeholder="متن خبر را وارد کنید" autocomplete="off"></textarea>
				</div>
			</div>
			<div class="col-sm-8">
				<div class="input-mask required" mask-type="tag" mask-label="کلیدواژه ها">
					<input type="text" name="data[keywords][]" placeholder="کلیدواژه ها را وارد کنید" autocomplete="off">
				</div>
				<p class="text-danger fsize-13 fykm"> * کلیدواژه ها را با دو فاصله از هم جدا کنید </p>
			</div>
			<div class="col-sm-4">
				<div class="input-mask required" mask-type mask-label="تاریخ آرشیو">
					<input class="date-picker" type="text" name="data[archiveDate]" placeholder="تاریخ آرشیو خبر را وارد کنید" autocomplete="off">
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
				<button class="btn btn-purple float-left"> ثبت خبر جدید </button>
			</div>
		</div>
	</form>
</div>
<div class="popup" popup-size="lg" popup-title="ویرایش خبر" id="edit">
	<div class="validation-message no-margin top"></div>
	<form action="/ajax/account/admin/news/edit" class="ajax-handler" method="post">
		<input type="text" name="Token" value="<?php echo $_SESSION['Token'] ?>" hidden>
		<div class="row">
			<div class="col-sm-6">
				<div class="input-mask required" mask-type mask-label="عنوان">
					<input type="text" name="data[title]" placeholder="عنوان خبر را وارد کنید" autocomplete="off">
				</div>
			</div>
			<div class="col-sm-6">
				<div class="input-mask required" mask-type mask-label="لینک">
					<input type="text" name="data[link]" placeholder="لینک خبر را وارد کنید" autocomplete="off">
				</div>
			</div>
			<div class="col-12">
				<div class="input-mask required" mask-type mask-label="خلاصه">
					<input type="text" name="data[demo]" placeholder="خلاصه خبر را وارد کنید" autocomplete="off">
				</div>
			</div>
			<div class="col-12">
				<div class="input-mask required" mask-type mask-label="متن">
					<textarea name="data[description]" id="description" rows="3" placeholder="متن خبر را وارد کنید" autocomplete="off"></textarea>
				</div>
			</div>
			<div class="col-sm-8">
				<div class="input-mask required" mask-type="tag" mask-label="کلیدواژه ها">
					<input type="text" name="data[keywords][]" placeholder="کلیدواژه ها را وارد کنید" autocomplete="off">
				</div>
				<p class="text-danger fsize-13 fykm"> * کلیدواژه ها را با دو فاصله از هم جدا کنید </p>
			</div>
			<div class="col-sm-4">
				<div class="input-mask required" mask-type mask-label="تاریخ آرشیو">
					<input class="date-picker" type="text" name="data[archiveDate]" placeholder="تاریخ آرشیو خبر را وارد کنید" autocomplete="off">
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
				<button class="btn btn-purple float-left"> ویرایش خبر </button>
			</div>
		</div>
	</form>
</div>
<div class="popup" popup-size="sm" popup-title="حذف خبر" id="delete">
    <div class="validation-message no-margin top"></div>
    <form action="/ajax/account/admin/news/delete" class="ajax-handler" method="post">
        <input type="text" name="Token" value="<?php echo $_SESSION['Token'] ?>" hidden>
        <input id="del" type="text" name="id" value="" hidden>
        <div class="row">
            <h6>آیا از حذف این مورد اطمینان دارید؟</h6>
        </div>
        <div class="clearFix">
            <div class="hr"></div>
            <div class="input-mask no-mask-margin">
                <button class="btn btn-danger float-left"> حذف خبر </button>
            </div>
        </div>
    </form>
</div>