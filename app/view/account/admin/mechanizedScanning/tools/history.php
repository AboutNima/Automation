<div class="block">
	<div class="header">
		<div class="title">
			<h6> تاریخچه ابزار <?php echo $data->type ?> </h6>
			<p> در این قسمت میتوانید تاریخچه استفاده از ابزار <?php echo $data->type ?> را مشاهده کنید </p>
		</div>
        <div class="more float-left">
            <div class="item">
                <i class="fal fa-ellipsis-h"></i>
            </div>
            <div class="menu">
                <a href="#add" class="popup-active" popup-target="#add"><span><i class="fas fa-layer-plus"></i> ثبت تجهیزات جدید </span></a>
                <a href="#exportExcel" class="exportTable" e-filename="تاریخچه <?php echo $data->title ?>" e-target=".table-mask"><span><i class="fas fa-file-excel"></i> خروجی اکسل </span></a>
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
							<td><?php echo $item->name ?></td>
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
						<td colspan="6" class="no-data"> موردی برای نمایش وجود ندارد! </td>
					</tr>
				<?php
				endif;
				?>
				</tbody>
			</table>
		</div>
	</div>
</div>