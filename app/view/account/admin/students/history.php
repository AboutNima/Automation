<div class="block">
	<div class="header">
		<div class="title">
			<h6> تاریخچه تجهیزات و امکانات کارآموز <?php echo $data->name ?> </h6>
			<p> در این قسمت میتوانید تاریخچه تجهیزات و امکانات کارآموز <?php echo $data->name ?> را مشاهده کنید </p>
		</div>
	</div>
	<div class="body">
		<div class="table-mask">
			<table>
				<thead>
				<tr>
					<th> ردیف </th>
					<th> تجهیزات و امکانات </th>
					<th> وضعیت </th>
					<th> تاریخ تحویل </th>
					<th> تاریخ دریافت </th>
					<th> مدت زمان </th>
				</tr>
				</thead>
				<tbody>
				<?php
				if(!empty($history)):
					$num=1;
					foreach($history as $item):
						?>
						<tr>
							<td><?php echo $num++ ?></td>
							<td><?php echo $item->title ?></td>
							<td>
								<?php
								if($item->status=='1'):
									?>
									<span class="label label-success"> تحویل گرفته شده </span>
								<?php
								else:
									?>
									<span class="label label-warning"> تحویل گرفته نشده </span>
								<?php
								endif;
								?>
							</td>
							<td><?php echo $calendar->date("j F Y ساعت H:i",$item->createdAt) ?></td>
							<td><?php echo $item->status=='0' ? '#' : $calendar->date("j F Y ساعت H:i",$item->updatedAt) ?></td>
							<td><?php echo $item->status=='0' ? '#' : humanTiming($item->updatedAt-$item->createdAt,false) ?></td>
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
<div class="block">
    <div class="header">
        <div class="title">
            <h6> تاریخچه ابزار کارآموز <?php echo $data->name ?> </h6>
            <p> در این قسمت میتوانید تاریخچه ابزار کارآموز <?php echo $data->name ?> را مشاهده کنید </p>
        </div>
    </div>
    <div class="body">
        <div class="table-mask">
            <table>
                <thead>
                <tr>
                    <th> ردیف </th>
                    <th> ابزار </th>
                    <th> وضعیت </th>
                    <th> تاریخ تحویل </th>
                    <th> تاریخ دریافت </th>
                    <th> مدت زمان </th>
                </tr>
                </thead>
                <tbody>
				<?php
				if(!empty($history)):
					$num=1;
					foreach($history as $item):
						?>
                        <tr>
                            <td><?php echo $num++ ?></td>
                            <td><?php echo $item->type ?></td>
                            <td>
								<?php
								if($item->status=='1'):
									?>
                                    <span class="label label-success"> تحویل گرفته شده </span>
								<?php
								else:
									?>
                                    <span class="label label-warning"> تحویل گرفته نشده </span>
								<?php
								endif;
								?>
                            </td>
                            <td><?php echo $calendar->date("j F Y ساعت H:i",$item->createdAt) ?></td>
                            <td><?php echo $item->status=='0' ? '#' : $calendar->date("j F Y ساعت H:i",$item->updatedAt) ?></td>
                            <td><?php echo $item->status=='0' ? '#' : humanTiming($item->updatedAt-$item->createdAt,false) ?></td>
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