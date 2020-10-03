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
					<th> نام و نام خانوادگی کار آموز </th>
					<th> نوع تغییرات </th>
					<th> میزان تغییرات </th>
					<th> تاریخ </th>
				</tr>
				</thead>
				<tbody>
				<?php
				if(!empty($history)):
					$num=1;
					foreach($history as $item):
						$item->unit=strtr($item->unit,[
							'0'=>'عدد',
							'1'=>'گرم',
							'2'=>'متر',
							'3'=>'لیتر'
						])
						?>
						<tr>
							<td><?php echo $num++ ?></td>
							<td><?php echo $item->name; ?></td>
							<td>
								<?php
								if($item->changeRate<0):
                                ?>
                                    <i class="far fa-long-arrow-down text-danger"></i>
                                <?php
								else:
                                ?>
                                    <i class="far fa-long-arrow-down text-danger"></i>
								<?php
								endif;
								?>
                            </td>
                            <td><?php echo str_replace(['-','+'],'',$item->changeRate) ?></td>
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