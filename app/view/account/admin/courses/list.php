<div class="block">
	<div class="header">
		<div class="title">
			<h6> دوره های ثبت شده در سامانه آموزش مجازی دی اسکیلز </h6>
			<p> در این قسمت میتوانید دوره آموزشی جدید ثبت کنید و یا دوره های ثبت شده را ویرایش کنید </p>
		</div>
	</div>
	<div class="body">
		<div class="table-mask">
			<table>
				<thead>
				<tr>
					<th> ردیف </th>
					<th> عنوان </th>
					<th> وضعیت </th>
					<th> تاریخ ایجاد </th>
					<th> گزینه ها </th>
				</tr>
				</thead>
				<tbody>
				<?php
				if(!empty($data['Result'])):
					$num=1;
					foreach($data['Result'] as $item):
						?>
						<tr>
							<td><?php echo $num++ ?></td>
							<td class="hidden fism"><?php echo $item['title'] ?></td>
							<td>
								<?php
								switch($item['status'])
								{
									case '0':
										echo "<span class='label label-primary'> فعال </span>";
										break;
									case '1':
										echo "<span class='label label-primary'> ثبت نام </span>";
										break;
									case '2':
										echo "<span class='label label-success'> در حال برگزاری </span>";
										break;
									case '3':
										echo "<span class='label label-default'> دروه به اتمام رسیده </span>";
										break;
									case '4':
										echo "<span class='label label-default'> مهلت ثبت نام به پایان رسیده </span>";
										break;
									case '5':
										echo "<span class='label label-warning'> نیاز به ویرایش مجدد </span>";
										break;
									case '6':
										echo "<span class='label label-warning'> در صف بررسی </span>";
										break;
									case '7':
										echo "<span class='label label-danger'> تایید نشد </span>";
										break;
									case '8':
										echo "<span class='label label-default'> غیر فعال </span>";
										break;
								}
								?>
							</td>
							<td><span class="label label-default"><?php echo $calendar->date("j F Y ساعت H:i",$item['createdAt']) ?></span></td>
							<td>
								<div class="d-inline-block">
									<div class="more float-left">
										<div class="item">
											<i class="fal fa-ellipsis-h"></i>
										</div>
										<div class="menu">
											<?php
											if($item['status']!=8):
                                            ?>
												<a href="/account/courses/<?php echo $item['id'] ?>/information"><span><i class="fad fa-file-alt"></i> مشخصات ثبت شده </span></a>
                                            <?php
                                            else:
                                            ?>
                                            #
											<?php
											endif;
											?>
										</div>
									</div>
								</div>
							</td>
						</tr>
					<?php
					endforeach;
				else:
					?>
					<tr>
						<td colspan="5"> موردی برای نمایش وجود ندارد! </td>
					</tr>
				<?php
				endif
				?>
				</tbody>
			</table>
		</div>
	</div>
</div>