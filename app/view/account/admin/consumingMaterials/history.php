<div class="block">
	<div class="header">
		<div class="title">
			<h6> تاریخچه مواد <?php echo $data->title ?> </h6>
			<p> در این قسمت میتوانید تاریخچه استفاده از مواد <?php echo $data->title ?> را مشاهده کنید </p>
		</div>
	</div>
	<div class="body">
		<div class="table-mask">
			<table>
				<thead>
				<tr>
					<th> ردیف </th>
					<th> نام و نام خانوادگی </th>
					<th> میزان تغییرات </th>
					<th> تاریخ </th>
				</tr>
				</thead>
				<tbody>
				<?php
				if(!empty($history)):
					$num=1;
					foreach($history as $item):
						$item->unit=strtr($item->unit, [
							'0'=>'عدد',
							'1'=>'گرم',
							'2'=>'متر',
							'3'=>'لیتر'
						])
						?>
						<tr>
							<td><?php echo $num++ ?></td>
							<td><?php echo $item->name ?></td>
							<td>
								<?php
								if($item->changeRate<0):
									?>
                                    <span class="label label-danger"><i class="fa fa-arrow-down"></i></span>
									<span class="label label-danger"> <?php echo str_replace('-','',$item->changeRate).' '.$item->unit.' '.'کاهش'; ?> </span>
								<?php
								else:
									?>
                                    <span class="label label-success"><i class="fa fa-arrow-up"></i></span>
									<span class="label label-success"> <?php echo str_replace('+','',$item->changeRate).' '.$item->unit.' '.'افزایش'; ?> </span>
								<?php
								endif;
								?>
							</td>
							<td><?php echo $calendar->date("j F Y ساعت H:i",$item->updatedAt) ?></td>
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