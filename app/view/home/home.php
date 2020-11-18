<header>
	<div class="background"></div>
	<div class="container">
		<div class="information">
			<h1> آموزشگاه فنی حرفه ای آزاد <span class="text-warning-logo">هور</span>باد </h1>
			<p> لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است </p>
			<div class="link">
				<a href="#"> تماس با ما </a>
				<a href="#"> ثبت نام در دوره </a>
			</div>
		</div>
	</div>
</header>
<div class="container">
	<div class="features">
		<div class="row">
			<div class="col-md-4">
				<div class="item">
					<i class="fad fa-file-certificate"></i>
					<h5> دعوت به کار نفرات برتر </h5>
					<p> آموزشگاه فنی حرفه ای آزاد <span class="text-warning-logo">هور</span><span class="text-primary-logo">باد</span> پس از اتمام دوره، از نفرات برتر دعوت به همکاری میکند! </p>
				</div>
			</div>
			<div class="col-md-4">
				<div class="item">
					<i class="fad fa-wrench"></i>
					<h5> برگزاری آموزش های تئوری و عملی </h5>
					<p> آموزشگاه فنی حرفه ای آزاد <span class="text-warning-logo">هور</span><span class="text-primary-logo">باد</span> پس از اتمام دوره، از نفرات برتر دعوت به همکاری میکند! </p>
				</div>
			</div>
			<div class="col-md-4">
				<div class="item">
					<i class="fad fa-users-cog"></i>
					<h5> حضور در پروژه های در دست انجام</h5>
					<p> آموزشگاه فنی حرفه ای آزاد <span class="text-warning-logo">هور</span><span class="text-primary-logo">باد</span> پس از اتمام دوره، از نفرات برتر دعوت به همکاری میکند! </p>
				</div>
			</div>
		</div>
	</div>
</div>
<section class="block teachers">
	<div class="container">
		<div class="header">
			<div>
				<p> اساتید حرفه ای </p>
				<h5> استفاده از برترین اساتید </h5>
				<span></span>
			</div>
		</div>
		<div class="body">
			<div class="row">
				<?php
				foreach($teachers['Result'] as $item):
					?>
					<div class="col-lg-4">
						<div class="item">
							<img src="http://dskills.ir/<?php echo $item['avatar'] ?>" alt="<?php echo $item['name'] ?>">
							<h6><?php echo $item['name'] ?></h6>
							<p><?php echo $item['biography'] ?></p>
						</div>
					</div>
				<?php
				endforeach;
				?>
			</div>
		</div>
	</div>
</section>
<section class="block best-course">
	<div class="container">
		<div class="header">
			<div class="float-right">
				<p> پیشنهاد ویژه </p>
				<h5> برترین دوره های آموزشی </h5>
				<span></span>
			</div>
			<div class="float-left">
				<a href="#"> همه دوره ها <i class="fal fa-angle-double-left"></i> </a>
			</div>
		</div>
		<div class="body">
			<div class="slick-slider" style="margin: 0 -15px">
				<?php
				foreach($courses['Result'] as $item):
					?>
					<div class="item">
						<div class="course">
							<div class="header">
								<img src="http://dskills.ir/<?php echo $item['poster'] ?>" alt="<?php echo $item['title'] ?>">
							</div>
							<div class="body">
								<div class="top-bar">
									<p> سطح حرفه ای </p>
									<span><i class="far fa-heart"></i></span>
								</div>
								<div class="title">
									<h5><?php echo $item['title'] ?></h5>
									<p><?php echo $item['teacherName'] ?></p>
									<div class="star">
										<i class="fas fa-star"></i>
										<i class="fas fa-star"></i>
										<i class="fas fa-star"></i>
										<i class="far fa-star"></i>
										<i class="far fa-star"></i>
										<span>3.2</span>
									</div>
								</div>
								<div class="information">
									<!--                                    <ul>-->
									<!--                                        <li><i class="far fa-clock"></i><p> 2 ساعت و 30 دقیقه </p></li>-->
									<!--                                    </ul>-->
								</div>
								<div class="payment">
									<p><?php echo number_format($item['price']/10) ?> تومان </p>
									<a href="http://dskills.ir/course/ds-<?php echo $item['id'] ?>"> ثبت نام </a>
								</div>
							</div>
						</div>
					</div>
				<?php
				endforeach;
				?>
			</div>
		</div>
		<div slick-dots></div>
	</div>
</section>
<section class="block they-say">
	<div class="container no-width">
		<div class="header">
			<h6> شرکت کنندگان چه میگویند </h6>
			<span></span>
		</div>
		<div class="body">
			<div class="slick-slider" style="margin: 0 -15px">
				<div class="item">
					<div class="top-bar">
						<img src="/public/home/media/user/3.jpg" alt="">
						<div>
							<p> نیما اسعدی </p>
							<span> دوره نصاب و تعمیر کار کولر های گازی پنجره ای و اسپلیت </span>
							<div class="star">
								<i class="fas fa-star"></i>
								<i class="fas fa-star"></i>
								<i class="fas fa-star"></i>
								<i class="far fa-star"></i>
								<i class="far fa-star"></i>
							</div>
						</div>
					</div>
					<div class="text">
						<p>
							لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی
							لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی
						</p>
					</div>
				</div>
			</div>
			<div slick-dots></div>
		</div>
	</div>
</section>