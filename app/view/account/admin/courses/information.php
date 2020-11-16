<div class="row">
    <div class="col-md-4 text-center">
        <div class="block">
            <div class="body">
                <h6><?php echo $course['teacherName'] ?></h6>
            </div>
        </div>
        <img src="/public/construct/media/user.png" style="border-radius: 50%" width="115px" height="115px">
    </div>
    <div class="col-md-8">
        <div class="block">
            <div class="body">
                <div class="row">
                    <div class="col-sm-6">
                        <ul class="listing">
                            <li>
                                <p> عنوان </p>
                                <span class="hidden-text d-block" style="max-width: 100%"><?php echo $course['title'] ?></span>
                            </li>
                            <li>
                                <p> عنوان دوره به لاتین </p>
                                <span class="hidden-text d-block" style="max-width: 100%"><?php echo $course['latinTitle'] ?></span>
                            </li>
                            <li>
                                <p> هزینه ثبت نام </p>
                                <span class="text-success"><?php echo number_format($course['price']) ?> ریال </span>
                            </li>
                        </ul>
                    </div>
                    <div class="col-sm-6">
                        <ul class="listing">
                            <li>
                                <p> ظرفیت دوره </p>
                                <span><?php echo $course['capacity'] ?> نفر </span>
                            </li>
                            <li>
                                <p> آدرس اتاق </p>
                                <span><a href="http://dskills.ir/w/<?php echo $course['link'] ?>" class="text-primary"><?php echo 'http://dskills.ir/w/'.$course['link'] ?></a></span>
                            </li>
                            <li>
                                <p> دفعات بازدید از دوره آموزشی </p>
                                <span><?php echo $course['seen'] ?> نفر </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="block">
    <div class="header">
        <div class="title">
            <h6> اسامی ثبت نام شده در دوره آموزشی <?php echo $course['title'] ?> </h6>
            <p> در این قسمت میتوانید اسامی ثبت نام شده در دوره آموزشی (<?php echo $course['title'] ?>) را مدیریت کنید </p>
        </div>
        <div class="more float-left">
            <a href="/account/courses/list" class="back"> بازگشت <i class="far fa-angle-double-left"></i></a>
        </div>
    </div>
    <div class="body">
        <div class="table-mask">
            <table>
                <thead>
                <tr>
                    <th> ردیف </th>
                    <th> نام و نام خانوادگی </th>
                    <th> شماره تماس </th>
                    <th> محل کار/سازمان فعالیت </th>
                    <th> شماره پیگیری </th>
                    <th> نام کاربری </th>
                    <th> گذرواژه </th>
                    <th> تاریخ ثبت نام </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>1</td>
                    <td class="fism"><?php echo $organizer['title'] ?></td>
                    <td>#</td>
                    <td>
                        <span class="label label-danger"> مدیریت </span>
                    </td>
                    <td>#</td>
                    <td><?php echo $organizer['SKUsername'] ?></td>
                    <td><?php echo $organizer['SKPassword'] ?></td>
                    <td>#</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td class="fism"><?php echo $course['teacherName'] ?></td>
                    <td><?php echo $course['teacherPhoneNumber'] ?></td>
                    <td>
                        <span class="label label-danger"> مدرس </span>
                    </td>
                    <td>#</td>
                    <td><?php echo $course['teacherPhoneNumber'] ?></td>
                    <td><?php echo $course['teacherPassword'] ?></td>
                    <td>#</td>
                </tr>
				<?php
				if(!empty($registeredUsers)):
					$num=3;
					foreach($registeredUsers as $item):
						?>
                        <tr>
                            <td><?php echo $num++ ?></td>
                            <td class="fism"><?php echo $item['name'] ?></td>
                            <td><?php echo $item['phoneNumber'] ?></td>
                            <td class="balloon" balloon-position="top" balloon-timeout="0" balloon-text="<?php echo $item['organization'] ?>">
                                <p class="hidden-text" style="max-width: 100px;margin: auto"><?php echo $item['organization'] ?></p>
                            </td>
                            <td>
								<span class="label label-warning"><?php echo $item['RefID'] ?></span>
                            </td>
                            <td><?php echo $item['username'] ?></td>
                            <td><?php echo $item['password'] ?></td>
                            <td><span class="label label-default"><?php echo $calendar->date("j F Y ساعت H:i",$item['createdAt']) ?></span></td>
                        </tr>
					<?php
					endforeach;
				endif
				?>
                </tbody>
            </table>
        </div>
    </div>
</div>