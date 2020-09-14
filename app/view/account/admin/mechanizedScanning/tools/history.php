<div class="block">
	<div class="header">
		<div class="title">
			<h6> تاریخچه ابزار <?php echo $data->type ?> </h6>
			<p> در این قسمت میتوانید تاریخچه استفاده از ابزار <?php echo $data->type ?> را مشاهده کنید </p>
		</div>
	</div>
	<div class="body">
		<div class="table-mask">
			<table>
				<thead>
				<tr>
					<th> ردیف </th>
					<th> موجودی کل </th>
					<th> موجودی فعلی </th>
					<th> توضیحات </th>
					<th> اندازه </th>
					<th> شرکت سازنده </th>
					<th> گزینه ها </th>
				</tr>
				</thead>
				<tbody>
				<?php
				$sub='';
				if(!empty($sub)):
					$num=1;
					foreach($sub as $item):
						?>
						<tr>
							<td><?php echo $num++ ?></td>
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
							<td><?php echo $item->size ?></td>
							<td><?php echo $item->company ?></td>
							<td>
								<div class="more">
									<div class="item">
										<i class="fal fa-ellipsis-h"></i>
									</div>
									<div class="menu">
										<a href="/account/mechanizedScanning/tools/<?php echo $item->id ?>"><span><i class="far fa-file-alt"></i> دیگر مشخصات </span></a>
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